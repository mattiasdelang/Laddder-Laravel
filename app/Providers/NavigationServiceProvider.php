<?php

namespace App\Providers;

use Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class NavigationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        view()->composer('includes.navigation', function ($view) {
            if (!\Auth::check())
                return;

            $user = Auth::user();

            $check = $user->activities()->where('seen', 0)->count();
            $view->with('notification', $check);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
