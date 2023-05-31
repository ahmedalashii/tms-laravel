@extends('layouts.traineeLayout')

@section('MainContent')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">Request a Meeting with Advisor</h1>
            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-clock me-1"></i>
                        Schedule a Meeting
                    </div>
                    <div class="card-body">
                        <div class="col-12 mt-2">
                            @foreach ($errors->all() as $message)
                                <div class="alert alert-danger">{{ $message }}</div>
                            @endforeach
                        </div>
                        <form action="{{ route('trainee.schedule-meeting') }}" method="POST">
                            @csrf
                            @if ($advisors->isEmpty())
                                <div class="alert alert-danger"><b style="color: black;">Note: </b> No advisors found to
                                    schedule a meeting with. This is
                                    because there are no approved training programs that has an advisor assigned to it.
                                </div>
                            @endif
                            <div class="mb-3">
                                <label for="advisor" class="form-label">Advisor <b class="text-danger">*</b></label>
                                <select class="form-control" name="advisor">
                                    <option value="">Select an advisor</option>
                                    @foreach ($advisors as $advisor)
                                        <option value="{{ $advisor->id }}" @if (old('advisor') == $advisor->id) selected @endif
                                            
                                            >{{ $advisor->displayName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Preferred Date <b class="text-danger">*</b></label>
                                <input type="date" class="form-control" name="date" min="{{ Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ old('date') }}">
                            </div>
                            <div class="mb-3">
                                <label for="time" class="form-label">Preferred Time <b class="text-danger">*</b></label>
                                <input type="time" class="form-control" name="time" min="{{ date('H:i') }}" value="{{ old('time') }}">
                            </div>
                            <div class="mb-3">
                                <label for="location" class="form-label">Location <b class="text-danger">*</b></label>
                                <input type="text" class="form-control" name="location" value="{{ old('location') }}">
                            </div>

                            <div class="mb-3">
                                <label for="notes">Notes (optional)</label>
                                <textarea class="form-control" id="notes" name="notes"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success">Request meeting</button>
                        </form>
                    </div>
                </div>
            </section>

            {{-- Section for all requested meetings --}}

            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-clock me-1"></i>
                        All Requested Meetings
                    </div>
                    <div class="card-body">
                        @if ($meetings->isEmpty())
                            <div class="alert alert-danger"><b style="color: black;">Note: </b> No meetings found.</div>
                        @else
                            <table class="table table-striped table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Advisor</th>
                                        <th>Preferred Date</th>
                                        <th>Preferred Time</th>
                                        <th>Location</th>
                                        <th>Notes</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($meetings as $meeting)
                                        <tr>
                                            <td>{{ $meeting->advisor->displayName }}</td>
                                            <td>{{ $meeting->date }}</td>
                                            <td>{{ Carbon\Carbon::parse($meeting->time)->format('h:i A') }}</td>
                                            <td>{{ $meeting->location }}</td>
                                            <td>{{ $meeting->notes }}</td>
                                            <td>{{ Str::ucfirst($meeting->status) }}</td>
                                            <td>
                                                @if ($meeting->status == 'pending')
                                                    <form action="{{ route('trainee.cancel-meeting', $meeting->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger">Cancel
                                                            Meeting</button>
                                                    </form>
                                                @else
                                                    <button class="btn btn-sm btn-secondary" disabled>Cancel
                                                        Meeting</button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </section>
        </div>
    </main>
@endsection
