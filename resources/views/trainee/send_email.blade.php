@extends('layouts.traineeLayout')

@section('MainContent')
    <main>
        <div class="container-fluid px-4">
            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-reply me-1"></i>
                        Send Email to Advisor
                    </div>

                    <form action="{{ route('trainee.send-email') }}" class="card-body" id="send-email-form" method="POST">
                        @csrf
                        <div class="col-12 mt-2">
                            @foreach ($errors->all() as $message)
                                <div class="alert alert-danger">{{ $message }}</div>
                            @endforeach
                        </div>
                        @if ($advisor ?? false)
                            <div class="form-group mb-2">
                                <label for="to">To (Advisor Email) <b class="text-danger">*</b></label>
                                <input type="email" class="form-control" id="to" name="email"
                                    value="{{ $advisor->email ?? '' }}" readonly>
                            </div>
                        @else
                            <div class="form-group mb-2">
                                <label for="to">To (Advisor Email) <b class="text-danger">*</b></label>
                                <select class="form-control" name="email" id="to" required>
                                    <option value="">Select an advisor</option>
                                    @foreach ($advisors as $advisor)
                                        <option value="{{ $advisor->email }}">{{ $advisor->displayName }}:
                                            {{ $advisor->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="subject">Subject <b class="text-danger">*</b></label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                        </div>
                        <div class="form-group mt-2">
                            <label for="message">Message Content <b class="text-danger">*</b></label>
                            <textarea class="form-control" id="message" style="min-height: 150px;" required name="message"></textarea>
                        </div>
                        <div class="form-group mt-2">
                            <button type="submit" class="btn btn-success">Send Email</button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </main>
@endsection
