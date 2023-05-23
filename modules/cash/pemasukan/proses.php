<?php
    session_start();

    // Panggil koneksi database.php untuk koneksi database
    require_once "../../../config/database.php";
    // fungsi untuk pengecekan status login user 
    // jika user belum login, alihkan ke halaman login dan tampilkan pesan = 1
    require_once "../../../auth/cek.php";
    // jika user sudah login, maka jalankan perintah untuk insert, update, dan delete
    if($_GET['act'] == 'insertTempCashMasuk'){
        if(isset($_POST['insertTempCashMasuk'])){
            $nomor_bukti = mysqli_real_escape_string($conn, trim($_POST['no_bukti']));
            $id_akun  = mysqli_real_escape_string($conn, trim($_POST['id_akun']));
            $bukti_masuk = mysqli_real_escape_string($conn, trim($_POST['bukti_masuk']));

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
            $kendaraan  = mysqli_real_escape_string($conn, trim($_POST['kendaraan']));
            $keterangan =  mysqli_real_escape_string($conn, trim($_POST['keterangan']));
            $jumlah =  mysqli_real_escape_string($conn, trim($_POST['jumlah']));
            $tanggal_masuk = $_POST['tanggal_masuk'];
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
                'tanggal_masuk' => $tanggal,
                'id_customer' => $id_customer,
                'nomor_bukti' => $nomor_bukti,
                'bukti_masuk' => $bukti_masuk,
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

    elseif($_GET['act'] == 'insertCashMasuk') {
        if(isset($_POST['insertCashmasuk'])){
            $temp_cash_masuk = $_SESSION['temp_cash_masuk'];
            $nomor_bukti = $temp_cash_masuk['nomor_bukti'];
            $bukti_masuk = $temp_cash_masuk['bukti_masuk'];
            $queryHeader = "INSERT INTO cash_masuk (nomor_masuk,bukti_masuk) VALUES ('$nomor_bukti' , '$bukti_masuk')";
            $execQueryHeader = mysqli_query($conn, $queryHeader) or die('Error inserting data into pembelian table: ' . mysqli_error($conn));
            $id_cmasuk = mysqli_insert_id($conn);

             // Insert data from temp_data_beli table
             $temp_cash_masuk = $_SESSION['temp_cash_masuk'];
             foreach ($temp_cash_masuk as $data) {
                 $id_customer = $data['id_customer'];
                 $id_jasa = $data['id_jasa'];
                 $id_barang = $data['id_barang'];
                 $kuantitas = $data['kuantitas'];
                 $id_akun = $data['id_akun'];
                 $target_pengeluaran = $data['target_pengeluaran'];
                 $jumlah = $data['jumlah'];
                 $nomor_bukti = $data['nomor_bukti'];
                 $kendaraan = $data['kendaraan'];
                 $keterangan = $data['keterangan'];
                 $tanggal_masuk = $data['tanggal_masuk'];

                 $queryDetail = "INSERT INTO history_cash_masuk (id_cmasuk, id_customer, id_jasa, id_barang, kuantitas, id_kas, target_akun, harga, nomor_bukti, kendaraan,keterangan,tanggal_masuk) 
                 VALUES ('$id_cmasuk', '$id_customer', '$id_jasa', '$id_barang', '$kuantitas', '$id_akun', '$target_pengeluaran', '$nomor_bukti', '$kendaraan', '$keterangan','$tanggal_masuk')";
                 $execQueryDetail = mysqli_query($conn, $queryDetail) or die('Error inserting data into pembelian_detail table: ' . mysqli_error($conn));

             }

             $tambahBarang = "SELECT hcm.id_barang, b.nama_barang,b.kuantitas, SUM(hcm.kuantitas) as total_kuantitas
                             FROM barang b
                             INNER JOIN history_cash_masuk hcm ON hcm.id_barang = b.id_barang
                             GROUP BY hcm.id_barang, b.nama_barang;";
             $exectambahBarang = mysqli_query($conn, $tambahBarang);
            
            

            while ($datatambahBarang = mysqli_fetch_array($exectambahBarang)){
                $id_barang = $datatambahBarang['id_barang'];
                $total_kuantitas = $datatambahBarang ['total_kuantitas'];
                
                $stock_baru = $stock_sekarang + $total_kuantitas;
                
                $insertKuantitas = "UPDATE barang SET kuantitas = '$stock_baru' WHERE id_barang = '$id_barang'";
                $execinsertKuantitas = mysqli_query($conn, $insertKuantitas);
            }

        }
    }
?>