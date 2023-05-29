@extends('layouts.traineeLayout')

@section('MainContent')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">Sent Emails</h1>
            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-user me-1"></i>
                        Sent Emails to Advisors
                    </div>
                    <div class="d-grid gap-0 d-md-flex justify-content-md-end">
                        <a href="{{ route('trainee.send-email-form') }}"> <button class="btn btn-success me-3 mt-2"
                                type="button">Send a new email</button> </a>
                    </div>

                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Advisor Name & Avatar</th>
                                    <th>Email address</th>
                                    <th>Subject</th>
                                    <th>Message</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($sent_emails->isEmpty())
                                    <tr>
                                        <td colspan="4" class="text-center">No sent emails found.</td>
                                    </tr>
                                @else
                                    @foreach ($sent_emails as $email)
                                        <tr>
                                            <td>
                                                <img src="{{ $email->advisor->avatar }}" class="rounded-circle me-1"
                                                    width="37px" height="40px"
                                                    alt="{{ $email->advisor->displayName }}'s avatar" />
                                                {{ $email->advisor->displayName }}
                                            </td>
                                            <td>{{ $email->advisor->email }}</td>
                                            <td>{{ $email->subject }}</td>
                                            <td>{{ $email->message }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        @if ($sent_emails->hasPages())
                            <br>
                        @endif
                        {{ $sent_emails->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </section>
        </div>
    </main>
@endsection
