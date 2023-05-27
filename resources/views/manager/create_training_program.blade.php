<style>
    /* banner input */
    .banner_input {
        min-width: 350px;
        max-width: 500px;
        width: 30%;
        height: 200px;
        border-radius: 4px;
        background-color: #CCC;
        position: relative;
    }

    #banner_input-image,
    .banner_input-label {
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 4px;
        cursor: pointer;
    }

    #banner_input-image {
        z-index: 5;
        object-fit: cover;
    }

    .banner_input-label {
        z-index: 4;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .banner_input:has(#banner_input-image:hover) .banner_input-label,
    .banner_input-label:hover {
        z-index: 6;
        background-color: #CCC;
        opacity: 0.8;
    }

    .banner_input #banner_input-image[src=""] {
        display: none;
    }

    @media(max-width:720px) {
        .banner_input {
            max-width: unset;
            width: 100%;
        }
    }
</style>

@extends('layouts.managerLayout')

@section('MainContent')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4"><span class="text-success">Create New Training Program</span></h1>
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
            <form class="mt-2 mb-4" action="{{ route('manager.store-training-program') }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-2">
                    <label for="banner_input">Banner image <b style="color: #d50100">*</b></label>
                    <div class="banner_input shadow-sm">
                        <img id="banner_input-image" src="" alt="">
                        <label for="banner_input" class="banner_input-label fs-1">+</label>
                        <input type="file" accept="image/*" class="d-none" id="banner_input" name="thumbnail" required>
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
                    <label for="location">Location <b style="color: #d50100">*</b></label>
                    <input type="text" class="form-control" id="description" name="location" required>
                </div>

                <div class="form-group mb-2">
                    <label for="capacity">Capacity: <b style="color: #d50100">*</b></label>
                    <input class="form-control" type="number" placeholder="Program Capacity" value="5" name="capacity"
                        id="capacity" min="5" max="100" required />
                </div>

                <div class="form-group mb-2">
                    <label for="duration">Duration: <b style="color: #d50100">*</b></label>
                    <input class="form-control" type="number" placeholder="Program Duration" value="1" name="duration"
                        id="duration" min="1" required />
                </div>

                <div class="form-group mb-2">
                    <label for="gender">Duration Unit: <b style="color: #d50100">*</b></label>
                    <div class="row">
                        <div class="col-md-12">
                            <select class="form-select" aria-label=".form-select-lg example" name="duration_unit" required>
                                <option selected value="">Select Duration Unit</option>
                                @foreach ($duration_units as $key => $duration_unit)
                                    <option value="{{ $key }}">
                                        {{ $duration_unit }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-2">
                    <label for="fees">Fees (Leave it blank if it is free) (In USD): </label>
                    <input class="form-control" type="number" placeholder="Program Fees" value="" name="fees"
                        min="1" id="fees" />
                </div>

                <div class="form-group mb-2">
                    <label for="start-date">Start Date <b style="color: #d50100">*</b></label>
                    <input type="date" class="form-control" id="start-date" name="start_date" required>
                </div>

                <div class="form-group mb-2">
                    <label for="end-date">End Date <b style="color: #d50100">*</b></label>
                    <input type="date" class="form-control" id="end-date" name="end_date" required>
                </div>

                <div class="form-group mb-2">
                    <label for="discipline">Discipline <b style="color: #d50100">*</b></label>
                    <div class="row">
                        <div class="col-md-12">
                            <select class="form-select" aria-label=".form-select-lg example" name="discipline_id"
                                id="discipline" required>
                                <option selected value="">Select Discipline</option>
                                @foreach ($disciplines as $discipline)
                                    <option value="{{ $discipline->id }}">
                                        {{ $discipline->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-2">
                    <label for="days">Select one or attendance days <b style="color: #d50100">*</b></label>
                    <strong class="text-danger">*</strong>
                    </label>
                    <div class="form-group">
                        @php
                            $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                        @endphp
                        @foreach ($days as $day)
                            <div class="form-check">
                                <input type="checkbox" name="attendance_days[]" value="{{ $day }}"
                                    class="form-check-input" id="day-{{ $day }}">
                                <label class="form-check-label" for="day-{{ $day }}">{{ $day }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-group mb-2">
                    <label for="start-time">Start Time <b style="color: #d50100">*</b></label>
                    <input type="time" class="form-control" id="start-time" name="start_time" required>
                </div>

                <div class="form-group mb-2">
                    <label for="end-time">End Time <b style="color: #d50100">*</b></label>
                    <input type="time" class="form-control" id="end-time" name="end_time" required>
                </div>

                <div class="form-group mb-2">
                    <label for="advisor">Advisor </label>
                    <div class="row">
                        <div class="col-md-12">
                            <select class="form-select mb-3" aria-label=".form-select-lg example" name="advisor_id"
                                id="advisor">
                                <option selected value="">Select Advisor</option>
                                @foreach ($advisors as $advisor)
                                    <option value="{{ $advisor->id }}">
                                        {{ $advisor->displayName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-end pb-2 justify-content-end">
                    <button type="submit" class="btn btn-success pe-4 ps-4">Create</button>
                    <a href="{{ route('manager.training-programs') }}" class="btn btn-danger ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </main>

    <script>
        // change banner image
        const bannerInput = document.getElementById("banner_input");
        const bannerImage = document.getElementById("banner_input-image");
        if (bannerInput && bannerImage) {
            bannerInput.addEventListener('change', (e) => {
                const reader = new FileReader();
                reader.onload = () => {
                    const base64 = reader.result;
                    bannerImage.src = base64;
                };

                reader.readAsDataURL(bannerInput.files[0]);
            })
        }
    </script>
@endsection
