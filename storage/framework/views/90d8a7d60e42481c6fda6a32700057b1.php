<?php $__env->startSection('MainContent'); ?>
    <?php
        $traineeFirbase = Auth::guard('trainee')->user();
        $trainee = \App\Models\Trainee::where('firebase_uid', $traineeFirbase->localId)->first();
        $trainee->load('disciplines');
    ?>

    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4"><span class="text-success">Edit</span> your profile</h1>
            <div class="row">
                <div class="d-flex align-items-center justify-content-center mb-3">
                    <img src="<?php echo e($trainee->avatar); ?>" id="user_avatar" class="avatar_img shadow-lg" alt="avatar" />
                </div>
            </div>
            <form class="mt-2 mb-4" method="POST" action="<?php echo e(route('trainee.update', $trainee->id)); ?>"
                enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="avatar_input">Change Avatar</label>
                            <input class="form-control form-control-lg" id="avatar_input" type="file" name="avatar-image"
                                accept="image/*">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="address">Address
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="address" placeholder="Address"
                                value="<?php echo e($trainee->address); ?>" name="address">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="name">Name
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="name" placeholder="Name"
                                value="<?php echo e($trainee->displayName); ?>" name="displayName">
                        </div>
                    </div>
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
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="email">Email address
                                <strong class="text-danger">*</strong>
                            </label>
                            <input type="email" class="form-control" id="email" value="<?php echo e($trainee->email); ?>"
                                name="email">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="phone">Phone number
                                <strong class="text-danger">*</strong>
                            </label>
                            <input type="text" class="form-control" id="phone" placeholder="Phone number"
                                value="<?php echo e($trainee->phone); ?>" name="phone">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="disciplines">Select one or more disciplines that you are interested in
                            <strong class="text-danger">*</strong>
                        </label>
                        <br>
                        <div class="form-group">
                            <?php $__currentLoopData = $disciplines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $discipline): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="form-check">
                                    <input type="checkbox" name="disciplines[]" value="<?php echo e($discipline->id); ?>"
                                        class="form-check-input" id="discipline-<?php echo e($discipline->id); ?>"
                                        <?php if($trainee->hasDiscipline($discipline->id)): ?> checked <?php endif; ?>>
                                    <label class="form-check-label"
                                        for="discipline-<?php echo e($discipline->id); ?>"><?php echo e($discipline->name); ?></label>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="h-100 d-flex align-items-end pb-2 justify-content-end">
                            <button type="submit" class="btn btn-success pe-4 ps-4">Save</button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="col-12 mt-2">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="alert alert-danger"><?php echo e($message); ?></div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.traineeLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/trainee/edit.blade.php ENDPATH**/ ?>