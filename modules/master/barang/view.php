<section class="content-header">
      <div class="container-fluid">
      <?php  
      // fungsi untuk menampilkan pesan
      // jika alert = "" (kosong)
      // tampilkan pesan "" (kosong)
      if (empty($_GET['alert'])) {
        echo "";
      } 
      // jika alert = 1
      // tampilkan pesan Gagal "Username atau Password salah, cek kembali Username dan Password Anda"
      elseif ($_GET['alert'] == 1) {
        echo "<div class='alert alert-success alert dismissable'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h4>  <i class='icon fa fa-check-circle'></i> Berhasil!</h4>
                Data barang berhasil ditambahkan.
              </div>";
      }
      // jika alert = 2
      // tampilkan pesan Sukses "Anda telah berhasil logout"
      // elseif ($_GET['alert'] == 2) {
      //   echo "<div class='alert alert-danger alert dismissable'>
      //           <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
      //           <h4>  <i class='icon fa fa-times-circle'></i> Gagal!</h4>
      //           Data barang tidak dapat ditambahkan.
      //         </div>";
      // }
      ?>
        <div class="row mb-2">
                  <div class="col-sm-6">
                    <h1>Item</h1>
                  </div>
                </div>
              </div><!-- /.container-fluid -->
            </section>

<?php
  $query = "SELECT * from barang";
  $execQuery = mysqli_query($conn, $query);
?>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                    <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#myModal">
                          <i class="fa fa-plus-square"></i> Tambah Barang
                      </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nama Barang</th>
                    <th>Harga Barang</th>
                    <th>Quantity</th>
                    <th>History</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    while ($data = mysqli_fetch_assoc($execQuery)){
                      $id_barang = $data['id_barang'];
                    ?>
                      <tr>
                      <td><?=$data['nama_barang']?></td>
                      <td>Rp. <?=$harga_beli_formatted = number_format($data['harga_beli'], 0, ',', '.');?></td>
                      <td><?=$data['kuantitas']?></td>
                      <td>
                        <a href="history.php?id=<?=$id_barang;?>&action=buy" class = "btn btn-outline-primary" style="margin-right: 10px;">Pembelian</a>
                        <a href="history.php?id=<?=$id_barang;?>&action=sell" class = "btn btn-outline-danger">Penjualan</a>
                      </td>
                      <td class="center">
                        <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#edit<?=$id_barang;?>"><i class = "far fa-edit"></i></button>
                      </td>
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
            <!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Tambah Barang</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <br>
            <form action="modules/master/barang/proses.php?act=insert" method="post">
                <label>Nama Barang</label>
                <input type="text" name="namabarang" placeholder="Nama Barang" class="form-control" required>
                <br>
                <label>Harga Barang</label>
                <input type="text" name="harga" placeholder="Harga Barang / Item" class="form-control" required>
                <br>
                <label>Kuantitas</label>
                <input type="text" name="kuantitas" placeholder="Jumlah" class="form-control" required>
                <br>
				<br>
				    <button type="button" class="btn btn-danger" style="float: left;" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="addnewbarang" style="float: right;">Submit</button>
            </form> 
        </div>
      </div>
    </div>
  </div>

<!-- Edit Modal -->
<?php
  $execQuery = mysqli_query($conn, "SELECT * FROM barang");

  while ($data = mysqli_fetch_array($execQuery)) {
    $id_barang = $data['id_barang'];
    $barang = $data ['nama_barang'];
    $harga = $data ['harga_beli'];
    $kuantitas = $data ['kuantitas'];
?>
<div class="modal fade" id="edit<?=$id_barang;?>">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit Barang</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <br>
            <form action="modules/master/barang/proses.php?act=edit" method="post">
                <input type="hidden" name="id_barang" value="<?=$id_barang;?>">
                <label>Nama Barang</label>
                <input type="text" name="namabarang" value="<?=$barang;?>" class="form-control" >
                <br>
                <label>Harga</label>
                <input type="text" name="harga" value="<?=$harga;?>" class="form-control" required>
                <br>
                <label>Kuantitas</label>
                <input type="text" name="kuantitas" value="<?=$kuantitas?>" class="form-control">
				        <br>
                <br>
				    <button type="button" class="btn btn-danger" style="float: left;" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="editbarang" style="float: right;">Submit</button>
            </form> 
        </div>
      </div>
    </div>
  </div>
<?php
  }
?>