<?php $__env->startSection('MainContent'); ?>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">We're excited to have you on board, <span
                    class="text-success"><?php echo e(Auth::guard('advisor')->user()->displayName); ?> 😎</span></h1>
            <div class="container">
                <canvas id="appStatisticsChart" width="100%" height="30%"></canvas>
            </div>
            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-clock me-1"></i>
                        Recently Enrolled Trainees
                    </div>
                    <div class="card-body">
                        <?php if($recent_enrollments->isNotEmpty()): ?>
                            <ul class="list-unstyled">
                                <?php $__currentLoopData = $recent_enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recent_enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <h5 class="mb-0"> <img
                                                    src="<?php echo e($recent_enrollment->trainee->avatar ?? 'https://www.contentviewspro.com/wp-content/uploads/2017/07/default_image.png'); ?>"
                                                    alt="trainee" class="rounded-circle" width="40px" height="40px">
                                                <?php echo e($recent_enrollment->trainee->displayName); ?></h5>
                                            <small><?php echo e($recent_enrollment->trainee->email); ?></small>
                                            <small class="text-muted">Enrolled on
                                                <?php echo e($recent_enrollment->created_at->format('d M Y')); ?></small> |
                                            <small class="text-muted">Training Program:
                                                <?php echo e($recent_enrollment->trainingProgram->name); ?></small>
                                        </div>
                                        <a href="<?php echo e(route('advisor.trainee-details', $recent_enrollment->trainee->id)); ?>"
                                            class="btn btn-sm btn-success">View Details</a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php else: ?>
                            <p class="bg-secondary text-white p-2">There are no recently enrolled trainees. Once a trainee
                                enrolls, they will appear here.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </section>

            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Trainees List</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="<?php echo e(route('advisor.trainees-list')); ?>">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Assigned Tranining Programs</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link"
                                href="<?php echo e(route('advisor.assigned-training-programs')); ?>">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Training Program Tasks</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="<?php echo e(route('advisor.tasks')); ?>">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Add New Task</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="<?php echo e(route('advisor.create-task')); ?>">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Send a new Email</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="<?php echo e(route('advisor.send-email-form')); ?>">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Received Emails</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="<?php echo e(route('advisor.received-emails')); ?>">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Sent Emails</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="<?php echo e(route('advisor.sent-emails')); ?>">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Meetings Scheduling</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="<?php echo e(route('advisor.meetings-schedule')); ?>">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-B1XS1PP0R6"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-B1XS1PP0R6');
    </script>
    <script>
        var appStatisticsCtx = document.getElementById('appStatisticsChart').getContext('2d');
        var appStatisticsChart = new Chart(appStatisticsCtx, {
            type: 'bar',
            data: {
                //               $my_trainees_count = auth_advisor()->trainees()->count();
                // $my_assigned_training_programs_count = auth_advisor()->assigned_training_programs()->count();
                // $my_tasks_count = auth_advisor()->assigned_training_programs()->withCount('tasks')->get()->sum('tasks_count');

                labels: [
                    'Trainees',
                    'Assigned Training Programs',
                    'Tasks',
                ],
                datasets: [{
                    label: 'Training Staff',
                    data: [
                        <?php echo e($my_trainees_count); ?>,
                        <?php echo e($my_assigned_training_programs_count); ?>,
                        <?php echo e($my_tasks_count); ?>

                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }, ],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.advisorLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/advisor/index.blade.php ENDPATH**/ ?>