<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Dashboard Pengguna</h1>

    <!-- 1. KARTU STATISTIK -->
    <div class="row">
        <!-- Card Profil -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Profil Saya</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= user()->username; ?></div>
                            <div class="text-xs text-gray-500"><?= user()->email; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Total -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Laporan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalLaporan ?? 0; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Disetujui -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Disetujui (ACC)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $approvedLaporan ?? 0; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Ditolak -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Ditolak / Revisi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $rejectedLaporan ?? 0; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. TABEL STATUS LAPORAN (FITUR YANG ANDA MINTA) -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Riwayat Status Laporan Anda</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr class="text-center">
                            <th width="5%">No</th>
                            <th>Nama Blok / Judul</th>
                            <th>Tanggal Upload</th>
                            <th>Status</th>
                            <th>Catatan / Pesan Petugas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($daftarLaporan)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-3">
                                    <span class="text-gray-500">Anda belum mengupload laporan apapun.</span><br>
                                    <a href="<?= base_url('user/input-tambang'); ?>" class="btn btn-primary btn-sm mt-2">
                                        <i class="fas fa-plus"></i> Upload Sekarang
                                    </a>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $i = 1; foreach ($daftarLaporan as $row) : ?>
                            <tr>
                                <td class="text-center align-middle"><?= $i++; ?></td>
                                <td class="align-middle">
                                    <strong><?= esc($row['nama_blok']); ?></strong><br>
                                    <small class="text-muted">Luas: <?= esc($row['luas_ha']); ?> Ha</small>
                                </td>
                                <td class="align-middle text-center"><?= date('d M Y', strtotime($row['created_at'])); ?></td>
                                <td class="align-middle text-center">
                                    <?php 
                                        $status = strtolower($row['status']);
                                        if($status == 'acc' || $status == 'disetujui'): 
                                    ?>
                                        <span class="badge badge-success px-3 py-2 shadow-sm rounded-pill"><i class="fas fa-check-circle mr-1"></i> Disetujui</span>
                                    <?php elseif($status == 'tolak' || $status == 'ditolak'): ?>
                                        <span class="badge badge-danger px-3 py-2 shadow-sm rounded-pill"><i class="fas fa-times-circle mr-1"></i> Ditolak</span>
                                    <?php else: ?>
                                        <span class="badge badge-warning px-3 py-2 shadow-sm rounded-pill"><i class="fas fa-clock mr-1"></i> Pending</span>
                                    <?php endif; ?>
                                </td>
                                <td class="align-middle">
                                    <?php if($status == 'tolak' || $status == 'ditolak'): ?>
                                        <!-- Tampilkan Catatan Jika Ditolak -->
                                        <div class="alert alert-danger py-2 px-3 small mb-2 border-0 shadow-sm">
                                            <strong><i class="fas fa-comment-dots"></i> Pesan Petugas:</strong><br>
                                            <?= !empty($row['catatan_penolakan']) ? esc($row['catatan_penolakan']) : 'Tidak ada catatan spesifik.'; ?>
                                        </div>
                                        
                                        <!-- Tombol Perbaiki -->
                                        <a href="<?= base_url('user/input-tambang'); ?>" class="btn btn-sm btn-warning shadow-sm rounded-pill px-3">
                                            <i class="fas fa-edit"></i> Perbaiki / Upload Ulang
                                        </a>

                                    <?php elseif($status == 'acc' || $status == 'disetujui'): ?>
                                        <span class="text-success small font-weight-bold"><i class="fas fa-check-circle"></i> Laporan valid & terverifikasi.</span>
                                    <?php else: ?>
                                        <span class="text-muted small"><em>Sedang menunggu pemeriksaan...</em></span>
                                    <?php endif; ?>
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

<?= $this->endSection() ?>