

<?php $__env->startSection('title', 'Отчёт: Движение товаров'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">Движение товаров</div>
    
    <form method="GET" style="margin-bottom: 2rem; display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem;">
        <div>
            <label for="store_id">Магазин</label>
            <select id="store_id" name="store_id">
                <option value="">Все магазины</option>
                <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($store->id); ?>" <?php echo e($storeId == $store->id ? 'selected' : ''); ?>>
                        <?php echo e($store->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div>
            <label for="product_id">Товар</label>
            <select id="product_id" name="product_id">
                <option value="">Все товары</option>
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($product->id); ?>" <?php echo e($productId == $product->id ? 'selected' : ''); ?>>
                        <?php echo e($product->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div>
            <label for="date_from">С</label>
            <input type="date" id="date_from" name="date_from" value="<?php echo e($dateFrom); ?>">
        </div>
        <div>
            <label for="date_to">По</label>
            <input type="date" id="date_to" name="date_to" value="<?php echo e($dateTo); ?>">
        </div>
        <div style="grid-column: 1 / -1;">
            <button type="submit" class="btn btn-primary">Применить фильтры</button>
            <a href="<?php echo e(route('reports.stock-movements')); ?>" class="btn">Сбросить</a>
        </div>
    </form>
    
    <table>
        <thead>
            <tr>
                <th>Дата</th>
                <th>Магазин</th>
                <th>Товар</th>
                <th>Тип</th>
                <th class="text-right">Количество</th>
                <th class="text-right">Остаток после</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $movements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $movement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($movement->movement_date->format('d.m.Y')); ?></td>
                    <td><?php echo e($movement->store->name); ?></td>
                    <td><?php echo e($movement->product->name); ?></td>
                    <td>
                        <?php if($movement->type == 'purchase'): ?>
                            <span style="color: #28a745;">Приход</span>
                        <?php elseif($movement->type == 'sale'): ?>
                            <span style="color: #dc3545;">Расход</span>
                        <?php else: ?>
                            Корректировка
                        <?php endif; ?>
                    </td>
                    <td class="text-right" style="color: <?php echo e($movement->quantity >= 0 ? '#28a745' : '#dc3545'); ?>">
                        <?php echo e($movement->quantity >= 0 ? '+' : ''); ?><?php echo e(number_format($movement->quantity, 4, ',', ' ')); ?> <?php echo e($movement->product->unit); ?>

                    </td>
                    <td class="text-right"><?php echo e(number_format($movement->quantity_after, 4, ',', ' ')); ?> <?php echo e($movement->product->unit); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="text-center">Нет движений</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <?php echo e($movements->links()); ?>

</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/reports/stock-movements.blade.php ENDPATH**/ ?>