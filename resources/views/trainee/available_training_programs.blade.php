@extends('layouts.traineeLayout')

@section('MainContent')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">Apply for Training Program</h1>
            <form action="./apply-for-training" method="post" enctype="multipart/form-data">
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
                                        <p class="card-text"><strong>Discipline: </strong>
                                            {{ $training_program->discipline->name }} </p>
                                        {{-- radio button --}}
                                        <input type="radio" name="training_program"
                                            id="program{{ $training_program->id }}" value="{{ $training_program->id }}">
                                        <label for="program{{ $training_program->id }}">Apply for this program</label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if ($training_programs->hasPages())
                        <br>
                    @endif
                    {{ $training_programs->links('pagination::bootstrap-5') }}
                </div>

                <!-- Submit -->
                <div class="mb-3 d-flex justify-content-end">
                    <button class="btn btn-success" type="submit" style="width: 100px">Apply</button>
                </div>
            </form>
        </div>
    </main>
@endsection
