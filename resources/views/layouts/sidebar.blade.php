<!-- resources/views/layouts/sidebar.blade.php -->
<nav id="sidebar" class="col-md-3 col-lg-2 bg-dark text-white sidebar">
    <div class="position-sticky pt-3">
        <!-- Hamburger menu for mobile -->
        <button class="btn btn-link d-md-none sidebar-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false">
            <i class="fas fa-bars text-white"></i>
        </button>

        <div class="collapse d-md-block" id="sidebarMenu">
            <div class="sidebar-header p-3">
                <h5 class="mb-0 text-white">Financial Management</h5>
            </div>

            <ul class="nav flex-column">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
                       href="{{ route('dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i>
                        Dashboard
                    </a>
                </li>

                <!-- CRM Section -->
                @can('access-crm')
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('crm.*') ? 'active' : '' }}" 
                       href="{{ route('crm.index') }}">
                        <i class="fas fa-users me-2"></i>
                        CRM
                    </a>
                </li>
                @endcan

                <!-- Financial Management Dropdown -->
                <li class="nav-item">
                    <a class="nav-link text-white dropdown-toggle {{ request()->routeIs('finance.*') ? 'active' : '' }}" 
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
                                <a class="nav-link text-white {{ request()->routeIs('accounts.*') ? 'active' : '' }}" 
                                   href="{{ route('accounts.index') }}">
                                    <i class="fas fa-bank me-2"></i>
                                    Accounts
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white {{ request()->routeIs('transactions.*') ? 'active' : '' }}" 
                                   href="{{ route('transactions.index') }}">
                                    <i class="fas fa-exchange-alt me-2"></i>
                                    Transactions
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white {{ request()->routeIs('invoices.*') ? 'active' : '' }}" 
                                   href="{{ route('invoices.index') }}">
                                    <i class="fas fa-file-invoice-dollar me-2"></i>
                                    Invoices
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Reports Dropdown -->
                <li class="nav-item">
                    <a class="nav-link text-white dropdown-toggle {{ request()->routeIs('reports.*') ? 'active' : '' }}"
                       data-bs-toggle="collapse" 
                       href="#reportsSubmenu" 
                       role="button" 
                       aria-expanded="false">
                        <i class="fas fa-file-alt me-2"></i>
                        Reports
                    </a>
                    <div class="collapse {{ request()->routeIs('reports.*') ? 'show' : '' }}" id="reportsSubmenu">
                        <ul class="nav flex-column ms-3">
                            <li class="nav-item">
                                <a class="nav-link text-white {{ request()->routeIs('reports.profit-loss') ? 'active' : '' }}" 
                                   href="{{ route('reports.profit-loss') }}">
                                    Profit & Loss
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white {{ request()->routeIs('reports.balance-sheet') ? 'active' : '' }}" 
                                   href="{{ route('reports.balance-sheet') }}">
                                    Balance Sheet
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white {{ request()->routeIs('reports.cash-flow') ? 'active' : '' }}" 
                                   href="{{ route('reports.cash-flow') }}">
                                    Cash Flow
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Additional Management Links -->
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('budgets.*') ? 'active' : '' }}" 
                       href="{{ route('budgets.index') }}">
                        <i class="fas fa-wallet me-2"></i>
                        Budget Planning
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('currency.*') ? 'active' : '' }}" 
                       href="{{ route('currency.index') }}">
                        <i class="fas fa-exchange-alt me-2"></i>
                        Currency Exchange
                    </a>
                </li>
            </ul>

            <!-- Quick Actions Section -->
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <span>Quick Actions</span>
            </h6>
            <ul class="nav flex-column mb-2">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('documents.index') }}">
                        <i class="fas fa-file-upload me-2"></i>
                        Upload Document
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
.sidebar {
    width: 250px;
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    overflow-y: auto;
    transition: all 0.3s;
    z-index: 1000;
}

.sidebar .nav-link {
    padding: 0.75rem 1rem;
    color: rgba(255, 255, 255, 0.8);
    transition: all 0.3s;
}

.sidebar .nav-link:hover,
.sidebar .nav-link.active {
    background-color: rgba(255, 255, 255, 0.1);
    color: #fff;
}

.sidebar .nav-link i {
    width: 20px;
    text-align: center;
}

.sidebar-toggle {
    color: white;
    margin: 1rem;
}

#content {
    margin-left: 250px;
    transition: all 0.3s;
}

@media (max-width: 768px) {
    .sidebar {
        margin-left: -250px;
    }
    
    .sidebar.active {
        margin-left: 0;
    }
    
    #content {
        margin-left: 0;
    }
    
    .d-md-block {
        display: none;
    }
    
    .sidebar.active .d-md-block {
        display: block;
    }
}
</style>