<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
{
    use HandlesAuthorization;

    public function allowRestify(?User $user = null): bool
    {
        return $user !== null;
    }

    public function show(?User $user, Client $model): bool
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

    public function update(User $user, Client $model): bool
    {
        return $user->role === 'admin';
    }

    public function updateBulk(User $user, Client $model): bool
    {
        return $user->role === 'admin';
    }

    public function deleteBulk(User $user, Client $model): bool
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, Client $model): bool
    {
        return $user->role === 'admin';
    }
}
