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
if (isset($_POST["submit"])) {
	if (tambahMember($_POST) > 0 ) {
		echo "<script type='text/javascript'>
                alert('Data Berhasil Di Tambah');
                window.location.href = 'index.php';
            </script>";
	} else {
		echo "<script type='text/javascript'>
                alert('Data Gagal Di Tambah');
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
    <title>Admin - Tambah - Member</title>
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
            <h1>TAMBAH DATA</h1><br>
            <form action="" method="post">
                <input class="input-box" type="text" name="nama" autofocus placeholder="Nama Member" required autocomplete="off"><br><br>
                <input class="input-box" type="text" name="notelp" placeholder="Nomor Telepon..." required autocomplete="off"><br><br>
                <input class="#" type="radio" name="status" value="Member" checked>
                <label for="Ya">Ya</label><br><br>
                <button class="btn" type="submit" name="submit">Tambah</button><br><br>
            </form>
        </div>
    </main>
</body>
</html>