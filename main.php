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
function updateUOMpembelian(id_barang) {
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
function updateUOMpenjualan(id_barang) {
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
<script>
  function showForm() {
    var option1 = document.getElementById("radioPrimary1");
    var option2 = document.getElementById("radioPrimary2");
    var form1 = document.getElementById("cashmasuk-option1");
    var form2 = document.getElementById("cashmasuk-option2");

    if (option1.checked) {
    form1.style.display = "block";
    form2.style.display = "none";
    } else if (option2.checked) {
    form1.style.display = "none";
    form2.style.display = "block";
    }
}
</script>
<script>
  document.getElementById("option").addEventListener("change", function() {
    var customerFields = document.getElementById("customerFields");
    var lainnyaFields = document.getElementById("lainnyaFields");

    if (this.value === "customer") {
      customerFields.style.display = "block";
      lainnyaFields.style.display = "none";
    } else if (this.value === "lainnya") {
      customerFields.style.display = "none";
      lainnyaFields.style.display = "block";
    }
  });
</script>
<script>
  document.getElementById("option").addEventListener("change", function() {
    var customerFields = document.getElementById("customerFields");
    var lainnyaFields = document.getElementById("lainnyaFields");

    if (this.value === "customer") {
      customerFields.style.display = "block";
      lainnyaFields.style.display = "none";
    } else if (this.value === "lainnya") {
      customerFields.style.display = "none";
      lainnyaFields.style.display = "block";
    }
  });
</script>
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

<!-- Page specific script -->
<script>
  //Area Chart
  $(function () {
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d');
    var areaChartData = {
      labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      datasets: [
        {
          label               : 'Digital Goods',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          data                : [28, 48, 40, 19, 86, 27, 90]
        },
        {
          label               : 'Electronics',
          backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          data                : [65, 59, 80, 81, 56, 55, 40]
        }
      ]
    };
  
    var areaChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          }
        }]
      },
      elements: {
        point: {
          radius: 0,
          hoverRadius: 0
        }
      }
    };
  
    new Chart(areaChartCanvas, {
      type: 'line',
      data: areaChartData,
      options: areaChartOptions
    });
  });
   
  //Line Chart
  $(function () {
    <?php
      $pembelian_akum = mysqli_query($conn, "select")
    ?>
    var pembelian_akum = 28;
    var lineChartCanvas = $('#lineChart').get(0).getContext('2d');
    var lineChartData = {
      labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      datasets: [
        {
          label               : 'Digital Goods',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          data                : [pembelian_akum, 48, 40, 19, 86, 27, 90],
          fill                : false
        },
        {
          label               : 'Electronics',
          backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          data                : [65, 59, 80, 81, 56, 55, 40],
          fill                : false
        }
      ]
    };
  
    var lineChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          }
        }],
      },
      elements: {
        point: {
          radius: 0,
          hoverRadius: 0
        }
      }
    };
  
    new Chart(lineChartCanvas, {
      type: 'line',
      data: lineChartData,
      options: lineChartOptions
    });
  });
  //Donut Chart
  $(function () {
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d');
    var donutData = {
      labels: ['Chrome', 'IE', 'FireFox', 'Safari', 'Opera', 'Navigator'],
      datasets: [
        {
          data: [700, 500, 400, 600, 300, 100],
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de']
        }
      ]
    };
          
          var donutOptions = {
          maintainAspectRatio : false,
          responsive : true
          };
          
          new Chart(donutChartCanvas, {
          type: 'doughnut',
          data: donutData,
          options: donutOptions
            });
    });
  //Pie Chart
$(function () {
  var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
  var pieData = {
    labels: ['Chrome', 'IE', 'FireFox', 'Safari', 'Opera', 'Navigator'],
    datasets: [
      {
        data: [700, 500, 400, 600, 300, 100],
        backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de']
      }
    ]
  };

  var pieOptions = {
    maintainAspectRatio : false,
    responsive : true
  };

  new Chart(pieChartCanvas, {
    type: 'pie',
    data: pieData,
    options: pieOptions
  });
});
//Bar Chart
$(function () {
  var barChartCanvas = $('#barChart').get(0).getContext('2d');
  var barChartData = {
    labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
    datasets: [
      {
        label               : 'Digital Goods',
        backgroundColor     : 'rgba(60,141,188,0.9)',
        borderColor         : 'rgba(60,141,188,0.8)',
        data                : [65, 59, 80, 81, 56, 55, 40]
      },
      {
        label               : 'Electronics',
        backgroundColor     : 'rgba(210, 214, 222, 1)',
        borderColor         : 'rgba(210, 214, 222, 1)',
        data                : [28, 48, 40, 19, 86, 27, 90]
      }
    ]
  };

  var barChartOptions = {
    responsive              : true,
    maintainAspectRatio     : false,
    datasetFill             : false
  };

  new Chart(barChartCanvas, {
    type: 'bar',
    data: barChartData,
    options: barChartOptions
  });
});
//Stacked Bar Chart
$(function () {
  var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d');
  var stackedBarChartData = {
    labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
    datasets: [
      {
        label               : 'Electronics',
        backgroundColor     : 'rgba(210, 214, 222, 1)',
        borderColor         : 'rgba(210, 214, 222, 1)',
        data                : [65, 59, 80, 81, 56, 55, 40]
      },
      {
        label               : 'Digital Goods',
        backgroundColor     : 'rgba(60,141,188,0.9)',
        borderColor         : 'rgba(60,141,188,0.8)',
        data                : [28, 48, 40, 19, 86, 27, 90]
      }
    ]
  };

  var stackedBarChartOptions = {
    responsive : true,
    maintainAspectRatio : false,
    scales: {
      xAxes: [
      {
        stacked: true
      }],
        yAxes: [
        {
          stacked: true
      }]
    }
  };

  new Chart(stackedBarChartCanvas, {
    type: 'bar',
    data: stackedBarChartData,
    options: stackedBarChartOptions
    });
});
</script>
</body>
</html>
