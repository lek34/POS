<?php
    $id_pembelian = $_GET['id_pembelian'];

    $query = "SELECT p.*, s.nama, s.no_rekening
                FROM pembelian p 
                INNER JOIN supplier s ON p.id_supplier = s.id_supplier
                WHERE id_pembelian = $id_pembelian
                ";
    $execQuery = mysqli_query ($conn, $query);

    $data = mysqli_fetch_assoc($execQuery);
    $nomor_faktur = $data ['no_faktur'];
    $nama_supplier = $data ['nama'];
    $no_rekening = $data ['no_rekening'];
    $tanggal = $data ['tanggal'];
    $tanggal_jatuh_tempo = $data ['jatuh_tempo'];
?>

<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Detail Pembelian</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h2>
                    <?=$nomor_faktur?>
                    <small class="float-right"><?=$tanggal?></small>
                  </h2>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    <h4>Detail :</h4>
                <b>Nama Supplier    :</b> <?=$nama_supplier?><br>
                <b>No. Rekening     :</b> <?=$no_rekening?><br>
                <b>Jatuh Tempo         :</b> <?=$tanggal_jatuh_tempo?>
                </div>
              </div>
              <br>
              <!-- /.row -->
              <form action="modules/transaksi/pembelian/proses.php?act=insertDetail" method="post">
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Nama Barang</th>
                      <th>Kuantitas</th>
                      <th>Bruto</th>
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
                            <input type="text" class="form-control" name="bruto">
                            </td>
                            <td>
                              <div class="row">
                                <div class = "col">
                                    <button type="submit" class="btn btn-outline-secondary" data-toggle="modal" data-target="#tambah">
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
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>Qty</th>
                      <th>Product</th>
                      <th>Serial #</th>
                      <th>Description</th>
                      <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                      <td>1</td>
                      <td>Call of Duty</td>
                      <td>455-981-221</td>
                      <td>El snort testosterone trophy driving gloves handsome</td>
                      <td>$64.50</td>
                    </tr>
                    <tr>
                      <td>1</td>
                      <td>Need for Speed IV</td>
                      <td>247-925-726</td>
                      <td>Wes Anderson umami biodiesel</td>
                      <td>$50.00</td>
                    </tr>
                    <tr>
                      <td>1</td>
                      <td>Monsters DVD</td>
                      <td>735-845-642</td>
                      <td>Terry Richardson helvetica tousled street art master</td>
                      <td>$10.70</td>
                    </tr>
                    <tr>
                      <td>1</td>
                      <td>Grown Ups Blue Ray</td>
                      <td>422-568-642</td>
                      <td>Tousled lomo letterpress</td>
                      <td>$25.99</td>
                    </tr>
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
                  <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
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