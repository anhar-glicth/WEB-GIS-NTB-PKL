<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Sebaran Titik Kawasan Pertambangan (Marker)</h6>
            <div class="dropdown no-arrow d-flex">
                <a class="btn btn-warning btn-sm mr-2 shadow-sm text-dark font-weight-bold" href="<?= base_url('poligon_view') ?>">
                    <i class="fas fa-hand-pointer text-dark"></i> Sematkan Manual
                </a>
                <a class="btn btn-primary btn-sm shadow-sm" href="<?= base_url('Home/poligon') ?>">
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

    // 3. Render Data from Database (Poligon & Marker)
    <?php 
    // Kelompokkan koordinat berdasarkan Perusahaan + Izin agar jadi satu poligon/grup
    $polygons = [];
    foreach ($koordinat as $k) {
        $key = str_replace(' ', '_', $k['companyName'] . '_' . $k['permit']);
        if (!isset($polygons[$key])) {
            $polygons[$key] = [
                'name' => $k['companyName'],
                'permit' => $k['permit'],
                'location' => $k['locationName'],
                'points' => []
            ];
        }
        $polygons[$key]['points'][] = [$k['latitude_deg'], $k['latitude_min'], $k['latitude_sec'], $k['latitude_dir'], $k['longitude_deg'], $k['longitude_min'], $k['longitude_sec'], $k['longitude_dir']];
    }
    ?>

    var colors = ['#e74c3c', '#2ecc71', '#3498db', '#9b59b6', '#f1c40f', '#e67e22', '#1abc9c', '#34495e'];
    var colorIdx = 0;

    <?php foreach ($polygons as $id => $p): ?>
        var polyCoords = [];
        var pointCount = <?= count($p['points']) ?>;
        
        <?php foreach ($p['points'] as $pt): ?>
            var lat = dmsToDecimal(<?= $pt[0] ?>, <?= $pt[1] ?>, <?= $pt[2] ?>, '<?= $pt[3] ?>');
            var lng = dmsToDecimal(<?= $pt[4] ?>, <?= $pt[5] ?>, <?= $pt[6] ?>, '<?= $pt[7] ?>');
            polyCoords.push([lat, lng]);
        <?php endforeach; ?>

        var color = colors[colorIdx % colors.length];
        colorIdx++;

        if (pointCount > 1) {
            // CASE: POLIGON
            var polygon = L.polygon(polyCoords, {
                color: color,
                fillColor: color,
                fillOpacity: 0.45,
                weight: 3
            }).addTo(map);

            // Tambahkan marker kecil di setiap sudut
            polyCoords.forEach(function(coord) {
                 L.circleMarker(coord, {radius: 4, color: 'white', weight: 1, fillOpacity: 0.8, fillColor: color}).addTo(map);
            });

            polygon.bindPopup(`
                <div style="min-width: 150px;">
                    <div class="badge badge-dark mb-1" style="background:${color};">AREA PERIZINAN</div>
                    <h6 class="mb-1"><b><?= $p['name'] ?></b></h6>
                    <p style="font-size: 12px; margin-bottom: 0;"><b>Lokasi:</b> <?= $p['location'] ?></p>
                    <small class="text-muted">Izin: <?= $p['permit'] ?></small>
                </div>
            `);
        } else {
            // CASE: MARKER TUNGGAL
            var marker = L.marker(polyCoords[0]).addTo(map);
            marker.bindPopup(`
                <div style="min-width: 150px;">
                    <div class="badge badge-success mb-1">TITIK LOKASI</div>
                    <h6><b><?= $p['name'] ?></b></h6>
                    <small class="text-muted"><?= $p['permit'] ?></small>
                </div>
            `);
        }
    <?php endforeach; ?>

    // DMS Converter Helper
    function dmsToDecimal(deg, min, sec, dir) {
        var res = parseFloat(deg) + (parseFloat(min) / 60) + (parseFloat(sec) / 3600);
        if (dir === 'S' || dir === 'W') res = res * -1;
        return res;
    }
</script>

<?= $this->endSection() ?>
