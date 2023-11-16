<?php
require '../../function.php';

$id = $_POST['id'];

$sql = mysqli_query($conn, "SELECT * FROM menu WHERE id_menu = $id");

$data = mysqli_fetch_array($sql);
$id_menu = $data['id_menu'];
$nama = $data['nama_menu'];
$harga = $data['harga_menu'];
?>
<?='<tr>'?>
<?="<td>
        <input type='hidden' name='id[]' value='$id_menu'>
        <input  type='text' class='nama-barang' name='nama[]' readonly value='$nama' required autocomplete='off'>
    </td>
    <td>
        <input type='number' class='harga-barang' name='harga[]' readonly value='$harga' required autocomplete='off'> 
    </td>
    <td>
        <input type='number' name='qty[]' class='qty-barang' min='1' autocomplete='off'>
    </td>
    <td>
        <input type='text' name='total[]' class='total-barang' readonly>
    </td>
    <td><button type='button' class='btn-remove'>Hapus</button></td></tr>";?>
<?='</tr>'?>