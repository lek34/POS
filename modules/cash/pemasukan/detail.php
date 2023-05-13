<div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h2>
                    Input Pemasukan
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
                    $no_bukti = 'CM/' . $date .'/'. str_pad($next_number, 4, '0', STR_PAD_LEFT);

                    ?>
                  <div class="col-12">
                    <form action="modules/cash/pemasukan/proses.php?act=insertTempCashMasuk" method="post"> <!-- form buka -->
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
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <label for="">Terima Dari : </label>
                            <div class="form-group clearfix">
                              <div class="icheck-primary d-inline">
                                <input type="radio" id="radioPrimary1" name="terimaDari" value="customer"checked>
                                <label for="radioPrimary1">
                                  Customer
                                </label>
                              </div>
                              <div class="icheck-primary d-inline" style="margin-left : 12px  ">
                                <input type="radio" id="radioPrimary3" name="terimaDari" value="lainnya">
                                <label for="radioPrimary3">
                                  Lainnya
                                </label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="">Customer : </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                            <select name="targetPengeluaran" class="form-control">
                                <?php
                                    $pilihanCustomer = mysqli_query($conn, "select * from customer WHERE status = 'Y'");
                                    while ($fetcharray = mysqli_fetch_array($pilihanCustomer)) {
                                    $namaCustomer = $fetcharray['nama'];
                                    ?>
                                    <option value="<?= $namaCustomer; ?>">
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
                                Posisi Debet
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="">Ke Kas : </label>
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
                            <input type="text" class="form-control" name="kendaraan">
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="">Jumlah : </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-10">
                                <input type="text" class="form-control" name="jumlah">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="">Keterangan : </label>
                                <input type="text" class="form-control" name="keterangan">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-12">
                            <button type="button" name="reset" class="btn btn-secondary" onclick="window.location.href='modules/transaksi/pembelian/proses.php?act=reset'" disabled>Reset</button>
                            <button type="submit" name="insertTempCashMasuk" class="btn btn-primary float-right">Submit</button>
                            </div>
                        </div>
                        
                    </form>
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
                                <?php
                                
                                if (!isset($_SESSION['temp_cash_masuk'])) {
                                    ?>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <?php 
                                } else {
                                    foreach ($_SESSION['temp_cash_masuk'] as $key => $value){   
                                        $id_akun = $value['id_akun'];
                                        $ambilAkun = "SELECT nama_akun, kode_akun FROM akun WHERE $id_akun = id_akun";
                                        $execQueryAkun = mysqli_query($conn, $ambilAkun);
                                        $fetchAkun = mysqli_fetch_array($execQueryAkun);
                                        $kode_akun = $fetchAkun['kode_akun'];
                                        $nama_akun = $fetchAkun['nama_akun'];
                                        $keterangan = $value['keterangan'];
                                        $jumlah = number_format($value ['jumlah'], 0, ',', '.');
                                ?>
                                <tr>
                                    <td><?=$kode_akun?></td>
                                    <td><?=$nama_akun?></td>
                                    <td><?=$keterangan?></td>
                                    <td>Rp.<?=$jumlah?></td>
                                </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
</div>

              <!-- /.row -->