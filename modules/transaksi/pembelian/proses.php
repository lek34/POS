<?php
session_start();

// Panggil koneksi database.php untuk koneksi database
require_once "../../../config/database.php";

// fungsi untuk pengecekan status login user 
// jika user belum login, alihkan ke halaman login dan tampilkan pesan = 1
require_once "../../../auth/cek.php";
// jika user sudah login, maka jalankan perintah untuk insert, update, dan delete
    if($_GET['act']=='inserttemp'){
        if(isset($_POST['inserttemp'])){
            $no_transaksi = mysqli_real_escape_string($conn, trim($_POST['nomor_transaksi']));
            $no_faktur = trim($_POST['no_faktur']);
            $supplier  = mysqli_real_escape_string($conn, trim($_POST['supplier']));
            $jatuh_tempo  	= mysqli_real_escape_string($conn, trim($_POST['jatuh_tempo']));

            // store the variables in the session
            $_SESSION['temp_data_transaksi'] = array(
                'no_transaksi' => $no_transaksi,
                'no_faktur' => $no_faktur,
                'supplier' => $supplier,
                'jatuh_tempo' => $jatuh_tempo
            );
            $faktur_barang = trim($_POST['no_faktur']);
            $id_barang = mysqli_real_escape_string($conn, trim($_POST['id_barang']));
            $kuantitas = mysqli_real_escape_string($conn, trim($_POST['kuantitas']));
            $harga_barang = mysqli_real_escape_string($conn, trim($_POST['harga_barang']));
            if(isset($_POST['disc'])){
                $disc = 0;
            } else {
                $disc = trim($_POST['disc']);
            }
            $bruto = ($kuantitas*$harga_barang);
            $netto = $bruto - ($bruto * ($disc/100));
            $user = $_SESSION['username'];

            if (!isset($_SESSION['temp_data_barang'])) {
                $_SESSION['temp_data_barang'] = array();
            }
            // Create a session array for transaction items
            $_SESSION['temp_data_barang'][] = array(
                'faktur_barang' => $faktur_barang,
                'id_barang' => $id_barang,
                'kuantitas' => $kuantitas,
                'harga_barang' => $harga_barang,
                'disc' => $disc,
                'bruto' => $bruto,
                'netto' => $netto,
                'user' => $user
            );

            header('location: ../../../main.php?module=detailPembelian');
        }
    } elseif ($_GET['act'] == 'deleteList'){
        if (isset($_POST['deleteList'])){
            $id_list = $_POST['indeks'];

            unset($_SESSION['temp_data_barang'][$id_list]);

            header('location: ../../../main.php?module=detailPembelian');
        }
    }
?>
