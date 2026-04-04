<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            <!-- Main Profile Card -->
            <div class="card border-0 shadow-lg" style="border-radius: 2rem; overflow: hidden;">
                <!-- Header Card with Gradient -->
                <div class="card-header border-0 p-0 position-relative" style="height: 160px; background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);">
                    <div class="position-absolute w-100 text-center" style="bottom: -60px;">
                        <!-- Profile Image Container -->
                        <div class="d-inline-block p-1 bg-white rounded-circle shadow-lg position-relative">
                            <?php 
                                $photo = !empty($user->user_image) && file_exists('uploads/profile/' . $user->user_image) 
                                         ? base_url('uploads/profile/' . $user->user_image) 
                                         : "https://ui-avatars.com/api/?name=" . urlencode($user->username) . "&background=4e73df&color=fff&size=256";
                            ?>
                            <img src="<?= $photo ?>" 
                                 class="rounded-circle shadow-sm" 
                                 style="width: 140px; height: 140px; object-fit: cover; border: 5px solid #fff;">
                            
                            <!-- Online Status Indicator -->
                            <span class="position-absolute border border-white border-3 bg-success rounded-circle" 
                                  style="width: 25px; height: 25px; bottom: 10px; right: 10px;"></span>
                        </div>
                    </div>
                </div>

                <div class="card-body pt-5 mt-4 text-center pb-5 px-sm-5">
                    <!-- Name & Role -->
                    <h2 class="font-weight-bold text-dark mb-1" style="letter-spacing: -0.5px;"><?= esc($user->username) ?></h2>
                    <p class="text-primary font-weight-bold mb-4 text-uppercase small tracking-widest"><i class="fas fa-shield-alt mr-1"></i> <?= $user->role ?></p>

                    <div class="row mt-5 text-left bg-light rounded-xl p-4 mx-2 shadow-sm border">
                        <div class="col-md-6 mb-4 mb-md-0 border-right-md">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary-soft p-3 rounded-circle mr-3">
                                    <i class="fas fa-envelope text-primary"></i>
                                </div>
                                <div>
                                    <p class="text-muted small mb-0 font-weight-bold">ALAMAT EMAIL</p>
                                    <p class="text-dark mb-0 font-weight-bold"><?= $user->email ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3 pl-md-3">
                                <div class="bg-success-soft p-3 rounded-circle mr-3">
                                    <i class="fas fa-calendar-check text-success"></i>
                                </div>
                                <div>
                                    <p class="text-muted small mb-0 font-weight-bold">BERGABUNG SEJAK</p>
                                    <p class="text-dark mb-0 font-weight-bold">Bulan <?= date('M Y') ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-5 d-flex justify-content-center gap-3">
                        <a href="<?= base_url('petugas/editProfile') ?>" class="btn btn-primary px-5 py-3 rounded-pill shadow-lg font-weight-bold transition-up">
                            <i class="fas fa-edit mr-2"></i> Sunting Profil Akun
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-primary-soft { background-color: rgba(78, 115, 223, 0.1); }
    .bg-success-soft { background-color: rgba(28, 200, 138, 0.1); }
    .rounded-xl { border-radius: 1.5rem !important; }
    .tracking-widest { letter-spacing: 0.15em; }
    .transition-up { transition: all 0.3s cubic-bezier(.25,.8,.25,1); }
    .transition-up:hover { transform: translateY(-5px); box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important; }
    @media (min-width: 768px) { .border-right-md { border-right: 1px solid #e3e6f0; } }
</style>

<?= $this->endSection() ?>
