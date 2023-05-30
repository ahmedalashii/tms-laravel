<?php $__env->startSection('MainContent'); ?>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Upload</h1>

            <form action="<?php echo e(route('trainee.upload')); ?>" method="POST" enctype="multipart/form-data" class="mt-3">
                <?php echo csrf_field(); ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-upload me-1"></i>
                        Upload New File
                    </div>
                    <div class="card-body">
                        <?php if($training_programs->isNotEmpty()): ?>
                            <div class="mb-3">
                                <label for="file" class="form-label">File (Max: 10MB)</label>
                                <input class="form-control" type="file" name="file" id="file" accept="*/*"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="training_program" class="form-label">Which training program is this file
                                    related to?</label>
                                <select class="form-select mb-3" aria-label=".form-select-lg example" id="training_program"
                                    name="training_program_id" required>
                                    <?php $__currentLoopData = $training_programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $training_program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($training_program->id); ?>"
                                            <?php if($task && $task->trainingProgram->id == $training_program->id): ?> selected <?php endif; ?>>
                                            <?php echo e($training_program->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="task" class="form-label">Choose the task that this file is
                                    related to</label>
                                <select class="form-select mb-3" aria-label=".form-select-lg example" id="task"
                                    name="task_id" required>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">File Description</label>
                                <input class="form-control" type="text" name="description" id="description"
                                    placeholder="File Description" required>
                            </div>
                            <button type="submit" class="btn btn-success">Upload</button>
                        <?php else: ?>
                            <div class="alert alert-danger">
                                <strong>Warning!</strong> You can't upload any files because you haven't joined any training
                                programs yet.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </form>

            <section>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-history me-1"></i>
                        Previous uploaded files
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <?php if($files->isEmpty()): ?>
                            <?php else: ?>
                                <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="list-group-item">
                                        <a href="<?php echo e($file->url); ?>" class="list-group-item-action" target="_blank">
                                            <div class="d-flex w-100 justify-content-between">
                                                
                                                <?php
                                                    $file_name = explode('_', $file->name);
                                                    // remove $file_name[0] from $file_name
                                                    $file_name = array_splice($file_name, 1);
                                                    // Convert array to string and capitalize the first letters
                                                    $file_name = implode('_', $file_name);
                                                ?>
                                                <h5 class="mb-1"><?php echo e($file_name); ?></h5>
                                                <?php
                                                    $sz = 'BKMGTP';
                                                    $decimals = 2;
                                                    $filesize = $file->size;
                                                    $factor = floor((strlen($filesize) - 1) / 3);
                                                    $size = sprintf("%.{$decimals}f", $filesize / pow(1024, $factor)) . @$sz[$factor] . 'B';
                                                    // if the $size has two BB
                                                    if (substr_count($size, 'B') > 1) {
                                                        // remove the last B
                                                        $size = substr($size, 0, -1);
                                                    }
                                                ?>
                                                <small class="text-muted"> <?php echo e($size); ?></small>
                                            </div>
                                            <small
                                                class="text-muted"><?php echo e(Carbon\Carbon::parse($file->created_at)->diffForHumans()); ?></small>
                                        </a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </ul>
                        
                        <?php if($files->hasPages()): ?>
                            <br>
                        <?php endif; ?>
                        <?php echo e($files->links('pagination::bootstrap-5')); ?>

                    </div>
                </div>
            </section>
        </div>
    </main>
    <script>
        var training_programs = <?php echo json_encode($training_programs, 15, 512) ?>;
        window.onload = function() {
            var training_program = document.getElementById('training_program');
            var task_element = document.getElementById('task');

            if (training_programs.length > 0) {
                var selected_training_program = training_program.value;
                console.log("selected_training_program: " + selected_training_program);
                var tasks = training_programs.find(training_program => training_program.id ==
                    selected_training_program).tasks;
                if (tasks.length) {
                    // add select task option
                    var option = document.createElement('option');
                    option.value = '';
                    option.text = 'Select a task';
                    task_element.appendChild(option);
                    tasks.forEach(task => {
                        var option = document.createElement('option');
                        option.value = task.id;
                        option.text = task.name;
                        task_element.appendChild(option);
                    });
                    // if there's a task selected
                    var task = <?php echo json_encode($task, 15, 512) ?>;
                    if (task && task.training_program_id == selected_training_program) {
                        task_element.value = task.id;
                    }
                } else {
                    // add select task option
                    var option = document.createElement('option');
                    option.value = '';
                    option.text = 'Select a task';
                    task_element.appendChild(option);
                }
            }
            training_program.addEventListener('change', function() {
                var selected_training_program = training_program.value;
                var tasks = training_programs.find(training_program => training_program.id ==
                    selected_training_program).tasks;
                task_element.innerHTML = '';
                // add select task option
                var option = document.createElement('option');
                option.value = '';
                option.text = 'Select a task';
                task_element.appendChild(option);
                tasks.forEach(task => {
                    var option = document.createElement('option');
                    option.value = task.id;
                    option.text = task.name;
                    task_element.appendChild(option);
                });
                var task = <?php echo json_encode($task, 15, 512) ?>;
                if (task && task.training_program_id == selected_training_program) {
                    task_element.value = task.id;
                }
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.traineeLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/trainee/upload.blade.php ENDPATH**/ ?>