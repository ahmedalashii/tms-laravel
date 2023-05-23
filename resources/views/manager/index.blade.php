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
                        Issues
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Sender</th>
                                    <th>Title</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Response</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <img src="https://randomuser.me/api/portraits/men/60.jpg"
                                            class="rounded-circle me-1" width="40px" alt="Jane Doe's avatar" />
                                        John Doe
                                    </td>
                                    <td>Bug 1</td>
                                    <td>Bug</td>
                                    <td>This is a bug that needs to be fixed.</td>
                                    <td>
                                        <a href="{{ route('manager.issue-response', 1) }}"
                                            class="btn btn-success">Respond</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="https://randomuser.me/api/portraits/men/60.jpg"
                                            class="rounded-circle me-1" width="40px" alt="Jane Doe's avatar" />
                                        John Doe
                                    </td>
                                    <td>Enhancement 1</td>
                                    <td>Enhancement</td>
                                    <td>This is an enhancement that would be nice to have.</td>
                                    <td>
                                        <a href="{{ route('manager.issue-response', 1) }}"
                                            class="btn btn-success">Respond</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="https://randomuser.me/api/portraits/men/60.jpg"
                                            class="rounded-circle me-1" width="40px" alt="Jane Doe's avatar" />
                                        John Doe
                                    </td>
                                    <td>Task 1</td>
                                    <td>Task</td>
                                    <td>This is a task that needs to be completed.</td>
                                    <td>
                                        <a href="{{ route('manager.issue-response', 1) }}"
                                            class="btn btn-success">Respond</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="https://randomuser.me/api/portraits/men/60.jpg"
                                            class="rounded-circle me-1" width="40px" alt="Jane Doe's avatar" />
                                        John Doe
                                    </td>
                                    <td>Bug 1</td>
                                    <td>Bug</td>
                                    <td>This is a bug that needs to be fixed.</td>
                                    <td>
                                        <a href="{{ route('manager.issue-response', 1) }}"
                                            class="btn btn-success">Respond</a>
                                    </td>
                                </tr>
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
                            <a class="small text-white stretched-link" href="{{ route('manager.authorize-trainees') }}">View
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
