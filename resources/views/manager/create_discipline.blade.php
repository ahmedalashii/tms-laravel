@extends('layouts.managerLayout')

@section('MainContent')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4 mb-4"><span class="text-success">Create New Discipline</span></h1>
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
        <form class="mt-2 mb-4" action="{{ route('manager.store-discipline') }}" method="POST">
            @csrf
        
            <div class="form-group mb-2">
                <label for="name">Name <b style="color: #d50100">*</b></label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="form-group mb-2">
                <label for="description">Description <b style="color: #d50100">*</b></label>
                <input type="text" class="form-control" id="description" name="description" required>
            </div>

            <div class="d-flex align-items-end pb-2 justify-content-end">
                <button type="submit" class="btn btn-success pe-4 ps-4">Create</button>
                <a href="{{ route('manager.disciplines') }}" class="btn btn-danger ms-2">Cancel</a>
            </div>
        </form>
    </div>
</main>
@endsection