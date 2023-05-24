@extends('layouts.managerLayout')

@section('MainContent')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">Training Programs</h1>
            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-user me-1"></i>
                        Training Programs Information
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('manager.training-programs') }}">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="discipline">Filter based on discipline</label>
                                    <div class="row">
                                        <div class="col-md-10">
                                            <select class="form-select mb-3" aria-label=".form-select-lg example"
                                                id="discipline" name="discipline">
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
                                <div class="col-md-4">
                                    <label for="advisor">Filter based on advisor</label>
                                    <div class="row">
                                        <div class="col-md-10">
                                            <select class="form-select mb-3" aria-label=".form-select-lg example"
                                                id="advisor" name="advisor">
                                                <option selected value="">Select Advisor</option>
                                                @foreach ($advisors as $advisor)
                                                    <option value="{{ $advisor->id }}"
                                                        @if (request()->get('advisor') == $advisor->id) selected @endif>
                                                        {{ $advisor->displayName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-success">Filter</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 d-flex justify-content-end align-items-end pb-3">
                                    <a class="btn btn-success" href="{{ route('manager.create-training-program') }}">Add New
                                        Training Program</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <input type="search" class="form-control" placeholder="Search for training programs"
                                        aria-label="Search" name="search" value="{{ request()->query('search') }}">
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-dark" type="submit">Search</button>
                                </div>
                            </div>
                            <br>
                        </form>

                        <table class="table table-striped table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Duration</th>
                                    <th>Discipline</th>
                                    <th>Advisor</th>
                                    <th>Location</th>
                                    <th>Users Length / Capacity</th>
                                    <th>Fees</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Edit</th>
                                    <th>Activate/Deactivate</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($training_programs->isNotEmpty())
                                    @foreach ($training_programs as $trainingProgram)
                                        <tr>
                                            <td>{{ $trainingProgram->name }}</td>
                                            <td>{{ $trainingProgram->description }}</td>
                                            <td>{{ $trainingProgram->duration }} {{ $trainingProgram->duration_unit }}
                                            </td>
                                            <td>{{ $trainingProgram->discipline->name }}</td>
                                            <td>{{ $trainingProgram->advisor?->displayName ?? '--' }}</td>
                                            <td>{{ $trainingProgram->location }}</td>
                                            <td>{{ $trainingProgram->users_length }} / {{ $trainingProgram->capacity }}
                                            <td>
                                                @if ($trainingProgram->fees)
                                                    {{ $trainingProgram->fees }} ₪
                                                @else
                                                    <b style="color: green">Free</b>
                                                @endif
                                            </td>
                                            <td>{{ $trainingProgram->start_date }}</td>
                                            <td>{{ $trainingProgram->end_date }}</td>
                                            <td>
                                                @if ($trainingProgram->trashed())
                                                    <button class="btn btn-secondary rounded-full btn-hover"
                                                        style="width: 100px; padding: 11px; cursor: not-allowed !important;"
                                                        disabled>
                                                        Edit
                                                    </button>
                                                @else
                                                    <form
                                                        action="{{ route('manager.edit-training-program', $trainingProgram->id) }}"
                                                        method="GET">
                                                        <button class="btn btn-success btn-sm" type="submit"
                                                            style="width: 100px; padding: 11px;">
                                                            Edit
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($trainingProgram->trashed())
                                                    <form
                                                        action="{{ route('manager.activate-training-program', $trainingProgram->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button class="btn btn-success rounded-full btn-hover"
                                                            type="submit" style="width: 100px; padding: 11px;">
                                                            Activate
                                                        </button>
                                                    </form>
                                                @else
                                                    <form
                                                        action="{{ route('manager.deactivate-training-program', $trainingProgram->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button class="btn btn-danger rounded-full btn-hover" type="submit"
                                                            style="width: 100px; padding: 11px;">
                                                            Deactivate
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="12" class="text-center">No Training Programs Found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        @if ($training_programs->hasPages())
                            <br>
                        @endif
                        {{ $training_programs->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </section>
        </div>
    </main>
@endsection
