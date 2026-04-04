<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $site_name ?> | GIS Pertambangan NTB</title>
    <!-- Bootstrap 4 / SB Admin 2 Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
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
        .btn-register { background: #4e73df; color: white; box-shadow: 0 4px 15px rgba(78, 115, 223, 0.4); }
        .btn-register:hover { background: #2e59d9; transform: translateY(-3px); }
        
        .navbar {
            position: absolute; top: 0; left: 0; width: 100%; z-index: 10;
            padding: 20px 50px; display: flex; justify-content: space-between; align-items: center;
            box-sizing: border-box;
        }
        .nav-links a { color: white; text-decoration: none; margin-left: 30px; font-weight: 500; font-size: 0.95rem; }
        
        /* Stats Section */
        .stats { padding: 80px 50px; background: #f8f9fc; display: flex; justify-content: space-around; flex-wrap: wrap; text-align: center; }
        .stat-item { flex: 1; min-width: 250px; padding: 20px; transition: transform 0.3s; }
        .stat-item:hover { transform: scale(1.05); }
        .stat-item i { font-size: 3rem; color: #4e73df; margin-bottom: 15px; }
        .stat-item h3 { font-size: 2.5rem; margin: 10px 0; color: #3a3b45; }
        .stat-item p { color: #858796; font-weight: 500; text-transform: uppercase; font-size: 0.8rem; }

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
            <a href="<?= base_url('Home/viewMaps') ?>">View Maps</a>
            <a href="<?= base_url('Home/marker') ?>">Daftar Marker</a>
            <a href="<?= base_url('login') ?>" style="border: 1px solid white; padding: 8px 20px; border-radius: 5px;">Login Sistem</a>
        </div>
    </nav>

    <!-- Hero Section Dinamis -->
    <div class="hero">
        <div class="hero-bg"></div>
        <div class="hero-content">
            <h1>Sistem Informasi Geografis <br> Wilayah Pertambangan NTB</h1>
            <p>Integrasi Data Spasial Dan Laporan Teknis Tambang Secara Real-Time.</p>
            <a href="<?= base_url('register') ?>" class="btn-main btn-register">
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
    <div class="stats" id="explore text-center">
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

    <!-- Footer -->
    <footer style="background: white; padding: 40px; text-align: center; border-top: 1px solid #e3e6f0;">
        <p class="small mb-0 text-muted">&copy; <?= date('Y') ?> <b><?= $site_name ?></b> - Dinas Energi dan Sumber Daya Mineral Prov. NTB.</p>
    </footer>

</body>
</html>