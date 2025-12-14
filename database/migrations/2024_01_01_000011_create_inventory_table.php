<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->decimal('quantity', 15, 4)->default(0); // остаток в базовой единице
            $table->timestamps();
            
            // Уникальный индекс: один остаток на товар в магазине
            $table->unique(['store_id', 'product_id']);
            
            // Индексы для производительности
            $table->index('store_id');
            $table->index('product_id');
            $table->index('quantity'); // для поиска товаров с остатками
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory');
    }
};

