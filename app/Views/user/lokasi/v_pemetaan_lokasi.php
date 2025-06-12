<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>

<!-- Container utama -->
<div style="display: flex; height: 100vh; box-sizing: border-box;">

  <!-- Sidebar -->
  <div id="sidebar" style="width: 20px; background:#F6F7FA; padding: 20px; border-right: 1px solid #ddd;">
    <!-- Konten sidebar di sini -->
    
  </div>

  <!-- Kontainer Peta (dengan padding kiri & kanan) -->
  <div style="flex-grow: 1; padding: 20px; box-sizing: border-box;">
    <div id="map" style="width: 100%; height: 100%;"></div>
  </div>

</div>
<!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-search/dist/leaflet-search.min.css" />

    <style>
        #map {
            width: 100%;
            height: 100vh;
        }
    </style>
</head>
<body>

<div id="map"></div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<script src="https://unpkg.com/leaflet-control-search/dist/leaflet-search.min.js"></script>

<script>
    // Basemap
    var peta1 = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        attribution: 'Map data &copy; OpenStreetMap, Imagery © Mapbox',
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1
    });

    var peta2 = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        id: 'mapbox/satellite-v9',
        tileSize: 512,
        zoomOffset: -1
    });

    var peta3 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    });

    var peta4 = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        id: 'mapbox/dark-v10',
        tileSize: 512,
        zoomOffset: -1
    });

    // Inisialisasi peta
    var map = L.map('map', {
        center: [-6.2, 106.8],
        zoom: 6,
        layers: [peta1]
    });

    // Layer switcher
    var baseMaps = {
        "Mapbox Streets": peta1,
        "Mapbox Satellite": peta2,
        "OpenStreetMap": peta3,
        "Mapbox Dark": peta4
    };
    L.control.layers(baseMaps).addTo(map);

    // Geocoder
    L.Control.geocoder({
        defaultMarkGeocode: false
    }).on('markgeocode', function(e) {
        var latlng = e.geocode.center;
        L.marker(latlng).addTo(map)
            .bindPopup(e.geocode.name).openPopup();
        map.setView(latlng, 14);
    }).addTo(map);

    // Fungsi konversi DMS ke Decimal
    function dmsToDecimal(deg, min, sec, dir) {
        var decimal = parseFloat(deg) + (parseFloat(min) / 60) + (parseFloat(sec) / 3600);
        if (dir === 'S' || dir === 'W') {
            decimal *= -1;
        }
        return decimal;
    }

    // Data dari controller
    var lokasi = <?= json_encode($lokasi) ?>;

    // LayerGroup untuk pencarian marker
    var markersLayer = new L.LayerGroup();
    map.addLayer(markersLayer);

    for (var i = 0; i < lokasi.length; i++) {
        var lat = dmsToDecimal(lokasi[i].latitude_deg, lokasi[i].latitude_min, lokasi[i].latitude_sec, lokasi[i].latitude_dir);
        var lng = dmsToDecimal(lokasi[i].longitude_deg, lokasi[i].longitude_min, lokasi[i].longitude_sec, lokasi[i].longitude_dir);
        var fotoUrl = "<?= base_url('uploads') ?>/" + lokasi[i].foto_lokasi;

        var popupContent = `
            <div style="min-width:50px">
                <b>Lokasi:</b> ${lokasi[i].locationName}<br>
                <b>Perusahaan:</b> ${lokasi[i].companyName}<br>
                <b>Permit:</b> ${lokasi[i].permit ?? 'Tidak Ada'}<br>
                <b>Latitude:</b> ${lokasi[i].latitude_deg}° ${lokasi[i].latitude_min}' ${lokasi[i].latitude_sec}" ${lokasi[i].latitude_dir}<br>
                <b>Longitude:</b> ${lokasi[i].longitude_deg}° ${lokasi[i].longitude_min}' ${lokasi[i].longitude_sec}" ${lokasi[i].longitude_dir}<br>
                <b>Gambar:</b><br>
                <img src="${fotoUrl}" alt="Foto Lokasi" style="max-width:100px; margin-top:5px; border:1px solid #ccc;">
            </div>
        `;

        var marker = L.marker([lat, lng], {
            title: lokasi[i].locationName + " - " + lokasi[i].companyName,
            locationName: lokasi[i].locationName.toLowerCase(),
            companyName: lokasi[i].companyName.toLowerCase()
        }).bindPopup(popupContent);

        marker.bindTooltip(
            `<b>${lokasi[i].locationName}</b><br>${lokasi[i].companyName}`,
            { direction: 'top', sticky: true }
        );

        markersLayer.addLayer(marker);
    }

    // Search control yang mendukung pencarian lokasi atau perusahaan
    var searchControl = new L.Control.Search({
        layer: markersLayer,
        zoom: 14,
        initial: false,
        marker: false,
        moveToLocation: function(latlng, title, map) {
            map.setView(latlng, 14);
        },
        filterData: function(text, records) {
            var json = {};
            text = text.toLowerCase();

            markersLayer.eachLayer(function(layer) {
                var loc = layer.options.locationName;
                var comp = layer.options.companyName;

                if (loc.includes(text) || comp.includes(text)) {
                    json[layer._leaflet_id] = layer;
                }
            });

            return json;
        }
    });

    map.addControl(searchControl);

    // Tambah placeholder ke input pencarian
    setTimeout(() => {
        if (searchControl._input) {
            searchControl._input.placeholder = "Cari lokasi atau perusahaan...";
        }
    }, 100);

    // Tampilkan koordinat saat klik di peta
    map.on('click', function(e) {
        alert("Latitude: " + e.latlng.lat + "\nLongitude: " + e.latlng.lng);
    });
</script>

  

</body>
</html>
<?= $this->endSection() ?>