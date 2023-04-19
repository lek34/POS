<!-- Sidebar user panel (optional) -->
<div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['username'] ; ?></a>
        </div>
      </div>

      <?php 
      $hak_akses = isset($_SESSION["hak_akses"]) ? $_SESSION["hak_akses"]  : '';

      function isPageActive($linkURL){
        $currentUrl = $_GET["module"];
        return($currentUrl == $linkURL);
      }

      if ($hak_akses =='Super Admin') { ?>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item">
                <a href="?module=beranda" class="nav-link <?php echo isPageActive("beranda") ? 'active' : ''; ?>">
                <p>
                    Dashboard
                </p>
                </a>
               </li>
               <li class="nav-item ">
                <a href="javascript:void(0);" class="nav-link <?php echo isPageActive('master') ? 'active' : ''; ?>">
                  <i class="nav-icon fas fa-briefcase"></i>
                  <p>
                    Master
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="?module=dataItem" class="nav-link <?php echo isPageActive('dataItem') ? 'active' : ''; ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Data Barang</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="?module=dataSup" class="nav-link <?php echo isPageActive('dataSup') ? 'active' : ''; ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Data Supplier</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="?module=dataCust" class="nav-link <?php echo isPageActive('dataCust') ? 'active' : ''; ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Data Customer</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="?module=noAcc" class="nav-link <?php echo isPageActive('noAcc') ? 'active' : ''; ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Nomor Akun</p>
                    </a>
                  </li>
                </ul>
            </li>

    <?php
      }
    ?>