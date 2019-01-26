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
$vouchers_view = new cvouchers_view();
$Page =& $vouchers_view;

// Page init
$vouchers_view->Page_Init();

// Page main
$vouchers_view->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($vouchers->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var vouchers_view = new ew_Page("vouchers_view");

// page properties
vouchers_view.PageID = "view"; // page ID
vouchers_view.FormID = "fvouchersview"; // form ID
var EW_PAGE_ID = vouchers_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
vouchers_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
vouchers_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
vouchers_view.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php } ?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("View") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $vouchers->TableCaption() ?>
&nbsp;&nbsp;<?php $vouchers_view->ExportOptions->Render("body"); ?>
</p>
<?php if ($vouchers->Export == "") { ?>
<p class="phpmaker">
<a href="<?php echo $vouchers_view->ListUrl ?>"><?php echo $Language->Phrase("BackToList") ?></a>&nbsp;
<a href="<?php echo $vouchers_view->AddUrl ?>"><?php echo $Language->Phrase("ViewPageAddLink") ?></a>&nbsp;
<a href="<?php echo $vouchers_view->EditUrl ?>"><?php echo $Language->Phrase("ViewPageEditLink") ?></a>&nbsp;
<a href="<?php echo $vouchers_view->CopyUrl ?>"><?php echo $Language->Phrase("ViewPageCopyLink") ?></a>&nbsp;
<a href="<?php echo $vouchers_view->DeleteUrl ?>"><?php echo $Language->Phrase("ViewPageDeleteLink") ?></a>&nbsp;
<?php } ?>
</p>
<?php $vouchers_view->ShowPageHeader(); ?>
<?php
$vouchers_view->ShowMessage();
?>
<p>
<?php if ($vouchers->Export == "") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($vouchers_view->Pager)) $vouchers_view->Pager = new cPrevNextPager($vouchers_view->StartRec, $vouchers_view->DisplayRecs, $vouchers_view->TotalRecs) ?>
<?php if ($vouchers_view->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($vouchers_view->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $vouchers_view->PageUrl() ?>start=<?php echo $vouchers_view->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($vouchers_view->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $vouchers_view->PageUrl() ?>start=<?php echo $vouchers_view->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $vouchers_view->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($vouchers_view->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $vouchers_view->PageUrl() ?>start=<?php echo $vouchers_view->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($vouchers_view->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $vouchers_view->PageUrl() ?>start=<?php echo $vouchers_view->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $vouchers_view->Pager->PageCount ?></span></td>
	</tr></table>
<?php } else { ?>
	<?php if ($vouchers_view->SearchWhere == "0=101") { ?>
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
<?php if ($vouchers->id->Visible) { // id ?>
	<tr id="r_id"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->id->FldCaption() ?></td>
		<td<?php echo $vouchers->id->CellAttributes() ?>>
<div<?php echo $vouchers->id->ViewAttributes() ?>><?php echo $vouchers->id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vouchers->VoucherNumber->Visible) { // VoucherNumber ?>
	<tr id="r_VoucherNumber"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->VoucherNumber->FldCaption() ?></td>
		<td<?php echo $vouchers->VoucherNumber->CellAttributes() ?>>
<div<?php echo $vouchers->VoucherNumber->ViewAttributes() ?>><?php echo $vouchers->VoucherNumber->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vouchers->ExpireDate->Visible) { // ExpireDate ?>
	<tr id="r_ExpireDate"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->ExpireDate->FldCaption() ?></td>
		<td<?php echo $vouchers->ExpireDate->CellAttributes() ?>>
<div<?php echo $vouchers->ExpireDate->ViewAttributes() ?>><?php echo $vouchers->ExpireDate->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vouchers->IssuedByFirst->Visible) { // IssuedByFirst ?>
	<tr id="r_IssuedByFirst"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->IssuedByFirst->FldCaption() ?></td>
		<td<?php echo $vouchers->IssuedByFirst->CellAttributes() ?>>
<div<?php echo $vouchers->IssuedByFirst->ViewAttributes() ?>><?php echo $vouchers->IssuedByFirst->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vouchers->IssuedByLast->Visible) { // IssuedByLast ?>
	<tr id="r_IssuedByLast"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->IssuedByLast->FldCaption() ?></td>
		<td<?php echo $vouchers->IssuedByLast->CellAttributes() ?>>
<div<?php echo $vouchers->IssuedByLast->ViewAttributes() ?>><?php echo $vouchers->IssuedByLast->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vouchers->FirstName->Visible) { // FirstName ?>
	<tr id="r_FirstName"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->FirstName->FldCaption() ?></td>
		<td<?php echo $vouchers->FirstName->CellAttributes() ?>>
<div<?php echo $vouchers->FirstName->ViewAttributes() ?>><?php echo $vouchers->FirstName->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vouchers->LastName->Visible) { // LastName ?>
	<tr id="r_LastName"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->LastName->FldCaption() ?></td>
		<td<?php echo $vouchers->LastName->CellAttributes() ?>>
<div<?php echo $vouchers->LastName->ViewAttributes() ?>><?php echo $vouchers->LastName->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vouchers->Program->Visible) { // Program ?>
	<tr id="r_Program"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->Program->FldCaption() ?></td>
		<td<?php echo $vouchers->Program->CellAttributes() ?>>
<div<?php echo $vouchers->Program->ViewAttributes() ?>><?php echo $vouchers->Program->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vouchers->cat_name->Visible) { // cat_name ?>
	<tr id="r_cat_name"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->cat_name->FldCaption() ?></td>
		<td<?php echo $vouchers->cat_name->CellAttributes() ?>>
<div<?php echo $vouchers->cat_name->ViewAttributes() ?>><?php echo $vouchers->cat_name->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vouchers->cat_breed->Visible) { // cat_breed ?>
	<tr id="r_cat_breed"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->cat_breed->FldCaption() ?></td>
		<td<?php echo $vouchers->cat_breed->CellAttributes() ?>>
<div<?php echo $vouchers->cat_breed->ViewAttributes() ?>><?php echo $vouchers->cat_breed->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vouchers->cat_age->Visible) { // cat_age ?>
	<tr id="r_cat_age"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->cat_age->FldCaption() ?></td>
		<td<?php echo $vouchers->cat_age->CellAttributes() ?>>
<div<?php echo $vouchers->cat_age->ViewAttributes() ?>><?php echo $vouchers->cat_age->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vouchers->copay->Visible) { // copay ?>
	<tr id="r_copay"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->copay->FldCaption() ?></td>
		<td<?php echo $vouchers->copay->CellAttributes() ?>>
<div<?php echo $vouchers->copay->ViewAttributes() ?>><?php echo $vouchers->copay->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vouchers->cat_status->Visible) { // cat_status ?>
	<tr id="r_cat_status"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->cat_status->FldCaption() ?></td>
		<td<?php echo $vouchers->cat_status->CellAttributes() ?>>
<div<?php echo $vouchers->cat_status->ViewAttributes() ?>><?php echo $vouchers->cat_status->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vouchers->date_redeemed->Visible) { // date_redeemed ?>
	<tr id="r_date_redeemed"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->date_redeemed->FldCaption() ?></td>
		<td<?php echo $vouchers->date_redeemed->CellAttributes() ?>>
<div<?php echo $vouchers->date_redeemed->ViewAttributes() ?>><?php echo $vouchers->date_redeemed->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vouchers->Clinic->Visible) { // Clinic ?>
	<tr id="r_Clinic"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->Clinic->FldCaption() ?></td>
		<td<?php echo $vouchers->Clinic->CellAttributes() ?>>
<div<?php echo $vouchers->Clinic->ViewAttributes() ?>><?php echo $vouchers->Clinic->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vouchers->ClinicPrice->Visible) { // ClinicPrice ?>
	<tr id="r_ClinicPrice"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->ClinicPrice->FldCaption() ?></td>
		<td<?php echo $vouchers->ClinicPrice->CellAttributes() ?>>
<div<?php echo $vouchers->ClinicPrice->ViewAttributes() ?>><?php echo $vouchers->ClinicPrice->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vouchers->vet_used->Visible) { // vet_used ?>
	<tr id="r_vet_used"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->vet_used->FldCaption() ?></td>
		<td<?php echo $vouchers->vet_used->CellAttributes() ?>>
<div<?php echo $vouchers->vet_used->ViewAttributes() ?>><?php echo $vouchers->vet_used->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vouchers->colony_id->Visible) { // colony_id ?>
	<tr id="r_colony_id"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->colony_id->FldCaption() ?></td>
		<td<?php echo $vouchers->colony_id->CellAttributes() ?>>
<div<?php echo $vouchers->colony_id->ViewAttributes() ?>><?php echo $vouchers->colony_id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vouchers->Spay->Visible) { // Spay ?>
	<tr id="r_Spay"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->Spay->FldCaption() ?></td>
		<td<?php echo $vouchers->Spay->CellAttributes() ?>>
<div<?php echo $vouchers->Spay->ViewAttributes() ?>><?php echo $vouchers->Spay->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vouchers->Neuter->Visible) { // Neuter ?>
	<tr id="r_Neuter"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->Neuter->FldCaption() ?></td>
		<td<?php echo $vouchers->Neuter->CellAttributes() ?>>
<div<?php echo $vouchers->Neuter->ViewAttributes() ?>><?php echo $vouchers->Neuter->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vouchers->FVRCP->Visible) { // FVRCP ?>
	<tr id="r_FVRCP"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->FVRCP->FldCaption() ?></td>
		<td<?php echo $vouchers->FVRCP->CellAttributes() ?>>
<div<?php echo $vouchers->FVRCP->ViewAttributes() ?>><?php echo $vouchers->FVRCP->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vouchers->FELV->Visible) { // FELV ?>
	<tr id="r_FELV"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->FELV->FldCaption() ?></td>
		<td<?php echo $vouchers->FELV->CellAttributes() ?>>
<div<?php echo $vouchers->FELV->ViewAttributes() ?>><?php echo $vouchers->FELV->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vouchers->Rabies->Visible) { // Rabies ?>
	<tr id="r_Rabies"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->Rabies->FldCaption() ?></td>
		<td<?php echo $vouchers->Rabies->CellAttributes() ?>>
<div<?php echo $vouchers->Rabies->ViewAttributes() ?>><?php echo $vouchers->Rabies->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vouchers->Pregnant->Visible) { // Pregnant ?>
	<tr id="r_Pregnant"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->Pregnant->FldCaption() ?></td>
		<td<?php echo $vouchers->Pregnant->CellAttributes() ?>>
<div<?php echo $vouchers->Pregnant->ViewAttributes() ?>><?php echo $vouchers->Pregnant->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vouchers->AssignedTo->Visible) { // AssignedTo ?>
	<tr id="r_AssignedTo"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->AssignedTo->FldCaption() ?></td>
		<td<?php echo $vouchers->AssignedTo->CellAttributes() ?>>
<div<?php echo $vouchers->AssignedTo->ViewAttributes() ?>><?php echo $vouchers->AssignedTo->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vouchers->mod_by->Visible) { // mod_by ?>
	<tr id="r_mod_by"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->mod_by->FldCaption() ?></td>
		<td<?php echo $vouchers->mod_by->CellAttributes() ?>>
<div<?php echo $vouchers->mod_by->ViewAttributes() ?>><?php echo $vouchers->mod_by->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($vouchers->mod_date->Visible) { // mod_date ?>
	<tr id="r_mod_date"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->mod_date->FldCaption() ?></td>
		<td<?php echo $vouchers->mod_date->CellAttributes() ?>>
<div<?php echo $vouchers->mod_date->ViewAttributes() ?>><?php echo $vouchers->mod_date->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<?php if ($vouchers->Export == "") { ?>
<br>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($vouchers_view->Pager)) $vouchers_view->Pager = new cPrevNextPager($vouchers_view->StartRec, $vouchers_view->DisplayRecs, $vouchers_view->TotalRecs) ?>
<?php if ($vouchers_view->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($vouchers_view->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $vouchers_view->PageUrl() ?>start=<?php echo $vouchers_view->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($vouchers_view->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $vouchers_view->PageUrl() ?>start=<?php echo $vouchers_view->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $vouchers_view->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($vouchers_view->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $vouchers_view->PageUrl() ?>start=<?php echo $vouchers_view->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($vouchers_view->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $vouchers_view->PageUrl() ?>start=<?php echo $vouchers_view->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $vouchers_view->Pager->PageCount ?></span></td>
	</tr></table>
<?php } else { ?>
	<?php if ($vouchers_view->SearchWhere == "0=101") { ?>
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
$vouchers_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($vouchers->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$vouchers_view->Page_Terminate();
?>
<?php

//
// Page class
//
class cvouchers_view {

	// Page ID
	var $PageID = 'view';

	// Table name
	var $TableName = 'vouchers';

	// Page object name
	var $PageObjName = 'vouchers_view';

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
	function cvouchers_view() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (vouchers)
		if (!isset($GLOBALS["vouchers"])) {
			$GLOBALS["vouchers"] = new cvouchers();
			$GLOBALS["Table"] =& $GLOBALS["vouchers"];
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

		// Table object (colonies)
		if (!isset($GLOBALS['colonies'])) $GLOBALS['colonies'] = new ccolonies();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'vouchers', TRUE);

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
		global $vouchers;

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$vouchers->Export = $_GET["export"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$vouchers->Export = $_POST["exporttype"];
		} else {
			$vouchers->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExport = $vouchers->Export; // Get export parameter, used in header
		$gsExportFile = $vouchers->TableVar; // Get export file, used in header
		$Charset = (EW_CHARSET <> "") ? ";charset=" . EW_CHARSET : ""; // Charset used in header
		if (@$_GET["id"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["id"]);
		}
		if ($vouchers->Export == "csv") {
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
		global $Language, $vouchers;

		// Load current record
		$bLoadCurrentRecord = FALSE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["id"] <> "") {
				$vouchers->id->setQueryStringValue($_GET["id"]);
				$this->RecKey["id"] = $vouchers->id->QueryStringValue;
			} else {
				$bLoadCurrentRecord = TRUE;
			}

			// Get action
			$vouchers->CurrentAction = "I"; // Display form
			switch ($vouchers->CurrentAction) {
				case "I": // Get a record to display
					$this->StartRec = 1; // Initialize start position
					if ($this->Recordset = $this->LoadRecordset()) // Load records
						$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
					if ($this->TotalRecs <= 0) { // No record found
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$this->Page_Terminate("voucherslist.php"); // Return to list page
					} elseif ($bLoadCurrentRecord) { // Load current record position
						$this->SetUpStartRec(); // Set up start record position

						// Point to current record
						if (intval($this->StartRec) <= intval($this->TotalRecs)) {
							$bMatchRecord = TRUE;
							$this->Recordset->Move($this->StartRec-1);
						}
					} else { // Match key values
						while (!$this->Recordset->EOF) {
							if (strval($vouchers->id->CurrentValue) == strval($this->Recordset->fields('id'))) {
								$vouchers->setStartRecordNumber($this->StartRec); // Save record position
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
						$sReturnUrl = "voucherslist.php"; // No matching record, return to list
					} else {
						$this->LoadRowValues($this->Recordset); // Load row values
					}
			}

			// Export data only
			if (in_array($vouchers->Export, array("html","word","excel","xml","csv","email","pdf"))) {
				$this->ExportData();
				if ($vouchers->Export <> "email")
					$this->Page_Terminate(); // Terminate response
				exit();
			}
		} else {
			$sReturnUrl = "voucherslist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$vouchers->RowType = EW_ROWTYPE_VIEW;
		$vouchers->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $vouchers;
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$vouchers->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$vouchers->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $vouchers->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$vouchers->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$vouchers->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$vouchers->setStartRecordNumber($this->StartRec);
		}
	}

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
		$this->AddUrl = $vouchers->AddUrl();
		$this->EditUrl = $vouchers->EditUrl();
		$this->CopyUrl = $vouchers->CopyUrl();
		$this->DeleteUrl = $vouchers->DeleteUrl();
		$this->ListUrl = $vouchers->ListUrl();

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

	// Set up export options
	function SetupExportOptions() {
		global $Language, $vouchers;

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
		$item->Body = "<a name=\"emf_vouchers\" id=\"emf_vouchers\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_vouchers',hdr:ewLanguage.Phrase('ExportToEmail'),key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
		$item->Visible = FALSE;

		// Hide options for export/action
		if ($vouchers->Export <> "")
			$this->ExportOptions->HideAllOptions();
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		global $vouchers;
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = FALSE;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $vouchers->SelectRecordCount();
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
		if ($vouchers->Export == "xml") {
			$XmlDoc = new cXMLDocument(EW_XML_ENCODING);
		} else {
			$ExportDoc = new cExportDocument($vouchers, "v");
		}
		$ParentTable = "";

		// Export master record
		if (EW_EXPORT_MASTER_RECORD && $vouchers->getMasterFilter() <> "" && $vouchers->getCurrentMasterTable() == "colonies") {
			global $colonies;
			$rsmaster = $colonies->LoadRs($this->DbMasterFilter); // Load master record
			if ($rsmaster && !$rsmaster->EOF) {
				if ($vouchers->Export == "xml") {
					$ParentTable = "colonies";
					$colonies->ExportXmlDocument($XmlDoc, '', $rsmaster, 1, 1);
				} else {
					$ExportStyle = $ExportDoc->Style;
					$ExportDoc->ChangeStyle("v"); // Change to vertical
					if ($vouchers->Export <> "csv" || EW_EXPORT_MASTER_RECORD_FOR_CSV) {
						$colonies->ExportDocument($ExportDoc, $rsmaster, 1, 1);
						$ExportDoc->ExportEmptyLine();
					}
					$ExportDoc->ChangeStyle($ExportStyle); // Restore
				}
				$rsmaster->Close();
			}
		}
		if ($bSelectLimit) {
			$StartRec = 1;
			$StopRec = $this->DisplayRecs;
		} else {
			$StartRec = $this->StartRec;
			$StopRec = $this->StopRec;
		}
		if ($vouchers->Export == "xml") {
			$vouchers->ExportXmlDocument($XmlDoc, ($ParentTable <> ""), $rs, $StartRec, $StopRec, "view");
		} else {
			$sHeader = $this->PageHeader;
			$this->Page_DataRendering($sHeader);
			$ExportDoc->Text .= $sHeader;
			$vouchers->ExportDocument($ExportDoc, $rs, $StartRec, $StopRec, "view");
			$sFooter = $this->PageFooter;
			$this->Page_DataRendered($sFooter);
			$ExportDoc->Text .= $sFooter;
		}

		// Close recordset
		$rs->Close();

		// Export header and footer
		if ($vouchers->Export <> "xml") {
			$ExportDoc->ExportHeaderAndFooter();
		}

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write BOM if utf-8
		if ($utf8 && !in_array($vouchers->Export, array("email", "xml")))
			echo "\xEF\xBB\xBF";

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED)
			echo ew_DebugMsg();

		// Output data
		if ($vouchers->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} elseif ($vouchers->Export == "email") {
			$this->ExportEmail($ExportDoc->Text);
			$this->Page_Terminate($vouchers->ExportReturnUrl());
		} elseif ($vouchers->Export == "pdf") {
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
