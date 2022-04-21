<?php

namespace App\Repositories\Companies\CompanyPaymentPeriod;

use App\Enums\CompanyPaymentQueueStatus;
use App\Interfaces\RepositoryInterfaces\Companies\CompanyPaymentPeriod\CompanyPaymentPeriodRepositoryInterface;
use App\Models\CompanyPaymentPeriod;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class CompanyPaymentPeriodRepository extends BaseRepository implements CompanyPaymentPeriodRepositoryInterface
{
    /**
     * @param CompanyPaymentPeriod $model
     */
    public function __construct(CompanyPaymentPeriod $model)
    {
        parent::__construct($model);
    }

    /**
     * @param $companyPackageId
     * @return bool
     */
    public function getUnPaidPeriodExistsByPackageId($companyPackageId): bool
    {
        return $this->model->where('company_package_id', $companyPackageId)
            ->where('queue_status', '!=', CompanyPaymentQueueStatus::SUCCESSFULL->value) //odenmemis odeme var mi ?
            ->exists(); //odenmemis odeme kaydi varsa true doner.
    }
}
