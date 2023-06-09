

<?php $__env->startSection('MainContent'); ?>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4"><span class="text-success"><?php echo e($trainee->displayName); ?></span> profile</h1>
            <div class="row">
                <div class="d-flex align-items-center justify-content-center mb-3">
                    <img src="<?php echo e($trainee->avatar); ?>" id="user_avatar" class="avatar_img shadow-lg" alt="avatar" />
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Address</h5>
                            <p class="card-text"><?php echo e($trainee->address); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Name</h5>
                            <p class="card-text"><?php echo e($trainee->displayName); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Email</h5>
                            <p class="card-text"><?php echo e($trainee->email); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Phone Number</h5>
                            <p class="card-text"><?php echo e($trainee->phone); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">CV File: <a href="<?php echo e($trainee->cv); ?>" target="_blank"
                                    class="btn btn-success">View CV File</a>
                            </h5>
                            <h5 class="card-title">Files Uploaded:</h5>
                            <?php if($trainee->files->isNotEmpty()): ?>
                                <ol class="list-group list-group-flush"
                                    style="max-height: 200px; overflow-y: scroll; overflow-x: hidden;">
                                    <?php $__currentLoopData = $trainee->files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="list-group-item list-decimal">
                                            <a href="<?php echo e($file->url); ?>" target="_blank"><?php echo e($file->description); ?></a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ol>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Disciplines</h5>
                            <?php if($trainee->disciplines->isNotEmpty()): ?>
                                <ul>
                                    <?php $__currentLoopData = $trainee->disciplines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $discipline): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($discipline->name); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Enrolled Training Programs</h5>
                            <?php
                                // Enrolled Programs Related to this Advisor
                                $enrolledPrograms = $trainee->training_programs->where('advisor_id', auth_advisor()->id);
                            ?>
                            <?php if($enrolledPrograms->isNotEmpty()): ?>
                                <ol class="list-group list-group-flush"
                                    style="max-height: 200px; overflow-y: scroll; overflow-x: hidden;">
                                    <?php $__currentLoopData = $enrolledPrograms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enrolledProgram): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="list-group-item list-decimal">
                                            <?php echo e($enrolledProgram->name); ?>

                                            <?php
                                                $submittedTasks = $enrolledProgram->tasks->load([
                                                    'files' => function ($query) use ($trainee) {
                                                        $query->where('trainee_id', $trainee->id);
                                                    },
                                                ]);
                                                // only the submitted tasks related to this trainee
                                                $submittedTasks = $submittedTasks->filter(function ($task) {
                                                    return $task->files->isNotEmpty();
                                                });
                                            ?>
                                            <?php if($submittedTasks->isNotEmpty()): ?>
                                                <br>
                                                <strong>Submitted Tasks Files:</strong>
                                                <ul>
                                                    <?php $__currentLoopData = $submittedTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submittedTask): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li>
                                                            <span class="text-success"><?php echo e($submittedTask->name); ?></span>
                                                            <ul>
                                                                <?php $__currentLoopData = $submittedTask->files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <li>
                                                                        <a href="<?php echo e($file->url); ?>"
                                                                            target="_blank"><?php echo e($file->name); ?></a>
                                                                    </li>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </ul>
                                                        </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ol>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.advisorLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/advisor/trainee_details.blade.php ENDPATH**/ ?>