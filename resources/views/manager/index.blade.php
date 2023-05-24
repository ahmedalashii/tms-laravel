@extends('layouts.managerLayout')

@section('MainContent')
    <main>
        @php
            $manager = Auth::guard('manager')->user();
            $manager_db = \App\Models\Manager::where('firebase_uid', $manager->localId)->first();
        @endphp
        <div class="container-fluid px-4">
            <h1 class="mt-4">We're excited to have you on board, <span class="text-success">{{ $manager->displayName }}
                    😎</span>
            </h1>

            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-warning me-1"></i>
                        Recent Training Requests
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Trainee Avatar & Name</th>
                                    <th>Trainee Email Address</th>
                                    <th>Training Program Requested</th>
                                    <th>Fees</th>
                                    <th>Has paid?</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($training_requests->isNotEmpty())
                                    @foreach ($training_requests as $training_request)
                                        <tr>
                                            <td>
                                                <img src="{{ $training_request->trainee->avatar }}"
                                                    class="rounded-circle me-1" width="37px" height="40px"
                                                    alt="{{ $training_request->trainee->displayName }}'s avatar" />
                                                {{ $training_request->trainee->displayName }}
                                            </td>
                                            <td>{{ $training_request->trainee->email }}</td>
                                            <td>{{ $training_request->trainingProgram->name }}</td>
                                            <td>
                                                @if ($training_request->trainingProgram->fees)
                                                    ${{ $training_request->trainingProgram->fees }}
                                                @else
                                                    <span class="badge bg-success">Free</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($training_request->fees_paid)
                                                    <span class="badge bg-success">Yes: <b
                                                            style="color: white; font-weight: 500">${{ $training_request->fees_paid }}</b></span>
                                                @else
                                                    <span class="badge bg-danger">No</span>
                                                @endif
                                            </td>
                                            <td>{{ $training_request->trainingProgram->start_date }}</td>
                                            <td>{{ $training_request->trainingProgram->end_date }}</td>
                                            <td>
                                                <form
                                                    action="{{ route('manager.approve-training-request', $training_request->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button class="btn btn-success rounded-full btn-hover" type="submit"
                                                        style="width: 100px; padding: 11px;">
                                                        Approve
                                                    </button>
                                                </form>
                                                <br>
                                                <form
                                                    action="{{ route('manager.reject-training-request', $training_request->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button class="btn btn-danger rounded-full btn-hover" type="submit"
                                                        style="width: 100px; padding: 11px;">
                                                        Reject
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8" class="text-center">No training requests found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Training Requests</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{ route('manager.training-requests') }}">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Disciplines</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{ route('manager.disciplines') }}">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Training Programs</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{ route('manager.training-programs') }}">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Authorize Trainees</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link"
                                href="{{ route('manager.authorize-trainees') }}">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="@if ($manager_db?->role == 'super_manager') col-xl-4 @else col-xl-6 @endif col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Trainees</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{ route('manager.trainees') }}">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>

                <div class="@if ($manager_db?->role == 'super_manager') col-xl-4 @else col-xl-6 @endif col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Issues</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{ route('manager.issues') }}">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>

                @if ($manager_db?->role == 'super_manager')
                    <div class="col-xl-4 col-md-6">
                        <div class="card bg-success text-white mb-4">
                            <div class="card-body">Managers Authorization</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="{{ route('manager.managers') }}">View
                                    Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </main>
@endsection
