@extends('layouts.advisorLayout')

@section('MainContent')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4"><span class="text-success">Create a new task</span></h1>
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
            @if ($training_programs->isEmpty())
                <div class="alert alert-danger">You are not assigned to any training program. Please wait for the admin to
                    assign you to a training program.</div>
            @else
                <form class="mt-2 mb-4" action="{{ route('advisor.create-task') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-2">
                        <label for="training-program">Training Program <b style="color: #d50100">*</b></label>
                        <div class="row">
                            <div class="col-md-12">
                                <select class="form-select" aria-label=".form-select-lg example" name="training_program_id"
                                    id="training-program" required>
                                    <option selected value="">Select a training program</option>
                                    @foreach ($training_programs as $training_program)
                                        <option value="{{ $training_program->id }}">{{ $training_program->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-2">
                        <label for="name">Name <b style="color: #d50100">*</b></label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="form-group mb-2">
                        <label for="description">Description <b style="color: #d50100">*</b></label>
                        <input type="text" class="form-control" id="description" name="description" required>
                    </div>


                    <div class="form-group mb-2">
                        <label for="due-date">End Date <b style="color: #d50100">*</b></label>
                        <input type="date" class="form-control" id="end-date" name="end_date" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div>
                                <label for="file" class="form-label">File representing the task (optional)
                                </label>
                                <input class="form-control form-control-lg" id="file" type="file" name="file"
                                    accept="*/*">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-end pb-2 justify-content-end">
                        <button type="submit" class="btn btn-success pe-4 ps-4">Create</button>
                    </div>
                </form>
            @endif
        </div>
    </main>
@endsection
