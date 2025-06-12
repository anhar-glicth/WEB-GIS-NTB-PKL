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

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<script>
	const map = L.map('map').setView([51.505, -0.09], 13);

	L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
		maxZoom: 19,
		attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
	}).addTo(map);

	L.Control.geocoder({ defaultMarkGeocode: true }).addTo(map);

	L.marker([51.5, -0.09]).addTo(map)
		.bindPopup('<b>Hello world!</b><br />I am a popup.').openPopup();
</script>

<?= $this->endSection() ?>
