<?php

namespace App\Policies;

use App\Models\InventoryAdjustment;
use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;

class InventoryAdjustmentPolicy
{
    use HandlesAuthorization;

    public function allowRestify(?User $user = null): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, InventoryAdjustment $inventoryAdjustment): bool
    {
        return true;
    }

    public function show(User $user, InventoryAdjustment $inventoryAdjustment): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    public function store(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, InventoryAdjustment $inventoryAdjustment): bool
    {
        return $inventoryAdjustment->status === 'draft';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, InventoryAdjustment $inventoryAdjustment): bool
    {
        return $inventoryAdjustment->status === 'draft';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, InventoryAdjustment $inventoryAdjustment): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, InventoryAdjustment $inventoryAdjustment): bool
    {
        return false;
    }
}
