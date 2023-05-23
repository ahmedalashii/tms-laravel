<?php $__env->startSection('MainContent'); ?>
    <div class="col-lg-7">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header">
                <h3 class="text-center font-weight-light my-4">Create Trainee Account</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php if(Session::has('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <?php echo e(Session::get('error')); ?>

                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    <?php endif; ?>

                    <div class="col-12 mt-2">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="alert alert-danger"><?php echo e($message); ?></div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <form action="<?php echo e(route('trainee.register')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="name"
                                    type="text" name="name" required autocomplete="name" autofocus
                                    value="<?php echo e(old('name')); ?>" />
                                <label for="name">Name
                                    <strong class="text-danger">*</strong>

                                </label>
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="email" type="email"
                            name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" />
                        <label for="email">Email address
                            <strong class="text-danger">*</strong>

                        </label>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="invalid-feedback" role="alert">
                                <strong><?php echo e($message); ?></strong>
                            </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="phone" type="phone" placeholder="+972 XX XXX XXX XXXX"
                            name="phone" required />
                        <label for="phone">Phone number
                            <strong class="text-danger">*</strong>
                        </label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="address" type="text" placeholder="Address" name="address"
                            required />
                        <label for="address">Address
                            <strong class="text-danger">*</strong>
                        </label>
                    </div>
                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" id="gender"
                        name="gender" required>
                        <option value="-1">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                    <label for="disciplines">Select one or more disciplines that you are interested in
                        <strong class="text-danger">*</strong>
                    </label>
                    <div class="form-group">
                        <?php $__currentLoopData = $disciplines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $discipline): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="form-check">
                                <input type="checkbox" name="disciplines[]" value="<?php echo e($discipline->id); ?>"
                                    class="form-check-input" id="discipline-<?php echo e($discipline->id); ?>">
                                <label class="form-check-label"
                                    for="discipline-<?php echo e($discipline->id); ?>"><?php echo e($discipline->name); ?></label>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div>
                                <label for="avatar-image" class="form-label">You avatar image
                                    <strong class="text-danger">*</strong>
                                </label>
                                <input class="form-control form-control-lg" id="avatar-image" type="file"
                                    name="avatar-image" accept="image/*" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div>
                                <label for="cv-file" class="form-label">Your CV
                                    <strong class="text-danger">*</strong>
                                </label>
                                <input class="form-control form-control-lg" id="cv-file" name="cv-file" type="file"
                                    accept=".pdf,.docx,.doc" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div>
                            <div class="form-floating mb-3 mb-md-0">
                                <input class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="password"
                                    type="password" name="password" required autocomplete="new-password" />
                                <label for="password">Password
                                    <strong class="text-danger">*</strong>
                                </label>
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="form-floating mb-3 mb-md-0">
                                <input class="form-control" id="password-confirm" type="password"
                                    name="password_confirmation" required autocomplete="new-password" />
                                <label for="password-confirm">Confirm Password
                                    <strong class="text-danger">*</strong>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 mb-0">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-block">
                                Create Account
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center py-3">
                <div class="small"><a href="<?php echo e(route('trainee.login')); ?>">Have an account? Go to login</a></div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.authLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/auth/trainee/register.blade.php ENDPATH**/ ?>