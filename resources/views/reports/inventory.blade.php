@extends('layouts.app')

@section('title', 'Отчёт: Остатки товаров')

@section('content')
<div class="card">
    <div class="card-header">Остатки товаров</div>
    
    <form method="GET" style="margin-bottom: 2rem; display: flex; gap: 1rem; align-items: end;">
        <div style="flex: 1;">
            <label for="store_id">Магазин</label>
            <select id="store_id" name="store_id" onchange="this.form.submit()">
                <option value="">Все магазины</option>
                @foreach($stores as $store)
                    <option value="{{ $store->id }}" {{ $storeId == $store->id ? 'selected' : '' }}>
                        {{ $store->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>
    
    <table>
        <thead>
            <tr>
                <th>Магазин</th>
                <th>Товар</th>
                <th>Единица</th>
                <th class="text-right">Остаток</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inventory as $item)
                <tr>
                    <td>{{ $item->store->name }}</td>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->product->unit }}</td>
                    <td class="text-right">{{ number_format($item->quantity, 4, ',', ' ') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Нет остатков</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    {{ $inventory->links() }}
</div>
@endsection

