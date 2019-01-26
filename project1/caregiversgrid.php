<?php

// Create page object
$caregivers_grid = new ccaregivers_grid();
$MasterPage =& $Page;
$Page =& $caregivers_grid;

// Page init
$caregivers_grid->Page_Init();

// Page main
$caregivers_grid->Page_Main();
?>
<?php if ($caregivers->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var caregivers_grid = new ew_Page("caregivers_grid");

// page properties
caregivers_grid.PageID = "grid"; // page ID
caregivers_grid.FormID = "fcaregiversgrid"; // form ID
var EW_PAGE_ID = caregivers_grid.PageID; // for backward compatibility

// extend page with ValidateForm function
caregivers_grid.ValidateForm = function(fobj) {
	ew_PostAutoSuggest(fobj);
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	var addcnt = 0;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		var chkthisrow = true;
		if (fobj.a_list && fobj.a_list.value == "gridinsert")
			chkthisrow = !(this.EmptyRow(fobj, infix));
		else
			chkthisrow = true;
		if (chkthisrow) {
			addcnt += 1;
		elm = fobj.elements["x" + infix + "_zip"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($caregivers->zip->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_num_deps"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($caregivers->num_deps->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_annual_income"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($caregivers->annual_income->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_app_source"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($caregivers->app_source->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_app_date"];
		if (elm && !ew_CheckDate(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($caregivers->app_date->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_Expiration"];
		if (elm && !ew_CheckDate(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($caregivers->Expiration->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_DateSent"];
		if (elm && !ew_CheckDate(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($caregivers->DateSent->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_budget_category"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($caregivers->budget_category->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_budget_category"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($caregivers->budget_category->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_AgeOfApplicant"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($caregivers->AgeOfApplicant->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_AgeOfApplicant"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($caregivers->AgeOfApplicant->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_DateSigned"];
		if (elm && !ew_CheckDate(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($caregivers->DateSigned->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_colony_id"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($caregivers->colony_id->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_colony_id"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($caregivers->colony_id->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_mod_date"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($caregivers->mod_date->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_mod_date"];
		if (elm && !ew_CheckDate(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($caregivers->mod_date->FldErrMsg()) ?>");

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
		} // End Grid Add checking
	}
	return true;
}

// Extend page with empty row check
caregivers_grid.EmptyRow = function(fobj, infix) {
	if (ew_ValueChanged(fobj, infix, "first_name", false)) return false;
	if (ew_ValueChanged(fobj, infix, "last_name", false)) return false;
	if (ew_ValueChanged(fobj, infix, "day_phone", false)) return false;
	if (ew_ValueChanged(fobj, infix, "other_phone", false)) return false;
	if (ew_ValueChanged(fobj, infix, "zemail", false)) return false;
	if (ew_ValueChanged(fobj, infix, "address", false)) return false;
	if (ew_ValueChanged(fobj, infix, "apt_num", false)) return false;
	if (ew_ValueChanged(fobj, infix, "city", false)) return false;
	if (ew_ValueChanged(fobj, infix, "county", false)) return false;
	if (ew_ValueChanged(fobj, infix, "zip", false)) return false;
	if (ew_ValueChanged(fobj, infix, "num_deps", false)) return false;
	if (ew_ValueChanged(fobj, infix, "annual_income", false)) return false;
	if (ew_ValueChanged(fobj, infix, "app_source", false)) return false;
	if (ew_ValueChanged(fobj, infix, "dl", false)) return false;
	if (ew_ValueChanged(fobj, infix, "app_date", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Expiration", false)) return false;
	if (ew_ValueChanged(fobj, infix, "ClinicGroup", false)) return false;
	if (ew_ValueChanged(fobj, infix, "DateSent", false)) return false;
	if (ew_ValueChanged(fobj, infix, "budget_category", false)) return false;
	if (ew_ValueChanged(fobj, infix, "AgeOfApplicant", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Applic", false)) return false;
	if (ew_ValueChanged(fobj, infix, "SubApplic", false)) return false;
	if (ew_ValueChanged(fobj, infix, "DateSigned", false)) return false;
	if (ew_ValueChanged(fobj, infix, "colony_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "mod_by", false)) return false;
	if (ew_ValueChanged(fobj, infix, "mod_date", false)) return false;
	return true;
}

// extend page with Form_CustomValidate function
caregivers_grid.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
caregivers_grid.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
caregivers_grid.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<?php } ?>
<?php
if ($caregivers->CurrentAction == "gridadd") {
	if ($caregivers->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$caregivers_grid->TotalRecs = $caregivers->SelectRecordCount();
			$caregivers_grid->Recordset = $caregivers_grid->LoadRecordset($caregivers_grid->StartRec-1, $caregivers_grid->DisplayRecs);
		} else {
			if ($caregivers_grid->Recordset = $caregivers_grid->LoadRecordset())
				$caregivers_grid->TotalRecs = $caregivers_grid->Recordset->RecordCount();
		}
		$caregivers_grid->StartRec = 1;
		$caregivers_grid->DisplayRecs = $caregivers_grid->TotalRecs;
	} else {
		$caregivers->CurrentFilter = "0=1";
		$caregivers_grid->StartRec = 1;
		$caregivers_grid->DisplayRecs = $caregivers->GridAddRowCount;
	}
	$caregivers_grid->TotalRecs = $caregivers_grid->DisplayRecs;
	$caregivers_grid->StopRec = $caregivers_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$caregivers_grid->TotalRecs = $caregivers->SelectRecordCount();
	} else {
		if ($caregivers_grid->Recordset = $caregivers_grid->LoadRecordset())
			$caregivers_grid->TotalRecs = $caregivers_grid->Recordset->RecordCount();
	}
	$caregivers_grid->StartRec = 1;
	$caregivers_grid->DisplayRecs = $caregivers_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$caregivers_grid->Recordset = $caregivers_grid->LoadRecordset($caregivers_grid->StartRec-1, $caregivers_grid->DisplayRecs);
}
?>
<p class="phpmaker ewTitle" style="white-space: nowrap;"><?php if ($caregivers->CurrentMode == "add" || $caregivers->CurrentMode == "copy") { ?><?php echo $Language->Phrase("Add") ?><?php } elseif ($caregivers->CurrentMode == "edit") { ?><?php echo $Language->Phrase("Edit") ?><?php } ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $caregivers->TableCaption() ?></p>
</p>
<?php $caregivers_grid->ShowPageHeader(); ?>
<?php
$caregivers_grid->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if (($caregivers->CurrentMode == "add" || $caregivers->CurrentMode == "copy" || $caregivers->CurrentMode == "edit") && $caregivers->CurrentAction != "F") { // add/copy/edit mode ?>
<div class="ewGridUpperPanel">
<?php if ($caregivers->AllowAddDeleteRow) { ?>
<span class="phpmaker">
<a href="javascript:void(0);" onclick="ew_AddGridRow(this);"><?php echo $Language->Phrase("AddBlankRow") ?></a>&nbsp;&nbsp;
</span>
<?php } ?>
</div>
<?php } ?>
<div id="gmp_caregivers" class="ewGridMiddlePanel">
<table cellspacing="0" data-rowhighlightclass="ewTableHighlightRow" data-rowselectclass="ewTableSelectRow" data-roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php echo $caregivers->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$caregivers_grid->RenderListOptions();

// Render list options (header, left)
$caregivers_grid->ListOptions->Render("header", "left");
?>
<?php if ($caregivers->caregiver_id->Visible) { // caregiver_id ?>
	<?php if ($caregivers->SortUrl($caregivers->caregiver_id) == "") { ?>
		<td><?php echo $caregivers->caregiver_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->caregiver_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($caregivers->caregiver_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->caregiver_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->first_name->Visible) { // first_name ?>
	<?php if ($caregivers->SortUrl($caregivers->first_name) == "") { ?>
		<td><?php echo $caregivers->first_name->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->first_name->FldCaption() ?></td><td style="width: 10px;"><?php if ($caregivers->first_name->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->first_name->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->last_name->Visible) { // last_name ?>
	<?php if ($caregivers->SortUrl($caregivers->last_name) == "") { ?>
		<td><?php echo $caregivers->last_name->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->last_name->FldCaption() ?></td><td style="width: 10px;"><?php if ($caregivers->last_name->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->last_name->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->day_phone->Visible) { // day_phone ?>
	<?php if ($caregivers->SortUrl($caregivers->day_phone) == "") { ?>
		<td><?php echo $caregivers->day_phone->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->day_phone->FldCaption() ?></td><td style="width: 10px;"><?php if ($caregivers->day_phone->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->day_phone->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->other_phone->Visible) { // other_phone ?>
	<?php if ($caregivers->SortUrl($caregivers->other_phone) == "") { ?>
		<td><?php echo $caregivers->other_phone->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->other_phone->FldCaption() ?></td><td style="width: 10px;"><?php if ($caregivers->other_phone->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->other_phone->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->zemail->Visible) { // email ?>
	<?php if ($caregivers->SortUrl($caregivers->zemail) == "") { ?>
		<td><?php echo $caregivers->zemail->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->zemail->FldCaption() ?></td><td style="width: 10px;"><?php if ($caregivers->zemail->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->zemail->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->address->Visible) { // address ?>
	<?php if ($caregivers->SortUrl($caregivers->address) == "") { ?>
		<td><?php echo $caregivers->address->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->address->FldCaption() ?></td><td style="width: 10px;"><?php if ($caregivers->address->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->address->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->apt_num->Visible) { // apt_num ?>
	<?php if ($caregivers->SortUrl($caregivers->apt_num) == "") { ?>
		<td><?php echo $caregivers->apt_num->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->apt_num->FldCaption() ?></td><td style="width: 10px;"><?php if ($caregivers->apt_num->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->apt_num->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->city->Visible) { // city ?>
	<?php if ($caregivers->SortUrl($caregivers->city) == "") { ?>
		<td><?php echo $caregivers->city->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->city->FldCaption() ?></td><td style="width: 10px;"><?php if ($caregivers->city->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->city->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->county->Visible) { // county ?>
	<?php if ($caregivers->SortUrl($caregivers->county) == "") { ?>
		<td><?php echo $caregivers->county->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->county->FldCaption() ?></td><td style="width: 10px;"><?php if ($caregivers->county->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->county->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->zip->Visible) { // zip ?>
	<?php if ($caregivers->SortUrl($caregivers->zip) == "") { ?>
		<td><?php echo $caregivers->zip->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->zip->FldCaption() ?></td><td style="width: 10px;"><?php if ($caregivers->zip->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->zip->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->num_deps->Visible) { // num_deps ?>
	<?php if ($caregivers->SortUrl($caregivers->num_deps) == "") { ?>
		<td><?php echo $caregivers->num_deps->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->num_deps->FldCaption() ?></td><td style="width: 10px;"><?php if ($caregivers->num_deps->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->num_deps->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->annual_income->Visible) { // annual_income ?>
	<?php if ($caregivers->SortUrl($caregivers->annual_income) == "") { ?>
		<td><?php echo $caregivers->annual_income->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->annual_income->FldCaption() ?></td><td style="width: 10px;"><?php if ($caregivers->annual_income->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->annual_income->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->app_source->Visible) { // app_source ?>
	<?php if ($caregivers->SortUrl($caregivers->app_source) == "") { ?>
		<td><?php echo $caregivers->app_source->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->app_source->FldCaption() ?></td><td style="width: 10px;"><?php if ($caregivers->app_source->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->app_source->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->dl->Visible) { // dl ?>
	<?php if ($caregivers->SortUrl($caregivers->dl) == "") { ?>
		<td><?php echo $caregivers->dl->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->dl->FldCaption() ?></td><td style="width: 10px;"><?php if ($caregivers->dl->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->dl->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->app_date->Visible) { // app_date ?>
	<?php if ($caregivers->SortUrl($caregivers->app_date) == "") { ?>
		<td><?php echo $caregivers->app_date->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->app_date->FldCaption() ?></td><td style="width: 10px;"><?php if ($caregivers->app_date->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->app_date->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->Expiration->Visible) { // Expiration ?>
	<?php if ($caregivers->SortUrl($caregivers->Expiration) == "") { ?>
		<td><?php echo $caregivers->Expiration->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->Expiration->FldCaption() ?></td><td style="width: 10px;"><?php if ($caregivers->Expiration->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->Expiration->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->ClinicGroup->Visible) { // ClinicGroup ?>
	<?php if ($caregivers->SortUrl($caregivers->ClinicGroup) == "") { ?>
		<td><?php echo $caregivers->ClinicGroup->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->ClinicGroup->FldCaption() ?></td><td style="width: 10px;"><?php if ($caregivers->ClinicGroup->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->ClinicGroup->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->DateSent->Visible) { // DateSent ?>
	<?php if ($caregivers->SortUrl($caregivers->DateSent) == "") { ?>
		<td><?php echo $caregivers->DateSent->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->DateSent->FldCaption() ?></td><td style="width: 10px;"><?php if ($caregivers->DateSent->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->DateSent->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->budget_category->Visible) { // budget_category ?>
	<?php if ($caregivers->SortUrl($caregivers->budget_category) == "") { ?>
		<td><?php echo $caregivers->budget_category->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->budget_category->FldCaption() ?></td><td style="width: 10px;"><?php if ($caregivers->budget_category->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->budget_category->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->AgeOfApplicant->Visible) { // AgeOfApplicant ?>
	<?php if ($caregivers->SortUrl($caregivers->AgeOfApplicant) == "") { ?>
		<td><?php echo $caregivers->AgeOfApplicant->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->AgeOfApplicant->FldCaption() ?></td><td style="width: 10px;"><?php if ($caregivers->AgeOfApplicant->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->AgeOfApplicant->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->Applic->Visible) { // Applic ?>
	<?php if ($caregivers->SortUrl($caregivers->Applic) == "") { ?>
		<td><?php echo $caregivers->Applic->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->Applic->FldCaption() ?></td><td style="width: 10px;"><?php if ($caregivers->Applic->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->Applic->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->SubApplic->Visible) { // SubApplic ?>
	<?php if ($caregivers->SortUrl($caregivers->SubApplic) == "") { ?>
		<td><?php echo $caregivers->SubApplic->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->SubApplic->FldCaption() ?></td><td style="width: 10px;"><?php if ($caregivers->SubApplic->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->SubApplic->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->DateSigned->Visible) { // DateSigned ?>
	<?php if ($caregivers->SortUrl($caregivers->DateSigned) == "") { ?>
		<td><?php echo $caregivers->DateSigned->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->DateSigned->FldCaption() ?></td><td style="width: 10px;"><?php if ($caregivers->DateSigned->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->DateSigned->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->colony_id->Visible) { // colony_id ?>
	<?php if ($caregivers->SortUrl($caregivers->colony_id) == "") { ?>
		<td><?php echo $caregivers->colony_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->colony_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($caregivers->colony_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->colony_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->mod_by->Visible) { // mod_by ?>
	<?php if ($caregivers->SortUrl($caregivers->mod_by) == "") { ?>
		<td><?php echo $caregivers->mod_by->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->mod_by->FldCaption() ?></td><td style="width: 10px;"><?php if ($caregivers->mod_by->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->mod_by->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($caregivers->mod_date->Visible) { // mod_date ?>
	<?php if ($caregivers->SortUrl($caregivers->mod_date) == "") { ?>
		<td><?php echo $caregivers->mod_date->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $caregivers->mod_date->FldCaption() ?></td><td style="width: 10px;"><?php if ($caregivers->mod_date->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($caregivers->mod_date->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$caregivers_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<?php
$caregivers_grid->StartRec = 1;
$caregivers_grid->StopRec = $caregivers_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = 0;
	if ($objForm->HasValue("key_count") && ($caregivers->CurrentAction == "gridadd" || $caregivers->CurrentAction == "gridedit" || $caregivers->CurrentAction == "F")) {
		$caregivers_grid->KeyCount = $objForm->GetValue("key_count");
		$caregivers_grid->StopRec = $caregivers_grid->KeyCount;
	}
}
$caregivers_grid->RecCnt = $caregivers_grid->StartRec - 1;
if ($caregivers_grid->Recordset && !$caregivers_grid->Recordset->EOF) {
	$caregivers_grid->Recordset->MoveFirst();
	if (!$bSelectLimit && $caregivers_grid->StartRec > 1)
		$caregivers_grid->Recordset->Move($caregivers_grid->StartRec - 1);
} elseif (!$caregivers->AllowAddDeleteRow && $caregivers_grid->StopRec == 0) {
	$caregivers_grid->StopRec = $caregivers->GridAddRowCount;
}

// Initialize aggregate
$caregivers->RowType = EW_ROWTYPE_AGGREGATEINIT;
$caregivers->ResetAttrs();
$caregivers_grid->RenderRow();
$caregivers_grid->RowCnt = 0;
if ($caregivers->CurrentAction == "gridadd")
	$caregivers_grid->RowIndex = 0;
if ($caregivers->CurrentAction == "gridedit")
	$caregivers_grid->RowIndex = 0;
while ($caregivers_grid->RecCnt < $caregivers_grid->StopRec) {
	$caregivers_grid->RecCnt++;
	if (intval($caregivers_grid->RecCnt) >= intval($caregivers_grid->StartRec)) {
		$caregivers_grid->RowCnt++;
		if ($caregivers->CurrentAction == "gridadd" || $caregivers->CurrentAction == "gridedit" || $caregivers->CurrentAction == "F") {
			$caregivers_grid->RowIndex++;
			$objForm->Index = $caregivers_grid->RowIndex;
			if ($objForm->HasValue("k_action"))
				$caregivers_grid->RowAction = strval($objForm->GetValue("k_action"));
			elseif ($caregivers->CurrentAction == "gridadd")
				$caregivers_grid->RowAction = "insert";
			else
				$caregivers_grid->RowAction = "";
		}

		// Set up key count
		$caregivers_grid->KeyCount = $caregivers_grid->RowIndex;

		// Init row class and style
		$caregivers->ResetAttrs();
		$caregivers->CssClass = "";
		if ($caregivers->CurrentAction == "gridadd") {
			if ($caregivers->CurrentMode == "copy") {
				$caregivers_grid->LoadRowValues($caregivers_grid->Recordset); // Load row values
				$caregivers_grid->SetRecordKey($caregivers_grid->RowOldKey, $caregivers_grid->Recordset); // Set old record key
			} else {
				$caregivers_grid->LoadDefaultValues(); // Load default values
				$caregivers_grid->RowOldKey = ""; // Clear old key value
			}
		} elseif ($caregivers->CurrentAction == "gridedit") {
			$caregivers_grid->LoadRowValues($caregivers_grid->Recordset); // Load row values
		}
		$caregivers->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($caregivers->CurrentAction == "gridadd") // Grid add
			$caregivers->RowType = EW_ROWTYPE_ADD; // Render add
		if ($caregivers->CurrentAction == "gridadd" && $caregivers->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$caregivers_grid->RestoreCurrentRowFormValues($caregivers_grid->RowIndex); // Restore form values
		if ($caregivers->CurrentAction == "gridedit") { // Grid edit
			if ($caregivers->EventCancelled) {
				$caregivers_grid->RestoreCurrentRowFormValues($caregivers_grid->RowIndex); // Restore form values
			}
			if ($caregivers_grid->RowAction == "insert")
				$caregivers->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$caregivers->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($caregivers->CurrentAction == "gridedit" && ($caregivers->RowType == EW_ROWTYPE_EDIT || $caregivers->RowType == EW_ROWTYPE_ADD) && $caregivers->EventCancelled) // Update failed
			$caregivers_grid->RestoreCurrentRowFormValues($caregivers_grid->RowIndex); // Restore form values
		if ($caregivers->RowType == EW_ROWTYPE_EDIT) // Edit row
			$caregivers_grid->EditRowCnt++;
		if ($caregivers->CurrentAction == "F") // Confirm row
			$caregivers_grid->RestoreCurrentRowFormValues($caregivers_grid->RowIndex); // Restore form values
		if ($caregivers->RowType == EW_ROWTYPE_ADD || $caregivers->RowType == EW_ROWTYPE_EDIT) { // Add / Edit row
			if ($caregivers->CurrentAction == "edit") {
				$caregivers->RowAttrs = array();
				$caregivers->CssClass = "ewTableEditRow";
			} else {
				$caregivers->RowAttrs = array();
			}
			if (!empty($caregivers_grid->RowIndex))
				$caregivers->RowAttrs = array_merge($caregivers->RowAttrs, array('data-rowindex'=>$caregivers_grid->RowIndex, 'id'=>'r' . $caregivers_grid->RowIndex . '_caregivers'));
		} else {
			$caregivers->RowAttrs = array();
		}

		// Render row
		$caregivers_grid->RenderRow();

		// Render list options
		$caregivers_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($caregivers_grid->RowAction <> "delete" && $caregivers_grid->RowAction <> "insertdelete" && !($caregivers_grid->RowAction == "insert" && $caregivers->CurrentAction == "F" && $caregivers_grid->EmptyRow())) {
?>
	<tr<?php echo $caregivers->RowAttributes() ?>>
<?php

// Render list options (body, left)
$caregivers_grid->ListOptions->Render("body", "left");
?>
	<?php if ($caregivers->caregiver_id->Visible) { // caregiver_id ?>
		<td<?php echo $caregivers->caregiver_id->CellAttributes() ?>>
<?php if ($caregivers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_caregiver_id" id="o<?php echo $caregivers_grid->RowIndex ?>_caregiver_id" value="<?php echo ew_HtmlEncode($caregivers->caregiver_id->OldValue) ?>">
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<div<?php echo $caregivers->caregiver_id->ViewAttributes() ?>><?php echo $caregivers->caregiver_id->EditValue ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_caregiver_id" id="x<?php echo $caregivers_grid->RowIndex ?>_caregiver_id" value="<?php echo ew_HtmlEncode($caregivers->caregiver_id->CurrentValue) ?>">
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $caregivers->caregiver_id->ViewAttributes() ?>><?php echo $caregivers->caregiver_id->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_caregiver_id" id="x<?php echo $caregivers_grid->RowIndex ?>_caregiver_id" value="<?php echo ew_HtmlEncode($caregivers->caregiver_id->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_caregiver_id" id="o<?php echo $caregivers_grid->RowIndex ?>_caregiver_id" value="<?php echo ew_HtmlEncode($caregivers->caregiver_id->OldValue) ?>">
<?php } ?>
<a name="<?php echo $caregivers_grid->PageObjName . "_row_" . $caregivers_grid->RowCnt ?>" id="<?php echo $caregivers_grid->PageObjName . "_row_" . $caregivers_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($caregivers->first_name->Visible) { // first_name ?>
		<td<?php echo $caregivers->first_name->CellAttributes() ?>>
<?php if ($caregivers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_first_name" id="x<?php echo $caregivers_grid->RowIndex ?>_first_name" size="30" maxlength="20" value="<?php echo $caregivers->first_name->EditValue ?>"<?php echo $caregivers->first_name->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_first_name" id="o<?php echo $caregivers_grid->RowIndex ?>_first_name" value="<?php echo ew_HtmlEncode($caregivers->first_name->OldValue) ?>">
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_first_name" id="x<?php echo $caregivers_grid->RowIndex ?>_first_name" size="30" maxlength="20" value="<?php echo $caregivers->first_name->EditValue ?>"<?php echo $caregivers->first_name->EditAttributes() ?>>
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $caregivers->first_name->ViewAttributes() ?>><?php echo $caregivers->first_name->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_first_name" id="x<?php echo $caregivers_grid->RowIndex ?>_first_name" value="<?php echo ew_HtmlEncode($caregivers->first_name->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_first_name" id="o<?php echo $caregivers_grid->RowIndex ?>_first_name" value="<?php echo ew_HtmlEncode($caregivers->first_name->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($caregivers->last_name->Visible) { // last_name ?>
		<td<?php echo $caregivers->last_name->CellAttributes() ?>>
<?php if ($caregivers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_last_name" id="x<?php echo $caregivers_grid->RowIndex ?>_last_name" size="30" maxlength="30" value="<?php echo $caregivers->last_name->EditValue ?>"<?php echo $caregivers->last_name->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_last_name" id="o<?php echo $caregivers_grid->RowIndex ?>_last_name" value="<?php echo ew_HtmlEncode($caregivers->last_name->OldValue) ?>">
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_last_name" id="x<?php echo $caregivers_grid->RowIndex ?>_last_name" size="30" maxlength="30" value="<?php echo $caregivers->last_name->EditValue ?>"<?php echo $caregivers->last_name->EditAttributes() ?>>
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $caregivers->last_name->ViewAttributes() ?>><?php echo $caregivers->last_name->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_last_name" id="x<?php echo $caregivers_grid->RowIndex ?>_last_name" value="<?php echo ew_HtmlEncode($caregivers->last_name->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_last_name" id="o<?php echo $caregivers_grid->RowIndex ?>_last_name" value="<?php echo ew_HtmlEncode($caregivers->last_name->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($caregivers->day_phone->Visible) { // day_phone ?>
		<td<?php echo $caregivers->day_phone->CellAttributes() ?>>
<?php if ($caregivers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_day_phone" id="x<?php echo $caregivers_grid->RowIndex ?>_day_phone" size="30" maxlength="20" value="<?php echo $caregivers->day_phone->EditValue ?>"<?php echo $caregivers->day_phone->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_day_phone" id="o<?php echo $caregivers_grid->RowIndex ?>_day_phone" value="<?php echo ew_HtmlEncode($caregivers->day_phone->OldValue) ?>">
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_day_phone" id="x<?php echo $caregivers_grid->RowIndex ?>_day_phone" size="30" maxlength="20" value="<?php echo $caregivers->day_phone->EditValue ?>"<?php echo $caregivers->day_phone->EditAttributes() ?>>
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $caregivers->day_phone->ViewAttributes() ?>><?php echo $caregivers->day_phone->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_day_phone" id="x<?php echo $caregivers_grid->RowIndex ?>_day_phone" value="<?php echo ew_HtmlEncode($caregivers->day_phone->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_day_phone" id="o<?php echo $caregivers_grid->RowIndex ?>_day_phone" value="<?php echo ew_HtmlEncode($caregivers->day_phone->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($caregivers->other_phone->Visible) { // other_phone ?>
		<td<?php echo $caregivers->other_phone->CellAttributes() ?>>
<?php if ($caregivers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_other_phone" id="x<?php echo $caregivers_grid->RowIndex ?>_other_phone" size="30" maxlength="20" value="<?php echo $caregivers->other_phone->EditValue ?>"<?php echo $caregivers->other_phone->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_other_phone" id="o<?php echo $caregivers_grid->RowIndex ?>_other_phone" value="<?php echo ew_HtmlEncode($caregivers->other_phone->OldValue) ?>">
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_other_phone" id="x<?php echo $caregivers_grid->RowIndex ?>_other_phone" size="30" maxlength="20" value="<?php echo $caregivers->other_phone->EditValue ?>"<?php echo $caregivers->other_phone->EditAttributes() ?>>
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $caregivers->other_phone->ViewAttributes() ?>><?php echo $caregivers->other_phone->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_other_phone" id="x<?php echo $caregivers_grid->RowIndex ?>_other_phone" value="<?php echo ew_HtmlEncode($caregivers->other_phone->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_other_phone" id="o<?php echo $caregivers_grid->RowIndex ?>_other_phone" value="<?php echo ew_HtmlEncode($caregivers->other_phone->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($caregivers->zemail->Visible) { // email ?>
		<td<?php echo $caregivers->zemail->CellAttributes() ?>>
<?php if ($caregivers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_zemail" id="x<?php echo $caregivers_grid->RowIndex ?>_zemail" size="30" maxlength="60" value="<?php echo $caregivers->zemail->EditValue ?>"<?php echo $caregivers->zemail->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_zemail" id="o<?php echo $caregivers_grid->RowIndex ?>_zemail" value="<?php echo ew_HtmlEncode($caregivers->zemail->OldValue) ?>">
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_zemail" id="x<?php echo $caregivers_grid->RowIndex ?>_zemail" size="30" maxlength="60" value="<?php echo $caregivers->zemail->EditValue ?>"<?php echo $caregivers->zemail->EditAttributes() ?>>
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $caregivers->zemail->ViewAttributes() ?>><?php echo $caregivers->zemail->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_zemail" id="x<?php echo $caregivers_grid->RowIndex ?>_zemail" value="<?php echo ew_HtmlEncode($caregivers->zemail->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_zemail" id="o<?php echo $caregivers_grid->RowIndex ?>_zemail" value="<?php echo ew_HtmlEncode($caregivers->zemail->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($caregivers->address->Visible) { // address ?>
		<td<?php echo $caregivers->address->CellAttributes() ?>>
<?php if ($caregivers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_address" id="x<?php echo $caregivers_grid->RowIndex ?>_address" size="30" maxlength="70" value="<?php echo $caregivers->address->EditValue ?>"<?php echo $caregivers->address->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_address" id="o<?php echo $caregivers_grid->RowIndex ?>_address" value="<?php echo ew_HtmlEncode($caregivers->address->OldValue) ?>">
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_address" id="x<?php echo $caregivers_grid->RowIndex ?>_address" size="30" maxlength="70" value="<?php echo $caregivers->address->EditValue ?>"<?php echo $caregivers->address->EditAttributes() ?>>
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $caregivers->address->ViewAttributes() ?>><?php echo $caregivers->address->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_address" id="x<?php echo $caregivers_grid->RowIndex ?>_address" value="<?php echo ew_HtmlEncode($caregivers->address->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_address" id="o<?php echo $caregivers_grid->RowIndex ?>_address" value="<?php echo ew_HtmlEncode($caregivers->address->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($caregivers->apt_num->Visible) { // apt_num ?>
		<td<?php echo $caregivers->apt_num->CellAttributes() ?>>
<?php if ($caregivers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_apt_num" id="x<?php echo $caregivers_grid->RowIndex ?>_apt_num" size="30" maxlength="5" value="<?php echo $caregivers->apt_num->EditValue ?>"<?php echo $caregivers->apt_num->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_apt_num" id="o<?php echo $caregivers_grid->RowIndex ?>_apt_num" value="<?php echo ew_HtmlEncode($caregivers->apt_num->OldValue) ?>">
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_apt_num" id="x<?php echo $caregivers_grid->RowIndex ?>_apt_num" size="30" maxlength="5" value="<?php echo $caregivers->apt_num->EditValue ?>"<?php echo $caregivers->apt_num->EditAttributes() ?>>
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $caregivers->apt_num->ViewAttributes() ?>><?php echo $caregivers->apt_num->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_apt_num" id="x<?php echo $caregivers_grid->RowIndex ?>_apt_num" value="<?php echo ew_HtmlEncode($caregivers->apt_num->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_apt_num" id="o<?php echo $caregivers_grid->RowIndex ?>_apt_num" value="<?php echo ew_HtmlEncode($caregivers->apt_num->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($caregivers->city->Visible) { // city ?>
		<td<?php echo $caregivers->city->CellAttributes() ?>>
<?php if ($caregivers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_city" id="x<?php echo $caregivers_grid->RowIndex ?>_city" size="30" maxlength="30" value="<?php echo $caregivers->city->EditValue ?>"<?php echo $caregivers->city->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_city" id="o<?php echo $caregivers_grid->RowIndex ?>_city" value="<?php echo ew_HtmlEncode($caregivers->city->OldValue) ?>">
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_city" id="x<?php echo $caregivers_grid->RowIndex ?>_city" size="30" maxlength="30" value="<?php echo $caregivers->city->EditValue ?>"<?php echo $caregivers->city->EditAttributes() ?>>
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $caregivers->city->ViewAttributes() ?>><?php echo $caregivers->city->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_city" id="x<?php echo $caregivers_grid->RowIndex ?>_city" value="<?php echo ew_HtmlEncode($caregivers->city->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_city" id="o<?php echo $caregivers_grid->RowIndex ?>_city" value="<?php echo ew_HtmlEncode($caregivers->city->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($caregivers->county->Visible) { // county ?>
		<td<?php echo $caregivers->county->CellAttributes() ?>>
<?php if ($caregivers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_county" id="x<?php echo $caregivers_grid->RowIndex ?>_county" size="30" maxlength="20" value="<?php echo $caregivers->county->EditValue ?>"<?php echo $caregivers->county->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_county" id="o<?php echo $caregivers_grid->RowIndex ?>_county" value="<?php echo ew_HtmlEncode($caregivers->county->OldValue) ?>">
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_county" id="x<?php echo $caregivers_grid->RowIndex ?>_county" size="30" maxlength="20" value="<?php echo $caregivers->county->EditValue ?>"<?php echo $caregivers->county->EditAttributes() ?>>
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $caregivers->county->ViewAttributes() ?>><?php echo $caregivers->county->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_county" id="x<?php echo $caregivers_grid->RowIndex ?>_county" value="<?php echo ew_HtmlEncode($caregivers->county->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_county" id="o<?php echo $caregivers_grid->RowIndex ?>_county" value="<?php echo ew_HtmlEncode($caregivers->county->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($caregivers->zip->Visible) { // zip ?>
		<td<?php echo $caregivers->zip->CellAttributes() ?>>
<?php if ($caregivers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_zip" id="x<?php echo $caregivers_grid->RowIndex ?>_zip" size="30" value="<?php echo $caregivers->zip->EditValue ?>"<?php echo $caregivers->zip->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_zip" id="o<?php echo $caregivers_grid->RowIndex ?>_zip" value="<?php echo ew_HtmlEncode($caregivers->zip->OldValue) ?>">
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_zip" id="x<?php echo $caregivers_grid->RowIndex ?>_zip" size="30" value="<?php echo $caregivers->zip->EditValue ?>"<?php echo $caregivers->zip->EditAttributes() ?>>
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $caregivers->zip->ViewAttributes() ?>><?php echo $caregivers->zip->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_zip" id="x<?php echo $caregivers_grid->RowIndex ?>_zip" value="<?php echo ew_HtmlEncode($caregivers->zip->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_zip" id="o<?php echo $caregivers_grid->RowIndex ?>_zip" value="<?php echo ew_HtmlEncode($caregivers->zip->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($caregivers->num_deps->Visible) { // num_deps ?>
		<td<?php echo $caregivers->num_deps->CellAttributes() ?>>
<?php if ($caregivers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_num_deps" id="x<?php echo $caregivers_grid->RowIndex ?>_num_deps" size="30" value="<?php echo $caregivers->num_deps->EditValue ?>"<?php echo $caregivers->num_deps->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_num_deps" id="o<?php echo $caregivers_grid->RowIndex ?>_num_deps" value="<?php echo ew_HtmlEncode($caregivers->num_deps->OldValue) ?>">
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_num_deps" id="x<?php echo $caregivers_grid->RowIndex ?>_num_deps" size="30" value="<?php echo $caregivers->num_deps->EditValue ?>"<?php echo $caregivers->num_deps->EditAttributes() ?>>
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $caregivers->num_deps->ViewAttributes() ?>><?php echo $caregivers->num_deps->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_num_deps" id="x<?php echo $caregivers_grid->RowIndex ?>_num_deps" value="<?php echo ew_HtmlEncode($caregivers->num_deps->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_num_deps" id="o<?php echo $caregivers_grid->RowIndex ?>_num_deps" value="<?php echo ew_HtmlEncode($caregivers->num_deps->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($caregivers->annual_income->Visible) { // annual_income ?>
		<td<?php echo $caregivers->annual_income->CellAttributes() ?>>
<?php if ($caregivers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_annual_income" id="x<?php echo $caregivers_grid->RowIndex ?>_annual_income" size="30" value="<?php echo $caregivers->annual_income->EditValue ?>"<?php echo $caregivers->annual_income->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_annual_income" id="o<?php echo $caregivers_grid->RowIndex ?>_annual_income" value="<?php echo ew_HtmlEncode($caregivers->annual_income->OldValue) ?>">
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_annual_income" id="x<?php echo $caregivers_grid->RowIndex ?>_annual_income" size="30" value="<?php echo $caregivers->annual_income->EditValue ?>"<?php echo $caregivers->annual_income->EditAttributes() ?>>
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $caregivers->annual_income->ViewAttributes() ?>><?php echo $caregivers->annual_income->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_annual_income" id="x<?php echo $caregivers_grid->RowIndex ?>_annual_income" value="<?php echo ew_HtmlEncode($caregivers->annual_income->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_annual_income" id="o<?php echo $caregivers_grid->RowIndex ?>_annual_income" value="<?php echo ew_HtmlEncode($caregivers->annual_income->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($caregivers->app_source->Visible) { // app_source ?>
		<td<?php echo $caregivers->app_source->CellAttributes() ?>>
<?php if ($caregivers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_app_source" id="x<?php echo $caregivers_grid->RowIndex ?>_app_source" size="30" value="<?php echo $caregivers->app_source->EditValue ?>"<?php echo $caregivers->app_source->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_app_source" id="o<?php echo $caregivers_grid->RowIndex ?>_app_source" value="<?php echo ew_HtmlEncode($caregivers->app_source->OldValue) ?>">
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_app_source" id="x<?php echo $caregivers_grid->RowIndex ?>_app_source" size="30" value="<?php echo $caregivers->app_source->EditValue ?>"<?php echo $caregivers->app_source->EditAttributes() ?>>
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $caregivers->app_source->ViewAttributes() ?>><?php echo $caregivers->app_source->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_app_source" id="x<?php echo $caregivers_grid->RowIndex ?>_app_source" value="<?php echo ew_HtmlEncode($caregivers->app_source->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_app_source" id="o<?php echo $caregivers_grid->RowIndex ?>_app_source" value="<?php echo ew_HtmlEncode($caregivers->app_source->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($caregivers->dl->Visible) { // dl ?>
		<td<?php echo $caregivers->dl->CellAttributes() ?>>
<?php if ($caregivers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_dl" id="x<?php echo $caregivers_grid->RowIndex ?>_dl" size="30" maxlength="10" value="<?php echo $caregivers->dl->EditValue ?>"<?php echo $caregivers->dl->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_dl" id="o<?php echo $caregivers_grid->RowIndex ?>_dl" value="<?php echo ew_HtmlEncode($caregivers->dl->OldValue) ?>">
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_dl" id="x<?php echo $caregivers_grid->RowIndex ?>_dl" size="30" maxlength="10" value="<?php echo $caregivers->dl->EditValue ?>"<?php echo $caregivers->dl->EditAttributes() ?>>
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $caregivers->dl->ViewAttributes() ?>><?php echo $caregivers->dl->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_dl" id="x<?php echo $caregivers_grid->RowIndex ?>_dl" value="<?php echo ew_HtmlEncode($caregivers->dl->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_dl" id="o<?php echo $caregivers_grid->RowIndex ?>_dl" value="<?php echo ew_HtmlEncode($caregivers->dl->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($caregivers->app_date->Visible) { // app_date ?>
		<td<?php echo $caregivers->app_date->CellAttributes() ?>>
<?php if ($caregivers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_app_date" id="x<?php echo $caregivers_grid->RowIndex ?>_app_date" value="<?php echo $caregivers->app_date->EditValue ?>"<?php echo $caregivers->app_date->EditAttributes() ?>>
<input type="hidden" name="fo<?php echo $caregivers_grid->RowIndex ?>_app_date" id="fo<?php echo $caregivers_grid->RowIndex ?>_app_date" value="<?php echo ew_HtmlEncode(ew_FormatDateTime($caregivers->app_date->OldValue, 5)) ?>">
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_app_date" id="o<?php echo $caregivers_grid->RowIndex ?>_app_date" value="<?php echo ew_HtmlEncode($caregivers->app_date->OldValue) ?>">
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_app_date" id="x<?php echo $caregivers_grid->RowIndex ?>_app_date" value="<?php echo $caregivers->app_date->EditValue ?>"<?php echo $caregivers->app_date->EditAttributes() ?>>
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $caregivers->app_date->ViewAttributes() ?>><?php echo $caregivers->app_date->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_app_date" id="x<?php echo $caregivers_grid->RowIndex ?>_app_date" value="<?php echo ew_HtmlEncode($caregivers->app_date->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_app_date" id="o<?php echo $caregivers_grid->RowIndex ?>_app_date" value="<?php echo ew_HtmlEncode($caregivers->app_date->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($caregivers->Expiration->Visible) { // Expiration ?>
		<td<?php echo $caregivers->Expiration->CellAttributes() ?>>
<?php if ($caregivers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_Expiration" id="x<?php echo $caregivers_grid->RowIndex ?>_Expiration" value="<?php echo $caregivers->Expiration->EditValue ?>"<?php echo $caregivers->Expiration->EditAttributes() ?>>
<input type="hidden" name="fo<?php echo $caregivers_grid->RowIndex ?>_Expiration" id="fo<?php echo $caregivers_grid->RowIndex ?>_Expiration" value="<?php echo ew_HtmlEncode(ew_FormatDateTime($caregivers->Expiration->OldValue, 5)) ?>">
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_Expiration" id="o<?php echo $caregivers_grid->RowIndex ?>_Expiration" value="<?php echo ew_HtmlEncode($caregivers->Expiration->OldValue) ?>">
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_Expiration" id="x<?php echo $caregivers_grid->RowIndex ?>_Expiration" value="<?php echo $caregivers->Expiration->EditValue ?>"<?php echo $caregivers->Expiration->EditAttributes() ?>>
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $caregivers->Expiration->ViewAttributes() ?>><?php echo $caregivers->Expiration->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_Expiration" id="x<?php echo $caregivers_grid->RowIndex ?>_Expiration" value="<?php echo ew_HtmlEncode($caregivers->Expiration->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_Expiration" id="o<?php echo $caregivers_grid->RowIndex ?>_Expiration" value="<?php echo ew_HtmlEncode($caregivers->Expiration->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($caregivers->ClinicGroup->Visible) { // ClinicGroup ?>
		<td<?php echo $caregivers->ClinicGroup->CellAttributes() ?>>
<?php if ($caregivers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_ClinicGroup" id="x<?php echo $caregivers_grid->RowIndex ?>_ClinicGroup" size="30" maxlength="25" value="<?php echo $caregivers->ClinicGroup->EditValue ?>"<?php echo $caregivers->ClinicGroup->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_ClinicGroup" id="o<?php echo $caregivers_grid->RowIndex ?>_ClinicGroup" value="<?php echo ew_HtmlEncode($caregivers->ClinicGroup->OldValue) ?>">
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_ClinicGroup" id="x<?php echo $caregivers_grid->RowIndex ?>_ClinicGroup" size="30" maxlength="25" value="<?php echo $caregivers->ClinicGroup->EditValue ?>"<?php echo $caregivers->ClinicGroup->EditAttributes() ?>>
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $caregivers->ClinicGroup->ViewAttributes() ?>><?php echo $caregivers->ClinicGroup->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_ClinicGroup" id="x<?php echo $caregivers_grid->RowIndex ?>_ClinicGroup" value="<?php echo ew_HtmlEncode($caregivers->ClinicGroup->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_ClinicGroup" id="o<?php echo $caregivers_grid->RowIndex ?>_ClinicGroup" value="<?php echo ew_HtmlEncode($caregivers->ClinicGroup->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($caregivers->DateSent->Visible) { // DateSent ?>
		<td<?php echo $caregivers->DateSent->CellAttributes() ?>>
<?php if ($caregivers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_DateSent" id="x<?php echo $caregivers_grid->RowIndex ?>_DateSent" value="<?php echo $caregivers->DateSent->EditValue ?>"<?php echo $caregivers->DateSent->EditAttributes() ?>>
<input type="hidden" name="fo<?php echo $caregivers_grid->RowIndex ?>_DateSent" id="fo<?php echo $caregivers_grid->RowIndex ?>_DateSent" value="<?php echo ew_HtmlEncode(ew_FormatDateTime($caregivers->DateSent->OldValue, 5)) ?>">
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_DateSent" id="o<?php echo $caregivers_grid->RowIndex ?>_DateSent" value="<?php echo ew_HtmlEncode($caregivers->DateSent->OldValue) ?>">
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_DateSent" id="x<?php echo $caregivers_grid->RowIndex ?>_DateSent" value="<?php echo $caregivers->DateSent->EditValue ?>"<?php echo $caregivers->DateSent->EditAttributes() ?>>
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $caregivers->DateSent->ViewAttributes() ?>><?php echo $caregivers->DateSent->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_DateSent" id="x<?php echo $caregivers_grid->RowIndex ?>_DateSent" value="<?php echo ew_HtmlEncode($caregivers->DateSent->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_DateSent" id="o<?php echo $caregivers_grid->RowIndex ?>_DateSent" value="<?php echo ew_HtmlEncode($caregivers->DateSent->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($caregivers->budget_category->Visible) { // budget_category ?>
		<td<?php echo $caregivers->budget_category->CellAttributes() ?>>
<?php if ($caregivers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_budget_category" id="x<?php echo $caregivers_grid->RowIndex ?>_budget_category" size="30" value="<?php echo $caregivers->budget_category->EditValue ?>"<?php echo $caregivers->budget_category->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_budget_category" id="o<?php echo $caregivers_grid->RowIndex ?>_budget_category" value="<?php echo ew_HtmlEncode($caregivers->budget_category->OldValue) ?>">
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_budget_category" id="x<?php echo $caregivers_grid->RowIndex ?>_budget_category" size="30" value="<?php echo $caregivers->budget_category->EditValue ?>"<?php echo $caregivers->budget_category->EditAttributes() ?>>
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $caregivers->budget_category->ViewAttributes() ?>><?php echo $caregivers->budget_category->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_budget_category" id="x<?php echo $caregivers_grid->RowIndex ?>_budget_category" value="<?php echo ew_HtmlEncode($caregivers->budget_category->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_budget_category" id="o<?php echo $caregivers_grid->RowIndex ?>_budget_category" value="<?php echo ew_HtmlEncode($caregivers->budget_category->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($caregivers->AgeOfApplicant->Visible) { // AgeOfApplicant ?>
		<td<?php echo $caregivers->AgeOfApplicant->CellAttributes() ?>>
<?php if ($caregivers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_AgeOfApplicant" id="x<?php echo $caregivers_grid->RowIndex ?>_AgeOfApplicant" size="30" value="<?php echo $caregivers->AgeOfApplicant->EditValue ?>"<?php echo $caregivers->AgeOfApplicant->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_AgeOfApplicant" id="o<?php echo $caregivers_grid->RowIndex ?>_AgeOfApplicant" value="<?php echo ew_HtmlEncode($caregivers->AgeOfApplicant->OldValue) ?>">
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_AgeOfApplicant" id="x<?php echo $caregivers_grid->RowIndex ?>_AgeOfApplicant" size="30" value="<?php echo $caregivers->AgeOfApplicant->EditValue ?>"<?php echo $caregivers->AgeOfApplicant->EditAttributes() ?>>
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $caregivers->AgeOfApplicant->ViewAttributes() ?>><?php echo $caregivers->AgeOfApplicant->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_AgeOfApplicant" id="x<?php echo $caregivers_grid->RowIndex ?>_AgeOfApplicant" value="<?php echo ew_HtmlEncode($caregivers->AgeOfApplicant->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_AgeOfApplicant" id="o<?php echo $caregivers_grid->RowIndex ?>_AgeOfApplicant" value="<?php echo ew_HtmlEncode($caregivers->AgeOfApplicant->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($caregivers->Applic->Visible) { // Applic ?>
		<td<?php echo $caregivers->Applic->CellAttributes() ?>>
<?php if ($caregivers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_Applic" id="x<?php echo $caregivers_grid->RowIndex ?>_Applic" size="30" maxlength="32" value="<?php echo $caregivers->Applic->EditValue ?>"<?php echo $caregivers->Applic->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_Applic" id="o<?php echo $caregivers_grid->RowIndex ?>_Applic" value="<?php echo ew_HtmlEncode($caregivers->Applic->OldValue) ?>">
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_Applic" id="x<?php echo $caregivers_grid->RowIndex ?>_Applic" size="30" maxlength="32" value="<?php echo $caregivers->Applic->EditValue ?>"<?php echo $caregivers->Applic->EditAttributes() ?>>
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $caregivers->Applic->ViewAttributes() ?>><?php echo $caregivers->Applic->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_Applic" id="x<?php echo $caregivers_grid->RowIndex ?>_Applic" value="<?php echo ew_HtmlEncode($caregivers->Applic->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_Applic" id="o<?php echo $caregivers_grid->RowIndex ?>_Applic" value="<?php echo ew_HtmlEncode($caregivers->Applic->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($caregivers->SubApplic->Visible) { // SubApplic ?>
		<td<?php echo $caregivers->SubApplic->CellAttributes() ?>>
<?php if ($caregivers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_SubApplic" id="x<?php echo $caregivers_grid->RowIndex ?>_SubApplic" size="30" maxlength="32" value="<?php echo $caregivers->SubApplic->EditValue ?>"<?php echo $caregivers->SubApplic->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_SubApplic" id="o<?php echo $caregivers_grid->RowIndex ?>_SubApplic" value="<?php echo ew_HtmlEncode($caregivers->SubApplic->OldValue) ?>">
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_SubApplic" id="x<?php echo $caregivers_grid->RowIndex ?>_SubApplic" size="30" maxlength="32" value="<?php echo $caregivers->SubApplic->EditValue ?>"<?php echo $caregivers->SubApplic->EditAttributes() ?>>
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $caregivers->SubApplic->ViewAttributes() ?>><?php echo $caregivers->SubApplic->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_SubApplic" id="x<?php echo $caregivers_grid->RowIndex ?>_SubApplic" value="<?php echo ew_HtmlEncode($caregivers->SubApplic->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_SubApplic" id="o<?php echo $caregivers_grid->RowIndex ?>_SubApplic" value="<?php echo ew_HtmlEncode($caregivers->SubApplic->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($caregivers->DateSigned->Visible) { // DateSigned ?>
		<td<?php echo $caregivers->DateSigned->CellAttributes() ?>>
<?php if ($caregivers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_DateSigned" id="x<?php echo $caregivers_grid->RowIndex ?>_DateSigned" value="<?php echo $caregivers->DateSigned->EditValue ?>"<?php echo $caregivers->DateSigned->EditAttributes() ?>>
<input type="hidden" name="fo<?php echo $caregivers_grid->RowIndex ?>_DateSigned" id="fo<?php echo $caregivers_grid->RowIndex ?>_DateSigned" value="<?php echo ew_HtmlEncode(ew_FormatDateTime($caregivers->DateSigned->OldValue, 5)) ?>">
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_DateSigned" id="o<?php echo $caregivers_grid->RowIndex ?>_DateSigned" value="<?php echo ew_HtmlEncode($caregivers->DateSigned->OldValue) ?>">
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_DateSigned" id="x<?php echo $caregivers_grid->RowIndex ?>_DateSigned" value="<?php echo $caregivers->DateSigned->EditValue ?>"<?php echo $caregivers->DateSigned->EditAttributes() ?>>
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $caregivers->DateSigned->ViewAttributes() ?>><?php echo $caregivers->DateSigned->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_DateSigned" id="x<?php echo $caregivers_grid->RowIndex ?>_DateSigned" value="<?php echo ew_HtmlEncode($caregivers->DateSigned->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_DateSigned" id="o<?php echo $caregivers_grid->RowIndex ?>_DateSigned" value="<?php echo ew_HtmlEncode($caregivers->DateSigned->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($caregivers->colony_id->Visible) { // colony_id ?>
		<td<?php echo $caregivers->colony_id->CellAttributes() ?>>
<?php if ($caregivers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($caregivers->colony_id->getSessionValue() <> "") { ?>
<div<?php echo $caregivers->colony_id->ViewAttributes() ?>><?php echo $caregivers->colony_id->ListViewValue() ?></div>
<input type="hidden" id="x<?php echo $caregivers_grid->RowIndex ?>_colony_id" name="x<?php echo $caregivers_grid->RowIndex ?>_colony_id" value="<?php echo ew_HtmlEncode($caregivers->colony_id->CurrentValue) ?>">
<?php } else { ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_colony_id" id="x<?php echo $caregivers_grid->RowIndex ?>_colony_id" size="30" value="<?php echo $caregivers->colony_id->EditValue ?>"<?php echo $caregivers->colony_id->EditAttributes() ?>>
<?php } ?>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_colony_id" id="o<?php echo $caregivers_grid->RowIndex ?>_colony_id" value="<?php echo ew_HtmlEncode($caregivers->colony_id->OldValue) ?>">
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($caregivers->colony_id->getSessionValue() <> "") { ?>
<div<?php echo $caregivers->colony_id->ViewAttributes() ?>><?php echo $caregivers->colony_id->ListViewValue() ?></div>
<input type="hidden" id="x<?php echo $caregivers_grid->RowIndex ?>_colony_id" name="x<?php echo $caregivers_grid->RowIndex ?>_colony_id" value="<?php echo ew_HtmlEncode($caregivers->colony_id->CurrentValue) ?>">
<?php } else { ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_colony_id" id="x<?php echo $caregivers_grid->RowIndex ?>_colony_id" size="30" value="<?php echo $caregivers->colony_id->EditValue ?>"<?php echo $caregivers->colony_id->EditAttributes() ?>>
<?php } ?>
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $caregivers->colony_id->ViewAttributes() ?>><?php echo $caregivers->colony_id->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_colony_id" id="x<?php echo $caregivers_grid->RowIndex ?>_colony_id" value="<?php echo ew_HtmlEncode($caregivers->colony_id->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_colony_id" id="o<?php echo $caregivers_grid->RowIndex ?>_colony_id" value="<?php echo ew_HtmlEncode($caregivers->colony_id->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($caregivers->mod_by->Visible) { // mod_by ?>
		<td<?php echo $caregivers->mod_by->CellAttributes() ?>>
<?php if ($caregivers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_mod_by" id="x<?php echo $caregivers_grid->RowIndex ?>_mod_by" size="30" maxlength="20" value="<?php echo $caregivers->mod_by->EditValue ?>"<?php echo $caregivers->mod_by->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_mod_by" id="o<?php echo $caregivers_grid->RowIndex ?>_mod_by" value="<?php echo ew_HtmlEncode($caregivers->mod_by->OldValue) ?>">
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_mod_by" id="x<?php echo $caregivers_grid->RowIndex ?>_mod_by" size="30" maxlength="20" value="<?php echo $caregivers->mod_by->EditValue ?>"<?php echo $caregivers->mod_by->EditAttributes() ?>>
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $caregivers->mod_by->ViewAttributes() ?>><?php echo $caregivers->mod_by->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_mod_by" id="x<?php echo $caregivers_grid->RowIndex ?>_mod_by" value="<?php echo ew_HtmlEncode($caregivers->mod_by->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_mod_by" id="o<?php echo $caregivers_grid->RowIndex ?>_mod_by" value="<?php echo ew_HtmlEncode($caregivers->mod_by->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($caregivers->mod_date->Visible) { // mod_date ?>
		<td<?php echo $caregivers->mod_date->CellAttributes() ?>>
<?php if ($caregivers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_mod_date" id="x<?php echo $caregivers_grid->RowIndex ?>_mod_date" value="<?php echo $caregivers->mod_date->EditValue ?>"<?php echo $caregivers->mod_date->EditAttributes() ?>>
<input type="hidden" name="fo<?php echo $caregivers_grid->RowIndex ?>_mod_date" id="fo<?php echo $caregivers_grid->RowIndex ?>_mod_date" value="<?php echo ew_HtmlEncode(ew_FormatDateTime($caregivers->mod_date->OldValue, 5)) ?>">
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_mod_date" id="o<?php echo $caregivers_grid->RowIndex ?>_mod_date" value="<?php echo ew_HtmlEncode($caregivers->mod_date->OldValue) ?>">
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_mod_date" id="x<?php echo $caregivers_grid->RowIndex ?>_mod_date" value="<?php echo $caregivers->mod_date->EditValue ?>"<?php echo $caregivers->mod_date->EditAttributes() ?>>
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $caregivers->mod_date->ViewAttributes() ?>><?php echo $caregivers->mod_date->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_mod_date" id="x<?php echo $caregivers_grid->RowIndex ?>_mod_date" value="<?php echo ew_HtmlEncode($caregivers->mod_date->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_mod_date" id="o<?php echo $caregivers_grid->RowIndex ?>_mod_date" value="<?php echo ew_HtmlEncode($caregivers->mod_date->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$caregivers_grid->ListOptions->Render("body", "right");
?>
	</tr>
<?php if ($caregivers->RowType == EW_ROWTYPE_ADD) { ?>
<?php } ?>
<?php if ($caregivers->RowType == EW_ROWTYPE_EDIT) { ?>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($caregivers->CurrentAction <> "gridadd" || $caregivers->CurrentMode == "copy")
		if (!$caregivers_grid->Recordset->EOF) $caregivers_grid->Recordset->MoveNext();
}
?>
<?php
	if ($caregivers->CurrentMode == "add" || $caregivers->CurrentMode == "copy" || $caregivers->CurrentMode == "edit") {
		$caregivers_grid->RowIndex = '$rowindex$';
		$caregivers_grid->LoadDefaultValues();

		// Set row properties
		$caregivers->ResetAttrs();
		$caregivers->RowAttrs = array();
		if (!empty($caregivers_grid->RowIndex))
			$caregivers->RowAttrs = array_merge($caregivers->RowAttrs, array('data-rowindex'=>$caregivers_grid->RowIndex, 'id'=>'r' . $caregivers_grid->RowIndex . '_caregivers'));
		$caregivers->RowType = EW_ROWTYPE_ADD;

		// Render row
		$caregivers_grid->RenderRow();

		// Render list options
		$caregivers_grid->RenderListOptions();

		// Add id and class to the template row
		$caregivers->RowAttrs["id"] = "r0_caregivers";
		ew_AppendClass($caregivers->RowAttrs["class"], "ewTemplate");
?>
	<tr<?php echo $caregivers->RowAttributes() ?>>
<?php

// Render list options (body, left)
$caregivers_grid->ListOptions->Render("body", "left");
?>
	<?php if ($caregivers->caregiver_id->Visible) { // caregiver_id ?>
		<td>&nbsp;</td>
	<?php } ?>
	<?php if ($caregivers->first_name->Visible) { // first_name ?>
		<td>
<?php if ($caregivers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_first_name" id="x<?php echo $caregivers_grid->RowIndex ?>_first_name" size="30" maxlength="20" value="<?php echo $caregivers->first_name->EditValue ?>"<?php echo $caregivers->first_name->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $caregivers->first_name->ViewAttributes() ?>><?php echo $caregivers->first_name->ViewValue ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_first_name" id="x<?php echo $caregivers_grid->RowIndex ?>_first_name" value="<?php echo ew_HtmlEncode($caregivers->first_name->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_first_name" id="o<?php echo $caregivers_grid->RowIndex ?>_first_name" value="<?php echo ew_HtmlEncode($caregivers->first_name->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($caregivers->last_name->Visible) { // last_name ?>
		<td>
<?php if ($caregivers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_last_name" id="x<?php echo $caregivers_grid->RowIndex ?>_last_name" size="30" maxlength="30" value="<?php echo $caregivers->last_name->EditValue ?>"<?php echo $caregivers->last_name->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $caregivers->last_name->ViewAttributes() ?>><?php echo $caregivers->last_name->ViewValue ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_last_name" id="x<?php echo $caregivers_grid->RowIndex ?>_last_name" value="<?php echo ew_HtmlEncode($caregivers->last_name->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_last_name" id="o<?php echo $caregivers_grid->RowIndex ?>_last_name" value="<?php echo ew_HtmlEncode($caregivers->last_name->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($caregivers->day_phone->Visible) { // day_phone ?>
		<td>
<?php if ($caregivers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_day_phone" id="x<?php echo $caregivers_grid->RowIndex ?>_day_phone" size="30" maxlength="20" value="<?php echo $caregivers->day_phone->EditValue ?>"<?php echo $caregivers->day_phone->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $caregivers->day_phone->ViewAttributes() ?>><?php echo $caregivers->day_phone->ViewValue ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_day_phone" id="x<?php echo $caregivers_grid->RowIndex ?>_day_phone" value="<?php echo ew_HtmlEncode($caregivers->day_phone->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_day_phone" id="o<?php echo $caregivers_grid->RowIndex ?>_day_phone" value="<?php echo ew_HtmlEncode($caregivers->day_phone->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($caregivers->other_phone->Visible) { // other_phone ?>
		<td>
<?php if ($caregivers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_other_phone" id="x<?php echo $caregivers_grid->RowIndex ?>_other_phone" size="30" maxlength="20" value="<?php echo $caregivers->other_phone->EditValue ?>"<?php echo $caregivers->other_phone->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $caregivers->other_phone->ViewAttributes() ?>><?php echo $caregivers->other_phone->ViewValue ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_other_phone" id="x<?php echo $caregivers_grid->RowIndex ?>_other_phone" value="<?php echo ew_HtmlEncode($caregivers->other_phone->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_other_phone" id="o<?php echo $caregivers_grid->RowIndex ?>_other_phone" value="<?php echo ew_HtmlEncode($caregivers->other_phone->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($caregivers->zemail->Visible) { // email ?>
		<td>
<?php if ($caregivers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_zemail" id="x<?php echo $caregivers_grid->RowIndex ?>_zemail" size="30" maxlength="60" value="<?php echo $caregivers->zemail->EditValue ?>"<?php echo $caregivers->zemail->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $caregivers->zemail->ViewAttributes() ?>><?php echo $caregivers->zemail->ViewValue ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_zemail" id="x<?php echo $caregivers_grid->RowIndex ?>_zemail" value="<?php echo ew_HtmlEncode($caregivers->zemail->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_zemail" id="o<?php echo $caregivers_grid->RowIndex ?>_zemail" value="<?php echo ew_HtmlEncode($caregivers->zemail->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($caregivers->address->Visible) { // address ?>
		<td>
<?php if ($caregivers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_address" id="x<?php echo $caregivers_grid->RowIndex ?>_address" size="30" maxlength="70" value="<?php echo $caregivers->address->EditValue ?>"<?php echo $caregivers->address->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $caregivers->address->ViewAttributes() ?>><?php echo $caregivers->address->ViewValue ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_address" id="x<?php echo $caregivers_grid->RowIndex ?>_address" value="<?php echo ew_HtmlEncode($caregivers->address->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_address" id="o<?php echo $caregivers_grid->RowIndex ?>_address" value="<?php echo ew_HtmlEncode($caregivers->address->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($caregivers->apt_num->Visible) { // apt_num ?>
		<td>
<?php if ($caregivers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_apt_num" id="x<?php echo $caregivers_grid->RowIndex ?>_apt_num" size="30" maxlength="5" value="<?php echo $caregivers->apt_num->EditValue ?>"<?php echo $caregivers->apt_num->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $caregivers->apt_num->ViewAttributes() ?>><?php echo $caregivers->apt_num->ViewValue ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_apt_num" id="x<?php echo $caregivers_grid->RowIndex ?>_apt_num" value="<?php echo ew_HtmlEncode($caregivers->apt_num->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_apt_num" id="o<?php echo $caregivers_grid->RowIndex ?>_apt_num" value="<?php echo ew_HtmlEncode($caregivers->apt_num->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($caregivers->city->Visible) { // city ?>
		<td>
<?php if ($caregivers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_city" id="x<?php echo $caregivers_grid->RowIndex ?>_city" size="30" maxlength="30" value="<?php echo $caregivers->city->EditValue ?>"<?php echo $caregivers->city->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $caregivers->city->ViewAttributes() ?>><?php echo $caregivers->city->ViewValue ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_city" id="x<?php echo $caregivers_grid->RowIndex ?>_city" value="<?php echo ew_HtmlEncode($caregivers->city->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_city" id="o<?php echo $caregivers_grid->RowIndex ?>_city" value="<?php echo ew_HtmlEncode($caregivers->city->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($caregivers->county->Visible) { // county ?>
		<td>
<?php if ($caregivers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_county" id="x<?php echo $caregivers_grid->RowIndex ?>_county" size="30" maxlength="20" value="<?php echo $caregivers->county->EditValue ?>"<?php echo $caregivers->county->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $caregivers->county->ViewAttributes() ?>><?php echo $caregivers->county->ViewValue ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_county" id="x<?php echo $caregivers_grid->RowIndex ?>_county" value="<?php echo ew_HtmlEncode($caregivers->county->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_county" id="o<?php echo $caregivers_grid->RowIndex ?>_county" value="<?php echo ew_HtmlEncode($caregivers->county->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($caregivers->zip->Visible) { // zip ?>
		<td>
<?php if ($caregivers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_zip" id="x<?php echo $caregivers_grid->RowIndex ?>_zip" size="30" value="<?php echo $caregivers->zip->EditValue ?>"<?php echo $caregivers->zip->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $caregivers->zip->ViewAttributes() ?>><?php echo $caregivers->zip->ViewValue ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_zip" id="x<?php echo $caregivers_grid->RowIndex ?>_zip" value="<?php echo ew_HtmlEncode($caregivers->zip->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_zip" id="o<?php echo $caregivers_grid->RowIndex ?>_zip" value="<?php echo ew_HtmlEncode($caregivers->zip->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($caregivers->num_deps->Visible) { // num_deps ?>
		<td>
<?php if ($caregivers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_num_deps" id="x<?php echo $caregivers_grid->RowIndex ?>_num_deps" size="30" value="<?php echo $caregivers->num_deps->EditValue ?>"<?php echo $caregivers->num_deps->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $caregivers->num_deps->ViewAttributes() ?>><?php echo $caregivers->num_deps->ViewValue ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_num_deps" id="x<?php echo $caregivers_grid->RowIndex ?>_num_deps" value="<?php echo ew_HtmlEncode($caregivers->num_deps->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_num_deps" id="o<?php echo $caregivers_grid->RowIndex ?>_num_deps" value="<?php echo ew_HtmlEncode($caregivers->num_deps->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($caregivers->annual_income->Visible) { // annual_income ?>
		<td>
<?php if ($caregivers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_annual_income" id="x<?php echo $caregivers_grid->RowIndex ?>_annual_income" size="30" value="<?php echo $caregivers->annual_income->EditValue ?>"<?php echo $caregivers->annual_income->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $caregivers->annual_income->ViewAttributes() ?>><?php echo $caregivers->annual_income->ViewValue ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_annual_income" id="x<?php echo $caregivers_grid->RowIndex ?>_annual_income" value="<?php echo ew_HtmlEncode($caregivers->annual_income->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_annual_income" id="o<?php echo $caregivers_grid->RowIndex ?>_annual_income" value="<?php echo ew_HtmlEncode($caregivers->annual_income->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($caregivers->app_source->Visible) { // app_source ?>
		<td>
<?php if ($caregivers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_app_source" id="x<?php echo $caregivers_grid->RowIndex ?>_app_source" size="30" value="<?php echo $caregivers->app_source->EditValue ?>"<?php echo $caregivers->app_source->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $caregivers->app_source->ViewAttributes() ?>><?php echo $caregivers->app_source->ViewValue ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_app_source" id="x<?php echo $caregivers_grid->RowIndex ?>_app_source" value="<?php echo ew_HtmlEncode($caregivers->app_source->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_app_source" id="o<?php echo $caregivers_grid->RowIndex ?>_app_source" value="<?php echo ew_HtmlEncode($caregivers->app_source->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($caregivers->dl->Visible) { // dl ?>
		<td>
<?php if ($caregivers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_dl" id="x<?php echo $caregivers_grid->RowIndex ?>_dl" size="30" maxlength="10" value="<?php echo $caregivers->dl->EditValue ?>"<?php echo $caregivers->dl->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $caregivers->dl->ViewAttributes() ?>><?php echo $caregivers->dl->ViewValue ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_dl" id="x<?php echo $caregivers_grid->RowIndex ?>_dl" value="<?php echo ew_HtmlEncode($caregivers->dl->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_dl" id="o<?php echo $caregivers_grid->RowIndex ?>_dl" value="<?php echo ew_HtmlEncode($caregivers->dl->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($caregivers->app_date->Visible) { // app_date ?>
		<td>
<?php if ($caregivers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_app_date" id="x<?php echo $caregivers_grid->RowIndex ?>_app_date" value="<?php echo $caregivers->app_date->EditValue ?>"<?php echo $caregivers->app_date->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $caregivers->app_date->ViewAttributes() ?>><?php echo $caregivers->app_date->ViewValue ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_app_date" id="x<?php echo $caregivers_grid->RowIndex ?>_app_date" value="<?php echo ew_HtmlEncode($caregivers->app_date->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_app_date" id="o<?php echo $caregivers_grid->RowIndex ?>_app_date" value="<?php echo ew_HtmlEncode($caregivers->app_date->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($caregivers->Expiration->Visible) { // Expiration ?>
		<td>
<?php if ($caregivers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_Expiration" id="x<?php echo $caregivers_grid->RowIndex ?>_Expiration" value="<?php echo $caregivers->Expiration->EditValue ?>"<?php echo $caregivers->Expiration->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $caregivers->Expiration->ViewAttributes() ?>><?php echo $caregivers->Expiration->ViewValue ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_Expiration" id="x<?php echo $caregivers_grid->RowIndex ?>_Expiration" value="<?php echo ew_HtmlEncode($caregivers->Expiration->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_Expiration" id="o<?php echo $caregivers_grid->RowIndex ?>_Expiration" value="<?php echo ew_HtmlEncode($caregivers->Expiration->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($caregivers->ClinicGroup->Visible) { // ClinicGroup ?>
		<td>
<?php if ($caregivers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_ClinicGroup" id="x<?php echo $caregivers_grid->RowIndex ?>_ClinicGroup" size="30" maxlength="25" value="<?php echo $caregivers->ClinicGroup->EditValue ?>"<?php echo $caregivers->ClinicGroup->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $caregivers->ClinicGroup->ViewAttributes() ?>><?php echo $caregivers->ClinicGroup->ViewValue ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_ClinicGroup" id="x<?php echo $caregivers_grid->RowIndex ?>_ClinicGroup" value="<?php echo ew_HtmlEncode($caregivers->ClinicGroup->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_ClinicGroup" id="o<?php echo $caregivers_grid->RowIndex ?>_ClinicGroup" value="<?php echo ew_HtmlEncode($caregivers->ClinicGroup->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($caregivers->DateSent->Visible) { // DateSent ?>
		<td>
<?php if ($caregivers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_DateSent" id="x<?php echo $caregivers_grid->RowIndex ?>_DateSent" value="<?php echo $caregivers->DateSent->EditValue ?>"<?php echo $caregivers->DateSent->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $caregivers->DateSent->ViewAttributes() ?>><?php echo $caregivers->DateSent->ViewValue ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_DateSent" id="x<?php echo $caregivers_grid->RowIndex ?>_DateSent" value="<?php echo ew_HtmlEncode($caregivers->DateSent->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_DateSent" id="o<?php echo $caregivers_grid->RowIndex ?>_DateSent" value="<?php echo ew_HtmlEncode($caregivers->DateSent->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($caregivers->budget_category->Visible) { // budget_category ?>
		<td>
<?php if ($caregivers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_budget_category" id="x<?php echo $caregivers_grid->RowIndex ?>_budget_category" size="30" value="<?php echo $caregivers->budget_category->EditValue ?>"<?php echo $caregivers->budget_category->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $caregivers->budget_category->ViewAttributes() ?>><?php echo $caregivers->budget_category->ViewValue ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_budget_category" id="x<?php echo $caregivers_grid->RowIndex ?>_budget_category" value="<?php echo ew_HtmlEncode($caregivers->budget_category->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_budget_category" id="o<?php echo $caregivers_grid->RowIndex ?>_budget_category" value="<?php echo ew_HtmlEncode($caregivers->budget_category->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($caregivers->AgeOfApplicant->Visible) { // AgeOfApplicant ?>
		<td>
<?php if ($caregivers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_AgeOfApplicant" id="x<?php echo $caregivers_grid->RowIndex ?>_AgeOfApplicant" size="30" value="<?php echo $caregivers->AgeOfApplicant->EditValue ?>"<?php echo $caregivers->AgeOfApplicant->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $caregivers->AgeOfApplicant->ViewAttributes() ?>><?php echo $caregivers->AgeOfApplicant->ViewValue ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_AgeOfApplicant" id="x<?php echo $caregivers_grid->RowIndex ?>_AgeOfApplicant" value="<?php echo ew_HtmlEncode($caregivers->AgeOfApplicant->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_AgeOfApplicant" id="o<?php echo $caregivers_grid->RowIndex ?>_AgeOfApplicant" value="<?php echo ew_HtmlEncode($caregivers->AgeOfApplicant->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($caregivers->Applic->Visible) { // Applic ?>
		<td>
<?php if ($caregivers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_Applic" id="x<?php echo $caregivers_grid->RowIndex ?>_Applic" size="30" maxlength="32" value="<?php echo $caregivers->Applic->EditValue ?>"<?php echo $caregivers->Applic->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $caregivers->Applic->ViewAttributes() ?>><?php echo $caregivers->Applic->ViewValue ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_Applic" id="x<?php echo $caregivers_grid->RowIndex ?>_Applic" value="<?php echo ew_HtmlEncode($caregivers->Applic->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_Applic" id="o<?php echo $caregivers_grid->RowIndex ?>_Applic" value="<?php echo ew_HtmlEncode($caregivers->Applic->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($caregivers->SubApplic->Visible) { // SubApplic ?>
		<td>
<?php if ($caregivers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_SubApplic" id="x<?php echo $caregivers_grid->RowIndex ?>_SubApplic" size="30" maxlength="32" value="<?php echo $caregivers->SubApplic->EditValue ?>"<?php echo $caregivers->SubApplic->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $caregivers->SubApplic->ViewAttributes() ?>><?php echo $caregivers->SubApplic->ViewValue ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_SubApplic" id="x<?php echo $caregivers_grid->RowIndex ?>_SubApplic" value="<?php echo ew_HtmlEncode($caregivers->SubApplic->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_SubApplic" id="o<?php echo $caregivers_grid->RowIndex ?>_SubApplic" value="<?php echo ew_HtmlEncode($caregivers->SubApplic->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($caregivers->DateSigned->Visible) { // DateSigned ?>
		<td>
<?php if ($caregivers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_DateSigned" id="x<?php echo $caregivers_grid->RowIndex ?>_DateSigned" value="<?php echo $caregivers->DateSigned->EditValue ?>"<?php echo $caregivers->DateSigned->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $caregivers->DateSigned->ViewAttributes() ?>><?php echo $caregivers->DateSigned->ViewValue ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_DateSigned" id="x<?php echo $caregivers_grid->RowIndex ?>_DateSigned" value="<?php echo ew_HtmlEncode($caregivers->DateSigned->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_DateSigned" id="o<?php echo $caregivers_grid->RowIndex ?>_DateSigned" value="<?php echo ew_HtmlEncode($caregivers->DateSigned->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($caregivers->colony_id->Visible) { // colony_id ?>
		<td>
<?php if ($caregivers->CurrentAction <> "F") { ?>
<?php if ($caregivers->colony_id->getSessionValue() <> "") { ?>
<div<?php echo $caregivers->colony_id->ViewAttributes() ?>><?php echo $caregivers->colony_id->ListViewValue() ?></div>
<input type="hidden" id="x<?php echo $caregivers_grid->RowIndex ?>_colony_id" name="x<?php echo $caregivers_grid->RowIndex ?>_colony_id" value="<?php echo ew_HtmlEncode($caregivers->colony_id->CurrentValue) ?>">
<?php } else { ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_colony_id" id="x<?php echo $caregivers_grid->RowIndex ?>_colony_id" size="30" value="<?php echo $caregivers->colony_id->EditValue ?>"<?php echo $caregivers->colony_id->EditAttributes() ?>>
<?php } ?>
<?php } else { ?>
<div<?php echo $caregivers->colony_id->ViewAttributes() ?>><?php echo $caregivers->colony_id->ViewValue ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_colony_id" id="x<?php echo $caregivers_grid->RowIndex ?>_colony_id" value="<?php echo ew_HtmlEncode($caregivers->colony_id->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_colony_id" id="o<?php echo $caregivers_grid->RowIndex ?>_colony_id" value="<?php echo ew_HtmlEncode($caregivers->colony_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($caregivers->mod_by->Visible) { // mod_by ?>
		<td>
<?php if ($caregivers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_mod_by" id="x<?php echo $caregivers_grid->RowIndex ?>_mod_by" size="30" maxlength="20" value="<?php echo $caregivers->mod_by->EditValue ?>"<?php echo $caregivers->mod_by->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $caregivers->mod_by->ViewAttributes() ?>><?php echo $caregivers->mod_by->ViewValue ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_mod_by" id="x<?php echo $caregivers_grid->RowIndex ?>_mod_by" value="<?php echo ew_HtmlEncode($caregivers->mod_by->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_mod_by" id="o<?php echo $caregivers_grid->RowIndex ?>_mod_by" value="<?php echo ew_HtmlEncode($caregivers->mod_by->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($caregivers->mod_date->Visible) { // mod_date ?>
		<td>
<?php if ($caregivers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $caregivers_grid->RowIndex ?>_mod_date" id="x<?php echo $caregivers_grid->RowIndex ?>_mod_date" value="<?php echo $caregivers->mod_date->EditValue ?>"<?php echo $caregivers->mod_date->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $caregivers->mod_date->ViewAttributes() ?>><?php echo $caregivers->mod_date->ViewValue ?></div>
<input type="hidden" name="x<?php echo $caregivers_grid->RowIndex ?>_mod_date" id="x<?php echo $caregivers_grid->RowIndex ?>_mod_date" value="<?php echo ew_HtmlEncode($caregivers->mod_date->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $caregivers_grid->RowIndex ?>_mod_date" id="o<?php echo $caregivers_grid->RowIndex ?>_mod_date" value="<?php echo ew_HtmlEncode($caregivers->mod_date->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$caregivers_grid->ListOptions->Render("body", "right");
?>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($caregivers->CurrentMode == "add" || $caregivers->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $caregivers_grid->KeyCount ?>">
<?php echo $caregivers_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($caregivers->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $caregivers_grid->KeyCount ?>">
<?php echo $caregivers_grid->MultiSelectKey ?>
<?php } ?>
<input type="hidden" name="detailpage" id="detailpage" value="caregivers_grid">
</div>
<?php

// Close recordset
if ($caregivers_grid->Recordset)
	$caregivers_grid->Recordset->Close();
?>
<?php if (($caregivers->CurrentMode == "add" || $caregivers->CurrentMode == "copy" || $caregivers->CurrentMode == "edit") && $caregivers->CurrentAction != "F") { // add/copy/edit mode ?>
<div class="ewGridLowerPanel">
<?php if ($caregivers->AllowAddDeleteRow) { ?>
<span class="phpmaker">
<a href="javascript:void(0);" onclick="ew_AddGridRow(this);"><?php echo $Language->Phrase("AddBlankRow") ?></a>&nbsp;&nbsp;
</span>
<?php } ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($caregivers->Export == "" && $caregivers->CurrentAction == "") { ?>
<?php } ?>
<?php
$caregivers_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$caregivers_grid->Page_Terminate();
$Page =& $MasterPage;
?>
