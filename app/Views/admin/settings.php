<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800 font-weight-bold">CMS: Website Settings</h1>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4 border-left-primary">
                <div class="card-header py-3 bg-primary text-white d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold shadow-sm">Landing Page Identity & Visuals</h6>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('message')) : ?>
                        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                            <i class="fas fa-check-circle mr-2"></i> <?= session()->getFlashdata('message') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('admin/updateSettings') ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        
                        <!-- Site Name Setting -->
                        <div class="form-group mb-4">
                            <label class="font-weight-bold small ml-1">Nama Website (Site Title)</label>
                            <input type="text" name="site_name" class="form-control form-control-user shadow-sm py-4 h5" value="<?= $kv['site_name'] ?>" placeholder="Contoh: SIG NTB" required>
                            <small class="text-muted ml-1 italic font-italic">Muncul di halaman awal dan tab browser.</small>
                        </div>

                        <!-- Hero Image Preview & Setting -->
                        <div class="form-group mb-4">
                            <label class="font-weight-bold small ml-1">Latar Belakang Utama (Hero Background Image)</label>
                            <div class="mb-3 border rounded p-2 text-center bg-gray-100 shadow-inner overflow-hidden" style="max-height: 250px;">
                                <img src="<?= $kv['hero_image'] ?>" class="img-fluid rounded shadow-lg" style="max-height: 230px; object-fit: cover; width: 100%;" id="currentHero">
                            </div>
                            <div class="custom-file">
                                <input type="file" name="hero_image" class="custom-file-input" id="heroFile" accept="image/*">
                                <label class="custom-file-label font-weight-bold" for="heroFile">Pilih foto latar baru...</label>
                            </div>
                            <small class="text-info ml-1 italic">Rekomendasi: Resolusi 1920x1080 (HD) agar tampilan tajam.</small>
                        </div>

                        <hr class="my-4">
                        <div class="d-flex justify-content-end align-items-center">
                            <span class="text-xs mr-3 font-italic text-muted d-none d-sm-block">Update terakhir akan langsung merubah tampilan publik.</span>
                            <button type="submit" class="btn btn-primary btn-sm px-5 py-3 font-weight-bold shadow-lg">
                                <i class="fas fa-save mr-2"></i> Update Tampilan Publik
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Info Helper Column -->
        <div class="col-lg-4">
            <div class="card shadow mb-4 bg-gray-100">
                <div class="card-body py-4">
                    <h6 class="font-weight-bold text-dark mb-3"><i class="fas fa-info-circle mr-2 text-primary"></i> Panduan Visual</h6>
                    <p class="small text-muted mb-0">Halaman depan Anda menggunakan filter **Brightness (0.4)**. Artinya, foto apapun yang Anda unggah akan secara otomatis dibuat sedikit lebih gelap di web agar tulisan putih tetap terbaca dengan jelas.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Preview image before upload script
    document.getElementById('heroFile').onchange = function (evt) {
        var tgt = evt.target || window.event.srcElement,
            files = tgt.files;
        if (FileReader && files && files.length) {
            var fr = new FileReader();
            fr.onload = function () {
                document.getElementById('currentHero').src = fr.result;
            }
            fr.readAsDataURL(files[0]);
        }
    }
</script>

<?= $this->endSection() ?>
