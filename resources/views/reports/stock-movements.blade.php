@extends('layouts.app')

@section('title', 'Отчёт: Движение товаров')

@section('content')
<div class="card">
    <div class="card-header">Движение товаров</div>
    
    <form method="GET" style="margin-bottom: 2rem; display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem;">
        <div>
            <label for="store_id">Магазин</label>
            <select id="store_id" name="store_id">
                <option value="">Все магазины</option>
                @foreach($stores as $store)
                    <option value="{{ $store->id }}" {{ $storeId == $store->id ? 'selected' : '' }}>
                        {{ $store->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="product_id">Товар</label>
            <select id="product_id" name="product_id">
                <option value="">Все товары</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ $productId == $product->id ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="date_from">С</label>
            <input type="date" id="date_from" name="date_from" value="{{ $dateFrom }}">
        </div>
        <div>
            <label for="date_to">По</label>
            <input type="date" id="date_to" name="date_to" value="{{ $dateTo }}">
        </div>
        <div style="grid-column: 1 / -1;">
            <button type="submit" class="btn btn-primary">Применить фильтры</button>
            <a href="{{ route('reports.stock-movements') }}" class="btn">Сбросить</a>
        </div>
    </form>
    
    <table>
        <thead>
            <tr>
                <th>Дата</th>
                <th>Магазин</th>
                <th>Товар</th>
                <th>Тип</th>
                <th class="text-right">Количество</th>
                <th class="text-right">Остаток после</th>
            </tr>
        </thead>
        <tbody>
            @forelse($movements as $movement)
                <tr>
                    <td>{{ $movement->movement_date->format('d.m.Y') }}</td>
                    <td>{{ $movement->store->name }}</td>
                    <td>{{ $movement->product->name }}</td>
                    <td>
                        @if($movement->type == 'purchase')
                            <span style="color: #28a745;">Приход</span>
                        @elseif($movement->type == 'sale')
                            <span style="color: #dc3545;">Расход</span>
                        @else
                            Корректировка
                        @endif
                    </td>
                    <td class="text-right" style="color: {{ $movement->quantity >= 0 ? '#28a745' : '#dc3545' }}">
                        {{ $movement->quantity >= 0 ? '+' : '' }}{{ number_format($movement->quantity, 4, ',', ' ') }} {{ $movement->product->unit }}
                    </td>
                    <td class="text-right">{{ number_format($movement->quantity_after, 4, ',', ' ') }} {{ $movement->product->unit }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Нет движений</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    {{ $movements->links() }}
</div>
@endsection

