@extends('layouts.managerLayout')

@section('MainContent')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">Advisors</h1>
            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-user me-1"></i>
                        Advisor Information
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <form action="{{ route('manager.advisors') }}" method="GET">
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
                                    <th>Is Authorized?</th>
                                    <th>CV</th>
                                    {{-- <th>Edit</th> --}}
                                    <th>Activate/Deactivate</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($advisors->isEmpty())
                                    <tr>
                                        <td colspan="9" class="text-center">No advisors found.</td>
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
                                            <td class="min-width">
                                                <p>
                                                    @if ($advisor->email_verified ?? false)
                                                        Yes <b style="color: #219653;">&#10003;</b>
                                                    @else
                                                        No <b style="color: #d50100;">&#x2717;</b>
                                                    @endif
                                                </p>
                                            </td>
                                            <td class="min-width">
                                                <p>
                                                    @if ($advisor->auth_id ?? false)
                                                        Yes <b style="color: #219653;">&#10003;</b>
                                                    @else
                                                        No <b style="color: #d50100;">&#x2717;</b>
                                                    @endif
                                                </p>
                                            <td><a href="{{ $advisor->cv }}">Download
                                                    CV</a></td>
                                            {{-- <td>
                                                @if ($advisor->trashed())
                                                    <button class="btn btn-secondary rounded-full btn-hover"
                                                        style="width: 100px; padding: 11px; cursor: not-allowed !important;"
                                                        disabled>
                                                        Edit
                                                    </button>
                                                @else
                                                    <form action="{{ route('manager.advisor-edit', $advisor->id) }}"
                                                        method="GET">
                                                        @csrf
                                                        <button class="btn btn-success btn-sm" type="submit"
                                                            style="width: 100px; padding: 11px;">
                                                            Edit
                                                        </button>
                                                    </form>
                                                @endif
                                            </td> --}}
                                            <td>
                                                @if ($advisor->trashed())
                                                    <form action="{{ route('manager.activate-advisor', $advisor->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button class="btn btn-success rounded-full btn-hover"
                                                            type="submit" style="width: 100px; padding: 11px;">
                                                            Activate
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('manager.deactivate-advisor', $advisor->id) }}"
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
