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
$caregivers_view = new ccaregivers_view();
$Page =& $caregivers_view;

// Page init
$caregivers_view->Page_Init();

// Page main
$caregivers_view->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($caregivers->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var caregivers_view = new ew_Page("caregivers_view");

// page properties
caregivers_view.PageID = "view"; // page ID
caregivers_view.FormID = "fcaregiversview"; // form ID
var EW_PAGE_ID = caregivers_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
caregivers_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
caregivers_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
caregivers_view.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php } ?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("View") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $caregivers->TableCaption() ?>
&nbsp;&nbsp;<?php $caregivers_view->ExportOptions->Render("body"); ?>
</p>
<?php if ($caregivers->Export == "") { ?>
<p class="phpmaker">
<a href="<?php echo $caregivers_view->ListUrl ?>"><?php echo $Language->Phrase("BackToList") ?></a>&nbsp;
<a href="<?php echo $caregivers_view->AddUrl ?>"><?php echo $Language->Phrase("ViewPageAddLink") ?></a>&nbsp;
<a href="<?php echo $caregivers_view->EditUrl ?>"><?php echo $Language->Phrase("ViewPageEditLink") ?></a>&nbsp;
<a href="<?php echo $caregivers_view->CopyUrl ?>"><?php echo $Language->Phrase("ViewPageCopyLink") ?></a>&nbsp;
<a href="<?php echo $caregivers_view->DeleteUrl ?>"><?php echo $Language->Phrase("ViewPageDeleteLink") ?></a>&nbsp;
<?php } ?>
</p>
<?php $caregivers_view->ShowPageHeader(); ?>
<?php
$caregivers_view->ShowMessage();
?>
<p>
<?php if ($caregivers->Export == "") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($caregivers_view->Pager)) $caregivers_view->Pager = new cPrevNextPager($caregivers_view->StartRec, $caregivers_view->DisplayRecs, $caregivers_view->TotalRecs) ?>
<?php if ($caregivers_view->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($caregivers_view->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $caregivers_view->PageUrl() ?>start=<?php echo $caregivers_view->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($caregivers_view->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $caregivers_view->PageUrl() ?>start=<?php echo $caregivers_view->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $caregivers_view->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($caregivers_view->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $caregivers_view->PageUrl() ?>start=<?php echo $caregivers_view->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($caregivers_view->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $caregivers_view->PageUrl() ?>start=<?php echo $caregivers_view->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $caregivers_view->Pager->PageCount ?></span></td>
	</tr></table>
<?php } else { ?>
	<?php if ($caregivers_view->SearchWhere == "0=101") { ?>
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
<?php if ($caregivers->caregiver_id->Visible) { // caregiver_id ?>
	<tr id="r_caregiver_id"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->caregiver_id->FldCaption() ?></td>
		<td<?php echo $caregivers->caregiver_id->CellAttributes() ?>>
<div<?php echo $caregivers->caregiver_id->ViewAttributes() ?>><?php echo $caregivers->caregiver_id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($caregivers->first_name->Visible) { // first_name ?>
	<tr id="r_first_name"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->first_name->FldCaption() ?></td>
		<td<?php echo $caregivers->first_name->CellAttributes() ?>>
<div<?php echo $caregivers->first_name->ViewAttributes() ?>><?php echo $caregivers->first_name->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($caregivers->last_name->Visible) { // last_name ?>
	<tr id="r_last_name"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->last_name->FldCaption() ?></td>
		<td<?php echo $caregivers->last_name->CellAttributes() ?>>
<div<?php echo $caregivers->last_name->ViewAttributes() ?>><?php echo $caregivers->last_name->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($caregivers->day_phone->Visible) { // day_phone ?>
	<tr id="r_day_phone"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->day_phone->FldCaption() ?></td>
		<td<?php echo $caregivers->day_phone->CellAttributes() ?>>
<div<?php echo $caregivers->day_phone->ViewAttributes() ?>><?php echo $caregivers->day_phone->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($caregivers->other_phone->Visible) { // other_phone ?>
	<tr id="r_other_phone"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->other_phone->FldCaption() ?></td>
		<td<?php echo $caregivers->other_phone->CellAttributes() ?>>
<div<?php echo $caregivers->other_phone->ViewAttributes() ?>><?php echo $caregivers->other_phone->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($caregivers->zemail->Visible) { // email ?>
	<tr id="r_zemail"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->zemail->FldCaption() ?></td>
		<td<?php echo $caregivers->zemail->CellAttributes() ?>>
<div<?php echo $caregivers->zemail->ViewAttributes() ?>><?php echo $caregivers->zemail->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($caregivers->address->Visible) { // address ?>
	<tr id="r_address"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->address->FldCaption() ?></td>
		<td<?php echo $caregivers->address->CellAttributes() ?>>
<div<?php echo $caregivers->address->ViewAttributes() ?>><?php echo $caregivers->address->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($caregivers->apt_num->Visible) { // apt_num ?>
	<tr id="r_apt_num"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->apt_num->FldCaption() ?></td>
		<td<?php echo $caregivers->apt_num->CellAttributes() ?>>
<div<?php echo $caregivers->apt_num->ViewAttributes() ?>><?php echo $caregivers->apt_num->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($caregivers->city->Visible) { // city ?>
	<tr id="r_city"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->city->FldCaption() ?></td>
		<td<?php echo $caregivers->city->CellAttributes() ?>>
<div<?php echo $caregivers->city->ViewAttributes() ?>><?php echo $caregivers->city->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($caregivers->county->Visible) { // county ?>
	<tr id="r_county"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->county->FldCaption() ?></td>
		<td<?php echo $caregivers->county->CellAttributes() ?>>
<div<?php echo $caregivers->county->ViewAttributes() ?>><?php echo $caregivers->county->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($caregivers->zip->Visible) { // zip ?>
	<tr id="r_zip"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->zip->FldCaption() ?></td>
		<td<?php echo $caregivers->zip->CellAttributes() ?>>
<div<?php echo $caregivers->zip->ViewAttributes() ?>><?php echo $caregivers->zip->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($caregivers->num_deps->Visible) { // num_deps ?>
	<tr id="r_num_deps"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->num_deps->FldCaption() ?></td>
		<td<?php echo $caregivers->num_deps->CellAttributes() ?>>
<div<?php echo $caregivers->num_deps->ViewAttributes() ?>><?php echo $caregivers->num_deps->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($caregivers->annual_income->Visible) { // annual_income ?>
	<tr id="r_annual_income"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->annual_income->FldCaption() ?></td>
		<td<?php echo $caregivers->annual_income->CellAttributes() ?>>
<div<?php echo $caregivers->annual_income->ViewAttributes() ?>><?php echo $caregivers->annual_income->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($caregivers->app_source->Visible) { // app_source ?>
	<tr id="r_app_source"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->app_source->FldCaption() ?></td>
		<td<?php echo $caregivers->app_source->CellAttributes() ?>>
<div<?php echo $caregivers->app_source->ViewAttributes() ?>><?php echo $caregivers->app_source->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($caregivers->dl->Visible) { // dl ?>
	<tr id="r_dl"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->dl->FldCaption() ?></td>
		<td<?php echo $caregivers->dl->CellAttributes() ?>>
<div<?php echo $caregivers->dl->ViewAttributes() ?>><?php echo $caregivers->dl->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($caregivers->app_date->Visible) { // app_date ?>
	<tr id="r_app_date"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->app_date->FldCaption() ?></td>
		<td<?php echo $caregivers->app_date->CellAttributes() ?>>
<div<?php echo $caregivers->app_date->ViewAttributes() ?>><?php echo $caregivers->app_date->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($caregivers->Expiration->Visible) { // Expiration ?>
	<tr id="r_Expiration"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->Expiration->FldCaption() ?></td>
		<td<?php echo $caregivers->Expiration->CellAttributes() ?>>
<div<?php echo $caregivers->Expiration->ViewAttributes() ?>><?php echo $caregivers->Expiration->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($caregivers->ClinicGroup->Visible) { // ClinicGroup ?>
	<tr id="r_ClinicGroup"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->ClinicGroup->FldCaption() ?></td>
		<td<?php echo $caregivers->ClinicGroup->CellAttributes() ?>>
<div<?php echo $caregivers->ClinicGroup->ViewAttributes() ?>><?php echo $caregivers->ClinicGroup->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($caregivers->DateSent->Visible) { // DateSent ?>
	<tr id="r_DateSent"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->DateSent->FldCaption() ?></td>
		<td<?php echo $caregivers->DateSent->CellAttributes() ?>>
<div<?php echo $caregivers->DateSent->ViewAttributes() ?>><?php echo $caregivers->DateSent->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($caregivers->budget_category->Visible) { // budget_category ?>
	<tr id="r_budget_category"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->budget_category->FldCaption() ?></td>
		<td<?php echo $caregivers->budget_category->CellAttributes() ?>>
<div<?php echo $caregivers->budget_category->ViewAttributes() ?>><?php echo $caregivers->budget_category->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($caregivers->AgeOfApplicant->Visible) { // AgeOfApplicant ?>
	<tr id="r_AgeOfApplicant"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->AgeOfApplicant->FldCaption() ?></td>
		<td<?php echo $caregivers->AgeOfApplicant->CellAttributes() ?>>
<div<?php echo $caregivers->AgeOfApplicant->ViewAttributes() ?>><?php echo $caregivers->AgeOfApplicant->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($caregivers->Applic->Visible) { // Applic ?>
	<tr id="r_Applic"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->Applic->FldCaption() ?></td>
		<td<?php echo $caregivers->Applic->CellAttributes() ?>>
<div<?php echo $caregivers->Applic->ViewAttributes() ?>><?php echo $caregivers->Applic->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($caregivers->SubApplic->Visible) { // SubApplic ?>
	<tr id="r_SubApplic"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->SubApplic->FldCaption() ?></td>
		<td<?php echo $caregivers->SubApplic->CellAttributes() ?>>
<div<?php echo $caregivers->SubApplic->ViewAttributes() ?>><?php echo $caregivers->SubApplic->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($caregivers->DateSigned->Visible) { // DateSigned ?>
	<tr id="r_DateSigned"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->DateSigned->FldCaption() ?></td>
		<td<?php echo $caregivers->DateSigned->CellAttributes() ?>>
<div<?php echo $caregivers->DateSigned->ViewAttributes() ?>><?php echo $caregivers->DateSigned->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($caregivers->colony_id->Visible) { // colony_id ?>
	<tr id="r_colony_id"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->colony_id->FldCaption() ?></td>
		<td<?php echo $caregivers->colony_id->CellAttributes() ?>>
<div<?php echo $caregivers->colony_id->ViewAttributes() ?>><?php echo $caregivers->colony_id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($caregivers->mod_by->Visible) { // mod_by ?>
	<tr id="r_mod_by"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->mod_by->FldCaption() ?></td>
		<td<?php echo $caregivers->mod_by->CellAttributes() ?>>
<div<?php echo $caregivers->mod_by->ViewAttributes() ?>><?php echo $caregivers->mod_by->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($caregivers->mod_date->Visible) { // mod_date ?>
	<tr id="r_mod_date"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->mod_date->FldCaption() ?></td>
		<td<?php echo $caregivers->mod_date->CellAttributes() ?>>
<div<?php echo $caregivers->mod_date->ViewAttributes() ?>><?php echo $caregivers->mod_date->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<?php if ($caregivers->Export == "") { ?>
<br>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($caregivers_view->Pager)) $caregivers_view->Pager = new cPrevNextPager($caregivers_view->StartRec, $caregivers_view->DisplayRecs, $caregivers_view->TotalRecs) ?>
<?php if ($caregivers_view->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($caregivers_view->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $caregivers_view->PageUrl() ?>start=<?php echo $caregivers_view->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($caregivers_view->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $caregivers_view->PageUrl() ?>start=<?php echo $caregivers_view->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $caregivers_view->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($caregivers_view->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $caregivers_view->PageUrl() ?>start=<?php echo $caregivers_view->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($caregivers_view->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $caregivers_view->PageUrl() ?>start=<?php echo $caregivers_view->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $caregivers_view->Pager->PageCount ?></span></td>
	</tr></table>
<?php } else { ?>
	<?php if ($caregivers_view->SearchWhere == "0=101") { ?>
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
$caregivers_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($caregivers->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$caregivers_view->Page_Terminate();
?>
<?php

//
// Page class
//
class ccaregivers_view {

	// Page ID
	var $PageID = 'view';

	// Table name
	var $TableName = 'caregivers';

	// Page object name
	var $PageObjName = 'caregivers_view';

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
	function ccaregivers_view() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (caregivers)
		if (!isset($GLOBALS["caregivers"])) {
			$GLOBALS["caregivers"] = new ccaregivers();
			$GLOBALS["Table"] =& $GLOBALS["caregivers"];
		}
		$KeyUrl = "";
		if (@$_GET["caregiver_id"] <> "") {
			$this->RecKey["caregiver_id"] = $_GET["caregiver_id"];
			$KeyUrl .= "&caregiver_id=" . urlencode($this->RecKey["caregiver_id"]);
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
			define("EW_TABLE_NAME", 'caregivers', TRUE);

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
		global $caregivers;

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$caregivers->Export = $_GET["export"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$caregivers->Export = $_POST["exporttype"];
		} else {
			$caregivers->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExport = $caregivers->Export; // Get export parameter, used in header
		$gsExportFile = $caregivers->TableVar; // Get export file, used in header
		$Charset = (EW_CHARSET <> "") ? ";charset=" . EW_CHARSET : ""; // Charset used in header
		if (@$_GET["caregiver_id"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["caregiver_id"]);
		}
		if ($caregivers->Export == "csv") {
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
		global $Language, $caregivers;

		// Load current record
		$bLoadCurrentRecord = FALSE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["caregiver_id"] <> "") {
				$caregivers->caregiver_id->setQueryStringValue($_GET["caregiver_id"]);
				$this->RecKey["caregiver_id"] = $caregivers->caregiver_id->QueryStringValue;
			} else {
				$bLoadCurrentRecord = TRUE;
			}

			// Get action
			$caregivers->CurrentAction = "I"; // Display form
			switch ($caregivers->CurrentAction) {
				case "I": // Get a record to display
					$this->StartRec = 1; // Initialize start position
					if ($this->Recordset = $this->LoadRecordset()) // Load records
						$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
					if ($this->TotalRecs <= 0) { // No record found
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$this->Page_Terminate("caregiverslist.php"); // Return to list page
					} elseif ($bLoadCurrentRecord) { // Load current record position
						$this->SetUpStartRec(); // Set up start record position

						// Point to current record
						if (intval($this->StartRec) <= intval($this->TotalRecs)) {
							$bMatchRecord = TRUE;
							$this->Recordset->Move($this->StartRec-1);
						}
					} else { // Match key values
						while (!$this->Recordset->EOF) {
							if (strval($caregivers->caregiver_id->CurrentValue) == strval($this->Recordset->fields('caregiver_id'))) {
								$caregivers->setStartRecordNumber($this->StartRec); // Save record position
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
						$sReturnUrl = "caregiverslist.php"; // No matching record, return to list
					} else {
						$this->LoadRowValues($this->Recordset); // Load row values
					}
			}

			// Export data only
			if (in_array($caregivers->Export, array("html","word","excel","xml","csv","email","pdf"))) {
				$this->ExportData();
				if ($caregivers->Export <> "email")
					$this->Page_Terminate(); // Terminate response
				exit();
			}
		} else {
			$sReturnUrl = "caregiverslist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$caregivers->RowType = EW_ROWTYPE_VIEW;
		$caregivers->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $caregivers;
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$caregivers->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$caregivers->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $caregivers->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$caregivers->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$caregivers->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$caregivers->setStartRecordNumber($this->StartRec);
		}
	}

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
		$this->AddUrl = $caregivers->AddUrl();
		$this->EditUrl = $caregivers->EditUrl();
		$this->CopyUrl = $caregivers->CopyUrl();
		$this->DeleteUrl = $caregivers->DeleteUrl();
		$this->ListUrl = $caregivers->ListUrl();

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

	// Set up export options
	function SetupExportOptions() {
		global $Language, $caregivers;

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
		$item->Body = "<a name=\"emf_caregivers\" id=\"emf_caregivers\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_caregivers',hdr:ewLanguage.Phrase('ExportToEmail'),key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
		$item->Visible = FALSE;

		// Hide options for export/action
		if ($caregivers->Export <> "")
			$this->ExportOptions->HideAllOptions();
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		global $caregivers;
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = FALSE;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $caregivers->SelectRecordCount();
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
		if ($caregivers->Export == "xml") {
			$XmlDoc = new cXMLDocument(EW_XML_ENCODING);
		} else {
			$ExportDoc = new cExportDocument($caregivers, "v");
		}
		$ParentTable = "";

		// Export master record
		if (EW_EXPORT_MASTER_RECORD && $caregivers->getMasterFilter() <> "" && $caregivers->getCurrentMasterTable() == "colonies") {
			global $colonies;
			$rsmaster = $colonies->LoadRs($this->DbMasterFilter); // Load master record
			if ($rsmaster && !$rsmaster->EOF) {
				if ($caregivers->Export == "xml") {
					$ParentTable = "colonies";
					$colonies->ExportXmlDocument($XmlDoc, '', $rsmaster, 1, 1);
				} else {
					$ExportStyle = $ExportDoc->Style;
					$ExportDoc->ChangeStyle("v"); // Change to vertical
					if ($caregivers->Export <> "csv" || EW_EXPORT_MASTER_RECORD_FOR_CSV) {
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
		if ($caregivers->Export == "xml") {
			$caregivers->ExportXmlDocument($XmlDoc, ($ParentTable <> ""), $rs, $StartRec, $StopRec, "view");
		} else {
			$sHeader = $this->PageHeader;
			$this->Page_DataRendering($sHeader);
			$ExportDoc->Text .= $sHeader;
			$caregivers->ExportDocument($ExportDoc, $rs, $StartRec, $StopRec, "view");
			$sFooter = $this->PageFooter;
			$this->Page_DataRendered($sFooter);
			$ExportDoc->Text .= $sFooter;
		}

		// Close recordset
		$rs->Close();

		// Export header and footer
		if ($caregivers->Export <> "xml") {
			$ExportDoc->ExportHeaderAndFooter();
		}

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write BOM if utf-8
		if ($utf8 && !in_array($caregivers->Export, array("email", "xml")))
			echo "\xEF\xBB\xBF";

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED)
			echo ew_DebugMsg();

		// Output data
		if ($caregivers->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} elseif ($caregivers->Export == "email") {
			$this->ExportEmail($ExportDoc->Text);
			$this->Page_Terminate($caregivers->ExportReturnUrl());
		} elseif ($caregivers->Export == "pdf") {
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
