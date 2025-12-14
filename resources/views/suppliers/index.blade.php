@extends('layouts.app')

@section('title', 'Поставщики')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h2>Поставщики</h2>
        <a href="{{ route('suppliers.create') }}" class="btn btn-primary">Добавить поставщика</a>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Телефон</th>
                <th>Email</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @forelse($suppliers as $supplier)
                <tr>
                    <td>{{ $supplier->id }}</td>
                    <td>{{ $supplier->name }}</td>
                    <td>{{ $supplier->phone }}</td>
                    <td>{{ $supplier->email }}</td>
                    <td>
                        <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.875rem;">Редактировать</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Нет поставщиков</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

