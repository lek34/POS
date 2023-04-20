<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Item</h1>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<?php
    $query = "SELECT * FROM supplier";
    $execQuery = mysqli_query($conn, $query);
?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#tambah">
                        <i class="fa fa-plus-square"></i> Tambah Supplier
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
                                    $id_supplier  = $data['id_supplier'];
                                    ?>
                                    <tr>
                                        <td><?=$data['nama']?></td>
                                        <td><?=$data['kontak']?></td>
                                        <td><?=$data['keterangan']?></td>
                                        <td><?=$data['alamat']?></td>
                                        <td>
                                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#edit<?=$id_supplier;?>">Edit</button>
                                            <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#delete<?=$id_supplier?>">Delete</button>
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
          <h4 class="modal-title">Tambah Supplier</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->

        <div class="modal-body">
            <br>
            <form action="modules/master/supplier/proses.php?act=insert" method="post">
                <label>Nama Supplier</label>
                <input type="text" name="nama" placeholder="Nama Supplier" class="form-control" required>
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
                <button type="submit" class="btn btn-primary" name="addSup" style="float: right;">Submit</button>
            </form> 
        </div>
      </div>
    </div>
  </div>

<!-- Edit Modal -->
<?php

    $execQuery = mysqli_query($conn, "SELECT * FROM supplier");

    while ($data = mysqli_fetch_array($execQuery)) {
        $id_supplier = $data['id_supplier'];
        $nama = $data ['nama'];
        $kontak = $data ['kontak'];
        $keterangan = $data ['keterangan'];
        $alamat = $data ['alamat'];
    
?>

<div class="modal fade" id="edit<?=$id_supplier;?>">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit Supplier</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <br>
            <form action="modules/master/supplier/proses.php?act=edit" method="post">
                <input type="hidden" name="id_supplier" value="<?=$id_supplier;?>">
                <label>Nama Supplier</label>
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
                <button type="submit" class="btn btn-primary" name="editSup" style="float: right;">Submit</button>
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