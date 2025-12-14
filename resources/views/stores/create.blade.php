@extends('layouts.app')

@section('title', 'Создать магазин')

@section('content')
<div class="card">
    <div class="card-header">Создать магазин</div>
    
    <form action="{{ route('stores.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="name">Название *</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        </div>
        
        <div class="form-group">
            <label for="address">Адрес</label>
            <textarea id="address" name="address">{{ old('address') }}</textarea>
        </div>
        
        <div class="form-group">
            <label for="phone">Телефон</label>
            <input type="text" id="phone" name="phone" value="{{ old('phone') }}">
        </div>
        
        <div class="form-group">
            <label>
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                Активен
            </label>
        </div>
        
        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Создать</button>
            <a href="{{ route('stores.index') }}" class="btn">Отмена</a>
        </div>
    </form>
</div>
@endsection

