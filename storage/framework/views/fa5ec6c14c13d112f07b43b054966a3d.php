

<?php $__env->startSection('MainContent'); ?>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">My Assigned Training Programs</h1>
            <form method="GET" action="<?php echo e(route('advisor.assigned-training-programs')); ?>">
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
                <?php if($training_programs->isNotEmpty()): ?>
                    <div class="row">
                        <?php $__currentLoopData = $training_programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trainingProgram): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-4">
                                <div class="card mt-2" style="height: 500px; overflow-y: scroll;">
                                    <img class="card-img-top"
                                        src="<?php echo e($trainingProgram->thumbnail ? (@getimagesize($trainingProgram->thumbnail) ? $trainingProgram->thumbnail : 'https://www.contentviewspro.com/wp-content/uploads/2017/07/default_image.png') : 'https://www.contentviewspro.com/wp-content/uploads/2017/07/default_image.png'); ?>"
                                        alt="<?php echo e($trainingProgram->name); ?>'s image" height="300px">
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
                                            <?php echo e($trainingProgram->capacity); ?> trainees registered for this
                                            program so
                                            far.
                                        </p>

                                        <p class="card-text"><strong>Discipline: </strong>
                                            <?php echo e($trainingProgram->discipline->name); ?> </p>

                                        <p class="card-text">
                                            <strong>Training Attendances Days: </strong>
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
                                                <b class="text-danger"><?php echo e($trainingProgram->fees); ?>

                                                    USD</b>
                                            <?php endif; ?>
                                        </p>

                                        <p>
                                            <strong>Enrolled Trainees: </strong>
                                            <?php if($trainingProgram->trainees->isEmpty()): ?>
                                                <b class="text-danger">No trainees registered for this program
                                                    yet.</b>
                                            <?php else: ?>
                                                <ul>
                                                    <?php $__currentLoopData = $trainingProgram->trainees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trainee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li>
                                                            <img src="<?php echo e($trainee?->avatar ?? 'https://www.contentviewspro.com/wp-content/uploads/2017/07/default_image.png'); ?>"
                                                                alt="advisor" class="rounded-circle" width="30px"
                                                                height="30px">
                                                            <a href="<?php echo e(route('advisor.trainee-details', $trainee->id)); ?>">
                                                                <?php echo e($trainee->displayName); ?>

                                                            </a>
                                                        </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <br>
                    <div class="alert alert-info"> You're not assigned to any training program <?php if(request()->query('search')): ?>
                            with the search term <b><?php echo e(request()->query('search')); ?></b>
                            <?php endif; ?> <?php if(request()->query('price_filter')): ?>
                                with the price filter factor <b><?php echo e(request()->query('price_filter')); ?></b>
                                <?php endif; ?> <?php if(request()->query('discipline')): ?>
                                    with the discipline
                                    <b><?php echo e(\App\Models\Discipline::find(request()->query('discipline'))?->name); ?></b>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if($training_programs->hasPages()): ?>
                                <br>
                            <?php endif; ?>
                            <?php echo e($training_programs->links('pagination::bootstrap-5')); ?>

                    </div>
            </div>
    </main>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.advisorLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/advisor/assigned_training_programs.blade.php ENDPATH**/ ?>