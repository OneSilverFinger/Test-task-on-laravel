<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained()->onDelete('restrict');
            $table->foreignId('store_id')->constrained()->onDelete('restrict');
            $table->string('number')->unique(); // номер закупки
            $table->date('order_date');
            $table->decimal('total_amount', 15, 2)->default(0); // общая сумма заказа
            $table->decimal('paid_amount', 15, 2)->default(0); // оплаченная сумма
            $table->decimal('debt_amount', 15, 2)->default(0); // задолженность (total - paid)
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Индексы для производительности
            $table->index(['supplier_id', 'order_date']);
            $table->index(['store_id', 'order_date']);
            $table->index('order_date');
            $table->index('number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};

