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
<?php include_once "userfn8.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
$colonies_list = new ccolonies_list();
$Page =& $colonies_list;

// Page init
$colonies_list->Page_Init();

// Page main
$colonies_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($colonies->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var colonies_list = new ew_Page("colonies_list");

// page properties
colonies_list.PageID = "list"; // page ID
colonies_list.FormID = "fcolonieslist"; // form ID
var EW_PAGE_ID = colonies_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
colonies_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
colonies_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
colonies_list.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php } ?>
<?php if (($colonies->Export == "") || (EW_EXPORT_MASTER_RECORD && $colonies->Export == "print")) { ?>
<?php } ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$colonies_list->TotalRecs = $colonies->SelectRecordCount();
	} else {
		if ($colonies_list->Recordset = $colonies_list->LoadRecordset())
			$colonies_list->TotalRecs = $colonies_list->Recordset->RecordCount();
	}
	$colonies_list->StartRec = 1;
	if ($colonies_list->DisplayRecs <= 0 || ($colonies->Export <> "" && $colonies->ExportAll)) // Display all records
		$colonies_list->DisplayRecs = $colonies_list->TotalRecs;
	if (!($colonies->Export <> "" && $colonies->ExportAll))
		$colonies_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$colonies_list->Recordset = $colonies_list->LoadRecordset($colonies_list->StartRec-1, $colonies_list->DisplayRecs);
?>
<p class="phpmaker ewTitle" style="white-space: nowrap;"><?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $colonies->TableCaption() ?>
&nbsp;&nbsp;<?php $colonies_list->ExportOptions->Render("body"); ?>
</p>
<?php if ($colonies->Export == "" && $colonies->CurrentAction == "") { ?>
<a href="javascript:ew_ToggleSearchPanel(colonies_list);" style="text-decoration: none;"><img id="colonies_list_SearchImage" src="phpimages/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="colonies_list_SearchPanel">
<form name="fcolonieslistsrch" id="fcolonieslistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<input type="hidden" id="t" name="t" value="colonies">
<div class="ewBasicSearch">
<div id="xsr_1" class="ewCssTableRow">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($colonies->getSessionBasicSearchKeyword()) ?>">
	<input type="Submit" name="Submit" id="Submit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
	<a href="<?php echo $colonies_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
</div>
<div id="xsr_2" class="ewCssTableRow">
	<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value=""<?php if ($colonies->getSessionBasicSearchType() == "") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($colonies->getSessionBasicSearchType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($colonies->getSessionBasicSearchType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
</div>
</div>
</form>
</div>
<?php } ?>
<?php $colonies_list->ShowPageHeader(); ?>
<?php
$colonies_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($colonies->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($colonies->CurrentAction <> "gridadd" && $colonies->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($colonies_list->Pager)) $colonies_list->Pager = new cPrevNextPager($colonies_list->StartRec, $colonies_list->DisplayRecs, $colonies_list->TotalRecs) ?>
<?php if ($colonies_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($colonies_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $colonies_list->PageUrl() ?>start=<?php echo $colonies_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($colonies_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $colonies_list->PageUrl() ?>start=<?php echo $colonies_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $colonies_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($colonies_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $colonies_list->PageUrl() ?>start=<?php echo $colonies_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($colonies_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $colonies_list->PageUrl() ?>start=<?php echo $colonies_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $colonies_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $colonies_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $colonies_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $colonies_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($colonies_list->SearchWhere == "0=101") { ?>
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
<a class="ewGridLink" href="<?php echo $colonies_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php if ($vouchers->DetailAdd) { ?>
<a class="ewGridLink" href="<?php echo $colonies->AddUrl() . "?" . EW_TABLE_SHOW_DETAIL . "=vouchers" ?>"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $colonies->TableCaption() ?>/<?php echo $vouchers->TableCaption() ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($caregivers->DetailAdd) { ?>
<a class="ewGridLink" href="<?php echo $colonies->AddUrl() . "?" . EW_TABLE_SHOW_DETAIL . "=caregivers" ?>"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $colonies->TableCaption() ?>/<?php echo $caregivers->TableCaption() ?></a>&nbsp;&nbsp;
<?php } ?>
</span>
</div>
<?php } ?>
<form name="fcolonieslist" id="fcolonieslist" class="ewForm" action="" method="post">
<input type="hidden" name="t" id="t" value="colonies">
<div id="gmp_colonies" class="ewGridMiddlePanel">
<?php if ($colonies_list->TotalRecs > 0) { ?>
<table cellspacing="0" data-rowhighlightclass="ewTableHighlightRow" data-rowselectclass="ewTableSelectRow" data-roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php echo $colonies->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$colonies_list->RenderListOptions();

// Render list options (header, left)
$colonies_list->ListOptions->Render("header", "left");
?>
<?php if ($colonies->colony_id->Visible) { // colony_id ?>
	<?php if ($colonies->SortUrl($colonies->colony_id) == "") { ?>
		<td><?php echo $colonies->colony_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $colonies->SortUrl($colonies->colony_id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $colonies->colony_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($colonies->colony_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($colonies->colony_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($colonies->colony_name->Visible) { // colony_name ?>
	<?php if ($colonies->SortUrl($colonies->colony_name) == "") { ?>
		<td><?php echo $colonies->colony_name->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $colonies->SortUrl($colonies->colony_name) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $colonies->colony_name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($colonies->colony_name->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($colonies->colony_name->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($colonies->colony_address->Visible) { // colony_address ?>
	<?php if ($colonies->SortUrl($colonies->colony_address) == "") { ?>
		<td><?php echo $colonies->colony_address->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $colonies->SortUrl($colonies->colony_address) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $colonies->colony_address->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($colonies->colony_address->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($colonies->colony_address->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($colonies->colony_aptnum->Visible) { // colony_aptnum ?>
	<?php if ($colonies->SortUrl($colonies->colony_aptnum) == "") { ?>
		<td><?php echo $colonies->colony_aptnum->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $colonies->SortUrl($colonies->colony_aptnum) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $colonies->colony_aptnum->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($colonies->colony_aptnum->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($colonies->colony_aptnum->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($colonies->colony_city->Visible) { // colony_city ?>
	<?php if ($colonies->SortUrl($colonies->colony_city) == "") { ?>
		<td><?php echo $colonies->colony_city->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $colonies->SortUrl($colonies->colony_city) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $colonies->colony_city->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($colonies->colony_city->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($colonies->colony_city->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($colonies->colony_county->Visible) { // colony_county ?>
	<?php if ($colonies->SortUrl($colonies->colony_county) == "") { ?>
		<td><?php echo $colonies->colony_county->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $colonies->SortUrl($colonies->colony_county) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $colonies->colony_county->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($colonies->colony_county->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($colonies->colony_county->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($colonies->colony_zip->Visible) { // colony_zip ?>
	<?php if ($colonies->SortUrl($colonies->colony_zip) == "") { ?>
		<td><?php echo $colonies->colony_zip->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $colonies->SortUrl($colonies->colony_zip) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $colonies->colony_zip->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($colonies->colony_zip->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($colonies->colony_zip->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($colonies->NumVouchIssued->Visible) { // NumVouchIssued ?>
	<?php if ($colonies->SortUrl($colonies->NumVouchIssued) == "") { ?>
		<td><?php echo $colonies->NumVouchIssued->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $colonies->SortUrl($colonies->NumVouchIssued) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $colonies->NumVouchIssued->FldCaption() ?></td><td style="width: 10px;"><?php if ($colonies->NumVouchIssued->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($colonies->NumVouchIssued->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($colonies->VoucherStartNum->Visible) { // VoucherStartNum ?>
	<?php if ($colonies->SortUrl($colonies->VoucherStartNum) == "") { ?>
		<td><?php echo $colonies->VoucherStartNum->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $colonies->SortUrl($colonies->VoucherStartNum) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $colonies->VoucherStartNum->FldCaption() ?></td><td style="width: 10px;"><?php if ($colonies->VoucherStartNum->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($colonies->VoucherStartNum->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($colonies->VoucherEndNum->Visible) { // VoucherEndNum ?>
	<?php if ($colonies->SortUrl($colonies->VoucherEndNum) == "") { ?>
		<td><?php echo $colonies->VoucherEndNum->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $colonies->SortUrl($colonies->VoucherEndNum) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $colonies->VoucherEndNum->FldCaption() ?></td><td style="width: 10px;"><?php if ($colonies->VoucherEndNum->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($colonies->VoucherEndNum->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($colonies->trapper->Visible) { // trapper ?>
	<?php if ($colonies->SortUrl($colonies->trapper) == "") { ?>
		<td><?php echo $colonies->trapper->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $colonies->SortUrl($colonies->trapper) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $colonies->trapper->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($colonies->trapper->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($colonies->trapper->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($colonies->notes->Visible) { // notes ?>
	<?php if ($colonies->SortUrl($colonies->notes) == "") { ?>
		<td><?php echo $colonies->notes->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $colonies->SortUrl($colonies->notes) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $colonies->notes->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($colonies->notes->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($colonies->notes->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($colonies->sage->Visible) { // sage ?>
	<?php if ($colonies->SortUrl($colonies->sage) == "") { ?>
		<td><?php echo $colonies->sage->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $colonies->SortUrl($colonies->sage) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $colonies->sage->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($colonies->sage->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($colonies->sage->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($colonies->Inactive->Visible) { // Inactive ?>
	<?php if ($colonies->SortUrl($colonies->Inactive) == "") { ?>
		<td><?php echo $colonies->Inactive->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $colonies->SortUrl($colonies->Inactive) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $colonies->Inactive->FldCaption() ?></td><td style="width: 10px;"><?php if ($colonies->Inactive->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($colonies->Inactive->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($colonies->mod_by->Visible) { // mod_by ?>
	<?php if ($colonies->SortUrl($colonies->mod_by) == "") { ?>
		<td><?php echo $colonies->mod_by->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $colonies->SortUrl($colonies->mod_by) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $colonies->mod_by->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($colonies->mod_by->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($colonies->mod_by->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($colonies->mod_date->Visible) { // mod_date ?>
	<?php if ($colonies->SortUrl($colonies->mod_date) == "") { ?>
		<td><?php echo $colonies->mod_date->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $colonies->SortUrl($colonies->mod_date) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $colonies->mod_date->FldCaption() ?></td><td style="width: 10px;"><?php if ($colonies->mod_date->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($colonies->mod_date->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$colonies_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<?php
if ($colonies->ExportAll && $colonies->Export <> "") {
	$colonies_list->StopRec = $colonies_list->TotalRecs;
} else {

	// Set the last record to display
	if ($colonies_list->TotalRecs > $colonies_list->StartRec + $colonies_list->DisplayRecs - 1)
		$colonies_list->StopRec = $colonies_list->StartRec + $colonies_list->DisplayRecs - 1;
	else
		$colonies_list->StopRec = $colonies_list->TotalRecs;
}
$colonies_list->RecCnt = $colonies_list->StartRec - 1;
if ($colonies_list->Recordset && !$colonies_list->Recordset->EOF) {
	$colonies_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $colonies_list->StartRec > 1)
		$colonies_list->Recordset->Move($colonies_list->StartRec - 1);
} elseif (!$colonies->AllowAddDeleteRow && $colonies_list->StopRec == 0) {
	$colonies_list->StopRec = $colonies->GridAddRowCount;
}

// Initialize aggregate
$colonies->RowType = EW_ROWTYPE_AGGREGATEINIT;
$colonies->ResetAttrs();
$colonies_list->RenderRow();
$colonies_list->RowCnt = 0;
while ($colonies_list->RecCnt < $colonies_list->StopRec) {
	$colonies_list->RecCnt++;
	if (intval($colonies_list->RecCnt) >= intval($colonies_list->StartRec)) {
		$colonies_list->RowCnt++;

		// Set up key count
		$colonies_list->KeyCount = $colonies_list->RowIndex;

		// Init row class and style
		$colonies->ResetAttrs();
		$colonies->CssClass = "";
		if ($colonies->CurrentAction == "gridadd") {
		} else {
			$colonies_list->LoadRowValues($colonies_list->Recordset); // Load row values
		}
		$colonies->RowType = EW_ROWTYPE_VIEW; // Render view
		$colonies->RowAttrs = array('onmouseover'=>'ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);');

		// Render row
		$colonies_list->RenderRow();

		// Render list options
		$colonies_list->RenderListOptions();
?>
	<tr<?php echo $colonies->RowAttributes() ?>>
<?php

// Render list options (body, left)
$colonies_list->ListOptions->Render("body", "left");
?>
	<?php if ($colonies->colony_id->Visible) { // colony_id ?>
		<td<?php echo $colonies->colony_id->CellAttributes() ?>>
<div<?php echo $colonies->colony_id->ViewAttributes() ?>><?php echo $colonies->colony_id->ListViewValue() ?></div>
<a name="<?php echo $colonies_list->PageObjName . "_row_" . $colonies_list->RowCnt ?>" id="<?php echo $colonies_list->PageObjName . "_row_" . $colonies_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($colonies->colony_name->Visible) { // colony_name ?>
		<td<?php echo $colonies->colony_name->CellAttributes() ?>>
<div<?php echo $colonies->colony_name->ViewAttributes() ?>><?php echo $colonies->colony_name->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($colonies->colony_address->Visible) { // colony_address ?>
		<td<?php echo $colonies->colony_address->CellAttributes() ?>>
<div<?php echo $colonies->colony_address->ViewAttributes() ?>><?php echo $colonies->colony_address->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($colonies->colony_aptnum->Visible) { // colony_aptnum ?>
		<td<?php echo $colonies->colony_aptnum->CellAttributes() ?>>
<div<?php echo $colonies->colony_aptnum->ViewAttributes() ?>><?php echo $colonies->colony_aptnum->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($colonies->colony_city->Visible) { // colony_city ?>
		<td<?php echo $colonies->colony_city->CellAttributes() ?>>
<div<?php echo $colonies->colony_city->ViewAttributes() ?>><?php echo $colonies->colony_city->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($colonies->colony_county->Visible) { // colony_county ?>
		<td<?php echo $colonies->colony_county->CellAttributes() ?>>
<div<?php echo $colonies->colony_county->ViewAttributes() ?>><?php echo $colonies->colony_county->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($colonies->colony_zip->Visible) { // colony_zip ?>
		<td<?php echo $colonies->colony_zip->CellAttributes() ?>>
<div<?php echo $colonies->colony_zip->ViewAttributes() ?>><?php echo $colonies->colony_zip->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($colonies->NumVouchIssued->Visible) { // NumVouchIssued ?>
		<td<?php echo $colonies->NumVouchIssued->CellAttributes() ?>>
<div<?php echo $colonies->NumVouchIssued->ViewAttributes() ?>><?php echo $colonies->NumVouchIssued->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($colonies->VoucherStartNum->Visible) { // VoucherStartNum ?>
		<td<?php echo $colonies->VoucherStartNum->CellAttributes() ?>>
<div<?php echo $colonies->VoucherStartNum->ViewAttributes() ?>><?php echo $colonies->VoucherStartNum->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($colonies->VoucherEndNum->Visible) { // VoucherEndNum ?>
		<td<?php echo $colonies->VoucherEndNum->CellAttributes() ?>>
<div<?php echo $colonies->VoucherEndNum->ViewAttributes() ?>><?php echo $colonies->VoucherEndNum->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($colonies->trapper->Visible) { // trapper ?>
		<td<?php echo $colonies->trapper->CellAttributes() ?>>
<div<?php echo $colonies->trapper->ViewAttributes() ?>><?php echo $colonies->trapper->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($colonies->notes->Visible) { // notes ?>
		<td<?php echo $colonies->notes->CellAttributes() ?>>
<div<?php echo $colonies->notes->ViewAttributes() ?>><?php echo $colonies->notes->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($colonies->sage->Visible) { // sage ?>
		<td<?php echo $colonies->sage->CellAttributes() ?>>
<div<?php echo $colonies->sage->ViewAttributes() ?>><?php echo $colonies->sage->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($colonies->Inactive->Visible) { // Inactive ?>
		<td<?php echo $colonies->Inactive->CellAttributes() ?>>
<div<?php echo $colonies->Inactive->ViewAttributes() ?>><?php echo $colonies->Inactive->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($colonies->mod_by->Visible) { // mod_by ?>
		<td<?php echo $colonies->mod_by->CellAttributes() ?>>
<div<?php echo $colonies->mod_by->ViewAttributes() ?>><?php echo $colonies->mod_by->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($colonies->mod_date->Visible) { // mod_date ?>
		<td<?php echo $colonies->mod_date->CellAttributes() ?>>
<div<?php echo $colonies->mod_date->ViewAttributes() ?>><?php echo $colonies->mod_date->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$colonies_list->ListOptions->Render("body", "right");
?>
	</tr>
<?php
	}
	if ($colonies->CurrentAction <> "gridadd")
		$colonies_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($colonies_list->Recordset)
	$colonies_list->Recordset->Close();
?>
<?php if ($colonies_list->TotalRecs > 0) { ?>
<?php if ($colonies->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($colonies->CurrentAction <> "gridadd" && $colonies->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($colonies_list->Pager)) $colonies_list->Pager = new cPrevNextPager($colonies_list->StartRec, $colonies_list->DisplayRecs, $colonies_list->TotalRecs) ?>
<?php if ($colonies_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($colonies_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $colonies_list->PageUrl() ?>start=<?php echo $colonies_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($colonies_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $colonies_list->PageUrl() ?>start=<?php echo $colonies_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $colonies_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($colonies_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $colonies_list->PageUrl() ?>start=<?php echo $colonies_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($colonies_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $colonies_list->PageUrl() ?>start=<?php echo $colonies_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $colonies_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $colonies_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $colonies_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $colonies_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($colonies_list->SearchWhere == "0=101") { ?>
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
<a class="ewGridLink" href="<?php echo $colonies_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php if ($vouchers->DetailAdd) { ?>
<a class="ewGridLink" href="<?php echo $colonies->AddUrl() . "?" . EW_TABLE_SHOW_DETAIL . "=vouchers" ?>"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $colonies->TableCaption() ?>/<?php echo $vouchers->TableCaption() ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($caregivers->DetailAdd) { ?>
<a class="ewGridLink" href="<?php echo $colonies->AddUrl() . "?" . EW_TABLE_SHOW_DETAIL . "=caregivers" ?>"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $colonies->TableCaption() ?>/<?php echo $caregivers->TableCaption() ?></a>&nbsp;&nbsp;
<?php } ?>
</span>
</div>
<?php } ?>
<?php } ?>
</td></tr></table>
<?php if ($colonies->Export == "" && $colonies->CurrentAction == "") { ?>
<?php } ?>
<?php
$colonies_list->ShowPageFooter();
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
$colonies_list->Page_Terminate();
?>
<?php

//
// Page class
//
class ccolonies_list {

	// Page ID
	var $PageID = 'list';

	// Table name
	var $TableName = 'colonies';

	// Page object name
	var $PageObjName = 'colonies_list';

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
	function ccolonies_list() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (colonies)
		if (!isset($GLOBALS["colonies"])) {
			$GLOBALS["colonies"] = new ccolonies();
			$GLOBALS["Table"] =& $GLOBALS["colonies"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "coloniesadd.php?" . EW_TABLE_SHOW_DETAIL . "=";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "coloniesdelete.php";
		$this->MultiUpdateUrl = "coloniesupdate.php";

		// Table object (caregivers)
		if (!isset($GLOBALS['caregivers'])) $GLOBALS['caregivers'] = new ccaregivers();

		// Table object (vouchers)
		if (!isset($GLOBALS['vouchers'])) $GLOBALS['vouchers'] = new cvouchers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'colonies', TRUE);

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
		if ($colonies->Export == "csv") {
			header('Content-Type: application/csv' . $Charset);
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.csv');
		}

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$colonies->GridAddRowCount = $gridaddcnt;

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
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security, $colonies;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";
		if ($this->IsPageRequest()) { // Validate request

			// Handle reset command
			$this->ResetCmd();

			// Hide all options
			if ($colonies->Export <> "" ||
				$colonies->CurrentAction == "gridadd" ||
				$colonies->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ExportOptions->HideAllOptions();
			}

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Restore search parms from Session
			$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$colonies->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($colonies->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $colonies->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$colonies->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->SearchWhere <> "") {
			if ($sSrchBasic == "")
				$this->ResetBasicSearchParms();
			$colonies->setSearchWhere($this->SearchWhere); // Save to Session
			if (!$this->RestoreSearch) {
				$this->StartRec = 1; // Reset start record counter
				$colonies->setStartRecordNumber($this->StartRec);
			}
		} else {
			$this->SearchWhere = $colonies->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter in session
		$colonies->setSessionWhere($sFilter);
		$colonies->CurrentFilter = "";

		// Export data only
		if (in_array($colonies->Export, array("html","word","excel","xml","csv","email","pdf"))) {
			$this->ExportData();
			if ($colonies->Export <> "email")
				$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Return basic search SQL
	function BasicSearchSQL($Keyword) {
		global $colonies;
		$sKeyword = ew_AdjustSql($Keyword);
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $colonies->colony_name, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $colonies->colony_address, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $colonies->colony_aptnum, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $colonies->colony_city, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $colonies->colony_county, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $colonies->colony_zip, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $colonies->trapper, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $colonies->notes, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $colonies->sage, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $colonies->mod_by, $Keyword);
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
		global $Security, $colonies;
		$sSearchStr = "";
		$sSearchKeyword = $colonies->BasicSearchKeyword;
		$sSearchType = $colonies->BasicSearchType;
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
			$colonies->setSessionBasicSearchKeyword($sSearchKeyword);
			$colonies->setSessionBasicSearchType($sSearchType);
		}
		return $sSearchStr;
	}

	// Clear all search parameters
	function ResetSearchParms() {
		global $colonies;

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$colonies->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		global $colonies;
		$colonies->setSessionBasicSearchKeyword("");
		$colonies->setSessionBasicSearchType("");
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		global $colonies;
		$bRestore = TRUE;
		if ($colonies->BasicSearchKeyword <> "") $bRestore = FALSE;
		$this->RestoreSearch = $bRestore;
		if ($bRestore) {

			// Restore basic search values
			$colonies->BasicSearchKeyword = $colonies->getSessionBasicSearchKeyword();
			$colonies->BasicSearchType = $colonies->getSessionBasicSearchType();
		}
	}

	// Set up sort parameters
	function SetUpSortOrder() {
		global $colonies;

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$colonies->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$colonies->CurrentOrderType = @$_GET["ordertype"];
			$colonies->UpdateSort($colonies->colony_id); // colony_id
			$colonies->UpdateSort($colonies->colony_name); // colony_name
			$colonies->UpdateSort($colonies->colony_address); // colony_address
			$colonies->UpdateSort($colonies->colony_aptnum); // colony_aptnum
			$colonies->UpdateSort($colonies->colony_city); // colony_city
			$colonies->UpdateSort($colonies->colony_county); // colony_county
			$colonies->UpdateSort($colonies->colony_zip); // colony_zip
			$colonies->UpdateSort($colonies->NumVouchIssued); // NumVouchIssued
			$colonies->UpdateSort($colonies->VoucherStartNum); // VoucherStartNum
			$colonies->UpdateSort($colonies->VoucherEndNum); // VoucherEndNum
			$colonies->UpdateSort($colonies->trapper); // trapper
			$colonies->UpdateSort($colonies->notes); // notes
			$colonies->UpdateSort($colonies->sage); // sage
			$colonies->UpdateSort($colonies->Inactive); // Inactive
			$colonies->UpdateSort($colonies->mod_by); // mod_by
			$colonies->UpdateSort($colonies->mod_date); // mod_date
			$colonies->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		global $colonies;
		$sOrderBy = $colonies->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($colonies->SqlOrderBy() <> "") {
				$sOrderBy = $colonies->SqlOrderBy();
				$colonies->setSessionOrderBy($sOrderBy);
				$colonies->colony_id->setSort("DESC");
			}
		}
	}

	// Reset command
	// cmd=reset (Reset search parameters)
	// cmd=resetall (Reset search and master/detail parameters)
	// cmd=resetsort (Reset sort parameters)
	function ResetCmd() {
		global $colonies;

		// Get reset command
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset search criteria
			if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$colonies->setSessionOrderBy($sOrderBy);
				$colonies->colony_id->setSort("");
				$colonies->colony_name->setSort("");
				$colonies->colony_address->setSort("");
				$colonies->colony_aptnum->setSort("");
				$colonies->colony_city->setSort("");
				$colonies->colony_county->setSort("");
				$colonies->colony_zip->setSort("");
				$colonies->NumVouchIssued->setSort("");
				$colonies->VoucherStartNum->setSort("");
				$colonies->VoucherEndNum->setSort("");
				$colonies->trapper->setSort("");
				$colonies->notes->setSort("");
				$colonies->sage->setSort("");
				$colonies->Inactive->setSort("");
				$colonies->mod_by->setSort("");
				$colonies->mod_date->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$colonies->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language, $colonies;

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

		// "detail_vouchers"
		$item =& $this->ListOptions->Add("detail_vouchers");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = True;
		$item->OnLeft = TRUE;

		// "detail_caregivers"
		$item =& $this->ListOptions->Add("detail_caregivers");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = True;
		$item->OnLeft = TRUE;

		// Call ListOptions_Load event
		$this->ListOptions_Load();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $colonies, $objForm;
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

		// "detail_vouchers"
		$oListOpt =& $this->ListOptions->Items["detail_vouchers"];
		if (True) {
			$oListOpt->Body = $Language->Phrase("DetailLink") . $Language->TablePhrase("vouchers", "TblCaption");
			$oListOpt->Body = "<a class=\"ewRowLink\" href=\"voucherslist.php?" . EW_TABLE_SHOW_MASTER . "=colonies&colony_id=" . urlencode(strval($colonies->colony_id->CurrentValue)) . "\">" . $oListOpt->Body . "</a>";
			$links = "";
			if ($GLOBALS["vouchers"]->DetailEdit)
				$links .= "<a class=\"ewRowLink\" href=\"" . $colonies->EditUrl(EW_TABLE_SHOW_DETAIL . "=vouchers") . "\">" . $Language->Phrase("EditLink") . "</a>&nbsp;";
			if ($GLOBALS["vouchers"]->DetailAdd)
				$links .= "<a class=\"ewRowLink\" href=\"" . $colonies->CopyUrl(EW_TABLE_SHOW_DETAIL . "=vouchers") . "\">" . $Language->Phrase("CopyLink") . "</a>&nbsp;";
			if ($links <> "") $oListOpt->Body .= "<br>" . $links;
		}

		// "detail_caregivers"
		$oListOpt =& $this->ListOptions->Items["detail_caregivers"];
		if (True) {
			$oListOpt->Body = $Language->Phrase("DetailLink") . $Language->TablePhrase("caregivers", "TblCaption");
			$oListOpt->Body = "<a class=\"ewRowLink\" href=\"caregiverslist.php?" . EW_TABLE_SHOW_MASTER . "=colonies&colony_id=" . urlencode(strval($colonies->colony_id->CurrentValue)) . "\">" . $oListOpt->Body . "</a>";
			$links = "";
			if ($GLOBALS["caregivers"]->DetailEdit)
				$links .= "<a class=\"ewRowLink\" href=\"" . $colonies->EditUrl(EW_TABLE_SHOW_DETAIL . "=caregivers") . "\">" . $Language->Phrase("EditLink") . "</a>&nbsp;";
			if ($GLOBALS["caregivers"]->DetailAdd)
				$links .= "<a class=\"ewRowLink\" href=\"" . $colonies->CopyUrl(EW_TABLE_SHOW_DETAIL . "=caregivers") . "\">" . $Language->Phrase("CopyLink") . "</a>&nbsp;";
			if ($links <> "") $oListOpt->Body .= "<br>" . $links;
		}
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	function RenderListOptionsExt() {
		global $Security, $Language, $colonies;
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

	// Load basic search values
	function LoadBasicSearchValues() {
		global $colonies;
		$colonies->BasicSearchKeyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		$colonies->BasicSearchType = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
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
		$this->ViewUrl = $colonies->ViewUrl();
		$this->EditUrl = $colonies->EditUrl();
		$this->InlineEditUrl = $colonies->InlineEditUrl();
		$this->CopyUrl = $colonies->CopyUrl();
		$this->InlineCopyUrl = $colonies->InlineCopyUrl();
		$this->DeleteUrl = $colonies->DeleteUrl();

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
		$item->Body = "<a name=\"emf_colonies\" id=\"emf_colonies\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_colonies',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fcolonieslist,sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
		$item->Visible = FALSE;

		// Hide options for export/action
		if ($colonies->Export <> "" ||
			$colonies->CurrentAction <> "")
			$this->ExportOptions->HideAllOptions();
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		global $colonies;
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = EW_SELECT_LIMIT;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $colonies->SelectRecordCount();
		} else {
			if ($rs = $this->LoadRecordset())
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;

		// Export all
		if ($colonies->ExportAll) {
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
		if ($colonies->Export == "xml") {
			$XmlDoc = new cXMLDocument(EW_XML_ENCODING);
		} else {
			$ExportDoc = new cExportDocument($colonies, "h");
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
			$colonies->ExportXmlDocument($XmlDoc, ($ParentTable <> ""), $rs, $StartRec, $StopRec, "");
		} else {
			$sHeader = $this->PageHeader;
			$this->Page_DataRendering($sHeader);
			$ExportDoc->Text .= $sHeader;
			$colonies->ExportDocument($ExportDoc, $rs, $StartRec, $StopRec, "");
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
