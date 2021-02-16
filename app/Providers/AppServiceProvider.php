<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */

    public function boot(){
        /**Register Observer Models **/

        # register the routes
        $this->app['path.config'] = base_path('config');

    }
    public function register()
    {
        //
    }
}
