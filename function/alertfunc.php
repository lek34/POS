<?php
        function alertText ($alert, $text){
            if ($alert % 2 == 1 ) {
              echo "<div class='alert alert-success alert dismissable'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4>  <i class='icon fa fa-check-circle'></i> Berhasil!</h4>
              $text
              </div>";
            } else {
              echo "<div class='alert alert-danger alert dismissable'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4>  <i class='icon fa fa-times-circle'></i> Gagal!</h4>
              $text
              </div>";
            }
        }
    
        if (isset($_GET['alert'])){
          $alert =  $_GET['alert'];
    
          switch ($alert){
            case 1:
              alertText(1, "Data berhasil ditambahkan");
              break;
            case 2:
              alertText(2, "Data gagal ditambahkan");
              break;
            case 3:
              alertText(3, "Data berhasil di-edit");
              break;
            case 4:
              alertText(4, "Data gagal di-edit");
              break;
            case 5:
              alertText(5, "Data berhasil dihapus");
              break;
            case 6:
              alertText(6, "Data gagal dihapus");
              break;  
          }
        }
?>