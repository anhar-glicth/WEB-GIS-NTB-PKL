<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Peta Sebaran Pertambangan NTB</h6>
        </div>
        <div class="card-body">
            <div id="map" style="width: 100%; height: 600px; border-radius: 10px; border: 1px solid #ccc;"></div>
        </div>
    </div>
</div>

<script>
    // Inisialisasi peta berpusat di NTB
    const map = L.map('map').setView([-8.65, 116.3], 9);

    const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    // Ambil data koordinat dari PHP
    const dataKoordinat = <?= json_encode($koordinat) ?>;
    
    // Objek untuk menampung poligon berdasarkan izin (permit)
    const poligonGroup = {};

    dataKoordinat.forEach(function(item) {
        // Konversi DMS ke Decimal jika perlu (asumsi database menyimpan nilai decimal)
        // Jika DB menyimpan derajat, menit, detik: kita hitung dulu
        const lat = parseFloat(item.latitude_deg) + (parseFloat(item.latitude_min)/60) + (parseFloat(item.latitude_sec)/3600);
        const lng = parseFloat(item.longitude_deg) + (parseFloat(item.longitude_min)/60) + (parseFloat(item.longitude_sec)/3600);
        
        // Sesuaikan arah (S/W menjadi negatif)
        const finalLat = (item.latitude_dir === 'S') ? lat * -1 : lat;
        const finalLng = (item.longitude_dir === 'W') ? lng * -1 : lng;

        // Tambah Marker
        const marker = L.marker([finalLat, finalLng]).addTo(map);
        marker.bindPopup(`
            <b>${item.companyName}</b><br>
            Lokasi: ${item.locationName}<br>
            Izin: ${item.permit}<br>
            <hr>
            <small>Lat: ${finalLat.toFixed(6)}, Lng: ${finalLng.toFixed(6)}</small>
        `);

        // Simpan titik ke grup poligon berdasarkan ID izin
        if (!poligonGroup[item.permit]) {
            poligonGroup[item.permit] = [];
        }
        poligonGroup[item.permit].push([finalLat, finalLng]);
    });

    // Gambar Poligon/Garis untuk setiap grup izin
    Object.keys(poligonGroup).forEach(function(key) {
        if (poligonGroup[key].length > 2) {
            L.polygon(poligonGroup[key], {color: 'blue', fillOpacity: 0.2}).addTo(map);
        } else if (poligonGroup[key].length > 1) {
            L.polyline(poligonGroup[key], {color: 'red'}).addTo(map);
        }
    });

    // Sesuaikan view jika ada data
    if (dataKoordinat.length > 0) {
        // map.fitBounds(L.featureGroup(Object.values(poligonGroup).flat()).getBounds());
    }
</script>

<?= $this->endSection() ?>
