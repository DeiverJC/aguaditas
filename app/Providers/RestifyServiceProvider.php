<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Binaryk\LaravelRestify\RestifyApplicationServiceProvider;

class RestifyServiceProvider extends RestifyApplicationServiceProvider
{
    /**
     * Register the Restify gate.
     *
     * This gate determines who can access Restify in non-local environments.
     *
     * @return void
     */
    /**
     * Register the Restify repositories.
     *
     * @return void
     */
    protected function repositories(): void
    {
        // Manual registration if auto-discovery fails
        \Binaryk\LaravelRestify\Restify::repositories([
            \App\Restify\UserRepository::class,
            \App\Restify\ProductRepository::class,
            \App\Restify\ClientRepository::class,
            \App\Restify\OrderRepository::class,
        ]);
    }

    /**
     * Register the Restify gate.
     *
     * This gate determines who can access Restify in non-local environments.
     *
     * @return void
     */
    protected function gate(): void
    {
        Gate::define('viewRestify', function ($user) {
            return true; // Allow all authenticated users for now, or check role
        });
    }
}
