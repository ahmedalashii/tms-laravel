@extends('layouts.advisorLayout')

@section('MainContent')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4"><span class="text-success">{{ $trainee->displayName }}</span> profile</h1>
            <div class="row">
                <div class="d-flex align-items-center justify-content-center mb-3">
                    <img src="{{ $trainee->avatar }}" id="user_avatar" class="avatar_img shadow-lg" alt="avatar" />
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Address</h5>
                            <p class="card-text">{{ $trainee->address }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Name</h5>
                            <p class="card-text">{{ $trainee->displayName }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Email</h5>
                            <p class="card-text">{{ $trainee->email }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Phone Number</h5>
                            <p class="card-text">{{ $trainee->phone }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">CV File: <a href="{{ $trainee->cv }}" target="_blank"
                                    class="btn btn-success">View CV File</a>
                            </h5>
                            <h5 class="card-title">Files Uploaded:</h5>
                            @if ($trainee->files->isNotEmpty())
                                <ol class="list-group list-group-flush"
                                    style="max-height: 200px; overflow-y: scroll; overflow-x: hidden;">
                                    @foreach ($trainee->files as $file)
                                        <li class="list-group-item list-decimal">
                                            <a href="{{ $file->url }}" target="_blank">{{ $file->description }}</a>
                                        </li>
                                    @endforeach
                                </ol>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Disciplines</h5>
                            @if ($trainee->disciplines->isNotEmpty())
                                <ul>
                                    @foreach ($trainee->disciplines as $discipline)
                                        <li>{{ $discipline->name }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Enrolled Training Programs</h5>
                            @php
                                // Enrolled Programs Related to this Advisor
                                $enrolledPrograms = $trainee->training_programs->where('advisor_id', auth_advisor()->id);
                            @endphp
                            @if ($enrolledPrograms->isNotEmpty())
                                <ol class="list-group list-group-flush"
                                    style="max-height: 200px; overflow-y: scroll; overflow-x: hidden;">
                                    @foreach ($enrolledPrograms as $enrolledProgram)
                                        <li class="list-group-item list-decimal">
                                            {{ $enrolledProgram->name }}
                                            @php
                                                $submittedTasks = $enrolledProgram->tasks->load([
                                                    'files' => function ($query) use ($trainee) {
                                                        $query->where('trainee_id', $trainee->id);
                                                    },
                                                ]);
                                                // only the submitted tasks related to this trainee
                                                $submittedTasks = $submittedTasks->filter(function ($task) {
                                                    return $task->files->isNotEmpty();
                                                });
                                            @endphp
                                            @if ($submittedTasks->isNotEmpty())
                                                <br>
                                                <strong>Submitted Tasks Files:</strong>
                                                <ul>
                                                    @foreach ($submittedTasks as $submittedTask)
                                                        <li>
                                                            <span class="text-success">{{ $submittedTask->name }}</span>
                                                            <ul>
                                                                @foreach ($submittedTask->files as $file)
                                                                    <li>
                                                                        <a href="{{ $file->url }}"
                                                                            target="_blank">{{ $file->name }}</a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ol>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
