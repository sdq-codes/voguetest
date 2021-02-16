<?php

namespace App\Providers;

use App\Adapters\Interfaces\PaymentGatewayAdapterInterface;
use App\Adapters\PaymentGatewayAdapter;
use App\Models\UserPermission;
use App\Repositories\Interfaces\TransactionRepositoryInterface;
use App\Repositories\Interfaces\UserPermissionRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\TransactionRepository;
use App\Repositories\UserPermissionRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */

    public function boot(){
        /**Register Observer Models **/

        # register the routes


    }
    public function register()
    {
        //
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            UserPermissionRepositoryInterface::class,
            UserPermissionRepository::class
        );

        $this->app->bind(
            TransactionRepositoryInterface::class,
            TransactionRepository::class
        );

        $this->app->bind(
            PaymentGatewayAdapterInterface::class,
            PaymentGatewayAdapter::class
        );
    }
}
