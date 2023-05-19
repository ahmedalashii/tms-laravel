<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>TrainMaster - Resource Not Found</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body>
    <div id="layoutError">
        <div id="layoutError_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="text-center mt-4">
                                <img class="mb-4 img-error" src="{{ asset('images/error-404-monochrome.svg') }}" />
                                <p class="lead">This requested URL was not found on this server.</p>
                                @php
                                    $session_guard = Session::get('guard');
                                    if ($session_guard == 'manager') {
                                        $url = route('manager');
                                    } elseif ($session_guard == 'trainee') {
                                        $url = route('trainee');
                                    } elseif ($session_guard == 'advisor') {
                                        $url = route('advisor');
                                    } else {
                                        $url = URL('/');
                                    }
                                @endphp
                                <a href="{{ $url }}">
                                    <i class="fas fa-arrow-left me-1"></i>
                                    Return to Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutError_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; TrainMaster |
                            <script>
                                document.write(new Date().getFullYear());
                            </script>
                        </div>
                    </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/scripts.js') }}"></script>
</body>

</html>
