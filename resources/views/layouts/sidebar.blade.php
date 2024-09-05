<div class="sidebar">
    <div class="sidebar-header text-center py-3">
        <h4 class="app-title">
            Foodies Admin
        </h4>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('users.list') }}">
                <i class="fas fa-users"></i> Users
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admins.list') }}">
                <i class="fas fa-user-shield"></i> Admins
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('products.list') }}">
                <i class="fas fa-box"></i> Products
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('orders.list') }}">
                <i class="fas fa-shopping-cart"></i> Orders
            </a>
        </li>
    </ul>
</div>