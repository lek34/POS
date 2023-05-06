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
                    $query = "SELECT MAX(nomor_masuk) as last_masuk , nomor_bukti from cash_masuk;";
                    $execQuery = mysqli_query($conn, $query);
                    $fetchQuery = mysqli_fetch_array($execQuery);
                    $date = date('ym');
                    $current_month = date('m');
                    $stored_month = substr($fetchQuery['nomor_bukti'], 5, 2); // extract the stored month from the last ID
                    $next_number = 1; // Set a default value for next_number before the if-else block
                    if ($current_month == $stored_month) {
                        // Increment the next number by 1 if the current month is the same as the stored month
                        $next_number = (int)$fetchQuery['last_transaksi'] + 1;
                    }
                    $date = date('ym');
                    $no_butki = 'BM/' . $date .'/'. str_pad($next_number, 4, '0', STR_PAD_LEFT);


                  if (!isset($_SESSION['temp_transaksi_beli'])) {/* pengulangan pertama */
                  ?>
                  <div class="col-sm-6 invoice-info">
                    <form action="modules/transaksi/pembelian/proses.php?act=inserttemp" method="post"> <!-- form buka -->
                        <div class="row">
                            <div class="col-4">
                                <label>No. Bukti : </label>
                                <input type="text" name = "no_butki" value=<?=$no_butki?> class="form-control" readonly>
                            </div>
                            <div class="col-2"></div>
                            <div class="col-6">
                                <label>tanggal : </label>
                                <input type="date" name = "tanggal_masuk" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label>Customer</label>
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
                          ?>
                          <option value="<?= $id; ?>">
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