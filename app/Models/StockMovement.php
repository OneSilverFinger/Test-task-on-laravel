<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class StockMovement extends Model
{
    protected $fillable = [
        'store_id',
        'product_id',
        'type',
        'reference_type',
        'reference_id',
        'quantity',
        'quantity_after',
        'movement_date',
        'notes',
    ];

    protected $casts = [
        'movement_date' => 'date',
        'quantity' => 'decimal:4',
        'quantity_after' => 'decimal:4',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function reference(): MorphTo
    {
        return $this->morphTo();
    }
}

