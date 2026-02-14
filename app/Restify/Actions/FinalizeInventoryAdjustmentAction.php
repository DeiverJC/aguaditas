<?php

namespace App\Restify\Actions;

use Binaryk\LaravelRestify\Actions\Action;
use Binaryk\LaravelRestify\Http\Requests\ActionRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use App\Models\Inventory;
use App\Models\InventoryMovement;
use Illuminate\Support\Facades\DB;

class FinalizeInventoryAdjustmentAction extends Action
{
    public static $uriKey = 'finalize-inventory-adjustment';

    public function authorize(ActionRequest $request): bool
    {
        return true;
    }

    public function handle(ActionRequest $request, $models): JsonResponse
    {
        // Ensure models is a collection
        if (!($models instanceof Collection)) {
            $models = collect([$models]);
        }

        foreach ($models as $adjustment) {
            if ($adjustment->status !== 'draft') {
                return response()->json(['message' => 'Adjustment is already finalized or not in draft status.'], 422);
            }

            DB::transaction(function () use ($adjustment, $request) {
                // Ensure we load the items
                $adjustment->load('items');
                
                foreach ($adjustment->items as $item) {
                    $inventory = Inventory::firstOrCreate(
                        ['product_id' => $item->product_id],
                        ['current_stock' => 0, 'min_stock' => 0]
                    );

                    if ($adjustment->type === 'input') {
                        $inventory->increment('current_stock', $item->quantity);
                    } else {
                        $inventory->decrement('current_stock', $item->quantity);
                    }

                    InventoryMovement::create([
                        'inventory_id' => $inventory->id,
                        'user_id' => $request->user()->id,
                        'type' => $adjustment->type,
                        'quantity' => $item->quantity,
                        'reason' => 'Inventory Adjustment #' . $adjustment->id . ': ' . ($adjustment->description ?? ''),
                    ]);
                }

                $adjustment->update([
                    'status' => 'finalized',
                    'finalized_at' => now(),
                ]);
            });
        }

        return ok('Inventory adjustment finalized successfully.');
    }
}
