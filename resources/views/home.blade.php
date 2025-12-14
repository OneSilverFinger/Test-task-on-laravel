@extends('layouts.app')

@section('title', 'Главная')

@section('content')
<div class="card">
    <div class="card-header">Панель управления</div>
    
    <div class="grid">
        <div class="stat-card">
            <h3>Остаток кассы</h3>
            <div class="value" style="color: {{ $cashBalance >= 0 ? '#28a745' : '#dc3545' }}">
                {{ number_format($cashBalance, 2, ',', ' ') }} ₽
            </div>
        </div>
        
        <div class="stat-card">
            <h3>Дебиторская задолженность</h3>
            <div class="value" style="color: #667eea">
                {{ number_format($totalCustomerDebt, 2, ',', ' ') }} ₽
            </div>
        </div>
        
        <div class="stat-card">
            <h3>Кредиторская задолженность</h3>
            <div class="value" style="color: #dc3545">
                {{ number_format($totalSupplierDebt, 2, ',', ' ') }} ₽
            </div>
        </div>
        
        <div class="stat-card">
            <h3>Закупки за месяц</h3>
            <div class="value" style="color: #ffc107">
                {{ number_format($monthPurchases, 2, ',', ' ') }} ₽
            </div>
        </div>
        
        <div class="stat-card">
            <h3>Продажи за месяц</h3>
            <div class="value" style="color: #28a745">
                {{ number_format($monthSales, 2, ',', ' ') }} ₽
            </div>
        </div>
    </div>
    
    <div style="margin-top: 2rem;">
        <a href="{{ route('purchase-orders.create') }}" class="btn btn-primary">Создать закупку</a>
        <a href="{{ route('sale-orders.create') }}" class="btn btn-success">Создать продажу</a>
        <a href="{{ route('reports.inventory') }}" class="btn btn-primary">Отчёты</a>
    </div>
</div>
@endsection

