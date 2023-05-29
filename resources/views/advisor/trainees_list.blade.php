@extends('layouts.advisorLayout')

@section('MainContent')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">My Trainees</h1>
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
                                    <th>CV</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($trainees->isEmpty())
                                    <tr>
                                        <td colspan="7" class="text-center">No trainees found.</td>
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
                                            <td><a href="{{ $trainee->cv }}">Download
                                                    CV</a></td>
                                            <td>
                                                <a href="{{ route('advisor.trainee-details', $trainee->id) }}"
                                                    class="btn btn-sm btn-success">View Details</a>
                                                <a href="{{ route('advisor.send-email', $trainee->id) }}"
                                                    class="btn btn-sm btn-secondary">Send an email</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        @if ($trainees->hasPages())
                            <br>
                        @endif
                        {{ $trainees->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </section>
        </div>
    </main>
@endsection
