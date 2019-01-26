<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg8.php" ?>
<?php include_once "ewmysql8.php" ?>
<?php include_once "phpfn8.php" ?>
<?php include_once "caregiversinfo.php" ?>
<?php include_once "coloniesinfo.php" ?>
<?php include_once "userfn8.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
$caregivers_delete = new ccaregivers_delete();
$Page =& $caregivers_delete;

// Page init
$caregivers_delete->Page_Init();

// Page main
$caregivers_delete->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var caregivers_delete = new ew_Page("caregivers_delete");

// page properties
caregivers_delete.PageID = "delete"; // page ID
caregivers_delete.FormID = "fcaregiversdelete"; // form ID
var EW_PAGE_ID = caregivers_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
caregivers_delete.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
caregivers_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
caregivers_delete.ValidateRequired = false; // no JavaScript validation
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
if ($caregivers_delete->Recordset = $caregivers_delete->LoadRecordset())
	$caregivers_deleteTotalRecs = $caregivers_delete->Recordset->RecordCount(); // Get record count
if ($caregivers_deleteTotalRecs <= 0) { // No record found, exit
	if ($caregivers_delete->Recordset)
		$caregivers_delete->Recordset->Close();
	$caregivers_delete->Page_Terminate("caregiverslist.php"); // Return to list
}
?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("Delete") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $caregivers->TableCaption() ?></p>
<p class="phpmaker"><a href="<?php echo $caregivers->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $caregivers_delete->ShowPageHeader(); ?>
<?php
$caregivers_delete->ShowMessage();
?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="caregivers">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($caregivers_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $caregivers->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top"><?php echo $caregivers->caregiver_id->FldCaption() ?></td>
		<td valign="top"><?php echo $caregivers->first_name->FldCaption() ?></td>
		<td valign="top"><?php echo $caregivers->last_name->FldCaption() ?></td>
		<td valign="top"><?php echo $caregivers->day_phone->FldCaption() ?></td>
		<td valign="top"><?php echo $caregivers->other_phone->FldCaption() ?></td>
		<td valign="top"><?php echo $caregivers->zemail->FldCaption() ?></td>
		<td valign="top"><?php echo $caregivers->address->FldCaption() ?></td>
		<td valign="top"><?php echo $caregivers->apt_num->FldCaption() ?></td>
		<td valign="top"><?php echo $caregivers->city->FldCaption() ?></td>
		<td valign="top"><?php echo $caregivers->county->FldCaption() ?></td>
		<td valign="top"><?php echo $caregivers->zip->FldCaption() ?></td>
		<td valign="top"><?php echo $caregivers->num_deps->FldCaption() ?></td>
		<td valign="top"><?php echo $caregivers->annual_income->FldCaption() ?></td>
		<td valign="top"><?php echo $caregivers->app_source->FldCaption() ?></td>
		<td valign="top"><?php echo $caregivers->dl->FldCaption() ?></td>
		<td valign="top"><?php echo $caregivers->app_date->FldCaption() ?></td>
		<td valign="top"><?php echo $caregivers->Expiration->FldCaption() ?></td>
		<td valign="top"><?php echo $caregivers->ClinicGroup->FldCaption() ?></td>
		<td valign="top"><?php echo $caregivers->DateSent->FldCaption() ?></td>
		<td valign="top"><?php echo $caregivers->budget_category->FldCaption() ?></td>
		<td valign="top"><?php echo $caregivers->AgeOfApplicant->FldCaption() ?></td>
		<td valign="top"><?php echo $caregivers->Applic->FldCaption() ?></td>
		<td valign="top"><?php echo $caregivers->SubApplic->FldCaption() ?></td>
		<td valign="top"><?php echo $caregivers->DateSigned->FldCaption() ?></td>
		<td valign="top"><?php echo $caregivers->colony_id->FldCaption() ?></td>
		<td valign="top"><?php echo $caregivers->mod_by->FldCaption() ?></td>
		<td valign="top"><?php echo $caregivers->mod_date->FldCaption() ?></td>
	</tr>
	</thead>
	<tbody>
<?php
$caregivers_delete->RecCnt = 0;
$i = 0;
while (!$caregivers_delete->Recordset->EOF) {
	$caregivers_delete->RecCnt++;

	// Set row properties
	$caregivers->ResetAttrs();
	$caregivers->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$caregivers_delete->LoadRowValues($caregivers_delete->Recordset);

	// Render row
	$caregivers_delete->RenderRow();
?>
	<tr<?php echo $caregivers->RowAttributes() ?>>
		<td<?php echo $caregivers->caregiver_id->CellAttributes() ?>>
<div<?php echo $caregivers->caregiver_id->ViewAttributes() ?>><?php echo $caregivers->caregiver_id->ListViewValue() ?></div></td>
		<td<?php echo $caregivers->first_name->CellAttributes() ?>>
<div<?php echo $caregivers->first_name->ViewAttributes() ?>><?php echo $caregivers->first_name->ListViewValue() ?></div></td>
		<td<?php echo $caregivers->last_name->CellAttributes() ?>>
<div<?php echo $caregivers->last_name->ViewAttributes() ?>><?php echo $caregivers->last_name->ListViewValue() ?></div></td>
		<td<?php echo $caregivers->day_phone->CellAttributes() ?>>
<div<?php echo $caregivers->day_phone->ViewAttributes() ?>><?php echo $caregivers->day_phone->ListViewValue() ?></div></td>
		<td<?php echo $caregivers->other_phone->CellAttributes() ?>>
<div<?php echo $caregivers->other_phone->ViewAttributes() ?>><?php echo $caregivers->other_phone->ListViewValue() ?></div></td>
		<td<?php echo $caregivers->zemail->CellAttributes() ?>>
<div<?php echo $caregivers->zemail->ViewAttributes() ?>><?php echo $caregivers->zemail->ListViewValue() ?></div></td>
		<td<?php echo $caregivers->address->CellAttributes() ?>>
<div<?php echo $caregivers->address->ViewAttributes() ?>><?php echo $caregivers->address->ListViewValue() ?></div></td>
		<td<?php echo $caregivers->apt_num->CellAttributes() ?>>
<div<?php echo $caregivers->apt_num->ViewAttributes() ?>><?php echo $caregivers->apt_num->ListViewValue() ?></div></td>
		<td<?php echo $caregivers->city->CellAttributes() ?>>
<div<?php echo $caregivers->city->ViewAttributes() ?>><?php echo $caregivers->city->ListViewValue() ?></div></td>
		<td<?php echo $caregivers->county->CellAttributes() ?>>
<div<?php echo $caregivers->county->ViewAttributes() ?>><?php echo $caregivers->county->ListViewValue() ?></div></td>
		<td<?php echo $caregivers->zip->CellAttributes() ?>>
<div<?php echo $caregivers->zip->ViewAttributes() ?>><?php echo $caregivers->zip->ListViewValue() ?></div></td>
		<td<?php echo $caregivers->num_deps->CellAttributes() ?>>
<div<?php echo $caregivers->num_deps->ViewAttributes() ?>><?php echo $caregivers->num_deps->ListViewValue() ?></div></td>
		<td<?php echo $caregivers->annual_income->CellAttributes() ?>>
<div<?php echo $caregivers->annual_income->ViewAttributes() ?>><?php echo $caregivers->annual_income->ListViewValue() ?></div></td>
		<td<?php echo $caregivers->app_source->CellAttributes() ?>>
<div<?php echo $caregivers->app_source->ViewAttributes() ?>><?php echo $caregivers->app_source->ListViewValue() ?></div></td>
		<td<?php echo $caregivers->dl->CellAttributes() ?>>
<div<?php echo $caregivers->dl->ViewAttributes() ?>><?php echo $caregivers->dl->ListViewValue() ?></div></td>
		<td<?php echo $caregivers->app_date->CellAttributes() ?>>
<div<?php echo $caregivers->app_date->ViewAttributes() ?>><?php echo $caregivers->app_date->ListViewValue() ?></div></td>
		<td<?php echo $caregivers->Expiration->CellAttributes() ?>>
<div<?php echo $caregivers->Expiration->ViewAttributes() ?>><?php echo $caregivers->Expiration->ListViewValue() ?></div></td>
		<td<?php echo $caregivers->ClinicGroup->CellAttributes() ?>>
<div<?php echo $caregivers->ClinicGroup->ViewAttributes() ?>><?php echo $caregivers->ClinicGroup->ListViewValue() ?></div></td>
		<td<?php echo $caregivers->DateSent->CellAttributes() ?>>
<div<?php echo $caregivers->DateSent->ViewAttributes() ?>><?php echo $caregivers->DateSent->ListViewValue() ?></div></td>
		<td<?php echo $caregivers->budget_category->CellAttributes() ?>>
<div<?php echo $caregivers->budget_category->ViewAttributes() ?>><?php echo $caregivers->budget_category->ListViewValue() ?></div></td>
		<td<?php echo $caregivers->AgeOfApplicant->CellAttributes() ?>>
<div<?php echo $caregivers->AgeOfApplicant->ViewAttributes() ?>><?php echo $caregivers->AgeOfApplicant->ListViewValue() ?></div></td>
		<td<?php echo $caregivers->Applic->CellAttributes() ?>>
<div<?php echo $caregivers->Applic->ViewAttributes() ?>><?php echo $caregivers->Applic->ListViewValue() ?></div></td>
		<td<?php echo $caregivers->SubApplic->CellAttributes() ?>>
<div<?php echo $caregivers->SubApplic->ViewAttributes() ?>><?php echo $caregivers->SubApplic->ListViewValue() ?></div></td>
		<td<?php echo $caregivers->DateSigned->CellAttributes() ?>>
<div<?php echo $caregivers->DateSigned->ViewAttributes() ?>><?php echo $caregivers->DateSigned->ListViewValue() ?></div></td>
		<td<?php echo $caregivers->colony_id->CellAttributes() ?>>
<div<?php echo $caregivers->colony_id->ViewAttributes() ?>><?php echo $caregivers->colony_id->ListViewValue() ?></div></td>
		<td<?php echo $caregivers->mod_by->CellAttributes() ?>>
<div<?php echo $caregivers->mod_by->ViewAttributes() ?>><?php echo $caregivers->mod_by->ListViewValue() ?></div></td>
		<td<?php echo $caregivers->mod_date->CellAttributes() ?>>
<div<?php echo $caregivers->mod_date->ViewAttributes() ?>><?php echo $caregivers->mod_date->ListViewValue() ?></div></td>
	</tr>
<?php
	$caregivers_delete->Recordset->MoveNext();
}
$caregivers_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="Action" id="Action" value="<?php echo ew_BtnCaption($Language->Phrase("DeleteBtn")) ?>">
</form>
<?php
$caregivers_delete->ShowPageFooter();
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
$caregivers_delete->Page_Terminate();
?>
<?php

//
// Page class
//
class ccaregivers_delete {

	// Page ID
	var $PageID = 'delete';

	// Table name
	var $TableName = 'caregivers';

	// Page object name
	var $PageObjName = 'caregivers_delete';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $caregivers;
		if ($caregivers->UseTokenInUrl) $PageUrl .= "t=" . $caregivers->TableVar . "&"; // Add page token
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
		global $objForm, $caregivers;
		if ($caregivers->UseTokenInUrl) {
			if ($objForm)
				return ($caregivers->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($caregivers->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function ccaregivers_delete() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (caregivers)
		if (!isset($GLOBALS["caregivers"])) {
			$GLOBALS["caregivers"] = new ccaregivers();
			$GLOBALS["Table"] =& $GLOBALS["caregivers"];
		}

		// Table object (colonies)
		if (!isset($GLOBALS['colonies'])) $GLOBALS['colonies'] = new ccolonies();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'caregivers', TRUE);

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
		global $caregivers;

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
		global $Language, $caregivers;

		// Load key parameters
		$this->RecKeys = $caregivers->GetRecordKeys(); // Load record keys
		$sFilter = $caregivers->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("caregiverslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in caregivers class, caregiversinfo.php

		$caregivers->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$caregivers->CurrentAction = $_POST["a_delete"];
		} else {
			$caregivers->CurrentAction = "I"; // Display record
		}
		switch ($caregivers->CurrentAction) {
			case "D": // Delete
				$caregivers->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($caregivers->getReturnUrl()); // Return to caller
				}
		}
	}

// No functions
	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $caregivers;

		// Call Recordset Selecting event
		$caregivers->Recordset_Selecting($caregivers->CurrentFilter);

		// Load List page SQL
		$sSql = $caregivers->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$caregivers->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $caregivers;
		$sFilter = $caregivers->KeyFilter();

		// Call Row Selecting event
		$caregivers->Row_Selecting($sFilter);

		// Load SQL based on filter
		$caregivers->CurrentFilter = $sFilter;
		$sSql = $caregivers->SQL();
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
		global $conn, $caregivers;
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row =& $rs->fields;
		$caregivers->Row_Selected($row);
		$caregivers->caregiver_id->setDbValue($rs->fields('caregiver_id'));
		$caregivers->first_name->setDbValue($rs->fields('first_name'));
		$caregivers->last_name->setDbValue($rs->fields('last_name'));
		$caregivers->day_phone->setDbValue($rs->fields('day_phone'));
		$caregivers->other_phone->setDbValue($rs->fields('other_phone'));
		$caregivers->zemail->setDbValue($rs->fields('email'));
		$caregivers->address->setDbValue($rs->fields('address'));
		$caregivers->apt_num->setDbValue($rs->fields('apt_num'));
		$caregivers->city->setDbValue($rs->fields('city'));
		$caregivers->county->setDbValue($rs->fields('county'));
		$caregivers->zip->setDbValue($rs->fields('zip'));
		$caregivers->num_deps->setDbValue($rs->fields('num_deps'));
		$caregivers->annual_income->setDbValue($rs->fields('annual_income'));
		$caregivers->app_source->setDbValue($rs->fields('app_source'));
		$caregivers->dl->setDbValue($rs->fields('dl'));
		$caregivers->app_date->setDbValue($rs->fields('app_date'));
		$caregivers->Expiration->setDbValue($rs->fields('Expiration'));
		$caregivers->ClinicGroup->setDbValue($rs->fields('ClinicGroup'));
		$caregivers->DateSent->setDbValue($rs->fields('DateSent'));
		$caregivers->budget_category->setDbValue($rs->fields('budget_category'));
		$caregivers->AgeOfApplicant->setDbValue($rs->fields('AgeOfApplicant'));
		$caregivers->Applic->setDbValue($rs->fields('Applic'));
		$caregivers->SubApplic->setDbValue($rs->fields('SubApplic'));
		$caregivers->DateSigned->setDbValue($rs->fields('DateSigned'));
		$caregivers->colony_id->setDbValue($rs->fields('colony_id'));
		$caregivers->mod_by->setDbValue($rs->fields('mod_by'));
		$caregivers->mod_date->setDbValue($rs->fields('mod_date'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $caregivers;

		// Initialize URLs
		// Call Row_Rendering event

		$caregivers->Row_Rendering();

		// Common render codes for all row types
		// caregiver_id
		// first_name
		// last_name
		// day_phone
		// other_phone
		// email
		// address
		// apt_num
		// city
		// county
		// zip
		// num_deps
		// annual_income
		// app_source
		// dl
		// app_date
		// Expiration
		// ClinicGroup
		// DateSent
		// budget_category
		// AgeOfApplicant
		// Applic
		// SubApplic
		// DateSigned
		// colony_id
		// mod_by
		// mod_date

		if ($caregivers->RowType == EW_ROWTYPE_VIEW) { // View row

			// caregiver_id
			$caregivers->caregiver_id->ViewValue = $caregivers->caregiver_id->CurrentValue;
			$caregivers->caregiver_id->ViewCustomAttributes = "";

			// first_name
			$caregivers->first_name->ViewValue = $caregivers->first_name->CurrentValue;
			$caregivers->first_name->ViewCustomAttributes = "";

			// last_name
			$caregivers->last_name->ViewValue = $caregivers->last_name->CurrentValue;
			$caregivers->last_name->ViewCustomAttributes = "";

			// day_phone
			$caregivers->day_phone->ViewValue = $caregivers->day_phone->CurrentValue;
			$caregivers->day_phone->ViewCustomAttributes = "";

			// other_phone
			$caregivers->other_phone->ViewValue = $caregivers->other_phone->CurrentValue;
			$caregivers->other_phone->ViewCustomAttributes = "";

			// email
			$caregivers->zemail->ViewValue = $caregivers->zemail->CurrentValue;
			$caregivers->zemail->ViewCustomAttributes = "";

			// address
			$caregivers->address->ViewValue = $caregivers->address->CurrentValue;
			$caregivers->address->ViewCustomAttributes = "";

			// apt_num
			$caregivers->apt_num->ViewValue = $caregivers->apt_num->CurrentValue;
			$caregivers->apt_num->ViewCustomAttributes = "";

			// city
			$caregivers->city->ViewValue = $caregivers->city->CurrentValue;
			$caregivers->city->ViewCustomAttributes = "";

			// county
			$caregivers->county->ViewValue = $caregivers->county->CurrentValue;
			$caregivers->county->ViewCustomAttributes = "";

			// zip
			$caregivers->zip->ViewValue = $caregivers->zip->CurrentValue;
			$caregivers->zip->ViewCustomAttributes = "";

			// num_deps
			$caregivers->num_deps->ViewValue = $caregivers->num_deps->CurrentValue;
			$caregivers->num_deps->ViewCustomAttributes = "";

			// annual_income
			$caregivers->annual_income->ViewValue = $caregivers->annual_income->CurrentValue;
			$caregivers->annual_income->ViewCustomAttributes = "";

			// app_source
			$caregivers->app_source->ViewValue = $caregivers->app_source->CurrentValue;
			$caregivers->app_source->ViewCustomAttributes = "";

			// dl
			$caregivers->dl->ViewValue = $caregivers->dl->CurrentValue;
			$caregivers->dl->ViewCustomAttributes = "";

			// app_date
			$caregivers->app_date->ViewValue = $caregivers->app_date->CurrentValue;
			$caregivers->app_date->ViewValue = ew_FormatDateTime($caregivers->app_date->ViewValue, 5);
			$caregivers->app_date->ViewCustomAttributes = "";

			// Expiration
			$caregivers->Expiration->ViewValue = $caregivers->Expiration->CurrentValue;
			$caregivers->Expiration->ViewValue = ew_FormatDateTime($caregivers->Expiration->ViewValue, 5);
			$caregivers->Expiration->ViewCustomAttributes = "";

			// ClinicGroup
			$caregivers->ClinicGroup->ViewValue = $caregivers->ClinicGroup->CurrentValue;
			$caregivers->ClinicGroup->ViewCustomAttributes = "";

			// DateSent
			$caregivers->DateSent->ViewValue = $caregivers->DateSent->CurrentValue;
			$caregivers->DateSent->ViewValue = ew_FormatDateTime($caregivers->DateSent->ViewValue, 5);
			$caregivers->DateSent->ViewCustomAttributes = "";

			// budget_category
			$caregivers->budget_category->ViewValue = $caregivers->budget_category->CurrentValue;
			$caregivers->budget_category->ViewCustomAttributes = "";

			// AgeOfApplicant
			$caregivers->AgeOfApplicant->ViewValue = $caregivers->AgeOfApplicant->CurrentValue;
			$caregivers->AgeOfApplicant->ViewCustomAttributes = "";

			// Applic
			$caregivers->Applic->ViewValue = $caregivers->Applic->CurrentValue;
			$caregivers->Applic->ViewCustomAttributes = "";

			// SubApplic
			$caregivers->SubApplic->ViewValue = $caregivers->SubApplic->CurrentValue;
			$caregivers->SubApplic->ViewCustomAttributes = "";

			// DateSigned
			$caregivers->DateSigned->ViewValue = $caregivers->DateSigned->CurrentValue;
			$caregivers->DateSigned->ViewValue = ew_FormatDateTime($caregivers->DateSigned->ViewValue, 5);
			$caregivers->DateSigned->ViewCustomAttributes = "";

			// colony_id
			$caregivers->colony_id->ViewValue = $caregivers->colony_id->CurrentValue;
			$caregivers->colony_id->ViewCustomAttributes = "";

			// mod_by
			$caregivers->mod_by->ViewValue = $caregivers->mod_by->CurrentValue;
			$caregivers->mod_by->ViewCustomAttributes = "";

			// mod_date
			$caregivers->mod_date->ViewValue = $caregivers->mod_date->CurrentValue;
			$caregivers->mod_date->ViewValue = ew_FormatDateTime($caregivers->mod_date->ViewValue, 5);
			$caregivers->mod_date->ViewCustomAttributes = "";

			// caregiver_id
			$caregivers->caregiver_id->LinkCustomAttributes = "";
			$caregivers->caregiver_id->HrefValue = "";
			$caregivers->caregiver_id->TooltipValue = "";

			// first_name
			$caregivers->first_name->LinkCustomAttributes = "";
			$caregivers->first_name->HrefValue = "";
			$caregivers->first_name->TooltipValue = "";

			// last_name
			$caregivers->last_name->LinkCustomAttributes = "";
			$caregivers->last_name->HrefValue = "";
			$caregivers->last_name->TooltipValue = "";

			// day_phone
			$caregivers->day_phone->LinkCustomAttributes = "";
			$caregivers->day_phone->HrefValue = "";
			$caregivers->day_phone->TooltipValue = "";

			// other_phone
			$caregivers->other_phone->LinkCustomAttributes = "";
			$caregivers->other_phone->HrefValue = "";
			$caregivers->other_phone->TooltipValue = "";

			// email
			$caregivers->zemail->LinkCustomAttributes = "";
			$caregivers->zemail->HrefValue = "";
			$caregivers->zemail->TooltipValue = "";

			// address
			$caregivers->address->LinkCustomAttributes = "";
			$caregivers->address->HrefValue = "";
			$caregivers->address->TooltipValue = "";

			// apt_num
			$caregivers->apt_num->LinkCustomAttributes = "";
			$caregivers->apt_num->HrefValue = "";
			$caregivers->apt_num->TooltipValue = "";

			// city
			$caregivers->city->LinkCustomAttributes = "";
			$caregivers->city->HrefValue = "";
			$caregivers->city->TooltipValue = "";

			// county
			$caregivers->county->LinkCustomAttributes = "";
			$caregivers->county->HrefValue = "";
			$caregivers->county->TooltipValue = "";

			// zip
			$caregivers->zip->LinkCustomAttributes = "";
			$caregivers->zip->HrefValue = "";
			$caregivers->zip->TooltipValue = "";

			// num_deps
			$caregivers->num_deps->LinkCustomAttributes = "";
			$caregivers->num_deps->HrefValue = "";
			$caregivers->num_deps->TooltipValue = "";

			// annual_income
			$caregivers->annual_income->LinkCustomAttributes = "";
			$caregivers->annual_income->HrefValue = "";
			$caregivers->annual_income->TooltipValue = "";

			// app_source
			$caregivers->app_source->LinkCustomAttributes = "";
			$caregivers->app_source->HrefValue = "";
			$caregivers->app_source->TooltipValue = "";

			// dl
			$caregivers->dl->LinkCustomAttributes = "";
			$caregivers->dl->HrefValue = "";
			$caregivers->dl->TooltipValue = "";

			// app_date
			$caregivers->app_date->LinkCustomAttributes = "";
			$caregivers->app_date->HrefValue = "";
			$caregivers->app_date->TooltipValue = "";

			// Expiration
			$caregivers->Expiration->LinkCustomAttributes = "";
			$caregivers->Expiration->HrefValue = "";
			$caregivers->Expiration->TooltipValue = "";

			// ClinicGroup
			$caregivers->ClinicGroup->LinkCustomAttributes = "";
			$caregivers->ClinicGroup->HrefValue = "";
			$caregivers->ClinicGroup->TooltipValue = "";

			// DateSent
			$caregivers->DateSent->LinkCustomAttributes = "";
			$caregivers->DateSent->HrefValue = "";
			$caregivers->DateSent->TooltipValue = "";

			// budget_category
			$caregivers->budget_category->LinkCustomAttributes = "";
			$caregivers->budget_category->HrefValue = "";
			$caregivers->budget_category->TooltipValue = "";

			// AgeOfApplicant
			$caregivers->AgeOfApplicant->LinkCustomAttributes = "";
			$caregivers->AgeOfApplicant->HrefValue = "";
			$caregivers->AgeOfApplicant->TooltipValue = "";

			// Applic
			$caregivers->Applic->LinkCustomAttributes = "";
			$caregivers->Applic->HrefValue = "";
			$caregivers->Applic->TooltipValue = "";

			// SubApplic
			$caregivers->SubApplic->LinkCustomAttributes = "";
			$caregivers->SubApplic->HrefValue = "";
			$caregivers->SubApplic->TooltipValue = "";

			// DateSigned
			$caregivers->DateSigned->LinkCustomAttributes = "";
			$caregivers->DateSigned->HrefValue = "";
			$caregivers->DateSigned->TooltipValue = "";

			// colony_id
			$caregivers->colony_id->LinkCustomAttributes = "";
			$caregivers->colony_id->HrefValue = "";
			$caregivers->colony_id->TooltipValue = "";

			// mod_by
			$caregivers->mod_by->LinkCustomAttributes = "";
			$caregivers->mod_by->HrefValue = "";
			$caregivers->mod_by->TooltipValue = "";

			// mod_date
			$caregivers->mod_date->LinkCustomAttributes = "";
			$caregivers->mod_date->HrefValue = "";
			$caregivers->mod_date->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($caregivers->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$caregivers->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security, $caregivers;
		$DeleteRows = TRUE;
		$sSql = $caregivers->SQL();
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
				$DeleteRows = $caregivers->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['caregiver_id'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($caregivers->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($caregivers->CancelMessage <> "") {
				$this->setFailureMessage($caregivers->CancelMessage);
				$caregivers->CancelMessage = "";
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
				$caregivers->Row_Deleted($row);
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
