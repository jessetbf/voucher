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
$vets_add = new cvets_add();
$Page =& $vets_add;

// Page init
$vets_add->Page_Init();

// Page main
$vets_add->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var vets_add = new ew_Page("vets_add");

// page properties
vets_add.PageID = "add"; // page ID
vets_add.FormID = "fvetsadd"; // form ID
var EW_PAGE_ID = vets_add.PageID; // for backward compatibility

// extend page with ValidateForm function
vets_add.ValidateForm = function(fobj) {
	ew_PostAutoSuggest(fobj);
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = 1;
	for (i=0; i<rowcnt; i++) {
		infix = "";
		elm = fobj.elements["x" + infix + "_CountyServed"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($vets->CountyServed->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Clinic"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($vets->Clinic->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Vet"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($vets->Vet->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Address"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($vets->Address->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_MailingAddress"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($vets->MailingAddress->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_City"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($vets->City->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Zip"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($vets->Zip->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Zip"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($vets->Zip->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_County"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($vets->County->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Active"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($vets->Active->FldCaption()) ?>");

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
vets_add.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
vets_add.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
vets_add.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php $vets_add->ShowPageHeader(); ?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("Add") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $vets->TableCaption() ?></p>
<p class="phpmaker"><a href="<?php echo $vets->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php
$vets_add->ShowMessage();
?>
<form name="fvetsadd" id="fvetsadd" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return vets_add.ValidateForm(this);">
<p>
<input type="hidden" name="t" id="t" value="vets">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($vets->CountyServed->Visible) { // CountyServed ?>
	<tr id="r_CountyServed"<?php echo $vets->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vets->CountyServed->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $vets->CountyServed->CellAttributes() ?>><span id="el_CountyServed">
<input type="text" name="x_CountyServed" id="x_CountyServed" size="30" maxlength="30" value="<?php echo $vets->CountyServed->EditValue ?>"<?php echo $vets->CountyServed->EditAttributes() ?>>
</span><?php echo $vets->CountyServed->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vets->Clinic->Visible) { // Clinic ?>
	<tr id="r_Clinic"<?php echo $vets->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vets->Clinic->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $vets->Clinic->CellAttributes() ?>><span id="el_Clinic">
<input type="text" name="x_Clinic" id="x_Clinic" size="30" maxlength="100" value="<?php echo $vets->Clinic->EditValue ?>"<?php echo $vets->Clinic->EditAttributes() ?>>
</span><?php echo $vets->Clinic->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vets->Vet->Visible) { // Vet ?>
	<tr id="r_Vet"<?php echo $vets->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vets->Vet->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $vets->Vet->CellAttributes() ?>><span id="el_Vet">
<input type="text" name="x_Vet" id="x_Vet" size="30" maxlength="100" value="<?php echo $vets->Vet->EditValue ?>"<?php echo $vets->Vet->EditAttributes() ?>>
</span><?php echo $vets->Vet->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vets->Address->Visible) { // Address ?>
	<tr id="r_Address"<?php echo $vets->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vets->Address->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $vets->Address->CellAttributes() ?>><span id="el_Address">
<input type="text" name="x_Address" id="x_Address" size="30" maxlength="100" value="<?php echo $vets->Address->EditValue ?>"<?php echo $vets->Address->EditAttributes() ?>>
</span><?php echo $vets->Address->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vets->MailingAddress->Visible) { // MailingAddress ?>
	<tr id="r_MailingAddress"<?php echo $vets->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vets->MailingAddress->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $vets->MailingAddress->CellAttributes() ?>><span id="el_MailingAddress">
<input type="text" name="x_MailingAddress" id="x_MailingAddress" size="30" maxlength="100" value="<?php echo $vets->MailingAddress->EditValue ?>"<?php echo $vets->MailingAddress->EditAttributes() ?>>
</span><?php echo $vets->MailingAddress->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vets->City->Visible) { // City ?>
	<tr id="r_City"<?php echo $vets->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vets->City->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $vets->City->CellAttributes() ?>><span id="el_City">
<input type="text" name="x_City" id="x_City" size="30" maxlength="30" value="<?php echo $vets->City->EditValue ?>"<?php echo $vets->City->EditAttributes() ?>>
</span><?php echo $vets->City->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vets->Zip->Visible) { // Zip ?>
	<tr id="r_Zip"<?php echo $vets->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vets->Zip->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $vets->Zip->CellAttributes() ?>><span id="el_Zip">
<input type="text" name="x_Zip" id="x_Zip" size="30" value="<?php echo $vets->Zip->EditValue ?>"<?php echo $vets->Zip->EditAttributes() ?>>
</span><?php echo $vets->Zip->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vets->County->Visible) { // County ?>
	<tr id="r_County"<?php echo $vets->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vets->County->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $vets->County->CellAttributes() ?>><span id="el_County">
<input type="text" name="x_County" id="x_County" size="30" maxlength="30" value="<?php echo $vets->County->EditValue ?>"<?php echo $vets->County->EditAttributes() ?>>
</span><?php echo $vets->County->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vets->Phone->Visible) { // Phone ?>
	<tr id="r_Phone"<?php echo $vets->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vets->Phone->FldCaption() ?></td>
		<td<?php echo $vets->Phone->CellAttributes() ?>><span id="el_Phone">
<input type="text" name="x_Phone" id="x_Phone" size="30" maxlength="30" value="<?php echo $vets->Phone->EditValue ?>"<?php echo $vets->Phone->EditAttributes() ?>>
</span><?php echo $vets->Phone->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vets->Fax->Visible) { // Fax ?>
	<tr id="r_Fax"<?php echo $vets->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vets->Fax->FldCaption() ?></td>
		<td<?php echo $vets->Fax->CellAttributes() ?>><span id="el_Fax">
<input type="text" name="x_Fax" id="x_Fax" size="30" maxlength="30" value="<?php echo $vets->Fax->EditValue ?>"<?php echo $vets->Fax->EditAttributes() ?>>
</span><?php echo $vets->Fax->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vets->AllCatsFee->Visible) { // AllCatsFee ?>
	<tr id="r_AllCatsFee"<?php echo $vets->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vets->AllCatsFee->FldCaption() ?></td>
		<td<?php echo $vets->AllCatsFee->CellAttributes() ?>><span id="el_AllCatsFee">
<input type="text" name="x_AllCatsFee" id="x_AllCatsFee" size="30" maxlength="10" value="<?php echo $vets->AllCatsFee->EditValue ?>"<?php echo $vets->AllCatsFee->EditAttributes() ?>>
</span><?php echo $vets->AllCatsFee->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vets->AllMaleDogs->Visible) { // AllMaleDogs ?>
	<tr id="r_AllMaleDogs"<?php echo $vets->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vets->AllMaleDogs->FldCaption() ?></td>
		<td<?php echo $vets->AllMaleDogs->CellAttributes() ?>><span id="el_AllMaleDogs">
<input type="text" name="x_AllMaleDogs" id="x_AllMaleDogs" size="30" maxlength="10" value="<?php echo $vets->AllMaleDogs->EditValue ?>"<?php echo $vets->AllMaleDogs->EditAttributes() ?>>
</span><?php echo $vets->AllMaleDogs->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vets->FemDogsUnder75->Visible) { // FemDogsUnder75 ?>
	<tr id="r_FemDogsUnder75"<?php echo $vets->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vets->FemDogsUnder75->FldCaption() ?></td>
		<td<?php echo $vets->FemDogsUnder75->CellAttributes() ?>><span id="el_FemDogsUnder75">
<input type="text" name="x_FemDogsUnder75" id="x_FemDogsUnder75" size="30" maxlength="10" value="<?php echo $vets->FemDogsUnder75->EditValue ?>"<?php echo $vets->FemDogsUnder75->EditAttributes() ?>>
</span><?php echo $vets->FemDogsUnder75->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vets->FemDogsOver75->Visible) { // FemDogsOver75 ?>
	<tr id="r_FemDogsOver75"<?php echo $vets->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vets->FemDogsOver75->FldCaption() ?></td>
		<td<?php echo $vets->FemDogsOver75->CellAttributes() ?>><span id="el_FemDogsOver75">
<input type="text" name="x_FemDogsOver75" id="x_FemDogsOver75" size="30" maxlength="10" value="<?php echo $vets->FemDogsOver75->EditValue ?>"<?php echo $vets->FemDogsOver75->EditAttributes() ?>>
</span><?php echo $vets->FemDogsOver75->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vets->AllFeralMaleCats->Visible) { // AllFeralMaleCats ?>
	<tr id="r_AllFeralMaleCats"<?php echo $vets->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vets->AllFeralMaleCats->FldCaption() ?></td>
		<td<?php echo $vets->AllFeralMaleCats->CellAttributes() ?>><span id="el_AllFeralMaleCats">
<input type="text" name="x_AllFeralMaleCats" id="x_AllFeralMaleCats" size="30" maxlength="10" value="<?php echo $vets->AllFeralMaleCats->EditValue ?>"<?php echo $vets->AllFeralMaleCats->EditAttributes() ?>>
</span><?php echo $vets->AllFeralMaleCats->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vets->AllFeralFemaleCats->Visible) { // AllFeralFemaleCats ?>
	<tr id="r_AllFeralFemaleCats"<?php echo $vets->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vets->AllFeralFemaleCats->FldCaption() ?></td>
		<td<?php echo $vets->AllFeralFemaleCats->CellAttributes() ?>><span id="el_AllFeralFemaleCats">
<input type="text" name="x_AllFeralFemaleCats" id="x_AllFeralFemaleCats" size="30" maxlength="10" value="<?php echo $vets->AllFeralFemaleCats->EditValue ?>"<?php echo $vets->AllFeralFemaleCats->EditAttributes() ?>>
</span><?php echo $vets->AllFeralFemaleCats->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vets->Comments->Visible) { // Comments ?>
	<tr id="r_Comments"<?php echo $vets->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vets->Comments->FldCaption() ?></td>
		<td<?php echo $vets->Comments->CellAttributes() ?>><span id="el_Comments">
<input type="text" name="x_Comments" id="x_Comments" size="30" maxlength="100" value="<?php echo $vets->Comments->EditValue ?>"<?php echo $vets->Comments->EditAttributes() ?>>
</span><?php echo $vets->Comments->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vets->Active->Visible) { // Active ?>
	<tr id="r_Active"<?php echo $vets->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vets->Active->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $vets->Active->CellAttributes() ?>><span id="el_Active">
<input type="text" name="x_Active" id="x_Active" size="30" maxlength="1" value="<?php echo $vets->Active->EditValue ?>"<?php echo $vets->Active->EditAttributes() ?>>
</span><?php echo $vets->Active->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("AddBtn")) ?>">
</form>
<?php
$vets_add->ShowPageFooter();
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
$vets_add->Page_Terminate();
?>
<?php

//
// Page class
//
class cvets_add {

	// Page ID
	var $PageID = 'add';

	// Table name
	var $TableName = 'vets';

	// Page object name
	var $PageObjName = 'vets_add';

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
	function cvets_add() {
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
			define("EW_PAGE_ID", 'add', TRUE);

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
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $Priv = 0;
	var $OldRecordset;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $vets;

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$vets->CurrentAction = $_POST["a_add"]; // Get form action
			$this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values

			// Validate form
			if (!$this->ValidateForm()) {
				$vets->CurrentAction = "I"; // Form error, reset action
				$vets->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		} else { // Not post back

			// Load key values from QueryString
			$bCopy = TRUE;
			if (@$_GET["id"] != "") {
				$vets->id->setQueryStringValue($_GET["id"]);
				$vets->setKey("id", $vets->id->CurrentValue); // Set up key
			} else {
				$vets->setKey("id", ""); // Clear key
				$bCopy = FALSE;
			}
			if ($bCopy) {
				$vets->CurrentAction = "C"; // Copy record
			} else {
				$vets->CurrentAction = "I"; // Display blank record
				$this->LoadDefaultValues(); // Load default values
			}
		}

		// Perform action based on action code
		switch ($vets->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("vetslist.php"); // No matching record, return to list
				}
				break;
			case "A": // ' Add new record
				$vets->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $vets->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "vetsview.php")
						$sReturnUrl = $vets->ViewUrl(); // View paging, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$vets->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
		$vets->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $vets;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		global $vets;
		$vets->CountyServed->CurrentValue = NULL;
		$vets->CountyServed->OldValue = $vets->CountyServed->CurrentValue;
		$vets->Clinic->CurrentValue = NULL;
		$vets->Clinic->OldValue = $vets->Clinic->CurrentValue;
		$vets->Vet->CurrentValue = NULL;
		$vets->Vet->OldValue = $vets->Vet->CurrentValue;
		$vets->Address->CurrentValue = NULL;
		$vets->Address->OldValue = $vets->Address->CurrentValue;
		$vets->MailingAddress->CurrentValue = NULL;
		$vets->MailingAddress->OldValue = $vets->MailingAddress->CurrentValue;
		$vets->City->CurrentValue = NULL;
		$vets->City->OldValue = $vets->City->CurrentValue;
		$vets->Zip->CurrentValue = NULL;
		$vets->Zip->OldValue = $vets->Zip->CurrentValue;
		$vets->County->CurrentValue = NULL;
		$vets->County->OldValue = $vets->County->CurrentValue;
		$vets->Phone->CurrentValue = NULL;
		$vets->Phone->OldValue = $vets->Phone->CurrentValue;
		$vets->Fax->CurrentValue = NULL;
		$vets->Fax->OldValue = $vets->Fax->CurrentValue;
		$vets->AllCatsFee->CurrentValue = NULL;
		$vets->AllCatsFee->OldValue = $vets->AllCatsFee->CurrentValue;
		$vets->AllMaleDogs->CurrentValue = NULL;
		$vets->AllMaleDogs->OldValue = $vets->AllMaleDogs->CurrentValue;
		$vets->FemDogsUnder75->CurrentValue = NULL;
		$vets->FemDogsUnder75->OldValue = $vets->FemDogsUnder75->CurrentValue;
		$vets->FemDogsOver75->CurrentValue = NULL;
		$vets->FemDogsOver75->OldValue = $vets->FemDogsOver75->CurrentValue;
		$vets->AllFeralMaleCats->CurrentValue = NULL;
		$vets->AllFeralMaleCats->OldValue = $vets->AllFeralMaleCats->CurrentValue;
		$vets->AllFeralFemaleCats->CurrentValue = NULL;
		$vets->AllFeralFemaleCats->OldValue = $vets->AllFeralFemaleCats->CurrentValue;
		$vets->Comments->CurrentValue = NULL;
		$vets->Comments->OldValue = $vets->Comments->CurrentValue;
		$vets->Active->CurrentValue = "Y";
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $vets;
		if (!$vets->CountyServed->FldIsDetailKey) {
			$vets->CountyServed->setFormValue($objForm->GetValue("x_CountyServed"));
		}
		if (!$vets->Clinic->FldIsDetailKey) {
			$vets->Clinic->setFormValue($objForm->GetValue("x_Clinic"));
		}
		if (!$vets->Vet->FldIsDetailKey) {
			$vets->Vet->setFormValue($objForm->GetValue("x_Vet"));
		}
		if (!$vets->Address->FldIsDetailKey) {
			$vets->Address->setFormValue($objForm->GetValue("x_Address"));
		}
		if (!$vets->MailingAddress->FldIsDetailKey) {
			$vets->MailingAddress->setFormValue($objForm->GetValue("x_MailingAddress"));
		}
		if (!$vets->City->FldIsDetailKey) {
			$vets->City->setFormValue($objForm->GetValue("x_City"));
		}
		if (!$vets->Zip->FldIsDetailKey) {
			$vets->Zip->setFormValue($objForm->GetValue("x_Zip"));
		}
		if (!$vets->County->FldIsDetailKey) {
			$vets->County->setFormValue($objForm->GetValue("x_County"));
		}
		if (!$vets->Phone->FldIsDetailKey) {
			$vets->Phone->setFormValue($objForm->GetValue("x_Phone"));
		}
		if (!$vets->Fax->FldIsDetailKey) {
			$vets->Fax->setFormValue($objForm->GetValue("x_Fax"));
		}
		if (!$vets->AllCatsFee->FldIsDetailKey) {
			$vets->AllCatsFee->setFormValue($objForm->GetValue("x_AllCatsFee"));
		}
		if (!$vets->AllMaleDogs->FldIsDetailKey) {
			$vets->AllMaleDogs->setFormValue($objForm->GetValue("x_AllMaleDogs"));
		}
		if (!$vets->FemDogsUnder75->FldIsDetailKey) {
			$vets->FemDogsUnder75->setFormValue($objForm->GetValue("x_FemDogsUnder75"));
		}
		if (!$vets->FemDogsOver75->FldIsDetailKey) {
			$vets->FemDogsOver75->setFormValue($objForm->GetValue("x_FemDogsOver75"));
		}
		if (!$vets->AllFeralMaleCats->FldIsDetailKey) {
			$vets->AllFeralMaleCats->setFormValue($objForm->GetValue("x_AllFeralMaleCats"));
		}
		if (!$vets->AllFeralFemaleCats->FldIsDetailKey) {
			$vets->AllFeralFemaleCats->setFormValue($objForm->GetValue("x_AllFeralFemaleCats"));
		}
		if (!$vets->Comments->FldIsDetailKey) {
			$vets->Comments->setFormValue($objForm->GetValue("x_Comments"));
		}
		if (!$vets->Active->FldIsDetailKey) {
			$vets->Active->setFormValue($objForm->GetValue("x_Active"));
		}
		$vets->id->setFormValue($objForm->GetValue("x_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $vets;
		$this->LoadOldRecord();
		$vets->id->CurrentValue = $vets->id->FormValue;
		$vets->CountyServed->CurrentValue = $vets->CountyServed->FormValue;
		$vets->Clinic->CurrentValue = $vets->Clinic->FormValue;
		$vets->Vet->CurrentValue = $vets->Vet->FormValue;
		$vets->Address->CurrentValue = $vets->Address->FormValue;
		$vets->MailingAddress->CurrentValue = $vets->MailingAddress->FormValue;
		$vets->City->CurrentValue = $vets->City->FormValue;
		$vets->Zip->CurrentValue = $vets->Zip->FormValue;
		$vets->County->CurrentValue = $vets->County->FormValue;
		$vets->Phone->CurrentValue = $vets->Phone->FormValue;
		$vets->Fax->CurrentValue = $vets->Fax->FormValue;
		$vets->AllCatsFee->CurrentValue = $vets->AllCatsFee->FormValue;
		$vets->AllMaleDogs->CurrentValue = $vets->AllMaleDogs->FormValue;
		$vets->FemDogsUnder75->CurrentValue = $vets->FemDogsUnder75->FormValue;
		$vets->FemDogsOver75->CurrentValue = $vets->FemDogsOver75->FormValue;
		$vets->AllFeralMaleCats->CurrentValue = $vets->AllFeralMaleCats->FormValue;
		$vets->AllFeralFemaleCats->CurrentValue = $vets->AllFeralFemaleCats->FormValue;
		$vets->Comments->CurrentValue = $vets->Comments->FormValue;
		$vets->Active->CurrentValue = $vets->Active->FormValue;
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

	// Load old record
	function LoadOldRecord() {
		global $vets;

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($vets->getKey("id")) <> "")
			$vets->id->CurrentValue = $vets->getKey("id"); // id
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$vets->CurrentFilter = $vets->KeyFilter();
			$sSql = $vets->SQL();
			$this->OldRecordset = ew_LoadRecordset($sSql);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		}
		return TRUE;
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
		} elseif ($vets->RowType == EW_ROWTYPE_ADD) { // Add row

			// CountyServed
			$vets->CountyServed->EditCustomAttributes = "";
			$vets->CountyServed->EditValue = ew_HtmlEncode($vets->CountyServed->CurrentValue);

			// Clinic
			$vets->Clinic->EditCustomAttributes = "";
			$vets->Clinic->EditValue = ew_HtmlEncode($vets->Clinic->CurrentValue);

			// Vet
			$vets->Vet->EditCustomAttributes = "";
			$vets->Vet->EditValue = ew_HtmlEncode($vets->Vet->CurrentValue);

			// Address
			$vets->Address->EditCustomAttributes = "";
			$vets->Address->EditValue = ew_HtmlEncode($vets->Address->CurrentValue);

			// MailingAddress
			$vets->MailingAddress->EditCustomAttributes = "";
			$vets->MailingAddress->EditValue = ew_HtmlEncode($vets->MailingAddress->CurrentValue);

			// City
			$vets->City->EditCustomAttributes = "";
			$vets->City->EditValue = ew_HtmlEncode($vets->City->CurrentValue);

			// Zip
			$vets->Zip->EditCustomAttributes = "";
			$vets->Zip->EditValue = ew_HtmlEncode($vets->Zip->CurrentValue);

			// County
			$vets->County->EditCustomAttributes = "";
			$vets->County->EditValue = ew_HtmlEncode($vets->County->CurrentValue);

			// Phone
			$vets->Phone->EditCustomAttributes = "";
			$vets->Phone->EditValue = ew_HtmlEncode($vets->Phone->CurrentValue);

			// Fax
			$vets->Fax->EditCustomAttributes = "";
			$vets->Fax->EditValue = ew_HtmlEncode($vets->Fax->CurrentValue);

			// AllCatsFee
			$vets->AllCatsFee->EditCustomAttributes = "";
			$vets->AllCatsFee->EditValue = ew_HtmlEncode($vets->AllCatsFee->CurrentValue);

			// AllMaleDogs
			$vets->AllMaleDogs->EditCustomAttributes = "";
			$vets->AllMaleDogs->EditValue = ew_HtmlEncode($vets->AllMaleDogs->CurrentValue);

			// FemDogsUnder75
			$vets->FemDogsUnder75->EditCustomAttributes = "";
			$vets->FemDogsUnder75->EditValue = ew_HtmlEncode($vets->FemDogsUnder75->CurrentValue);

			// FemDogsOver75
			$vets->FemDogsOver75->EditCustomAttributes = "";
			$vets->FemDogsOver75->EditValue = ew_HtmlEncode($vets->FemDogsOver75->CurrentValue);

			// AllFeralMaleCats
			$vets->AllFeralMaleCats->EditCustomAttributes = "";
			$vets->AllFeralMaleCats->EditValue = ew_HtmlEncode($vets->AllFeralMaleCats->CurrentValue);

			// AllFeralFemaleCats
			$vets->AllFeralFemaleCats->EditCustomAttributes = "";
			$vets->AllFeralFemaleCats->EditValue = ew_HtmlEncode($vets->AllFeralFemaleCats->CurrentValue);

			// Comments
			$vets->Comments->EditCustomAttributes = "";
			$vets->Comments->EditValue = ew_HtmlEncode($vets->Comments->CurrentValue);

			// Active
			$vets->Active->EditCustomAttributes = "";
			$vets->Active->EditValue = ew_HtmlEncode($vets->Active->CurrentValue);

			// Edit refer script
			// CountyServed

			$vets->CountyServed->HrefValue = "";

			// Clinic
			$vets->Clinic->HrefValue = "";

			// Vet
			$vets->Vet->HrefValue = "";

			// Address
			$vets->Address->HrefValue = "";

			// MailingAddress
			$vets->MailingAddress->HrefValue = "";

			// City
			$vets->City->HrefValue = "";

			// Zip
			$vets->Zip->HrefValue = "";

			// County
			$vets->County->HrefValue = "";

			// Phone
			$vets->Phone->HrefValue = "";

			// Fax
			$vets->Fax->HrefValue = "";

			// AllCatsFee
			$vets->AllCatsFee->HrefValue = "";

			// AllMaleDogs
			$vets->AllMaleDogs->HrefValue = "";

			// FemDogsUnder75
			$vets->FemDogsUnder75->HrefValue = "";

			// FemDogsOver75
			$vets->FemDogsOver75->HrefValue = "";

			// AllFeralMaleCats
			$vets->AllFeralMaleCats->HrefValue = "";

			// AllFeralFemaleCats
			$vets->AllFeralFemaleCats->HrefValue = "";

			// Comments
			$vets->Comments->HrefValue = "";

			// Active
			$vets->Active->HrefValue = "";
		}
		if ($vets->RowType == EW_ROWTYPE_ADD ||
			$vets->RowType == EW_ROWTYPE_EDIT ||
			$vets->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$vets->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($vets->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$vets->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError, $vets;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!is_null($vets->CountyServed->FormValue) && $vets->CountyServed->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $vets->CountyServed->FldCaption());
		}
		if (!is_null($vets->Clinic->FormValue) && $vets->Clinic->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $vets->Clinic->FldCaption());
		}
		if (!is_null($vets->Vet->FormValue) && $vets->Vet->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $vets->Vet->FldCaption());
		}
		if (!is_null($vets->Address->FormValue) && $vets->Address->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $vets->Address->FldCaption());
		}
		if (!is_null($vets->MailingAddress->FormValue) && $vets->MailingAddress->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $vets->MailingAddress->FldCaption());
		}
		if (!is_null($vets->City->FormValue) && $vets->City->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $vets->City->FldCaption());
		}
		if (!is_null($vets->Zip->FormValue) && $vets->Zip->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $vets->Zip->FldCaption());
		}
		if (!ew_CheckInteger($vets->Zip->FormValue)) {
			ew_AddMessage($gsFormError, $vets->Zip->FldErrMsg());
		}
		if (!is_null($vets->County->FormValue) && $vets->County->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $vets->County->FldCaption());
		}
		if (!is_null($vets->Active->FormValue) && $vets->Active->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $vets->Active->FldCaption());
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
		global $conn, $Language, $Security, $vets;
		$rsnew = array();

		// CountyServed
		$vets->CountyServed->SetDbValueDef($rsnew, $vets->CountyServed->CurrentValue, "", FALSE);

		// Clinic
		$vets->Clinic->SetDbValueDef($rsnew, $vets->Clinic->CurrentValue, "", FALSE);

		// Vet
		$vets->Vet->SetDbValueDef($rsnew, $vets->Vet->CurrentValue, "", FALSE);

		// Address
		$vets->Address->SetDbValueDef($rsnew, $vets->Address->CurrentValue, "", FALSE);

		// MailingAddress
		$vets->MailingAddress->SetDbValueDef($rsnew, $vets->MailingAddress->CurrentValue, "", FALSE);

		// City
		$vets->City->SetDbValueDef($rsnew, $vets->City->CurrentValue, "", FALSE);

		// Zip
		$vets->Zip->SetDbValueDef($rsnew, $vets->Zip->CurrentValue, 0, FALSE);

		// County
		$vets->County->SetDbValueDef($rsnew, $vets->County->CurrentValue, "", FALSE);

		// Phone
		$vets->Phone->SetDbValueDef($rsnew, $vets->Phone->CurrentValue, NULL, FALSE);

		// Fax
		$vets->Fax->SetDbValueDef($rsnew, $vets->Fax->CurrentValue, NULL, FALSE);

		// AllCatsFee
		$vets->AllCatsFee->SetDbValueDef($rsnew, $vets->AllCatsFee->CurrentValue, NULL, FALSE);

		// AllMaleDogs
		$vets->AllMaleDogs->SetDbValueDef($rsnew, $vets->AllMaleDogs->CurrentValue, NULL, FALSE);

		// FemDogsUnder75
		$vets->FemDogsUnder75->SetDbValueDef($rsnew, $vets->FemDogsUnder75->CurrentValue, NULL, FALSE);

		// FemDogsOver75
		$vets->FemDogsOver75->SetDbValueDef($rsnew, $vets->FemDogsOver75->CurrentValue, NULL, FALSE);

		// AllFeralMaleCats
		$vets->AllFeralMaleCats->SetDbValueDef($rsnew, $vets->AllFeralMaleCats->CurrentValue, NULL, FALSE);

		// AllFeralFemaleCats
		$vets->AllFeralFemaleCats->SetDbValueDef($rsnew, $vets->AllFeralFemaleCats->CurrentValue, NULL, FALSE);

		// Comments
		$vets->Comments->SetDbValueDef($rsnew, $vets->Comments->CurrentValue, NULL, FALSE);

		// Active
		$vets->Active->SetDbValueDef($rsnew, $vets->Active->CurrentValue, "", TRUE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $vets->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $conn->Execute($vets->InsertSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($vets->CancelMessage <> "") {
				$this->setFailureMessage($vets->CancelMessage);
				$vets->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}

		// Get insert id if necessary
		if ($AddRow) {
			$vets->id->setDbValue($conn->Insert_ID());
			$rsnew['id'] = $vets->id->DbValue;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$vets->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
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
