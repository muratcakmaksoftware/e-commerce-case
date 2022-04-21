<?php

namespace App\Repositories\Companies\CompanyPaymentLog;

use App\Interfaces\RepositoryInterfaces\Companies\CompanyPaymentLog\CompanyPaymentLogRepositoryInterface;
use App\Models\CompanyPaymentLog;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class CompanyPaymentLogRepository extends BaseRepository implements CompanyPaymentLogRepositoryInterface
{
    /**
     * @param CompanyPaymentLog $model
     */
    public function __construct(CompanyPaymentLog $model)
    {
        parent::__construct($model);
    }
}
