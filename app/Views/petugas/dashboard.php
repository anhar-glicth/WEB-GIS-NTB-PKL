<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Dashboard Petugas</h1>

    <!-- Content Row (Kartu Statistik) -->
    <div class="row">
        <!-- Card Total -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Laporan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalLaporan; ?></div>
                        </div>
                        <div class="col-auto"><i class="fas fa-file-alt fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Card Pending -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Menunggu (Pending)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $laporanPending; ?></div>
                        </div>
                        <div class="col-auto"><i class="fas fa-clock fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card ACC -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Disetujui</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $laporanAcc; ?></div>
                        </div>
                        <div class="col-auto"><i class="fas fa-check-circle fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Tolak -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Ditolak</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $laporanTolak; ?></div>
                        </div>
                        <div class="col-auto"><i class="fas fa-times-circle fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row (Tabel Laporan Terbaru) -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Laporan Terbaru Masuk (5 Terakhir)</h6>
            
            <!-- TOMBOL LIHAT LEBIH BANYAK (INI SOLUSINYA) -->
            <a href="<?= base_url('petugas/laporan'); ?>" class="btn btn-sm btn-primary shadow-sm">
                Lihat Semua Laporan <i class="fas fa-arrow-right fa-sm text-white-50"></i>
            </a>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Pengguna</th>
                            <th>Blok Tambang</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($laporanTerbaru)): ?>
                            <tr><td colspan="5" class="text-center py-3">Belum ada data laporan masuk.</td></tr>
                        <?php else: ?>
                            <?php foreach ($laporanTerbaru as $row) : ?>
                            <tr>
                                <td><?= date('d/m/Y H:i', strtotime($row['created_at'])); ?></td>
                                <td><?= esc($row['username']); ?></td>
                                <td><?= esc($row['nama_blok'] ?? 'Judul: ' . ($row['judul'] ?? '-')); ?></td>
                                <td class="text-center">
                                    <?php if($row['status']=='acc'): ?>
                                        <span class="badge badge-success">Disetujui</span>
                                    <?php elseif($row['status']=='tolak'): ?>
                                        <span class="badge badge-danger">Ditolak</span>
                                    <?php else: ?>
                                        <span class="badge badge-warning">Pending</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <!-- Link ke Detail menggunakan route baru detail_laporan -->
                                    <a href="<?= base_url('petugas/detail_laporan/' . $row['id']); ?>" class="btn btn-info btn-sm shadow-sm">
                                        <i class="fas fa-eye"></i> Periksa
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
<?= $this->endSection(); ?>