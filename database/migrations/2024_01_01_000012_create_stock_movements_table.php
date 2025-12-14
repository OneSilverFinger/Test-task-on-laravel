<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->onDelete('restrict');
            $table->foreignId('product_id')->constrained()->onDelete('restrict');
            $table->enum('type', ['purchase', 'sale', 'adjustment']); // тип движения
            $table->string('reference_type')->nullable(); // PurchaseOrder, SaleOrder
            $table->unsignedBigInteger('reference_id')->nullable(); // ID закупки/продажи
            $table->decimal('quantity', 15, 4); // положительное для прихода, отрицательное для расхода
            $table->decimal('quantity_after', 15, 4); // остаток после движения
            $table->date('movement_date');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Индексы для производительности
            $table->index(['store_id', 'product_id', 'movement_date']);
            $table->index(['reference_type', 'reference_id']);
            $table->index('movement_date');
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};

