<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tambah Pembelian</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

 <!-- generate nomor Faktur -->   
<?php
  $totBruto = 0;
  $totDiskon = 0;
  $totNetto = 0;
  $jatuh_tempo_bawah = "DD/MM/YYYY";
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

<!-- Mulai content -->
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h2>
                    
                  </h2>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                
                  <?php
                  if (!isset($_SESSION['temp_data_transaksi'])) {/* pengulangan pertama */
                  ?>
                  <div class="col-sm-4 invoice-col">
                    <form action="modules/transaksi/pembelian/proses.php?act=inserttemp" method="post"> <!-- form buka -->
                      <input type="hidden" name="nomor_transaksi" placeholder="You Shouldn't See This" value='<?= $next_number?>' class="form-control" hidden>
                      <label>No. Faktur</label>
                      <input type="text" name="no_faktur" placeholder="No Faktur" value='<?= $newFaktur?>' class="form-control" readonly>
                      <br>
                      <label>Supplier</label>
                      <select name="id_supplier" class="form-control">
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
                      <input type="date" id="jatuh_tempo" name="jatuh_tempo" placeholder="jatuhtempo" class="form-control" required>
                    </div>
                  </div>
                  <br>
                  <?php
                  } else { 
                    $no_transaksi = $_SESSION['temp_data_transaksi']['no_transaksi'];
                    $supplier = $_SESSION['temp_data_transaksi']['id_supplier'];
                    $jatuh_tempo = $_SESSION['temp_data_transaksi']['jatuh_tempo'];
                  ?>
                  <div class="col-sm-4 invoice-col">
                  <form action="modules/transaksi/pembelian/proses.php?act=inserttemp" method="post"> <!-- form buka -->
                      <input type="hidden" name="nomor_transaksi" placeholder="You Shouldn't See This" value='<?= $next_number?>' class="form-control" hidden>
                      <label>No. Faktur</label>
                      <input type="text" name="no_faktur" placeholder="No Faktur" value='<?=$newFaktur?>' class="form-control" readonly>
                      <br>
                      <label>Supplier</label>
                      <select name="id_supplier" class="form-control" readonly>
                        <?php
                        $pilihansupplier = mysqli_query($conn, "select * from supplier WHERE status = 'Y'");
                        while ($fetcharray = mysqli_fetch_array($pilihansupplier)) {
                          $namasupplier = $fetcharray['nama'];
                          $idsup = $fetcharray['id_supplier'];
                          $selected = ($idsup == $supplier) ? "selected" : "";
                          ?>
                          <option value="<?= $idsup; ?>" <?= $selected ?>>
                            <?= $namasupplier; ?>
                          </option>
                          <?php
                        }
                        ?>
                      </select>
                      <br>
                      <label>Jatuh Tempo</label>
                      <input type="date" id="jatuh_tempo" value="<?=$jatuh_tempo?>" name="jatuh_tempo" placeholder="jatuhtempo" class="form-control" readonly>
                    </div>
                  </div>
                  <br>
                  <div class="col-4 invoice-col">
                    <a href="modules/transaksi/pembelian/proses.php?act=reset">
                      <button type="button" name="reset" class="btn btn-primary">reset</button>
                    </a>
                  </div>

                  <?php
                  }
                  ?>
                
              <!-- /.row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Nama Barang</th>
                      <th>Qty</th>
                      <th>Harga Barang</th>
                      <th>Disc</th>
                      <th>Submit</th>
                    </tr>
                    </thead>
                    <tbody>
                      
                        <tr>
                            <td>
                            <select name="id_barang" class="form-control">
                              <?php
                              $pilihanbarang = mysqli_query($conn, "select * from barang WHERE status = 'Y'");
                              while ($fetcharray = mysqli_fetch_array($pilihanbarang)) {
                              $namabarang = $fetcharray['nama_barang'];
                              $id_barang= $fetcharray['id_barang'];
                              ?>
                              <option value="<?= $id_barang; ?>">
                                  <?= $namabarang; ?>
                              </option>
                              <?php
                              }
                              ?>
                          </select>
                            </td>
                            <td>
                            <input type="text" class="form-control" name="kuantitas">
                            
                            </td>
                            <td>
                            <div class="input-group mb-3">
                              <div class="input-group-append">
                                <span class="input-group-text">Rp.</span>
                              </div>
                              <input type="text" class="form-control" name="harga_barang">
                            </div>
                            </td>
                            <td>
                            <div class="input-group mb-3">
                              <input type="text" class="form-control" name="disc">
                              <div class="input-group-append">
                                <span class="input-group-text">%</span>
                              </div>
                            </div>
                            <td>
                              <div class="row">
                                <div class = "col">
                                    <button type="submit" name="inserttemp" class="btn btn-outline-secondary">
                                      Tambah
                                    </button>
                                </div>
                            </div>
                          </td>
                        </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              </form>
<!-- form tutup -->
                <br>
              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <h3>List Barang :</h3>
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>No.</th>
                      <th>Nama Barang</th>
                      <th>Qty</th>
                      <th>Harga Barang</th>
                      <th>Bruto</th>
                      <th>Disc</th>
                      <th>Netto</th>
                      <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php
                      if (!isset($_SESSION['temp_data_barang'])) {
                      ?>
                      <tr>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                      </tr>
                      <?php
                    } else {
                      $i = 1;
                      foreach ($_SESSION['temp_data_barang'] as $key => $value){   
                        $id_barang = $value['id_barang'];
                        $id_supplier = $value['id_supplier'];
                        $query = "SELECT nama_barang FROM barang WHERE $id_barang = id_barang";
                        $ambilBarang= mysqli_query($conn, $query);
                        $fetchBarang = mysqli_fetch_assoc($ambilBarang);
                        $nama_barang = $fetchBarang['nama_barang'];
                        $kuantitas = $value['kuantitas'];
                        $harga_barang = $value ['harga_barang'];
                        $harga_barang_formatted = number_format($harga_barang, 0, ',', '.');
                        $bruto = $value ['bruto'];
                        $bruto_formatted = number_format($bruto, 0, ',', '.');
                        $disc = $value ['disc'];
                        $netto = $value ['netto'];
                        $netto_formatted = number_format($netto, 0, ',', '.');
                        $diskon = $value ['diskon'];

                        ?>
                        <tr>
                          <td><?=$i?></td>
                          <td><?=$nama_barang?></td>
                          <td><?=$kuantitas?></td>
                          <td>Rp. <?=$harga_barang_formatted?></td>
                          <td>Rp. <?=$bruto_formatted?></td>
                          <td><?=$disc?>%</td>
                          <td>Rp. <?=$netto_formatted?></td>
                          <td>
                            <form action="modules/transaksi/pembelian/proses.php?act=deleteList" method="post">
                              <input type="hidden" name="indeks" value=<?=$key?>>
                              <button type="submit" name="deleteList"class="btn btn-danger btn-sm" ><i class = "far fa-trash-alt"></i></button>
                            </form>
                          </td>
                      </tr>
                      <?php
                      $i++;

                      $totBruto += $bruto;
                      $totDiskon += $diskon;
                      $totNetto += $netto;
                      $_SESSION['totNetto'] = $totNetto;
                      }
                      $totBruto = number_format($totBruto, 0, ',', '.');
                      $totDiskon = number_format($totDiskon, 0, ',', '.');
                      $totNetto = number_format($totNetto, 0, ',', '.');
                      
                      $jatuh_tempo_bawah = $jatuh_tempo;
                    }
                      ?>
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">
                </div>
                <!-- /.col -->
                <div class="col-6">
                  <p class="lead">Jatuh Tempo : <?=$jatuh_tempo_bawah?></p>

                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>Rp. <?=$totBruto?></td>
                      </tr>
                      <tr>
                        <th>Disc</th>
                        <td>Rp. <?=$totDiskon?></td>
                      </tr>
                      <tr>
                      </tr>
                      <tr>
                        <th>Total:</th>
                        <td>Rp. <?=$totNetto?></td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col">
                  <a href="?module=detailPembelian" rel="noopener" target="_blank" class="btn btn-default float-left  " onclick="printPage()"><i class="fas fa-print"></i> Print</a>
                    <script>
                    function printPage() {
                      window.addEventListener("load", window.print());
                    }
                    </script>
                    <form action="modules/transaksi/pembelian/proses.php?act=insertPembelian" method="post">
                      <button type="submit" name="insertPembelian" class="btn btn-success float-right">Submit</button>
                    </form>
                    <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                    <i class="fas fa-download"></i> Generate PDF
                  </button>
                </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
  