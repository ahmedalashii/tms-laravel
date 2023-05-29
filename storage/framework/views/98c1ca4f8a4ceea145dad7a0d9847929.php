

<?php $__env->startSection('MainContent'); ?>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">Sent Emails</h1>
            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-user me-1"></i>
                        Sent Emails to Advisors
                    </div>
                    <div class="d-grid gap-0 d-md-flex justify-content-md-end">
                        <a href="<?php echo e(route('trainee.send-email-form')); ?>"> <button class="btn btn-success me-3 mt-2"
                                type="button">Send a new email</button> </a>
                    </div>

                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Advisor Name & Avatar</th>
                                    <th>Email address</th>
                                    <th>Subject</th>
                                    <th>Message</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($sent_emails->isEmpty()): ?>
                                    <tr>
                                        <td colspan="4" class="text-center">No sent emails found.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php $__currentLoopData = $sent_emails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $email): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <img src="<?php echo e($email->advisor->avatar); ?>" class="rounded-circle me-1"
                                                    width="37px" height="40px"
                                                    alt="<?php echo e($email->advisor->displayName); ?>'s avatar" />
                                                <?php echo e($email->advisor->displayName); ?>

                                            </td>
                                            <td><?php echo e($email->advisor->email); ?></td>
                                            <td><?php echo e($email->subject); ?></td>
                                            <td><?php echo e($email->message); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <?php if($sent_emails->hasPages()): ?>
                            <br>
                        <?php endif; ?>
                        <?php echo e($sent_emails->links('pagination::bootstrap-5')); ?>

                    </div>
                </div>
            </section>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.traineeLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/trainee/sent_emails.blade.php ENDPATH**/ ?>