<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>History</h1>
            </div>
        </div>
        </div><!-- /.container-fluid -->
</section>



<?php
    if(isset($_GET)){
?>
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
                        $id_barang = $_GET['id_barang'];
                        $action = $_GET['action'];

                        if($action == "buy"){
                            $query = "SELECT * FROM transaksi WHERE tipe = 'buy' AND id_barang = '$id_barang'";
                            $execQuery = mysqli_query($conn, $query);

                            while ($data = mysqli_fetch_assoc($execQuery)) {?>
                                # code...

                            <?php
                            }

                        ?>
                        <?php
                        } elseif ($action == "sell"){
                            $query = "SELECT * FROM transaksi WHERE tipe = 'sell' AND id_barang = '$id_barang'";
                            $execQuery = mysqli_query($conn, $query);

                            while ($data = mysqli_fetch_assoc($execQuery)) {?>
                                # code...

                            <?php
                            }
                        }?>
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
    <?php
    }
?>