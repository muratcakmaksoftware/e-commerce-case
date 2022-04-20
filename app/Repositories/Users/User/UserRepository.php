<?php

namespace App\Repositories\Users\User;

use App\Interfaces\RepositoryInterfaces\Users\User\UserRepositoryInterface;
use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    /**
     * UserRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * @param string $email
     * @param array $columns
     * @return null|Model
     */
    public function getUserByEmail(string $email, array $columns = []): ?Model
    {
        return $this->model->select($columns)->where('email', $email)->first();
    }
}
