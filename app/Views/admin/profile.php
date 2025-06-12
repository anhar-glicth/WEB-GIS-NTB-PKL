<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">My Profile</h1>

    <div class="card mb-3" style="max-width: 540px;">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="<?= base_url('img/default.png') ?>" class="img-fluid rounded-start" alt="Profile Image">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title"><?= esc($user->username); ?></h5>
                    <p class="card-text"><strong>Email:</strong> <?= esc($user->email); ?></p>
                    <p class="card-text"><strong>Role:</strong> <?= esc($user->role); ?></p>
                    <p class="card-text"><small class="text-muted">ID User: <?= esc($user->userid); ?></small></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
