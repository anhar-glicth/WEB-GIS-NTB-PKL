<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>

<div class="container-fluid py-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-history mr-2 text-primary"></i> Status Verifikasi Koordinat</h1>
        <a href="<?= base_url('poligon') ?>" class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm">
            <i class="fas fa-plus mr-1"></i> Gambar Poligon Baru
        </a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0 rounded-xl overflow-hidden">
                <div class="card-header py-3 bg-white border-bottom">
                    <h6 class="m-0 font-weight-bold text-primary font-italic">Pelacakan Status Pengajuan Koordinat Wilayah Tambang</h6>
                </div>
                <div class="card-body p-0">
                    <?php if(session()->getFlashdata('success')): ?>
                        <div class="alert alert-success border-0 rounded-0 m-0"><i class="fas fa-check-circle mr-2"></i> <?= session()->getFlashdata('success') ?></div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle" id="dataTable" width="100%" cellspacing="0">
                            <thead class="bg-light text-dark font-weight-bold">
                                <tr>
                                    <th class="px-4 py-3" width="5%">#</th>
                                    <th>Identitas Perusahaan</th>
                                    <th>Status Verifikasi</th>
                                    <th>Catatan / Feedback Petugas</th>
                                    <th class="text-center">Titik</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                $grouped = [];
                                foreach ($koordinat as $k) {
                                    $key = $k['permit'];
                                    if (!isset($grouped[$key])) {
                                        $grouped[$key] = [
                                            'company'  => $k['companyName'],
                                            'location' => $k['locationName'],
                                            'status'   => $k['status'] ?? 'Pending',
                                            'note'     => $k['catatan_petugas'] ?? '-',
                                            'count'    => 0
                                        ];
                                    }
                                    $grouped[$key]['count']++;
                                }

                                foreach ($grouped as $permit => $data): ?>
                                    <tr>
                                        <td class="px-4 py-4 font-weight-bold text-muted"><?= $no++ ?></td>
                                        <td class="py-4">
                                            <div class="font-weight-bold text-dark mb-1"><?= $data['company'] ?></div>
                                            <div class="small text-muted"><i class="fas fa-id-badge mr-1"></i> Izin: <?= $permit ?></div>
                                        </td>
                                        <td class="py-4">
                                            <?php if($data['status'] == 'Pending'): ?>
                                                <span class="badge badge-warning px-3 py-2 rounded-pill"><i class="fas fa-spinner fa-spin mr-1"></i> MENUNGGU</span>
                                            <?php elseif($data['status'] == 'Disetujui'): ?>
                                                <span class="badge badge-success px-3 py-2 rounded-pill shadow-sm"><i class="fas fa-check-circle mr-1"></i> DISETUJUI</span>
                                            <?php else: ?>
                                                <span class="badge badge-danger px-3 py-2 rounded-pill shadow-sm"><i class="fas fa-times-circle mr-1"></i> DITOLAK</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="py-4 small italic text-muted" style="max-width: 300px;">
                                            <?php if($data['status'] == 'Ditolak'): ?>
                                                <div class="p-2 border-left-danger bg-light text-dark shadow-sm">
                                                    <i class="fas fa-comment-dots text-danger mr-1"></i> "<?= $data['note'] ?>"
                                                </div>
                                            <?php elseif($data['status'] == 'Disetujui'): ?>
                                                <span class="text-success ml-1 font-weight-bold">✓ Peta Berhasil Dipublikasikan</span>
                                            <?php else: ?>
                                                <span class="ml-1">- Sedang diperiksa -</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center py-4">
                                            <span class="badge badge-secondary px-3 py-1"><?= $data['count'] ?> Titik</span>
                                        </td>
                                        <td class="text-center py-4 px-4">
                                            <?php if($data['status'] != 'Disetujui'): ?>
                                                <a href="<?= base_url('poligon/hapusByPermit/' . $permit) ?>" 
                                                   class="btn btn-outline-danger btn-sm rounded-pill px-3"
                                                   onclick="return confirm('Hapus pengajuan poligon ini?')">
                                                    <i class="fas fa-trash fa-xs mr-1"></i> Batal / Hapus
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted small"><i class="fas fa-lock"></i> Terkunci</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php if(empty($grouped)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted h6 font-italic">
                                            <i class="fas fa-folder-open fa-2x mb-2 d-block opacity-25"></i>
                                            Anda belum pernah mengirimkan data koordinat poligon.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .rounded-xl { border-radius: 1rem !important; }
    .italic { font-style: italic; }
    .border-left-danger { border-left: 3px solid #e74a3b !important; }
    .badge-primary-soft { background: rgba(78, 115, 223, 0.1); }
</style>

<?= $this->endSection() ?>
