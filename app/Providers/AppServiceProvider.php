<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Channel;

use Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        view()->composer('*' ,function($view)
        {
            $view->with('channels',Channel::all()); 
        });

        // view()->share('channels' , Channel::all());
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
