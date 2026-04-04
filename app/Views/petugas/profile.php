<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Profil Saya</h1>

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Akun (Petugas)</h6>
                </div>
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto mr-3">
                            <i class="fas fa-id-card fa-4x text-gray-300"></i>
                        </div>
                        <div class="col">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <span class="text-xs font-weight-bold text-primary text-uppercase mb-1">Username</span>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $user->username ?></div>
                                </li>
                                <li class="list-group-item">
                                    <span class="text-xs font-weight-bold text-primary text-uppercase mb-1">Email Aktif</span>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $user->email ?></div>
                                </li>
                                <li class="list-group-item">
                                    <span class="text-xs font-weight-bold text-primary text-uppercase mb-1">Hak Akses</span>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <span class="badge badge-success"><?= $user->role ?></span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="<?= base_url('petugas/editProfile') ?>" class="btn btn-primary btn-sm shadow-sm float-right">
                        <i class="fas fa-user-edit fa-sm text-white-50 mr-1"></i> Edit Profil Akun
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
