<?php 
include '../includes/init_session.php';  // Pastikan session dimulai di sini
include '../includes/functions.php';
include '../view/sidebar.php';

// Proses form submission
if (isset($_POST["submit"])) {
    if (tambahkeluhan($_POST) > 0) {
        echo "
            <script>
                alert('Data berhasil ditambahkan!');
                document.location.href = 'pformkeluhan.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data gagal ditambahkan! :(');
                document.location.href = 'pformkeluhan.php';
            </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WebISP | Form Keluhan</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../public/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../public/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Mengisi Form Keluhan</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Form Keluhan</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Form</h3>
                            </div>
                            <form action="" method="POST">
                                <div class="card-body">
                                    <!-- Input tersembunyi untuk id_customer, diisi otomatis -->
                                    <input type="hidden" name="id_customer" value="<?php echo $id_customer; ?>">
                                    <input type="hidden" name="id_kepalateknisi" value="1">
                                    <input type="hidden" name="status" value="dari_pengguna_<?php echo $id_customer; ?>">

                                    <div class="form-group">
                                        <label for="tanggal_keluhan">Tanggal Keluhan</label>
                                        <input type="date" name="tanggal_keluhan" id="tanggal_keluhan" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="judul_keluhan">Judul Keluhan</label>
                                        <input type="text" name="judul_keluhan" id="judul_keluhan" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="deskripsi">Deskripsi</label>
                                        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4" required></textarea>
                                    </div>

                                    <a href="../pelanggan/dashboard.php" class="btn btn-secondary float-left">Cancel</a>
                                    <button type="submit" name="submit" class="btn btn-success float-right">Kirim!</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/adminlte.min.js"></script>
</body>
</html>
