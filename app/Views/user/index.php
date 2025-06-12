<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Selamat Datang di Dashboard</h1>

    <div class="row">
        <!-- Card 1: Profil User -->
        <div class="col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <h5 class="card-title">Profil Pengguna</h5>
                    <p class="card-text">Halo, <strong><?= user()->username ?></strong></p>
                    <p>Email: <?= user()->email ?></p>
                    <p>Status: <?= user()->active ? 'Aktif' : 'Nonaktif' ?></p>
                </div>
            </div>
        </div>

        <!-- Card 2: Statistik Laporan -->
        <div class="col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <h5 class="card-title">Statistik Laporan</h5>
                    <p>Total Laporan: <strong><?= $totalLaporan ?? '0' ?></strong></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
