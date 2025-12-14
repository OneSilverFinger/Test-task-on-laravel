<?php

namespace App\Services;

use App\Models\Inventory;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;

class InventoryService
{
    /**
     * Обновить остатки при закупке
     */
    public function addStock(int $storeId, int $productId, float $quantity, string $referenceType, int $referenceId, ?string $notes = null): void
    {
        DB::transaction(function () use ($storeId, $productId, $quantity, $referenceType, $referenceId, $notes) {
            // Обновляем остаток и получаем новый остаток
            $quantityAfter = Inventory::adjust($storeId, $productId, $quantity);
            
            // Фиксируем движение
            StockMovement::create([
                'store_id' => $storeId,
                'product_id' => $productId,
                'type' => 'purchase',
                'reference_type' => $referenceType,
                'reference_id' => $referenceId,
                'quantity' => $quantity,
                'quantity_after' => $quantityAfter,
                'movement_date' => today(),
                'notes' => $notes,
            ]);
        });
    }

    /**
     * Обновить остатки при продаже
     */
    public function removeStock(int $storeId, int $productId, float $quantity, string $referenceType, int $referenceId, ?string $notes = null): void
    {
        DB::transaction(function () use ($storeId, $productId, $quantity, $referenceType, $referenceId, $notes) {
            // Проверяем достаточность остатков
            $inventory = Inventory::where('store_id', $storeId)
                ->where('product_id', $productId)
                ->first();
            
            $currentQuantity = $inventory ? $inventory->quantity : 0;
            
            if ($currentQuantity < $quantity) {
                throw new \Exception("Недостаточно товара на складе. Доступно: {$currentQuantity}, требуется: {$quantity}");
            }
            
            // Обновляем остаток (отрицательное значение) и получаем новый остаток
            $quantityAfter = Inventory::adjust($storeId, $productId, -$quantity);
            
            // Фиксируем движение
            StockMovement::create([
                'store_id' => $storeId,
                'product_id' => $productId,
                'type' => 'sale',
                'reference_type' => $referenceType,
                'reference_id' => $referenceId,
                'quantity' => -$quantity,
                'quantity_after' => $quantityAfter,
                'movement_date' => today(),
                'notes' => $notes,
            ]);
        });
    }
}

