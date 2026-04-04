<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800 font-weight-bold">Update Account Information</h1>

    <div class="row mb-5">
        <div class="col-lg-6 col-md-10 mx-auto mx-lg-0">
            <div class="card shadow mb-4 border-left-info shadow-lg">
                <div class="card-header py-3 bg-info text-white">
                    <h6 class="m-0 font-weight-bold shadow-sm">My User Account Settings</h6>
                </div>
                <div class="card-body">
                    <?php if (session()->has('errors')): ?>
                        <div class="alert alert-danger px-4 py-3 alert-dismissible fade show" role="alert shadow-sm small">
                            <strong><i class="fas fa-exclamation-triangle mr-2"></i> Whoops!</strong> Please check the inputs.
                            <ul class="mb-0 mt-2 list-unstyled text-xs">
                                <?php foreach (session('errors') as $error): ?>
                                    <li><i class="fas fa-dot-circle mr-1 text-danger"></i> <?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('user/updateProfile') ?>" method="POST" class="user">
                        <?= csrf_field() ?>
                        <div class="form-group mb-4">
                            <label class="small font-weight-bold ml-1">Username (Display Name)</label>
                            <input type="text" name="username" class="form-control form-control-user form-control-sm border-left-info py-4 px-3 h6" value="<?= old('username', $user->username) ?>" required>
                        </div>
                        <div class="form-group mb-4">
                            <label class="small font-weight-bold ml-1">Primary Email Address</label>
                            <input type="email" name="email" class="form-control form-control-user form-control-sm border-left-info py-4 px-3 h6" value="<?= old('email', $user->email) ?>" required>
                        </div>
                        
                        <div class="form-group mb-4">
                            <label class="small font-weight-bold ml-1 text-primary">New Password (Optional)</label>
                            <input type="password" name="password" class="form-control form-control-user form-control-sm border-left-primary py-4 px-3 h6" placeholder="Leave blank if you don't want to change password">
                            <small class="text-muted ml-1">Minimum 8 characters for security.</small>
                        </div>

                        <hr class="mb-4">
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center">
                            <a href="<?= base_url('user/profile') ?>" class="text-xs font-weight-bold text-muted mb-3 mb-sm-0 text-decoration-none">
                                <i class="fas fa-arrow-left mr-1"></i> Discard & Return Profile
                            </a>
                            <button type="submit" class="btn btn-info btn-block btn-sm px-4 py-2 font-weight-bold shadow-lg" style="max-width: 200px;">
                                <i class="fas fa-save mr-1"></i> Update Profile & Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
