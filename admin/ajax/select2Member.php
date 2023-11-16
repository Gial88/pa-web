<?php
require '../../function.php';

if (!isset($_GET['searchTerm'])) {
    $json = [];
}else {
    $search = $_GET['searchTerm'];
    $query ='SELECT * FROM member WHERE nama_mem LIKE "%'.$search.'%" OR
            nomor_telp_mem LIKE "%'.$search.'%" LIMIT 5';
    $result = mysqli_query($conn, $query);
    $json = [];

    while($row = mysqli_fetch_assoc($result)){
        $json[] = ['id' => $row['id_mem'], 'text' => $row['nama_mem'] ]; 
    }
    echo json_encode($json);
}
?>