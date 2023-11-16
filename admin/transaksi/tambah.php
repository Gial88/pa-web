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
	if (tambahTransaksi($_POST) > 0 ) {
		if (tambahTransaksiDetail($_POST) > 0 ) {
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

$menu = query("SELECT * FROM menu ORDER BY jenis");
$member = query("SELECT * FROM member ORDER BY id_mem");
$admin = $_SESSION['name'];
$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Tambah - Menu</title>
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
    </header>
    
    <main>
    <button class="btn" onclick="window.location.href='index.php'">Kembali</button>
        <center><h1>TAMBAH DATA</h1></center><br>
        <form action="" method="post">
        <input type="hidden" name='admin' value="<?= $_SESSION['id'];?>">
        <div class="container" style="margin-bottom: 10px;">
            <label for="">Member : </label>
            <select class="member" name="member" style="width: 250px;" autofocus ></select>
            |
            <label for="">Menu : </label>
            <select class="sltmenu" style="width: 250px;"></select>
        </div>
            <table class="tabel" id="table-transaksi" style="overflow:auto;">
                <thead>
                    <tr>
                        <th>Nama Makanan</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Total Harga</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
                <tbody style="height:50px">
                    <tr>
                        <td colspan="2"></td>
                        <td>Total Pembayaran</td>
                        <td style="display: flex; border:none"><p>Rp.</p><input type="number" name="total_pem" class="total-pem" readonly style="width: 100%;"></td>
                    </tr>
                </tbody>
            </table>
            <br>
            <center><button class="btn" type="submit" name="submit">Submit</button></center>
        </form>
    </main>
    <script type='text/javascript'>
        $(document).ready(function(){
            $(".total-pem").val(0);
            $('.sltmenu').prop('disabled', true);
            $(document).on('change','.sltmenu', function(){
                const id_menu = $(this).val();
                $.ajax({
                    url:'../ajax/getMenu.php',
                    type: 'post',
                    data:{id: id_menu}
                })
                .done(function(data){
                    $('.tabel').append(data);
                    console.log("success");
                })
                .fail(function(){
                    console.log("error");
                })
                .always(function(){
                    console.log("complete");
                });
            });
            $(document).on('click', '.btn-remove', function(){
                var kurang = 0;
                $(this).closest("tr").remove();
                var total = $(this).closest("tr").find('.total-barang').val();
                kurang = $(".total-pem").val() - total;
                $(".total-pem").val(kurang);
				});
			$(document).on('keyup','.qty-barang', function(){
				var harga = $(this).closest("tr").find('.harga-barang').val();
				var jumlah = $(this).val();
                var sum=0;
				var total = Number(harga) * Number(jumlah);
				$(this).closest("tr").find('.total-barang').val(total);
                $(".total-barang").each(function(){
                    sum += +$(this).val();
                });
                $(".total-pem").val(sum);
				});
            $(document).on('change', '.member', function(){
                $('.sltmenu').prop('disabled', false);
            });
            $('.sltmenu').select2({
                placeholder:'Masukkan Nama Menu',
                ajax:{
                    url:'../ajax/select2Menu.php',
                    dataType:'json',
                    delay: 250,
                    data: function(data){
                        return{
                            searchTerm: data.term
                        };
                    },
                    processResults: function(response){
                        return{
                            results:response
                        };
                    },
                    cache: true
                } 
            });
            $('.member').select2({
                placeholder:'Masukkan Nama Menu',
                ajax:{
                    url:'../ajax/select2Member.php',
                    dataType:'json',
                    delay: 250,
                    data: function(data){
                        return{
                            searchTerm: data.term
                        };
                    },
                    processResults: function(response){
                        return{
                            results:response
                        };
                    },
                    cache: true
                } 
            });
        });
    </script>
</body>
</html>