<?php

namespace App\Restify;

use App\Models\User;
use App\Restify\Repository;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;


class UserRepository extends Repository
{
    public static string $model = User::class;

    public function fields(RestifyRequest $request): array
    {
        return [
            id(),
            field('name')->required(),
            email()->required(),
            datetime('email_verified_at')->nullable()->readonly(),
            password('password')->required(),
            field('remember_token')->nullable(),
            datetime('created_at')->nullable()->readonly(),
            datetime('updated_at')->nullable()->readonly(),
        ];
    }
}
