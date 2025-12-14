

<?php $__env->startSection('title', 'Поставщики'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h2>Поставщики</h2>
        <a href="<?php echo e(route('suppliers.create')); ?>" class="btn btn-primary">Добавить поставщика</a>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Телефон</th>
                <th>Email</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($supplier->id); ?></td>
                    <td><?php echo e($supplier->name); ?></td>
                    <td><?php echo e($supplier->phone); ?></td>
                    <td><?php echo e($supplier->email); ?></td>
                    <td>
                        <a href="<?php echo e(route('suppliers.edit', $supplier)); ?>" class="btn btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.875rem;">Редактировать</a>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="text-center">Нет поставщиков</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/suppliers/index.blade.php ENDPATH**/ ?>