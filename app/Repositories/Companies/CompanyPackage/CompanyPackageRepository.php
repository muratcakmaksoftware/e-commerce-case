<?php

namespace App\Repositories\Companies\CompanyPackage;

use App\Interfaces\RepositoryInterfaces\Companies\Company\CompanyRepositoryInterface;
use App\Models\CompanyPackage;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class CompanyPackageRepository extends BaseRepository implements CompanyRepositoryInterface
{
    /**
     * @param CompanyPackage $model
     */
    public function __construct(CompanyPackage $model)
    {
        parent::__construct($model);
    }
}
