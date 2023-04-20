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
                        <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#mymodal">
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
                                while ($data = mysqli_fetch_assoc($execQuery)) {
                                    $id_supplier  = $data['id_suppllier'];
                                    ?>
                                    <tr>
                                        <td><?=$data['nama']?></td>
                                        <td><?=$data['kontak']?></td>
                                        <td><?=$data['keterangan']?></td>
                                        <td><?=$data['alamat']?></td>
                                        <td>
                                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?=$idbarang?>">Edit</button>
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?=$idbarang?>">Delete</button>
                                        </td>
                                    </tr>
                                <?php
                                }
                            ?>
