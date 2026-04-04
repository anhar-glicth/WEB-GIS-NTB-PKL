<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $site_name ?> | GIS Pertambangan NTB</title>
    
    <!-- Bootstrap 4 / Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Poppins', sans-serif; margin: 0; padding: 0; overflow-x: hidden; }
        
        /* Hero Section Dinamis */
        .hero {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            position: relative;
        }
        
        .hero-bg {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1;
            background-image: url('<?= $hero_image ?>');
            background-size: cover;
            background-position: center;
            filter: brightness(0.4);
        }

        .hero-content { position: relative; z-index: 2; padding: 20px; }
        .hero h1 { font-size: 3.5rem; font-weight: 700; margin-bottom: 20px; text-shadow: 2px 2px 10px rgba(0,0,0,0.5); }
        .hero p { font-size: 1.2rem; margin-bottom: 40px; opacity: 0.9; }

        .btn-main {
            padding: 15px 40px; 
            font-size: 1.1rem; 
            border-radius: 50px; 
            border: none; 
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-decoration: none;
            display: inline-block;
        }
        .btn-register { background: #4e73df; color: white; box-shadow: 0 4px 15px rgba(78, 115, 223, 0.4); border: none !important; }
        .btn-register:hover { background: #2e59d9; transform: translateY(-3px); color: white; text-decoration: none; }
        
        .navbar {
            position: absolute; top: 0; left: 0; width: 100%; z-index: 10;
            padding: 20px 50px; display: flex; justify-content: space-between; align-items: center;
            box-sizing: border-box;
            background: transparent;
        }
        .nav-links a { color: white !important; text-decoration: none; margin-left: 30px; font-weight: 500; font-size: 0.95rem; }
        
        /* Stats Section */
        .stats { padding: 80px 50px; background: #f8f9fc; display: flex; justify-content: space-around; flex-wrap: wrap; text-align: center; }
        .stat-item { flex: 1; min-width: 250px; padding: 20px; transition: transform 0.3s; }
        .stat-item:hover { transform: scale(1.05); }
        .stat-item i { font-size: 3rem; color: #4e73df; margin-bottom: 15px; }
        .stat-item h3 { font-size: 2.5rem; margin: 10px 0; color: #3a3b45; }
        .stat-item p { color: #858796; font-weight: 500; text-transform: uppercase; font-size: 0.8rem; }

        /* Modal Styles */
        .modal-content { border-radius: 20px; border: none; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.2); }
        .modal-header { border: none; padding: 30px 40px 10px; text-align: center; display: block; }
        .modal-title { font-weight: 700; color: #4e73df; font-size: 1.5rem; }
        .modal-body { padding: 10px 40px 40px; }
        .form-control { border-radius: 12px; padding: 24px 15px; border: 1px solid #e3e6f0; font-size: 0.9rem; }
        .form-control:focus { box-shadow: 0 0 0 0.2rem rgba(78,115,223,0.1); border-color: #4e73df; }
        .modal .btn-primary { border-radius: 12px; padding: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; }
        
        /* Mobile Adjustments */
        @media (max-width: 768px) {
            .hero h1 { font-size: 2.2rem; }
            .navbar { padding: 20px; }
            .nav-links { display: none; }
        }
    </style>
</head>
<body>

    <!-- Simple Navbar -->
    <nav class="navbar">
        <div class="logo">
            <h3 style="color: white; margin: 0; letter-spacing: 2px;"><i class="fas fa-mountain mr-2"></i><?= $site_name ?></h3>
        </div>
        <div class="nav-links">
            <a href="#explore-map" style="scroll-behavior: smooth;">View Maps</a>
            <a href="javascript:void(0)" data-toggle="modal" data-target="#loginModal">Daftar Marker</a>
            <a href="javascript:void(0)" data-toggle="modal" data-target="#loginModal" style="border: 1px solid white; padding: 8px 20px; border-radius: 5px;">Login Sistem</a>
        </div>
    </nav>

    <!-- Hero Section Dinamis -->
    <div class="hero">
        <div class="hero-bg"></div>
        <div class="hero-content">
            <h1>Sistem Informasi Geografis <br> Wilayah Pertambangan NTB</h1>
            <p>Integrasi Data Spasial Dan Laporan Teknis Tambang Secara Real-Time.</p>
            <a href="javascript:void(0)" data-toggle="modal" data-target="#registerModal" class="btn-main btn-register">
                Mulai Daftar Perusahaan <i class="fas fa-arrow-right ml-2"></i>
            </a>
            
            <div style="margin-top: 50px;">
                <a href="#explore" style="color: rgba(255,255,255,0.7); text-decoration: none; font-size: 0.9rem;">
                    Scroll Untuk Melihat Statistik <br>
                    <i class="fas fa-chevron-down mt-2 animate-bounce"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Section Dinamis -->
    <div class="stats" id="explore">
        <div class="stat-item">
            <i class="fas fa-layer-group"></i>
            <h3><?= $totalLaporan ?></h3>
            <p>Laporan Terkirim</p>
        </div>
        <div class="stat-item">
            <i class="fas fa-industry"></i>
            <h3><?= $totalPerusahaan ?></h3>
            <p>Perusahaan Terdaftar</p>
        </div>
        <div class="stat-item">
            <i class="fas fa-map-marker-alt"></i>
            <h3><?= $totalTitik ?></h3>
            <p>Titik Koordinat GIS</p>
        </div>
    </div>

    <!-- FITUR UTAMA SECTION -->
    <div style="padding: 100px 50px; background: white; text-align: center;">
        <h6 style="color: #4e73df; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 15px;">Pelayanan Kami</h6>
        <h2 style="font-weight: 700; color: #3a3b45; margin-bottom: 60px;">Fitur Unggulan Sistem GIS</h2>
        
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-5">
                    <div style="padding: 40px 30px; border-radius: 25px; background: #f8f9fc; transition: all 0.3s;" class="h-100 hover-card">
                        <div style="width: 70px; height: 70px; background: rgba(78, 115, 223, 0.1); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px;">
                            <i class="fas fa-map-marked-alt" style="font-size: 2rem; color: #4e73df;"></i>
                        </div>
                        <h4 style="font-weight: 700; color: #3a3b45; margin-bottom: 15px;">Visualisasi Spasial</h4>
                        <p style="color: #858796; font-size: 0.95rem; line-height: 1.6;">Pemetaan wilayah pertambangan secara akurat menggunakan teknologi Leaflet.js untuk akurasi data yang tinggi.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-5">
                    <div style="padding: 40px 30px; border-radius: 25px; background: #f8f9fc; transition: all 0.3s;" class="h-100 hover-card">
                        <div style="width: 70px; height: 70px; background: rgba(28, 200, 138, 0.1); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px;">
                            <i class="fas fa-file-contract" style="font-size: 2rem; color: #1cc88a;"></i>
                        </div>
                        <h4 style="font-weight: 700; color: #3a3b45; margin-bottom: 15px;">Pelaporan Digital</h4>
                        <p style="color: #858796; font-size: 0.95rem; line-height: 1.6;">Sistem pelaporan teknis yang terintegrasi, memudahkan perusahaan tambang dalam administrasi perizinan.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-5">
                    <div style="padding: 40px 30px; border-radius: 25px; background: #f8f9fc; transition: all 0.3s;" class="h-100 hover-card">
                        <div style="width: 70px; height: 70px; background: rgba(246, 194, 62, 0.1); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px;">
                            <i class="fas fa-shield-alt" style="font-size: 2rem; color: #f6c23e;"></i>
                        </div>
                        <h4 style="font-weight: 700; color: #3a3b45; margin-bottom: 15px;">Monitoring & Verifikasi</h4>
                        <p style="color: #858796; font-size: 0.95rem; line-height: 1.6;">Validasi data oleh petugas lapangan untuk memastikan kepatuhan terhadap regulasi pertambangan di NTB.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- EXPLORASI WILAYAH (GIS SECTION) -->
    <div id="explore-map" style="padding: 100px 0; background: #f8f9fc;">
        <div class="container text-center mb-5">
            <h6 style="color: #4e73df; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 15px;">Eksplorasi Data Spasial</h6>
            <h2 style="font-weight: 700; color: #3a3b45;">Peta Wilayah Pertambangan Terverifikasi</h2>
            <p class="text-muted">Visualisasi area tambang yang telah melalui proses validasi oleh Dinas ESDM NTB.</p>
        </div>
        
        <div class="container-fluid px-md-5">
            <div id="map" style="height: 600px; width: 100%; border-radius: 30px; border: 8px solid white; box-shadow: 0 15px 45px rgba(0,0,0,0.1); z-index: 1;"></div>
        </div>
    </div>


    <!-- INTEGRATION SECTION -->
    <div style="padding: 80px 0; background: linear-gradient(rgba(78, 115, 223, 0.03), rgba(78, 115, 223, 0.03));">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h2 style="font-weight: 700; color: #3a3b45; margin-bottom: 25px;">Siap Berintegrasi Secara Digital?</h2>
                    <p style="color: #858796; font-size: 1.1rem; margin-bottom: 40px;">Daftarkan perusahaan Anda sekarang untuk mulai mengelola data koordinat dan laporan operasional dalam satu platform terpusat.</p>
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#registerModal" class="btn btn-primary" style="padding: 15px 45px; border-radius: 50px; font-weight: 600; font-size: 1rem; text-transform: uppercase;">Mulai Registrasi <i class="fas fa-rocket ml-2"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer style="background: white; padding: 40px; text-align: center; border-top: 1px solid #e3e6f0;">
        <p class="small mb-0 text-muted">&copy; <?= date('Y') ?> <b><?= $site_name ?></b> - Dinas Energi dan Sumber Daya Mineral Prov. NTB.</p>
    </footer>

    <!-- LOGIN MODAL -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Login Sistem</h5>
                    <p class="mb-0">Masuk ke Dashboard GIS</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; top: 20px; right: 20px;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php if (session()->has('error') || session()->has('errors')) : ?>
                        <div class="alert alert-danger small rounded-lg mb-3">
                            <?= session('error') ?: 'Silakan periksa kembali inputan Anda.' ?>
                        </div>
                    <?php endif ?>
                    
                    <form action="<?= url_to('login') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label class="small font-weight-bold text-primary">Email atau Username</label>
                            <input type="text" class="form-control" name="login" placeholder="Masukkan ID Anda" required>
                        </div>
                        <div class="form-group mb-4">
                            <label class="small font-weight-bold text-primary">Kata Sandi</label>
                            <input type="password" name="password" class="form-control" placeholder="********" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block shadow">Masuk Sekarang</button>
                    </form>
                    <div class="text-center mt-4 small">
                        <p class="text-muted mb-1">Belum punya akun? <a href="javascript:void(0)" onclick="$('#loginModal').modal('hide'); $('#registerModal').modal('show');" class="font-weight-bold">Daftar Perusahaan</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- REGISTER MODAL -->
    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registrasi Perusahaan</h5>
                    <p class="mb-0">Daftarkan perusahaan Anda ke sistem GIS</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; top: 20px; right: 20px;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php if (session()->has('errors')) : ?>
                        <div class="alert alert-danger small rounded-lg mb-3">
                            <ul class="mb-0 pl-3">
                            <?php foreach (session('errors') as $error) : ?>
                                <li><?= $error ?></li>
                            <?php endforeach ?>
                            </ul>
                        </div>
                    <?php endif ?>

                    <form action="<?= url_to('register') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="small font-weight-bold text-primary">Email Resmi</label>
                                <input type="email" class="form-control" name="email" placeholder="contoh@mail.com" value="<?= old('email') ?>" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="small font-weight-bold text-primary">Username</label>
                                <input type="text" class="form-control" name="username" placeholder="Username" value="<?= old('username') ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="small font-weight-bold text-primary">Kata Sandi</label>
                                <input type="password" name="password" class="form-control" placeholder="********" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="small font-weight-bold text-primary">Konfirmasi Sandi</label>
                                <input type="password" name="pass_confirm" class="form-control" placeholder="********" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block shadow mt-3">Daftar Akun Baru</button>
                    </form>
                    <div class="text-center mt-4 small">
                        <p class="text-muted">Sudah terdaftar? <a href="javascript:void(0)" onclick="$('#registerModal').modal('hide'); $('#loginModal').modal('show');" class="font-weight-bold">Login Disini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // LEAFLET GIS EXECUTION
        $(document).ready(function() {
            // 1. Definisikan Base Layers
            var whiteMode = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; CartoDB Positron',
                subdomains: 'abcd',
                maxZoom: 20
            });

            var satelliteMode = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                attribution: '&copy; Google Maps Satellite'
            });

            var osmMode = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            });

            // 2. Inisialisasi Peta (Default Menggunakan White Mode agar poligon terlihat jelas)
            var map = L.map('map', {
                scrollWheelZoom: false,
                layers: [whiteMode] // Mulai dengan White Mode sesuai permintaan
            }).setView([-8.65, 117.33], 8.5);

            // 3. Tambahkan Tombol Pilihan Layer (Control)
            var baseMaps = {
                "Mode Putih (Jelas)": whiteMode,
                "Mode Satelit": satelliteMode,
                "Mode Jalanan (OSM)": osmMode
            };
            L.control.layers(baseMaps).addTo(map);

            <?php
            $polygons = [];
            if (!empty($koordinat)) {
                foreach ($koordinat as $k) {
                    $permit = $k['permit'];
                    if (!isset($polygons[$permit])) {
                        $polygons[$permit] = [
                            'company' => $k['companyName'] ?? 'Perusahaan',
                            'location' => $k['locationName'] ?? 'Wilayah',
                            'coords' => []
                        ];
                    }
                    $polygons[$permit]['coords'][] = [(float)$k['latitude_decimal'], (float)$k['longitude_decimal']];
                }
            }
            ?>

            // KOLEKSI WARNA KONTRAS (PALETTE)
            var niceColors = ['#e74c3c', '#3498db', '#f1c40f', '#9b59b6', '#1abc9c', '#e67e22', '#2ecc71', '#34495e'];
            var colorIndex = 0;

            <?php foreach ($polygons as $permit => $data) : ?>
                var currentPoligonColor = niceColors[colorIndex % niceColors.length];
                
                var polygon = L.polygon(<?= json_encode($data['coords']) ?>, {
                    color: currentPoligonColor, 
                    fillColor: currentPoligonColor,
                    fillOpacity: 0.5,
                    weight: 2
                }).addTo(map);
                
                polygon.bindPopup("<b><?= esc($data['company']) ?></b><br>Izin: <?= esc($permit) ?>");
                
                colorIndex++; // Geser ke warna berikutnya untuk poligon selanjutnya
            <?php endforeach; ?>
        });

        // SMOOTH SCROLL
        $('a[href^="#"]').on('click', function(event) {
            var target = $(this.getAttribute('href'));
            if( target.length ) {
                event.preventDefault();
                $('html, body').stop().animate({
                    scrollTop: target.offset().top
                }, 1000);
            }
        });

        // AUTH MODAL AUTOMATION
        $(document).ready(function() {
            <?php if (session()->has('error') || (session()->has('errors') && !old('email'))) : ?>
                $('#loginModal').modal('show');
            <?php elseif (session()->has('errors') && old('email')) : ?>
                $('#registerModal').modal('show');
            <?php endif; ?>
        });
    </script>

    <!-- Leaflet Resources -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

</body>
</html>