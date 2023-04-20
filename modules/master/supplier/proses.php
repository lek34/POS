
<?php
session_start();

// Panggil koneksi database.php untuk koneksi database
require_once "../../../config/database.php";

// fungsi untuk pengecekan status login user 
// jika user belum login, alihkan ke halaman login dan tampilkan pesan = 1
require_once "../../../auth/cek.php";
// jika user sudah login, maka jalankan perintah untuk insert, update, dan delete
    if ($_GET['act']=='insert') {
        if (isset($_POST['addSup'])){
            $nama = mysqli_real_escape_string($conn, trim($_POST['nama']));
            $kontak  = mysqli_real_escape_string($conn, trim($_POST['kontak']));
            $keterangan = mysqli_real_escape_string($conn, trim($_POST['keterangan']));
            $alamat = mysqli_real_escape_string($conn, trim($_POST['alamat']));

            $query = "INSERT INTO supplier (nama, kontak, keterangan, alamat) VALUES ('$nama', '$kontak', '$keterangan', '$alamat')";
            $execQuery = mysqli_query($conn, $query);

            if ($execQuery){
                echo 'completed';
                header('location: ../../../main.php?module=dataSup');
            } else {
                echo
                "<script>
                alert ('Data gagal ditambahkan')
                </script>";
                header('location:modules/master/supplier/view.php');
            }
        }
    }
    elseif ($_GET['act']=='update') {
        if (isset($_POST['editSUp'])){

        }
        
    }
    elseif ($_GET['act']=='delete') {
        if (isset($_POST['delSup'])){
            
        }
    }
?>
