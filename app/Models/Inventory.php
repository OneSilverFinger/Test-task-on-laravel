<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventory extends Model
{
    protected $table = 'inventory';

    protected $fillable = [
        'store_id',
        'product_id',
        'quantity',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public static function adjust(int $storeId, int $productId, float $quantityChange): float
    {
        $inventory = static::firstOrNew([
            'store_id' => $storeId,
            'product_id' => $productId,
        ]);
        
        $inventory->quantity = ($inventory->quantity ?? 0) + $quantityChange;
        $inventory->save();
        
        return $inventory->quantity;
    }
}

