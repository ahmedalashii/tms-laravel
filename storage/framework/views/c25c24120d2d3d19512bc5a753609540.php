

<?php $__env->startSection('MainContent'); ?>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">Apply for Training</h1>

            <form action="./apply-for-training" method="post" enctype="multipart/form-data">
                <!-- Training Programs -->
                <div class="mb-3">
                    <h5 class="form-label fs-5">Training Programs</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mt-2">
                                <img class="card-img-top" src="https://placehold.it/300x150" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">Google IT Support Professional Certificate</h5>
                                    <p class="card-text">This program will teach you the skills you need to
                                        become an IT support professional.</p>
                                    <input type="checkbox" name="training-programs[]" value="program1">
                                    <label for="program1">Select the program</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mt-2">
                                <img class="card-img-top" src="https://placehold.it/300x150" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">AWS Certified Cloud Practitioner</h5>
                                    <p class="card-text">This program will teach you the basics of cloud
                                        computing and how to use AWS services.</p>
                                    <input type="checkbox" name="training-programs[]" value="program2">
                                    <label for="program2">Select the program</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mt-2">
                                <img class="card-img-top" src="https://placehold.it/300x150" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">Udacity Full-Stack Web Developer Nanodegree</h5>
                                    <p class="card-text">This program will teach you how to build web
                                        applications from scratch.</p>
                                    <input type="checkbox" name="training-programs[]" value="program3">
                                    <label for="program3">Select the program</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cover Letter -->
                <div class="form-floating mb-3">
                    <textarea class="form-control" placeholder="Write a cover letter" id="floatingTextarea2" style="height: 100px"></textarea>
                    <label for="floatingTextarea2">Cover Letter</label>
                </div>

                <!-- Resume -->
                <div class="mb-3">
                    <label for="resume" class="form-label">Resume</label>
                    <input class="form-control" type="file" name="resume" id="resume">
                </div>

                <button type="submit" class="btn btn-success">Submit</button>

            </form>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.traineeLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/trainee/apply_for_training.blade.php ENDPATH**/ ?>