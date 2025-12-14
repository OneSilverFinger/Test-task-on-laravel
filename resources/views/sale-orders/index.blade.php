@extends('layouts.app')

@section('title', 'Продажи')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h2>Продажи</h2>
        <a href="{{ route('sale-orders.create') }}" class="btn btn-primary">Создать продажу</a>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Номер</th>
                <th>Дата</th>
                <th>Покупатель</th>
                <th>Магазин</th>
                <th>Сумма</th>
                <th>Оплачено</th>
                <th>Задолженность</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>{{ $order->number }}</td>
                    <td>{{ $order->order_date->format('d.m.Y') }}</td>
                    <td>{{ $order->customer->name }}</td>
                    <td>{{ $order->store->name }}</td>
                    <td class="text-right">{{ number_format($order->total_amount, 2, ',', ' ') }} ₽</td>
                    <td class="text-right">{{ number_format($order->paid_amount, 2, ',', ' ') }} ₽</td>
                    <td class="text-right" style="color: {{ $order->debt_amount > 0 ? '#dc3545' : '#28a745' }}">
                        {{ number_format($order->debt_amount, 2, ',', ' ') }} ₽
                    </td>
                    <td>
                        <a href="{{ route('sale-orders.show', $order) }}" class="btn btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.875rem;">Просмотр</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Нет продаж</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    {{ $orders->links() }}
</div>
@endsection

