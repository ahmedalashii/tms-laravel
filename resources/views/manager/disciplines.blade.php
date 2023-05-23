@extends('layouts.managerLayout')

@section('MainContent')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">Disciplines</h1>
            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-user me-1"></i>
                        Discipline Information
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <form method="GET" action="{{ route('manager.disciplines') }}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="search" class="form-control"
                                            placeholder="Search for disciplines" aria-label="Search" name="search"
                                            value="{{ request()->query('search') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <button class="btn btn-dark" type="submit">Search</button>
                                    </div>
                                    <div class="col-md-3 d-flex justify-content-end align-items-end pb-3">
                                        <a class="btn btn-success" href="{{ route('manager.create-discipline') }}">Add New
                                            Discipline</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <table class="table table-striped table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Edit</th>
                                    <th>Activate/Deactivate</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($disciplines->isNotEmpty())
                                    @foreach ($disciplines as $discipline)
                                        <tr>
                                            <td>{{ $discipline->name }}</td>
                                            <td>{{ $discipline->description }}</td>
                                            <td>
                                                @if ($discipline->trashed())
                                                    <button class="btn btn-secondary rounded-full btn-hover"
                                                        style="width: 100px; padding: 11px; cursor: not-allowed !important;"
                                                        disabled>
                                                        Edit
                                                    </button>
                                                @else
                                                    <form action="{{ route('manager.edit-discipline', $discipline->id) }}"
                                                        method="GET">
                                                        <button class="btn btn-success btn-sm" type="submit"
                                                            style="width: 100px; padding: 11px;">
                                                            Edit
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($discipline->trashed())
                                                    <form
                                                        action="{{ route('manager.activate-discipline', $discipline->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button class="btn btn-success rounded-full btn-hover"
                                                            type="submit" style="width: 100px; padding: 11px;">
                                                            Activate
                                                        </button>
                                                    </form>
                                                @else
                                                    <form
                                                        action="{{ route('manager.deactivate-discipline', $discipline->id) }}"
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
                                        <td colspan="4" class="text-center">No Disciplines Found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        @if ($disciplines->hasPages())
                            <br>
                        @endif
                        {{ $disciplines->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </section>
        </div>
    </main>
@endsection
