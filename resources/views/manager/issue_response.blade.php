@extends('layouts.managerLayout')

@section('MainContent')
    <main>
        <div class="container-fluid px-4">
            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-reply me-1"></i>
                        Response on Issue <b><span class="text-success">"Issue title"</span></b> by
                        <b><span class="text-success">"Issue sender"</span></b>
                    </div>
                    <form action="" class="card-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title">
                        </div>
                        <div class="form-group mt-2">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" style="min-height: 150px;"></textarea>
                        </div>
                        <div class="form-group mt-2">
                            <button type="submit" class="btn btn-success">Response</button>
                        </div>
                    </form>
                </div>
            </section>

        </div>
    </main>
@endsection
