@extends('layouts.app')

@section('title', 'Создать продажу')

@section('content')
<div class="card">
    <div class="card-header">Создать продажу</div>
    
    <form action="{{ route('sale-orders.store') }}" method="POST" id="orderForm">
        @csrf
        
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-bottom: 2rem;">
            <div class="form-group">
                <label for="customer_id">Покупатель *</label>
                <select id="customer_id" name="customer_id" required>
                    <option value="">Выберите покупателя</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label for="store_id">Магазин *</label>
                <select id="store_id" name="store_id" required>
                    <option value="">Выберите магазин</option>
                    @foreach($stores as $store)
                        <option value="{{ $store->id }}" {{ old('store_id') == $store->id ? 'selected' : '' }}>
                            {{ $store->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label for="order_date">Дата *</label>
                <input type="date" id="order_date" name="order_date" value="{{ old('order_date', date('Y-m-d')) }}" required>
            </div>
        </div>
        
        <div class="form-group">
            <label for="notes">Примечания</label>
            <textarea id="notes" name="notes">{{ old('notes') }}</textarea>
        </div>
        
        <div class="card" style="margin-top: 2rem;">
            <div class="card-header">Товары</div>
            <div id="items-container">
                <div class="item-row" style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr auto; gap: 1rem; align-items: end; margin-bottom: 1rem;">
                    <div>
                        <label>Товар *</label>
                        <select name="items[0][product_id]" class="product-select" required>
                            <option value="">Выберите товар</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" data-unit="{{ $product->unit }}">
                                    {{ $product->name }} ({{ $product->unit }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label>Количество *</label>
                        <input type="number" name="items[0][quantity]" step="0.0001" min="0.0001" class="quantity-input" required>
                        <small class="unit-label"></small>
                    </div>
                    <div>
                        <label>Цена за единицу *</label>
                        <input type="number" name="items[0][price]" step="0.01" min="0" class="price-input" required>
                    </div>
                    <div>
                        <label>Итого</label>
                        <input type="text" class="total-input" readonly style="font-weight: bold;">
                    </div>
                    <div>
                        <button type="button" class="btn btn-danger remove-item" style="padding: 0.5rem;">×</button>
                    </div>
                </div>
            </div>
            <button type="button" id="add-item" class="btn btn-primary">Добавить товар</button>
            <div style="margin-top: 1rem; font-size: 1.25rem; font-weight: bold;">
                Итого: <span id="grand-total">0.00</span> ₽
            </div>
        </div>
        
        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">Создать продажу</button>
            <a href="{{ route('sale-orders.index') }}" class="btn">Отмена</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
let itemIndex = 1;

document.getElementById('add-item').addEventListener('click', function() {
    const container = document.getElementById('items-container');
    const template = container.querySelector('.item-row').cloneNode(true);
    
    template.querySelectorAll('input, select').forEach(input => {
        const name = input.name || input.className;
        if (name.includes('items[0]')) {
            input.name = name.replace('items[0]', `items[${itemIndex}]`);
            if (input.type !== 'hidden') {
                input.value = '';
            }
        }
        input.classList.remove('is-invalid');
    });
    
    container.appendChild(template);
    attachItemEvents(template);
    itemIndex++;
});

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-item')) {
        if (document.querySelectorAll('.item-row').length > 1) {
            e.target.closest('.item-row').remove();
            calculateTotals();
        }
    }
});

function attachItemEvents(itemRow) {
    const productSelect = itemRow.querySelector('.product-select');
    const quantityInput = itemRow.querySelector('.quantity-input');
    const priceInput = itemRow.querySelector('.price-input');
    const totalInput = itemRow.querySelector('.total-input');
    const unitLabel = itemRow.querySelector('.unit-label');
    
    productSelect.addEventListener('change', function() {
        const unit = this.options[this.selectedIndex].dataset.unit || '';
        unitLabel.textContent = unit;
        calculateItemTotal(itemRow);
    });
    
    quantityInput.addEventListener('input', () => calculateItemTotal(itemRow));
    priceInput.addEventListener('input', () => calculateItemTotal(itemRow));
}

function calculateItemTotal(itemRow) {
    const quantity = parseFloat(itemRow.querySelector('.quantity-input').value) || 0;
    const price = parseFloat(itemRow.querySelector('.price-input').value) || 0;
    const total = quantity * price;
    itemRow.querySelector('.total-input').value = total.toFixed(2);
    calculateTotals();
}

function calculateTotals() {
    let grandTotal = 0;
    document.querySelectorAll('.item-row').forEach(row => {
        const total = parseFloat(row.querySelector('.total-input').value) || 0;
        grandTotal += total;
    });
    document.getElementById('grand-total').textContent = grandTotal.toFixed(2);
}

document.querySelectorAll('.item-row').forEach(row => attachItemEvents(row));
</script>
@endpush
@endsection

