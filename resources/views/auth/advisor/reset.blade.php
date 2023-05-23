@extends('layouts.authLayout')

@section('MainContent')
    <div class="col-lg-5">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header">
                <h3 class="text-center font-weight-light my-4">Password Recovery</h3>
            </div>
            <div class="card-body">
                @if (Session::has('message'))
                    <div class="alert alert-info alert-dismissible fade show">
                        {{ Session::get('message') }}
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                @endif
                @if (Session::has('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ Session::get('error') }}
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                @endif
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ $error }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endforeach
                @endif

                <div class="small mb-3 text-muted">Enter your Advisor ID and we will send you a link to reset your
                    password.</div>
                <form id="reset-form" action="{{ route('advisor.reset') }}" method="POST">
                    @csrf
                    <div class="form-floating mb-3">
                        <input class="form-control @error('id') is-invalid @enderror" id="id" type="text"
                            name="id" value="{{ old('id') }}" required autocomplete="id" autofocus />
                        <label for="id">Your Advisor ID</label>
                        @error('id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                        <a class="small" href="{{ route('advisor.login') }}">Return to login</a>
                        <button type="submit" class="btn btn-success">
                            Reset
                            Password
                        </button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center py-3">
                <div class="small"><a href="{{ route('advisor.register') }}">Need an account? Sign up!</a></div>
            </div>
        </div>
    </div>
@endsection
