

<?php $__env->startSection('MainContent'); ?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4 mb-4"><span class="text-success">Create New Discipline</span></h1>
        <?php if(Session::has('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?php echo e(Session::get('error')); ?>

                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php endif; ?>

        <div class="col-12 mt-2">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="alert alert-danger"><?php echo e($message); ?></div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <form class="mt-2 mb-4" action="<?php echo e(route('manager.store-discipline')); ?>" method="POST">
            <?php echo csrf_field(); ?>
        
            <div class="form-group mb-2">
                <label for="name">Name <b style="color: #d50100">*</b></label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="form-group mb-2">
                <label for="description">Description <b style="color: #d50100">*</b></label>
                <input type="text" class="form-control" id="description" name="description" required>
            </div>

            <div class="d-flex align-items-end pb-2 justify-content-end">
                <button type="submit" class="btn btn-success pe-4 ps-4">Create</button>
                <a href="<?php echo e(route('manager.disciplines')); ?>" class="btn btn-danger ms-2">Cancel</a>
            </div>
        </form>
    </div>
</main>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.managerLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/manager/create_discipline.blade.php ENDPATH**/ ?>