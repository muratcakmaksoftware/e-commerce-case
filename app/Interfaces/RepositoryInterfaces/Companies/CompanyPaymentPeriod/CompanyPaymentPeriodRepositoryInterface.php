<?php

namespace App\Interfaces\RepositoryInterfaces\Companies\CompanyPaymentPeriod;

use App\Interfaces\RepositoryInterfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface CompanyPaymentPeriodRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param $companyPackageId
     * @return bool
     */
    public function getUnPaidPeriodExistsByPackageId($companyPackageId): bool;
}
