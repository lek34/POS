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
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
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
<!-- jquery-validation -->
<script src="plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="plugins/jquery-validation/additional-methods.min.js"></script>
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
</script>

<script>
function updateUOM(id_barang) {
  var uom_select = document.getElementById("uom_select_penjualan");
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
</script>

<script>
const costPriceInput = document.getElementById('costPrice');
const sellingPriceInput = document.getElementById('harga_barang');
const marginInput = document.getElementById('margin');
const barangIdInput = document.getElementById('id_barang_penjualan');

function updateSellingPrice() {
  const costPrice = parseFloat(barangIdInput.options[barangIdInput.selectedIndex].dataset.hargaModal);
  const margin = parseFloat(marginInput.value);
  const sellingPrice = costPrice * (1 + margin / 100);
  sellingPriceInput.value = sellingPrice.toFixed(0); 
}

barangIdInput.addEventListener('change', updateSellingPrice);
marginInput.addEventListener('input', updateSellingPrice);


</script>
<!-- Masking -->
<script>
    function formatCurrency(inputId) {
      // Retrieve the input field using its ID
      let inputField = document.getElementById(inputId);

      // Remove non-numeric characters from the input value
      let numericValue = inputField.value.replace(/\D/g, "");

      // Format the numeric value with the "Rp." prefix and thousands separators
      let formattedValue = `Rp. ${numericValue.replace(/\B(?=(\d{3})+(?!\d))/g, ".")}`;

      // Update the input field value with the formatted value
      inputField.value = formattedValue;
    }
    function formatPhone(inputId) {
      let inputField = document.getElementById(inputId);

      // Remove non-numeric characters from the input value
      let numericValue = inputField.value.replace(/\D/g, "");

      // Format the numeric value with the "Rp." prefix and thousands separators
      let formattedValue = `Rp. ${numericValue.replace(/\B(?=(\d{3})+(?!\d))/g, ".")}`;

      // Update the input field value with the formatted value
      inputField.value = formattedValue;
    }
  </script> 
<script>
$(document).ready (function () {
  //$.validator.setDefaults({
  //  submitHandler: function () {
    //  alert( "Form successful submitted!" );
    //}
  //});
  $('#fcust').validate({
    rules: {
      kontak: {
        minlength: 10
      },
    },
    messages: {
      kontak: {
        minlength: "Silahkan masukkan nomor telepon yang valid"
      },
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});
</script>
</body>
</html>
