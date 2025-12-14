<?php

namespace App\Http\Controllers;

use App\Models\CashMovement;
use App\Models\PurchaseOrder;
use App\Models\SaleOrder;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Текущий остаток кассы
        $cashBalance = CashMovement::getCurrentBalance();
        
        // Общая дебиторская задолженность
        $totalCustomerDebt = SaleOrder::where('debt_amount', '>', 0)->sum('debt_amount');
        
        // Общая кредиторская задолженность
        $totalSupplierDebt = PurchaseOrder::where('debt_amount', '>', 0)->sum('debt_amount');
        
        // Статистика за текущий месяц
        $monthStart = now()->startOfMonth();
        $monthEnd = now()->endOfMonth();
        
        $monthPurchases = PurchaseOrder::whereBetween('order_date', [$monthStart, $monthEnd])
            ->sum('total_amount');
        
        $monthSales = SaleOrder::whereBetween('order_date', [$monthStart, $monthEnd])
            ->sum('total_amount');
        
        return view('home', compact(
            'cashBalance',
            'totalCustomerDebt',
            'totalSupplierDebt',
            'monthPurchases',
            'monthSales'
        ));
    }
}

