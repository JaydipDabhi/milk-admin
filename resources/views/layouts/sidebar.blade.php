<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('admin.index') }}" class="brand-link">
        <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Milk Admin</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('admin.index') }}" class="d-block">User Name</a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                {{-- Users Menu --}}
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

                {{-- Milk Delivery --}}
                @php
                    $MilkMenuOpen = request()->routeIs(
                        'admin.milk_delivery_list',
                        'admin.milk_delivery',
                        'admin.milk_delivery_edit',
                    );
                @endphp
                <li class="nav-item {{ $MilkMenuOpen ? 'menu-open' : '' }}">
                    <a href="javascript:void(0);" class="nav-link {{ $MilkMenuOpen ? 'active' : '' }}">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>Milk Delivery<i class="right fas fa-angle-left"></i></p>
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
                @php
                    $RateMenuOpen = request()->routeIs('admin.add_rate', 'admin.rate_list', 'admin.rate_edit');
                @endphp
                <li class="nav-item {{ $RateMenuOpen ? 'menu-open' : '' }}">
                    <a href="javascript:void(0);" class="nav-link {{ $RateMenuOpen ? 'active' : '' }}">
                        <i class="nav-icon fas fa-rupee-sign"></i>
                        <p>Rate Master<i class="right fas fa-angle-left"></i></p>
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

                {{-- Rate Master --}}
                {{-- @php
                    $RateMenuOpen = request()->routeIs('admin.add_rate', 'admin.rate_list', 'admin.rate_edit');
                @endphp --}}
                <li class="nav-item">
                    <a href="javascript:void(0);" class="nav-link">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <p>Monthly Reports<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('reports.monthly') }}" class="nav-link">
                                <i class="fas fa-file-alt nav-icon"></i>
                                <p>Monthly Reports</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- <li class="nav-item ">
                    <a href="javascript:void(0);" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>All Customers<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="fas fa-user nav-icon"></i>
                                <p>Customer List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="fas fa-user-plus nav-icon"></i>
                                <p>Add New Customer</p>
                            </a>
                        </li>
                    </ul>
                </li> --}}

            </ul>
        </nav>

    </div>
</aside>
