

<?php $__env->startSection('title', 'Создать товар'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">Создать товар</div>
    
    <form action="<?php echo e(route('products.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        
        <div class="form-group">
            <label for="name">Название *</label>
            <input type="text" id="name" name="name" value="<?php echo e(old('name')); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="sku">Артикул</label>
            <input type="text" id="sku" name="sku" value="<?php echo e(old('sku')); ?>">
        </div>
        
        <div class="form-group">
            <label for="unit">Единица измерения *</label>
            <input type="text" id="unit" name="unit" value="<?php echo e(old('unit', 'шт')); ?>" required>
            <small>Например: шт, кг, м, л и т.п.</small>
        </div>
        
        <div class="form-group">
            <label for="description">Описание</label>
            <textarea id="description" name="description"><?php echo e(old('description')); ?></textarea>
        </div>
        
        <div class="form-group">
            <label>
                <input type="checkbox" name="is_active" value="1" <?php echo e(old('is_active', true) ? 'checked' : ''); ?>>
                Активен
            </label>
        </div>
        
        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Создать</button>
            <a href="<?php echo e(route('products.index')); ?>" class="btn">Отмена</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/products/create.blade.php ENDPATH**/ ?>