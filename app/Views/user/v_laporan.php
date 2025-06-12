<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Buat Laporan Baru</h1>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (isset($validation)): ?>
        <div class="alert alert-danger">
            <?= $validation->listErrors() ?>
        </div>
    <?php endif; ?>

   <?php helper('form'); ?>

<form action="<?= base_url('Laporan/insertLaporan') ?>" method="post" enctype="multipart/form-data">

    <?= csrf_field() ?>

    <div class="form-group">
        <label for="judul">Judul Laporan</label>
        <input type="text" name="judul" id="judul" class="form-control" value="<?= old('judul') ?>" required>
    </div>

    <div class="form-group">
        <label for="file">File Laporan (PDF/DOC/DOCX)</label>
        <input type="file" name="file" id="file" class="form-control" accept=".pdf,.doc,.docx" required>
    </div>

    <!-- tombol submit dll -->
      <button type="submit" class="btn btn-primary">Upload</button>
</form>

</div>

<?= $this->endSection() ?>
