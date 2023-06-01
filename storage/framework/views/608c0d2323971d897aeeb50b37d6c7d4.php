

<?php $__env->startSection('MainContent'); ?>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">My Trainees</h1>
            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-user me-1"></i>
                        Trainee Information
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <form action="<?php echo e(route('advisor.trainees-list')); ?>" method="GET">
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
                            <thead class="table-dark">
                                <tr>
                                    <th>Avatar & Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Address</th>
                                    <th>Gender</th>
                                    <th>CV</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($trainees->isEmpty()): ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No trainees found.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php $__currentLoopData = $trainees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trainee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <img src="<?php echo e($trainee->avatar); ?>" class="rounded-circle me-1" width="37px"
                                                    height="40px" alt="<?php echo e($trainee->displayName); ?>'s avatar" />
                                                <?php echo e($trainee->displayName); ?>

                                            </td>
                                            <td><?php echo e($trainee->email); ?></td>
                                            <td><?php echo e($trainee->phone); ?></td>
                                            <td><?php echo e($trainee->address); ?></td>
                                            <td><?php echo e(Str::ucfirst($trainee->gender)); ?></td>
                                            <td><a href="<?php echo e($trainee->cv); ?>">Download
                                                    CV</a></td>
                                            <td>
                                                <a href="<?php echo e(route('advisor.trainee-details', $trainee->id)); ?>"
                                                    class="btn btn-sm btn-success">View Details</a>
                                                <form action="<?php echo e(route('advisor.send-email-form', $trainee->id)); ?>"
                                                    method="GET" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <a href="$"
                                                        class="btn btn-sm btn-secondary"
                                                        onclick="event.preventDefault(); this.closest('form').submit();">Send
                                                        Email</a>
                                                </form>

                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <?php if($trainees->hasPages()): ?>
                            <br>
                        <?php endif; ?>
                        <?php echo e($trainees->links('pagination::bootstrap-5')); ?>

                    </div>
                </div>
            </section>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.advisorLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/advisor/trainees_list.blade.php ENDPATH**/ ?>