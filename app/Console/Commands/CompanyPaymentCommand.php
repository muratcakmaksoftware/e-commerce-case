<?php

namespace App\Console\Commands;

use App\Enums\CompanyPaymentAutoPayStatus;
use App\Enums\CompanyPaymentLogType;
use App\Enums\CompanyPaymentPeriodStatus;
use App\Enums\CompanyPaymentQueueStatus;
use App\Enums\CompanyStatus;
use App\Jobs\CompanyPaymentJob;
use App\Models\Company;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CompanyPaymentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'company:payments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Company Payments';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /**
         * Companies milyonlarca kayıt altında çalışacağından eloquent yerine QueryBuilder kullanılacaktır.
         * Neden QueryBuilder ?
           Eloquent'in elastik yapısı gereği ve with gibi işlemleriyle büyük verilerde aşırı yavaşlatığından dolayıdır.
         **/
        $companyPeriods = DB::table('companies')->select([
            'companies.id', //sirket
            'company_packages.id as company_package_id', //sirketin paketi
            'company_payment_periods.id as company_payment_period_id', //sirketin paketinin odemeleri
            'payment_at',
        ])->join('company_packages', 'company_packages.company_id','=','companies.id') //otomatik odeme aktif mi kontrolu ve paket tekrarlama kontrolu icin gereklidir
            ->join('company_payment_periods', 'company_payment_periods.company_id','=','companies.id')
            ->where('companies.status', CompanyStatus::ACTIVE->value) //Aktif olan sirketlerde ara
            ->where('company_payment_periods.queue_status', CompanyPaymentQueueStatus::WAITING->value) //Kuyrukta olmayanları alır
            ->where('company_packages.auto_pay', CompanyPaymentAutoPayStatus::ACTIVE->value) //otomatik odeme aktif mi ?
            ->whereDate('payment_at','<=',now()->toDateString()) //ödemesi geçmiş veya ödeme günü ise ödeme alınması için job'a gönderilecektir.
            ->get();

        foreach ($companyPeriods as $companyPeriod){
            CompanyPaymentJob::dispatch($companyPeriod)->onQueue('company_payments');
        }

        $this->info('Company Periods OK');
    }
}
