<?php 
require '../includes/functions.php';
require '../view/sidebar.php';

$users = query("SELECT * FROM users"); 
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>WebISP | Kelola Data User</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../public/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../public/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
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

    .badge-user-admin {
      background-color: #dc3545;
      color: white;
      padding: 5px 10px;
      border-radius: 10px;
      font-weight: normal;
    }

    .badge-user-supervisor {
      background-color: #28a745;
      color: white;
      padding: 5px 10px;
      border-radius: 10px;
      font-weight: normal;
    }

    .badge-user-teknisi {
      background-color: #17a2b8;
      color: white;
      padding: 5px 10px;
      border-radius: 10px;
      font-weight: normal;
    }

    .badge-user-sales {
      background-color: #ffc107;
      color: black;
      padding: 5px 10px;
      border-radius: 10px;
      font-weight: normal;
    }

    .badge-user-customer {
      background-color: #6c757d;
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
  </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
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
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><i class="fas fa-users mr-2"></i>Data User</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i> Home</a></li>
              <li class="breadcrumb-item active">Kelola Data User</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- User Stats Cards -->
        <div class="row mb-4">
          <div class="col-md-3">
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?= count($users) ?></h3>
                <p>Total User</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
            </div>
          </div>
          
          <?php
          $admin = 0;
          $supervisor = 0;
          $teknisi = 0;
          foreach($users as $user) {
            if($user["level"] == "Admin") $admin++;
            if($user["level"] == "Supervisor") $supervisor++;
            if($user["level"] == "Teknisi") $teknisi++;
          }
          ?>
          
          <div class="col-md-3">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?= $admin ?></h3>
                <p>Admin</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-shield"></i>
              </div>
            </div>
          </div>
          
          <div class="col-md-3">
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?= $supervisor ?></h3>
                <p>Supervisor</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-tie"></i>
              </div>
            </div>
          </div>
          
          <div class="col-md-3">
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?= $teknisi ?></h3>
                <p>Teknisi</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-cog"></i>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-users mr-2"></i>
                  Daftar User
                </h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-success add-button" onclick="window.location.href='tambahdatauser.php';">
                    <i class="fas fa-user-plus"></i> Tambah User Baru
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-hover">
                  <thead>
                  <tr>
                    <th width="5%">No. </th>
                    <th width="10%">ID User</th>
                    <th width="20%">Email</th>
                    <th width="20%">Username</th>
                    <th width="15%">Level</th>
                    <th width="15%">Aksi</th>
                  </tr>
                  </thead>

                  <tbody>
                  <?php $i = 1; ?>
                  <?php foreach($users as $row) : 
                    // Set badge class berdasarkan level
                    $badge_class = "";
                    $icon_class = "";
                    switch($row["level"]) {
                      case "Admin":
                        $badge_class = "badge-user-admin";
                        $icon_class = "fas fa-user-shield";
                        break;
                      case "Supervisor":
                        $badge_class = "badge-user-supervisor";
                        $icon_class = "fas fa-user-tie";
                        break;
                      case "Kepala Teknisi":
                      case "Teknisi":
                        $badge_class = "badge-user-teknisi";
                        $icon_class = "fas fa-user-cog";
                        break;
                      case "Sales Marketing":
                        $badge_class = "badge-user-sales";
                        $icon_class = "fas fa-user-tag";
                        break;
                      default:
                        $badge_class = "badge-user-customer";
                        $icon_class = "fas fa-user";
                    }
                  ?>
                  <tr>
                    <td class="text-center"><?= $i; ?></td>
                    <td><span class="badge badge-secondary"><?= $row["id_user"]; ?></span></td>
                    <td><?= $row["email"]; ?></td>
                    <td><?= $row["username"]; ?></td>
                    <td class="text-center">
                      <span class="<?= $badge_class; ?>">
                        <i class="<?= $icon_class; ?> mr-1"></i>
                        <?= $row["level"]; ?>
                      </span>
                    </td>
                    <td class="text-center">
                      <a class="btn btn-primary btn-sm btn-action" href="ubahdatauser.php?id_user=<?= $row["id_user"]; ?>" data-toggle="tooltip" title="Ubah">
                        <i class="fas fa-edit"></i>
                      </a>
                      <a class="btn btn-danger btn-sm btn-action delete-user" href="javascript:void(0)" data-id="<?= $row["id_user"]; ?>" data-toggle="tooltip" title="Hapus">
                        <i class="fas fa-trash"></i>
                      </a>
                    </td>
                  </tr>
                  <?php $i++; ?>
                  <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../public/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
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
    // DataTable initialization with responsive
    var table = $("#example1").DataTable({
      "responsive": true, 
      "lengthChange": true, 
      "autoWidth": false,
      "language": {
        "search": "Cari:",
        "lengthMenu": "Tampilkan _MENU_ data per halaman",
        "zeroRecords": "Tidak ada data yang ditemukan",
        "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
        "infoEmpty": "Tidak ada data yang ditampilkan",
        "infoFiltered": "(difilter dari _MAX_ total data)",
        "paginate": {
          "first": "Pertama",
          "last": "Terakhir",
          "next": "Selanjutnya",
          "previous": "Sebelumnya"
        }
      },
      "drawCallback": function() {
        // Rebind delete button event after table redraw
        bindDeleteEvents();
      }
    });
    
    // Enable tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    // Function to bind delete events
    function bindDeleteEvents() {
      $('.delete-user').off('click').on('click', function() {
        const id = $(this).data('id');
        
        Swal.fire({
          title: 'Apakah Anda yakin?',
          text: "Data user akan dihapus permanen!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Ya, hapus!',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = 'hapusdatauser.php?id_user=' + id;
          }
        });
      });
    }
    
    // Initial binding of delete events
    bindDeleteEvents();
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