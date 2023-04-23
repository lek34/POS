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
                <h1>Tambah Pembelian</h1>
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
                        <a href="main.php?module=detailPembelian">
                            <button type="button" class="btn btn-outline-secondary">
                            <i class="fa fa-plus-square"></i> Tambah Pembelian
                            </button>
                        </a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                <th>No. Faktur </th>
                                <th>Tanggal Pembelian</th>
                                <th>Supplier</th>
                                <th>Netto</th>
                                <th>Status</th>
                                <th>Jatuh Tempo</th>
                                <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT p.*, s.nama
                                            FROM pembelian p
                                            INNER JOIN supplier s ON p.id_supplier = s.id_supplier
                                            ";
                                $execQuery = mysqli_query($conn, $query);

                                while ($data = mysqli_fetch_array($execQuery)){
                                    $id_pembelian = $data ['id_pembelian'];
                                    $no_faktur = $data ['no_faktur'];
                                    $tanggal  = $data ['tanggal'];
                                    $jatuh_tempo  = $data ['jatuh_tempo'];
                                    $supplier = $data ['nama'];
                                    $netto = number_format($data['netto'], 0, ',', '.');
                                    $status = $data ['status_pembayaran'];
                                ?>
                                <tr>
                                    <td><?=$no_faktur?></td>
                                    <td><?=$tanggal?></td>
                                    <td><?=$supplier?></td>
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
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete<?=$id_barang;?>"><i class = "far fa-trash-alt"></i></button>
                                        <a href="?module=detailPembelian&id_pembelian=<?=$id_pembelian?>"><button type="button" class="btn btn-warning btn-sm"><i class="fas fa-ellipsis-h" style="color : #ffffff"></i></button></a>
                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#bayar<?=$id_pembelian?>"><i class="fas fa-check" style = "color : #ffffff"></i></button>

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
<div class="modal-dialog modal-dialog-centered">
  ...
</div>