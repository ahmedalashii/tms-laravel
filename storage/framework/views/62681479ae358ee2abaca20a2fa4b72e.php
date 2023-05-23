

<?php $__env->startSection('MainContent'); ?>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4"><span class="text-success"><?php echo e($discipline->name); ?></span></h1>
            <form action="<?php echo e(route('manager.update-discipline', $discipline->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="form-group mb-2">
                    <label for="name">Name <b style="color: #d50100">*</b></label>
                    <input type="text" class="form-control" id="name" value="<?php echo e($discipline->name); ?>" name="name"
                        required>
                </div>

                <div class="form-group mb-2">
                    <label for="description">Description <b style="color: #d50100">*</b></label>
                    <input type="text" class="form-control" id="description" value="<?php echo e($discipline->description); ?>"
                        name="description" required>
                </div>

                <div class="d-flex align-items-end pb-2 justify-content-end">
                    <button type="submit" class="btn btn-success pe-4 ps-4">Save</button>
                    <a href="<?php echo e(route('manager.disciplines')); ?>" class="btn btn-danger ms-2">Cancel</a>
                </div>

            </form>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.managerLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/manager/edit_discipline.blade.php ENDPATH**/ ?>