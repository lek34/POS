<section class="content-header">
      <div class="container-fluid">
      <?php
        // if (isset($_GET['alert'])) {
        //   $alert =  $_GET['alert'];
        //   switchAlert($alert);
        //   }
        if (isset($_GET['alert'])) {
          $alert = $_GET['alert'];
          if ($alert == 1) {
            echo "<div class='toastrDefaultError'>
            </div>";
          } 
        }
      ?>
        <div class="row mb-2">
                  <div class="col-sm-6">
                    <h1>Item</h1>
                  </div>
                </div>
              </div><!-- /.container-fluid -->
            </section>

<?php
  $query = "SELECT * from barang WHERE status = 'Y'";
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
                      $barang = $data ['nama_barang'];
                      $harga_beli_formatted = number_format($data['harga_beli'], 0, ',', '.');
                      $kuantitas = $data ['kuantitas'];
                    ?>
                      <tr>
                      <td><?=$barang?></td>
                      <td>Rp. <?=$harga_beli_formatted;?></td>
                      <td><?=$kuantitas?></td>
                      <td>
                        <a href="history.php?id=<?=$id_barang;?>&action=buy" class = "btn btn-outline-primary" style="margin-right: 10px;">Pembelian</a>
                        <a href="history.php?id=<?=$id_barang;?>&action=sell" class = "btn btn-outline-danger">Penjualan</a>
                      </td>
                      <td class="center">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#edit<?=$id_barang;?>"><i class = "far fa-edit"></i></button>
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete<?=$id_barang;?>"><i class = "far fa-trash-alt"></i></button>
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
<!-- Delete Modal -->
<div class="modal fade" id="delete<?=$id_barang;?>">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Hapus Barang</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <br>
              Apakah anda ingin menghapus barang?
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
          <form action="modules/master/barang/proses.php?act=delete" method="post">
            <input type="hidden" name="id_barang" value="<?=$id_barang;?>">
            <button type="submit" class="btn btn-primary" name="deletebarang">Yes</button>
				    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          </form> 
        </div>
      </div>
    </div>
  </div>
<?php
  }
?>