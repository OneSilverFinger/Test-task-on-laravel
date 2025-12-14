@extends('layouts.app')

@section('title', 'Товары')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h2>Товары</h2>
        <a href="{{ route('products.create') }}" class="btn btn-primary">Добавить товар</a>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Артикул</th>
                <th>Единица</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->sku }}</td>
                    <td>{{ $product->unit }}</td>
                    <td>{{ $product->is_active ? 'Активен' : 'Неактивен' }}</td>
                    <td>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.875rem;">Редактировать</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Нет товаров</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

