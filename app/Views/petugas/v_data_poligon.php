<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid py-4">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-5">
        <div>
            <h1 class="h3 mb-1 text-gray-900 font-weight-bold">Verifikasi Koordinat Wilayah</h1>
            <p class="text-muted small mb-0">Manajemen persetujuan area poligon pertambangan di wilayah NTB.</p>
        </div>
        <div class="badge badge-primary-soft p-3 rounded-lg border">
            <i class="fas fa-microchip text-primary mr-2"></i> Dashboard Monitoring Petugas
        </div>
    </div>

    <!-- Alert Success / Error -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success border-0 shadow-sm rounded-xl mb-4 py-3"><i class="fas fa-check-circle mr-2"></i> <?= session()->getFlashdata('success'); ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger border-0 shadow-sm rounded-xl mb-4 py-3"><i class="fas fa-exclamation-circle mr-2"></i> <?= session()->getFlashdata('error'); ?></div>
    <?php endif; ?>

    <div class="card shadow-2xl border-0 rounded-3xl overflow-hidden" style="border-radius: 1.5rem !important;">
        <div class="card-header py-4 bg-white border-bottom d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-dark"><i class="fas fa-list-ul mr-2 text-primary"></i> Antrian Persetujuan Area</h6>
            <span class="badge badge-light border px-3 py-2 text-muted fw-normal"><?= count($poligon) ?> Pengajuan</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-light-soft text-muted small text-uppercase font-weight-bold">
                        <tr class="text-center">
                            <th width="5%" class="px-4 py-3 border-0">ID</th>
                            <th class="text-left border-0">Identitas & Legalitas</th>
                            <th class="border-0">Status Sistem</th>
                            <th class="border-0">Geometri Area</th>
                            <th class="border-0">Dokumentasi</th>
                            <th width="18%" class="px-4 py-3 border-0 text-primary">Panel Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody class="text-dark">
                        <?php if(empty($poligon)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-box-4344464-3613915.png" style="width: 150px; opacity: 0.6;" class="mb-3 d-block mx-auto">
                                    <span class="text-muted italic h6">Semua data sudah bersih. Belum ada antrian baru.</span>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $i = 1; foreach ($poligon as $permit => $data) : ?>
                            <tr class="transition-all hover-bg-light">
                                <td class="text-center px-4 font-weight-bold text-muted"><?= $i++; ?></td>
                                <td class="py-4">
                                    <div class="font-weight-bold text-dark h6 mb-1"><?= esc($data['companyName']); ?></div>
                                    <div class="text-primary font-weight-bold small"><span class="badge badge-primary-soft">Izin: <?= $permit ?></span></div>
                                    <div class="mt-1"><small class="text-muted"><i class="fas fa-map-marker-alt mr-1"></i> Site: <?= esc($data['locationName']); ?></small></div>
                                </td>
                                <td class="text-center py-4">
                                    <?php if($data['status'] == 'Pending'): ?>
                                        <div class="status-pill status-pending"><i class="fas fa-clock mr-1"></i> WAITING</div>
                                    <?php elseif($data['status'] == 'Disetujui'): ?>
                                        <div class="status-pill status-approved"><i class="fas fa-check-circle mr-1"></i> VERIFIED</div>
                                    <?php else: ?>
                                        <div class="status-pill status-rejected"><i class="fas fa-times-circle mr-1"></i> REJECTED</div>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center py-4">
                                    <div class="font-weight-bold text-dark mb-0"><?= $data['titik_count'] ?> Titik</div>
                                    <small class="text-muted d-block italic tracking-tighter">Poligon Area</small>
                                </td>
                                <td class="text-center py-4">
                                    <div class="btn-group rounded-pill overflow-hidden border shadow-sm">
                                        <?php if($data['foto_lokasi']): ?>
                                            <a href="<?= base_url('uploads/lokasi/' . $data['foto_lokasi']); ?>" target="_blank" class="btn btn-white btn-sm px-3" title="Foto">
                                                <i class="fas fa-camera text-primary"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if($data['dokumen_pendukung']): ?>
                                            <a href="<?= base_url('uploads/dokumen/' . $data['dokumen_pendukung']); ?>" target="_blank" class="btn btn-white btn-sm px-3" title="PDF">
                                                <i class="fas fa-file-pdf text-danger"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="text-center py-4 px-4">
                                    <?php if($data['status'] == 'Pending'): ?>
                                        <div class="d-flex flex-column gap-2">
                                            <a href="<?= base_url('petugas/data-poligon/acc/' . $permit); ?>" 
                                               class="btn btn-primary btn-sm rounded-pill font-weight-bold mb-2 shadow-sm py-2" 
                                               onclick="return confirm('Apakah Anda yakin data ini sudah valid?');">
                                                <i class="fas fa-check-double mr-1"></i> TERIMA (ACC)
                                            </a>
                                            <button type="button" class="btn btn-outline-warning btn-sm rounded-pill font-weight-bold py-2" 
                                                    data-toggle="modal" data-target="#tolakModal<?= str_replace('/', '_', $permit) ?>">
                                                <i class="fas fa-comment-slash mr-1"></i> TOLAK AREA
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                    <a href="<?= base_url('petugas/data-poligon/hapus/' . $permit); ?>" 
                                       class="btn btn-link text-danger btn-sm mt-2 text-decoration-none small" 
                                       onclick="return confirm('Hapus permanen area ini?');">
                                        <i class="fas fa-trash-alt mr-1"></i> Hapus Data
                                    </a>
                                </td>
                            </tr>

                            <!-- MODAL TOLAK (REFINED) -->
                            <div class="modal fade" id="tolakModal<?= str_replace('/', '_', $permit) ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <form action="<?= base_url('petugas/data-poligon/tolak/' . $permit) ?>" method="POST" class="w-100">
                                        <?= csrf_field() ?>
                                        <div class="modal-content border-0 shadow-2xl rounded-3xl" style="border-radius: 1.5rem !important;">
                                            <div class="modal-header bg-white border-0 py-4 px-4">
                                                <div>
                                                    <h5 class="modal-title font-weight-bold text-dark h4">Konfirmasi Penolakan</h5>
                                                    <p class="text-muted small mb-0">Berikan alasan mengapa area ini tidak disetujui.</p>
                                                </div>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body px-4 py-2">
                                                <textarea name="catatan" class="form-control bg-light border-0 py-3 px-3 rounded-xl shadow-inner-sm" rows="5" placeholder="Contoh: Koordinat tidak sesuai dengan IUP, lampiran PDF terpotong." required></textarea>
                                            </div>
                                            <div class="modal-footer border-0 p-4">
                                                <button type="submit" class="btn btn-warning btn-block py-3 font-weight-bold rounded-pill shadow-lg">KIRIM KEPUTUSAN PENOLAKAN</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-light-soft { background-color: #f8f9fc; }
    .rounded-xl { border-radius: 1rem !important; }
    .shadow-2xl { box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1) !important; }
    .badge-primary-soft { background: rgba(78, 115, 223, 0.08); border: 1px solid rgba(78, 115, 223, 0.15) !important; }
    .status-pill { display: inline-flex; align-items: center; padding: 0.5rem 1.25rem; border-radius: 50rem; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px; }
    .status-pending { background: #fef9e7; color: #f1c40f; }
    .status-approved { background: #e8f8f5; color: #2ecc71; }
    .status-rejected { background: #fdedec; color: #e74a3b; }
    .btn-white { background: #fff; }
    .btn-white:hover { background: #f8f9fc; }
    .hover-bg-light:hover { background-color: #fafbfc; transition: 0.2s; }
    .italic { font-style: italic; }
    .tracking-tighter { letter-spacing: -0.02em; }
    .shadow-inner-sm { box-shadow: inset 0 2px 4px 0 rgba(0,0,0,0.06); }
</style>

<?= $this->endSection(); ?>