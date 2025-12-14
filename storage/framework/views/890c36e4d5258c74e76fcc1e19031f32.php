

<?php $__env->startSection('title', 'Магазины'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h2>Магазины</h2>
        <a href="<?php echo e(route('stores.create')); ?>" class="btn btn-primary">Добавить магазин</a>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Адрес</th>
                <th>Телефон</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($store->id); ?></td>
                    <td><?php echo e($store->name); ?></td>
                    <td><?php echo e($store->address); ?></td>
                    <td><?php echo e($store->phone); ?></td>
                    <td><?php echo e($store->is_active ? 'Активен' : 'Неактивен'); ?></td>
                    <td>
                        <a href="<?php echo e(route('stores.edit', $store)); ?>" class="btn btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.875rem;">Редактировать</a>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="text-center">Нет магазинов</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/stores/index.blade.php ENDPATH**/ ?>