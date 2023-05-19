

<?php $__env->startSection('MainContent'); ?>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">Issues</h1>

            <!-- section template -->
            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-warning me-1"></i>
                        issues
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Sender</th>
                                    <th>Title</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Response</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <img src="https://randomuser.me/api/portraits/men/60.jpg" class="rounded-circle me-1"
                                            width="40px" alt="Jane Doe's avatar" />
                                        John Doe
                                    </td>
                                    <td>Bug 1</td>
                                    <td>Bug</td>
                                    <td>This is a bug that needs to be fixed.</td>
                                    <td>
                                        <a href="<?php echo e(route('manager.issue-response', 1)); ?>" class="btn btn-success">Respond</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="https://randomuser.me/api/portraits/men/60.jpg"
                                            class="rounded-circle me-1" width="40px" alt="Jane Doe's avatar" />
                                        John Doe
                                    </td>
                                    <td>Enhancement 1</td>
                                    <td>Enhancement</td>
                                    <td>This is an enhancement that would be nice to have.</td>
                                    <td>
                                        <a href="<?php echo e(route('manager.issue-response', 1)); ?>" class="btn btn-success">Respond</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="https://randomuser.me/api/portraits/men/60.jpg"
                                            class="rounded-circle me-1" width="40px" alt="Jane Doe's avatar" />
                                        John Doe
                                    </td>
                                    <td>Task 1</td>
                                    <td>Task</td>
                                    <td>This is a task that needs to be completed.</td>
                                    <td>
                                        <a href="<?php echo e(route('manager.issue-response', 1)); ?>" class="btn btn-success">Respond</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="https://randomuser.me/api/portraits/men/60.jpg"
                                            class="rounded-circle me-1" width="40px" alt="Jane Doe's avatar" />
                                        John Doe
                                    </td>
                                    <td>Bug 1</td>
                                    <td>Bug</td>
                                    <td>This is a bug that needs to be fixed.</td>
                                    <td>
                                        <a href="<?php echo e(route('manager.issue-response', 1)); ?>" class="btn btn-success">Respond</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="https://randomuser.me/api/portraits/men/60.jpg"
                                            class="rounded-circle me-1" width="40px" alt="Jane Doe's avatar" />
                                        John Doe
                                    </td>
                                    <td>Enhancement 1</td>
                                    <td>Enhancement</td>
                                    <td>This is an enhancement that would be nice to have.</td>
                                    <td>
                                        <a href="<?php echo e(route('manager.issue-response', 1)); ?>" class="btn btn-success">Respond</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="https://randomuser.me/api/portraits/men/60.jpg"
                                            class="rounded-circle me-1" width="40px" alt="Jane Doe's avatar" />
                                        John Doe
                                    </td>
                                    <td>Task 1</td>
                                    <td>Task</td>
                                    <td>This is a task that needs to be completed.</td>
                                    <td>
                                        <a href="<?php echo e(route('manager.issue-response', 1)); ?>" class="btn btn-success">Respond</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="https://randomuser.me/api/portraits/men/60.jpg"
                                            class="rounded-circle me-1" width="40px" alt="Jane Doe's avatar" />
                                        John Doe
                                    </td>
                                    <td>Bug 1</td>
                                    <td>Bug</td>
                                    <td>This is a bug that needs to be fixed.</td>
                                    <td>
                                        <a href="<?php echo e(route('manager.issue-response', 1)); ?>" class="btn btn-success">Respond</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="https://randomuser.me/api/portraits/men/60.jpg"
                                            class="rounded-circle me-1" width="40px" alt="Jane Doe's avatar" />
                                        John Doe
                                    </td>
                                    <td>Enhancement 1</td>
                                    <td>Enhancement</td>
                                    <td>This is an enhancement that would be nice to have.</td>
                                    <td>
                                        <a href="<?php echo e(route('manager.issue-response', 1)); ?>" class="btn btn-success">Respond</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.managerLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/manager/issues.blade.php ENDPATH**/ ?>