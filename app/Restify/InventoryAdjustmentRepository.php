<?php

namespace App\Restify;

use App\Models\InventoryAdjustment;
use App\Restify\Actions\FinalizeInventoryAdjustmentAction;
use Binaryk\LaravelRestify\Fields\BelongsTo;
use Binaryk\LaravelRestify\Fields\Field;
use Binaryk\LaravelRestify\Fields\HasMany;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;
use Binaryk\LaravelRestify\Repositories\Repository;
use Illuminate\Http\Request;

class InventoryAdjustmentRepository extends Repository
{
    public static string $model = InventoryAdjustment::class;

    public static string $uriKey = 'inventory-adjustments';

    public function fields(RestifyRequest $request): array
    {
        return [
            Field::make('id')->readonly(),
            
            BelongsTo::make('user', 'user', UserRepository::class)
                ->rules('required')
                ->canSee(fn($request) => $request->user()->can('view', $this->resource)),

            Field::make('type')->rules('required', 'in:input,output'),
            
            Field::make('description'),
            
            Field::make('status')
                ->readonly()
                ->value(fn() => $this->resource->status ?? 'draft'),

            Field::make('finalized_at')->readonly(),
            
            Field::make('created_at')->readonly(),
            Field::make('updated_at')->readonly(),

            HasMany::make('items', 'items', InventoryAdjustmentItemRepository::class),
        ];
    }

    public function actions(RestifyRequest $request): array
    {
        return [
            new FinalizeInventoryAdjustmentAction,
        ];
    }
}
