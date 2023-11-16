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
$member = query("SELECT * FROM member WHERE id_mem = $id")[0];
if (isset($_POST["submit"])) {
	if (updateMember($_POST) > 0 ) {
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
    <title>Admin - Update - Member</title>
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
                <input type="hidden" name="id" value="<?= $member['id_mem']?>">
                <input class="input-box" type="text" name="nama" autocomplete="off" required placeholder="Nama Member" value="<?= $member['nama_mem']?>"><br><br>
                <input class="input-box" type="text" name="notelp" autocomplete="off" required placeholder="Nomor Telepon..." value="<?= $member['nomor_telp_mem']?>"><br><br>
                <input class="#" type="radio" style="visibility: hidden;" name="status" value="Member" <?= $member['status'] == "Member" ? "checked" : "" ?>>
                <label style="visibility: hidden;" for="Ya">Ya</label><br><br>
                <button class="btn" type="submit" name="submit">Ubah</button><br><br>
            </form>
        </div>
    </main>
</body>
</html>