<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>

<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Daftar Pengguna</h1>
        <div class="d-none d-sm-inline-block">
            <span class="badge badge-info shadow-sm p-2 px-3 border-0" style="font-size: 0.85rem; background-color: #4e73df; color: white;">
                <i class="fas fa-users mr-1"></i> Total: <?= count($userList) ?> User Terdaftar
            </span>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="card shadow border-0 rounded-lg overflow-hidden text-sm">
        <div class="card-header py-3 bg-white d-flex align-items-center justify-content-between border-bottom">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-id-card mr-2"></i>Data Management Akun
            </h6>
            <a class="btn btn-sm btn-primary shadow-sm rounded-pill px-3" href="<?= base_url('admin/createUser') ?>" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border:none;">
                <i class="fas fa-user-plus fa-sm mr-1"></i> Tambah Akun Baru
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr class="text-secondary small font-weight-bold">
                            <th class="pl-4 py-3 border-0" width="50px">NO</th>
                            <th class="py-3 border-0">USERNAME</th>
                            <th class="py-3 border-0">EMAIL</th>
                            <th class="py-3 border-0 text-center">JABATAN / ROLE</th>
                            <th class="py-3 border-0 text-right pr-4">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($userList as $user): ?>
                        <tr class="align-middle border-bottom">
                            <td class="pl-4 py-4 font-weight-bold text-dark"><?= $i++; ?></td>
                            <td class="py-4">
                                <div class="d-flex align-items-center text-dark font-weight-bold">
                                    <div class="avatar-sm rounded-circle d-flex align-items-center justify-content-center mr-3 shadow-sm" style="background-color: rgba(78, 115, 223, 0.1); width: 28px; height: 28px; border: 1px solid rgba(78, 115, 223, 0.2);">
                                        <i class="fas fa-user text-primary" style="font-size: 10px;"></i>
                                    </div>
                                    <?= esc($user->username); ?>
                                </div>
                            </td>
                            <td class="py-4 text-muted small"><?= esc($user->email); ?></td>
                            <td class="py-4 text-center">
                                <?php if ($user->role == 'admin'): ?>
                                    <span class="badge badge-primary px-3 py-1 rounded-pill shadow-sm small">ADMIN</span>
                                <?php elseif ($user->role == 'petugas'): ?>
                                    <span class="badge badge-warning px-3 py-1 rounded-pill shadow-sm text-dark small">PETUGAS</span>
                                <?php else: ?>
                                    <span class="badge badge-success px-3 py-1 rounded-pill shadow-sm small">USER</span>
                                <?php endif; ?>
                            </td>
                            <td class="py-4 text-right pr-4">
                                <a href="<?= base_url('admin/detail/' . $user->userid); ?>" 
                                   class="btn btn-sm btn-outline-primary rounded-pill px-3 shadow-sm mr-1" 
                                   style="font-weight: 600; font-size: 0.75rem;">
                                    <i class="fas fa-eye mr-1"></i> Detail
                                </a>
                                <a href="<?= base_url('admin/deleteUser/' . $user->userid); ?>" 
                                   class="btn btn-sm btn-outline-danger rounded-pill px-3 shadow-sm" 
                                   style="font-weight: 600; font-size: 0.75rem;"
                                   onclick="return confirm('⚠️ PERINGATAN: Akun ini akan dihapus permanen. Lanjutkan?');">
                                    <i class="fas fa-trash mr-1"></i> Hapus
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .table thead th { letter-spacing: 0.1em; text-transform: uppercase; border-bottom: none !important; font-size: 0.7rem; }
    .table tbody tr:hover { background-color: #fcfdfe !important; }
    .badge { font-weight: 700; padding: 0.5em 1em !important; font-size: 0.6rem !important; }
</style>

<?= $this->endSection() ?>