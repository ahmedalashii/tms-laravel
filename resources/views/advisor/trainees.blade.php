@extends('layouts.advisorLayout')

@section('MainContent')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">Trainees</h1>
            <section class="mt-3 mb-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-user me-1"></i>
                        Trainee Information
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Name</th>
                                    <th>Email address</th>
                                    <th>Address</th>
                                    <th>Gender</th>
                                    <th>CV</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <img src="https://randomuser.me/api/portraits/men/60.jpg" class="rounded-circle me-1"
                                            width="40px" alt="Jane Doe's avatar" />
                                        John Doe
                                    </td>
                                    <td>johndoe@example.com</td>
                                    <td>123 Main Street, Anytown, CA 91234</td>
                                    <td>Male</td>
                                    <td><a href="https://example.com/cv/johndoe.pdf">Download CV</a></td>
                                    <td><a href="trainee_edit.html" class="btn btn-success">Edit</a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="https://randomuser.me/api/portraits/men/60.jpg"
                                            class="rounded-circle me-1" width="40px" alt="Jane Doe's avatar" />
                                        John Doe
                                    </td>
                                    <td>johndoe@example.com</td>
                                    <td>123 Main Street, Anytown, CA 91234</td>
                                    <td>Male</td>
                                    <td><a href="https://example.com/cv/johndoe.pdf">Download CV</a></td>
                                    <td><a href="trainee_edit.html" class="btn btn-success">Edit</a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="https://randomuser.me/api/portraits/men/60.jpg"
                                            class="rounded-circle me-1" width="40px" alt="Jane Doe's avatar" />
                                        John Doe
                                    </td>
                                    <td>johndoe@example.com</td>
                                    <td>123 Main Street, Anytown, CA 91234</td>
                                    <td>Male</td>
                                    <td><a href="https://example.com/cv/johndoe.pdf">Download CV</a></td>
                                    <td><a href="trainee_edit.html" class="btn btn-success">Edit</a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="https://randomuser.me/api/portraits/men/60.jpg"
                                            class="rounded-circle me-1" width="40px" alt="Jane Doe's avatar" />
                                        John Doe
                                    </td>
                                    <td>johndoe@example.com</td>
                                    <td>123 Main Street, Anytown, CA 91234</td>
                                    <td>Male</td>
                                    <td><a href="https://example.com/cv/johndoe.pdf">Download CV</a></td>
                                    <td><a href="trainee_edit.html" class="btn btn-success">Edit</a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="https://randomuser.me/api/portraits/men/60.jpg"
                                            class="rounded-circle me-1" width="40px" alt="Jane Doe's avatar" />
                                        John Doe
                                    </td>
                                    <td>johndoe@example.com</td>
                                    <td>123 Main Street, Anytown, CA 91234</td>
                                    <td>Male</td>
                                    <td><a href="https://example.com/cv/johndoe.pdf">Download CV</a></td>
                                    <td><a href="trainee_edit.html" class="btn btn-success">Edit</a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="https://randomuser.me/api/portraits/men/60.jpg"
                                            class="rounded-circle me-1" width="40px" alt="Jane Doe's avatar" />
                                        John Doe
                                    </td>
                                    <td>johndoe@example.com</td>
                                    <td>123 Main Street, Anytown, CA 91234</td>
                                    <td>Male</td>
                                    <td><a href="https://example.com/cv/johndoe.pdf">Download CV</a></td>
                                    <td><a href="trainee_edit.html" class="btn btn-success">Edit</a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="https://randomuser.me/api/portraits/men/60.jpg"
                                            class="rounded-circle me-1" width="40px" alt="Jane Doe's avatar" />
                                        John Doe
                                    </td>
                                    <td>johndoe@example.com</td>
                                    <td>123 Main Street, Anytown, CA 91234</td>
                                    <td>Male</td>
                                    <td><a href="https://example.com/cv/johndoe.pdf">Download CV</a></td>
                                    <td><a href="trainee_edit.html" class="btn btn-success">Edit</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </main>
@endsection
