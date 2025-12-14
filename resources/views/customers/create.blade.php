@extends('layouts.app')

@section('title', 'Создать покупателя')

@section('content')
<div class="card">
    <div class="card-header">Создать покупателя</div>
    
    <form action="{{ route('customers.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="name">Имя *</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        </div>
        
        <div class="form-group">
            <label for="phone">Телефон</label>
            <input type="text" id="phone" name="phone" value="{{ old('phone') }}">
        </div>
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}">
        </div>
        
        <div class="form-group">
            <label for="address">Адрес</label>
            <textarea id="address" name="address">{{ old('address') }}</textarea>
        </div>
        
        <div class="form-group">
            <label for="notes">Примечания</label>
            <textarea id="notes" name="notes">{{ old('notes') }}</textarea>
        </div>
        
        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Создать</button>
            <a href="{{ route('customers.index') }}" class="btn">Отмена</a>
        </div>
    </form>
</div>
@endsection

