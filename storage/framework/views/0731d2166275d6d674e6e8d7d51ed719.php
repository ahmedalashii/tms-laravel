<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>TrainMaster - Advisor</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="<?php echo e(asset('css/styles.css')); ?>" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        /* notifications */
        .notifications_container {
            position: relative;
            height: 100%;
            display: flex;
            align-items: center;
        }

        .notifications_bell_btn {
            cursor: pointer;
            background-color: transparent;
            outline: none;
            border: none;
            position: relative;
        }

        .notifications_count {
            --size: 20px;
            background-color: var(--bs-danger);
            color: #FFF;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: var(--size);
            height: var(--size);

            font-size: 12px;
            padding: 4px;
            border-radius: 12px;

            position: absolute;
            inset-inline-start: 100%;
            top: 0;
            transform: translateX(calc((var(--size) * -1) /1.2)) translateY(calc((var(--size) * -1) /3));
        }

        .notifications_bell_icon {
            font-size: 24px;
        }

        .notifications {
            width: 400px;
            border-radius: 8px;

            position: absolute;
            inset-inline-end: -500px;
            /* 8px = nav padding  + 8px gap*/
            top: calc(100% + 16px);
            z-index: 999;
            transition: 0.3s all ease-in-out;

            max-height: 80dvh;
            overflow: auto;
        }

        .notifications.active {
            inset-inline-end: 0;
        }

        .notification_item:has(+.notification_item) {
            border-bottom: 1px solid #CCC;
        }

        .notification_text {
            max-height: 120px;
            overflow: hidden;
        }

        @media(max-width:720px) {
            .notifications {
                width: 350px;
            }

            .notifications.active {
                inset-inline-end: -60px;
            }
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <?php
        $advisor = auth_advisor();
        $advisor_db = \App\Models\Advisor::where('firebase_uid', $advisor->localId)->first();
    ?>

    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="<?php echo e(route('advisor')); ?>">Train Master</a>
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
                        <a class="dropdown-item nav-link text-dark" href="<?php echo e(route('advisor.logout')); ?>"
                            onclick="event.preventDefault(); document.getElementById('form').submit()">Logout</a>
                        <form method="POST" action="<?php echo e(route('advisor.logout')); ?>" id="form">
                            <?php echo csrf_field(); ?>
                        </form>
                    </li>
                    <li>
                        <a class="dropdown-item nav-link text-dark" href="<?php echo e(route('advisor.edit')); ?>">
                            Edit Profile
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="ms-auto me-3 notifications_container">
            <button class="notifications_bell_btn" id="notifications_bell">
                <span class="notifications_count d-none" id="notifications_count"></span>
                <i class="fa-solid fa-bell text-light notifications_bell_icon"></i>
            </button>
            <div class="notifications bg-dark text-light shadow-lg" id="notifications">
            </div>
        </div>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="<?php echo e(route('advisor')); ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt text-success"></i></div>
                            Dashboard
                        </a>
                        <a class="nav-link" href="<?php echo e(route('advisor.edit')); ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-edit text-success"></i></div>
                            Edit My Profile
                        </a>
                        <hr class="sidebar-divider">
                        <a class="nav-link" href="<?php echo e(route('advisor.trainees-list')); ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-users text-success"></i></div>
                            My Trainees
                        </a>
                        <a class="nav-link" href="<?php echo e(route('advisor.assigned-training-programs')); ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-users text-success"></i></div>
                            My Assigned Training Programs
                        </a>

                        <a class="nav-link" href="<?php echo e(route('advisor.tasks')); ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-book text-success"></i></div>
                            Training Program Tasks
                        </a>

                        <a class="nav-link" href="<?php echo e(route('advisor.create-task')); ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-book text-success"></i></div>
                            Add New Task
                        </a>

                        <a class="nav-link" href="<?php echo e(route('advisor.send-email-form')); ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-users text-success"></i></div>
                            Send a new email
                        </a>
                        <a class="nav-link" href="<?php echo e(route('advisor.received-emails')); ?>">
                            <div class="sb-nav-link-icon"><i class="far fa-solid fa-user text-success"></i></div>
                            Received Emails
                        </a>
                        <a class="nav-link" href="<?php echo e(route('advisor.sent-emails')); ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-users text-success"></i></div>
                            Sent Emails
                        </a>
                        <a class="nav-link" href="<?php echo e(route('advisor.meetings-schedule')); ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-video text-success"></i></div>
                            Meetings Schedule
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as: <span class="text-warning">Advisor</span></div>
                    <?php echo e(auth_advisor()->displayName); ?>

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
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        $(document).ready(function() {
            // toggle notifications
            const notifications_bell = document.getElementById("notifications_bell");
            const notifications = document.getElementById("notifications");
            const notifications_count = document.getElementById("notifications_count");
            let notifications_list = [];
            let unreadNotifications = <?php echo json_encode(auth_advisor()->notifications, 15, 512) ?>.filter(el => el.read_at == null);
            <?php echo json_encode(auth_advisor()->notifications, 15, 512) ?>.map(el => notifications_list.push(el.data.message));

            let closeTimeOutId = null;

            const updateNotificationsCount = (count) => {
                console.log({
                    count
                })
                if (count > 0) {
                    notifications_count.innerText = count > 99 ? "+99" : count;
                    notifications_count.classList.remove("d-none")
                } else {
                    console.log("NO NOTIFICATIONS")
                    notifications_count.classList.add("d-none")
                }
            }

            const appendNotification = (notification_text, notifications_list, notifications,
                unreadNotifications, is_first = false) => {
                // don't update the notifications count if the notification is already read
                updateNotificationsCount(unreadNotifications.length);

                const notificationItem = document.createElement("div");
                notificationItem.classList = "notification_item p-3 pt-2 pb-0";

                const notificationText = document.createElement("p")
                notificationText.classList = "notification_text"
                notificationText.innerText = notification_text;

                notificationItem.appendChild(notificationText);
                if (is_first == false) {
                    notifications.appendChild(notificationItem);
                } else {
                    notifications.prepend(notificationItem);
                }
            }

            if (notifications_bell && notifications && notifications_count) {
                // show initial data
                notifications_list.map(el => appendNotification(el, notifications_list, notifications,
                    unreadNotifications));

                notifications_bell.addEventListener('click', (e) => {
                    // make all notifications of advisor as read when the bell is clicked
                    axios.post("<?php echo e(route('advisor.notifications.read')); ?>").then(res => {
                        console.log(res.data)
                    }).catch(err => {
                        console.log(err.response.data)
                    })
                    notifications.classList.toggle('active');
                    if (closeTimeOutId) {
                        clearTimeout(closeTimeOutId);
                        closeTimeOutId = null;
                    }
                    // update notifications count to 0
                    updateNotificationsCount(0);
                    closeTimeOutId = setTimeout(() => {
                        notifications.classList.remove('active');
                        closeTimeOutId = null;
                    }, 10000)
                })
            }


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
            var authId = <?php echo e(auth_advisor()->id); ?>;
            // get the channel
            var channel = pusher.subscribe('private-App.Models.Advisor.' + authId);
            // bind the event
            channel.bind("Illuminate\\Notifications\\Events\\BroadcastNotificationCreated", function(data) {
                var data = JSON.stringify(data);
                var message = JSON.parse(data).message;
                // append the message to the notifications list at the beginning
                notifications_list.unshift(message);
                unreadNotifications.unshift(message);
                appendNotification(message, notifications_list, notifications, unreadNotifications, true);
                Swal.fire({
                    title: message,
                    toast: true,
                    width: 450,
                    showConfirmButton: false,
                    position: "bottom-end",
                    icon: "info",
                });
            });
        });
    </script>
</body>

</html>
<?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/layouts/advisorLayout.blade.php ENDPATH**/ ?>