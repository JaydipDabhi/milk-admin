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
                                <i class="fas fa-user nav-icon"></i>
                                <p>User List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.user_create') }}"
                                class="nav-link {{ request()->routeIs('admin.user_create') ? 'active' : '' }}">
                                <i class="fas fa-user-plus nav-icon"></i>
                                <p>Add New User</p>
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
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            All Customers
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.customer_list') }}"
                                class="nav-link {{ request()->routeIs('admin.customer_list', 'admin.customer_edit') ? 'active' : '' }}">
                                <i class="fas fa-user nav-icon"></i>
                                <p>Customer List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.customer_create') }}"
                                class="nav-link {{ request()->routeIs('admin.customer_create') ? 'active' : '' }}">
                                <i class="fas fa-user-plus nav-icon"></i>
                                <p>Add New Customer</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Customers Menu --}}
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
