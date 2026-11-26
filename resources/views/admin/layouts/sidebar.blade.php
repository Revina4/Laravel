<aside class="main-sidebar sidebar-dark-primary">

    <a href="/admin/dashboard" class="brand-link">
        <span class="brand-text"><i class="fas fa-cash-register mr-2"></i> Kasir App</span>
    </a>

    <div class="sidebar">
        <nav class="mt-3">
            <ul class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview"
                role="menu"
                data-accordion="false">

                <li class="nav-item">
                    <a href="/admin/dashboard"
                       class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-th-large"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                @if (auth()->user()->role === 'admin')

                    <li class="nav-item">
                        <a href="/admin/user"
                           class="nav-link {{ request()->is('admin/user*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>User</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/admin/kategori"
                           class="nav-link {{ request()->is('admin/kategori*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-list"></i>
                            <p>Kelola Kategori</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/admin/produk"
                           class="nav-link {{ request()->is('admin/produk*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-box"></i>
                            <p>Kelola Produk</p>
                        </a>
                    </li>

                @endif

                <li class="nav-item">
                    <a href="/admin/transaksi"
                       class="nav-link {{ request()->is('admin/transaksi*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>Kelola Transaksi</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>

</aside>

<div class="content-wrapper">