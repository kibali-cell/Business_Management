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

                <!-- Financial Management Dropdown -->
                <li class="nav-item">
                    <a href="#financeSubmenu" data-bs-toggle="collapse" 
                    class="nav-link {{ request()->routeIs('finance.*') ? 'active' : '' }}" 
                    aria-expanded="{{ request()->routeIs('finance.*') ? 'true' : 'false' }}">
                        <i class="fas fa-money-bill me-2"></i>
                        Financial Management
                        <i class="fas fa-chevron-down float-end"></i>
                    </a>
                    <ul class="collapse {{ request()->routeIs('finance.*') ? 'show' : '' }}" id="financeSubmenu" style="list-style: none; padding-left: 0;">
    <li class="nav-item">
        <a href="{{ route('accounts.index') }}" 
           class="nav-link ms-4 {{ request()->routeIs('accounts.*') ? 'active' : '' }}">
            <i class="fas fa-bank me-2"></i>
            Accounts
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('transactions.index') }}" 
           class="nav-link ms-4 {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
            <i class="fas fa-exchange-alt me-2"></i>
            Transactions
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('invoices.index') }}" 
           class="nav-link ms-4 {{ request()->routeIs('invoices.*') ? 'active' : '' }}">
            <i class="fas fa-file-invoice-dollar me-2"></i>
            Invoices
        </a>
    </li>
</ul>

                </li>

                <!-- Reports Dropdown -->
                <li class="nav-item">
                    <a href="#reportsSubmenu" data-bs-toggle="collapse" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                        <i class="fas fa-file-alt me-2"></i>
                        Reports
                        <i class="fas fa-chevron-down float-end"></i>
                    </a>
                    <ul class="collapse {{ request()->routeIs('reports.*') ? 'show' : '' }}" id="reportsSubmenu" style=" list-style: none; padding-left: 0; " >
                        <li class="nav-item">
                            <a href="{{ route('reports.profit-loss') }}" class="nav-link ms-4 {{ request()->routeIs('reports.profit-loss') ? 'active' : '' }}">
                                Profit & Loss
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('reports.balance-sheet') }}" class="nav-link ms-4 {{ request()->routeIs('reports.balance-sheet') ? 'active' : '' }}">
                                Balance Sheet
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('reports.cash-flow') }}" class="nav-link ms-4 {{ request()->routeIs('reports.cash-flow') ? 'active' : '' }}">
                                Cash Flow
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Budget Management -->
                <li class="nav-item">
                    <a href="{{ route('budgets.index') }}" class="nav-link {{ request()->routeIs('budgets.*') ? 'active' : '' }}">
                        <i class="fas fa-wallet me-2"></i>
                        Budget Planning
                    </a>
                </li>

                <!-- Bank Accounts -->
                <li class="nav-item">
                    <a href="{{ route('bank-accounts.index') }}" class="nav-link {{ request()->routeIs('bank-accounts.*') ? 'active' : '' }}">
                        <i class="fas fa-university me-2"></i>
                        Bank Accounts
                    </a>
                </li>

                <!-- Currency Management -->
                <li class="nav-item">
                    <a href="{{ route('currency.index') }}" class="nav-link {{ request()->routeIs('currency.*') ? 'active' : '' }}">
                        <i class="fas fa-exchange-alt me-2"></i>
                        Currency Exchange
                    </a>
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
