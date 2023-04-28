
<?php
session_start();

// Panggil koneksi database.php untuk koneksi database
require_once "../../../config/database.php";

// fungsi untuk pengecekan status login user 
// jika user belum login, alihkan ke halaman login dan tampilkan pesan = 1
require_once "../../../auth/cek.php";

// jika user sudah login, maka jalankan perintah untuk insert, update, dan delete
    if ($_GET['act']=='insert') {
        if(isset($_POST['addnewjasa'])){
            $jasa = mysqli_real_escape_string($conn, trim($_POST['namajasa']));
            //check data ada atau tidak
            $check = "SELECT * FROM jasa WHERE nama_jasa = '$jasa'";
            $result = mysqli_query($conn, $check);
            if (mysqli_num_rows($result) <= 0) {
                $query = "INSERT INTO jasa (nama_jasa) VALUES ('$jasa')";
                $execQuery = mysqli_query($conn, $query);
                if ($execQuery) {
                    //jika berhasil tampilkan pesan berhasil simpan data
                    header("location: ../../../main.php?module=dataJasa&alert=1");
                } else {
                    header("location: ../../../main.php?module=dataJasa&alert=2");
                }
            }
            else {
                header("location: ../../../main.php?module=dataJasa&alert=8");
            }
            //or die('Ada kesalahan pada query insert : '.mysqli_error($conn));
            // cek query
        }
    }
    elseif ($_GET['act']=='edit') {
        if(isset($_POST['editbarang'])){
            $id_jasa = mysqli_real_escape_string($conn, trim($_POST['id_jasa']));
            $jasa = mysqli_real_escape_string($conn, trim($_POST['namajasa']));
            
            $query = "UPDATE hasa SET nama_jasa = '$jasa'";
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
        if(isset($_POST['deletejasa'])){
            $id_jasa = mysqli_real_escape_string($conn, trim($_POST['id_jasa']));
            
            $query = "UPDATE jasa SET status = 'N' WHERE id_jasa= '$id_jasa'";
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