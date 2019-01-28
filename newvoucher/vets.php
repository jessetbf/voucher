<?php require_once 'script/pdocrud.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
</head>
<body class="hold-transition skin-blue sidebar-mini">
  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
      </section>
      <!-- Code box -->
      <section class="content">
        <?php
          $pdocrud = new PDOCrud();
          $pdocrud->setSkin("green");
/*          $pdocrud->crudRemoveCol(array("colony_id"));
          $pdocrud->colRename("colony_name", "Name");
          $pdocrud->colRename("colony_address", "Address");
          $pdocrud->colRename("colony_city", "City");
          $pdocrud->colRename("colony_county", "County");
          $pdocrud->colRename("colony_zip", "Zip");
          $pdocrud->colRename("NumVouchIssued", "# Issued");
          $pdocrud->colRename("VoucherStartNum", "Start");
          $pdocrud->colRename("VoucherEndNum", "End");
*/          echo $pdocrud->dbTable("vets")->render();
        ?>
      </section>
    </div>
  </div>
</body>

</html>