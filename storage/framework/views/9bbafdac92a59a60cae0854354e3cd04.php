

<?php $__env->startSection('MainContent'); ?>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">My Training Requests</h1>
            <form method="GET" action="<?php echo e(route('trainee.all-training-requests')); ?>">
                <div class="row">
                    <div class="col-md-6">
                        <label for="price_filter">Filter based on price</label>
                        <div class="row">
                            <div class="col-md-10">
                                <select class="form-select mb-3" aria-label=".form-select-lg example" id="price_filter"
                                    name="price_filter">
                                    <option selected value="">Select Price Filter Factor</option>
                                    <option value="free" <?php if(request()->get('price_filter') == 'free'): ?> selected <?php endif; ?>>
                                        Free
                                    </option>
                                    <option value="paid" <?php if(request()->get('price_filter') == 'paid'): ?> selected <?php endif; ?>>
                                        Paid
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-success">Filter</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="discipline">Filter based on discipline</label>
                        <div class="row">
                            <div class="col-md-10">
                                <select class="form-select mb-3" aria-label=".form-select-lg example" id="discipline"
                                    name="discipline">
                                    <option selected value="">Select Discipline</option>
                                    <?php $__currentLoopData = $disciplines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $discipline): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($discipline->id); ?>"
                                            <?php if(request()->get('discipline') == $discipline->id): ?> selected <?php endif; ?>>
                                            <?php echo e($discipline->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-success">Filter</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <input type="search" class="form-control" placeholder="Search for training programs"
                            aria-label="Search" name="search" value="<?php echo e(request()->query('search')); ?>">
                    </div>
                    <div class="col-md-2 d-flex justify-content-end">
                        <button class="btn btn-dark" type="submit" style="width: 300px">Search</button>
                    </div>
                </div>
            </form>
            <div class="mb-3">
                <?php if($training_requests->isNotEmpty()): ?>
                    <div class="row">
                        <?php $__currentLoopData = $training_requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trainingRequest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-4">
                                <div class="card mt-2" style="height: 500px; overflow-y: scroll;">
                                    <img class="card-img-top"
                                        src="<?php echo e($trainingRequest->trainingProgram->thumbnail ? (@getimagesize($trainingRequest->trainingProgram->thumbnail) ? $trainingRequest->trainingProgram->thumbnail : 'https://www.contentviewspro.com/wp-content/uploads/2017/07/default_image.png') : 'https://www.contentviewspro.com/wp-content/uploads/2017/07/default_image.png'); ?>"
                                        alt="<?php echo e($trainingRequest->trainingProgram->name); ?>'s image" height="300px">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo e($trainingRequest->trainingProgram->name); ?></h5>
                                        <p class="card-text"><?php echo e($trainingRequest->trainingProgram->description); ?></p>
                                        <p class="card-text">
                                            <strong>Submission Date: </strong>
                                            <?php echo e(Carbon\Carbon::parse($trainingRequest->created_at)->format('d M Y h:i A')); ?>

                                        </p>
                                        <p class="card-text"><strong>Status: </strong>
                                            <?php if($trainingRequest->status == 'pending'): ?>
                                                <span class="text-warning">Pending</span>
                                            <?php elseif($trainingRequest->status == 'approved'): ?>
                                                <span class="text-success">Approved</span>
                                            <?php else: ?>
                                                <span class="text-danger">Rejected</span>
                                            <?php endif; ?>
                                        </p>
                                        <p class="card-text"><strong>Start Date: </strong>
                                            <?php echo e($trainingRequest->trainingProgram->start_date); ?>

                                        </p>
                                        <p class="card-text"><strong>End Date: </strong>
                                            <?php echo e($trainingRequest->trainingProgram->end_date); ?>

                                        </p>
                                        <p class="card-text"><strong>Duration: </strong>
                                            <?php echo e($trainingRequest->trainingProgram->duration); ?>

                                            <?php echo e($trainingRequest->trainingProgram->duration_unit); ?>

                                        </p>
                                        <p class="card-text"><strong>Location: </strong>
                                            <?php echo e($trainingRequest->location); ?>

                                        </p>
                                        <p class="card-text"><strong>Capacity: </strong>
                                            <?php echo e($trainingRequest->trainingProgram->users_length); ?> /
                                            <?php echo e($trainingRequest->trainingProgram->capacity); ?> trainees registered for this
                                            program so
                                            far.
                                        </p>

                                        <p class="card-text"><strong>Discipline: </strong>
                                            <?php echo e($trainingRequest->trainingProgram->discipline->name); ?> </p>
                                        <p class="card-text">
                                            <strong>Advisor: </strong>
                                            <?php if($trainingRequest->advisor): ?>
                                                <img src="<?php echo e($trainingRequest->advisor?->avatar ?? 'https://www.contentviewspro.com/wp-content/uploads/2017/07/default_image.png'); ?>"
                                                    alt="advisor" class="rounded-circle" width="30px" height="30px">
                                                <?php echo e($trainingRequest->advisor->displayName); ?>

                                            <?php else: ?>
                                                <span class="text-danger">No advisor assigned yet.</span>
                                            <?php endif; ?>
                                        </p>
                                        <p class="card-text">
                                            <strong>Training Attendances Dates: </strong>
                                            <?php $__currentLoopData = $trainingRequest->trainingProgram->training_attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $training_attendances): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <ul>
                                                    <li>
                                                        <?php echo e($training_attendances->attendance_day); ?>

                                                    </li>
                                                    <li>
                                                        From
                                                        <?php echo e(date('g:i A', strtotime($training_attendances->start_time))); ?>

                                                        to
                                                        <?php echo e(date('g:i A', strtotime($training_attendances->end_time))); ?>

                                                    </li>
                                                </ul>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </p>
                                        <p>
                                            <strong>Fees: </strong>
                                            <?php if($trainingRequest->trainingProgram->fees <= 0): ?>
                                                <b class="text-success">Free</b>
                                            <?php else: ?>
                                                <b class="text-danger"><?php echo e($trainingRequest->trainingProgram->fees); ?>

                                                    USD</b>
                                            <?php endif; ?>
                                        </p>
                                        <p>
                                            <strong>Fees Paid: </strong>
                                            <?php if($trainingRequest->fees_paid <= 0 && $trainingRequest->trainingProgram->fees <= 0): ?>
                                                <b class="text-success">It's Free</b>
                                            <?php elseif($trainingRequest->fees_paid <= 0 && $trainingRequest->trainingProgram->fees > 0): ?>
                                                <b class="text-danger">Not Paid</b>
                                            <?php elseif($trainingRequest->fees_paid > 0 && $trainingRequest->trainingProgram->fees > 0): ?>
                                                <b class="text-success"><?php echo e($trainingRequest->fees_paid); ?> USD</b>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <br>
                    <div class="alert alert-info">You have not registered for any training program yet.</div>
                <?php endif; ?>
                <?php if($training_requests->hasPages()): ?>
                    <br>
                <?php endif; ?>
                <?php echo e($training_requests->links('pagination::bootstrap-5')); ?>

            </div>
        </div>
    </main>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.traineeLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/trainee/all_training_requests.blade.php ENDPATH**/ ?>