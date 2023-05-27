<style>
    /* banner input */
    .banner_input {
        min-width: 350px;
        max-width: 500px;
        width: 30%;
        height: 200px;
        border-radius: 4px;
        background-color: #CCC;
        position: relative;
    }

    #banner_input-image,
    .banner_input-label {
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 4px;
        cursor: pointer;
    }

    #banner_input-image {
        z-index: 5;
        object-fit: cover;
    }

    .banner_input-label {
        z-index: 4;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .banner_input:has(#banner_input-image:hover) .banner_input-label,
    .banner_input-label:hover {
        z-index: 6;
        background-color: #CCC;
        opacity: 0.8;
    }

    .banner_input #banner_input-image[src=""] {
        display: none;
    }

    @media(max-width:720px) {
        .banner_input {
            max-width: unset;
            width: 100%;
        }
    }
</style>


<?php $__env->startSection('MainContent'); ?>
    <?php
        $trainingProgram = $trainingProgram->load('training_attendances');
    ?>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4"><span class="text-success"><?php echo e($trainingProgram->name); ?></span></h1>
            <div class="col-12 mt-2">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="alert alert-danger"><?php echo e($message); ?></div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <form action="<?php echo e(route('manager.update-training-program', $trainingProgram->id)); ?>" method="POST"
                enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <input type="hidden" name="users_length" value="<?php echo e($trainingProgram->users_length); ?>">

                <div class="form-group mb-2">
                    <label for="banner_input">Banner image</label>
                    <div class="banner_input shadow-sm">
                        <img id="banner_input-image" src="<?php echo e($trainingProgram->thumbnail); ?>" alt="">
                        <label for="banner_input" class="banner_input-label fs-1">+</label>
                        <input type="file" accept="image/*" class="d-none" id="banner_input" name="thumbnail">
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="name">Name <b style="color: #d50100">*</b></label>
                    <input type="text" class="form-control" id="name" value="<?php echo e($trainingProgram->name); ?>"
                        name="name" required>
                </div>

                <div class="form-group mb-2">
                    <label for="description">Description <b style="color: #d50100">*</b></label>
                    <input type="text" class="form-control" id="description" value="<?php echo e($trainingProgram->description); ?>"
                        name="description" required>
                </div>

                <div class="form-group mb-2">
                    <label for="location">Location <b style="color: #d50100">*</b></label>
                    <input type="text" class="form-control" id="description" name="location" required
                        value="<?php echo e($trainingProgram->location); ?>">
                </div>


                <div class="form-group mb-2">
                    <label for="capacity">Capacity: <b style="color: #d50100">*</b></label>
                    <input class="form-control" type="number" placeholder="Program Capacity"
                        value="<?php echo e($trainingProgram->capacity); ?>" name="capacity" id="capacity" min="5"
                        max="100" required />
                </div>

                <div class="form-group mb-2">
                    <label for="duration">Duration <b style="color: #d50100">*</b></label>
                    <input type="text" class="form-control" id="duration" value="<?php echo e($trainingProgram->duration); ?>"
                        name="duration" required>
                </div>

                <div class="form-group mb-2">
                    <label for="gender">Duration Unit: <b style="color: #d50100">*</b></label>
                    <div class="row">
                        <div class="col-md-12">
                            <select class="form-select" aria-label=".form-select-lg example" name="duration_unit" required>
                                <option selected value="">Select Duration Unit</option>
                                <?php $__currentLoopData = $duration_units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $duration_unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>" <?php if($trainingProgram->duration_unit == $key): ?> selected <?php endif; ?>>
                                        <?php echo e($duration_unit); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-2">
                    <label for="fees">Fees (Leave it blank if it is free) (In USD): </label>
                    <input class="form-control" type="number" placeholder="Program Fees" name="fees"
                        value="<?php echo e($trainingProgram->fees); ?>" id="fees" />
                </div>

                <div class="form-group mb-2">
                    <label for="start-date">Start Date <b style="color: #d50100">*</b></label>
                    <input type="date" class="form-control" id="start-date" value="<?php echo e($trainingProgram->start_date); ?>"
                        name="start_date" required>
                </div>

                <div class="form-group mb-2">
                    <label for="end-date">End Date <b style="color: #d50100">*</b></label>
                    <input type="date" class="form-control" id="end-date" value="<?php echo e($trainingProgram->end_date); ?>"
                        name="end_date" required>
                </div>

                <div class="form-group mb-2">
                    <label for="discipline">Discipline <b style="color: #d50100">*</b></label>
                    <div class="row">
                        <div class="col-md-12">
                            <select class="form-select" aria-label=".form-select-lg example" name="discipline_id"
                                id="discipline" required>
                                <option selected value="">Select Discipline</option>
                                <?php $__currentLoopData = $disciplines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $discipline): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($discipline->id); ?>"
                                        <?php if($trainingProgram->discipline_id == $discipline->id): ?> selected <?php endif; ?>>
                                        <?php echo e($discipline->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>


                <div class="form-group mb-2">
                    <label for="days">Select one or attendance days <b style="color: #d50100">*</b></label>
                    <strong class="text-danger">*</strong>
                    </label>
                    <div class="form-group">
                        <?php
                            $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                        ?>
                        <?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="form-check">
                                <input type="checkbox" name="attendance_days[]" value="<?php echo e($day); ?>"
                                    class="form-check-input" id="day-<?php echo e($day); ?>"
                                    <?php if(in_array($day, $trainingProgram->training_attendances->pluck('attendance_day')->toArray())): ?> checked <?php endif; ?>>
                                <label class="form-check-label"
                                    for="day-<?php echo e($day); ?>"><?php echo e($day); ?></label>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <div class="form-group mb-2">
                    <label for="start-time">Start Time <b style="color: #d50100">*</b></label>
                    <input type="time" class="form-control" id="start-time" name="start_time"
                        <?php if($trainingProgram->training_attendances->isNotEmpty()): ?> value="<?php echo e(date('H:i', strtotime($trainingProgram->training_attendances[0]->start_time))); ?>" <?php endif; ?>
                        required>
                </div>

                <div class="form-group mb-2">
                    <label for="end-time">End Time <b style="color: #d50100">*</b></label>
                    <input type="time" class="form-control" id="end-time" name="end_time"
                        <?php if($trainingProgram->training_attendances->isNotEmpty()): ?> value="<?php echo e(date('H:i', strtotime($trainingProgram->training_attendances[0]->end_time))); ?>" <?php endif; ?>
                        required>
                </div>

                <div class="form-group mb-2">
                    <label for="advisor">Advisor </label>
                    <div class="row">
                        <div class="col-md-12">
                            <select class="form-select mb-3" aria-label=".form-select-lg example" name="advisor_id"
                                id="advisor">
                                <option selected value="">Select Advisor</option>
                                <?php $__currentLoopData = $advisors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $advisor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($advisor->id); ?>" <?php if($trainingProgram->advisor_id == $advisor->id): ?> selected <?php endif; ?>>
                                        <?php echo e($advisor->displayName); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-end pb-2 justify-content-end">
                    <button type="submit" class="btn btn-success pe-4 ps-4">Save</button>
                    <a href="<?php echo e(route('manager.training-programs')); ?>" class="btn btn-danger ms-2">Cancel</a>
                </div>

            </form>
        </div>
    </main>
    <script>
        // change banner image
        const bannerInput = document.getElementById("banner_input");
        const bannerImage = document.getElementById("banner_input-image");
        if (bannerInput && bannerImage) {
            bannerInput.addEventListener('change', (e) => {
                const reader = new FileReader();
                reader.onload = () => {
                    const base64 = reader.result;
                    bannerImage.src = base64;
                };

                reader.readAsDataURL(bannerInput.files[0]);
            })
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.managerLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/manager/edit_training_program.blade.php ENDPATH**/ ?>