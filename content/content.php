<?php
require_once "config/database.php";


if (empty($_SESSION['username']) && empty($_SESSION['password'])){
	echo "<meta http-equiv='refresh' content='0; url=login.php?alert=1'>";
}

else{
    if ($_GET['module'] == 'beranda') {
		include "modules/home/dashboard.php";
	}
    elseif ($_GET['module'] == 'tabel') {
		include "modules/home/dashboard.php";
	}
	elseif ($_GET['module'] == 'dataItem') {
		include "modules/master/barang/view.php";
	}
	elseif ($_GET['module'] == 'dataSup') {
		include "modules/master/supplier/view.php";
	}
	elseif ($_GET['module'] == 'dataCust') {
		include "modules/master/customer/view.php";
	}
	elseif ($_GET['module'] == 'noAcc') {
		include "modules/master/akunbank/view.php";
	}
	elseif ($_GET['module'] == 'User') {
		include "modules/user/view.php";
	}
	elseif ($_GET['module'] == 'buyItem'){
		include "modules/transaksi/pembelian/view.php";
	}

	
}

?>