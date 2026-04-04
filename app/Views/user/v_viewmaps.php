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

    // 3. Render Data from Database (Poligon & Marker)
    <?php 
    // Kelompokkan koordinat berdasarkan Perusahaan + Izin agar jadi satu poligon
    $polygons = [];
    foreach ($koordinat as $k) {
        $key = str_replace(' ', '_', $k['companyName'] . '_' . $k['permit']);
        if (!isset($polygons[$key])) {
            $polygons[$key] = [
                'name' => $k['companyName'],
                'permit' => $k['permit'],
                'location' => $k['locationName'],
                'foto' => $k['foto_lokasi'],
                'points' => []
            ];
        }
        $polygons[$key]['points'][] = [$k['latitude_deg'], $k['latitude_min'], $k['latitude_sec'], $k['latitude_dir'], $k['longitude_deg'], $k['longitude_min'], $k['longitude_sec'], $k['longitude_dir']];
    }
    ?>

    // Array warna untuk poligon agar bervariasi
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
            // CASE: POLIGON (Jika titik lebih dari satu, buat garis/arsiran)
            var area = L.polygon(polyCoords, {
                color: color,
                fillColor: color,
                fillOpacity: 0.45,
                weight: 3
            }).addTo(map);

            // Tambahkan marker kecil di setiap sudut poligon
            polyCoords.forEach(function(coord) {
                 L.circleMarker(coord, {radius: 4, color: 'white', weight: 1, fillOpacity: 1, fillColor: color}).addTo(map);
            });

            area.bindPopup(`
                <div style="min-width: 180px;">
                    <div class="badge badge-dark mb-1" style="background:${color};">AREA PERIZINAN</div>
                    <h6 class="mb-0"><b><?= $p['name'] ?></b></h6>
                    <small class="text-muted d-block mb-2"><?= $p['permit'] ?></small>
                    <hr class="my-1">
                    <?php if ($p['foto']): ?>
                        <img src="<?= base_url('uploads/lokasi/' . $p['foto']) ?>" class="img-fluid rounded border mb-2" style="max-height: 100px; width:100%; object-fit:cover;">
                    <?php endif; ?>
                    <p class="small mb-0"><b>Lokasi:</b> <?= $p['location'] ?></p>
                </div>
            `);

        } else {
            // CASE: MARKER TUNGGAL (Jika hanya satu titik)
            var marker = L.marker(polyCoords[0]).addTo(map);
            marker.bindPopup(`
                <div style="min-width: 180px;">
                    <div class="badge badge-success mb-1">TITIK LOKASI</div>
                    <h6 class="mb-0"><b><?= $p['name'] ?></b></h6>
                    <small class="text-muted d-block mb-2"><?= $p['permit'] ?></small>
                    <hr class="my-1">
                    <?php if ($p['foto']): ?>
                        <img src="<?= base_url('uploads/lokasi/' . $p['foto']) ?>" class="img-fluid rounded border mb-2" style="max-height: 100px; width:100%; object-fit:cover;">
                    <?php endif; ?>
                    <p class="small mb-0"><b>Alamat:</b> <?= $p['location'] ?></p>
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

<style>
    /* Styling khusus button popup agar lebih cantik */
    .btn-xs { padding: 2px 5px; font-size: 10px; border-radius: 3px; }
    .badge-primary { font-size: 9px; padding: 4px 8px; }
</style>

<?= $this->endSection() ?>
