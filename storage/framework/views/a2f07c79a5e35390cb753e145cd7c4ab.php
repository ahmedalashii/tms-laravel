

<?php $__env->startSection('MainContent'); ?>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">Managers</h1>
            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-user me-1"></i>
                        Manager Information
                    </div>
                    <div class="card-body">
                        <form action="<?php echo e(route('manager.managers')); ?>" method="GET">
                            <div class="row">
                                <div class="col-md-11">
                                    <input type="search" class="form-control" placeholder="Search for trainees"
                                        aria-label="Search" name="search" value="<?php echo e(request()->query('search')); ?>">
                                </div>
                                <div class="col-md-1">
                                    <button class="btn btn-dark" type="submit">Search</button>
                                </div>
                            </div>
                        </form>
                        <br>
                        <table class="table table-striped table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Name</th>
                                    <th>Email address</th>
                                    <th>Address</th>
                                    <th>Phone Number</th>
                                    <th>Activate/Deactivate</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($managers->isEmpty()): ?>
                                    <tr>
                                        <td colspan="10" class="text-center">No trainees found.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php $__currentLoopData = $managers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manager): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($manager->displayName); ?></td>
                                            <td><?php echo e($manager->email); ?></td>
                                            <td><?php echo e($manager->address); ?></td>
                                            <td><?php echo e($manager->phone); ?></td>
                                            <td>
                                                <form method="POST"
                                                    action="<?php if($manager->is_active ?? false): ?> <?php echo e(route('manager.deactivate-manager', $manager->id)); ?> <?php else: ?> <?php echo e(route('manager.activate-manager', $manager->id)); ?> <?php endif; ?>">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="id" value="<?php echo e($manager->id); ?>" />
                                                    <button type="submit"
                                                        class="btn <?php if($manager->is_active ?? false): ?> btn-danger <?php else: ?> btn-success <?php endif; ?>">
                                                        <?php if($manager->is_active ?? false): ?>
                                                            Deactivate
                                                        <?php else: ?>
                                                            Activate
                                                        <?php endif; ?>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.managerLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/manager/managers.blade.php ENDPATH**/ ?>