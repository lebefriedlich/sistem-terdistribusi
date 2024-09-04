<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('category-hotel.index') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('img/Rove_Inn.png') }}" alt="" style="width: 100px;">
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <li class="nav-item active">
        <a class="nav-link" href="{{ route('dashboard.index') }}">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span></a>
    </li>

    <hr class="sidebar-divider my-0">
    <li class="nav-item active">
        <a class="nav-link" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false"
            aria-controls="collapseExample">
            <i class="bi bi-building"></i>
            <span>Hotel</span></a>
        </a>
        <div class="collapse" id="collapseExample">
            <ul>
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('category-hotel.index') }}">
                        <i class="bi bi-bookmark-fill"></i>
                        <span>Kategori Kamar</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('room.index') }}">
                        <i class="bi bi-door-open-fill"></i>
                        <span>Kamar</span></a>
                </li>
            </ul>
        </div>
    </li>

    <li class="nav-item active">
        <a class="nav-link" data-toggle="collapse" href="#collapseExample1" role="button" aria-expanded="false"
            aria-controls="collapseExample1">
            <i class="bi bi-car-front-fill"></i>
            <span>Kendaraan</span></a>
        </a>
        <div class="collapse" id="collapseExample1">
            <ul>
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('categoriesV.index') }}">
                        <i class="bi bi-bookmark-fill"></i>
                        <span>Kategori Kendaraan</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('vehicle.index') }}">
                        <i class="bi bi-car-front"></i>
                        <span>Kendaraan</span></a>
                </li>
            </ul>
        </div>
    </li>

    <hr class="sidebar-divider">

    <li class="nav-item active">
        <a class="btn nav-link" data-toggle="modal" data-target="#logoutModal">
            <i class="bi bi-box-arrow-left"></i>
            <span>Keluar</span>
        </a>
    </li>
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
