<?php $__env->startSection('MainContent'); ?>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">Disciplines</h1>
            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-user me-1"></i>
                        Discipline Information
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <form method="GET" action="<?php echo e(route('manager.disciplines')); ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="search" class="form-control"
                                            placeholder="Search for disciplines" aria-label="Search" name="search"
                                            value="<?php echo e(request()->query('search')); ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <button class="btn btn-dark" type="submit">Search</button>
                                    </div>
                                    <div class="col-md-3 d-flex justify-content-end align-items-end pb-3">
                                        <a class="btn btn-success" href="<?php echo e(route('manager.create-discipline')); ?>">Add New
                                            Discipline</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <table class="table table-striped table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Edit</th>
                                    <th>Activate/Deactivate</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($disciplines->isNotEmpty()): ?>
                                    <?php $__currentLoopData = $disciplines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $discipline): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($discipline->name); ?></td>
                                            <td><?php echo e($discipline->description); ?></td>
                                            <td>
                                                <?php if($discipline->trashed()): ?>
                                                    <button class="btn btn-secondary rounded-full btn-hover"
                                                        style="width: 100px; padding: 11px; cursor: not-allowed !important;"
                                                        disabled>
                                                        Edit
                                                    </button>
                                                <?php else: ?>
                                                    <form action="<?php echo e(route('manager.edit-discipline', $discipline->id)); ?>"
                                                        method="GET">
                                                        <button class="btn btn-success btn-sm" type="submit"
                                                            style="width: 100px; padding: 11px;">
                                                            Edit
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($discipline->trashed()): ?>
                                                    <form
                                                        action="<?php echo e(route('manager.activate-discipline', $discipline->id)); ?>"
                                                        method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <button class="btn btn-success rounded-full btn-hover"
                                                            type="submit" style="width: 100px; padding: 11px;">
                                                            Activate
                                                        </button>
                                                    </form>
                                                <?php else: ?>
                                                    <form
                                                        action="<?php echo e(route('manager.deactivate-discipline', $discipline->id)); ?>"
                                                        method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <button class="btn btn-danger rounded-full btn-hover" type="submit"
                                                            style="width: 100px; padding: 11px;">
                                                            Deactivate
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center">No Disciplines Found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <?php if($disciplines->hasPages()): ?>
                            <br>
                        <?php endif; ?>
                        <?php echo e($disciplines->links('pagination::bootstrap-5')); ?>

                    </div>
                </div>
            </section>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.managerLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/manager/disciplines.blade.php ENDPATH**/ ?>