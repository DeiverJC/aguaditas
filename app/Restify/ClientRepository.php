<?php

namespace App\Restify;

use App\Models\Client;
use Binaryk\LaravelRestify\Fields\Field;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;

class ClientRepository extends Repository
{
    public static string $model = Client::class;

    public function fields(RestifyRequest $request): array
    {
        return [
            Field::make('id')->readonly(),
            Field::make('name')->required(),
            Field::make('phone')->nullable(),
            Field::make('address')->nullable(),
            Field::make('created_at')->readonly(),
            Field::make('updated_at')->readonly(),
        ];
    }
}
