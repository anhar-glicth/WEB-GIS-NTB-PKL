<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $judul ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        /* Navbar */
        .navbar {
            background-color: #fff;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            padding: 15px 0;
        }
        .nav-link {
            font-weight: 500;
            color: #333;
        }
        .nav-link:hover {
            color: #0d6efd;
        }
        .btn-login-nav {
            border-radius: 20px;
            padding: 8px 25px;
            font-weight: 600;
        }

        /* Hero Section */
        .hero-section {
            padding: 100px 0;
            background: linear-gradient(135deg, #e0f2ff 0%, #ffffff 100%);
            border-bottom-left-radius: 50px;
            border-bottom-right-radius: 50px;
            position: relative;
            overflow: hidden;
        }
        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            color: #0a2540;
            line-height: 1.2;
        }
        .hero-title span {
            color: #0d6efd;
        }
        .hero-text {
            color: #6c757d;
            font-size: 1.1rem;
            margin: 20px 0;
        }
        .hero-img {
            max-width: 100%;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(13, 110, 253, 0.2);
        }
        /* Kelas Baru untuk Gambar Persegi */
        .square-img {
            width: 100%;
            height: auto;
            max-width: 400px; /* Atur ukuran maksimal sesuai kebutuhan */
            aspect-ratio: 1 / 1;
            object-fit: cover;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(13, 110, 253, 0.2);
        }
        .btn-primary-custom {
            background-color: #0d6efd;
            border: none;
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-primary-custom:hover {
            background-color: #0b5ed7;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(13, 110, 253, 0.3);
        }

        /* Stats Section */
        .stats-container {
            background: #0a2540;
            color: white;
            border-radius: 20px;
            padding: 40px;
            margin-top: -50px;
            position: relative;
            z-index: 10;
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        .stat-item h3 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #4dabf7;
        }

        /* Services Section */
        .service-card {
            background: #fff;
            border-radius: 15px;
            padding: 30px;
            transition: all 0.3s;
            border: 1px solid #eef2f6;
            height: 100%;
        }
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(13, 110, 253, 0.1);
            border-color: #0d6efd;
        }
        .icon-box {
            width: 60px;
            height: 60px;
            background: #e7f1ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0d6efd;
            font-size: 24px;
            margin-bottom: 20px;
        }

        /* Modal Login Custom */
        .modal-content {
            border-radius: 20px;
            border: none;
        }
        .modal-header {
            border-bottom: none;
            padding-bottom: 0;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="fas fa-globe text-primary"></i> WEB GIS <span class="text-primary">NTB</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link mx-2" href="#">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link mx-2" href="#services">Layanan</a></li>
                    <li class="nav-item ms-3">
                        <?php if (logged_in()) : ?>
                            <a href="<?= base_url('logout') ?>" class="btn btn-outline-danger btn-login-nav">Logout</a>
                        <?php else : ?>
                            <button type="button" class="btn btn-primary btn-login-nav shadow-sm" data-bs-toggle="modal" data-bs-target="#loginModal">
                                Login <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="badge bg-primary bg-opacity-10 text-primary mb-3 px-3 py-2 rounded-pill">
                        <i class="fas fa-star me-1"></i> Sistem Informasi Geografis Terpadu
                    </div>
                    <h1 class="hero-title mb-3">
                        Kelola Data Tambang <br>
                        <span>Lebih Efisien & Akurat</span>
                    </h1>
                    <p class="hero-text">
                        Platform digital untuk pemetaan, pelaporan, dan monitoring aktivitas pertambangan di Nusa Tenggara Barat.
                    </p>
                    <div class="mt-4">
                        <button class="btn btn-primary-custom text-white me-3 shadow" data-bs-toggle="modal" data-bs-target="#loginModal">
                            Mulai Sekarang
                        </button>
                    </div>
                </div>
                <div class="col-lg-6 mt-5 mt-lg-0 text-center">
                    <!-- Menggunakan class baru 'square-img' dan menghapus 'hero-img' -->
                    <img src="<?= base_url('img/image.png') ?>" alt="Dashboard Preview" class="square-img">
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section (DINAMIS) -->
    <section class="container">
        <div class="stats-container">
            <div class="row text-center">
                <div class="col-md-3 col-6 mb-4 mb-md-0 stat-item border-end border-secondary">
                    <!-- Mengambil data dari stats['total_perusahaan'] -->
                    <h3><?= $stats['total_perusahaan'] ?? 0; ?>+</h3>
                    <p class="mb-0 text-white-50">Perusahaan</p>
                </div>
                <div class="col-md-3 col-6 mb-4 mb-md-0 stat-item border-end border-secondary">
                    <!-- Mengambil data dari stats['total_laporan'] -->
                    <h3><?= $stats['total_laporan'] ?? 0; ?>+</h3>
                    <p class="mb-0 text-white-50">Laporan Masuk</p>
                </div>
                <div class="col-md-3 col-6 stat-item border-end border-secondary">
                    <!-- Mengambil data dari stats['total_poligon'] (Koordinat) -->
                    <h3><?= $stats['total_poligon'] ?? 0; ?>+</h3>
                    <p class="mb-0 text-white-50">Titik Poligon</p>
                </div>
                <div class="col-md-3 col-6 stat-item">
                    <!-- Tetap Statis (Opsional) -->
                    <h3>24/7</h3>
                    <p class="mb-0 text-white-50">Monitoring</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-5 mt-5">
        <div class="container">
            <div class="text-center mb-5">
                <h6 class="text-primary fw-bold text-uppercase">Layanan Kami</h6>
                <h2 class="fw-bold">Solusi Digital Pertambangan</h2>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="service-card">
                        <div class="icon-box"><i class="fas fa-map-marked-alt"></i></div>
                        <h5>Pemetaan Poligon</h5>
                        <p class="text-muted small">Input dan visualisasi area tambang dengan koordinat presisi tinggi.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="service-card">
                        <div class="icon-box"><i class="fas fa-file-contract"></i></div>
                        <h5>E-Reporting</h5>
                        <p class="text-muted small">Pelaporan berkala (RKAB) secara digital yang terintegrasi.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="service-card">
                        <div class="icon-box"><i class="fas fa-chart-pie"></i></div>
                        <h5>Analisa Data</h5>
                        <p class="text-muted small">Dashboard eksekutif untuk memantau produksi dan cadangan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white py-4 border-top mt-5">
        <div class="container text-center">
            <p class="mb-0 text-muted small">&copy; <?= date('Y') ?> WEB GIS NTB. All rights reserved.</p>
        </div>
    </footer>

    <!-- MODAL LOGIN POP-UP -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content overflow-hidden">
                <div class="row g-0">
                    <div class="col-md-5 d-none d-md-block bg-primary text-white p-4 d-flex flex-column justify-content-center align-items-center text-center">
                        <i class="fas fa-globe fa-4x mb-3"></i>
                        <h4 class="fw-bold">WEB GIS NTB</h4>
                        <p class="small">Silakan login untuk mengakses dashboard.</p>
                    </div>
                    <div class="col-md-7 p-4">
                        <div class="modal-header p-0 border-0 mb-3">
                            <h5 class="modal-title fw-bold text-dark" id="loginModalLabel">Login Akun</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        
                        <?= view('App\Views\Auth\_message_block') ?>

                        <form action="<?= url_to('login') ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label for="login" class="form-label small text-muted">Email atau Username</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-primary"></i></span>
                                    <input type="text" class="form-control border-start-0 bg-light <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>"
                                           name="login" placeholder="Masukan email/username">
                                    <div class="invalid-feedback"><?= session('errors.login') ?></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label small text-muted">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-primary"></i></span>
                                    <input type="password" name="password" class="form-control border-start-0 bg-light <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="Masukan password">
                                    <div class="invalid-feedback"><?= session('errors.password') ?></div>
                                </div>
                            </div>
                            <?php if ($config->allowRemembering): ?>
                            <div class="form-check mb-3">
                                <input type="checkbox" name="remember" class="form-check-input" <?php if (old('remember')) : ?> checked <?php endif ?>>
                                <label class="form-check-label small text-muted">Ingat Saya</label>
                            </div>
                            <?php endif; ?>
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">Masuk</button>
                        </form>

                        <div class="mt-4 text-center small">
                            <p class="text-muted mb-1">Belum punya akun?</p>
                            <?php if ($config->allowRegistration) : ?>
                                <a href="<?= url_to('register') ?>" class="text-primary fw-bold text-decoration-none">Daftar Sekarang</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php if (session('errors') || session('error')) : ?>
    <script>
        var myModal = new bootstrap.Modal(document.getElementById('loginModal'), {});
        myModal.show();
    </script>
    <?php endif; ?>
</body>
</html>