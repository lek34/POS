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
                <a href="" class="nav-link <?php echo isPageActive("beranda") ? 'active' : ''; ?>">
                <i class="fa-sharp fa-regular fa-chart-line-down"></i>
                <p>
                    Dashboard
                </p>
                </a>
               </li>

    <?php
      }
    ?>