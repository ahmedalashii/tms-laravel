@extends('layouts.managerLayout')

@section('MainContent')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4"><span class="text-success">Create new training program</span></h1>
            <form action="" class="mt-2 mb-4">
                <div class="form-group mb-2">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name">
                </div>

                <div class="form-group mb-2">
                    <label for="description">Description</label>
                    <input type="email" class="form-control" id="description">
                </div>

                <div class="form-group mb-2">
                    <label for="duration">Duration</label>
                    <input type="text" class="form-control" id="duration">
                </div>

                <div class="form-group mb-2">
                    <label for="start-date">Start Date</label>
                    <input type="date" class="form-control" id="start-date">
                </div>

                <div class="form-group mb-2">
                    <label for="end-date">End Date</label>
                    <input type="date" class="form-control" id="end-date">
                </div>

                <div class="form-group mt-3 mb-2">
                    <label for="gender">Discipline</label>
                    <select class="form-select mb-3" aria-label=".form-select-lg example">
                        <option value="Web Development">Web Development</option>
                        <option value="Mobile Development">Mobile Development</option>
                        <option value="Software Development">Software Development</option>
                        <option value="Database Administration">Database Administration</option>
                        <option value="Data Science">Data Science</option>
                        <option value="Artificial Intelligence">Artificial Intelligence</option>
                        <option value="Machine Learning">Machine Learning</option>
                        <option value="Cyber Security">Cyber Security</option>
                        <option value="Cloud Computing">Cloud Computing</option>
                        <option value="Network Administration">Network Administration</option>
                        <option value="Game Development">Game Development</option>
                        <option value="DevOps">DevOps</option>
                    </select>
                </div>

                <div class="h-100 d-flex align-items-end pb-2 justify-content-end">
                    <button type="button" class="btn btn-success pe-4 ps-4">Create</button>
                    <a href="training_programs.html" class="btn btn-danger ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </main>
@endsection
