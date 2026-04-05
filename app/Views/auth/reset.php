<?= $this->extend('auth/templates/index') ?>
<?= $this->section('content') ?>

<div class="container py-5 mt-4">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-7 col-md-9">
            <div class="card shadow-lg border-0 rounded-3xl overflow-hidden bg-white-translucent" style="border-radius: 2rem !important; backdrop-filter: blur(10px);">
                <div class="card-body p-5">
                    <!-- Heading & Icon -->
                    <div class="text-center mb-5">
                        <div class="icon-avatar bg-gradient-success mx-auto mb-4 d-flex align-items-center justify-content-center shadow-lg" style="width: 80px; height: 80px; border-radius: 2rem; background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);">
                            <i class="fas fa-user-lock fa-2x text-white"></i>
                        </div>
                        <h2 class="font-weight-bold text-gray-900 mb-2">Reset Password</h2>
                        <p class="text-muted small">Ciptakan kata sandi baru yang kuat untuk mengamankan kembali akses Anda ke sistem SIG-TAMBANG NTB.</p>
                    </div>

                    <!-- Alert Messages -->
                    <div class="mb-4">
                        <?= view('App\Views\Auth\_message_block') ?>
                    </div>

                    <!-- Form -->
                    <form action="<?= url_to('reset-password') ?>" method="post" class="user">
                        <?= csrf_field() ?>

                        <div class="row">
                            <!-- Token & Email Field -->
                            <div class="col-md-12 mb-4">
                                <label for="token" class="small font-weight-bold ml-1 text-muted">Kode Token dari Email</label>
                                <div class="input-group-custom">
                                    <i class="fas fa-ticket-alt input-icon text-success"></i>
                                    <input type="text" 
                                           class="form-control form-control-user custom-input-field <?php if (session('errors.token')) : ?>is-invalid<?php endif ?>"
                                           name="token" 
                                           placeholder="Tempel kode token di sini"
                                           value="<?= old('token', $token ?? '') ?>"
                                           style="padding-left: 3.5rem; height: 55px; border-radius: 1rem; border: 1px solid #e3e6f0; background: #f8f9fc;">
                                </div>
                                <div class="invalid-feedback ml-2"><?= session('errors.token') ?></div>
                            </div>

                            <div class="col-md-12 mb-4">
                                <label for="email" class="small font-weight-bold ml-1 text-muted">Konfirmasi Alamat Email</label>
                                <div class="input-group-custom">
                                    <i class="fas fa-envelope input-icon text-primary"></i>
                                    <input type="email" 
                                           class="form-control form-control-user custom-input-field <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>"
                                           name="email" 
                                           placeholder="Masukkan email Anda"
                                           value="<?= old('email') ?>"
                                           style="padding-left: 3.5rem; height: 55px; border-radius: 1rem; border: 1px solid #e3e6f0; background: #f8f9fc;">
                                </div>
                                <div class="invalid-feedback ml-2"><?= session('errors.email') ?></div>
                            </div>

                            <!-- New Password -->
                            <div class="col-md-6 mb-4">
                                <label for="password" class="small font-weight-bold ml-1 text-muted">Password Baru</label>
                                <div class="input-group-custom">
                                    <i class="fas fa-key input-icon text-warning"></i>
                                    <input type="password" 
                                           class="form-control form-control-user custom-input-field <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>"
                                           name="password"
                                           style="padding-left: 3.5rem; height: 55px; border-radius: 1rem; border: 1px solid #e3e6f0; background: #f8f9fc;">
                                </div>
                                <div class="invalid-feedback ml-2"><?= session('errors.password') ?></div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="col-md-6 mb-4">
                                <label for="pass_confirm" class="small font-weight-bold ml-1 text-muted">Ulangi Password</label>
                                <div class="input-group-custom">
                                    <i class="fas fa-redo input-icon text-warning"></i>
                                    <input type="password" 
                                           class="form-control form-control-user custom-input-field <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>"
                                           name="pass_confirm"
                                           style="padding-left: 3.5rem; height: 55px; border-radius: 1rem; border: 1px solid #e3e6f0; background: #f8f9fc;">
                                </div>
                                <div class="invalid-feedback ml-2"><?= session('errors.pass_confirm') ?></div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success btn-block py-3 font-weight-bold rounded-pill shadow-lg mt-4" style="background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%); border: none;">
                            PERBARUI KATA SANDI <i class="fas fa-check-circle ml-2"></i>
                        </button>
                    </form>

                    <div class="text-center mt-5">
                        <p class="small text-muted mb-0">Sudah ingat password Anda? <a href="<?= url_to('login') ?>" class="font-weight-bold text-primary text-decoration-none">Login Sekarang</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body { background-color: #f0f2f5; background-image: radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%), radial-gradient(at 50% 0%, hsla(225,39%,30%,1) 0, transparent 50%), radial-gradient(at 100% 0%, hsla(139,49%,30%,1) 0, transparent 50%); min-height: 100vh; }
    .input-group-custom { position: relative; }
    .input-icon { position: absolute; left: 1.5rem; top: 50%; transform: translateY(-50%); z-index: 10; font-size: 1.1rem; opacity: 0.6; }
    .custom-input-field:focus { box-shadow: 0 0 15px rgba(28, 200, 138, 0.2); border-color: #1cc88a; background: #fff !important; }
    .btn-success:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(28,200,138,0.3); transition: 0.3s; }
    .bg-white-translucent { background: rgba(255, 255, 255, 0.95); box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37); }
</style>

<?= $this->endSection() ?>
