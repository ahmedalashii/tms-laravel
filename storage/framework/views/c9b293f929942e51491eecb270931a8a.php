<?php $__env->startSection('MainContent'); ?>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">Request a Meeting with Advisor</h1>
            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-clock me-1"></i>
                        Schedule a Meeting
                    </div>
                    <div class="card-body">
                        <div class="col-12 mt-2">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="alert alert-danger"><?php echo e($message); ?></div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <form action="<?php echo e(route('trainee.schedule-meeting')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php if($advisors->isEmpty()): ?>
                                    <div class="alert alert-danger"><b style="color: black;">Note: </b> No advisors found to schedule a meeting with. This is
                                        because there are no approved training programs that has an advisor assigned to it.</div>
                            <?php endif; ?>
                            <div class="mb-3">
                                <label for="advisor" class="form-label">Advisor <b class="text-danger">*</b></label>
                                <select class="form-control" name="advisor">
                                    <option value="">Select an advisor</option>
                                    <?php $__currentLoopData = $advisors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $advisor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($advisor->id); ?>"><?php echo e($advisor->displayName); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Date <b class="text-danger">*</b></label>
                                <input type="date" class="form-control" name="date">
                            </div>
                            <div class="mb-3">
                                <label for="time" class="form-label">Time <b class="text-danger">*</b></label>
                                <input type="time" class="form-control" name="time">
                            </div>
                            <div class="mb-3">
                                <label for="location" class="form-label">Location <b class="text-danger">*</b></label>
                                <input type="text" class="form-control" name="location">
                            </div>

                            <div class="mb-3">
                                <label for="notes">Notes (optional)</label>
                                <textarea class="form-control" id="notes" name="notes"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success">Request meeting</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.traineeLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/trainee/request_meeting.blade.php ENDPATH**/ ?>