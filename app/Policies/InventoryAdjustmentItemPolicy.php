<?php

namespace App\Policies;

use App\Models\InventoryAdjustmentItem;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class InventoryAdjustmentItemPolicy
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
    public function view(User $user, InventoryAdjustmentItem $inventoryAdjustmentItem): bool
    {
        return true;
    }

    public function show(User $user, InventoryAdjustmentItem $inventoryAdjustmentItem): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function store(User $user): bool
    {
        return true;
    }

    public function update(User $user, InventoryAdjustmentItem $inventoryAdjustmentItem): bool
    {
        return $inventoryAdjustmentItem->adjustment->status === 'draft';
    }

    public function delete(User $user, InventoryAdjustmentItem $inventoryAdjustmentItem): bool
    {
        return $inventoryAdjustmentItem->adjustment->status === 'draft';
    }

    public function restore(User $user, InventoryAdjustmentItem $inventoryAdjustmentItem): bool
    {
        return true;
    }

    public function forceDelete(User $user, InventoryAdjustmentItem $inventoryAdjustmentItem): bool
    {
        return false;
    }

    public function attachInventoryAdjustment(User $user, InventoryAdjustmentItem $inventoryAdjustmentItem): bool
    {
        return true;
    }

    public function attachProduct(User $user, InventoryAdjustmentItem $inventoryAdjustmentItem): bool
    {
        return true;
    }
}
