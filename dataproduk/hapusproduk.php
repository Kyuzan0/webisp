<?php 
require '../includes/functions.php';

$id = $_GET["id_produk"];

if( hapuspaket($id) > 0 ) {
    echo "
            <script>
                alert('data berhasil dihapus!');
                document.location.href = 'dataproduk.php'
            </script>
        ";

} else {
    echo "
            <script>
                alert('data gagal dihapus!');
                document.location.href = 'dataproduk.php'
            </script>
        ";
}

?>