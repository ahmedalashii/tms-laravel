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
                                <div class="alert alert-danger"><b style="color: black;">Note: </b> No advisors found to
                                    schedule a meeting with. This is
                                    because there are no approved training programs that has an advisor assigned to it.
                                </div>
                            <?php endif; ?>
                            <div class="mb-3">
                                <label for="advisor" class="form-label">Advisor <b class="text-danger">*</b></label>
                                <select class="form-control" name="advisor">
                                    <option value="">Select an advisor</option>
                                    <?php $__currentLoopData = $advisors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $advisor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($advisor->id); ?>"
                                            <?php if(old('advisor') == $advisor->id): ?> selected <?php endif; ?>><?php echo e($advisor->displayName); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Preferred Date <b class="text-danger">*</b></label>
                                <input type="date" class="form-control" name="date"
                                    min="<?php echo e(Carbon\Carbon::now()->format('Y-m-d')); ?>" value="<?php echo e(old('date')); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="time" class="form-label">Preferred Time <b class="text-danger">*</b></label>
                                <input type="time" class="form-control" name="time" min="<?php echo e(date('H:i')); ?>"
                                    value="<?php echo e(old('time')); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="location" class="form-label">Location <b class="text-danger">*</b></label>
                                <input type="text" class="form-control" name="location" value="<?php echo e(old('location')); ?>">
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

            

            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-clock me-1"></i>
                        All Requested Meetings
                    </div>
                    <div class="card-body">
                        <?php if($meetings->isEmpty()): ?>
                            <div class="alert alert-danger"><b style="color: black;">Note: </b> No meetings found.</div>
                        <?php else: ?>
                            <table class="table table-striped table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Advisor</th>
                                        <th>Preferred Date</th>
                                        <th>Preferred Time</th>
                                        <th>Location</th>
                                        <th>Notes</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $meetings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meeting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($meeting->advisor->displayName); ?></td>
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
                                                    <form action="<?php echo e(route('trainee.cancel-meeting', $meeting->id)); ?>"
                                                        method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <button type="submit" class="btn btn-sm btn-danger">Cancel
                                                            Meeting</button>
                                                    </form>
                                                <?php else: ?>
                                                    <button class="btn btn-sm btn-secondary" disabled>Cancel
                                                        Meeting</button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            <?php if($meetings->hasPages()): ?>
                                <br>
                            <?php endif; ?>
                            <?php echo e($meetings->links('pagination::bootstrap-5')); ?>

                        <?php endif; ?>
                    </div>
                </div>
            </section>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.traineeLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/trainee/request_meeting.blade.php ENDPATH**/ ?>