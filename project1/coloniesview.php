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
$colonies_view = new ccolonies_view();
$Page =& $colonies_view;

// Page init
$colonies_view->Page_Init();

// Page main
$colonies_view->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($colonies->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var colonies_view = new ew_Page("colonies_view");

// page properties
colonies_view.PageID = "view"; // page ID
colonies_view.FormID = "fcoloniesview"; // form ID
var EW_PAGE_ID = colonies_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
colonies_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
colonies_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
colonies_view.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php } ?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("View") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $colonies->TableCaption() ?>
&nbsp;&nbsp;<?php $colonies_view->ExportOptions->Render("body"); ?>
</p>
<?php if ($colonies->Export == "") { ?>
<p class="phpmaker">
<a href="<?php echo $colonies_view->ListUrl ?>"><?php echo $Language->Phrase("BackToList") ?></a>&nbsp;
<a href="<?php echo $colonies_view->AddUrl ?>"><?php echo $Language->Phrase("ViewPageAddLink") ?></a>&nbsp;
<a href="<?php echo $colonies_view->EditUrl ?>"><?php echo $Language->Phrase("ViewPageEditLink") ?></a>&nbsp;
<a href="<?php echo $colonies_view->CopyUrl ?>"><?php echo $Language->Phrase("ViewPageCopyLink") ?></a>&nbsp;
<a href="<?php echo $colonies_view->DeleteUrl ?>"><?php echo $Language->Phrase("ViewPageDeleteLink") ?></a>&nbsp;
<a href="voucherslist.php?<?php echo EW_TABLE_SHOW_MASTER ?>=colonies&colony_id=<?php echo urlencode(strval($colonies->colony_id->CurrentValue)) ?>"><?php echo $Language->Phrase("ViewPageDetailLink") ?><?php echo $Language->TablePhrase("vouchers", "TblCaption") ?>
</a>
&nbsp;
<a href="caregiverslist.php?<?php echo EW_TABLE_SHOW_MASTER ?>=colonies&colony_id=<?php echo urlencode(strval($colonies->colony_id->CurrentValue)) ?>"><?php echo $Language->Phrase("ViewPageDetailLink") ?><?php echo $Language->TablePhrase("caregivers", "TblCaption") ?>
</a>
&nbsp;
<?php } ?>
</p>
<?php $colonies_view->ShowPageHeader(); ?>
<?php
$colonies_view->ShowMessage();
?>
<p>
<?php if ($colonies->Export == "") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($colonies_view->Pager)) $colonies_view->Pager = new cPrevNextPager($colonies_view->StartRec, $colonies_view->DisplayRecs, $colonies_view->TotalRecs) ?>
<?php if ($colonies_view->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($colonies_view->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $colonies_view->PageUrl() ?>start=<?php echo $colonies_view->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($colonies_view->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $colonies_view->PageUrl() ?>start=<?php echo $colonies_view->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $colonies_view->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($colonies_view->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $colonies_view->PageUrl() ?>start=<?php echo $colonies_view->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($colonies_view->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $colonies_view->PageUrl() ?>start=<?php echo $colonies_view->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $colonies_view->Pager->PageCount ?></span></td>
	</tr></table>
<?php } else { ?>
	<?php if ($colonies_view->SearchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
<?php } ?>
		</td>
	</tr>
</table>
</form>
<br>
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($colonies->colony_id->Visible) { // colony_id ?>
	<tr id="r_colony_id"<?php echo $colonies->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $colonies->colony_id->FldCaption() ?></td>
		<td<?php echo $colonies->colony_id->CellAttributes() ?>>
<div<?php echo $colonies->colony_id->ViewAttributes() ?>><?php echo $colonies->colony_id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($colonies->colony_name->Visible) { // colony_name ?>
	<tr id="r_colony_name"<?php echo $colonies->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $colonies->colony_name->FldCaption() ?></td>
		<td<?php echo $colonies->colony_name->CellAttributes() ?>>
<div<?php echo $colonies->colony_name->ViewAttributes() ?>><?php echo $colonies->colony_name->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($colonies->colony_address->Visible) { // colony_address ?>
	<tr id="r_colony_address"<?php echo $colonies->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $colonies->colony_address->FldCaption() ?></td>
		<td<?php echo $colonies->colony_address->CellAttributes() ?>>
<div<?php echo $colonies->colony_address->ViewAttributes() ?>><?php echo $colonies->colony_address->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($colonies->colony_aptnum->Visible) { // colony_aptnum ?>
	<tr id="r_colony_aptnum"<?php echo $colonies->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $colonies->colony_aptnum->FldCaption() ?></td>
		<td<?php echo $colonies->colony_aptnum->CellAttributes() ?>>
<div<?php echo $colonies->colony_aptnum->ViewAttributes() ?>><?php echo $colonies->colony_aptnum->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($colonies->colony_city->Visible) { // colony_city ?>
	<tr id="r_colony_city"<?php echo $colonies->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $colonies->colony_city->FldCaption() ?></td>
		<td<?php echo $colonies->colony_city->CellAttributes() ?>>
<div<?php echo $colonies->colony_city->ViewAttributes() ?>><?php echo $colonies->colony_city->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($colonies->colony_county->Visible) { // colony_county ?>
	<tr id="r_colony_county"<?php echo $colonies->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $colonies->colony_county->FldCaption() ?></td>
		<td<?php echo $colonies->colony_county->CellAttributes() ?>>
<div<?php echo $colonies->colony_county->ViewAttributes() ?>><?php echo $colonies->colony_county->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($colonies->colony_zip->Visible) { // colony_zip ?>
	<tr id="r_colony_zip"<?php echo $colonies->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $colonies->colony_zip->FldCaption() ?></td>
		<td<?php echo $colonies->colony_zip->CellAttributes() ?>>
<div<?php echo $colonies->colony_zip->ViewAttributes() ?>><?php echo $colonies->colony_zip->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($colonies->NumVouchIssued->Visible) { // NumVouchIssued ?>
	<tr id="r_NumVouchIssued"<?php echo $colonies->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $colonies->NumVouchIssued->FldCaption() ?></td>
		<td<?php echo $colonies->NumVouchIssued->CellAttributes() ?>>
<div<?php echo $colonies->NumVouchIssued->ViewAttributes() ?>><?php echo $colonies->NumVouchIssued->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($colonies->VoucherStartNum->Visible) { // VoucherStartNum ?>
	<tr id="r_VoucherStartNum"<?php echo $colonies->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $colonies->VoucherStartNum->FldCaption() ?></td>
		<td<?php echo $colonies->VoucherStartNum->CellAttributes() ?>>
<div<?php echo $colonies->VoucherStartNum->ViewAttributes() ?>><?php echo $colonies->VoucherStartNum->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($colonies->VoucherEndNum->Visible) { // VoucherEndNum ?>
	<tr id="r_VoucherEndNum"<?php echo $colonies->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $colonies->VoucherEndNum->FldCaption() ?></td>
		<td<?php echo $colonies->VoucherEndNum->CellAttributes() ?>>
<div<?php echo $colonies->VoucherEndNum->ViewAttributes() ?>><?php echo $colonies->VoucherEndNum->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($colonies->trapper->Visible) { // trapper ?>
	<tr id="r_trapper"<?php echo $colonies->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $colonies->trapper->FldCaption() ?></td>
		<td<?php echo $colonies->trapper->CellAttributes() ?>>
<div<?php echo $colonies->trapper->ViewAttributes() ?>><?php echo $colonies->trapper->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($colonies->notes->Visible) { // notes ?>
	<tr id="r_notes"<?php echo $colonies->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $colonies->notes->FldCaption() ?></td>
		<td<?php echo $colonies->notes->CellAttributes() ?>>
<div<?php echo $colonies->notes->ViewAttributes() ?>><?php echo $colonies->notes->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($colonies->sage->Visible) { // sage ?>
	<tr id="r_sage"<?php echo $colonies->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $colonies->sage->FldCaption() ?></td>
		<td<?php echo $colonies->sage->CellAttributes() ?>>
<div<?php echo $colonies->sage->ViewAttributes() ?>><?php echo $colonies->sage->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($colonies->Inactive->Visible) { // Inactive ?>
	<tr id="r_Inactive"<?php echo $colonies->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $colonies->Inactive->FldCaption() ?></td>
		<td<?php echo $colonies->Inactive->CellAttributes() ?>>
<div<?php echo $colonies->Inactive->ViewAttributes() ?>><?php echo $colonies->Inactive->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($colonies->mod_by->Visible) { // mod_by ?>
	<tr id="r_mod_by"<?php echo $colonies->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $colonies->mod_by->FldCaption() ?></td>
		<td<?php echo $colonies->mod_by->CellAttributes() ?>>
<div<?php echo $colonies->mod_by->ViewAttributes() ?>><?php echo $colonies->mod_by->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($colonies->mod_date->Visible) { // mod_date ?>
	<tr id="r_mod_date"<?php echo $colonies->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $colonies->mod_date->FldCaption() ?></td>
		<td<?php echo $colonies->mod_date->CellAttributes() ?>>
<div<?php echo $colonies->mod_date->ViewAttributes() ?>><?php echo $colonies->mod_date->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<?php if ($colonies->Export == "") { ?>
<br>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($colonies_view->Pager)) $colonies_view->Pager = new cPrevNextPager($colonies_view->StartRec, $colonies_view->DisplayRecs, $colonies_view->TotalRecs) ?>
<?php if ($colonies_view->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($colonies_view->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $colonies_view->PageUrl() ?>start=<?php echo $colonies_view->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($colonies_view->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $colonies_view->PageUrl() ?>start=<?php echo $colonies_view->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $colonies_view->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($colonies_view->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $colonies_view->PageUrl() ?>start=<?php echo $colonies_view->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($colonies_view->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $colonies_view->PageUrl() ?>start=<?php echo $colonies_view->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $colonies_view->Pager->PageCount ?></span></td>
	</tr></table>
<?php } else { ?>
	<?php if ($colonies_view->SearchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
<?php } ?>
		</td>
	</tr>
</table>
</form>
<?php } ?>
<p>
<?php
$colonies_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($colonies->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$colonies_view->Page_Terminate();
?>
<?php

//
// Page class
//
class ccolonies_view {

	// Page ID
	var $PageID = 'view';

	// Table name
	var $TableName = 'colonies';

	// Page object name
	var $PageObjName = 'colonies_view';

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
	function ccolonies_view() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (colonies)
		if (!isset($GLOBALS["colonies"])) {
			$GLOBALS["colonies"] = new ccolonies();
			$GLOBALS["Table"] =& $GLOBALS["colonies"];
		}
		$KeyUrl = "";
		if (@$_GET["colony_id"] <> "") {
			$this->RecKey["colony_id"] = $_GET["colony_id"];
			$KeyUrl .= "&colony_id=" . urlencode($this->RecKey["colony_id"]);
		}
		if (@$_GET["colony_name"] <> "") {
			$this->RecKey["colony_name"] = $_GET["colony_name"];
			$KeyUrl .= "&colony_name=" . urlencode($this->RecKey["colony_name"]);
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
			define("EW_TABLE_NAME", 'colonies', TRUE);

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
		global $colonies;

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$colonies->Export = $_GET["export"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$colonies->Export = $_POST["exporttype"];
		} else {
			$colonies->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExport = $colonies->Export; // Get export parameter, used in header
		$gsExportFile = $colonies->TableVar; // Get export file, used in header
		$Charset = (EW_CHARSET <> "") ? ";charset=" . EW_CHARSET : ""; // Charset used in header
		if (@$_GET["colony_id"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["colony_id"]);
		}
		if (@$_GET["colony_name"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["colony_name"]);
		}
		if ($colonies->Export == "csv") {
			header('Content-Type: application/csv' . $Charset);
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.csv');
		}

		// Setup export options
		$this->SetupExportOptions();

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
		global $Language, $colonies;

		// Load current record
		$bLoadCurrentRecord = FALSE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["colony_id"] <> "") {
				$colonies->colony_id->setQueryStringValue($_GET["colony_id"]);
				$this->RecKey["colony_id"] = $colonies->colony_id->QueryStringValue;
			} else {
				$bLoadCurrentRecord = TRUE;
			}
			if (@$_GET["colony_name"] <> "") {
				$colonies->colony_name->setQueryStringValue($_GET["colony_name"]);
				$this->RecKey["colony_name"] = $colonies->colony_name->QueryStringValue;
			} else {
				$bLoadCurrentRecord = TRUE;
			}

			// Get action
			$colonies->CurrentAction = "I"; // Display form
			switch ($colonies->CurrentAction) {
				case "I": // Get a record to display
					$this->StartRec = 1; // Initialize start position
					if ($this->Recordset = $this->LoadRecordset()) // Load records
						$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
					if ($this->TotalRecs <= 0) { // No record found
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$this->Page_Terminate("colonieslist.php"); // Return to list page
					} elseif ($bLoadCurrentRecord) { // Load current record position
						$this->SetUpStartRec(); // Set up start record position

						// Point to current record
						if (intval($this->StartRec) <= intval($this->TotalRecs)) {
							$bMatchRecord = TRUE;
							$this->Recordset->Move($this->StartRec-1);
						}
					} else { // Match key values
						while (!$this->Recordset->EOF) {
							if (strval($colonies->colony_id->CurrentValue) == strval($this->Recordset->fields('colony_id')) AND strval($colonies->colony_name->CurrentValue) == strval($this->Recordset->fields('colony_name'))) {
								$colonies->setStartRecordNumber($this->StartRec); // Save record position
								$bMatchRecord = TRUE;
								break;
							} else {
								$this->StartRec++;
								$this->Recordset->MoveNext();
							}
						}
					}
					if (!$bMatchRecord) {
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "colonieslist.php"; // No matching record, return to list
					} else {
						$this->LoadRowValues($this->Recordset); // Load row values
					}
			}

			// Export data only
			if (in_array($colonies->Export, array("html","word","excel","xml","csv","email","pdf"))) {
				$this->ExportData();
				if ($colonies->Export <> "email")
					$this->Page_Terminate(); // Terminate response
				exit();
			}
		} else {
			$sReturnUrl = "colonieslist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$colonies->RowType = EW_ROWTYPE_VIEW;
		$colonies->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $colonies;
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$colonies->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$colonies->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $colonies->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$colonies->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$colonies->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$colonies->setStartRecordNumber($this->StartRec);
		}
	}

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
		$this->AddUrl = $colonies->AddUrl();
		$this->EditUrl = $colonies->EditUrl();
		$this->CopyUrl = $colonies->CopyUrl();
		$this->DeleteUrl = $colonies->DeleteUrl();
		$this->ListUrl = $colonies->ListUrl();

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

	// Set up export options
	function SetupExportOptions() {
		global $Language, $colonies;

		// Printer friendly
		$item =& $this->ExportOptions->Add("print");
		$item->Body = "<a href=\"" . $this->ExportPrintUrl . "\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = FALSE;

		// Export to Excel
		$item =& $this->ExportOptions->Add("excel");
		$item->Body = "<a href=\"" . $this->ExportExcelUrl . "\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = FALSE;

		// Export to Word
		$item =& $this->ExportOptions->Add("word");
		$item->Body = "<a href=\"" . $this->ExportWordUrl . "\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = FALSE;

		// Export to Html
		$item =& $this->ExportOptions->Add("html");
		$item->Body = "<a href=\"" . $this->ExportHtmlUrl . "\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = FALSE;

		// Export to Xml
		$item =& $this->ExportOptions->Add("xml");
		$item->Body = "<a href=\"" . $this->ExportXmlUrl . "\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = FALSE;

		// Export to Csv
		$item =& $this->ExportOptions->Add("csv");
		$item->Body = "<a href=\"" . $this->ExportCsvUrl . "\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = TRUE;

		// Export to Pdf
		$item =& $this->ExportOptions->Add("pdf");
		$item->Body = "<a href=\"" . $this->ExportPdfUrl . "\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = FALSE;

		// Export to Email
		$item =& $this->ExportOptions->Add("email");
		$item->Body = "<a name=\"emf_colonies\" id=\"emf_colonies\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_colonies',hdr:ewLanguage.Phrase('ExportToEmail'),key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
		$item->Visible = FALSE;

		// Hide options for export/action
		if ($colonies->Export <> "")
			$this->ExportOptions->HideAllOptions();
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		global $colonies;
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = FALSE;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $colonies->SelectRecordCount();
		} else {
			if ($rs = $this->LoadRecordset())
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;
		$this->SetUpStartRec(); // Set up start record position

		// Set the last record to display
		if ($this->DisplayRecs < 0) {
			$this->StopRec = $this->TotalRecs;
		} else {
			$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
		}
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		if ($colonies->Export == "xml") {
			$XmlDoc = new cXMLDocument(EW_XML_ENCODING);
		} else {
			$ExportDoc = new cExportDocument($colonies, "v");
		}
		$ParentTable = "";
		if ($bSelectLimit) {
			$StartRec = 1;
			$StopRec = $this->DisplayRecs;
		} else {
			$StartRec = $this->StartRec;
			$StopRec = $this->StopRec;
		}
		if ($colonies->Export == "xml") {
			$colonies->ExportXmlDocument($XmlDoc, ($ParentTable <> ""), $rs, $StartRec, $StopRec, "view");
		} else {
			$sHeader = $this->PageHeader;
			$this->Page_DataRendering($sHeader);
			$ExportDoc->Text .= $sHeader;
			$colonies->ExportDocument($ExportDoc, $rs, $StartRec, $StopRec, "view");
			$sFooter = $this->PageFooter;
			$this->Page_DataRendered($sFooter);
			$ExportDoc->Text .= $sFooter;
		}

		// Close recordset
		$rs->Close();

		// Export header and footer
		if ($colonies->Export <> "xml") {
			$ExportDoc->ExportHeaderAndFooter();
		}

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write BOM if utf-8
		if ($utf8 && !in_array($colonies->Export, array("email", "xml")))
			echo "\xEF\xBB\xBF";

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED)
			echo ew_DebugMsg();

		// Output data
		if ($colonies->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} elseif ($colonies->Export == "email") {
			$this->ExportEmail($ExportDoc->Text);
			$this->Page_Terminate($colonies->ExportReturnUrl());
		} elseif ($colonies->Export == "pdf") {
			$this->ExportPDF($ExportDoc->Text);
		} else {
			echo $ExportDoc->Text;
		}
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
