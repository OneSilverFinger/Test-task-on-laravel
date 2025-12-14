@extends('layouts.app')

@section('title', 'Магазины')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h2>Магазины</h2>
        <a href="{{ route('stores.create') }}" class="btn btn-primary">Добавить магазин</a>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Адрес</th>
                <th>Телефон</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @forelse($stores as $store)
                <tr>
                    <td>{{ $store->id }}</td>
                    <td>{{ $store->name }}</td>
                    <td>{{ $store->address }}</td>
                    <td>{{ $store->phone }}</td>
                    <td>{{ $store->is_active ? 'Активен' : 'Неактивен' }}</td>
                    <td>
                        <a href="{{ route('stores.edit', $store) }}" class="btn btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.875rem;">Редактировать</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Нет магазинов</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

