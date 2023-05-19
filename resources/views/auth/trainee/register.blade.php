@extends('layouts.authLayout')

@section('MainContent')
    <div class="col-lg-7">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header">
                <h3 class="text-center font-weight-light my-4">Create Trainee Account</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    @if (Session::has('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ Session::get('error') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif

                    <div class="col-12 mt-2">
                        @foreach ($errors->all() as $message)
                            <div class="alert alert-danger">{{ $message }}</div>
                        @endforeach
                    </div>
                </div>
                <form action="{{ route('trainee.register') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input class="form-control @error('name') is-invalid @enderror" id="name"
                                    type="text" name="name" required autocomplete="name" autofocus
                                    value="{{ old('name') }}" />
                                <label for="name">Name
                                    <strong class="text-danger">*</strong>

                                </label>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control @error('email') is-invalid @enderror" id="email" type="email"
                            name="email" value="{{ old('email') }}" required autocomplete="email" />
                        <label for="email">Email address
                            <strong class="text-danger">*</strong>

                        </label>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="phone" type="phone" placeholder="+972 XX XXX XXX XXXX"
                            name="phone" required />
                        <label for="phone">Phone number
                            <strong class="text-danger">*</strong>
                        </label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="address" type="text" placeholder="Address" name="address"
                            required />
                        <label for="address">Address
                            <strong class="text-danger">*</strong>
                        </label>
                    </div>
                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" id="gender"
                        name="gender" required>
                        <option value="-1">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div>
                                <label for="avatar-image" class="form-label">You avatar image
                                    <strong class="text-danger">*</strong>
                                </label>
                                <input class="form-control form-control-lg" id="avatar-image" type="file"
                                    name="avatar-image" accept="image/*" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div>
                                <label for="cv-file" class="form-label">Your CV
                                    <strong class="text-danger">*</strong>
                                </label>
                                <input class="form-control form-control-lg" id="cv-file" name="cv-file" type="file"
                                    accept=".pdf,.docx,.doc" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div>
                            <div class="form-floating mb-3 mb-md-0">
                                <input class="form-control @error('password') is-invalid @enderror" id="password"
                                    type="password" name="password" required autocomplete="new-password" />
                                <label for="password">Password
                                    <strong class="text-danger">*</strong>
                                </label>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="form-floating mb-3 mb-md-0">
                                <input class="form-control" id="password-confirm" type="password"
                                    name="password_confirmation" required autocomplete="new-password" />
                                <label for="password-confirm">Confirm Password
                                    <strong class="text-danger">*</strong>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 mb-0">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-block">
                                Create Account
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center py-3">
                <div class="small"><a href="{{ route('trainee.login') }}">Have an account? Go to login</a></div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
@endsection
