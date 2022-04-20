<?php

namespace App\Repositories\Companies\CompanyPackage;

use App\Interfaces\RepositoryInterfaces\Companies\CompanyPackage\CompanyPackageRepositoryInterface;
use App\Models\CompanyPackage;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class CompanyPackageRepository extends BaseRepository implements CompanyPackageRepositoryInterface
{
    /**
     * @param CompanyPackage $model
     */
    public function __construct(CompanyPackage $model)
    {
        parent::__construct($model);
    }
}
