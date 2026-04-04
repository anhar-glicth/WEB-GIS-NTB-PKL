<?= $this->extend('auth/templates/index') ?>
<?= $this->section('content') ?>

<div class="card" style="max-width: 550px;">
    <div class="card-header">
        <h3>Daftar Perusahaan</h3>
        <p>Lengkapi formulir untuk registrasi sistem GIS</p>
    </div>
    <div class="card-body">

        <?= view('App\Views\Auth\_message_block') ?>

        <form action="<?= url_to('register') ?>" method="post" class="user">
            <?= csrf_field() ?>

            <div class="form-group mb-3">
                <label for="email"><?=lang('Auth.email')?></label>
                <input type="email" class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>"
                       name="email" aria-describedby="emailHelp" placeholder="johndoe@example.com" value="<?= old('email') ?>">
                <small id="emailHelp" class="form-text text-muted ml-1"><?=lang('Auth.weNeverShare')?></small>
                <div class="invalid-feedback ml-1">
                    <?= session('errors.email') ?>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="username"><?=lang('Auth.username')?></label>
                <input type="text" class="form-control <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>" 
                       name="username" placeholder="Username untuk Login" value="<?= old('username') ?>">
                <div class="invalid-feedback ml-1">
                    <?= session('errors.username') ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 mb-3">
                    <label for="password"><?=lang('Auth.password')?></label>
                    <input type="password" name="password" 
                           class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" 
                           placeholder="Kata Sandi" autocomplete="off">
                    <div class="invalid-feedback ml-1">
                        <?= session('errors.password') ?>
                    </div>
                </div>
                <div class="col-sm-6 mb-4">
                    <label for="pass_confirm">Konfirmasi Sandi</label>
                    <input type="password" name="pass_confirm" 
                           class="form-control <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" 
                           placeholder="Ulangi Sandi" autocomplete="off">
                    <div class="invalid-feedback ml-1">
                        <?= session('errors.pass_confirm') ?>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block text-uppercase shadow-sm">
                Registrasi Akun Baru <i class="fas fa-user-plus ml-2"></i>
            </button>
        </form>

        <div class="auth-footer mt-4">
            <p><?=lang('Auth.alreadyRegistered')?> <a href="<?= url_to('login') ?>"><?=lang('Auth.signIn')?> Sekarang</a></p>
            <p class="mt-3">
                <a href="<?= base_url('/') ?>" class="text-secondary"><i class="fas fa-arrow-left mr-1"></i> Beranda</a>
            </p>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
