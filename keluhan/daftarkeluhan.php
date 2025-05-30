<?php 
require '../includes/functions.php';
require '../view/sidebar.php';

// Query dengan JOIN untuk mendapatkan nama user berdasarkan level
$keluhan = query("SELECT k.*, u.level, 
    CASE 
        WHEN u.level = 'Admin' THEN a.nama
        WHEN u.level = 'Supervisor' THEN s.nama  
        WHEN u.level = 'Kepala Teknisi' THEN kt.nama
        WHEN u.level = 'Sales Marketing' THEN sm.nama
        WHEN u.level = 'Teknisi' THEN t.nama
        WHEN u.level = 'Customer' THEN c.nama
        ELSE u.username
    END as nama_user
    FROM keluhan k 
    JOIN users u ON k.id_user = u.id_user
    LEFT JOIN admin a ON u.id_user = a.id_user
    LEFT JOIN supervisor s ON u.id_user = s.id_user  
    LEFT JOIN kepalateknisi kt ON u.id_user = kt.id_user
    LEFT JOIN salesmarketing sm ON u.id_user = sm.id_user
    LEFT JOIN teknisi t ON u.id_user = t.id_user
    LEFT JOIN customer c ON u.id_user = c.id_user");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>WebISP | Kelola Data Keluhan</title>

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
    
    .badge-status-pending {
      background-color: #ffc107;
      color: black;
      padding: 5px 10px;
      border-radius: 10px;
      font-weight: normal;
    }
    
    .badge-status-proses {
      background-color: #17a2b8;
      color: white;
      padding: 5px 10px;
      border-radius: 10px;
      font-weight: normal;
    }
    
    .badge-status-selesai {
      background-color: #28a745;
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
    
    .description-cell {
      max-width: 250px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }
    
    .description-cell:hover {
      white-space: normal;
      overflow: visible;
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
    
    .card-title {
      font-weight: 600;
      letter-spacing: 0.5px;
    }
    
    .data-row {
      transition: all 0.2s;
    }
    
    .data-row:hover {
      transform: scale(1.01);
    }

    .user-badge {
      padding: 4px 8px;
      border-radius: 12px;
      font-size: 0.85em;
      font-weight: 500;
    }
    
    .level-admin { background-color: #dc3545; color: white; }
    .level-supervisor { background-color: #6f42c1; color: white; }
    .level-kepala-teknisi { background-color: #fd7e14; color: white; }
    .level-sales-marketing { background-color: #20c997; color: white; }
    .level-teknisi { background-color: #0dcaf0; color: black; }
    .level-customer { background-color: #198754; color: white; }
  </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><i class="fas fa-comments mr-2"></i>Daftar Keluhan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i> Home</a></li>
              <li class="breadcrumb-item active">Data Keluhan</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Keluhan Stats Cards -->
            <div class="row mb-4">
              <div class="col-md-3">
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3><?= count($keluhan) ?></h3>
                    <p>Total Keluhan</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-comments"></i>
                  </div>
                </div>
              </div>
              
              <div class="col-md-3">
                <div class="small-box bg-warning">
                  <div class="inner">
                    <?php
                    $pending = 0;
                    foreach($keluhan as $k) {
                      if($k["status"] == "Pending") {
                        $pending++;
                      }
                    }
                    ?>
                    <h3><?= $pending ?></h3>
                    <p>Keluhan Pending</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-clock"></i>
                  </div>
                </div>
              </div>
              
              <div class="col-md-3">
                <div class="small-box bg-primary">
                  <div class="inner">
                    <?php
                    $proses = 0;
                    foreach($keluhan as $k) {
                      if($k["status"] == "Proses") {
                        $proses++;
                      }
                    }
                    ?>
                    <h3><?= $proses ?></h3>
                    <p>Keluhan Diproses</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-cog fa-spin"></i>
                  </div>
                </div>
              </div>
              
              <div class="col-md-3">
                <div class="small-box bg-success">
                  <div class="inner">
                    <?php
                    $selesai = 0;
                    foreach($keluhan as $k) {
                      if($k["status"] == "Selesai") {
                        $selesai++;
                      }
                    }
                    ?>
                    <h3><?= $selesai ?></h3>
                    <p>Keluhan Selesai</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-check-circle"></i>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-list mr-2"></i>
                  Daftar Keluhan Pelanggan
                </h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-success add-button" onclick="window.location.href='tambahkeluhan.php';">
                    <i class="fas fa-plus-circle"></i> Tambah Keluhan
                  </button>
                </div>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-hover">
                  <thead>
                  <tr>
                    <th width="5%">No</th>
                    <th width="15%">Nama User</th>
                    <th width="15%">Tanggal</th>
                    <th width="20%">Judul</th>
                    <th width="25%">Deskripsi</th>
                    <th width="10%">Status</th>
                    <th width="10%">Aksi</th>
                  </tr>
                  </thead>

                  <tbody>
                  <?php $i = 1; ?>
                  <?php foreach($keluhan as $row) : 
                    // Tentukan badge status
                    switch($row["status"]) {
                      case "Pending":
                        $badge_class = "badge-status-pending";
                        break;
                      case "Proses":
                        $badge_class = "badge-status-proses";
                        break;
                      case "Selesai":
                        $badge_class = "badge-status-selesai";
                        break;
                      default:
                        $badge_class = "badge-secondary";
                    }
                    
                    // Tentukan class badge level
                    $level_class = "";
                    switch($row["level"]) {
                      case "Admin":
                        $level_class = "level-admin";
                        break;
                      case "Supervisor":
                        $level_class = "level-supervisor";
                        break;
                      case "Kepala Teknisi":
                        $level_class = "level-kepala-teknisi";
                        break;
                      case "Sales Marketing":
                        $level_class = "level-sales-marketing";
                        break;
                      case "Teknisi":
                        $level_class = "level-teknisi";
                        break;
                      case "Customer":
                        $level_class = "level-customer";
                        break;
                    }
                  ?>
                  <tr class="data-row">
                    <td class="text-center"><?= $i;?></td>
                    <td>
                      <div class="mb-2"><?= $row["nama_user"];?></div>
                      <small><span class="user-badge <?= $level_class ?>"><?= $row["level"];?></span></small>
                    </td>
                    <td><?= $row["tanggal_keluhan"];?></td>
                    <td class="font-weight-bold"><?= $row["judul_keluhan"];?></td>
                    <td class="description-cell"><?= $row["deskripsi"];?></td>
                    <td class="text-center"><span class="<?= $badge_class ?>"><?= $row["status"];?></span></td>
                    <td class="text-center">
                      <button type="button" class="btn btn-info btn-sm btn-action view-keluhan" data-id="<?= $row["id_keluhan"]; ?>" data-toggle="tooltip" title="Lihat Detail">
                        <i class="fas fa-eye"></i>
                      </button>
                      <a class="btn btn-primary btn-sm btn-action" href="ubahkeluhan.php?id_keluhan=<?= $row["id_keluhan"]; ?>" data-toggle="tooltip" title="Ubah">
                        <i class="fas fa-edit"></i>
                      </a>
                      <a class="btn btn-danger btn-sm btn-action delete-keluhan" href="javascript:void(0)" data-id="<?= $row["id_keluhan"]; ?>" data-toggle="tooltip" title="Hapus">
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

  <!-- Detail Modal -->
  <div class="modal fade" id="modal-detail">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <h4 class="modal-title">Detail Keluhan</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="text-center mb-3">
            <i class="fas fa-comments fa-3x text-info"></i>
          </div>
          <table class="table table-striped">
            <tr>
              <th>ID Keluhan</th>
              <td id="detail-id"></td>
            </tr>
            <tr>
              <th>Nama User</th>
              <td id="detail-nama-user"></td>
            </tr>
            <tr>
              <th>Level User</th>
              <td id="detail-level-user"></td>
            </tr>
            <tr>
              <th>Tanggal</th>
              <td id="detail-tanggal"></td>
            </tr>
            <tr>
              <th>Judul</th>
              <td id="detail-judul"></td>
            </tr>
            <tr>
              <th>Status</th>
              <td id="detail-status"></td>
            </tr>
            <tr>
              <th>Deskripsi</th>
              <td id="detail-deskripsi"></td>
            </tr>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

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

<script>
$(function () {
    // DataTable initialization with responsive
    var table = $("#example1").DataTable({
      "responsive": true, 
      "lengthChange": true, 
      "autoWidth": false,
      "drawCallback": function(settings) {
        // Reinitialize tooltips after table redraw
        $('[data-toggle="tooltip"]').tooltip();
        
        // Reinitialize view and delete handlers after table redraw
        initializeViewHandler();
        initializeDeleteHandler();
      },
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
      }
    });
    
    // Function to initialize view handler
    function initializeViewHandler() {
      $('.view-keluhan').off('click').on('click', function() {
        const id = $(this).data('id');
        let keluhanData = null;
        
        <?php foreach($keluhan as $row): ?>
        if(<?= json_encode($row["id_keluhan"]); ?> == id) {
          keluhanData = {
            id: <?= json_encode($row["id_keluhan"]); ?>,
            nama_user: <?= json_encode($row["nama_user"]); ?>,
            level: <?= json_encode($row["level"]); ?>,
            tanggal: <?= json_encode($row["tanggal_keluhan"]); ?>,
            judul: <?= json_encode($row["judul_keluhan"]); ?>,
            deskripsi: <?= json_encode($row["deskripsi"]); ?>,
            status: <?= json_encode($row["status"]); ?>
          };
          
          // Tentukan badge status
          switch(keluhanData.status) {
            case "Pending":
              keluhanData.statusBadge = '<span class="badge-status-pending">Pending</span>';
              break;
            case "Proses":
              keluhanData.statusBadge = '<span class="badge-status-proses">Proses</span>';
              break;
            case "Selesai":
              keluhanData.statusBadge = '<span class="badge-status-selesai">Selesai</span>';
              break;
            default:
              keluhanData.statusBadge = '<span class="badge-secondary">' + keluhanData.status + '</span>';
          }
          
          // Tentukan badge level
          let levelClass = "";
          switch(keluhanData.level) {
            case "Admin": levelClass = "level-admin"; break;
            case "Supervisor": levelClass = "level-supervisor"; break;
            case "Kepala Teknisi": levelClass = "level-kepala-teknisi"; break;
            case "Sales Marketing": levelClass = "level-sales-marketing"; break;
            case "Teknisi": levelClass = "level-teknisi"; break;
            case "Customer": levelClass = "level-customer"; break;
          }
          keluhanData.levelBadge = '<span class="user-badge ' + levelClass + '">' + keluhanData.level + '</span>';
        }
        <?php endforeach; ?>
        
        if(keluhanData) {
          $('#detail-id').text(keluhanData.id);
          $('#detail-nama-user').text(keluhanData.nama_user);
          $('#detail-level-user').html(keluhanData.levelBadge);
          $('#detail-tanggal').text(keluhanData.tanggal);
          $('#detail-judul').text(keluhanData.judul);
          $('#detail-status').html(keluhanData.statusBadge);
          $('#detail-deskripsi').text(keluhanData.deskripsi);
          
          $('#modal-detail').modal('show');
        }
      });
    }
    
    // Function to initialize delete handler
    function initializeDeleteHandler() {
      $('.delete-keluhan').off('click').on('click', function() {
        const id = $(this).data('id');
        
        Swal.fire({
          title: 'Apakah Anda yakin?',
          text: "Data keluhan akan dihapus permanen!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Ya, hapus!',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = 'hapuskeluhan.php?id_keluhan=' + id;
          }
        });
      });
    }
    
    // Initial initialization of handlers
    initializeViewHandler();
    initializeDeleteHandler();
    
    // Show toastr notification if there's a message
    <?php if(isset($_SESSION['message'])): ?>
    toastr.success('<?= $_SESSION['message']; ?>');
    <?php unset($_SESSION['message']); endif; ?>
});
</script>
</body>
</html>