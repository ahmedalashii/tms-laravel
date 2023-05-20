

<?php $__env->startSection('MainContent'); ?>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4"><span class="text-success"><?php echo e($trainee->displayName); ?></span></h1>
            <div class="row">
                <div class="d-flex align-items-center justify-content-center mb-3">
                    <img src="<?php echo e($trainee->avatar); ?>" id="user_avatar" class="avatar_img shadow-lg" alt="avatar" />
                </div>
            </div>
            <form class="mt-2 mb-4" method="POST" action="<?php echo e(route('manager.trainees-update', $trainee->id)); ?>">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="address">Address
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="address" placeholder="Address"
                                value="<?php echo e($trainee->address); ?>" name="address">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="name">Name
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="name" placeholder="Name"
                                value="<?php echo e($trainee->displayName); ?>" name="displayName">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="gender">Gender
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-control" id="gender" name="gender">
                                <option value="-1">Select your gender</option>
                                <?php
                                    $genders = ['male', 'female'];
                                ?>
                                <?php $__currentLoopData = $genders ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gender): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($gender); ?>" <?php if($trainee->gender == $gender): ?> selected <?php endif; ?>>
                                        <?php echo e(ucfirst($gender)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" id="email" value="<?php echo e($trainee->email); ?>"
                                name="email">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="phone">Phone number</label>
                            <input type="text" class="form-control" id="phone" placeholder="Phone number"
                                value="<?php echo e($trainee->phone); ?>" name="phone">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="h-100 d-flex align-items-end pb-2 justify-content-end">
                            <button type="submit" class="btn btn-success pe-4 ps-4">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.managerLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/manager/edit_trainee.blade.php ENDPATH**/ ?>