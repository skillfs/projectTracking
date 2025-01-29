<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'My Custom App') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.2.1/r-3.0.3/sc-2.4.3/datatables.min.css"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=hourglass_empty" />

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/style.css'])
    <style>

    </style>
</head>

<body>
    <div id="app">
        <!-- Navbar -->
        @php
            $user = Auth::user();
            $userRole = $user && $user->role()->first() ? $user->role()->first()->role_name : '';
        @endphp

        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container">
                {{-- <button onclick="window.history.back();" class="btn btn-secondary me-2">
                    &larr; กลับ
                </button> --}}

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ url('/home') }}">หน้าแรก</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('softwares.list') }}">คำขอพัฒนา</a>
                        </li>

                        <!-- Show only if user is department_head -->
                        @if ($userRole === 'department_head')
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('softwares.dhApprovals') }}">
                                    หัวหน้าแผนก
                                </a>
                            </li>
                        @endif

                        <!-- Show only if user is admin -->
                        @if ($userRole === 'admin')
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('softwares.adminApprovals') }}">
                                    หัวหน้าทีมพัฒนา
                                </a>
                            </li>
                        @endif

                    </ul>

                    <!-- Right Side Of Navbar (Notification Icon and Profile Dropdown) -->
                    <ul class="navbar-nav ms-auto align-items-center">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center"
                                    href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false" v-pre>
                                    <div class="profile-icon">
                                        <span class="fw-bold">{{ strtoupper(substr(Auth::user()->f_name, 0, 1)) }}</span>
                                    </div>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <!-- My Requests -->
                                    <a class="dropdown-item" href="{{ route('softwares.myRequests') }}">คำขอของฉัน</a>

                                    <!-- Logout -->
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.2.1/r-3.0.3/sc-2.4.3/datatables.min.js"></script>
    @yield('scripts')
</body>

</html>
