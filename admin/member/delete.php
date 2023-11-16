<?php  
require '../../function.php';
$id = $_GET["id"];

if (deleteMember($id) > 0) {
    echo "
    <script>
        alert('Data Berhasil Di Hapus');
        window.location.href = 'index.php';
    </script>";
} else {
    echo "<script type='text/javascript'>
        alert('Data Gagal Di Hapus');
        window.location.href = 'index.php';
    </script>";	
}
?>