<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>
<div class="container-fluid">
    <h3 class="mb-4 text-gray-800">Detail Laporan</h3>

    <div class="card shadow p-4">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Judul:</strong> <?= esc($laporan['judul']); ?></p>
                <p><strong>Nama Blok:</strong> <?= esc($laporan['nama_blok'] ?? '-'); ?></p>
                <p><strong>Luas (Ha):</strong> <?= esc($laporan['luas_ha'] ?? '-'); ?></p>
                <p><strong>Status:</strong>
                    <?php if ($laporan['status'] == 'acc'): ?>
                        <span class="badge badge-success">Disetujui</span>
                    <?php elseif ($laporan['status'] == 'tolak'): ?>
                        <span class="badge badge-danger">Ditolak</span>
                    <?php else: ?>
                        <span class="badge badge-warning">Pending</span>
                    <?php endif; ?>
                </p>
                <p><strong>Nama Pengguna:</strong> <?= esc($laporan['username']); ?></p>
                <p><strong>Email:</strong> <?= esc($laporan['email']); ?></p>
            </div>

            <div class="col-md-6">
                <p><strong>SD Tereka Volume:</strong> <?= esc($laporan['sd_tereka_volume'] ?? '-'); ?></p>
                <p><strong>SD Terunjuk Tonase:</strong> <?= esc($laporan['sd_terunjuk_tonase'] ?? '-'); ?></p>
                <p><strong>SD Terukur Volume:</strong> <?= esc($laporan['sd_terukur_volume'] ?? '-'); ?></p>
                <p><strong>CD Terbukti Tonase:</strong> <?= esc($laporan['cd_terbukti_tonase'] ?? '-'); ?></p>
                <p><strong>Produksi Harian:</strong> <?= esc($laporan['prod_harian'] ?? '-'); ?></p>
                <p><strong>Produksi Tahunan:</strong> <?= esc($laporan['prod_tahunan'] ?? '-'); ?></p>
                <p><strong>File:</strong>
                    <a href="<?= base_url('uploads/' . $laporan['file']); ?>" target="_blank">
                        <?= esc($laporan['file']); ?>
                    </a>
                </p>
            </div>
        </div>

        <a href="<?= base_url('petugas') ?>" class="btn btn-secondary mt-3">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<?= $this->endSection() ?>
