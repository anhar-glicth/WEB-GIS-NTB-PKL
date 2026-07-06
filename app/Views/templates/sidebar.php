<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion shadow-lg" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center py-5" href="<?= base_url('/') ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-layer-group text-warning"></i>
        </div>
        <div class="sidebar-brand-text mx-3">WEB GIS<span>NTB</span></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <?php 
    $uri = service('uri');
    $seg1 = $uri->getSegment(1);
    $seg2 = ($uri->getTotalSegments() > 1) ? $uri->getSegment(2) : '';
    ?>

    <!-- ===================== ADMIN MENU ===================== -->
    <?php if (in_groups('admin')): ?>
    <div class="sidebar-heading mt-4 small opacity-50 px-4 font-weight-bold">ADMINISTRASI</div>
    
    <li class="nav-item <?= ($seg1 == 'admin' && ($seg2 == 'index' || $seg2 == '')) ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard Admin</span>
        </a>
    </li>
    <li class="nav-item <?= ($seg2 == 'user-list' || $seg2 == 'createUser') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/user-list') ?>">
            <i class="fas fa-fw fa-users-cog"></i>
            <span>Manajemen User</span>
        </a>
    </li>
    <li class="nav-item <?= ($seg2 == 'settings') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/settings') ?>">
            <i class="fas fa-fw fa-tools"></i>
            <span>Settings Landing</span>
        </a>
    </li>
    <?php endif; ?>

    <!-- ===================== USER MENU ===================== -->
    <?php if (in_groups('user')): ?>
    <div class="sidebar-heading mt-4 small opacity-50 px-4 font-weight-bold">MENU KERJA</div>

    <li class="nav-item <?= ($seg1 == 'user' && ($seg2 == 'index' || $seg2 == '')) ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('user') ?>">
            <i class="fas fa-fw fa-th-large"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item <?= ($seg1 == 'user' && $seg2 == 'input-tambang') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('user/input-tambang') ?>">
            <i class="fas fa-fw fa-file-invoice"></i>
            <span>Input Data Tambang</span>
        </a>
    </li>
    <li class="nav-item <?= ($seg1 == 'user' && ($seg2 == 'input-perusahaan' || $seg2 == 'detailPerusahaan')) ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('user/detailPerusahaan') ?>">
            <i class="fas fa-fw fa-building"></i>
            <span>Identitas Perusahaan</span>
        </a>
    </li>

    <hr class="sidebar-divider">
    <div class="sidebar-heading small opacity-50 px-4 font-weight-bold">PETA & GIS</div>

    <li class="nav-item <?= ($seg1 == 'Home' && $seg2 == 'marker') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('Home/marker') ?>">
            <i class="fas fa-fw fa-map-marked-alt"></i>
            <span>Input Koordinat</span>
        </a>
    </li>
    <li class="nav-item <?= ($seg2 == 'riwayat') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('poligon/riwayat') ?>">
            <i class="fas fa-fw fa-history"></i>
            <span>Riwayat & Kelola</span>
        </a>
    </li>
    <?php endif; ?>

    <!-- ===================== PETUGAS MENU ===================== -->
    <?php if (in_groups('petugas')): ?>
    <div class="sidebar-heading mt-4 small opacity-50 px-4 font-weight-bold">MENU PETUGAS</div>
    <li class="nav-item <?= ($seg1 == 'petugas' && ($seg2 == 'index' || $seg2 == '')) ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('petugas') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item <?= ($seg2 == 'laporan') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('petugas/laporan') ?>">
            <i class="fas fa-fw fa-file-signature"></i>
            <span>Laporan Tambang</span>
        </a>
    </li>
    <li class="nav-item <?= ($seg2 == 'data-poligon') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('petugas/data-poligon') ?>">
            <i class="fas fa-fw fa-globe-asia"></i>
            <span>Koordinat Tambang</span>
        </a>
    </li>
    <?php endif; ?>

    <hr class="sidebar-divider">
    <div class="sidebar-heading small opacity-50 px-4 font-weight-bold">PERSONAL</div>

    <li class="nav-item <?= ($seg2 == 'profile') ? 'active' : '' ?>">
        <?php 
            $profileUrl = base_url('user/profile'); // Default
            if (in_groups('admin')) {
                $profileUrl = base_url('admin/profile');
            } elseif (in_groups('petugas')) {
                $profileUrl = base_url('petugas/profile');
            }
        ?>
        <a class="nav-link" href="<?= $profileUrl ?>">
            <i class="fas fa-fw fa-user-circle"></i>
            <span>Profil Saya</span>
        </a>
    </li>

    <!-- Logout -->
    <hr class="sidebar-divider d-none d-md-block">
    <li class="nav-item">
        <a class="nav-link bg-danger text-white mx-3 rounded shadow-sm py-2 mb-4 text-center" 
           href="<?= base_url('logout') ?>" 
           style="border: none !important; width: auto !important; margin-right: 1rem !important; display: block !important;">
            <i class="fas fa-fw fa-power-off text-white"></i>
            <span class="ml-1 d-none d-md-inline font-weight-bold">Log Out</span>
        </a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline mt-2">
        <button class="rounded-circle border-0 shadow" id="sidebarToggle" style="background: rgba(255,255,255,0.2) !important;">
            <i class="fas fa-chevron-left text-white i-toggle"></i>
        </button>
    </div>

</ul>

<style>
    /* Styling Dasar Sidebar */
    .sidebar { min-height: 100vh; position: sticky; top: 0; background: #3d5ad1 !important; transition: all 0.3s ease; }
    .sidebar-brand-text { font-weight: 800; letter-spacing: 1px; text-transform: uppercase; }
    .sidebar-brand-text span { color: #f1c40f; }

    /* Nav Link & Hover Effects */
    .nav-item .nav-link { padding: 0.8rem 1.5rem; transition: 0.3s; border-radius: 0 50px 50px 0; margin-right: 15px; margin-bottom: 2px; color: rgba(255,255,255,0.8) !important; }
    .nav-item .nav-link i { font-size: 1rem; width: 1.5rem; opacity: 0.7; }
    .nav-item .nav-link:hover { background: rgba(255,255,255,0.1) !important; padding-left: 1.8rem; opacity: 1; color: #fff !important; }

    /* State Active */
    .nav-item.active .nav-link { 
        background: rgba(255,255,255,0.2) !important; 
        font-weight: 700; 
        color: #fff !important; 
        border-left: 4px solid #f1c40f !important; 
    }
    .nav-item.active .nav-link i { opacity: 1; color: #f1c40f !important; }

    /* Sidebar Heading */
    .sidebar-heading { letter-spacing: 1.5px; color: rgba(255,255,255,0.4) !important; font-size: 0.65rem !important; margin-top: 1.5rem !important; }
    
    /* Logout Styling */
    .bg-danger:hover { background: #c0392b !important; transform: scale(1.03); transition: 0.2s; }

    /* Collapsed Sidebar Mode */
    .sidebar.toggled { width: 6.5rem !important; overflow: visible; }
    .sidebar.toggled .nav-item .nav-link { border-radius: 50% !important; width: 45px !important; height: 45px !important; margin: 10px auto !important; padding: 0 !important; display: flex !important; align-items: center; justify-content: center; }
    .sidebar.toggled .nav-item .nav-link span, .sidebar.toggled .sidebar-brand-text { display: none !important; }
    .sidebar.toggled #sidebarToggle i { transform: rotate(180deg); }

    #sidebarToggle:hover { background: #f1c40f !important; }
</style>