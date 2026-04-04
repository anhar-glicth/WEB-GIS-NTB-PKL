<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>

<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Monitoring Laporan Wilayah</h1>
        <div class="d-none d-sm-inline-block">
            <span class="badge badge-info shadow-sm p-2 px-3 border-0" style="font-size: 0.85rem; background-color: #4e73df; color: white;">
                <i class="fas fa-list mr-1"></i> Total: <?= count($laporan) ?> Berkas
            </span>
        </div>
    </div>

    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success border-0 shadow-sm mb-4">
            <i class="fas fa-check-circle mr-2"></i> <?= session()->getFlashdata('message') ?>
        </div>
    <?php endif; ?>

    <!-- Main Table Card -->
    <div class="card shadow border-0 rounded-lg overflow-hidden text-sm">
        <div class="card-header py-3 bg-white border-bottom">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-table mr-2"></i>Data Laporan Masuk
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-light text-secondary small font-weight-bold">
                        <tr>
                            <th class="pl-4 py-3 border-0 text-center" width="50">NO</th>
                            <th class="py-3 border-0">JUDUL LAPORAN</th>
                            <th class="py-3 border-0">PENGIRIM (USER)</th>
                            <th class="py-3 border-0 text-center">STATUS</th>
                            <th class="py-3 border-0 text-center">FILE</th>
                            <th class="py-3 border-0 text-right pr-4">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($laporan as $row): ?>
                        <tr class="align-middle border-bottom">
                            <td class="pl-4 py-4 text-center font-weight-bold text-dark"><?= $i++; ?></td>
                            <td class="py-4">
                                <span class="text-dark font-weight-bold d-block mb-1"><?= esc($row['judul']) ?></span>
                                <small class="text-muted"><i class="fas fa-clock mr-1"></i> <?= date('d M Y', strtotime($row['created_at'])) ?></small>
                            </td>
                            <td class="py-4 font-weight-bold text-primary"><?= strtoupper(esc($row['username'])) ?></td>
                            <td class="py-4 text-center">
                                <?php 
                                    $status = strtolower($row['status']);
                                    if ($status == 'pending'): ?>
                                    <span class="badge badge-warning px-3 py-2 rounded-pill shadow-sm small font-weight-bold">PENDING</span>
                                <?php elseif ($status == 'acc' || $status == 'disetujui'): ?>
                                    <span class="badge badge-success px-3 py-2 rounded-pill shadow-sm small font-weight-bold text-white">DISETUJUI</span>
                                <?php elseif ($status == 'tolak' || $status == 'ditolak'): ?>
                                    <span class="badge badge-danger px-3 py-2 rounded-pill shadow-sm small font-weight-bold text-white">DITOLAK</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary px-3 py-2 rounded-pill small"><?= strtoupper($row['status']) ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="py-4 text-center">
                                <?php if (!empty($row['file'])) : ?>
                                    <a href="<?= base_url('petugas/download/' . $row['id']) ?>" class="btn btn-sm btn-outline-info rounded-pill px-3 py-1 shadow-sm font-weight-bold" style="font-size: 0.75rem;">
                                        <i class="fas fa-file-download mr-1"></i> Lihat File
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted small italic">N/A</span>
                                <?php endif; ?>
                            </td>
                            <td class="py-4 text-right pr-4">
                                <a href="<?= base_url('petugas/detail_laporan/' . $row['id']) ?>" class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm font-weight-bold transition-up" style="font-size: 0.75rem; background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border:none;">
                                    <i class="fas fa-eye mr-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .rounded-lg { border-radius: 1rem !important; }
    .table thead th { letter-spacing: 0.05em; text-transform: uppercase; font-size: 0.75rem; border-bottom: none !important; }
    .table tbody tr:hover { background-color: #f8f9fc !important; cursor: pointer; }
    .badge { font-family: 'Inter', sans-serif; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
    .transition-up { transition: transform 0.2s; }
    .transition-up:hover { transform: translateY(-2px); }
</style>

<?= $this->endSection() ?>
