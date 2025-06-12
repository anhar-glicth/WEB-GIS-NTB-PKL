<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>

<!-- Container utama dengan padding kiri-kanan -->
<div style="padding: 0 30px;"> <!-- Ganti nilai 30px sesuai kebutuhan -->

  <!-- Peta -->
  <div id="map" style="width: 100%; height: 80vh; margin-bottom: 20px;"></div>
 
  <!-- Tabel koordinat -->
  <div style="height: 20vh; overflow-y: auto; padding: 10px; background: #f9f9f9; border: 1px solid #ccc; position: relative;">
    <input type="color" id="colorPicker" value="#ff0000" style="position: absolute; top: 10px; left: 10px; z-index: 1000;" />
    <table id="coordTable" border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse; margin-top: 30px;">
      <thead>
        <tr>
          <th>No</th>
          <th>Latitude (Decimal)</th>
          <th>Latitude (DMS)</th>
          <th>Longitude (Decimal)</th>
          <th>Longitude (DMS)</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>

  <!-- Tombol Unduh -->
  <div style="margin-top: 10px;">
    <button onclick="downloadExcel()">Unduh Excel</button>
    <button onclick="downloadWord()">Unduh Word</button>
  </div>
</div>

<!-- CSS dan JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

<script>
  var map = L.map('map').setView([0, 0], 2);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map);

  L.Control.geocoder({ defaultMarkGeocode: true }).addTo(map);

  var drawnItems = new L.FeatureGroup();
  map.addLayer(drawnItems);

  function getSelectedColor() {
    return document.getElementById('colorPicker').value;
  }

  var drawControl = new L.Control.Draw({
    draw: {
      polygon: {
        shapeOptions: {
          color: getSelectedColor()
        }
      },
      polyline: false,
      rectangle: false,
      circle: false,
      marker: false,
      circlemarker: false
    },
    edit: {
      featureGroup: drawnItems,
      remove: true
    }
  });
  map.addControl(drawControl);

  let lastCoordinates = [];

  function convertDMS(dec, isLat) {
    var deg = Math.floor(Math.abs(dec));
    var minFloat = (Math.abs(dec) - deg) * 60;
    var min = Math.floor(minFloat);
    var sec = ((minFloat - min) * 60).toFixed(2);
    var dir = isLat ? (dec >= 0 ? 'N' : 'S') : (dec >= 0 ? 'E' : 'W');
    return `${deg}° ${min}' ${sec}" ${dir}`;
  }

  function updateTable(latlngs) {
    lastCoordinates = latlngs;
    var tbody = document.querySelector('#coordTable tbody');
    tbody.innerHTML = '';

    latlngs.forEach(function(latlng, idx) {
      var latDMS = convertDMS(latlng.lat, true);
      var lngDMS = convertDMS(latlng.lng, false);
      var tr = document.createElement('tr');
      tr.innerHTML = `<td>${idx + 1}</td>
                      <td>${latlng.lat.toFixed(6)}</td>
                      <td>${latDMS}</td>
                      <td>${latlng.lng.toFixed(6)}</td>
                      <td>${lngDMS}</td>`;
      tbody.appendChild(tr);
    });
  }

  map.on(L.Draw.Event.CREATED, function (event) {
    var layer = event.layer;
    layer.setStyle({ color: getSelectedColor() });
    drawnItems.addLayer(layer);
    var latlngs = layer.getLatLngs()[0];
    updateTable(latlngs);
  });

  document.getElementById('colorPicker').addEventListener('change', function() {
    var newColor = this.value;
    drawnItems.eachLayer(function(layer) {
      layer.setStyle({ color: newColor });
    });
  });

  function downloadExcel() {
    if (lastCoordinates.length === 0) return alert("Belum ada koordinat!");

    const data = lastCoordinates.map((latlng, idx) => ({
      No: idx + 1,
      Latitude_Decimal: latlng.lat.toFixed(6),
      Latitude_DMS: convertDMS(latlng.lat, true),
      Longitude_Decimal: latlng.lng.toFixed(6),
      Longitude_DMS: convertDMS(latlng.lng, false)
    }));

    const ws = XLSX.utils.json_to_sheet(data);
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, "Koordinat");
    XLSX.writeFile(wb, "Koordinat_Poligon.xlsx");
  }

  function downloadWord() {
    if (lastCoordinates.length === 0) return alert("Belum ada koordinat!");

    let content = "Daftar Koordinat Titik:\n\n";
    lastCoordinates.forEach((latlng, idx) => {
      content += `${idx + 1}. Lat: ${latlng.lat.toFixed(6)} (${convertDMS(latlng.lat, true)}), Lng: ${latlng.lng.toFixed(6)} (${convertDMS(latlng.lng, false)})\n`;
    });

    const blob = new Blob([content], {
      type: "application/vnd.openxmlformats-officedocument.wordprocessingml.document"
    });
    saveAs(blob, "Koordinat_Poligon.doc");
  }
</script>

<?= $this->endSection() ?>
