@extends('layouts.managerLayout')

@section('MainContent')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">Trainees</h1>
            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-user me-1"></i>
                        Trainee Information
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <form action="{{ route('manager.trainees') }}" method="GET">
                                <div class="row">
                                    <div class="col-md-11">
                                        <input type="search" class="form-control" placeholder="Search for trainees"
                                            aria-label="Search" name="search" value="{{ request()->query('search') }}">
                                    </div>
                                    <div class="col-md-1">
                                        <button class="btn btn-dark" type="submit">Search</button>
                                    </div>
                                </div>
                            </form>
                            <br>
                            <thead class="table-dark">
                                <tr>
                                    <th>Avatar & Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Address</th>
                                    <th>Gender</th>
                                    <th>Is Email Verified?</th>
                                    <th>Is Authorized?</th>
                                    <th>CV</th>
                                    <th>Edit</th>
                                    <th>Activate/Deactivate</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($trainees->isEmpty())
                                    <tr>
                                        <td colspan="10" class="text-center">No trainees found.</td>
                                    </tr>
                                @else
                                    @foreach ($trainees as $trainee)
                                        <tr>
                                            <td>
                                                <img src="{{ $trainee->avatar }}" class="rounded-circle me-1" width="37px"
                                                    height="40px" alt="{{ $trainee->displayName }}'s avatar" />
                                                {{ $trainee->displayName }}
                                            </td>
                                            <td>{{ $trainee->email }}</td>
                                            <td>{{ $trainee->phone }}</td>
                                            <td>{{ $trainee->address }}</td>
                                            <td>{{ Str::ucfirst($trainee->gender) }}</td>
                                            <td class="min-width">
                                                <p>
                                                    @if ($trainee->email_verified ?? false)
                                                        Yes <b style="color: #219653;">&#10003;</b>
                                                    @else
                                                        No <b style="color: #d50100;">&#x2717;</b>
                                                    @endif
                                                </p>
                                            </td>
                                            <td class="min-width">
                                                <p>
                                                    @if ($trainee->auth_id ?? false)
                                                        Yes <b style="color: #219653;">&#10003;</b>
                                                    @else
                                                        No <b style="color: #d50100;">&#x2717;</b>
                                                    @endif
                                                </p>
                                            <td><a href="{{ $trainee->cv }}">Download
                                                    CV</a></td>
                                            <td>
                                                @if ($trainee->trashed())
                                                    <button class="btn btn-secondary rounded-full btn-hover"
                                                        style="width: 100px; padding: 11px; cursor: not-allowed !important;"
                                                        disabled>
                                                        Edit
                                                    </button>
                                                @else
                                                    <form action="{{ route('manager.trainees-edit', $trainee->id) }}"
                                                        method="GET">
                                                        @csrf
                                                        <button class="btn btn-success btn-sm" type="submit"
                                                            style="width: 100px; padding: 11px;">
                                                            Edit
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($trainee->trashed())
                                                    <form action="{{ route('manager.activate-trainee', $trainee->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button class="btn btn-success rounded-full btn-hover"
                                                            type="submit" style="width: 100px; padding: 11px;">
                                                            Activate
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('manager.deactivate-trainee', $trainee->id) }}"
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
                                @endif
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center mt-5">
                            {{ $trainees->links() }}
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
@endsection
