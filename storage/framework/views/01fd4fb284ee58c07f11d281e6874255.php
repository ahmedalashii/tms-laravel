<?php $__env->startSection('MainContent'); ?>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">Apply for Training Program</h1>
            <h5 class="form-label fs-5">Training Programs</h5>
            <form method="GET" action="<?php echo e(route('trainee.available-training-programs')); ?>">
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
            <form action="<?php echo e(route('trainee.apply-training-program')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <?php if($training_programs->isNotEmpty()): ?>
                        <div class="row">
                            <?php $__currentLoopData = $training_programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trainingProgram): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-4">
                                    <div class="card mt-2" style="height: 500px; overflow-y: scroll;">
                                        <img class="card-img-top"
                                            src="<?php echo e($trainingProgram->thumbnail ?? 'https://www.contentviewspro.com/wp-content/uploads/2017/07/default_image.png'); ?>"
                                            alt="<?php echo e($trainingProgram->name); ?>'s image">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo e($trainingProgram->name); ?></h5>
                                            <p class="card-text"><?php echo e($trainingProgram->description); ?></p>
                                            <p class="card-text"><strong>Start Date: </strong>
                                                <?php echo e($trainingProgram->start_date); ?>

                                            </p>
                                            <p class="card-text"><strong>End Date: </strong>
                                                <?php echo e($trainingProgram->end_date); ?>

                                            </p>
                                            <p class="card-text"><strong>Duration: </strong>
                                                <?php echo e($trainingProgram->duration); ?>

                                                <?php echo e($trainingProgram->duration_unit); ?>

                                            </p>
                                            <p class="card-text"><strong>Location: </strong>
                                                <?php echo e($trainingProgram->location); ?>

                                            </p>
                                            <p class="card-text"><strong>Capacity: </strong>
                                                <?php echo e($trainingProgram->users_length); ?> /
                                                <?php echo e($trainingProgram->capacity); ?> trainees registered for this program so
                                                far.
                                            </p>
                                            <p class="card-text"><strong>Discipline: </strong>
                                                <?php echo e($trainingProgram->discipline->name); ?> </p>

                                            <p class="card-text">
                                                <strong>Advisor: </strong>
                                                <?php if($trainingProgram->advisor): ?>
                                                    <img src="<?php echo e($trainingProgram->advisor?->avatar ?? 'https://www.contentviewspro.com/wp-content/uploads/2017/07/default_image.png'); ?>"
                                                        alt="advisor" class="rounded-circle" width="30px" height="30px">
                                                    <?php echo e($trainingProgram->advisor->displayName); ?>

                                                <?php else: ?>
                                                    <span class="text-danger">No advisor assigned yet.</span>
                                                <?php endif; ?>
                                            </p>

                                            <p class="card-text">
                                                <strong>Training Attendances Dates: </strong>
                                                <?php $__currentLoopData = $trainingProgram->training_attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $training_attendances): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                                <?php if($trainingProgram->fees <= 0): ?>
                                                    <b class="text-success">Free</b>
                                                <?php else: ?>
                                                    <b class="text-danger"><?php echo e($trainingProgram->fees); ?> USD</b>
                                                <?php endif; ?>
                                            </p>

                                            <input type="radio" name="training_program_id"
                                                id="program<?php echo e($trainingProgram->id); ?>" value="<?php echo e($trainingProgram->id); ?>">
                                            <label for="program<?php echo e($trainingProgram->id); ?>">Choose this program</label>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <br>
                        <div class="alert alert-info">No training programs available at the moment.</div>
                    <?php endif; ?>
                    <?php if($training_programs->hasPages()): ?>
                        <br>
                    <?php endif; ?>
                    <?php echo e($training_programs->links('pagination::bootstrap-5')); ?>

                </div>

                <?php if(count($training_programs) > 0): ?>
                    <div class="mb-3 d-flex justify-content-end">
                        <button class="btn btn-success" type="submit" style="width: 100px">Apply</button>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.traineeLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/trainee/available_training_programs.blade.php ENDPATH**/ ?>