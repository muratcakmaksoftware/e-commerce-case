<?php

namespace App\Repositories\Domains\Domain;

use App\Interfaces\RepositoryInterfaces\Domains\Domain\DomainRepositoryInterface;
use App\Models\Domain;
use App\Repositories\BaseRepository;

class DomainRepository extends BaseRepository implements DomainRepositoryInterface
{

    /**
     * @param Domain $model
     */
    public function __construct(Domain $model)
    {
        parent::__construct($model);
    }

    /**
     * @param string $url
     * @param array $columns
     * @return bool
     */
    public function urlExists(string $url): bool
    {
        return $this->model->where('url', $url)->exists();
    }
}
