<section class="content-header">
    <div class="container-fluid">
    <?php
        if (isset($_GET['alert'])) {
            $alert =  $_GET['alert'];
            switchAlert($alert);
    }
    // if (isset($_GET['alert'])) {
    //     $alert =  $_GET['alert'];
    //     switchAlert($alert);
// }
?>
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Tambah Penjualan</h1>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-md-flex justify-content-md-end">
                        <a href="main.php?module=detailPenjualan">
                            <button type="button" class="btn btn-outline-secondary">
                            <i class="fa fa-plus-square"></i> Tambah Penjualan
                            </button>
                        </a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                <th>No. Faktur </th>
                                <th>Tanggal Penjualan</th>
                                <th>Customer</th>
                                <th>Plat</th>
                                <th>Netto</th>
                                <th>Status</th>
                                <th>Jatuh Tempo</th>
                                <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT p.*, c.nama
                                            FROM penjualan p
                                            INNER JOIN customer c ON p.id_customer = c.id_customer
                                            ";
                                $execQuery = mysqli_query($conn, $query);

                                while ($data = mysqli_fetch_array($execQuery)){
                                    $id_penjualan = $data ['id_penjualan'];
                                    $no_faktur = $data ['no_faktur'];
                                    $tanggal  = $data ['tanggal'];
                                    $jatuh_tempo  = $data ['jatuh_tempo'];
                                    $customer = $data ['nama'];
                                    $plat = $data ['plat'];
                                    $netto = number_format($data['netto'], 0, ',', '.');
                                    $status = $data ['status_pembayaran'];
                                ?>
                                <tr>
                                    <td><?=$no_faktur?></td>
                                    <td><?=$tanggal?></td>
                                    <td><?=$customer?></td>
                                    <td><?=$plat?></td>
                                    <td>Rp. <?=$netto?></td>
                                    <td>
                                        <?php
                                        if ($status == "N") {
                                            echo "Belum Terbayar";
                                        } else {
                                            echo "Terbayar";
                                        }
                                        ?>
                                    </td>
                                    <td><?=$jatuh_tempo?></td>
                                    <td>
                                        <a href="?module=detailPenjualan&id_penjualan=<?=$id_penjualan?>"><button type="button" class="btn btn-warning btn-sm"><i class="fas fa-ellipsis-h" style="color : #ffffff"></i></button></a>
                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#bayar<?=$id_penjualan?>"><i class="fas fa-check" style = "color : #ffffff"></i></button>
                                    </td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                </table>
                <br><br>
                <div class="row">
                    <div class="col-8"></div>
                    <?php
                        $query = "SELECT SUM(netto) as piutang_dagang FROM penjualan WHERE status_pembayaran = 'N'";
                        $execQuery = mysqli_query($conn, $query);

                        $ambilPiutangDagang = mysqli_fetch_array($execQuery);
                        $piutang_dagang =  number_format($ambilPiutangDagang['piutang_dagang'], 0, ',', '.');
                    ?>
                    <div class="col-4">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>Piutang Dagang :</th>
                                    <td>Rp. <?=$piutang_dagang?></td>
                                </tr>
                            </table>
                        </div>

                    </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

<!-- The Modal -->
<?php
    $query = "SELECT id_penjualan FROM penjualan";
    $execQuery = mysqli_query($conn, $query);

    while ($data = mysqli_fetch_array($execQuery)){
    $id_penjualan = $data ['id_penjualan'];
    ?>
  <div class="modal fade" id="bayar<?=$id_penjualan?>">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Penjualan</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
            <br>
            <form action="modules/transaksi/penjualan/proses.php?act=sell" method="post">
                <p>Selesaikan Pembayaran?</p>
                <br>
                <br>
                <input type="hidden" name="id_penjualan" value="<?=$id_penjualan;?>">
                <button type="button" class="btn btn-danger" style="float: left;" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="buy" style="float: right;">Submit</button>
            </form> 
        </div>
      </div>
    </div>
  </div>
  <?php
    }mysqli_close($conn);
?>