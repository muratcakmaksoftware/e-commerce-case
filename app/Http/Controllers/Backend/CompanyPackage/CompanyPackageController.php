<?php

namespace App\Http\Controllers\Backend\CompanyPackage;

use App\Enums\PaymentPeriodType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Companies\CompanyPackage\StoreCompanyPackageRequest;
use App\Interfaces\RepositoryInterfaces\Companies\Company\CompanyRepositoryInterface;
use App\Interfaces\RepositoryInterfaces\Companies\CompanyPackage\CompanyPackageRepositoryInterface;
use App\Models\CompanyPackage;
use App\Strategies\CompanyPackagePeriod\CompanyPackagePeriodMonthStrategy;
use App\Strategies\CompanyPackagePeriod\CompanyPackagePeriodStrategy;
use App\Strategies\CompanyPackagePeriod\CompanyPackagePeriodYearStrategy;
use App\Traits\APIResponseTrait;

class CompanyPackageController extends Controller
{
    use APIResponseTrait;

    /**
     * @var CompanyRepositoryInterface
     */
    private CompanyRepositoryInterface $repository;

    /**
     * @param CompanyRepositoryInterface $repository
     */
    public function __construct(CompanyRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function store(StoreCompanyPackageRequest $request)
    {
        $attributes = $request->all();
        if(PaymentPeriodType::tryFrom($attributes['period_type']) !== null){ //PeriodType uyman bir değer gönderildiyse.
            $companyPackage = app()->make(CompanyPackageRepositoryInterface::class)->store($attributes);
            dd($companyPackage);
            //Strategy Design Pattern kullanilmistir
            $companyPackagePeriodStrategy = new CompanyPackagePeriodStrategy();
            match ($attributes['period_type']){
                PaymentPeriodType::MONTH->value => $companyPackagePeriodStrategy->setStrategy(new CompanyPackagePeriodMonthStrategy()),
                PaymentPeriodType::YEAR->value => $companyPackagePeriodStrategy->setStrategy(new CompanyPackagePeriodYearStrategy()),
            };
            $companyPackagePeriodStrategy->createPeriods($attributes);
        }
        return $this->responseBadRequest();
    }

}