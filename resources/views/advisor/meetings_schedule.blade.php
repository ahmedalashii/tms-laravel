@extends('layouts.advisorLayout')

@section('MainContent')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">Meetings Schedule</h1>
            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-user me-1"></i>
                        Meetings Schedule
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Trainee Avatar & Name</th>
                                    <th>Email address</th>
                                    <th>Preferred Date</th>
                                    <th>Preferred Time</th>
                                    <th>Location</th>
                                    <th>Notes</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($meetings->isNotEmpty())
                                    @foreach ($meetings as $meeting)
                                        <tr>
                                            <td>
                                                <img src="{{ $meeting->trainee->avatar ?? 'https://www.contentviewspro.com/wp-content/uploads/2017/07/default_image.png' }}"
                                                    class="rounded-circle me-1" width="40px" alt="Trainee's avatar" />
                                                {{ $meeting->trainee->displayName }}
                                            </td>
                                            <td>{{ $meeting->trainee->email }}</td>
                                            <td>{{ $meeting->date }}</td>
                                            <td>{{ Carbon\Carbon::parse($meeting->time)->format('h:i A') }}</td>
                                            <td>{{ $meeting->location }}</td>
                                            <td>{{ $meeting->notes }}</td>
                                            <td>
                                                @if ($meeting->status == 'pending')
                                                    <span
                                                        class="badge bg-warning text-dark">{{ Str::ucfirst($meeting->status) }}</span>
                                                @elseif($meeting->status == 'approved')
                                                    <span
                                                        class="badge bg-success">{{ Str::ucfirst($meeting->status) }}</span>
                                                @elseif($meeting->status == 'rejected' || $meeting->status == 'cancelled')
                                                    <span
                                                        class="badge bg-danger">{{ Str::ucfirst($meeting->status) }}</span>
                                                @else
                                                    <span
                                                        class="badge bg-secondary">{{ Str::ucfirst($meeting->status) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($meeting->status == 'pending')
                                                    <form action="{{ route('advisor.reject-meeting', $meeting->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            style="width: 80px;">Reject
                                                        </button>
                                                    </form>
                                                    <hr>
                                                    <form action="{{ route('advisor.approve-meeting', $meeting->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success"
                                                            style="width: 80px">Approve
                                                        </button>
                                                    </form>
                                                @elseif($meeting->status == 'rejected' || $meeting->status == 'cancelled' || $meeting->status == 'approved')
                                                    <form action="{{ route('advisor.reject-meeting', $meeting->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger" disabled
                                                            style="width: 80px">Reject
                                                        </button>
                                                    </form>
                                                    <hr>

                                                    <form action="{{ route('advisor.approve-meeting', $meeting->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success" disabled
                                                            style="width: 80px">Approve
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7">
                                            <p class="bg-secondary text-white p-2">There are no meetings scheduled. Once a
                                                trainee
                                                schedules a meeting, it will appear here.</p>
                                        </td>
                                @endif
                            </tbody>
                        </table>
                        @if ($meetings->hasPages())
                            <br>
                        @endif
                        {{ $meetings->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </section>
        </div>
    </main>
@endsection
