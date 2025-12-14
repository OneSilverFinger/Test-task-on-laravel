<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\Store;
use App\Models\Product;
use App\Services\OrderService;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    public function __construct(
        private OrderService $orderService
    ) {}

    public function index()
    {
        $orders = PurchaseOrder::with(['supplier', 'store'])
            ->orderBy('order_date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(50);
        
        return view('purchase-orders.index', compact('orders'));
    }

    public function create()
    {
        $suppliers = Supplier::orderBy('name')->get();
        $stores = Store::where('is_active', true)->orderBy('name')->get();
        $products = Product::where('is_active', true)->orderBy('name')->get();
        
        return view('purchase-orders.create', compact('suppliers', 'stores', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'store_id' => 'required|exists:stores,id',
            'order_date' => 'required|date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.0001',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        try {
            $order = $this->orderService->createPurchaseOrder($validated);
            return redirect()->route('purchase-orders.show', $order)->with('success', 'Закупка создана успешно');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Ошибка: ' . $e->getMessage());
        }
    }

    public function show(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load(['supplier', 'store', 'items.product', 'payments']);
        return view('purchase-orders.show', compact('purchaseOrder'));
    }

    public function addPayment(Request $request, PurchaseOrder $purchaseOrder)
    {
        $validated = $request->validate([
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'notes' => 'nullable|string',
        ]);

        try {
            $this->orderService->addPurchasePayment($purchaseOrder->id, $validated);
            return redirect()->route('purchase-orders.show', $purchaseOrder)->with('success', 'Оплата добавлена успешно');
        } catch (\Exception $e) {
            return back()->with('error', 'Ошибка: ' . $e->getMessage());
        }
    }
}

