@extends('layouts.traineeLayout')

@section('MainContent')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Task Submission</h1>

            <form action="{{ route('trainee.upload') }}" method="POST" enctype="multipart/form-data" class="mt-3">
                @csrf
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-upload me-1"></i>
                        Submit a task
                    </div>
                    <div class="card-body">
                        @if ($training_programs->isNotEmpty())
                            <div class="mb-3">
                                <label for="training_program" class="form-label">Which training program is this file
                                    related to? <span class="text-danger">*</span></label>
                                <select class="form-select mb-3" aria-label=".form-select-lg example" id="training_program"
                                    name="training_program_id" required>
                                    @foreach ($training_programs as $training_program)
                                        <option value="{{ $training_program->id }}"
                                            @if ($task && $task->trainingProgram->id == $training_program->id) selected @endif>
                                            {{ $training_program->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="task" class="form-label">Choose the task that this file is
                                    related to <span class="text-danger">*</span></label>
                                <select class="form-select mb-3" aria-label=".form-select-lg example" id="task"
                                    name="task_id" required>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="file" class="form-label">File (Max: 10MB) <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" type="file" name="file" id="file" accept="*/*"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="description" id="description"
                                    placeholder="File Description" required />
                            </div>

                            <button type="submit" class="btn btn-success">Upload</button>
                        @else
                            <div class="alert alert-danger">
                                <strong>Warning!</strong> You can't upload any files because you haven't joined any training
                                programs yet.
                            </div>
                        @endif
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
                            @if ($files->isEmpty())
                            @else
                                @foreach ($files as $file)
                                    <li class="list-group-item">
                                        <a href="{{ $file->url }}" class="list-group-item-action" target="_blank">
                                            <div class="d-flex w-100 justify-content-between">
                                                @php
                                                    // A1T8xntf3wQgLWEm5HevpFGtNi82_trainee_avatar_image.jpg  >> Remove based on split the first index
                                                    if (strpos($file->name, 'cv') !== false || strpos($file->name, 'avatar') !== false) {
                                                        $file_name = explode('_', $file->name);
                                                        // remove $file_name[0] from $file_name
                                                        $file_name = array_splice($file_name, 1);
                                                        // Convert array to string and capitalize the first letters
                                                        $file_name = implode('_', $file_name);
                                                    } else {
                                                        $file_name = $file->name;
                                                    }
                                                @endphp
                                                <h5 class="mb-1">{{ $file_name }}</h5>
                                                @php
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
                                                @endphp
                                                <small class="text-muted"> {{ $size }}</small>
                                            </div>
                                            <small
                                                class="text-muted">{{ Carbon\Carbon::parse($file->created_at)->diffForHumans() }}</small>
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                        {{-- if there's pagination  >> do sth --}}
                        @if ($files->hasPages())
                            <br>
                        @endif
                        {{ $files->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </section>
        </div>
    </main>
    <script>
        var training_programs = @json($training_programs);
        window.onload = function() {
            var training_program = document.getElementById('training_program');
            var task_element = document.getElementById('task');




            if (training_programs.length > 0) {
                var selected_training_program = training_program.value;
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
                    var task = @json($task);
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
                var task = @json($task);
                if (task && task.training_program_id == selected_training_program) {
                    task_element.value = task.id;
                }
            });
        }
    </script>
@endsection
