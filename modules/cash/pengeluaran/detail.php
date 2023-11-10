<?php
    if (isset($_GET['alert'])) {
        $alert =  $_GET['alert'];
        switchAlert($alert);
        }
    ?>
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
    <!-- Header Row -->
    <div class="row">
        
        <?php
        /*  unset($_SESSION['header_cash_keluar']);
        unset($_SESSION['temp_cash_keluar']); */
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
        <form action="modules/cash/pengeluaran/proses.php?act=insertTempCashKeluar" method="post"> <!-- form buka -->
        <!-- Pengulangan pertama -->
        <?php
        if (!isset($_SESSION['header_cash_keluar'])) { 
            $terima_dari = NULL;
        ?>
            <div class="row">
                <div class="col-2">
                    <input type="hidden" name="last_keluar" placeholder="You Shouldn't See This" value='<?= $next_number?>' class="form-control" hidden>
                    <label>No. Bukti : </label>
                    <input type="text" name = "no_bukti" value=<?=$no_bukti?> class="form-control" readonly>
                </div>
                <div class="col-2">
                <label for="">Ke Kas : </label>
                    <select name="id_akun" class="form-control" required>
                            <?php
                            $pilihanAkun = mysqli_query($conn, "select * from akun WHERE status = 'Y'");
                            while ($fetcharray = mysqli_fetch_array($pilihanAkun)) {
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
                <div class="col-2">
                    <label>Tanggal : </label>
                    <?php
                        $tanggal_keluar = date("d/m/y");
                    ?>
                    <input type="text" name = "tanggal_keluar" class="form-control" value="<?=$tanggal_keluar?>" readonly>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label for=""> Dibayarkan Kepada : </label>
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="radio" id="radioPrimary1" name="terimaDari" value="customer" onclick="showFormKeluar()">
                            <label for="radioPrimary1">
                            Customer
                            </label>
                        </div>
                        <div class="icheck-primary d-inline" style="margin-left : 12px  ">
                            <input type="radio" id="radioPrimary2" name="terimaDari" value="lainnya" onclick="showFormKeluar()">
                            <label for="radioPrimary2">
                            Lainnya
                            </label>
                        </div>
                        <div class="icheck-primary d-inline" style="margin-left : 12px  ">
                            <input type="radio" id="radioPrimary3" name="terimaDari" value="pihak_jasa" onclick="showFormKeluar()">
                            <label for="radioPrimary3">
                            Pihak Jasa
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            } else {
                    $no_bukti = $_SESSION['header_cash_keluar']['no_bukti'];
                    $idAkun = $_SESSION['header_cash_keluar']['id_akun'];
                    $tanggal_keluar = $_SESSION['header_cash_keluar']['tanggal_keluar'];
                    $terima_dari = $_SESSION['header_cash_keluar']['terima_dari'];
                    $last_keluar = $_SESSION['header_cash_keluar']['last_keluar'];
            ?>
            <!-- After Second Repetition -->
            <div class="row">
                <div class="col-2">
                    <label>No. Bukti : </label>
                    <input type="text" name = "no_bukti" value=<?=$no_bukti?> class="form-control" readonly>
                    <input type="hidden" name="last_keluar" value="<?=$last_keluar?>">
                </div>
                <div class="col-2">
                <label for="">Ke Kas : </label>
                    <select class="form-control" disabled>
                        <?php
                            $queryNamaAkun = "SELECT nama_akun from akun where $idAkun = id_akun";
                            $execQueryNamaAkun =  mysqli_query($conn, $queryNamaAkun);
                            $fetchNamaAkun = mysqli_fetch_array($execQueryNamaAkun);
                            $namaAkun = $fetchNamaAkun['nama_akun'];
                            ?>
                            <option value="<?= $idAkun; ?>">
                                <?= $namaAkun; ?>
                            </option>
                    </select>
                    <input type="hidden" name="id_akun" value="<?=$idAkun?>">
                </div>
                <div class="col-2">
                    <label>Tanggal : </label>
                    <input type="text" class="form-control" value="<?=$tanggal_keluar?>" disabled>
                    <input type="hidden" name="tanggal_keluar" value="<?=$tanggal_keluar?>">
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label for=""> Dibayarkan Kepada : </label>
                    <!-- Option For what the users checed on the first repetition -->
                    <?php
                        if ($terima_dari == "customer") {
                        ?>
                        <div class="form-group clearfix">
                            <div class="icheck-primary d-inline">
                                <input type="radio" id="radioPrimary1" onclick="showForm()" checked disabled">
                                <input type="hidden" name="terimaDari" value="customer">
                                <label for="radioPrimary1">
                                Customer
                                </label>
                            </div>
                            <div class="icheck-primary d-inline" style="margin-left : 12px  ">
                                <input type="radio" id="radioPrimary2" name="terimaDari" value="lainnya" onclick="showForm()" disabled>
                                <label for="radioPrimary2">
                                Lainnya
                                </label>
                            </div>
                            <div class="icheck-primary d-inline" style="margin-left : 12px  ">
                                <input type="radio" id="radioPrimary3" name="terimaDari" value="salesman" onclick="showForm()" disabled>
                                <label for="radioPrimary3">
                                Pihak Jasa
                                </label>
                            </div>
                        </div>
                        <?php
                        } elseif ($terima_dari == "lainnya") {
                        ?>
                        <div class="form-group clearfix">
                            <div class="icheck-primary d-inline">
                                <input type="radio" id="radioPrimary1" name="terimaDari" value="customer" onclick="showForm()" disabled>
                                <label for="radioPrimary1" readonly>
                                Customer
                                </label>
                            </div>
                            <div class="icheck-primary d-inline" style="margin-left : 12px  ">
                                <input type="radio" id="radioPrimary2" onclick="showForm()" disabled checked>
                                <input type="hidden" name="terimaDari" value="lainnya">
                                <label for="radioPrimary2" readonly>
                                Lainnya
                                </label>
                            </div>
                            <div class="icheck-primary d-inline" style="margin-left : 12px  ">
                                <input type="radio" id="radioPrimary3" name="terimaDari" value="salesman" onclick="showForm()" disabled>
                                <label for="radioPrimary3">
                                Pihak Jasa
                                </label>
                            </div>
                        </div>
                        <?php
                        } else {
                        ?>
                        <div class="form-group clearfix">
                            <div class="icheck-primary d-inline">
                                <input type="radio" id="radioPrimary1" name="terimaDari" value="customer" onclick="showForm()" disabled>
                                <label for="radioPrimary1" readonly>
                                Customer
                                </label>
                            </div>
                            <div class="icheck-primary d-inline" style="margin-left : 12px  ">
                                <input type="radio" id="radioPrimary2" onclick="showForm()" disabled>
                                <input type="hidden" name="terimaDari" value="lainnya">
                                <label for="radioPrimary2" readonly>
                                Lainnya
                                </label>
                            </div>
                            <div class="icheck-primary d-inline" style="margin-left : 12px  ">
                                <input type="radio" id="radioPrimary3" name="terimaDari" value="salesman" onclick="showForm()" disabled checked>
                                <input type="hidden" name="terimaDari" value="pihak_jasa">
                                <label for="radioPrimary3">
                                Pihak Jasa
                                </label>
                            </div>
                        </div>
                        <?php
                        }
                    ?>
                </div>
            </div>
            <?php
            }
            ?>
            <!-- End of Header Row -->
            <!-- Content information -->
            <?php
                if(isset($_SESSION['temp_cash_keluar'])){
                    if ($terima_dari == "customer") {
                    ?>
                    <div id="cashkeluar-option1">
                        <div class="row">
                            <div class="col-5">
                            <label for="">Customer : </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <?php
                                if (isset($_SESSION['header_cash_keluar']['dari'])) {
                                    $dari = $_SESSION['header_cash_keluar']['dari'];
                                
                                    // Prepare and execute the SQL query using prepared statements
                                    $queryNamaCustomer = "SELECT nama FROM customer WHERE id_customer = ?";
                                    $stmt = mysqli_prepare($conn, $queryNamaCustomer);
                                    mysqli_stmt_bind_param($stmt, "s", $dari);
                                    mysqli_stmt_execute($stmt);
                                    $result = mysqli_stmt_get_result($stmt);
                                
                                    // Fetch the row from the result set
                                    if ($fetchNamaCustomer = mysqli_fetch_array($result)) {
                                        $namaCustomer = $fetchNamaCustomer['nama'];
                                    } else {
                                        // Handle the case when no row is returned
                                        $namaCustomer = "Customer Not Found";
                                    }
                                } else {
                                    // Handle the case when the session variable is not set
                                    $dari = null;
                                    $namaCustomer = "Session Variable Not Set";
                                }
                                ?>
                                <select class="form-control" disabled>
                                    <option value="<?= $dari; ?>">
                                        <?= $namaCustomer; ?>
                                    </option>
                                </select>
                                <input type="hidden" name="dariCustomer" value="<?=$dari?>">
                            </div>
                            <div class="col-1">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <label for="">Barang : </label>
                            </div>
                            <div class="col-1">
                                <label for="">Satuan : </label>
                            </div>
                            <div class="col-1">
                                <label for="">Qty : </label>
                            </div>
                            <div class="col-2">
                                <label for="">Nama Jasa : </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
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
                            <div class="col-1">
                                <select name="uom" class="form-control" id="uom_select_penjualan">
                                </select>
                                <input type="text" class="form-control" name="satuankecil" id="satuankecil_input" hidden>
                            </div>
                            <div class="col-1">
                                <input type="text" class="form-control" name="kuantitas" id="kuantitas_input">
                            </div>
                            <div class="col-2">
                            <select name="id_jasa" class="form-control">
                                <option value=""></option>
                                    <?php
                                    $pilihanjasa = mysqli_query($conn, "select * from jasa WHERE status = 'Y'");
                                    while ($fetcharray = mysqli_fetch_array($pilihanjasa)) {
                                    $namajasa = $fetcharray['nama_jasa'];
                                    $id_jasa = $fetcharray['id_jasa'];
                                    ?>
                                    <option value="<?= $id_jasa; ?>">
                                        <?= $namajasa?>
                                    </option>
                                    <?php
                                    }
                                    ?>
                            </select>;
                            </div>
                        </div>
                    </div>
                    <?php
                    } elseif ($terima_dari == "lainnya") {
                        $dari = $_SESSION['header_cash_keluar']['dari'];
                    ?>
                    <div id="cashkeluar-option2">
                        <div class="row">
                            <div class="col-6">
                            <label for="">Dibayarkan Kepada : </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <input type="text" class="form-control"value="<?=$dari?>" disabled>
                                <input type="hidden" value="<?=$dari?>" name="dariLainnya">
                            </div>
                            <div class="col-1">
                            </div>
                        </div>
                    </div>
                    <?php
                    } else {
                        if (isset($_SESSION['header_cash_keluar']['dari'])) {
                            $dari = $_SESSION['header_cash_keluar']['dari'];
                        
                            // Prepare and execute the SQL query using prepared statements
                            $queryNamaPihak = "SELECT nama_pihak FROM pihak_jasa WHERE id_pjasa = ?";
                            $stmt = mysqli_prepare($conn, $queryNamaPihak);
                            mysqli_stmt_bind_param($stmt, "s", $dari);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                        
                            // Fetch the row from the result set
                            if ($fetchNamaPihak = mysqli_fetch_array($result)) {
                                $namaPihak = $fetchNamaPihak['nama_pihak'];
                            } else {
                                // Handle the case when no row is returned
                                $namaPihak = "Name Not Found";
                            }
                        } else {
                            // Handle the case when the session variable is not set
                            $dari = null;
                            $namaPihak = "Session Variable Not Set";
                        }
                        ?>
                        <div id = "cashkeluar-option3">
                            <div class="row">
                                <div class="col-3">
                                    <label for="">Nama Pihak : </label>
                                </div>
                                <div class="col-3">
                                    <label for="">Nama Jasa : </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <select name="dariJasa" class="form-control" style="pointer-events: none; background-color: #e9ecef;">
                                        <option value="<?= $dari?>">
                                            <?= $namaPihak?>
                                        </option>
                                    </select>
                                    <input type="hidden" name = "dariJasa" value="<?=$dari?>">
                                </div>
                                <div class="col-3">
                                <select name="id_jasa_pihak" class="form-control">
                                        <option>Select an Option</option>
                                        <?php
                                        $pilihanjasa = mysqli_query($conn, "select * from jasa WHERE status = 'Y'");
                                        while ($fetcharray = mysqli_fetch_array($pilihanjasa)) {
                                        $namaJasa = $fetcharray['nama_jasa'];
                                        $id_jasa = $fetcharray['id_jasa'];
                                        ?>
                                        <option value="<?= $id_jasa; ?>">
                                            <?= $namaJasa; ?>
                                        </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-1">
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                } else {
                ?>
                <div id="cashkeluar-option1" style="display: none;">
                    <div class="row">
                        <div class="col-5">
                        <label for="">Customer : </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                        <select name="dariCustomer" class="form-control">
                            <?php
                            $pilihanCustomer = mysqli_query($conn, "select * from customer WHERE status = 'Y'");
                            while ($fetcharray = mysqli_fetch_array($pilihanCustomer)) {
                                $namaCustomer = $fetcharray['nama'];
                                $id_customer = $fetcharray['id_customer'];
                            ?>
                                <option value="<?= $id_customer; ?>">
                                <?= $namaCustomer; ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                        </div>
                        <div class="col-1">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <label for="">Barang : </label>
                        </div>
                        <div class="col-1">
                            <label for="">Satuan : </label>
                        </div>
                        <div class="col-1">
                            <label for="">Qty : </label>
                        </div>
                        <div class="col-2">
                            <label for="">Nama Jasa : </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <select name="barangPenjualan"  id="id_barang_penjualan" class="form-control" onchange="updateUOMpenjualan(this.value)">
                                <option value="">Select an item</option>
                                <?php
                                $pilihanbarang = mysqli_query($conn, "select * from barang WHERE status = 'Y'");
                                while ($fetcharray = mysqli_fetch_array($pilihanbarang)) {
                                    $namabarang = $fetcharray['nama_barang'];
                                    $barang_id = $fetcharray['id_barang'];
                                    $harga_modal= $fetcharray['harga_modal'];
                                ?>
                                <option value="<?= $barang_id; ?>" data-harga-modal="<?= $harga_modal?>">
                                    <?= $namabarang; ?>
                                </option>
                                
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-1">
                            <select name="uom" class="form-control" id="uom_select_penjualan">
                            </select>
                            <input type="text" class="form-control" name="satuankecil" id="satuankecil_input" hidden>
                        </div>
                        <div class="col-1">
                            <input type="text" class="form-control" name="kuantitas">
                        </div>
                        <div class="col-2">
                        <select name="id_jasa" class="form-control">
                            <option value=""></option>
                                <?php
                                $pilihanjasa = mysqli_query($conn, "select * from jasa WHERE status = 'Y'");
                                while ($fetcharray = mysqli_fetch_array($pilihanjasa)) {
                                $namajasa = $fetcharray['nama_jasa'];
                                $id_jasa = $fetcharray['id_jasa'];
                                ?>
                                <option value="<?= $id_jasa; ?>">
                                    <?= $namajasa ?>
                                </option>
                                
                                <?php
                                }
                                ?>
                        </select>
                        </div>
                    </div>
                </div>
                <div id="cashkeluar-option2" style="display: none;">
                    <div class="row">
                        <div class="col-6">
                        <label for="">Dibayarkan Kepada : </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <input type="text" class="form-control" name="dariLainnya" placeholder="Nama">
                        </div>
                        <div class="col-1">
                        </div>
                    </div>
                </div>
                <div id="cashkeluar-option3" style="display: none;">
                    <div class="row">
                        <div class="col-3">
                            <label for="">Nama Pihak : </label>
                        </div>
                        <div class="col-3">
                            <label for="">Nama Jasa : </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <select name="dariJasa" class="form-control">
                                <option value="-">Select an Option</option>
                                <?php
                                $pilihanPihak = mysqli_query($conn, "select * from pihak_jasa WHERE status = 'Y'");
                                while ($fetcharray = mysqli_fetch_array($pilihanPihak)) {
                                $namaPihak = $fetcharray['nama_pihak'];
                                $id_pihak = $fetcharray['id_pjasa'];
                                ?>
                                <option value="<?= $id_pihak; ?>">
                                    <?= $namaPihak; ?>
                                </option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-3">
                        <select name="id_jasa_pihak" class="form-control">
                                <option>Select an Option</option>
                                <?php
                                $pilihanjasa = mysqli_query($conn, "select * from jasa WHERE status = 'Y'");
                                while ($fetcharray = mysqli_fetch_array($pilihanjasa)) {
                                $namaJasa = $fetcharray['nama_jasa'];
                                $id_jasa = $fetcharray['id_jasa'];
                                ?>
                                <option value="<?= $id_jasa; ?>">
                                    <?= $namaJasa; ?>
                                </option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-1">
                        </div>
                    </div>
                </div>
                <?php
                }
            ?>
                <div class="row">
                    <div class="col-2">
                        <label for="">Kendaraaan : </label>
                    </div>
                    <div class="col-2">
                        <label for="">Jumlah : </label>
                    </div>
                    <div class="col-2">
                        <label for="">Keterangan : </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        <input type="text" class="form-control" name="kendaraan">
                    </div>
                    <div class="col-2">
                        <input type="text" class="form-control"  name="jumlah" required>
                    </div>
                    <div class="col-2">
                    <?php
                     if (isset($_SESSION['header_cash_keluar'])) {
                        $keterangan = $_SESSION['header_cash_keluar']['keterangan'];
                        if (!empty($keterangan)) {
                            ?>
                            <input type="text" class="form-control" name="keterangan" readonly value="<?= $keterangan ?>">
                            <?php
                        } else {
                            ?>
                            <input type="text" class="form-control" name="keterangan">
                            <?php
                        }
                    } else {
                        ?>
                        <input type="text" class="form-control" name="keterangan">
                        <?php
                    }
                    ?>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-12">
                        <?php
                        if (!isset($_SESSION['header_cash_keluar'])) {
                        ?>
                        <button type="button" name="reset" class="btn btn-secondary" onclick="window.location.href='modules/cash/pengeluaran/proses.php?act=reset'" disabled>Reset</button>
                        <?php
                        } else {
                        ?>
                        <button type="button" name="reset" class="btn btn-danger" onclick="window.location.href='modules/cash/pengeluaran/proses.php?act=reset'">Reset</button>
                        <?php
                        }
                        ?>
                        <button type="submit" name="insertTempCashkeluar" class="btn btn-primary float-right">Tambahkan</button>
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
                        <th>No.</th>
                        <th>Account</th>
                        <th>Nama Akun</th>
                        <th>Dibayarkan Kepada</th>
                        <th>Barang</th>
                        <th>Qty</th>
                        <th>Jasa</th>
                        <th>Jumlah</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totJumlah = 0;
                    if (!isset($_SESSION['temp_cash_keluar'])) {
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
                        <td>-</td>
                    </tr>
                    <?php
                    } else {
                    $i = 1;
                    /* Ambil Nama Akun */
                    $queryAkun  = "SELECT nama_akun, kode_akun FROM akun WHERE $idAkun = id_akun";
                    $execQueryAkun = mysqli_query($conn, $queryAkun);
                    $fetchAkun = mysqli_fetch_array($execQueryAkun);
                    $nama_akun = $fetchAkun['nama_akun'];
                    $kode_akun  = $fetchAkun['kode_akun'];
                    foreach ($_SESSION['temp_cash_keluar'] as $key => $value) {
                        
                        /* Ambil Nama Customer */
                        if($terima_dari == "customer"){
                            $dari = $_SESSION['header_cash_keluar']['dari'];
                            $queryNamaCustomer = "SELECT nama FROM customer WHERE $dari = id_customer";
                            $execQueryNamaCustomer = mysqli_query($conn, $queryNamaCustomer);
                            $fetchNamaCustomer = mysqli_fetch_array($execQueryNamaCustomer);
                            $dari = $fetchNamaCustomer ['nama'];

                            /* Ambil Nama Barang */
                            $id_barang = $value['barangPenjualan'];
                            $queryNamaBarang = "SELECT nama_barang FROM barang WHERE $id_barang = id_barang";
                            $execQueryNamaBarang = mysqli_query($conn, $queryNamaBarang);
                            $fetchNamaBarang = mysqli_fetch_array($execQueryNamaBarang);
                            $nama_barang = $fetchNamaBarang['nama_barang'];
                        } elseif ($terima_dari == "lainnya") {
                            $dari = $_SESSION['header_cash_keluar']['dari'];
                            $nama_barang = NULL;
                        } else {
                            $dari = $_SESSION['header_cash_keluar']['dari'];
                            // Prepare and execute the SQL query using prepared statements
                            $queryNamaPihak = "SELECT nama_pihak FROM pihak_jasa WHERE id_pjasa = ?";
                            $stmt = mysqli_prepare($conn, $queryNamaPihak);
                            mysqli_stmt_bind_param($stmt, "s", $dari);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            $fetchNamaPihak = mysqli_fetch_array($result);
                            $dari = $fetchNamaPihak['nama_pihak'];

                            $nama_barang = NULL;
                        }
                        
                        $id_jasa = $value['id_jasa'];
                        if ($id_jasa == NULL) {
                            $nama_jasa = NULL;
                        } else {
                            $queryNamaJasa = "SELECT nama_jasa FROM jasa WHERE id_jasa = $id_jasa";
                            $execQueryNamaJasa = mysqli_query($conn, $queryNamaJasa);
                            $fetchNamaJasa = mysqli_fetch_array($execQueryNamaJasa);
                            $nama_jasa = $fetchNamaJasa['nama_jasa'];
                        }
                        $kuantitas = $value['kuantitas'];
                        $jumlah = $value['jumlah'];
                        $jumlah_tampil = number_format($jumlah, 0, ',', '.');
                        $totJumlah += $jumlah;
                        $totalJumlah = number_format($totJumlah, 0, ',', '.');
                    ?>
                    <tr>
                        <td><?=$i?></td>
                        <td><?=$kode_akun?></td>
                        <td><?=$nama_akun?></td>
                        <td><?=$dari?></td>
                        <td><?=$nama_barang?></td>
                        <td><?=$kuantitas?></td>
                        <td><?=$nama_jasa?></td>
                        <td>Rp.<?=$jumlah_tampil?></td>
                        <td>
                            <form action="modules/cash/pengeluaran/proses.php?act=deleteList" method="post">
                              <input type="hidden" name="indexhapus" value=<?=$key?>>
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
        <!-- accepted payments column -->
        <?php
            if(!isset($tanggal_keluar)){
                $tanggal_bawah = "DD/MM/YYYY";
            } else{
                $tanggal_bawah = $tanggal_keluar;
            }
            $totalJumlah = number_format($totJumlah, 0, ',', '.');
        ?>
        <div class="col-6">
        </div>
        <!-- /.col -->
        <div class="col-6"> 
            <p class="lead">Tanggal keluar : <?=$tanggal_bawah?></p>
            <div class="table-responsive">
            <table class="table">
                <tr>
                <th>Total:</th>
                <td>Rp. <?=$totalJumlah?></td>
                </tr>
            </table>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <div class="row no-print">
        <div class="col">
            <?php
            if(!isset($_SESSION['temp_cash_keluar'])){
            ?>
                <button type="submit" name="insertPembelian" class="btn btn-success float-right" disabled>Submit</button>
            <?php
            } else {
            ?>
            <form action="modules/cash/pengeluaran/proses.php?act=insertCash" method="post">
                <input type="hidden" name="totJumlah" value="<?=$totJumlah?>">
                <button type="submit" name="insertCash" class="btn btn-success float-right">Submit</button>
            </form>
            <?php
            }
            ?>
        </div>
    </div>
        <!-- /.row -->
</div>    <!-- /.row -->