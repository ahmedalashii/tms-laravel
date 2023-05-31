<?php $__env->startSection('MainContent'); ?>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">Meetings Schedule</h1>
            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-user me-1"></i>
                        Meetings Schedule
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Trainee Avatar & Name</th>
                                    <th>Email address</th>
                                    <th>Preferred Date</th>
                                    <th>Preferred Time</th>
                                    <th>Location</th>
                                    <th>Notes</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($meetings->isNotEmpty()): ?>
                                    <?php $__currentLoopData = $meetings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meeting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <img src="<?php echo e($meeting->trainee->avatar ?? 'https://www.contentviewspro.com/wp-content/uploads/2017/07/default_image.png'); ?>"
                                                    class="rounded-circle me-1" width="40px" alt="Trainee's avatar" />
                                                <?php echo e($meeting->trainee->displayName); ?>

                                            </td>
                                            <td><?php echo e($meeting->trainee->email); ?></td>
                                            <td><?php echo e($meeting->date); ?></td>
                                            <td><?php echo e(Carbon\Carbon::parse($meeting->time)->format('h:i A')); ?></td>
                                            <td><?php echo e($meeting->location); ?></td>
                                            <td><?php echo e($meeting->notes); ?></td>
                                            <td>
                                                <?php if($meeting->status == 'pending'): ?>
                                                    <span
                                                        class="badge bg-warning text-dark"><?php echo e(Str::ucfirst($meeting->status)); ?></span>
                                                <?php elseif($meeting->status == 'approved'): ?>
                                                    <span
                                                        class="badge bg-success"><?php echo e(Str::ucfirst($meeting->status)); ?></span>
                                                <?php elseif($meeting->status == 'rejected' || $meeting->status == 'cancelled'): ?>
                                                    <span
                                                        class="badge bg-danger"><?php echo e(Str::ucfirst($meeting->status)); ?></span>
                                                <?php else: ?>
                                                    <span
                                                        class="badge bg-secondary"><?php echo e(Str::ucfirst($meeting->status)); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($meeting->status == 'pending'): ?>
                                                    <form action="<?php echo e(route('advisor.reject-meeting', $meeting->id)); ?>"
                                                        method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            style="width: 80px;">Reject
                                                        </button>
                                                    </form>
                                                    <hr>
                                                    <form action="<?php echo e(route('advisor.approve-meeting', $meeting->id)); ?>"
                                                        method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <button type="submit" class="btn btn-sm btn-success"
                                                            style="width: 80px">Approve
                                                        </button>
                                                    </form>
                                                <?php elseif($meeting->status == 'rejected' || $meeting->status == 'cancelled' || $meeting->status == 'approved'): ?>
                                                    <form action="<?php echo e(route('advisor.reject-meeting', $meeting->id)); ?>"
                                                        method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <button type="submit" class="btn btn-sm btn-danger" disabled
                                                            style="width: 80px">Reject
                                                        </button>
                                                    </form>
                                                    <hr>

                                                    <form action="<?php echo e(route('advisor.approve-meeting', $meeting->id)); ?>"
                                                        method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <button type="submit" class="btn btn-sm btn-success" disabled
                                                            style="width: 80px">Approve
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7">
                                            <p class="bg-secondary text-white p-2">There are no meetings scheduled. Once a
                                                trainee
                                                schedules a meeting, it will appear here.</p>
                                        </td>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <?php if($meetings->hasPages()): ?>
                            <br>
                        <?php endif; ?>
                        <?php echo e($meetings->links('pagination::bootstrap-5')); ?>

                    </div>
                </div>
            </section>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.advisorLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/advisor/meetings_schedule.blade.php ENDPATH**/ ?>