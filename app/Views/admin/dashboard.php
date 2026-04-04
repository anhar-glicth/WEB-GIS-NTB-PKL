<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>

<div class="container-fluid py-4">
    <!-- Row Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Admin Dashboard</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm rounded-pill px-3">
            <i class="fas fa-download fa-sm text-white-50 mr-1"></i> Generate Report
        </a>
    </div>

    <!-- STATS CARDS -->
    <div class="row">

        <!-- Total User Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2 border-0 rounded-lg">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Pengguna</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_users ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Groups Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2 border-0 rounded-lg">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Role / Jabatan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_groups ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-tag fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Placeholder for Reports -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2 border-0 rounded-lg">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Laporan
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">12</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar"
                                            style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Map Points -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2 border-0 rounded-lg">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Lokasi Tambang</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">24</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-map-marked-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- RECENT ACTIVITIES -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4 border-0 rounded-lg overflow-hidden">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">Pengguna Terbaru</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light small font-weight-bold">
                                <tr>
                                    <th class="pl-4 py-3">Username</th>
                                    <th class="py-3">Role</th>
                                    <th class="py-3">Waktu Daftar</th>
                                    <th class="py-3 text-right pr-4">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_users as $user): ?>
                                <tr class="small align-middle text-dark">
                                    <td class="pl-4 py-3 font-weight-bold">
                                        <i class="fas fa-user-circle mr-2 text-muted"></i><?= $user->username ?>
                                    </td>
                                    <td>
                                        <span class="badge badge-primary-light text-primary px-2 py-1 rounded">
                                            <?= strtoupper($user->role) ?>
                                        </span>
                                    </td>
                                    <td class="text-muted"><?= date('d M Y, H:i', strtotime($user->created_at)) ?></td>
                                    <td class="text-right pr-4">
                                        <button class="btn btn-sm btn-light border p-1 px-2 rounded-lg" title="Lihat Profil">
                                            <i class="fas fa-chevron-right fa-xs"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white text-center py-2">
                    <a href="<?= base_url('admin/user-list') ?>" class="small font-weight-bold text-primary">Lihat Semua User <i class="fas fa-arrow-right ml-1"></i></a>
                </div>
            </div>
        </div>

        <!-- INFO CARD -->
        <div class="col-lg-4">
            <div class="card shadow mb-4 border-0 rounded-lg bg-gradient-primary text-white">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <div class="avatar-lg mx-auto bg-white-translucent d-flex align-items-center justify-content-center rounded-circle shadow" style="width: 70px; height: 70px;">
                            <i class="fas fa-shield-alt fa-2x text-white"></i>
                        </div>
                    </div>
                    <h5 class="font-weight-bold">Halo, Administrator!</h5>
                    <p class="small opacity-8 px-4">Selamat datang kembali di sistem GIS-NTB. Anda memiliki kontrol penuh atas manajemen data dan keamanan akun.</p>
                    <a href="<?= base_url('admin/settings') ?>" class="btn btn-light btn-sm rounded-pill px-4 font-weight-bold text-primary shadow-sm mt-3">Konfigurasi Situs</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .border-left-primary { border-left: .25rem solid #4e73df!important; }
    .border-left-success { border-left: .25rem solid #1cc88a!important; }
    .border-left-info { border-left: .25rem solid #36b9cc!important; }
    .border-left-warning { border-left: .25rem solid #f6c23e!important; }
    .bg-gradient-primary { background: linear-gradient(180deg, #4e73df 10%, #224abe 100%); background-size: cover; }
    .bg-white-translucent { background: rgba(255,255,255,0.2); }
    .opacity-8 { opacity: 0.8; }
    .badge-primary-light { background-color: rgba(78, 115, 223, 0.1); }
</style>

<?= $this->endSection() ?>
