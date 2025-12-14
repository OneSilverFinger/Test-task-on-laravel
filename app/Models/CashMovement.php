<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class CashMovement extends Model
{
    protected $table = 'cash_movements';

    protected $fillable = [
        'type',
        'category',
        'reference_type',
        'reference_id',
        'amount',
        'movement_date',
        'description',
        'notes',
    ];

    protected $casts = [
        'movement_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function reference(): MorphTo
    {
        return $this->morphTo();
    }

    public static function getCurrentBalance(): float
    {
        $income = static::where('type', 'income')->sum('amount');
        $expense = static::where('type', 'expense')->sum('amount');
        return $income - $expense;
    }
}

