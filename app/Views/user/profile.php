<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Account Profile (User)</h1>

    <div class="row mb-5">
        <div class="col-lg-6">
            <div class="card shadow mb-4 border-left-info text-dark">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-info text-white rounded-top">
                    <h6 class="m-0 font-weight-bold">Identity & Settings</h6>
                </div>
                <div class="card-body">
                    <div class="row align-items-center mb-3 text-center">
                        <div class="col-12 mb-4">
                            <div class="mx-auto" style="width: 100px; height: 100px; border-radius: 50%; background: #f8f9fc; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                                <i class="fas fa-user fa-3x text-info"></i>
                            </div>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush mb-4 small font-weight-bold">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Username
                            <span class="text-info"><?= $user->username ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Address (Email)
                            <span class="text-info"><?= $user->email ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Access Role
                            <span class="badge badge-info badge-pill px-3 py-2"><?= $user->role ?></span>
                        </li>
                    </ul>
                    <a href="<?= base_url('user/editProfile') ?>" class="btn btn-info btn-sm btn-block shadow-sm py-2">
                        <i class="fas fa-user-cog mr-1"></i> Edit Account Settings
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
