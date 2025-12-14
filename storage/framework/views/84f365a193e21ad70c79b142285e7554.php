

<?php $__env->startSection('title', 'Закупки'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h2>Закупки</h2>
        <a href="<?php echo e(route('purchase-orders.create')); ?>" class="btn btn-primary">Создать закупку</a>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Номер</th>
                <th>Дата</th>
                <th>Поставщик</th>
                <th>Магазин</th>
                <th>Сумма</th>
                <th>Оплачено</th>
                <th>Задолженность</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($order->number); ?></td>
                    <td><?php echo e($order->order_date->format('d.m.Y')); ?></td>
                    <td><?php echo e($order->supplier->name); ?></td>
                    <td><?php echo e($order->store->name); ?></td>
                    <td class="text-right"><?php echo e(number_format($order->total_amount, 2, ',', ' ')); ?> ₽</td>
                    <td class="text-right"><?php echo e(number_format($order->paid_amount, 2, ',', ' ')); ?> ₽</td>
                    <td class="text-right" style="color: <?php echo e($order->debt_amount > 0 ? '#dc3545' : '#28a745'); ?>">
                        <?php echo e(number_format($order->debt_amount, 2, ',', ' ')); ?> ₽
                    </td>
                    <td>
                        <a href="<?php echo e(route('purchase-orders.show', $order)); ?>" class="btn btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.875rem;">Просмотр</a>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="8" class="text-center">Нет закупок</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <?php echo e($orders->links()); ?>

</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/purchase-orders/index.blade.php ENDPATH**/ ?>