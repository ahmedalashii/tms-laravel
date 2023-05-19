

<?php $__env->startSection('MainContent'); ?>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4"><span class="text-success">Trainee Name</span></h1>
            <div class="row">
                <div class="d-flex align-items-center justify-content-center mb-3">
                    <img src="https://randomuser.me/api/portraits/men/60.jpg" class="rounded-circle shadow-lg" width="150px"
                        alt="Jane Doe's avatar" />
                </div>
            </div>
            <form action="" class="mt-2 mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="avatar">Change Avatar</label>
                            <input type="file" class="form-control" id="avatar">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="gender">Gender</label>
                            <select class="form-control" id="gender">
                                <option selected disabled>Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" id="email">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="phone">Phone number</label>
                            <input type="text" class="form-control" id="phone">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="cv">CV</label>
                            <input type="file" class="form-control" id="cv">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="h-100 d-flex align-items-end pb-2 justify-content-end">
                            <button type="button" class="btn btn-success pe-4 ps-4">Save</button>
                            <button type="button" class="btn btn-danger ms-2">Delete</button>
                            <button type="button" class="btn btn-danger ms-2">Disable</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.managerLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/manager/edit_trainee.blade.php ENDPATH**/ ?>