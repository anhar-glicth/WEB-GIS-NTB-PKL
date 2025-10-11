<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Form Input Identitas Perusahaan</h1>

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

    <form action="<?= base_url('user/input-perusahaan') ?>" method="post">
        <?= csrf_field() ?>

        <!-- INFORMASI UMUM -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Umum Perusahaan</h6>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label for="nama_perusahaan" class="col-sm-4 col-form-label">Nama Perusahaan:</label>
                    <div class="col-sm-8">
                        <input type="text" name="nama_perusahaan" id="nama_perusahaan" class="form-control"
                            placeholder="Contoh: PT Tambang Emas Nusantara" value="<?= old('nama_perusahaan') ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="alamat_perusahaan" class="col-sm-4 col-form-label">Alamat Lengkap:</label>
                    <div class="col-sm-8">
                        <textarea name="alamat_perusahaan" id="alamat_perusahaan" class="form-control" rows="3"
                            placeholder="Masukkan alamat lengkap perusahaan"><?= old('alamat_perusahaan') ?></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="npwp" class="col-sm-4 col-form-label">NPWP:</label>
                    <div class="col-sm-8">
                        <input type="text" name="npwp" id="npwp" class="form-control"
                            placeholder="Masukkan Nomor Pokok Wajib Pajak (NPWP)" value="<?= old('npwp') ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jenis_usaha" class="col-sm-4 col-form-label">Jenis Usaha:</label>
                    <div class="col-sm-8">
                        <input type="text" name="jenis_usaha" id="jenis_usaha" class="form-control"
                            placeholder="Contoh: Pertambangan Batu Bara, Emas, Nikel, dsb" value="<?= old('jenis_usaha') ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tahun_berdiri" class="col-sm-4 col-form-label">Tahun Berdiri:</label>
                    <div class="col-sm-8">
                        <input type="number" name="tahun_berdiri" id="tahun_berdiri" class="form-control"
                            placeholder="Contoh: 2012" value="<?= old('tahun_berdiri') ?>">
                    </div>
                </div>
            </div>
        </div>

        <!-- LEGALITAS DAN IZIN -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Legalitas dan Perizinan</h6>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label for="nib" class="col-sm-4 col-form-label">Nomor Induk Berusaha (NIB):</label>
                    <div class="col-sm-8">
                        <input type="text" name="nib" id="nib" class="form-control"
                            placeholder="Masukkan NIB perusahaan" value="<?= old('nib') ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="izin_usaha" class="col-sm-4 col-form-label">Nomor Izin Usaha / IUP:</label>
                    <div class="col-sm-8">
                        <input type="text" name="izin_usaha" id="izin_usaha" class="form-control"
                            placeholder="Masukkan nomor izin usaha pertambangan" value="<?= old('izin_usaha') ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="masa_berlaku" class="col-sm-4 col-form-label">Masa Berlaku Izin:</label>
                    <div class="col-sm-8">
                        <input type="date" name="masa_berlaku" id="masa_berlaku" class="form-control"
                            value="<?= old('masa_berlaku') ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="dokumen_legal" class="col-sm-4 col-form-label">Dokumen Legalitas (Opsional):</label>
                    <div class="col-sm-8">
                        <input type="file" name="dokumen_legal" id="dokumen_legal" class="form-control">
                    </div>
                </div>
            </div>
        </div>

        <!-- KONTAK PERUSAHAAN -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Kontak dan Penanggung Jawab</h6>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label for="nama_direktur" class="col-sm-4 col-form-label">Nama Direktur / Penanggung Jawab:</label>
                    <div class="col-sm-8">
                        <input type="text" name="nama_direktur" id="nama_direktur" class="form-control"
                            placeholder="Masukkan nama lengkap direktur" value="<?= old('nama_direktur') ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email_perusahaan" class="col-sm-4 col-form-label">Email Perusahaan:</label>
                    <div class="col-sm-8">
                        <input type="email" name="email_perusahaan" id="email_perusahaan" class="form-control"
                            placeholder="contoh: info@perusahaan.com" value="<?= old('email_perusahaan') ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="no_telepon" class="col-sm-4 col-form-label">Nomor Telepon / HP:</label>
                    <div class="col-sm-8">
                        <input type="text" name="no_telepon" id="no_telepon" class="form-control"
                            placeholder="Contoh: +62 812 3456 7890" value="<?= old('no_telepon') ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="website" class="col-sm-4 col-form-label">Website (Opsional):</label>
                    <div class="col-sm-8">
                        <input type="url" name="website" id="website" class="form-control"
                            placeholder="contoh: https://www.perusahaan.com" value="<?= old('website') ?>">
                    </div>
                </div>
            </div>
        </div>

        <!-- TOMBOL -->
        <div class="mb-4">
            <button type="submit" class="btn btn-primary">Simpan Data</button>
            <button type="reset" class="btn btn-secondary">Reset</button>
            <button type="button" class="btn btn-success">Download Excel</button>
        </div>

    </form>
</div>

<?= $this->endSection() ?>
