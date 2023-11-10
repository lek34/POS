<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
              <?php  
              // fungsi query untuk menampilkan data dari tabel obat
              $query = mysqli_query($conn, "SELECT COUNT(id_barang) as jumlah FROM barang")
                                              or die('Ada kesalahan pada query tampil Data: '.mysqli_error($conn));
              // tampilkan data
              $data = mysqli_fetch_assoc($query);
              ?>
                <h3><?=$data['jumlah']?></h3>

                <p>New Item</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
              <?php  
              // fungsi query untuk menampilkan data dari tabel obat
              $query = mysqli_query($conn, "SELECT COUNT(id_penjualan) as jumlah FROM penjualan")
                                              or die('Ada kesalahan pada query tampil Data: '.mysqli_error($conn));
              // tampilkan data
              $data = mysqli_fetch_assoc($query);
              ?>
                <h3><?=$data['jumlah']?></h3>

                <p>Total Sales</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
              <?php  
            // fungsi query untuk menampilkan data dari tabel obat
            $query = mysqli_query($conn, "SELECT COUNT(id_user) as jumlah FROM is_users where status = 'aktif'")
                                            or die('Ada kesalahan pada query tampil Data: '.mysqli_error($conn));
            // tampilkan data
            $data = mysqli_fetch_assoc($query);
            ?>
                <h3><?=$data['jumlah']?></h3>

                <p>User Registrations</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
              <?php  
              // fungsi query untuk menampilkan data dari tabel obat
              $query = mysqli_query($conn, "SELECT COUNT(id_pembelian) as jumlah FROM pembelian")
                                              or die('Ada kesalahan pada query tampil Data: '.mysqli_error($conn));
              // tampilkan data
              $data = mysqli_fetch_assoc($query);
              ?>
                <h3><?=$data['jumlah']?></h3>

                <p>Total Buy</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-12 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
			  <!-- /.card -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1"></i>
                  Sales
                  
                </h3>
                <div class="card-tools">
                  <ul class="nav nav-pills ml-auto">
                    <li class="nav-item">
                      <a class="nav-link active" href="#revenue-chart" data-toggle="tab" >Line Chart</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#sales-chart" data-toggle="tab">Bar Chart</a>
                    </li>
                  </ul>
                </div>
                <div class="row">
                  <div class="col-4">

                  </div>
                  <div class="col-5">
                  <?php
                       /* $pilihantahun = mysqli_query($conn, "SELECT * FROM penjualan_netto join pembelian_netto");
                       while ($fetcharray = mysqli_fetch_array($pilihantahun)) {
                           $tahun_beli = json_decode($fetcharray['tanggal_akum_beli'], true) ?? [];
                           $tahun_jual = json_decode($fetcharray['tanggal_akum_jual'], true) ?? [];
                           $tahun_transaksi = [];
                       
                           foreach ($tahun_beli as $i => $data) {
                               if (!existCheck($data, $tahun_transaksi)) {
                                   $tahun_transaksi[] = $data;
                               }
                           }
                       
                           foreach ($tahun_jual as $i => $data) {
                               if (!existCheck($data, $tahun_transaksi)) {
                                   $tahun_transaksi[] = $data;
                               }
                           }
                       
                           sort($tahun_transaksi);
                       
                           var_dump($tahun_transaksi);
                           ?>
                           <select name="tahun" id="tahun" class="form-control">
                               <?php
                               foreach ($tahun_transaksi as $tahun) {
                               ?>
                                   <option value="<?= $tahun; ?>">
                                       <?= $tahun; ?>
                                   </option>
                               <?php
                               }
                               ?>
                           </select>
                        <?php
                        } */
                        ?>
                  
                  </div>
                
                </div>
                
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">
                  <!-- Morris chart - Sales -->
                  <div class="chart tab-pane active" id="revenue-chart"
                       style="position: relative; height: 300px;">
                       <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                   </div>
                  <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                  <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                  </div>
                </div>
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- DIRECT CHAT -->
            
            <!--/.direct-chat -->

            <!-- TO DO List -->
            
            <!-- /.card -->
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-5 connectedSortable">

            <!-- Map card -->
            <!-- /.card -->

            <!-- solid sales graph -->
            <!-- /.card -->

            <!-- Calendar -->
            
            <!-- /.card -->
          </section>
          <!-- right col -->
        </div>