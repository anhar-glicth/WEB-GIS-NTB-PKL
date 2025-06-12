<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Laporan</h1>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Judul</th>
                <th>User</th>
                <th>Status</th>
                <th>File</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($laporan as $row): ?>
            <tr>
                <td><?= esc($row['judul']) ?></td>
                <td><?= esc($row['username']) ?></td>
                <td>
                    <?php if ($row['status'] == 'pending'): ?>
                        <span class="badge badge-warning">Pending</span>
                    <?php elseif ($row['status'] == 'approved'): ?>
                        <span class="badge badge-success">Disetujui</span>
                    <?php elseif ($row['status'] == 'rejected'): ?>
                        <span class="badge badge-danger">Ditolak</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="<?= base_url('uploads/' . $row['file']) ?>" target="_blank" class="btn btn-info btn-sm">
                        <i class="fas fa-file-alt"></i> Lihat
                    </a>
                </td>
                <td>
                    <?php if ($row['status'] == 'pending'): ?>
                      <a href="<?= base_url('petugas/acc/' . $row['id']) ?>" class="btn btn-success btn-sm">
        <i class="fas fa-check"></i> ACC
    </a>
    <a href="<?= base_url('petugas/tolak/' . $row['id']) ?>" class="btn btn-danger btn-sm">
        <i class="fas fa-times"></i> Tolak
    </a>
                    <?php else: ?>
                        <span class="text-muted">Tidak ada aksi</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
