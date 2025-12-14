

<?php $__env->startSection('title', 'Покупатели'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h2>Покупатели</h2>
        <a href="<?php echo e(route('customers.create')); ?>" class="btn btn-primary">Добавить покупателя</a>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Телефон</th>
                <th>Email</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($customer->id); ?></td>
                    <td><?php echo e($customer->name); ?></td>
                    <td><?php echo e($customer->phone); ?></td>
                    <td><?php echo e($customer->email); ?></td>
                    <td>
                        <a href="<?php echo e(route('customers.edit', $customer)); ?>" class="btn btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.875rem;">Редактировать</a>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="text-center">Нет покупателей</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/customers/index.blade.php ENDPATH**/ ?>