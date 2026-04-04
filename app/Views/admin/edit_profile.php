<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>

<div class="container-fluid py-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Update Profil Admin</h1>
        <a href="<?= base_url('admin/profile') ?>" class="btn btn-light btn-sm rounded-pill shadow-sm px-3">
            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Profil
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow border-0 rounded-lg overflow-hidden">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-id-card-alt mr-2"></i>Identitas & Keamanan Akun</h6>
                </div>
                <div class="card-body p-4">
                    <?php if (session()->has('errors')): ?>
                        <div class="alert alert-danger border-0 shadow-sm small">
                            <i class="fas fa-exclamation-circle mr-2"></i> <strong>Mohon periksa kembali:</strong>
                            <ul class="mb-0 mt-1 pl-4">
                                <?php foreach (session('errors') as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('admin/updateProfile') ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        
                        <!-- UPLOAD FOTO PROFIL -->
                        <div class="form-group mb-5 p-3 rounded-lg border-left-info shadow-sm bg-white" style="border: 1px dashed #e3e6f0;">
                            <label class="small font-weight-bold text-info"><i class="fas fa-camera mr-1"></i> FOTO PROFIL ADMIN (BARU)</label>
                            <input type="file" name="user_image" class="form-control form-control-sm border-0 bg-transparent h-auto py-2" accept="image/*">
                            <small class="text-muted italic small"><i class="fas fa-info-circle mr-1"></i> Format: JPG/PNG, Maks: 1MB.</small>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="small font-weight-bold text-muted">USERNAME ADMIN</label>
                                    <div class="input-group shadow-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light border-0"><i class="fas fa-user text-primary"></i></span>
                                        </div>
                                        <input type="text" name="username" class="form-control border-0 bg-light" value="<?= old('username', $user->username) ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="small font-weight-bold text-muted">ALAMAT EMAIL</label>
                                    <div class="input-group shadow-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light border-0"><i class="fas fa-envelope text-primary"></i></span>
                                        </div>
                                        <input type="email" name="email" class="form-control border-0 bg-light" value="<?= old('email', $user->email) ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4 p-3 bg-light rounded-lg border-left-danger">
                            <label class="small font-weight-bold text-danger">PASSWORD BARU (RAHASIA)</label>
                            <div class="input-group shadow-sm mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text border-0"><i class="fas fa-lock text-danger"></i></span>
                                </div>
                                <input type="password" name="password" class="form-control border-0" placeholder="Biarkan kosong jika tidak ingin ganti password">
                            </div>
                            <small class="text-muted italic small"><i class="fas fa-info-circle mr-1"></i> Minimal 8 karakter kompleks untuk keamanan maksimal.</small>
                        </div>

                        <div class="text-right mt-5">
                            <button type="submit" class="btn btn-primary btn-primary-gradient rounded-pill px-5 shadow-lg font-weight-bold">
                                <i class="fas fa-save mr-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .rounded-lg { border-radius: 15px !important; }
    .border-left-danger { border-left: 4px solid #e74a3b !important; }
    .btn-primary-gradient { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border: none; transition: 0.3s; }
    .btn-primary-gradient:hover { transform: translateY(-2px); box-shadow: 0 4px 15px rgba(34, 74, 190, 0.4) !important; }
    .form-control:focus { background-color: #fff; box-shadow: none; border: 1px solid #4e73df; }
    .italic { font-style: italic; }
</style>

<?= $this->endSection() ?>
