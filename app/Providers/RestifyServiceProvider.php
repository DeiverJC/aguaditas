<?php

namespace App\Providers;

use Binaryk\LaravelRestify\RestifyApplicationServiceProvider;
use Illuminate\Support\Facades\Gate;

class RestifyServiceProvider extends RestifyApplicationServiceProvider
{
    /**
     * Register the Restify gate.
     *
     * This gate determines who can access Restify in non-local environments.
     */
    /**
     * Register the Restify repositories.
     */
    protected function repositories(): void
    {
        // Manual registration if auto-discovery fails
        \Binaryk\LaravelRestify\Restify::repositories([
            \App\Restify\UserRepository::class,
            \App\Restify\ProductRepository::class,
            \App\Restify\ClientRepository::class,
            \App\Restify\OrderRepository::class,
            \App\Restify\InventoryAdjustmentRepository::class,
            \App\Restify\InventoryAdjustmentItemRepository::class,
        ]);
    }

    /**
     * Register the Restify gate.
     *
     * This gate determines who can access Restify in non-local environments.
     */
    protected function gate(): void
    {
        Gate::define('viewRestify', function ($user) {
            return true; // Allow all authenticated users for now, or check role
        });
    }
}
