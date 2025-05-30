<?php 
require '../includes/functions.php';
require '../view/sidebar.php';

// Ambil data di URL, pastikan id_keluhan ada
if(isset($_GET["id_keluhan"])) {
    $id = $_GET["id_keluhan"];
} else {
    echo "ID keluhan tidak ditemukan!";
    exit;
}

// Query data keluhan berdasarkan id
$kel = query("SELECT * FROM keluhan WHERE id_keluhan = $id")[0];

// Cek apakah tombol submit sudah ditekan atau belum
if( isset($_POST["submit"]) ) {
    // Cek apakah ada perubahan data
    $is_changed = false;
    
    if($_POST["id_user"] != $kel["id_user"] ||
       $_POST["tanggal_keluhan"] != $kel["tanggal_keluhan"] ||
       $_POST["judul_keluhan"] != $kel["judul_keluhan"] ||
       $_POST["deskripsi"] != $kel["deskripsi"] ||
       $_POST["status"] != $kel["status"]) {
        $is_changed = true;
    }
    
    if(!$is_changed) {
        echo "<script>
            alert('Tidak ada perubahan data yang dilakukan!');
            document.location.href = 'daftarkeluhan.php';
        </script>";
        exit;
    }
    
    // Cek apakah data berhasil diubah atau tidak
    if( ubahkeluhan($_POST) > 0 ) {
        echo "
            <script>
                alert('Data berhasil diubah!');
                document.location.href = 'daftarkeluhan.php'
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data gagal diubah! :(');
                document.location.href = 'ubahkeluhan.php'
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
  <title>WebISP | Ubah Data Keluhan</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../public/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../public/css/adminlte.min.css">
  
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  

  <div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Mengubah Data Keluhan</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Keluhan Pelanggan</h3>
                </div>

                <form action="" method="POST">
                    <div class="card-body">
                        <input type="hidden" name="id_keluhan" value="<?= $kel['id_keluhan']; ?>">

                        <div class="form-group">
                            <label for="id_user">ID Customer</label>
                            <input type="text" name="id_user" id="id_user" class="form-control" required value="<?= $kel["id_user"]; ?> " readonly>
                        </div>

                        <div class="form-group">
                            <label for="tanggal_keluhan">Tanggal Keluhan</label>
                            <input type="text" name="tanggal_keluhan" id="tanggal_keluhan" class="form-control" required value="<?= $kel["tanggal_keluhan"]; ?>">
                        </div>

                        <div class="form-group">
                            <label for="judul_keluhan">Judul Keluhan</label>
                            <input type="text" name="judul_keluhan" id="judul_keluhan" class="form-control" required value="<?= $kel["judul_keluhan"]; ?>" >
                        </div>

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control" required><?= $kel["deskripsi"]; ?></textarea >
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="level" class="form-control custom-select" required>
                                        <option value="Pending" <?= ($kel["status"] == "Pending") ? 'selected' : ''; ?>>Pending</option>
                                        <option value="Proses" <?= ($kel["status"] == "Proses") ? 'selected' : ''; ?>>Proses</option>
                                        <option value="Selesai" <?= ($kel["status"] == "Selesai") ? 'selected' : ''; ?>>Selesai</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <a href="daftarkeluhan.php" class="btn btn-secondary float-left">Cancel</a>
                        <button type="submit" name="submit" class="btn btn-success float-right">Ubah Data</button>
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
