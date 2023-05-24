<?php $__env->startSection('MainContent'); ?>
    <div class="col-lg-5">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header">
                <h3 class="text-center font-weight-light my-4">Password Recovery</h3>
            </div>
            <div class="card-body">
                <?php if(Session::has('message')): ?>
                    <div class="alert alert-info alert-dismissible fade show">
                        <?php echo e(Session::get('message')); ?>

                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                <?php endif; ?>
                <?php if(Session::has('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <?php echo e(Session::get('error')); ?>

                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                <?php endif; ?>
                <?php if($errors->any()): ?>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <?php echo e($error); ?>

                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>

                <div class="small mb-3 text-muted">Enter your Advisor ID and we will send you a link to reset your
                    password.</div>
                <form id="reset-form" action="<?php echo e(route('advisor.reset')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="form-floating mb-3">
                        <input class="form-control <?php $__errorArgs = ['id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="id" type="text"
                            name="id" value="<?php echo e(old('id')); ?>" required autocomplete="id" autofocus />
                        <label for="id">Your Advisor ID</label>
                        <?php $__errorArgs = ['id'];
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
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                        <a class="small" href="<?php echo e(route('advisor.login')); ?>">Return to login</a>
                        <button type="submit" class="btn btn-success">
                            Reset
                            Password
                        </button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center py-3">
                <div class="small"><a href="<?php echo e(route('advisor.register')); ?>">Need an account? Sign up!</a></div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.authLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/auth/advisor/reset.blade.php ENDPATH**/ ?>