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

        <!-- IDENTITAS & AKSI -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">Identitas Perusahaan</h6>
                </div>
                <div class="card-body">
                    <?php if ($perusahaan): ?>
                        <h5 class="font-weight-bold"><?= esc($perusahaan['nama_perusahaan']); ?></h5>
                        <p class="text-muted small mb-3"><?= esc($perusahaan['alamat_perusahaan']); ?></p>
                        <div class="mb-2">
                            <span class="d-block small font-weight-bold">Direktur:</span> <?= esc($perusahaan['nama_direktur']); ?>
                        </div>
                        <div class="mb-2">
                            <span class="d-block small font-weight-bold">Kontak:</span> <?= esc($perusahaan['no_telepon']); ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning small">Data Perusahaan belum dilengkapi.</div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- CARD AKSI VERIFIKASI -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-dark">Aksi Verifikasi</h6>
                </div>
                <div class="card-body text-center">
                    
                    <?php if ($laporan['status'] == 'pending') : ?>
                        <p class="small text-muted mb-3">Tentukan status laporan ini:</p>
                        <div class="d-flex justify-content-center">
                            
                            <!-- Tombol ACC -->
                            <a href="<?= base_url('petugas/acc/' . $laporan['id']); ?>" 
                               class="btn btn-success btn-icon-split mr-2"
                               onclick="return confirm('Yakin menyetujui laporan ini?');">
                                <span class="icon text-white-50"><i class="fas fa-check"></i></span>
                                <span class="text">Setujui</span>
                            </a>

                            <!-- Tombol TOLAK (Pemicu Modal) -->
                            <!-- FIX: Menambahkan support atribut BS4 (data-toggle) dan BS5 (data-bs-toggle) -->
                            <button type="button" class="btn btn-danger btn-icon-split" 
                                    data-toggle="modal" data-target="#modalTolak"
                                    data-bs-toggle="modal" data-bs-target="#modalTolak">
                                <span class="icon text-white-50"><i class="fas fa-times"></i></span>
                                <span class="text">Tolak</span>
                            </button>

                        </div>
                    <?php else : ?>
                        <div class="alert alert-secondary mb-0 small">
                            Status: <strong><?= strtoupper($laporan['status']); ?></strong>
                            <?php if($laporan['status'] == 'tolak' && !empty($laporan['catatan_penolakan'])): ?>
                                <hr class="my-2">
                                <div class="text-left"><strong>Catatan:</strong> <?= esc($laporan['catatan_penolakan']); ?></div>
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

<!-- ========================================== -->
<!-- MODAL POP-UP (Bagian yang membuat tombol Tolak berfungsi) -->
<!-- ========================================== -->
<div class="modal fade" id="modalTolak" tabindex="-1" role="dialog" aria-labelledby="modalTolakLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalTolakLabel">Konfirmasi Penolakan</h5>
                <!-- Tombol Close (Support BS4 & BS5) -->
                <button type="button" class="close text-white" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form action="<?= base_url('petugas/tolak/' . $laporan['id']); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="catatan" class="font-weight-bold text-gray-800">Alasan Penolakan:</label>
                        <textarea class="form-control" id="catatan" name="catatan_penolakan" rows="4" required placeholder="Tuliskan alasan penolakan atau revisi di sini..."></textarea>
                        <small class="text-muted">Catatan ini akan dikirim ke user.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Kirim Penolakan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script Diagnosa (Otomatis cek jika modal macet) -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Cek apakah tombol tolak ada
        var btnTolak = document.querySelector('[data-target="#modalTolak"]');
        
        if(btnTolak) {
            btnTolak.addEventListener('click', function() {
                // Cek apakah jQuery tersedia (Wajib untuk Bootstrap Modal)
                if (typeof $ === 'undefined') {
                    alert('PERINGATAN SISTEM:\nLibrary jQuery tidak ditemukan.\n\nTombol Pop-up tidak bisa terbuka. Mohon periksa file template "header" atau "footer" Anda untuk memastikan script Bootstrap/jQuery sudah dimuat.');
                }
            });
        }
    });
</script>

<?= $this->endSection() ?>