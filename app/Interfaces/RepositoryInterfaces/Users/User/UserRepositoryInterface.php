<?php

namespace App\Interfaces\RepositoryInterfaces\Users\User;

use App\Interfaces\RepositoryInterfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param string $email
     * @return Model|null
     */
    public function getUserByEmail(string $email): ?Model;
}
