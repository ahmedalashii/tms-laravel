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
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4"><span class="text-success"><?php echo e($trainingProgram->name); ?></span></h1>
            <form action="" class="mt-2 mb-4">
                <?php echo csrf_field(); ?>
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
                    <input type="email" class="form-control" id="description" value="<?php echo e($trainingProgram->description); ?>"
                        name="description" required>
                </div>

                <div class="form-group mb-2">
                    <label for="duration">Duration <b style="color: #d50100">*</b></label>
                    <input type="text" class="form-control" id="duration" value="<?php echo e($trainingProgram->duration); ?>"
                        name="duration" required>
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

                <div class="form-group mt-3 mb-2">
                    <label for="gender">Discipline</label>
                    <select class="form-select mb-3" aria-label=".form-select-lg example">
                        <option value="Web Development">Web Development</option>
                        <option value="Mobile Development">Mobile Development</option>
                        <option value="Software Development">Software Development</option>
                        <option value="Database Administration">Database Administration</option>
                        <option value="Data Science">Data Science</option>
                        <option value="Artificial Intelligence">Artificial Intelligence</option>
                        <option value="Machine Learning">Machine Learning</option>
                        <option value="Cyber Security">Cyber Security</option>
                        <option value="Cloud Computing">Cloud Computing</option>
                        <option value="Network Administration">Network Administration</option>
                        <option value="Game Development">Game Development</option>
                        <option value="DevOps">DevOps</option>
                    </select>
                </div>

                <div class="h-100 d-flex align-items-end pb-2 justify-content-end">
                    <button type="button" class="btn btn-success pe-4 ps-4">Save</button>
                    <a href="training_programs.html" class="btn btn-danger ms-2">Cancel</a>
                    <button type="button" class="btn btn-danger ms-2">Delete</button>
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