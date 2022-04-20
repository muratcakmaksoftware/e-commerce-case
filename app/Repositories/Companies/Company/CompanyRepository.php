<?php

namespace App\Repositories\Companies\Company;

use App\Interfaces\RepositoryInterfaces\Companies\Company\CompanyRepositoryInterface;
use App\Models\Company;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class CompanyRepository extends BaseRepository implements CompanyRepositoryInterface
{

    /**
     * @param User $model
     */
    public function __construct(Company $model)
    {
        parent::__construct($model);
    }
}
