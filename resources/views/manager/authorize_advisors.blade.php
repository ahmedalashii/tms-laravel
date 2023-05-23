@extends('layouts.managerLayout')

@section('MainContent')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">Authorize New Advisors</h1>

            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-user me-1"></i>
                        Advisor Information
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <form action="{{ route('manager.authorize-advisors') }}" method="GET">
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
                                    <th>Is Email Verified?</th>
                                    <th>CV</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($advisors->isEmpty())
                                    <tr>
                                        <td colspan="8" class="text-center">No advisors found.</td>
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
                                            <td>{{ ucfirst($advisor->gender) }}</td>
                                            <td class="min-width">
                                                <p>
                                                    @if ($advisor->email_verified ?? false)
                                                        Yes <b style="color: #219653;">&#10003;</b>
                                                    @else
                                                        No <b style="color: #d50100;">&#x2717;</b>
                                                    @endif
                                                </p>
                                            </td>
                                            <td><a href="{{ $advisor->cv }}">Download
                                                    CV</a></td>
                                            <td>
                                                @if ($advisor->email_verified ?? false)
                                                    <form action="{{ route('manager.authorize-advisor', $advisor->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success">Authorize</button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('manager.verify-advisor', $advisor->id) }}"
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
