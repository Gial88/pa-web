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
$admin = query("SELECT * FROM admin JOIN user ON admin.id_user=user.id_user WHERE id_adm=$id")[0];
if (isset($_POST["submit"])) {
	if (regisEdit($_POST) > 0 ) {
		if (updateAdmin($_POST)  >0 ) {
            echo "<script type='text/javascript'>
                alert('Data Berhasil Di Ubah');
                window.location.href = 'index.php';
            </script>";
        }
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
    <title>Owner - Ubah - Admin</title>
    <link rel="stylesheet" href="../../css/style2.css">
</head>
<body>
    <header>
        <div class="logo-box">
            <p class="logo">Warunk Makan Istiqomah</p>
        </div>
    </header>
    
    <main>
        <div class="box">
            <h1>TAMBAH DATA</h1><br>
            <form action="" method="post">
                <input type="hidden" name="id_user" value="<?= $admin['id_user'];?>">
                <input type="hidden" name="id_adm" value="<?= $admin['id_adm'];?>">
                <input class="input-box" type="tesxt" name="username" autocomplete="off" required placeholder="Username" value="<?= $admin['username'];?>"><br><br>
                <input class="input-box" type="password" name="password" autocomplete="off" required placeholder="Password"><br><br>
                <input class="input-box" type="password" name="password2" autocomplete="off" required  placeholder="Konfirmasi Password"><br><br>
                <input class="input-box" type="text" name="nama" autocomplete="off" required  placeholder="Nama Admin" value="<?= $admin['nama_adm'];?>"><br><br>
                <input class="input-box" type="text" name="notelp" autocomplete="off" required  placeholder="Nomor Telepon" value="<?= $admin['nomor_telp_adm'];?>"><br><br>
                <input class="input-box" type="email" name="email" autocomplete="off" required  placeholder="Email" value="<?= $admin['email_adm'];?>"><br><br>
                <input type="radio" name="role" value="Admin" checked required><label>Admin</label><br><br>
                <button class="btn" type="submit" name="submit">Ubah</button><br><br>
            </form>
        </div>
    </main>
</body>
</html>