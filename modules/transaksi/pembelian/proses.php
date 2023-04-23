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
            $no_faktur = mysqli_real_escape_string($conn, trim($_POST['no_faktur']));
            $id_supplier = mysqli_real_escape_string($conn, trim($_POST['id_supplier']));
            $jatuh_tempo = mysqli_real_escape_string($conn, trim($_POST['jatuh_tempo']));

            // store the variables in the session
            $_SESSION['temp_data_transaksi'] = array(
                'no_transaksi' => $no_transaksi,
                'no_faktur' => $no_faktur,
                'id_supplier' => $id_supplier,
                'jatuh_tempo' => $jatuh_tempo
            );
            $faktur_barang = trim($_POST['no_faktur']);
            $id_barang = mysqli_real_escape_string($conn, trim($_POST['id_barang']));
            $kuantitas = mysqli_real_escape_string($conn, trim($_POST['kuantitas']));
            $harga_barang = mysqli_real_escape_string($conn, trim($_POST['harga_barang']));
            $disc =  mysqli_real_escape_string($conn, trim($_POST['disc']));
            $bruto = ($kuantitas*$harga_barang);
            $diskon = ($bruto * ($disc/100));
            $netto = $bruto - $diskon;
            $user = $_SESSION['username'];

            if (!isset($_SESSION['temp_data_barang'])) {
                $_SESSION['temp_data_barang'] = array();
            }
            // Create a session array for transaction items
            $_SESSION['temp_data_barang'][] = array(
                'faktur_barang' => $faktur_barang,
                'id_barang' => $id_barang,
                'kuantitas' => $kuantitas,
                'id_supplier' => $id_supplier,
                'harga_barang' => $harga_barang,
                'disc' => $disc,
                'bruto' => $bruto,
                'netto' => $netto,
                'user' => $user,
                'diskon' => $diskon
            );

            header('location: ../../../main.php?module=detailPembelian');
        }
    } 
    elseif ($_GET['act'] == 'deleteList'){
        if (isset($_POST['deleteList'])){
            $id_list = $_POST['indeks'];

            unset($_SESSION['temp_data_barang'][$id_list]);

            header('location: ../../../main.php?module=detailPembelian');
        }
    }
    elseif ($_GET['act'] == 'reset'){
            unset($_SESSION['temp_data_transaksi']);
            unset($_SESSION['temp_data_barang']);

            header('location: ../../../main.php?module=detailPembelian');
        
    }

    elseif ($_GET['act'] == 'buy'){
        if(isset($_POST['buy'])){
            $id_pembelian = mysqli_real_escape_string($conn, trim($_POST['id_pembelian']));

            $query = "UPDATE pembelian SET status_pembayaran = 'Y' WHERE id_pembelian = '$id_pembelian'";
            $execQuery = mysqli_query($conn, $query);

            header('location: ../../../main.php?module=buyItem');
        }
    }

    elseif ($_GET['act'] == 'insertPembelian') {
        if (isset($_POST['insertPembelian'])) {
            $temp_data_transaksi = $_SESSION['temp_data_transaksi'];
            $no_transaksi = $temp_data_transaksi['no_transaksi'];
            $no_faktur = $temp_data_transaksi['no_faktur'];
            $id_supplier = $temp_data_transaksi['id_supplier'];
            $jatuh_tempo = $temp_data_transaksi['jatuh_tempo'];
            $totNetto = $_SESSION['totNetto'];
            
            $queryHeader = "INSERT INTO pembelian (no_faktur, id_supplier, nomor_transaksi, jatuh_tempo, netto) VALUES ('$no_faktur', '$id_supplier', '$no_transaksi', '$jatuh_tempo', '$totNetto')";
            $execQueryHeader = mysqli_query($conn, $queryHeader) or die('Error inserting data into pembelian table: ' . mysqli_error($conn));
            $id_pembelian = mysqli_insert_id($conn);
    
            // Insert data from temp_data_barang table
            $temp_data_barang = $_SESSION['temp_data_barang'];
            foreach ($temp_data_barang as $data) {
                $id_barang = $data['id_barang'];
                $id_supplier = $data['id_supplier'];
                $kuantitas = $data['kuantitas'];
                $harga_barang = $data['harga_barang'];
                $disc = $data['disc'];
                $bruto = $data['bruto'];
                $netto = $data['netto'];
                $user = $data['user'];
                $diskon = $data['diskon'];
    
                $queryDetail = "INSERT INTO history_pembelian (id_pembelian, id_supplier, id_barang, kuantitas, harga_barang, disc, bruto, netto, user) 
                                VALUES ('$id_pembelian', '$id_supplier', '$id_barang', '$kuantitas', '$harga_barang', '$disc', '$bruto', '$netto', '$user')";
                $execQueryDetail = mysqli_query($conn, $queryDetail) or die('Error inserting data into pembelian_detail table: ' . mysqli_error($conn));
            }
            
            $tambahBarang = "SELECT hp.kuantitas as kuantitas_baru , b.kuantitas, hp.id_barang as id_barang_beli, b.id_barang FROM barang b
                            INNER JOIN history_pembelian hp 
                            WHERE hp.id_barang = b.id_barang";
            $exectambahBarang = mysqli_query($conn, $tambahBarang);
            
            $totKuantitas = 0;
            while ($datatambahBarang = mysqli_fetch_array($exectambahBarang)){
                $kuantitas_tambah = $datatambahBarang ['kuantitas_baru'];
                $totKuantitas += $kuantitas_tambah;
                $kuantitas = $datatambahBarang ['kuantitas'];
            }
            $kuantitasBaru = $totKuantitas + $kuantitas;

            $insertKuantitas = "UPDATE barang SET kuantitas = '$kuantitasBaru' WHERE id_barang = '$id_barang'";
            $execinsertKuantitas = mysqli_query($conn, $insertKuantitas);
            // Clear session data after successful insertions
            unset($_SESSION['temp_data_transaksi']);
            unset($_SESSION['temp_data_barang']);
    
            header('location: ../../../main.php?module=buyItem');

        }
    }
    
?>
