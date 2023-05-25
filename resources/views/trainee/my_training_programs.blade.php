@extends('layouts.traineeLayout')

@section('MainContent')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">My Training Programs</h1>
            <form method="GET" action="{{ route('trainee.my-training-programs') }}">
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
                            <div class="col-md-4">
                                <div class="card mt-2" style="height: 500px; overflow-y: scroll;">
                                    <img class="card-img-top"
                                        src="{{ $trainingProgram->thumbnail ?? 'https://www.contentviewspro.com/wp-content/uploads/2017/07/default_image.png' }}"
                                        alt="{{ $trainingProgram->name }}'s image">
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
                                            {{ $trainingProgram->capacity }} trainees registered for this program so
                                            far.
                                        </p>
                                        <p class="card-text"><strong>Status: </strong>
                                            @if ($trainingProgram->trainee_status == 'pending')
                                                <span class="text-warning">Pending</span>
                                            @elseif($trainingProgram->trainee_status == 'approved')
                                                <span class="text-success">Approved</span>
                                            @else
                                                <span class="text-danger">Rejected</span>
                                            @endif
                                        </p>
                                        <p class="card-text"><strong>Discipline: </strong>
                                            {{ $trainingProgram->discipline->name }} </p>
                                        <p class="card-text">
                                            <strong>Advisor: </strong>
                                            @if ($trainingProgram->advisor)
                                                <img src="{{ $trainingProgram->advisor?->avatar ?? 'https://www.contentviewspro.com/wp-content/uploads/2017/07/default_image.png' }}"
                                                    alt="advisor" class="rounded-circle" width="30px" height="30px">
                                                {{ $trainingProgram->advisor->displayName }}
                                            @else
                                                <span class="text-danger">No advisor assigned yet.</span>
                                            @endif
                                        </p>
                                        <p>
                                            <strong>Fees: </strong>
                                            @if ($trainingProgram->fees <= 0)
                                                <b class="text-success">Free</b>
                                            @else
                                                <b class="text-danger">{{ $trainingProgram->fees }} USD</b>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <br>
                    <div class="alert alert-info">You have not registered for any training program yet.</div>
                @endif
                @if ($training_programs->hasPages())
                    <br>
                @endif
                {{ $training_programs->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </main>

@endsection
