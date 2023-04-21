<section class="content-header">
    <div class="container-fluid">
    <?php

    function alertText ($alert, $text){
        if ($alert % 2 == 1 ) {
          echo "<div class='alert alert-success alert dismissable'>
          <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
          <h4>  <i class='icon fa fa-check-circle'></i> Berhasil!</h4>
          $text
          </div>";
        } else {
          echo "<div class='alert alert-danger alert dismissable'>
          <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
          <h4>  <i class='icon fa fa-times-circle'></i> Gagal!</h4>
          $text
          </div>";
        }
    }

      // fungsi untuk menampilkan pesan
      // jika alert = "" (kosong)
      // tampilkan pesan "" (kosong)
      if (empty($_GET['alert'])) {
        echo "";
      } 

     if (isset($_GET['alert'])){
      $alert =  $_GET['alert'];

      switch ($alert){
        case 1:
          alertText(1, "Data berhasil ditambahkan");
          break;
        case 2:
          alertText(2, "Data gagal ditambahkan");
          break;
        case 3:
          alertText(3, "Data berhasil di-edit");
          break;
        case 4:
          alertText(4, "Data gagal di-edit");
          break;
        case 5:
          alertText(5, "Data berhasil dihapus");
          break;
        case 6:
          alertText(6, "Data gagal dihapus");
          break;  
      }
     }
  ?>
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Supplier</h1>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<?php
  $query = "SELECT * from supplier WHERE status = 'Y'";
    $execQuery = mysqli_query($conn, $query);
?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#tambah">
                        <i class="fa fa-plus-square"></i> Tambah Supplier
                        </button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                <th>No. Faktur </th>
                                <th>Nama Barang</th>
                                <th>Tanggal</th>
                                <th>Supplier</th>
                                <th>Harga Bruto</th>
                                <th>Disc</th>
                                <th>Harga Netto</th>
                                <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM pembelian";
                                $execQuery = mysqli_query($conn, $query);

                                while ($data = mysqli_fetch_array($execQuery)){
                                    $query = "";
                                }