<?php
session_start();
require "../../function.php";
if (!isset($_SESSION['login'])) {
    header('Location: ../../login.php');
    exit;
}

if (isset($_SESSION['login'])) {
    if($_SESSION['role'] == 'Owner'){
        header("Location: ../../owner/transaksi/index.php");
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel - Transaksi</title>
    <link rel="stylesheet" href="../../css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js" type="text/javascript" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.css" integrity="sha512-p209YNS54RKxuGVBVhL+pZPTioVDcYPZPYYlKWS9qVvQwrlzxBxkR8/48SCP58ieEuBosYiPUS970ixAfI/w/A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
    <header>
        <div class="logo-box">
            <p><?= $_SESSION['name'];?></p>
            <p class="logo">Warunk Makan Istiqomah</p>
            <p><?= $_SESSION['role'];?></p>
        </div>
        <div class="navbar">
            <div class="choice">
                <ul>
                    <li><a href="../transaksi/index.php">Transaksi</a></li>
                    <li><a href="../menu/index.php">Menu</a></li>
                    <li><a href="../member/index.php">Member</a></li>
                    <div class="logout">
                        <li><a href="../../logout.php">Keluar</a></li>
                    </div>
                </ul>
            </div>
        </div>
    </header>

    <main>
        <div class="container">
            <a class="btn" href="tambah.php">Tambah</a>
            <input class="search-box" type="text" name="cari" id="search-box" placeholder="Cari...">
            <select class="select-box">
                <option value="">Sorting Descending</option>
                <option value="id_trans">ID Transaksi</option>
                <option value="member.nama_mem">Nama Member</option>
                <option value="admin.nama_adm">Nama Admin</option>
                <option value="tanggal_trans">Tanggal Transaksi</option>
            </select>
        </div>
    
        <div id="pagination">

        </div>
    </main>
    <script>
        $(document).ready(function(){
            function load_data(page, query = '', sort=''){
                $.ajax({
                    url:'../ajax/fetchTransaksi.php',
                    method:'POST',
                    data:{page:page, query:query, sort:sort},
                    success:function(data){
                        $('#pagination').html(data);
                    }
                })
            }
            load_data(1);
            $('#search-box').keyup(function(){
                var query = $('#search-box').val();
                var sort = $('.select-box').val();
                load_data(1, query, sort);
            });

            $(document).on('click','.page-link', function(){
                var page = $(this).data('page_number');
                var query = $('#search-box').val();
                var sort = $('.select-box').val();
                load_data(page, query, sort);
            });
            $(document).on('change','.select-box', function(){
                var query = $('#search-box').val();
                var sort = $(this).val();
                load_data(1, query,sort);
            });
        });
    </script>
    <footer>
        <p>Copyright © Warunk Makan Istiqomah. All rights reserved.</p>
    </footer>
</body>
</html>