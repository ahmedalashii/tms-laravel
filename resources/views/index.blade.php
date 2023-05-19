@extends('layouts.authLayout')

@section('MainContent')
    <div class="col-lg-5">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header">
                <h3 class="text-center font-weight-light my-4">
                    You want to login as?
                </h3>
            </div>
            <div class="card-body">
                <div class="card bg-success text-white mb-2">
                    <div class="card-body">Trainee user</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('trainee.login') }}">Go to
                            login page</a>
                        <div class="small text-white">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                </div>
                <div class="card bg-success text-white mb-2">
                    <div class="card-body">Manager user</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href=" {{ route('manager.login') }}">Go to
                            login page</a>
                        <div class="small text-white">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                </div>
                <div class="card bg-success text-white mb-2">
                    <div class="card-body">Advisor user</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href=" {{ route('advisor.login') }}">Go to
                            login page</a>
                        <div class="small text-white">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
