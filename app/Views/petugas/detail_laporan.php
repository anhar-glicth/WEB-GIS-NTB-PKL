<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Verifikasi Laporan</h1>
        
        <!-- Status Badge -->
        <?php if ($laporan['status'] == 'acc'): ?>
            <span class="badge badge-success px-3 py-2"><i class="fas fa-check-circle"></i> Disetujui</span>
        <?php elseif ($laporan['status'] == 'tolak'): ?>
            <span class="badge badge-danger px-3 py-2"><i class="fas fa-times-circle"></i> Ditolak</span>
        <?php else: ?>
            <span class="badge badge-warning px-3 py-2"><i class="fas fa-clock"></i> Menunggu Verifikasi</span>
        <?php endif; ?>
    </div>

    <div class="row">
        <!-- DETAIL DATA TAMBANG -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-success text-white">
                    <h6 class="m-0 font-weight-bold">Data Laporan Tambang</h6>
                </div>
                <div class="card-body">
                    <!-- Tampilkan Detail Data (Sama seperti sebelumnya) -->
                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Judul Laporan</div>
                        <div class="col-md-8">: <?= esc($laporan['judul']); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Nama Blok</div>
                        <div class="col-md-8">: <?= esc($laporan['nama_blok'] ?? '-'); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Luas Area</div>
                        <div class="col-md-8">: <?= esc($laporan['luas_ha'] ?? '0'); ?> Ha</div>
                    </div>
                    
                    <hr>
                    <h6 class="font-weight-bold text-primary mb-3">Sumberdaya & Cadangan</h6>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li><small class="text-muted">SD Tereka (Vol):</small> <strong><?= number_format((float)($laporan['sd_tereka_volume'] ?? 0)); ?></strong></li>
                                <li><small class="text-muted">SD Terunjuk (Ton):</small> <strong><?= number_format((float)($laporan['sd_terunjuk_tonase'] ?? 0)); ?></strong></li>
                                <li><small class="text-muted">SD Terukur (Vol):</small> <strong><?= number_format((float)($laporan['sd_terukur_volume'] ?? 0)); ?></strong></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li><small class="text-muted">CD Terbukti (Ton):</small> <strong><?= number_format((float)($laporan['cd_terbukti_tonase'] ?? 0)); ?></strong></li>
                                <li><small class="text-muted">Produksi Harian:</small> <strong><?= number_format((float)($laporan['prod_harian'] ?? 0)); ?></strong></li>
                                <li><small class="text-muted">Produksi Tahunan:</small> <strong><?= number_format((float)($laporan['prod_tahunan'] ?? 0)); ?></strong></li>
                            </ul>
                        </div>
                    </div>

                    <hr>
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-4 font-weight-bold">File Lampiran</div>
                        <div class="col-md-8">
                            <?php if (!empty($laporan['file'])) : ?>
                                <a href="<?= base_url('petugas/download/' . $laporan['id']); ?>" class="btn btn-sm btn-info shadow-sm">
                                    <i class="fas fa-download fa-sm text-white-50"></i> Download Dokumen
                                </a>
                                <small class="d-block text-muted mt-1"><?= esc($laporan['file']); ?></small>
                            <?php else : ?>
                                <span class="text-danger font-italic">Tidak ada file dilampirkan</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- IDENTITAS PERUSAHAAN & AKSI -->
        <div class="col-lg-4">
            <!-- Card Identitas Perusahaan -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">Identitas Perusahaan</h6>
                </div>
                <div class="card-body">
                    <?php if ($perusahaan): ?>
                        <h5 class="font-weight-bold"><?= esc($perusahaan['nama_perusahaan']); ?></h5>
                        <p class="text-muted small mb-3"><i class="fas fa-map-marker-alt"></i> <?= esc($perusahaan['alamat_perusahaan']); ?></p>
                        <div class="mb-2">
                            <span class="d-block small font-weight-bold text-gray-600">Direktur Utama:</span>
                            <?= esc($perusahaan['nama_direktur']); ?>
                        </div>
                        <!-- ... data perusahaan lainnya ... -->
                    <?php else: ?>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> Data Perusahaan belum dilengkapi.
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- CARD AKSI VERIFIKASI (MODIFIED) -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-dark">Aksi Verifikasi</h6>
                </div>
                <div class="card-body text-center">
                    
                    <?php if ($laporan['status'] == 'pending') : ?>
                        <p class="small text-muted mb-3">Tentukan status laporan ini:</p>
                        <div class="d-flex justify-content-center">
                            <!-- Tombol ACC (Langsung) -->
                            <a href="<?= base_url('petugas/acc/' . $laporan['id']); ?>" 
                               class="btn btn-success btn-icon-split mr-2"
                               onclick="return confirm('Yakin menyetujui laporan ini?');">
                                <span class="icon text-white-50"><i class="fas fa-check"></i></span>
                                <span class="text">Setujui</span>
                            </a>

                            <!-- Tombol TOLAK (Pemicu Modal) -->
                            <button type="button" class="btn btn-danger btn-icon-split" data-toggle="modal" data-target="#modalTolak">
                                <span class="icon text-white-50"><i class="fas fa-times"></i></span>
                                <span class="text">Tolak</span>
                            </button>
                        </div>
                    <?php else : ?>
                        <div class="alert alert-secondary mb-0">
                            Status: <strong><?= strtoupper($laporan['status']); ?></strong>
                            <?php if($laporan['status'] == 'tolak' && !empty($laporan['catatan_penolakan'])): ?>
                                <hr>
                                <small class="text-left d-block"><strong>Catatan:</strong><br><?= esc($laporan['catatan_penolakan']); ?></small>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

    <a href="<?= base_url('petugas/laporan') ?>" class="btn btn-secondary mb-4">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
    </a>
</div>

<!-- MODAL TOLAK -->
<div class="modal fade" id="modalTolak" tabindex="-1" role="dialog" aria-labelledby="modalTolakLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalTolakLabel">Tolak Laporan</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Form mengarah ke method tolak di controller -->
            <form action="<?= base_url('petugas/tolak/' . $laporan['id']); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="catatan" class="font-weight-bold">Alasan Penolakan / Catatan Revisi:</label>
                        <textarea class="form-control" id="catatan" name="catatan_penolakan" rows="4" required placeholder="Contoh: Data tonase tidak sesuai dengan lampiran PDF. Mohon perbaiki."></textarea>
                        <small class="text-muted">Catatan ini akan muncul di dashboard user.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Kirim Penolakan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>