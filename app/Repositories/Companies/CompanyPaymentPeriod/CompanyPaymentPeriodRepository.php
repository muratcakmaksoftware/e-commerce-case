<?php

namespace App\Repositories\Companies\CompanyPaymentPeriod;

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
}
