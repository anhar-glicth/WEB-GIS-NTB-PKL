<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= esc($judul ?? 'Identitas Perusahaan'); ?></h1>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" width="100%">
                    <thead class="table-primary">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama Perusahaan</th>
                            <th>Alamat</th>
                            <th>NPWP</th>
                            <th>Jenis Usaha</th>
                            <th>Tahun Berdiri</th>
                            <th>Direktur</th>
                            <th>Email</th>
                            <th>No. Telepon</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($perusahaan) && is_array($perusahaan)): ?>
                            <?php $no = 1; foreach ($perusahaan as $row): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= esc($row['nama_perusahaan']); ?></td>
                                    <td><?= esc($row['alamat_perusahaan']); ?></td>
                                    <td><?= esc($row['npwp']); ?></td>
                                    <td><?= esc($row['jenis_usaha']); ?></td>
                                    <td><?= esc($row['tahun_berdiri']); ?></td>
                                    <td><?= esc($row['nama_direktur']); ?></td>
                                    <td><?= esc($row['email_perusahaan']); ?></td>
                                    <td><?= esc($row['no_telepon']); ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('petugas/perusahaan/detail/' . $row['id']); ?>" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> Lihat
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="10" class="text-center text-muted">Belum ada data perusahaan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
