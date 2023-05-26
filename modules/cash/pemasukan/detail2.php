<?php
if (isset($_GET['id_penjualan'])) { ?>
  <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Pemasukan Cash</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
<?php
  $id_penjualan = $_GET['id_penjualan'];
  $execQuery = mysqli_query($conn, "SELECT penjualan.jatuh_tempo, penjualan.no_faktur, customer.nama
                                    FROM penjualan
                                    JOIN customer ON penjualan.id_customer = customer.id_customer
                                    WHERE penjualan.id_penjualan = '$id_penjualan'");
  while ($data = mysqli_fetch_array($execQuery)){
    $no_faktur = $data ['no_faktur'];
    $customer = $data ['nama'];
    $jatuh_tempo = $data ['jatuh_tempo'];
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
                  <div class="col-sm-4 invoice-col">
                      <label>No. Faktur</label>
                      <input type="text" name="no_faktur" placeholder="No Faktur" value='<?=$no_faktur?>' class="form-control" readonly>
                      <br>
                      <label>Customer</label>
                      <input type="text" name="no_faktur" placeholder="No Faktur" value='<?=$customer?>' class="form-control" readonly>
                      <br>
                      <label>Jatuh Tempo</label>
                      <input type="date" id="jatuh_tempo" value="<?=$jatuh_tempo?>" name="jatuh_tempo" placeholder="jatuhtempo" class="form-control" readonly>
                    </div>
                  </div>
                  <br>
      <?php
        }
      ?>        
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
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $i = 1;
                        $execQuery = mysqli_query($conn, "SELECT p.id_penjualan, hp.*,  b.nama_barang 
                                                          FROM penjualan p
                                                          JOIN history_penjualan hp ON p.id_penjualan = hp.id_penjualan 
                                                          JOIN barang b ON hp.id_barang = b.id_barang 
                                                          WHERE p.id_penjualan = '$id_penjualan';");
                        while ($data = mysqli_fetch_array($execQuery)){
                          $nama_barang = $data ['nama_barang'];
                          $kuantitas  = $data ['kuantitas'];
                          $harga_barang = number_format($data ['harga_barang'], 0, ',', '.');
                          $disc = number_format($data ['disc'], 0, ',', '.');
                          $bruto = number_format($data ['bruto'], 0, ',', '.');
                          $netto = number_format($data ['netto'], 0, ',', '.');
                    ?>
                    <tr>
                        <td><?=$i?></>
                        <td><?=$nama_barang?></td>
                        <td><?=$kuantitas?></td>
                        <td>Rp. <?=$harga_barang?></td>
                        <td>Rp. <?=$bruto?></td>
                        <td><?=$disc?>%</td>
                        <td>Rp. <?=$netto?></td>
                    </tr>
                    <?php
                    $i++;
                      }
                    ?>
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
              <br>
              <br>
              <br>
              <br>
              <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">
                </div>
                <!-- /.col -->
                <div class="col-6">
                <?php
                    $execQuery = mysqli_query($conn, "SELECT p.jatuh_tempo
                                                      FROM penjualan p
                                                      WHERE p.id_penjualan = '$id_penjualan'");
                    while ($data = mysqli_fetch_array($execQuery)){
                      $jatuh_tempo = $data ['jatuh_tempo'];
                  ?>
                  <p class="lead">Jatuh Tempo : <?=$jatuh_tempo?></p>
                  <?php
                    }
                  ?>
                  <div class="table-responsive">
                    <table class="table">
                    <?php
                        $i = 1;
                        $execQuery = mysqli_query($conn, "SELECT p.id_penjualan, SUM(hp.bruto) as total_bruto, SUM(hp.netto) as total_netto, SUM(hp.diskon) as total_diskon
                                                          FROM penjualan p 
                                                          JOIN history_penjualan hp ON p.id_penjualan = hp.id_penjualan 
                                                          WHERE p.id_penjualan = '$id_penjualan' 
                                                          GROUP BY p.id_penjualan;");

                        while ($data = mysqli_fetch_array($execQuery)){
                          $totBruto =  number_format($data ['total_bruto'], 0, ',', '.');
                          $totDiskon =  number_format($data ['total_diskon'], 0, ',', '.');
                          $totNetto  = number_format($data ['total_netto'], 0, ',', '.');
                    ?>
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
                      <?php
                        }
                      ?>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col">
                  <a href="?module=detailPenjualan" rel="noopener" target="_blank" class="btn btn-default float-left  " onclick="printPage()"><i class="fas fa-print"></i> Print</a>
                    <script>
                    function printPage() {
                      window.addEventListener("load", window.print());
                    }
                    </script>
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
  
  <?php 
      } 
  else  { ?>
      <?php
        if (isset($_GET['alert'])) {
          $alert =  $_GET['alert'];
          switchAlert($alert);
          }
      ?>
      <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Pemasukan Cash</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>




 <!--Penambahan-->   
 <!-- generate nomor Faktur -->   
<?php
  $totBruto = 0;
  $totDiskon = 0;
  $totNetto = 0;
  $tanggal_bawah = "DD/MM/YYYY";        
  $query = "SELECT MAX(nomor_masuk) as last_masuk , bukti_masuk from cash_masuk;";
  $execQuery = mysqli_query($conn, $query);
  $fetchQuery = mysqli_fetch_array($execQuery);
  $date = date('ym');
  $current_month = date('m');
  $stored_month = substr($fetchQuery['bukti_masuk'], 5, 2); // extract the stored month from the last ID
  $next_number = 1; // Set a default value for next_number before the if-else block
  if ($current_month == $stored_month) {
      // Increment the next number by 1 if the current month is the same as the stored month
      $next_number = (int)$fetchQuery['last_masuk'] + 1;
  }
  $date = date('ym');
  $no_bukti = 'CM/' . $date .'/'. str_pad($next_number, 4, '0', STR_PAD_LEFT);
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
              <div class="row">
                
                  <?php
                  if (!isset($_SESSION['temp_transaksi_masuk'])) {/* pengulangan pertama */
                  ?>
                  <div class="col-sm-4 invoice-info">
                    <form action="modules/cash/pemasukan/proses.php?act=inserttemp" method="post"> <!-- form buka -->
                      <input type="hidden" name="last_masuk" placeholder="You Shouldn't See This" value='<?= $next_number?>' class="form-control" hidden>
                      <label>No. Bukti</label>
                      <input type="text" name="no_bukti" placeholder="No Bukti" value='<?= $no_bukti?>' class="form-control" readonly>
                      <br>
                      <label>Terima dari</label>
                        <select name="option" id="option" class="form-control">
                        <option value="customer">Customer</option>
                        <option value="lainnya">Lainnya</option>
                        </select>
                      <br>
                        <div id="customerFields">
                        <label>Customer</label>
                        <select name="id_customer" class="form-control">
                        <?php
                        $pilihancustomer = mysqli_query($conn, "select * from customer WHERE status = 'Y'");
                        while ($fetcharray = mysqli_fetch_array($pilihancustomer)) {
                          $namacustomer = $fetcharray['nama'];
                          $idcus = $fetcharray['id_customer'];
                          $selected = ($idcus == $customer) ? "selected" : "";
                          ?>
                          <option value="<?= $idcus; ?>" <?= $selected ?>>
                            <?= $namacustomer; ?>
                          </option>
                          <?php
                        }
                        ?>
                        </select>
                        </div>
                        <div id="lainnyaFields" style="display: none;">
                        <label>Lainnya</label>
                        <input type="text" name="lainnya" class="form-control">
                        </div>
                        <br>
                        <label>Tanggal</label>
                        <input type="date" id="tanggal" name="tanggal" placeholder="jatuhtempo" class="form-control">
                        <br>
                        <label>Kendaraan</label>
                        <input type="text" id="kendaraan" name="kendaraan" placeholder="Kendaraan" class="form-control" required>
                        <br>
                        <label>Ke Kas</label>
                        <select name="id_akun" class="form-control">
                            <?php
                                $pilihanCustomer = mysqli_query($conn, "select * from akun WHERE status = 'Y'");
                                while ($fetcharray = mysqli_fetch_array($pilihanCustomer)) {
                                $namaAkun = $fetcharray['nama_akun'];
                                $idAkun = $fetcharray['id_akun'];
                                ?>
                                <option value="<?= $idAkun; ?>">
                                    <?= $namaAkun; ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-2 invoice-col d-md-flex justify-content-md-end">
                    
                  </div>
                  <div class="col-sm-5" style="margin-left : 24px;">
                    </div>
                  </div>
                  <div class="row" style="margin : 24px 0 0 2px">
                      <button type="button" name="reset" class="btn btn-secondary align-items-center" onclick="window.location.href='modules/cash/pemasukan/proses.php?act=reset'" style="height : 50px" disabled>Reset</button>
                    </div>
                  <br>
                  <?php
                  } else { 
                    $last_masuk = $_SESSION['temp_transaksi_masuk']['last_masuk'];
                    $customer = $_SESSION['temp_transaksi_masuk']['id_customer'];
                    $kendaraan = $_SESSION['temp_transaksi_masuk']['kendaraan'];
                    $akun = $_SESSION['temp_transaksi_masuk']['akun'];
                    $option = $_SESSION['temp_transaksi_masuk']['option'];
                    $lainnya = $_SESSION['temp_transaksi_masuk']['lainnya'];
                    $tanggal = $_SESSION['temp_transaksi_masuk']['tanggal'];
                  ?>
                  <div class="col-sm-4 invoice-col">
                  <form action="modules/cash/pemasukan/proses.php?act=inserttemp" method="post"> <!-- form buka -->
                      <input type="hidden" name="nomor_transaksi" placeholder="You Shouldn't See This" value='<?= $next_number?>' class="form-control" hidden>
                      <label>No. Bukti</label>
                      <input type="text" name="no_bukti" placeholder="No Faktur" value='<?=$no_bukti?>' class="form-control" readonly>
                      <br>
                      <?php
                        if($option == "customer") { ?>
                        <label>Customer</label>
                        <select name="id_customer" class="form-control" style="pointer-events: none; background-color: #e9ecef;">
                          <?php
                          $pilihancustomer = mysqli_query($conn, "select * from customer WHERE status = 'Y'");
                          while ($fetcharray = mysqli_fetch_array($pilihancustomer)) {
                            $namacustomer = $fetcharray['nama'];
                            $idcus = $fetcharray['id_customer'];
                            $selected = ($idcus == $customer) ? "selected" : "";
                            ?>
                            <option value="<?= $idcus; ?>" <?= $selected ?>>
                              <?= $namacustomer; ?>
                            </option>
                            <?php
                          }
                          ?>
                        </select>
                      <?php
                        }else{ ?>
                          <label>Lainnya</label>
                          <input type="text" id="lain" value="<?=$lainnya?>" name="lainnya" placeholder="lain" class="form-control" readonly>
                        <?php
                        }
                      ?>
                      <br>
                      <label>Tanggal</label>
                      <input type="date" id="tanggal" value="<?=$tanggal?>" name="jatuh_tempo" placeholder="tanggal" class="form-control" readonly>
                      <br>
                      <label>Kendaraan</label>
                      <input type="text" id="kendaraan" value="<?=$kendaraan?>" name="kendaraan" placeholder="kendaraan" class="form-control" readonly>
                      <br>
                        <label>Ke Kas</label>
                        <select name="id_akun" class="form-control" style="pointer-events: none; background-color: #e9ecef;">
                            <?php
                                $pilihanCustomer = mysqli_query($conn, "select * from akun WHERE status = 'Y'");
                                while ($fetcharray = mysqli_fetch_array($pilihanCustomer)) {
                                $namaAkun = $fetcharray['nama_akun'];
                                $idAkun = $fetcharray['id_akun'];
                                $selected = ($idAkun == $akun) ? "selected" : "";
                                ?>
                                <option value="<?= $idAkun; ?>" <?= $selected ?>>
                                    <?= $namaAkun; ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-2 invoice-col d-md-flex justify-content-md-end">
                    
                  </div>
                    </div>
                  </div>
                  <div class="row" style="margin : 24px 0 0 2px">
                      <button type="button" name="reset" class="btn btn-primary align-items-center" onclick="window.location.href='modules/cash/pemasukan/proses.php?act=reset'" style="height : 50px">Reset</button>
                    </div>
                  <br>
                  
                  <?php
                  }
                  ?>
                
              <!-- /.row -->
              <div class="row">
                <div class="col-12 table-responsive">
                <h3>List Barang :</h3>
                  <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Nama Barang</th>
                      <th>Satuan</th>
                      <th>Qty</th>
                      <th>Margin</th>
                      <th>Harga Barang</th>
                      <th>Disc</th>
                      <th>Submit</th>
                    </tr>
                    </thead>
                    <tbody>
                      
                        <tr>
                            <td>
                            <select name="id_barang_penjualan"  id="id_barang_penjualan" class="form-control" onchange="updateUOMpenjualan(this.value)">
                            <option value="">Select an item</option>
                              <?php
                              $pilihanbarang = mysqli_query($conn, "select * from barang WHERE status = 'Y'");
                              while ($fetcharray = mysqli_fetch_array($pilihanbarang)) {
                              $namabarang = $fetcharray['nama_barang'];
                              $barang_id = $fetcharray['id_barang'];
                              $harga_modal= $fetcharray['harga_modal'];
                              ?>
                              <option value="<?= $barang_id; ?>" data-harga-modal="<?= $harga_modal; ?>">
                                  <?= $namabarang; ?>
                              </option>
                               
                              <?php
                              }
                              ?>
                          </select>
                            </td>
                            <td>
                            <select name="uom" class="form-control" id="uom_select_penjualan">
                            </select>
                            <input type="text" class="form-control" name="satuankecil" id="satuankecil_input" hidden>
                          </td>
                            <td>
                              <input type="text" class="form-control" name="kuantitas" required>
                            </td>

                            <td>
                              <input type="hidden" id="costPrice" value="<?= $harga_modal; ?>">
                              <input type="text" class="form-control" name="margin" id="margin" required>
                        
                            </td>

                            <td>
                            <div class="input-group mb-3">
                              <div class="input-group-append">
                              </div>
                              <input type="text" class="form-control" name="harga_barang" class="harga_barang" id="harga_barang" required>
                            </div>
                            </td>
                            
                            <td>
                            <div class="input-group mb-3">
                              <input type="text" class="form-control" name="disc" value="0" required>
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
                      if (!isset($_SESSION['temp_data_jual'])) {
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
                      foreach ($_SESSION['temp_data_jual'] as $key => $value){   
                        $id_barang = $value['id_barang'];
                        $id_customer = $value['id_customer'];
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
                          <td><a href="main.php?module=detailPenjualan&id_barang=<?=$id_barang?>" style="text-decoration: none; color : black;"><?=$nama_barang?></a></td>
                          <td><?=$kuantitas?></td>
                          <td>Rp. <?=$harga_barang_formatted?></td>
                          <td>Rp. <?=$bruto_formatted?></td>
                          <td><?=$disc?>%</td>
                          <td>Rp. <?=$netto_formatted?></td>
                          <td>
                            <form action="modules/cash/pemasukan/proses.php?act=deleteList" method="post">
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
                      
                      $tanggal_bawah = $tanggal;
                    }
                      ?>
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <h3>Jasa</h3>
                    <table class="table table-striped">
                      <thead>
                        <th>Nama Jasa</th>
                        <th>Harga Jasa</th>
                        <th>Deskripsi</th>
                        <th>Submit</th>
                      </thead>
                      <tbody>
                        <form action="modules/cash/pemasukan/proses.php?act=insertTempJasa" method="post">
                          <td>
                          <select name="id_jasa" class="form-control">
                          <option value=""></option>
                              <?php
                              $pilihanjasa = mysqli_query($conn, "select * from jasa WHERE status = 'Y'");
                              while ($fetcharray = mysqli_fetch_array($pilihanjasa)) {
                              $namajasa = $fetcharray['nama_jasa'];
                              $id_jasa = $fetcharray['id_jasa'];
                              ?>
                              <option value="<?= $id_jasa; ?>">
                                  <?= $namajasa; ?>
                              </option>
                               
                              <?php
                              }
                              ?>
                          </select>
                        </td>
                        <td>
                          <input type="text" class="form-control" name="harga_jasa">
                        </td>
                        <td>
                          <input type="text" class="form-control" name="deskripsi_jasa">
                        </td>
                        <td>
                          <button type="submit" name="insertTempJasa" class="btn btn-outline-secondary">
                              Tambah
                          </button>
                        </td>
                        </form>
                      </tbody>
                    </table>
                </div>
              </div>
              <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <th>No.</th>
                        <th>Nama Jasa</th>
                        <th>Harga Jasa</th>
                        <th>Deskripsi</th>
                        <th>Delete</th>
                      </thead>
                      <tbody>
                        <?php
                        if (!isset($_SESSION['temp_jasa'])) {
                          ?>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                          <?php
                        } else {
                          $i = 1;
                          foreach ($_SESSION['temp_jasa'] as $key => $value){
                            $id_jasa = $value['id_jasa'];
                            $query = "SELECT nama_jasa FROM jasa WHERE $id_jasa = id_jasa";
                            $ambilJasa= mysqli_query($conn, $query);
                            $fetchJasa = mysqli_fetch_assoc($ambilJasa);
                            $namajasa = $fetchJasa['nama_jasa'];
                            $harga_jasa = $value ['harga_jasa'];
                            $deskripsi = $value ['deskripsi'];
                          }   
                          ?>
                          <td><?=$i?></td>
                          <td><?=$namajasa?></td>
                          <td><?=$harga_jasa?></td>
                          <td><?=$deskripsi?></td>
                          <td>
                            <form action="modules/cash/pemasukan/proses.php?act=deleteJasa" method="post">
                              <input type="hidden" name="indeks" value=<?=$key?>>
                              <button type="submit" name="deleteList"class="btn btn-danger btn-sm" ><i class = "far fa-trash-alt"></i></button>
                            </form>
                          </td>
                          <?php
                          $i++;
                        }
                        ?>
                      </tbody>
                    </table>
                </div>
              </div>

              <div class="row" style="margin-top : 32px;">
                <!-- accepted payments column -->
                <div class="col-3">
                <form action="modules/cash/pemasukan/proses.php?act=jumlah" method="post">
                <div class="row">
                        <label>Jumlah : </label>
                        <input type="text" name="jumlah" placeholder="Jumlah" class="form-control" >
                    </div>
                    <br>
                    <div class="row">
                        <label>Keterangan : </label>
                        <input type="text" name="keterangan" placeholder="Keterangan" class="form-control" >
                    </div>
                    <br>
                    <div class="row">
                            <button type="submit" name="inserttemp" class="btn btn-outline-secondary">
                                Tambah
                            </button>
                    </div>
                    </form>
                </div>
                
                <div class="col-3">
                </div>
                
                <!-- /.col -->
                <div class="col-3">
                  <p class="lead">Tanggal : <?=$tanggal_bawah?></p>
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
              <div class="row">
                <div class="col">
                    <form action="modules/cash/pemasukan/proses.php?act=insertPenjualan" method="post">
                      <button type="submit" name="insertPenjualan" class="btn btn-success float-right">Submit</button>
                    </form>
                </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <?php 
  } 
?>

