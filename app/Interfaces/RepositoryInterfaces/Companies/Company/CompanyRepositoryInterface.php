<?php

namespace App\Interfaces\RepositoryInterfaces\Companies\Company;

use App\Interfaces\RepositoryInterfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface CompanyRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param int $companyId
     * @return Collection
     */
    public function getCompanyPackageDetail(int $companyId): Collection;
}
