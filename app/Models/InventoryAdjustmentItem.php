<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryAdjustmentItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'inventory_adjustment_id',
        'product_id',
        'quantity',
    ];

    public function adjustment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(InventoryAdjustment::class, 'inventory_adjustment_id');
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
