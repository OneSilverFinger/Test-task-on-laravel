

<?php $__env->startSection('title', 'Продажа #' . $saleOrder->number); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">Продажа <?php echo e($saleOrder->number); ?></div>
    
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 2rem; margin-bottom: 2rem;">
        <div>
            <p><strong>Дата:</strong> <?php echo e($saleOrder->order_date->format('d.m.Y')); ?></p>
            <p><strong>Покупатель:</strong> <?php echo e($saleOrder->customer->name); ?></p>
            <p><strong>Магазин:</strong> <?php echo e($saleOrder->store->name); ?></p>
        </div>
        <div>
            <p><strong>Общая сумма:</strong> <?php echo e(number_format($saleOrder->total_amount, 2, ',', ' ')); ?> ₽</p>
            <p><strong>Оплачено:</strong> <?php echo e(number_format($saleOrder->paid_amount, 2, ',', ' ')); ?> ₽</p>
            <p><strong>Задолженность:</strong> 
                <span style="color: <?php echo e($saleOrder->debt_amount > 0 ? '#dc3545' : '#28a745'); ?>">
                    <?php echo e(number_format($saleOrder->debt_amount, 2, ',', ' ')); ?> ₽
                </span>
            </p>
        </div>
    </div>
    
    <?php if($saleOrder->notes): ?>
        <div style="margin-bottom: 2rem;">
            <strong>Примечания:</strong> <?php echo e($saleOrder->notes); ?>

        </div>
    <?php endif; ?>
    
    <h3>Товары:</h3>
    <table>
        <thead>
            <tr>
                <th>Товар</th>
                <th>Количество</th>
                <th>Цена</th>
                <th class="text-right">Итого</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $saleOrder->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($item->product->name); ?></td>
                    <td><?php echo e(number_format($item->quantity, 4, ',', ' ')); ?> <?php echo e($item->product->unit); ?></td>
                    <td><?php echo e(number_format($item->price, 2, ',', ' ')); ?> ₽</td>
                    <td class="text-right"><?php echo e(number_format($item->total, 2, ',', ' ')); ?> ₽</td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
        <tfoot>
            <tr style="font-weight: bold;">
                <td colspan="3" class="text-right">Итого:</td>
                <td class="text-right"><?php echo e(number_format($saleOrder->total_amount, 2, ',', ' ')); ?> ₽</td>
            </tr>
        </tfoot>
    </table>
    
    <div class="card" style="margin-top: 2rem;">
        <div class="card-header">Оплаты</div>
        
        <table>
            <thead>
                <tr>
                    <th>Дата</th>
                    <th>Сумма</th>
                    <th>Примечания</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $saleOrder->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($payment->payment_date->format('d.m.Y')); ?></td>
                        <td class="text-right"><?php echo e(number_format($payment->amount, 2, ',', ' ')); ?> ₽</td>
                        <td><?php echo e($payment->notes); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="3" class="text-center">Нет оплат</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <?php if($saleOrder->debt_amount > 0): ?>
            <form action="<?php echo e(route('sale-orders.add-payment', $saleOrder)); ?>" method="POST" style="margin-top: 1rem;">
                <?php echo csrf_field(); ?>
                <div style="display: grid; grid-template-columns: 1fr 1fr 2fr auto; gap: 1rem; align-items: end;">
                    <div>
                        <label>Дата оплаты</label>
                        <input type="date" name="payment_date" value="<?php echo e(date('Y-m-d')); ?>" required>
                    </div>
                    <div>
                        <label>Сумма</label>
                        <input type="number" name="amount" step="0.01" min="0.01" max="<?php echo e($saleOrder->debt_amount); ?>" required>
                    </div>
                    <div>
                        <label>Примечания</label>
                        <input type="text" name="notes">
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success">Добавить оплату</button>
                    </div>
                </div>
            </form>
        <?php endif; ?>
    </div>
    
    <div style="margin-top: 2rem;">
        <a href="<?php echo e(route('sale-orders.index')); ?>" class="btn">Назад к списку</a>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/sale-orders/show.blade.php ENDPATH**/ ?>