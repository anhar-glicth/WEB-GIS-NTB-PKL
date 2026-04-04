<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>

<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800">Input Data Koordinat Poligon</h1>

  <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
  <?php endif; ?>

  <form action="<?= base_url('Home/simpanPoligon') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="row">
        <!-- FORM METADATA -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Lokasi</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama Perusahaan</label>
                        <input type="text" name="companyName" class="form-control" required placeholder="PT. Tambang Maju">
                    </div>
                    <div class="form-group">
                        <label>Nama Lokasi / Blok</label>
                        <input type="text" name="locationName" class="form-control" required placeholder="Blok Sekotong">
                    </div>
                    <div class="form-group">
                        <label>Nomor Izin (IUP)</label>
                        <input type="text" name="permit" class="form-control" required placeholder="123/IUP/2024">
                    </div>
                    <div class="form-group">
                        <label>Foto Lokasi</label>
                        <input type="file" name="foto_lokasi" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Dokumen Pendukung (PDF)</label>
                        <input type="file" name="dokumen_pendukung" class="form-control">
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary btn-block">Simpan Seluruh Koordinat</button>
                    <button type="reset" class="btn btn-secondary btn-block">Reset Form</button>
                </div>
            </div>
        </div>

        <!-- PETA & TABEL -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Gambar Area di Peta</h6>
                    <input type="color" id="colorPicker" value="#4e73df" class="form-control-sm">
                </div>
                <div class="card-body" style="padding: 0;">
                    <div id="map" style="width: 100%; height: 500px;"></div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Titik Koordinat</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="max-height: 300px;">
                        <table class="table table-bordered" id="coordTable" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Lat (Dec)</th>
                                    <th>Long (Dec)</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="coordInputs">
                                <!-- Input hidden akan masuk ke sini secara otomatis saat gambar di peta -->
                            </tbody>
                        </table>
                    </div>
                    <div id="no-data-msg" class="text-center py-3 text-muted">
                        Silakan gunakan alat gambar (Polygon) di peta untuk mengambil titik.
                    </div>
                </div>
            </div>
        </div>
    </div>
  </form>
</div>

<!-- LEAFLET & DRAW -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.js"></script>

<script>
  // Inisialisasi Peta
  var map = L.map('map').setView([-8.65, 116.3], 9);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map);

  var drawnItems = new L.FeatureGroup();
  map.addLayer(drawnItems);

  var drawControl = new L.Control.Draw({
    draw: {
      polygon: { shapeOptions: { color: document.getElementById('colorPicker').value } },
      polyline: false, rectangle: false, circle: false, marker: false, circlemarker: false
    },
    edit: { featureGroup: drawnItems, remove: true }
  });
  map.addControl(drawControl);

  // Saat Poligon Selesai Digambar
  map.on(L.Draw.Event.CREATED, function (event) {
    var layer = event.layer;
    drawnItems.addLayer(layer);
    
    var latlngs = layer.getLatLngs()[0];
    updateInputs(latlngs);
  });

  // Update Input Hidden & Tabel
  function updateInputs(latlngs) {
    var tbody = document.getElementById('coordInputs');
    var msg = document.getElementById('no-data-msg');
    tbody.innerHTML = '';
    msg.style.display = 'none';

    latlngs.forEach(function(latlng, idx) {
      // 1. Tambah baris ke tabel (visual)
      var tr = document.createElement('tr');
      tr.innerHTML = `<td>${idx + 1}</td>
                      <td>${latlng.lat.toFixed(6)}</td>
                      <td>${latlng.lng.toFixed(6)}</td>
                      <td><span class="badge badge-success">OK</span></td>`;
      tbody.appendChild(tr);

      // 2. Tambah input hidden (untuk form submission)
      // Kita pecah ke DMS untuk menyesuaikan controller simpanPoligon
      const dmsLat = toDMS(latlng.lat);
      const dmsLng = toDMS(latlng.lng);

      tbody.innerHTML += `<input type="hidden" name="lat_deg[]" value="${dmsLat.d}">
                          <input type="hidden" name="lat_min[]" value="${dmsLat.m}">
                          <input type="hidden" name="lat_sec[]" value="${dmsLat.s}">
                          <input type="hidden" name="lat_dir[]" value="${latlng.lat >= 0 ? 'N' : 'S'}">
                          
                          <input type="hidden" name="long_deg[]" value="${dmsLng.d}">
                          <input type="hidden" name="long_min[]" value="${dmsLng.m}">
                          <input type="hidden" name="long_sec[]" value="${dmsLng.s}">
                          <input type="hidden" name="long_dir[]" value="${latlng.lng >= 0 ? 'E' : 'W'}">`;
    });
  }

  function toDMS(deg) {
    var d = Math.floor(Math.abs(deg));
    var minFloat = (Math.abs(deg) - d) * 60;
    var m = Math.floor(minFloat);
    var s = ((minFloat - m) * 60).toFixed(2);
    return {d, m, s};
  }

  // Ganti Warna
  document.getElementById('colorPicker').addEventListener('change', function() {
    var newColor = this.value;
    drawnItems.eachLayer(function(layer) { layer.setStyle({ color: newColor }); });
  });
</script>

<?= $this->endSection() ?>
