<?php 
require '../includes/functions.php';

$id = $_GET["id_keluhan"];

if( hapuskeluhan($id) > 0 ) {
    echo "
            <script>
                alert('data berhasil dihapus!');
                document.location.href = 'daftarkeluhan.php'
            </script>
        ";

} else {
    echo "
            <script>
                alert('data gagal dihapus!');
                document.location.href = 'daftarkeluhan.php'
            </script>
        ";
}

?>