<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Pilihan Tampilan Peta (Basemaps)</h6>
        </div>
        <div class="card-body">
            <div id="map" style="width: 100%; height: 650px; border-radius: 10px; border: 1px solid #ccc;"></div>
        </div>
    </div>
</div>

<!-- LEAFLET -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    // 1. Definisi Layer OpenStreetMap (Gratis & Selalu Tersedia)
    var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    });

    // 2. Definisi Layer Google Maps (Sering Disukai User)
    var googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
        maxZoom: 20,
        subdomains:['mt0','mt1','mt2','mt3']
    });

    var googleHybrid = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
        maxZoom: 20,
        subdomains:['mt0','mt1','mt2','mt3']
    });

    // 3. Inisialisasi Peta - Fokus ke NTB
    var map = L.map('map', {
        center: [-8.65, 116.3], // Nusa Tenggara Barat (Pusat)
        zoom: 9,
        layers: [osm] // Layer Default
    });

    // 4. Kontrol Pilihan Layer
    var baseMaps = {
        "OpenStreetMap": osm,
        "Google Streets": googleStreets,
        "Google Satellite (Hybrid)": googleHybrid
    };

    L.control.layers(baseMaps).addTo(map);

    // 5. Tambahkan Skala
    L.control.scale({position: 'bottomright'}).addTo(map);
</script>

<?= $this->endSection() ?>
