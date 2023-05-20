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
                    <form action="./attendance" method="post">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group mt-2">
                            <label for="date_of_attendance">Date of Attendance</label>
                            <input type="date" class="form-control" id="date_of_attendance" name="date_of_attendance"
                                required>
                        </div>
                        <div class="form-group mt-2">
                            <label for="session_or_course_name">Session or Course Name</label>
                            <input type="text" class="form-control" id="session_or_course_name"
                                name="session_or_course_name" required>
                        </div>
                        <div class="form-group mt-2">
                            <label for="any_other_relevant_information">Any other relevant information</label>
                            <textarea class="form-control" id="any_other_relevant_information" name="any_other_relevant_information"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success mt-2">Submit Attendance</button>
                    </form>
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
                                <th scope="col">Date of Attendance</th>
                                <th scope="col">Session or Course Name</th>
                                <th scope="col">Attendance Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2023-05-16</td>
                                <td>Introduction to Programming</td>
                                <td><span class="badge bg-success">Present</span></td>
                            </tr>
                            <tr>
                                <td>2023-05-17</td>
                                <td>Data Structures</td>
                                <td><span class="badge bg-danger">Absent</span></td>
                            </tr>
                            <tr>
                                <td>2023-05-18</td>
                                <td>Algorithms</td>
                                <td><span class="badge bg-success">Present</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>
@endsection
