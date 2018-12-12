<?php
define('INCLUDE_CHECK',true);
require 'connect.php';
require('fpdf.php');

$pdf=new FPDF('P','mm','Letter');
$id = $_GET['id'];
$sql = "SELECT * FROM vouchers WHERE colony_id = " . $_GET['id'];
$result = mysqli_query($link,$sql) or die('Query failed: ' . mysqli_error($link));
if(mysqli_num_rows($result) == 0) die('Yeah, I got nothin.');
$vetsql = "SELECT * FROM vets WHERE CountyServed = '" . $_GET['county'] . "' AND active = 'Y'";
$vetresult = mysqli_query($link,$vetsql) or die('Query failed: ' . mysqli_error($link));
$infosql = "SELECT colony_name, colony_address, colony_aptnum, colony_city, colony_county,
  colony_zip, first_name, last_name, address, apt_num, city, county, zip, trapper FROM colonies,
  caregivers WHERE colonies.colony_id = " . $_GET['id'] . " AND caregivers.colony_id = colonies.colony_id";
$inforesult = mysqli_query($link,$infosql) or die('Query failed: ' . mysqli_error($link));
$infocount = mysqli_num_rows($inforesult);
while($inforow = mysqli_fetch_assoc($inforesult)) {
  $colony_name = $inforow['colony_name'];
  $colony_address = $inforow['colony_address'];
  $colony_aptnum = $inforow['colony_aptnum'];
  $colony_city = $inforow['colony_city'];
  $colony_zip = $inforow['colony_zip'];
  $colony_county = $inforow['colony_county'];
  $first_name = $inforow['first_name'];
  $last_name = $inforow['last_name'];
  $address = $inforow['address'];
  $apt_num = $inforow['apt_num'];
  $city = $inforow['city'];
  $zip = $inforow['zip'];
  $trapper = $inforow['trapper'];
}
  while($row = mysqli_fetch_assoc($result)) {
  $VoucherNum = $row['VoucherNumber'];
  $Program = $row['Program'];
  $IssuedTo = $row['FirstName'] . ' ' . $row['LastName'];
  $CoPay = $row['copay'] == -1 ? "" : $row['copay'];
  $ExpireDate = $row['ExpireDate'];

  $todays_date = date("Y-m-d");
  $today = strtotime($todays_date);
  $expiration_date = strtotime($ExpireDate);

  if ($expiration_date <= $today) {
       $ExpireDate = "" ;
  }
  $IssuedBy = $row['IssuedByFirst'] . ' ' . $row['IssuedByLast'];
  
  $pdf->SetTopMargin(15);
  $pdf->SetLeftMargin(16);
  $pdf->AddPage();
  // Main box
  $pdf->SetFont('Arial','B',16);
  $pdf->SetLineWidth(.7);
  $pdf->Cell(185,90,'',1,1,'C');
  // NMHPU logo
  $pdf->SetXY(0,0);
  $pdf->Image('img/bfu_logo.jpg',20,50,16);
  // FlatCC logo
  $pdf->SetXY(0,0);
  $pdf->Image('img/CC-Kitty.jpg',165,45,35);
  
  // Voucher Number
  $pdf->SetFont('Arial','B',16);
  $pdf->SetXY(18,17);
  $pdf->SetLineWidth(.3);
  $pdf->Cell(20,9,$VoucherNum,1,1,'C');
  // Program
  $pdf->SetFont('Arial','B',11);
  $pdf->SetXY(18,28);
  $pdf->SetLineWidth(.1);
  $w=$pdf->GetStringWidth($Program);
  $pdf->Cell($w+4,6,$Program,1,1,'C');
  // County
  $pdf->SetFont('Arial','B',11);
  $pdf->SetXY(45,19);
  $pdf->SetLineWidth(.1);
  $w=$pdf->GetStringWidth($colony_county);
  $pdf->Cell($w+4,6,$colony_county,1,1,'C');
  
  
  // Title
  $pdf->SetFont('Arial','',14);
  $pdf->SetXY(75,18);
  $pdf->MultiCell(80,5,'Best Friends Animal Society - Utah Community Cat Voucher',0,'C');
  // 'Issued to' information
  $pdf->SetXY(38,40);
  $pdf->SetFont('Times', 'B', 12);
  $pdf->Write(4, "*");
  $pdf->SetFont('');
  $pdf->SetFont('Times','',12);
  $pdf->Write(6,'Issued to:');
  $pdf->SetXY(40,43);
  $pdf->SetFont('Times','',12);
  $pdf->Cell(55,8,$IssuedTo);
  $pdf->Line(40,50,80,50);
  // 'Issued by'
  $pdf->SetXY(40,52);
  $pdf->Write(6,'Issued by:');
  $pdf->SetXY(40,55);
  $pdf->Cell(55,8,$IssuedBy);
  $pdf->Line(40,62,80,62);
  // 'Expires'
  $pdf->SetXY(40,64);
  $pdf->Write(6,'Expires:   ' . $ExpireDate);
  $pdf->Line(58,69,78,69);

  // Optional 'Volunteer:' line
  $pdf->SetXY(20,75);
  $pdf->Write(6, "Trapper:\n    (if different than above)" . $trapper);
  
  // 'Footer' info inside box
  $pdf->SetXY(65,89);
  $pdf->SetXY(55,94);
  $pdf->Write(6,'Call 801-574-2454 or visit bestfriendsutah.org/communitycats for details');
  $pdf->SetXY(93,99);
  $pdf->Write(6,'DO NOT DUPLICATE');
  
  // Dollar signs
  $pdf->SetFont('Arial','B',20);
  $pdf->SetXY(175,13);
  $pdf->Write(18,'$ ' . $CoPay);
  //  'Co-pay'
  $pdf->SetFont('Arial','B',14);
  $pdf->SetXY(176,25);
  $pdf->Write(6,'Co-pay');
  
  // 'Veterinary Use Only' Box
  $pdf->SetFillColor(235);
  $pdf->Rect(100,35,64,51,'F');
  $pdf->SetXY(113,35);
  $pdf->SetFont('Arial','BU',10);
  $pdf->Write(6, 'Veterinary Use Only');
  $pdf->SetXY(107,41);
  $pdf->SetFont('Arial','',8);
  $pdf->Write(6, 'Procedure: Cat ');
  $pdf->SetFont('Arial','I',8);
  $pdf->Write(6, '(veterinary check one)');
  $pdf->SetXY(113,46);
  $pdf->SetFont('Arial','B',8);
  $pdf->Write(6, '[  ] Spay      [  ]  Neuter');
  $pdf->SetXY(107,52);
  $pdf->SetFont('Arial','',8);
  $pdf->Write(6, 'Vaccines:');
  $pdf->SetXY(109,57);
  $pdf->SetFont('Arial','B',8);
  $pdf->Write(6, '[  ] Rabies    [  ]  FELV    [  ]  FVRCP');
  $pdf->SetXY(102,65);
  $pdf->SetFont('Arial','',8);
  $pdf->Write(6, 'Date of surgery: _______________________');
  $pdf->SetXY(102,72);
  $pdf->Write(6, 'Clinic: ________________________________');
  $pdf->SetXY(102,79);
  $pdf->Write(6, 'Age (circle one):   Kitten   Adult    Senior');
  
  // Stuff below the big, main box
  $pdf->SetXY(20,106);
  $pdf->Cell(180,6,'--- Do Not Cut - Do Not Cut - Do Not Cut ---',0,1,'C');
  $pdf->SetXY(19,125);
  $pdf->SetFontSize(11);
  $pdf->MultiCell(180,4,'**Rabies and FVRCP vaccinations are included**
  We provide the vaccinations to the clinics. Keep in mind most clinics may charge up to $5 fee per cat to cover the costs of syringes and disposal fees. Other vaccinations, testing and treatments are not covered under the voucher program.',1,'C');
  $pdf->SetXY(15,112);
  $pdf->MultiCell(190,4,'The copay should be paid directly to the clinic at the time of surgery. This donation helps support our ongoing work to solve the pet overpopulation problem in Utah shelters.',1);
  $pdf->SetXY(14,145);
  $pdf->SetFont('Arial','',10);
  $pdf->MultiCell(180,4,'Vouchers are non-transferable. Voucher expiration date cannot be extended. This voucher may not be used in conjunction with any other discount spay/neuter program. Funds for this coupon are limited and are intended to help those who could not otherwise afford the sterilization surgery.',1);
  $pdf->SetXY(14,166);
  $pdf->SetFont('Arial', 'B', 10);
  $pdf->Write(4, "Complete the following details. Do not leave blank. * denotes required fields.\n");
/*
  $pdf->Write(5, 'Caregiver Address:  ');
  $pdf->Cell(90,16,$first_name . ' ' . $last_name . ' ' . $address,1);
  $CurrY = $pdf->GetY();
  $CurrX = $pdf->GetX();
  $pdf->Write(5,' City:  ');
  $pdf->Cell(47,6,$city,1);
  $pdf->SetXY($CurrX,$CurrY+8);
  $pdf->Write(5,' Zip:   ');
  $pdf->Cell(47,6,$zip,1,1);
 */
  $pdf->Write(4, "\n*");
  $pdf->SetFont('');
  $pdf->Write(4,"Name of Cat and Description    ");
  $CurrY = $pdf->GetY();
  $CurrX = $pdf->GetX();
  $pdf->Cell(128,16,'',1,1);
  $pdf->SetXY($CurrX,$CurrY);
  $pdf->Write(4,"\n(color, fur length, eye color,\n");
  $pdf->Write(4,"markings, etc.):\n\n\n            ");
  $pdf->SetX($CurrX+50);
  $pdf->SetY($CurrY+23);
  $pdf->SetFont('Arial', 'B', 10);
  $pdf->Write(4, "*");
  $pdf->SetFont('');
  $pdf->Write(5, 'Location of cats (address):       ');
  $pdf->Cell(71,16,$colony_name . ' ' . $colony_address,1);
  $CurrY = $pdf->GetY();
  $CurrX = $pdf->GetX();
  $pdf->SetFont('Arial', 'B', 10);
  $pdf->Write(4, " *");
  $pdf->SetFont('');
  $pdf->Write(5,'City:  ');
  $pdf->Cell(47,6,$colony_city,1);
  $pdf->SetXY($CurrX,$CurrY+8);
  $pdf->SetFont('Arial', 'B', 10);
  $pdf->Write(4, " *");
  $pdf->SetFont('');
  $pdf->Write(5,'Zip:   ');
  $pdf->Cell(47,6,$colony_zip,1,1);
  $pdf->Write(4,"\n");
  $CurrY = $pdf->GetY();
  $CurrX = $pdf->GetX();
  $pdf->SetX($CurrX+30);
  $pdf->Cell(128,16,'',1,1);
  $pdf->SetXY($CurrX,$CurrY - 6);
  $pdf->Write(4,"\n\n");
  $pdf->Write(4,"De-worm?\nOther treatment?\nOther notes.\n\nExtra treatments/medical care are not covered by the voucher. ");

  // TNR definition
    $pdf->SetY(226);
  $pdf->SetFontSize(11);

  // 1st page footer
    $pdf->SetY(249);
  $pdf->SetFontSize(13);
    $pdf->Cell(0,10,'Please look on the back side for a list of program rules and participating clinics in your area',1,0,'C');

  // Add the back page information
  $pdf->AddPage();
  $pdf->SetFontSize(10);
  $pdf->SetXY(25,12);
  $pdf->MultiCell(160,4,'PROGRAM RULES. To ensure future funding of this program, this voucher must be used for its intended purpose.
  
  1.   Vouchers are non-transferable.
  2.   If the vouchers are being used in a way deemed inappropriate, we will not allow participation
        in the program.
  3.   The expiration date cannot be extended.
  4.   Call this clinic to make an appointment before the expiration date. Be sure to mention you
        are conducting Trap, Neuter, Return (TNR) and have a Community Cat voucher.
  5.   Take this voucher to the hospital when you take your Community Cat to be spayed or neutered.
  6.   The co-pay amount should be paid to the vet office and goes towards the cost of the surgery
        to help the funding of this program.
  7.   For the protection of the vet staff, all cats should be brought to the clinic in a humane
        trap, unless the vet staff has given permission to bring in a carrier for free-roaming, tame cats.
  8.  Whenever a cat is in a trap, the trap should be fully covered with a sheet at all times. When
       setting the trap, please line the bottom with newspaper. See Trapping Guidelines or
       search online: "Alley Cat Allies Trapping An Entire Colony" video for additional  information.
',1);
  $pdf->SetLeftMargin(25);
  $pdf->SetRightMargin(115);
  $pdf->SetXY(25,88);
  $counter = 0;
  $HEIGHT = 4.5;
  while($vetrow = mysqli_fetch_assoc($vetresult)) {
    $pdf->SetFont('Arial','B',10);
    $pdf->Write($HEIGHT, $vetrow['Clinic'] . "\n");
    $pdf->SetFont('Arial','',10);
    $pdf->Write($HEIGHT, $vetrow['Phone'] . "\n");
    $pdf->Write($HEIGHT, $vetrow['MailingAddress'] . ", ");
    $pdf->Write($HEIGHT, $vetrow['City'] . " ");
    $pdf->Write($HEIGHT, $vetrow['Zip'] . "\n");
    $pdf->Write($HEIGHT, $vetrow['HoursInfo'] . "\n\n");
    if (++$counter == 5) {
      $pdf->SetLeftMargin(120);
      $pdf->SetRightMargin(25);
      $pdf->SetXY(120,88);
    }
  }
  $pdf->SetRightMargin(15);
  mysqli_data_seek($vetresult, 0) or die('Seek failed: ' . mysqli_error($link) . "<br><br>" . $vetsql);
  }
$pdf->Output();
mysqli_close($link);
?>
