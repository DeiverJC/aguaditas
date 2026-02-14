<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    public function allowRestify(?User $user = null): bool
    {
        return $user !== null;
    }

    public function show(?User $user, Order $model): bool
    {
        return true;
    }

    public function store(User $user): bool
    {
        // Both admin and repartidor can create orders (sales)
        return true;
    }

    public function storeBulk(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Order $model): bool
    {
        // Repartidor can only update own orders or status (logic can be refined)
        // For now, allow admin and owner
        return $user->role === 'admin' || $user->id === $model->user_id;
    }

    public function updateBulk(User $user, Order $model): bool
    {
        return $user->role === 'admin';
    }

    public function deleteBulk(User $user, Order $model): bool
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, Order $model): bool
    {
        return $user->role === 'admin';
    }
}
