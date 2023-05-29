@extends('layouts.traineeLayout')

@section('MainContent')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">Training Attendance</h1>
            <section class="card mb-4 mt-4">
                <div class="card-header">
                    <i class="fas fa-calendar-check me-1"></i>
                    Fill in Training Attendance Form
                </div>

                <div class="card-body">
                    <div class="col-12 mt-2">
                        @foreach ($errors->all() as $message)
                            <div class="alert alert-danger">{{ $message }}</div>
                        @endforeach
                    </div>
                    @if ($training_programs->isEmpty())
                        <div class="alert alert-danger"><b style="color: black;">Note: </b> No training programs found to
                            fill in the attendance form. This is
                            because there are no approved training programs that the manager gives you access to.
                        </div>
                    @else
                        <form action="{{ route('trainee.training_attendance') }}" method="POST" id="form">
                            @csrf
                            <div class="form-group mt-2">
                                <label for="training_program">Select Training Program <b style="color: red">*</b></label>
                                <select class="form-select" aria-label=".form-select-lg example" id="training_program"
                                    name="training_program_id">
                                    @foreach ($training_programs as $training_program)
                                        <option value="{{ $training_program->id }}">
                                            {{ $training_program->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mt-2">
                                <label for="training_attendance">Select Attendance Date (For the last 10 days) <b
                                        style="color: red">*</b></label>
                                <select class="form-select" aria-label=".form-select-lg example" id="training_attendance"
                                    name="training_attendance_id">
                                </select>
                            </div>

                            <div class="form-group mt-2">
                                <label for="attendance_status">Select Attendance Status <b style="color: red">*</b></label>
                                <select class="form-select" aria-label=".form-select-lg example" id="attendance_status"
                                    name="attendance_status">
                                    <option value="present">Present</option>
                                    <option value="absent">Absent</option>
                                    <option value="late">Late</option>
                                    <option value="excused">Excused</option>
                                </select>
                            </div>

                            <div class="form-group mt-2">
                                <label for="any_other_relevant_information">Any other relevant information</label>
                                <textarea class="form-control" id="any_other_relevant_information" name="notes"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success mt-2">Submit Attendance</button>
                        </form>
                    @endif

                </div>
            </section>

            <section class="card mb-4 mt-4">
                <div class="card-header">
                    <i class="fas fa-history me-1"></i>
                    Attendance History
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Date/Day of Attendance</th>
                                <th scope="col">Training Program</th>
                                <th scope="col">Attendance Status</th>
                                <th scope="col">Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($attendance_histories->isEmpty())
                                <tr>
                                    <td colspan="4" class="text-center">No attendance found.</td>
                                </tr>
                            @else
                                @foreach ($attendance_histories as $attendance_history)
                                    <tr>
                                        <td> {{ $attendance_history->attendance_date }}
                                            {{ $attendance_history->training_attendance->attendance_day }} </td>
                                        <td>{{ $attendance_history->training_attendance->training_program->name }}</td>
                                        <td>
                                            @if ($attendance_history->attendance_status == 'present')
                                                <span class="badge bg-success" style="color: white;">Present</span>
                                            @elseif ($attendance_history->attendance_status == 'absent')
                                                <span class="badge bg-danger" style="color: white;">Absent</span>
                                            @elseif ($attendance_history->attendance_status == 'late')
                                                <span class="badge bg-warning" style="color: black;">Late</span>
                                            @elseif ($attendance_history->attendance_status == 'excused')
                                                <span class="badge bg-info" style="color: black;">Excused</span>
                                            @else
                                                <span class="badge bg-secondary">Unknown</span>
                                            @endif
                                        </td>
                                        <td>{{ $attendance_history->notes ?? '--' }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    {{ $attendance_histories->links('pagination::bootstrap-5') }}
                </div>
            </section>
        </div>
    </main>
    <script>
        var training_programs = @json($training_programs);

        function formatAMPM(date) {
            var hours = date.getHours();
            var minutes = date.getMinutes();
            var ampm = hours >= 12 ? 'pm' : 'am';
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            minutes = minutes < 10 ? '0' + minutes : minutes;
            var strTime = hours + ':' + minutes + ' ' + ampm;
            return strTime;
        }

        window.onload = function() {
            var training_program = document.getElementById('training_program');
            var training_attendance_element = document.getElementById('training_attendance');
            // The first training program is selected by default
            if (training_programs.length > 0) {
                var training_attendances = training_programs[0].training_attendances;
                var latest_15_days = [];
                var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday',
                    'Saturday'
                ];
                training_attendances.forEach(training_attendance => {
                    // I need the last 15 days only that matches the attendance_day >> Ex: Sunday, Monday, Tuesday, etc.
                    var attendance_day = training_attendance.attendance_day;
                    var today = new Date();
                    for (var i = 0; i < 15; i++) {
                        var day = new Date(today);
                        day.setDate(day.getDate() - i);
                        // to iso date
                        day = new Date(day.toISOString().slice(0, 10));
                        if (days[day.getDay()] == attendance_day) {
                            latest_15_days.push(day);
                        }
                    }
                    // remove where days[day.getDay()] == attendance_day
                    latest_15_days = latest_15_days.filter(day => days[day.getDay()] == attendance_day);
                    // Sort the days in ascending order
                    latest_15_days.sort(function(a, b) {
                        return a - b;
                    });
                    // Each day has to be added as an option
                    latest_15_days.forEach(day => {
                        var option = document.createElement('option');
                        option.value = training_attendance.id;
                        option.innerHTML = day.toISOString().slice(0, 10);
                        var dayOfWeek = day.getDay();
                        option.innerHTML += ' ' + ['Sunday', 'Monday', 'Tuesday',
                            'Wednesday',
                            'Thursday',
                            'Friday', 'Saturday'
                        ][dayOfWeek] + ': From ';
                        var start_time = formatAMPM(new Date(day.toISOString().slice(0,
                                10) + 'T' +
                            training_attendance.start_time));
                        option.innerHTML += ' ' + start_time + ' to ';
                        var end_time = formatAMPM(new Date(day.toISOString().slice(0, 10) +
                            'T' +
                            training_attendance
                            .end_time));
                        option.innerHTML += ' ' + end_time;
                        training_attendance_element.appendChild(option);
                    });
                });
                // Sort the options in ascending order based on the text
                var options = training_attendance_element.options;
                var options_array = [];
                for (var i = 0; i < options.length; i++) {
                    options_array.push({
                        value: options[i].value,
                        text: options[i].text
                    });
                }
                options_array.sort(function(a, b) {
                    if (a.text < b.text) return -1;
                    else if (a.text > b.text) return 1;
                    else return 0;
                });
                for (var i = 0; i < options.length; i++) {
                    options[i].value = options_array[i].value;
                    options[i].text = options_array[i].text;
                }
                // Get the form element of "form" id
                var form = document.getElementById('form');
                // Get the selected option
                var selected_option = training_attendance_element.options[
                    training_attendance_element.selectedIndex];
                // Get the text of the selected option
                var selected_option_text = selected_option.text;
                // Split the text by spaces
                var splitted_text = selected_option_text.split(' ');
                // Get the date from the splitted text
                var date = splitted_text[0];
                // Create or update a hidden input with the name "date" and the value of the date
                var hidden_input = document.querySelector('input[name="date"]');
                if (hidden_input) {
                    hidden_input.value = date;
                } else {
                    var input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'date';
                    input.value = date;
                    form.appendChild(input);
                }
            }
            training_program.addEventListener('change', function() {
                var selected_training_program = training_program.value;
                var training_attendances = training_programs.find(training_program => training_program.id ==
                    selected_training_program).training_attendances;
                training_attendance.innerHTML = '';

                var latest_15_days = [];
                var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday',
                    'Saturday'
                ];
                training_attendances.forEach(training_attendance => {
                    // I need the last 10 days only that matches the attendance_day >> Ex: Sunday, Monday, Tuesday, etc.
                    var attendance_day = training_attendance.attendance_day;
                    var today = new Date();
                    for (var i = 0; i < 15; i++) {
                        var day = new Date(today);
                        day.setDate(day.getDate() - i);
                        // to iso date
                        day = new Date(day.toISOString().slice(0, 10));
                        if (days[day.getDay()] == attendance_day) {
                            latest_15_days.push(day);
                        }
                    }
                    // remove where days[day.getDay()] == attendance_day
                    latest_15_days = latest_15_days.filter(day => days[day.getDay()] == attendance_day);
                    // Sort the days in ascending order
                    latest_15_days.sort(function(a, b) {
                        return a - b;
                    });
                    // Each day has to be added as an option
                    latest_15_days.forEach(day => {
                        var option = document.createElement('option');
                        option.value = training_attendance.id;
                        option.innerHTML = day.toISOString().slice(0, 10);
                        var dayOfWeek = day.getDay();
                        option.innerHTML += ' ' + ['Sunday', 'Monday', 'Tuesday',
                            'Wednesday',
                            'Thursday',
                            'Friday', 'Saturday'
                        ][dayOfWeek] + ': From ';
                        var start_time = formatAMPM(new Date(day.toISOString().slice(0,
                                10) + 'T' +
                            training_attendance.start_time));
                        option.innerHTML += ' ' + start_time + ' to ';
                        var end_time = formatAMPM(new Date(day.toISOString().slice(0, 10) +
                            'T' +
                            training_attendance
                            .end_time));
                        option.innerHTML += ' ' + end_time;
                        training_attendance_element.appendChild(option);
                    });
                });
                // Sort the options in ascending order based on the text
                var options = training_attendance_element.options;
                var options_array = [];
                for (var i = 0; i < options.length; i++) {
                    options_array.push({
                        value: options[i].value,
                        text: options[i].text
                    });
                }
                options_array.sort(function(a, b) {
                    if (a.text < b.text) return -1;
                    else if (a.text > b.text) return 1;
                    else return 0;
                });
                for (var i = 0; i < options.length; i++) {
                    options[i].value = options_array[i].value;
                    options[i].text = options_array[i].text;
                }
            });
            // Listen to the selection of the training attendance and insert a hidden input with the date splitted from the text like this : "2023-05-16 Tuesday: From 12:52 pm to 1:52 pm" >> "2023-05-16"
            training_attendance_element.addEventListener('change', function() {
                // Get the form element of "form" id
                var form = document.getElementById('form');
                // Get the selected option
                var selected_option = training_attendance_element.options[
                    training_attendance_element.selectedIndex];
                // Get the text of the selected option
                var selected_option_text = selected_option.text;
                // Split the text by spaces
                var splitted_text = selected_option_text.split(' ');
                // Get the date from the splitted text
                var date = splitted_text[0];
                // Create or update a hidden input with the name "date" and the value of the date
                var hidden_input = document.querySelector('input[name="date"]');
                if (hidden_input) {
                    console.log("hidden input exists and the value is updated to " + date);
                    hidden_input.value = date;
                } else {
                    var input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'date';
                    input.value = date;
                    form.appendChild(input);
                }
            });
        }
    </script>
@endsection
