<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Gate;
use App\Models\InventoryAdjustment;
use App\Policies\InventoryAdjustmentPolicy;
use App\Models\InventoryAdjustmentItem;
use App\Policies\InventoryAdjustmentItemPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(InventoryAdjustment::class, InventoryAdjustmentPolicy::class);
        Gate::policy(InventoryAdjustmentItem::class, InventoryAdjustmentItemPolicy::class);
    }
}
