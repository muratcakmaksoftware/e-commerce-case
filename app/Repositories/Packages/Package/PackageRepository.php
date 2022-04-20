<?php

namespace App\Repositories\Packages\Package;

use App\Interfaces\RepositoryInterfaces\Packages\Package\PackageRepositoryInterface;
use App\Models\Package;
use App\Repositories\BaseRepository;

class PackageRepository extends BaseRepository implements PackageRepositoryInterface
{
    /**
     * @param Package $model
     */
    public function __construct(Package $model)
    {
        parent::__construct($model);
    }
}
