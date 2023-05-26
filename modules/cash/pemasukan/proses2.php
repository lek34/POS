<?php
// jika user belum login, alihkan ke halaman login dan tampilkan pesan = 1
    require_once "../../../auth/cek.php";
    // jika user sudah login, maka jalankan perintah untuk insert, update, dan delete
    if($_GET['act'] == 'insertTempCashMasuk'){
        if(isset($_POST['insertTempCashMasuk'])){
            
            $nomor_bukti = mysqli_real_escape_string($conn, trim($_POST['no_bukti']));
            $id_akun  = mysqli_real_escape_string($conn, trim($_POST['id_akun']));

            if(!empty($_POST['targetPengeluaran'])){
                $id_customer = mysqli_real_escape_string($conn, trim($_POST['targetPengeluaran']));
                $ambilCustomer = "SELECT nama FROM customer WHERE $id_customer = id_customer";

            } else {
                $target_pengeluaran = mysqli_real_escape_string($conn, trim($_POST['targetPengeluaran2']));
            }
            $id_akun  = mysqli_real_escape_string($conn, trim($_POST['id_akun']));
            $kendaraan  = mysqli_real_escape_string($conn, trim($_POST['kendaraan']));
            $keterangan =  mysqli_real_escape_string($conn, trim($_POST['keterangan']));
            $jumlah =  mysqli_real_escape_string($conn, trim($_POST['jumlah']));

            $tanggal = $_POST['tanggal_masuk'];
            if(isset($_POST['barangPenjualan'])){
                $barang_penjualan = mysqli_real_escape_string($conn, trim($_POST['barangPenjualan']));
                $kuantitas = mysqli_real_escape_string($conn, trim($_POST['kuantitas']));

            $_SESSION['temp_cash_masuk'][] = array(
                'tanggal_masuk' => $tanggal,
                'id_customer' => $id_customer,
                'nomor_bukti' => $nomor_bukti,
                'target_pengeluaran' => $target_pengeluaran,
            );
            header('location: ../../../main.php?module=detailCashMasuk');
        }
    }

    elseif($_GET['act'] == 'insertCashMasuk') {
        if(isset($_POST['insertCashmasuk'])){

        }
     }
    }
?>