@extends('layouts.traineeLayout')

@section('MainContent')
    @php
        $traineeFirbase = Auth::guard('trainee')->user();
        $trainee = \App\Models\Trainee::where('firebase_uid', $traineeFirbase->localId)->first();
        $trainee->load('disciplines');
    @endphp

    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4"><span class="text-success">Edit</span> your profile</h1>
            <div class="row">
                <div class="d-flex align-items-center justify-content-center mb-3">
                    <img src="{{ $trainee->avatar }}" id="user_avatar" class="avatar_img shadow-lg" alt="avatar" />
                </div>
            </div>
            <form class="mt-2 mb-4" method="POST" action="{{ route('trainee.update', $trainee->id) }}"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="avatar_input">Change Avatar</label>
                            <input class="form-control form-control-lg" id="avatar_input" type="file" name="avatar-image"
                                accept="image/*">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="address">Address
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="address" placeholder="Address"
                                value="{{ $trainee->address }}" name="address">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="name">Name
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="name" placeholder="Name"
                                value="{{ $trainee->displayName }}" name="displayName">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="gender">Gender
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-control" id="gender" name="gender">
                                <option value="-1">Select your gender</option>
                                @php
                                    $genders = ['male', 'female'];
                                @endphp
                                @foreach ($genders ?? [] as $gender)
                                    <option value="{{ $gender }}" @if ($trainee->gender == $gender) selected @endif>
                                        {{ ucfirst($gender) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="email">Email address
                                <strong class="text-danger">*</strong>
                            </label>
                            <input type="email" class="form-control" id="email" value="{{ $trainee->email }}"
                                name="email">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="phone">Phone number
                                <strong class="text-danger">*</strong>
                            </label>
                            <input type="text" class="form-control" id="phone" placeholder="Phone number"
                                value="{{ $trainee->phone }}" name="phone">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="disciplines">Select one or more disciplines that you are interested in
                            <strong class="text-danger">*</strong>
                        </label>
                        <br>
                        <div class="form-group">
                            @foreach ($disciplines as $discipline)
                                <div class="form-check">
                                    <input type="checkbox" name="disciplines[]" value="{{ $discipline->id }}"
                                        class="form-check-input" id="discipline-{{ $discipline->id }}"
                                        @if ($trainee->hasDiscipline($discipline->id)) checked @endif>
                                    <label class="form-check-label"
                                        for="discipline-{{ $discipline->id }}">{{ $discipline->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="h-100 d-flex align-items-end pb-2 justify-content-end">
                            <button type="submit" class="btn btn-success pe-4 ps-4">Save</button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="col-12 mt-2">
                @foreach ($errors->all() as $message)
                    <div class="alert alert-danger">{{ $message }}</div>
                @endforeach
            </div>
        </div>
    </main>
@endsection
