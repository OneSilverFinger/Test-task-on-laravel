<?php

namespace App\Http\Controllers;

use App\Models\SaleOrder;
use App\Models\Customer;
use App\Models\Store;
use App\Models\Product;
use App\Services\OrderService;
use Illuminate\Http\Request;

class SaleOrderController extends Controller
{
    public function __construct(
        private OrderService $orderService
    ) {}

    public function index()
    {
        $orders = SaleOrder::with(['customer', 'store'])
            ->orderBy('order_date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(50);
        
        return view('sale-orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        $stores = Store::where('is_active', true)->orderBy('name')->get();
        $products = Product::where('is_active', true)->orderBy('name')->get();
        
        return view('sale-orders.create', compact('customers', 'stores', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'store_id' => 'required|exists:stores,id',
            'order_date' => 'required|date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.0001',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        try {
            $order = $this->orderService->createSaleOrder($validated);
            return redirect()->route('sale-orders.show', $order)->with('success', 'Продажа создана успешно');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Ошибка: ' . $e->getMessage());
        }
    }

    public function show(SaleOrder $saleOrder)
    {
        $saleOrder->load(['customer', 'store', 'items.product', 'payments']);
        return view('sale-orders.show', compact('saleOrder'));
    }

    public function addPayment(Request $request, SaleOrder $saleOrder)
    {
        $validated = $request->validate([
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'notes' => 'nullable|string',
        ]);

        try {
            $this->orderService->addSalePayment($saleOrder->id, $validated);
            return redirect()->route('sale-orders.show', $saleOrder)->with('success', 'Оплата добавлена успешно');
        } catch (\Exception $e) {
            return back()->with('error', 'Ошибка: ' . $e->getMessage());
        }
    }
}

