@extends('layouts.app')

@section('title', 'Создать товар')

@section('content')
<div class="card">
    <div class="card-header">Создать товар</div>
    
    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="name">Название *</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        </div>
        
        <div class="form-group">
            <label for="sku">Артикул</label>
            <input type="text" id="sku" name="sku" value="{{ old('sku') }}">
        </div>
        
        <div class="form-group">
            <label for="unit">Единица измерения *</label>
            <input type="text" id="unit" name="unit" value="{{ old('unit', 'шт') }}" required>
            <small>Например: шт, кг, м, л и т.п.</small>
        </div>
        
        <div class="form-group">
            <label for="description">Описание</label>
            <textarea id="description" name="description">{{ old('description') }}</textarea>
        </div>
        
        <div class="form-group">
            <label>
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                Активен
            </label>
        </div>
        
        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Создать</button>
            <a href="{{ route('products.index') }}" class="btn">Отмена</a>
        </div>
    </form>
</div>
@endsection

