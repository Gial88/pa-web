<?php
require '../../function.php';

if (!isset($_GET['searchTerm'])) {
    $json = [];
}else {
    $search = $_GET['searchTerm'];
    $query ='SELECT * FROM menu WHERE nama_menu LIKE "%'.$search.'%" LIMIT 5';
    $result = mysqli_query($conn, $query);
    $json = [];

    while($row = mysqli_fetch_assoc($result)){
        $json[] = ['id' => $row['id_menu'], 'text' => $row['nama_menu']]; 
    }
    echo json_encode($json);
}
?>