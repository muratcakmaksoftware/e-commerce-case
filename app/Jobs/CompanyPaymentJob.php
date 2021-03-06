<?php

namespace App\Jobs;

use App\Enums\CompanyPaymentLogType;
use App\Enums\CompanyPaymentQueueStatus;
use App\Enums\CompanyStatus;
use App\Interfaces\RepositoryInterfaces\Companies\Company\CompanyRepositoryInterface;
use App\Interfaces\RepositoryInterfaces\Companies\CompanyPackage\CompanyPackageRepositoryInterface;
use App\Interfaces\RepositoryInterfaces\Companies\CompanyPaymentLog\CompanyPaymentLogRepositoryInterface;
use App\Interfaces\RepositoryInterfaces\Companies\CompanyPaymentPeriod\CompanyPaymentPeriodRepositoryInterface;
use App\Services\Companies\CompanyPackage\CompanyPackageService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Throwable;

class CompanyPaymentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 120; //maksimum işin bitmesi için verilen saniye

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3; //işin hata oluşma durumunda kaç kere denemesini gerektiğini belirleriz.

    /**
     * Calculate the number of seconds to wait before retrying the job.
     *
     * @return int
     */
    public function backoff()
    {
        return 1 * 24 * 60 * 60; //gün * saat * dakika * saniye | Ödeme başarısız olursa 1 gün sonra tekrar denemeye ayarlandı.
    }

    private $companyPeriod;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($companyPeriod)
    {
        $this->companyPeriod = $companyPeriod;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws Exception
     */
    public function handle()
    {
        $companyPackageRepository = app()->make(CompanyPackageRepositoryInterface::class);
        $companyPaymentPeriodRepository = app()->make(CompanyPaymentPeriodRepositoryInterface::class);
        $companyPaymentPeriod = $companyPaymentPeriodRepository->getById($this->companyPeriod->company_payment_period_id);

        if ($companyPaymentPeriod->queue_status === CompanyPaymentQueueStatus::WAITING) { //ilk kez kuyraga girmisse
            $companyPaymentPeriod->queue_status = CompanyPaymentQueueStatus::PROCESSING; //islemde diye durumu guncellenir
            $companyPaymentPeriod->save();
        }

        if (rand(0, 1) == 1) { //Hesaptan para cekildi mi ?
            //Odeme periodunu odendi olarak isaretleme
            $companyPaymentPeriodRepository->update($this->companyPeriod->company_payment_period_id, [
                'queue_status' => CompanyPaymentQueueStatus::SUCCESSFULL->value
            ]);

            //Paket Durumunu Kontrolu
            $companyPackage = $companyPackageRepository->getById($this->companyPeriod->company_package_id);

            //Sirketin baska odenecek periodu var mi ?
            if ($companyPaymentPeriodRepository->getUnPaidPeriodExistsByPackageId($this->companyPeriod->company_package_id)) {
                // Odenmemis odeme periodu bulunmaktadir.
                // Paket devam etmektedir veya Paketin odenmemis birden fazla periodu vardir.
                //Suanki zaman > paket bitis tarihini gecmis mi ?
                if (Carbon::parse(Carbon::now()->toDateString()) > Carbon::parse($companyPackage->expired_at)) {
                    //Kalan odeme periodlari bulunmaktadir.
                } else {
                    //Paket Devam etmektedir.
                }
            } else { //Sirketin tum odeme periodlari tamamlanmis tekrarlama varsa tekrarlama yapilacaktir.
                if ($companyPackage->repeat) { //Paket Tekrari Acik Mi ?
                    //Mevcut paket silindi olarak isaretlenecek ve gecmiste aldigi paketin bilgisi ve odeme periods'i tutulmus olacaktir.

                    //Mevcut paketin soft delete olarak silinmesi
                    $companyPackageRepository->destroy($this->companyPeriod->company_package_id);

                    //Paketi bagli periodlarin soft delete olarak silinmesi
                    $companyPaymentPeriodRepository->destoryPackagePeriods($this->companyPeriod->company_package_id);

                    //Mevcut paketi tekrar olusturulur ve yeni periods tanimlanmis olur.
                    CompanyPackageService::store([
                        'package_id' => $companyPackage->package_id,
                        'company_id' => $companyPackage->company_id,
                        'company_payment_id' => $companyPackage->company_payment_id,
                        'period_type' => $companyPackage->period_type,
                        'auto_pay' => $companyPackage->auto_pay,
                        'repeat' => $companyPackage->repeat,
                    ]);
                } else {
                    //Paket tekrari acik degil bu yuzden islem yapilmayacak.
                    //...
                }
            }
        } else {
            //Odeme sirasinda olusan hata tespit edilmistir ve log yapilacaktir
            $companyPaymentErrorType = CompanyPaymentLogType::from(rand(0, 2))->value;
            $errorException = new Exception('Could not withdraw money from account');
            app()->make(CompanyPaymentLogRepositoryInterface::class)->store(
                [
                    'company_payment_period_id' => $this->companyPeriod->company_payment_period_id,
                    'type' => $companyPaymentErrorType,
                    'description' => $errorException->getMessage()
                ]
            );

            //Odemenin basarsiz olduguna dahil guncelleme
            $companyPaymentPeriodRepository->update($this->companyPeriod->company_payment_period_id, [
                'queue_status' => CompanyPaymentQueueStatus::UNSUCCESSFUL->value
            ]);

            $this->release($this->backoff()); //tekrar deneme icin kac saniye beklensin ?
        }
    }

    /**
     * Handle a job failure.
     *
     * @param Throwable $exception
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function failed(Throwable $exception) //belirlenen son deneme sayısında yine hata oluşursa yapılacak işleri belirleriz.
    {
        //Ödemeyi yapılmadığı için sistem otomatik olarak şirketi askıya alıyor.
        app(CompanyRepositoryInterface::class)->update($this->companyPeriod->id, [
            'status' => CompanyStatus::PASSIVE->value
        ]);

        //Deneme aşımı olarak periodun durum bilgisi güncellenmesi.
        app()->make(CompanyPaymentPeriodRepositoryInterface::class)->update($this->companyPeriod->id, [
            'queue_status' => CompanyPaymentQueueStatus::TRIAL_LIMIT_EXCEEDED->value
        ]);
    }
}
