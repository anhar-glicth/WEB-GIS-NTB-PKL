<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Account Profile (User)</h1>

    <div class="row justify-content-center">
        <div class="col-lg-5 mt-4">
            <!-- Modern Profile Card -->
            <div class="card shadow-lg border-0 rounded-xl overflow-hidden animate__animated animate__fadeIn">
                <div class="card-header bg-gradient-primary py-5 text-center position-relative">
                    <div class="profile-img-container shadow-lg">
                        <img src="<?= base_url('uploads/profile/' . ($user->user_image ?: 'default.png')) ?>" 
                             onerror="this.src='<?= base_url('img/undraw_profile_1.svg') ?>'" 
                             class="profile-img-main border border-white" alt="Profile">
                    </div>
                </div>
                <div class="card-body pt-5 mt-4 px-4 pb-5">
                    <div class="text-center mb-4">
                        <h4 class="font-weight-bold text-dark mb-1"><?= $user->username; ?></h4>
                        <span class="badge badge-pill badge-primary px-3 py-1 shadow-sm"><?= strtoupper($user->role); ?></span>
                    </div>

                    <div class="list-group list-group-flush small">
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3 border-0">
                            <span class="text-muted"><i class="fas fa-envelope-open-text mr-2 text-primary"></i> Email Address</span>
                            <span class="font-weight-bold text-dark"><?= $user->email; ?></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3 border-0">
                            <span class="text-muted"><i class="fas fa-fingerprint mr-2 text-primary"></i> Account ID</span>
                            <span class="text-dark">#USR-<?= sprintf("%04d", $user->userid); ?></span>
                        </div>
                    </div>

                    <div class="mt-4 px-3">
                        <a href="<?= base_url('user/editProfile'); ?>" class="btn btn-primary btn-block btn-round shadow py-2 font-weight-bold">
                            <i class="fas fa-pen-nib mr-2"></i> Edit Account Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-gradient-primary { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); min-height: 120px; border-bottom: 0; }
        .rounded-xl { border-radius: 1.25rem !important; }
        .profile-img-container {
            position: absolute; bottom: -50px; left: 50%; transform: translateX(-50%);
            width: 100px; height: 100px; background: white; border-radius: 50%;
            padding: 4px; z-index: 5;
        }
        .profile-img-main { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
        .btn-round { border-radius: 50px; }
        .list-group-item { background: transparent; transition: 0.3s; }
        .list-group-item:hover { transform: translateX(5px); color: #4e73df !important; }
    </style>
</div>

<?= $this->endSection() ?>
