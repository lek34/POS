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
            $supplier = mysqli_real_escape_string($conn, trim($_POST['supplier']));
            $jatuh_tempo = mysqli_real_escape_string($conn, trim($_POST['jatuh_tempo']));

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

    
    elseif($_GET['act']=='insertPembelian'){
        if(isset($_POST['insertPembelian'])){
            // Get the data from the session
            $temp_data_transaksi = $_SESSION['temp_data_transaksi'];    

            foreach($temp_data_transaksi as $data) {
                $no_transaksi = $data['no_transaksi'];
                $no_faktur = $data['no_faktur'];
                $supplier = $data['supplier'];
                $jatuh_tempo = $data['jatuh_tempo'];
            
                $queryHeader = "INSERT INTO pembelian (no_faktur, id_supplier, nomor_transaksi, jatuh_tempo) VALUES ('$no_faktur', '$supplier', '$no_transaksi', '$jatuh_tempo')";
                $execQueryHeader = mysqli_query($conn, $queryHeader) or die('Ada kesalahan pada query user: ' . mysqli_error($conn));
            }
            
            $id_pembelian = mysqli_insert_id($conn);

            if (!isset($_SESSION['temp_data_barang'])) {

                $_SESSION['temp_data_barang'] = array();
            }else{
                 // Loop through temp_data_barang and insert each record into pembelian_detail table
                foreach($_SESSION['temp_data_barang'] as $data) {

                    // Retrieve data from array
                    $faktur_barang = $data['faktur_barang'];
                    $id_barang = $data['id_barang'];
                    $kuantitas = $data['kuantitas'];
                    $harga_barang = $data['harga_barang'];
                    $disc = $data['disc'];
                    $bruto = $data['bruto'];
                    $netto = $data['netto'];
                    $user = $data['user'];

                    // Insert data into pembelian_detail table
                    $queryDetail = "INSERT INTO pembelian_detail (id_pembelian, faktur_barang, id_barang, kuantitas, harga_barang, disc, bruto, netto, user) 
                                    VALUES ('$id_pembelian', '$faktur_barang', '$id_barang', '$kuantitas', '$harga_barang', '$disc', '$bruto', '$netto', '$user')";
                    $execQueryDetail = mysqli_query($conn, $queryDetail) or die('Ada kesalahan pada query detail: ' . mysqli_error($conn));
                }
            }
            // Clear session data after successful insertions
                unset($_SESSION['temp_data_transaksi']);
                unset($_SESSION['temp_data_barang']);
                
                header('location: ../../../main.php?module=buyItem');
            }
        }
?>
