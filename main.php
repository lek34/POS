<?php
  session_start();
  include 'config/database.php';
  include 'function/alertfunc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    require_once 'layout/head.php'
  ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <?php
    require_once 'layout/navbar.php'
  ?>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="dist/img/storage-stacks.png" width="50px" height="50px" style="margin-right: 10px;margin-left: 10px;">
      <span class="brand-text font-weight-bold">Point Of Sales</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
    <?php
        require_once 'layout/sidebar.php'
    ?>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <?php 
          include 'content/content.php'
         ?>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script src="plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
<script>
$('.toastrDefaultSuccess').click(function() {
      toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });
</script>
<script>
function updateUOM(id_barang) {
  var isi_header = document.getElementById('isi_header');
  var uom_select = document.getElementById("uom_select");
  var selectedOption = "";

  // Clear the select options
  uom_select.innerHTML = "";

  <?php
  $pilihansatuan = mysqli_query($conn, "select * from barang WHERE status = 'Y'");
  while ($fetcharray = mysqli_fetch_array($pilihansatuan)) {
    $barang_id = $fetcharray['id_barang'];
    $uombesar = $fetcharray['uom_besar'];
    $uomkecil = $fetcharray['uom_kecil'];
    $satuanbesar = $fetcharray['satuan_besar'];
    $satuankecil = $fetcharray['satuan_kecil'];
  ?>

    if (<?= $barang_id; ?> == id_barang) {
      uom_select.add(new Option('<?= $uombesar; ?>', 'besar'));
      uom_select.add(new Option('<?= $uomkecil; ?>', 'kecil'));
      uom_select.selectedIndex = -1;

      console.log('satuan kecil:', '<?= $satuankecil; ?>');
      document.getElementById('satuankecil_input').value = '<?= $satuankecil; ?>';
    }

  <?php
  }
  ?>
}

function changeUOMSelect(targetId) {
  selectedOption = uom_select.value;

  if (selectedOption === 'besar' && !isi_header_added) {
    var isi_td = document.createElement('td');
    isi_td.id = 'isi_td';
    var isi_th = document.createElement('th');
    isi_th.textContent = 'Isi';

    isi_header.parentNode.insertBefore(isi_th, isi_header);

    isi_header_added = true;

    var table_rows = document.querySelectorAll('#tableBarang tbody tr');

    for (var i = 0; i < table_rows.length; i++) {
      var qty_td = table_rows[i].querySelector('td:nth-child(3)');
      table_rows[i].insertBefore(isi_td.cloneNode(true), qty_td);
    }

    // update the target element with the new text content
    var target = document.getElementById(targetId);
    target.textContent = '<?= $satuankecil ?> / <?= $uomkecil ?>';
  } else if (selectedOption === 'kecil' && isi_header_added) {
    var isi_th = document.querySelector('#isi_header th:last-child');
    isi_th.parentNode.removeChild(isi_th);

    isi_header_added = false;

    var isi_td = document.querySelector('#tableBarang tbody td:last-child');
    isi_td.parentNode.removeChild(isi_td);
  }

  // clear the text content of the target element
  var target = document.getElementById(targetId);
  target.textContent = '';
}

    </script>
</body>
</html>
