@extends('layouts.advisorLayout')

@section('MainContent')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">We're excited to have you on board, <span
                    class="text-success">{{ Auth::guard('advisor')->user()->displayName }} 😎</span></h1>

            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-clock me-1"></i>
                        Recently Enrolled Trainees
                    </div>
                    <div class="card-body">
                        @if ($recent_trainees->isNotEmpty())
                            <ul class="list-unstyled">
                                @foreach ($recent_trainees as $recent_trainee)
                                    <li class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <h5 class="mb-0">{{ $recent_trainee->displayName }}</h5>
                                            <small>{{ $recent_trainee->email }}</small>
                                        </div>
                                        <a href="#" class="btn btn-sm btn-success">View Details</a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="bg-secondary text-white p-2">There are no recently enrolled trainees. Once a trainee
                                enrolls, they will appear here.</p>
                        @endif
                    </div>
                </div>
            </section>

            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Training Attendance</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="./attendance.html">View Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Request a Meeting</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="./request-meeting.html">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Personal File Upload</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="./upload.html">View Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
