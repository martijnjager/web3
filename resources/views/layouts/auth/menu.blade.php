<ul class="sidebar navbar-nav">

    @role('admin')
    <li class="nav-item {{ route_active('user.index') }}">
        <a class="nav-link" href="{{ route('auth.user.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Users</span>
        </a>
    </li>
    @endrole
        <li class="nav-item {{ route_active('user.edit') }}">
            <a class="nav-link" href="{{ route('auth.user.edit', auth()->user()->id) }}">
                <i class="fas fa-fw fa-user"></i>
                <span>My Account</span>
            </a>
        </li>

    <li class="nav-item {{ route_active('project') }}">
        <a class="nav-link" href="{{ route('auth.project.index') }}">
            <i class="fas fa-fw fa-toolbox"></i>
            <span>Projects</span>
        </a>
    </li>

    <li class="nav-item {{ route_active('calendar') }}">
        <a class="nav-link" href="{{ route('auth.calendar') }}">
            <i class="fas fa-fw fa-toolbox"></i>
            <span>Calendar</span>
        </a>
    </li>

    <li class="nav-item {{ route_active('auth.document.index') }}">
        <a class="nav-link" href="{{ route('auth.document.index') }}">
            <i class="fas fa-fw fa-file-pdf"></i>
            <span>Documents</span>
        </a>
    </li>

</ul>
