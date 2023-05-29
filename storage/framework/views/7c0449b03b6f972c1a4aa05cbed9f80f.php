

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
                            
                                <ol class="list-group list-group-flush" style="max-height: 200px; overflow-y: scroll; overflow-x: hidden;">
                                    <?php $__currentLoopData = $trainee->files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="list-group-item list-decimal" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; !important; ">
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
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.advisorLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/advisor/trainee_details.blade.php ENDPATH**/ ?>