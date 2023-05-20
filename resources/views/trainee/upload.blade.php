@extends('layouts.traineeLayout')

@section('MainContent')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Upload</h1>

            <form action="./upload-files" method="post" enctype="multipart/form-data" class="mt-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-upload me-1"></i>
                        Upload New File
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="file" class="form-label">File</label>
                            <input class="form-control" type="file" name="file" id="file">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">File Description</label>
                            <input class="form-control" type="text" name="description" id="description"
                                placeholder="File Description">
                        </div>
                        <button type="submit" class="btn btn-success">Upload</button>
                    </div>
                </div>
            </form>

            <section>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-history me-1"></i>
                        Previous uploaded files
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @if ($files->isEmpty())
                            @else
                                @foreach ($files as $file)
                                    <li class="list-group-item">
                                        <a href="{{ $file->url }}" class="list-group-item-action" target="_blank">
                                            <div class="d-flex w-100 justify-content-between">
                                                {{--  A1T8xntf3wQgLWEm5HevpFGtNi82_trainee_avatar_image.jpg  >> Remove based on split the first index --}}
                                                @php
                                                    $file_name = explode('_', $file->name);
                                                    // remove $file_name[0] from $file_name
                                                    $file_name = array_splice($file_name, 1);
                                                    // Convert array to string and capitalize the first letters
                                                    $file_name = implode('_', $file_name);
                                                @endphp
                                                <h5 class="mb-1">{{ $file_name }}</h5>
                                                @php
                                                    $sz = 'BKMGTP';
                                                    $decimals = 2;
                                                    $filesize = $file->size;
                                                    $factor = floor((strlen($filesize) - 1) / 3);
                                                    $size = sprintf("%.{$decimals}f", $filesize / pow(1024, $factor)) . @$sz[$factor] . 'B';
                                                @endphp
                                                <small class="text-muted"> {{ $size }}</small>
                                            </div>
                                            <small
                                                class="text-muted">{{ Carbon\Carbon::parse($file->created_at)->diffForHumans() }}</small>
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                        {{-- if there's pagination  >> do sth --}}
                        @if ($files->hasPages())
                            <br>
                        @endif
                        {{ $files->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </section>
        </div>
    </main>
@endsection
