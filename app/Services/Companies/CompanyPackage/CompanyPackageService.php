<?php

namespace App\Services\Companies\CompanyPackage;

use App\Enums\CompanyPaymentPeriodType;
use App\Interfaces\RepositoryInterfaces\Companies\CompanyPackage\CompanyPackageRepositoryInterface;
use App\Strategies\CompanyPackagePeriod\CompanyPackagePeriodMonthStrategy;
use App\Strategies\CompanyPackagePeriod\CompanyPackagePeriodStrategy;
use App\Strategies\CompanyPackagePeriod\CompanyPackagePeriodYearStrategy;
use Illuminate\Contracts\Container\BindingResolutionException;

class CompanyPackageService
{
    /**
     * @param array $attributes
     * @return array|null
     * @throws BindingResolutionException
     */
    public static function store(array $attributes): ?array
    {
        if (CompanyPaymentPeriodType::tryFrom($attributes['period_type']) !== null) { //PeriodType uyman bir değer gönderildiyse.
            $companyPackage = app()->make(CompanyPackageRepositoryInterface::class)->store($attributes);
            $attributes['company_package_id'] = $companyPackage->id;
            //Strategy Design Pattern kullanilmistir
            $companyPackagePeriodStrategy = new CompanyPackagePeriodStrategy();
            match ($attributes['period_type']) {
                CompanyPaymentPeriodType::MONTH->value => $companyPackagePeriodStrategy->setStrategy(new CompanyPackagePeriodMonthStrategy()),
                CompanyPaymentPeriodType::YEAR->value => $companyPackagePeriodStrategy->setStrategy(new CompanyPackagePeriodYearStrategy()),
            };

            return $companyPackagePeriodStrategy->createPeriods($attributes);
        }
        return null;
    }
}
