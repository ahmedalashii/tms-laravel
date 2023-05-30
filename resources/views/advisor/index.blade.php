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
                        @if ($recent_enrollments->isNotEmpty())
                            <ul class="list-unstyled">
                                @foreach ($recent_enrollments as $recent_enrollment)
                                    <li class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <h5 class="mb-0"> <img
                                                    src="{{ $recent_enrollment->trainee->avatar ?? 'https://www.contentviewspro.com/wp-content/uploads/2017/07/default_image.png' }}"
                                                    alt="trainee" class="rounded-circle" width="40px" height="40px">
                                                {{ $recent_enrollment->trainee->displayName }}</h5>
                                            <small>{{ $recent_enrollment->trainee->email }}</small>
                                            <small class="text-muted">Enrolled on
                                                {{ $recent_enrollment->created_at->format('d M Y') }}</small> |
                                            <small class="text-muted">Training Program:
                                                {{ $recent_enrollment->trainingProgram->name }}</small>
                                        </div>
                                        <a href="{{ route('advisor.trainee-details', $recent_enrollment->trainee->id) }}"
                                            class="btn btn-sm btn-success">View Details</a>
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
                        <div class="card-body">Trainees List</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{ route('advisor.trainees-list') }}">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Assigned Tranining Programs</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link"
                                href="{{ route('advisor.assigned-training-programs') }}">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>




                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Sent a new Email</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{ route('advisor.send-email-form') }}">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Received Emails</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{ route('advisor.received-emails') }}">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Sent Emails</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{ route('advisor.sent-emails') }}">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Training Program Tasks</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{ route('advisor.tasks') }}">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
