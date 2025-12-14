

<?php $__env->startSection('title', 'Отчёт: Движение денежных средств'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">Движение денежных средств</div>
    
    <div class="grid" style="margin-bottom: 2rem;">
        <div class="stat-card">
            <h3>Текущий остаток кассы</h3>
            <div class="value" style="color: <?php echo e($balance >= 0 ? '#28a745' : '#dc3545'); ?>">
                <?php echo e(number_format($balance, 2, ',', ' ')); ?> ₽
            </div>
        </div>
        <div class="stat-card">
            <h3>Приход за период</h3>
            <div class="value" style="color: #28a745">
                <?php echo e(number_format($income, 2, ',', ' ')); ?> ₽
            </div>
        </div>
        <div class="stat-card">
            <h3>Расход за период</h3>
            <div class="value" style="color: #dc3545">
                <?php echo e(number_format($expense, 2, ',', ' ')); ?> ₽
            </div>
        </div>
    </div>
    
    <form method="GET" style="margin-bottom: 2rem; display: grid; grid-template-columns: 1fr 1fr auto; gap: 1rem; align-items: end;">
        <div>
            <label for="date_from">С</label>
            <input type="date" id="date_from" name="date_from" value="<?php echo e($dateFrom); ?>">
        </div>
        <div>
            <label for="date_to">По</label>
            <input type="date" id="date_to" name="date_to" value="<?php echo e($dateTo); ?>">
        </div>
        <div>
            <button type="submit" class="btn btn-primary">Применить</button>
            <a href="<?php echo e(route('reports.cash-movements')); ?>" class="btn">Сбросить</a>
        </div>
    </form>
    
    <table>
        <thead>
            <tr>
                <th>Дата</th>
                <th>Тип</th>
                <th>Категория</th>
                <th>Описание</th>
                <th class="text-right">Сумма</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $movements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $movement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($movement->movement_date->format('d.m.Y')); ?></td>
                    <td>
                        <?php if($movement->type == 'income'): ?>
                            <span style="color: #28a745;">Приход</span>
                        <?php else: ?>
                            <span style="color: #dc3545;">Расход</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($movement->category == 'sale_payment'): ?>
                            Оплата продажи
                        <?php elseif($movement->category == 'purchase_payment'): ?>
                            Оплата закупки
                        <?php else: ?>
                            Прочее
                        <?php endif; ?>
                    </td>
                    <td><?php echo e($movement->description); ?></td>
                    <td class="text-right" style="color: <?php echo e($movement->type == 'income' ? '#28a745' : '#dc3545'); ?>">
                        <?php echo e($movement->type == 'income' ? '+' : '-'); ?><?php echo e(number_format($movement->amount, 2, ',', ' ')); ?> ₽
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="text-center">Нет движений</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <?php echo e($movements->links()); ?>

</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/reports/cash-movements.blade.php ENDPATH**/ ?>