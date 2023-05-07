<?php
if (isset($_GET['id_pembelian'])) { ?>
  <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Detail Mobil</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
<?php
  $id_pembelian = $_GET['id_pembelian'];
  $execQuery = mysqli_query($conn, "SELECT pembelian.jatuh_tempo, pembelian.no_faktur, supplier.nama
                                    FROM pembelian
                                    JOIN supplier ON pembelian.id_supplier = supplier.id_supplier
                                    WHERE pembelian.id_pembelian = '$id_pembelian'");
  while ($data = mysqli_fetch_array($execQuery)){
    $no_faktur = $data ['no_faktur'];
    $supplier = $data ['nama'];
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
                      <label>Supplier</label>
                      <input type="text" name="no_faktur" placeholder="No Faktur" value='<?=$supplier?>' class="form-control" readonly>
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
                        $execQuery = mysqli_query($conn, "SELECT p.id_pembelian, hp.*,  b.nama_barang 
                                                          FROM pembelian p
                                                          JOIN history_pembelian hp ON p.id_pembelian = hp.id_pembelian 
                                                          JOIN barang b ON hp.id_barang = b.id_barang 
                                                          WHERE p.id_pembelian = '$id_pembelian';");
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
                                                      FROM pembelian p
                                                      WHERE p.id_pembelian = '$id_pembelian'");
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
                        $execQuery = mysqli_query($conn, "SELECT p.id_pembelian, SUM(hp.bruto) as total_bruto, SUM(hp.netto) as total_netto, SUM(hp.diskon) as total_diskon
                                                          FROM pembelian p 
                                                          JOIN history_pembelian hp ON p.id_pembelian = hp.id_pembelian 
                                                          WHERE p.id_pembelian = '$id_pembelian' 
                                                          GROUP BY p.id_pembelian;");

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
                  <a href="?module=detailPembelian" rel="noopener" target="_blank" class="btn btn-default float-left  " onclick="printPage()"><i class="fas fa-print"></i> Print</a>
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
      <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tambah Mobil</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

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
                  if (!isset($_SESSION['temp_transaksi_mobil'])) {/* pengulangan pertama */
                  ?>
                  <div class="col-sm-4 invoice-info">
                    <form action="modules/mobil/proses.php?act=inserttemp" method="post"> <!-- form buka -->
                      <label>Merk Mobil</label>
                      <input type="text" name="merk" placeholder="Merk Mobil" class="form-control">
                      <br>
                      <label>No Polisi</label>
                      <input type="text" name="plat" placeholder="No Polisi" class="form-control">
                      <br>
                      <label>Tanggal Periksa</label>
                      <input type="date" id="tanggal_periksa" name="tanggal_periksa" placeholder="Tanggal Periksa" class="form-control" required>
                      <br>
                      <label>Pemeriksa</label>
                      <input type="text" name="pemeriksa" placeholder="Pemeriksa" class="form-control">
                      <br>
                    </div>
                  </div>
                  <div class="row" style="margin : 24px 0 0 2px">
                      <button type="button" name="reset" class="btn btn-secondary align-items-center" onclick="window.location.href='modules/mobil/proses.php?act=reset'" style="height : 50px" disabled>Reset</button>
                  </div>
                  <br>
                  <?php
                  } else { 
                    $merk = $_SESSION['temp_transaksi_mobil']['merk'];
                    $plat = $_SESSION['temp_transaksi_mobil']['plat'];
                    $tanggal_periksa = $_SESSION['temp_transaksi_mobil']['tanggal_periksa'];
                    $pemeriksa = $_SESSION['temp_transaksi_mobil']['pemeriksa'];
                    $perlengkapan_array = $_SESSION['temp_data_perlengkapan'];
                  ?>
                  <div class="col-sm-4 invoice-col">
                  <form action="modules/mobil/proses.php?act=inserttemp" method="post"> 
                    <!-- form buka -->
                      <label>Merk Mobil</label>
                      <input type="text" name="merk" value='<?=$merk?>' class="form-control" readonly>
                      <br>
                      <label>No Polisi</label>
                      <input type="text" name="plat" value='<?=$plat?>' class="form-control" readonly>
                      <br>
                      <label>Tanggal Periksa</label>
                      <input type="date" name="tanggal_periksa" value='<?=$tanggal_periksa?>' class="form-control" readonly>
                      <br>
                      <label>Pemeriksa</label>
                      <input type="text" name="pemeriksa" value='<?=$pemeriksa?>' class="form-control" readonly>
                      <br>
                    </div>
                    <div class="col-sm-2 invoice-col d-md-flex justify-content-md-end">
                  </div>
                  </div>
                  <div class="row" style="margin: 24px 0 0 2px">
                      <button type="button" name="reset" class="btn btn-primary align-items-center" onclick="window.location.href='modules/mobil/proses.php?act=reset'" style="height : 50px">Reset</button>
                    </div>
                  <br>
                  
                  <?php
                  }
                  ?>
                
              <!-- /.row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped" id="tableBarang">
                  <thead>
                    <tr>
                      <th>Nama Perlengkapan</th>
                      <th>Kondisi</th>
                      <th>Deskripsi</th>
                      <th>Submit</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <td>
                      <select name="id_perlengkapan" class="form-control">
                        <?php
                        $pilihanbarang = mysqli_query($conn, "select * from mobil WHERE status = 'Y'");
                        while ($fetcharray = mysqli_fetch_array($pilihanbarang)) {
                          $perlengkapan = $fetcharray['prlkpn'];
                          $perlengkapan_id = $fetcharray['id_prlkpn']; // use a different variable name here
                        ?>
                          <option value="<?= $perlengkapan_id; ?>">
                            <?= $perlengkapan; ?>
                          </option>
                        <?php
                        }
                        ?>
                      </select>
                      </td>

    <td>
    <input type="radio" id="kondisi-baik" name="kondisi" value="Baik">
    <label for="kondisi-baik">Baik</label>

    <input type="radio" id="kondisi-rusak" name="kondisi" value="Rusak">
    <label for="kondisi-rusak">Rusak</label>
    </td>
      <td>
      <input type="radio" id="perlengkapan-ada" name="perlengkapan" value="Ada">
      <label for="perlengkapan-ada">Ada</label>

      <input type="radio" id="perlengkapan-tidakada" name="perlengkapan" value="Tidak ada">
      <label for="perlengkapan-tidakada">Tidak Ada</label>
      </td>
      
      <td>
        <div class="row">
          <div class = "col">
              <button type="submit" name="inserttemp" class="btn btn-outline-secondary" onclick="clearIsiHeaderAdded()">
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
                  <h3>List Perlengkapan :</h3>
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>No.</th>
                      <th>Nama Perlengkapan</th>
                      <th>Kondisi</th>
                      <th>Deskripsi</th>
                      <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php
                      if (!isset($_SESSION['temp_data_perlengkapan'])) {
                      ?>
                      <tr>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                      </tr>
                      <?php
                    } else {
                      $i = 1;
                      foreach ($_SESSION['temp_data_perlengkapan'] as $key => $value){   
                        $id_perlengkapan = $value['id_perlengkapan'];
                        $query = "SELECT prlkpn FROM mobil WHERE $id_perlengkapan = id_prlkpn";
                        $ambilPerlengkapan= mysqli_query($conn, $query);
                        $fetchPerlengkapan = mysqli_fetch_assoc($ambilPerlengkapan);
                        $nama_perlengkapan = $fetchPerlengkapan['prlkpn'];
                        $kondisi = $value['kondisi'];
                        $deskripsi = $value ['perlengkapan'];
                        ?>
                        <tr>
                          <td><?=$i?></td>
                          <td><?=$nama_perlengkapan?></td>
                          <td><?=$kondisi?></td>
                          <td><?=$deskripsi?></td>
                          <td>
                            <form action="modules/mobil/proses.php?act=deleteList" method="post">
                              <input type="hidden" name="indeks" value=<?=$key?>>
                              <button type="submit" name="deleteList"class="btn btn-danger btn-sm" ><i class = "far fa-trash-alt"></i></button>
                            </form>
                          </td>
                      </tr>
                      <?php
                      $i++;       
                      }
                    }
                      ?>
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col">
                  
                    <form action="modules/transaksi/pembelian/proses.php?act=insertPembelian" method="post">
                      <button type="submit" name="insertPembelian" class="btn btn-success float-right">Submit</button>
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