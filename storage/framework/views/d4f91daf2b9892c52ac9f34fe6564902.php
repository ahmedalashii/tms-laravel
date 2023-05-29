

<?php $__env->startSection('MainContent'); ?>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">Sent Emails</h1>
            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-user me-1"></i>
                        Sent Emails to Trainees
                    </div>
                    <div class="d-grid gap-0 d-md-flex justify-content-md-end">
                        <a href="<?php echo e(route('advisor.send-email-form')); ?>"> <button class="btn btn-success me-3 mt-2"
                                type="button">Send a new email</button> </a>
                    </div>

                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Trainee Name & Avatar</th>
                                    <th>Email address</th>
                                    <th>Subject</th>
                                    <th>Message</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($sent_emails->isEmpty()): ?>
                                    <tr>
                                        <td colspan="4" class="text-center">No emails found.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php $__currentLoopData = $sent_emails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $email): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <img src="<?php echo e($email->trainee->avatar); ?>" class="rounded-circle me-1"
                                                    width="37px" height="40px"
                                                    alt="<?php echo e($email->trainee->displayName); ?>'s avatar" />
                                                <?php echo e($email->trainee->displayName); ?>

                                            </td>
                                            <td><?php echo e($email->trainee->email); ?></td>
                                            <td><?php echo e($email->subject); ?></td>
                                            <td><?php echo e($email->message); ?></td>
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

<?php echo $__env->make('layouts.advisorLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/advisor/sent_emails.blade.php ENDPATH**/ ?>