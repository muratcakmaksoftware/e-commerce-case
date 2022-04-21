<?php

namespace App\Http\Controllers\Backend\CompanyPackage;

use App\Enums\CompanyPaymentPeriodType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Companies\CompanyPackage\CheckCompanyPackageRequest;
use App\Http\Requests\Companies\CompanyPackage\StoreCompanyPackageRequest;
use App\Interfaces\RepositoryInterfaces\Companies\Company\CompanyRepositoryInterface;
use App\Interfaces\RepositoryInterfaces\Companies\CompanyPackage\CompanyPackageRepositoryInterface;
use App\Jobs\CompanyPaymentJob;
use App\Models\Company;
use App\Services\Companies\CompanyPackage\CompanyPackageService;
use App\Strategies\CompanyPackagePeriod\CompanyPackagePeriodMonthStrategy;
use App\Strategies\CompanyPackagePeriod\CompanyPackagePeriodStrategy;
use App\Strategies\CompanyPackagePeriod\CompanyPackagePeriodYearStrategy;
use App\Traits\APIResponseTrait;
use Carbon\Carbon;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;

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

    /**
     * @param StoreCompanyPackageRequest $request
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function store(StoreCompanyPackageRequest $request): JsonResponse
    {
        $response = CompanyPackageService::store($request->all());
        if(isset($response)){
            return $this->responseSuccess($response);
        }
        return $this->responseBadRequest();
    }

    /**
     * @param CheckCompanyPackageRequest $request
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function checkCompanyPackage(CheckCompanyPackageRequest $request): JsonResponse
    {
        $companyPackageDetail = app()->make(CompanyRepositoryInterface::class)->getCompanyPackageDetail($request->get('company_id'))->toArray();
        return $this->responseSuccess($companyPackageDetail);
    }

}
