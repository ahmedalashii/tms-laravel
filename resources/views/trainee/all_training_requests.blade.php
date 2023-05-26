@extends('layouts.traineeLayout')

@section('MainContent')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">My Training Requests</h1>
            <form method="GET" action="{{ route('trainee.all-training-requests') }}">
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
                @if ($training_requests->isNotEmpty())
                    <div class="row">
                        @foreach ($training_requests as $trainingRequest)
                            <div class="col-md-4">
                                <div class="card mt-2" style="height: 500px; overflow-y: scroll;">
                                    <img class="card-img-top"
                                        src="{{ $trainingRequest->trainingProgram->thumbnail ? (@getimagesize($trainingRequest->trainingProgram->thumbnail) ? $trainingRequest->trainingProgram->thumbnail : 'https://www.contentviewspro.com/wp-content/uploads/2017/07/default_image.png') : 'https://www.contentviewspro.com/wp-content/uploads/2017/07/default_image.png' }}"
                                        alt="{{ $trainingRequest->trainingProgram->name }}'s image" height="300px">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $trainingRequest->trainingProgram->name }}</h5>
                                        <p class="card-text">{{ $trainingRequest->trainingProgram->description }}</p>
                                        <p class="card-text">
                                            <strong>Submission Date: </strong>
                                            {{ Carbon\Carbon::parse($trainingRequest->created_at)->format('d M Y h:i A') }}
                                        </p>
                                        <p class="card-text"><strong>Status: </strong>
                                            @if ($trainingRequest->status == 'pending')
                                                <span class="text-warning">Pending</span>
                                            @elseif($trainingRequest->status == 'approved')
                                                <span class="text-success">Approved</span>
                                            @else
                                                <span class="text-danger">Rejected</span>
                                            @endif
                                        </p>
                                        <p class="card-text"><strong>Start Date: </strong>
                                            {{ $trainingRequest->trainingProgram->start_date }}
                                        </p>
                                        <p class="card-text"><strong>End Date: </strong>
                                            {{ $trainingRequest->trainingProgram->end_date }}
                                        </p>
                                        <p class="card-text"><strong>Duration: </strong>
                                            {{ $trainingRequest->trainingProgram->duration }}
                                            {{ $trainingRequest->trainingProgram->duration_unit }}
                                        </p>
                                        <p class="card-text"><strong>Location: </strong>
                                            {{ $trainingRequest->location }}
                                        </p>
                                        <p class="card-text"><strong>Capacity: </strong>
                                            {{ $trainingRequest->trainingProgram->users_length }} /
                                            {{ $trainingRequest->trainingProgram->capacity }} trainees registered for this
                                            program so
                                            far.
                                        </p>

                                        <p class="card-text"><strong>Discipline: </strong>
                                            {{ $trainingRequest->trainingProgram->discipline->name }} </p>
                                        <p class="card-text">
                                            <strong>Advisor: </strong>
                                            @if ($trainingRequest->advisor)
                                                <img src="{{ $trainingRequest->advisor?->avatar ?? 'https://www.contentviewspro.com/wp-content/uploads/2017/07/default_image.png' }}"
                                                    alt="advisor" class="rounded-circle" width="30px" height="30px">
                                                {{ $trainingRequest->advisor->displayName }}
                                            @else
                                                <span class="text-danger">No advisor assigned yet.</span>
                                            @endif
                                        </p>
                                        <p class="card-text">
                                            <strong>Training Attendances Dates: </strong>
                                            @foreach ($trainingRequest->trainingProgram->training_attendances as $training_attendances)
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
                                            @if ($trainingRequest->trainingProgram->fees <= 0)
                                                <b class="text-success">Free</b>
                                            @else
                                                <b class="text-danger">{{ $trainingRequest->trainingProgram->fees }}
                                                    USD</b>
                                            @endif
                                        </p>
                                        <p>
                                            <strong>Fees Paid: </strong>
                                            @if ($trainingRequest->fees_paid <= 0 && $trainingRequest->trainingProgram->fees <= 0)
                                                <b class="text-success">It's Free</b>
                                            @elseif ($trainingRequest->fees_paid <= 0 && $trainingRequest->trainingProgram->fees > 0)
                                                <b class="text-danger">Not Paid</b>
                                            @elseif ($trainingRequest->fees_paid > 0 && $trainingRequest->trainingProgram->fees > 0)
                                                <b class="text-success">{{ $trainingRequest->fees_paid }} USD</b>
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
                @if ($training_requests->hasPages())
                    <br>
                @endif
                {{ $training_requests->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </main>

@endsection
