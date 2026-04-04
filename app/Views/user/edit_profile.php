<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800 font-weight-bold">Update Account Information</h1>

    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-8">
            <div class="card shadow-lg border-0 rounded-xl overflow-hidden animate__animated animate__fadeIn">
                <div class="card-header bg-gradient-primary py-4 text-center">
                    <h5 class="m-0 font-weight-bold text-white"><i class="fas fa-user-edit mr-2"></i> Update your Information</h5>
                </div>
                <div class="card-body p-4">
                    <?php if (session()->has('errors')): ?>
                        <div class="alert alert-danger shadow-sm border-0 small rounded-lg mb-4">
                             <ul class="mb-0 pl-3">
                                <?php foreach (session('errors') as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('user/updateProfile') ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        
                        <!-- Premium Photo Upload Section -->
                        <div class="text-center mb-5">
                            <div class="position-relative d-inline-block p-1 bg-white shadow rounded-circle">
                                <img id="img-preview" src="<?= base_url('uploads/profile/' . ($user->user_image ?: 'default.png')) ?>" 
                                     onerror="this.src='<?= base_url('img/undraw_profile_1.svg') ?>'" 
                                     class="rounded-circle border" style="width: 110px; height: 110px; object-fit: cover;">
                                <label for="user_image" class="btn btn-primary btn-circle btn-sm shadow position-absolute" 
                                       style="bottom: 5px; right: 5px; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-camera"></i>
                                </label>
                                <input type="file" name="user_image" id="user_image" class="d-none" accept="image/*" onchange="previewImg()">
                            </div>
                            <p class="small text-muted mt-2 font-italic"><i class="fas fa-info-circle mr-1"></i> Tap icon camera to change photo</p>
                        </div>

                        <!-- Input Groups -->
                        <div class="form-group mb-4">
                            <label class="small font-weight-bold text-dark ml-1">Username</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text bg-light border-0"><i class="fas fa-user text-primary"></i></span></div>
                                <input type="text" name="username" class="form-control border-0 bg-light rounded-right py-4" value="<?= old('username', $user->username) ?>" required>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="small font-weight-bold text-dark ml-1">Email Address</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text bg-light border-0"><i class="fas fa-envelope text-primary"></i></span></div>
                                <input type="email" name="email" class="form-control border-0 bg-light rounded-right py-4" value="<?= old('email', $user->email) ?>" required>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="small font-weight-bold text-primary ml-1">Security: Change Password</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text bg-light border-0"><i class="fas fa-lock text-primary"></i></span></div>
                                <input type="password" name="password" class="form-control border-0 bg-light rounded-right py-4" placeholder="Leave blank to keep current">
                            </div>
                        </div>

                        <hr class="my-4 border-light">

                        <button type="submit" class="btn btn-primary btn-block btn-round shadow-lg py-2 font-weight-bold">
                            <i class="fas fa-cloud-upload-alt mr-2"></i> Save Changes Now
                        </button>
                        
                        <div class="text-center mt-3">
                            <a href="<?= base_url('user/profile') ?>" class="text-xs font-weight-bold text-muted text-decoration-none">
                                <i class="fas fa-chevron-left mr-1"></i> No changes? Go back
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-gradient-primary { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border: 0; }
        .rounded-xl { border-radius: 1.5rem !important; }
        .btn-round { border-radius: 50px; }
        .input-group-text { border-radius: 10px 0 0 10px !important; }
        .form-control { border-radius: 0 10px 10px 0 !important; font-size: 0.9rem; }
        .form-control:focus { background: #fff !important; box-shadow: 0 0 15px rgba(78,115,223,0.1); border: 1px solid #4e73df !important; }
    </style>
</div>

<script>
    function previewImg() {
        const image = document.querySelector('#user_image');
        const imgPreview = document.querySelector('#img-preview');

        const fileReader = new FileReader();
        fileReader.readAsDataURL(image.files[0]);

        fileReader.onload = function(e) {
            imgPreview.src = e.target.result;
        }
    }
</script>
<?= $this->endSection() ?>
