<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-map text-primary"></i> Data Poligon Pertambangan</h1>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Titik Koordinat Masuk</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Perusahaan</th>
                            <th>Lokasi / Site</th>
                            <th>Izin</th>
                            <th>Koordinat (DMS)</th>
                            <th>Foto</th>
                            <th>Dokumen</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($poligon)): ?>
                            <tr>
                                <td colspan="8" class="text-center">Belum ada data poligon yang masuk.</td>
                            </tr>
                        <?php else: ?>
                            <?php $i = 1; foreach ($poligon as $row) : ?>
                            <tr>
                                <td class="text-center"><?= $i++; ?></td>
                                <td>
                                    <strong><?= esc($row['companyName']); ?></strong>
                                </td>
                                <td><?= esc($row['locationName']); ?></td>
                                <td><?= esc($row['permit']); ?></td>
                                <td class="small">
                                    <!-- Menampilkan Koordinat Lat/Long -->
                                    <strong>Lat:</strong> <?= $row['latitude_deg']; ?>&deg; <?= $row['latitude_min']; ?>' <?= $row['latitude_sec']; ?>" <?= $row['latitude_dir']; ?><br>
                                    <strong>Long:</strong> <?= $row['longitude_deg']; ?>&deg; <?= $row['longitude_min']; ?>' <?= $row['longitude_sec']; ?>" <?= $row['longitude_dir']; ?>
                                </td>
                                <td class="text-center">
                                    <?php if($row['foto_lokasi']): ?>
                                        <a href="<?= base_url('uploads/lokasi/' . $row['foto_lokasi']); ?>" target="_blank">
                                            <img src="<?= base_url('uploads/lokasi/' . $row['foto_lokasi']); ?>" alt="Foto" width="80" class="img-thumbnail">
                                        </a>
                                    <?php else: ?>
                                        <span class="badge badge-secondary">No Image</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if($row['dokumen_pendukung']): ?>
                                        <a href="<?= base_url('uploads/dokumen/' . $row['dokumen_pendukung']); ?>" class="btn btn-sm btn-info" target="_blank">
                                            <i class="fas fa-file-download"></i> Unduh
                                        </a>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('petugas/data-poligon/hapus/' . $row['id']); ?>" class="btn btn-danger btn-sm btn-circle" onclick="return confirm('Yakin ingin menghapus data ini?');" title="Hapus">
                                        <i class="fas fa-trash"></i>
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