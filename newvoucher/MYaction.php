<?php
require_once 'script/PDOModel.php';
$pdomodel = new PDOModel();
try {
    $pdomodel->connect("localhost", "root", "Pegasus99", "feralfix");
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
}

$post = post_array_check($_POST);

$colonies = array();
$caregivers = array();
$vouchers = array();

foreach ($post as $key => $value) {
    switch ($key) {
    case 'colonyAddress':
    case 'colonyCity':
    case 'colonyCounty':
    case 'colonyZip':
    case 'colonyTrapper':
    case 'numVouch':
    case 'vouchStart':
    case 'vouchEnd':
        $colonies[$key] = $value;
        break;
  }
}

foreach ($post as $key => $value) {
    switch ($key) {
    case 'CaregiverFirst':
    case 'CaregiverLast':
    case 'CaregiverDay':
    case 'CaregiverOther':
    case 'CaregiverEmail':
        $caregivers[$key] = $value;
        break;
  }
}

foreach ($post as $key => $value) {
    switch ($key) {
    case 'expireDate':
    case 'issuedByFirst':
    case 'issuedByLast':
    case 'issuedToFirst':
    case 'issuedToLast':
    case 'program':
    case 'copay':
        $vouchers[$key] = $value;
        break;
  }
}
$vouchers['expireDate'] = date('Y-m-d', strtotime($vouchers['expireDate']));


$pdomodel->dbTransaction = true; // Start PDO transaction. All 3+ INSERTs must complete with no errors.
$pdomodel->insert("colonies", $colonies);
$colony_id = $pdomodel->lastInsertId;
$caregivers['colony_id'] = $colony_id;
$vouchers['colony_id'] = $colony_id;
$pdomodel->insert("caregivers", $caregivers);
$counter = $colonies['numVouch'];
while ($counter-- > 0) {
    $vouchers['voucherNumber'] = $colonies['vouchStart'];
    $pdomodel->insert("vouchers", $vouchers);
    ++$colonies['vouchStart'];
}
$pdomodel->commitTransaction(); // End PDO transaction


function post_array_check($arr) {
    $new_arr = array();
    $new_val = '';
    foreach ($arr as $key => $value) {
        if ( !is_array($value) ) {
            $new_val = strip_tags(trim($value));
            $new_arr[$key] = htmlspecialchars($new_val, ENT_QUOTES, 'UTF-8');
            continue;
        }
        $str = '';
        foreach ($value as $v) {
            $str .= strip_tags(trim($v)) . ", ";
            $str = htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
        }
        $str = substr($str, 0, -2);
        $new_arr[$key] = $str;
    }
    return $new_arr;
}
header('Location: genpdf.php?id=' . $vouchers['colony_id'] . '&county=' . $caregivers['CaregiverCounty']);
?>
