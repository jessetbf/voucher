<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg8.php" ?>
<?php include_once "ewmysql8.php" ?>
<?php include_once "phpfn8.php" ?>
<?php include_once "vouchersinfo.php" ?>
<?php include_once "coloniesinfo.php" ?>
<?php include_once "userfn8.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
$vouchers_delete = new cvouchers_delete();
$Page =& $vouchers_delete;

// Page init
$vouchers_delete->Page_Init();

// Page main
$vouchers_delete->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var vouchers_delete = new ew_Page("vouchers_delete");

// page properties
vouchers_delete.PageID = "delete"; // page ID
vouchers_delete.FormID = "fvouchersdelete"; // form ID
var EW_PAGE_ID = vouchers_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
vouchers_delete.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
vouchers_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
vouchers_delete.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php

// Load records for display
if ($vouchers_delete->Recordset = $vouchers_delete->LoadRecordset())
	$vouchers_deleteTotalRecs = $vouchers_delete->Recordset->RecordCount(); // Get record count
if ($vouchers_deleteTotalRecs <= 0) { // No record found, exit
	if ($vouchers_delete->Recordset)
		$vouchers_delete->Recordset->Close();
	$vouchers_delete->Page_Terminate("voucherslist.php"); // Return to list
}
?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("Delete") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $vouchers->TableCaption() ?></p>
<p class="phpmaker"><a href="<?php echo $vouchers->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $vouchers_delete->ShowPageHeader(); ?>
<?php
$vouchers_delete->ShowMessage();
?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="vouchers">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($vouchers_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $vouchers->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top"><?php echo $vouchers->id->FldCaption() ?></td>
		<td valign="top"><?php echo $vouchers->VoucherNumber->FldCaption() ?></td>
		<td valign="top"><?php echo $vouchers->ExpireDate->FldCaption() ?></td>
		<td valign="top"><?php echo $vouchers->IssuedByFirst->FldCaption() ?></td>
		<td valign="top"><?php echo $vouchers->IssuedByLast->FldCaption() ?></td>
		<td valign="top"><?php echo $vouchers->FirstName->FldCaption() ?></td>
		<td valign="top"><?php echo $vouchers->LastName->FldCaption() ?></td>
		<td valign="top"><?php echo $vouchers->Program->FldCaption() ?></td>
		<td valign="top"><?php echo $vouchers->cat_name->FldCaption() ?></td>
		<td valign="top"><?php echo $vouchers->cat_breed->FldCaption() ?></td>
		<td valign="top"><?php echo $vouchers->cat_age->FldCaption() ?></td>
		<td valign="top"><?php echo $vouchers->copay->FldCaption() ?></td>
		<td valign="top"><?php echo $vouchers->cat_status->FldCaption() ?></td>
		<td valign="top"><?php echo $vouchers->date_redeemed->FldCaption() ?></td>
		<td valign="top"><?php echo $vouchers->Clinic->FldCaption() ?></td>
		<td valign="top"><?php echo $vouchers->ClinicPrice->FldCaption() ?></td>
		<td valign="top"><?php echo $vouchers->vet_used->FldCaption() ?></td>
		<td valign="top"><?php echo $vouchers->colony_id->FldCaption() ?></td>
		<td valign="top"><?php echo $vouchers->Spay->FldCaption() ?></td>
		<td valign="top"><?php echo $vouchers->Neuter->FldCaption() ?></td>
		<td valign="top"><?php echo $vouchers->FVRCP->FldCaption() ?></td>
		<td valign="top"><?php echo $vouchers->FELV->FldCaption() ?></td>
		<td valign="top"><?php echo $vouchers->Rabies->FldCaption() ?></td>
		<td valign="top"><?php echo $vouchers->Pregnant->FldCaption() ?></td>
		<td valign="top"><?php echo $vouchers->AssignedTo->FldCaption() ?></td>
		<td valign="top"><?php echo $vouchers->mod_by->FldCaption() ?></td>
		<td valign="top"><?php echo $vouchers->mod_date->FldCaption() ?></td>
	</tr>
	</thead>
	<tbody>
<?php
$vouchers_delete->RecCnt = 0;
$i = 0;
while (!$vouchers_delete->Recordset->EOF) {
	$vouchers_delete->RecCnt++;

	// Set row properties
	$vouchers->ResetAttrs();
	$vouchers->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$vouchers_delete->LoadRowValues($vouchers_delete->Recordset);

	// Render row
	$vouchers_delete->RenderRow();
?>
	<tr<?php echo $vouchers->RowAttributes() ?>>
		<td<?php echo $vouchers->id->CellAttributes() ?>>
<div<?php echo $vouchers->id->ViewAttributes() ?>><?php echo $vouchers->id->ListViewValue() ?></div></td>
		<td<?php echo $vouchers->VoucherNumber->CellAttributes() ?>>
<div<?php echo $vouchers->VoucherNumber->ViewAttributes() ?>><?php echo $vouchers->VoucherNumber->ListViewValue() ?></div></td>
		<td<?php echo $vouchers->ExpireDate->CellAttributes() ?>>
<div<?php echo $vouchers->ExpireDate->ViewAttributes() ?>><?php echo $vouchers->ExpireDate->ListViewValue() ?></div></td>
		<td<?php echo $vouchers->IssuedByFirst->CellAttributes() ?>>
<div<?php echo $vouchers->IssuedByFirst->ViewAttributes() ?>><?php echo $vouchers->IssuedByFirst->ListViewValue() ?></div></td>
		<td<?php echo $vouchers->IssuedByLast->CellAttributes() ?>>
<div<?php echo $vouchers->IssuedByLast->ViewAttributes() ?>><?php echo $vouchers->IssuedByLast->ListViewValue() ?></div></td>
		<td<?php echo $vouchers->FirstName->CellAttributes() ?>>
<div<?php echo $vouchers->FirstName->ViewAttributes() ?>><?php echo $vouchers->FirstName->ListViewValue() ?></div></td>
		<td<?php echo $vouchers->LastName->CellAttributes() ?>>
<div<?php echo $vouchers->LastName->ViewAttributes() ?>><?php echo $vouchers->LastName->ListViewValue() ?></div></td>
		<td<?php echo $vouchers->Program->CellAttributes() ?>>
<div<?php echo $vouchers->Program->ViewAttributes() ?>><?php echo $vouchers->Program->ListViewValue() ?></div></td>
		<td<?php echo $vouchers->cat_name->CellAttributes() ?>>
<div<?php echo $vouchers->cat_name->ViewAttributes() ?>><?php echo $vouchers->cat_name->ListViewValue() ?></div></td>
		<td<?php echo $vouchers->cat_breed->CellAttributes() ?>>
<div<?php echo $vouchers->cat_breed->ViewAttributes() ?>><?php echo $vouchers->cat_breed->ListViewValue() ?></div></td>
		<td<?php echo $vouchers->cat_age->CellAttributes() ?>>
<div<?php echo $vouchers->cat_age->ViewAttributes() ?>><?php echo $vouchers->cat_age->ListViewValue() ?></div></td>
		<td<?php echo $vouchers->copay->CellAttributes() ?>>
<div<?php echo $vouchers->copay->ViewAttributes() ?>><?php echo $vouchers->copay->ListViewValue() ?></div></td>
		<td<?php echo $vouchers->cat_status->CellAttributes() ?>>
<div<?php echo $vouchers->cat_status->ViewAttributes() ?>><?php echo $vouchers->cat_status->ListViewValue() ?></div></td>
		<td<?php echo $vouchers->date_redeemed->CellAttributes() ?>>
<div<?php echo $vouchers->date_redeemed->ViewAttributes() ?>><?php echo $vouchers->date_redeemed->ListViewValue() ?></div></td>
		<td<?php echo $vouchers->Clinic->CellAttributes() ?>>
<div<?php echo $vouchers->Clinic->ViewAttributes() ?>><?php echo $vouchers->Clinic->ListViewValue() ?></div></td>
		<td<?php echo $vouchers->ClinicPrice->CellAttributes() ?>>
<div<?php echo $vouchers->ClinicPrice->ViewAttributes() ?>><?php echo $vouchers->ClinicPrice->ListViewValue() ?></div></td>
		<td<?php echo $vouchers->vet_used->CellAttributes() ?>>
<div<?php echo $vouchers->vet_used->ViewAttributes() ?>><?php echo $vouchers->vet_used->ListViewValue() ?></div></td>
		<td<?php echo $vouchers->colony_id->CellAttributes() ?>>
<div<?php echo $vouchers->colony_id->ViewAttributes() ?>><?php echo $vouchers->colony_id->ListViewValue() ?></div></td>
		<td<?php echo $vouchers->Spay->CellAttributes() ?>>
<div<?php echo $vouchers->Spay->ViewAttributes() ?>><?php echo $vouchers->Spay->ListViewValue() ?></div></td>
		<td<?php echo $vouchers->Neuter->CellAttributes() ?>>
<div<?php echo $vouchers->Neuter->ViewAttributes() ?>><?php echo $vouchers->Neuter->ListViewValue() ?></div></td>
		<td<?php echo $vouchers->FVRCP->CellAttributes() ?>>
<div<?php echo $vouchers->FVRCP->ViewAttributes() ?>><?php echo $vouchers->FVRCP->ListViewValue() ?></div></td>
		<td<?php echo $vouchers->FELV->CellAttributes() ?>>
<div<?php echo $vouchers->FELV->ViewAttributes() ?>><?php echo $vouchers->FELV->ListViewValue() ?></div></td>
		<td<?php echo $vouchers->Rabies->CellAttributes() ?>>
<div<?php echo $vouchers->Rabies->ViewAttributes() ?>><?php echo $vouchers->Rabies->ListViewValue() ?></div></td>
		<td<?php echo $vouchers->Pregnant->CellAttributes() ?>>
<div<?php echo $vouchers->Pregnant->ViewAttributes() ?>><?php echo $vouchers->Pregnant->ListViewValue() ?></div></td>
		<td<?php echo $vouchers->AssignedTo->CellAttributes() ?>>
<div<?php echo $vouchers->AssignedTo->ViewAttributes() ?>><?php echo $vouchers->AssignedTo->ListViewValue() ?></div></td>
		<td<?php echo $vouchers->mod_by->CellAttributes() ?>>
<div<?php echo $vouchers->mod_by->ViewAttributes() ?>><?php echo $vouchers->mod_by->ListViewValue() ?></div></td>
		<td<?php echo $vouchers->mod_date->CellAttributes() ?>>
<div<?php echo $vouchers->mod_date->ViewAttributes() ?>><?php echo $vouchers->mod_date->ListViewValue() ?></div></td>
	</tr>
<?php
	$vouchers_delete->Recordset->MoveNext();
}
$vouchers_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="Action" id="Action" value="<?php echo ew_BtnCaption($Language->Phrase("DeleteBtn")) ?>">
</form>
<?php
$vouchers_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php include_once "footer.php" ?>
<?php
$vouchers_delete->Page_Terminate();
?>
<?php

//
// Page class
//
class cvouchers_delete {

	// Page ID
	var $PageID = 'delete';

	// Table name
	var $TableName = 'vouchers';

	// Page object name
	var $PageObjName = 'vouchers_delete';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $vouchers;
		if ($vouchers->UseTokenInUrl) $PageUrl .= "t=" . $vouchers->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	// Show message
	function ShowMessage() {
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			echo "<p class=\"ewMessage\">" . $sMessage . "</p>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			echo "<p class=\"ewSuccessMessage\">" . $sSuccessMessage . "</p>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			echo "<p class=\"ewErrorMessage\">" . $sErrorMessage . "</p>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p class=\"phpmaker\">" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Fotoer exists, display
			echo "<p class=\"phpmaker\">" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm, $vouchers;
		if ($vouchers->UseTokenInUrl) {
			if ($objForm)
				return ($vouchers->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($vouchers->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cvouchers_delete() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (vouchers)
		if (!isset($GLOBALS["vouchers"])) {
			$GLOBALS["vouchers"] = new cvouchers();
			$GLOBALS["Table"] =& $GLOBALS["vouchers"];
		}

		// Table object (colonies)
		if (!isset($GLOBALS['colonies'])) $GLOBALS['colonies'] = new ccolonies();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'vouchers', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;
		global $vouchers;

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();
		$this->Page_Redirecting($url);

		 // Close connection
		$conn->Close();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $Language, $vouchers;

		// Load key parameters
		$this->RecKeys = $vouchers->GetRecordKeys(); // Load record keys
		$sFilter = $vouchers->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("voucherslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in vouchers class, vouchersinfo.php

		$vouchers->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$vouchers->CurrentAction = $_POST["a_delete"];
		} else {
			$vouchers->CurrentAction = "I"; // Display record
		}
		switch ($vouchers->CurrentAction) {
			case "D": // Delete
				$vouchers->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($vouchers->getReturnUrl()); // Return to caller
				}
		}
	}

// No functions
	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $vouchers;

		// Call Recordset Selecting event
		$vouchers->Recordset_Selecting($vouchers->CurrentFilter);

		// Load List page SQL
		$sSql = $vouchers->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$vouchers->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $vouchers;
		$sFilter = $vouchers->KeyFilter();

		// Call Row Selecting event
		$vouchers->Row_Selecting($sFilter);

		// Load SQL based on filter
		$vouchers->CurrentFilter = $sFilter;
		$sSql = $vouchers->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $vouchers;
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row =& $rs->fields;
		$vouchers->Row_Selected($row);
		$vouchers->id->setDbValue($rs->fields('id'));
		$vouchers->VoucherNumber->setDbValue($rs->fields('VoucherNumber'));
		$vouchers->ExpireDate->setDbValue($rs->fields('ExpireDate'));
		$vouchers->IssuedByFirst->setDbValue($rs->fields('IssuedByFirst'));
		$vouchers->IssuedByLast->setDbValue($rs->fields('IssuedByLast'));
		$vouchers->FirstName->setDbValue($rs->fields('FirstName'));
		$vouchers->LastName->setDbValue($rs->fields('LastName'));
		$vouchers->Program->setDbValue($rs->fields('Program'));
		$vouchers->cat_name->setDbValue($rs->fields('cat_name'));
		$vouchers->cat_breed->setDbValue($rs->fields('cat_breed'));
		$vouchers->cat_age->setDbValue($rs->fields('cat_age'));
		$vouchers->copay->setDbValue($rs->fields('copay'));
		$vouchers->cat_status->setDbValue($rs->fields('cat_status'));
		$vouchers->date_redeemed->setDbValue($rs->fields('date_redeemed'));
		$vouchers->Clinic->setDbValue($rs->fields('Clinic'));
		$vouchers->ClinicPrice->setDbValue($rs->fields('ClinicPrice'));
		$vouchers->vet_used->setDbValue($rs->fields('vet_used'));
		$vouchers->colony_id->setDbValue($rs->fields('colony_id'));
		$vouchers->Spay->setDbValue($rs->fields('Spay'));
		$vouchers->Neuter->setDbValue($rs->fields('Neuter'));
		$vouchers->FVRCP->setDbValue($rs->fields('FVRCP'));
		$vouchers->FELV->setDbValue($rs->fields('FELV'));
		$vouchers->Rabies->setDbValue($rs->fields('Rabies'));
		$vouchers->Pregnant->setDbValue($rs->fields('Pregnant'));
		$vouchers->AssignedTo->setDbValue($rs->fields('AssignedTo'));
		$vouchers->mod_by->setDbValue($rs->fields('mod_by'));
		$vouchers->mod_date->setDbValue($rs->fields('mod_date'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $vouchers;

		// Initialize URLs
		// Call Row_Rendering event

		$vouchers->Row_Rendering();

		// Common render codes for all row types
		// id
		// VoucherNumber
		// ExpireDate
		// IssuedByFirst
		// IssuedByLast
		// FirstName
		// LastName
		// Program
		// cat_name
		// cat_breed
		// cat_age
		// copay
		// cat_status
		// date_redeemed
		// Clinic
		// ClinicPrice
		// vet_used
		// colony_id
		// Spay
		// Neuter
		// FVRCP
		// FELV
		// Rabies
		// Pregnant
		// AssignedTo
		// mod_by
		// mod_date

		if ($vouchers->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$vouchers->id->ViewValue = $vouchers->id->CurrentValue;
			$vouchers->id->ViewCustomAttributes = "";

			// VoucherNumber
			$vouchers->VoucherNumber->ViewValue = $vouchers->VoucherNumber->CurrentValue;
			$vouchers->VoucherNumber->ViewCustomAttributes = "";

			// ExpireDate
			$vouchers->ExpireDate->ViewValue = $vouchers->ExpireDate->CurrentValue;
			$vouchers->ExpireDate->ViewValue = ew_FormatDateTime($vouchers->ExpireDate->ViewValue, 5);
			$vouchers->ExpireDate->ViewCustomAttributes = "";

			// IssuedByFirst
			$vouchers->IssuedByFirst->ViewValue = $vouchers->IssuedByFirst->CurrentValue;
			$vouchers->IssuedByFirst->ViewCustomAttributes = "";

			// IssuedByLast
			$vouchers->IssuedByLast->ViewValue = $vouchers->IssuedByLast->CurrentValue;
			$vouchers->IssuedByLast->ViewCustomAttributes = "";

			// FirstName
			$vouchers->FirstName->ViewValue = $vouchers->FirstName->CurrentValue;
			$vouchers->FirstName->ViewCustomAttributes = "";

			// LastName
			$vouchers->LastName->ViewValue = $vouchers->LastName->CurrentValue;
			$vouchers->LastName->ViewCustomAttributes = "";

			// Program
			$vouchers->Program->ViewValue = $vouchers->Program->CurrentValue;
			$vouchers->Program->ViewCustomAttributes = "";

			// cat_name
			$vouchers->cat_name->ViewValue = $vouchers->cat_name->CurrentValue;
			$vouchers->cat_name->ViewCustomAttributes = "";

			// cat_breed
			$vouchers->cat_breed->ViewValue = $vouchers->cat_breed->CurrentValue;
			$vouchers->cat_breed->ViewCustomAttributes = "";

			// cat_age
			$vouchers->cat_age->ViewValue = $vouchers->cat_age->CurrentValue;
			$vouchers->cat_age->ViewCustomAttributes = "";

			// copay
			$vouchers->copay->ViewValue = $vouchers->copay->CurrentValue;
			$vouchers->copay->ViewCustomAttributes = "";

			// cat_status
			$vouchers->cat_status->ViewValue = $vouchers->cat_status->CurrentValue;
			$vouchers->cat_status->ViewCustomAttributes = "";

			// date_redeemed
			$vouchers->date_redeemed->ViewValue = $vouchers->date_redeemed->CurrentValue;
			$vouchers->date_redeemed->ViewValue = ew_FormatDateTime($vouchers->date_redeemed->ViewValue, 5);
			$vouchers->date_redeemed->ViewCustomAttributes = "";

			// Clinic
			$vouchers->Clinic->ViewValue = $vouchers->Clinic->CurrentValue;
			$vouchers->Clinic->ViewCustomAttributes = "";

			// ClinicPrice
			$vouchers->ClinicPrice->ViewValue = $vouchers->ClinicPrice->CurrentValue;
			$vouchers->ClinicPrice->ViewCustomAttributes = "";

			// vet_used
			$vouchers->vet_used->ViewValue = $vouchers->vet_used->CurrentValue;
			$vouchers->vet_used->ViewCustomAttributes = "";

			// colony_id
			$vouchers->colony_id->ViewValue = $vouchers->colony_id->CurrentValue;
			$vouchers->colony_id->ViewCustomAttributes = "";

			// Spay
			$vouchers->Spay->ViewValue = $vouchers->Spay->CurrentValue;
			$vouchers->Spay->ViewCustomAttributes = "";

			// Neuter
			$vouchers->Neuter->ViewValue = $vouchers->Neuter->CurrentValue;
			$vouchers->Neuter->ViewCustomAttributes = "";

			// FVRCP
			$vouchers->FVRCP->ViewValue = $vouchers->FVRCP->CurrentValue;
			$vouchers->FVRCP->ViewCustomAttributes = "";

			// FELV
			$vouchers->FELV->ViewValue = $vouchers->FELV->CurrentValue;
			$vouchers->FELV->ViewCustomAttributes = "";

			// Rabies
			$vouchers->Rabies->ViewValue = $vouchers->Rabies->CurrentValue;
			$vouchers->Rabies->ViewCustomAttributes = "";

			// Pregnant
			$vouchers->Pregnant->ViewValue = $vouchers->Pregnant->CurrentValue;
			$vouchers->Pregnant->ViewCustomAttributes = "";

			// AssignedTo
			$vouchers->AssignedTo->ViewValue = $vouchers->AssignedTo->CurrentValue;
			$vouchers->AssignedTo->ViewCustomAttributes = "";

			// mod_by
			$vouchers->mod_by->ViewValue = $vouchers->mod_by->CurrentValue;
			$vouchers->mod_by->ViewCustomAttributes = "";

			// mod_date
			$vouchers->mod_date->ViewValue = $vouchers->mod_date->CurrentValue;
			$vouchers->mod_date->ViewValue = ew_FormatDateTime($vouchers->mod_date->ViewValue, 5);
			$vouchers->mod_date->ViewCustomAttributes = "";

			// id
			$vouchers->id->LinkCustomAttributes = "";
			$vouchers->id->HrefValue = "";
			$vouchers->id->TooltipValue = "";

			// VoucherNumber
			$vouchers->VoucherNumber->LinkCustomAttributes = "";
			$vouchers->VoucherNumber->HrefValue = "";
			$vouchers->VoucherNumber->TooltipValue = "";

			// ExpireDate
			$vouchers->ExpireDate->LinkCustomAttributes = "";
			$vouchers->ExpireDate->HrefValue = "";
			$vouchers->ExpireDate->TooltipValue = "";

			// IssuedByFirst
			$vouchers->IssuedByFirst->LinkCustomAttributes = "";
			$vouchers->IssuedByFirst->HrefValue = "";
			$vouchers->IssuedByFirst->TooltipValue = "";

			// IssuedByLast
			$vouchers->IssuedByLast->LinkCustomAttributes = "";
			$vouchers->IssuedByLast->HrefValue = "";
			$vouchers->IssuedByLast->TooltipValue = "";

			// FirstName
			$vouchers->FirstName->LinkCustomAttributes = "";
			$vouchers->FirstName->HrefValue = "";
			$vouchers->FirstName->TooltipValue = "";

			// LastName
			$vouchers->LastName->LinkCustomAttributes = "";
			$vouchers->LastName->HrefValue = "";
			$vouchers->LastName->TooltipValue = "";

			// Program
			$vouchers->Program->LinkCustomAttributes = "";
			$vouchers->Program->HrefValue = "";
			$vouchers->Program->TooltipValue = "";

			// cat_name
			$vouchers->cat_name->LinkCustomAttributes = "";
			$vouchers->cat_name->HrefValue = "";
			$vouchers->cat_name->TooltipValue = "";

			// cat_breed
			$vouchers->cat_breed->LinkCustomAttributes = "";
			$vouchers->cat_breed->HrefValue = "";
			$vouchers->cat_breed->TooltipValue = "";

			// cat_age
			$vouchers->cat_age->LinkCustomAttributes = "";
			$vouchers->cat_age->HrefValue = "";
			$vouchers->cat_age->TooltipValue = "";

			// copay
			$vouchers->copay->LinkCustomAttributes = "";
			$vouchers->copay->HrefValue = "";
			$vouchers->copay->TooltipValue = "";

			// cat_status
			$vouchers->cat_status->LinkCustomAttributes = "";
			$vouchers->cat_status->HrefValue = "";
			$vouchers->cat_status->TooltipValue = "";

			// date_redeemed
			$vouchers->date_redeemed->LinkCustomAttributes = "";
			$vouchers->date_redeemed->HrefValue = "";
			$vouchers->date_redeemed->TooltipValue = "";

			// Clinic
			$vouchers->Clinic->LinkCustomAttributes = "";
			$vouchers->Clinic->HrefValue = "";
			$vouchers->Clinic->TooltipValue = "";

			// ClinicPrice
			$vouchers->ClinicPrice->LinkCustomAttributes = "";
			$vouchers->ClinicPrice->HrefValue = "";
			$vouchers->ClinicPrice->TooltipValue = "";

			// vet_used
			$vouchers->vet_used->LinkCustomAttributes = "";
			$vouchers->vet_used->HrefValue = "";
			$vouchers->vet_used->TooltipValue = "";

			// colony_id
			$vouchers->colony_id->LinkCustomAttributes = "";
			$vouchers->colony_id->HrefValue = "";
			$vouchers->colony_id->TooltipValue = "";

			// Spay
			$vouchers->Spay->LinkCustomAttributes = "";
			$vouchers->Spay->HrefValue = "";
			$vouchers->Spay->TooltipValue = "";

			// Neuter
			$vouchers->Neuter->LinkCustomAttributes = "";
			$vouchers->Neuter->HrefValue = "";
			$vouchers->Neuter->TooltipValue = "";

			// FVRCP
			$vouchers->FVRCP->LinkCustomAttributes = "";
			$vouchers->FVRCP->HrefValue = "";
			$vouchers->FVRCP->TooltipValue = "";

			// FELV
			$vouchers->FELV->LinkCustomAttributes = "";
			$vouchers->FELV->HrefValue = "";
			$vouchers->FELV->TooltipValue = "";

			// Rabies
			$vouchers->Rabies->LinkCustomAttributes = "";
			$vouchers->Rabies->HrefValue = "";
			$vouchers->Rabies->TooltipValue = "";

			// Pregnant
			$vouchers->Pregnant->LinkCustomAttributes = "";
			$vouchers->Pregnant->HrefValue = "";
			$vouchers->Pregnant->TooltipValue = "";

			// AssignedTo
			$vouchers->AssignedTo->LinkCustomAttributes = "";
			$vouchers->AssignedTo->HrefValue = "";
			$vouchers->AssignedTo->TooltipValue = "";

			// mod_by
			$vouchers->mod_by->LinkCustomAttributes = "";
			$vouchers->mod_by->HrefValue = "";
			$vouchers->mod_by->TooltipValue = "";

			// mod_date
			$vouchers->mod_date->LinkCustomAttributes = "";
			$vouchers->mod_date->HrefValue = "";
			$vouchers->mod_date->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($vouchers->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$vouchers->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security, $vouchers;
		$DeleteRows = TRUE;
		$sSql = $vouchers->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;
		}
		$conn->BeginTrans();

		// Clone old rows
		$rsold = ($rs) ? $rs->GetRows() : array();
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $vouchers->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['id'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($vouchers->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($vouchers->CancelMessage <> "") {
				$this->setFailureMessage($vouchers->CancelMessage);
				$vouchers->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$vouchers->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'
	function Message_Showing(&$msg, $type) {

		// Example:
		//if ($type == 'success') $msg = "your success message";

	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}
}
?>
