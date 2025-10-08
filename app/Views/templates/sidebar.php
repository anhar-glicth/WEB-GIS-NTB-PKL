<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('/ php') ?>">
                <div class="sidebar-brand-icon rotate-n-15">
                 	<i class="fas fa-compass"></i>
                </div>
                <div class="sidebar-brand-text mx-3">WEB GIS NTB </div>
            </a>
            <?php if(in_groups('admin')): ?>
 <hr class="sidebar-divider">     
    <div class="sidebar-heading">
        <i class="fas fa-users"></i>
        User Management
    </div>
          <li class="nav-item">
          <a class="nav-link" href="<?= base_url('/admin/userList') ?>">

                <i class="fas fa-users"></i>
                <span>User List</span></a>
          </li>        
 <hr class="sidebar-divider"> 
           
<li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin/profile') ?>">
                <i class="fas fa-users"></i>
                <span>My Profile</span></a>
          </li>    
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin/editProfile') ?>">
                <i class="fas fa-users"></i>
                <span>Edit Profile</span></a>
          </li>   
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin/createUser') ?>">

                <i class="fas fa-users"></i>
                <span>Tambah user</span></a>
          </li>        
          <?php endif; ?> 

            <!-- Nav Item - Pages Collapse Menu -->
            

            <!-- Nav Item - -->
           <?php if (in_groups('user')): ?>

 <li class="nav-item">
                <a class="nav-link"  href="<?= base_url('/') ?>">
                  <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link"  href="<?= base_url('Home/viewMaps') ?>">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>view maps</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link"  href="<?= base_url('Home/marker') ?>">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Marker</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('Home/baseMaps') ?>">
                    <i class="fas fa-location-dot"></i></i>
                    <span> Base maps</span></a>
            </li>
             <li class="nav-item">
                <a class="nav-link" href="<?= base_url('Home/poligon') ?>">
                 <i class="fas fa-map-marker-alt"></i>
                    <span> Poligon</span></a>
            </li>
             <li class="nav-item">
                <a class="nav-link" href="<?= base_url('input-tambang') ?>">
                 <i class="fas fa-map-marker-alt"></i>
                    <span> Input Data Tambang</span></a>
            </li>
             <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
        <i class="fas fa-columns"></i>
        <span>Layouts</span>
    </a>
    
    <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#accordionSidebar">
        <nav class="sb-sidenav-menu-nested nav">
            <a class="nav-link" href="<?= base_url('Lokasi/inputLokasi')?>">Input lokasi</a>
            <a class="nav-link" href="<?= base_url('Lokasi/dataLokasi')?>">Data Lokasi</a>
            <a class="nav-link" href="<?= base_url('Lokasi/pemetaanLokasi')?>">Pemetaan Lokasi</a>
            <li class="nav-item">
              <a class="nav-link" href="<?= base_url('Home/simpan') ?>">
                    <i class="fas fa-location-dot"></i></i>
                    <span> Laporan Pertambangan</span></a>
            </li>
        </nav>
    </div>
</li>
<?php endif; ?>

            <?php if (in_groups('petugas')): ?>
                
 <hr class="sidebar-divider">  

    <div class="sidebar-heading">
        <i class="fas fa-users"></i>
        Laporan
        
    </div>
    <hr class="sidebar-divider d-none d-md-block">
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('/') ?>">
                <i class="fas fa-users"></i>
                <span>Laporan tambang</span></a>
          </li>        

                <?php endif; ?>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('logout') ?>">
                    <i class="fas fa-sign-out-alt"></i></i>
                    <span> Log out</span></a>
                </li>
                
                <!-- Sidebar Toggler (Sidebar) -->
                <div class="text-center d-none d-md-inline">
                    <button class="rounded-circle border-0" id="sidebarToggle"></button>
                </div>
          
        </ul>