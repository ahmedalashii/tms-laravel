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
    @php
        $trainingProgram = $trainingProgram->load('training_attendances');
    @endphp
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4"><span class="text-success">{{ $trainingProgram->name }}</span></h1>
            <div class="col-12 mt-2">
                @foreach ($errors->all() as $message)
                    <div class="alert alert-danger">{{ $message }}</div>
                @endforeach
            </div>
            <form action="{{ route('manager.update-training-program', $trainingProgram->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="users_length" value="{{ $trainingProgram->users_length }}">

                <div class="form-group mb-2">
                    <label for="banner_input">Banner image</label>
                    <div class="banner_input shadow-sm">
                        <img id="banner_input-image" src="{{ $trainingProgram->thumbnail }}" alt="">
                        <label for="banner_input" class="banner_input-label fs-1">+</label>
                        <input type="file" accept="image/*" class="d-none" id="banner_input" name="thumbnail">
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="name">Name <b style="color: #d50100">*</b></label>
                    <input type="text" class="form-control" id="name" value="{{ $trainingProgram->name }}"
                        name="name" required>
                </div>

                <div class="form-group mb-2">
                    <label for="description">Description <b style="color: #d50100">*</b></label>
                    <input type="text" class="form-control" id="description" value="{{ $trainingProgram->description }}"
                        name="description" required>
                </div>

                <div class="form-group mb-2">
                    <label for="location">Location <b style="color: #d50100">*</b></label>
                    <input type="text" class="form-control" id="description" name="location" required
                        value="{{ $trainingProgram->location }}">
                </div>


                <div class="form-group mb-2">
                    <label for="capacity">Capacity: <b style="color: #d50100">*</b></label>
                    <input class="form-control" type="number" placeholder="Program Capacity"
                        value="{{ $trainingProgram->capacity }}" name="capacity" id="capacity" min="5"
                        max="100" required />
                </div>

                <div class="form-group mb-2">
                    <label for="duration">Duration <b style="color: #d50100">*</b></label>
                    <input type="text" class="form-control" id="duration" value="{{ $trainingProgram->duration }}"
                        name="duration" required>
                </div>

                <div class="form-group mb-2">
                    <label for="gender">Duration Unit: <b style="color: #d50100">*</b></label>
                    <div class="row">
                        <div class="col-md-12">
                            <select class="form-select" aria-label=".form-select-lg example" name="duration_unit" required>
                                <option selected value="">Select Duration Unit</option>
                                @foreach ($duration_units as $key => $duration_unit)
                                    <option value="{{ $key }}" @if ($trainingProgram->duration_unit == $key) selected @endif>
                                        {{ $duration_unit }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-2">
                    <label for="fees">Fees (Leave it blank if it is free) (In USD): </label>
                    <input class="form-control" type="number" placeholder="Program Fees" name="fees"
                        value="{{ $trainingProgram->fees }}" id="fees" />
                </div>

                <div class="form-group mb-2">
                    <label for="start-date">Start Date <b style="color: #d50100">*</b></label>
                    <input type="date" class="form-control" id="start-date" value="{{ $trainingProgram->start_date }}"
                        name="start_date" required>
                </div>

                <div class="form-group mb-2">
                    <label for="end-date">End Date <b style="color: #d50100">*</b></label>
                    <input type="date" class="form-control" id="end-date" value="{{ $trainingProgram->end_date }}"
                        name="end_date" required>
                </div>

                <div class="form-group mb-2">
                    <label for="discipline">Discipline <b style="color: #d50100">*</b></label>
                    <div class="row">
                        <div class="col-md-12">
                            <select class="form-select" aria-label=".form-select-lg example" name="discipline_id"
                                id="discipline" required>
                                <option selected value="">Select Discipline</option>
                                @foreach ($disciplines as $discipline)
                                    <option value="{{ $discipline->id }}"
                                        @if ($trainingProgram->discipline_id == $discipline->id) selected @endif>
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
                                    class="form-check-input" id="day-{{ $day }}"
                                    @if (in_array($day, $trainingProgram->training_attendances->pluck('attendance_day')->toArray())) checked @endif>
                                <label class="form-check-label"
                                    for="day-{{ $day }}">{{ $day }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-group mb-2">
                    <label for="start-time">Start Time <b style="color: #d50100">*</b></label>
                    <input type="time" class="form-control" id="start-time" name="start_time"
                        @if ($trainingProgram->training_attendances->isNotEmpty()) value="{{ $trainingProgram->training_attendances[0]->start_time }}" @endif
                        required>
                </div>

                <div class="form-group mb-2">
                    <label for="end-time">End Time <b style="color: #d50100">*</b></label>
                    <input type="time" class="form-control" id="end-time" name="end_time"
                        @if ($trainingProgram->training_attendances->isNotEmpty()) value="{{ $trainingProgram->training_attendances[0]->end_time }}" @endif
                        required>
                </div>

                <div class="form-group mb-2">
                    <label for="advisor">Advisor </label>
                    <div class="row">
                        <div class="col-md-12">
                            <select class="form-select mb-3" aria-label=".form-select-lg example" name="advisor_id"
                                id="advisor">
                                <option selected value="">Select Advisor</option>
                                @foreach ($advisors as $advisor)
                                    <option value="{{ $advisor->id }}" @if ($trainingProgram->advisor_id == $advisor->id) selected @endif>
                                        {{ $advisor->displayName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-end pb-2 justify-content-end">
                    <button type="submit" class="btn btn-success pe-4 ps-4">Save</button>
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
