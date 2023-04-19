<section class="content-header">
      <div class="container-fluid">
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
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    while ($data = mysqli_fetch_assoc($execQuery)){
                      $id_barang = $data['id_barang'];
                    ?>
                      <tr>
                      <td><?=$data['nama_barang']?></td>
                      <td><?=$data['harga_beli']?></td>
                      <td><?=$data['kuantitas']?></td>
                      <td><a href="history.php?id=<?=$id_barang;?>&action=buy" class = "btn btn-outline-secondary">Pembelian</a><a href="history.php?id=<?=$id_barang;?>&action=sell" class = "btn btn-outline-secondary">Penjualan</a></td>
                      </tr>
                    <?php
                    }

                    mysqli_close($conn);
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