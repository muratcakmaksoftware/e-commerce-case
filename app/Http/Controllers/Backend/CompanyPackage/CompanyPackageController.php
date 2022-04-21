<?php

namespace App\Http\Controllers\Backend\CompanyPackage;

use App\Enums\PaymentPeriodType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Companies\CompanyPackage\CheckCompanyPackageRequest;
use App\Http\Requests\Companies\CompanyPackage\StoreCompanyPackageRequest;
use App\Interfaces\RepositoryInterfaces\Companies\Company\CompanyRepositoryInterface;
use App\Interfaces\RepositoryInterfaces\Companies\CompanyPackage\CompanyPackageRepositoryInterface;
use App\Models\Company;
use App\Strategies\CompanyPackagePeriod\CompanyPackagePeriodMonthStrategy;
use App\Strategies\CompanyPackagePeriod\CompanyPackagePeriodStrategy;
use App\Strategies\CompanyPackagePeriod\CompanyPackagePeriodYearStrategy;
use App\Traits\APIResponseTrait;
use Carbon\Carbon;

class CompanyPackageController extends Controller
{
    use APIResponseTrait;

    /**
     * @var CompanyPackageRepositoryInterface
     */
    private CompanyPackageRepositoryInterface $repository;

    /**
     * @param CompanyPackageRepositoryInterface $repository
     */
    public function __construct(CompanyPackageRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function store(StoreCompanyPackageRequest $request)
    {
        $attributes = $request->all();
        if (PaymentPeriodType::tryFrom($attributes['period_type']) !== null) { //PeriodType uyman bir değer gönderildiyse.
            $companyPackage = app()->make(CompanyPackageRepositoryInterface::class)->store($attributes);
            $attributes['company_package_id'] = $companyPackage->id;
            //Strategy Design Pattern kullanilmistir
            $companyPackagePeriodStrategy = new CompanyPackagePeriodStrategy();
            match ($attributes['period_type']) {
                PaymentPeriodType::MONTH->value => $companyPackagePeriodStrategy->setStrategy(new CompanyPackagePeriodMonthStrategy()),
                PaymentPeriodType::YEAR->value => $companyPackagePeriodStrategy->setStrategy(new CompanyPackagePeriodYearStrategy()),
            };

            return $this->responseSuccess($companyPackagePeriodStrategy->createPeriods($attributes));
        }
        return $this->responseBadRequest();
    }

    public function checkCompanyPackage(CheckCompanyPackageRequest $request)
    {
        $companyPackageDetail = app()->make(CompanyRepositoryInterface::class)->getCompanyPackageDetail($request->get('company_id'))->toArray();
        return $this->responseSuccess($companyPackageDetail);
    }

}
