<?= $this->extend('auth/templates/index') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-4 col-md-6">
        <div class="card o-hidden border-0 shadow-lg my-3">
            <div class="card-body p-3">
                <div class="text-center mb-3">
                    <h1 class="h5 text-gray-900"><?=lang('Auth.register')?></h1>
                </div>
                <?= view('Myth\Auth\Views\_message_block') ?>
                
                <form action="<?= base_url('register') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="form-group mb-2">
                        <input type="text" class="form-control form-control-user form-control-sm" id="username" name="username" placeholder="<?=lang('Auth.username')?>" required value="<?= old('username') ?>">
                    </div>

                    <div class="form-group mb-2">
                        <input type="email" class="form-control form-control-user form-control-sm" id="emailAddress" name="email" placeholder="Email Address" required value="<?= old('email') ?>">
                    </div>

                    <div class="form-group row mb-2">
                        <div class="col-sm-6 mb-2 mb-sm-0">
                            <input type="password" class="form-control form-control-user form-control-sm" id="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="col-sm-6">
                          <input type="password" class="form-control form-control-user form-control-sm" id="passwordConfirm" name="pass_confirm" placeholder="<?=lang('Auth.password')?>" autocomplete="off" required>

                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-user btn-block btn-sm">
                        <?=lang('Auth.register')?>
                    </button>

                    <hr class="my-2">

                    <div class="text-center">
                        <a class="small" href="<?= base_url('forgot-password') ?>">
                            Forgot Password?
                        </a>
                    </div>
                    <div class="text-center">
                        <a class="small" href="<?= base_url('login') ?>">
                            Already have an account? Login!
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
