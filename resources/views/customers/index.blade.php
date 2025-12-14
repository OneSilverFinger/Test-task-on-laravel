@extends('layouts.app')

@section('title', 'Покупатели')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h2>Покупатели</h2>
        <a href="{{ route('customers.create') }}" class="btn btn-primary">Добавить покупателя</a>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Телефон</th>
                <th>Email</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customers as $customer)
                <tr>
                    <td>{{ $customer->id }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>
                        <a href="{{ route('customers.edit', $customer) }}" class="btn btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.875rem;">Редактировать</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Нет покупателей</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

