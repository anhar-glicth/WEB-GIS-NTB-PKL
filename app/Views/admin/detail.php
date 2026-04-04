<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>

<div class="container-fluid py-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Informasi Detail Pengguna</h1>
        <a href="<?= base_url('admin/user-list') ?>" class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm">
            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow-lg border-0 overflow-hidden" style="border-radius: 1.5rem;">
                <div class="row no-gutters">
                    <!-- Sisi Foto -->
                    <div class="col-md-5 bg-light d-flex align-items-center justify-content-center p-4">
                        <?php 
                            $photo = !empty($user->user_image) && file_exists('uploads/profile/' . $user->user_image) 
                                     ? base_url('uploads/profile/' . $user->user_image) 
                                     : "https://ui-avatars.com/api/?name=" . urlencode($user->username) . "&background=random&color=fff&size=256";
                        ?>
                        <div class="position-relative">
                            <img src="<?= $photo ?>" 
                                 class="img-fluid rounded-circle shadow border-white" 
                                 style="width: 160px; height: 160px; object-fit: cover; border: 6px solid #fff;" 
                                 alt="Profile Image">
                            <span class="badge badge-success position-absolute" style="bottom: 10px; right: 10px; border-radius: 50%; width: 20px; height: 20px; border: 3px solid #fff;">&nbsp;</span>
                        </div>
                    </div>
                    
                    <!-- Sisi Informasi -->
                    <div class="col-md-7">
                        <div class="card-body p-4">
                            <div class="mb-4">
                                <span class="badge badge-primary-soft text-primary px-3 py-1 rounded-pill mb-2 small font-weight-bold"><?= strtoupper($user->role) ?> ROLE</span>
                                <h2 class="font-weight-bold text-dark h3 mb-0"><?= esc($user->username); ?></h2>
                            </div>
                            
                            <hr class="my-4">
                            
                            <div class="mb-3">
                                <label class="small text-muted font-weight-bold mb-1 d-block uppercase">EMAIL AKTIF</label>
                                <p class="text-dark font-weight-bold mb-0 ml-1"><i class="fas fa-envelope mr-2 text-primary"></i><?= esc($user->email); ?></p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="small text-muted font-weight-bold mb-1 d-block uppercase">IDENTITAS USER</label>
                                <p class="text-dark font-weight-bold mb-0 ml-1"><i class="far fa-id-badge mr-2 text-primary"></i>ID SYSTEM #<?= esc($user->userid); ?></p>
                            </div>
                            
                            <div class="mt-4 pt-3 border-top">
                                <p class="text-muted small italic mb-0">Terdaftar pada: <?= date('d M Y') ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .badge-primary-soft { background: rgba(78, 115, 223, 0.1); }
    .rounded-pill { border-radius: 50rem !important; }
    .uppercase { text-transform: uppercase; letter-spacing: 0.1em; }
    .italic { font-style: italic; }
</style>

<?= $this->endSection() ?>
