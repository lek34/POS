<?php
session_start();

// Panggil koneksi database.php untuk koneksi database
require_once "../../../config/database.php";

// fungsi untuk pengecekan status login user 
// jika user belum login, alihkan ke halaman login dan tampilkan pesan = 1
require_once "../../../auth/cek.php";
// jika user sudah login, maka jalankan perintah untuk insert, update, dan delete
    if ($_GET['act']=='inserttemp') {
        $nomor_transaksi  = mysqli_real_escape_string($conn, trim($_POST['nomor_transaksi']));
        $no_faktur = trim($_POST['no_faktur']);
        $supplier  = mysqli_real_escape_string($conn, trim($_POST['supplier']));
        $jatuh_tempo  	= mysqli_real_escape_string($conn, trim($_POST['jatuh_tempo']));

        $transaction_data = array (
            'nomor_transaksi' => $nomor_transaksi,
            'no_faktur' => $no_faktur,
            'supplier' => $supplier,
            'jatuh_tempo' => $jatuh_tempo
        );
        if (!isset($_SESSION['temp_transaction'])) {
            $_SESSION['temp_transaction'] = array();
            }
            $success = array_push($_SESSION['temp_transaction'], $transaction_data);

        if ($success){
            $id_pembelian = mysqli_insert_id($conn);
            header('location: ../../../main.php?module=detailPembelian&id_pembelian='.$id_pembelian);
        } else {
            header('location: ../../../main.php?module=buyItem&alert=2');
        }
    }

    elseif ($_GET['act']=='edit') {
        if (isset($_POST['editBuy'])){
            $supplier  = mysqli_real_escape_string($conn, trim($_POST['supplier']));
            $id_pembelian  = mysqli_real_escape_string($conn, trim($_POST['id_pembelian']));
            $jatuh_tempo  	= mysqli_real_escape_string($conn, trim($_POST['jatuh_tempo']));
            $query = "UPDATE pembelian SET id_supplier = '$supplier', jatuh_tempo = '$jatuh_tempo' WHERE id_pembelian = '$id_pembelian'";
            $execQuery = mysqli_query($conn, $query);

            if ($execQuery){
                header('location: ../../../main.php?module=buyItem&alert=3');
            } else {
                header('location: ../../../main.php?module=buyItem&alert=4');
            }
        }
        
    }
    elseif($_GET['act'] == 'insertDetail'){
        if(isset($_POST['insertDetail'])){
            $id_pembelian = mysqli_real_escape_string($conn, trim($_POST['id_pembelian']));
            $id_barang = mysqli_real_escape_string($conn, trim($_POST['id_barang']));
            $kuantitas = mysqli_real_escape_string($conn, trim($_POST['kuantitas']));
            $harga_barang = mysqli_real_escape_string($conn, trim($_POST['harga_barang']));
            $disc = mysqli_real_escape_string($conn, trim($_POST['disc']));
            $bruto = ($kuantitas*$harga_barang);
            $netto = $bruto - $disc;
            $user = $_SESSION['username'];

            $query = "INSERT INTO temp_beli (id_pembelian, id_barang, kuantitas, harga_barang, disc, bruto, netto, creator) 
                        VALUES ($id_pembelian, $id_barang, $kuantitas, $harga_barang, $disc, $bruto, $netto, $user)";
            $execQuery = mysqli_query($conn, $query);

            if($execQuery){
                header('location: ../../../main.php?module=detailPembelian&id_pembelian='.$id_pembelian);
            }
        }
    }

    elseif ($_GET['act']=='delete') {
        if (isset($_POST['delSup'])){
            $id_sup = mysqli_real_escape_string($conn, trim($_POST['id_supplier']));

            $query = "UPDATE supplier SET status = 'N' WHERE id_supplier = '$id_sup'";
            $execQuery = mysqli_query($conn, $query);

            if ($execQuery){
                header('location: ../../../main.php?module=buyItem&alert=5');
            } else {
                header('location: ../../../main.php?module=buyItem&alert=6');
            }
        }
    }
?>
