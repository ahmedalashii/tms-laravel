@extends('layouts.advisorLayout')

@section('MainContent')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">My Assigned Training Programs</h1>
            <form method="GET" action="{{ route('advisor.assigned-training-programs') }}">
                <div class="row">
                    <div class="col-md-6">
                        <label for="price_filter">Filter based on price</label>
                        <div class="row">
                            <div class="col-md-10">
                                <select class="form-select mb-3" aria-label=".form-select-lg example" id="price_filter"
                                    name="price_filter">
                                    <option selected value="">Select Price Filter Factor</option>
                                    <option value="free" @if (request()->get('price_filter') == 'free') selected @endif>
                                        Free
                                    </option>
                                    <option value="paid" @if (request()->get('price_filter') == 'paid') selected @endif>
                                        Paid
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-success">Filter</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="discipline">Filter based on discipline</label>
                        <div class="row">
                            <div class="col-md-10">
                                <select class="form-select mb-3" aria-label=".form-select-lg example" id="discipline"
                                    name="discipline">
                                    <option selected value="">Select Discipline</option>
                                    @foreach ($disciplines as $discipline)
                                        <option value="{{ $discipline->id }}"
                                            @if (request()->get('discipline') == $discipline->id) selected @endif>
                                            {{ $discipline->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-success">Filter</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <input type="search" class="form-control" placeholder="Search for training programs"
                            aria-label="Search" name="search" value="{{ request()->query('search') }}">
                    </div>
                    <div class="col-md-2 d-flex justify-content-end">
                        <button class="btn btn-dark" type="submit" style="width: 300px">Search</button>
                    </div>
                </div>
            </form>
            <div class="mb-3">
                @if ($training_programs->isNotEmpty())
                    <div class="row">
                        @foreach ($training_programs as $trainingProgram)
                            @php
                                $trainingProgram
                                    ->load('tasks')
                                    ->latest()
                                    ->take(5)
                                    ->get();
                            @endphp
                            <div class="col-md-4">
                                <div class="card mt-2" style="height: 500px; overflow-y: scroll;">
                                    <img class="card-img-top"
                                        src="{{ $trainingProgram->thumbnail ? (@getimagesize($trainingProgram->thumbnail) ? $trainingProgram->thumbnail : 'https://www.contentviewspro.com/wp-content/uploads/2017/07/default_image.png') : 'https://www.contentviewspro.com/wp-content/uploads/2017/07/default_image.png' }}"
                                        alt="{{ $trainingProgram->name }}'s image" height="300px">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $trainingProgram->name }}</h5>
                                        <p class="card-text">{{ $trainingProgram->description }}</p>
                                        <p class="card-text"><strong>Start Date: </strong>
                                            {{ $trainingProgram->start_date }}
                                        </p>
                                        <p class="card-text"><strong>End Date: </strong>
                                            {{ $trainingProgram->end_date }}
                                        </p>
                                        <p class="card-text"><strong>Duration: </strong>
                                            {{ $trainingProgram->duration }}
                                            {{ $trainingProgram->duration_unit }}
                                        </p>
                                        <p class="card-text"><strong>Location: </strong>
                                            {{ $trainingProgram->location }}
                                        </p>
                                        <p class="card-text"><strong>Capacity: </strong>
                                            {{ $trainingProgram->users_length }} /
                                            {{ $trainingProgram->capacity }} trainees registered for this
                                            program so
                                            far.
                                        </p>

                                        <p class="card-text"><strong>Discipline: </strong>
                                            {{ $trainingProgram->discipline->name }} </p>

                                        <p class="card-text">
                                            <strong>Training Attendances Days: </strong>
                                            @foreach ($trainingProgram->training_attendances as $training_attendances)
                                                <ul>
                                                    <li>
                                                        {{ $training_attendances->attendance_day }}
                                                    </li>
                                                    <li>
                                                        From
                                                        {{ date('g:i A', strtotime($training_attendances->start_time)) }}
                                                        to
                                                        {{ date('g:i A', strtotime($training_attendances->end_time)) }}
                                                    </li>
                                                </ul>
                                            @endforeach
                                        </p>
                                        <p>
                                            <strong>Fees: </strong>
                                            @if ($trainingProgram->fees <= 0)
                                                <b class="text-success">Free</b>
                                            @else
                                                <b class="text-danger">{{ $trainingProgram->fees }}
                                                    USD</b>
                                            @endif
                                        </p>

                                        <p>
                                            <strong>Enrolled Trainees: </strong>
                                            @if ($trainingProgram->trainees->isEmpty())
                                                <b class="text-danger">No trainees registered for this program
                                                    yet.</b>
                                            @else
                                                <ul>
                                                    @foreach ($trainingProgram->trainees as $trainee)
                                                        <li>
                                                            <img src="{{ $trainee?->avatar ?? 'https://www.contentviewspro.com/wp-content/uploads/2017/07/default_image.png' }}"
                                                                alt="advisor" class="rounded-circle" width="30px"
                                                                height="30px">
                                                            <a href="{{ route('advisor.trainee-details', $trainee->id) }}">
                                                                {{ $trainee->displayName }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </p>
                                        <p>
                                            <strong>Last 5 Tasks: </strong>
                                            @if ($trainingProgram->tasks->isEmpty())
                                                <b class="text-danger">No tasks created for this program
                                                    yet.</b>
                                            @else
                                                <ul>
                                                    @foreach ($trainingProgram->tasks as $task)
                                                        <li>
                                                            {{-- name, description, end_date --}}
                                                            <strong>Name: </strong> {{ $task->name }} <br>
                                                            <strong>Description: </strong> {{ $task->description }} <br>
                                                            <strong>End Date: </strong> {{ $task->end_date }} <br>
                                                            <strong>File: </strong> <a href="{{ $task->file_url }}">View
                                                                File</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <br>
                    <div class="alert alert-info"> You're not assigned to any training program @if (request()->query('search'))
                            with the search term <b>{{ request()->query('search') }}</b>
                            @endif @if (request()->query('price_filter'))
                                with the price filter factor <b>{{ request()->query('price_filter') }}</b>
                                @endif @if (request()->query('discipline'))
                                    with the discipline
                                    <b>{{ \App\Models\Discipline::find(request()->query('discipline'))?->name }}</b>
                                @endif
                            @endif
                            @if ($training_programs->hasPages())
                                <br>
                            @endif
                            {{ $training_programs->links('pagination::bootstrap-5') }}
                    </div>
            </div>
    </main>

@endsection
