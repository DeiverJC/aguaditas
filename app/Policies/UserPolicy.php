<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function allowRestify(?User $user = null): bool
    {
        return true;
    }

    public function show(User $user, User $model): bool
    {
        return $user->role === 'admin' || $user->id === $model->id;
    }

    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function store(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function storeBulk(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, User $model): bool
    {
        return $user->role === 'admin' || $user->id === $model->id;
    }

    public function updateBulk(User $user, User $model): bool
    {
        return $user->role === 'admin';
    }

    public function deleteBulk(User $user, User $model): bool
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, User $model): bool
    {
        return $user->role === 'admin';
    }
}
