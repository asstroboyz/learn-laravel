<?php

namespace App\Providers;

use App\Models\User;
use App\Services\Impl\UserServiceImpl;
use App\Services\UserServices;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider implements DeferrableProvider
{

    public array $singletons = [
        UserServices::class => UserServiceImpl::class,
    ];
    public function provides()
    {
        return [UserServices::class];
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        
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
