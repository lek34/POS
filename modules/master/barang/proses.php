
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
            $barang = mysqli_real_escape_string($conn, trim($_POST['namabarang']));
            
            $query = "INSERT INTO barang (nama_barang) VALUES ('$barang')";
            $execQuery = mysqli_query($conn, $query);
            //or die('Ada kesalahan pada query insert : '.mysqli_error($conn));
            // cek query
            if ($execQuery) {
                //jika berhasil tampilkan pesan berhasil simpan data
                header("location: ../../../main.php?module=dataItem&alert=1");
            } else {
                header("location: ../../../main.php?module=dataItem&alert=2");
            }
        }
    }
    elseif ($_GET['act']=='edit') {
        if(isset($_POST['editbarang'])){
            $id_barang = mysqli_real_escape_string($conn, trim($_POST['id_barang']));
            $barang = mysqli_real_escape_string($conn, trim($_POST['namabarang']));
            $kuantitas = mysqli_real_escape_string($conn, trim($_POST['kuantitas']));
            
            $query = "UPDATE barang SET nama_barang = '$barang', kuantitas = '$kuantitas' WHERE id_barang = '$id_barang'";
            $execQuery = mysqli_query($conn, $query);
            //or die('Ada kesalahan pada query insert : '.mysqli_error($conn));
            if ($execQuery) {
                //jika berhasil tampilkan pesan berhasil simpan data
                header("location: ../../../main.php?module=dataItem&alert=3");
            } else {
                header("location: ../../../main.php?module=dataItem&alert=4");
            }
        }
    }
    elseif ($_GET['act']=='delete') {
        if(isset($_POST['deletebarang'])){
            $id_barang = mysqli_real_escape_string($conn, trim($_POST['id_barang']));
            
            $query = "UPDATE barang SET status = 'N' WHERE id_barang = '$id_barang'";
            $execQuery = mysqli_query($conn, $query);
            if($execQuery) {
                //jika berhasil tampilkan pesan berhasil simpan data
                header("location: ../../../main.php?module=dataItem&alert=5");
            } else {
                header("location: ../../../main.php?module=dataItem&alert=6");
            }
        }
    }
?>