<?php

namespace App\Repositories\Companies\Company;

use App\Interfaces\RepositoryInterfaces\Companies\Company\CompanyRepositoryInterface;
use App\Models\Company;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CompanyRepository extends BaseRepository implements CompanyRepositoryInterface
{
    /**
     * @param Company $model
     */
    public function __construct(Company $model)
    {
        parent::__construct($model);
    }

    /**
     * @param $companyId
     * @return Collection
     */
    public function getCompanyPackageDetail($companyId): Collection
    {
        return $this->model->with(['companyPackages' => function ($query) {
            $query->with('companyPaymentPeriods');
        }])->where('id', $companyId)->get();
    }
}
