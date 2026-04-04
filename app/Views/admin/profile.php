<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-2xl rounded-3xl overflow-hidden" style="border-radius: 2.5rem !important;">
                <!-- Header with Geometric Pattern & Gradient -->
                <div class="card-header border-0 p-header d-flex align-items-end justify-content-center" 
                     style="height: 300px; background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); background-size: cover; background-position: center; position: relative;">
                    
                    <div class="position-absolute w-100 text-right p-4" style="top: 0;">
                        <a href="<?= base_url('admin/editProfile') ?>" class="btn btn-glass-blur rounded-pill px-4 py-2 text-white font-weight-bold shadow-sm">
                            <i class="fas fa-edit mr-2"></i> Edit Profil
                        </a>
                    </div>

                    <!-- Profile Image Overlay -->
                    <div class="profile-img-container shadow-2xl">
                        <?php 
                            $photo = !empty($user->user_image) && file_exists('uploads/profile/' . $user->user_image) 
                                     ? base_url('uploads/profile/' . $user->user_image) 
                                     : "https://ui-avatars.com/api/?name=" . urlencode($user->username) . "&background=4e73df&color=fff&size=512";
                        ?>
                        <img src="<?= $photo ?>" 
                             class="rounded-full shadow-lg" 
                             style="width: 180px; height: 180px; object-fit: cover; border: 8px solid rgba(255,255,255,0.2);">
                    </div>
                </div>

                <div class="card-body pt-5 px-sm-5 text-center mt-4">
                    <h1 class="display-4 font-weight-bold text-dark mt-3 mb-1" style="letter-spacing: -1.5px;"><?= esc($user->username) ?></h1>
                    <span class="badge badge-primary-soft rounded-pill px-4 py-2 font-weight-bold text-primary mb-5 uppercase tracking-widest small">
                        <i class="fas fa-star mr-1"></i> <?= $user->role ?> System Administrator
                    </span>

                    <div class="row border-top pt-5">
                        <div class="col-md-4 mb-4 border-right-md text-md-left">
                            <label class="small text-muted font-weight-bold uppercase mb-1 d-block tracking-tighter">ALAMAT EMAIL</label>
                            <p class="h6 font-weight-bold text-dark mb-0"><?= $user->email ?></p>
                        </div>
                        <div class="col-md-4 mb-4 border-right-md text-md-left">
                            <label class="small text-muted font-weight-bold uppercase mb-1 d-block tracking-tighter">PERAN SISTEM</label>
                            <p class="h6 font-weight-bold text-primary mb-0"><i class="fas fa-shield-alt mr-1"></i> Full Access Admin</p>
                        </div>
                        <div class="col-md-4 mb-4 text-md-left">
                            <label class="small text-muted font-weight-bold uppercase mb-1 d-block tracking-tighter">KODE USER</label>
                            <p class="h6 font-weight-bold text-dark mb-0">#<?= str_pad($user->userid, 4, '0', STR_PAD_LEFT) ?></p>
                        </div>
                    </div>

                    <div class="mt-4 p-3 bg-light rounded-xl small border">
                        <span class="text-muted"><i class="fas fa-clock mr-1"></i> Login Terakhir: <?= date('d M Y, H:i') ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .rounded-full { border-radius: 50% !important; }
    .shadow-2xl { box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important; }
    .badge-primary-soft { background: rgba(78, 115, 223, 0.1); }
    .btn-glass-blur { background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.3); transition: 0.3s; }
    .btn-glass-blur:hover { background: rgba(255, 255, 255, 0.25); transform: scale(1.05); }
    .tracking-widest { letter-spacing: 0.2em; }
    .tracking-tighter { letter-spacing: 0.02em; }
    .p-header { padding-bottom: 90px; }
    .rounded-xl { border-radius: 1rem !important; }
    @media (min-width: 768px) { .border-right-md { border-right: 1px solid #eee; } }
</style>

<?= $this->endSection() ?>
