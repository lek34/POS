<section class="content-header">
    <div class="container-fluid">
        <?php
            $id_pjasa = $_GET['id_pjasa'];

            if (isset($_GET['alert'])) {
                $alert =  $_GET['alert'];
                switchAlert($alert);
                }
        ?>
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>History Jasa</h1>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-4">

                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No. Bukti</th>
                                    <th>Jumlah</th>
                                    <th>Jasa</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>