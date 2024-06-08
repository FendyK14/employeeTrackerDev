<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        @if (session('employee'))
            {{-- Dashboard --}}
            <li class="nav-item">
                <a class="nav-link" href={{ route('Dashboard') }}>
                    <i class="bi bi-columns menu-icon"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>
            {{-- Attendance --}}
            <li class="nav-item">
                <a class="nav-link" href={{ route('Attendance') }}>
                    <i class="bi bi-card-checklist menu-icon"></i>
                    <span class="menu-title">Attendance</span>
                </a>
            </li>
            @if (Session::get('employee')->positionId === 1)
                {{-- Employee Data --}}
                <li class="nav-item">
                    <a class="nav-link" href={{ route('List Employee') }}>
                        <i class="fa-solid fa-user menu-icon"></i>
                        <span class="menu-title">Employee Data</span>
                    </a>
                </li>
            @else
                {{-- Group --}}
                <li class="nav-item">
                    <a class="nav-link" href={{ route('Group List') }}>
                        <i class="bi bi-people-fill menu-icon"></i>
                        <span class="menu-title">Group</span>
                    </a>
                </li>
                @if (Session::get('employee')->positionId === 2)
                    {{-- Project --}}
                    <li class="nav-item">
                        <a class="nav-link" href={{ route('List Project') }}>
                            <i class="bi bi-ui-checks-grid menu-icon"></i>
                            <span class="menu-title">Project</span>
                        </a>
                    </li>
                @endif
                {{-- Activity --}}
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#activity" aria-expanded="false"
                        aria-controls="activity">
                        <i class="bi bi-activity menu-icon"></i>
                        <span class="menu-title">Activity</span>
                        <i class="bi bi-arrow-right-circle menu-arrow"></i>
                    </a>
                    <div class="collapse" id="activity">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href={{ route('Your activity') }}>Your
                                    Activity</a></li>
                            <li class="nav-item"> <a class="nav-link" href={{ route('Group Activity') }}>Group
                                    Activity</a>
                            </li>
                        </ul>
                    </div>
                </li>
                @if (Session::get('employee')->positionId === 2)
                    {{-- Sub Activity --}}
                    <li class="nav-item">
                        <a class="nav-link" href={{ route('List Subactivity') }}>
                            <i class="bi bi-subtract menu-icon"></i>
                            <span class="menu-title">Sub Activity</span>
                        </a>
                    </li>
                @endif
            @endif
            {{-- Report --}}
            <li class="nav-item">
                <a class="nav-link" href={{ route('List Report') }}>
                    <i class="bi bi-clipboard2-data-fill menu-icon"></i>
                    <span class="menu-title">Report</span>
                </a>
            </li>
            {{-- Setting --}}
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#setting" aria-expanded="false"
                    aria-controls="setting">
                    <i class="bi bi-gear menu-icon"></i>
                    <span class="menu-title">Setting</span>
                    <i class="bi bi-arrow-right-circle menu-arrow"></i>
                </a>
                <div class="collapse" id="setting">
                    <ul class="nav flex-column sub-menu">
                        @if (Session::get('employee')->positionId === 1)
                            <li class="nav-item">
                                <a class="nav-link"
                                    href={{ route('Company Profile', ['id' => Session::get('employee')->companyId]) }}>Company
                                    Profile</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link"
                                href={{ route('User Profile', ['id' => Session::get('employee')->employeeId]) }}>User
                                Profile</a>
                        </li>
                        @if (Session::get('employee')->positionId === 1)
                            <li class="nav-item">
                                <a class="nav-link" href={{ route('List Position') }}>Position</a>
                            </li>
                        @endif
                    </ul>
                </div>
        @endif
        </li>
    </ul>
</nav>
