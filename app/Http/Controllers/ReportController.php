<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\PurchaseOrder;
use App\Models\SaleOrder;
use App\Models\StockMovement;
use App\Models\CashMovement;
use App\Models\Store;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function inventory()
    {
        $stores = Store::where('is_active', true)->orderBy('name')->get();
        $storeId = request('store_id');
        
        $query = Inventory::with(['store', 'product'])
            ->where('quantity', '>', 0);
        
        if ($storeId) {
            $query->where('store_id', $storeId);
        }
        
        $inventory = $query->orderBy('store_id')
            ->orderBy('product_id')
            ->paginate(100);
        
        return view('reports.inventory', compact('inventory', 'stores', 'storeId'));
    }

    public function debts()
    {
        // Дебиторская задолженность (долги покупателей)
        $customerDebts = SaleOrder::select('customer_id', DB::raw('SUM(debt_amount) as total_debt'))
            ->where('debt_amount', '>', 0)
            ->with('customer')
            ->groupBy('customer_id')
            ->get()
            ->filter(fn($item) => $item->total_debt > 0);
        
        // Кредиторская задолженность (долги поставщикам)
        $supplierDebts = PurchaseOrder::select('supplier_id', DB::raw('SUM(debt_amount) as total_debt'))
            ->where('debt_amount', '>', 0)
            ->with('supplier')
            ->groupBy('supplier_id')
            ->get()
            ->filter(fn($item) => $item->total_debt > 0);
        
        return view('reports.debts', compact('customerDebts', 'supplierDebts'));
    }

    public function stockMovements()
    {
        $stores = Store::where('is_active', true)->orderBy('name')->get();
        $products = Product::where('is_active', true)->orderBy('name')->get();
        
        $storeId = request('store_id');
        $productId = request('product_id');
        $dateFrom = request('date_from');
        $dateTo = request('date_to');
        
        $query = StockMovement::with(['store', 'product'])
            ->orderBy('movement_date', 'desc')
            ->orderBy('id', 'desc');
        
        if ($storeId) {
            $query->where('store_id', $storeId);
        }
        
        if ($productId) {
            $query->where('product_id', $productId);
        }
        
        if ($dateFrom) {
            $query->where('movement_date', '>=', $dateFrom);
        }
        
        if ($dateTo) {
            $query->where('movement_date', '<=', $dateTo);
        }
        
        $movements = $query->paginate(100);
        
        return view('reports.stock-movements', compact('movements', 'stores', 'products', 'storeId', 'productId', 'dateFrom', 'dateTo'));
    }

    public function cashMovements()
    {
        $dateFrom = request('date_from', date('Y-m-01'));
        $dateTo = request('date_to', date('Y-m-d'));
        
        $movements = CashMovement::whereBetween('movement_date', [$dateFrom, $dateTo])
            ->orderBy('movement_date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(100);
        
        $income = CashMovement::where('type', 'income')
            ->whereBetween('movement_date', [$dateFrom, $dateTo])
            ->sum('amount');
        
        $expense = CashMovement::where('type', 'expense')
            ->whereBetween('movement_date', [$dateFrom, $dateTo])
            ->sum('amount');
        
        $balance = CashMovement::getCurrentBalance();
        
        return view('reports.cash-movements', compact('movements', 'income', 'expense', 'balance', 'dateFrom', 'dateTo'));
    }
}

