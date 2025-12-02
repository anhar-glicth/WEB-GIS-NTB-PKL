<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $judul; ?></h1>

    <!-- Flash Message -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('info')) : ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="fas fa-info-circle"></i> <?= session()->getFlashdata('info'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-primary text-white">
            <h6 class="m-0 font-weight-bold">Data Identitas Perusahaan</h6>
            <?php if ($perusahaan) : ?>
                <a href="<?= base_url('user/input-perusahaan'); ?>" class="btn btn-sm btn-warning shadow-sm text-dark font-weight-bold">
                    <i class="fas fa-edit fa-sm"></i> Edit Data
                </a>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <?php if ($perusahaan) : ?>
                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-md-6">
                        <table class="table table-borderless table-sm">
                            <tr>
                                <th width="35%">Nama Perusahaan</th>
                                <td>: <strong><?= esc($perusahaan['nama_perusahaan']); ?></strong></td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>: <?= esc($perusahaan['alamat_perusahaan']); ?></td>
                            </tr>
                            <tr>
                                <th>NPWP</th>
                                <td>: <?= esc($perusahaan['npwp'] ?? '-'); ?></td>
                            </tr>
                            <tr>
                                <th>Jenis Usaha</th>
                                <td>: <?= esc($perusahaan['jenis_usaha'] ?? '-'); ?></td>
                            </tr>
                            <tr>
                                <th>Tahun Berdiri</th>
                                <td>: <?= esc($perusahaan['tahun_berdiri'] ?? '-'); ?></td>
                            </tr>
                            <tr>
                                <th>NIB</th>
                                <td>: <?= esc($perusahaan['nib'] ?? '-'); ?></td>
                            </tr>
                        </table>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="col-md-6 border-left-lg">
                        <table class="table table-borderless table-sm">
                            <tr>
                                <th width="35%">Izin Usaha (IUP)</th>
                                <td>: <?= esc($perusahaan['izin_usaha'] ?? '-'); ?></td>
                            </tr>
                            <tr>
                                <th>Masa Berlaku</th>
                                <td>: <?= esc($perusahaan['masa_berlaku'] ?? '-'); ?></td>
                            </tr>
                            <tr>
                                <th>Nama Direktur</th>
                                <td>: <strong><?= esc($perusahaan['nama_direktur']); ?></strong></td>
                            </tr>
                            <tr>
                                <th>Email Perusahaan</th>
                                <td>: <?= esc($perusahaan['email_perusahaan']); ?></td>
                            </tr>
                            <tr>
                                <th>No. Telepon</th>
                                <td>: <?= esc($perusahaan['no_telepon']); ?></td>
                            </tr>
                            <tr>
                                <th>Website</th>
                                <td>: 
                                    <?php if(!empty($perusahaan['website'])): ?>
                                        <a href="<?= esc($perusahaan['website']); ?>" target="_blank"><?= esc($perusahaan['website']); ?></a>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            <?php else : ?>
                <div class="text-center py-5">
                    <img src="https://img.icons8.com/clouds/100/000000/company.png" alt="No Data" class="mb-3">
                    <h5 class="text-gray-600 mb-3">Data Perusahaan Belum Dilengkapi</h5>
                    <p class="mb-4">Silakan lengkapi data identitas perusahaan Anda untuk keperluan administrasi.</p>
                    <a href="<?= base_url('user/input-perusahaan'); ?>" class="btn btn-primary btn-lg shadow-sm">
                        <i class="fas fa-plus-circle mr-2"></i> Lengkapi Data Sekarang
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>

<?= $this->endSection(); ?>