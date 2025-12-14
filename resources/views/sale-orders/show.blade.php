@extends('layouts.app')

@section('title', 'Продажа #' . $saleOrder->number)

@section('content')
<div class="card">
    <div class="card-header">Продажа {{ $saleOrder->number }}</div>
    
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 2rem; margin-bottom: 2rem;">
        <div>
            <p><strong>Дата:</strong> {{ $saleOrder->order_date->format('d.m.Y') }}</p>
            <p><strong>Покупатель:</strong> {{ $saleOrder->customer->name }}</p>
            <p><strong>Магазин:</strong> {{ $saleOrder->store->name }}</p>
        </div>
        <div>
            <p><strong>Общая сумма:</strong> {{ number_format($saleOrder->total_amount, 2, ',', ' ') }} ₽</p>
            <p><strong>Оплачено:</strong> {{ number_format($saleOrder->paid_amount, 2, ',', ' ') }} ₽</p>
            <p><strong>Задолженность:</strong> 
                <span style="color: {{ $saleOrder->debt_amount > 0 ? '#dc3545' : '#28a745' }}">
                    {{ number_format($saleOrder->debt_amount, 2, ',', ' ') }} ₽
                </span>
            </p>
        </div>
    </div>
    
    @if($saleOrder->notes)
        <div style="margin-bottom: 2rem;">
            <strong>Примечания:</strong> {{ $saleOrder->notes }}
        </div>
    @endif
    
    <h3>Товары:</h3>
    <table>
        <thead>
            <tr>
                <th>Товар</th>
                <th>Количество</th>
                <th>Цена</th>
                <th class="text-right">Итого</th>
            </tr>
        </thead>
        <tbody>
            @foreach($saleOrder->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ number_format($item->quantity, 4, ',', ' ') }} {{ $item->product->unit }}</td>
                    <td>{{ number_format($item->price, 2, ',', ' ') }} ₽</td>
                    <td class="text-right">{{ number_format($item->total, 2, ',', ' ') }} ₽</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="font-weight: bold;">
                <td colspan="3" class="text-right">Итого:</td>
                <td class="text-right">{{ number_format($saleOrder->total_amount, 2, ',', ' ') }} ₽</td>
            </tr>
        </tfoot>
    </table>
    
    <div class="card" style="margin-top: 2rem;">
        <div class="card-header">Оплаты</div>
        
        <table>
            <thead>
                <tr>
                    <th>Дата</th>
                    <th>Сумма</th>
                    <th>Примечания</th>
                </tr>
            </thead>
            <tbody>
                @forelse($saleOrder->payments as $payment)
                    <tr>
                        <td>{{ $payment->payment_date->format('d.m.Y') }}</td>
                        <td class="text-right">{{ number_format($payment->amount, 2, ',', ' ') }} ₽</td>
                        <td>{{ $payment->notes }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Нет оплат</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        @if($saleOrder->debt_amount > 0)
            <form action="{{ route('sale-orders.add-payment', $saleOrder) }}" method="POST" style="margin-top: 1rem;">
                @csrf
                <div style="display: grid; grid-template-columns: 1fr 1fr 2fr auto; gap: 1rem; align-items: end;">
                    <div>
                        <label>Дата оплаты</label>
                        <input type="date" name="payment_date" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div>
                        <label>Сумма</label>
                        <input type="number" name="amount" step="0.01" min="0.01" max="{{ $saleOrder->debt_amount }}" required>
                    </div>
                    <div>
                        <label>Примечания</label>
                        <input type="text" name="notes">
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success">Добавить оплату</button>
                    </div>
                </div>
            </form>
        @endif
    </div>
    
    <div style="margin-top: 2rem;">
        <a href="{{ route('sale-orders.index') }}" class="btn">Назад к списку</a>
    </div>
</div>
@endsection

