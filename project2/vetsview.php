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
$vets_view = new cvets_view();
$Page =& $vets_view;

// Page init
$vets_view->Page_Init();

// Page main
$vets_view->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($vets->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var vets_view = new ew_Page("vets_view");

// page properties
vets_view.PageID = "view"; // page ID
vets_view.FormID = "fvetsview"; // form ID
var EW_PAGE_ID = vets_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
vets_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
vets_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
vets_view.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php } ?>
<?php $vets_view->ShowPageHeader(); ?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("View") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $vets->TableCaption() ?>
&nbsp;&nbsp;<?php $vets_view->ExportOptions->Render("body"); ?>
</p>
<?php if ($vets->Export == "") { ?>
<p class="phpmaker">
<a href="<?php echo $vets_view->ListUrl ?>"><?php echo $Language->Phrase("BackToList") ?></a>&nbsp;
<a href="<?php echo $vets_view->AddUrl ?>"><?php echo $Language->Phrase("ViewPageAddLink") ?></a>&nbsp;
<a href="<?php echo $vets_view->EditUrl ?>"><?php echo $Language->Phrase("ViewPageEditLink") ?></a>&nbsp;
<a href="<?php echo $vets_view->CopyUrl ?>"><?php echo $Language->Phrase("ViewPageCopyLink") ?></a>&nbsp;
<a href="<?php echo $vets_view->DeleteUrl ?>"><?php echo $Language->Phrase("ViewPageDeleteLink") ?></a>&nbsp;
<?php } ?>
</p>
<?php
$vets_view->ShowMessage();
?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($vets->id->Visible) { // id ?>
	<tr id="r_id"<?php echo $vets->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vets->id->FldCaption() ?></td>
		<td<?php echo $vets->id->CellAttributes() ?>>
<div<?php echo $vets->id->ViewAttributes() ?>><?php echo $vets->id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vets->CountyServed->Visible) { // CountyServed ?>
	<tr id="r_CountyServed"<?php echo $vets->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vets->CountyServed->FldCaption() ?></td>
		<td<?php echo $vets->CountyServed->CellAttributes() ?>>
<div<?php echo $vets->CountyServed->ViewAttributes() ?>><?php echo $vets->CountyServed->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vets->Clinic->Visible) { // Clinic ?>
	<tr id="r_Clinic"<?php echo $vets->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vets->Clinic->FldCaption() ?></td>
		<td<?php echo $vets->Clinic->CellAttributes() ?>>
<div<?php echo $vets->Clinic->ViewAttributes() ?>><?php echo $vets->Clinic->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vets->Vet->Visible) { // Vet ?>
	<tr id="r_Vet"<?php echo $vets->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vets->Vet->FldCaption() ?></td>
		<td<?php echo $vets->Vet->CellAttributes() ?>>
<div<?php echo $vets->Vet->ViewAttributes() ?>><?php echo $vets->Vet->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vets->Address->Visible) { // Address ?>
	<tr id="r_Address"<?php echo $vets->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vets->Address->FldCaption() ?></td>
		<td<?php echo $vets->Address->CellAttributes() ?>>
<div<?php echo $vets->Address->ViewAttributes() ?>><?php echo $vets->Address->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vets->MailingAddress->Visible) { // MailingAddress ?>
	<tr id="r_MailingAddress"<?php echo $vets->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vets->MailingAddress->FldCaption() ?></td>
		<td<?php echo $vets->MailingAddress->CellAttributes() ?>>
<div<?php echo $vets->MailingAddress->ViewAttributes() ?>><?php echo $vets->MailingAddress->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vets->City->Visible) { // City ?>
	<tr id="r_City"<?php echo $vets->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vets->City->FldCaption() ?></td>
		<td<?php echo $vets->City->CellAttributes() ?>>
<div<?php echo $vets->City->ViewAttributes() ?>><?php echo $vets->City->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vets->Zip->Visible) { // Zip ?>
	<tr id="r_Zip"<?php echo $vets->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vets->Zip->FldCaption() ?></td>
		<td<?php echo $vets->Zip->CellAttributes() ?>>
<div<?php echo $vets->Zip->ViewAttributes() ?>><?php echo $vets->Zip->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vets->County->Visible) { // County ?>
	<tr id="r_County"<?php echo $vets->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vets->County->FldCaption() ?></td>
		<td<?php echo $vets->County->CellAttributes() ?>>
<div<?php echo $vets->County->ViewAttributes() ?>><?php echo $vets->County->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vets->Phone->Visible) { // Phone ?>
	<tr id="r_Phone"<?php echo $vets->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vets->Phone->FldCaption() ?></td>
		<td<?php echo $vets->Phone->CellAttributes() ?>>
<div<?php echo $vets->Phone->ViewAttributes() ?>><?php echo $vets->Phone->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vets->Fax->Visible) { // Fax ?>
	<tr id="r_Fax"<?php echo $vets->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vets->Fax->FldCaption() ?></td>
		<td<?php echo $vets->Fax->CellAttributes() ?>>
<div<?php echo $vets->Fax->ViewAttributes() ?>><?php echo $vets->Fax->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vets->AllCatsFee->Visible) { // AllCatsFee ?>
	<tr id="r_AllCatsFee"<?php echo $vets->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vets->AllCatsFee->FldCaption() ?></td>
		<td<?php echo $vets->AllCatsFee->CellAttributes() ?>>
<div<?php echo $vets->AllCatsFee->ViewAttributes() ?>><?php echo $vets->AllCatsFee->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vets->AllMaleDogs->Visible) { // AllMaleDogs ?>
	<tr id="r_AllMaleDogs"<?php echo $vets->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vets->AllMaleDogs->FldCaption() ?></td>
		<td<?php echo $vets->AllMaleDogs->CellAttributes() ?>>
<div<?php echo $vets->AllMaleDogs->ViewAttributes() ?>><?php echo $vets->AllMaleDogs->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vets->FemDogsUnder75->Visible) { // FemDogsUnder75 ?>
	<tr id="r_FemDogsUnder75"<?php echo $vets->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vets->FemDogsUnder75->FldCaption() ?></td>
		<td<?php echo $vets->FemDogsUnder75->CellAttributes() ?>>
<div<?php echo $vets->FemDogsUnder75->ViewAttributes() ?>><?php echo $vets->FemDogsUnder75->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vets->FemDogsOver75->Visible) { // FemDogsOver75 ?>
	<tr id="r_FemDogsOver75"<?php echo $vets->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vets->FemDogsOver75->FldCaption() ?></td>
		<td<?php echo $vets->FemDogsOver75->CellAttributes() ?>>
<div<?php echo $vets->FemDogsOver75->ViewAttributes() ?>><?php echo $vets->FemDogsOver75->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vets->AllFeralMaleCats->Visible) { // AllFeralMaleCats ?>
	<tr id="r_AllFeralMaleCats"<?php echo $vets->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vets->AllFeralMaleCats->FldCaption() ?></td>
		<td<?php echo $vets->AllFeralMaleCats->CellAttributes() ?>>
<div<?php echo $vets->AllFeralMaleCats->ViewAttributes() ?>><?php echo $vets->AllFeralMaleCats->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vets->AllFeralFemaleCats->Visible) { // AllFeralFemaleCats ?>
	<tr id="r_AllFeralFemaleCats"<?php echo $vets->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vets->AllFeralFemaleCats->FldCaption() ?></td>
		<td<?php echo $vets->AllFeralFemaleCats->CellAttributes() ?>>
<div<?php echo $vets->AllFeralFemaleCats->ViewAttributes() ?>><?php echo $vets->AllFeralFemaleCats->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vets->Comments->Visible) { // Comments ?>
	<tr id="r_Comments"<?php echo $vets->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vets->Comments->FldCaption() ?></td>
		<td<?php echo $vets->Comments->CellAttributes() ?>>
<div<?php echo $vets->Comments->ViewAttributes() ?>><?php echo $vets->Comments->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vets->Active->Visible) { // Active ?>
	<tr id="r_Active"<?php echo $vets->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vets->Active->FldCaption() ?></td>
		<td<?php echo $vets->Active->CellAttributes() ?>>
<div<?php echo $vets->Active->ViewAttributes() ?>><?php echo $vets->Active->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php
$vets_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($vets->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$vets_view->Page_Terminate();
?>
<?php

//
// Page class
//
class cvets_view {

	// Page ID
	var $PageID = 'view';

	// Table name
	var $TableName = 'vets';

	// Page object name
	var $PageObjName = 'vets_view';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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
	function cvets_view() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (vets)
		if (!isset($GLOBALS["vets"])) {
			$GLOBALS["vets"] = new cvets();
			$GLOBALS["Table"] =& $GLOBALS["vets"];
		}
		$KeyUrl = "";
		if (@$_GET["id"] <> "") {
			$this->RecKey["id"] = $_GET["id"];
			$KeyUrl .= "&id=" . urlencode($this->RecKey["id"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'vets', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "span";
		$this->ExportOptions->Separator = "&nbsp;&nbsp;";
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
	var $ExportOptions; // Export options
	var $DisplayRecs = 1;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $RecCnt;
	var $RecKey = array();
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $Language, $vets;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["id"] <> "") {
				$vets->id->setQueryStringValue($_GET["id"]);
				$this->RecKey["id"] = $vets->id->QueryStringValue;
			} else {
				$sReturnUrl = "vetslist.php"; // Return to list
			}

			// Get action
			$vets->CurrentAction = "I"; // Display form
			switch ($vets->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "vetslist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "vetslist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$vets->RowType = EW_ROWTYPE_VIEW;
		$vets->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $vets;
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$vets->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$vets->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $vets->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$vets->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$vets->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$vets->setStartRecordNumber($this->StartRec);
		}
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
		$this->AddUrl = $vets->AddUrl();
		$this->EditUrl = $vets->EditUrl();
		$this->CopyUrl = $vets->CopyUrl();
		$this->DeleteUrl = $vets->DeleteUrl();
		$this->ListUrl = $vets->ListUrl();

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

	// PDF Export
	function ExportPDF($html) {
		echo($html);
		ew_DeleteTmpImages();
		exit();
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
