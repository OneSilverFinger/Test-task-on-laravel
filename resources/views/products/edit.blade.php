@extends('layouts.app')

@section('title', 'Редактировать товар')

@section('content')
<div class="card">
    <div class="card-header">Редактировать товар</div>
    
    <form action="{{ route('products.update', $product) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="name">Название *</label>
            <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required>
        </div>
        
        <div class="form-group">
            <label for="sku">Артикул</label>
            <input type="text" id="sku" name="sku" value="{{ old('sku', $product->sku) }}">
        </div>
        
        <div class="form-group">
            <label for="unit">Единица измерения *</label>
            <input type="text" id="unit" name="unit" value="{{ old('unit', $product->unit) }}" required>
        </div>
        
        <div class="form-group">
            <label for="description">Описание</label>
            <textarea id="description" name="description">{{ old('description', $product->description) }}</textarea>
        </div>
        
        <div class="form-group">
            <label>
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                Активен
            </label>
        </div>
        
        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="{{ route('products.index') }}" class="btn">Отмена</a>
        </div>
    </form>
</div>
@endsection

