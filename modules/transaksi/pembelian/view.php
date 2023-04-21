<section class="content-header">
    <div class="container-fluid">
    <?php
        if (isset($_GET['alert'])) {
            $alert =  $_GET['alert'];
            switchAlert($alert);
    }
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
                        <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#tambah">
                        <i class="fa fa-plus-square"></i> Tambah Pembelian
                        </button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                <th>No. Faktur </th>
                                <th>Tanggal Pembelian</th>
                                <th>Supplier</th>
                                <th>Disc</th>
                                <th>Harga Netto</th>
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
                                    $disc = $data ['disc'];
                                    $netto = number_format($data['harga_netto'], 0, ',', '.');
                                    $status = $data ['status_pembayaran'];
                                ?>
                                <tr>
                                    <td><?=$no_faktur?></td>
                                    <td><?=$tanggal?></td>
                                    <td><?=$supplier?></td>
                                    <td><?=$disc?></td>
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
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#edit<?=$id_pembelian;?>"><i class = "far fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete<?=$id_barang;?>"><i class = "far fa-trash-alt"></i></button>
                                        <a href="?module=detailPembelian&id_pembelian=<?=$id_pembelian?>"><button type="button" class="btn btn-warning btn-sm"><i class="fas fa-ellipsis-h" style="color : #ffffff"></i></button></a>
                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#delete<?=$id_barang;?>"><i class="fas fa-check" style = "color : #ffffff"></i></button>

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

<?php
    $query = "SELECT MAX(nomor_transaksi) as last_transaksi , no_faktur from pembelian;";
    $execQuery = mysqli_query($conn, $query);
    $fetchQuery = mysqli_fetch_array($execQuery);
    $date = date('ym');
    $current_month = date('m');
    $stored_month = substr($fetchQuery['no_faktur'], 5, 2); // extract the stored month from the last ID
    $next_number = 1; // Set a default value for next_number before the if-else block
    if ($current_month == $stored_month) {
        // Increment the next number by 1 if the current month is the same as the stored month
        $next_number = (int)$fetchQuery['last_transaksi'] + 1;
    }
    $date = date('ym');
    $newFaktur = 'PB/' . $date .'/'. str_pad($next_number, 4, '0', STR_PAD_LEFT);
    ?>      
<!-- The Modal -->
  <div class="modal fade" id="tambah">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Tambah Pembelian</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
            <br>

            <form action="modules/transaksi/pembelian/proses.php?act=insert" method="post">
                <input type="text" name="nomor_transaksi" placeholder="You Shouldn't See This" value='<?= $next_number?>' class="form-control" hidden>
                <label>No. Faktur</label>
                <input type="hidden" name="id_pembelian" placeholder="No Faktur" value='<?= $newFaktur?>' class="form-control" readonly>
                <input type="text" name="no_faktur" placeholder="No Faktur" value='<?= $newFaktur?>' class="form-control" readonly>
                <br>
                <label>Supplier</label>
                <select name="supplier" class="form-control">
                    <?php
                    $pilihansupplier = mysqli_query($conn, "select * from supplier WHERE status = 'Y'");
                    while ($fetcharray = mysqli_fetch_array($pilihansupplier)) {
                    $namasupplier = $fetcharray['nama'];
                    $idsup = $fetcharray['id_supplier'];
                    ?>
                    <option value="<?= $idsup; ?>">
                        <?= $namasupplier; ?>
                    </option>
                    <?php
                    }
                    ?>
                </select>
                <br>
                <label>Jatuh Tempo</label>
                <input type="date" name="jatuh_tempo" placeholder="jatuhtempo" class="form-control" required>
                <br>
                <br>
				<br>
				            <button type="button" class="btn btn-danger" style="float: left;" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="addBuy" style="float: right;">Submit</button>
            </form> 
        </div>
      </div>
    </div>
  </div>

<?php
$query = "SELECT p.*, s.nama
            FROM pembelian p
            INNER JOIN supplier s ON p.id_supplier = s.id_supplier
            ";
$execQuery = mysqli_query($conn, $query);

while ($data = mysqli_fetch_array($execQuery)){
    $id_pembelian = $data ['id_pembelian'];
    $no_faktur = $data ['no_faktur'];
    $supplier = $data ['nama'];
    $jatuh_tempo = $data ['jatuh_tempo'];
?>
<div class="modal fade" id="edit<?=$id_pembelian;?>">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit Supplier</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <br>
            <form action="modules/transaksi/pembelian/proses.php?act=edit" method="post">
                <input type="hidden" name="id_pembelian" value = <?=$id_pembelian?> hidden>
                <label>No. Faktur</label>
                <input type="text" name="no_faktur" placeholder="No Faktur" value='<?= $newFaktur?>' class="form-control" readonly>
                <br>
                <label>Supplier</label>
                <select name="supplier" class="form-control">
                    <?php
                    $pilihansupplier = mysqli_query($conn, "select * from supplier where status = 'Y'");
                    while ($fetcharray = mysqli_fetch_array($pilihansupplier)) {
                    $namasupplier = $fetcharray['nama'];
                    $idsup = $fetcharray['id_supplier'];
                    ?>
                    <option value="<?= $idsup; ?>">
                        <?= $namasupplier; ?>
                    </option>
                    <?php
                    }
                    ?>
                </select>
                <br>
                <label>Jatuh Tempo</label>
                <input type="date" name="jatuh_tempo" placeholder="jatuhtempo" value='<?= $jatuh_tempo?>' class="form-control" required>

                <br>
				<br>
				    <button type="button" class="btn btn-danger" style="float: left;" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="editBuy" style="float: right;">Submit</button>
            </form>  
        </div>
      </div>
    </div>
  </div>
    
<?php
}
?>
  