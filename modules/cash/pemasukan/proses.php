<?php
    session_start();

    // Panggil koneksi database.php untuk koneksi database
    require_once "../../config/database.php";
    // fungsi untuk pengecekan status login user 
    // jika user belum login, alihkan ke halaman login dan tampilkan pesan = 1
    require_once "../../auth/cek.php";
    // jika user sudah login, maka jalankan perintah untuk insert, update, dan delete

    if($_GET['act'] == 'insertTempCashMasuk'){
        if(isset($_POST['insertTempCashMasuk'])){
            $no_bukti = mysqli_real_escape_string($conn, trim($_POST['no_bukti']));
            $tanggal_masuk = mysqli_real_escape_string($conn, trim($_POST['tanggal_masuk']));
            $no_jurnal = mysqli_real_escape_string($conn, trim($_POST['no_jurnal']));
        }
    }
?>