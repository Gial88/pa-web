<?php
session_start();
require "../../function.php";
if (!isset($_SESSION['login'])) {
    header('Location: ../../login.php');
    exit;
}

if (isset($_SESSION['login'])) {
    if($_SESSION['role'] == 'Admin'){
        header("Location: ../../admin/transaksi/index.php");
    }
}
$id = $_GET['id'];
$transaksi = query("SELECT quantity, total_harga, menu.nama_menu, menu.harga_menu, id_trans FROM transaksi_detail 
                JOIN menu ON transaksi_detail.id_menu = menu.id_menu WHERE id_trans = $id");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner - Detail Transaksi</title>
    <link rel="stylesheet" href="../../css/style2.css">
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
                    <li><a href="../admin/index.php">Admin</a></li>
                    <div class="logout">
                        <li><a href="../../logout.php">Keluar</a></li>
                    </div>
                </ul>
            </div>
        </div>
    </header>

    <main>
    <button class="btn" onclick="window.location.href='index.php'">Kembali</button>
        <table class="tabel">
            <tr>
                <th>No</th>
                <th>Menu</th>
                <th>Jumlah Pesanan</th>
                <th>Harga</th>
                <th>Total</th>  
            </tr>
        <?php $i = 1; ?>
		<?php foreach($transaksi as $row):?>
            <tr>
                <td><?= $i ;?></td>
                <td><?= $row["nama_menu"]; ?></td>
                <td><?= $row["quantity"]; ?></td>
                <td><?= $row["harga_menu"]; ?></td>
                <td><?= $row["total_harga"]; ?></td>
            </tr>
        <?php $i++; ?>
        <?php endforeach;?>
        </table>
    </div>
    </main>

    <footer>
        <p>Copyright © Warunk Makan Istiqomah. All rights reserved.</p>
    </footer>
</body>
</html>