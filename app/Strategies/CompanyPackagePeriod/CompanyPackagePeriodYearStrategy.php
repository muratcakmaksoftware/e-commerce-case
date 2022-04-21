<?php

namespace App\Strategies\CompanyPackagePeriod;

use App\Interfaces\RepositoryInterfaces\Companies\CompanyPackage\CompanyPackageRepositoryInterface;
use App\Interfaces\RepositoryInterfaces\Companies\CompanyPaymentPeriod\CompanyPaymentPeriodRepositoryInterface;
use App\Interfaces\RepositoryInterfaces\Packages\Package\PackageRepositoryInterface;
use App\Interfaces\Strategies\CompanyPackagePeriod\CompanyPackagePeriodStrategyInterface;
use Carbon\Carbon;

class CompanyPackagePeriodYearStrategy implements CompanyPackagePeriodStrategyInterface
{
    /**
     * @param array $attributes
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function createPeriods(array $attributes): array
    {
        $packageId = $attributes['package_id']; //Satin alinan paket
        $companyId = $attributes['company_id']; //Alan sirket
        $companyPackageId = $attributes['company_package_id']; //Sirkete ait paket

        $package = app()->make(PackageRepositoryInterface::class)->getById($packageId);//paket bilgisi

        $date = Carbon::now();
        for ($i = 0; $i < 12; $i++){
            $nextMonth = $date->addMonth()->toDateString();
            app()->make(CompanyPaymentPeriodRepositoryInterface::class)->store([
                'company_package_id' => $companyPackageId,
                'company_id' => $companyId,
                'payment_at' => $nextMonth,
                'price' => $package->price,
            ]);//Pakete ait odeme periyodu eklenmistir. Burada eksik olan status approval default da 0 almaktadir bu yuzden eklenmedi.
        }

        $companyPackageRepository = app()->make(CompanyPackageRepositoryInterface::class);
        $companyPackageRepository->update($companyPackageId, ['expired_at' => $nextMonth]); //paketin bitis tarihi belirlenmistir.
        $companyPackage = $companyPackageRepository->getById($companyPackageId);
        return [
            'start_date' => Carbon::parse($companyPackage->created_at)->toDateString(),
            'end_date' => $companyPackage->expired_at,
            'package' => $package->toArray()
        ];
    }
}
