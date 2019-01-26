<?php $groupswithaccess="CLIENT"; require_once("../slpw/sitelokpw.php"); ?>
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
$vets_list = new cvets_list();
$Page =& $vets_list;

// Page init
$vets_list->Page_Init();

// Page main
$vets_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($vets->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var vets_list = new ew_Page("vets_list");

// page properties
vets_list.PageID = "list"; // page ID
vets_list.FormID = "fvetslist"; // form ID
var EW_PAGE_ID = vets_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
vets_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
vets_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
vets_list.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php } ?>
<?php if (($vets->Export == "") || (EW_EXPORT_MASTER_RECORD && $vets->Export == "print")) { ?>
<?php } ?>
<?php $vets_list->ShowPageHeader(); ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$vets_list->TotalRecs = $vets->SelectRecordCount();
	} else {
		if ($vets_list->Recordset = $vets_list->LoadRecordset())
			$vets_list->TotalRecs = $vets_list->Recordset->RecordCount();
	}
	$vets_list->StartRec = 1;
	if ($vets_list->DisplayRecs <= 0 || ($vets->Export <> "" && $vets->ExportAll)) // Display all records
		$vets_list->DisplayRecs = $vets_list->TotalRecs;
	if (!($vets->Export <> "" && $vets->ExportAll))
		$vets_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$vets_list->Recordset = $vets_list->LoadRecordset($vets_list->StartRec-1, $vets_list->DisplayRecs);
?>
<p class="phpmaker ewTitle" style="white-space: nowrap;"><?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $vets->TableCaption() ?>
&nbsp;&nbsp;<?php $vets_list->ExportOptions->Render("body"); ?>
</p>
<?php if ($vets->Export == "" && $vets->CurrentAction == "") { ?>
<a href="javascript:ew_ToggleSearchPanel(vets_list);" style="text-decoration: none;"><img id="vets_list_SearchImage" src="phpimages/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="vets_list_SearchPanel">
<form name="fvetslistsrch" id="fvetslistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<input type="hidden" id="t" name="t" value="vets">
<div class="ewBasicSearch">
<div id="xsr_1" class="ewCssTableRow">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($vets->getSessionBasicSearchKeyword()) ?>">
	<input type="Submit" name="Submit" id="Submit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
	<a href="<?php echo $vets_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
</div>
<div id="xsr_2" class="ewCssTableRow">
	<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value=""<?php if ($vets->getSessionBasicSearchType() == "") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($vets->getSessionBasicSearchType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($vets->getSessionBasicSearchType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
</div>
</div>
</form>
</div>
<?php } ?>
<?php
$vets_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<form name="fvetslist" id="fvetslist" class="ewForm" action="" method="post">
<input type="hidden" name="t" id="t" value="vets">
<div id="gmp_vets" class="ewGridMiddlePanel">
<?php if ($vets_list->TotalRecs > 0) { ?>
<table cellspacing="0" data-rowhighlightclass="ewTableHighlightRow" data-rowselectclass="ewTableSelectRow" data-roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php echo $vets->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$vets_list->RenderListOptions();

// Render list options (header, left)
$vets_list->ListOptions->Render("header", "left");
?>
<?php if ($vets->id->Visible) { // id ?>
	<?php if ($vets->SortUrl($vets->id) == "") { ?>
		<td><?php echo $vets->id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vets->SortUrl($vets->id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vets->id->FldCaption() ?></td><td style="width: 10px;"><?php if ($vets->id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vets->id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vets->CountyServed->Visible) { // CountyServed ?>
	<?php if ($vets->SortUrl($vets->CountyServed) == "") { ?>
		<td><?php echo $vets->CountyServed->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vets->SortUrl($vets->CountyServed) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vets->CountyServed->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($vets->CountyServed->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vets->CountyServed->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vets->Clinic->Visible) { // Clinic ?>
	<?php if ($vets->SortUrl($vets->Clinic) == "") { ?>
		<td><?php echo $vets->Clinic->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vets->SortUrl($vets->Clinic) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vets->Clinic->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($vets->Clinic->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vets->Clinic->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vets->Vet->Visible) { // Vet ?>
	<?php if ($vets->SortUrl($vets->Vet) == "") { ?>
		<td><?php echo $vets->Vet->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vets->SortUrl($vets->Vet) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vets->Vet->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($vets->Vet->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vets->Vet->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vets->Address->Visible) { // Address ?>
	<?php if ($vets->SortUrl($vets->Address) == "") { ?>
		<td><?php echo $vets->Address->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vets->SortUrl($vets->Address) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vets->Address->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($vets->Address->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vets->Address->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vets->MailingAddress->Visible) { // MailingAddress ?>
	<?php if ($vets->SortUrl($vets->MailingAddress) == "") { ?>
		<td><?php echo $vets->MailingAddress->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vets->SortUrl($vets->MailingAddress) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vets->MailingAddress->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($vets->MailingAddress->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vets->MailingAddress->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vets->City->Visible) { // City ?>
	<?php if ($vets->SortUrl($vets->City) == "") { ?>
		<td><?php echo $vets->City->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vets->SortUrl($vets->City) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vets->City->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($vets->City->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vets->City->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vets->Zip->Visible) { // Zip ?>
	<?php if ($vets->SortUrl($vets->Zip) == "") { ?>
		<td><?php echo $vets->Zip->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vets->SortUrl($vets->Zip) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vets->Zip->FldCaption() ?></td><td style="width: 10px;"><?php if ($vets->Zip->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vets->Zip->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vets->County->Visible) { // County ?>
	<?php if ($vets->SortUrl($vets->County) == "") { ?>
		<td><?php echo $vets->County->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vets->SortUrl($vets->County) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vets->County->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($vets->County->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vets->County->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vets->Phone->Visible) { // Phone ?>
	<?php if ($vets->SortUrl($vets->Phone) == "") { ?>
		<td><?php echo $vets->Phone->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vets->SortUrl($vets->Phone) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vets->Phone->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($vets->Phone->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vets->Phone->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vets->Fax->Visible) { // Fax ?>
	<?php if ($vets->SortUrl($vets->Fax) == "") { ?>
		<td><?php echo $vets->Fax->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vets->SortUrl($vets->Fax) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vets->Fax->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($vets->Fax->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vets->Fax->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vets->AllCatsFee->Visible) { // AllCatsFee ?>
	<?php if ($vets->SortUrl($vets->AllCatsFee) == "") { ?>
		<td><?php echo $vets->AllCatsFee->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vets->SortUrl($vets->AllCatsFee) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vets->AllCatsFee->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($vets->AllCatsFee->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vets->AllCatsFee->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vets->AllMaleDogs->Visible) { // AllMaleDogs ?>
	<?php if ($vets->SortUrl($vets->AllMaleDogs) == "") { ?>
		<td><?php echo $vets->AllMaleDogs->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vets->SortUrl($vets->AllMaleDogs) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vets->AllMaleDogs->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($vets->AllMaleDogs->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vets->AllMaleDogs->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vets->FemDogsUnder75->Visible) { // FemDogsUnder75 ?>
	<?php if ($vets->SortUrl($vets->FemDogsUnder75) == "") { ?>
		<td><?php echo $vets->FemDogsUnder75->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vets->SortUrl($vets->FemDogsUnder75) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vets->FemDogsUnder75->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($vets->FemDogsUnder75->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vets->FemDogsUnder75->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vets->FemDogsOver75->Visible) { // FemDogsOver75 ?>
	<?php if ($vets->SortUrl($vets->FemDogsOver75) == "") { ?>
		<td><?php echo $vets->FemDogsOver75->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vets->SortUrl($vets->FemDogsOver75) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vets->FemDogsOver75->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($vets->FemDogsOver75->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vets->FemDogsOver75->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vets->AllFeralMaleCats->Visible) { // AllFeralMaleCats ?>
	<?php if ($vets->SortUrl($vets->AllFeralMaleCats) == "") { ?>
		<td><?php echo $vets->AllFeralMaleCats->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vets->SortUrl($vets->AllFeralMaleCats) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vets->AllFeralMaleCats->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($vets->AllFeralMaleCats->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vets->AllFeralMaleCats->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vets->AllFeralFemaleCats->Visible) { // AllFeralFemaleCats ?>
	<?php if ($vets->SortUrl($vets->AllFeralFemaleCats) == "") { ?>
		<td><?php echo $vets->AllFeralFemaleCats->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vets->SortUrl($vets->AllFeralFemaleCats) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vets->AllFeralFemaleCats->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($vets->AllFeralFemaleCats->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vets->AllFeralFemaleCats->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vets->Comments->Visible) { // Comments ?>
	<?php if ($vets->SortUrl($vets->Comments) == "") { ?>
		<td><?php echo $vets->Comments->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vets->SortUrl($vets->Comments) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vets->Comments->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($vets->Comments->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vets->Comments->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vets->Active->Visible) { // Active ?>
	<?php if ($vets->SortUrl($vets->Active) == "") { ?>
		<td><?php echo $vets->Active->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $vets->SortUrl($vets->Active) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vets->Active->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($vets->Active->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vets->Active->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$vets_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<?php
if ($vets->ExportAll && $vets->Export <> "") {
	$vets_list->StopRec = $vets_list->TotalRecs;
} else {

	// Set the last record to display
	if ($vets_list->TotalRecs > $vets_list->StartRec + $vets_list->DisplayRecs - 1)
		$vets_list->StopRec = $vets_list->StartRec + $vets_list->DisplayRecs - 1;
	else
		$vets_list->StopRec = $vets_list->TotalRecs;
}
$vets_list->RecCnt = $vets_list->StartRec - 1;
if ($vets_list->Recordset && !$vets_list->Recordset->EOF) {
	$vets_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $vets_list->StartRec > 1)
		$vets_list->Recordset->Move($vets_list->StartRec - 1);
} elseif (!$vets->AllowAddDeleteRow && $vets_list->StopRec == 0) {
	$vets_list->StopRec = $vets->GridAddRowCount;
}

// Initialize aggregate
$vets->RowType = EW_ROWTYPE_AGGREGATEINIT;
$vets->ResetAttrs();
$vets_list->RenderRow();
$vets_list->RowCnt = 0;
while ($vets_list->RecCnt < $vets_list->StopRec) {
	$vets_list->RecCnt++;
	if (intval($vets_list->RecCnt) >= intval($vets_list->StartRec)) {
		$vets_list->RowCnt++;

		// Set up key count
		$vets_list->KeyCount = $vets_list->RowIndex;

		// Init row class and style
		$vets->ResetAttrs();
		$vets->CssClass = "";
		if ($vets->CurrentAction == "gridadd") {
			$vets_list->LoadDefaultValues(); // Load default values
		} else {
			$vets_list->LoadRowValues($vets_list->Recordset); // Load row values
		}
		$vets->RowType = EW_ROWTYPE_VIEW; // Render view
		$vets->RowAttrs = array('onmouseover'=>'ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);');

		// Render row
		$vets_list->RenderRow();

		// Render list options
		$vets_list->RenderListOptions();
?>
	<tr<?php echo $vets->RowAttributes() ?>>
<?php

// Render list options (body, left)
$vets_list->ListOptions->Render("body", "left");
?>
	<?php if ($vets->id->Visible) { // id ?>
		<td<?php echo $vets->id->CellAttributes() ?>>
<div<?php echo $vets->id->ViewAttributes() ?>><?php echo $vets->id->ListViewValue() ?></div>
<a name="<?php echo $vets_list->PageObjName . "_row_" . $vets_list->RowCnt ?>" id="<?php echo $vets_list->PageObjName . "_row_" . $vets_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($vets->CountyServed->Visible) { // CountyServed ?>
		<td<?php echo $vets->CountyServed->CellAttributes() ?>>
<div<?php echo $vets->CountyServed->ViewAttributes() ?>><?php echo $vets->CountyServed->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vets->Clinic->Visible) { // Clinic ?>
		<td<?php echo $vets->Clinic->CellAttributes() ?>>
<div<?php echo $vets->Clinic->ViewAttributes() ?>><?php echo $vets->Clinic->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vets->Vet->Visible) { // Vet ?>
		<td<?php echo $vets->Vet->CellAttributes() ?>>
<div<?php echo $vets->Vet->ViewAttributes() ?>><?php echo $vets->Vet->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vets->Address->Visible) { // Address ?>
		<td<?php echo $vets->Address->CellAttributes() ?>>
<div<?php echo $vets->Address->ViewAttributes() ?>><?php echo $vets->Address->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vets->MailingAddress->Visible) { // MailingAddress ?>
		<td<?php echo $vets->MailingAddress->CellAttributes() ?>>
<div<?php echo $vets->MailingAddress->ViewAttributes() ?>><?php echo $vets->MailingAddress->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vets->City->Visible) { // City ?>
		<td<?php echo $vets->City->CellAttributes() ?>>
<div<?php echo $vets->City->ViewAttributes() ?>><?php echo $vets->City->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vets->Zip->Visible) { // Zip ?>
		<td<?php echo $vets->Zip->CellAttributes() ?>>
<div<?php echo $vets->Zip->ViewAttributes() ?>><?php echo $vets->Zip->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vets->County->Visible) { // County ?>
		<td<?php echo $vets->County->CellAttributes() ?>>
<div<?php echo $vets->County->ViewAttributes() ?>><?php echo $vets->County->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vets->Phone->Visible) { // Phone ?>
		<td<?php echo $vets->Phone->CellAttributes() ?>>
<div<?php echo $vets->Phone->ViewAttributes() ?>><?php echo $vets->Phone->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vets->Fax->Visible) { // Fax ?>
		<td<?php echo $vets->Fax->CellAttributes() ?>>
<div<?php echo $vets->Fax->ViewAttributes() ?>><?php echo $vets->Fax->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vets->AllCatsFee->Visible) { // AllCatsFee ?>
		<td<?php echo $vets->AllCatsFee->CellAttributes() ?>>
<div<?php echo $vets->AllCatsFee->ViewAttributes() ?>><?php echo $vets->AllCatsFee->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vets->AllMaleDogs->Visible) { // AllMaleDogs ?>
		<td<?php echo $vets->AllMaleDogs->CellAttributes() ?>>
<div<?php echo $vets->AllMaleDogs->ViewAttributes() ?>><?php echo $vets->AllMaleDogs->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vets->FemDogsUnder75->Visible) { // FemDogsUnder75 ?>
		<td<?php echo $vets->FemDogsUnder75->CellAttributes() ?>>
<div<?php echo $vets->FemDogsUnder75->ViewAttributes() ?>><?php echo $vets->FemDogsUnder75->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vets->FemDogsOver75->Visible) { // FemDogsOver75 ?>
		<td<?php echo $vets->FemDogsOver75->CellAttributes() ?>>
<div<?php echo $vets->FemDogsOver75->ViewAttributes() ?>><?php echo $vets->FemDogsOver75->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vets->AllFeralMaleCats->Visible) { // AllFeralMaleCats ?>
		<td<?php echo $vets->AllFeralMaleCats->CellAttributes() ?>>
<div<?php echo $vets->AllFeralMaleCats->ViewAttributes() ?>><?php echo $vets->AllFeralMaleCats->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vets->AllFeralFemaleCats->Visible) { // AllFeralFemaleCats ?>
		<td<?php echo $vets->AllFeralFemaleCats->CellAttributes() ?>>
<div<?php echo $vets->AllFeralFemaleCats->ViewAttributes() ?>><?php echo $vets->AllFeralFemaleCats->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vets->Comments->Visible) { // Comments ?>
		<td<?php echo $vets->Comments->CellAttributes() ?>>
<div<?php echo $vets->Comments->ViewAttributes() ?>><?php echo $vets->Comments->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($vets->Active->Visible) { // Active ?>
		<td<?php echo $vets->Active->CellAttributes() ?>>
<div<?php echo $vets->Active->ViewAttributes() ?>><?php echo $vets->Active->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$vets_list->ListOptions->Render("body", "right");
?>
	</tr>
<?php
	}
	if ($vets->CurrentAction <> "gridadd")
		$vets_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($vets_list->Recordset)
	$vets_list->Recordset->Close();
?>
<?php if ($vets->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($vets->CurrentAction <> "gridadd" && $vets->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($vets_list->Pager)) $vets_list->Pager = new cPrevNextPager($vets_list->StartRec, $vets_list->DisplayRecs, $vets_list->TotalRecs) ?>
<?php if ($vets_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($vets_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $vets_list->PageUrl() ?>start=<?php echo $vets_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($vets_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $vets_list->PageUrl() ?>start=<?php echo $vets_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $vets_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($vets_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $vets_list->PageUrl() ?>start=<?php echo $vets_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($vets_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $vets_list->PageUrl() ?>start=<?php echo $vets_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $vets_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $vets_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $vets_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $vets_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($vets_list->SearchWhere == "0=101") { ?>
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
<a href="<?php echo $vets_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
</span>
</div>
<?php } ?>
</td></tr></table>
<?php if ($vets->Export == "" && $vets->CurrentAction == "") { ?>
<?php } ?>
<?php
$vets_list->ShowPageFooter();
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
$vets_list->Page_Terminate();
?>
<?php

//
// Page class
//
class cvets_list {

	// Page ID
	var $PageID = 'list';

	// Table name
	var $TableName = 'vets';

	// Page object name
	var $PageObjName = 'vets_list';

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
	function cvets_list() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (vets)
		if (!isset($GLOBALS["vets"])) {
			$GLOBALS["vets"] = new cvets();
			$GLOBALS["Table"] =& $GLOBALS["vets"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "vetsadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "vetsdelete.php";
		$this->MultiUpdateUrl = "vetsupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'vets', TRUE);

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
		global $vets;

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$vets->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();

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
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security, $vets;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";
		if ($this->IsPageRequest()) { // Validate request

			// Handle reset command
			$this->ResetCmd();

			// Hide all options
			if ($vets->Export <> "" ||
				$vets->CurrentAction == "gridadd" ||
				$vets->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ExportOptions->HideAllOptions();
			}

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Restore search parms from Session
			$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$vets->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($vets->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $vets->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$vets->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->SearchWhere <> "") {
			if ($sSrchBasic == "")
				$this->ResetBasicSearchParms();
			$vets->setSearchWhere($this->SearchWhere); // Save to Session
			if (!$this->RestoreSearch) {
				$this->StartRec = 1; // Reset start record counter
				$vets->setStartRecordNumber($this->StartRec);
			}
		} else {
			$this->SearchWhere = $vets->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter in session
		$vets->setSessionWhere($sFilter);
		$vets->CurrentFilter = "";
	}

	// Return basic search SQL
	function BasicSearchSQL($Keyword) {
		global $vets;
		$sKeyword = ew_AdjustSql($Keyword);
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $vets->CountyServed, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $vets->Clinic, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $vets->Vet, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $vets->Address, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $vets->MailingAddress, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $vets->City, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $vets->County, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $vets->Phone, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $vets->Fax, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $vets->AllCatsFee, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $vets->AllMaleDogs, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $vets->FemDogsUnder75, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $vets->FemDogsOver75, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $vets->AllFeralMaleCats, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $vets->AllFeralFemaleCats, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $vets->Comments, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $vets->Active, $Keyword);
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
		global $Security, $vets;
		$sSearchStr = "";
		$sSearchKeyword = $vets->BasicSearchKeyword;
		$sSearchType = $vets->BasicSearchType;
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
			$vets->setSessionBasicSearchKeyword($sSearchKeyword);
			$vets->setSessionBasicSearchType($sSearchType);
		}
		return $sSearchStr;
	}

	// Clear all search parameters
	function ResetSearchParms() {
		global $vets;

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$vets->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		global $vets;
		$vets->setSessionBasicSearchKeyword("");
		$vets->setSessionBasicSearchType("");
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		global $vets;
		$bRestore = TRUE;
		if (@$_GET[EW_TABLE_BASIC_SEARCH] <> "") $bRestore = FALSE;
		$this->RestoreSearch = $bRestore;
		if ($bRestore) {

			// Restore basic search values
			$vets->BasicSearchKeyword = $vets->getSessionBasicSearchKeyword();
			$vets->BasicSearchType = $vets->getSessionBasicSearchType();
		}
	}

	// Set up sort parameters
	function SetUpSortOrder() {
		global $vets;

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$vets->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$vets->CurrentOrderType = @$_GET["ordertype"];
			$vets->UpdateSort($vets->id); // id
			$vets->UpdateSort($vets->CountyServed); // CountyServed
			$vets->UpdateSort($vets->Clinic); // Clinic
			$vets->UpdateSort($vets->Vet); // Vet
			$vets->UpdateSort($vets->Address); // Address
			$vets->UpdateSort($vets->MailingAddress); // MailingAddress
			$vets->UpdateSort($vets->City); // City
			$vets->UpdateSort($vets->Zip); // Zip
			$vets->UpdateSort($vets->County); // County
			$vets->UpdateSort($vets->Phone); // Phone
			$vets->UpdateSort($vets->Fax); // Fax
			$vets->UpdateSort($vets->AllCatsFee); // AllCatsFee
			$vets->UpdateSort($vets->AllMaleDogs); // AllMaleDogs
			$vets->UpdateSort($vets->FemDogsUnder75); // FemDogsUnder75
			$vets->UpdateSort($vets->FemDogsOver75); // FemDogsOver75
			$vets->UpdateSort($vets->AllFeralMaleCats); // AllFeralMaleCats
			$vets->UpdateSort($vets->AllFeralFemaleCats); // AllFeralFemaleCats
			$vets->UpdateSort($vets->Comments); // Comments
			$vets->UpdateSort($vets->Active); // Active
			$vets->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		global $vets;
		$sOrderBy = $vets->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($vets->SqlOrderBy() <> "") {
				$sOrderBy = $vets->SqlOrderBy();
				$vets->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// cmd=reset (Reset search parameters)
	// cmd=resetall (Reset search and master/detail parameters)
	// cmd=resetsort (Reset sort parameters)
	function ResetCmd() {
		global $vets;

		// Get reset command
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset search criteria
			if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$vets->setSessionOrderBy($sOrderBy);
				$vets->id->setSort("");
				$vets->CountyServed->setSort("");
				$vets->Clinic->setSort("");
				$vets->Vet->setSort("");
				$vets->Address->setSort("");
				$vets->MailingAddress->setSort("");
				$vets->City->setSort("");
				$vets->Zip->setSort("");
				$vets->County->setSort("");
				$vets->Phone->setSort("");
				$vets->Fax->setSort("");
				$vets->AllCatsFee->setSort("");
				$vets->AllMaleDogs->setSort("");
				$vets->FemDogsUnder75->setSort("");
				$vets->FemDogsOver75->setSort("");
				$vets->AllFeralMaleCats->setSort("");
				$vets->AllFeralFemaleCats->setSort("");
				$vets->Comments->setSort("");
				$vets->Active->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$vets->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language, $vets;

		// "view"
		$item =& $this->ListOptions->Add("view");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = TRUE;
		$item->OnLeft = FALSE;

		// "edit"
		$item =& $this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = TRUE;
		$item->OnLeft = FALSE;

		// "copy"
		$item =& $this->ListOptions->Add("copy");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = TRUE;
		$item->OnLeft = FALSE;

		// "delete"
		$item =& $this->ListOptions->Add("delete");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = TRUE;
		$item->OnLeft = FALSE;

		// Call ListOptions_Load event
		$this->ListOptions_Load();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $vets, $objForm;
		$this->ListOptions->LoadDefault();

		// "view"
		$oListOpt =& $this->ListOptions->Items["view"];
		if ($oListOpt->Visible)
			$oListOpt->Body = "<a href=\"" . $this->ViewUrl . "\">" . $Language->Phrase("ViewLink") . "</a>";

		// "edit"
		$oListOpt =& $this->ListOptions->Items["edit"];
		if ($oListOpt->Visible) {
			$oListOpt->Body = "<a href=\"" . $this->EditUrl . "\">" . $Language->Phrase("EditLink") . "</a>";
		}

		// "copy"
		$oListOpt =& $this->ListOptions->Items["copy"];
		if ($oListOpt->Visible) {
			$oListOpt->Body = "<a href=\"" . $this->CopyUrl . "\">" . $Language->Phrase("CopyLink") . "</a>";
		}

		// "delete"
		$oListOpt =& $this->ListOptions->Items["delete"];
		if ($oListOpt->Visible)
			$oListOpt->Body = "<a" . "" . " href=\"" . $this->DeleteUrl . "\">" . $Language->Phrase("DeleteLink") . "</a>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	function RenderListOptionsExt() {
		global $Security, $Language, $vets;
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

	// Load basic search values
	function LoadBasicSearchValues() {
		global $vets;
		$vets->BasicSearchKeyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		$vets->BasicSearchType = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $vets;

		// Call Recordset Selecting event
		$vets->Recordset_Selecting($vets->CurrentFilter);

		// Load List page SQL
		$sSql = $vets->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$vets->Recordset_Selected($rs);
		return $rs;
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
		$this->ViewUrl = $vets->ViewUrl();
		$this->EditUrl = $vets->EditUrl();
		$this->InlineEditUrl = $vets->InlineEditUrl();
		$this->CopyUrl = $vets->CopyUrl();
		$this->InlineCopyUrl = $vets->InlineCopyUrl();
		$this->DeleteUrl = $vets->DeleteUrl();

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
