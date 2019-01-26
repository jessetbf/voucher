<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
 
<body>
    <div class="container">
            <div class="row">
                <h2>Community Cat Voucher History / Reprint</h2>
            </div>
            <div class="row">
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Vouchers Issued</th>
                      <th>Range</th>
                      <th>Date</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                   include 'database.php';
                   $pdo = Database::connect();
                   $lastname = '%' . $_POST['lastname'] . '%';
                   $sql = "SELECT * FROM colonies, caregivers
                                   WHERE UPPER(last_name) LIKE UPPER('$lastname')
                                     AND colonies.colony_id = caregivers.colony_id
                                ORDER BY last_name, caregivers.mod_date DESC";
                   foreach ($pdo->query($sql) as $row) {
                            echo '<tr>';
                            echo '<td>'. '<a href="genpdf.php?id=' . $row['colony_id']. '&county=' . 
                            $row['colony_county'] . '"">' . $row['first_name'] . ' ' . $row['last_name'] . '</a></td>';
                            echo '<td>'. $row['NumVouchIssued'] . '</td>';
                            echo '<td>'. $row['VoucherStartNum'] . '-' . $row['VoucherEndNum'] . '</td>';
                            echo '<td>'. $row['mod_date'] . '</td>';
                            echo '</tr>';
                   }
                   Database::disconnect();
                  ?>
                  </tbody>
            </table>
        </div>
    </div> <!-- /container -->
  </body>
</html>