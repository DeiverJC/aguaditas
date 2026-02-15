<?php

namespace App\Restify;

use App\Models\InventoryAdjustmentItem;
use Binaryk\LaravelRestify\Fields\BelongsTo;
use Binaryk\LaravelRestify\Fields\Field;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;
use Binaryk\LaravelRestify\Repositories\Repository;

class InventoryAdjustmentItemRepository extends Repository
{
    public static string $model = InventoryAdjustmentItem::class;

    public function fields(RestifyRequest $request): array
    {
        return [
            Field::make('id')->readonly(),
            
            BelongsTo::make('adjustment', 'adjustment', InventoryAdjustmentRepository::class),
            
            BelongsTo::make('product', 'product', ProductRepository::class)
                ->rules('required'),

            Field::make('quantity')
                ->rules('required', 'integer', 'min:1'),
            
            Field::make('created_at')->readonly(),
            Field::make('updated_at')->readonly(),
        ];
    }

    public static function related(): array
    {
        return [
            'adjustment' => InventoryAdjustmentRepository::class,
            'product' => ProductRepository::class,
        ];
    }
}
