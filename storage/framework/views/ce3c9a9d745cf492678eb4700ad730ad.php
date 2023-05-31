<?php $__env->startSection('MainContent'); ?>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">Training Request Review</h1>
            <section class="card mb-4 mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-bell me-1"></i>
                        Criteria</span>
                    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample"
                        aria-expanded="false" aria-controls="collapseExample">
                        <i class="fas fa-solid fa-pen-to-square"></i>
                    </button>
                </div>
                <div class="card-body">
                    <p>The following criteria are used to review training requests:</p>
                    <ul>
                        <?php
                            $training_criteria = \App\Models\TrainingCriterion::all();
                        ?>
                        <?php $__currentLoopData = $training_criteria; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $training_criterion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($training_criterion->name); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <div>
                        <form class="collapse" id="collapseExample" action="<?php echo e(route('manager.update-training-criteria')); ?>"
                            method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"
                                    name="criterion"></textarea>
                                <label for="floatingTextarea2">Add New Criterion (Only one at a time represented by one
                                    line)</label>
                            </div>
                            <button class="btn btn-success w-100 mt-2" type="submit">Add Criterion</button>
                        </form>
                    </div>
                </div>
            </section>

            <table class="table table-striped table-bordered">
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
                                    <img src="<?php echo e($training_request->trainee->avatar); ?>" class="rounded-circle me-1"
                                        width="37px" height="40px"
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
                                    <form action="<?php echo e(route('manager.approve-training-request', $training_request->id)); ?>"
                                        method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button class="btn btn-success rounded-full btn-hover" type="submit"
                                            style="width: 100px; padding: 11px;">
                                            Approve
                                        </button>
                                    </form>
                                    <br>
                                    <form action="<?php echo e(route('manager.reject-training-request', $training_request->id)); ?>"
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
            <?php if($training_requests->hasPages()): ?>
                <br>
            <?php endif; ?>
            <?php echo e($training_requests->links('pagination::bootstrap-5')); ?>

        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.managerLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/manager/training_requests.blade.php ENDPATH**/ ?>