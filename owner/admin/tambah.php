<?php  
session_start();
require '../../function.php';
if (!isset($_SESSION['login'])) {
    header('Location: ../../login.php');
    exit;
}

if (isset($_SESSION['login'])) {
    if($_SESSION['role'] == 'Admin'){
        header("Location: ../../admin/transaksi/index.php");
    }
}
if (isset($_POST["submit"])) {
	if (regis($_POST) > 0 ) {
        if (tambahAdmin($_POST) > 0 ) {
            echo "<script type='text/javascript'>
                alert('Data Berhasil Di Tambah');
                window.location.href = 'index.php';
            </script>";
        }
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
    <title>Owner - Tambah - Admin</title>
    <link rel="stylesheet" href="../../css/style2.css">
</head>
<body>
    <header>
        <div class="logo-box">
            <p class="logo">Warunk Makan Istiqomah</p>
        </div>
    </header>
    
    <main class="form-regis">
        <div class="box">
            <h1>TAMBAH DATA</h1><br>
            <form action="" method="post">
                <input class="input-box" type="tesxt" name="username" autocomplete="off" autofocus required placeholder="Username"><br><br>
                <input class="input-box" type="password" name="password" autocomplete="off" required placeholder="Password"><br><br>
                <input class="input-box" type="password" name="password2" autocomplete="off" required  placeholder="Konfirmasi Password"><br><br>
                <input class="input-box" type="text" name="nama" autocomplete="off" required  placeholder="Nama Admin"><br><br>
                <input class="input-box" type="text" name="notelp" autocomplete="off" required  placeholder="Nomor Telepon"><br><br>
                <input class="input-box" type="email" name="email" autocomplete="off" required  placeholder="Email"><br><br>
                <input type="radio" checked name="role" value="Admin"  required><label>Admin</label><br><br>
                <button class="btn" type="submit" name="submit">Tambah</button><br><br>
                <button class="btn" onclick="window.location.href='index.php'">Kembali</button>
            </form>
        </div>
    </main>
</body>
</html>