<?php 
session_start(); 
require '../../function.php';
if (!isset($_SESSION['login'])) {
    header('Location: ../../login.php');
    exit;
}

if (isset($_SESSION['login'])) {
    if($_SESSION['role'] == 'Owner'){
        header("Location: ../../owner/transaksi/index.php");
    }
}
$id = $_GET["id"];
$menu = query("SELECT * FROM menu WHERE id_menu = $id")[0];
if (isset($_POST["submit"])) {
	if (updateMenu($_POST) > 0 ) {
		echo "<script type='text/javascript'>
                alert('Data Berhasil Di Ubah');
                window.location.href = 'index.php';
            </script>";
	} else {
		echo "<script type='text/javascript'>
                alert('Data Gagal Di Ubah');
            </script>";	
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Ubah - Menu</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
    <header>
        <div class="logo-box">
            <p><?= $_SESSION['name'];?></p>
            <p class="logo">Warunk Makan Istiqomah</p>
            <p><?= $_SESSION['role'];?></p>
        </div>
    </header>
    
    <main>
    <button class="btn" onclick="window.location.href='index.php'">Kembali</button>
        <div class="box">
            <h1>UBAH DATA</h1><br>
            <form action="" method="post">
                <input type="hidden" name="id" value="<?= $menu['id_menu']?>">
                <input class="input-box" type="text" name="nama" value="<?= $menu['nama_menu']?>" autocomplete="off" placeholder="Nama Menu" required><br><br>
                <input class="input-box" type="number" name="harga" placeholder="Harga Menu" required autocomplete="off" value="<?= $menu['harga_menu']?>"><br><br>
                <label for="">Jenis Menu</label><br>
                <input type="radio" name="jenis" value="Makanan" <?= $menu['jenis'] == "Makanan" ? "checked" : "" ?>><label>Makanan</label><br>
                <input type="radio" name="jenis" value="Minuman" <?= $menu['jenis'] == "Minuman" ? "checked" : "" ?>><label>Minuman</label><br>
                <button class="btn" type="submit" name="submit">Ubah</button><br><br>
            </form>
        </div>
    </main>
</body>
</html>