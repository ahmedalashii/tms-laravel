<?php $__env->startSection('MainContent'); ?>
    <main>
        <?php
            $manager = Auth::guard('manager')->user();
            $manager_db = \App\Models\Manager::where('firebase_uid', $manager->localId)->first();
        ?>
        <div class="container-fluid px-4">
            <h1 class="mt-4">We're excited to have you on board, <span class="text-success"><?php echo e($manager->displayName); ?>

                    😎</span>
            </h1>

            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-warning me-1"></i>
                        Recent Training Requests
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Trainee Avatar & Name</th>
                                    <th>Trainee Email Address</th>
                                    <th>Training Program Requested</th>
                                    <th>Fees</th>
                                    <th>Has paid?</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($training_requests->isNotEmpty()): ?>
                                    <?php $__currentLoopData = $training_requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $training_request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <img src="<?php echo e($training_request->trainee->avatar); ?>"
                                                    class="rounded-circle me-1" width="37px" height="40px"
                                                    alt="<?php echo e($training_request->trainee->displayName); ?>'s avatar" />
                                                <?php echo e($training_request->trainee->displayName); ?>

                                            </td>
                                            <td><?php echo e($training_request->trainee->email); ?></td>
                                            <td><?php echo e($training_request->trainingProgram->name); ?></td>
                                            <td>
                                                <?php if($training_request->trainingProgram->fees): ?>
                                                    $<?php echo e($training_request->trainingProgram->fees); ?>

                                                <?php else: ?>
                                                    <span class="badge bg-success">Free</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($training_request->fees_paid): ?>
                                                    <span class="badge bg-success">Yes: <b
                                                            style="color: white; font-weight: 500">$<?php echo e($training_request->fees_paid); ?></b></span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">No</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e($training_request->trainingProgram->start_date); ?></td>
                                            <td><?php echo e($training_request->trainingProgram->end_date); ?></td>
                                            <td>
                                                <form
                                                    action="<?php echo e(route('manager.approve-training-request', $training_request->id)); ?>"
                                                    method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <button class="btn btn-success rounded-full btn-hover" type="submit"
                                                        style="width: 100px; padding: 11px;">
                                                        Approve
                                                    </button>
                                                </form>
                                                <br>
                                                <form
                                                    action="<?php echo e(route('manager.reject-training-request', $training_request->id)); ?>"
                                                    method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <button class="btn btn-danger rounded-full btn-hover" type="submit"
                                                        style="width: 100px; padding: 11px;">
                                                        Reject
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center">No training requests found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Training Requests</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="<?php echo e(route('manager.training-requests')); ?>">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Disciplines</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="<?php echo e(route('manager.disciplines')); ?>">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Training Programs</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="<?php echo e(route('manager.training-programs')); ?>">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Authorize Trainees</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link"
                                href="<?php echo e(route('manager.authorize-trainees')); ?>">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="<?php if($manager_db?->role == 'super_manager'): ?> col-xl-4 <?php else: ?> col-xl-6 <?php endif; ?> col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Trainees</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="<?php echo e(route('manager.trainees')); ?>">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>

                <div class="<?php if($manager_db?->role == 'super_manager'): ?> col-xl-4 <?php else: ?> col-xl-6 <?php endif; ?> col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Issues</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="<?php echo e(route('manager.issues')); ?>">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>

                <?php if($manager_db?->role == 'super_manager'): ?>
                    <div class="col-xl-4 col-md-6">
                        <div class="card bg-success text-white mb-4">
                            <div class="card-body">Managers Authorization</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="<?php echo e(route('manager.managers')); ?>">View
                                    Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.managerLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/manager/index.blade.php ENDPATH**/ ?>