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
	elseif ($_GET['module'] == 'master') {
		include "modules/transaksi/view.php";
	}
}

?>