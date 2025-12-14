

<?php $__env->startSection('title', 'Главная'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">Панель управления</div>
    
    <div class="grid">
        <div class="stat-card">
            <h3>Остаток кассы</h3>
            <div class="value" style="color: <?php echo e($cashBalance >= 0 ? '#28a745' : '#dc3545'); ?>">
                <?php echo e(number_format($cashBalance, 2, ',', ' ')); ?> ₽
            </div>
        </div>
        
        <div class="stat-card">
            <h3>Дебиторская задолженность</h3>
            <div class="value" style="color: #667eea">
                <?php echo e(number_format($totalCustomerDebt, 2, ',', ' ')); ?> ₽
            </div>
        </div>
        
        <div class="stat-card">
            <h3>Кредиторская задолженность</h3>
            <div class="value" style="color: #dc3545">
                <?php echo e(number_format($totalSupplierDebt, 2, ',', ' ')); ?> ₽
            </div>
        </div>
        
        <div class="stat-card">
            <h3>Закупки за месяц</h3>
            <div class="value" style="color: #ffc107">
                <?php echo e(number_format($monthPurchases, 2, ',', ' ')); ?> ₽
            </div>
        </div>
        
        <div class="stat-card">
            <h3>Продажи за месяц</h3>
            <div class="value" style="color: #28a745">
                <?php echo e(number_format($monthSales, 2, ',', ' ')); ?> ₽
            </div>
        </div>
    </div>
    
    <div style="margin-top: 2rem;">
        <a href="<?php echo e(route('purchase-orders.create')); ?>" class="btn btn-primary">Создать закупку</a>
        <a href="<?php echo e(route('sale-orders.create')); ?>" class="btn btn-success">Создать продажу</a>
        <a href="<?php echo e(route('reports.inventory')); ?>" class="btn btn-primary">Отчёты</a>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/home.blade.php ENDPATH**/ ?>