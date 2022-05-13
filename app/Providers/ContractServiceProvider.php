<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\User;
use App\Repositories\CompanyRepository;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Services\CompanyService;
use App\Services\Contracts\CompanyServiceInterface;
use App\Services\Contracts\UserServiceInterface;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class ContractServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //Repositories
        $this->app->singleton(UserRepositoryInterface::class, fn() => new UserRepository(User::class));
        $this->app->singleton(CompanyRepositoryInterface::class, fn() => new CompanyRepository(Company::class));

        //Services
        $this->app->singleton(UserServiceInterface::class, fn() => new UserService(app(UserRepositoryInterface::class)));
        $this->app->singleton(CompanyServiceInterface::class, fn() => new CompanyService(app(CompanyRepositoryInterface::class)));
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
