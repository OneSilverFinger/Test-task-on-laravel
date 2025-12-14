<?php

namespace App\Services;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\SaleOrder;
use App\Models\SaleOrderItem;
use App\Models\PurchasePayment;
use App\Models\SalePayment;
use App\Models\CashMovement;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(
        private InventoryService $inventoryService
    ) {}

    /**
     * Создать закупку
     */
    public function createPurchaseOrder(array $data): PurchaseOrder
    {
        return DB::transaction(function () use ($data) {
            $order = PurchaseOrder::create([
                'supplier_id' => $data['supplier_id'],
                'store_id' => $data['store_id'],
                'number' => $data['number'] ?? null,
                'order_date' => $data['order_date'],
                'notes' => $data['notes'] ?? null,
            ]);

            $totalAmount = 0;

            foreach ($data['items'] as $itemData) {
                $itemTotal = $itemData['quantity'] * $itemData['price'];
                $totalAmount += $itemTotal;

                PurchaseOrderItem::create([
                    'purchase_order_id' => $order->id,
                    'product_id' => $itemData['product_id'],
                    'quantity' => $itemData['quantity'],
                    'price' => $itemData['price'],
                    'total' => $itemTotal,
                ]);

                // Обновляем остатки
                $this->inventoryService->addStock(
                    $order->store_id,
                    $itemData['product_id'],
                    $itemData['quantity'],
                    PurchaseOrder::class,
                    $order->id
                );
            }

            $order->update([
                'total_amount' => $totalAmount,
                'debt_amount' => $totalAmount, // изначально вся сумма в долг
            ]);

            return $order->fresh(['supplier', 'store', 'items.product']);
        });
    }

    /**
     * Создать продажу
     */
    public function createSaleOrder(array $data): SaleOrder
    {
        return DB::transaction(function () use ($data) {
            $order = SaleOrder::create([
                'customer_id' => $data['customer_id'],
                'store_id' => $data['store_id'],
                'number' => $data['number'] ?? null,
                'order_date' => $data['order_date'],
                'notes' => $data['notes'] ?? null,
            ]);

            $totalAmount = 0;

            foreach ($data['items'] as $itemData) {
                $itemTotal = $itemData['quantity'] * $itemData['price'];
                $totalAmount += $itemTotal;

                SaleOrderItem::create([
                    'sale_order_id' => $order->id,
                    'product_id' => $itemData['product_id'],
                    'quantity' => $itemData['quantity'],
                    'price' => $itemData['price'],
                    'total' => $itemTotal,
                ]);

                // Обновляем остатки
                $this->inventoryService->removeStock(
                    $order->store_id,
                    $itemData['product_id'],
                    $itemData['quantity'],
                    SaleOrder::class,
                    $order->id
                );
            }

            $order->update([
                'total_amount' => $totalAmount,
                'debt_amount' => $totalAmount, // изначально вся сумма в долг
            ]);

            return $order->fresh(['customer', 'store', 'items.product']);
        });
    }

    /**
     * Добавить оплату по закупке
     */
    public function addPurchasePayment(int $orderId, array $data): PurchasePayment
    {
        return DB::transaction(function () use ($orderId, $data) {
            $order = PurchaseOrder::findOrFail($orderId);

            $payment = PurchasePayment::create([
                'purchase_order_id' => $orderId,
                'payment_date' => $data['payment_date'],
                'amount' => $data['amount'],
                'notes' => $data['notes'] ?? null,
            ]);

            // Обновляем суммы
            $newPaidAmount = $order->paid_amount + $data['amount'];
            $newDebtAmount = max(0, $order->total_amount - $newPaidAmount);

            $order->update([
                'paid_amount' => $newPaidAmount,
                'debt_amount' => $newDebtAmount,
            ]);

            // Фиксируем движение денег
            CashMovement::create([
                'type' => 'expense',
                'category' => 'purchase_payment',
                'reference_type' => PurchasePayment::class,
                'reference_id' => $payment->id,
                'amount' => $data['amount'],
                'movement_date' => $data['payment_date'],
                'description' => "Оплата закупки {$order->number}",
                'notes' => $data['notes'] ?? null,
            ]);

            return $payment;
        });
    }

    /**
     * Добавить оплату по продаже
     */
    public function addSalePayment(int $orderId, array $data): SalePayment
    {
        return DB::transaction(function () use ($orderId, $data) {
            $order = SaleOrder::findOrFail($orderId);

            $payment = SalePayment::create([
                'sale_order_id' => $orderId,
                'payment_date' => $data['payment_date'],
                'amount' => $data['amount'],
                'notes' => $data['notes'] ?? null,
            ]);

            // Обновляем суммы
            $newPaidAmount = $order->paid_amount + $data['amount'];
            $newDebtAmount = max(0, $order->total_amount - $newPaidAmount);

            $order->update([
                'paid_amount' => $newPaidAmount,
                'debt_amount' => $newDebtAmount,
            ]);

            // Фиксируем движение денег
            CashMovement::create([
                'type' => 'income',
                'category' => 'sale_payment',
                'reference_type' => SalePayment::class,
                'reference_id' => $payment->id,
                'amount' => $data['amount'],
                'movement_date' => $data['payment_date'],
                'description' => "Оплата продажи {$order->number}",
                'notes' => $data['notes'] ?? null,
            ]);

            return $payment;
        });
    }
}

