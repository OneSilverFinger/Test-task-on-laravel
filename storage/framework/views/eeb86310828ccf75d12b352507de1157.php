

<?php $__env->startSection('title', 'Создать покупателя'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">Создать покупателя</div>
    
    <form action="<?php echo e(route('customers.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        
        <div class="form-group">
            <label for="name">Имя *</label>
            <input type="text" id="name" name="name" value="<?php echo e(old('name')); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="phone">Телефон</label>
            <input type="text" id="phone" name="phone" value="<?php echo e(old('phone')); ?>">
        </div>
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>">
        </div>
        
        <div class="form-group">
            <label for="address">Адрес</label>
            <textarea id="address" name="address"><?php echo e(old('address')); ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="notes">Примечания</label>
            <textarea id="notes" name="notes"><?php echo e(old('notes')); ?></textarea>
        </div>
        
        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Создать</button>
            <a href="<?php echo e(route('customers.index')); ?>" class="btn">Отмена</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/customers/create.blade.php ENDPATH**/ ?>