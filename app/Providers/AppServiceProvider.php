<?php

namespace App\Providers;

use App\Thread;
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

        // pass value to all views

        view()->composer('*' ,function($view)
        {
             // pass the channels for all views

            $view->with('channels' , Channel::all());

            // check if there authenticated user

            if(auth()->check()){

                // pass unreadNotifications for all views

                $view->with('unreadNotifications', auth()->user()->unreadNotifications);
            }
        });

        // add spamDetect rule for validation rules

        Validator()->extend('spamDetect' , 'App\Rules\SpamDetect@passes');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // check if app running in local env

        if ($this->app->isLocal())
        {
            // register the debugbar into my app
            
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }
}
