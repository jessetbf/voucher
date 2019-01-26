<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg8.php" ?>
<?php include_once "ewmysql8.php" ?>
<?php include_once "phpfn8.php" ?>
<?php include_once "vetsinfo.php" ?>
<?php include_once "userfn8.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
$vets_delete = new cvets_delete();
$Page =& $vets_delete;

// Page init
$vets_delete->Page_Init();

// Page main
$vets_delete->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var vets_delete = new ew_Page("vets_delete");

// page properties
vets_delete.PageID = "delete"; // page ID
vets_delete.FormID = "fvetsdelete"; // form ID
var EW_PAGE_ID = vets_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
vets_delete.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
vets_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
vets_delete.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php $vets_delete->ShowPageHeader(); ?>
<?php

// Load records for display
if ($vets_delete->Recordset = $vets_delete->LoadRecordset())
	$vets_deleteTotalRecs = $vets_delete->Recordset->RecordCount(); // Get record count
if ($vets_deleteTotalRecs <= 0) { // No record found, exit
	if ($vets_delete->Recordset)
		$vets_delete->Recordset->Close();
	$vets_delete->Page_Terminate("vetslist.php"); // Return to list
}
?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("Delete") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $vets->TableCaption() ?></p>
<p class="phpmaker"><a href="<?php echo $vets->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php
$vets_delete->ShowMessage();
?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="vets">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($vets_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $vets->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top"><?php echo $vets->id->FldCaption() ?></td>
		<td valign="top"><?php echo $vets->CountyServed->FldCaption() ?></td>
		<td valign="top"><?php echo $vets->Clinic->FldCaption() ?></td>
		<td valign="top"><?php echo $vets->Vet->FldCaption() ?></td>
		<td valign="top"><?php echo $vets->Address->FldCaption() ?></td>
		<td valign="top"><?php echo $vets->MailingAddress->FldCaption() ?></td>
		<td valign="top"><?php echo $vets->City->FldCaption() ?></td>
		<td valign="top"><?php echo $vets->Zip->FldCaption() ?></td>
		<td valign="top"><?php echo $vets->County->FldCaption() ?></td>
		<td valign="top"><?php echo $vets->Phone->FldCaption() ?></td>
		<td valign="top"><?php echo $vets->Fax->FldCaption() ?></td>
		<td valign="top"><?php echo $vets->AllCatsFee->FldCaption() ?></td>
		<td valign="top"><?php echo $vets->AllMaleDogs->FldCaption() ?></td>
		<td valign="top"><?php echo $vets->FemDogsUnder75->FldCaption() ?></td>
		<td valign="top"><?php echo $vets->FemDogsOver75->FldCaption() ?></td>
		<td valign="top"><?php echo $vets->AllFeralMaleCats->FldCaption() ?></td>
		<td valign="top"><?php echo $vets->AllFeralFemaleCats->FldCaption() ?></td>
		<td valign="top"><?php echo $vets->Comments->FldCaption() ?></td>
		<td valign="top"><?php echo $vets->Active->FldCaption() ?></td>
	</tr>
	</thead>
	<tbody>
<?php
$vets_delete->RecCnt = 0;
$i = 0;
while (!$vets_delete->Recordset->EOF) {
	$vets_delete->RecCnt++;

	// Set row properties
	$vets->ResetAttrs();
	$vets->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$vets_delete->LoadRowValues($vets_delete->Recordset);

	// Render row
	$vets_delete->RenderRow();
?>
	<tr<?php echo $vets->RowAttributes() ?>>
		<td<?php echo $vets->id->CellAttributes() ?>>
<div<?php echo $vets->id->ViewAttributes() ?>><?php echo $vets->id->ListViewValue() ?></div></td>
		<td<?php echo $vets->CountyServed->CellAttributes() ?>>
<div<?php echo $vets->CountyServed->ViewAttributes() ?>><?php echo $vets->CountyServed->ListViewValue() ?></div></td>
		<td<?php echo $vets->Clinic->CellAttributes() ?>>
<div<?php echo $vets->Clinic->ViewAttributes() ?>><?php echo $vets->Clinic->ListViewValue() ?></div></td>
		<td<?php echo $vets->Vet->CellAttributes() ?>>
<div<?php echo $vets->Vet->ViewAttributes() ?>><?php echo $vets->Vet->ListViewValue() ?></div></td>
		<td<?php echo $vets->Address->CellAttributes() ?>>
<div<?php echo $vets->Address->ViewAttributes() ?>><?php echo $vets->Address->ListViewValue() ?></div></td>
		<td<?php echo $vets->MailingAddress->CellAttributes() ?>>
<div<?php echo $vets->MailingAddress->ViewAttributes() ?>><?php echo $vets->MailingAddress->ListViewValue() ?></div></td>
		<td<?php echo $vets->City->CellAttributes() ?>>
<div<?php echo $vets->City->ViewAttributes() ?>><?php echo $vets->City->ListViewValue() ?></div></td>
		<td<?php echo $vets->Zip->CellAttributes() ?>>
<div<?php echo $vets->Zip->ViewAttributes() ?>><?php echo $vets->Zip->ListViewValue() ?></div></td>
		<td<?php echo $vets->County->CellAttributes() ?>>
<div<?php echo $vets->County->ViewAttributes() ?>><?php echo $vets->County->ListViewValue() ?></div></td>
		<td<?php echo $vets->Phone->CellAttributes() ?>>
<div<?php echo $vets->Phone->ViewAttributes() ?>><?php echo $vets->Phone->ListViewValue() ?></div></td>
		<td<?php echo $vets->Fax->CellAttributes() ?>>
<div<?php echo $vets->Fax->ViewAttributes() ?>><?php echo $vets->Fax->ListViewValue() ?></div></td>
		<td<?php echo $vets->AllCatsFee->CellAttributes() ?>>
<div<?php echo $vets->AllCatsFee->ViewAttributes() ?>><?php echo $vets->AllCatsFee->ListViewValue() ?></div></td>
		<td<?php echo $vets->AllMaleDogs->CellAttributes() ?>>
<div<?php echo $vets->AllMaleDogs->ViewAttributes() ?>><?php echo $vets->AllMaleDogs->ListViewValue() ?></div></td>
		<td<?php echo $vets->FemDogsUnder75->CellAttributes() ?>>
<div<?php echo $vets->FemDogsUnder75->ViewAttributes() ?>><?php echo $vets->FemDogsUnder75->ListViewValue() ?></div></td>
		<td<?php echo $vets->FemDogsOver75->CellAttributes() ?>>
<div<?php echo $vets->FemDogsOver75->ViewAttributes() ?>><?php echo $vets->FemDogsOver75->ListViewValue() ?></div></td>
		<td<?php echo $vets->AllFeralMaleCats->CellAttributes() ?>>
<div<?php echo $vets->AllFeralMaleCats->ViewAttributes() ?>><?php echo $vets->AllFeralMaleCats->ListViewValue() ?></div></td>
		<td<?php echo $vets->AllFeralFemaleCats->CellAttributes() ?>>
<div<?php echo $vets->AllFeralFemaleCats->ViewAttributes() ?>><?php echo $vets->AllFeralFemaleCats->ListViewValue() ?></div></td>
		<td<?php echo $vets->Comments->CellAttributes() ?>>
<div<?php echo $vets->Comments->ViewAttributes() ?>><?php echo $vets->Comments->ListViewValue() ?></div></td>
		<td<?php echo $vets->Active->CellAttributes() ?>>
<div<?php echo $vets->Active->ViewAttributes() ?>><?php echo $vets->Active->ListViewValue() ?></div></td>
	</tr>
<?php
	$vets_delete->Recordset->MoveNext();
}
$vets_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="Action" id="Action" value="<?php echo ew_BtnCaption($Language->Phrase("DeleteBtn")) ?>">
</form>
<?php
$vets_delete->ShowPageFooter();
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
$vets_delete->Page_Terminate();
?>
<?php

//
// Page class
//
class cvets_delete {

	// Page ID
	var $PageID = 'delete';

	// Table name
	var $TableName = 'vets';

	// Page object name
	var $PageObjName = 'vets_delete';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $vets;
		if ($vets->UseTokenInUrl) $PageUrl .= "t=" . $vets->TableVar . "&"; // Add page token
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
		global $objForm, $vets;
		if ($vets->UseTokenInUrl) {
			if ($objForm)
				return ($vets->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($vets->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cvets_delete() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (vets)
		if (!isset($GLOBALS["vets"])) {
			$GLOBALS["vets"] = new cvets();
			$GLOBALS["Table"] =& $GLOBALS["vets"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'vets', TRUE);

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
		global $vets;

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

		 // Close connection
		$conn->Close();

		// Go to URL if specified
		$this->Page_Redirecting($url);
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
		global $Language, $vets;

		// Load key parameters
		$this->RecKeys = $vets->GetRecordKeys(); // Load record keys
		$sFilter = $vets->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("vetslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in vets class, vetsinfo.php

		$vets->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$vets->CurrentAction = $_POST["a_delete"];
		} else {
			$vets->CurrentAction = "I"; // Display record
		}
		switch ($vets->CurrentAction) {
			case "D": // Delete
				$vets->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($vets->getReturnUrl()); // Return to caller
				}
		}
	}

// No functions
	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $vets;

		// Call Recordset Selecting event
		$vets->Recordset_Selecting($vets->CurrentFilter);

		// Load List page SQL
		$sSql = $vets->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$vets->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $vets;
		$sFilter = $vets->KeyFilter();

		// Call Row Selecting event
		$vets->Row_Selecting($sFilter);

		// Load SQL based on filter
		$vets->CurrentFilter = $sFilter;
		$sSql = $vets->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$row = $rs->fields;
			$vets->Row_Selected($row);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $vets;
		if (!$rs || $rs->EOF) return;
		$vets->id->setDbValue($rs->fields('id'));
		$vets->CountyServed->setDbValue($rs->fields('CountyServed'));
		$vets->Clinic->setDbValue($rs->fields('Clinic'));
		$vets->Vet->setDbValue($rs->fields('Vet'));
		$vets->Address->setDbValue($rs->fields('Address'));
		$vets->MailingAddress->setDbValue($rs->fields('MailingAddress'));
		$vets->City->setDbValue($rs->fields('City'));
		$vets->Zip->setDbValue($rs->fields('Zip'));
		$vets->County->setDbValue($rs->fields('County'));
		$vets->Phone->setDbValue($rs->fields('Phone'));
		$vets->Fax->setDbValue($rs->fields('Fax'));
		$vets->AllCatsFee->setDbValue($rs->fields('AllCatsFee'));
		$vets->AllMaleDogs->setDbValue($rs->fields('AllMaleDogs'));
		$vets->FemDogsUnder75->setDbValue($rs->fields('FemDogsUnder75'));
		$vets->FemDogsOver75->setDbValue($rs->fields('FemDogsOver75'));
		$vets->AllFeralMaleCats->setDbValue($rs->fields('AllFeralMaleCats'));
		$vets->AllFeralFemaleCats->setDbValue($rs->fields('AllFeralFemaleCats'));
		$vets->Comments->setDbValue($rs->fields('Comments'));
		$vets->Active->setDbValue($rs->fields('Active'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $vets;

		// Initialize URLs
		// Call Row_Rendering event

		$vets->Row_Rendering();

		// Common render codes for all row types
		// id
		// CountyServed
		// Clinic
		// Vet
		// Address
		// MailingAddress
		// City
		// Zip
		// County
		// Phone
		// Fax
		// AllCatsFee
		// AllMaleDogs
		// FemDogsUnder75
		// FemDogsOver75
		// AllFeralMaleCats
		// AllFeralFemaleCats
		// Comments
		// Active

		if ($vets->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$vets->id->ViewValue = $vets->id->CurrentValue;
			$vets->id->ViewCustomAttributes = "";

			// CountyServed
			$vets->CountyServed->ViewValue = $vets->CountyServed->CurrentValue;
			$vets->CountyServed->ViewCustomAttributes = "";

			// Clinic
			$vets->Clinic->ViewValue = $vets->Clinic->CurrentValue;
			$vets->Clinic->ViewCustomAttributes = "";

			// Vet
			$vets->Vet->ViewValue = $vets->Vet->CurrentValue;
			$vets->Vet->ViewCustomAttributes = "";

			// Address
			$vets->Address->ViewValue = $vets->Address->CurrentValue;
			$vets->Address->ViewCustomAttributes = "";

			// MailingAddress
			$vets->MailingAddress->ViewValue = $vets->MailingAddress->CurrentValue;
			$vets->MailingAddress->ViewCustomAttributes = "";

			// City
			$vets->City->ViewValue = $vets->City->CurrentValue;
			$vets->City->ViewCustomAttributes = "";

			// Zip
			$vets->Zip->ViewValue = $vets->Zip->CurrentValue;
			$vets->Zip->ViewCustomAttributes = "";

			// County
			$vets->County->ViewValue = $vets->County->CurrentValue;
			$vets->County->ViewCustomAttributes = "";

			// Phone
			$vets->Phone->ViewValue = $vets->Phone->CurrentValue;
			$vets->Phone->ViewCustomAttributes = "";

			// Fax
			$vets->Fax->ViewValue = $vets->Fax->CurrentValue;
			$vets->Fax->ViewCustomAttributes = "";

			// AllCatsFee
			$vets->AllCatsFee->ViewValue = $vets->AllCatsFee->CurrentValue;
			$vets->AllCatsFee->ViewCustomAttributes = "";

			// AllMaleDogs
			$vets->AllMaleDogs->ViewValue = $vets->AllMaleDogs->CurrentValue;
			$vets->AllMaleDogs->ViewCustomAttributes = "";

			// FemDogsUnder75
			$vets->FemDogsUnder75->ViewValue = $vets->FemDogsUnder75->CurrentValue;
			$vets->FemDogsUnder75->ViewCustomAttributes = "";

			// FemDogsOver75
			$vets->FemDogsOver75->ViewValue = $vets->FemDogsOver75->CurrentValue;
			$vets->FemDogsOver75->ViewCustomAttributes = "";

			// AllFeralMaleCats
			$vets->AllFeralMaleCats->ViewValue = $vets->AllFeralMaleCats->CurrentValue;
			$vets->AllFeralMaleCats->ViewCustomAttributes = "";

			// AllFeralFemaleCats
			$vets->AllFeralFemaleCats->ViewValue = $vets->AllFeralFemaleCats->CurrentValue;
			$vets->AllFeralFemaleCats->ViewCustomAttributes = "";

			// Comments
			$vets->Comments->ViewValue = $vets->Comments->CurrentValue;
			$vets->Comments->ViewCustomAttributes = "";

			// Active
			$vets->Active->ViewValue = $vets->Active->CurrentValue;
			$vets->Active->ViewCustomAttributes = "";

			// id
			$vets->id->LinkCustomAttributes = "";
			$vets->id->HrefValue = "";
			$vets->id->TooltipValue = "";

			// CountyServed
			$vets->CountyServed->LinkCustomAttributes = "";
			$vets->CountyServed->HrefValue = "";
			$vets->CountyServed->TooltipValue = "";

			// Clinic
			$vets->Clinic->LinkCustomAttributes = "";
			$vets->Clinic->HrefValue = "";
			$vets->Clinic->TooltipValue = "";

			// Vet
			$vets->Vet->LinkCustomAttributes = "";
			$vets->Vet->HrefValue = "";
			$vets->Vet->TooltipValue = "";

			// Address
			$vets->Address->LinkCustomAttributes = "";
			$vets->Address->HrefValue = "";
			$vets->Address->TooltipValue = "";

			// MailingAddress
			$vets->MailingAddress->LinkCustomAttributes = "";
			$vets->MailingAddress->HrefValue = "";
			$vets->MailingAddress->TooltipValue = "";

			// City
			$vets->City->LinkCustomAttributes = "";
			$vets->City->HrefValue = "";
			$vets->City->TooltipValue = "";

			// Zip
			$vets->Zip->LinkCustomAttributes = "";
			$vets->Zip->HrefValue = "";
			$vets->Zip->TooltipValue = "";

			// County
			$vets->County->LinkCustomAttributes = "";
			$vets->County->HrefValue = "";
			$vets->County->TooltipValue = "";

			// Phone
			$vets->Phone->LinkCustomAttributes = "";
			$vets->Phone->HrefValue = "";
			$vets->Phone->TooltipValue = "";

			// Fax
			$vets->Fax->LinkCustomAttributes = "";
			$vets->Fax->HrefValue = "";
			$vets->Fax->TooltipValue = "";

			// AllCatsFee
			$vets->AllCatsFee->LinkCustomAttributes = "";
			$vets->AllCatsFee->HrefValue = "";
			$vets->AllCatsFee->TooltipValue = "";

			// AllMaleDogs
			$vets->AllMaleDogs->LinkCustomAttributes = "";
			$vets->AllMaleDogs->HrefValue = "";
			$vets->AllMaleDogs->TooltipValue = "";

			// FemDogsUnder75
			$vets->FemDogsUnder75->LinkCustomAttributes = "";
			$vets->FemDogsUnder75->HrefValue = "";
			$vets->FemDogsUnder75->TooltipValue = "";

			// FemDogsOver75
			$vets->FemDogsOver75->LinkCustomAttributes = "";
			$vets->FemDogsOver75->HrefValue = "";
			$vets->FemDogsOver75->TooltipValue = "";

			// AllFeralMaleCats
			$vets->AllFeralMaleCats->LinkCustomAttributes = "";
			$vets->AllFeralMaleCats->HrefValue = "";
			$vets->AllFeralMaleCats->TooltipValue = "";

			// AllFeralFemaleCats
			$vets->AllFeralFemaleCats->LinkCustomAttributes = "";
			$vets->AllFeralFemaleCats->HrefValue = "";
			$vets->AllFeralFemaleCats->TooltipValue = "";

			// Comments
			$vets->Comments->LinkCustomAttributes = "";
			$vets->Comments->HrefValue = "";
			$vets->Comments->TooltipValue = "";

			// Active
			$vets->Active->LinkCustomAttributes = "";
			$vets->Active->HrefValue = "";
			$vets->Active->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($vets->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$vets->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security, $vets;
		$DeleteRows = TRUE;
		$sSql = $vets->SQL();
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
				$DeleteRows = $vets->Row_Deleting($row);
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
				$DeleteRows = $conn->Execute($vets->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($vets->CancelMessage <> "") {
				$this->setFailureMessage($vets->CancelMessage);
				$vets->CancelMessage = "";
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
				$vets->Row_Deleted($row);
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
