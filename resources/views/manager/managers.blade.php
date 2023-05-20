@extends('layouts.managerLayout')

@section('MainContent')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">Managers</h1>
            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-user me-1"></i>
                        Manager Information
                    </div>
                    <div class="card-body">
                        <form action="{{ route('manager.managers') }}" method="GET">
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
                        <table class="table table-striped table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Name</th>
                                    <th>Email address</th>
                                    <th>Address</th>
                                    <th>Phone Number</th>
                                    <th>Activate/Deactivate</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($managers->isEmpty())
                                    <tr>
                                        <td colspan="10" class="text-center">No trainees found.</td>
                                    </tr>
                                @else
                                    @foreach ($managers as $manager)
                                        <tr>
                                            <td>{{ $manager->displayName }}</td>
                                            <td>{{ $manager->email }}</td>
                                            <td>{{ $manager->address }}</td>
                                            <td>{{ $manager->phone }}</td>
                                            <td>
                                                <form method="POST"
                                                    action="@if ($manager->is_active ?? false) {{ route('manager.deactivate-manager', $manager->id) }} @else {{ route('manager.activate-manager', $manager->id) }} @endif">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $manager->id }}" />
                                                    <button type="submit"
                                                        class="btn @if ($manager->is_active ?? false) btn-danger @else btn-success @endif">
                                                        @if ($manager->is_active ?? false)
                                                            Deactivate
                                                        @else
                                                            Activate
                                                        @endif
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </main>
@endsection
