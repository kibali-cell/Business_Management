

{{-- resources/views/layouts/sidebar.blade.php --}}
<nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    Dashboard
                </a>
            </li>
            @can('access-crm')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('crm.*') ? 'active' : '' }}" href="{{ route('crm.index') }}">
                    CRM
                </a>
            </li>
            @endcan

            <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('crm.customers.*') ? 'active' : '' }}" 
       href="{{ route('crm.customers.index') }}">
        Customers
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('tasks.*') ? 'active' : '' }}" 
       href="{{ route('tasks.index') }}">
        Tasks
    </a>
</li>
        </ul>
    </div>
</nav>