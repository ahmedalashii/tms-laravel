@extends('layouts.traineeLayout')

@section('MainContent')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">Request a Meeting with Advisor</h1>


            <!-- PAGE CONTENT -->
            <!-- section template -->
            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-clock me-1"></i>
                        Schedule a Meeting
                    </div>
                    <div class="card-body">
                        <form action="./meetings" method="post">
                            <div class="mb-3">
                                <label for="advisor" class="form-label">Advisor</label>
                                <select class="form-control" name="advisor">
                                    <option value="">Select an advisor</option>
                                    <option value="1">Advisor 1</option>
                                    <option value="2">Advisor 2</option>
                                    <option value="3">Advisor 3</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control" name="date">
                            </div>
                            <div class="mb-3">
                                <label for="time" class="form-label">Time</label>
                                <input type="time" class="form-control" name="time">
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" class="form-control" name="subject">
                            </div>
                            <button type="submit" class="btn btn-success">Request meeting</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </main>
@endsection
