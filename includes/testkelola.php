<?php 
// koneksi ke database
require 'functions.php';
$users = query("SELECT * FROM users")
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halam Admin</title>
</head>
<body>
    
<h1>Data User</h1>

<a href="tambah.php">Tambah data user</a>
<br><br>

<table border="1" cellpadding="10" cellspacing="0" >

    <tr>
        <th>No. </th>
        <th>Aksi</th>
        <th>id_user</th>
        <th>username</th>
        <th>password</th>
        <th>level</th>
    </tr>

<?php $i = 1; ?>
<?php foreach( $users as $row ) : ?>

    <tr>
        <td><?= $i;?></td>
        <td>
            <a href="">ubah</a> |
            <a href="">hapus</a>
        </td>
        <td><?= $row["id_user"];?></td>
        <td><?= $row["username"];?></td>
        <td><?= $row["password"];?></td>
        <td><?= $row["level"];?></td>
    </tr>
<?php $i++; ?>
<?php endforeach; ?>

</table>

</body>
</html>