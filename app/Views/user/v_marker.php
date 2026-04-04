<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Sebaran Titik Kawasan Pertambangan (Marker)</h6>
            <div class="dropdown no-arrow">
                <a class="btn btn-primary btn-sm" href="<?= base_url('Home/poligon') ?>">
                    <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data Baru
                </a>
            </div>
        </div>
        <div class="card-body">
            <div id="map" style="width: 100%; height: 75vh; border-radius: 10px;"></div>
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

    // 2. Initialize Map
    var map = L.map('map', {
        center: [-8.65, 116.3], // NTB
        zoom: 9,
        layers: [osm]
    });

    var baseMaps = {
        "OpenStreetMap": osm,
        "Google Satellite": googleHybrid
    };
    L.control.layers(baseMaps).addTo(map);

    // 3. Render Markers from Database
    <?php foreach ($koordinat as $k): ?>
        <?php 
            // Konversi DMS ke Decimal jika diperlukan, atau langsung gunakan jika sudah decimal
            // Karena kita menyimpan dalam format DMS (deg, min, sec), kita lakukan konversi di sisi JS
            $lat = $k['latitude_deg']; // placeholder, let's assume we use helper below
        ?>
        
        var lat = dmsToDecimal(<?= $k['latitude_deg'] ?>, <?= $k['latitude_min'] ?>, <?= $k['latitude_sec'] ?>, '<?= $k['latitude_dir'] ?>');
        var lng = dmsToDecimal(<?= $k['longitude_deg'] ?>, <?= $k['longitude_min'] ?>, <?= $k['longitude_sec'] ?>, '<?= $k['longitude_dir'] ?>');
        
        L.marker([lat, lng]).addTo(map)
            .bindPopup(`
                <div style="min-width: 150px;">
                    <h6 style="margin-bottom: 5px;"><b><?= $k['companyName'] ?></b></h6>
                    <p style="font-size: 12px; margin-bottom: 3px;">
                        <b>Lokasi:</b> <?= $k['locationName'] ?><br>
                        <b>Izin:</b> <?= $k['permit'] ?>
                    </p>
                    <a href="<?= base_url('Home/viewMaps') ?>" class="btn btn-info btn-sm text-white" style="font-size: 10px;">Detail Map</a>
                </div>
            `);
    <?php endforeach; ?>

    // Helper Konversi DMS
    function dmsToDecimal(deg, min, sec, dir) {
        var res = deg + (min / 60) + (sec / 3600);
        if (dir === 'S' || dir === 'W') {
            res = res * -1;
        }
        return res;
    }
</script>

<?= $this->endSection() ?>
