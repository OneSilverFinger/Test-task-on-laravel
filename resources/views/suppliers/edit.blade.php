@extends('layouts.app')

@section('title', 'Редактировать поставщика')

@section('content')
<div class="card">
    <div class="card-header">Редактировать поставщика</div>
    
    <form action="{{ route('suppliers.update', $supplier) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="name">Название *</label>
            <input type="text" id="name" name="name" value="{{ old('name', $supplier->name) }}" required>
        </div>
        
        <div class="form-group">
            <label for="phone">Телефон</label>
            <input type="text" id="phone" name="phone" value="{{ old('phone', $supplier->phone) }}">
        </div>
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $supplier->email) }}">
        </div>
        
        <div class="form-group">
            <label for="address">Адрес</label>
            <textarea id="address" name="address">{{ old('address', $supplier->address) }}</textarea>
        </div>
        
        <div class="form-group">
            <label for="notes">Примечания</label>
            <textarea id="notes" name="notes">{{ old('notes', $supplier->notes) }}</textarea>
        </div>
        
        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="{{ route('suppliers.index') }}" class="btn">Отмена</a>
        </div>
    </form>
</div>
@endsection

