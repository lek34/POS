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
              <div class="row">
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
                            <?php
                             if(!isset($_SESSION['temp_cash_masuk'])){?>
                                <label for="">Terima Dari : </label>
                                <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="radioPrimary1" name="terimaDari" value="customer" onclick="showForm()">
                                    <label for="radioPrimary1">
                                    Customer
                                    </label>
                                </div>
                                <div class="icheck-primary d-inline" style="margin-left : 12px  ">
                                    <input type="radio" id="radioPrimary2" name="terimaDari" value="lainnya" onclick="showForm()">
                                    <label for="radioPrimary2">
                                    Lainnya
                                    </label>
                                </div>
                                </div>
                             <?php
                             }else{ ?>
                                <label for="">Terima Dari : </label>
                                <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="radioPrimary1" name="terimaDari" value="customer" onclick="showForm()" checked>
                                    <label for="radioPrimary1">
                                    Customer
                                    </label>
                                </div>
                                <div class="icheck-primary d-inline" style="margin-left : 12px  ">
                                    <input type="radio" id="radioPrimary2" name="terimaDari" value="lainnya" onclick="showForm()">
                                    <label for="radioPrimary2">
                                    Lainnya
                                    </label>
                                </div>
                                </div>
                            <?php
                             }
                            ?>
                                
                            </div>
                            </div>
                            <?php
                             if(isset($_SESSION['temp_cash_masuk'])){?>
                                <div id="cashmasuk-option1">
                             <?php
                             }else{ ?>
                                <div id="cashmasuk-option1" style="display: none;">
                            <?php
                             }
                            ?>
                                <div class="row">
                                    <div class="col-12">
                                    <label for="">Customer : </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-2">
                                    <select name="targetPengeluaran" class="form-control">
                                        <option value="">Select an option</option>
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
                                    <input type="text" class="form-control">
                                    </div>
                                    <div class="col-1">
                                    Posisi Debet
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="">Barang : </label>
                                    </div>
                                    <div class="col-3">
                                        <label for="">Satuan : </label>
                                    </div>
                                    <div class="col-3">
                                        <label for="">Qty : </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                    <select name="barangPenjualan"  id="id_barang_penjualan" class="form-control" onchange="updateUOMpenjualan(this.value)">
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
                                    </div>
                                    <div class="col-3">
                                        <select name="uom" class="form-control" id="uom_select_penjualan">
                                        </select>
                                        <input type="text" class="form-control" name="satuankecil" id="satuankecil_input" hidden>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" name="kuantitas">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="">Nama Jasa : </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
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
                                    </div>
                                </div>

                            </div>
                            <div id="cashmasuk-option2" style="display: none;">
                            <div class="row">
                                <div class="col-12">
                                <label for="">Lainnya : </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-10">
                                    <input type="text" class="form-control" name="targetPengeluaran2">
                                </div>
                                <div class="col-1">
                                    Posisi Debet
                                </div>
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
                                <input type="text" class="form-control jumlah_mask"  name="jumlah" oninput="formatCurrency('jumlah_mask')">
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
                                <button type="button" name="reset" class="btn btn-secondary" onclick="window.location.href='modules/cash/pemasukan/proses.php?act=reset'">Reset</button>
                                <button type="submit" name="insertTempCashMasuk" class="btn btn-primary float-right">Tambahkan</button>
                            </form>
                            </div>
                        </div>
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
                                    <th>No.</th>
                                    <th>Account</th>
                                    <th>Nama Akun</th>
                                    <th>Keterangan Jurnal/Referensi</th>
                                    <th>Terima Dari</th>
                                    <th>Barang</th>
                                    <th>Jasa</th>
                                    <th>Jumlah</th>
                                    <th>Delete</th>
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
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <?php 
                                } else {
                                    $i = 1;
                                    foreach ($_SESSION['temp_cash_masuk'] as $key => $value){   
                                        $id_akun = $value['id_akun'];
                                        $ambilAkun = "SELECT nama_akun, kode_akun FROM akun WHERE $id_akun = id_akun";
                                        $execQueryAkun = mysqli_query($conn, $ambilAkun);
                                        $fetchAkun = mysqli_fetch_array($execQueryAkun);
                                        $kode_akun = $fetchAkun['kode_akun'];
                                        $nama_akun = $fetchAkun['nama_akun'];
                                        $keterangan = $value['keterangan'];
                                        $jumlah = $value['jumlah'];
                                        $id_barang = $value['id_barang'];
                                        $target_pengeluaran = $value['target_pengeluaran'];
                                        $id_jasa = $value['id_jasa'];
                                        $nama_jasa = NULL;
                                        $nama_barang = NULL;
                                        if (isset($id_barang) && $id_barang = $value['id_barang']) {  
                                            $ambilNamaBarang = "SELECT nama_barang FROM barang WHERE $id_barang = id_barang";
                                            $execQueryBarang = mysqli_query($conn, $ambilNamaBarang);
                                            $fetchNamaBarang = mysqli_fetch_array($execQueryBarang);
                                            $nama_barang = $fetchNamaBarang['nama_barang'];
                                          }
                                          var_dump($nama_barang);

                                        if (isset($id_jasa) && $id_jasa = $value['id_jasa']) {  
                                        $ambilNamaJasa = "SELECT nama_jasa FROM jasa WHERE $id_jasa = id_jasa";
                                        $execQueryJasa = mysqli_query($conn, $ambilNamaJasa);
                                        $fetchNamaJasa = mysqli_fetch_array($execQueryJasa);
                                        $nama_jasa = $fetchNamaJasa['nama_jasa'];
                                        }
                                        var_dump($nama_jasa);
                                ?>
                                <tr>
                                    <td><?=$i?></td>
                                    <td><?=$kode_akun?></td>
                                    <td><?=$nama_akun?></td>
                                    <td><?=$keterangan?></td>
                                    <td><?=$target_pengeluaran?></td>
                                    <td>
                                        <?php
                                           if (!empty($nama_barang)) {
                                                echo $nama_barang;
                                           } else {
                                            echo "-";
                                           }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                           if (!empty($nama_jasa)) {
                                                echo $nama_jasa;
                                           } else {
                                            echo "-";
                                           }
                                        ?>
                                    </td>
                                    <td><?=$jumlah?></td>
                                    <td>
                                    <form action="modules/cash/pemasukan/proses.php?act=deleteList" method="post">
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
                    
                </div>
                <div class="row">
                        <div class="col-12 d-md-flex justify-content-md-end">
                            <form action="modules/cash/pemasukan/proses.php?act=insertCashMasuk" method="post"></form>
                            <button type="submit" class="btn btn-primary float-right">Submit</button>
                        </div>
                    </div>
</div>

              <!-- /.row -->