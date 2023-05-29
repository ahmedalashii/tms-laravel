@extends('layouts.traineeLayout')

@section('MainContent')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4"><span class="text-success">{{ $advisor->displayName }}</span> profile</h1>
            <div class="row">
                <div class="d-flex align-items-center justify-content-center mb-3">
                    <img src="{{ $advisor->avatar }}" id="user_avatar" class="avatar_img shadow-lg" alt="avatar" />
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Address</h5>
                            <p class="card-text">{{ $advisor->address }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Name</h5>
                            <p class="card-text">{{ $advisor->displayName }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Email</h5>
                            <p class="card-text">{{ $advisor->email }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Phone Number</h5>
                            <p class="card-text">{{ $advisor->phone }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">CV File: <a href="{{ $advisor->cv }}" target="_blank"
                                    class="btn btn-success">View CV File</a>
                            </h5>
                            <hr>
                            <h5 class="card-title">Assigned Training Programs</h5>
                            @php
                                // Enrolled Training Programs Related to this Advisor
                                $assignedPrograms = $advisor->assigned_training_programs;
                            @endphp
                            @if ($assignedPrograms->isNotEmpty())
                                <ol class="list-group list-group-flush"
                                    style="max-height: 200px; overflow-y: scroll; overflow-x: hidden;">
                                    @foreach ($assignedPrograms as $assignedProgram)
                                        <li class="list-group-item list-decimal"
                                            style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; !important; ">
                                            {{ $assignedProgram->name }}
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
                            @if ($advisor->disciplines->isNotEmpty())
                                <ul>
                                    @foreach ($advisor->disciplines as $discipline)
                                        <li>{{ $discipline->name }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
