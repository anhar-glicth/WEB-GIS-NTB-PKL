<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SIG-TAMBANG NTB | Perizinan Pertambangan</title>

    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    
    <!-- SB Admin 2 CSS -->
    <link href="<?= base_url('css/sb-admin-2.min.css') ?>" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fc;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow: hidden;
        }
        .bg-auth-gradient {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            z-index: -1;
        }
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            overflow: hidden;
            width: 100%;
            max-width: 450px;
        }
        .card-header {
            background: white;
            border-bottom: none;
            padding: 40px 30px 10px;
            text-align: center;
        }
        .card-header h3 {
            font-weight: 700;
            color: #4e73df;
            font-size: 1.6rem;
            margin-bottom: 5px;
        }
        .card-header p {
            font-size: 0.85rem;
            color: #858796;
        }
        .card-body {
            padding: 20px 40px 40px;
        }
        .btn-primary {
            background-color: #4e73df;
            border: none;
            padding: 14px;
            font-weight: 600;
            border-radius: 12px;
            transition: all 0.3s;
            box-shadow: 0 4px 10px rgba(78, 115, 223, 0.3);
        }
        .btn-primary:hover {
            background-color: #2e59d9;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(78, 115, 223, 0.4);
        }
        .form-control {
            border-radius: 12px;
            padding: 25px 20px;
            border: 1px solid #e3e6f0;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.1);
        }
        label {
            font-weight: 600;
            color: #4e73df;
            font-size: 0.8rem;
            margin-bottom: 8px;
            margin-left: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .auth-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.85rem;
            color: #858796;
        }
        .auth-footer a {
            color: #4e73df;
            font-weight: 700;
            text-decoration: none;
        }
        .auth-footer a:hover {
            text-decoration: underline;
        }
        /* Custom UI flair */
        .shape {
            position: fixed;
            z-index: -1;
            filter: blur(80px);
            opacity: 0.5;
            border-radius: 50%;
        }
        .shape-1 { width: 500px; height: 500px; background: #4e73df; top: -150px; left: -150px; }
        .shape-2 { width: 400px; height: 400px; background: #00d2ff; bottom: -100px; right: -100px; }
    </style>
</head>

<body>
    <div class="bg-auth-gradient"></div>
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>

    <?=$this->renderSection('content')?>

    <!-- Scripts -->
    <script src="<?= base_url('vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('vendor/jquery-easing/jquery.easing.min.js') ?>"></script>
</body>

</html>