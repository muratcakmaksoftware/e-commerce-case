<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginAuthRequest;
use App\Http\Requests\Auth\RegisterAuthRequest;
use App\Interfaces\RepositoryInterfaces\Companies\Company\CompanyRepositoryInterface;
use App\Interfaces\RepositoryInterfaces\Domains\Domain\DomainRepositoryInterface;
use App\Interfaces\RepositoryInterfaces\Users\User\UserRepositoryInterface;
use App\Traits\APIResponseTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use APIResponseTrait;

    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $repository;

    /**
     * @param UserRepositoryInterface $repository
     */
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function login(LoginAuthRequest $request): JsonResponse
    {
        if (auth('sanctum')->check()) {
            auth('sanctum')->user()->currentAccessToken()->delete();
        }
        $attributes = $request->all();

        $user = $this->repository->getUserByEmail($attributes['email'], ['id', 'name', 'email', 'password']);
        if ($user) {
            if (Hash::check($attributes['password'], $user->password)) {
                $user->token = $this->createToken($user);
                unset($user->password);

                return $this->responseSuccess([
                    'user' => $user
                ]);
            }
        }
        return $this->responseBadRequest();
    }

    public function register(RegisterAuthRequest $request): JsonResponse
    {
        $attributes = $request->all();
        $attributes['password'] = Hash::make($attributes['password']);
        $user = $this->repository->store([
            'name' => $attributes['name'].' '. $attributes['last_name'],
            'email' => $attributes['email'],
            'password' => $attributes['password']
        ]);
        if ($user) {
            $company = app()->make(CompanyRepositoryInterface::class)->store([
                'user_id' => $user->id,
                'name' => $attributes['company_name']
            ]);

            $domain = app()->make(DomainRepositoryInterface::class)->store([
                'company_id' => $company->id,
                'url' => $attributes['site_url']
            ]);

            return $this->responseSuccess([
                'company_id' => $company->id,
                'token' => $this->createToken($user)
            ]);
        }
        return $this->responseBadRequest();
    }

    /**
     * @param Model $user
     * @return string
     */
    public function createToken(Model $user): string
    {
        return $user->createToken(config('app.name'))->plainTextToken;
    }

    /**
     * @return int
     */
    public function logout(): int
    {
        return auth()->user()->tokens()->delete();
    }
}
