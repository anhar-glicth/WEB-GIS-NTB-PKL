<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>

<div class="container-fluid py-4">
    <!-- Row Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Admin Dashboard</h1>
        <div class="d-none d-sm-inline-block">
            <span class="badge badge-primary-light text-primary px-3 py-2 rounded-pill shadow-sm small">
                <i class="fas fa-calendar-day mr-1"></i> <?= date('d M Y') ?>
            </span>
        </div>
    </div>

    <!-- STATS CARDS (Dinamis & Real-time) -->
    <div class="row">

        <!-- Total User Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 border-left-primary shadow h-100 py-2 rounded-lg transition-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Pengguna</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($total_users) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Role Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 border-left-success shadow h-100 py-2 rounded-lg transition-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Role / Jabatan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($total_groups) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-shield fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Reports Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 border-left-warning shadow h-100 py-2 rounded-lg transition-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Persetujuan Pending</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($pending_laporan ?? 0) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Approved Reports Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 border-left-info shadow h-100 py-2 rounded-lg transition-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Laporan Disetujui</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($acc_laporan ?? 0) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-signature fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- RECENT ACTIVITIES & INFO -->
    <div class="row">
        <!-- Pengguna Baru -->
        <div class="col-lg-8">
            <div class="card shadow mb-4 border-0 rounded-lg overflow-hidden">
                <div class="card-header py-3 bg-white d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Pengguna Terbaru</h6>
                    <a href="<?= base_url('admin/user-list') ?>" class="small font-weight-bold text-primary">Lihat Semua <i class="fas fa-arrow-right ml-1"></i></a>
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
                                    <td class="text-muted"><?= date('d M Y', strtotime($user->created_at)) ?></td>
                                    <td class="text-right pr-4">
                                        <a href="<?= base_url('admin/detail/' . ($user->userid ?? '')); ?>" class="btn btn-sm btn-light border p-1 px-2 rounded-lg" title="Lihat Profil">
                                            <i class="fas fa-chevron-right fa-xs"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Card Admin -->
        <div class="col-lg-4">
            <div class="card shadow mb-4 border-0 rounded-lg bg-primary text-white overflow-hidden shadow-lg">
                <div class="card-body text-center py-5 position-relative">
                    <div class="mb-4">
                         <i class="fas fa-shield-alt fa-3x mb-3 text-white-50"></i>
                    </div>
                    <h5 class="font-weight-bold">Administrator Panel</h5>
                    <p class="small opacity-8 px-3">Selamat datang di pusat kendali SIG-NTB. Anda memiliki otoritas penuh untuk mengelola data tambang dan akun pengguna.</p>
                    <a href="<?= base_url('admin/settings') ?>" class="btn btn-light btn-sm rounded-pill px-4 font-weight-bold text-primary mt-3">Settings</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .rounded-lg { border-radius: 12px !important; }
    .border-left-primary { border-left: .25rem solid #4e73df!important; }
    .border-left-success { border-left: .25rem solid #1cc88a!important; }
    .border-left-warning { border-left: .25rem solid #f6c23e!important; }
    .border-left-info { border-left: .25rem solid #36b9cc!important; }
    .badge-primary-light { background-color: rgba(78, 115, 223, 0.1); }
    .opacity-8 { opacity: 0.8; }
    .transition-card { transition: transform 0.2s ease; }
    .transition-card:hover { transform: translateY(-3px); }
</style>

<?= $this->endSection() ?>
