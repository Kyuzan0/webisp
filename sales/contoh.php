<?php
$paketPromo = [
    ["nama" => "Paket Internet Murah 5GB", "harga" => "Rp15.000", "masa_aktif" => "7 Hari"],
    ["nama" => "Paket Super Kuota 10GB", "harga" => "Rp25.000", "masa_aktif" => "15 Hari"],
    ["nama" => "Paket Unlimited Harian", "harga" => "Rp10.000", "masa_aktif" => "1 Hari"],
];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Daftar Promo Paket Internet</title>
    <style>
        table {
            width: 60%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        th, td {
            padding: 10px;
            border: 1px solid #aaa;
            text-align: center;
        }
        th {
            background-color: #f2b632;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Promo Paket Internet</h2>
    <table>
        <tr>
            <th>Nama Paket</th>
            <th>Harga</th>
            <th>Masa Aktif</th>
        </tr>
        <?php foreach ($paketPromo as $paket): ?>
        <tr>
            <td><?= $paket['nama'] ?></td>
            <td><?= $paket['harga'] ?></td>
            <td><?= $paket['masa_aktif'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>