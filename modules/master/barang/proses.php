
<?php
session_start();

// Panggil koneksi database.php untuk koneksi database
require_once "../../../config/database.php";

// fungsi untuk pengecekan status login user 
// jika user belum login, alihkan ke halaman login dan tampilkan pesan = 1
require_once "../../../auth/cek.php";
// jika user sudah login, maka jalankan perintah untuk insert, update, dan delete
    if ($_GET['act']=='insert') {
        if(isset($_POST['addnewbarang'])){
            $barang = mysqli_real_escape_string($conn, trim($_POST['barang']));
            $harga = mysqli_real_escape_string($conn, trim($_POST['harga']));
            $query = mysqli_query($conn,"INSERT INTO barang (idbarang, penerima, kondisi, quantity) value ('$barang', '$penerima', '$kondisi', '$qty')")
            or die('Ada kesalahan pada query insert : '.mysqli_error($conn));
            // cek query
            //if ($query) {
                // jika berhasil tampilkan pesan berhasil simpan data
                //header("location: ../../main.php?module=dataItem&alert=1");
            //}
        }
    }
    elseif ($_GET['act']=='update') {
        if(isset($_POST['editbarang'])){
            
        }
    }
    elseif ($_GET['act']=='delete') {
        if(isset($_POST['deletebarang'])){
            
        }
    }
?>