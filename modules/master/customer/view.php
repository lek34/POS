<section class="content-header">
    <div class="container-fluid">
    <?php  
      // fungsi untuk menampilkan pesan
      // jika alert = "" (kosong)
      // tampilkan pesan "" (kosong)
      if (empty($_GET['alert'])) {
        echo "";
      } 
      // jika alert = 1
      // tampilkan pesan Berhasil "Data barang berhasil ditambahkan"
      elseif ($_GET['alert'] == 1) {
        echo "<div class='alert alert-success alert dismissable'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h4>  <i class='icon fa fa-check-circle'></i> Berhasil!</h4>
                Data barang berhasil ditambahkan.
              </div>";
      }

      elseif ($_GET['alert'] == 2) {
        echo "<div class='alert alert-danger alert dismissable'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h4>  <i class='icon fa fa-times-circle'></i> Berhasil!</h4>
                Data barang gagal ditambahkan.
              </div>";
      }

      elseif ($_GET['alert'] == 3) {
        echo "<div class='alert alert-success alert dismissable'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h4>  <i class='icon fa fa-check-circle'></i> Berhasil!</h4>
                Data barang berhasil di-edit.
              </div>";
      }

      elseif ($_GET['alert'] == 4) {
        echo "<div class='alert alert-danger alert dismissable'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h4>  <i class='icon fa fa-times-circle'></i> Berhasil!</h4>
                Data barang gagal di-edit.
              </div>";
      }

      elseif ($_GET['alert'] == 5) {
        echo "<div class='alert alert-success alert dismissable'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h4>  <i class='icon fa fa-check-circle'></i> Berhasil!</h4>
                Data barang berhasil di-hapus.
              </div>";
      }

      elseif ($_GET['alert'] == 6) {
        echo "<div class='alert alert-danger alert dismissable'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h4>  <i class='icon fa fa-times-circle'></i> Berhasil!</h4>
                Data barang gagal di-hapus.
              </div>";
      }
    ?>
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Customer</h1>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<?php
    $query = "SELECT * FROM customer";
    $execQuery = mysqli_query($conn, $query);
?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#tambah">
                        <i class="fa fa-plus-square"></i> Tambah Customer
                        </button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                <th>Nama</th>
                                <th>Kontak</th>
                                <th>Keterangan</th>
                                <th>Alamat</th>
                                <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                while ($data = mysqli_fetch_array($execQuery)) {
                                    $id_customer  = $data['id_customer'];
                                    ?>
                                    <tr>
                                        <td><?=$data['nama']?></td>
                                        <td><?=$data['kontak']?></td>
                                        <td><?=$data['keterangan']?></td>
                                        <td><?=$data['alamat']?></td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#edit<?=$id_customer;?>"><i class = "far fa-edit"></i></button>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete<?=$id_customer?>"><i class = "fas fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                                <?php
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>

<!-- Insert Modal -->
<div class="modal fade" id="tambah">
  <div class="modal-dialog">
    <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Tambah Customer</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->

        <div class="modal-body">
            <br>
            <form action="modules/master/customer/proses.php?act=insert" method="post">
                <label>Nama Customer</label>
                <input type="text" name="nama" placeholder="Nama Customer" class="form-control" required>
                <br>
                <label>Kontak</label>
                <input type="text" name="kontak" placeholder="Kontak" class="form-control" required>
                <br>
                <label>Keterangan</label>
                <input type="text" name="keterangan" placeholder="Keterangan" class="form-control">
				<br>
                <label>Alamat</label>
                <input type="text" name="alamat" placeholder="Alamat" class="form-control" required>
                <br>
                <br>
				    <button type="button" class="btn btn-danger" style="float: left;" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="addCust" style="float: right;">Submit</button>
            </form> 
        </div>
      </div>
    </div>
  </div>

<!-- Edit Modal -->
<?php

    $execQuery = mysqli_query($conn, "SELECT * FROM customer");

    while ($data = mysqli_fetch_array($execQuery)) {
        $id_customer = $data['id_customer'];
        $nama = $data ['nama'];
        $kontak = $data ['kontak'];
        $keterangan = $data ['keterangan'];
        $alamat = $data ['alamat'];
    
?>

<div class="modal fade" id="edit<?=$id_customer;?>">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit Customer</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <br>
            <form action="modules/master/customer/proses.php?act=edit" method="post">
                <input type="hidden" name="id_customer" value="<?=$id_customer;?>">
                <label>Nama customer</label>
                <input type="text" name="nama" value="<?=$nama;?>" class="form-control" >
                <br>
                <label>Kontak</label>
                <input type="text" name="kontak" value="<?=$kontak;?>" class="form-control" required>
                <br>
                <label>Keterangan</label>
                <input type="text" name="keterangan" value="<?=$keterangan?>" class="form-control">
				<br>
                <label>Alamat</label>
                <input type="text" name="alamat" value="<?=$alamat?>" class="form-control" required>
                <br>
                <br>
				    <button type="button" class="btn btn-danger" style="float: left;" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="editCust" style="float: right;">Submit</button>
            </form> 
        </div>
      </div>
    </div>
  </div>
    
<!-- Delete Modal -->
<div class="modal fade" id="delete<?=$id_customer;?>">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Delete Item</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <br>
                Apakah Anda Ingin Menghapus Customer?
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <form action="modules/master/customer/proses.php?act=delete" method="post">
            <input type="hidden" name="id_customer" value="<?=$id_customer?>">
            <button type="submit" class="btn btn-primary" name="delCust">Yes</button>
          </form>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>           

  <?php
    }
    mysqli_close($conn);
  ?>