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
            $id_customer = mysqli_real_escape_string($conn, trim($_POST['id_customer']));
            $jatuh_tempo = mysqli_real_escape_string($conn, trim($_POST['jatuh_tempo']));

            // store the variables in the session
            $_SESSION['temp_transaksi_jual'] = array(
                'no_transaksi' => $no_transaksi,
                'no_faktur' => $no_faktur,
                'id_customer' => $id_customer,
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

            // get data from database
            $getStock = mysqli_query($conn, "SELECT kuantitas FROM barang WHERE id_barang='$id_barang'");
            $data = mysqli_fetch_assoc($getStock);
            $stock_sekarang = $data['kuantitas'];

            // check if stock is enough
            if($kuantitas > $stock_sekarang){
                header ('location: ../../../main.php?module=detailPenjualan&alert=7');
            }
            else{
                if (!isset($_SESSION['temp_data_jual'])) {
                    $_SESSION['temp_data_jual'] = array();
                }
    
                // Create a session array for transaction items
                $_SESSION['temp_data_jual'][] = array(
                    'faktur_barang' => $faktur_barang,
                    'id_barang' => $id_barang,
                    'kuantitas' => $kuantitas,
                    'id_customer' => $id_customer,
                    'harga_barang' => $harga_barang,
                    'disc' => $disc,
                    'bruto' => $bruto,
                    'netto' => $netto,
                    'user' => $user,
                    'diskon' => $diskon
                );
                header('location: ../../../main.php?module=detailPenjualan');
            }
            
        }
    } 
    elseif ($_GET['act'] == 'deleteList'){
        if (isset($_POST['deleteList'])){
            $id_list = $_POST['indeks'];

            unset($_SESSION['temp_data_jual'][$id_list]);

            header('location: ../../../main.php?module=detailPenjualan');
        }
    }
    elseif ($_GET['act'] == 'reset'){
            unset($_SESSION['temp_transaksi_jual']);
            unset($_SESSION['temp_data_jual']);

            header('location: ../../../main.php?module=detailPenjualan');
        
    }

    elseif ($_GET['act'] == 'sell'){
        if(isset($_POST['buy'])){
            $id_penjualan = mysqli_real_escape_string($conn, trim($_POST['id_penjualan']));

            $query = "UPDATE penjualan SET status_pembayaran = 'Y' WHERE id_penjualan = '$id_penjualan'";
            $execQuery = mysqli_query($conn, $query);

            header('location: ../../../main.php?module=sellItem');
        }
    }

    elseif ($_GET['act'] == 'insertPenjualan') {
        if (isset($_POST['insertPenjualan'])) {
            $temp_transaksi_jual = $_SESSION['temp_transaksi_jual'];
            $no_transaksi = $temp_transaksi_jual['no_transaksi'];
            $no_faktur = $temp_transaksi_jual['no_faktur'];
            $id_customer = $temp_transaksi_jual['id_customer'];
            $jatuh_tempo = $temp_transaksi_jual['jatuh_tempo'];
            $totNetto = $_SESSION['totNetto'];
            $creator = $_SESSION['username'];
            
            $queryHeader = "INSERT INTO penjualan (no_faktur, id_customer, nomor_transaksi, jatuh_tempo, netto, creator) 
                            VALUES ('$no_faktur', '$id_customer', '$no_transaksi', '$jatuh_tempo', '$totNetto', '$creator')";
            $execQueryHeader = mysqli_query($conn, $queryHeader) or die('Error inserting data into penjualan table: ' . mysqli_error($conn));
            $id_penjualan = mysqli_insert_id($conn);
    
            // Insert data from temp_data_jual table
            $temp_data_jual = $_SESSION['temp_data_jual'];
            foreach ($temp_data_jual as $data) {
                $id_barang = $data['id_barang'];
                $id_customer = $data['id_customer'];
                $kuantitas = $data['kuantitas'];
                $harga_barang = $data['harga_barang'];
                $disc = $data['disc'];
                $bruto = $data['bruto'];
                $netto = $data['netto'];
                $user = $data['user'];
                $diskon = $data['diskon'];
    
                $queryDetail = "INSERT INTO history_penjualan (id_penjualan, id_customer, id_barang, kuantitas, harga_barang, disc, diskon, bruto, netto, user) 
                                VALUES ('$id_penjualan', '$id_customer', '$id_barang', '$kuantitas', '$harga_barang', '$disc', '$diskon', '$bruto', '$netto', '$user')";
                $execQueryDetail = mysqli_query($conn, $queryDetail) or die('Error inserting data into penjualan_detail table: ' . mysqli_error($conn));
            }
            
            $tambahBarang = "SELECT hp.id_barang, b.nama_barang, b.kuantitas, SUM(hp.kuantitas) as total_kuantitas 
                            FROM barang b 
                            INNER JOIN history_penjualan hp ON hp.id_barang = b.id_barang 
                            WHERE hp.id_penjualan = '$id_penjualan'
                            GROUP BY hp.id_barang, b.nama_barang;";
            $exectambahBarang = mysqli_query($conn, $tambahBarang);
            
            
            while ($datatambahBarang = mysqli_fetch_array($exectambahBarang)){
                $id_barang = $datatambahBarang['id_barang'];
                $stock_sekarang = $datatambahBarang['kuantitas'];
                $total_kuantitas = $datatambahBarang ['total_kuantitas'];
                $stock_baru = $stock_sekarang - $total_kuantitas;

                $insertKuantitas = "UPDATE barang SET kuantitas = '$stock_baru' WHERE id_barang = '$id_barang'";
                $execinsertKuantitas = mysqli_query($conn, $insertKuantitas);
            }
            // Clear session data after successful insertions
            unset($_SESSION['temp_transaksi_jual']);
            unset($_SESSION['temp_data_jual']);
    
            header('location: ../../../main.php?module=sellItem');

        }
    }
    
?>
