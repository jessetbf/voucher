<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg8.php" ?>
<?php include_once "ewmysql8.php" ?>
<?php include_once "phpfn8.php" ?>
<?php include_once "coloniesinfo.php" ?>
<?php include_once "userfn8.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
$colonies_delete = new ccolonies_delete();
$Page =& $colonies_delete;

// Page init
$colonies_delete->Page_Init();

// Page main
$colonies_delete->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var colonies_delete = new ew_Page("colonies_delete");

// page properties
colonies_delete.PageID = "delete"; // page ID
colonies_delete.FormID = "fcoloniesdelete"; // form ID
var EW_PAGE_ID = colonies_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
colonies_delete.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
colonies_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
colonies_delete.ValidateRequired = false; // no JavaScript validation
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
if ($colonies_delete->Recordset = $colonies_delete->LoadRecordset())
	$colonies_deleteTotalRecs = $colonies_delete->Recordset->RecordCount(); // Get record count
if ($colonies_deleteTotalRecs <= 0) { // No record found, exit
	if ($colonies_delete->Recordset)
		$colonies_delete->Recordset->Close();
	$colonies_delete->Page_Terminate("colonieslist.php"); // Return to list
}
?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("Delete") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $colonies->TableCaption() ?></p>
<p class="phpmaker"><a href="<?php echo $colonies->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $colonies_delete->ShowPageHeader(); ?>
<?php
$colonies_delete->ShowMessage();
?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="colonies">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($colonies_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $colonies->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top"><?php echo $colonies->colony_id->FldCaption() ?></td>
		<td valign="top"><?php echo $colonies->colony_name->FldCaption() ?></td>
		<td valign="top"><?php echo $colonies->colony_address->FldCaption() ?></td>
		<td valign="top"><?php echo $colonies->colony_aptnum->FldCaption() ?></td>
		<td valign="top"><?php echo $colonies->colony_city->FldCaption() ?></td>
		<td valign="top"><?php echo $colonies->colony_county->FldCaption() ?></td>
		<td valign="top"><?php echo $colonies->colony_zip->FldCaption() ?></td>
		<td valign="top"><?php echo $colonies->NumVouchIssued->FldCaption() ?></td>
		<td valign="top"><?php echo $colonies->VoucherStartNum->FldCaption() ?></td>
		<td valign="top"><?php echo $colonies->VoucherEndNum->FldCaption() ?></td>
		<td valign="top"><?php echo $colonies->trapper->FldCaption() ?></td>
		<td valign="top"><?php echo $colonies->notes->FldCaption() ?></td>
		<td valign="top"><?php echo $colonies->sage->FldCaption() ?></td>
		<td valign="top"><?php echo $colonies->Inactive->FldCaption() ?></td>
		<td valign="top"><?php echo $colonies->mod_by->FldCaption() ?></td>
		<td valign="top"><?php echo $colonies->mod_date->FldCaption() ?></td>
	</tr>
	</thead>
	<tbody>
<?php
$colonies_delete->RecCnt = 0;
$i = 0;
while (!$colonies_delete->Recordset->EOF) {
	$colonies_delete->RecCnt++;

	// Set row properties
	$colonies->ResetAttrs();
	$colonies->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$colonies_delete->LoadRowValues($colonies_delete->Recordset);

	// Render row
	$colonies_delete->RenderRow();
?>
	<tr<?php echo $colonies->RowAttributes() ?>>
		<td<?php echo $colonies->colony_id->CellAttributes() ?>>
<div<?php echo $colonies->colony_id->ViewAttributes() ?>><?php echo $colonies->colony_id->ListViewValue() ?></div></td>
		<td<?php echo $colonies->colony_name->CellAttributes() ?>>
<div<?php echo $colonies->colony_name->ViewAttributes() ?>><?php echo $colonies->colony_name->ListViewValue() ?></div></td>
		<td<?php echo $colonies->colony_address->CellAttributes() ?>>
<div<?php echo $colonies->colony_address->ViewAttributes() ?>><?php echo $colonies->colony_address->ListViewValue() ?></div></td>
		<td<?php echo $colonies->colony_aptnum->CellAttributes() ?>>
<div<?php echo $colonies->colony_aptnum->ViewAttributes() ?>><?php echo $colonies->colony_aptnum->ListViewValue() ?></div></td>
		<td<?php echo $colonies->colony_city->CellAttributes() ?>>
<div<?php echo $colonies->colony_city->ViewAttributes() ?>><?php echo $colonies->colony_city->ListViewValue() ?></div></td>
		<td<?php echo $colonies->colony_county->CellAttributes() ?>>
<div<?php echo $colonies->colony_county->ViewAttributes() ?>><?php echo $colonies->colony_county->ListViewValue() ?></div></td>
		<td<?php echo $colonies->colony_zip->CellAttributes() ?>>
<div<?php echo $colonies->colony_zip->ViewAttributes() ?>><?php echo $colonies->colony_zip->ListViewValue() ?></div></td>
		<td<?php echo $colonies->NumVouchIssued->CellAttributes() ?>>
<div<?php echo $colonies->NumVouchIssued->ViewAttributes() ?>><?php echo $colonies->NumVouchIssued->ListViewValue() ?></div></td>
		<td<?php echo $colonies->VoucherStartNum->CellAttributes() ?>>
<div<?php echo $colonies->VoucherStartNum->ViewAttributes() ?>><?php echo $colonies->VoucherStartNum->ListViewValue() ?></div></td>
		<td<?php echo $colonies->VoucherEndNum->CellAttributes() ?>>
<div<?php echo $colonies->VoucherEndNum->ViewAttributes() ?>><?php echo $colonies->VoucherEndNum->ListViewValue() ?></div></td>
		<td<?php echo $colonies->trapper->CellAttributes() ?>>
<div<?php echo $colonies->trapper->ViewAttributes() ?>><?php echo $colonies->trapper->ListViewValue() ?></div></td>
		<td<?php echo $colonies->notes->CellAttributes() ?>>
<div<?php echo $colonies->notes->ViewAttributes() ?>><?php echo $colonies->notes->ListViewValue() ?></div></td>
		<td<?php echo $colonies->sage->CellAttributes() ?>>
<div<?php echo $colonies->sage->ViewAttributes() ?>><?php echo $colonies->sage->ListViewValue() ?></div></td>
		<td<?php echo $colonies->Inactive->CellAttributes() ?>>
<div<?php echo $colonies->Inactive->ViewAttributes() ?>><?php echo $colonies->Inactive->ListViewValue() ?></div></td>
		<td<?php echo $colonies->mod_by->CellAttributes() ?>>
<div<?php echo $colonies->mod_by->ViewAttributes() ?>><?php echo $colonies->mod_by->ListViewValue() ?></div></td>
		<td<?php echo $colonies->mod_date->CellAttributes() ?>>
<div<?php echo $colonies->mod_date->ViewAttributes() ?>><?php echo $colonies->mod_date->ListViewValue() ?></div></td>
	</tr>
<?php
	$colonies_delete->Recordset->MoveNext();
}
$colonies_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="Action" id="Action" value="<?php echo ew_BtnCaption($Language->Phrase("DeleteBtn")) ?>">
</form>
<?php
$colonies_delete->ShowPageFooter();
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
$colonies_delete->Page_Terminate();
?>
<?php

//
// Page class
//
class ccolonies_delete {

	// Page ID
	var $PageID = 'delete';

	// Table name
	var $TableName = 'colonies';

	// Page object name
	var $PageObjName = 'colonies_delete';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $colonies;
		if ($colonies->UseTokenInUrl) $PageUrl .= "t=" . $colonies->TableVar . "&"; // Add page token
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
		global $objForm, $colonies;
		if ($colonies->UseTokenInUrl) {
			if ($objForm)
				return ($colonies->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($colonies->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function ccolonies_delete() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (colonies)
		if (!isset($GLOBALS["colonies"])) {
			$GLOBALS["colonies"] = new ccolonies();
			$GLOBALS["Table"] =& $GLOBALS["colonies"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'colonies', TRUE);

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
		global $colonies;

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
		global $Language, $colonies;

		// Load key parameters
		$this->RecKeys = $colonies->GetRecordKeys(); // Load record keys
		$sFilter = $colonies->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("colonieslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in colonies class, coloniesinfo.php

		$colonies->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$colonies->CurrentAction = $_POST["a_delete"];
		} else {
			$colonies->CurrentAction = "I"; // Display record
		}
		switch ($colonies->CurrentAction) {
			case "D": // Delete
				$colonies->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($colonies->getReturnUrl()); // Return to caller
				}
		}
	}

// No functions
	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $colonies;

		// Call Recordset Selecting event
		$colonies->Recordset_Selecting($colonies->CurrentFilter);

		// Load List page SQL
		$sSql = $colonies->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$colonies->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $colonies;
		$sFilter = $colonies->KeyFilter();

		// Call Row Selecting event
		$colonies->Row_Selecting($sFilter);

		// Load SQL based on filter
		$colonies->CurrentFilter = $sFilter;
		$sSql = $colonies->SQL();
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
		global $conn, $colonies;
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row =& $rs->fields;
		$colonies->Row_Selected($row);
		$colonies->colony_id->setDbValue($rs->fields('colony_id'));
		$colonies->colony_name->setDbValue($rs->fields('colony_name'));
		$colonies->colony_address->setDbValue($rs->fields('colony_address'));
		$colonies->colony_aptnum->setDbValue($rs->fields('colony_aptnum'));
		$colonies->colony_city->setDbValue($rs->fields('colony_city'));
		$colonies->colony_county->setDbValue($rs->fields('colony_county'));
		$colonies->colony_zip->setDbValue($rs->fields('colony_zip'));
		$colonies->NumVouchIssued->setDbValue($rs->fields('NumVouchIssued'));
		$colonies->VoucherStartNum->setDbValue($rs->fields('VoucherStartNum'));
		$colonies->VoucherEndNum->setDbValue($rs->fields('VoucherEndNum'));
		$colonies->trapper->setDbValue($rs->fields('trapper'));
		$colonies->notes->setDbValue($rs->fields('notes'));
		$colonies->sage->setDbValue($rs->fields('sage'));
		$colonies->Inactive->setDbValue($rs->fields('Inactive'));
		$colonies->mod_by->setDbValue($rs->fields('mod_by'));
		$colonies->mod_date->setDbValue($rs->fields('mod_date'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $colonies;

		// Initialize URLs
		// Call Row_Rendering event

		$colonies->Row_Rendering();

		// Common render codes for all row types
		// colony_id
		// colony_name
		// colony_address
		// colony_aptnum
		// colony_city
		// colony_county
		// colony_zip
		// NumVouchIssued
		// VoucherStartNum
		// VoucherEndNum
		// trapper
		// notes
		// sage
		// Inactive
		// mod_by
		// mod_date

		if ($colonies->RowType == EW_ROWTYPE_VIEW) { // View row

			// colony_id
			$colonies->colony_id->ViewValue = $colonies->colony_id->CurrentValue;
			$colonies->colony_id->ViewCustomAttributes = "";

			// colony_name
			$colonies->colony_name->ViewValue = $colonies->colony_name->CurrentValue;
			$colonies->colony_name->ViewCustomAttributes = "";

			// colony_address
			$colonies->colony_address->ViewValue = $colonies->colony_address->CurrentValue;
			$colonies->colony_address->ViewCustomAttributes = "";

			// colony_aptnum
			$colonies->colony_aptnum->ViewValue = $colonies->colony_aptnum->CurrentValue;
			$colonies->colony_aptnum->ViewCustomAttributes = "";

			// colony_city
			$colonies->colony_city->ViewValue = $colonies->colony_city->CurrentValue;
			$colonies->colony_city->ViewCustomAttributes = "";

			// colony_county
			$colonies->colony_county->ViewValue = $colonies->colony_county->CurrentValue;
			$colonies->colony_county->ViewCustomAttributes = "";

			// colony_zip
			$colonies->colony_zip->ViewValue = $colonies->colony_zip->CurrentValue;
			$colonies->colony_zip->ViewCustomAttributes = "";

			// NumVouchIssued
			$colonies->NumVouchIssued->ViewValue = $colonies->NumVouchIssued->CurrentValue;
			$colonies->NumVouchIssued->ViewCustomAttributes = "";

			// VoucherStartNum
			$colonies->VoucherStartNum->ViewValue = $colonies->VoucherStartNum->CurrentValue;
			$colonies->VoucherStartNum->ViewCustomAttributes = "";

			// VoucherEndNum
			$colonies->VoucherEndNum->ViewValue = $colonies->VoucherEndNum->CurrentValue;
			$colonies->VoucherEndNum->ViewCustomAttributes = "";

			// trapper
			$colonies->trapper->ViewValue = $colonies->trapper->CurrentValue;
			$colonies->trapper->ViewCustomAttributes = "";

			// notes
			$colonies->notes->ViewValue = $colonies->notes->CurrentValue;
			$colonies->notes->ViewCustomAttributes = "";

			// sage
			$colonies->sage->ViewValue = $colonies->sage->CurrentValue;
			$colonies->sage->ViewCustomAttributes = "";

			// Inactive
			$colonies->Inactive->ViewValue = $colonies->Inactive->CurrentValue;
			$colonies->Inactive->ViewCustomAttributes = "";

			// mod_by
			$colonies->mod_by->ViewValue = $colonies->mod_by->CurrentValue;
			$colonies->mod_by->ViewCustomAttributes = "";

			// mod_date
			$colonies->mod_date->ViewValue = $colonies->mod_date->CurrentValue;
			$colonies->mod_date->ViewValue = ew_FormatDateTime($colonies->mod_date->ViewValue, 5);
			$colonies->mod_date->ViewCustomAttributes = "";

			// colony_id
			$colonies->colony_id->LinkCustomAttributes = "";
			$colonies->colony_id->HrefValue = "";
			$colonies->colony_id->TooltipValue = "";

			// colony_name
			$colonies->colony_name->LinkCustomAttributes = "";
			$colonies->colony_name->HrefValue = "";
			$colonies->colony_name->TooltipValue = "";

			// colony_address
			$colonies->colony_address->LinkCustomAttributes = "";
			$colonies->colony_address->HrefValue = "";
			$colonies->colony_address->TooltipValue = "";

			// colony_aptnum
			$colonies->colony_aptnum->LinkCustomAttributes = "";
			$colonies->colony_aptnum->HrefValue = "";
			$colonies->colony_aptnum->TooltipValue = "";

			// colony_city
			$colonies->colony_city->LinkCustomAttributes = "";
			$colonies->colony_city->HrefValue = "";
			$colonies->colony_city->TooltipValue = "";

			// colony_county
			$colonies->colony_county->LinkCustomAttributes = "";
			$colonies->colony_county->HrefValue = "";
			$colonies->colony_county->TooltipValue = "";

			// colony_zip
			$colonies->colony_zip->LinkCustomAttributes = "";
			$colonies->colony_zip->HrefValue = "";
			$colonies->colony_zip->TooltipValue = "";

			// NumVouchIssued
			$colonies->NumVouchIssued->LinkCustomAttributes = "";
			$colonies->NumVouchIssued->HrefValue = "";
			$colonies->NumVouchIssued->TooltipValue = "";

			// VoucherStartNum
			$colonies->VoucherStartNum->LinkCustomAttributes = "";
			$colonies->VoucherStartNum->HrefValue = "";
			$colonies->VoucherStartNum->TooltipValue = "";

			// VoucherEndNum
			$colonies->VoucherEndNum->LinkCustomAttributes = "";
			$colonies->VoucherEndNum->HrefValue = "";
			$colonies->VoucherEndNum->TooltipValue = "";

			// trapper
			$colonies->trapper->LinkCustomAttributes = "";
			$colonies->trapper->HrefValue = "";
			$colonies->trapper->TooltipValue = "";

			// notes
			$colonies->notes->LinkCustomAttributes = "";
			$colonies->notes->HrefValue = "";
			$colonies->notes->TooltipValue = "";

			// sage
			$colonies->sage->LinkCustomAttributes = "";
			$colonies->sage->HrefValue = "";
			$colonies->sage->TooltipValue = "";

			// Inactive
			$colonies->Inactive->LinkCustomAttributes = "";
			$colonies->Inactive->HrefValue = "";
			$colonies->Inactive->TooltipValue = "";

			// mod_by
			$colonies->mod_by->LinkCustomAttributes = "";
			$colonies->mod_by->HrefValue = "";
			$colonies->mod_by->TooltipValue = "";

			// mod_date
			$colonies->mod_date->LinkCustomAttributes = "";
			$colonies->mod_date->HrefValue = "";
			$colonies->mod_date->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($colonies->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$colonies->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security, $colonies;
		$DeleteRows = TRUE;
		$sSql = $colonies->SQL();
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
				$DeleteRows = $colonies->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['colony_id'];
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['colony_name'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($colonies->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($colonies->CancelMessage <> "") {
				$this->setFailureMessage($colonies->CancelMessage);
				$colonies->CancelMessage = "";
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
				$colonies->Row_Deleted($row);
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
