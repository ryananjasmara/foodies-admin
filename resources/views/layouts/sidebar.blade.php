<div class="sidebar">
    <div class="sidebar-header text-center py-3">
        <h4 class="app-title">
            Foodies Admin
        </h4>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ Request::routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        @if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->hasPermission('view_users'))
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('users.list') ? 'active' : '' }}" href="{{ route('users.list') }}">
                    <i class="fas fa-users"></i> Users
                </a>
            </li>
        @endif
        @if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->hasPermission('view_admins'))
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admins.list') ? 'active' : '' }}" href="{{ route('admins.list') }}">
                    <i class="fas fa-user-shield"></i> Admins
                </a>
            </li>
        @endif
        @if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->hasPermission('view_products'))
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('products.list') ? 'active' : '' }}"
                    href="{{ route('products.list') }}">
                    <i class="fas fa-box"></i> Products
                </a>
            </li>
        @endif
        @if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->hasPermission('view_orders'))
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('orders.list') ? 'active' : '' }}" href="{{ route('orders.list') }}">
                    <i class="fas fa-shopping-cart"></i> Orders
                </a>
            </li>
        @endif
        @if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->hasPermission('view_roles'))
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('roles.list') ? 'active' : '' }}" href="{{ route('roles.list') }}">
                    <i class="fas fa-shield-alt"></i> Access Control
                </a>
            </li>
        @endif
    </ul>
</div>