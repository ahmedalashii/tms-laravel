@extends('layouts.traineeLayout')

@section('MainContent')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">My Advisors</h1>
            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-user me-1"></i>
                        Advisor Information
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <form action="{{ route('trainee.advisors-list') }}" method="GET">
                                <div class="row">
                                    <div class="col-md-11">
                                        <input type="search" class="form-control" placeholder="Search for advisors"
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
                                @if ($advisors->isEmpty())
                                    <tr>
                                        <td colspan="7" class="text-center">No advisors found.</td>
                                    </tr>
                                @else
                                    @foreach ($advisors as $advisor)
                                        <tr>
                                            <td>
                                                <img src="{{ $advisor->avatar }}" class="rounded-circle me-1" width="37px"
                                                    height="40px" alt="{{ $advisor->displayName }}'s avatar" />
                                                {{ $advisor->displayName }}
                                            </td>
                                            <td>{{ $advisor->email }}</td>
                                            <td>{{ $advisor->phone }}</td>
                                            <td>{{ $advisor->address }}</td>
                                            <td>{{ Str::ucfirst($advisor->gender) }}</td>
                                            <td><a href="{{ $advisor->cv }}">See
                                                    CV</a></td>
                                            <td>
                                                <a href="{{ route('trainee.advisor-details', $advisor->id) }}"
                                                    class="btn btn-sm btn-success">View Details</a>
                                                <form action="{{ route('trainee.send-email-form', $advisor->id) }}"
                                                    method="GET" class="d-inline">
                                                    @csrf
                                                    <a href="$"
                                                        class="btn btn-sm btn-secondary"
                                                        onclick="event.preventDefault(); this.closest('form').submit();">Send
                                                        Email</a>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        @if ($advisors->hasPages())
                            <br>
                        @endif
                        {{ $advisors->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </section>
        </div>
    </main>
@endsection
