<?php 
require '../includes/functions.php';
require '../view/sidebar.php';

// Modifikasi query untuk mengambil nama produk dan menghitung statistik
$plggn = query("SELECT c.*, p.nama_produk 
             FROM customer c 
             LEFT JOIN produk p ON c.id_produk = p.id_produk"); 

// Hitung statistik pelanggan
$total_pelanggan = count($plggn);
$active_pelanggan = 0;
$inactive_pelanggan = 0;

foreach($plggn as $row) {
    if(strtolower($row["status"]) === 'active') {
        $active_pelanggan++;
    } else {
        $inactive_pelanggan++;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>WebISP | Kelola Data Pelanggan</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../public/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- Sweetalert2 -->
  <link rel="stylesheet" href="../public/plugins/sweetalert2/sweetalert2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../public/css/adminlte.min.css">
  
  <style>
    .card {
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      transition: transform 0.3s;
    }
    
    .card:hover {
      transform: translateY(-5px);
    }
    
    .card-header {
      background: linear-gradient(45deg, #3c8dbc, #00c0ef);
      color: white;
      border-radius: 15px 15px 0 0 !important;
    }
    
    .badge-status-active {
      background-color: #28a745;
      color: white;
      padding: 5px 10px;
      border-radius: 10px;
      font-weight: normal;
    }
    
    .badge-status-inactive {
      background-color: #dc3545;
      color: white;
      padding: 5px 10px;
      border-radius: 10px;
      font-weight: normal;
    }
    
    .btn-action {
      border-radius: 20px;
      margin: 2px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      transition: all 0.3s;
    }
    
    .btn-action:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    
    .table-hover tbody tr:hover {
      background-color: rgba(0,123,255,0.1);
    }
    
    .add-button {
      border-radius: 30px;
      box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
      font-weight: 600;
      padding: 10px 20px;
      transition: all 0.15s ease;
    }
    
    .add-button:hover {
      transform: translateY(-2px);
      box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
    }
    
    .add-button i {
      margin-right: 5px;
    }

    .customer-info {
      font-size: 0.9rem;
    }

    .customer-info i {
      width: 20px;
      color: #3c8dbc;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      
    </ul>
  </nav>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><i class="fas fa-users mr-2"></i>Data Pelanggan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i> Home</a></li>
              <li class="breadcrumb-item active">Daftar Pelanggan</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Customer Stats Cards -->
        <div class="row mb-4">
          <div class="col-md-4">
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?= $total_pelanggan ?></h3>
                <p>Total Pelanggan</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
            </div>
          </div>
          
          <div class="col-md-4">
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?= $active_pelanggan ?></h3>
                <p>Pelanggan Aktif</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-check"></i>
              </div>
            </div>
          </div>
          
          <div class="col-md-4">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?= $inactive_pelanggan ?></h3>
                <p>Pelanggan Non-Aktif</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-times"></i>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-list mr-2"></i>
                  Daftar Pelanggan
                </h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-success add-button" onclick="window.location.href='tambahdatapelanggan.php';">
                    <i class="fas fa-user-plus"></i> Tambah Pelanggan Baru
                  </button>
                </div>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th width="10%">ID Customer</th>
                      <th width="15%">Produk</th>
                      <th width="25%">Informasi Pelanggan</th>
                      <th width="15%">Kontak</th>
                      <th width="10%">Status</th>
                      <th width="10%">Aksi</th>                    
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i = 1; ?>
                    <?php foreach($plggn as $row) : ?>
                    <tr>
                      <td class="text-center"><?= $i;?></td>
                      <td><span class="badge badge-secondary"><?= $row["id_customer"];?></span></td>
                      <td>
                        <div class="font-weight-bold text-primary"><?= $row["nama_produk"];?></div>
                        <small class="text-muted">(ID: <?= $row["id_produk"];?>)</small>
                      </td>
                      <td>
                        <div class="customer-info">
                          <div class="font-weight-bold mb-1"><?= $row["nama"];?></div>
                          <div><i class="fas fa-map-marker-alt"></i> <?= $row["alamat"];?></div>
                        </div>
                      </td>
                      <td>
                        <div class="customer-info">
                          <div><i class="fas fa-envelope"></i> <?= $row["email"];?></div>
                          <div><i class="fas fa-phone"></i> <?= $row["no_hp"];?></div>
                        </div>
                      </td>
                      <td class="text-center">
                        <span class="badge-status-<?= strtolower($row["status"]) === 'active' ? 'active' : 'inactive' ?>">
                          <i class="fas fa-<?= strtolower($row["status"]) === 'active' ? 'check-circle' : 'times-circle' ?> mr-1"></i>
                          <?= $row["status"];?>
                        </span>
                      </td>
                      <td class="text-center">
                        <a class="btn btn-primary btn-sm btn-action" href="ubahdatapelanggan.php?id_customer=<?= $row["id_customer"]; ?>" data-toggle="tooltip" title="Ubah">
                          <i class="fas fa-edit"></i>
                        </a>
                        <a class="btn btn-danger btn-sm btn-action delete-customer" href="javascript:void(0)" data-id="<?= $row["id_customer"]; ?>" data-toggle="tooltip" title="Hapus">
                          <i class="fas fa-trash"></i>
                        </a>
                      </td>
                    </tr>
                    <?php $i++; ?>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
  </aside>
</div>

<!-- jQuery -->
<script src="../public/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables & Plugins -->
<script src="../public/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../public/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../public/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../public/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- SweetAlert2 -->
<script src="../public/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- AdminLTE App -->
<script src="../public/js/adminlte.min.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    // DataTable initialization
    $("#example1").DataTable({
      "responsive": true, 
      "lengthChange": true, 
      "autoWidth": false,
      "language": {
        "search": "Cari:",
        "lengthMenu": "Tampilkan _MENU_ data per halaman",
        "zeroRecords": "Data tidak ditemukan",
        "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
        "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
        "infoFiltered": "(disaring dari _MAX_ total data)",
        "paginate": {
          "first": "Pertama",
          "last": "Terakhir",
          "next": "Selanjutnya",
          "previous": "Sebelumnya"
        }
      }
    });

    // Enable tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Delete confirmation
    $('.delete-customer').on('click', function() {
      const id = $(this).data('id');
      
      Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data pelanggan akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = 'hapusdatapelanggan.php?id_customer=' + id;
        }
      });
    });
  });

  $(document).ready(function() {
    $('[data-widget="pushmenu"]').on('click', function(e) {
        e.preventDefault();
        if ($('body').hasClass('sidebar-collapse')) {
            $('body').removeClass('sidebar-collapse');
        } else {
            $('body').addClass('sidebar-collapse');
        }
    });
});
</script>
</body>
</html>