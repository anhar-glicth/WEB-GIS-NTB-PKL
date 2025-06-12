<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>

<!-- Wrapper dengan padding -->
<div style="display: flex; height: 100vh; padding: 20px; box-sizing: border-box;">
  <div id="map" style="flex-grow: 1; border: 1px solid #ccc; border-radius: 8px;"></div>
</div>

<!-- CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

<!-- JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<script>
    // Definisi basemaps
    var peta1 = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        attribution: 'Map data &copy; OpenStreetMap, Imagery © Mapbox',
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1
    });

    var peta2 = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        attribution: 'Map data &copy; OpenStreetMap, Imagery © Mapbox',
        id: 'mapbox/satellite-v9',
        tileSize: 512,
        zoomOffset: -1
    });

    var peta3 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    });

    var peta4 = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        attribution: 'Map data &copy; OpenStreetMap, Imagery © Mapbox',
        id: 'mapbox/dark-v10',
        tileSize: 512,
        zoomOffset: -1
    });

    // Inisialisasi peta
    var map = L.map('map', {
        center: [-6.2, 106.8], // Jakarta
        zoom: 13,
        layers: [peta1] // Layer default
    });

    // Kontrol layer
    var baseMaps = {
        "Mapbox Streets": peta1,
        "Mapbox Satellite": peta2,
        "OpenStreetMap": peta3,
        "Mapbox Dark": peta4
    };
    L.control.layers(baseMaps).addTo(map);

    // Tambahkan search
    L.Control.geocoder({
        defaultMarkGeocode: false
    }).on('markgeocode', function(e) {
        var latlng = e.geocode.center;
        L.marker(latlng).addTo(map)
            .bindPopup(e.geocode.name).openPopup();
        map.setView(latlng, 14);
    }).addTo(map);
</script>

<?= $this->endSection() ?>
