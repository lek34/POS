<?php
    session_start();

    // Panggil koneksi database.php untuk koneksi database
    require_once "../../../config/database.php";
    // fungsi untuk pengecekan status login user 
    // jika user belum login, alihkan ke halaman login dan tampilkan pesan = 1
    require_once "../../../auth/cek.php";
    // jika user sudah login, maka jalankan perintah untuk insert, update, dan delete
    echo'test 1';
    if($_GET['act'] == 'insertTempCashMasuk'){
        echo'test 2';
        if(isset($_POST['insertTempCashMasuk'])){
            echo'test 3';
            $nomor_bukti = mysqli_real_escape_string($conn, trim($_POST['no_bukti']));
            $target_pengeluaran = mysqli_real_escape_string($conn, trim($_POST['targetPengeluaran']));
            $id_akun  = mysqli_real_escape_string($conn, trim($_POST['id_akun']));
            $kendaraan  = mysqli_real_escape_string($conn, trim($_POST['kendaraan']));
            $keterangan =  mysqli_real_escape_string($conn, trim($_POST['keterangan']));
            $jumlah =  mysqli_real_escape_string($conn, trim($_POST['jumlah']));
            

            $_SESSION['temp_cash_masuk'][] = array(
                'nomor_bukti' => $nomor_bukti,
                'target_pengeluaran' => $target_pengeluaran,
                'id_akun' => $id_akun,
                'kendaraan' => $kendaraan,
                'keterangan' => $keterangan,
                'jumlah' => $jumlah,
            );
        }
        header('location: ../../../main.php?module=detailCashMasuk');
    }
?>