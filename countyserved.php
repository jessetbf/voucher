<?php
define('INCLUDE_CHECK',true);
require 'connect.php';
    $probe="SELECT count(*) AS NUMVETS FROM vets WHERE countyserved = '" . $_POST['county'] . "'";
    $result=mysql_query($probe);
    if ( ! $result) { exit('<p>Error probing vets: ' . mysql_error() . '</p>'); }
    while($row = mysql_fetch_assoc($result)) {
    	echo $row['NUMVETS'];
	}
    mysql_close();
?>
