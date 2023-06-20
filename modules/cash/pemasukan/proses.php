<?php
session_start();

// Panggil koneksi database.php untuk koneksi database
require_once "../../../config/database.php";
// fungsi untuk pengecekan status login user 
// jika user belum login, alihkan ke halaman login dan tampilkan pesan = 1
require_once "../../../auth/cek.php";

if($_GET['act'] == 'insertTempCashMasuk'){
    if(isset($_POST['insertTempCashMasuk'])){
        /* Header Information */
        $last_masuk = mysqli_real_escape_string($conn, trim($_POST['last_masuk']));
        $no_bukti = mysqli_real_escape_string($conn, trim($_POST['no_bukti']));
        $id_akun = mysqli_real_escape_string($conn, trim($_POST['id_akun']));
        $tanggal_masuk = $_POST['tanggal_masuk'];
        $terima_dari = mysqli_real_escape_string($conn, trim($_POST['terimaDari']));
        $keterangan = mysqli_real_escape_string($conn, trim($_POST['keterangan']));
        if ($terima_dari == "customer") {
            $sumber = $_POST['sumberCustomer'];
        } else {
            $sumber = mysqli_real_escape_string($conn, trim($_POST['sumberLainnya']));
        }

        $_SESSION['header_cash_masuk'] =  array(
            'sumber' => $sumber,
            'last_masuk' => $last_masuk,
            'no_bukti' => $no_bukti,
            'id_akun' => $id_akun,
            'tanggal_masuk' => $tanggal_masuk,
            'terima_dari' => $terima_dari,
            'keterangan' => $keterangan,
        );

        /* end of header information */
        /* Content Information */

        if ($terima_dari == "customer") {
            $barangPenjualan = mysqli_real_escape_string($conn, trim($_POST['barangPenjualan']));
            $uom = mysqli_real_escape_string($conn, trim($_POST['uom']));
            $satuan_kecil = mysqli_real_escape_string($conn, trim($_POST['satuankecil']));
            $kuantitas = mysqli_real_escape_string($conn, trim($_POST['kuantitas']));
            $id_jasa = mysqli_real_escape_string($conn, trim($_POST['id_jasa']));
        } else {
            $barangPenjualan = "";
            $uom = "";
            $satuan_kecil = "";
            $kuantitas = "";
            $id_jasa = "";
        }
        $kendaraan = mysqli_real_escape_string($conn, trim($_POST['barangPenjualan']));
        $jumlah = mysqli_real_escape_string($conn, trim($_POST['jumlah']));
        
        $_SESSION['temp_cash_masuk'][] = array(
            'barangPenjualan' => $barangPenjualan,
            'uom' => $uom,
            'satuan_kecil' => $satuan_kecil,
            'id_jasa' => $id_jasa,
            'kuantitas' => $kuantitas,
            'kendaraan' => $kendaraan,
            'jumlah' => $jumlah,
            
        );

        header('location: ../../../main.php?module=detailCashMasuk');
    }
}

elseif ($_GET['act'] == 'reset'){
    unset($_SESSION['header_cash_masuk']);
    unset($_SESSION['temp_cash_masuk']);

    header('location: ../../../main.php?module=detailCashMasuk');
}

elseif ($_GET['act'] == 'deleteList'){
    if (isset($_POST['deleteList'])){
        $id_list = $_POST['indexhapus'];

        unset($_SESSION['temp_cash_masuk'][$id_list]);

        header('location: ../../../main.php?module=detailCashMasuk');
    }
}
elseif ($_GET['act'] == 'insertCash'){
    if (isset($_POST['insertCash'])){
        $totJumlah = $_POST['totJumlah'];
        $no_bukti = $_SESSION['header_cash_masuk']['no_bukti'];
        $id_akun =  $_SESSION['header_cash_masuk']['id_akun'];
        $tanggal_masuk = $_SESSION['header_cash_masuk']['tanggal_masuk'];
        $terima_dari = $_SESSION['header_cash_masuk']['terima_dari'];
        $last_masuk = $_SESSION['header_cash_masuk']['last_masuk'];
        $keterangan = $_SESSION['header_cash_masuk']['keterangan'];
        /* Ambil Keterangan Nama */
        if ($terima_dari == "customer") {
            $sumber = $_SESSION['header_cash_masuk']['sumber'];
            $queryNamaCustomer = "SELECT nama FROM customer WHERE $sumber = id_customer";
            $execQueryNamaCustomer = mysqli_query($conn, $queryNamaCustomer);
            $fetchNamaCustomer = mysqli_fetch_array($execQueryNamaCustomer);
            $sumber = $fetchNamaCustomer ['nama'];
        } else {
            $sumber = $_SESSION['header_cash_masuk']['sumber'];
        }
        $queryHeader = "INSERT INTO cash_masuk (bukti_masuk, nomor_masuk, sumber, jumlah, id_akun, tanggal_masuk, keterangan) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $queryHeader);
        mysqli_stmt_bind_param($stmt, 'ssssdss', $no_bukti, $last_masuk, $sumber, $totJumlah, $id_akun, $tanggal_masuk, $keterangan);
        mysqli_stmt_execute($stmt);

        $id_cashMasuk = mysqli_insert_id($conn);


        $temp_cash_masuk = $_SESSION['temp_cash_masuk'];
        foreach ($temp_cash_masuk as $key => $data) {
            /* Cek Barang */
            $barang = $data['barangPenjualan'];
            $kuantitas = $data['kuantitas'];
            $jasa = $data['id_jasa'];
            $jumlah = $data['jumlah'];
            $keterangan = $data['keterangan'];

            $queryDetail = "INSERT INTO history_cash_masuk (id_cash_masuk, id_barang, kuantitas, jasa, jumlah) VALUES (?, ?, ?, ?, ?, )";
            $stmt = mysqli_prepare($conn, $queryDetail);
            mysqli_stmt_bind_param($stmt, 'iiiii', $id_cashMasuk, $barang, $kuantitas, $jasa, $jumlah);
            mysqli_stmt_execute($stmt);
        }
    }
    unset($_SESSION['header_cash_masuk']);
    unset($_SESSION['temp_cash_masuk']);
    header('location: ../../../main.php?module=cashMasuk');
}
?>