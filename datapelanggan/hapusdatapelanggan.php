<?php 
require '../includes/functions.php';

$id = $_GET["id_customer"];

if( hapuspelanggan($id) > 0 ) {
    echo "
            <script>
                alert('data berhasil dihapus!');
                document.location.href = 'keloladatapelanggan.php'
            </script>
        ";

} else {
    echo "
            <script>
                alert('data gagal dihapus!');
                document.location.href = 'keloladatapelanggan.php'
            </script>
        ";
}

?>