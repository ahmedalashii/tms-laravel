<?php $__env->startSection('MainContent'); ?>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">Apply for Training Program</h1>
            <form action="./apply-for-training" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <h5 class="form-label fs-5">Training Programs</h5>
                    <div class="row">
                        <?php $__currentLoopData = $training_programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $training_program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-4">
                                <div class="card mt-2" style="height: 500px; overflow-y: scroll;">
                                    <img class="card-img-top"
                                        src="<?php echo e($training_program->thumbnail ?? 'https://www.contentviewspro.com/wp-content/uploads/2017/07/default_image.png'); ?>"
                                        alt="<?php echo e($training_program->name); ?>'s image">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo e($training_program->name); ?></h5>
                                        <p class="card-text"><?php echo e($training_program->description); ?></p>
                                        <p class="card-text"><strong>Start Date: </strong>
                                            <?php echo e($training_program->start_date); ?>

                                        </p>
                                        <p class="card-text"><strong>End Date: </strong> <?php echo e($training_program->end_date); ?>

                                        </p>
                                        <p class="card-text"><strong>Duration: </strong> <?php echo e($training_program->duration); ?>

                                            <?php echo e($training_program->duration_unit); ?>

                                        </p>
                                        <p class="card-text"><strong>Location: </strong> <?php echo e($training_program->location); ?>

                                        </p>
                                        <p class="card-text"><strong>Capacity: </strong>
                                            <?php echo e($training_program->users_length); ?> /
                                            <?php echo e($training_program->capacity); ?> trainees registered for this program so far.
                                        </p>
                                        <p class="card-text"><strong>Discipline: </strong>
                                            <?php echo e($training_program->discipline->name); ?> </p>
                                        
                                        <input type="radio" name="training_program"
                                            id="program<?php echo e($training_program->id); ?>" value="<?php echo e($training_program->id); ?>">
                                        <label for="program<?php echo e($training_program->id); ?>">Apply for this program</label>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php if($training_programs->hasPages()): ?>
                        <br>
                    <?php endif; ?>
                    <?php echo e($training_programs->links('pagination::bootstrap-5')); ?>

                </div>

                <!-- Submit -->
                <div class="mb-3 d-flex justify-content-end">
                    <button class="btn btn-success" type="submit" style="width: 100px">Apply</button>
                </div>
            </form>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.traineeLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/trainee/available_training_programs.blade.php ENDPATH**/ ?>