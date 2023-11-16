<?php 
require '../../function.php';

$limit = 5;

$page = 1;

if ($_POST['page'] > 1) {
    $start = (($_POST['page'] - 1) *$limit);
    $page = $_POST['page'];
}else {
    $start=0;
}

$query = "SELECT user.username, user.id_user, nama_adm, id_adm, nomor_telp_adm, email_adm 
            FROM admin JOIN user ON admin.id_user = user.id_user ";

if ($_POST['query'] != '') {
    $query .= '
        WHERE user.username LIKE "%'.$_POST['query'].'%" OR 
        nomor_telp_adm LIKE "%'.$_POST['query'].'%" OR 
        nama_adm LIKE "%'.$_POST['query'].'%" 
    ';
}

if ($_POST['sort'] != ''){
    $query .= 'ORDER BY '.$_POST['sort'].' ASC';
}else {
    $query .= 'ORDER BY id_adm ASC';
}

$filter_query = $query .' LIMIT '.$start.' , '.$limit;

$statement = mysqli_prepare($conn, $query); 

$statement = mysqli_query($conn, $query);

$total_data = mysqli_num_rows($statement);

$statement = mysqli_prepare($conn, $filter_query);

$fecth = mysqli_query($conn, $filter_query);

$result = mysqli_fetch_all($fecth, MYSQLI_ASSOC);

$output = '
    <table class="tabel">
    <tr>
        <th>No</th>
        <th>Username</th>
        <th>Nama</th>
        <th>No Handphone</th>
        <th>Action</th>
    </tr>
';

if ($total_data>0) {
    $i = 1;
	foreach($result as $row){
        $output .='     
            <tr>
                <td>'.$i.'</td>
                <td>'.$row["username"].'</td>
                <td>'.$row["nama_adm"].'</td>
                <td>'.$row["nomor_telp_adm"].'</td>
                <td>
                    <a class="btn" href="update.php?id='.$row['id_adm'].'">Ubah</a>
                    <a class="btn" href="delete.php?id='.$row['id_user'].'" onclick="return confirm(\'Apakah Anda Ingin Mengahpus Data\')">Hapus</a>
                </td>
            </tr>
            ';
        $i++;
    }
}else {
    $output .= '
    <tr>
        <td colspan="5" align="center">Data Tidak Ditemukan !!!</td>
    </tr>
    ';
}

$output .='
    </table>
    <br>
    <div align="center" id="page">
        <ul class="pagination">
';

$total_links = ceil($total_data/$limit);

$previous_link = '';

$next_link = '';

$page_link = '';

if ($total_links > 4) {
    if ($page < 5) {
        for ($count = 1; $count <= 5; $count++){
            $page_array[] = $count;
        }
        $page_array[] = '...';
        $page_array[] = $total_links;
    }else {
        $end_limit = $total_links - 5;
        if ($page > $end_limit) {
            $page_array[] = 1;
            $page_array[] = '...';
            for ($count = $end_limit; $count <= $total_links; $count++){
                $page_array[] = $count;
            }
        }else {
            $page_array[] = 1;
            $page_array[] = '...';
            for ($count = $page-1; $count <= $page; $count++){
                $page_array[] = $count;

            }
            $page_array[] = '...';
            $page_array[] = $total_links;
        }
    }
}else {
    for ($count = 1; $count <= $total_links; $count++){
        $page_array[] = $count;
    }
}

for($count = 0; $count< count($page_array); $count++){
    if ($page == $page_array[$count]) {
        $page_link .='
            <li class="page-item active disabled">
                <a href="#" class="page-link">'.$page_array[$count].'</a>
            </li>
        ';
        $previous_id = $page_array[$count] - 1;
        if ($previous_id > 0) {
            $previous_link .='
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0)" data-page_number="'.$previous_id.'">Previous</a>
                </li>';
        }else {
            $previous_link .= '
            <li class="page-item disabled">
                <a href="#" class="page-link">Previous</a>
            </li>
            ';        
        }
        $next_id = $page_array[$count] + 1;
        if ($next_id > $total_links) {
            $next_link .= '
            <li class="page-item disabled">
                <a href="#" class="page-link">Next</a>
            </li>
            ';
        }else {
            $next_link .= '
            <li class="page-item">
                <a class="page-link" href="javascript:void(0)" data-page_number="'.$next_id.'">Next</a>
            </li>';
        }
    } else {
        if ($page_array[$count] == '...') {
            $page_link .='
            <li class="page-item disabled">
                <a href="#" class="page-link">...</a>
            </li>';
        }else {
            $page_link .='
            <li class="page-item">
                <a class="page-link" href="javascript:void(0)" data-page_number="'.$page_array[$count].'">'.$page_array[$count].'</a>
            </li>';
        }
    }
}

$output .= $previous_link . $page_link . $next_link;

echo $output;
?>