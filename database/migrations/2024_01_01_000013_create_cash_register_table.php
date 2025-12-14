<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cash_movements', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['income', 'expense']); // приход/расход
            $table->enum('category', ['sale_payment', 'purchase_payment', 'other']); // категория
            $table->string('reference_type')->nullable(); // SalePayment, PurchasePayment
            $table->unsignedBigInteger('reference_id')->nullable(); // ID оплаты
            $table->decimal('amount', 15, 2);
            $table->date('movement_date');
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Индексы для производительности
            $table->index(['type', 'movement_date']);
            $table->index(['category', 'movement_date']);
            $table->index('movement_date');
            $table->index(['reference_type', 'reference_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cash_movements');
    }
};

