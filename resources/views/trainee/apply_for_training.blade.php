@extends('layouts.traineeLayout')

@section('MainContent')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">Apply for Training</h1>

            <form action="./apply-for-training" method="post" enctype="multipart/form-data">
                <!-- Training Programs -->
                <div class="mb-3">
                    <h5 class="form-label fs-5">Training Programs</h5>
                    <div class="row">
                        @foreach ($training_programs as $training_program)
                            <div class="col-md-4">
                                <div class="card mt-2" style="height: 500px; overflow-y: scroll;">
                                    <img class="card-img-top"
                                        src="{{ $training_program->thumbnail ?? 'https://www.contentviewspro.com/wp-content/uploads/2017/07/default_image.png' }}"
                                        alt="{{ $training_program->name }}'s image">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $training_program->name }}</h5>
                                        <p class="card-text">{{ $training_program->description }}</p>
                                        <p class="card-text"><strong>Start Date: </strong>
                                            {{ $training_program->start_date }}
                                        </p>
                                        <p class="card-text"><strong>End Date: </strong> {{ $training_program->end_date }}
                                        </p>
                                        <p class="card-text"><strong>Duration: </strong> {{ $training_program->duration }}
                                            {{ $training_program->duration_unit }}
                                        </p>
                                        <p class="card-text"><strong>Location: </strong> {{ $training_program->location }}
                                        </p>
                                        <p class="card-text"><strong>Capacity: </strong>
                                            {{ $training_program->users_length }} /
                                            {{ $training_program->capacity }} trainees registered for this program so far.
                                        </p>
                                        {{-- discipline --}}
                                        <p class="card-text"><strong>Discipline: </strong>
                                            {{ $training_program->discipline->name }}
                                            <input type="checkbox" name="training-programs[]" value="program1">
                                            <label for="program1">Select the program</label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @if ($training_programs->hasPages())
                            <br>
                        @endif
                        {{ $training_programs->links('pagination::bootstrap-5') }}
                    </div>
                </div>

                <!-- Cover Letter -->
                <div class="form-floating mb-3">
                    <textarea class="form-control" placeholder="Write a cover letter" id="floatingTextarea2" style="height: 100px"></textarea>
                    <label for="floatingTextarea2">Cover Letter <b class="text-danger">*</b></label>
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
@endsection
