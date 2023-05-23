@extends('layouts.managerLayout')

@section('MainContent')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4"><span class="text-success">{{ $discipline->name }}</span></h1>
            <form action="{{ route('manager.update-discipline', $discipline->id) }}" method="POST">
                @csrf

                <div class="form-group mb-2">
                    <label for="name">Name <b style="color: #d50100">*</b></label>
                    <input type="text" class="form-control" id="name" value="{{ $discipline->name }}" name="name"
                        required>
                </div>

                <div class="form-group mb-2">
                    <label for="description">Description <b style="color: #d50100">*</b></label>
                    <input type="text" class="form-control" id="description" value="{{ $discipline->description }}"
                        name="description" required>
                </div>

                <div class="d-flex align-items-end pb-2 justify-content-end">
                    <button type="submit" class="btn btn-success pe-4 ps-4">Save</button>
                    <a href="{{ route('manager.disciplines') }}" class="btn btn-danger ms-2">Cancel</a>
                </div>

            </form>
        </div>
    </main>
@endsection
