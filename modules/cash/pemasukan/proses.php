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
            if(!empty($_POST['targetPengeluaran'])){
                $id_customer = mysqli_real_escape_string($conn, trim($_POST['targetPengeluaran']));
                $ambilCustomer = "SELECT nama FROM customer WHERE $id_customer = id_customer";
                $queryAmbilCustomer = mysqli_query($conn, $ambilCustomer);
                $fetchCustomer = mysqli_fetch_array($queryAmbilCustomer);
                $nama_customer = $fetchCustomer['nama'];
                $target_pengeluaran = $nama_customer;
            } else {
                $target_pengeluaran = mysqli_real_escape_string($conn, trim($_POST['targetPengeluaran2']));
            }
            $id_akun  = mysqli_real_escape_string($conn, trim($_POST['id_akun']));
            $kendaraan  = mysqli_real_escape_string($conn, trim($_POST['kendaraan']));
            $keterangan =  mysqli_real_escape_string($conn, trim($_POST['keterangan']));
            $jumlah =  mysqli_real_escape_string($conn, trim($_POST['jumlah']));

            if(isset($_POST['barangPenjualan'])){
                $barang_penjualan = mysqli_real_escape_string($conn, trim($_POST['barangPenjualan']));
                $kuantitas = mysqli_real_escape_string($conn, trim($_POST['kuantitas']));
            } else {
                $barang_penjualan = NULL;
                $kuantitas = NULL;
            }

            if(isset($_POST['id_jasa'])){
                $id_jasa = mysqli_real_escape_string($conn, trim($_POST['id_jasa']));
                $deskripsi_jasa = mysqli_real_escape_string($conn, trim($_POST['deskripsi_jasa']));
            } else {
                $id_jasa = NULL;
                $deskripsi_jasa = NULL;
            }
            

            $_SESSION['temp_cash_masuk'][] = array(
                'id_customer' => $id_customer,
                'nomor_bukti' => $nomor_bukti,
                'target_pengeluaran' => $target_pengeluaran,
                'id_akun' => $id_akun,
                'kendaraan' => $kendaraan,
                'keterangan' => $keterangan,
                'jumlah' => $jumlah,
                'id_barang' => $barang_penjualan,
                'kuantitas' => $kuantitas,
                'id_jasa' => $id_jasa,
                'deskripsi_jasa' => $deskripsi_jasa,
            );
        }
        header('location: ../../../main.php?module=detailCashMasuk');
    }

    elseif ($_GET['act'] == 'reset'){
        unset($_SESSION['temp_cash_masuk']);
        header('location: ../../../main.php?module=detailCashMasuk');
    }

    elseif ($_GET['act'] == 'deleteList'){
        if (isset($_POST['deleteList'])){
            $id_list = $_POST['indeks'];

            unset($_SESSION['temp_cash_masuk'][$id_list]);

            header('location: ../../../main.php?module=detailCashMasuk');
        }
    }
?>