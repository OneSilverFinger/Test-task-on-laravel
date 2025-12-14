@extends('layouts.app')

@section('title', 'Отчёт: Задолженности')

@section('content')
<div class="card" style="margin-bottom: 2rem;">
    <div class="card-header">Дебиторская задолженность (долги покупателей)</div>
    
    <table>
        <thead>
            <tr>
                <th>Покупатель</th>
                <th class="text-right">Сумма задолженности</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customerDebts as $debt)
                <tr>
                    <td>{{ $debt->customer->name }}</td>
                    <td class="text-right" style="color: #dc3545; font-weight: bold;">
                        {{ number_format($debt->total_debt, 2, ',', ' ') }} ₽
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="text-center">Нет дебиторской задолженности</td>
                </tr>
            @endforelse
        </tbody>
        @if($customerDebts->count() > 0)
            <tfoot>
                <tr style="font-weight: bold;">
                    <td class="text-right">Итого:</td>
                    <td class="text-right" style="color: #dc3545;">
                        {{ number_format($customerDebts->sum('total_debt'), 2, ',', ' ') }} ₽
                    </td>
                </tr>
            </tfoot>
        @endif
    </table>
</div>

<div class="card">
    <div class="card-header">Кредиторская задолженность (долги поставщикам)</div>
    
    <table>
        <thead>
            <tr>
                <th>Поставщик</th>
                <th class="text-right">Сумма задолженности</th>
            </tr>
        </thead>
        <tbody>
            @forelse($supplierDebts as $debt)
                <tr>
                    <td>{{ $debt->supplier->name }}</td>
                    <td class="text-right" style="color: #dc3545; font-weight: bold;">
                        {{ number_format($debt->total_debt, 2, ',', ' ') }} ₽
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="text-center">Нет кредиторской задолженности</td>
                </tr>
            @endforelse
        </tbody>
        @if($supplierDebts->count() > 0)
            <tfoot>
                <tr style="font-weight: bold;">
                    <td class="text-right">Итого:</td>
                    <td class="text-right" style="color: #dc3545;">
                        {{ number_format($supplierDebts->sum('total_debt'), 2, ',', ' ') }} ₽
                    </td>
                </tr>
            </tfoot>
        @endif
    </table>
</div>
@endsection

