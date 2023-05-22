<?php $__env->startSection('MainContent'); ?>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">Training Programs</h1>
            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-user me-1"></i>
                        Training Programs Information
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <form method="GET" action="<?php echo e(route('manager.training-programs')); ?>">
                                    <label for="gender">Filter based on discipline</label>
                                    <div class="row">
                                        <div class="col-md-10">
                                            <select class="form-select mb-3" aria-label=".form-select-lg example"
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
                                </form>
                            </div>

                            <div class="col-md-8 d-flex justify-content-end align-items-end pb-3">
                                <a class="btn btn-success" href="<?php echo e(route('manager.create-training-program')); ?>">Add New
                                    Training Program</a>
                            </div>
                        </div>
                        <table class="table table-striped table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Duration</th>
                                    <th>Discipline</th>
                                    <th>Location</th>
                                    <th>Fees</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Edit</th>
                                    <th>Activate/Deactivate</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($training_programs->isNotEmpty()): ?>
                                    <?php $__currentLoopData = $training_programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $training_program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($training_program->name); ?></td>
                                            <td><?php echo e($training_program->description); ?></td>
                                            <td><?php echo e($training_program->duration); ?> <?php echo e($training_program->duration_unit); ?>

                                            </td>
                                            <td><?php echo e($training_program->discipline->name); ?></td>
                                            <td><?php echo e($training_program->location); ?></td>
                                            <td>
                                                <?php if($training_program->fees): ?>
                                                    <?php echo e($training_program->fees); ?> ₪
                                                <?php else: ?>
                                                    <b style="color: green">Free</b>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e($training_program->start_date); ?></td>
                                            <td><?php echo e($training_program->end_date); ?></td>
                                            <td>
                                                <?php if($training_program->trashed()): ?>
                                                    <button class="btn btn-secondary rounded-full btn-hover"
                                                        style="width: 100px; padding: 11px; cursor: not-allowed !important;"
                                                        disabled>
                                                        Edit
                                                    </button>
                                                <?php else: ?>
                                                    <form
                                                        action="<?php echo e(route('manager.edit-training-program', $training_program->id)); ?>"
                                                        method="GET">
                                                        <button class="btn btn-success btn-sm" type="submit"
                                                            style="width: 100px; padding: 11px;">
                                                            Edit
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($training_program->trashed()): ?>
                                                    <form
                                                        action="<?php echo e(route('manager.activate-training-program', $training_program->id)); ?>"
                                                        method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <button class="btn btn-success rounded-full btn-hover"
                                                            type="submit" style="width: 100px; padding: 11px;">
                                                            Activate
                                                        </button>
                                                    </form>
                                                <?php else: ?>
                                                    <form
                                                        action="<?php echo e(route('manager.deactivate-training-program', $training_program->id)); ?>"
                                                        method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <button class="btn btn-danger rounded-full btn-hover" type="submit"
                                                            style="width: 100px; padding: 11px;">
                                                            Deactivate
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No Training Programs Found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <?php if($training_programs->hasPages()): ?>
                            <br>
                        <?php endif; ?>
                        <?php echo e($training_programs->links('pagination::bootstrap-5')); ?>

                    </div>
                </div>
            </section>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.managerLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/manager/training_programs.blade.php ENDPATH**/ ?>