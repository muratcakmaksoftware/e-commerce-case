<?php

namespace App\Providers;

use App\Interfaces\RepositoryInterfaces\Companies\Company\CompanyRepositoryInterface;
use App\Interfaces\RepositoryInterfaces\Companies\CompanyPackage\CompanyPackageRepositoryInterface;
use App\Interfaces\RepositoryInterfaces\Companies\CompanyPaymentLog\CompanyPaymentLogRepositoryInterface;
use App\Interfaces\RepositoryInterfaces\Companies\CompanyPaymentPeriod\CompanyPaymentPeriodRepositoryInterface;
use App\Interfaces\RepositoryInterfaces\Domains\Domain\DomainRepositoryInterface;
use App\Interfaces\RepositoryInterfaces\Packages\Package\PackageRepositoryInterface;
use App\Interfaces\RepositoryInterfaces\Users\User\UserRepositoryInterface;
use App\Repositories\Companies\Company\CompanyRepository;
use App\Repositories\Companies\CompanyPackage\CompanyPackageRepository;
use App\Repositories\Companies\CompanyPaymentLog\CompanyPaymentLogRepository;
use App\Repositories\Companies\CompanyPaymentPeriod\CompanyPaymentPeriodRepository;
use App\Repositories\Domains\Domain\DomainRepository;
use App\Repositories\Packages\Package\PackageRepository;
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
        $this->app->bind(CompanyPaymentPeriodRepositoryInterface::class, CompanyPaymentPeriodRepository::class);
        $this->app->bind(PackageRepositoryInterface::class, PackageRepository::class);
        $this->app->bind(CompanyPaymentLogRepositoryInterface::class, CompanyPaymentLogRepository::class);
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
