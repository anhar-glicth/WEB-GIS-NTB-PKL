<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid py-4">
    <!-- Row Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Dashboard Petugas Lapangan</h1>
        <div class="d-none d-sm-inline-block">
            <span class="badge badge-primary-light text-primary px-3 py-2 rounded-pill shadow-sm small">
                <i class="fas fa-calendar-day mr-1"></i> <?= date('d M Y') ?>
            </span>
        </div>
    </div>

    <!-- STATS CARDS GRID -->
    <div class="row mb-4">
        <!-- Dashboard Total -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm rounded-lg h-100 bg-primary text-white overflow-hidden transition-card">
                <div class="card-body p-4 position-relative">
                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-8">Total Masuk</div>
                    <div class="h2 mb-0 font-weight-bold"><?= $totalLaporan; ?></div>
                    <div class="position-absolute" style="right: 20px; bottom: 20px; opacity: 0.2;">
                        <i class="fas fa-file-invoice fa-3x"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm rounded-lg h-100 bg-white border-left-warning transition-card">
                <div class="card-body p-4">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Verifikasi Pending</div>
                    <div class="h2 mb-0 font-weight-bold text-gray-800"><?= $laporanPending; ?></div>
                    <div class="small mt-2 text-muted italic">Butuh penanganan segera</div>
                </div>
            </div>
        </div>

        <!-- ACC Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm rounded-lg h-100 bg-white border-left-success transition-card">
                <div class="card-body p-4">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Telah Disetujui</div>
                    <div class="h2 mb-0 font-weight-bold text-gray-800"><?= $laporanAcc; ?></div>
                    <div class="small mt-2 text-muted italic">Data yang sudah diverifikasi</div>
                </div>
            </div>
        </div>

        <!-- Rejected Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm rounded-lg h-100 bg-white border-left-danger transition-card">
                <div class="card-body p-4">
                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Ditolak / Revisi</div>
                    <div class="h2 mb-0 font-weight-bold text-gray-800"><?= $laporanTolak; ?></div>
                    <div class="small mt-2 text-muted italic text-danger-light font-weight-bold">Perlu tindak lanjut</div>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN MONITORING TABLE -->
    <div class="card shadow-sm border-0 rounded-lg overflow-hidden">
        <div class="card-header py-3 bg-white d-flex align-items-center justify-content-between px-4">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-tasks mr-2"></i>Laporan Masuk Terbaru</h6>
            <a href="<?= base_url('petugas/laporan'); ?>" class="btn btn-sm btn-outline-info rounded-pill px-3 shadow-none small transition">
                Lihat Seluruh Laporan <i class="fas fa-external-link-alt ml-1 fa-xs"></i>
            </a>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" width="100%" cellspacing="0">
                    <thead class="bg-light text-secondary small font-weight-bold">
                        <tr>
                            <th class="pl-4 py-3 border-0">WAKTU MASUK</th>
                            <th class="py-3 border-0">USERNAME</th>
                            <th class="py-3 border-0">NAMA BLOK / JUDUL</th>
                            <th class="py-3 border-0 text-center">STATUS</th>
                            <th class="py-3 border-0 text-right pr-4">OPERASI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($laporanTerbaru)): ?>
                            <tr><td colspan="5" class="text-center py-5 text-muted">Belum ada laporan baru yang perlu ditinjau.</td></tr>
                        <?php else: ?>
                            <?php foreach ($laporanTerbaru as $row) : ?>
                            <tr class="align-middle">
                                <td class="pl-4 py-4 small font-weight-600 text-dark">
                                    <?= date('d M Y', strtotime($row['created_at'] ?? 'now')); ?><br>
                                    <span class="text-muted small"><?= date('H:i', strtotime($row['created_at'] ?? 'now')); ?></span>
                                </td>
                                <td class="py-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-min rounded bg-light mr-2 d-flex align-items-center justify-content-center">
                                            <i class="fas fa-user-tie text-muted small"></i>
                                        </div>
                                        <div class="small font-weight-bold"><?= esc($row['username'] ?? 'Anonymous'); ?></div>
                                    </div>
                                </td>
                                <td class="py-4 font-weight-bold text-primary-dark">
                                    <?= esc($row['nama_blok'] ?? (substr($row['judul'] ?? 'Laporan Tanpa Judul', 0, 30))); ?>
                                </td>
                                <td class="py-4 text-center">
                                    <?php if(strtolower($row['status'] ?? '') == 'acc'): ?>
                                        <span class="badge badge-soft-success px-3 py-2 rounded-pill"><i class="fas fa-check-circle mr-1"></i> ACC</span>
                                    <?php elseif(strtolower($row['status'] ?? '') == 'tolak'): ?>
                                        <span class="badge badge-soft-danger px-3 py-2 rounded-pill"><i class="fas fa-times-circle mr-1"></i> TOLAK</span>
                                    <?php else: ?>
                                        <span class="badge badge-soft-warning px-3 py-2 rounded-pill"><i class="fas fa-hourglass-half mr-1 text-dark"></i> PENDING</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-4 text-right pr-4">
                                    <a href="<?= base_url('petugas/detail_laporan/' . ($row['id'] ?? '')); ?>" class="btn btn-sm btn-link-action text-primary transition">
                                        Periksa <i class="fas fa-chevron-right ml-1 small"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .rounded-lg { border-radius: 12px !important; }
    .border-left-primary { border-left: .25rem solid #4e73df!important; }
    .border-left-success { border-left: .25rem solid #1cc88a!important; }
    .border-left-warning { border-left: .25rem solid #f6c23e!important; }
    .border-left-danger { border-left: .25rem solid #e74a3b!important; }
    .badge-primary-light { background-color: rgba(78, 115, 223, 0.1); }
    .avatar-min { width: 30px; height: 30px; border: 1px solid #eeeff2; }
    .opacity-8 { opacity: 0.8; }
    .italic { font-style: italic; }
    .text-primary-dark { color: #2c3e50; font-size: 0.9rem; }
    .font-weight-600 { font-weight: 600; }
    
    /* Soft Badges */
    .badge-soft-success { background: #e8f5e9; color: #2e7d32; font-weight: 700; font-size: 0.65rem; letter-spacing: 0.5px; }
    .badge-soft-danger { background: #ffebee; color: #c62828; font-weight: 700; font-size: 0.65rem; letter-spacing: 0.5px; }
    .badge-soft-warning { background: #fff8e1; color: #f9a825; font-weight: 700; font-size: 0.65rem; letter-spacing: 0.5px; }

    .btn-link-action { font-weight: 700; font-size: 0.8rem; text-decoration: none !important; }
    .btn-link-action:hover { color: #224abe !important; transform: translateX(3px); }

    .transition-card { transition: all 0.3s ease; }
    .transition-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
</style>

<?= $this->endSection(); ?>