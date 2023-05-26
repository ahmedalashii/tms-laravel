<?php $__env->startSection('MainContent'); ?>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">Training Request Review</h1>
            <section class="card mb-4 mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-bell me-1"></i>
                        Criteria</span>
                    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample"
                        aria-expanded="false" aria-controls="collapseExample">
                        <i class="fas fa-solid fa-pen-to-square"></i>
                    </button>
                </div>
                <div class="card-body">
                    <p>The following criteria are used to review training requests:</p>
                    <ul>
                        <li>Trainee's academic background</li>
                        <li>Trainee's work experience</li>
                        <li>Trainee's financial need</li>
                        <li>The availability of training programs</li>
                    </ul>
                    <div>
                        <form class="collapse" id="collapseExample">
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
                                <label for="floatingTextarea2">New criteria each line is a criteria new
                                    point</label>
                            </div>
                            <button class="btn btn-success w-100 mt-2" type="submit">Update criteria</button>
                        </form>
                    </div>
                </div>
            </section>

            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Trainee Name</th>
                        <th>Trainee Email Address</th>
                        <th>Training Program Requested</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>John Doe</td>
                        <td>john.doe@example.com</td>
                        <td>Data Structures</td>
                        <td>May 17th</td>
                        <td>May 24th</td>
                        <td>
                            <a href="#" class="btn btn-success">Approve</a> | <a href="#"
                                class="btn btn-danger">Reject</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Jane Doe</td>
                        <td>jane.doe@example.com</td>
                        <td>Algorithms</td>
                        <td>May 25th</td>
                        <td>June 1st</td>
                        <td>
                            <a href="#" class="btn btn-success">Approve</a> | <a href="#"
                                class="btn btn-danger">Reject</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Jane Doe</td>
                        <td>jane.doe@example.com</td>
                        <td>Algorithms</td>
                        <td>May 25th</td>
                        <td>June 1st</td>
                        <td>
                            <a href="#" class="btn btn-success">Approve</a> | <a href="#"
                                class="btn btn-danger">Reject</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Jane Doe</td>
                        <td>jane.doe@example.com</td>
                        <td>Algorithms</td>
                        <td>May 25th</td>
                        <td>June 1st</td>
                        <td>
                            <a href="#" class="btn btn-success">Approve</a> | <a href="#"
                                class="btn btn-danger">Reject</a>
                        </td>
                </tbody>
            </table>

        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.advisorLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/advisor/trainees_requests.blade.php ENDPATH**/ ?>