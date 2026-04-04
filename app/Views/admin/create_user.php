<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>

<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Tambah Akun</h1>
        <a href="<?= base_url('admin/user-list') ?>" class="btn btn-light btn-sm rounded-pill shadow-sm px-3 small">
            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow border-0 rounded-lg overflow-hidden">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-user-plus mr-2"></i>Registrasi Akun Baru</h6>
                </div>
                <div class="card-body p-4">
                    <!-- Alert Errors -->
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

                    <form action="<?= base_url('admin/saveUser') ?>" method="POST">
                        <?= csrf_field() ?>
                        
                        <!-- Username & Email -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="small font-weight-bold text-muted">USERNAME</label>
                                <div class="input-group shadow-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light border-0"><i class="fas fa-user text-primary"></i></span>
                                    </div>
                                    <input type="text" name="username" class="form-control border-0 bg-light" value="<?= old('username') ?>" placeholder="e.g. jdoe" required>
                                </div>
                            </div>
                            <div class="col-md-6 mt-3 mt-md-0">
                                <label class="small font-weight-bold text-muted">EMAIL ADRESS</label>
                                <div class="input-group shadow-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light border-0"><i class="fas fa-envelope text-primary"></i></span>
                                    </div>
                                    <input type="email" name="email" class="form-control border-0 bg-light" value="<?= old('email') ?>" placeholder="e.g. john@example.com" required>
                                </div>
                            </div>
                        </div>

                        <!-- Role / Group -->
                        <div class="form-group mb-4">
                            <label class="small font-weight-bold text-muted">JABATAN / ROLE SYSTEM</label>
                            <div class="input-group shadow-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-0"><i class="fas fa-user-tag text-primary"></i></span>
                                </div>
                                <select name="group_id" class="form-control border-0 bg-light" required>
                                    <option value="" disabled selected>-- Pilih Role --</option>
                                    <?php foreach($groups as $g): ?>
                                        <option value="<?= $g->id ?>" <?= old('group_id') == $g->id ? 'selected' : '' ?>><?= strtoupper($g->name) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <small class="text-muted small italic">Tentukan hak akses utama pengguna ini.</small>
                        </div>

                        <!-- Password -->
                        <div class="form-group mb-4">
                            <label class="small font-weight-bold text-muted text-danger">KATA SANDI AWAL</label>
                            <div class="input-group shadow-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-0"><i class="fas fa-lock text-danger"></i></span>
                                </div>
                                <input type="password" name="password" class="form-control border-0 bg-light" placeholder="Minimal 8 karakter" required>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary btn-block-mobile rounded-pill px-5 shadow-lg font-weight-bold transition-up">
                                <i class="fas fa-check-circle mr-2"></i> Daftarkan Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .rounded-lg { border-radius: 1.25rem !important; }
    .btn-primary { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border: none; }
    .form-control:focus { background-color: #fff !important; box-shadow: none; border: 1px solid #4e73df !important; }
    .transition-up { transition: 0.3s; }
    .transition-up:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(78, 115, 223, 0.4) !important; }
    .italic { font-style: italic; }
    @media (max-width: 576px) { .btn-block-mobile { width: 100%; } }
</style>

<?= $this->endSection() ?>