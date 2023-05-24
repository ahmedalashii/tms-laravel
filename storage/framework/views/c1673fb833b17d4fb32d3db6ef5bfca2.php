<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>TrainMaster - Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="<?php echo e(asset('css/styles.css')); ?>" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <?php
        $manager = Auth::guard('manager')->user();
        $manager_db = \App\Models\Manager::where('firebase_uid', $manager->localId)->first();
    ?>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="<?php echo e(route('manager')); ?>">TrainMaster</a>
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
                        <a class="dropdown-item nav-link text-dark" href="<?php echo e(route('manager.logout')); ?>"
                            onclick="event.preventDefault(); document.getElementById('form').submit()">Logout</a>
                        <form method="POST" action="<?php echo e(route('manager.logout')); ?>" id="form">
                            <?php echo csrf_field(); ?>
                        </form>
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
                        <a class="nav-link" href="<?php echo e(route('manager')); ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt text-success"></i></div>
                            Dashboard
                        </a>
                        <hr class="sidebar-divider">
                        <a class="nav-link" href="<?php echo e(route('manager.training-requests')); ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-school text-success"></i></div>
                            Training Requests
                        </a>
                        

                        <a class="nav-link" href="<?php echo e(route('manager.disciplines')); ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-book text-success"></i></div>
                            Disciplines
                        </a>

                        <a class="nav-link" href="<?php echo e(route('manager.create-discipline')); ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-book text-success"></i></div>
                            Add New Discipline
                        </a>
                        

                        <a class="nav-link" href="<?php echo e(route('manager.training-programs')); ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-book text-success"></i></div>
                            Training Programs
                        </a>

                        <a class="nav-link" href="<?php echo e(route('manager.create-training-program')); ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-book text-success"></i></div>
                            Add New Training Program
                        </a>

                        <a class="nav-link" href="<?php echo e(route('manager.authorize-trainees')); ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-user-plus text-success"></i></div>
                            Authorize trainees
                        </a>
                        <a class="nav-link" href="<?php echo e(route('manager.trainees')); ?>">
                            <div class="sb-nav-link-icon"><i class="far fa-solid fa-user text-success"></i></div>
                            Trainees
                        </a>
                        <a class="nav-link" href="<?php echo e(route('manager.authorize-advisors')); ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-user-plus text-success"></i></div>
                            Authorize advisors
                        </a>
                        <a class="nav-link" href="<?php echo e(route('manager.advisors')); ?>">
                            <div class="sb-nav-link-icon"><i class="far fa-solid fa-user text-success"></i></div>
                            Advisors
                        </a>
                        

                        <?php if($manager_db?->role == 'super_manager'): ?>
                            <hr class="sidebar-divider">
                            <a class="nav-link" href="<?php echo e(route('manager.managers')); ?>">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-tie text-success"></i></div>
                                Managers Authorization
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as: <span class="text-warning">
                            <?php if($manager_db?->role == 'super_manager'): ?>
                                Super Manager
                            <?php else: ?>
                                Manager
                            <?php endif; ?>
                        </span></div>
                    <?php echo e(Auth::guard('manager')->user()->displayName); ?>

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
            </footer>
        </div>
    </div>
    <?php echo $__env->make('includes.js.allJS', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>

</html>
<?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/layouts/managerLayout.blade.php ENDPATH**/ ?>