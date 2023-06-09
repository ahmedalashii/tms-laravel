@extends('layouts.traineeLayout')

@section('MainContent')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">We're excited to have you on board, <span
                    class="text-success">{{ auth_trainee()->displayName }} 😎</span></h1>

            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-clock me-1"></i>
                        Timeline of Tasks in the last 30 days
                    </div>
                    <div class="card-body">
                        @if ($tasks->isEmpty())
                            <p class="bg-secondary text-white p-2">There are no tasks available. Once a task is added, it
                                will appear here.</p>
                        @else
                            <ul class="list-unstyled">
                                @foreach ($tasks as $task)
                                    <li class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <h5 class="mb-0">{{ $task->name }}</h5>
                                            @if ($task->file_url)
                                                <small><strong>File: </strong>
                                                    <a href="{{ $task->file_url }}"
                                                        target="_blank">{{ $task->name }}.{{ $task->file()->extension }}</a>
                                                </small><br>
                                            @endif
                                            <small><strong>Training Program: </strong>
                                                {{ $task->trainingProgram->name }}
                                            </small><br>
                                            <small>{{ $task->description }}</small>
                                            <small
                                                @if (Carbon\Carbon::parse($task->end_date)->diffInDays(Carbon\Carbon::now()) <= 4) style="color: red;" @else
                                                class="text-muted" @endif>
                                                Deadline: {{ Carbon\Carbon::parse($task->end_date)->format('d M Y') }}
                                            </small>
                                        </div>
                                        <a href="{{ route('trainee.upload', $task->id) }}" class="btn btn-sm btn-success"
                                            style="width:95px;">
                                            @if ($task->submittedFileUrl)
                                                Edit Submission
                                            @else
                                                Add Submission
                                            @endif
                                        </a>
                                    </li>
                                    {{-- if last task then hr --}}
                                    @if (!$loop->last)
                                        <hr>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </section>

            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-clock me-1"></i>
                        Newly Added Training Programs
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            @foreach ($recent_programs as $recent_program)
                                <li class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h5 class="mb-0">{{ $recent_program->name }}</h5>
                                        <small>{{ $recent_program->description }}</small>
                                        <small class="text-muted">Added on
                                            {{ $recent_program->created_at->format('d M Y') }}</small>
                                    </div>
                                    <a href="{{ route('trainee.available-training-programs') }}"
                                        class="btn btn-sm btn-success">View Details</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </section>

            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Training Program Task Submission</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{ route('trainee.upload') }}">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Apply For Training Programs</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link"
                                href="{{ route('trainee.available-training-programs') }}">View Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">My Training Requests</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link"
                                href="{{ route('trainee.all-training-requests') }}">View Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">My Approved Training Programs</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link"
                                href="{{ route('trainee.approved-training-programs') }}">View Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Training Attendance</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link"
                                href="{{ route('trainee.training-attendance') }}">View Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Request a Meeting</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{ route('trainee.request-meeting') }}">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Advisors List</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{ route('trainee.advisors-list') }}">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Sent a new Email</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{ route('trainee.send-email-form') }}">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Received Emails</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{ route('trainee.received-emails') }}">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Sent Emails</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{ route('trainee.sent-emails') }}">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
