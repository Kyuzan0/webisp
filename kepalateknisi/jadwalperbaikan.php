<?php 
require '../includes/functions.php';
require '../view/sidebar.php';

// Query untuk mengambil data perbaikan, termasuk nama customer
$query = "SELECT p.*, k.judul_keluhan, t.nama as nama_teknisi, c.nama as nama_customer
          FROM perbaikan p
          LEFT JOIN keluhan k ON p.id_keluhan = k.id_keluhan
          LEFT JOIN teknisi t ON p.id_teknisi = t.id_teknisi
          LEFT JOIN customer c ON k.id_user = c.id_customer -- Menggunakan k.id_user sesuai koreksi sebelumnya
          ORDER BY p.waktu_penugasan DESC";
$result = mysqli_query($conn, $query);

// Array untuk menyimpan data perbaikan
$jadwal_perbaikan = [];

// Periksa apakah query berhasil
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $jadwal_perbaikan[] = $row;
    }
}

// Hitung status perbaikan untuk kartu statistik
$total_perbaikan = count($jadwal_perbaikan);
$pending_perbaikan = 0;
$inprogress_perbaikan = 0;
$completed_perbaikan = 0;

foreach ($jadwal_perbaikan as $row) {
    $status = 'Pending';
    if ($row['waktu_selesai']) {
        $status = 'Completed';
    } else if (strtotime($row['waktu_penugasan']) <= time()) {
        $status = 'In Progress';
    }

    switch (strtolower($status)) {
        case 'pending':
            $pending_perbaikan++;
            break;
        case 'in progress':
            $inprogress_perbaikan++;
            break;
        case 'completed':
            $completed_perbaikan++;
            break;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>WebISP | Jadwal Perbaikan</title>

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

    .badge-status-inprogress {
      background-color: #17a2b8;
      color: white;
      padding: 5px 10px;
      border-radius: 10px;
      font-weight: normal;
    }

    .badge-status-completed {
      background-color: #28a745;
      color: white;
      padding: 5px 10px;
      border-radius: 10px;
      font-weight: normal;
    }

    .badge-status-cancelled {
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
      box-shadow: 0 4 empat 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
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
  </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->

  <!-- /.navbar -->

  <!-- Main Sidebar Container -->


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><i class="fas fa-calendar-check mr-2"></i>Jadwal Perbaikan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i> Home</a></li>
              <li class="breadcrumb-item active">Jadwal Perbaikan</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Perbaikan Stats Cards -->
            <div class="row mb-4">
              <div class="col-md-3">
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3><?= $total_perbaikan ?></h3>
                    <p>Total Perbaikan</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-tools"></i>
                  </div>
                </div>
              </div>

              <div class="col-md-3">
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3><?= $pending_perbaikan ?></h3>
                    <p>Perbaikan Pending</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-clock"></i>
                  </div>
                </div>
              </div>

              <div class="col-md-3">
                <div class="small-box bg-primary">
                  <div class="inner">
                    <h3><?= $inprogress_perbaikan ?></h3>
                    <p>Perbaikan Diproses</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-cog fa-spin"></i>
                  </div>
                </div>
              </div>

              <div class="col-md-3">
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3><?= $completed_perbaikan ?></h3>
                    <p>Perbaikan Selesai</p>
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
                  Daftar Jadwal Perbaikan
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Keluhan</th>
                            <th width="15%">Teknisi</th>
                            <th width="15%">Waktu Penugasan</th>
                            <th width="15%">Waktu Selesai</th>
                            <th width="25%">Deskripsi</th>
                            <th width="10%">Status</th>
                            <th width="10%">Aksi</th> <!-- Menambahkan kolom Aksi -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($jadwal_perbaikan as $row):
                            // Tentukan status berdasarkan waktu selesai
                            $status = 'Pending';
                            $badge_class = 'badge-status-pending'; // Default
                            if ($row['waktu_selesai']) {
                                $status = 'Completed';
                                $badge_class = 'badge-status-completed';
                            } else if (strtotime($row['waktu_penugasan']) <= time()) {
                                $status = 'In Progress';
                                $badge_class = 'badge-status-inprogress';
                            }
                        ?>
                        <tr class="data-row">
                            <td class="text-center"><?= $i++; ?></td>
                            <td><?= htmlspecialchars($row['judul_keluhan']); ?></td> <!-- Ditambahkan htmlspecialchars -->
                            <td><?= htmlspecialchars($row['nama_teknisi']); ?></td> <!-- Ditambahkan htmlspecialchars -->
                            <td><?= date('d/m/Y H:i', strtotime($row['waktu_penugasan'])); ?></td>
                            <td><?= $row['waktu_selesai'] ? date('d/m/Y H:i', strtotime($row['waktu_selesai'])) : '-'; ?></td>
                            <td class="description-cell"><?= htmlspecialchars($row['deskripsi']); ?></td> <!-- Ditambahkan htmlspecialchars -->
                            <td class="text-center">
                                <span class="badge <?= $badge_class; ?>">
                                    <?= $status; ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <!-- Tombol Detail -->
                                <button type="button" class="btn btn-info btn-sm btn-action view-perbaikan"
                                    data-id="<?= $row['id_perbaikan']; ?>"
                                    data-keluhan="<?= htmlspecialchars($row['judul_keluhan']); ?>"
                                    data-teknisi="<?= htmlspecialchars($row['nama_teknisi']); ?>"
                                    data-penugasan="<?= date('d/m/Y H:i', strtotime($row['waktu_penugasan'])); ?>"
                                    data-selesai="<?= $row['waktu_selesai'] ? date('d/m/Y H:i', strtotime($row['waktu_selesai'])) : '-'; ?>"
                                    data-deskripsi="<?= htmlspecialchars($row['deskripsi']); ?>"
                                    data-status="<?= $status; ?>"
                                    data-toggle="tooltip" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
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


  <!-- Detail Modal -->
  <div class="modal fade" id="modal-detail-perbaikan">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <h4 class="modal-title">Detail Jadwal Perbaikan</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="text-center mb-3">
            <i class="fas fa-calendar-check fa-3x text-info"></i>
          </div>
          <table class="table table-striped">
            <tr>
              <th>ID Perbaikan</th>
              <td id="detail-perbaikan-id"></td>
            </tr>
            <tr>
              <th>Keluhan</th>
              <td id="detail-perbaikan-keluhan"></td>
            </tr>
            <tr>
              <th>Teknisi</th>
              <td id="detail-perbaikan-teknisi"></td>
            </tr>
            <tr>
              <th>Waktu Penugasan</th>
              <td id="detail-perbaikan-penugasan"></td>
            </tr>
            <tr>
              <th>Waktu Selesai</th>
              <td id="detail-perbaikan-selesai"></td>
            </tr>
            <tr>
              <th>Status</th>
              <td id="detail-perbaikan-status"></td>
            </tr>
            <tr>
              <th>Deskripsi</th>
              <td id="detail-perbaikan-deskripsi"></td>
            </tr>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>


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
    // DataTable initialization
    $("#example1").DataTable({
      "responsive": true,
      "lengthChange": true, // Mengubah false menjadi true
      "autoWidth": false,
      "language": { // Menambahkan konfigurasi bahasa
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

    // Enable tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // View Perbaikan Detail
    $('.view-perbaikan').on('click', function() {
        const id = $(this).data('id');
        const keluhan = $(this).data('keluhan');
        const teknisi = $(this).data('teknisi');
        const penugasan = $(this).data('penugasan');
        const selesai = $(this).data('selesai');
        const deskripsi = $(this).data('deskripsi');
        const status = $(this).data('status');

        // Tentukan badge status
        let statusBadge = '';
        switch(status.toLowerCase()) {
            case 'pending':
                statusBadge = '<span class="badge-status-pending"><i class="fas fa-clock mr-1"></i> Pending</span>';
                break;
            case 'in progress':
                statusBadge = '<span class="badge-status-inprogress"><i class="fas fa-spinner mr-1"></i> In Progress</span>';
                break;
            case 'completed':
                statusBadge = '<span class="badge-status-completed"><i class="fas fa-check-circle mr-1"></i> Completed</span>';
                break;
            case 'cancelled': // Menambahkan case cancelled jika status ini mungkin ada
                statusBadge = '<span class="badge-status-cancelled"><i class="fas fa-times-circle mr-1"></i> Cancelled</span>';
                break;
            default:
                statusBadge = '<span class="badge badge-secondary">' + status + '</span>';
        }


        $('#detail-perbaikan-id').text(id);
        $('#detail-perbaikan-keluhan').text(keluhan);
        $('#detail-perbaikan-teknisi').text(teknisi);
        $('#detail-perbaikan-penugasan').text(penugasan);
        $('#detail-perbaikan-selesai').text(selesai);
        $('#detail-perbaikan-status').html(statusBadge);
        $('#detail-perbaikan-deskripsi').text(deskripsi);

        $('#modal-detail-perbaikan').modal('show');
    });

  });
</script>
</body>
</html>

<?php
// Fungsi untuk menentukan class badge berdasarkan status
function getStatusBadgeClass($status) {
    switch(strtolower($status)) {
        case 'pending':
            return 'status-pending'; // Menggunakan class CSS baru
        case 'in progress':
            return 'status-inprogress'; // Menggunakan class CSS baru
        case 'completed':
            return 'status-completed'; // Menggunakan class CSS baru
        case 'cancelled':
            return 'status-cancelled'; // Menggunakan class CSS baru
        default:
            return 'secondary';
    }
}

// Tutup koneksi database
mysqli_close($conn);
?>