@extends('layouts.managerLayout')

@section('MainContent')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">Training Request Review</h1>
            <section class="card mb-4 mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-bell me-1"></i>
                        Criteria</span>
                    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample"
                        aria-expanded="false" aria-controls="collapseExample">
                        <i class="fas fa-solid fa-pen-to-square"></i>
                    </button>
                </div>
                <div class="card-body">
                    <p>The following criteria are used to review training requests:</p>
                    <ul>
                        @php
                            $training_criteria = \App\Models\TrainingCriterion::all();
                        @endphp
                        @foreach ($training_criteria as $training_criterion)
                            <li>{{ $training_criterion->name }}</li>
                        @endforeach
                    </ul>
                    <div>
                        <form class="collapse" id="collapseExample" action="{{ route('manager.update-training-criteria') }}"
                            method="POST">
                            @csrf
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"
                                    name="criterion"></textarea>
                                <label for="floatingTextarea2">Add New Criterion (Only one at a time represented by one
                                    line)</label>
                            </div>
                            <button class="btn btn-success w-100 mt-2" type="submit">Add Criterion</button>
                        </form>
                    </div>
                </div>
            </section>

            <table class="table table-striped table-bordered">
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
                                    <img src="{{ $training_request->trainee->avatar }}" class="rounded-circle me-1"
                                        width="37px" height="40px"
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
                                    <form action="{{ route('manager.approve-training-request', $training_request->id) }}"
                                        method="POST">
                                        @csrf
                                        <button class="btn btn-success rounded-full btn-hover" type="submit"
                                            style="width: 100px; padding: 11px;">
                                            Approve
                                        </button>
                                    </form>
                                    <br>
                                    <form action="{{ route('manager.reject-training-request', $training_request->id) }}"
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
            @if ($trainees->hasPages())
                <br>
            @endif
            {{ $trainees->links('pagination::bootstrap-5') }}
        </div>
    </main>
@endsection
