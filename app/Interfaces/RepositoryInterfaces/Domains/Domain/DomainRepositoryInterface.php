<?php

namespace App\Interfaces\RepositoryInterfaces\Domains\Domain;

use App\Interfaces\RepositoryInterfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface DomainRepositoryInterface extends BaseRepositoryInterface
{
    public function urlExists(string $url): bool;
}
