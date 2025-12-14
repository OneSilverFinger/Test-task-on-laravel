<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\SaleOrderController;
use App\Http\Controllers\ReportController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Справочники
Route::resource('stores', StoreController::class);
Route::resource('suppliers', SupplierController::class);
Route::resource('customers', CustomerController::class);
Route::resource('products', ProductController::class);

// Закупки
Route::resource('purchase-orders', PurchaseOrderController::class);
Route::post('purchase-orders/{purchaseOrder}/payments', [PurchaseOrderController::class, 'addPayment'])->name('purchase-orders.add-payment');

// Продажи
Route::resource('sale-orders', SaleOrderController::class);
Route::post('sale-orders/{saleOrder}/payments', [SaleOrderController::class, 'addPayment'])->name('sale-orders.add-payment');

// Отчёты
Route::prefix('reports')->name('reports.')->group(function () {
    Route::get('inventory', [ReportController::class, 'inventory'])->name('inventory');
    Route::get('debts', [ReportController::class, 'debts'])->name('debts');
    Route::get('stock-movements', [ReportController::class, 'stockMovements'])->name('stock-movements');
    Route::get('cash-movements', [ReportController::class, 'cashMovements'])->name('cash-movements');
});

