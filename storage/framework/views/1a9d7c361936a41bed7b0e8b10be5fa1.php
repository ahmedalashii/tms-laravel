<?php $__env->startSection('MainContent'); ?>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">We're excited to have you on board, <span
                    class="text-success"><?php echo e(Auth::guard('advisor')->user()->displayName); ?> 😎</span></h1>

            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-clock me-1"></i>
                        Recently Enrolled Trainees
                    </div>
                    <div class="card-body">
                        <?php if($recent_enrollments->isNotEmpty()): ?>
                            <ul class="list-unstyled">
                                <?php $__currentLoopData = $recent_enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recent_enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <h5 class="mb-0"> <img
                                                    src="<?php echo e($recent_enrollment->trainee->avatar ?? 'https://www.contentviewspro.com/wp-content/uploads/2017/07/default_image.png'); ?>"
                                                    alt="trainee" class="rounded-circle" width="40px" height="40px">
                                                <?php echo e($recent_enrollment->trainee->displayName); ?></h5>
                                            <small><?php echo e($recent_enrollment->trainee->email); ?></small>
                                            <small class="text-muted">Enrolled on
                                                <?php echo e($recent_enrollment->created_at->format('d M Y')); ?></small> |
                                            <small class="text-muted">Training Program:
                                                <?php echo e($recent_enrollment->trainingProgram->name); ?></small>
                                        </div>
                                        <a href="<?php echo e(route('advisor.trainee-details', $recent_enrollment->trainee->id)); ?>"
                                            class="btn btn-sm btn-success">View Details</a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php else: ?>
                            <p class="bg-secondary text-white p-2">There are no recently enrolled trainees. Once a trainee
                                enrolls, they will appear here.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </section>

            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Trainees List</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="<?php echo e(route('advisor.trainees-list')); ?>">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Assigned Tranining Programs</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link"
                                href="<?php echo e(route('advisor.assigned-training-programs')); ?>">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Sent Emails</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link"
                                href="<?php echo e(route('advisor.sent-emails')); ?>">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.advisorLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/advisor/index.blade.php ENDPATH**/ ?>