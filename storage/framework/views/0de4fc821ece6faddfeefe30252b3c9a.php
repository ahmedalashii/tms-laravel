<?php $__env->startSection('MainContent'); ?>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">Authorize New Advisors</h1>

            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-user me-1"></i>
                        Advisor Information
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <form action="<?php echo e(route('manager.authorize-advisors')); ?>" method="GET">
                                <div class="row">
                                    <div class="col-md-11">
                                        <input type="search" class="form-control" placeholder="Search for advisors"
                                            aria-label="Search" name="search" value="<?php echo e(request()->query('search')); ?>">
                                    </div>
                                    <div class="col-md-1">
                                        <button class="btn btn-dark" type="submit">Search</button>
                                    </div>
                                </div>
                            </form>
                            <br>
                            <thead class="table-dark">
                                <tr>
                                    <th>Avatar & Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Address</th>
                                    <th>Gender</th>
                                    <th>Is Email Verified?</th>
                                    <th>CV</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($advisors->isEmpty()): ?>
                                    <tr>
                                        <td colspan="8" class="text-center">No advisors found.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php $__currentLoopData = $advisors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $advisor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <img src="<?php echo e($advisor->avatar); ?>" class="rounded-circle me-1" width="37px"
                                                    height="40px" alt="<?php echo e($advisor->displayName); ?>'s avatar" />
                                                <?php echo e($advisor->displayName); ?>

                                            </td>
                                            <td><?php echo e($advisor->email); ?></td>
                                            <td><?php echo e($advisor->phone); ?></td>
                                            <td><?php echo e($advisor->address); ?></td>
                                            <td><?php echo e(ucfirst($advisor->gender)); ?></td>
                                            <td class="min-width">
                                                <p>
                                                    <?php if($advisor->email_verified ?? false): ?>
                                                        Yes <b style="color: #219653;">&#10003;</b>
                                                    <?php else: ?>
                                                        No <b style="color: #d50100;">&#x2717;</b>
                                                    <?php endif; ?>
                                                </p>
                                            </td>
                                            <td><a href="<?php echo e($advisor->cv); ?>">Download
                                                    CV</a></td>
                                            <td>
                                                <?php if($advisor->email_verified ?? false): ?>
                                                    <form action="<?php echo e(route('manager.authorize-advisor', $advisor->id)); ?>"
                                                        method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <button type="submit" class="btn btn-success">Authorize</button>
                                                    </form>
                                                <?php else: ?>
                                                    <form action="<?php echo e(route('manager.verify-advisor', $advisor->id)); ?>"
                                                        method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <button type="submit" class="btn btn-success">
                                                            Send Verification Email
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <?php if($advisors->hasPages()): ?>
                            <br>
                        <?php endif; ?>
                        <?php echo e($advisors->links('pagination::bootstrap-5')); ?>

                    </div>
                </div>
            </section>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.managerLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/manager/authorize_advisors.blade.php ENDPATH**/ ?>