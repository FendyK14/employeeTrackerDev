<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo me-5" href="#">
            <h1>E-Tracker</h1>
        </a>
        <a class="navbar-brand brand-logo-mini" href="#">
            <h1>E-T</h1>
        </a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        {{-- @auth --}}
        @if (session('employee'))
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                <span class="navbar-toggler-icon"></span>
            </button>
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item nav-profile dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
                        <i class="bi bi-person-circle profile-pic"></i>
                        <span>{{ Session::get('employee')->employeeName }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                        <a class="dropdown-item"
                            href={{ route('User Profile', ['id' => Session::get('employee')->employeeId]) }}>
                            <i class="bi bi-person-circle"></i> Profile
                        </a>
                        <a class="dropdown-item" href={{ route('Logout') }}>
                            <i class="bi bi-box-arrow-left"></i> Logout
                        </a>
                    </div>
                </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                data-toggle="offcanvas">
                <span class="navbar-toggler-icon"></span>
            </button>
            {{-- @endauth --}}
        @endif
    </div>

</nav>
