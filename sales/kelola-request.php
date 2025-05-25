<?php
require '../includes/init_session.php';
require '../includes/functions.php';
require '../view/sidebar.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Request Paket - Sales Marketing</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../public/plugins/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../public/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../public/css/adminlte.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="../public/plugins/sweetalert2/sweetalert2.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="../public/plugins/toastr/toastr.min.css">
    
    <style>
        .card {
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-3px);
        }
        
        .card-header {
            background: linear-gradient(45deg, #3c8dbc, #00c0ef);
            color: white;
            border-radius: 15px 15px 0 0 !important;
        }
        
        .btn-action {
            border-radius: 8px;
            margin: 2px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border: none;
        }
        
        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        .table-hover tbody tr:hover {
            background-color: rgba(0,123,255,0.08);
            transform: scale(1.005);
            transition: all 0.2s ease;
        }
        
        .badge-upgrade {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
            padding: 6px 12px;
            border-radius: 12px;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.7rem;
        }
        
        .badge-downgrade {
            background: linear-gradient(45deg, #ffc107, #fd7e14);
            color: #212529;
            padding: 6px 12px;
            border-radius: 12px;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.7rem;
        }
        
        .customer-name {
            font-weight: 600;
            color: #2c3e50;
        }
        
        .status-badge {
            font-size: 0.75rem;
            padding: 4px 8px;
            border-radius: 10px;
            font-weight: 500;
        }
        
        .price-diff-positive {
            color: #28a745;
            font-weight: 600;
        }
        
        .price-diff-negative {
            color: #dc3545;
            font-weight: 600;
        }
        
        .small-box {
            border-radius: 10px;
            overflow: hidden;
        }
        
        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .modal-header {
            border-radius: 15px 15px 0 0;
        }
        
        .loading-spinner {
            display: none;
            text-align: center;
            padding: 20px;
        }
        
        .table th {
            border-top: none;
            font-weight: 600;
            color: #495057;
            background-color: #f8f9fa;
        }
        
        .row-number {
            font-weight: 600;
            color: #6c757d;
            text-align: center;
        }
        
        @media (max-width: 768px) {
            .btn-group .btn {
                margin-bottom: 5px;
            }
            
            .card-header h3 {
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="fas fa-exchange-alt mr-2"></i>Kelola Request Perubahan Paket</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../dashboard.php"><i class="fas fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item active">Kelola Request</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3 id="pending-count">-</h3>
                                <p>Pending</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3 id="approved-count">-</h3>
                                <p>Disetujui</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3 id="rejected-count">-</h3>
                                <p>Ditolak</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-times"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3 id="total-count">-</h3>
                                <p>Total</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-list"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Request Table -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-table mr-2"></i>Daftar Request Perubahan Paket</h3>
                                <div class="card-tools">
                                    <button class="btn btn-tool btn-action" onclick="loadRequests()" id="refresh-btn">
                                        <i class="fas fa-sync"></i> Refresh
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="table-requests" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th width="5%">No.</th>
                                                <th width="10%">Tanggal</th>
                                                <th width="15%">Customer</th>
                                                <th width="12%">Kontak</th>
                                                <th width="12%">Paket Lama</th>
                                                <th width="12%">Paket Baru</th>
                                                <th width="8%">Jenis</th>
                                                <th width="8%">Selisih</th>
                                                <th width="8%">Status</th>
                                                <th width="10%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Data akan diload via AJAX -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- Modal Approve/Reject -->
<div class="modal fade" id="modalProcess" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="modalTitle"><i class="fas fa-info-circle mr-2"></i>Proses Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-process">
                    <input type="hidden" id="request-id" name="id_request">
                    <input type="hidden" id="action-type" name="action">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fas fa-user mr-2"></i>Customer:</label>
                                <p id="customer-info" class="form-control-plaintext customer-name font-weight-bold"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fas fa-exchange-alt mr-2"></i>Perubahan:</label>
                                <p id="request-info" class="form-control-plaintext"></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="catatan"><i class="fas fa-comment mr-2"></i>Catatan Admin: <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="catatan" name="catatan" rows="4" 
                                  placeholder="Berikan catatan untuk customer..." required></textarea>
                        <small class="form-text text-muted">Catatan ini akan dikirim ke customer</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-action" data-dismiss="modal">
                    <i class="fas fa-times mr-2"></i>Batal
                </button>
                <button type="button" class="btn btn-action" id="btn-confirm" onclick="processRequest()">
                    <i class="fas fa-spinner fa-spin mr-2 d-none" id="process-spinner"></i>
                    <span id="btn-text">Konfirmasi</span>
                </button>
            </div>
        </div>
    </div>
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
<!-- AdminLTE App -->
<script src="../public/js/adminlte.min.js"></script>
<!-- SweetAlert2 -->
<script src="../public/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="../public/plugins/toastr/toastr.min.js"></script>

<script>
    let dataTable;
    
    $(document).ready(function() {
        initializeDataTable();
        loadRequests();
        
        // Form validation
        $('#form-process').on('submit', function(e) {
            e.preventDefault();
        });
        
        // Auto-refresh setiap 5 menit
        setInterval(loadRequests, 300000);
    });

    function initializeDataTable() {
        dataTable = $("#table-requests").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "pageLength": 25,
            "order": [[1, "desc"]], // Sort by date descending (index 1 karena ada kolom No.)
            "columnDefs": [
                { "orderable": false, "targets": [0, 9] }, // Disable sorting for No. and action column
                { "searchable": false, "targets": [0] } // Disable search for No. column
            ],
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
                },
                "processing": "Memproses..."
            }
        });
    }

    function loadRequests() {
        $('#loading-spinner').show();
        $('#refresh-btn').prop('disabled', true);
        
        $.ajax({
            url: '../api/admin-kelola-request.php',
            type: 'GET',
            dataType: 'json',
            timeout: 10000,
            success: function(response) {
                if (response.success) {
                    displayRequests(response.requests);
                    updateStatistics(response.requests);
                    toastr.success('Data berhasil dimuat');
                } else {
                    showError('Gagal memuat data', response.message);
                }
            },
            error: function(xhr, status, error) {
                let message = 'Terjadi kesalahan sistem';
                if (status === 'timeout') {
                    message = 'Koneksi timeout, silakan coba lagi';
                } else if (xhr.status === 404) {
                    message = 'API endpoint tidak ditemukan';
                } else if (xhr.status === 500) {
                    message = 'Error server internal';
                }
                showError('Error', message);
            },
            complete: function() {
                $('#loading-spinner').hide();
                $('#refresh-btn').prop('disabled', false);
            }
        });
    }

    function displayRequests(requests) {
        // Clear existing data
        dataTable.clear();
        
        requests.forEach(function(req, index) {
            const selisihHarga = parseInt(req.harga_baru) - parseInt(req.harga_lama);
            const selisihClass = selisihHarga >= 0 ? 'price-diff-positive' : 'price-diff-negative';
            const jenisClass = req.jenis_request === 'upgrade' ? 'badge-upgrade' : 'badge-downgrade';
            
            // Status dan action buttons
            let statusBadge = '';
            let actionButtons = '';
            
            switch(req.status_request) {
                case 'pending':
                    statusBadge = '<span class="badge badge-warning status-badge">Pending</span>';
                    actionButtons = `
                        <div class="btn-group btn-group-sm" role="group">
                            <button class="btn btn-success btn-action" 
                                    onclick="showModal(${req.id_request}, 'approve', '${escapeHtml(req.customer_name)}', '${escapeHtml(req.paket_lama)}', '${escapeHtml(req.paket_baru)}', '${req.jenis_request}')" 
                                    data-toggle="tooltip" title="Setujui Request">
                                <i class="fas fa-check"></i>
                            </button>
                            <button class="btn btn-danger btn-action" 
                                    onclick="showModal(${req.id_request}, 'reject', '${escapeHtml(req.customer_name)}', '${escapeHtml(req.paket_lama)}', '${escapeHtml(req.paket_baru)}', '${req.jenis_request}')" 
                                    data-toggle="tooltip" title="Tolak Request">
                                <i class="fas fa-times"></i>
                            </button>
                            <button class="btn btn-info btn-action" 
                                    onclick="showAlasan(${req.id_request})" 
                                    data-toggle="tooltip" title="Lihat Alasan">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>`;
                    break;
                case 'disetujui':
                    statusBadge = '<span class="badge badge-success status-badge">Disetujui</span>';
                    actionButtons = `
                        <small class="text-muted">Oleh: ${req.admin_name || 'Sales'}</small><br>
                        <button class="btn btn-sm btn-info btn-action mt-1" 
                                onclick="showAlasan(${req.id_request})" 
                                data-toggle="tooltip" title="Lihat Detail">
                            <i class="fas fa-info-circle"></i>
                        </button>`;
                    break;
                case 'ditolak':
                    statusBadge = '<span class="badge badge-danger status-badge">Ditolak</span>';
                    actionButtons = `
                        <small class="text-muted">Oleh: ${req.admin_name || 'Sales'}</small><br>
                        <button class="btn btn-sm btn-info btn-action mt-1" 
                                onclick="showAlasan(${req.id_request})" 
                                data-toggle="tooltip" title="Lihat Detail">
                            <i class="fas fa-info-circle"></i>
                        </button>`;
                    break;
            }
            
            // Add row to DataTable dengan nomor urut
            dataTable.row.add([
                `<span class="row-number">${index + 1}</span>`,
                formatDate(req.tanggal_request),
                `<span class="customer-name">${req.customer_name}</span><br><small class="text-muted">ID: ${req.id_customer}</small>`,
                `${req.no_hp}<br><small class="text-muted">${req.email || '-'}</small>`,
                `${req.paket_lama}<br><small class="text-muted">Rp ${parseInt(req.harga_lama).toLocaleString('id-ID')}</small>`,
                `${req.paket_baru}<br><small class="text-muted">Rp ${parseInt(req.harga_baru).toLocaleString('id-ID')}</small>`,
                `<span class="${jenisClass}">${req.jenis_request}</span>`,
                `<span class="${selisihClass}"><strong>${selisihHarga >= 0 ? '+' : ''}Rp ${selisihHarga.toLocaleString('id-ID')}</strong></span>`,
                statusBadge,
                actionButtons
            ]);
        });
        
        // Draw the table
        dataTable.draw();
        
        // Enable tooltips
        $('[data-toggle="tooltip"]').tooltip();
    }

    function updateStatistics(requests) {
        const stats = requests.reduce((acc, req) => {
            acc[req.status_request] = (acc[req.status_request] || 0) + 1;
            return acc;
        }, {});
        
        $('#pending-count').text(stats.pending || 0);
        $('#approved-count').text(stats.disetujui || 0);
        $('#rejected-count').text(stats.ditolak || 0);
        $('#total-count').text(requests.length);
    }

    function showAlasan(requestId) {
        $.ajax({
            url: '../api/admin-kelola-request.php',
            type: 'GET',
            data: { detail: requestId },
            dataType: 'json',
            success: function(response) {
                if (response.success && response.request) {
                    const req = response.request;
                    let content = `
                        <div class="card">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fas fa-user mr-2"></i>${req.customer_name}</h6>
                            </div>
                            <div class="card-body">
                                <p><strong>Alasan Customer:</strong></p>
                                <div class="p-3 border rounded bg-light mb-3">${req.alasan_request}</div>
                    `;
                    
                    if (req.catatan_admin) {
                        content += `
                            <p><strong>Catatan Admin:</strong></p>
                            <div class="p-3 border rounded bg-warning-light">${req.catatan_admin}</div>
                        `;
                    }
                    
                    content += `</div></div>`;
                    
                    Swal.fire({
                        title: '<i class="fas fa-comment-alt mr-2"></i>Detail Request',
                        html: content,
                        icon: 'info',
                        width: '600px',
                        confirmButtonClass: 'btn-action'
                    });
                } else {
                    Swal.fire({
                        title: 'Info',
                        text: 'Detail request tidak ditemukan',
                        icon: 'info'
                    });
                }
            },
            error: function() {
                showError('Error', 'Gagal memuat detail request');
            }
        });
    }

    function showModal(id, action, customer, paketLama, paketBaru, jenis) {
        $('#request-id').val(id);
        $('#action-type').val(action);
        $('#customer-info').text(customer);
        $('#request-info').html(`<strong>${jenis.toUpperCase()}:</strong> ${paketLama} → ${paketBaru}`);
        $('#catatan').val('').focus();
        
        if (action === 'approve') {
            $('#modalTitle').html('<i class="fas fa-check-circle mr-2"></i>Setujui Request');
            $('#btn-confirm').removeClass('btn-danger').addClass('btn-success');
            $('#btn-text').html('<i class="fas fa-check mr-2"></i>Setujui');
        } else {
            $('#modalTitle').html('<i class="fas fa-times-circle mr-2"></i>Tolak Request');
            $('#btn-confirm').removeClass('btn-success').addClass('btn-danger');
            $('#btn-text').html('<i class="fas fa-times mr-2"></i>Tolak');
        }
        
        $('#modalProcess').modal('show');
    }

    function processRequest() {
        const catatan = $('#catatan').val().trim();
        if (!catatan) {
            toastr.error('Catatan admin harus diisi');
            $('#catatan').focus();
            return;
        }
        
        // Show loading state
        $('#process-spinner').removeClass('d-none');
        $('#btn-confirm').prop('disabled', true);
        
        const formData = new FormData($('#form-process')[0]);
        
        $.ajax({
            url: '../api/admin-kelola-request.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            timeout: 15000,
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Sukses!',
                        text: 'Request berhasil diproses',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    $('#modalProcess').modal('hide');
                    $('#form-process')[0].reset();
                    loadRequests();
                } else {
                    showError('Gagal Memproses', response.message);
                }
            },
            error: function(xhr, status, error) {
                let message = 'Terjadi kesalahan sistem';
                if (status === 'timeout') {
                    message = 'Proses timeout, silakan coba lagi';
                }
                showError('Error', message);
            },
            complete: function() {
                $('#process-spinner').addClass('d-none');
                $('#btn-confirm').prop('disabled', false);
            }
        });
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        const options = { 
            year: 'numeric', 
            month: 'short', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        };
        return date.toLocaleDateString('id-ID', options);
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function showError(title, message) {
        Swal.fire({
            title: title,
            text: message,
            icon: 'error',
            confirmButtonClass: 'btn-action'
        });
    }

    // Reset modal when closed
    $('#modalProcess').on('hidden.bs.modal', function() {
        $('#form-process')[0].reset();
        $('#process-spinner').addClass('d-none');
        $('#btn-confirm').prop('disabled', false);
    });
</script>
</body>
</html>