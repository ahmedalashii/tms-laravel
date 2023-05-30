@extends('layouts.advisorLayout')

@section('MainContent')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">Tasks</h1>
            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-user me-1"></i>
                        Tasks Information
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('advisor.tasks') }}">
                            <div class="row">
                                <div class="col-md-10">
                                    <label for="discipline">Filter based on training program</label>
                                    <div class="row">
                                        <div class="col-md-10">
                                            <select class="form-select mb-3" aria-label=".form-select-lg example"
                                                id="discipline" name="training_program">
                                                <option selected value="">Select Training Program</option>
                                                @foreach ($training_programs as $training_program)
                                                    <option value="{{ $training_program->id }}"
                                                        @if (request()->get('training_program') == $training_program->id) selected @endif>
                                                        {{ $training_program->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-success" style="width: 100%;">Filter</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex justify-content-end align-items-end pb-3">
                                    <a class="btn btn-success" href="{{ route('advisor.create-task') }}" role="button"
                                        style="width: 100%;">Create Task</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <input type="search" class="form-control" placeholder="Search for tasks"
                                        aria-label="Search" name="search" value="{{ request()->query('search') }}">
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-dark" type="submit" style="width: 100%;">
                                        Search
                                </div>
                            </div>
                            <br>
                        </form>

                        <table class="table table-striped table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Training Program</th>
                                    <th>Creation Date</th>
                                    <th>End Date</th>
                                    <th>Edit</th>
                                    <th>Activate/Deactivate</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($tasks->isNotEmpty())
                                    @foreach ($tasks as $task)
                                        <tr>
                                            <td>{{ $task->name }}</td>
                                            <td>{{ $task->description }}</td>
                                            <td>{{ $task->trainingProgram->name }}</td>
                                            <td>{{ Carbon\Carbon::parse($task->created_at)->format('d/m/Y') }}</td>
                                            <td>{{ $task->end_date }}</td>
                                            <td>
                                                @if ($task->trashed())
                                                    <button class="btn btn-secondary rounded-full btn-hover"
                                                        style="width: 100px; padding: 11px; cursor: not-allowed !important;"
                                                        disabled>
                                                        Edit
                                                    </button>
                                                @else
                                                    <form action="{{ route('advisor.edit-task', $task->id) }}"
                                                        method="GET">
                                                        <button class="btn btn-success btn-sm" type="submit"
                                                            style="width: 100px; padding: 11px;">
                                                            Edit
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($task->trashed())
                                                    <form action="{{ route('advisor.activate-task', $task->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button class="btn btn-success rounded-full btn-hover"
                                                            type="submit" style="width: 100px; padding: 11px;">
                                                            Activate
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('advisor.deactivate-task', $task->id) }}"
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
                                        <td colspan="12" class="text-center">No Tasks Found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        @if ($tasks->hasPages())
                            <br>
                        @endif
                        {{ $tasks->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </section>
        </div>
    </main>
@endsection
