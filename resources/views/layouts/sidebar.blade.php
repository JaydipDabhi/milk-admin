<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('admin.index') }}" class="brand-link">
        <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Chamunda Dairy</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('admin.index') }}"
                    class="d-block">{{ auth()->check() ? auth()->user()->name : 'Guest' }}</a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                {{-- Users Menu --}}
                @if (auth()->check() && auth()->user()->isSuperAdmin())
                    @php
                        $userMenuOpen = request()->routeIs('admin.user_list', 'admin.user_create', 'admin.user_edit');
                    @endphp
                    <li class="nav-item {{ $userMenuOpen ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ $userMenuOpen ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                All Users
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.user_list') }}"
                                    class="nav-link {{ request()->routeIs('admin.user_list', 'admin.user_edit') ? 'active' : '' }}">
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>User List</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{-- Customers Menu --}}
                @php
                    $customerMenuOpen = request()->routeIs(
                        'admin.customer_list',
                        'admin.customer_create',
                        'admin.customer_edit',
                    );
                @endphp
                <li class="nav-item {{ $customerMenuOpen ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $customerMenuOpen ? 'active' : '' }}">
                        <i class="nav-icon fas fa-address-book"></i>
                        <p>
                            All Customers
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.customer_list') }}"
                                class="nav-link {{ request()->routeIs('admin.customer_list', 'admin.customer_edit') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Customer List</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Milk Delivery Menu --}}
                @php
                    $milkMenuOpen = request()->routeIs(
                        'admin.milk_delivery_list',
                        'admin.milk_delivery',
                        'admin.milk_delivery_edit',
                    );
                @endphp
                <li class="nav-item {{ $milkMenuOpen ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $milkMenuOpen ? 'active' : '' }}">
                        <i class="nav-icon fas fa-truck"></i>
                        <p>
                            Milk Delivery
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.milk_delivery_list') }}"
                                class="nav-link {{ request()->routeIs('admin.milk_delivery_list', 'admin.milk_delivery_edit') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Milk Delivery List</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Rate Master --}}
                @if (auth()->check() && auth()->user()->isSuperAdmin())
                    @php
                        $rateMenuOpen = request()->routeIs('admin.add_rate', 'admin.rate_list', 'admin.rate_edit');
                    @endphp
                    <li class="nav-item {{ $rateMenuOpen ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ $rateMenuOpen ? 'active' : '' }}">
                            <i class="nav-icon fas fa-rupee-sign"></i>
                            <p>
                                Rate Master
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.rate_list') }}"
                                    class="nav-link {{ request()->routeIs('admin.rate_list', 'admin.rate_edit') ? 'active' : '' }}">
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Rate List</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{-- Reports Menu --}}
                @php
                    $reportMenuOpen = request()->routeIs(
                        'reports.full_reports',
                        'reports.monthly_report_form',
                        'reports.generate_monthly_report',
                        'reports.yearly_report_form',
                        'reports.generate_yearly_report',
                        'reports.print_reports',
                        'reports.print_reports_pdf',
                    );
                @endphp
                <li class="nav-item {{ $reportMenuOpen ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $reportMenuOpen ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>
                            Reports
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('reports.full_reports') }}"
                                class="nav-link {{ request()->routeIs('reports.full_reports') ? 'active' : '' }}">
                                <i class="fas fa-clipboard-list nav-icon"></i>
                                <p>All Over Full Reports</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('reports.monthly_report_form') }}"
                                class="nav-link {{ request()->routeIs('reports.monthly_report_form', 'reports.generate_monthly_report') ? 'active' : '' }}">
                                <i class="far fa-calendar-alt nav-icon"></i>
                                <p>Monthly Reports</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('reports.yearly_report_form') }}"
                                class="nav-link {{ request()->routeIs('reports.yearly_report_form', 'reports.generate_yearly_report') ? 'active' : '' }}">
                                <i class="far fa-calendar nav-icon"></i>
                                <p>Yearly Reports</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('reports.print_reports') }}"
                                class="nav-link {{ request()->routeIs('reports.print_reports', 'reports.print_reports_pdf') ? 'active' : '' }}">
                                <i class="fas fa-file-pdf nav-icon"></i>
                                <p>Print Monthly Reports</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Milk Dairy --}}
                @php
                    $dairyMenuOpen = request()->routeIs(
                        'milk_dairy.summary',
                        'milk_dairy.create',
                        'milk_dairy.edit',
                        'milk_dairy.ten_days_reports',
                    );
                @endphp
                <li class="nav-item {{ $dairyMenuOpen ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $dairyMenuOpen ? 'active' : '' }}">
                        <i class="nav-icon fas fa-truck"></i>
                        <p>
                            Milk Dairy
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('milk_dairy.summary') }}"
                                class="nav-link {{ request()->routeIs('milk_dairy.summary', 'milk_dairy.create', 'milk_dairy.edit') ? 'active' : '' }}">
                                <i class="fas fa-clipboard nav-icon"></i>
                                <p>Dairy Daily Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('milk_dairy.ten_days_reports') }}"
                                class="nav-link {{ request()->routeIs('milk_dairy.ten_days_reports') ? 'active' : '' }}">
                                <i class="fas fa-clipboard nav-icon"></i>
                                <p>10 Days Dairy Reports</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

        </nav>
    </div>
</aside>
