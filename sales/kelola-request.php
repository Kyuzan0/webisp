<?php

require '../includes/init_session.php';
require '../includes/functions.php';

?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Request Paket - Sales Marketing</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Kelola Request Perubahan Paket</h1>
                    <button class="btn btn-primary" onclick="loadRequests()">
                        <i class="fas fa-sync"></i> Refresh
                    </button>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 id="pending-count">0</h4>
                                        <p class="mb-0">Pending</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-clock fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 id="approved-count">0</h4>
                                        <p class="mb-0">Disetujui</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-check fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-danger text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 id="rejected-count">0</h4>
                                        <p class="mb-0">Ditolak</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-times fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 id="total-count">0</h4>
                                        <p class="mb-0">Total</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-list fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Request Table -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="fas fa-table"></i> Daftar Request Pending</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover" id="table-requests">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Customer</th>
                                                <th>Kontak</th>
                                                <th>Paket Lama</th>
                                                <th>Paket Baru</th>
                                                <th>Jenis</th>
                                                <th>Selisih Harga</th>
                                                <th>Alasan</th>
                                                <th>Aksi</th>
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
            </main>
        </div>
    </div>

    <!-- Modal Approve/Reject -->
    <div class="modal fade" id="modalProcess" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Proses Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="form-process">
                        <input type="hidden" id="request-id" name="id_request">
                        <input type="hidden" id="action-type" name="action">
                        
                        <div class="mb-3">
                            <label class="form-label">Customer:</label>
                            <p id="customer-info" class="form-control-plaintext"></p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Request:</label>
                            <p id="request-info" class="form-control-plaintext"></p>
                        </div>
                        
                        <div class="mb-3">
                            <label for="catatan" class="form-label">Catatan Admin</label>
                            <textarea class="form-control" id="catatan" name="catatan" rows="3" placeholder="Berikan catatan untuk customer..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn" id="btn-confirm" onclick="processRequest()">Konfirmasi</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            loadRequests();
        });

        function loadRequests() {
            $.ajax({
                url: 'api/admin-kelola-request.php',
                type: 'GET',
                success: function(response) {
                    const data = JSON.parse(response);
                    if (data.success) {
                        displayRequests(data.requests);
                        updateStatistics(data.requests);
                    } else {
                        alert('Error: ' + data.message);
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan sistem');
                }
            });
        }

        function displayRequests(requests) {
            let rows = '';
            requests.forEach(function(req) {
                const selisihHarga = req.harga_baru - req.harga_lama;
                const selisihClass = selisihHarga > 0 ? 'text-success' : 'text-danger';
                const jenisClass = req.jenis_request === 'upgrade' ? 'success' : 'warning';
                
                rows += `
                    <tr>
                        <td>${formatDate(req.tanggal_request)}</td>
                        <td>
                            <strong>${req.customer_name}</strong><br>
                            <small class="text-muted">ID: ${req.id_customer}</small>
                        </td>
                        <td>
                            ${req.no_hp}<br>
                            <small>${req.email}</small>
                        </td>
                        <td>
                            ${req.paket_lama}<br>
                            <small class="text-muted">Rp ${req.harga_lama.toLocaleString()}</small>
                        </td>
                        <td>
                            ${req.paket_baru}<br>
                            <small class="text-muted">Rp ${req.harga_baru.toLocaleString()}</small>
                        </td>
                        <td><span class="badge bg-${jenisClass}">${req.jenis_request}</span></td>
                        <td class="${selisihClass}">
                            <strong>${selisihHarga > 0 ? '+' : ''}Rp ${selisihHarga.toLocaleString()}</strong>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-info" onclick="showAlasan('${req.alasan_request}')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-success" onclick="showModal(${req.id_request}, 'approve', '${req.customer_name}', '${req.paket_lama}', '${req.paket_baru}', '${req.jenis_request}')">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="showModal(${req.id_request}, 'reject', '${req.customer_name}', '${req.paket_lama}', '${req.paket_baru}', '${req.jenis_request}')">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            });
            $('#table-requests tbody').html(rows);
        }

        function updateStatistics(requests) {
            $('#pending-count').text(requests.length);
            $('#total-count').text(requests.length);
            // Note: approved and rejected counts would need separate API call for historical data
        }

        function showAlasan(alasan) {
            alert('Alasan Customer:\n\n' + alasan);
        }

        function showModal(id, action, customer, paketLama, paketBaru, jenis) {
            $('#request-id').val(id);
            $('#action-type').val(action);
            $('#customer-info').text(customer);
            $('#request-info').text(`${jenis.toUpperCase()}: ${paketLama} → ${paketBaru}`);
            
            if (action === 'approve') {
                $('#modalTitle').text('Setujui Request');
                $('#btn-confirm').removeClass('btn-danger').addClass('btn-success').text('Setujui');
            } else {
                $('#modalTitle').text('Tolak Request');
                $('#btn-confirm').removeClass('btn-success').addClass('btn-danger').text('Tolak');
            }
            
            $('#modalProcess').modal('show');
        }

        function processRequest() {
            const formData = new FormData($('#form-process')[0]);
            
            $.ajax({
                url: 'api/admin-kelola-request.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    const data = JSON.parse(response);
                    if (data.success) {
                        alert('Request berhasil diproses!');
                        $('#modalProcess').modal('hide');
                        $('#form-process')[0].reset();
                        loadRequests();
                    } else {
                        alert('Error: ' + data.message);
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan sistem');
                }
            });
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID') + '<br><small>' + date.toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'}) + '</small>';
        }
    </script>
</body>
</html>