@extends('layouts.managerLayout')

@section('MainContent')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">Authorize New Trainees</h1>

            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-user me-1"></i>
                        Trainee Information
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <form action="{{ route('manager.authorize-trainees') }}" method="GET">
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
                                    <th>CV</th>
                                    <th>Authorize</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($trainees->isEmpty())
                                    <tr>
                                        <td colspan="8" class="text-center">No trainees found.</td>
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
                                            <td>{{ ucfirst($trainee->gender) }}</td>
                                            <td class="min-width">
                                                <p>
                                                    @if ($trainee->email_verified ?? false)
                                                        Yes <b style="color: #219653;">&#10003;</b>
                                                    @else
                                                        No <b style="color: #d50100;">&#x2717;</b>
                                                    @endif
                                                </p>
                                            </td>
                                            <td><a href="{{ $trainee->cv }}">Download
                                                    CV</a></td>
                                            <td>
                                                @if ($trainee->email_verified ?? false)
                                                    <form action="{{ route('manager.authorize-trainee', $trainee->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success">Authorize</button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('manager.verify-trainee', $trainee->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success">
                                                            Send Verification Email
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
