<nav id="sidebar" class="col-md-3 col-lg-2 d-none d-md-block bg-light sidebar">
    <div class="position-sticky pt-3">
        <!-- Hamburger menu for mobile -->
        <button class="btn btn-link d-md-none sidebar-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false">
            <i class="fas fa-bars"></i>
        </button>

        <div class="collapse d-md-block" id="sidebarMenu">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
                       href="{{ route('dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i>
                        Dashboard
                    </a>
                </li>

                @can('access-crm')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('crm.*') ? 'active' : '' }}" 
                       href="{{ route('crm.index') }}">
                        <i class="fas fa-users me-2"></i>
                        CRM
                    </a>
                </li>
                @endcan

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('crm.customers.*') ? 'active' : '' }}"
                       href="{{ route('crm.customers.index') }}">
                        <i class="fas fa-user-tie me-2"></i>
                        Customers
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('tasks.*') ? 'active' : '' }}"
                       href="{{ route('tasks.index') }}">
                        <i class="fas fa-tasks me-2"></i>
                        Tasks
                    </a>
                </li>

                <!-- New Document Management Link -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('documents.*') ? 'active' : '' }}"
                       href="{{ route('documents.index') }}">
                        <i class="fas fa-file-alt me-2"></i>
                        Documents
                    </a>
                </li>

                <li class="nav-item">
    <a class="nav-link dropdown-toggle {{ request()->routeIs('finance.*') ? 'active' : '' }}" 
       data-bs-toggle="collapse" 
       href="#financeSubmenu" 
       role="button" 
       aria-expanded="false">
        <i class="fas fa-money-bill me-2"></i>
        Financial Management
    </a>
    <div class="collapse {{ request()->routeIs('finance.*') ? 'show' : '' }}" id="financeSubmenu">
        <ul class="nav flex-column ms-3">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('accounts.*') ? 'active' : '' }}" 
                   href="{{ route('accounts.index') }}">
                    <i class="fas fa-bank me-2"></i>
                    Accounts
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}" 
                   href="{{ route('transactions.index') }}">
                    <i class="fas fa-exchange-alt me-2"></i>
                    Transactions
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('invoices.*') ? 'active' : '' }}" 
                   href="{{ route('invoices.index') }}">
                    <i class="fas fa-file-invoice-dollar me-2"></i>
                    Invoices
                </a>
            </li>
        </ul>
    </div>
</li>
            </ul>

            <!-- Optional: Add secondary menu items -->
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <span>Quick Actions</span>
            </h6>
            <ul class="nav flex-column mb-2">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('documents.index') }}">
                        <i class="fas fa-file-upload me-2"></i>
                        Upload Document
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

