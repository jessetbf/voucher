<?php $groupswithaccess="CLIENT"; require_once("../slpw/sitelokpw.php"); ?>
<?php
define('INCLUDE_CHECK',true);
require 'connect.php';
if (isset($_POST['Generate'])) {
	$numvouch =         $_POST['numvouch'];
	$vouchstart =       $_POST['vouchstart'];
	$vouchend =         $_POST['vouchend'];
	$issuedtofirst =    mysql_real_escape_string($_POST['issuedtofirst']);
	$issuedtolast =     mysql_real_escape_string($_POST['issuedtolast']);
	$issuedbyfirst =    mysql_real_escape_string($_POST['issuedbyfirst']);
	$issuedbylast =     mysql_real_escape_string($_POST['issuedbylast']);
	$expires =          date('Y-m-d', strtotime($_POST['expires']));
	$program =          $_POST['program'];
	$copay =            $_POST['copay'];
	$ColonyName =       $_POST['ColonyName'];
	$ColonyAddress =    mysql_real_escape_string($_POST['ColonyAddress']);
	$ColonyApt =        $_POST['ColonyApt'];
	$ColonyCity =       $_POST['ColonyCity'];
	$ColonyCounty =     $_POST['ColonyCounty'];
	$ColonyZip =        $_POST['ColonyZip'];
	$ColonyTrapper =    $_POST['ColonyTrapper'];
	$CaregiverFirst =   $_POST['CaregiverFirst'];
	$CaregiverLast =    $_POST['CaregiverLast'];
	$CaregiverDay =     $_POST['CaregiverDay'];
	$CaregiverOther =   $_POST['CaregiverOther'];
	$CaregiverEmail =   $_POST['CaregiverEmail'];
	$CaregiverAddress = $_POST['CaregiverAddress'];
	$CaregiverApt =     $_POST['CaregiverApt'];
	$CaregiverCity =    $_POST['CaregiverCity'];
	$CaregiverCounty =  $_POST['CaregiverCounty'];
	$CaregiverZip =     $_POST['CaregiverZip'];
	$copay = ($copay == "") ? -1 : $copay;
	$sql = "INSERT INTO colonies (colony_id, colony_name, colony_address, colony_aptnum, colony_city,
				colony_county, colony_zip, NumVouchIssued, VoucherStartNum, VoucherEndNum,
				trapper, mod_by, mod_date)
			VALUES (null, '$ColonyName', '$ColonyAddress', '$ColonyApt', '$ColonyCity', '$ColonyCounty',
					'$ColonyZip', $numvouch, $vouchstart, $vouchend, '$ColonyTrapper', '$slusername', null)";
	$result = mysql_query($sql) or die('Colonies query failed: ' . "<p>" . $sql . "</p>" . mysql_error());
	$colonyid = mysql_insert_id();
	$counter = $numvouch;
	while ($counter-- > 0) {
		$sql = "INSERT INTO vouchers (id, VoucherNumber, ExpireDate, IssuedByFirst, IssuedByLast, FirstName, LastName, Program, copay,
							colony_id, mod_by, mod_date)
						VALUES (null, $vouchstart, '$expires', '$issuedbyfirst', '$issuedbylast', '$issuedtofirst', '$issuedtolast', '$program', '$copay',
							$colonyid, '$slusername', null)";
		$result = mysql_query($sql) or die('Voucher query failed: ' . "<p>" . $sql . "</p>" . mysql_error());
		++$vouchstart;
	}
	$sql = "INSERT INTO caregivers (caregiver_id, first_name, last_name, day_phone, other_phone, email, address,
						apt_num, city, county, zip, colony_id, mod_by, mod_date)
					VALUES (null, '$CaregiverFirst', '$CaregiverLast', '$CaregiverDay', '$CaregiverOther', '$CaregiverEmail',
						'$CaregiverAddress', '$CaregiverApt', '$CaregiverCity', '$CaregiverCounty', '$CaregiverZip', $colonyid, '$slusername', null)";
	$result = mysql_query($sql) or die('Caregivers query failed: ' . "<p>" . $sql . "</p>" . mysql_error());
	mysql_close();
	header('Location: genpdf.php?id=' . $colonyid . '&county=' . $CaregiverCounty);
} else {
	$sql = "SELECT MAX(VoucherNumber) AS nextvoucher FROM vouchers";
	$result = mysql_query($sql) or die('Query failed: ' . mysql_error());
	$row = mysql_fetch_array($result);
	$nextvoucher = $row['nextvoucher'];
	mysql_close();}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Generate Feral Fix vouchers</title>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
    <link type="text/css" href="css/ui-lightness/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" />
    <script src="js/jquery-1.9.1.js" type="text/javascript"></script>
    <script src="js/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
    <script type="text/javascript" charset="utf-8">
		$(function(){
		  $.datepicker.setDefaults(
			$.extend($.datepicker.regional[""])
		  );
		  $("#expires").datepicker({ dateFormat: 'yy-mm-dd' });
		});
    </script>
<!-- TinyMCE -->
<script type="text/javascript" src="tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		theme : "simple"
	});
</script>
<!-- /TinyMCE -->
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	background-color: #F2E7C4;
}
</style>
<script type="text/javascript">
	function checkVets() {
	    var fragment="county=" + $("#ColonyCounty").val();
	    $.ajax({
	      type: "POST",
	      url: "countyserved.php",
	      data: fragment,
	      async: false,
	      success: function(returnval) {
                if (returnval == 0) {
                    alert("We don't have any vets defined that service " + $("#ColonyCounty").val() + ". Please fix it before continuing.");
                    return false;
                }
	      }
	    });
	}
</script>
<?php
	if (isset($nextvoucher)) { 
?>
<script type="text/javascript">

	function endingvoucher() {
//		document.vouchers.vouchend.disabled = "false";
		document.vouchers.vouchend.value = (parseInt(document.vouchers.numvouch.value) + parseInt(document.vouchers.vouchstart.value) - 1);
//		document.vouchers.vouchend.readonly = "true";
//		document.vouchers.vouchstart.disabled = "false";
//		document.vouchers.vouchstart.readonly = "true";

	}

	function BuildColonyName(lname) {
		document.vouchers.CaregiverFirst.value=document.vouchers.issuedtofirst.value;
		document.vouchers.CaregiverLast.value=lname;
//		document.vouchers.ColonyTrapper.value=document.vouchers.ColonyName.value + " " + lname;
		document.vouchers.ColonyName.value=document.vouchers.ColonyName.value + "_" + lname;
	}
	
	function getSelectedValue() {
		var index = document.getElementById('ColonyCounty').selectedIndex;
		document.getElementById('CaregiverCounty').options[index].selected = true;
//		document.getElementById('program').value=document.getElementById('CaregiverCounty').value;
	}

</script>
<?php } ?>
</head>
<body>
<p>You are logged in as <?php echo $slusername; ?></p>
<p>click here to <a href="<?php /* siteloklogout($_SERVER['PHP_SELF']); */ ?>"><img src="img/logout.png" alt="Logout button" /></a></p>
<h1>Generate vouchers</h1>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="vouchers">
<table width="700" border="0">
  <tr>
    <td width="144" align="right"><label># of vouchers to generate:</label></td>
    <td width="298"><select name="numvouch" size="1" onchange="endingvoucher();">
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5</option>
      <option value="6">6</option>
      <option value="7">7</option>
      <option value="8">8</option>
      <option value="9">9</option>
      <option value="10">10</option>
      <option value="11">11</option>
      <option value="12">12</option>
      <option value="13">13</option>
      <option value="14">14</option>
      <option value="15">15</option>
      <option value="16">16</option>
      <option value="17">17</option>
      <option value="18">18</option>
      <option value="19">19</option>
      <option value="20">20</option>
      <option value="21">21</option>
      <option value="22">22</option>
      <option value="23">23</option>
      <option value="24">24</option>
      <option value="25">25</option>
      <option value="30">30</option>
      <option value="40">40</option>
      <option value="50">50</option>
    </select></td>
  </tr>
  <tr>
    <td align="right"><label for="vouchstart">Starting voucher #:</label></td>
    <td><input name="vouchstart" type="text" id="vouchstart" value="<?php echo $nextvoucher + 1; ?>" size="8" maxlength="6" /></td>
  </tr>
  <tr>
    <td align="right"><label for="vouchend">Ending voucher #: </label></td>
    <td><input name="vouchend" type="text" id="vouchend" value="<?php echo $nextvoucher + 1; ?>" size="8" maxlength="6" /></td>
  </tr>
  <tr>
    <td align="right"><label for="issuedtofirst">Issued to:</label></td>
    <td>First name: <input type="text" name="issuedtofirst" id="issuedtofirst" onChange="this.form.ColonyName.value=value;" /></td>
    <td width="244">Last name: <input type="text" name="issuedtolast" id="issuedtolast" onChange="BuildColonyName(value);"/></td>
  </tr>
  <tr>
    <td align="right"><label for="issuedbyfirst">Issued by:</label></td>
    <td><span id="sprytextfield2">
    First name: <input type="text" name="issuedbyfirst" id="issuedbyfirst" />
    <span class="textfieldRequiredMsg">A value is required.</span></span></p></td>
    <td><span id="sprytextfield3">
      <label for="issuedbylast">Last name:</label>
      <input type="text" name="issuedbylast" id="issuedbylast" />
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
  </tr>
  <tr>
    <td align="right"><label for="program">Program:</label></td>
    <td width="298"><select name="program" size="1">
      <option value="TNR">TNR</option>
      <option value="Staff TNR">Staff TNR</option>
      <option value="SNR">SNR</option>
      <option value="Staff SNR">Staff SNR</option>
      <option value="So Salt Lake - SNR">So Salt Lake - SNR</option>
      <option value="WVAS - SNR">WVAS - SNR</option>
      <option value="SLCo AS - TNR">SLCo AS - TNR</option>
      <option value="Murray AS - SNR">Murray AS - SNR</option>
      <option value="So. Ogden - SNR">So. Ogden - SNR</option>
    </select></td>
  </tr>
  <tr>
    <td align="right"><label for="copay">CoPay:</label></td>
    <td><input name="copay" type="text" id="copay" size="6" maxlength="2" /></td>
  </tr>
  <tr>
    <td align="right"><label for="expires">Expires:</label></td>
    <td>
    <input type="text" name="expires" id="expires" />
  </td>
  </tr>
  <tr>
  	<td colspan="2">
   	  <h2>Colony Information </h2></td>
  </tr>
  <tr>
  	<td align="right">Colony name:</td>
    <td><input type="text" name="ColonyName" id="ColonyName" /></td>
  </tr>
  <tr>
  	<td align="right">Colony address:</td>
    <td><input type="text" name="ColonyAddress" id="ColonyAddress" onChange="this.form.CaregiverAddress.value=value;" /></td>
  </tr>
  <tr>
  	<td align="right">Apt #</td>
    <td><input name="ColonyApt" type="text" id="ColonyApt" size="6" onChange="this.form.CaregiverApt.value=value;" /></td>
  </tr>
  <tr>
  	<td align="right">City</td>
    <td><input name="ColonyCity" type="text" id="ColonyCity" size="20" onChange="this.form.CaregiverCity.value=value;" /></td>
  </tr>
  <tr>
  	<td align="right">County</td>
    <td><select name="ColonyCounty" id="ColonyCounty" onChange="getSelectedValue(); checkVets(); ">
            <option value="">Choose County:</option>
            <option value="Beaver">Beaver</option>
            <option value="Box Elder">Box Elder</option>
            <option value="Cache">Cache</option>
            <option value="Carbon">Carbon</option>
            <option value="Daggett">Daggett</option>
            <option value="Davis">Davis</option>
            <option value="Duchesne">Duchesne</option>
            <option value="Emery">Emery</option>
            <option value="Garfield">Garfield</option>
            <option value="Grand">Grand</option>
            <option value="Iron">Iron</option>
            <option value="Juab">Juab</option>
            <option value="Kane">Kane</option>
            <option value="Millard">Millard</option>
            <option value="Morgan">Morgan</option>
            <option value="Piute">Piute</option>
            <option value="Rich">Rich</option>
            <option value="Salt Lake">Salt Lake</option>
            <option value="San Juan">San Juan</option>
            <option value="Sanpete">Sanpete</option>
            <option value="Sevier">Sevier</option>
            <option value="Summit">Summit</option>
            <option value="Tooele">Tooele</option>
            <option value="Uintah">Uintah</option>
            <option value="Utah">Utah</option>
            <option value="Wasatch">Wasatch</option>
            <option value="Washington">Washington</option>
            <option value="Wayne">Wayne</option>
            <option value="Weber">Weber</option>
    </select>
    </td>
  </tr>
  <tr>
  	<td align="right">Zip</td>
    <td><span id="sprytextfield4">
      <input type="text" name="ColonyZip" id="ColonyZip" onChange="this.form.CaregiverZip.value=value;" />
      <span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>
  </tr>
  <tr>
  	<td align="right">Trapper</td>
    <td><input type="text" name="ColonyTrapper" id="ColonyTrapper" /></td>
  </tr>
  <tr>
  	<td colspan="2">
   	  <h2>Caregiver Information </h2></td>
  </tr>
  <tr>
    <td align="right">First name:</td>
    <td><input type="text" name="CaregiverFirst" id="CaregiverFirst" /></td>
    <td>Last name: <input type="text" name="CaregiverLast" id="CaregiverLast" /></td>
  </tr>
  <tr>
    <td align="right">Day phone: </td>
    <td><input type="text" name="CaregiverDay" id="CaregiverDay" /></td>
    <td>Other phone:<input type="text" name="CaregiverOther" id="CaregiverOther" /></td>
  </tr>
  <tr>
  	<td align="right">Email</td>
    <td><span id="sprytextfield5">
      <input type="text" name="CaregiverEmail" id="CaregiverEmail" />
      <span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>
  </tr>
  <tr>
  	<td align="right">Address</td>
    <td><input type="text" name="CaregiverAddress" id="CaregiverAddress" /></td>
  </tr>
  <tr>
  	<td align="right">Apt #</td>
    <td><input name="CaregiverApt" type="text" id="CaregiverApt" size="6" /></td>
  </tr>
  <tr>
  	<td align="right">City</td>
    <td><input type="text" name="CaregiverCity" id="CaregiverCity" /></td>
  </tr>
  <tr>
  	<td align="right">County</td>
    <td><select name="CaregiverCounty" id="CaregiverCounty">
            <option value="">Choose County:</option>
            <option value="Beaver">Beaver</option>
            <option value="Box Elder">Box Elder</option>
            <option value="Cache">Cache</option>
            <option value="Carbon">Carbon</option>
            <option value="Daggett">Daggett</option>
            <option value="Davis">Davis</option>
            <option value="Duchesne">Duchesne</option>
            <option value="Emery">Emery</option>
            <option value="Garfield">Garfield</option>
            <option value="Grand">Grand</option>
            <option value="Iron">Iron</option>
            <option value="Juab">Juab</option>
            <option value="Kane">Kane</option>
            <option value="Millard">Millard</option>
            <option value="Morgan">Morgan</option>
            <option value="Piute">Piute</option>
            <option value="Rich">Rich</option>
            <option value="Salt Lake">Salt Lake</option>
            <option value="San Juan">San Juan</option>
            <option value="Sanpete">Sanpete</option>
            <option value="Sevier">Sevier</option>
            <option value="Summit">Summit</option>
            <option value="Tooele">Tooele</option>
            <option value="Uintah">Uintah</option>
            <option value="Utah">Utah</option>
            <option value="Wasatch">Wasatch</option>
            <option value="Washington">Washington</option>
            <option value="Wayne">Wayne</option>
            <option value="Weber">Weber</option>
    	</select>
    </td>
  </tr>
  <tr>
  	<td align="right">Zip</td>
    <td><span id="sprytextfield6">
    <input name="CaregiverZip" type="text" id="CaregiverZip" size="10" />
<span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>
  </tr>
  <tr>
  	<td><p>&nbsp;</p></td>
    <td></td>
  </tr>
  <tr>
    <td align="right"><input name="Generate" type="submit" value="Generate" /></td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "zip_code", {validateOn:["blur"], isRequired:false});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "email", {isRequired:false});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "zip_code", {isRequired:false});
</script>
<p>click here to <a href="<?php /* siteloklogout($_SERVER['PHP_SELF']); */ ?>"><img src="img/logout.png" alt="Logout button" /></a></p>
</body>
</html>