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
$vouchers_list = new cvouchers_list();
$Page =& $vouchers_list;

// Page init
$vouchers_list->Page_Init();

// Page main
$vouchers_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($vouchers->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var vouchers_list = new ew_Page("vouchers_list");

// page properties
vouchers_list.PageID = "list"; // page ID
vouchers_list.FormID = "fvoucherslist"; // form ID
var EW_PAGE_ID = vouchers_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
vouchers_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
vouchers_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
vouchers_list.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php } ?>
<?php if (($vouchers->Export == "") || (EW_EXPORT_MASTER_RECORD && $vouchers->Export == "print")) { ?>
<?php
$gsMasterReturnUrl = "colonieslist.php";
if ($vouchers_list->DbMasterFilter <> "" && $vouchers->getCurrentMasterTable() == "colonies") {
	if ($vouchers_list->MasterRecordExists) {
		if ($vouchers->getCurrentMasterTable() == $vouchers->TableVar) $gsMasterReturnUrl .= "?" . EW_TABLE_SHOW_MASTER . "=";
?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("MasterRecord") ?><?php echo $colonies->TableCaption() ?>
&nbsp;&nbsp;<?php $vouchers_list->ExportOptions->Render("body"); ?>
</p>
<?php if ($vouchers->Export == "") { ?>
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
		$vouchers_list->TotalRecs = $vouchers->SelectRecordCount();
	} else {
		if ($vouchers_list->Recordset = $vouchers_list->LoadRecordset())
			$vouchers_list->TotalRecs = $vouchers_list->Recordset->RecordCount();
	}
	$vouchers_list->StartRec = 1;
	if ($vouchers_list->DisplayRecs <= 0 || ($vouchers->Export <> "" && $vouchers->ExportAll)) // Display all records
		$vouchers_list->DisplayRecs = $vouchers_list->TotalRecs;
	if (!($vouchers->Export <> "" && $vouchers->ExportAll))
		$vouchers_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$vouchers_list->Recordset = $vouchers_list->LoadRecordset($vouchers_list->StartRec-1, $vouchers_list->DisplayRecs);
?>
<p class="phpmaker ewTitle" style="white-space: nowrap;"><?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $vouchers->TableCaption() ?>
<?php if ($vouchers->getCurrentMasterTable() == "") { ?>
&nbsp;&nbsp;<?php $vouchers_list->ExportOptions->Render("body"); ?>
<?php } ?>
</p>
<?php if ($vouchers->Export == "" && $vouchers->CurrentAction == "") { ?>
<a href="javascript:ew_ToggleSearchPanel(vouchers_list);" style="text-decoration: none;"><img id="vouchers_list_SearchImage" src="phpimages/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="vouchers_list_SearchPanel">
<form name="fvoucherslistsrch" id="fvoucherslistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<input type="hidden" id="t" name="t" value="vouchers">
<div class="ewBasicSearch">
<div id="xsr_1" class="ewCssTableRow">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($vouchers->getSessionBasicSearchKeyword()) ?>">
	<input type="Submit" name="Submit" id="Submit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
	<a href="<?php echo $vouchers_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
</div>
<div id="xsr_2" class="ewCssTableRow">
	<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value=""<?php if ($vouchers->getSessionBasicSearchType() == "") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($vouchers->getSessionBasicSearchType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($vouchers->getSessionBasicSearchType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
</div>
</div>
</form>
</div>
<?php } ?>
<?php $vouchers_list->ShowPageHeader(); ?>
<?php
$vouchers_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($vouchers->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($vouchers->CurrentAction <> "gridadd" && $vouchers->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($vouchers_list->Pager)) $vouchers_list->Pager = new cPrevNextPager($vouchers_list->StartRec, $vouchers_list->DisplayRecs, $vouchers_list->TotalRecs) ?>
<?php if ($vouchers_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($vouchers_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $vouchers_list->PageUrl() ?>start=<?php echo $vouchers_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($vouchers_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $vouchers_list->PageUrl() ?>start=<?php echo $vouchers_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $vouchers_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($vouchers_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $vouchers_list->PageUrl() ?>start=<?php echo $vouchers_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($vouchers_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $vouchers_list->PageUrl() ?>start=<?php echo $vouchers_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $vouchers_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $vouchers_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $vouchers_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $vouchers_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($vouchers_list->SearchWhere == "0=101") { ?>
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
<a class="ewGridLink" href="<?php echo $vouchers_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
</span>
</div>
<?php } ?>
<form name="fvoucherslist" id="fvoucherslist" class="ewForm" action="" method="post">
<input type="hidden" name="t" id="t" value="vouchers">
<div id="gmp_vouchers" class="ewGridMiddlePanel">
<?php if ($vouchers_list->TotalRecs > 0) { ?>
<table cellspacing="0" data-rowhighlightclass="ewTableHighlightRow" data-rowselectclass="ewTableSelectRow" data-roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php echo $vouchers->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$vouchers_list->RenderListOptions();

// Render list options (header, left)
$vouchers_list->ListOptions->Render("header", "left");
?>
<?php if ($vouchers->id->Visible) { // id ?>
	<?php if ($vouchers->SortUrl($vouchers->id) == "") { ?>
		<td><?php echo $vouchers->id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vouchers->SortUrl($vouchers->id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->id->FldCaption() ?></td><td style="width: 10px;"><?php if ($vouchers->id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->VoucherNumber->Visible) { // VoucherNumber ?>
	<?php if ($vouchers->SortUrl($vouchers->VoucherNumber) == "") { ?>
		<td><?php echo $vouchers->VoucherNumber->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vouchers->SortUrl($vouchers->VoucherNumber) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->VoucherNumber->FldCaption() ?></td><td style="width: 10px;"><?php if ($vouchers->VoucherNumber->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->VoucherNumber->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->ExpireDate->Visible) { // ExpireDate ?>
	<?php if ($vouchers->SortUrl($vouchers->ExpireDate) == "") { ?>
		<td><?php echo $vouchers->ExpireDate->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vouchers->SortUrl($vouchers->ExpireDate) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->ExpireDate->FldCaption() ?></td><td style="width: 10px;"><?php if ($vouchers->ExpireDate->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->ExpireDate->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->IssuedByFirst->Visible) { // IssuedByFirst ?>
	<?php if ($vouchers->SortUrl($vouchers->IssuedByFirst) == "") { ?>
		<td><?php echo $vouchers->IssuedByFirst->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vouchers->SortUrl($vouchers->IssuedByFirst) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->IssuedByFirst->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($vouchers->IssuedByFirst->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->IssuedByFirst->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->IssuedByLast->Visible) { // IssuedByLast ?>
	<?php if ($vouchers->SortUrl($vouchers->IssuedByLast) == "") { ?>
		<td><?php echo $vouchers->IssuedByLast->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vouchers->SortUrl($vouchers->IssuedByLast) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->IssuedByLast->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($vouchers->IssuedByLast->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->IssuedByLast->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->FirstName->Visible) { // FirstName ?>
	<?php if ($vouchers->SortUrl($vouchers->FirstName) == "") { ?>
		<td><?php echo $vouchers->FirstName->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vouchers->SortUrl($vouchers->FirstName) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->FirstName->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($vouchers->FirstName->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->FirstName->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->LastName->Visible) { // LastName ?>
	<?php if ($vouchers->SortUrl($vouchers->LastName) == "") { ?>
		<td><?php echo $vouchers->LastName->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vouchers->SortUrl($vouchers->LastName) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->LastName->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($vouchers->LastName->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->LastName->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->Program->Visible) { // Program ?>
	<?php if ($vouchers->SortUrl($vouchers->Program) == "") { ?>
		<td><?php echo $vouchers->Program->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vouchers->SortUrl($vouchers->Program) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->Program->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($vouchers->Program->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->Program->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->cat_name->Visible) { // cat_name ?>
	<?php if ($vouchers->SortUrl($vouchers->cat_name) == "") { ?>
		<td><?php echo $vouchers->cat_name->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vouchers->SortUrl($vouchers->cat_name) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->cat_name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($vouchers->cat_name->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->cat_name->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->cat_breed->Visible) { // cat_breed ?>
	<?php if ($vouchers->SortUrl($vouchers->cat_breed) == "") { ?>
		<td><?php echo $vouchers->cat_breed->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vouchers->SortUrl($vouchers->cat_breed) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->cat_breed->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($vouchers->cat_breed->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->cat_breed->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->cat_age->Visible) { // cat_age ?>
	<?php if ($vouchers->SortUrl($vouchers->cat_age) == "") { ?>
		<td><?php echo $vouchers->cat_age->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vouchers->SortUrl($vouchers->cat_age) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->cat_age->FldCaption() ?></td><td style="width: 10px;"><?php if ($vouchers->cat_age->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->cat_age->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->copay->Visible) { // copay ?>
	<?php if ($vouchers->SortUrl($vouchers->copay) == "") { ?>
		<td><?php echo $vouchers->copay->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vouchers->SortUrl($vouchers->copay) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->copay->FldCaption() ?></td><td style="width: 10px;"><?php if ($vouchers->copay->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->copay->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->cat_status->Visible) { // cat_status ?>
	<?php if ($vouchers->SortUrl($vouchers->cat_status) == "") { ?>
		<td><?php echo $vouchers->cat_status->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vouchers->SortUrl($vouchers->cat_status) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->cat_status->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($vouchers->cat_status->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->cat_status->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->date_redeemed->Visible) { // date_redeemed ?>
	<?php if ($vouchers->SortUrl($vouchers->date_redeemed) == "") { ?>
		<td><?php echo $vouchers->date_redeemed->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vouchers->SortUrl($vouchers->date_redeemed) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->date_redeemed->FldCaption() ?></td><td style="width: 10px;"><?php if ($vouchers->date_redeemed->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->date_redeemed->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->Clinic->Visible) { // Clinic ?>
	<?php if ($vouchers->SortUrl($vouchers->Clinic) == "") { ?>
		<td><?php echo $vouchers->Clinic->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vouchers->SortUrl($vouchers->Clinic) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->Clinic->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($vouchers->Clinic->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->Clinic->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->ClinicPrice->Visible) { // ClinicPrice ?>
	<?php if ($vouchers->SortUrl($vouchers->ClinicPrice) == "") { ?>
		<td><?php echo $vouchers->ClinicPrice->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vouchers->SortUrl($vouchers->ClinicPrice) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->ClinicPrice->FldCaption() ?></td><td style="width: 10px;"><?php if ($vouchers->ClinicPrice->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->ClinicPrice->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->vet_used->Visible) { // vet_used ?>
	<?php if ($vouchers->SortUrl($vouchers->vet_used) == "") { ?>
		<td><?php echo $vouchers->vet_used->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vouchers->SortUrl($vouchers->vet_used) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->vet_used->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($vouchers->vet_used->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->vet_used->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->colony_id->Visible) { // colony_id ?>
	<?php if ($vouchers->SortUrl($vouchers->colony_id) == "") { ?>
		<td><?php echo $vouchers->colony_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vouchers->SortUrl($vouchers->colony_id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->colony_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($vouchers->colony_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->colony_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->Spay->Visible) { // Spay ?>
	<?php if ($vouchers->SortUrl($vouchers->Spay) == "") { ?>
		<td><?php echo $vouchers->Spay->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vouchers->SortUrl($vouchers->Spay) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->Spay->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($vouchers->Spay->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->Spay->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->Neuter->Visible) { // Neuter ?>
	<?php if ($vouchers->SortUrl($vouchers->Neuter) == "") { ?>
		<td><?php echo $vouchers->Neuter->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vouchers->SortUrl($vouchers->Neuter) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->Neuter->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($vouchers->Neuter->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->Neuter->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->FVRCP->Visible) { // FVRCP ?>
	<?php if ($vouchers->SortUrl($vouchers->FVRCP) == "") { ?>
		<td><?php echo $vouchers->FVRCP->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vouchers->SortUrl($vouchers->FVRCP) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->FVRCP->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($vouchers->FVRCP->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->FVRCP->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->FELV->Visible) { // FELV ?>
	<?php if ($vouchers->SortUrl($vouchers->FELV) == "") { ?>
		<td><?php echo $vouchers->FELV->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vouchers->SortUrl($vouchers->FELV) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->FELV->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($vouchers->FELV->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->FELV->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->Rabies->Visible) { // Rabies ?>
	<?php if ($vouchers->SortUrl($vouchers->Rabies) == "") { ?>
		<td><?php echo $vouchers->Rabies->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vouchers->SortUrl($vouchers->Rabies) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->Rabies->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($vouchers->Rabies->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->Rabies->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->Pregnant->Visible) { // Pregnant ?>
	<?php if ($vouchers->SortUrl($vouchers->Pregnant) == "") { ?>
		<td><?php echo $vouchers->Pregnant->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vouchers->SortUrl($vouchers->Pregnant) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->Pregnant->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($vouchers->Pregnant->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->Pregnant->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->AssignedTo->Visible) { // AssignedTo ?>
	<?php if ($vouchers->SortUrl($vouchers->AssignedTo) == "") { ?>
		<td><?php echo $vouchers->AssignedTo->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vouchers->SortUrl($vouchers->AssignedTo) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->AssignedTo->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($vouchers->AssignedTo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->AssignedTo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->mod_by->Visible) { // mod_by ?>
	<?php if ($vouchers->SortUrl($vouchers->mod_by) == "") { ?>
		<td><?php echo $vouchers->mod_by->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vouchers->SortUrl($vouchers->mod_by) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->mod_by->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($vouchers->mod_by->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->mod_by->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->mod_date->Visible) { // mod_date ?>
	<?php if ($vouchers->SortUrl($vouchers->mod_date) == "") { ?>
		<td><?php echo $vouchers->mod_date->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vouchers->SortUrl($vouchers->mod_date) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->mod_date->FldCaption() ?></td><td style="width: 10px;"><?php if ($vouchers->mod_date->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->mod_date->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$vouchers_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<?php
if ($vouchers->ExportAll && $vouchers->Export <> "") {
	$vouchers_list->StopRec = $vouchers_list->TotalRecs;
} else {

	// Set the last record to display
	if ($vouchers_list->TotalRecs > $vouchers_list->StartRec + $vouchers_list->DisplayRecs - 1)
		$vouchers_list->StopRec = $vouchers_list->StartRec + $vouchers_list->DisplayRecs - 1;
	else
		$vouchers_list->StopRec = $vouchers_list->TotalRecs;
}
$vouchers_list->RecCnt = $vouchers_list->StartRec - 1;
if ($vouchers_list->Recordset && !$vouchers_list->Recordset->EOF) {
	$vouchers_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $vouchers_list->StartRec > 1)
		$vouchers_list->Recordset->Move($vouchers_list->StartRec - 1);
} elseif (!$vouchers->AllowAddDeleteRow && $vouchers_list->StopRec == 0) {
	$vouchers_list->StopRec = $vouchers->GridAddRowCount;
}

// Initialize aggregate
$vouchers->RowType = EW_ROWTYPE_AGGREGATEINIT;
$vouchers->ResetAttrs();
$vouchers_list->RenderRow();
$vouchers_list->RowCnt = 0;
while ($vouchers_list->RecCnt < $vouchers_list->StopRec) {
	$vouchers_list->RecCnt++;
	if (intval($vouchers_list->RecCnt) >= intval($vouchers_list->StartRec)) {
		$vouchers_list->RowCnt++;

		// Set up key count
		$vouchers_list->KeyCount = $vouchers_list->RowIndex;

		// Init row class and style
		$vouchers->ResetAttrs();
		$vouchers->CssClass = "";
		if ($vouchers->CurrentAction == "gridadd") {
		} else {
			$vouchers_list->LoadRowValues($vouchers_list->Recordset); // Load row values
		}
		$vouchers->RowType = EW_ROWTYPE_VIEW; // Render view
		$vouchers->RowAttrs = array('onmouseover'=>'ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);');

		// Render row
		$vouchers_list->RenderRow();

		// Render list options
		$vouchers_list->RenderListOptions();
?>
	<tr<?php echo $vouchers->RowAttributes() ?>>
<?php

// Render list options (body, left)
$vouchers_list->ListOptions->Render("body", "left");
?>
	<?php if ($vouchers->id->Visible) { // id ?>
		<td<?php echo $vouchers->id->CellAttributes() ?>>
<div<?php echo $vouchers->id->ViewAttributes() ?>><?php echo $vouchers->id->ListViewValue() ?></div>
<a name="<?php echo $vouchers_list->PageObjName . "_row_" . $vouchers_list->RowCnt ?>" id="<?php echo $vouchers_list->PageObjName . "_row_" . $vouchers_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($vouchers->VoucherNumber->Visible) { // VoucherNumber ?>
		<td<?php echo $vouchers->VoucherNumber->CellAttributes() ?>>
<div<?php echo $vouchers->VoucherNumber->ViewAttributes() ?>><?php echo $vouchers->VoucherNumber->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vouchers->ExpireDate->Visible) { // ExpireDate ?>
		<td<?php echo $vouchers->ExpireDate->CellAttributes() ?>>
<div<?php echo $vouchers->ExpireDate->ViewAttributes() ?>><?php echo $vouchers->ExpireDate->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vouchers->IssuedByFirst->Visible) { // IssuedByFirst ?>
		<td<?php echo $vouchers->IssuedByFirst->CellAttributes() ?>>
<div<?php echo $vouchers->IssuedByFirst->ViewAttributes() ?>><?php echo $vouchers->IssuedByFirst->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vouchers->IssuedByLast->Visible) { // IssuedByLast ?>
		<td<?php echo $vouchers->IssuedByLast->CellAttributes() ?>>
<div<?php echo $vouchers->IssuedByLast->ViewAttributes() ?>><?php echo $vouchers->IssuedByLast->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vouchers->FirstName->Visible) { // FirstName ?>
		<td<?php echo $vouchers->FirstName->CellAttributes() ?>>
<div<?php echo $vouchers->FirstName->ViewAttributes() ?>><?php echo $vouchers->FirstName->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vouchers->LastName->Visible) { // LastName ?>
		<td<?php echo $vouchers->LastName->CellAttributes() ?>>
<div<?php echo $vouchers->LastName->ViewAttributes() ?>><?php echo $vouchers->LastName->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vouchers->Program->Visible) { // Program ?>
		<td<?php echo $vouchers->Program->CellAttributes() ?>>
<div<?php echo $vouchers->Program->ViewAttributes() ?>><?php echo $vouchers->Program->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vouchers->cat_name->Visible) { // cat_name ?>
		<td<?php echo $vouchers->cat_name->CellAttributes() ?>>
<div<?php echo $vouchers->cat_name->ViewAttributes() ?>><?php echo $vouchers->cat_name->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vouchers->cat_breed->Visible) { // cat_breed ?>
		<td<?php echo $vouchers->cat_breed->CellAttributes() ?>>
<div<?php echo $vouchers->cat_breed->ViewAttributes() ?>><?php echo $vouchers->cat_breed->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vouchers->cat_age->Visible) { // cat_age ?>
		<td<?php echo $vouchers->cat_age->CellAttributes() ?>>
<div<?php echo $vouchers->cat_age->ViewAttributes() ?>><?php echo $vouchers->cat_age->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vouchers->copay->Visible) { // copay ?>
		<td<?php echo $vouchers->copay->CellAttributes() ?>>
<div<?php echo $vouchers->copay->ViewAttributes() ?>><?php echo $vouchers->copay->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vouchers->cat_status->Visible) { // cat_status ?>
		<td<?php echo $vouchers->cat_status->CellAttributes() ?>>
<div<?php echo $vouchers->cat_status->ViewAttributes() ?>><?php echo $vouchers->cat_status->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vouchers->date_redeemed->Visible) { // date_redeemed ?>
		<td<?php echo $vouchers->date_redeemed->CellAttributes() ?>>
<div<?php echo $vouchers->date_redeemed->ViewAttributes() ?>><?php echo $vouchers->date_redeemed->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vouchers->Clinic->Visible) { // Clinic ?>
		<td<?php echo $vouchers->Clinic->CellAttributes() ?>>
<div<?php echo $vouchers->Clinic->ViewAttributes() ?>><?php echo $vouchers->Clinic->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vouchers->ClinicPrice->Visible) { // ClinicPrice ?>
		<td<?php echo $vouchers->ClinicPrice->CellAttributes() ?>>
<div<?php echo $vouchers->ClinicPrice->ViewAttributes() ?>><?php echo $vouchers->ClinicPrice->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vouchers->vet_used->Visible) { // vet_used ?>
		<td<?php echo $vouchers->vet_used->CellAttributes() ?>>
<div<?php echo $vouchers->vet_used->ViewAttributes() ?>><?php echo $vouchers->vet_used->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vouchers->colony_id->Visible) { // colony_id ?>
		<td<?php echo $vouchers->colony_id->CellAttributes() ?>>
<div<?php echo $vouchers->colony_id->ViewAttributes() ?>><?php echo $vouchers->colony_id->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vouchers->Spay->Visible) { // Spay ?>
		<td<?php echo $vouchers->Spay->CellAttributes() ?>>
<div<?php echo $vouchers->Spay->ViewAttributes() ?>><?php echo $vouchers->Spay->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vouchers->Neuter->Visible) { // Neuter ?>
		<td<?php echo $vouchers->Neuter->CellAttributes() ?>>
<div<?php echo $vouchers->Neuter->ViewAttributes() ?>><?php echo $vouchers->Neuter->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vouchers->FVRCP->Visible) { // FVRCP ?>
		<td<?php echo $vouchers->FVRCP->CellAttributes() ?>>
<div<?php echo $vouchers->FVRCP->ViewAttributes() ?>><?php echo $vouchers->FVRCP->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vouchers->FELV->Visible) { // FELV ?>
		<td<?php echo $vouchers->FELV->CellAttributes() ?>>
<div<?php echo $vouchers->FELV->ViewAttributes() ?>><?php echo $vouchers->FELV->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vouchers->Rabies->Visible) { // Rabies ?>
		<td<?php echo $vouchers->Rabies->CellAttributes() ?>>
<div<?php echo $vouchers->Rabies->ViewAttributes() ?>><?php echo $vouchers->Rabies->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vouchers->Pregnant->Visible) { // Pregnant ?>
		<td<?php echo $vouchers->Pregnant->CellAttributes() ?>>
<div<?php echo $vouchers->Pregnant->ViewAttributes() ?>><?php echo $vouchers->Pregnant->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vouchers->AssignedTo->Visible) { // AssignedTo ?>
		<td<?php echo $vouchers->AssignedTo->CellAttributes() ?>>
<div<?php echo $vouchers->AssignedTo->ViewAttributes() ?>><?php echo $vouchers->AssignedTo->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vouchers->mod_by->Visible) { // mod_by ?>
		<td<?php echo $vouchers->mod_by->CellAttributes() ?>>
<div<?php echo $vouchers->mod_by->ViewAttributes() ?>><?php echo $vouchers->mod_by->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vouchers->mod_date->Visible) { // mod_date ?>
		<td<?php echo $vouchers->mod_date->CellAttributes() ?>>
<div<?php echo $vouchers->mod_date->ViewAttributes() ?>><?php echo $vouchers->mod_date->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$vouchers_list->ListOptions->Render("body", "right");
?>
	</tr>
<?php
	}
	if ($vouchers->CurrentAction <> "gridadd")
		$vouchers_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($vouchers_list->Recordset)
	$vouchers_list->Recordset->Close();
?>
<?php if ($vouchers_list->TotalRecs > 0) { ?>
<?php if ($vouchers->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($vouchers->CurrentAction <> "gridadd" && $vouchers->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($vouchers_list->Pager)) $vouchers_list->Pager = new cPrevNextPager($vouchers_list->StartRec, $vouchers_list->DisplayRecs, $vouchers_list->TotalRecs) ?>
<?php if ($vouchers_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($vouchers_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $vouchers_list->PageUrl() ?>start=<?php echo $vouchers_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($vouchers_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $vouchers_list->PageUrl() ?>start=<?php echo $vouchers_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $vouchers_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($vouchers_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $vouchers_list->PageUrl() ?>start=<?php echo $vouchers_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($vouchers_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $vouchers_list->PageUrl() ?>start=<?php echo $vouchers_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $vouchers_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $vouchers_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $vouchers_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $vouchers_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($vouchers_list->SearchWhere == "0=101") { ?>
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
<a class="ewGridLink" href="<?php echo $vouchers_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
</span>
</div>
<?php } ?>
<?php } ?>
</td></tr></table>
<?php if ($vouchers->Export == "" && $vouchers->CurrentAction == "") { ?>
<?php } ?>
<?php
$vouchers_list->ShowPageFooter();
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
$vouchers_list->Page_Terminate();
?>
<?php

//
// Page class
//
class cvouchers_list {

	// Page ID
	var $PageID = 'list';

	// Table name
	var $TableName = 'vouchers';

	// Page object name
	var $PageObjName = 'vouchers_list';

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
	function cvouchers_list() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (vouchers)
		if (!isset($GLOBALS["vouchers"])) {
			$GLOBALS["vouchers"] = new cvouchers();
			$GLOBALS["Table"] =& $GLOBALS["vouchers"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "vouchersadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "vouchersdelete.php";
		$this->MultiUpdateUrl = "vouchersupdate.php";

		// Table object (colonies)
		if (!isset($GLOBALS['colonies'])) $GLOBALS['colonies'] = new ccolonies();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'vouchers', TRUE);

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
		if ($vouchers->Export == "csv") {
			header('Content-Type: application/csv' . $Charset);
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.csv');
		}

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$vouchers->GridAddRowCount = $gridaddcnt;

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
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security, $vouchers;

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
			if ($vouchers->Export <> "" ||
				$vouchers->CurrentAction == "gridadd" ||
				$vouchers->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ExportOptions->HideAllOptions();
			}

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Restore search parms from Session
			$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$vouchers->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($vouchers->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $vouchers->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$vouchers->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->SearchWhere <> "") {
			if ($sSrchBasic == "")
				$this->ResetBasicSearchParms();
			$vouchers->setSearchWhere($this->SearchWhere); // Save to Session
			if (!$this->RestoreSearch) {
				$this->StartRec = 1; // Reset start record counter
				$vouchers->setStartRecordNumber($this->StartRec);
			}
		} else {
			$this->SearchWhere = $vouchers->getSearchWhere();
		}

		// Build filter
		$sFilter = "";

		// Restore master/detail filter
		$this->DbMasterFilter = $vouchers->getMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $vouchers->getDetailFilter(); // Restore detail filter
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Load master record
		if ($vouchers->getMasterFilter() <> "" && $vouchers->getCurrentMasterTable() == "colonies") {
			global $colonies;
			$rsmaster = $colonies->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate($vouchers->getReturnUrl()); // Return to caller
			} else {
				$colonies->LoadListRowValues($rsmaster);
				$colonies->RowType = EW_ROWTYPE_MASTER; // Master row
				$colonies->RenderListRow();
				$rsmaster->Close();
			}
		}

		// Set up filter in session
		$vouchers->setSessionWhere($sFilter);
		$vouchers->CurrentFilter = "";

		// Export data only
		if (in_array($vouchers->Export, array("html","word","excel","xml","csv","email","pdf"))) {
			$this->ExportData();
			if ($vouchers->Export <> "email")
				$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Return basic search SQL
	function BasicSearchSQL($Keyword) {
		global $vouchers;
		$sKeyword = ew_AdjustSql($Keyword);
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $vouchers->IssuedByFirst, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $vouchers->IssuedByLast, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $vouchers->FirstName, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $vouchers->LastName, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $vouchers->Program, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $vouchers->cat_name, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $vouchers->cat_breed, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $vouchers->cat_status, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $vouchers->Clinic, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $vouchers->vet_used, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $vouchers->Spay, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $vouchers->Neuter, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $vouchers->FVRCP, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $vouchers->FELV, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $vouchers->Rabies, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $vouchers->Pregnant, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $vouchers->AssignedTo, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $vouchers->mod_by, $Keyword);
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
		global $Security, $vouchers;
		$sSearchStr = "";
		$sSearchKeyword = $vouchers->BasicSearchKeyword;
		$sSearchType = $vouchers->BasicSearchType;
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
			$vouchers->setSessionBasicSearchKeyword($sSearchKeyword);
			$vouchers->setSessionBasicSearchType($sSearchType);
		}
		return $sSearchStr;
	}

	// Clear all search parameters
	function ResetSearchParms() {
		global $vouchers;

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$vouchers->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		global $vouchers;
		$vouchers->setSessionBasicSearchKeyword("");
		$vouchers->setSessionBasicSearchType("");
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		global $vouchers;
		$bRestore = TRUE;
		if ($vouchers->BasicSearchKeyword <> "") $bRestore = FALSE;
		$this->RestoreSearch = $bRestore;
		if ($bRestore) {

			// Restore basic search values
			$vouchers->BasicSearchKeyword = $vouchers->getSessionBasicSearchKeyword();
			$vouchers->BasicSearchType = $vouchers->getSessionBasicSearchType();
		}
	}

	// Set up sort parameters
	function SetUpSortOrder() {
		global $vouchers;

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$vouchers->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$vouchers->CurrentOrderType = @$_GET["ordertype"];
			$vouchers->UpdateSort($vouchers->id); // id
			$vouchers->UpdateSort($vouchers->VoucherNumber); // VoucherNumber
			$vouchers->UpdateSort($vouchers->ExpireDate); // ExpireDate
			$vouchers->UpdateSort($vouchers->IssuedByFirst); // IssuedByFirst
			$vouchers->UpdateSort($vouchers->IssuedByLast); // IssuedByLast
			$vouchers->UpdateSort($vouchers->FirstName); // FirstName
			$vouchers->UpdateSort($vouchers->LastName); // LastName
			$vouchers->UpdateSort($vouchers->Program); // Program
			$vouchers->UpdateSort($vouchers->cat_name); // cat_name
			$vouchers->UpdateSort($vouchers->cat_breed); // cat_breed
			$vouchers->UpdateSort($vouchers->cat_age); // cat_age
			$vouchers->UpdateSort($vouchers->copay); // copay
			$vouchers->UpdateSort($vouchers->cat_status); // cat_status
			$vouchers->UpdateSort($vouchers->date_redeemed); // date_redeemed
			$vouchers->UpdateSort($vouchers->Clinic); // Clinic
			$vouchers->UpdateSort($vouchers->ClinicPrice); // ClinicPrice
			$vouchers->UpdateSort($vouchers->vet_used); // vet_used
			$vouchers->UpdateSort($vouchers->colony_id); // colony_id
			$vouchers->UpdateSort($vouchers->Spay); // Spay
			$vouchers->UpdateSort($vouchers->Neuter); // Neuter
			$vouchers->UpdateSort($vouchers->FVRCP); // FVRCP
			$vouchers->UpdateSort($vouchers->FELV); // FELV
			$vouchers->UpdateSort($vouchers->Rabies); // Rabies
			$vouchers->UpdateSort($vouchers->Pregnant); // Pregnant
			$vouchers->UpdateSort($vouchers->AssignedTo); // AssignedTo
			$vouchers->UpdateSort($vouchers->mod_by); // mod_by
			$vouchers->UpdateSort($vouchers->mod_date); // mod_date
			$vouchers->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		global $vouchers;
		$sOrderBy = $vouchers->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($vouchers->SqlOrderBy() <> "") {
				$sOrderBy = $vouchers->SqlOrderBy();
				$vouchers->setSessionOrderBy($sOrderBy);
				$vouchers->id->setSort("DESC");
			}
		}
	}

	// Reset command
	// cmd=reset (Reset search parameters)
	// cmd=resetall (Reset search and master/detail parameters)
	// cmd=resetsort (Reset sort parameters)
	function ResetCmd() {
		global $vouchers;

		// Get reset command
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset search criteria
			if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall")
				$this->ResetSearchParms();

			// Reset master/detail keys
			if (strtolower($sCmd) == "resetall") {
				$vouchers->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$vouchers->colony_id->setSessionValue("");
			}

			// Reset sorting order
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$vouchers->setSessionOrderBy($sOrderBy);
				$vouchers->id->setSort("");
				$vouchers->VoucherNumber->setSort("");
				$vouchers->ExpireDate->setSort("");
				$vouchers->IssuedByFirst->setSort("");
				$vouchers->IssuedByLast->setSort("");
				$vouchers->FirstName->setSort("");
				$vouchers->LastName->setSort("");
				$vouchers->Program->setSort("");
				$vouchers->cat_name->setSort("");
				$vouchers->cat_breed->setSort("");
				$vouchers->cat_age->setSort("");
				$vouchers->copay->setSort("");
				$vouchers->cat_status->setSort("");
				$vouchers->date_redeemed->setSort("");
				$vouchers->Clinic->setSort("");
				$vouchers->ClinicPrice->setSort("");
				$vouchers->vet_used->setSort("");
				$vouchers->colony_id->setSort("");
				$vouchers->Spay->setSort("");
				$vouchers->Neuter->setSort("");
				$vouchers->FVRCP->setSort("");
				$vouchers->FELV->setSort("");
				$vouchers->Rabies->setSort("");
				$vouchers->Pregnant->setSort("");
				$vouchers->AssignedTo->setSort("");
				$vouchers->mod_by->setSort("");
				$vouchers->mod_date->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$vouchers->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language, $vouchers;

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
		global $Security, $Language, $vouchers, $objForm;
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
		global $Security, $Language, $vouchers;
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

	// Load basic search values
	function LoadBasicSearchValues() {
		global $vouchers;
		$vouchers->BasicSearchKeyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		$vouchers->BasicSearchType = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
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

	// Load old record
	function LoadOldRecord() {
		global $vouchers;

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($vouchers->getKey("id")) <> "")
			$vouchers->id->CurrentValue = $vouchers->getKey("id"); // id
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$vouchers->CurrentFilter = $vouchers->KeyFilter();
			$sSql = $vouchers->SQL();
			$this->OldRecordset = ew_LoadRecordset($sSql);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $vouchers;

		// Initialize URLs
		$this->ViewUrl = $vouchers->ViewUrl();
		$this->EditUrl = $vouchers->EditUrl();
		$this->InlineEditUrl = $vouchers->InlineEditUrl();
		$this->CopyUrl = $vouchers->CopyUrl();
		$this->InlineCopyUrl = $vouchers->InlineCopyUrl();
		$this->DeleteUrl = $vouchers->DeleteUrl();

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
		$item->Body = "<a name=\"emf_vouchers\" id=\"emf_vouchers\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_vouchers',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fvoucherslist,sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
		$item->Visible = FALSE;

		// Hide options for export/action
		if ($vouchers->Export <> "" ||
			$vouchers->CurrentAction <> "")
			$this->ExportOptions->HideAllOptions();
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		global $vouchers;
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = EW_SELECT_LIMIT;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $vouchers->SelectRecordCount();
		} else {
			if ($rs = $this->LoadRecordset())
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;

		// Export all
		if ($vouchers->ExportAll) {
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
		if ($vouchers->Export == "xml") {
			$XmlDoc = new cXMLDocument(EW_XML_ENCODING);
		} else {
			$ExportDoc = new cExportDocument($vouchers, "h");
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
			$vouchers->ExportXmlDocument($XmlDoc, ($ParentTable <> ""), $rs, $StartRec, $StopRec, "");
		} else {
			$sHeader = $this->PageHeader;
			$this->Page_DataRendering($sHeader);
			$ExportDoc->Text .= $sHeader;
			$vouchers->ExportDocument($ExportDoc, $rs, $StartRec, $StopRec, "");
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

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {
		global $vouchers;
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
					$vouchers->colony_id->setQueryStringValue($GLOBALS["colonies"]->colony_id->QueryStringValue);
					$vouchers->colony_id->setSessionValue($vouchers->colony_id->QueryStringValue);
					if (!is_numeric($GLOBALS["colonies"]->colony_id->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$vouchers->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$vouchers->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "colonies") {
				if ($vouchers->colony_id->QueryStringValue == "") $vouchers->colony_id->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $vouchers->getMasterFilter(); //  Get master filter
		$this->DbDetailFilter = $vouchers->getDetailFilter(); // Get detail filter
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
