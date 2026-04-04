<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>

<div class="container-fluid">
    <!-- Row: Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">Visualisasi Seluruh Wilayah Pertambangan</h6>
                    <div class="dropdown no-arrow">
                        <a class="btn btn-light btn-sm shadow-sm" href="<?= base_url('Home/poligon') ?>">
                            <i class="fas fa-plus fa-sm text-primary"></i> <span class="d-none d-sm-inline">Tambah Data SIG</span>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <!-- Map Container with Responsive Height -->
                    <div id="map" style="width: 100%; height: 75vh; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- LEAFLET -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    // 1. Layer Definitions
    var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    });

    var googleHybrid = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
        maxZoom: 20,
        subdomains:['mt0','mt1','mt2','mt3']
    });

    // 2. Map Initialization
    var map = L.map('map', {
        center: [-8.65, 116.3], // NTT/NTB
        zoom: 9,
        layers: [osm]
    });

    var baseMaps = {
        "Struktur Jalan (OSM)": osm,
        "Satelit (Hybrid)": googleHybrid
    };
    L.control.layers(baseMaps).addTo(map);

    // 3. Render Data from Database
    <?php foreach ($koordinat as $k): ?>
        var lat = dmsToDecimal(<?= $k['latitude_deg'] ?>, <?= $k['latitude_min'] ?>, <?= $k['latitude_sec'] ?>, '<?= $k['latitude_dir'] ?>');
        var lng = dmsToDecimal(<?= $k['longitude_deg'] ?>, <?= $k['longitude_min'] ?>, <?= $k['longitude_sec'] ?>, '<?= $k['longitude_dir'] ?>');
        
        L.marker([lat, lng]).addTo(map)
            .bindPopup(`
                <div style="min-width: 180px;">
                    <div class="badge badge-primary mb-2"><?= $k['permit'] ?></div>
                    <h6 class="mb-1"><b><?= $k['companyName'] ?></b></h6>
                    <hr class="my-1">
                    <p class="small text-muted mb-2"><b>Area:</b> <?= $k['locationName'] ?></p>
                    <?php if ($k['foto_lokasi']): ?>
                        <img src="<?= base_url('uploads/lokasi/' . $k['foto_lokasi']) ?>" 
                             class="img-fluid rounded mb-2 shadow-sm" 
                             style="max-height: 100px; width: 100%; object-fit: cover;">
                    <?php endif; ?>
                    <a href="<?= base_url('user/laporan') ?>" class="btn btn-info btn-xs btn-block text-white" style="font-size: 10px;">Lihat Laporan Teknis</a>
                </div>
            `);
    <?php endforeach; ?>

    // DMS Converter Helper
    function dmsToDecimal(deg, min, sec, dir) {
        var res = deg + (min / 60) + (sec / 3600);
        if (dir === 'S' || dir === 'W') res = res * -1;
        return res;
    }
</script>

<style>
    /* Styling khusus button popup agar lebih cantik */
    .btn-xs { padding: 2px 5px; font-size: 10px; border-radius: 3px; }
    .badge-primary { font-size: 9px; padding: 4px 8px; }
</style>

<?= $this->endSection() ?>
