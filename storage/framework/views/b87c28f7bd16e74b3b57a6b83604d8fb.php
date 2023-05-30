

<?php $__env->startSection('MainContent'); ?>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4"><span class="text-success">Create a new task</span></h1>
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
            <?php if($training_programs->isEmpty()): ?>
                <div class="alert alert-danger">You are not assigned to any training program. Please wait for the admin to
                    assign you to a training program.</div>
            <?php else: ?>
                <form class="mt-2 mb-4" action="<?php echo e(route('advisor.create-task')); ?>" method="POST"
                    enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="form-group mb-2">
                        <label for="training-program">Training Program <b style="color: #d50100">*</b></label>
                        <div class="row">
                            <div class="col-md-12">
                                <select class="form-select" aria-label=".form-select-lg example" name="training_program_id"
                                    id="training-program" required>
                                    <option selected value="">Select a training program</option>
                                    <?php $__currentLoopData = $training_programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $training_program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($training_program->id); ?>"><?php echo e($training_program->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-2">
                        <label for="name">Name <b style="color: #d50100">*</b></label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="form-group mb-2">
                        <label for="description">Description <b style="color: #d50100">*</b></label>
                        <input type="text" class="form-control" id="description" name="description" required>
                    </div>


                    <div class="form-group mb-2">
                        <label for="due-date">End Date <b style="color: #d50100">*</b></label>
                        <input type="date" class="form-control" id="end-date" name="end_date" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div>
                                <label for="file" class="form-label">File representing the task (optional)
                                </label>
                                <input class="form-control form-control-lg" id="file" type="file" name="file"
                                    accept="*/*">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-end pb-2 justify-content-end">
                        <button type="submit" class="btn btn-success pe-4 ps-4">Create</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.advisorLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/advisor/create_task.blade.php ENDPATH**/ ?>