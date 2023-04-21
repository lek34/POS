
<?php
session_start();

// Panggil koneksi database.php untuk koneksi database
require_once "../../../config/database.php";

// fungsi untuk pengecekan status login user 
// jika user belum login, alihkan ke halaman login dan tampilkan pesan = 1
require_once "../../../auth/cek.php";
// jika user sudah login, maka jalankan perintah untuk insert, update, dan delete
    if ($_GET['act']=='insert') {
        if (isset($_POST['addAcc'])){
            $kode_akun = mysqli_real_escape_string($conn, trim($_POST['kode_akun']));
            $nama_akun  = mysqli_real_escape_string($conn, trim($_POST['nama_akun']));

            $query = "INSERT INTO akun (kode_akun, nama_akun) VALUES ('$kode_akun', '$nama_akun')";
            $execQuery = mysqli_query($conn, $query);

            if ($execQuery){
                header('location: ../../../main.php?module=noAcc&alert=1');
            } else {
                header('location: ../../../main.php?module=noAcc&alert=2');
            }
        }
    }
    elseif ($_GET['act']=='edit') {
        if (isset($_POST['editAcc'])){
            $id_akun = mysqli_real_escape_string($conn, trim($_POST['id_akun']));
            $kode_akun = mysqli_real_escape_string($conn, trim($_POST['kode_akun']));
            $nama_akun  = mysqli_real_escape_string($conn, trim($_POST['nama_akun']));

            $query = "UPDATE akun SET kode_akun = '$kode_akun', nama_akun = '$nama_akun' WHERE id_akun = '$id_akun'";
            $execQuery = mysqli_query($conn, $query);

            if ($execQuery){
                header('location: ../../../main.php?module=noAcc&alert=3');
            } else {
                header('location: ../../../main.php?module=noAcc&alert=4');
            }
        }
        
    }
    elseif ($_GET['act']=='delete') {
        if (isset($_POST['delSup'])){
            $id_sup = mysqli_real_escape_string($conn, trim($_POST['id_supplier']));

            $query = "DELETE FROM supplier WHERE id_supplier = '$id_sup'";
            $execQuery = mysqli_query($conn, $query);

            if ($execQuery){
                header('location: ../../../main.php?module=noAcc&alert=5');
            } else {
                header('location: ../../../main.php?module=noAcc&alert=6');
            }
        }
    }
?>
