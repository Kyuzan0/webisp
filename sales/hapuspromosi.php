<?php 
require '../includes/functions.php';

$id = $_GET["id_promosi"];

if( hapuspromosi($id) > 0 ) {
    echo "
            <script>
                alert('data berhasil dihapus!');
                document.location.href = 'datapromo.php'
            </script>
        ";

} else {
    echo "
            <script>
                alert('data gagal dihapus!');
                document.location.href = 'datapromo.php'
            </script>
        ";
}

?>