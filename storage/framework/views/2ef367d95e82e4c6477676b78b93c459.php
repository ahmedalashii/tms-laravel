<?php $__env->startSection('MainContent'); ?>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">We're excited to have you on board, <span
                    class="text-success"><?php echo e(auth_trainee()->displayName); ?> 😎</span></h1>

            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-clock me-1"></i>
                        Timeline of Tasks in the last 30 days
                    </div>
                    <div class="card-body">
                        <?php if($tasks->isEmpty()): ?>
                            <p class="bg-secondary text-white p-2">There are no tasks available. Once a task is added, it
                                will appear here.</p>
                        <?php else: ?>
                            <ul class="list-unstyled">
                                <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <h5 class="mb-0"><?php echo e($task->name); ?></h5>
                                            <?php if($task->file_url): ?>
                                                <small><strong>File: </strong>
                                                    <a href="<?php echo e($task->file_url); ?>"
                                                        target="_blank"><?php echo e($task->name); ?>.<?php echo e($task->file()->extension); ?></a>
                                                </small><br>
                                            <?php endif; ?>
                                            <small><strong>Training Program: </strong>
                                                <?php echo e($task->trainingProgram->name); ?>

                                            </small><br>
                                            <small><?php echo e($task->description); ?></small>
                                            <small
                                                <?php if(Carbon\Carbon::parse($task->end_date)->diffInDays(Carbon\Carbon::now()) <= 4): ?> style="color: red;" <?php else: ?>
                                                class="text-muted" <?php endif; ?>>
                                                Deadline: <?php echo e(Carbon\Carbon::parse($task->end_date)->format('d M Y')); ?>

                                            </small>
                                        </div>
                                        <a href="<?php echo e(route('trainee.upload', $task->id)); ?>" class="btn btn-sm btn-success"
                                            style="width:95px;">
                                            <?php if($task->submittedFileUrl): ?>
                                                Edit Submission
                                            <?php else: ?>
                                                Add Submission
                                            <?php endif; ?>
                                        </a>
                                    </li>
                                    
                                    <?php if(!$loop->last): ?>
                                        <hr>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </section>

            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-clock me-1"></i>
                        Newly Added Training Programs
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <?php $__currentLoopData = $recent_programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recent_program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h5 class="mb-0"><?php echo e($recent_program->name); ?></h5>
                                        <small><?php echo e($recent_program->description); ?></small>
                                        <small class="text-muted">Added on
                                            <?php echo e($recent_program->created_at->format('d M Y')); ?></small>
                                    </div>
                                    <a href="<?php echo e(route('trainee.available-training-programs')); ?>"
                                        class="btn btn-sm btn-success">View Details</a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            </section>

            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Training Program Task Submission</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="<?php echo e(route('trainee.upload')); ?>">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Apply For Training Programs</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link"
                                href="<?php echo e(route('trainee.available-training-programs')); ?>">View Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">My Training Requests</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link"
                                href="<?php echo e(route('trainee.all-training-requests')); ?>">View Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">My Approved Training Programs</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link"
                                href="<?php echo e(route('trainee.approved-training-programs')); ?>">View Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Training Attendance</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link"
                                href="<?php echo e(route('trainee.training-attendance')); ?>">View Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Request a Meeting</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="<?php echo e(route('trainee.request-meeting')); ?>">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Advisors List</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="<?php echo e(route('trainee.advisors-list')); ?>">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Sent a new Email</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="<?php echo e(route('trainee.send-email-form')); ?>">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Received Emails</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="<?php echo e(route('trainee.received-emails')); ?>">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Sent Emails</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="<?php echo e(route('trainee.sent-emails')); ?>">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.traineeLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/trainee/index.blade.php ENDPATH**/ ?>