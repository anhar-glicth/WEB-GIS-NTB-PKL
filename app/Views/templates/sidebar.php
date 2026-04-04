<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar"
    style="position: sticky; top: 0; height: 100vh; overflow-y: auto; z-index: 100;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('/') ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-compass"></i>
        </div>
        <div class="sidebar-brand-text mx-3">WEB GIS NTB</div>
    </a>

    <!-- ===================== ADMIN MENU ===================== -->
    <?php if (in_groups('admin')): ?>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        <i class="fas fa-cog"></i> Administrasi
    </div>

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('admin') ?>">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('admin/user-list') ?>">
            <i class="fas fa-users"></i>
            <span>Daftar User</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('admin/createUser') ?>">
            <i class="fas fa-user-plus"></i>
            <span>Tambah User</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('admin/profile') ?>">
            <i class="fas fa-id-card"></i>
            <span>Profil Saya</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('admin/editProfile') ?>">
            <i class="fas fa-edit"></i>
            <span>Edit Profil</span>
        </a>
    </li>
    <?php endif; ?>

    <!-- ===================== USER MENU ===================== -->
    <?php if (in_groups('user')): ?>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        <i class="fas fa-user"></i> Menu User
    </div>

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('user') ?>">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('user/input-tambang') ?>">
            <i class="fas fa-file-upload"></i>
            <span>Input Data Tambang</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('user/input-perusahaan') ?>">
            <i class="fas fa-building"></i>
            <span>Identitas Perusahaan</span>
        </a>
    </li>

    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        <i class="fas fa-map"></i> Peta & GIS
    </div>

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('Home/viewMaps') ?>">
            <i class="fas fa-map-marked-alt"></i>
            <span>View Maps</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('Home/marker') ?>">
            <i class="fas fa-map-marker-alt"></i>
            <span>Marker</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('Home/baseMaps') ?>">
            <i class="fas fa-layer-group"></i>
            <span>Base Maps</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('poligon_view') ?>">
            <i class="fas fa-draw-polygon"></i>
            <span>Input Koordinat Tambang</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('user/laporan-list') ?>">
            <i class="fas fa-file-alt"></i>
            <span>Upload Laporan (Dokumen)</span>
        </a>
    </li>
    <?php endif; ?>

    <!-- ===================== PETUGAS MENU ===================== -->
    <?php if (in_groups('petugas')): ?>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        <i class="fas fa-clipboard-check"></i> Menu Petugas
    </div>

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('petugas') ?>">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('petugas/laporan') ?>">
            <i class="fas fa-file-alt"></i>
            <span>Laporan Tambang</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('petugas/identitas_perusahaan') ?>">
            <i class="fas fa-building"></i>
            <span>Identitas Perusahaan</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('petugas/data-poligon') ?>">
            <i class="fas fa-map-marked-alt"></i>
            <span>Koordinat Tambang</span>
        </a>
    </li>
    <?php endif; ?>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Logout -->
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('logout') ?>">
            <i class="fas fa-sign-out-alt"></i>
            <span>Log Out</span>
        </a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>