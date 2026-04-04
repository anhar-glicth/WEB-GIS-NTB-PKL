<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800 font-weight-bold">Update Petugas Account Profile</h1>

    <div class="row mb-5">
        <div class="col-lg-6">
            <div class="card shadow mb-4 border-left-primary shadow-lg">
                <div class="card-header py-3 bg-primary text-white">
                    <h6 class="m-0 font-weight-bold text-uppercase shadow-sm">Personal Identity & Security</h6>
                </div>
                <div class="card-body">
                    <?php if (session()->has('errors')): ?>
                        <div class="alert alert-danger px-4 py-3 alert-dismissible fade show" role="alert shadow-sm small">
                            <strong><i class="fas fa-exclamation-triangle mr-2"></i> Whoops!</strong> Please check the inputs below.
                            <ul class="mb-0 mt-2 list-unstyled text-xs">
                                <?php foreach (session('errors') as $error): ?>
                                    <li><i class="fas fa-dot-circle mr-1 text-danger"></i> <?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('petugas/updateProfile') ?>" method="POST" class="user">
                        <?= csrf_field() ?>
                        <div class="form-group mb-4">
                            <label class="small font-weight-bold ml-1">Username (Display Name)</label>
                            <input type="text" name="username" class="form-control form-control-user form-control-sm border-left-primary py-4 px-3 h6" value="<?= old('username', $user->username) ?>" required>
                        </div>
                        <div class="form-group mb-4">
                            <label class="small font-weight-bold ml-1">Primary Email Address</label>
                            <input type="email" name="email" class="form-control form-control-user form-control-sm border-left-primary py-4 px-3 h6" value="<?= old('email', $user->email) ?>" required>
                        </div>
                        <div class="form-group mb-4">
                            <label class="small font-weight-bold ml-1 text-danger">New Password (Secret Access)</label>
                            <input type="password" name="password" class="form-control form-control-user form-control-sm border-left-danger py-4 px-3 h6" placeholder="Leave empty to keep existing password">
                            <small class="text-muted ml-1 font-italic">For improved security, use at least 8 varied characters.</small>
                        </div>
                        <hr class="mb-4 shadow-sm">
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center">
                            <a href="<?= base_url('petugas/profile') ?>" class="text-xs font-weight-bold text-muted mb-3 mb-sm-0 text-decoration-none">
                                <i class="fas fa-arrow-left mr-1"></i> Discard Changes
                            </a>
                            <button type="submit" class="btn btn-primary btn-block btn-sm px-4 py-2 font-weight-bold shadow-lg" style="max-width: 250px;">
                                <i class="fas fa-save mr-1 shadow-sm"></i> Save Identity & Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
