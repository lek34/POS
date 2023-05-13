<div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h2>
                    Input Pengeluaran
                  </h2>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row gy-5">
                  <?php
                    $query = "SELECT MAX(nomor_keluar) as last_keluar , bukti_keluar from cash_keluar;";
                    $execQuery = mysqli_query($conn, $query);
                    $fetchQuery = mysqli_fetch_array($execQuery);
                    $date = date('ym');
                    $current_month = date('m');
                    $stored_month = substr($fetchQuery['bukti_keluar'], 5, 2); // extract the stored month from the last ID
                    $next_number = 1; // Set a default value for next_number before the if-else block
                    if ($current_month == $stored_month) {
                        // Increment the next number by 1 if the current month is the same as the stored month
                        $next_number = (int)$fetchQuery['last_keluar'] + 1;
                    }
                    $date = date('ym');
                    $no_bukti = 'CK/' . $date .'/'. str_pad($next_number, 4, '0', STR_PAD_LEFT);

                    ?>
                  <div class="col-12">
                    <form action="modules/transaksi/pembelian/proses.php?act=inserttemp" method="post"> <!-- form buka -->
                        <div class="row">
                            <div class="col-2">
                                <label>No. Bukti : </label>
                                <input type="text" name = "no_bukti" value=<?=$no_bukti?> class="form-control" readonly>
                            </div>
                            <div class="col-2"></div>
                            <div class="col-3">
                                <label>Tanggal : </label>
                                <input type="date" name = "tanggal_masuk" class="form-control">
                            </div>
                            <div class="col-3">
                                <label for="">No. Jurnal :</label>
                                <input type="text" name="no_jurnal" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <label for="">Ke : </label>
                            <div class="form-group clearfix">
                              <div class="icheck-primary d-inline">
                                <input type="radio" id="radioPrimary1" name="terimaDari" value="customer"checked>
                                <label for="radioPrimary1">
                                    <a href="main.php?module=detailCashKeluar&tampilan=penjualan" style>
                                        Supplier
                                    </a>
                                </label>
                              </div>
                              <div class="icheck-primary d-inline" style="margin-left : 12px  ">
                                <input type="radio" id="radioPrimary2" name="terimaDari" value="lainnya">
                                <label for="radioPrimary2">
                                <a href="main.php?module=detailCashKeluar&tampilan=lain" style>
                                        Lainnya
                                    </a>
                                </label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <?php
                        if (isset($_GET['tampilan'])) { ?>
                             <?php 
                             if ($_GET['tampilan'] === 'penjualan') { ?>

<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tambah Pembelian</h1>
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
                  if (!isset($_SESSION['temp_transaksi_beli'])) {/* pengulangan pertama */
                  ?>
                  <div class="col-sm-4 invoice-info">
                    <form action="modules/transaksi/pembelian/proses.php?act=inserttemp" method="post"> <!-- form buka -->
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
                   
                    </div>
                    <div class="col-sm-2"></div>
                    <div class="col-sm-5" style="margin-left : 24px; ">
                      <div class="row">
                        <h5><b>History Pembelian Terdahulu</b></h5>
                      </div>
                      <div class="row" style="margin-top : 24px">
                      <div class="col-12">
                          <label>Nama Barang</label>
                          <input type="text" placeholder = "Nama Barang" value="" class="form-control" readonly>
                        </div>
                      </div>
                      <div class="row" style="margin-top : 24px">
                      <div class="col-6">
                          <label>No. Faktur</label>
                          <input type="text" placeholder = "PB/XXXX/XXXX" value="" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                          <label>Harga Beli</label>
                          <input type="text" placeholder = "Rp." value="" class="form-control" readonly>
                        </div>
                    </div>
                      <div class="row" style="margin-top : 24px">
                      <div class="col-4">
                          <label>Tanggal</label>
                          <input type="text"placeholder="DD/MM/YYYY" value="" class="form-control" readonly>
                        </div>
                        <div class="col-4">
                          <label>Kuantitas</label>
                          <input type="text" placeholder="0" value="" class="form-control" readonly>
                        </div>
                        <div class="col-4">
                          <label>Stock Sekarang</label>
                          <input type="text" placeholder="0" class="form-control" readonly>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row" style="margin : 24px 0 0 2px">
                      <button type="button" name="reset" class="btn btn-secondary align-items-center" onclick="window.location.href='modules/transaksi/pembelian/proses.php?act=reset'" style="height : 50px" disabled>Reset</button>
                  </div>
                  <br>
                  <?php
                  } else { 
                    $no_transaksi = $_SESSION['temp_transaksi_beli']['no_transaksi'];
                    $supplier = $_SESSION['temp_transaksi_beli']['id_supplier'];
                    $jatuh_tempo = $_SESSION['temp_transaksi_beli']['jatuh_tempo'];
                    $barang_array = $_SESSION['temp_data_beli'];
                    // Get the latest index of the temp_data_beli array
                    $nama_barang = "Nama Barang";
                    $total_kuantitas = "";
                    $harga_barang = "0";
                    $no_faktur = "PB/XXXX/XXXX";
                    $tanggal = "";
                    $kuantitas = "0";
                    if (isset($_GET['id_barang'])) {
                      $id_barang = $_GET['id_barang'];
                      $execQuery = mysqli_query($conn, "SELECT max_hp.id_barang, b.nama_barang, b.kuantitas as stok_sekarang, SUM(hp.kuantitas) as total_kuantitas, hp.harga_barang, pb.no_faktur, pb.tanggal 
                                                      FROM barang b 
                                                      INNER JOIN 
                                                      ( SELECT id_barang, MAX(id_pembelian) as max_id_pembelian FROM history_pembelian GROUP BY id_barang ) max_hp 
                                                      ON b.id_barang = max_hp.id_barang 
                                                      INNER JOIN history_pembelian hp ON hp.id_barang = max_hp.id_barang AND hp.id_pembelian = max_hp.max_id_pembelian 
                                                      INNER JOIN pembelian pb ON pb.id_pembelian = hp.id_pembelian WHERE max_hp.id_barang = '$id_barang' 
                                                      GROUP BY max_hp.id_barang, b.nama_barang;");
                  
                      while ($row = mysqli_fetch_array($execQuery, MYSQLI_ASSOC)) {
                          // Access the values using the column names
                          $id_barang = $row['id_barang'];
                          $nama_barang = $row['nama_barang'];
                          $total_kuantitas = $row['total_kuantitas'];
                          $harga_barang = $row['harga_barang'];
                          $no_faktur = $row['no_faktur'];
                          $tanggal = $row['tanggal'];
                          $kuantitas = $row['stok_sekarang'];
                      }
                  }

                  
                  ?>
                  <div class="col-sm-4 invoice-col">
                  <form action="modules/transaksi/pembelian/proses.php?act=inserttemp" method="post"> 
                    <!-- form buka -->
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
                    <div class="col-sm-2 invoice-col d-md-flex justify-content-md-end">
                  </div>
                  <!-- History Pembelian Terdahulu -->
                  <div class="col-sm-5" style="margin-left : 24px;">
                      <div class="row">
                        <h5><b>History Pembelian Terdahulu</b></h5>
                      </div>
                      <div class="row" style="margin-top : 24px">
                      <div class="col-12">
                          <label>Nama Barang</label>
                          <input type="text" value="<?=$nama_barang?>" class="form-control" readonly>
                        </div>
                        </div>
                        <div class="row" style="margin-top : 24px ;">
                        <div class="col-6">
                          <label>No. Faktur</label>
                          <input type="text" value="<?=$no_faktur?>" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                          <label>Harga Beli</label>
                          <?php
                          $harga_barang_formatted = number_format($harga_barang, 0, ',', '.');
                          ?>
                          <input type="text" value="Rp. <?=$harga_barang_formatted?>" class="form-control" readonly>
                        </div>
                      </div>
                      <div class="row" style="margin-top : 24px">
                      <div class="col-4">
                          <label>Tanggal</label>
                          <input type="text"placeholder="DD/MM/YYYY" value="<?=$tanggal?>" class="form-control" readonly>
                        </div>
                        <div class="col-4">
                          <label>Kuantitas</label>
                          <input type="text" placeholder="0" value="<?=$total_kuantitas?>" class="form-control" readonly>
                        </div>
                        <div class="col-4">
                          <label>Stock Sekarang</label>
                          <input type="text" placeholder="0" value="<?=$kuantitas?>" class="form-control" readonly>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row" style="margin: 24px 0 0 2px">
                      <button type="button" name="reset" class="btn btn-primary align-items-center" onclick="window.location.href='modules/transaksi/pembelian/proses.php?act=reset'" style="height : 50px">Reset</button>
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
                      <th>Nama Barang</th>
                      <th>Satuan</th>
                      <th>Qty</th>
                      <th>Harga Barang</th>
                      <th>Disc</th>
                      <th>Submit</th>
                    </tr>
                    </thead>
                    <tbody>
                      
                        <tr>
                        <td>
  <select name="id_barang" class="form-control" onchange="updateUOMpembelian(this.value)">
  <option value="">Select an item</option>
    <?php
    $pilihanbarang = mysqli_query($conn, "select * from barang WHERE status = 'Y'");
    while ($fetcharray = mysqli_fetch_array($pilihanbarang)) {
      $namabarang = $fetcharray['nama_barang'];
      $barang_id = $fetcharray['id_barang']; // use a different variable name here
    ?>
      <option value="<?= $barang_id; ?>">
        <?= $namabarang; ?>
      </option>
    <?php
    }
    ?>
  </select>
</td>
<td>
  <select name="uom" class="form-control" id="uom_select">
  </select>
  <input type="text" class="form-control" name="satuan_kecil" id="satuankecil_input" hidden>
</td>
  <td>
  <input type="text" class="form-control" name="kuantitas" id="kuantitaspembelian_mask" oninput="formatNumber('kuantitaspembelian_mask')" required>
  </td>
      <td>
      <div class="input-group mb-3">
        <div class="input-group-append">
        </div>
        <input type="text" class="form-control" name="harga_barang" id="hargapembelian_mask" oninput="formatCurrency('hargapembelian_mask')" required>
      </div>
      </td>
      <td>
      <div class="input-group mb-3">
        <input type="text" class="form-control" name="disc" id="discpembelian_mask" oninput="formatNumber('discpembelian_mask')" required>
        <div class="input-group-append">
          <span class="input-group-text">%</span>
        </div>
      </div>
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
                      if (!isset($_SESSION['temp_data_beli'])) {
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
                      foreach ($_SESSION['temp_data_beli'] as $key => $value){   
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
                          <td><a href="main.php?module=detailPembelian&id_barang=<?=$id_barang?>" style="text-decoration: none; color : black;"><?=$nama_barang?></a></td>
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
                            else { ?>
                                                <div class="row">
                                                <div class="col-12">
                                                    <label for="">Nama : </label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-2">
                                                <select name="id_customer" class="form-control">
                                                    <?php
                                                        $pilihanCustomer = mysqli_query($conn, "select * from customer WHERE status = 'Y'");
                                                        while ($fetcharray = mysqli_fetch_array($pilihanCustomer)) {
                                                        $namaCustomer = $fetcharray['nama'];
                                                        $idCustomer = $fetcharray['id_customer'];
                                                        ?>
                                                        <option value="<?= $idCustomer; ?>">
                                                            <?= $namaCustomer; ?>
                                                        </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" class="form-control" >
                                                </div>
                                                <div class="col-1">
                                                    Posisi Kredit
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="">Dari Kas : </label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-1">
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
                                                <div class="col-9">
                                                    <input type="text" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="">Kendaraan : </label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-2">
                                                <select name="id_kendaraan" class="form-control">
                                                    <?php
                                                        $pilihanCustomer = mysqli_query($conn, "select * from customer WHERE status = 'Y'");
                                                        while ($fetcharray = mysqli_fetch_array($pilihanCustomer)) {
                                                        $namaCustomer = $fetcharray['nama'];
                                                        $idCustomer = $fetcharray['id_customer'];
                                                        ?>
                                                        <option value="<?= $idCustomer; ?>">
                                                            <?= $namaCustomer; ?>
                                                        </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="">Keterangan : </label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="row" style="margin : 24px 0 0 2px">
                                        <button type="button" name="reset" class="btn btn-secondary align-items-center" onclick="window.location.href='modules/transaksi/pembelian/proses.php?act=reset'" style="height : 50px" disabled>Reset</button>
                                    </div>
                                    <br>
                                </div>
                                <br>
                                <br>
                                <div class="row">
                                        <div class="col-12 table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                    <th>Account</th>
                                                    <th>Nama Perkiraan</th>
                                                    <th>Keterangan Jurnal/Referensi</th>
                                                    <th>Jumlah</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                             <?php
                            }
                            ?>
                            
                        <?php
                        }
                        ?>

</div>

              <!-- /.row -->