

<?php $__env->startSection('title', 'Отчёт: Остатки товаров'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">Остатки товаров</div>
    
    <form method="GET" style="margin-bottom: 2rem; display: flex; gap: 1rem; align-items: end;">
        <div style="flex: 1;">
            <label for="store_id">Магазин</label>
            <select id="store_id" name="store_id" onchange="this.form.submit()">
                <option value="">Все магазины</option>
                <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($store->id); ?>" <?php echo e($storeId == $store->id ? 'selected' : ''); ?>>
                        <?php echo e($store->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    </form>
    
    <table>
        <thead>
            <tr>
                <th>Магазин</th>
                <th>Товар</th>
                <th>Единица</th>
                <th class="text-right">Остаток</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $inventory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($item->store->name); ?></td>
                    <td><?php echo e($item->product->name); ?></td>
                    <td><?php echo e($item->product->unit); ?></td>
                    <td class="text-right"><?php echo e(number_format($item->quantity, 4, ',', ' ')); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="4" class="text-center">Нет остатков</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <?php echo e($inventory->links()); ?>

</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/reports/inventory.blade.php ENDPATH**/ ?>