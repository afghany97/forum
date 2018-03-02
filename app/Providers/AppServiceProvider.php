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
            if(auth()->check())

                $view->with('unreadNotifications',auth()->user()->unreadNotifications); 
        });

        // pass the channels var for all views

        view()->share('channels' , Channel::all());

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal())
        {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }
}
