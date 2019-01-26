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
$caregivers_list = new ccaregivers_list();
$Page =& $caregivers_list;

// Page init
$caregivers_list->Page_Init();

// Page main
$caregivers_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($caregivers->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var caregivers_list = new ew_Page("caregivers_list");

// page properties
caregivers_list.PageID = "list"; // page ID
caregivers_list.FormID = "fcaregiverslist"; // form ID
var EW_PAGE_ID = caregivers_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
caregivers_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
caregivers_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
caregivers_list.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php } ?>
<?php if (($caregivers->Export == "") || (EW_EXPORT_MASTER_RECORD && $caregivers->Export == "print")) { ?>
<?php
$gsMasterReturnUrl = "colonieslist.php";
if ($caregivers_list->DbMasterFilter <> "" && $caregivers->getCurrentMasterTable() == "colonies") {
	if ($caregivers_list->MasterRecordExists) {
		if ($caregivers->getCurrentMasterTable() == $caregivers->TableVar) $gsMasterReturnUrl .= "?" . EW_TABLE_SHOW_MASTER . "=";
?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("MasterRecord") ?><?php echo $colonies->TableCaption() ?>
&nbsp;&nbsp;<?php $caregivers_list->ExportOptions->Render("body"); ?>
</p>
<?php if ($caregivers->Export == "") { ?>
<p class="phpmaker"><a href="<?php echo $gsMasterReturnUrl ?>"><?php echo $Language->Phrase("BackToMasterPage") ?></a></p>
<?php } ?>
<?php include_once "coloniesmaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$caregivers_list->TotalRecs = $caregivers->SelectRecordCount();
	} else {
		if ($caregivers_list->Recordset = $caregivers_list->LoadRecordset())
			$caregivers_list->TotalRecs = $caregivers_list->Recordset->RecordCount();
	}
	$caregivers_list->StartRec = 1;
	if ($caregivers_list->DisplayRecs <= 0 || ($caregivers->Export <> "" && $caregivers->ExportAll)) // Display all records
		$caregivers_list->DisplayRecs = $caregivers_list->TotalRecs;
	if (!($caregivers->Export <> "" && $caregivers->ExportAll))
		$caregivers_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$caregivers_list->Recordset = $caregivers_list->LoadRecordset($caregivers_list->StartRec-1, $caregivers_list->DisplayRecs);
?>
<p class="phpmaker ewTitle" style="white-space: nowrap;"><?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $caregivers->TableCaption() ?>
<?php if ($caregivers->getCurrentMasterTable() == "") { ?>
&nbsp;&nbsp;<?php $caregivers_list->ExportOptions->Render("body"); ?>
<?php } ?>
</p>
<?php if ($caregivers->Export == "" && $caregivers->CurrentAction == "") { ?>
<a href="javascript:ew_ToggleSearchPanel(caregivers_list);" style="text-decoration: none;"><img id="caregivers_list_SearchImage" src="phpimages/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="caregivers_list_SearchPanel">
<form name="fcaregiverslistsrch" id="fcaregiverslistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<input type="hidden" id="t" name="t" value="caregivers">
<div class="ewBasicSearch">
<div id="xsr_1" class="ewCssTableRow">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($caregivers->getSessionBasicSearchKeyword()) ?>">
	<input type="Submit" name="Submit" id="Submit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
	<a href="<?php echo $caregivers_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
</div>
<div id="xsr_2" class="ewCssTableRow">
	<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value=""<?php if ($caregivers->getSessionBasicSearchType() == "") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($caregivers->getSessionBasicSearchType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($caregivers->getSessionBasicSearchType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
</div>
</div>
</form>
</div>
<?php } ?>
<?php $caregivers_list->ShowPageHeader(); ?>
<?php
$caregivers_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($caregivers->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($caregivers->CurrentAction <> "gridadd" && $caregivers->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($caregivers_list->Pager)) $caregivers_list->Pager = new cPrevNextPager($caregivers_list->StartRec, $caregivers_list->DisplayRecs, $caregivers_list->TotalRecs) ?>
<?php if ($caregivers_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($caregivers_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $caregivers_list->PageUrl() ?>start=<?php echo $caregivers_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($caregivers_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $caregivers_list->PageUrl() ?>start=<?php echo $caregivers_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $caregivers_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($caregivers_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $caregivers_list->PageUrl() ?>start=<?php echo $caregivers_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($caregivers_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $caregivers_list->PageUrl() ?>start=<?php echo $caregivers_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $caregivers_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $caregivers_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $caregivers_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $caregivers_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($caregivers_list->SearchWhere == "0=101") { ?>
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
<span class="phpmaker">
<a class="ewGridLink" href="<?php echo $caregivers_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
</span>
</div>
<?php } ?>
<form name="fcaregiverslist" id="fcaregiverslist" class="ewForm" action="" method="post">
<input type="hidden" name="t" id="t" value="caregivers">
<div id="gmp_caregivers" class="ewGridMiddlePanel">
<?php if ($caregivers_list->TotalRecs > 0) { ?>
<table cellspacing="0" data-rowhighlightclass="ewTableHighlightRow" data-rowselectclass="ewTableSelectRow" data-roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php echo $caregivers->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$caregivers_list->RenderListOptions();

// Render list options (header, left)
$caregivers_list->ListOptions->Render("header", "left");
?>
<?php if ($caregivers->caregiver_id->Visible) { // caregiver_id ?>
	<?php if ($caregivers->SortUrl($caregivers->caregiver_id) == "") { ?>
		<td><?php echo $caregivers->caregiver_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $caregivers->SortUrl($caregivers->caregiver_id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->caregiver_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($caregivers->caregiver_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->caregiver_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->first_name->Visible) { // first_name ?>
	<?php if ($caregivers->SortUrl($caregivers->first_name) == "") { ?>
		<td><?php echo $caregivers->first_name->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $caregivers->SortUrl($caregivers->first_name) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->first_name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($caregivers->first_name->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->first_name->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->last_name->Visible) { // last_name ?>
	<?php if ($caregivers->SortUrl($caregivers->last_name) == "") { ?>
		<td><?php echo $caregivers->last_name->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $caregivers->SortUrl($caregivers->last_name) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->last_name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($caregivers->last_name->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->last_name->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->day_phone->Visible) { // day_phone ?>
	<?php if ($caregivers->SortUrl($caregivers->day_phone) == "") { ?>
		<td><?php echo $caregivers->day_phone->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $caregivers->SortUrl($caregivers->day_phone) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->day_phone->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($caregivers->day_phone->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->day_phone->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->other_phone->Visible) { // other_phone ?>
	<?php if ($caregivers->SortUrl($caregivers->other_phone) == "") { ?>
		<td><?php echo $caregivers->other_phone->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $caregivers->SortUrl($caregivers->other_phone) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->other_phone->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($caregivers->other_phone->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->other_phone->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->zemail->Visible) { // email ?>
	<?php if ($caregivers->SortUrl($caregivers->zemail) == "") { ?>
		<td><?php echo $caregivers->zemail->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $caregivers->SortUrl($caregivers->zemail) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->zemail->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($caregivers->zemail->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->zemail->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->address->Visible) { // address ?>
	<?php if ($caregivers->SortUrl($caregivers->address) == "") { ?>
		<td><?php echo $caregivers->address->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $caregivers->SortUrl($caregivers->address) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->address->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($caregivers->address->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->address->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->apt_num->Visible) { // apt_num ?>
	<?php if ($caregivers->SortUrl($caregivers->apt_num) == "") { ?>
		<td><?php echo $caregivers->apt_num->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $caregivers->SortUrl($caregivers->apt_num) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->apt_num->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($caregivers->apt_num->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->apt_num->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->city->Visible) { // city ?>
	<?php if ($caregivers->SortUrl($caregivers->city) == "") { ?>
		<td><?php echo $caregivers->city->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $caregivers->SortUrl($caregivers->city) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->city->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($caregivers->city->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->city->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->county->Visible) { // county ?>
	<?php if ($caregivers->SortUrl($caregivers->county) == "") { ?>
		<td><?php echo $caregivers->county->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $caregivers->SortUrl($caregivers->county) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->county->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($caregivers->county->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->county->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->zip->Visible) { // zip ?>
	<?php if ($caregivers->SortUrl($caregivers->zip) == "") { ?>
		<td><?php echo $caregivers->zip->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $caregivers->SortUrl($caregivers->zip) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->zip->FldCaption() ?></td><td style="width: 10px;"><?php if ($caregivers->zip->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->zip->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->num_deps->Visible) { // num_deps ?>
	<?php if ($caregivers->SortUrl($caregivers->num_deps) == "") { ?>
		<td><?php echo $caregivers->num_deps->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $caregivers->SortUrl($caregivers->num_deps) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->num_deps->FldCaption() ?></td><td style="width: 10px;"><?php if ($caregivers->num_deps->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->num_deps->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->annual_income->Visible) { // annual_income ?>
	<?php if ($caregivers->SortUrl($caregivers->annual_income) == "") { ?>
		<td><?php echo $caregivers->annual_income->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $caregivers->SortUrl($caregivers->annual_income) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->annual_income->FldCaption() ?></td><td style="width: 10px;"><?php if ($caregivers->annual_income->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->annual_income->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->app_source->Visible) { // app_source ?>
	<?php if ($caregivers->SortUrl($caregivers->app_source) == "") { ?>
		<td><?php echo $caregivers->app_source->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $caregivers->SortUrl($caregivers->app_source) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->app_source->FldCaption() ?></td><td style="width: 10px;"><?php if ($caregivers->app_source->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->app_source->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->dl->Visible) { // dl ?>
	<?php if ($caregivers->SortUrl($caregivers->dl) == "") { ?>
		<td><?php echo $caregivers->dl->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $caregivers->SortUrl($caregivers->dl) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->dl->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($caregivers->dl->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->dl->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->app_date->Visible) { // app_date ?>
	<?php if ($caregivers->SortUrl($caregivers->app_date) == "") { ?>
		<td><?php echo $caregivers->app_date->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $caregivers->SortUrl($caregivers->app_date) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->app_date->FldCaption() ?></td><td style="width: 10px;"><?php if ($caregivers->app_date->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->app_date->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->Expiration->Visible) { // Expiration ?>
	<?php if ($caregivers->SortUrl($caregivers->Expiration) == "") { ?>
		<td><?php echo $caregivers->Expiration->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $caregivers->SortUrl($caregivers->Expiration) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->Expiration->FldCaption() ?></td><td style="width: 10px;"><?php if ($caregivers->Expiration->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->Expiration->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->ClinicGroup->Visible) { // ClinicGroup ?>
	<?php if ($caregivers->SortUrl($caregivers->ClinicGroup) == "") { ?>
		<td><?php echo $caregivers->ClinicGroup->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $caregivers->SortUrl($caregivers->ClinicGroup) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->ClinicGroup->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($caregivers->ClinicGroup->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->ClinicGroup->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->DateSent->Visible) { // DateSent ?>
	<?php if ($caregivers->SortUrl($caregivers->DateSent) == "") { ?>
		<td><?php echo $caregivers->DateSent->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $caregivers->SortUrl($caregivers->DateSent) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->DateSent->FldCaption() ?></td><td style="width: 10px;"><?php if ($caregivers->DateSent->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->DateSent->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->budget_category->Visible) { // budget_category ?>
	<?php if ($caregivers->SortUrl($caregivers->budget_category) == "") { ?>
		<td><?php echo $caregivers->budget_category->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $caregivers->SortUrl($caregivers->budget_category) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->budget_category->FldCaption() ?></td><td style="width: 10px;"><?php if ($caregivers->budget_category->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->budget_category->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->AgeOfApplicant->Visible) { // AgeOfApplicant ?>
	<?php if ($caregivers->SortUrl($caregivers->AgeOfApplicant) == "") { ?>
		<td><?php echo $caregivers->AgeOfApplicant->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $caregivers->SortUrl($caregivers->AgeOfApplicant) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->AgeOfApplicant->FldCaption() ?></td><td style="width: 10px;"><?php if ($caregivers->AgeOfApplicant->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->AgeOfApplicant->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->Applic->Visible) { // Applic ?>
	<?php if ($caregivers->SortUrl($caregivers->Applic) == "") { ?>
		<td><?php echo $caregivers->Applic->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $caregivers->SortUrl($caregivers->Applic) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->Applic->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($caregivers->Applic->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->Applic->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->SubApplic->Visible) { // SubApplic ?>
	<?php if ($caregivers->SortUrl($caregivers->SubApplic) == "") { ?>
		<td><?php echo $caregivers->SubApplic->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $caregivers->SortUrl($caregivers->SubApplic) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->SubApplic->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($caregivers->SubApplic->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->SubApplic->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->DateSigned->Visible) { // DateSigned ?>
	<?php if ($caregivers->SortUrl($caregivers->DateSigned) == "") { ?>
		<td><?php echo $caregivers->DateSigned->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $caregivers->SortUrl($caregivers->DateSigned) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->DateSigned->FldCaption() ?></td><td style="width: 10px;"><?php if ($caregivers->DateSigned->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->DateSigned->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->colony_id->Visible) { // colony_id ?>
	<?php if ($caregivers->SortUrl($caregivers->colony_id) == "") { ?>
		<td><?php echo $caregivers->colony_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $caregivers->SortUrl($caregivers->colony_id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->colony_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($caregivers->colony_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->colony_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->mod_by->Visible) { // mod_by ?>
	<?php if ($caregivers->SortUrl($caregivers->mod_by) == "") { ?>
		<td><?php echo $caregivers->mod_by->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $caregivers->SortUrl($caregivers->mod_by) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->mod_by->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($caregivers->mod_by->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->mod_by->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->mod_date->Visible) { // mod_date ?>
	<?php if ($caregivers->SortUrl($caregivers->mod_date) == "") { ?>
		<td><?php echo $caregivers->mod_date->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $caregivers->SortUrl($caregivers->mod_date) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->mod_date->FldCaption() ?></td><td style="width: 10px;"><?php if ($caregivers->mod_date->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->mod_date->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$caregivers_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<?php
if ($caregivers->ExportAll && $caregivers->Export <> "") {
	$caregivers_list->StopRec = $caregivers_list->TotalRecs;
} else {

	// Set the last record to display
	if ($caregivers_list->TotalRecs > $caregivers_list->StartRec + $caregivers_list->DisplayRecs - 1)
		$caregivers_list->StopRec = $caregivers_list->StartRec + $caregivers_list->DisplayRecs - 1;
	else
		$caregivers_list->StopRec = $caregivers_list->TotalRecs;
}
$caregivers_list->RecCnt = $caregivers_list->StartRec - 1;
if ($caregivers_list->Recordset && !$caregivers_list->Recordset->EOF) {
	$caregivers_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $caregivers_list->StartRec > 1)
		$caregivers_list->Recordset->Move($caregivers_list->StartRec - 1);
} elseif (!$caregivers->AllowAddDeleteRow && $caregivers_list->StopRec == 0) {
	$caregivers_list->StopRec = $caregivers->GridAddRowCount;
}

// Initialize aggregate
$caregivers->RowType = EW_ROWTYPE_AGGREGATEINIT;
$caregivers->ResetAttrs();
$caregivers_list->RenderRow();
$caregivers_list->RowCnt = 0;
while ($caregivers_list->RecCnt < $caregivers_list->StopRec) {
	$caregivers_list->RecCnt++;
	if (intval($caregivers_list->RecCnt) >= intval($caregivers_list->StartRec)) {
		$caregivers_list->RowCnt++;

		// Set up key count
		$caregivers_list->KeyCount = $caregivers_list->RowIndex;

		// Init row class and style
		$caregivers->ResetAttrs();
		$caregivers->CssClass = "";
		if ($caregivers->CurrentAction == "gridadd") {
		} else {
			$caregivers_list->LoadRowValues($caregivers_list->Recordset); // Load row values
		}
		$caregivers->RowType = EW_ROWTYPE_VIEW; // Render view
		$caregivers->RowAttrs = array('onmouseover'=>'ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);');

		// Render row
		$caregivers_list->RenderRow();

		// Render list options
		$caregivers_list->RenderListOptions();
?>
	<tr<?php echo $caregivers->RowAttributes() ?>>
<?php

// Render list options (body, left)
$caregivers_list->ListOptions->Render("body", "left");
?>
	<?php if ($caregivers->caregiver_id->Visible) { // caregiver_id ?>
		<td<?php echo $caregivers->caregiver_id->CellAttributes() ?>>
<div<?php echo $caregivers->caregiver_id->ViewAttributes() ?>><?php echo $caregivers->caregiver_id->ListViewValue() ?></div>
<a name="<?php echo $caregivers_list->PageObjName . "_row_" . $caregivers_list->RowCnt ?>" id="<?php echo $caregivers_list->PageObjName . "_row_" . $caregivers_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($caregivers->first_name->Visible) { // first_name ?>
		<td<?php echo $caregivers->first_name->CellAttributes() ?>>
<div<?php echo $caregivers->first_name->ViewAttributes() ?>><?php echo $caregivers->first_name->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($caregivers->last_name->Visible) { // last_name ?>
		<td<?php echo $caregivers->last_name->CellAttributes() ?>>
<div<?php echo $caregivers->last_name->ViewAttributes() ?>><?php echo $caregivers->last_name->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($caregivers->day_phone->Visible) { // day_phone ?>
		<td<?php echo $caregivers->day_phone->CellAttributes() ?>>
<div<?php echo $caregivers->day_phone->ViewAttributes() ?>><?php echo $caregivers->day_phone->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($caregivers->other_phone->Visible) { // other_phone ?>
		<td<?php echo $caregivers->other_phone->CellAttributes() ?>>
<div<?php echo $caregivers->other_phone->ViewAttributes() ?>><?php echo $caregivers->other_phone->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($caregivers->zemail->Visible) { // email ?>
		<td<?php echo $caregivers->zemail->CellAttributes() ?>>
<div<?php echo $caregivers->zemail->ViewAttributes() ?>><?php echo $caregivers->zemail->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($caregivers->address->Visible) { // address ?>
		<td<?php echo $caregivers->address->CellAttributes() ?>>
<div<?php echo $caregivers->address->ViewAttributes() ?>><?php echo $caregivers->address->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($caregivers->apt_num->Visible) { // apt_num ?>
		<td<?php echo $caregivers->apt_num->CellAttributes() ?>>
<div<?php echo $caregivers->apt_num->ViewAttributes() ?>><?php echo $caregivers->apt_num->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($caregivers->city->Visible) { // city ?>
		<td<?php echo $caregivers->city->CellAttributes() ?>>
<div<?php echo $caregivers->city->ViewAttributes() ?>><?php echo $caregivers->city->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($caregivers->county->Visible) { // county ?>
		<td<?php echo $caregivers->county->CellAttributes() ?>>
<div<?php echo $caregivers->county->ViewAttributes() ?>><?php echo $caregivers->county->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($caregivers->zip->Visible) { // zip ?>
		<td<?php echo $caregivers->zip->CellAttributes() ?>>
<div<?php echo $caregivers->zip->ViewAttributes() ?>><?php echo $caregivers->zip->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($caregivers->num_deps->Visible) { // num_deps ?>
		<td<?php echo $caregivers->num_deps->CellAttributes() ?>>
<div<?php echo $caregivers->num_deps->ViewAttributes() ?>><?php echo $caregivers->num_deps->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($caregivers->annual_income->Visible) { // annual_income ?>
		<td<?php echo $caregivers->annual_income->CellAttributes() ?>>
<div<?php echo $caregivers->annual_income->ViewAttributes() ?>><?php echo $caregivers->annual_income->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($caregivers->app_source->Visible) { // app_source ?>
		<td<?php echo $caregivers->app_source->CellAttributes() ?>>
<div<?php echo $caregivers->app_source->ViewAttributes() ?>><?php echo $caregivers->app_source->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($caregivers->dl->Visible) { // dl ?>
		<td<?php echo $caregivers->dl->CellAttributes() ?>>
<div<?php echo $caregivers->dl->ViewAttributes() ?>><?php echo $caregivers->dl->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($caregivers->app_date->Visible) { // app_date ?>
		<td<?php echo $caregivers->app_date->CellAttributes() ?>>
<div<?php echo $caregivers->app_date->ViewAttributes() ?>><?php echo $caregivers->app_date->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($caregivers->Expiration->Visible) { // Expiration ?>
		<td<?php echo $caregivers->Expiration->CellAttributes() ?>>
<div<?php echo $caregivers->Expiration->ViewAttributes() ?>><?php echo $caregivers->Expiration->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($caregivers->ClinicGroup->Visible) { // ClinicGroup ?>
		<td<?php echo $caregivers->ClinicGroup->CellAttributes() ?>>
<div<?php echo $caregivers->ClinicGroup->ViewAttributes() ?>><?php echo $caregivers->ClinicGroup->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($caregivers->DateSent->Visible) { // DateSent ?>
		<td<?php echo $caregivers->DateSent->CellAttributes() ?>>
<div<?php echo $caregivers->DateSent->ViewAttributes() ?>><?php echo $caregivers->DateSent->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($caregivers->budget_category->Visible) { // budget_category ?>
		<td<?php echo $caregivers->budget_category->CellAttributes() ?>>
<div<?php echo $caregivers->budget_category->ViewAttributes() ?>><?php echo $caregivers->budget_category->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($caregivers->AgeOfApplicant->Visible) { // AgeOfApplicant ?>
		<td<?php echo $caregivers->AgeOfApplicant->CellAttributes() ?>>
<div<?php echo $caregivers->AgeOfApplicant->ViewAttributes() ?>><?php echo $caregivers->AgeOfApplicant->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($caregivers->Applic->Visible) { // Applic ?>
		<td<?php echo $caregivers->Applic->CellAttributes() ?>>
<div<?php echo $caregivers->Applic->ViewAttributes() ?>><?php echo $caregivers->Applic->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($caregivers->SubApplic->Visible) { // SubApplic ?>
		<td<?php echo $caregivers->SubApplic->CellAttributes() ?>>
<div<?php echo $caregivers->SubApplic->ViewAttributes() ?>><?php echo $caregivers->SubApplic->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($caregivers->DateSigned->Visible) { // DateSigned ?>
		<td<?php echo $caregivers->DateSigned->CellAttributes() ?>>
<div<?php echo $caregivers->DateSigned->ViewAttributes() ?>><?php echo $caregivers->DateSigned->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($caregivers->colony_id->Visible) { // colony_id ?>
		<td<?php echo $caregivers->colony_id->CellAttributes() ?>>
<div<?php echo $caregivers->colony_id->ViewAttributes() ?>><?php echo $caregivers->colony_id->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($caregivers->mod_by->Visible) { // mod_by ?>
		<td<?php echo $caregivers->mod_by->CellAttributes() ?>>
<div<?php echo $caregivers->mod_by->ViewAttributes() ?>><?php echo $caregivers->mod_by->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($caregivers->mod_date->Visible) { // mod_date ?>
		<td<?php echo $caregivers->mod_date->CellAttributes() ?>>
<div<?php echo $caregivers->mod_date->ViewAttributes() ?>><?php echo $caregivers->mod_date->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$caregivers_list->ListOptions->Render("body", "right");
?>
	</tr>
<?php
	}
	if ($caregivers->CurrentAction <> "gridadd")
		$caregivers_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($caregivers_list->Recordset)
	$caregivers_list->Recordset->Close();
?>
<?php if ($caregivers_list->TotalRecs > 0) { ?>
<?php if ($caregivers->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($caregivers->CurrentAction <> "gridadd" && $caregivers->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($caregivers_list->Pager)) $caregivers_list->Pager = new cPrevNextPager($caregivers_list->StartRec, $caregivers_list->DisplayRecs, $caregivers_list->TotalRecs) ?>
<?php if ($caregivers_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($caregivers_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $caregivers_list->PageUrl() ?>start=<?php echo $caregivers_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($caregivers_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $caregivers_list->PageUrl() ?>start=<?php echo $caregivers_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $caregivers_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($caregivers_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $caregivers_list->PageUrl() ?>start=<?php echo $caregivers_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($caregivers_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $caregivers_list->PageUrl() ?>start=<?php echo $caregivers_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $caregivers_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $caregivers_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $caregivers_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $caregivers_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($caregivers_list->SearchWhere == "0=101") { ?>
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
<span class="phpmaker">
<a class="ewGridLink" href="<?php echo $caregivers_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
</span>
</div>
<?php } ?>
<?php } ?>
</td></tr></table>
<?php if ($caregivers->Export == "" && $caregivers->CurrentAction == "") { ?>
<?php } ?>
<?php
$caregivers_list->ShowPageFooter();
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
$caregivers_list->Page_Terminate();
?>
<?php

//
// Page class
//
class ccaregivers_list {

	// Page ID
	var $PageID = 'list';

	// Table name
	var $TableName = 'caregivers';

	// Page object name
	var $PageObjName = 'caregivers_list';

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
	function ccaregivers_list() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (caregivers)
		if (!isset($GLOBALS["caregivers"])) {
			$GLOBALS["caregivers"] = new ccaregivers();
			$GLOBALS["Table"] =& $GLOBALS["caregivers"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "caregiversadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "caregiversdelete.php";
		$this->MultiUpdateUrl = "caregiversupdate.php";

		// Table object (colonies)
		if (!isset($GLOBALS['colonies'])) $GLOBALS['colonies'] = new ccolonies();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'caregivers', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();

		// List options
		$this->ListOptions = new cListOptions();

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
		if ($caregivers->Export == "csv") {
			header('Content-Type: application/csv' . $Charset);
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.csv');
		}

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$caregivers->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();

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

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $DisplayRecs = 20;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $RowCnt;
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;	
	var $MultiSelectKey;
	var $RestoreSearch;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security, $caregivers;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";
		if ($this->IsPageRequest()) { // Validate request

			// Handle reset command
			$this->ResetCmd();

			// Set up master detail parameters
			$this->SetUpMasterParms();

			// Hide all options
			if ($caregivers->Export <> "" ||
				$caregivers->CurrentAction == "gridadd" ||
				$caregivers->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ExportOptions->HideAllOptions();
			}

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Restore search parms from Session
			$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$caregivers->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($caregivers->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $caregivers->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$caregivers->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->SearchWhere <> "") {
			if ($sSrchBasic == "")
				$this->ResetBasicSearchParms();
			$caregivers->setSearchWhere($this->SearchWhere); // Save to Session
			if (!$this->RestoreSearch) {
				$this->StartRec = 1; // Reset start record counter
				$caregivers->setStartRecordNumber($this->StartRec);
			}
		} else {
			$this->SearchWhere = $caregivers->getSearchWhere();
		}

		// Build filter
		$sFilter = "";

		// Restore master/detail filter
		$this->DbMasterFilter = $caregivers->getMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $caregivers->getDetailFilter(); // Restore detail filter
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Load master record
		if ($caregivers->getMasterFilter() <> "" && $caregivers->getCurrentMasterTable() == "colonies") {
			global $colonies;
			$rsmaster = $colonies->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate($caregivers->getReturnUrl()); // Return to caller
			} else {
				$colonies->LoadListRowValues($rsmaster);
				$colonies->RowType = EW_ROWTYPE_MASTER; // Master row
				$colonies->RenderListRow();
				$rsmaster->Close();
			}
		}

		// Set up filter in session
		$caregivers->setSessionWhere($sFilter);
		$caregivers->CurrentFilter = "";

		// Export data only
		if (in_array($caregivers->Export, array("html","word","excel","xml","csv","email","pdf"))) {
			$this->ExportData();
			if ($caregivers->Export <> "email")
				$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Return basic search SQL
	function BasicSearchSQL($Keyword) {
		global $caregivers;
		$sKeyword = ew_AdjustSql($Keyword);
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $caregivers->first_name, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $caregivers->last_name, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $caregivers->day_phone, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $caregivers->other_phone, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $caregivers->zemail, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $caregivers->address, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $caregivers->apt_num, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $caregivers->city, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $caregivers->county, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $caregivers->dl, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $caregivers->ClinicGroup, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $caregivers->Applic, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $caregivers->SubApplic, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $caregivers->mod_by, $Keyword);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSql(&$Where, &$Fld, $Keyword) {
		$sFldExpression = ($Fld->FldVirtualExpression <> "") ? $Fld->FldVirtualExpression : $Fld->FldExpression;
		$lFldDataType = ($Fld->FldIsVirtual) ? EW_DATATYPE_STRING : $Fld->FldDataType;
		if ($lFldDataType == EW_DATATYPE_NUMBER) {
			$sWrk = $sFldExpression . " = " . ew_QuotedValue($Keyword, $lFldDataType);
		} else {
			$sWrk = $sFldExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", $lFldDataType));
		}
		if ($Where <> "") $Where .= " OR ";
		$Where .= $sWrk;
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere() {
		global $Security, $caregivers;
		$sSearchStr = "";
		$sSearchKeyword = $caregivers->BasicSearchKeyword;
		$sSearchType = $caregivers->BasicSearchType;
		if ($sSearchKeyword <> "") {
			$sSearch = trim($sSearchKeyword);
			if ($sSearchType <> "") {
				while (strpos($sSearch, "  ") !== FALSE)
					$sSearch = str_replace("  ", " ", $sSearch);
				$arKeyword = explode(" ", trim($sSearch));
				foreach ($arKeyword as $sKeyword) {
					if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
					$sSearchStr .= "(" . $this->BasicSearchSQL($sKeyword) . ")";
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL($sSearch);
			}
		}
		if ($sSearchKeyword <> "") {
			$caregivers->setSessionBasicSearchKeyword($sSearchKeyword);
			$caregivers->setSessionBasicSearchType($sSearchType);
		}
		return $sSearchStr;
	}

	// Clear all search parameters
	function ResetSearchParms() {
		global $caregivers;

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$caregivers->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		global $caregivers;
		$caregivers->setSessionBasicSearchKeyword("");
		$caregivers->setSessionBasicSearchType("");
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		global $caregivers;
		$bRestore = TRUE;
		if ($caregivers->BasicSearchKeyword <> "") $bRestore = FALSE;
		$this->RestoreSearch = $bRestore;
		if ($bRestore) {

			// Restore basic search values
			$caregivers->BasicSearchKeyword = $caregivers->getSessionBasicSearchKeyword();
			$caregivers->BasicSearchType = $caregivers->getSessionBasicSearchType();
		}
	}

	// Set up sort parameters
	function SetUpSortOrder() {
		global $caregivers;

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$caregivers->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$caregivers->CurrentOrderType = @$_GET["ordertype"];
			$caregivers->UpdateSort($caregivers->caregiver_id); // caregiver_id
			$caregivers->UpdateSort($caregivers->first_name); // first_name
			$caregivers->UpdateSort($caregivers->last_name); // last_name
			$caregivers->UpdateSort($caregivers->day_phone); // day_phone
			$caregivers->UpdateSort($caregivers->other_phone); // other_phone
			$caregivers->UpdateSort($caregivers->zemail); // email
			$caregivers->UpdateSort($caregivers->address); // address
			$caregivers->UpdateSort($caregivers->apt_num); // apt_num
			$caregivers->UpdateSort($caregivers->city); // city
			$caregivers->UpdateSort($caregivers->county); // county
			$caregivers->UpdateSort($caregivers->zip); // zip
			$caregivers->UpdateSort($caregivers->num_deps); // num_deps
			$caregivers->UpdateSort($caregivers->annual_income); // annual_income
			$caregivers->UpdateSort($caregivers->app_source); // app_source
			$caregivers->UpdateSort($caregivers->dl); // dl
			$caregivers->UpdateSort($caregivers->app_date); // app_date
			$caregivers->UpdateSort($caregivers->Expiration); // Expiration
			$caregivers->UpdateSort($caregivers->ClinicGroup); // ClinicGroup
			$caregivers->UpdateSort($caregivers->DateSent); // DateSent
			$caregivers->UpdateSort($caregivers->budget_category); // budget_category
			$caregivers->UpdateSort($caregivers->AgeOfApplicant); // AgeOfApplicant
			$caregivers->UpdateSort($caregivers->Applic); // Applic
			$caregivers->UpdateSort($caregivers->SubApplic); // SubApplic
			$caregivers->UpdateSort($caregivers->DateSigned); // DateSigned
			$caregivers->UpdateSort($caregivers->colony_id); // colony_id
			$caregivers->UpdateSort($caregivers->mod_by); // mod_by
			$caregivers->UpdateSort($caregivers->mod_date); // mod_date
			$caregivers->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		global $caregivers;
		$sOrderBy = $caregivers->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($caregivers->SqlOrderBy() <> "") {
				$sOrderBy = $caregivers->SqlOrderBy();
				$caregivers->setSessionOrderBy($sOrderBy);
				$caregivers->caregiver_id->setSort("DESC");
			}
		}
	}

	// Reset command
	// cmd=reset (Reset search parameters)
	// cmd=resetall (Reset search and master/detail parameters)
	// cmd=resetsort (Reset sort parameters)
	function ResetCmd() {
		global $caregivers;

		// Get reset command
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset search criteria
			if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall")
				$this->ResetSearchParms();

			// Reset master/detail keys
			if (strtolower($sCmd) == "resetall") {
				$caregivers->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$caregivers->colony_id->setSessionValue("");
			}

			// Reset sorting order
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$caregivers->setSessionOrderBy($sOrderBy);
				$caregivers->caregiver_id->setSort("");
				$caregivers->first_name->setSort("");
				$caregivers->last_name->setSort("");
				$caregivers->day_phone->setSort("");
				$caregivers->other_phone->setSort("");
				$caregivers->zemail->setSort("");
				$caregivers->address->setSort("");
				$caregivers->apt_num->setSort("");
				$caregivers->city->setSort("");
				$caregivers->county->setSort("");
				$caregivers->zip->setSort("");
				$caregivers->num_deps->setSort("");
				$caregivers->annual_income->setSort("");
				$caregivers->app_source->setSort("");
				$caregivers->dl->setSort("");
				$caregivers->app_date->setSort("");
				$caregivers->Expiration->setSort("");
				$caregivers->ClinicGroup->setSort("");
				$caregivers->DateSent->setSort("");
				$caregivers->budget_category->setSort("");
				$caregivers->AgeOfApplicant->setSort("");
				$caregivers->Applic->setSort("");
				$caregivers->SubApplic->setSort("");
				$caregivers->DateSigned->setSort("");
				$caregivers->colony_id->setSort("");
				$caregivers->mod_by->setSort("");
				$caregivers->mod_date->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$caregivers->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language, $caregivers;

		// "view"
		$item =& $this->ListOptions->Add("view");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = TRUE;
		$item->OnLeft = TRUE;

		// "edit"
		$item =& $this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = TRUE;
		$item->OnLeft = TRUE;

		// "copy"
		$item =& $this->ListOptions->Add("copy");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = TRUE;
		$item->OnLeft = TRUE;

		// "delete"
		$item =& $this->ListOptions->Add("delete");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = TRUE;
		$item->OnLeft = TRUE;

		// Call ListOptions_Load event
		$this->ListOptions_Load();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $caregivers, $objForm;
		$this->ListOptions->LoadDefault();

		// "view"
		$oListOpt =& $this->ListOptions->Items["view"];
		if ($oListOpt->Visible)
			$oListOpt->Body = "<a class=\"ewRowLink\" href=\"" . $this->ViewUrl . "\">" . $Language->Phrase("ViewLink") . "</a>";

		// "edit"
		$oListOpt =& $this->ListOptions->Items["edit"];
		if ($oListOpt->Visible) {
			$oListOpt->Body = "<a class=\"ewRowLink\" href=\"" . $this->EditUrl . "\">" . $Language->Phrase("EditLink") . "</a>";
		}

		// "copy"
		$oListOpt =& $this->ListOptions->Items["copy"];
		if ($oListOpt->Visible) {
			$oListOpt->Body = "<a class=\"ewRowLink\" href=\"" . $this->CopyUrl . "\">" . $Language->Phrase("CopyLink") . "</a>";
		}

		// "delete"
		$oListOpt =& $this->ListOptions->Items["delete"];
		if ($oListOpt->Visible)
			$oListOpt->Body = "<a class=\"ewRowLink\"" . "" . " href=\"" . $this->DeleteUrl . "\">" . $Language->Phrase("DeleteLink") . "</a>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	function RenderListOptionsExt() {
		global $Security, $Language, $caregivers;
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

	// Load basic search values
	function LoadBasicSearchValues() {
		global $caregivers;
		$caregivers->BasicSearchKeyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		$caregivers->BasicSearchType = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
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

	// Load old record
	function LoadOldRecord() {
		global $caregivers;

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($caregivers->getKey("caregiver_id")) <> "")
			$caregivers->caregiver_id->CurrentValue = $caregivers->getKey("caregiver_id"); // caregiver_id
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$caregivers->CurrentFilter = $caregivers->KeyFilter();
			$sSql = $caregivers->SQL();
			$this->OldRecordset = ew_LoadRecordset($sSql);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $caregivers;

		// Initialize URLs
		$this->ViewUrl = $caregivers->ViewUrl();
		$this->EditUrl = $caregivers->EditUrl();
		$this->InlineEditUrl = $caregivers->InlineEditUrl();
		$this->CopyUrl = $caregivers->CopyUrl();
		$this->InlineCopyUrl = $caregivers->InlineCopyUrl();
		$this->DeleteUrl = $caregivers->DeleteUrl();

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
		$item->Body = "<a name=\"emf_caregivers\" id=\"emf_caregivers\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_caregivers',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fcaregiverslist,sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
		$item->Visible = FALSE;

		// Hide options for export/action
		if ($caregivers->Export <> "" ||
			$caregivers->CurrentAction <> "")
			$this->ExportOptions->HideAllOptions();
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		global $caregivers;
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = EW_SELECT_LIMIT;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $caregivers->SelectRecordCount();
		} else {
			if ($rs = $this->LoadRecordset())
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;

		// Export all
		if ($caregivers->ExportAll) {
			$this->DisplayRecs = $this->TotalRecs;
			$this->StopRec = $this->TotalRecs;
		} else { // Export one page only
			$this->SetUpStartRec(); // Set up start record position

			// Set the last record to display
			if ($this->DisplayRecs < 0) {
				$this->StopRec = $this->TotalRecs;
			} else {
				$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
			}
		}
		if ($bSelectLimit)
			$rs = $this->LoadRecordset($this->StartRec-1, $this->DisplayRecs);
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		if ($caregivers->Export == "xml") {
			$XmlDoc = new cXMLDocument(EW_XML_ENCODING);
		} else {
			$ExportDoc = new cExportDocument($caregivers, "h");
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
			$caregivers->ExportXmlDocument($XmlDoc, ($ParentTable <> ""), $rs, $StartRec, $StopRec, "");
		} else {
			$sHeader = $this->PageHeader;
			$this->Page_DataRendering($sHeader);
			$ExportDoc->Text .= $sHeader;
			$caregivers->ExportDocument($ExportDoc, $rs, $StartRec, $StopRec, "");
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

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {
		global $caregivers;
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (@$_GET[EW_TABLE_SHOW_MASTER] <> "") {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "colonies") {
				$bValidMaster = TRUE;
				if (@$_GET["colony_id"] <> "") {
					$GLOBALS["colonies"]->colony_id->setQueryStringValue($_GET["colony_id"]);
					$caregivers->colony_id->setQueryStringValue($GLOBALS["colonies"]->colony_id->QueryStringValue);
					$caregivers->colony_id->setSessionValue($caregivers->colony_id->QueryStringValue);
					if (!is_numeric($GLOBALS["colonies"]->colony_id->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$caregivers->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$caregivers->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "colonies") {
				if ($caregivers->colony_id->QueryStringValue == "") $caregivers->colony_id->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $caregivers->getMasterFilter(); //  Get master filter
		$this->DbDetailFilter = $caregivers->getDetailFilter(); // Get detail filter
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt =& $this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}
}
?>
