<section class="content-header">
    <div class="container-fluid">
    <?php
  if (isset($_GET['alert'])) {
    $alert =  $_GET['alert'];
    switchAlert($alert);
    }
?>
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Bank Account</h1>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<?php
    $query = "SELECT * FROM akun";
    $execQuery = mysqli_query($conn, $query);
?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#tambah">
                        <i class="fa fa-plus-square"></i> Tambah Bank Account
                        </button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                <th>Kode Akun</th>
                                <th>Nama Akun</th>
                                <th>Debit</th>
                                <th>Kredit</th>
                                <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                while ($data = mysqli_fetch_array($execQuery)) {
                                    $id_akun  = $data['id_akun'];
                                    ?>
                                    <tr>
                                        <td><?=$data['kode_akun']?></td>
                                        <td><?=$data['nama_akun']?></td>
                                        <td><?=$data['debit']?></td>
                                        <td><?=$data['kredit']?></td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#edit<?=$id_akun;?>"><i class = "far fa-edit"></i></button>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete<?=$id_akun?>"><i class = "far fa-trash-alt"></i></button>
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
          <h4 class="modal-title">Tambah Bank Account</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->

        <div class="modal-body">
            <br>
            <form action="modules/master/akunbank/proses.php?act=insert" method="post">
                <label>Kode Akun</label>
                <input type="text" name="kode_akun" placeholder="Kode Akun" class="form-control" required>
                <br>
                <label>Nama Akun</label>
                <input type="text" name="nama_akun" placeholder="Nama Akun" class="form-control" required>
                <br>
                <br>
				    <button type="button" class="btn btn-danger" style="float: left;" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="addAcc" style="float: right;">Submit</button>
            </form> 
        </div>
      </div>
    </div>
  </div>

<!-- Edit Modal -->
<?php

    $execQuery = mysqli_query($conn, "SELECT * FROM akun");

    while ($data = mysqli_fetch_array($execQuery)) {
        $id_akun = $data['id_akun'];
        $kode_akun = $data ['kode_akun'];
        $nama_akun = $data ['nama_akun'];
?>

<div class="modal fade" id="edit<?=$id_akun;?>">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit Bank Account</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <br>
            <form action="modules/master/akunbank/proses.php?act=edit" method="post">
                <input type="hidden" name="id_akun" value="<?=$id_akun;?>">
                <label>Kode Akun</label>
                <input type="text" name="kode_akun" value="<?=$kode_akun;?>" class="form-control" >
                <br>
                <label>Nama Akun</label>
                <input type="text" name="nama_akun" value="<?=$nama_akun;?>" class="form-control" required>
                <br>
                <br>
				    <button type="button" class="btn btn-danger" style="float: left;" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="editAcc" style="float: right;">Submit</button>
            </form> 
        </div>
      </div>
    </div>
  </div>
    
<!-- Delete Modal -->
<div class="modal fade" id="delete<?=$id_supplier;?>">
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
                Apakah Anda Ingin Menghapus Supplier <?=$namasupplier;?> ?
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <form action="modules/master/supplier/proses.php?act=delete" method="post">
            <input type="hidden" name="idupdtsup" value="<?=$idsup?>">
            <button type="submit" class="btn btn-primary" name="delSup">Yes</button>
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