<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Application')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <div class="d-flex flex-column min-vh-100">
        <header class="header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col text-end">
                        <div class="admin-info d-inline-flex align-items-center">
                            <div class="dropdown">
                                <span class="admin-name dropdown-toggle" id="adminMenu" data-bs-toggle="dropdown"
                                    aria-expanded="false" title="Admin Menu">
                                    {{ session('login_name') }} &nbsp; <i class="fas fa-caret-down"></i>
                                </span>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminMenu">
                                    <li>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                        <a class="dropdown-item" href="#"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Logout <i class="fas fa-sign-out-alt"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>


        @include('layouts.sidebar')

        <div class="content flex-grow-1" style="margin-left: 220px; padding: 20px;">
            @yield('content')
        </div>

        <footer class="footer bg-light text-center py-3 mt-auto">
            <div class="container">
                &copy; {{ date('Y') }} Foodies Admin. All rights reserved.
            </div>
        </footer>
    </div>

    <div aria-live="polite" aria-atomic="true" class="position-relative">
        <div class="toast-container position-fixed top-0 end-0 p-3">
            @if (session('success'))
                <div class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive"
                    aria-atomic="true" data-delay="3000">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ session('success') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-dismiss="toast"
                            aria-label="Close"></button>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive"
                    aria-atomic="true" data-delay="3000">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ session('error') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-dismiss="toast"
                            aria-label="Close"></button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.toast').toast('show');
        });
    </script>
    @stack('scripts')
</body>

</html>