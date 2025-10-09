<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Form Input Data Tambang</h1>

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

    <form action="<?= base_url('user/input-tambang') ?>" method="post">
        <?= csrf_field() ?>

        <!-- INFORMASI UMUM -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Umum</h6>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label for="nama_blok" class="col-sm-4 col-form-label">Nama Blok / Prospek:</label>
                    <div class="col-sm-8">
                        <input type="text" name="nama_blok" id="nama_blok" class="form-control" 
                            placeholder="Contoh: Blok Selatan A" value="<?= old('nama_blok') ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="luas_ha" class="col-sm-4 col-form-label">Luas (Ha):</label>
                    <div class="col-sm-8">
                        <input type="number" step="0.01" name="luas_ha" id="luas_ha" class="form-control" 
                            placeholder="Masukkan luas area dalam hektar (misal: 120.5)" value="<?= old('luas_ha') ?>">
                    </div>
                </div>
            </div>
        </div>

        <!-- SUMBERDAYA -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Sumber Daya</h6>
            </div>
            <div class="card-body">

                <h6 class="text-secondary">Tereka</h6>
                <div class="form-group row">
                    <label for="sd_tereka_volume" class="col-sm-4 col-form-label">Volume (m³):</label>
                    <div class="col-sm-8">
                        <input type="number" step="0.01" name="sd_tereka_volume" id="sd_tereka_volume" class="form-control"
                            placeholder="Masukkan volume tereka (contoh: 35000.75)" value="<?= old('sd_tereka_volume') ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="sd_tereka_tonase" class="col-sm-4 col-form-label">Tonase:</label>
                    <div class="col-sm-8">
                        <input type="number" step="0.01" name="sd_tereka_tonase" id="sd_tereka_tonase" class="form-control"
                            placeholder="Masukkan tonase tereka (contoh: 24000)" value="<?= old('sd_tereka_tonase') ?>">
                    </div>
                </div>
                <hr>

                <h6 class="text-secondary">Terunjuk</h6>
                <div class="form-group row">
                    <label for="sd_terunjuk_volume" class="col-sm-4 col-form-label">Volume (m³):</label>
                    <div class="col-sm-8">
                        <input type="number" step="0.01" name="sd_terunjuk_volume" id="sd_terunjuk_volume" class="form-control"
                            placeholder="Masukkan volume terunjuk" value="<?= old('sd_terunjuk_volume') ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="sd_terunjuk_tonase" class="col-sm-4 col-form-label">Tonase:</label>
                    <div class="col-sm-8">
                        <input type="number" step="0.01" name="sd_terunjuk_tonase" id="sd_terunjuk_tonase" class="form-control"
                            placeholder="Masukkan tonase terunjuk" value="<?= old('sd_terunjuk_tonase') ?>">
                    </div>
                </div>
                <hr>

                <h6 class="text-secondary">Terukur</h6>
                <div class="form-group row">
                    <label for="sd_terukur_volume" class="col-sm-4 col-form-label">Volume (m³):</label>
                    <div class="col-sm-8">
                        <input type="number" step="0.01" name="sd_terukur_volume" id="sd_terukur_volume" class="form-control"
                            placeholder="Masukkan volume terukur" value="<?= old('sd_terukur_volume') ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="sd_terukur_tonase" class="col-sm-4 col-form-label">Tonase:</label>
                    <div class="col-sm-8">
                        <input type="number" step="0.01" name="sd_terukur_tonase" id="sd_terukur_tonase" class="form-control"
                            placeholder="Masukkan tonase terukur" value="<?= old('sd_terukur_tonase') ?>">
                    </div>
                </div>

            </div>
        </div>

        <!-- CADANGAN -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Cadangan</h6>
            </div>
            <div class="card-body">
                <h6 class="text-secondary">Terkira</h6>
                <div class="form-group row">
                    <label for="cd_terkira_volume" class="col-sm-4 col-form-label">Volume (m³):</label>
                    <div class="col-sm-8">
                        <input type="number" step="0.01" name="cd_terkira_volume" id="cd_terkira_volume" class="form-control"
                            placeholder="Masukkan volume terkira" value="<?= old('cd_terkira_volume') ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="cd_terkira_tonase" class="col-sm-4 col-form-label">Tonase:</label>
                    <div class="col-sm-8">
                        <input type="number" step="0.01" name="cd_terkira_tonase" id="cd_terkira_tonase" class="form-control"
                            placeholder="Masukkan tonase terkira" value="<?= old('cd_terkira_tonase') ?>">
                    </div>
                </div>
                <hr>

                <h6 class="text-secondary">Terbukti</h6>
                <div class="form-group row">
                    <label for="cd_terbukti_volume" class="col-sm-4 col-form-label">Volume (m³):</label>
                    <div class="col-sm-8">
                        <input type="number" step="0.01" name="cd_terbukti_volume" id="cd_terbukti_volume" class="form-control"
                            placeholder="Masukkan volume terbukti" value="<?= old('cd_terbukti_volume') ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="cd_terbukti_tonase" class="col-sm-4 col-form-label">Tonase:</label>
                    <div class="col-sm-8">
                        <input type="number" step="0.01" name="cd_terbukti_tonase" id="cd_terbukti_tonase" class="form-control"
                            placeholder="Masukkan tonase terbukti" value="<?= old('cd_terbukti_tonase') ?>">
                    </div>
                </div>
            </div>
        </div>

        <!-- PRODUKSI -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Rencana Produksi</h6>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label for="prod_harian" class="col-sm-4 col-form-label">Produksi Harian (m³/hari):</label>
                    <div class="col-sm-8">
                        <input type="number" step="0.01" name="prod_harian" id="prod_harian" class="form-control"
                            placeholder="Masukkan produksi per hari" value="<?= old('prod_harian') ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="prod_bulanan" class="col-sm-4 col-form-label">Produksi Bulanan (m³/bulan):</label>
                    <div class="col-sm-8">
                        <input type="number" step="0.01" name="prod_bulanan" id="prod_bulanan" class="form-control"
                            placeholder="Masukkan produksi per bulan" value="<?= old('prod_bulanan') ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="prod_tahunan" class="col-sm-4 col-form-label">Produksi Tahunan (m³/tahun):</label>
                    <div class="col-sm-8">
                        <input type="number" step="0.01" name="prod_tahunan" id="prod_tahunan" class="form-control"
                            placeholder="Masukkan produksi per tahun" value="<?= old('prod_tahunan') ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="umur_tambang" class="col-sm-4 col-form-label">Perkiraan Umur Tambang (tahun):</label>
                    <div class="col-sm-8">
                        <input type="number" step="1" name="umur_tambang" id="umur_tambang" class="form-control"
                            placeholder="Masukkan umur tambang (contoh: 5)" value="<?= old('umur_tambang') ?>">
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
