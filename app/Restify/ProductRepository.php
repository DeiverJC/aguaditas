<?php

namespace App\Restify;

use App\Models\Product;
use Binaryk\LaravelRestify\Fields\Field;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;

class ProductRepository extends Repository
{
    public static string $model = Product::class;

    public function fields(RestifyRequest $request): array
    {
        return [
            Field::make('id')->readonly(),
            Field::make('name')->required(),
            Field::make('sku')->required(),
            Field::make('unit_type')->required(),
            Field::make('sale_price')->rules('numeric')->required(),
            Field::make('created_at')->readonly(),
            Field::make('updated_at')->readonly(),
        ];
    }
}
