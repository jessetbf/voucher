<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg8.php" ?>
<?php include_once "ewmysql8.php" ?>
<?php include_once "phpfn8.php" ?>
<?php include_once "coloniesinfo.php" ?>
<?php include_once "caregiversinfo.php" ?>
<?php include_once "vouchersinfo.php" ?>
<?php include_once "vouchersgridcls.php" ?>
<?php include_once "caregiversgridcls.php" ?>
<?php include_once "userfn8.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
$colonies_add = new ccolonies_add();
$Page =& $colonies_add;

// Page init
$colonies_add->Page_Init();

// Page main
$colonies_add->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var colonies_add = new ew_Page("colonies_add");

// page properties
colonies_add.PageID = "add"; // page ID
colonies_add.FormID = "fcoloniesadd"; // form ID
var EW_PAGE_ID = colonies_add.PageID; // for backward compatibility

// extend page with ValidateForm function
colonies_add.ValidateForm = function(fobj) {
	ew_PostAutoSuggest(fobj);
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = 1;
	for (i=0; i<rowcnt; i++) {
		infix = "";
		elm = fobj.elements["x" + infix + "_colony_name"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($colonies->colony_name->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_NumVouchIssued"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($colonies->NumVouchIssued->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_VoucherStartNum"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($colonies->VoucherStartNum->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_VoucherEndNum"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($colonies->VoucherEndNum->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_Inactive"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($colonies->Inactive->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Inactive"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($colonies->Inactive->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_mod_date"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($colonies->mod_date->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_mod_date"];
		if (elm && !ew_CheckDate(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($colonies->mod_date->FldErrMsg()) ?>");

		// Set up row object
		var row = {};
		row["index"] = infix;
		for (var j = 0; j < fobj.elements.length; j++) {
			var el = fobj.elements[j];
			var len = infix.length + 2;
			if (el.name.substr(0, len) == "x" + infix + "_") {
				var elname = "x_" + el.name.substr(len);
				if (ewLang.isObject(row[elname])) { // already exists
					if (ewLang.isArray(row[elname])) {
						row[elname][row[elname].length] = el; // add to array
					} else {
						row[elname] = [row[elname], el]; // convert to array
					}
				} else {
					row[elname] = el;
				}
			}
		}
		fobj.row = row;

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}

	// Process detail page
	var detailpage = (fobj.detailpage) ? fobj.detailpage.value : "";
	if (detailpage != "") {
		return eval(detailpage+".ValidateForm(fobj)");
	}
	return true;
}

// extend page with Form_CustomValidate function
colonies_add.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
colonies_add.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
colonies_add.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("Add") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $colonies->TableCaption() ?></p>
<p class="phpmaker"><a href="<?php echo $colonies->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $colonies_add->ShowPageHeader(); ?>
<?php
$colonies_add->ShowMessage();
?>
<form name="fcoloniesadd" id="fcoloniesadd" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return colonies_add.ValidateForm(this);">
<p>
<input type="hidden" name="t" id="t" value="colonies">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($colonies->colony_name->Visible) { // colony_name ?>
	<tr id="r_colony_name"<?php echo $colonies->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $colonies->colony_name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $colonies->colony_name->CellAttributes() ?>><span id="el_colony_name">
<input type="text" name="x_colony_name" id="x_colony_name" size="30" maxlength="20" value="<?php echo $colonies->colony_name->EditValue ?>"<?php echo $colonies->colony_name->EditAttributes() ?>>
</span><?php echo $colonies->colony_name->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($colonies->colony_address->Visible) { // colony_address ?>
	<tr id="r_colony_address"<?php echo $colonies->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $colonies->colony_address->FldCaption() ?></td>
		<td<?php echo $colonies->colony_address->CellAttributes() ?>><span id="el_colony_address">
<input type="text" name="x_colony_address" id="x_colony_address" size="30" maxlength="30" value="<?php echo $colonies->colony_address->EditValue ?>"<?php echo $colonies->colony_address->EditAttributes() ?>>
</span><?php echo $colonies->colony_address->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($colonies->colony_aptnum->Visible) { // colony_aptnum ?>
	<tr id="r_colony_aptnum"<?php echo $colonies->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $colonies->colony_aptnum->FldCaption() ?></td>
		<td<?php echo $colonies->colony_aptnum->CellAttributes() ?>><span id="el_colony_aptnum">
<input type="text" name="x_colony_aptnum" id="x_colony_aptnum" size="30" maxlength="5" value="<?php echo $colonies->colony_aptnum->EditValue ?>"<?php echo $colonies->colony_aptnum->EditAttributes() ?>>
</span><?php echo $colonies->colony_aptnum->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($colonies->colony_city->Visible) { // colony_city ?>
	<tr id="r_colony_city"<?php echo $colonies->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $colonies->colony_city->FldCaption() ?></td>
		<td<?php echo $colonies->colony_city->CellAttributes() ?>><span id="el_colony_city">
<input type="text" name="x_colony_city" id="x_colony_city" size="30" maxlength="20" value="<?php echo $colonies->colony_city->EditValue ?>"<?php echo $colonies->colony_city->EditAttributes() ?>>
</span><?php echo $colonies->colony_city->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($colonies->colony_county->Visible) { // colony_county ?>
	<tr id="r_colony_county"<?php echo $colonies->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $colonies->colony_county->FldCaption() ?></td>
		<td<?php echo $colonies->colony_county->CellAttributes() ?>><span id="el_colony_county">
<input type="text" name="x_colony_county" id="x_colony_county" size="30" maxlength="20" value="<?php echo $colonies->colony_county->EditValue ?>"<?php echo $colonies->colony_county->EditAttributes() ?>>
</span><?php echo $colonies->colony_county->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($colonies->colony_zip->Visible) { // colony_zip ?>
	<tr id="r_colony_zip"<?php echo $colonies->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $colonies->colony_zip->FldCaption() ?></td>
		<td<?php echo $colonies->colony_zip->CellAttributes() ?>><span id="el_colony_zip">
<input type="text" name="x_colony_zip" id="x_colony_zip" size="30" maxlength="30" value="<?php echo $colonies->colony_zip->EditValue ?>"<?php echo $colonies->colony_zip->EditAttributes() ?>>
</span><?php echo $colonies->colony_zip->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($colonies->NumVouchIssued->Visible) { // NumVouchIssued ?>
	<tr id="r_NumVouchIssued"<?php echo $colonies->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $colonies->NumVouchIssued->FldCaption() ?></td>
		<td<?php echo $colonies->NumVouchIssued->CellAttributes() ?>><span id="el_NumVouchIssued">
<input type="text" name="x_NumVouchIssued" id="x_NumVouchIssued" size="30" value="<?php echo $colonies->NumVouchIssued->EditValue ?>"<?php echo $colonies->NumVouchIssued->EditAttributes() ?>>
</span><?php echo $colonies->NumVouchIssued->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($colonies->VoucherStartNum->Visible) { // VoucherStartNum ?>
	<tr id="r_VoucherStartNum"<?php echo $colonies->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $colonies->VoucherStartNum->FldCaption() ?></td>
		<td<?php echo $colonies->VoucherStartNum->CellAttributes() ?>><span id="el_VoucherStartNum">
<input type="text" name="x_VoucherStartNum" id="x_VoucherStartNum" size="30" value="<?php echo $colonies->VoucherStartNum->EditValue ?>"<?php echo $colonies->VoucherStartNum->EditAttributes() ?>>
</span><?php echo $colonies->VoucherStartNum->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($colonies->VoucherEndNum->Visible) { // VoucherEndNum ?>
	<tr id="r_VoucherEndNum"<?php echo $colonies->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $colonies->VoucherEndNum->FldCaption() ?></td>
		<td<?php echo $colonies->VoucherEndNum->CellAttributes() ?>><span id="el_VoucherEndNum">
<input type="text" name="x_VoucherEndNum" id="x_VoucherEndNum" size="30" value="<?php echo $colonies->VoucherEndNum->EditValue ?>"<?php echo $colonies->VoucherEndNum->EditAttributes() ?>>
</span><?php echo $colonies->VoucherEndNum->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($colonies->trapper->Visible) { // trapper ?>
	<tr id="r_trapper"<?php echo $colonies->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $colonies->trapper->FldCaption() ?></td>
		<td<?php echo $colonies->trapper->CellAttributes() ?>><span id="el_trapper">
<input type="text" name="x_trapper" id="x_trapper" size="30" maxlength="30" value="<?php echo $colonies->trapper->EditValue ?>"<?php echo $colonies->trapper->EditAttributes() ?>>
</span><?php echo $colonies->trapper->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($colonies->notes->Visible) { // notes ?>
	<tr id="r_notes"<?php echo $colonies->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $colonies->notes->FldCaption() ?></td>
		<td<?php echo $colonies->notes->CellAttributes() ?>><span id="el_notes">
<input type="text" name="x_notes" id="x_notes" size="30" maxlength="100" value="<?php echo $colonies->notes->EditValue ?>"<?php echo $colonies->notes->EditAttributes() ?>>
</span><?php echo $colonies->notes->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($colonies->sage->Visible) { // sage ?>
	<tr id="r_sage"<?php echo $colonies->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $colonies->sage->FldCaption() ?></td>
		<td<?php echo $colonies->sage->CellAttributes() ?>><span id="el_sage">
<input type="text" name="x_sage" id="x_sage" size="30" maxlength="1" value="<?php echo $colonies->sage->EditValue ?>"<?php echo $colonies->sage->EditAttributes() ?>>
</span><?php echo $colonies->sage->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($colonies->Inactive->Visible) { // Inactive ?>
	<tr id="r_Inactive"<?php echo $colonies->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $colonies->Inactive->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $colonies->Inactive->CellAttributes() ?>><span id="el_Inactive">
<input type="text" name="x_Inactive" id="x_Inactive" size="30" value="<?php echo $colonies->Inactive->EditValue ?>"<?php echo $colonies->Inactive->EditAttributes() ?>>
</span><?php echo $colonies->Inactive->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($colonies->mod_by->Visible) { // mod_by ?>
	<tr id="r_mod_by"<?php echo $colonies->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $colonies->mod_by->FldCaption() ?></td>
		<td<?php echo $colonies->mod_by->CellAttributes() ?>><span id="el_mod_by">
<input type="text" name="x_mod_by" id="x_mod_by" size="30" maxlength="20" value="<?php echo $colonies->mod_by->EditValue ?>"<?php echo $colonies->mod_by->EditAttributes() ?>>
</span><?php echo $colonies->mod_by->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($colonies->mod_date->Visible) { // mod_date ?>
	<tr id="r_mod_date"<?php echo $colonies->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $colonies->mod_date->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $colonies->mod_date->CellAttributes() ?>><span id="el_mod_date">
<input type="text" name="x_mod_date" id="x_mod_date" value="<?php echo $colonies->mod_date->EditValue ?>"<?php echo $colonies->mod_date->EditAttributes() ?>>
</span><?php echo $colonies->mod_date->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($colonies->getCurrentDetailTable() == "vouchers" && $vouchers->DetailAdd) { ?>
<br>
<?php include_once "vouchersgrid.php" ?>
<br>
<?php } ?>
<?php if ($colonies->getCurrentDetailTable() == "caregivers" && $caregivers->DetailAdd) { ?>
<br>
<?php include_once "caregiversgrid.php" ?>
<br>
<?php } ?>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("AddBtn")) ?>">
</form>
<?php
$colonies_add->ShowPageFooter();
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
$colonies_add->Page_Terminate();
?>
<?php

//
// Page class
//
class ccolonies_add {

	// Page ID
	var $PageID = 'add';

	// Table name
	var $TableName = 'colonies';

	// Page object name
	var $PageObjName = 'colonies_add';

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
	function ccolonies_add() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (colonies)
		if (!isset($GLOBALS["colonies"])) {
			$GLOBALS["colonies"] = new ccolonies();
			$GLOBALS["Table"] =& $GLOBALS["colonies"];
		}

		// Table object (caregivers)
		if (!isset($GLOBALS['caregivers'])) $GLOBALS['caregivers'] = new ccaregivers();

		// Table object (vouchers)
		if (!isset($GLOBALS['vouchers'])) $GLOBALS['vouchers'] = new cvouchers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

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

		// Create form object
		$objForm = new cFormObj();

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
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $colonies;

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$colonies->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values

			// Set up detail parameters
			$this->SetUpDetailParms();

			// Validate form
			if (!$this->ValidateForm()) {
				$colonies->CurrentAction = "I"; // Form error, reset action
				$colonies->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["colony_id"] != "") {
				$colonies->colony_id->setQueryStringValue($_GET["colony_id"]);
				$colonies->setKey("colony_id", $colonies->colony_id->CurrentValue); // Set up key
			} else {
				$colonies->setKey("colony_id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if (@$_GET["colony_name"] != "") {
				$colonies->colony_name->setQueryStringValue($_GET["colony_name"]);
				$colonies->setKey("colony_name", $colonies->colony_name->CurrentValue); // Set up key
			} else {
				$colonies->setKey("colony_name", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$colonies->CurrentAction = "C"; // Copy record
			} else {
				$colonies->CurrentAction = "I"; // Display blank record
				$this->LoadDefaultValues(); // Load default values
			}
		}

		// Set up detail parameters
		$this->SetUpDetailParms();

		// Perform action based on action code
		switch ($colonies->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("colonieslist.php"); // No matching record, return to list
				}
				break;
			case "A": // ' Add new record
				$colonies->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					if ($colonies->getCurrentDetailTable() <> "") // Master/detail add
						$sReturnUrl = $colonies->getDetailUrl();
					else
						$sReturnUrl = $colonies->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "coloniesview.php")
						$sReturnUrl = $colonies->ViewUrl(); // View paging, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$colonies->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$colonies->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
		$colonies->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $colonies;

		// Get upload data
		$index = $objForm->Index; // Save form index
		$objForm->Index = 0;
		$confirmPage = (strval($objForm->GetValue("a_confirm")) <> "");
		$objForm->Index = $index; // Restore form index
	}

	// Load default values
	function LoadDefaultValues() {
		global $colonies;
		$colonies->colony_name->CurrentValue = NULL;
		$colonies->colony_name->OldValue = $colonies->colony_name->CurrentValue;
		$colonies->colony_address->CurrentValue = NULL;
		$colonies->colony_address->OldValue = $colonies->colony_address->CurrentValue;
		$colonies->colony_aptnum->CurrentValue = NULL;
		$colonies->colony_aptnum->OldValue = $colonies->colony_aptnum->CurrentValue;
		$colonies->colony_city->CurrentValue = NULL;
		$colonies->colony_city->OldValue = $colonies->colony_city->CurrentValue;
		$colonies->colony_county->CurrentValue = NULL;
		$colonies->colony_county->OldValue = $colonies->colony_county->CurrentValue;
		$colonies->colony_zip->CurrentValue = NULL;
		$colonies->colony_zip->OldValue = $colonies->colony_zip->CurrentValue;
		$colonies->NumVouchIssued->CurrentValue = NULL;
		$colonies->NumVouchIssued->OldValue = $colonies->NumVouchIssued->CurrentValue;
		$colonies->VoucherStartNum->CurrentValue = NULL;
		$colonies->VoucherStartNum->OldValue = $colonies->VoucherStartNum->CurrentValue;
		$colonies->VoucherEndNum->CurrentValue = NULL;
		$colonies->VoucherEndNum->OldValue = $colonies->VoucherEndNum->CurrentValue;
		$colonies->trapper->CurrentValue = NULL;
		$colonies->trapper->OldValue = $colonies->trapper->CurrentValue;
		$colonies->notes->CurrentValue = NULL;
		$colonies->notes->OldValue = $colonies->notes->CurrentValue;
		$colonies->sage->CurrentValue = NULL;
		$colonies->sage->OldValue = $colonies->sage->CurrentValue;
		$colonies->Inactive->CurrentValue = 0;
		$colonies->mod_by->CurrentValue = NULL;
		$colonies->mod_by->OldValue = $colonies->mod_by->CurrentValue;
		$colonies->mod_date->CurrentValue = NULL;
		$colonies->mod_date->OldValue = $colonies->mod_date->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $colonies;
		if (!$colonies->colony_name->FldIsDetailKey) {
			$colonies->colony_name->setFormValue($objForm->GetValue("x_colony_name"));
		}
		if (!$colonies->colony_address->FldIsDetailKey) {
			$colonies->colony_address->setFormValue($objForm->GetValue("x_colony_address"));
		}
		if (!$colonies->colony_aptnum->FldIsDetailKey) {
			$colonies->colony_aptnum->setFormValue($objForm->GetValue("x_colony_aptnum"));
		}
		if (!$colonies->colony_city->FldIsDetailKey) {
			$colonies->colony_city->setFormValue($objForm->GetValue("x_colony_city"));
		}
		if (!$colonies->colony_county->FldIsDetailKey) {
			$colonies->colony_county->setFormValue($objForm->GetValue("x_colony_county"));
		}
		if (!$colonies->colony_zip->FldIsDetailKey) {
			$colonies->colony_zip->setFormValue($objForm->GetValue("x_colony_zip"));
		}
		if (!$colonies->NumVouchIssued->FldIsDetailKey) {
			$colonies->NumVouchIssued->setFormValue($objForm->GetValue("x_NumVouchIssued"));
		}
		if (!$colonies->VoucherStartNum->FldIsDetailKey) {
			$colonies->VoucherStartNum->setFormValue($objForm->GetValue("x_VoucherStartNum"));
		}
		if (!$colonies->VoucherEndNum->FldIsDetailKey) {
			$colonies->VoucherEndNum->setFormValue($objForm->GetValue("x_VoucherEndNum"));
		}
		if (!$colonies->trapper->FldIsDetailKey) {
			$colonies->trapper->setFormValue($objForm->GetValue("x_trapper"));
		}
		if (!$colonies->notes->FldIsDetailKey) {
			$colonies->notes->setFormValue($objForm->GetValue("x_notes"));
		}
		if (!$colonies->sage->FldIsDetailKey) {
			$colonies->sage->setFormValue($objForm->GetValue("x_sage"));
		}
		if (!$colonies->Inactive->FldIsDetailKey) {
			$colonies->Inactive->setFormValue($objForm->GetValue("x_Inactive"));
		}
		if (!$colonies->mod_by->FldIsDetailKey) {
			$colonies->mod_by->setFormValue($objForm->GetValue("x_mod_by"));
		}
		if (!$colonies->mod_date->FldIsDetailKey) {
			$colonies->mod_date->setFormValue($objForm->GetValue("x_mod_date"));
			$colonies->mod_date->CurrentValue = ew_UnFormatDateTime($colonies->mod_date->CurrentValue, 5);
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $colonies;
		$this->LoadOldRecord();
		$colonies->colony_name->CurrentValue = $colonies->colony_name->FormValue;
		$colonies->colony_address->CurrentValue = $colonies->colony_address->FormValue;
		$colonies->colony_aptnum->CurrentValue = $colonies->colony_aptnum->FormValue;
		$colonies->colony_city->CurrentValue = $colonies->colony_city->FormValue;
		$colonies->colony_county->CurrentValue = $colonies->colony_county->FormValue;
		$colonies->colony_zip->CurrentValue = $colonies->colony_zip->FormValue;
		$colonies->NumVouchIssued->CurrentValue = $colonies->NumVouchIssued->FormValue;
		$colonies->VoucherStartNum->CurrentValue = $colonies->VoucherStartNum->FormValue;
		$colonies->VoucherEndNum->CurrentValue = $colonies->VoucherEndNum->FormValue;
		$colonies->trapper->CurrentValue = $colonies->trapper->FormValue;
		$colonies->notes->CurrentValue = $colonies->notes->FormValue;
		$colonies->sage->CurrentValue = $colonies->sage->FormValue;
		$colonies->Inactive->CurrentValue = $colonies->Inactive->FormValue;
		$colonies->mod_by->CurrentValue = $colonies->mod_by->FormValue;
		$colonies->mod_date->CurrentValue = $colonies->mod_date->FormValue;
		$colonies->mod_date->CurrentValue = ew_UnFormatDateTime($colonies->mod_date->CurrentValue, 5);
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

	// Load old record
	function LoadOldRecord() {
		global $colonies;

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($colonies->getKey("colony_id")) <> "")
			$colonies->colony_id->CurrentValue = $colonies->getKey("colony_id"); // colony_id
		else
			$bValidKey = FALSE;
		if (strval($colonies->getKey("colony_name")) <> "")
			$colonies->colony_name->CurrentValue = $colonies->getKey("colony_name"); // colony_name
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$colonies->CurrentFilter = $colonies->KeyFilter();
			$sSql = $colonies->SQL();
			$this->OldRecordset = ew_LoadRecordset($sSql);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
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
		} elseif ($colonies->RowType == EW_ROWTYPE_ADD) { // Add row

			// colony_name
			$colonies->colony_name->EditCustomAttributes = "";
			$colonies->colony_name->EditValue = ew_HtmlEncode($colonies->colony_name->CurrentValue);

			// colony_address
			$colonies->colony_address->EditCustomAttributes = "";
			$colonies->colony_address->EditValue = ew_HtmlEncode($colonies->colony_address->CurrentValue);

			// colony_aptnum
			$colonies->colony_aptnum->EditCustomAttributes = "";
			$colonies->colony_aptnum->EditValue = ew_HtmlEncode($colonies->colony_aptnum->CurrentValue);

			// colony_city
			$colonies->colony_city->EditCustomAttributes = "";
			$colonies->colony_city->EditValue = ew_HtmlEncode($colonies->colony_city->CurrentValue);

			// colony_county
			$colonies->colony_county->EditCustomAttributes = "";
			$colonies->colony_county->EditValue = ew_HtmlEncode($colonies->colony_county->CurrentValue);

			// colony_zip
			$colonies->colony_zip->EditCustomAttributes = "";
			$colonies->colony_zip->EditValue = ew_HtmlEncode($colonies->colony_zip->CurrentValue);

			// NumVouchIssued
			$colonies->NumVouchIssued->EditCustomAttributes = "";
			$colonies->NumVouchIssued->EditValue = ew_HtmlEncode($colonies->NumVouchIssued->CurrentValue);

			// VoucherStartNum
			$colonies->VoucherStartNum->EditCustomAttributes = "";
			$colonies->VoucherStartNum->EditValue = ew_HtmlEncode($colonies->VoucherStartNum->CurrentValue);

			// VoucherEndNum
			$colonies->VoucherEndNum->EditCustomAttributes = "";
			$colonies->VoucherEndNum->EditValue = ew_HtmlEncode($colonies->VoucherEndNum->CurrentValue);

			// trapper
			$colonies->trapper->EditCustomAttributes = "";
			$colonies->trapper->EditValue = ew_HtmlEncode($colonies->trapper->CurrentValue);

			// notes
			$colonies->notes->EditCustomAttributes = "";
			$colonies->notes->EditValue = ew_HtmlEncode($colonies->notes->CurrentValue);

			// sage
			$colonies->sage->EditCustomAttributes = "";
			$colonies->sage->EditValue = ew_HtmlEncode($colonies->sage->CurrentValue);

			// Inactive
			$colonies->Inactive->EditCustomAttributes = "";
			$colonies->Inactive->EditValue = ew_HtmlEncode($colonies->Inactive->CurrentValue);

			// mod_by
			$colonies->mod_by->EditCustomAttributes = "";
			$colonies->mod_by->EditValue = ew_HtmlEncode($colonies->mod_by->CurrentValue);

			// mod_date
			$colonies->mod_date->EditCustomAttributes = "";
			$colonies->mod_date->EditValue = ew_HtmlEncode(ew_FormatDateTime($colonies->mod_date->CurrentValue, 5));

			// Edit refer script
			// colony_name

			$colonies->colony_name->HrefValue = "";

			// colony_address
			$colonies->colony_address->HrefValue = "";

			// colony_aptnum
			$colonies->colony_aptnum->HrefValue = "";

			// colony_city
			$colonies->colony_city->HrefValue = "";

			// colony_county
			$colonies->colony_county->HrefValue = "";

			// colony_zip
			$colonies->colony_zip->HrefValue = "";

			// NumVouchIssued
			$colonies->NumVouchIssued->HrefValue = "";

			// VoucherStartNum
			$colonies->VoucherStartNum->HrefValue = "";

			// VoucherEndNum
			$colonies->VoucherEndNum->HrefValue = "";

			// trapper
			$colonies->trapper->HrefValue = "";

			// notes
			$colonies->notes->HrefValue = "";

			// sage
			$colonies->sage->HrefValue = "";

			// Inactive
			$colonies->Inactive->HrefValue = "";

			// mod_by
			$colonies->mod_by->HrefValue = "";

			// mod_date
			$colonies->mod_date->HrefValue = "";
		}
		if ($colonies->RowType == EW_ROWTYPE_ADD ||
			$colonies->RowType == EW_ROWTYPE_EDIT ||
			$colonies->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$colonies->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($colonies->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$colonies->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError, $colonies;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!is_null($colonies->colony_name->FormValue) && $colonies->colony_name->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $colonies->colony_name->FldCaption());
		}
		if (!ew_CheckInteger($colonies->NumVouchIssued->FormValue)) {
			ew_AddMessage($gsFormError, $colonies->NumVouchIssued->FldErrMsg());
		}
		if (!ew_CheckInteger($colonies->VoucherStartNum->FormValue)) {
			ew_AddMessage($gsFormError, $colonies->VoucherStartNum->FldErrMsg());
		}
		if (!ew_CheckInteger($colonies->VoucherEndNum->FormValue)) {
			ew_AddMessage($gsFormError, $colonies->VoucherEndNum->FldErrMsg());
		}
		if (!is_null($colonies->Inactive->FormValue) && $colonies->Inactive->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $colonies->Inactive->FldCaption());
		}
		if (!ew_CheckInteger($colonies->Inactive->FormValue)) {
			ew_AddMessage($gsFormError, $colonies->Inactive->FldErrMsg());
		}
		if (!is_null($colonies->mod_date->FormValue) && $colonies->mod_date->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $colonies->mod_date->FldCaption());
		}
		if (!ew_CheckDate($colonies->mod_date->FormValue)) {
			ew_AddMessage($gsFormError, $colonies->mod_date->FldErrMsg());
		}

		// Validate detail grid
		if ($colonies->getCurrentDetailTable() == "vouchers" && $GLOBALS["vouchers"]->DetailAdd) {
			$vouchers_grid = new cvouchers_grid(); // get detail page object
			$vouchers_grid->ValidateGridForm();
			$vouchers_grid = NULL;
		}
		if ($colonies->getCurrentDetailTable() == "caregivers" && $GLOBALS["caregivers"]->DetailAdd) {
			$caregivers_grid = new ccaregivers_grid(); // get detail page object
			$caregivers_grid->ValidateGridForm();
			$caregivers_grid = NULL;
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $conn, $Language, $Security, $colonies;

		// Check if key value entered
		if ($colonies->colony_name->CurrentValue == "" && $colonies->colony_name->getSessionValue() == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			return FALSE;
		}

		// Begin transaction
		if ($colonies->getCurrentDetailTable() <> "")
			$conn->BeginTrans();
		$rsnew = array();

		// colony_name
		$colonies->colony_name->SetDbValueDef($rsnew, $colonies->colony_name->CurrentValue, "", FALSE);

		// colony_address
		$colonies->colony_address->SetDbValueDef($rsnew, $colonies->colony_address->CurrentValue, NULL, FALSE);

		// colony_aptnum
		$colonies->colony_aptnum->SetDbValueDef($rsnew, $colonies->colony_aptnum->CurrentValue, NULL, FALSE);

		// colony_city
		$colonies->colony_city->SetDbValueDef($rsnew, $colonies->colony_city->CurrentValue, NULL, FALSE);

		// colony_county
		$colonies->colony_county->SetDbValueDef($rsnew, $colonies->colony_county->CurrentValue, NULL, FALSE);

		// colony_zip
		$colonies->colony_zip->SetDbValueDef($rsnew, $colonies->colony_zip->CurrentValue, NULL, FALSE);

		// NumVouchIssued
		$colonies->NumVouchIssued->SetDbValueDef($rsnew, $colonies->NumVouchIssued->CurrentValue, NULL, FALSE);

		// VoucherStartNum
		$colonies->VoucherStartNum->SetDbValueDef($rsnew, $colonies->VoucherStartNum->CurrentValue, NULL, FALSE);

		// VoucherEndNum
		$colonies->VoucherEndNum->SetDbValueDef($rsnew, $colonies->VoucherEndNum->CurrentValue, NULL, FALSE);

		// trapper
		$colonies->trapper->SetDbValueDef($rsnew, $colonies->trapper->CurrentValue, NULL, FALSE);

		// notes
		$colonies->notes->SetDbValueDef($rsnew, $colonies->notes->CurrentValue, NULL, FALSE);

		// sage
		$colonies->sage->SetDbValueDef($rsnew, $colonies->sage->CurrentValue, NULL, FALSE);

		// Inactive
		$colonies->Inactive->SetDbValueDef($rsnew, $colonies->Inactive->CurrentValue, 0, strval($colonies->Inactive->CurrentValue) == "");

		// mod_by
		$colonies->mod_by->SetDbValueDef($rsnew, $colonies->mod_by->CurrentValue, NULL, FALSE);

		// mod_date
		$colonies->mod_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($colonies->mod_date->CurrentValue, 5), ew_CurrentDate(), FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $colonies->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $conn->Execute($colonies->InsertSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($colonies->CancelMessage <> "") {
				$this->setFailureMessage($colonies->CancelMessage);
				$colonies->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}

		// Get insert id if necessary
		if ($AddRow) {
			$colonies->colony_id->setDbValue($conn->Insert_ID());
			$rsnew['colony_id'] = $colonies->colony_id->DbValue;
		}

		// Add detail records
		if ($AddRow) {
			if ($colonies->getCurrentDetailTable() == "vouchers" && $GLOBALS["vouchers"]->DetailAdd) {
				$GLOBALS["vouchers"]->colony_id->setSessionValue($colonies->colony_id->CurrentValue); // Set master key
				$vouchers_grid = new cvouchers_grid(); // get detail page object
				$AddRow = $vouchers_grid->GridInsert();
				$vouchers_grid = NULL;
			}
			if ($colonies->getCurrentDetailTable() == "caregivers" && $GLOBALS["caregivers"]->DetailAdd) {
				$GLOBALS["caregivers"]->colony_id->setSessionValue($colonies->colony_id->CurrentValue); // Set master key
				$caregivers_grid = new ccaregivers_grid(); // get detail page object
				$AddRow = $caregivers_grid->GridInsert();
				$caregivers_grid = NULL;
			}
		}

		// Commit/Rollback transaction
		if ($colonies->getCurrentDetailTable() <> "") {
			if ($AddRow) {
				$conn->CommitTrans(); // Commit transaction
			} else {
				$conn->RollbackTrans(); // Rollback transaction
			}
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$colonies->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up detail parms based on QueryString
	function SetUpDetailParms() {
		global $colonies;
		$bValidDetail = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_DETAIL])) {
			$sDetailTblVar = $_GET[EW_TABLE_SHOW_DETAIL];
			$colonies->setCurrentDetailTable($sDetailTblVar);
		} else {
			$sDetailTblVar = $colonies->getCurrentDetailTable();
		}
		if ($sDetailTblVar <> "") {
			if ($sDetailTblVar == "vouchers") {
				if (!isset($GLOBALS["vouchers"]))
					$GLOBALS["vouchers"] = new cvouchers;
				if ($GLOBALS["vouchers"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["vouchers"]->CurrentMode = "copy";
					else
						$GLOBALS["vouchers"]->CurrentMode = "add";
					$GLOBALS["vouchers"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["vouchers"]->setCurrentMasterTable($colonies->TableVar);
					$GLOBALS["vouchers"]->setStartRecordNumber(1);
					$GLOBALS["vouchers"]->colony_id->FldIsDetailKey = TRUE;
					$GLOBALS["vouchers"]->colony_id->CurrentValue = $colonies->colony_id->CurrentValue;
					$GLOBALS["vouchers"]->colony_id->setSessionValue($GLOBALS["vouchers"]->colony_id->CurrentValue);
				}
			}
			if ($sDetailTblVar == "caregivers") {
				if (!isset($GLOBALS["caregivers"]))
					$GLOBALS["caregivers"] = new ccaregivers;
				if ($GLOBALS["caregivers"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["caregivers"]->CurrentMode = "copy";
					else
						$GLOBALS["caregivers"]->CurrentMode = "add";
					$GLOBALS["caregivers"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["caregivers"]->setCurrentMasterTable($colonies->TableVar);
					$GLOBALS["caregivers"]->setStartRecordNumber(1);
					$GLOBALS["caregivers"]->colony_id->FldIsDetailKey = TRUE;
					$GLOBALS["caregivers"]->colony_id->CurrentValue = $colonies->colony_id->CurrentValue;
					$GLOBALS["caregivers"]->colony_id->setSessionValue($GLOBALS["caregivers"]->colony_id->CurrentValue);
				}
			}
		}
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
