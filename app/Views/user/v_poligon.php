<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>

<div class="container-fluid">
    <div class="row">
        <!-- Peta (Full di Mobile, Kolom 8 di Desktop) -->
        <div class="col-lg-8 col-md-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Map Editor (Poligon Wilayah)</h6>
                </div>
                <div class="card-body p-0">
                    <div id="map" style="width: 100%; height: 70vh;"></div>
                </div>
            </div>
        </div>

        <!-- Form Input (Tampil di Samping di Desktop, di Bawah di Mobile) -->
        <div class="col-lg-4 col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Wilayah Tambang</h6>
                </div>
                <div class="card-body">
                    <form id="polygonForm" action="<?= base_url('Home/simpanPoligon') ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        
                        <div class="mb-3">
                            <label class="form-label small font-weight-bold">Nama Perusahaan</label>
                            <input type="text" name="companyName" class="form-control form-control-sm" required placeholder="Contoh: PT. Sumber Alam">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small font-weight-bold">Nama Lokasi</label>
                            <input type="text" name="locationName" class="form-control form-control-sm" required placeholder="Dusun/Desa/Kecamatan">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small font-weight-bold">No. Izin IUP/NIB</label>
                            <input type="text" name="permit" class="form-control form-control-sm" required placeholder="000/IUP/2024">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small font-weight-bold">Foto Lokasi</label>
                            <div class="custom-file">
                                <input type="file" name="foto_lokasi" class="custom-file-input" id="fotoFile">
                                <label class="custom-file-label" for="fotoFile" style="font-size: 11px;">Pilih foto...</label>
                            </div>
                        </div>

                        <hr>
                        <p class="small text-muted font-italic mb-2 text-center">Titik koordinat akan terisi otomatis saat Anda menggambar poligon di peta.</p>
                        
                        <div id="coordinateInputs"></div>

                        <button type="submit" class="btn btn-primary btn-sm btn-block shadow-sm mt-3">
                            <i class="fas fa-save mr-1"></i> Simpan Data SIG
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- LEAFLET & DRAW -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>

<script>
    var map = L.map('map').setView([-8.65, 116.3], 9);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    var drawnItems = new L.FeatureGroup();
    map.addLayer(drawnItems);

    var drawControl = new L.Control.Draw({
        edit: { featureGroup: drawnItems },
        draw: { polygon: true, polyline: false, rectangle: false, circle: false, marker: false, circlemarker: false }
    });
    map.addControl(drawControl);

    // --- RENDER DATA LAMA SEBAGAI REFERENSI ---
    <?php 
    $polygons = [];
    if (isset($koordinat)) {
        foreach ($koordinat as $k) {
            $key = str_replace(' ', '_', $k['companyName'] . '_' . $k['permit']);
            if (!isset($polygons[$key])) {
                $polygons[$key] = [
                    'name' => $k['companyName'],
                    'permit' => $k['permit'],
                    'points' => []
                ];
            }
            $polygons[$key]['points'][] = [$k['latitude_deg'], $k['latitude_min'], $k['latitude_sec'], $k['latitude_dir'], $k['longitude_deg'], $k['longitude_min'], $k['longitude_sec'], $k['longitude_dir']];
        }
    }
    ?>

    var colors = ['#e74c3c', '#2ecc71', '#3498db', '#9b59b6', '#f1c40f', '#e67e22', '#1abc9c', '#34495e'];
    var colorIdx = 0;

    <?php foreach ($polygons as $id => $p): ?>
        var refCoords = [];
        <?php foreach ($p['points'] as $pt): ?>
            var rlat = dmsToDecimalPure(<?= $pt[0] ?>, <?= $pt[1] ?>, <?= $pt[2] ?>, '<?= $pt[3] ?>');
            var rlng = dmsToDecimalPure(<?= $pt[4] ?>, <?= $pt[5] ?>, <?= $pt[6] ?>, '<?= $pt[7] ?>');
            refCoords.push([rlat, rlng]);
        <?php endforeach; ?>

        if (refCoords.length > 1) {
            var color = colors[colorIdx % colors.length]; colorIdx++;
            L.polygon(refCoords, {
                color: color, 
                fillColor: color,
                fillOpacity: 0.15, // Buat transparan agar tidak mengganggu gambar baru
                weight: 1,
                dashArray: '4, 4'
            }).addTo(map).bindTooltip("<?= $p['name'] ?>", {sticky: true});
        } else {
             L.circleMarker(refCoords[0], {radius: 4, color: '#333'}).addTo(map);
        }
    <?php endforeach; ?>

    function dmsToDecimalPure(deg, min, sec, dir) {
        var res = parseFloat(deg) + (parseFloat(min) / 60) + (parseFloat(sec) / 3600);
        if (dir === 'S' || dir === 'W') res = res * -1;
        return res;
    }

    map.on(L.Draw.Event.CREATED, function (e) {
        var layer = e.layer;
        drawnItems.clearLayers();
        drawnItems.addLayer(layer);
        
        var latlngs = layer.getLatLngs()[0];
        updateCoordinateInputs(latlngs);
    });

    function updateCoordinateInputs(latlngs) {
        var container = document.getElementById('coordinateInputs');
        container.innerHTML = '';
        latlngs.forEach(function(latlng, index) {
            var dmsLat = decimalToDMS(latlng.lat, 'lat');
            var dmsLng = decimalToDMS(latlng.lng, 'lng');
            
            container.innerHTML += `
                <input type="hidden" name="lat_deg[]" value="${dmsLat.deg}">
                <input type="hidden" name="lat_min[]" value="${dmsLat.min}">
                <input type="hidden" name="lat_sec[]" value="${dmsLat.sec}">
                <input type="hidden" name="lat_dir[]" value="${dmsLat.dir}">
                <input type="hidden" name="long_deg[]" value="${dmsLng.deg}">
                <input type="hidden" name="long_min[]" value="${dmsLng.min}">
                <input type="hidden" name="long_sec[]" value="${dmsLng.sec}">
                <input type="hidden" name="long_dir[]" value="${dmsLng.dir}">
            `;
        });
    }

    function decimalToDMS(decimal, type) {
        var absolute = Math.abs(decimal);
        var degrees = Math.floor(absolute);
        var minutesNotTruncated = (absolute - degrees) * 60;
        var minutes = Math.floor(minutesNotTruncated);
        var seconds = ((minutesNotTruncated - minutes) * 60).toFixed(2);
        var direction = "";
        if (type === 'lat') {
            direction = decimal >= 0 ? "N" : "S";
        } else {
            direction = decimal >= 0 ? "E" : "W";
        }
        return { deg: degrees, min: minutes, sec: seconds, dir: direction };
    }
</script>

<?= $this->endSection() ?>
