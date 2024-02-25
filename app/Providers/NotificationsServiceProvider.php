<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\View;

class NotificationsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            try {
                $notifications = auth()->user()->notifications ?? [];
            } catch (\Throwable $e) {
                // Manejar la excepción, proporcionar un valor predeterminado o realizar otras acciones necesarias.
                $notifications = [];
            }

            $view->with('notifications', $notifications);
        });

    }

}
