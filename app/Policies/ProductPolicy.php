<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function allowRestify(User $user = null): bool
    {
        return $user !== null;
    }

    public function show(User $user = null, Product $model): bool
    {
        return true;
    }

    public function store(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function storeBulk(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Product $model): bool
    {
        return $user->role === 'admin';
    }

    public function updateBulk(User $user, Product $model): bool
    {
        return $user->role === 'admin';
    }

    public function deleteBulk(User $user, Product $model): bool
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, Product $model): bool
    {
        return $user->role === 'admin';
    }
}
