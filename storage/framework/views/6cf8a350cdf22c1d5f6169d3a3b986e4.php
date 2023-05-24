<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>TrainMaster - Trainee</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="<?php echo e(asset('css/styles.css')); ?>" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="<?php echo e(route('trainee')); ?>">TrainMaster</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>

        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li>
                        <a class="dropdown-item nav-link text-dark" href="<?php echo e(route('trainee.logout')); ?>"
                            onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                            <?php echo e(__('Logout')); ?>

                        </a>
                        <form id="logout-form" action="<?php echo e(route('trainee.logout')); ?>" method="POST" class="d-none">
                            <?php echo csrf_field(); ?>
                        </form>
                    </li>
                    <li>
                        <a class="dropdown-item nav-link text-dark" href="<?php echo e(route('trainee.edit')); ?>">
                            Edit Profile
                        </a>
                    </li>
                </ul>
            </li>

        </ul>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="<?php echo e(route('trainee')); ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt text-success"></i></div>
                            Dashboard
                        </a>
                        <a class="nav-link" href="<?php echo e(route('trainee.edit')); ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-edit text-success"></i></div>
                            Edit My Profile
                        </a>
                        <hr class="sidebar-divider">
                        <a class="nav-link" href="<?php echo e(route('trainee.upload')); ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-upload text-success"></i></div>
                            Upload
                        </a>
                        <a class="nav-link" href="<?php echo e(route('trainee.available-training-programs')); ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-graduation-cap text-success"></i></div>
                            Apply For Training Program
                        </a>
                        <a class="nav-link" href="<?php echo e(route('trainee.training-attendance')); ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-calendar-check text-success"></i></div>
                            Training Attendance
                        </a>
                        <a class="nav-link" href="<?php echo e(route('trainee.request-meeting')); ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-video text-success"></i></div>
                            Request Meeting
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as: <span class="text-warning">Trainee</span></div>
                    <?php echo e(auth_trainee()->displayName); ?>

                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <?php echo $__env->yieldContent('MainContent'); ?>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; TrainMaster |
                            <script>
                                document.write(new Date().getFullYear());
                            </script>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    </div>
    <?php echo $__env->make('includes.js.allJS', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script>
        $(document).ready(function() {
            // Enable pusher logging - don't include this in production
            Pusher.logToConsole = true;

            var pusher = new Pusher('50fd908f86ab9aec746a', {
                cluster: 'ap2',
                authEndpoint: '/broadcasting/auth',
                auth: {
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    }
                }
            });
            // get the auth user id
            var authId = <?php echo e(auth_trainee()->id); ?>;
            // get the channel
            var channel = pusher.subscribe('private-App.Models.Trainee.' + authId);
            // bind the event
            channel.bind("Illuminate\\Notifications\\Events\\BroadcastNotificationCreated", function(data) {
                var data = JSON.stringify(data);
                var message = JSON.parse(data).message;
                Swal.fire({
                    title: message,
                    toast: true,
                    showConfirmButton: false,
                    position: "top-start",
                    icon: "info",
                });
            });
        });
    </script>
</body>

</html>
<?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/layouts/traineeLayout.blade.php ENDPATH**/ ?>