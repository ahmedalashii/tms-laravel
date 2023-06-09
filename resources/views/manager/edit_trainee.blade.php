@extends('layouts.managerLayout')

@section('MainContent')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4"><span class="text-success">{{ $trainee->displayName }}</span></h1>
            <div class="row">
                <div class="d-flex align-items-center justify-content-center mb-3">
                    <img src="{{ $trainee->avatar }}" id="user_avatar" class="avatar_img shadow-lg" alt="avatar" />
                </div>
            </div>
            <form class="mt-2 mb-4" method="POST" action="{{ route('manager.trainees-update', $trainee->id) }}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="address">Address
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="address" placeholder="Address"
                                value="{{ $trainee->address }}" name="address">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="name">Name
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="name" placeholder="Name"
                                value="{{ $trainee->displayName }}" name="displayName">
                        </div>
                    </div>
                </div>
                <div class="row">
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
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" id="email" value="{{ $trainee->email }}"
                                name="email">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="phone">Phone number</label>
                            <input type="text" class="form-control" id="phone" placeholder="Phone number"
                                value="{{ $trainee->phone }}" name="phone">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="h-100 d-flex align-items-end pb-2 justify-content-end">
                            <button type="submit" class="btn btn-success pe-4 ps-4">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
@endsection
