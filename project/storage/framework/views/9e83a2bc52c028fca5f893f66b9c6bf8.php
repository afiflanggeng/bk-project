<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KlinikApp</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #b3e5fc;
        }

        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 200px;
            height: 240px;
            /* Tinggi seragam untuk semua kotak */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .card img {
            width: 100px;
            /* Ukuran gambar seragam */
            height: 100px;
            object-fit: cover;
            /* Pastikan gambar tetap proporsional */
        }

        .header {
            background-color: #0288d1;
        }

        .header .btn-login {
            background-color: #d32f2f;
            border: none;
        }

        .btn-primary {
            background-color: #a40000;
            border: none;
            width: 100px;
            /* Tambahkan lebar seragam untuk tombol */
        }

        .btn-primary:hover {
            background-color: #0277bd;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <nav class="navbar header navbar-dark">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">KlinikApp</span>
            <a href="<?php echo e(route('showLoginPage')); ?>" class="btn btn-login text-white">Login</a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container d-flex justify-content-center align-items-center" style="height: calc(100vh - 56px);">
        <div class="row g-3 justify-content-center">
            <!-- Pasien Lama -->
            <div class="col-6 col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <img src="https://cdn.pixabay.com/photo/2018/11/13/21/43/avatar-3814049_640.png"
                            alt="Pasien Lama" class="rounded-circle mb-3">
                        <h5 class="card-title">Pasien Lama</h5>
                        <button class="btn btn-primary">Login</button>
                    </div>
                </div>
            </div>
            <!-- Pasien Baru -->
            <div class="col-6 col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <img src="https://cdn.pixabay.com/photo/2018/11/13/21/43/avatar-3814049_640.png"
                            alt="Pasien Baru" class="rounded-circle mb-3">
                        <h5 class="card-title">Pasien Baru</h5>
                        <button class="btn btn-primary">Daftar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php /**PATH C:\Users\Hanvy\Documents\klinikApp\project\resources\views/welcome.blade.php ENDPATH**/ ?>