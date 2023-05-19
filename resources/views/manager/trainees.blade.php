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
                            <thead class="table-dark">
                                <tr>
                                    <th>Avatar & Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Address</th>
                                    <th>Gender</th>
                                    <th>Is Email Verified?</th>
                                    <th>CV</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($trainees->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-center">No trainees found.</td>
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
                                            <td><a href="{{ $trainee->cv }}">Download
                                                    CV</a></td>
                                            <td><a href="{{ route('manager.trainees-edit', $trainee->id) }}"
                                                    class="btn btn-success">Edit</a>
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
