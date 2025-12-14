@extends('layouts.app')

@section('title', 'Редактировать магазин')

@section('content')
<div class="card">
    <div class="card-header">Редактировать магазин</div>
    
    <form action="{{ route('stores.update', $store) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="name">Название *</label>
            <input type="text" id="name" name="name" value="{{ old('name', $store->name) }}" required>
        </div>
        
        <div class="form-group">
            <label for="address">Адрес</label>
            <textarea id="address" name="address">{{ old('address', $store->address) }}</textarea>
        </div>
        
        <div class="form-group">
            <label for="phone">Телефон</label>
            <input type="text" id="phone" name="phone" value="{{ old('phone', $store->phone) }}">
        </div>
        
        <div class="form-group">
            <label>
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $store->is_active) ? 'checked' : '' }}>
                Активен
            </label>
        </div>
        
        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="{{ route('stores.index') }}" class="btn">Отмена</a>
        </div>
    </form>
</div>
@endsection

