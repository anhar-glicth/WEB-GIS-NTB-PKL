<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>

<div class="row" style="margin: 0;">
  <!-- Kolom Peta -->
  <div class="col-md-8" style="padding: 0; margin-left: 5px;">

    <div id="map" style="width: 100%; height: 100vh;"></div>
  </div>

  <!-- Kolom Inputan -->
  <div class="col-md-3" style="padding: 10px; background-color: #f8f9fa;">
    <?php $errors = session('errors'); ?>

    <?php echo form_open_multipart('Lokasi/insertData'); ?>
    <h5>Input Koordinat Manual (DMS)</h5>

    <!-- Nama Lokasi -->
    <div class="form-group">
        <label for="locationName">Nama Lokasi</label>
        <input type="text" id="locationName" class="form-control form-control-sm" placeholder="Nama lokasi" name="locationName">
       <p class="text-danger"><?= isset($errors['locationName']) ? validation_show_error('locationName') : '' ?></p>

    </div>

    <!-- Nama Perusahaan -->
    <div class="form-group mt-2">
        <label for="companyName">Nama Perusahaan</label>
        <input type="text" id="companyName" class="form-control form-control-sm" placeholder="Nama perusahaan" name="companyName">
<p class="text-danger"><?= isset($errors['companyName']) ? validation_show_error('companyName') : '' ?></p>

    </div>

    <!-- Surat Izin -->
    <div class="form-group mt-2">
        <label for="permit">Surat Izin (No. atau Nama)</label>
        <input type="text" id="permit" class="form-control form-control-sm" placeholder="Nomor/Nama surat izin" name="permit">
        <p class="text-danger"><?= isset($errors['permit']) ? validation_show_error('permit') : '' ?></p>


    <!-- Latitude -->
    <div class="mt-3">
      <strong>Latitude:</strong><br>
      <input type="number" id="latDeg" placeholder="Derajat" style="width: 70px;" name="latitude_deg">
      <input type="number" id="latMin" placeholder="Menit" style="width: 70px;"name="latitude_min">
      <input type="number" id="latSec" placeholder="Detik" style="width: 70px;"name="latitude_sec"><br>
      <select id="latDir" class="form-select form-select-sm mt-1" style="width: 80px;" name="latitude_dir">
        
        <option value="N" name="latitude_dir">N</option>
        <option value="S"name="latitude_dir">S</option>
      </select>
    </div>

    <!-- Longitude -->
    <div class="mt-3">
      <strong>Longitude:</strong><br>
      <input type="number" id="lngDeg" placeholder="Derajat" style="width: 70px;" name="longitude_deg">
      <input type="number" id="lngMin" placeholder="Menit" style="width: 70px;"name="longitude_min">
      <input type="number" id="lngSec" placeholder="Detik" style="width: 70px;"name="longitude_sec"><br>
      <select id="lngDir" class="form-select form-select-sm mt-1" style="width: 80px;"name="longitude_dir">
        <option value="E"name="longitude_dir">E</option>
        <option value="W"name="longitude_dir">W</option>
      </select>
    </div>

 <!-- foto start -->
  <div class="form-group">
    <label for="input poto">Foto lokasi</label>
    <input type="file" class="form-control form-control-sm" id="foto_lokasi" name="foto_lokasi" accept="image/*" onchange="previewImage(event)">

    <small class="form-text text-muted">Format gambar: jpg, jpeg, png. Maksimal ukuran 2MB.</small>
    <div class="mt-2">
      <img id="preview" src="#" alt="Preview" style="display: none; max-width: 100%; height: auto;">

  </div>

  <!-- foto end -->
    <!-- Tombol -->
    <button type="submit"class=" btn btn-primary btn-sm mt-3" onclick="addManualPointDMS()">Tambah Titik</button>
  </div>
  <?php echo form_close(); ?>
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

    // =========================
    // Tambahan: Klik Map => isi form & marker
    // =========================
    let marker;

    function toDMS(decimal, isLat = true) {
        const dir = decimal >= 0 ? (isLat ? 'N' : 'E') : (isLat ? 'S' : 'W');
        const abs = Math.abs(decimal);
        const deg = Math.floor(abs);
        const minFloat = (abs - deg) * 60;
        const min = Math.floor(minFloat);
        const sec = Math.round((minFloat - min) * 60);
        return { deg, min, sec, dir };
    }

    function setFormFromLatLng(latlng) {
        const lat = toDMS(latlng.lat, true);
        const lng = toDMS(latlng.lng, false);

        document.getElementById("latDeg").value = lat.deg;
        document.getElementById("latMin").value = lat.min;
        document.getElementById("latSec").value = lat.sec;
        document.getElementById("latDir").value = lat.dir;

        document.getElementById("lngDeg").value = lng.deg;
        document.getElementById("lngMin").value = lng.min;
        document.getElementById("lngSec").value = lng.sec;
        document.getElementById("lngDir").value = lng.dir;
    }

    map.on('click', function(e) {
        const latlng = e.latlng;

        if (marker) {
            marker.setLatLng(latlng);
        } else {
            marker = L.marker(latlng).addTo(map);
        }

        setFormFromLatLng(latlng);
    });
    function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function() {
        var output = document.getElementById('preview');
        output.src = reader.result;
        output.style.display = 'block';
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>
<?= $this->endSection() ?>