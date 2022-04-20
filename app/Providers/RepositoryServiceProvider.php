<?php

namespace App\Providers;

use App\Interfaces\RepositoryInterfaces\Companies\Company\CompanyRepositoryInterface;
use App\Interfaces\RepositoryInterfaces\Companies\CompanyPackage\CompanyPackageRepositoryInterface;
use App\Interfaces\RepositoryInterfaces\Domains\Domain\DomainRepositoryInterface;
use App\Interfaces\RepositoryInterfaces\Users\User\UserRepositoryInterface;
use App\Repositories\Companies\Company\CompanyRepository;
use App\Repositories\Companies\CompanyPackage\CompanyPackageRepository;
use App\Repositories\Domains\Domain\DomainRepository;
use App\Repositories\Users\User\UserRepository;
use App\Repositories\BaseRepository;
use App\Interfaces\RepositoryInterfaces\BaseRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(DomainRepositoryInterface::class, DomainRepository::class);
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);
        $this->app->bind(CompanyPackageRepositoryInterface::class, CompanyPackageRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
