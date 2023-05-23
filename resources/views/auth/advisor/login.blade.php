@extends('layouts.authLayout')

@section('MainContent')
    <div class="col-lg-5">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header">
                <h3 class="text-center font-weight-light my-4">
                    Login to Advisor Account
                </h3>
            </div>
            <div class="card-body">
                @if (Session::has('message'))
                    <div class="alert alert-info alert-dismissible fade show">
                        {{ Session::get('message') }}
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                @endif
                <form method="POST" action="{{ route('advisor.login') }}">
                    @csrf
                    <div class="form-floating mb-3">
                        <input class="form-control @error('id') is-invalid @enderror" id="id" type="text"
                            name="id" value="{{ old('id') }}" required autocomplete="id" autofocus />
                        <label for="id">Your ID</label>
                        @error('id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control @error('password') is-invalid @enderror" id="password" type="password"
                            name="password" placeholder="Password" required autocomplete="current-password" />
                        <label for="password">Password</label>

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" id="remember" type="checkbox" name="remember"
                            {{ old('remember') ? 'checked' : '' }} />
                        <label class="form-check-label" for="remember">Remember Me</label>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                        <a class="small" href="{{ route('advisor.reset') }}">Forgot Password?</a>
                        <button class="btn btn-success" type="submit">Login</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center py-3">
                <div class="small">
                    <a href="{{ route('advisor.register') }}">Need an account? Sign up!</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://www.gstatic.com/firebasejs/7.14.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.14.0/firebase-auth.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
@endsection
