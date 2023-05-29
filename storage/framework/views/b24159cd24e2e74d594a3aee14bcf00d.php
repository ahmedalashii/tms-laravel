<?php $__env->startSection('MainContent'); ?>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">Received Emails</h1>
            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-user me-1"></i>
                        Received Emails from Trainees
                    </div>
                    <div class="d-grid gap-0 d-md-flex justify-content-md-end">
                        <a href="<?php echo e(route('advisor.send-email-form')); ?>"> <button class="btn btn-success me-3 mt-2"
                                type="button">Send a new email</button> </a>
                    </div>

                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Trainee Avatar & Name</th>
                                    <th>Email address</th>
                                    <th>Subject</th>
                                    <th>Message</th>
                                    <th>Sent at</th>
                                    <th>Reply</th>
                                    <th>Ignore</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($received_emails->isEmpty()): ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No received emails found.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php $__currentLoopData = $received_emails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $email): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                            <td><?php echo e(Carbon\Carbon::parse($email->created_at)->format('d/m/Y h:i A')); ?></td>
                                            <td>
                                                <a
                                                    href="<?php echo e(route('advisor.send-email-form', ['trainee' => $email->trainee->id])); ?>">
                                                    <button class="btn btn-success me-3 mt-2" type="button">Reply</button>
                                                </a>
                                            </td>
                                            <td>
                                                <form action="<?php echo e(route('advisor.ignore-email', $email->id)); ?>"
                                                    method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <button class="btn btn-danger me-3 mt-2" type="submit">Ignore</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <?php if($received_emails->hasPages()): ?>
                            <br>
                        <?php endif; ?>
                        <?php echo e($received_emails->links('pagination::bootstrap-5')); ?>

                    </div>
                </div>
            </section>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.advisorLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/advisor/received_emails.blade.php ENDPATH**/ ?>