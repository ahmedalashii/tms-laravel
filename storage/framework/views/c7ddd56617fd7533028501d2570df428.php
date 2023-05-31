

<?php $__env->startSection('MainContent'); ?>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">Tasks</h1>
            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-user me-1"></i>
                        Tasks Information
                    </div>
                    <div class="card-body">
                        <form method="GET" action="<?php echo e(route('advisor.tasks')); ?>">
                            <div class="row">
                                <div class="col-md-10">
                                    <label for="discipline">Filter based on training program</label>
                                    <div class="row">
                                        <div class="col-md-10">
                                            <select class="form-select mb-3" aria-label=".form-select-lg example"
                                                id="discipline" name="training_program">
                                                <option selected value="">Select Training Program</option>
                                                <?php $__currentLoopData = $training_programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $training_program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($training_program->id); ?>"
                                                        <?php if(request()->get('training_program') == $training_program->id): ?> selected <?php endif; ?>>
                                                        <?php echo e($training_program->name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-success" style="width: 100%;">Filter</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-end align-items-end pb-3">
                                    <a class="btn btn-success" href="<?php echo e(route('advisor.create-task')); ?>" role="button"
                                        style="width: 100%;">Create Task</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <input type="search" class="form-control" placeholder="Search for tasks"
                                        aria-label="Search" name="search" value="<?php echo e(request()->query('search')); ?>">
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-dark" type="submit" style="width: 100%;">
                                        Search
                                </div>
                            </div>
                            <br>
                        </form>

                        <table class="table table-striped table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Training Program</th>
                                    <th>Creation Date</th>
                                    <th>End Date</th>
                                    <th>Edit</th>
                                    <th>Activate/Deactivate</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($tasks->isNotEmpty()): ?>
                                    <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($task->name); ?></td>
                                            <td><?php echo e($task->description); ?></td>
                                            <td><?php echo e($task->trainingProgram->name); ?></td>
                                            <td><?php echo e(Carbon\Carbon::parse($task->created_at)->format('d/m/Y')); ?></td>
                                            <td><?php echo e($task->end_date); ?></td>
                                            <td>
                                                <?php if($task->trashed()): ?>
                                                    <button class="btn btn-secondary rounded-full btn-hover"
                                                        style="width: 100px; padding: 11px; cursor: not-allowed !important;"
                                                        disabled>
                                                        Edit
                                                    </button>
                                                <?php else: ?>
                                                    <form action="<?php echo e(route('advisor.edit-task', $task->id)); ?>"
                                                        method="GET">
                                                        <button class="btn btn-success btn-sm" type="submit"
                                                            style="width: 100px; padding: 11px;">
                                                            Edit
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($task->trashed()): ?>
                                                    <form action="<?php echo e(route('advisor.activate-task', $task->id)); ?>"
                                                        method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <button class="btn btn-success rounded-full btn-hover"
                                                            type="submit" style="width: 100px; padding: 11px;">
                                                            Activate
                                                        </button>
                                                    </form>
                                                <?php else: ?>
                                                    <form action="<?php echo e(route('advisor.deactivate-task', $task->id)); ?>"
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
                                        <td colspan="12" class="text-center">No Tasks Found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <?php if($tasks->hasPages()): ?>
                            <br>
                        <?php endif; ?>
                        <?php echo e($tasks->links('pagination::bootstrap-5')); ?>

                    </div>
                </div>
            </section>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.advisorLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/advisor/tasks.blade.php ENDPATH**/ ?>