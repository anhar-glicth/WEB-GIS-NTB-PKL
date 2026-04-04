<?= $this->extend('auth/templates/index') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3>Login Sistem</h3>
        <p>Silakan masuk untuk akses dashboard GIS</p>
    </div>
    <div class="card-body">

        <?= view('App\Views\Auth\_message_block') ?>

        <form action="<?= url_to('login') ?>" method="post">
            <?= csrf_field() ?>

            <?php if ($config->validFields === ['email']): ?>
                <div class="form-group mb-3">
                    <label for="login"><?=lang('Auth.email')?></label>
                    <input type="email" class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>"
                           name="login" placeholder="Email Terdaftar">
                    <div class="invalid-feedback">
                        <?= session('errors.login') ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="form-group mb-3">
                    <label for="login">Email atau Username</label>
                    <input type="text" class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>"
                           name="login" placeholder="Email atau Username">
                    <div class="invalid-feedback">
                        <?= session('errors.login') ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="form-group mb-4">
                <label for="password"><?=lang('Auth.password')?></label>
                <input type="password" name="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="Kata Sandi">
                <div class="invalid-feedback">
                    <?= session('errors.password') ?>
                </div>
            </div>

            <?php if ($config->allowRemembering): ?>
                <div class="form-check mb-4 custom-control custom-checkbox small">
                    <input type="checkbox" name="remember" class="custom-control-input" id="customCheck" <?php if (old('remember')) : ?> checked <?php endif ?>>
                    <label class="custom-control-label font-weight-normal text-muted" for="customCheck">
                        <?=lang('Auth.rememberMe')?>
                    </label>
                </div>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary btn-block text-uppercase shadow-sm">
                Masuk Sekarang <i class="fas fa-sign-in-alt ml-2"></i>
            </button>
        </form>

        <div class="auth-footer mt-4">
            <?php if ($config->allowRegistration) : ?>
                <p>Belum punya akun? <a href="<?= url_to('register') ?>">Daftar Perusahaan</a></p>
            <?php endif; ?>
            <?php if ($config->activeResetter): ?>
                <p><a href="<?= url_to('forgot') ?>" class="small">Lupa Kata Sandi?</a></p>
            <?php endif; ?>
            <p class="mt-3">
                <a href="<?= base_url('/') ?>" class="text-secondary"><i class="fas fa-arrow-left mr-1"></i> Kembali ke Beranda</a>
            </p>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
