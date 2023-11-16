<?php
$conn = mysqli_connect('localhost','root','','pa_web');

function query($query){
	global $conn;
	$result = mysqli_query($conn, $query);
		$rows = [];
	while ( $row = mysqli_fetch_assoc($result)) {
		$rows[]=$row;
	}
	return $rows;
}

function tambahMenu($data){
	global $conn;

	$nama = htmlspecialchars($data["nama"]);
	$harga = htmlspecialchars($data["harga"]);
	$jenis = htmlspecialchars($data["jenis"]);

	$query = "INSERT INTO menu VALUES 
			('','$nama','$harga','$jenis')";
			mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function deleteMenu($id){
	global $conn;
	$hasil = 0;
	$result = mysqli_query($conn, "SELECT id_menu FROM transaksi_detail WHERE id_menu = '$id'");
	$sum = mysqli_num_rows($result);
	if ($sum > 0) {
		echo"
			<script>
				alert('Data Tidak Dapat Dihapus, Karena Terhubung Dengan Data lainnya');
			</script>
		";
		$hasil--;
	}else{
		mysqli_query($conn, "DELETE FROM menu WHERE id_menu=$id");
		$hasil = mysqli_affected_rows($conn);
	}
	return $hasil;
}

function updateMenu($data){
	global $conn;

	$id = $data["id"];
	$nama = htmlspecialchars($data["nama"]);
	$harga = htmlspecialchars($data["harga"]);
	$jenis = htmlspecialchars($data["jenis"]);

	$query = "UPDATE menu SET
				nama_menu = '$nama', 
				harga_menu = '$harga',
				jenis = '$jenis'
				WHERE id_menu = $id ";
			mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

// Function untuk member
function tambahMember($data){
	global $conn;

	$nama = htmlspecialchars($data["nama"]);
	$notelp = htmlspecialchars($data["notelp"]);
	$status = htmlspecialchars($data["status"]);

	$query = "INSERT INTO member VALUES 
			('','$nama','$notelp','$status')";
			mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function deleteMember($id){
	global $conn;
	$result = mysqli_query($conn, "SELECT id_mem FROM transaksi WHERE id_mem = '$id'");
	$sum = mysqli_num_rows($result);
	if ($sum > 0) {
		echo"
			<script>
				alert('Data Tidak Dapat Dihapus, Karena Terhubung Dengan Data lainnya');
			</script>
		";
		return false;
	}else{
		mysqli_query($conn, "DELETE FROM member WHERE id_mem=$id");
		return mysqli_affected_rows($conn);
	}
	
}

function updateMember($data){
	global $conn;

	$id = $data["id"];
	$nama = htmlspecialchars($data["nama"]);
	$notelp = htmlspecialchars($data["notelp"]);
	$status = htmlspecialchars($data["status"]);

	$query = "UPDATE member SET
				nama_mem = '$nama', 
				nomor_telp_mem = '$notelp',
				status = '$status'
				WHERE id_mem = $id ";
			mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function regis($data){
	global $conn;

	$username = strtolower(stripcslashes($data["username"]));
	$password = mysqli_real_escape_string($conn, $data["password"]);
	$password2 = mysqli_real_escape_string($conn, $data["password2"]);
	$role = htmlspecialchars($data["role"]);


	// cek konfirmasi

	if ($password !== $password2) {
		echo "
			<script>
				alert('Password berbeda');
			</script>
		";
		return false;
	}

	//cek username ada apa belum
	$result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");

	if (mysqli_fetch_assoc($result)) {
		echo "
			<script>
				alert('Username Telah ada');
			</script>
		";
		return false;
	} 

	// enkripsi password
	$password = password_hash($password, PASSWORD_DEFAULT);


	// tambahkan user ke database
	mysqli_query($conn, "INSERT INTO user VALUES(
					'','$username','$password','$role')");
	return mysqli_affected_rows($conn);
}

function tambahAdmin($data){
	global $conn;

	$nama = htmlspecialchars($data["nama"]);
	$notelp = htmlspecialchars($data["notelp"]);
	$email = htmlspecialchars($data["email"]);
	$result = mysqli_query($conn, "SELECT id_user FROM user ORDER BY id_user DESC LIMIT 1");
	$row = mysqli_fetch_assoc($result);
	$id_user = $row['id_user'];
	$query = "INSERT INTO admin VALUES 
			('','$id_user','$nama','$notelp','$email')";
			mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);
}


function deleteAdmin($id){
	global $conn;
	mysqli_query($conn, "DELETE FROM admin WHERE id_user=$id");
	return mysqli_affected_rows($conn);
}

function deleteUser($id){
	global $conn;
	mysqli_query($conn, "DELETE FROM user WHERE id_user=$id");
	return mysqli_affected_rows($conn);
}

function updateAdmin($data){
	global $conn;

	$id_adm = $data["id_adm"];
	$id_user = $data["id_user"];
	$nama = htmlspecialchars($data["nama"]);
	$notelp = htmlspecialchars($data["notelp"]);
	$email = htmlspecialchars($data["email"]);

	$query = "UPDATE admin SET
				id_user = '$id_user',
				nama_adm = '$nama', 
				nomor_telp_adm = '$notelp',
				email_adm = '$email'
				WHERE id_adm = $id_adm";
			mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function regisEdit($data){
	global $conn;
	$id = $data['id_user'];
	$username = strtolower(stripcslashes($data["username"]));
	$password = mysqli_real_escape_string($conn, $data["password"]);
	$password2 = mysqli_real_escape_string($conn, $data["password2"]);
	$role = htmlspecialchars($data["role"]);


	// cek konfirmasi

	if ($password !== $password2) {
		echo "
			<script>
				alert('Password berbeda');
			</script>
		";
		return false;
	}

	//cek username ada apa belum
	$result1 = mysqli_query($conn,"SELECT username FROM user WHERE id_user = '$id'");
	$result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
	$row = mysqli_fetch_assoc($result1);
	if ($row['username'] != $username) {
		if (mysqli_fetch_assoc($result)) {
			echo "
				<script>
					alert('Username Telah ada');
				</script>
			";
			return false;
		}
	}

	// enkripsi password
	$password = password_hash($password, PASSWORD_DEFAULT);


	// tambahkan user ke database
	mysqli_query($conn, "UPDATE user SET
						username = '$username',
						password = '$password',
						status = '$role' 
						WHERE id_user = $id");
	return mysqli_affected_rows($conn);
}

function tambahTransaksi($data){
	global $conn;
	date_default_timezone_set('Asia/Jakarta');
	// $id_adm = $data["id_adm"];
	$member = $data["member"];
	$admin = $data["admin"];
	$result2 = mysqli_query($conn, "SELECT id_adm FROM admin WHERE id_user = '$admin'");
	$row2 = mysqli_fetch_assoc($result2);
	$id_admin = $row2['id_adm'];
	$id_member = $data['member'];
	$tanggal = date('Y-m-d');
	$waktu = date('H:i:s');
	$total_pem = htmlspecialchars($data["total_pem"]);

	$query = "INSERT INTO transaksi VALUES
					('','$id_member','$id_admin','$tanggal','$waktu','$total_pem')";
					mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);
}

function tambahTransaksiDetail($data){
	global $conn;
	date_default_timezone_set('Asia/Jakarta');
	// $id_adm = $data["id_adm"];
	$id_menu = $data['id'];
	$qty = $data["qty"];
	$total= $data['total'];
	$result = mysqli_query($conn, "SELECT id_trans FROM transaksi ORDER BY id_trans DESC LIMIT 1");
	$row = mysqli_fetch_assoc($result);
	$id_trans = $row['id_trans'];
	$i = 0;
	foreach ($id_menu as $row => $val) {
		$query = "INSERT INTO transaksi_detail VALUES
					('','$id_trans','$id_menu[$i]','$qty[$i]','$total[$i]')";
					mysqli_query($conn, $query);
	$i++;
	}
	return mysqli_affected_rows($conn);
}

?>