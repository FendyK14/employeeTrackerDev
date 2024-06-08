<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href={{ asset('css/style.css') }}>
    <link rel="stylesheet" href={{ asset('vendors/base/vendor.bundle.base.css') }}>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href={{ asset('vendors/ti-icons/css/themify-icons.css') }}>
</head>

{{-- Dinamis Path --}}
@php
    // Tambahkan path jika tampilan error
    $prefixes = [
        'position/',
        'employee/',
        'profile/',
        'group',
        'attendance/',
        'member/',
        'project/',
        'activity/',
        'subactivity/',
        'report',
        'your-activity/',
    ];
    $isActive =
        collect($prefixes)->contains(function ($prefix) {
            return Str::startsWith(request()->path(), $prefix);
        }) || request()->is('dashboard');
    $employee = session('employee');
@endphp

<body>
    <div class="container-scroller">
        {{-- Navbar --}}
        @include('component.navbar.navbar')
        <div class="{{ $isActive ? 'page-body-dashboard' : 'page-body-wrapper' }}">
            @if ($employee)
                @if (Session::get('employee'))
                    {{-- Sidebar --}}
                    @include('component.sidebar.sidebar')
                    <div class="{{ Request::is('dashboard') ? 'main-dashboard' : 'main-panel' }}" id="home">
                        <div class="content-wrapper">
                            @yield('content')
                        </div>
                    </div>
                @endif
            @else
                <div class="d-flex bg-warning"></div>
                @yield('content')
            @endif
        </div>
    </div>
    <script>
        // Cetak posisi path
        var currentPath = "{{ request()->path() }}";
        console.log(currentPath);
    </script>
    <script src={{ asset('vendors/base/vendor.bundle.base.js') }}></script>
    <script src={{ asset('js/off-canvas.js') }}></script>
    <script src={{ asset('js/hoverable-collapse.js') }}></script>
    <script src={{ asset('js/template.js') }}></script>
    <script src={{ asset('js/jquery.cookie.js') }}></script>
    <script src="https://kit.fontawesome.com/00cba2cf34.js" crossorigin="anonymous"></script>
    <script src={{ asset('js/script.js') }}></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    @if (!request()->is('register/user') && !request()->is('register/company') && !request()->is('login'))
        @include('sweetalert::alert')
    @endif
</body>

</html>
