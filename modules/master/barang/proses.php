
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