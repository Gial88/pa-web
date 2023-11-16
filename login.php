<?php  
session_start();
require 'function.php';
// cek cookie
if (isset($_COOKIE['login'])) {
	 if ($_COOKIE['login']== 'true') {
	 	$_SESSION['login'] = true; 
	 }
}

if (isset($_SESSION['login'])) {
    if($_SESSION['role'] == 'Admin'){
        header("Location: admin/transaksi/index.php");
    }else{
        header("Location: owner/transaksi/index.php");
    }
}

if (isset($_POST["login"])) {
	
	$username = $_POST['username'];
	$password = $_POST['password'];


	$result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

	// cek username
	if (mysqli_num_rows($result) === 1) {
		// cek password
		$row = mysqli_fetch_assoc($result);
		if ( password_verify($password, $row["password"])){
			// set session
			$_SESSION['login'] = true;
			$_SESSION['id'] = $row['id_user'];
            $id = $row['id_user'];
            $query = mysqli_query($conn, "SELECT * FROM admin WHERE id_user = '$id'");
            $result = mysqli_fetch_assoc($query);
            $_SESSION['name'] = $result['nama_adm'];
            $_SESSION['role'] = $row['status'];
			// cek remember me
			if (isset($_POST['remember'])) {
				setcookie('login', 'true', time()+3600);
			}

			if($_SESSION['role'] == 'Admin'){
                header("Location: admin/transaksi/index.php");
            }else{
                header("Location: owner/transaksi/index.php");
            }
		}
	}
	$error = true;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="logo-box">
            <p class="logo">Warunk Makan Istiqomah</a>
        </div>
    </header>
    <?php if(isset($error)): ?>
	<?php echo "
        <script type='text/javascript'>
            alert('Username / Password Salah');
        </script>
        "; ?>
    <?php endif; ?>
    <main>
        <div class="box">
            <h1>Login</h1><br>
            <form action="" method="post">
                <input class="input-box" type="text" name="username" placeholder="Username/email" autocomplete="off" required><br><br>
                <input class="input-box" type="password" name="password" placeholder="Password" autocomplete="off" required><br><br>
                <label>Remember Me</label>
	            <input type="checkbox" name="remember" id="remember"><br><br>
                <button class="btn" type="submit" name="login">Login</button><br>
            </form>
        </div>
    </main>
</body>
</html>