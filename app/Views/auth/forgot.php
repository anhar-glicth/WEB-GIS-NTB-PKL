<?= $this->extend('auth/templates/index') ?>
<?= $this->section('content') ?>

<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-xl-5 col-lg-6 col-md-8">
            <div class="card shadow-lg border-0 rounded-3xl overflow-hidden bg-white-translucent" style="border-radius: 2rem !important; backdrop-filter: blur(10px);">
                <div class="card-body p-5">
                    <!-- Heading & Icon -->
                    <div class="text-center mb-5">
                        <div class="icon-avatar bg-gradient-primary mx-auto mb-4 d-flex align-items-center justify-content-center shadow-lg" style="width: 80px; height: 80px; border-radius: 2rem; background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);">
                            <i class="fas fa-key-skeleton fa-2x text-white"></i>
                        </div>
                        <h2 class="font-weight-bold text-gray-900 mb-2">Lupa Password?</h2>
                        <p class="text-muted small">Jangan khawatir! Masukkan email Anda di bawah ini, dan kami akan mengirimkan instruksi pemulihan akuntansi secara instan.</p>
                    </div>

                    <!-- Alert Messages -->
                    <div class="mb-4">
                        <?= view('App\Views\Auth\_message_block') ?>
                    </div>

                    <!-- Form -->
                    <form action="<?= url_to('forgot') ?>" method="post" class="user">
                        <?= csrf_field() ?>

                        <div class="form-group mb-4">
                            <label for="email" class="small font-weight-bold ml-1 text-muted">Alamat Email Terdaftar</label>
                            <div class="input-group-custom">
                                <i class="fas fa-envelope input-icon text-primary"></i>
                                <input type="email" 
                                       class="form-control form-control-user custom-input-field <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>"
                                       name="email" 
                                       placeholder="contoh@gmail.com"
                                       style="padding-left: 3.5rem; height: 60px; border-radius: 1rem; border: 1px solid #e3e6f0; background: #f8f9fc;">
                            </div>
                            <div class="invalid-feedback ml-2">
                                <?= session('errors.email') ?>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block py-3 font-weight-bold rounded-pill shadow-lg mt-5" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border: none;">
                            KIRIM LINK PEMULIHAN <i class="fas fa-paper-plane ml-2"></i>
                        </button>
                    </form>

                    <div class="text-center mt-5">
                        <a class="small font-weight-bold text-primary text-decoration-none" href="<?= url_to('login') ?>">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Halaman Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body { background-color: #f0f2f5; background-image: radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%), radial-gradient(at 50% 0%, hsla(225,39%,30%,1) 0, transparent 50%), radial-gradient(at 100% 0%, hsla(339,49%,30%,1) 0, transparent 50%); min-height: 100vh; }
    .bg-gradient-primary { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); }
    .rounded-3xl { border-radius: 1.5rem !important; }
    .input-group-custom { position: relative; }
    .input-icon { position: absolute; left: 1.5rem; top: 50%; transform: translateY(-50%); z-index: 10; font-size: 1.2rem; opacity: 0.6; }
    .custom-input-field:focus { box-shadow: 0 0 15px rgba(78, 115, 223, 0.2); border-color: #4e73df; background: #fff !important; }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(78,115,223,0.3); transition: 0.3s; }
    .bg-white-translucent { background: rgba(255, 255, 255, 0.95); box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37); }
</style>

<?= $this->endSection() ?>
