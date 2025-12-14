@extends('layouts.app')

@section('title', 'Отчёт: Движение денежных средств')

@section('content')
<div class="card">
    <div class="card-header">Движение денежных средств</div>
    
    <div class="grid" style="margin-bottom: 2rem;">
        <div class="stat-card">
            <h3>Текущий остаток кассы</h3>
            <div class="value" style="color: {{ $balance >= 0 ? '#28a745' : '#dc3545' }}">
                {{ number_format($balance, 2, ',', ' ') }} ₽
            </div>
        </div>
        <div class="stat-card">
            <h3>Приход за период</h3>
            <div class="value" style="color: #28a745">
                {{ number_format($income, 2, ',', ' ') }} ₽
            </div>
        </div>
        <div class="stat-card">
            <h3>Расход за период</h3>
            <div class="value" style="color: #dc3545">
                {{ number_format($expense, 2, ',', ' ') }} ₽
            </div>
        </div>
    </div>
    
    <form method="GET" style="margin-bottom: 2rem; display: grid; grid-template-columns: 1fr 1fr auto; gap: 1rem; align-items: end;">
        <div>
            <label for="date_from">С</label>
            <input type="date" id="date_from" name="date_from" value="{{ $dateFrom }}">
        </div>
        <div>
            <label for="date_to">По</label>
            <input type="date" id="date_to" name="date_to" value="{{ $dateTo }}">
        </div>
        <div>
            <button type="submit" class="btn btn-primary">Применить</button>
            <a href="{{ route('reports.cash-movements') }}" class="btn">Сбросить</a>
        </div>
    </form>
    
    <table>
        <thead>
            <tr>
                <th>Дата</th>
                <th>Тип</th>
                <th>Категория</th>
                <th>Описание</th>
                <th class="text-right">Сумма</th>
            </tr>
        </thead>
        <tbody>
            @forelse($movements as $movement)
                <tr>
                    <td>{{ $movement->movement_date->format('d.m.Y') }}</td>
                    <td>
                        @if($movement->type == 'income')
                            <span style="color: #28a745;">Приход</span>
                        @else
                            <span style="color: #dc3545;">Расход</span>
                        @endif
                    </td>
                    <td>
                        @if($movement->category == 'sale_payment')
                            Оплата продажи
                        @elseif($movement->category == 'purchase_payment')
                            Оплата закупки
                        @else
                            Прочее
                        @endif
                    </td>
                    <td>{{ $movement->description }}</td>
                    <td class="text-right" style="color: {{ $movement->type == 'income' ? '#28a745' : '#dc3545' }}">
                        {{ $movement->type == 'income' ? '+' : '-' }}{{ number_format($movement->amount, 2, ',', ' ') }} ₽
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Нет движений</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    {{ $movements->links() }}
</div>
@endsection

