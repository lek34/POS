<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tambah Pembelian</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
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
                <div class="col-sm-4 invoice-col">
                <form action="modules/transaksi/pembelian/proses.php?act=insertPembelian" method="post"> <!-- form buka -->
                  <input type="hidden" name="nomor_transaksi" placeholder="You Shouldn't See This" value='<?= $next_number?>' class="form-control" hidden>
                  <label>No. Faktur</label>
                  <input type="text" name="" placeholder="No Faktur" value='<?= $newFaktur?>' class="form-control" readonly>
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
                  <input type="date" id="jatuh_tempo" name="jatuh_tempo" placeholder="jatuhtempo" class="form-control" required>
                </div>
              </div>
              <br>
              <!-- /.row -->
            
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                  <thead id="table-detail">
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
                              <input type="hidden" name="id_pembelian" value="<?=$id_pembelian?>">
                            <input type="text" class="form-control" name="kuantitas">
                            </td>
                            <td>
                            <input type="text" class="form-control" name="harga_barang">
                            </td>
                            <td>
                            <input type="text" class="form-control" name="disc" value="0">
                            </td>
                            <td>
                              <div class="row">
                                <div class = "col">
                                    <button type="submit" name="insertDetail" class="btn btn-outline-secondary">
                                        <i class="fa fa-plus-square"></i> Tambah
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
                        $ambildatatemp = "SELECT t.*, b.nama_barang
                        FROM temp_beli t
                        INNER JOIN barang b ON t.id_barang = b.id_barang
                        ";
                        $execdatatemp = mysqli_query($conn, $ambildatatemp);

                        while ($datatemp = mysqli_fetch_array($execdatatemp)) {
                          $nama_barang = $datatemp ['nama_barang'];
                          $kuantitas = $datatemp ['kuantitas'];
                          $harga_barang = number_format($datatemp['harga_barang'], 0, ',', '.');
                          $bruto = number_format($datatemp['bruto'], 0, ',', '.');
                          $disc = number_format($datatemp['disc'], 0, ',', '.');
                          $netto = number_format($datatemp['netto'], 0, ',', '.');
                          ?>
                          <tr>
                            <td><?=$nama_barang?></td>
                            <td><?=$kuantitas?></td>
                            <td><?=$harga_barang?></td>
                            <td><?=$bruto?></td>
                            <td><?=$disc?></td>
                            <td><?=$netto?></td>
                          </tr>
                        <?php
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
                  <p class="lead">Payment Methods:</p>
                  <img src="dist/img/credit/visa.png" alt="Visa">
                  <img src="dist/img/credit/mastercard.png" alt="Mastercard">
                  <img src="dist/img/credit/american-express.png" alt="American Express">
                  <img src="dist/img/credit/paypal2.png" alt="Paypal">

                  <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
                    plugg
                    dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                  </p>
                </div>
                <!-- /.col -->
                <div class="col-6">
                  <p class="lead">Amount Due 2/22/2014</p>

                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>$250.30</td>
                      </tr>
                      <tr>
                        <th>Tax (9.3%)</th>
                        <td>$10.34</td>
                      </tr>
                      <tr>
                        <th>Shipping:</th>
                        <td>$5.80</td>
                      </tr>
                      <tr>
                        <th>Total:</th>
                        <td>$265.24</td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                <a href="?module=detailPembelian&id_pembelian=<?=$id_pembelian?>" rel="noopener" target="_blank" class="btn btn-default" onclick="printPage()"><i class="fas fa-print"></i> Print</a>
                    <script>
                    function printPage() {
                      window.addEventListener("load", window.print());
                    }
                    </script>
                  <button type="button" name="insertPembelian" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                    Payment
                  </button>
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
  