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
$id = $_GET['id'];
// Query Transaksi1
$transaksi = query("SELECT transaksi.total_pemb, quantity, total_harga, menu.nama_menu, menu.harga_menu, 
                transaksi_detail.id_trans FROM transaksi_detail 
                JOIN menu ON transaksi_detail.id_menu = menu.id_menu 
                JOIN transaksi ON transaksi_detail.id_trans = transaksi.id_trans WHERE transaksi_detail.id_trans = $id");
// Query Transaksi2
$transaksi2 = query("SELECT member.nama_mem, id_trans, admin.nama_adm, tanggal_trans, total_pemb, waktu_trans 
                FROM transaksi 
                JOIN member ON transaksi.id_mem = member.id_mem 
                JOIN admin ON transaksi.id_adm = admin.id_adm WHERE id_trans = $id")[0];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Kasih!</title>
    <link rel="stylesheet" href="../../css/invoice.css">
</head>
<body>
    <main>
        <div class="container">
            <div class="logo-box">
                <p class="logo">Warunk Makan Istiqomah</p>
            </div>
            <div class="box">
                <div class="top-cont">
                    <h1>Terima Kasih, <?= $transaksi2['nama_mem']?> !</h1>
                    <p></p>
                    <p>Nomor Pesanan : <?= $transaksi2['id_trans']?> </p>
                    <p>Tanggal Transaksi : <?= $transaksi2['tanggal_trans']?> | <?= $transaksi2['waktu_trans']?></p>
                    <p>Admin : <?= $transaksi2['nama_adm']?> </p>
                </div>
                <table>
                    <tr>
                        <th class="col1">Menu</th>
                        <th class="col2">Jumlah</th>
                        <th class="col3">Harga</th>
                        <th class="col4">Total Harga</th>

                    </tr>
                    <?php foreach ($transaksi as $row):?>
                    <tr>
                        <td class="col1"><?= $row['nama_menu']?></td>
                        <td class="col2"><?= $row['quantity']?></td>
                        <td class="col3"><?= $row['harga_menu']?></td>
                        <td class="col4"><?= $row['total_harga']?></td>
                    </tr>
                    <?php endforeach;?>
                    <tr class="total">
                        <td class="col1" colspan="3">Total Harga</td>
                        <td class="col4"><?= $transaksi2['total_pemb']?></td>
                    </tr>
                </table>
            </div>
        </div>
    </main>
</body>
</html>