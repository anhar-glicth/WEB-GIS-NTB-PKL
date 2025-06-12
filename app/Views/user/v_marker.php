<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>

<!-- CSS Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

<!-- Layout -->
<div style="display: flex; height: 100vh; box-sizing: border-box;">

    <!-- Sidebar -->
    <div style="width: 20px; background:#F6F7FA; padding: 20px; border-right: 1px solid #ddd;">
        
        </ul>
    </div>

    <!-- Peta -->
    <div id="map" style="flex: 1;"></div>

</div>

<!-- JS Leaflet -->
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

    var peta2 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    });

    var map = L.map('map', {
        center: [-8.65, 116.3], // NTB area
        zoom: 9,
        layers: [peta1]
    });

    var baseMaps = {
        "Mapbox Streets": peta1,
        "OpenStreetMap": peta2
    };
    L.control.layers(baseMaps).addTo(map);

    // Geocoder
    L.Control.geocoder({
        defaultMarkGeocode: false
    }).on('markgeocode', function(e) {
        var latlng = e.geocode.center;
        var companyName = prompt("Masukkan nama perusahaan:", e.geocode.name);
        if (companyName && companyName.trim() !== "") {
            L.marker(latlng).addTo(map)
                .bindPopup(`<b>${companyName}</b><br>${e.geocode.name}`).openPopup();
            map.setView(latlng, 14);
        } else {
            alert("Nama perusahaan tidak boleh kosong.");
        }
    }).addTo(map);

    // ====== Tambah Marker Manual ======
    var addMarkerMode = false;

    var addMarkerButton = L.control({position: 'topright'});
    addMarkerButton.onAdd = function(map) {
        var div = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-custom');
        div.innerHTML = '<button id="addMarkerBtn" title="Tambah Marker Manual" style="background:white;border:none;padding:6px;">📍</button>';
        div.style.cursor = 'pointer';
        return div;
    };
    addMarkerButton.addTo(map);

    document.addEventListener('click', function(e) {
        if (e.target && e.target.id === "addMarkerBtn") {
            alert("Klik di peta untuk menambahkan marker perusahaan.");
            addMarkerMode = true;
        }
    });

    map.on('click', function(e) {
        if (addMarkerMode) {
            var companyName = prompt("Masukkan nama perusahaan:");
            if (companyName && companyName.trim() !== "") {
                L.marker(e.latlng).addTo(map)
                    .bindPopup(`<b>${companyName}</b>`).openPopup();
            } else {
                alert("Nama perusahaan tidak boleh kosong.");
            }
            addMarkerMode = false;
        }
    });
</script>

<style>
    .leaflet-control-custom button:hover {
        background-color: #f0f0f0;
    }
</style>

<?= $this->endSection() ?>
