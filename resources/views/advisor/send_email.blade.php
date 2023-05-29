@extends('layouts.advisorLayout')

@section('MainContent')
    <main>
        <div class="container-fluid px-4">
            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-reply me-1"></i>
                        Send Email to Trainee
                    </div>
                    <form action="{{ route('advisor.send-email', $trainee->id) }}" class="card-body" id="send-email-form" method="POST">
                        @csrf
                        <div class="form-group mb-2">
                            <label for="to">To (Trainee Email) <b class="text-danger">*</b></label>
                            <input type="text" class="form-control" id="to" value=" {{ $trainee->email }}"
                                disabled required name="email">
                        </div>
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
