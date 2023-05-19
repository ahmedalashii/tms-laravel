

<?php $__env->startSection('MainContent'); ?>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">Emails</h1>
            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-user me-1"></i>
                        Emails
                    </div>
                    <div class="d-grid gap-0 d-md-flex justify-content-md-end">
                        <!-- <button type="button" class="btn btn-success ">Send Email</button>     -->
                        <a href="./sendEmail.html"> <button class="btn btn-success me-3 mt-2" type="button">Send
                                Email</button> </a>
                        <!-- <button class="btn btn-primary" type="button">Button</button> -->
                    </div>

                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Name</th>
                                    <th>Email address</th>
                                    <th>Message</th>
                                    <th>Reply</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <img src="https://randomuser.me/api/portraits/men/60.jpg"
                                            class="rounded-circle me-1" width="40px" alt="Jane Doe's avatar" />
                                        John Doe
                                    </td>
                                    <td>johndoe@example.com</td>
                                    <td>Lorem ipsum dolor sit amet consectetur ...</td>
                                    <td><a href="./reply.html"><button type="button"
                                                class="btn btn-success">Reply</button></a></td>
                                    <td><button type="button" class="btn btn-danger">Delete</button></td>
                                </tr>

                                <tr>
                                    <td>
                                        <img src="https://randomuser.me/api/portraits/men/60.jpg"
                                            class="rounded-circle me-1" width="40px" alt="Jane Doe's avatar" />
                                        John Doe
                                    </td>
                                    <td>johndoe@example.com</td>
                                    <td>Lorem ipsum dolor sit amet consectetur ...</td>
                                    <td><a href="./reply.html"><button type="button"
                                                class="btn btn-success">Reply</button></a></td>
                                    <td><button type="button" class="btn btn-danger">Delete</button></td>
                                </tr>

                                <tr>
                                    <td>
                                        <img src="https://randomuser.me/api/portraits/men/60.jpg"
                                            class="rounded-circle me-1" width="40px" alt="Jane Doe's avatar" />
                                        John Doe
                                    </td>
                                    <td>johndoe@example.com</td>
                                    <td>Lorem ipsum dolor sit amet consectetur ...</td>
                                    <td><a href="./reply.html"><button type="button"
                                                class="btn btn-success">Reply</button></a></td>
                                    <td><button type="button" class="btn btn-danger">Delete</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.advisorLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/advisor/notifications_and_emails.blade.php ENDPATH**/ ?>