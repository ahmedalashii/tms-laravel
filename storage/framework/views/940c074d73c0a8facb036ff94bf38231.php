

<?php $__env->startSection('MainContent'); ?>
    <main>
        <div class="container-fluid px-4">
            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-reply me-1"></i>
                        Send Email to Trainee
                    </div>

                    <form action="<?php echo e(route('advisor.send-email')); ?>" class="card-body" id="send-email-form" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="col-12 mt-2">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="alert alert-danger"><?php echo e($message); ?></div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <?php if($trainee ?? false): ?>
                            <div class="form-group mb-2">
                                <label for="to">To (Trainee Email) <b class="text-danger">*</b></label>
                                <input type="email" class="form-control" id="to" name="email"
                                    value="<?php echo e($trainee->email ?? ''); ?>" readonly>
                            </div>
                        <?php else: ?>
                            <div class="form-group mb-2">
                                <label for="to">To (Trainee Email) <b class="text-danger">*</b></label>
                                <select class="form-control" name="email" id="to" required>
                                    <option value="">Select a trainee</option>
                                    <?php $__currentLoopData = $trainees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trainee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($trainee->email); ?>"><?php echo e($trainee->displayName); ?>:
                                            <?php echo e($trainee->email); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        <?php endif; ?>
                        <div class="form-group">
                            <label for="subject">Subject <b class="text-danger">*</b></label>
                            <input type="text" class="form-control" id="subject" name="subject" required
                                <?php if($subject ?? false): ?> value="Re:[<?php echo e($subject ?? ''); ?>]" <?php endif; ?>>
                        </div>
                        <div class="form-group mt-2">
                            <label for="message">Message Content <b class="text-danger">*</b></label>
                            <textarea class="form-control" id="message" style="min-height: 150px;" required name="message"></textarea>
                        </div>
                        <div class="form-group mt-2">
                            <button type="submit" class="btn btn-success">Send Email</button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.advisorLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/advisor/send_email.blade.php ENDPATH**/ ?>