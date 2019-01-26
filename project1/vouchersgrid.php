<?php

// Create page object
$vouchers_grid = new cvouchers_grid();
$MasterPage =& $Page;
$Page =& $vouchers_grid;

// Page init
$vouchers_grid->Page_Init();

// Page main
$vouchers_grid->Page_Main();
?>
<?php if ($vouchers->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var vouchers_grid = new ew_Page("vouchers_grid");

// page properties
vouchers_grid.PageID = "grid"; // page ID
vouchers_grid.FormID = "fvouchersgrid"; // form ID
var EW_PAGE_ID = vouchers_grid.PageID; // for backward compatibility

// extend page with ValidateForm function
vouchers_grid.ValidateForm = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_VoucherNumber"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($vouchers->VoucherNumber->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_VoucherNumber"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($vouchers->VoucherNumber->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_ExpireDate"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($vouchers->ExpireDate->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_ExpireDate"];
		if (elm && !ew_CheckDate(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($vouchers->ExpireDate->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_IssuedByFirst"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($vouchers->IssuedByFirst->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_IssuedByLast"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($vouchers->IssuedByLast->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_cat_age"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($vouchers->cat_age->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_copay"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($vouchers->copay->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_date_redeemed"];
		if (elm && !ew_CheckDate(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($vouchers->date_redeemed->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_ClinicPrice"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($vouchers->ClinicPrice->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_colony_id"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($vouchers->colony_id->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_mod_date"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($vouchers->mod_date->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_mod_date"];
		if (elm && !ew_CheckDate(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($vouchers->mod_date->FldErrMsg()) ?>");

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
vouchers_grid.EmptyRow = function(fobj, infix) {
	if (ew_ValueChanged(fobj, infix, "VoucherNumber", false)) return false;
	if (ew_ValueChanged(fobj, infix, "ExpireDate", false)) return false;
	if (ew_ValueChanged(fobj, infix, "IssuedByFirst", false)) return false;
	if (ew_ValueChanged(fobj, infix, "IssuedByLast", false)) return false;
	if (ew_ValueChanged(fobj, infix, "FirstName", false)) return false;
	if (ew_ValueChanged(fobj, infix, "LastName", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Program", false)) return false;
	if (ew_ValueChanged(fobj, infix, "cat_name", false)) return false;
	if (ew_ValueChanged(fobj, infix, "cat_breed", false)) return false;
	if (ew_ValueChanged(fobj, infix, "cat_age", false)) return false;
	if (ew_ValueChanged(fobj, infix, "copay", false)) return false;
	if (ew_ValueChanged(fobj, infix, "cat_status", false)) return false;
	if (ew_ValueChanged(fobj, infix, "date_redeemed", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Clinic", false)) return false;
	if (ew_ValueChanged(fobj, infix, "ClinicPrice", false)) return false;
	if (ew_ValueChanged(fobj, infix, "vet_used", false)) return false;
	if (ew_ValueChanged(fobj, infix, "colony_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Spay", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Neuter", false)) return false;
	if (ew_ValueChanged(fobj, infix, "FVRCP", false)) return false;
	if (ew_ValueChanged(fobj, infix, "FELV", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Rabies", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Pregnant", false)) return false;
	if (ew_ValueChanged(fobj, infix, "AssignedTo", false)) return false;
	if (ew_ValueChanged(fobj, infix, "mod_by", false)) return false;
	if (ew_ValueChanged(fobj, infix, "mod_date", false)) return false;
	return true;
}

// extend page with Form_CustomValidate function
vouchers_grid.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
vouchers_grid.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
vouchers_grid.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<?php } ?>
<?php
if ($vouchers->CurrentAction == "gridadd") {
	if ($vouchers->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$vouchers_grid->TotalRecs = $vouchers->SelectRecordCount();
			$vouchers_grid->Recordset = $vouchers_grid->LoadRecordset($vouchers_grid->StartRec-1, $vouchers_grid->DisplayRecs);
		} else {
			if ($vouchers_grid->Recordset = $vouchers_grid->LoadRecordset())
				$vouchers_grid->TotalRecs = $vouchers_grid->Recordset->RecordCount();
		}
		$vouchers_grid->StartRec = 1;
		$vouchers_grid->DisplayRecs = $vouchers_grid->TotalRecs;
	} else {
		$vouchers->CurrentFilter = "0=1";
		$vouchers_grid->StartRec = 1;
		$vouchers_grid->DisplayRecs = $vouchers->GridAddRowCount;
	}
	$vouchers_grid->TotalRecs = $vouchers_grid->DisplayRecs;
	$vouchers_grid->StopRec = $vouchers_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$vouchers_grid->TotalRecs = $vouchers->SelectRecordCount();
	} else {
		if ($vouchers_grid->Recordset = $vouchers_grid->LoadRecordset())
			$vouchers_grid->TotalRecs = $vouchers_grid->Recordset->RecordCount();
	}
	$vouchers_grid->StartRec = 1;
	$vouchers_grid->DisplayRecs = $vouchers_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$vouchers_grid->Recordset = $vouchers_grid->LoadRecordset($vouchers_grid->StartRec-1, $vouchers_grid->DisplayRecs);
}
?>
<p class="phpmaker ewTitle" style="white-space: nowrap;"><?php if ($vouchers->CurrentMode == "add" || $vouchers->CurrentMode == "copy") { ?><?php echo $Language->Phrase("Add") ?><?php } elseif ($vouchers->CurrentMode == "edit") { ?><?php echo $Language->Phrase("Edit") ?><?php } ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $vouchers->TableCaption() ?></p>
</p>
<?php $vouchers_grid->ShowPageHeader(); ?>
<?php
$vouchers_grid->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if (($vouchers->CurrentMode == "add" || $vouchers->CurrentMode == "copy" || $vouchers->CurrentMode == "edit") && $vouchers->CurrentAction != "F") { // add/copy/edit mode ?>
<div class="ewGridUpperPanel">
<?php if ($vouchers->AllowAddDeleteRow) { ?>
<span class="phpmaker">
<a href="javascript:void(0);" onclick="ew_AddGridRow(this);"><?php echo $Language->Phrase("AddBlankRow") ?></a>&nbsp;&nbsp;
</span>
<?php } ?>
</div>
<?php } ?>
<div id="gmp_vouchers" class="ewGridMiddlePanel">
<table cellspacing="0" data-rowhighlightclass="ewTableHighlightRow" data-rowselectclass="ewTableSelectRow" data-roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php echo $vouchers->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$vouchers_grid->RenderListOptions();

// Render list options (header, left)
$vouchers_grid->ListOptions->Render("header", "left");
?>
<?php if ($vouchers->id->Visible) { // id ?>
	<?php if ($vouchers->SortUrl($vouchers->id) == "") { ?>
		<td><?php echo $vouchers->id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->id->FldCaption() ?></td><td style="width: 10px;"><?php if ($vouchers->id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->VoucherNumber->Visible) { // VoucherNumber ?>
	<?php if ($vouchers->SortUrl($vouchers->VoucherNumber) == "") { ?>
		<td><?php echo $vouchers->VoucherNumber->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->VoucherNumber->FldCaption() ?></td><td style="width: 10px;"><?php if ($vouchers->VoucherNumber->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->VoucherNumber->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->ExpireDate->Visible) { // ExpireDate ?>
	<?php if ($vouchers->SortUrl($vouchers->ExpireDate) == "") { ?>
		<td><?php echo $vouchers->ExpireDate->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->ExpireDate->FldCaption() ?></td><td style="width: 10px;"><?php if ($vouchers->ExpireDate->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->ExpireDate->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->IssuedByFirst->Visible) { // IssuedByFirst ?>
	<?php if ($vouchers->SortUrl($vouchers->IssuedByFirst) == "") { ?>
		<td><?php echo $vouchers->IssuedByFirst->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->IssuedByFirst->FldCaption() ?></td><td style="width: 10px;"><?php if ($vouchers->IssuedByFirst->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->IssuedByFirst->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->IssuedByLast->Visible) { // IssuedByLast ?>
	<?php if ($vouchers->SortUrl($vouchers->IssuedByLast) == "") { ?>
		<td><?php echo $vouchers->IssuedByLast->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->IssuedByLast->FldCaption() ?></td><td style="width: 10px;"><?php if ($vouchers->IssuedByLast->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->IssuedByLast->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->FirstName->Visible) { // FirstName ?>
	<?php if ($vouchers->SortUrl($vouchers->FirstName) == "") { ?>
		<td><?php echo $vouchers->FirstName->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->FirstName->FldCaption() ?></td><td style="width: 10px;"><?php if ($vouchers->FirstName->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->FirstName->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->LastName->Visible) { // LastName ?>
	<?php if ($vouchers->SortUrl($vouchers->LastName) == "") { ?>
		<td><?php echo $vouchers->LastName->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->LastName->FldCaption() ?></td><td style="width: 10px;"><?php if ($vouchers->LastName->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->LastName->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->Program->Visible) { // Program ?>
	<?php if ($vouchers->SortUrl($vouchers->Program) == "") { ?>
		<td><?php echo $vouchers->Program->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->Program->FldCaption() ?></td><td style="width: 10px;"><?php if ($vouchers->Program->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->Program->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->cat_name->Visible) { // cat_name ?>
	<?php if ($vouchers->SortUrl($vouchers->cat_name) == "") { ?>
		<td><?php echo $vouchers->cat_name->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->cat_name->FldCaption() ?></td><td style="width: 10px;"><?php if ($vouchers->cat_name->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->cat_name->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->cat_breed->Visible) { // cat_breed ?>
	<?php if ($vouchers->SortUrl($vouchers->cat_breed) == "") { ?>
		<td><?php echo $vouchers->cat_breed->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->cat_breed->FldCaption() ?></td><td style="width: 10px;"><?php if ($vouchers->cat_breed->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->cat_breed->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->cat_age->Visible) { // cat_age ?>
	<?php if ($vouchers->SortUrl($vouchers->cat_age) == "") { ?>
		<td><?php echo $vouchers->cat_age->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->cat_age->FldCaption() ?></td><td style="width: 10px;"><?php if ($vouchers->cat_age->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->cat_age->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->copay->Visible) { // copay ?>
	<?php if ($vouchers->SortUrl($vouchers->copay) == "") { ?>
		<td><?php echo $vouchers->copay->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->copay->FldCaption() ?></td><td style="width: 10px;"><?php if ($vouchers->copay->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->copay->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->cat_status->Visible) { // cat_status ?>
	<?php if ($vouchers->SortUrl($vouchers->cat_status) == "") { ?>
		<td><?php echo $vouchers->cat_status->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->cat_status->FldCaption() ?></td><td style="width: 10px;"><?php if ($vouchers->cat_status->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->cat_status->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->date_redeemed->Visible) { // date_redeemed ?>
	<?php if ($vouchers->SortUrl($vouchers->date_redeemed) == "") { ?>
		<td><?php echo $vouchers->date_redeemed->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->date_redeemed->FldCaption() ?></td><td style="width: 10px;"><?php if ($vouchers->date_redeemed->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->date_redeemed->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->Clinic->Visible) { // Clinic ?>
	<?php if ($vouchers->SortUrl($vouchers->Clinic) == "") { ?>
		<td><?php echo $vouchers->Clinic->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->Clinic->FldCaption() ?></td><td style="width: 10px;"><?php if ($vouchers->Clinic->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->Clinic->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->ClinicPrice->Visible) { // ClinicPrice ?>
	<?php if ($vouchers->SortUrl($vouchers->ClinicPrice) == "") { ?>
		<td><?php echo $vouchers->ClinicPrice->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->ClinicPrice->FldCaption() ?></td><td style="width: 10px;"><?php if ($vouchers->ClinicPrice->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->ClinicPrice->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->vet_used->Visible) { // vet_used ?>
	<?php if ($vouchers->SortUrl($vouchers->vet_used) == "") { ?>
		<td><?php echo $vouchers->vet_used->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->vet_used->FldCaption() ?></td><td style="width: 10px;"><?php if ($vouchers->vet_used->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->vet_used->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->colony_id->Visible) { // colony_id ?>
	<?php if ($vouchers->SortUrl($vouchers->colony_id) == "") { ?>
		<td><?php echo $vouchers->colony_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->colony_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($vouchers->colony_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->colony_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->Spay->Visible) { // Spay ?>
	<?php if ($vouchers->SortUrl($vouchers->Spay) == "") { ?>
		<td><?php echo $vouchers->Spay->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->Spay->FldCaption() ?></td><td style="width: 10px;"><?php if ($vouchers->Spay->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->Spay->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->Neuter->Visible) { // Neuter ?>
	<?php if ($vouchers->SortUrl($vouchers->Neuter) == "") { ?>
		<td><?php echo $vouchers->Neuter->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->Neuter->FldCaption() ?></td><td style="width: 10px;"><?php if ($vouchers->Neuter->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->Neuter->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->FVRCP->Visible) { // FVRCP ?>
	<?php if ($vouchers->SortUrl($vouchers->FVRCP) == "") { ?>
		<td><?php echo $vouchers->FVRCP->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->FVRCP->FldCaption() ?></td><td style="width: 10px;"><?php if ($vouchers->FVRCP->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->FVRCP->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->FELV->Visible) { // FELV ?>
	<?php if ($vouchers->SortUrl($vouchers->FELV) == "") { ?>
		<td><?php echo $vouchers->FELV->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->FELV->FldCaption() ?></td><td style="width: 10px;"><?php if ($vouchers->FELV->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->FELV->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->Rabies->Visible) { // Rabies ?>
	<?php if ($vouchers->SortUrl($vouchers->Rabies) == "") { ?>
		<td><?php echo $vouchers->Rabies->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->Rabies->FldCaption() ?></td><td style="width: 10px;"><?php if ($vouchers->Rabies->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->Rabies->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->Pregnant->Visible) { // Pregnant ?>
	<?php if ($vouchers->SortUrl($vouchers->Pregnant) == "") { ?>
		<td><?php echo $vouchers->Pregnant->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->Pregnant->FldCaption() ?></td><td style="width: 10px;"><?php if ($vouchers->Pregnant->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->Pregnant->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->AssignedTo->Visible) { // AssignedTo ?>
	<?php if ($vouchers->SortUrl($vouchers->AssignedTo) == "") { ?>
		<td><?php echo $vouchers->AssignedTo->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->AssignedTo->FldCaption() ?></td><td style="width: 10px;"><?php if ($vouchers->AssignedTo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->AssignedTo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->mod_by->Visible) { // mod_by ?>
	<?php if ($vouchers->SortUrl($vouchers->mod_by) == "") { ?>
		<td><?php echo $vouchers->mod_by->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->mod_by->FldCaption() ?></td><td style="width: 10px;"><?php if ($vouchers->mod_by->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->mod_by->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($vouchers->mod_date->Visible) { // mod_date ?>
	<?php if ($vouchers->SortUrl($vouchers->mod_date) == "") { ?>
		<td><?php echo $vouchers->mod_date->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $vouchers->mod_date->FldCaption() ?></td><td style="width: 10px;"><?php if ($vouchers->mod_date->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($vouchers->mod_date->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$vouchers_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<?php
$vouchers_grid->StartRec = 1;
$vouchers_grid->StopRec = $vouchers_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = 0;
	if ($objForm->HasValue("key_count") && ($vouchers->CurrentAction == "gridadd" || $vouchers->CurrentAction == "gridedit" || $vouchers->CurrentAction == "F")) {
		$vouchers_grid->KeyCount = $objForm->GetValue("key_count");
		$vouchers_grid->StopRec = $vouchers_grid->KeyCount;
	}
}
$vouchers_grid->RecCnt = $vouchers_grid->StartRec - 1;
if ($vouchers_grid->Recordset && !$vouchers_grid->Recordset->EOF) {
	$vouchers_grid->Recordset->MoveFirst();
	if (!$bSelectLimit && $vouchers_grid->StartRec > 1)
		$vouchers_grid->Recordset->Move($vouchers_grid->StartRec - 1);
} elseif (!$vouchers->AllowAddDeleteRow && $vouchers_grid->StopRec == 0) {
	$vouchers_grid->StopRec = $vouchers->GridAddRowCount;
}

// Initialize aggregate
$vouchers->RowType = EW_ROWTYPE_AGGREGATEINIT;
$vouchers->ResetAttrs();
$vouchers_grid->RenderRow();
$vouchers_grid->RowCnt = 0;
if ($vouchers->CurrentAction == "gridadd")
	$vouchers_grid->RowIndex = 0;
if ($vouchers->CurrentAction == "gridedit")
	$vouchers_grid->RowIndex = 0;
while ($vouchers_grid->RecCnt < $vouchers_grid->StopRec) {
	$vouchers_grid->RecCnt++;
	if (intval($vouchers_grid->RecCnt) >= intval($vouchers_grid->StartRec)) {
		$vouchers_grid->RowCnt++;
		if ($vouchers->CurrentAction == "gridadd" || $vouchers->CurrentAction == "gridedit" || $vouchers->CurrentAction == "F") {
			$vouchers_grid->RowIndex++;
			$objForm->Index = $vouchers_grid->RowIndex;
			if ($objForm->HasValue("k_action"))
				$vouchers_grid->RowAction = strval($objForm->GetValue("k_action"));
			elseif ($vouchers->CurrentAction == "gridadd")
				$vouchers_grid->RowAction = "insert";
			else
				$vouchers_grid->RowAction = "";
		}

		// Set up key count
		$vouchers_grid->KeyCount = $vouchers_grid->RowIndex;

		// Init row class and style
		$vouchers->ResetAttrs();
		$vouchers->CssClass = "";
		if ($vouchers->CurrentAction == "gridadd") {
			if ($vouchers->CurrentMode == "copy") {
				$vouchers_grid->LoadRowValues($vouchers_grid->Recordset); // Load row values
				$vouchers_grid->SetRecordKey($vouchers_grid->RowOldKey, $vouchers_grid->Recordset); // Set old record key
			} else {
				$vouchers_grid->LoadDefaultValues(); // Load default values
				$vouchers_grid->RowOldKey = ""; // Clear old key value
			}
		} elseif ($vouchers->CurrentAction == "gridedit") {
			$vouchers_grid->LoadRowValues($vouchers_grid->Recordset); // Load row values
		}
		$vouchers->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($vouchers->CurrentAction == "gridadd") // Grid add
			$vouchers->RowType = EW_ROWTYPE_ADD; // Render add
		if ($vouchers->CurrentAction == "gridadd" && $vouchers->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$vouchers_grid->RestoreCurrentRowFormValues($vouchers_grid->RowIndex); // Restore form values
		if ($vouchers->CurrentAction == "gridedit") { // Grid edit
			if ($vouchers->EventCancelled) {
				$vouchers_grid->RestoreCurrentRowFormValues($vouchers_grid->RowIndex); // Restore form values
			}
			if ($vouchers_grid->RowAction == "insert")
				$vouchers->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$vouchers->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($vouchers->CurrentAction == "gridedit" && ($vouchers->RowType == EW_ROWTYPE_EDIT || $vouchers->RowType == EW_ROWTYPE_ADD) && $vouchers->EventCancelled) // Update failed
			$vouchers_grid->RestoreCurrentRowFormValues($vouchers_grid->RowIndex); // Restore form values
		if ($vouchers->RowType == EW_ROWTYPE_EDIT) // Edit row
			$vouchers_grid->EditRowCnt++;
		if ($vouchers->CurrentAction == "F") // Confirm row
			$vouchers_grid->RestoreCurrentRowFormValues($vouchers_grid->RowIndex); // Restore form values
		if ($vouchers->RowType == EW_ROWTYPE_ADD || $vouchers->RowType == EW_ROWTYPE_EDIT) { // Add / Edit row
			if ($vouchers->CurrentAction == "edit") {
				$vouchers->RowAttrs = array();
				$vouchers->CssClass = "ewTableEditRow";
			} else {
				$vouchers->RowAttrs = array();
			}
			if (!empty($vouchers_grid->RowIndex))
				$vouchers->RowAttrs = array_merge($vouchers->RowAttrs, array('data-rowindex'=>$vouchers_grid->RowIndex, 'id'=>'r' . $vouchers_grid->RowIndex . '_vouchers'));
		} else {
			$vouchers->RowAttrs = array();
		}

		// Render row
		$vouchers_grid->RenderRow();

		// Render list options
		$vouchers_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($vouchers_grid->RowAction <> "delete" && $vouchers_grid->RowAction <> "insertdelete" && !($vouchers_grid->RowAction == "insert" && $vouchers->CurrentAction == "F" && $vouchers_grid->EmptyRow())) {
?>
	<tr<?php echo $vouchers->RowAttributes() ?>>
<?php

// Render list options (body, left)
$vouchers_grid->ListOptions->Render("body", "left");
?>
	<?php if ($vouchers->id->Visible) { // id ?>
		<td<?php echo $vouchers->id->CellAttributes() ?>>
<?php if ($vouchers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_id" id="o<?php echo $vouchers_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($vouchers->id->OldValue) ?>">
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<div<?php echo $vouchers->id->ViewAttributes() ?>><?php echo $vouchers->id->EditValue ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_id" id="x<?php echo $vouchers_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($vouchers->id->CurrentValue) ?>">
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $vouchers->id->ViewAttributes() ?>><?php echo $vouchers->id->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_id" id="x<?php echo $vouchers_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($vouchers->id->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_id" id="o<?php echo $vouchers_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($vouchers->id->OldValue) ?>">
<?php } ?>
<a name="<?php echo $vouchers_grid->PageObjName . "_row_" . $vouchers_grid->RowCnt ?>" id="<?php echo $vouchers_grid->PageObjName . "_row_" . $vouchers_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($vouchers->VoucherNumber->Visible) { // VoucherNumber ?>
		<td<?php echo $vouchers->VoucherNumber->CellAttributes() ?>>
<?php if ($vouchers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_VoucherNumber" id="x<?php echo $vouchers_grid->RowIndex ?>_VoucherNumber" size="30" value="<?php echo $vouchers->VoucherNumber->EditValue ?>"<?php echo $vouchers->VoucherNumber->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_VoucherNumber" id="o<?php echo $vouchers_grid->RowIndex ?>_VoucherNumber" value="<?php echo ew_HtmlEncode($vouchers->VoucherNumber->OldValue) ?>">
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_VoucherNumber" id="x<?php echo $vouchers_grid->RowIndex ?>_VoucherNumber" size="30" value="<?php echo $vouchers->VoucherNumber->EditValue ?>"<?php echo $vouchers->VoucherNumber->EditAttributes() ?>>
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $vouchers->VoucherNumber->ViewAttributes() ?>><?php echo $vouchers->VoucherNumber->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_VoucherNumber" id="x<?php echo $vouchers_grid->RowIndex ?>_VoucherNumber" value="<?php echo ew_HtmlEncode($vouchers->VoucherNumber->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_VoucherNumber" id="o<?php echo $vouchers_grid->RowIndex ?>_VoucherNumber" value="<?php echo ew_HtmlEncode($vouchers->VoucherNumber->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vouchers->ExpireDate->Visible) { // ExpireDate ?>
		<td<?php echo $vouchers->ExpireDate->CellAttributes() ?>>
<?php if ($vouchers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_ExpireDate" id="x<?php echo $vouchers_grid->RowIndex ?>_ExpireDate" value="<?php echo $vouchers->ExpireDate->EditValue ?>"<?php echo $vouchers->ExpireDate->EditAttributes() ?>>
<input type="hidden" name="fo<?php echo $vouchers_grid->RowIndex ?>_ExpireDate" id="fo<?php echo $vouchers_grid->RowIndex ?>_ExpireDate" value="<?php echo ew_HtmlEncode(ew_FormatDateTime($vouchers->ExpireDate->OldValue, 5)) ?>">
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_ExpireDate" id="o<?php echo $vouchers_grid->RowIndex ?>_ExpireDate" value="<?php echo ew_HtmlEncode($vouchers->ExpireDate->OldValue) ?>">
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_ExpireDate" id="x<?php echo $vouchers_grid->RowIndex ?>_ExpireDate" value="<?php echo $vouchers->ExpireDate->EditValue ?>"<?php echo $vouchers->ExpireDate->EditAttributes() ?>>
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $vouchers->ExpireDate->ViewAttributes() ?>><?php echo $vouchers->ExpireDate->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_ExpireDate" id="x<?php echo $vouchers_grid->RowIndex ?>_ExpireDate" value="<?php echo ew_HtmlEncode($vouchers->ExpireDate->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_ExpireDate" id="o<?php echo $vouchers_grid->RowIndex ?>_ExpireDate" value="<?php echo ew_HtmlEncode($vouchers->ExpireDate->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vouchers->IssuedByFirst->Visible) { // IssuedByFirst ?>
		<td<?php echo $vouchers->IssuedByFirst->CellAttributes() ?>>
<?php if ($vouchers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_IssuedByFirst" id="x<?php echo $vouchers_grid->RowIndex ?>_IssuedByFirst" size="30" maxlength="50" value="<?php echo $vouchers->IssuedByFirst->EditValue ?>"<?php echo $vouchers->IssuedByFirst->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_IssuedByFirst" id="o<?php echo $vouchers_grid->RowIndex ?>_IssuedByFirst" value="<?php echo ew_HtmlEncode($vouchers->IssuedByFirst->OldValue) ?>">
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_IssuedByFirst" id="x<?php echo $vouchers_grid->RowIndex ?>_IssuedByFirst" size="30" maxlength="50" value="<?php echo $vouchers->IssuedByFirst->EditValue ?>"<?php echo $vouchers->IssuedByFirst->EditAttributes() ?>>
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $vouchers->IssuedByFirst->ViewAttributes() ?>><?php echo $vouchers->IssuedByFirst->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_IssuedByFirst" id="x<?php echo $vouchers_grid->RowIndex ?>_IssuedByFirst" value="<?php echo ew_HtmlEncode($vouchers->IssuedByFirst->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_IssuedByFirst" id="o<?php echo $vouchers_grid->RowIndex ?>_IssuedByFirst" value="<?php echo ew_HtmlEncode($vouchers->IssuedByFirst->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vouchers->IssuedByLast->Visible) { // IssuedByLast ?>
		<td<?php echo $vouchers->IssuedByLast->CellAttributes() ?>>
<?php if ($vouchers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_IssuedByLast" id="x<?php echo $vouchers_grid->RowIndex ?>_IssuedByLast" size="30" maxlength="50" value="<?php echo $vouchers->IssuedByLast->EditValue ?>"<?php echo $vouchers->IssuedByLast->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_IssuedByLast" id="o<?php echo $vouchers_grid->RowIndex ?>_IssuedByLast" value="<?php echo ew_HtmlEncode($vouchers->IssuedByLast->OldValue) ?>">
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_IssuedByLast" id="x<?php echo $vouchers_grid->RowIndex ?>_IssuedByLast" size="30" maxlength="50" value="<?php echo $vouchers->IssuedByLast->EditValue ?>"<?php echo $vouchers->IssuedByLast->EditAttributes() ?>>
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $vouchers->IssuedByLast->ViewAttributes() ?>><?php echo $vouchers->IssuedByLast->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_IssuedByLast" id="x<?php echo $vouchers_grid->RowIndex ?>_IssuedByLast" value="<?php echo ew_HtmlEncode($vouchers->IssuedByLast->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_IssuedByLast" id="o<?php echo $vouchers_grid->RowIndex ?>_IssuedByLast" value="<?php echo ew_HtmlEncode($vouchers->IssuedByLast->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vouchers->FirstName->Visible) { // FirstName ?>
		<td<?php echo $vouchers->FirstName->CellAttributes() ?>>
<?php if ($vouchers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_FirstName" id="x<?php echo $vouchers_grid->RowIndex ?>_FirstName" size="30" maxlength="50" value="<?php echo $vouchers->FirstName->EditValue ?>"<?php echo $vouchers->FirstName->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_FirstName" id="o<?php echo $vouchers_grid->RowIndex ?>_FirstName" value="<?php echo ew_HtmlEncode($vouchers->FirstName->OldValue) ?>">
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_FirstName" id="x<?php echo $vouchers_grid->RowIndex ?>_FirstName" size="30" maxlength="50" value="<?php echo $vouchers->FirstName->EditValue ?>"<?php echo $vouchers->FirstName->EditAttributes() ?>>
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $vouchers->FirstName->ViewAttributes() ?>><?php echo $vouchers->FirstName->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_FirstName" id="x<?php echo $vouchers_grid->RowIndex ?>_FirstName" value="<?php echo ew_HtmlEncode($vouchers->FirstName->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_FirstName" id="o<?php echo $vouchers_grid->RowIndex ?>_FirstName" value="<?php echo ew_HtmlEncode($vouchers->FirstName->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vouchers->LastName->Visible) { // LastName ?>
		<td<?php echo $vouchers->LastName->CellAttributes() ?>>
<?php if ($vouchers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_LastName" id="x<?php echo $vouchers_grid->RowIndex ?>_LastName" size="30" maxlength="50" value="<?php echo $vouchers->LastName->EditValue ?>"<?php echo $vouchers->LastName->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_LastName" id="o<?php echo $vouchers_grid->RowIndex ?>_LastName" value="<?php echo ew_HtmlEncode($vouchers->LastName->OldValue) ?>">
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_LastName" id="x<?php echo $vouchers_grid->RowIndex ?>_LastName" size="30" maxlength="50" value="<?php echo $vouchers->LastName->EditValue ?>"<?php echo $vouchers->LastName->EditAttributes() ?>>
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $vouchers->LastName->ViewAttributes() ?>><?php echo $vouchers->LastName->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_LastName" id="x<?php echo $vouchers_grid->RowIndex ?>_LastName" value="<?php echo ew_HtmlEncode($vouchers->LastName->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_LastName" id="o<?php echo $vouchers_grid->RowIndex ?>_LastName" value="<?php echo ew_HtmlEncode($vouchers->LastName->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vouchers->Program->Visible) { // Program ?>
		<td<?php echo $vouchers->Program->CellAttributes() ?>>
<?php if ($vouchers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_Program" id="x<?php echo $vouchers_grid->RowIndex ?>_Program" size="30" maxlength="50" value="<?php echo $vouchers->Program->EditValue ?>"<?php echo $vouchers->Program->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_Program" id="o<?php echo $vouchers_grid->RowIndex ?>_Program" value="<?php echo ew_HtmlEncode($vouchers->Program->OldValue) ?>">
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_Program" id="x<?php echo $vouchers_grid->RowIndex ?>_Program" size="30" maxlength="50" value="<?php echo $vouchers->Program->EditValue ?>"<?php echo $vouchers->Program->EditAttributes() ?>>
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $vouchers->Program->ViewAttributes() ?>><?php echo $vouchers->Program->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_Program" id="x<?php echo $vouchers_grid->RowIndex ?>_Program" value="<?php echo ew_HtmlEncode($vouchers->Program->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_Program" id="o<?php echo $vouchers_grid->RowIndex ?>_Program" value="<?php echo ew_HtmlEncode($vouchers->Program->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vouchers->cat_name->Visible) { // cat_name ?>
		<td<?php echo $vouchers->cat_name->CellAttributes() ?>>
<?php if ($vouchers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_cat_name" id="x<?php echo $vouchers_grid->RowIndex ?>_cat_name" size="30" maxlength="20" value="<?php echo $vouchers->cat_name->EditValue ?>"<?php echo $vouchers->cat_name->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_cat_name" id="o<?php echo $vouchers_grid->RowIndex ?>_cat_name" value="<?php echo ew_HtmlEncode($vouchers->cat_name->OldValue) ?>">
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_cat_name" id="x<?php echo $vouchers_grid->RowIndex ?>_cat_name" size="30" maxlength="20" value="<?php echo $vouchers->cat_name->EditValue ?>"<?php echo $vouchers->cat_name->EditAttributes() ?>>
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $vouchers->cat_name->ViewAttributes() ?>><?php echo $vouchers->cat_name->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_cat_name" id="x<?php echo $vouchers_grid->RowIndex ?>_cat_name" value="<?php echo ew_HtmlEncode($vouchers->cat_name->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_cat_name" id="o<?php echo $vouchers_grid->RowIndex ?>_cat_name" value="<?php echo ew_HtmlEncode($vouchers->cat_name->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vouchers->cat_breed->Visible) { // cat_breed ?>
		<td<?php echo $vouchers->cat_breed->CellAttributes() ?>>
<?php if ($vouchers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_cat_breed" id="x<?php echo $vouchers_grid->RowIndex ?>_cat_breed" size="30" maxlength="20" value="<?php echo $vouchers->cat_breed->EditValue ?>"<?php echo $vouchers->cat_breed->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_cat_breed" id="o<?php echo $vouchers_grid->RowIndex ?>_cat_breed" value="<?php echo ew_HtmlEncode($vouchers->cat_breed->OldValue) ?>">
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_cat_breed" id="x<?php echo $vouchers_grid->RowIndex ?>_cat_breed" size="30" maxlength="20" value="<?php echo $vouchers->cat_breed->EditValue ?>"<?php echo $vouchers->cat_breed->EditAttributes() ?>>
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $vouchers->cat_breed->ViewAttributes() ?>><?php echo $vouchers->cat_breed->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_cat_breed" id="x<?php echo $vouchers_grid->RowIndex ?>_cat_breed" value="<?php echo ew_HtmlEncode($vouchers->cat_breed->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_cat_breed" id="o<?php echo $vouchers_grid->RowIndex ?>_cat_breed" value="<?php echo ew_HtmlEncode($vouchers->cat_breed->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vouchers->cat_age->Visible) { // cat_age ?>
		<td<?php echo $vouchers->cat_age->CellAttributes() ?>>
<?php if ($vouchers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_cat_age" id="x<?php echo $vouchers_grid->RowIndex ?>_cat_age" size="30" value="<?php echo $vouchers->cat_age->EditValue ?>"<?php echo $vouchers->cat_age->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_cat_age" id="o<?php echo $vouchers_grid->RowIndex ?>_cat_age" value="<?php echo ew_HtmlEncode($vouchers->cat_age->OldValue) ?>">
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_cat_age" id="x<?php echo $vouchers_grid->RowIndex ?>_cat_age" size="30" value="<?php echo $vouchers->cat_age->EditValue ?>"<?php echo $vouchers->cat_age->EditAttributes() ?>>
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $vouchers->cat_age->ViewAttributes() ?>><?php echo $vouchers->cat_age->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_cat_age" id="x<?php echo $vouchers_grid->RowIndex ?>_cat_age" value="<?php echo ew_HtmlEncode($vouchers->cat_age->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_cat_age" id="o<?php echo $vouchers_grid->RowIndex ?>_cat_age" value="<?php echo ew_HtmlEncode($vouchers->cat_age->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vouchers->copay->Visible) { // copay ?>
		<td<?php echo $vouchers->copay->CellAttributes() ?>>
<?php if ($vouchers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_copay" id="x<?php echo $vouchers_grid->RowIndex ?>_copay" size="30" value="<?php echo $vouchers->copay->EditValue ?>"<?php echo $vouchers->copay->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_copay" id="o<?php echo $vouchers_grid->RowIndex ?>_copay" value="<?php echo ew_HtmlEncode($vouchers->copay->OldValue) ?>">
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_copay" id="x<?php echo $vouchers_grid->RowIndex ?>_copay" size="30" value="<?php echo $vouchers->copay->EditValue ?>"<?php echo $vouchers->copay->EditAttributes() ?>>
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $vouchers->copay->ViewAttributes() ?>><?php echo $vouchers->copay->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_copay" id="x<?php echo $vouchers_grid->RowIndex ?>_copay" value="<?php echo ew_HtmlEncode($vouchers->copay->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_copay" id="o<?php echo $vouchers_grid->RowIndex ?>_copay" value="<?php echo ew_HtmlEncode($vouchers->copay->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vouchers->cat_status->Visible) { // cat_status ?>
		<td<?php echo $vouchers->cat_status->CellAttributes() ?>>
<?php if ($vouchers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_cat_status" id="x<?php echo $vouchers_grid->RowIndex ?>_cat_status" size="30" maxlength="1" value="<?php echo $vouchers->cat_status->EditValue ?>"<?php echo $vouchers->cat_status->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_cat_status" id="o<?php echo $vouchers_grid->RowIndex ?>_cat_status" value="<?php echo ew_HtmlEncode($vouchers->cat_status->OldValue) ?>">
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_cat_status" id="x<?php echo $vouchers_grid->RowIndex ?>_cat_status" size="30" maxlength="1" value="<?php echo $vouchers->cat_status->EditValue ?>"<?php echo $vouchers->cat_status->EditAttributes() ?>>
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $vouchers->cat_status->ViewAttributes() ?>><?php echo $vouchers->cat_status->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_cat_status" id="x<?php echo $vouchers_grid->RowIndex ?>_cat_status" value="<?php echo ew_HtmlEncode($vouchers->cat_status->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_cat_status" id="o<?php echo $vouchers_grid->RowIndex ?>_cat_status" value="<?php echo ew_HtmlEncode($vouchers->cat_status->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vouchers->date_redeemed->Visible) { // date_redeemed ?>
		<td<?php echo $vouchers->date_redeemed->CellAttributes() ?>>
<?php if ($vouchers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_date_redeemed" id="x<?php echo $vouchers_grid->RowIndex ?>_date_redeemed" value="<?php echo $vouchers->date_redeemed->EditValue ?>"<?php echo $vouchers->date_redeemed->EditAttributes() ?>>
<input type="hidden" name="fo<?php echo $vouchers_grid->RowIndex ?>_date_redeemed" id="fo<?php echo $vouchers_grid->RowIndex ?>_date_redeemed" value="<?php echo ew_HtmlEncode(ew_FormatDateTime($vouchers->date_redeemed->OldValue, 5)) ?>">
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_date_redeemed" id="o<?php echo $vouchers_grid->RowIndex ?>_date_redeemed" value="<?php echo ew_HtmlEncode($vouchers->date_redeemed->OldValue) ?>">
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_date_redeemed" id="x<?php echo $vouchers_grid->RowIndex ?>_date_redeemed" value="<?php echo $vouchers->date_redeemed->EditValue ?>"<?php echo $vouchers->date_redeemed->EditAttributes() ?>>
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $vouchers->date_redeemed->ViewAttributes() ?>><?php echo $vouchers->date_redeemed->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_date_redeemed" id="x<?php echo $vouchers_grid->RowIndex ?>_date_redeemed" value="<?php echo ew_HtmlEncode($vouchers->date_redeemed->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_date_redeemed" id="o<?php echo $vouchers_grid->RowIndex ?>_date_redeemed" value="<?php echo ew_HtmlEncode($vouchers->date_redeemed->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vouchers->Clinic->Visible) { // Clinic ?>
		<td<?php echo $vouchers->Clinic->CellAttributes() ?>>
<?php if ($vouchers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_Clinic" id="x<?php echo $vouchers_grid->RowIndex ?>_Clinic" size="30" maxlength="50" value="<?php echo $vouchers->Clinic->EditValue ?>"<?php echo $vouchers->Clinic->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_Clinic" id="o<?php echo $vouchers_grid->RowIndex ?>_Clinic" value="<?php echo ew_HtmlEncode($vouchers->Clinic->OldValue) ?>">
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_Clinic" id="x<?php echo $vouchers_grid->RowIndex ?>_Clinic" size="30" maxlength="50" value="<?php echo $vouchers->Clinic->EditValue ?>"<?php echo $vouchers->Clinic->EditAttributes() ?>>
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $vouchers->Clinic->ViewAttributes() ?>><?php echo $vouchers->Clinic->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_Clinic" id="x<?php echo $vouchers_grid->RowIndex ?>_Clinic" value="<?php echo ew_HtmlEncode($vouchers->Clinic->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_Clinic" id="o<?php echo $vouchers_grid->RowIndex ?>_Clinic" value="<?php echo ew_HtmlEncode($vouchers->Clinic->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vouchers->ClinicPrice->Visible) { // ClinicPrice ?>
		<td<?php echo $vouchers->ClinicPrice->CellAttributes() ?>>
<?php if ($vouchers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_ClinicPrice" id="x<?php echo $vouchers_grid->RowIndex ?>_ClinicPrice" size="30" value="<?php echo $vouchers->ClinicPrice->EditValue ?>"<?php echo $vouchers->ClinicPrice->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_ClinicPrice" id="o<?php echo $vouchers_grid->RowIndex ?>_ClinicPrice" value="<?php echo ew_HtmlEncode($vouchers->ClinicPrice->OldValue) ?>">
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_ClinicPrice" id="x<?php echo $vouchers_grid->RowIndex ?>_ClinicPrice" size="30" value="<?php echo $vouchers->ClinicPrice->EditValue ?>"<?php echo $vouchers->ClinicPrice->EditAttributes() ?>>
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $vouchers->ClinicPrice->ViewAttributes() ?>><?php echo $vouchers->ClinicPrice->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_ClinicPrice" id="x<?php echo $vouchers_grid->RowIndex ?>_ClinicPrice" value="<?php echo ew_HtmlEncode($vouchers->ClinicPrice->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_ClinicPrice" id="o<?php echo $vouchers_grid->RowIndex ?>_ClinicPrice" value="<?php echo ew_HtmlEncode($vouchers->ClinicPrice->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vouchers->vet_used->Visible) { // vet_used ?>
		<td<?php echo $vouchers->vet_used->CellAttributes() ?>>
<?php if ($vouchers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_vet_used" id="x<?php echo $vouchers_grid->RowIndex ?>_vet_used" size="30" maxlength="35" value="<?php echo $vouchers->vet_used->EditValue ?>"<?php echo $vouchers->vet_used->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_vet_used" id="o<?php echo $vouchers_grid->RowIndex ?>_vet_used" value="<?php echo ew_HtmlEncode($vouchers->vet_used->OldValue) ?>">
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_vet_used" id="x<?php echo $vouchers_grid->RowIndex ?>_vet_used" size="30" maxlength="35" value="<?php echo $vouchers->vet_used->EditValue ?>"<?php echo $vouchers->vet_used->EditAttributes() ?>>
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $vouchers->vet_used->ViewAttributes() ?>><?php echo $vouchers->vet_used->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_vet_used" id="x<?php echo $vouchers_grid->RowIndex ?>_vet_used" value="<?php echo ew_HtmlEncode($vouchers->vet_used->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_vet_used" id="o<?php echo $vouchers_grid->RowIndex ?>_vet_used" value="<?php echo ew_HtmlEncode($vouchers->vet_used->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vouchers->colony_id->Visible) { // colony_id ?>
		<td<?php echo $vouchers->colony_id->CellAttributes() ?>>
<?php if ($vouchers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($vouchers->colony_id->getSessionValue() <> "") { ?>
<div<?php echo $vouchers->colony_id->ViewAttributes() ?>><?php echo $vouchers->colony_id->ListViewValue() ?></div>
<input type="hidden" id="x<?php echo $vouchers_grid->RowIndex ?>_colony_id" name="x<?php echo $vouchers_grid->RowIndex ?>_colony_id" value="<?php echo ew_HtmlEncode($vouchers->colony_id->CurrentValue) ?>">
<?php } else { ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_colony_id" id="x<?php echo $vouchers_grid->RowIndex ?>_colony_id" size="30" value="<?php echo $vouchers->colony_id->EditValue ?>"<?php echo $vouchers->colony_id->EditAttributes() ?>>
<?php } ?>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_colony_id" id="o<?php echo $vouchers_grid->RowIndex ?>_colony_id" value="<?php echo ew_HtmlEncode($vouchers->colony_id->OldValue) ?>">
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($vouchers->colony_id->getSessionValue() <> "") { ?>
<div<?php echo $vouchers->colony_id->ViewAttributes() ?>><?php echo $vouchers->colony_id->ListViewValue() ?></div>
<input type="hidden" id="x<?php echo $vouchers_grid->RowIndex ?>_colony_id" name="x<?php echo $vouchers_grid->RowIndex ?>_colony_id" value="<?php echo ew_HtmlEncode($vouchers->colony_id->CurrentValue) ?>">
<?php } else { ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_colony_id" id="x<?php echo $vouchers_grid->RowIndex ?>_colony_id" size="30" value="<?php echo $vouchers->colony_id->EditValue ?>"<?php echo $vouchers->colony_id->EditAttributes() ?>>
<?php } ?>
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $vouchers->colony_id->ViewAttributes() ?>><?php echo $vouchers->colony_id->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_colony_id" id="x<?php echo $vouchers_grid->RowIndex ?>_colony_id" value="<?php echo ew_HtmlEncode($vouchers->colony_id->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_colony_id" id="o<?php echo $vouchers_grid->RowIndex ?>_colony_id" value="<?php echo ew_HtmlEncode($vouchers->colony_id->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vouchers->Spay->Visible) { // Spay ?>
		<td<?php echo $vouchers->Spay->CellAttributes() ?>>
<?php if ($vouchers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_Spay" id="x<?php echo $vouchers_grid->RowIndex ?>_Spay" size="30" maxlength="1" value="<?php echo $vouchers->Spay->EditValue ?>"<?php echo $vouchers->Spay->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_Spay" id="o<?php echo $vouchers_grid->RowIndex ?>_Spay" value="<?php echo ew_HtmlEncode($vouchers->Spay->OldValue) ?>">
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_Spay" id="x<?php echo $vouchers_grid->RowIndex ?>_Spay" size="30" maxlength="1" value="<?php echo $vouchers->Spay->EditValue ?>"<?php echo $vouchers->Spay->EditAttributes() ?>>
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $vouchers->Spay->ViewAttributes() ?>><?php echo $vouchers->Spay->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_Spay" id="x<?php echo $vouchers_grid->RowIndex ?>_Spay" value="<?php echo ew_HtmlEncode($vouchers->Spay->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_Spay" id="o<?php echo $vouchers_grid->RowIndex ?>_Spay" value="<?php echo ew_HtmlEncode($vouchers->Spay->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vouchers->Neuter->Visible) { // Neuter ?>
		<td<?php echo $vouchers->Neuter->CellAttributes() ?>>
<?php if ($vouchers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_Neuter" id="x<?php echo $vouchers_grid->RowIndex ?>_Neuter" size="30" maxlength="1" value="<?php echo $vouchers->Neuter->EditValue ?>"<?php echo $vouchers->Neuter->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_Neuter" id="o<?php echo $vouchers_grid->RowIndex ?>_Neuter" value="<?php echo ew_HtmlEncode($vouchers->Neuter->OldValue) ?>">
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_Neuter" id="x<?php echo $vouchers_grid->RowIndex ?>_Neuter" size="30" maxlength="1" value="<?php echo $vouchers->Neuter->EditValue ?>"<?php echo $vouchers->Neuter->EditAttributes() ?>>
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $vouchers->Neuter->ViewAttributes() ?>><?php echo $vouchers->Neuter->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_Neuter" id="x<?php echo $vouchers_grid->RowIndex ?>_Neuter" value="<?php echo ew_HtmlEncode($vouchers->Neuter->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_Neuter" id="o<?php echo $vouchers_grid->RowIndex ?>_Neuter" value="<?php echo ew_HtmlEncode($vouchers->Neuter->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vouchers->FVRCP->Visible) { // FVRCP ?>
		<td<?php echo $vouchers->FVRCP->CellAttributes() ?>>
<?php if ($vouchers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_FVRCP" id="x<?php echo $vouchers_grid->RowIndex ?>_FVRCP" size="30" maxlength="1" value="<?php echo $vouchers->FVRCP->EditValue ?>"<?php echo $vouchers->FVRCP->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_FVRCP" id="o<?php echo $vouchers_grid->RowIndex ?>_FVRCP" value="<?php echo ew_HtmlEncode($vouchers->FVRCP->OldValue) ?>">
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_FVRCP" id="x<?php echo $vouchers_grid->RowIndex ?>_FVRCP" size="30" maxlength="1" value="<?php echo $vouchers->FVRCP->EditValue ?>"<?php echo $vouchers->FVRCP->EditAttributes() ?>>
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $vouchers->FVRCP->ViewAttributes() ?>><?php echo $vouchers->FVRCP->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_FVRCP" id="x<?php echo $vouchers_grid->RowIndex ?>_FVRCP" value="<?php echo ew_HtmlEncode($vouchers->FVRCP->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_FVRCP" id="o<?php echo $vouchers_grid->RowIndex ?>_FVRCP" value="<?php echo ew_HtmlEncode($vouchers->FVRCP->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vouchers->FELV->Visible) { // FELV ?>
		<td<?php echo $vouchers->FELV->CellAttributes() ?>>
<?php if ($vouchers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_FELV" id="x<?php echo $vouchers_grid->RowIndex ?>_FELV" size="30" maxlength="1" value="<?php echo $vouchers->FELV->EditValue ?>"<?php echo $vouchers->FELV->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_FELV" id="o<?php echo $vouchers_grid->RowIndex ?>_FELV" value="<?php echo ew_HtmlEncode($vouchers->FELV->OldValue) ?>">
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_FELV" id="x<?php echo $vouchers_grid->RowIndex ?>_FELV" size="30" maxlength="1" value="<?php echo $vouchers->FELV->EditValue ?>"<?php echo $vouchers->FELV->EditAttributes() ?>>
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $vouchers->FELV->ViewAttributes() ?>><?php echo $vouchers->FELV->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_FELV" id="x<?php echo $vouchers_grid->RowIndex ?>_FELV" value="<?php echo ew_HtmlEncode($vouchers->FELV->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_FELV" id="o<?php echo $vouchers_grid->RowIndex ?>_FELV" value="<?php echo ew_HtmlEncode($vouchers->FELV->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vouchers->Rabies->Visible) { // Rabies ?>
		<td<?php echo $vouchers->Rabies->CellAttributes() ?>>
<?php if ($vouchers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_Rabies" id="x<?php echo $vouchers_grid->RowIndex ?>_Rabies" size="30" maxlength="1" value="<?php echo $vouchers->Rabies->EditValue ?>"<?php echo $vouchers->Rabies->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_Rabies" id="o<?php echo $vouchers_grid->RowIndex ?>_Rabies" value="<?php echo ew_HtmlEncode($vouchers->Rabies->OldValue) ?>">
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_Rabies" id="x<?php echo $vouchers_grid->RowIndex ?>_Rabies" size="30" maxlength="1" value="<?php echo $vouchers->Rabies->EditValue ?>"<?php echo $vouchers->Rabies->EditAttributes() ?>>
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $vouchers->Rabies->ViewAttributes() ?>><?php echo $vouchers->Rabies->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_Rabies" id="x<?php echo $vouchers_grid->RowIndex ?>_Rabies" value="<?php echo ew_HtmlEncode($vouchers->Rabies->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_Rabies" id="o<?php echo $vouchers_grid->RowIndex ?>_Rabies" value="<?php echo ew_HtmlEncode($vouchers->Rabies->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vouchers->Pregnant->Visible) { // Pregnant ?>
		<td<?php echo $vouchers->Pregnant->CellAttributes() ?>>
<?php if ($vouchers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_Pregnant" id="x<?php echo $vouchers_grid->RowIndex ?>_Pregnant" size="30" maxlength="1" value="<?php echo $vouchers->Pregnant->EditValue ?>"<?php echo $vouchers->Pregnant->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_Pregnant" id="o<?php echo $vouchers_grid->RowIndex ?>_Pregnant" value="<?php echo ew_HtmlEncode($vouchers->Pregnant->OldValue) ?>">
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_Pregnant" id="x<?php echo $vouchers_grid->RowIndex ?>_Pregnant" size="30" maxlength="1" value="<?php echo $vouchers->Pregnant->EditValue ?>"<?php echo $vouchers->Pregnant->EditAttributes() ?>>
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $vouchers->Pregnant->ViewAttributes() ?>><?php echo $vouchers->Pregnant->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_Pregnant" id="x<?php echo $vouchers_grid->RowIndex ?>_Pregnant" value="<?php echo ew_HtmlEncode($vouchers->Pregnant->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_Pregnant" id="o<?php echo $vouchers_grid->RowIndex ?>_Pregnant" value="<?php echo ew_HtmlEncode($vouchers->Pregnant->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vouchers->AssignedTo->Visible) { // AssignedTo ?>
		<td<?php echo $vouchers->AssignedTo->CellAttributes() ?>>
<?php if ($vouchers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_AssignedTo" id="x<?php echo $vouchers_grid->RowIndex ?>_AssignedTo" size="30" maxlength="50" value="<?php echo $vouchers->AssignedTo->EditValue ?>"<?php echo $vouchers->AssignedTo->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_AssignedTo" id="o<?php echo $vouchers_grid->RowIndex ?>_AssignedTo" value="<?php echo ew_HtmlEncode($vouchers->AssignedTo->OldValue) ?>">
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_AssignedTo" id="x<?php echo $vouchers_grid->RowIndex ?>_AssignedTo" size="30" maxlength="50" value="<?php echo $vouchers->AssignedTo->EditValue ?>"<?php echo $vouchers->AssignedTo->EditAttributes() ?>>
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $vouchers->AssignedTo->ViewAttributes() ?>><?php echo $vouchers->AssignedTo->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_AssignedTo" id="x<?php echo $vouchers_grid->RowIndex ?>_AssignedTo" value="<?php echo ew_HtmlEncode($vouchers->AssignedTo->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_AssignedTo" id="o<?php echo $vouchers_grid->RowIndex ?>_AssignedTo" value="<?php echo ew_HtmlEncode($vouchers->AssignedTo->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vouchers->mod_by->Visible) { // mod_by ?>
		<td<?php echo $vouchers->mod_by->CellAttributes() ?>>
<?php if ($vouchers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_mod_by" id="x<?php echo $vouchers_grid->RowIndex ?>_mod_by" size="30" maxlength="20" value="<?php echo $vouchers->mod_by->EditValue ?>"<?php echo $vouchers->mod_by->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_mod_by" id="o<?php echo $vouchers_grid->RowIndex ?>_mod_by" value="<?php echo ew_HtmlEncode($vouchers->mod_by->OldValue) ?>">
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_mod_by" id="x<?php echo $vouchers_grid->RowIndex ?>_mod_by" size="30" maxlength="20" value="<?php echo $vouchers->mod_by->EditValue ?>"<?php echo $vouchers->mod_by->EditAttributes() ?>>
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $vouchers->mod_by->ViewAttributes() ?>><?php echo $vouchers->mod_by->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_mod_by" id="x<?php echo $vouchers_grid->RowIndex ?>_mod_by" value="<?php echo ew_HtmlEncode($vouchers->mod_by->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_mod_by" id="o<?php echo $vouchers_grid->RowIndex ?>_mod_by" value="<?php echo ew_HtmlEncode($vouchers->mod_by->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vouchers->mod_date->Visible) { // mod_date ?>
		<td<?php echo $vouchers->mod_date->CellAttributes() ?>>
<?php if ($vouchers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_mod_date" id="x<?php echo $vouchers_grid->RowIndex ?>_mod_date" value="<?php echo $vouchers->mod_date->EditValue ?>"<?php echo $vouchers->mod_date->EditAttributes() ?>>
<input type="hidden" name="fo<?php echo $vouchers_grid->RowIndex ?>_mod_date" id="fo<?php echo $vouchers_grid->RowIndex ?>_mod_date" value="<?php echo ew_HtmlEncode(ew_FormatDateTime($vouchers->mod_date->OldValue, 5)) ?>">
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_mod_date" id="o<?php echo $vouchers_grid->RowIndex ?>_mod_date" value="<?php echo ew_HtmlEncode($vouchers->mod_date->OldValue) ?>">
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_mod_date" id="x<?php echo $vouchers_grid->RowIndex ?>_mod_date" value="<?php echo $vouchers->mod_date->EditValue ?>"<?php echo $vouchers->mod_date->EditAttributes() ?>>
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $vouchers->mod_date->ViewAttributes() ?>><?php echo $vouchers->mod_date->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_mod_date" id="x<?php echo $vouchers_grid->RowIndex ?>_mod_date" value="<?php echo ew_HtmlEncode($vouchers->mod_date->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_mod_date" id="o<?php echo $vouchers_grid->RowIndex ?>_mod_date" value="<?php echo ew_HtmlEncode($vouchers->mod_date->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$vouchers_grid->ListOptions->Render("body", "right");
?>
	</tr>
<?php if ($vouchers->RowType == EW_ROWTYPE_ADD) { ?>
<?php } ?>
<?php if ($vouchers->RowType == EW_ROWTYPE_EDIT) { ?>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($vouchers->CurrentAction <> "gridadd" || $vouchers->CurrentMode == "copy")
		if (!$vouchers_grid->Recordset->EOF) $vouchers_grid->Recordset->MoveNext();
}
?>
<?php
	if ($vouchers->CurrentMode == "add" || $vouchers->CurrentMode == "copy" || $vouchers->CurrentMode == "edit") {
		$vouchers_grid->RowIndex = '$rowindex$';
		$vouchers_grid->LoadDefaultValues();

		// Set row properties
		$vouchers->ResetAttrs();
		$vouchers->RowAttrs = array();
		if (!empty($vouchers_grid->RowIndex))
			$vouchers->RowAttrs = array_merge($vouchers->RowAttrs, array('data-rowindex'=>$vouchers_grid->RowIndex, 'id'=>'r' . $vouchers_grid->RowIndex . '_vouchers'));
		$vouchers->RowType = EW_ROWTYPE_ADD;

		// Render row
		$vouchers_grid->RenderRow();

		// Render list options
		$vouchers_grid->RenderListOptions();

		// Add id and class to the template row
		$vouchers->RowAttrs["id"] = "r0_vouchers";
		ew_AppendClass($vouchers->RowAttrs["class"], "ewTemplate");
?>
	<tr<?php echo $vouchers->RowAttributes() ?>>
<?php

// Render list options (body, left)
$vouchers_grid->ListOptions->Render("body", "left");
?>
	<?php if ($vouchers->id->Visible) { // id ?>
		<td>&nbsp;</td>
	<?php } ?>
	<?php if ($vouchers->VoucherNumber->Visible) { // VoucherNumber ?>
		<td>
<?php if ($vouchers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_VoucherNumber" id="x<?php echo $vouchers_grid->RowIndex ?>_VoucherNumber" size="30" value="<?php echo $vouchers->VoucherNumber->EditValue ?>"<?php echo $vouchers->VoucherNumber->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $vouchers->VoucherNumber->ViewAttributes() ?>><?php echo $vouchers->VoucherNumber->ViewValue ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_VoucherNumber" id="x<?php echo $vouchers_grid->RowIndex ?>_VoucherNumber" value="<?php echo ew_HtmlEncode($vouchers->VoucherNumber->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_VoucherNumber" id="o<?php echo $vouchers_grid->RowIndex ?>_VoucherNumber" value="<?php echo ew_HtmlEncode($vouchers->VoucherNumber->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vouchers->ExpireDate->Visible) { // ExpireDate ?>
		<td>
<?php if ($vouchers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_ExpireDate" id="x<?php echo $vouchers_grid->RowIndex ?>_ExpireDate" value="<?php echo $vouchers->ExpireDate->EditValue ?>"<?php echo $vouchers->ExpireDate->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $vouchers->ExpireDate->ViewAttributes() ?>><?php echo $vouchers->ExpireDate->ViewValue ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_ExpireDate" id="x<?php echo $vouchers_grid->RowIndex ?>_ExpireDate" value="<?php echo ew_HtmlEncode($vouchers->ExpireDate->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_ExpireDate" id="o<?php echo $vouchers_grid->RowIndex ?>_ExpireDate" value="<?php echo ew_HtmlEncode($vouchers->ExpireDate->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vouchers->IssuedByFirst->Visible) { // IssuedByFirst ?>
		<td>
<?php if ($vouchers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_IssuedByFirst" id="x<?php echo $vouchers_grid->RowIndex ?>_IssuedByFirst" size="30" maxlength="50" value="<?php echo $vouchers->IssuedByFirst->EditValue ?>"<?php echo $vouchers->IssuedByFirst->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $vouchers->IssuedByFirst->ViewAttributes() ?>><?php echo $vouchers->IssuedByFirst->ViewValue ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_IssuedByFirst" id="x<?php echo $vouchers_grid->RowIndex ?>_IssuedByFirst" value="<?php echo ew_HtmlEncode($vouchers->IssuedByFirst->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_IssuedByFirst" id="o<?php echo $vouchers_grid->RowIndex ?>_IssuedByFirst" value="<?php echo ew_HtmlEncode($vouchers->IssuedByFirst->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vouchers->IssuedByLast->Visible) { // IssuedByLast ?>
		<td>
<?php if ($vouchers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_IssuedByLast" id="x<?php echo $vouchers_grid->RowIndex ?>_IssuedByLast" size="30" maxlength="50" value="<?php echo $vouchers->IssuedByLast->EditValue ?>"<?php echo $vouchers->IssuedByLast->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $vouchers->IssuedByLast->ViewAttributes() ?>><?php echo $vouchers->IssuedByLast->ViewValue ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_IssuedByLast" id="x<?php echo $vouchers_grid->RowIndex ?>_IssuedByLast" value="<?php echo ew_HtmlEncode($vouchers->IssuedByLast->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_IssuedByLast" id="o<?php echo $vouchers_grid->RowIndex ?>_IssuedByLast" value="<?php echo ew_HtmlEncode($vouchers->IssuedByLast->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vouchers->FirstName->Visible) { // FirstName ?>
		<td>
<?php if ($vouchers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_FirstName" id="x<?php echo $vouchers_grid->RowIndex ?>_FirstName" size="30" maxlength="50" value="<?php echo $vouchers->FirstName->EditValue ?>"<?php echo $vouchers->FirstName->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $vouchers->FirstName->ViewAttributes() ?>><?php echo $vouchers->FirstName->ViewValue ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_FirstName" id="x<?php echo $vouchers_grid->RowIndex ?>_FirstName" value="<?php echo ew_HtmlEncode($vouchers->FirstName->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_FirstName" id="o<?php echo $vouchers_grid->RowIndex ?>_FirstName" value="<?php echo ew_HtmlEncode($vouchers->FirstName->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vouchers->LastName->Visible) { // LastName ?>
		<td>
<?php if ($vouchers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_LastName" id="x<?php echo $vouchers_grid->RowIndex ?>_LastName" size="30" maxlength="50" value="<?php echo $vouchers->LastName->EditValue ?>"<?php echo $vouchers->LastName->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $vouchers->LastName->ViewAttributes() ?>><?php echo $vouchers->LastName->ViewValue ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_LastName" id="x<?php echo $vouchers_grid->RowIndex ?>_LastName" value="<?php echo ew_HtmlEncode($vouchers->LastName->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_LastName" id="o<?php echo $vouchers_grid->RowIndex ?>_LastName" value="<?php echo ew_HtmlEncode($vouchers->LastName->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vouchers->Program->Visible) { // Program ?>
		<td>
<?php if ($vouchers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_Program" id="x<?php echo $vouchers_grid->RowIndex ?>_Program" size="30" maxlength="50" value="<?php echo $vouchers->Program->EditValue ?>"<?php echo $vouchers->Program->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $vouchers->Program->ViewAttributes() ?>><?php echo $vouchers->Program->ViewValue ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_Program" id="x<?php echo $vouchers_grid->RowIndex ?>_Program" value="<?php echo ew_HtmlEncode($vouchers->Program->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_Program" id="o<?php echo $vouchers_grid->RowIndex ?>_Program" value="<?php echo ew_HtmlEncode($vouchers->Program->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vouchers->cat_name->Visible) { // cat_name ?>
		<td>
<?php if ($vouchers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_cat_name" id="x<?php echo $vouchers_grid->RowIndex ?>_cat_name" size="30" maxlength="20" value="<?php echo $vouchers->cat_name->EditValue ?>"<?php echo $vouchers->cat_name->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $vouchers->cat_name->ViewAttributes() ?>><?php echo $vouchers->cat_name->ViewValue ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_cat_name" id="x<?php echo $vouchers_grid->RowIndex ?>_cat_name" value="<?php echo ew_HtmlEncode($vouchers->cat_name->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_cat_name" id="o<?php echo $vouchers_grid->RowIndex ?>_cat_name" value="<?php echo ew_HtmlEncode($vouchers->cat_name->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vouchers->cat_breed->Visible) { // cat_breed ?>
		<td>
<?php if ($vouchers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_cat_breed" id="x<?php echo $vouchers_grid->RowIndex ?>_cat_breed" size="30" maxlength="20" value="<?php echo $vouchers->cat_breed->EditValue ?>"<?php echo $vouchers->cat_breed->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $vouchers->cat_breed->ViewAttributes() ?>><?php echo $vouchers->cat_breed->ViewValue ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_cat_breed" id="x<?php echo $vouchers_grid->RowIndex ?>_cat_breed" value="<?php echo ew_HtmlEncode($vouchers->cat_breed->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_cat_breed" id="o<?php echo $vouchers_grid->RowIndex ?>_cat_breed" value="<?php echo ew_HtmlEncode($vouchers->cat_breed->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vouchers->cat_age->Visible) { // cat_age ?>
		<td>
<?php if ($vouchers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_cat_age" id="x<?php echo $vouchers_grid->RowIndex ?>_cat_age" size="30" value="<?php echo $vouchers->cat_age->EditValue ?>"<?php echo $vouchers->cat_age->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $vouchers->cat_age->ViewAttributes() ?>><?php echo $vouchers->cat_age->ViewValue ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_cat_age" id="x<?php echo $vouchers_grid->RowIndex ?>_cat_age" value="<?php echo ew_HtmlEncode($vouchers->cat_age->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_cat_age" id="o<?php echo $vouchers_grid->RowIndex ?>_cat_age" value="<?php echo ew_HtmlEncode($vouchers->cat_age->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vouchers->copay->Visible) { // copay ?>
		<td>
<?php if ($vouchers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_copay" id="x<?php echo $vouchers_grid->RowIndex ?>_copay" size="30" value="<?php echo $vouchers->copay->EditValue ?>"<?php echo $vouchers->copay->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $vouchers->copay->ViewAttributes() ?>><?php echo $vouchers->copay->ViewValue ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_copay" id="x<?php echo $vouchers_grid->RowIndex ?>_copay" value="<?php echo ew_HtmlEncode($vouchers->copay->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_copay" id="o<?php echo $vouchers_grid->RowIndex ?>_copay" value="<?php echo ew_HtmlEncode($vouchers->copay->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vouchers->cat_status->Visible) { // cat_status ?>
		<td>
<?php if ($vouchers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_cat_status" id="x<?php echo $vouchers_grid->RowIndex ?>_cat_status" size="30" maxlength="1" value="<?php echo $vouchers->cat_status->EditValue ?>"<?php echo $vouchers->cat_status->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $vouchers->cat_status->ViewAttributes() ?>><?php echo $vouchers->cat_status->ViewValue ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_cat_status" id="x<?php echo $vouchers_grid->RowIndex ?>_cat_status" value="<?php echo ew_HtmlEncode($vouchers->cat_status->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_cat_status" id="o<?php echo $vouchers_grid->RowIndex ?>_cat_status" value="<?php echo ew_HtmlEncode($vouchers->cat_status->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vouchers->date_redeemed->Visible) { // date_redeemed ?>
		<td>
<?php if ($vouchers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_date_redeemed" id="x<?php echo $vouchers_grid->RowIndex ?>_date_redeemed" value="<?php echo $vouchers->date_redeemed->EditValue ?>"<?php echo $vouchers->date_redeemed->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $vouchers->date_redeemed->ViewAttributes() ?>><?php echo $vouchers->date_redeemed->ViewValue ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_date_redeemed" id="x<?php echo $vouchers_grid->RowIndex ?>_date_redeemed" value="<?php echo ew_HtmlEncode($vouchers->date_redeemed->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_date_redeemed" id="o<?php echo $vouchers_grid->RowIndex ?>_date_redeemed" value="<?php echo ew_HtmlEncode($vouchers->date_redeemed->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vouchers->Clinic->Visible) { // Clinic ?>
		<td>
<?php if ($vouchers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_Clinic" id="x<?php echo $vouchers_grid->RowIndex ?>_Clinic" size="30" maxlength="50" value="<?php echo $vouchers->Clinic->EditValue ?>"<?php echo $vouchers->Clinic->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $vouchers->Clinic->ViewAttributes() ?>><?php echo $vouchers->Clinic->ViewValue ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_Clinic" id="x<?php echo $vouchers_grid->RowIndex ?>_Clinic" value="<?php echo ew_HtmlEncode($vouchers->Clinic->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_Clinic" id="o<?php echo $vouchers_grid->RowIndex ?>_Clinic" value="<?php echo ew_HtmlEncode($vouchers->Clinic->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vouchers->ClinicPrice->Visible) { // ClinicPrice ?>
		<td>
<?php if ($vouchers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_ClinicPrice" id="x<?php echo $vouchers_grid->RowIndex ?>_ClinicPrice" size="30" value="<?php echo $vouchers->ClinicPrice->EditValue ?>"<?php echo $vouchers->ClinicPrice->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $vouchers->ClinicPrice->ViewAttributes() ?>><?php echo $vouchers->ClinicPrice->ViewValue ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_ClinicPrice" id="x<?php echo $vouchers_grid->RowIndex ?>_ClinicPrice" value="<?php echo ew_HtmlEncode($vouchers->ClinicPrice->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_ClinicPrice" id="o<?php echo $vouchers_grid->RowIndex ?>_ClinicPrice" value="<?php echo ew_HtmlEncode($vouchers->ClinicPrice->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vouchers->vet_used->Visible) { // vet_used ?>
		<td>
<?php if ($vouchers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_vet_used" id="x<?php echo $vouchers_grid->RowIndex ?>_vet_used" size="30" maxlength="35" value="<?php echo $vouchers->vet_used->EditValue ?>"<?php echo $vouchers->vet_used->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $vouchers->vet_used->ViewAttributes() ?>><?php echo $vouchers->vet_used->ViewValue ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_vet_used" id="x<?php echo $vouchers_grid->RowIndex ?>_vet_used" value="<?php echo ew_HtmlEncode($vouchers->vet_used->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_vet_used" id="o<?php echo $vouchers_grid->RowIndex ?>_vet_used" value="<?php echo ew_HtmlEncode($vouchers->vet_used->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vouchers->colony_id->Visible) { // colony_id ?>
		<td>
<?php if ($vouchers->CurrentAction <> "F") { ?>
<?php if ($vouchers->colony_id->getSessionValue() <> "") { ?>
<div<?php echo $vouchers->colony_id->ViewAttributes() ?>><?php echo $vouchers->colony_id->ListViewValue() ?></div>
<input type="hidden" id="x<?php echo $vouchers_grid->RowIndex ?>_colony_id" name="x<?php echo $vouchers_grid->RowIndex ?>_colony_id" value="<?php echo ew_HtmlEncode($vouchers->colony_id->CurrentValue) ?>">
<?php } else { ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_colony_id" id="x<?php echo $vouchers_grid->RowIndex ?>_colony_id" size="30" value="<?php echo $vouchers->colony_id->EditValue ?>"<?php echo $vouchers->colony_id->EditAttributes() ?>>
<?php } ?>
<?php } else { ?>
<div<?php echo $vouchers->colony_id->ViewAttributes() ?>><?php echo $vouchers->colony_id->ViewValue ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_colony_id" id="x<?php echo $vouchers_grid->RowIndex ?>_colony_id" value="<?php echo ew_HtmlEncode($vouchers->colony_id->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_colony_id" id="o<?php echo $vouchers_grid->RowIndex ?>_colony_id" value="<?php echo ew_HtmlEncode($vouchers->colony_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vouchers->Spay->Visible) { // Spay ?>
		<td>
<?php if ($vouchers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_Spay" id="x<?php echo $vouchers_grid->RowIndex ?>_Spay" size="30" maxlength="1" value="<?php echo $vouchers->Spay->EditValue ?>"<?php echo $vouchers->Spay->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $vouchers->Spay->ViewAttributes() ?>><?php echo $vouchers->Spay->ViewValue ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_Spay" id="x<?php echo $vouchers_grid->RowIndex ?>_Spay" value="<?php echo ew_HtmlEncode($vouchers->Spay->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_Spay" id="o<?php echo $vouchers_grid->RowIndex ?>_Spay" value="<?php echo ew_HtmlEncode($vouchers->Spay->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vouchers->Neuter->Visible) { // Neuter ?>
		<td>
<?php if ($vouchers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_Neuter" id="x<?php echo $vouchers_grid->RowIndex ?>_Neuter" size="30" maxlength="1" value="<?php echo $vouchers->Neuter->EditValue ?>"<?php echo $vouchers->Neuter->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $vouchers->Neuter->ViewAttributes() ?>><?php echo $vouchers->Neuter->ViewValue ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_Neuter" id="x<?php echo $vouchers_grid->RowIndex ?>_Neuter" value="<?php echo ew_HtmlEncode($vouchers->Neuter->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_Neuter" id="o<?php echo $vouchers_grid->RowIndex ?>_Neuter" value="<?php echo ew_HtmlEncode($vouchers->Neuter->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vouchers->FVRCP->Visible) { // FVRCP ?>
		<td>
<?php if ($vouchers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_FVRCP" id="x<?php echo $vouchers_grid->RowIndex ?>_FVRCP" size="30" maxlength="1" value="<?php echo $vouchers->FVRCP->EditValue ?>"<?php echo $vouchers->FVRCP->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $vouchers->FVRCP->ViewAttributes() ?>><?php echo $vouchers->FVRCP->ViewValue ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_FVRCP" id="x<?php echo $vouchers_grid->RowIndex ?>_FVRCP" value="<?php echo ew_HtmlEncode($vouchers->FVRCP->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_FVRCP" id="o<?php echo $vouchers_grid->RowIndex ?>_FVRCP" value="<?php echo ew_HtmlEncode($vouchers->FVRCP->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vouchers->FELV->Visible) { // FELV ?>
		<td>
<?php if ($vouchers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_FELV" id="x<?php echo $vouchers_grid->RowIndex ?>_FELV" size="30" maxlength="1" value="<?php echo $vouchers->FELV->EditValue ?>"<?php echo $vouchers->FELV->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $vouchers->FELV->ViewAttributes() ?>><?php echo $vouchers->FELV->ViewValue ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_FELV" id="x<?php echo $vouchers_grid->RowIndex ?>_FELV" value="<?php echo ew_HtmlEncode($vouchers->FELV->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_FELV" id="o<?php echo $vouchers_grid->RowIndex ?>_FELV" value="<?php echo ew_HtmlEncode($vouchers->FELV->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vouchers->Rabies->Visible) { // Rabies ?>
		<td>
<?php if ($vouchers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_Rabies" id="x<?php echo $vouchers_grid->RowIndex ?>_Rabies" size="30" maxlength="1" value="<?php echo $vouchers->Rabies->EditValue ?>"<?php echo $vouchers->Rabies->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $vouchers->Rabies->ViewAttributes() ?>><?php echo $vouchers->Rabies->ViewValue ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_Rabies" id="x<?php echo $vouchers_grid->RowIndex ?>_Rabies" value="<?php echo ew_HtmlEncode($vouchers->Rabies->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_Rabies" id="o<?php echo $vouchers_grid->RowIndex ?>_Rabies" value="<?php echo ew_HtmlEncode($vouchers->Rabies->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vouchers->Pregnant->Visible) { // Pregnant ?>
		<td>
<?php if ($vouchers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_Pregnant" id="x<?php echo $vouchers_grid->RowIndex ?>_Pregnant" size="30" maxlength="1" value="<?php echo $vouchers->Pregnant->EditValue ?>"<?php echo $vouchers->Pregnant->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $vouchers->Pregnant->ViewAttributes() ?>><?php echo $vouchers->Pregnant->ViewValue ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_Pregnant" id="x<?php echo $vouchers_grid->RowIndex ?>_Pregnant" value="<?php echo ew_HtmlEncode($vouchers->Pregnant->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_Pregnant" id="o<?php echo $vouchers_grid->RowIndex ?>_Pregnant" value="<?php echo ew_HtmlEncode($vouchers->Pregnant->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vouchers->AssignedTo->Visible) { // AssignedTo ?>
		<td>
<?php if ($vouchers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_AssignedTo" id="x<?php echo $vouchers_grid->RowIndex ?>_AssignedTo" size="30" maxlength="50" value="<?php echo $vouchers->AssignedTo->EditValue ?>"<?php echo $vouchers->AssignedTo->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $vouchers->AssignedTo->ViewAttributes() ?>><?php echo $vouchers->AssignedTo->ViewValue ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_AssignedTo" id="x<?php echo $vouchers_grid->RowIndex ?>_AssignedTo" value="<?php echo ew_HtmlEncode($vouchers->AssignedTo->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_AssignedTo" id="o<?php echo $vouchers_grid->RowIndex ?>_AssignedTo" value="<?php echo ew_HtmlEncode($vouchers->AssignedTo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vouchers->mod_by->Visible) { // mod_by ?>
		<td>
<?php if ($vouchers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_mod_by" id="x<?php echo $vouchers_grid->RowIndex ?>_mod_by" size="30" maxlength="20" value="<?php echo $vouchers->mod_by->EditValue ?>"<?php echo $vouchers->mod_by->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $vouchers->mod_by->ViewAttributes() ?>><?php echo $vouchers->mod_by->ViewValue ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_mod_by" id="x<?php echo $vouchers_grid->RowIndex ?>_mod_by" value="<?php echo ew_HtmlEncode($vouchers->mod_by->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_mod_by" id="o<?php echo $vouchers_grid->RowIndex ?>_mod_by" value="<?php echo ew_HtmlEncode($vouchers->mod_by->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vouchers->mod_date->Visible) { // mod_date ?>
		<td>
<?php if ($vouchers->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $vouchers_grid->RowIndex ?>_mod_date" id="x<?php echo $vouchers_grid->RowIndex ?>_mod_date" value="<?php echo $vouchers->mod_date->EditValue ?>"<?php echo $vouchers->mod_date->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $vouchers->mod_date->ViewAttributes() ?>><?php echo $vouchers->mod_date->ViewValue ?></div>
<input type="hidden" name="x<?php echo $vouchers_grid->RowIndex ?>_mod_date" id="x<?php echo $vouchers_grid->RowIndex ?>_mod_date" value="<?php echo ew_HtmlEncode($vouchers->mod_date->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $vouchers_grid->RowIndex ?>_mod_date" id="o<?php echo $vouchers_grid->RowIndex ?>_mod_date" value="<?php echo ew_HtmlEncode($vouchers->mod_date->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$vouchers_grid->ListOptions->Render("body", "right");
?>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($vouchers->CurrentMode == "add" || $vouchers->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $vouchers_grid->KeyCount ?>">
<?php echo $vouchers_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($vouchers->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $vouchers_grid->KeyCount ?>">
<?php echo $vouchers_grid->MultiSelectKey ?>
<?php } ?>
<input type="hidden" name="detailpage" id="detailpage" value="vouchers_grid">
</div>
<?php

// Close recordset
if ($vouchers_grid->Recordset)
	$vouchers_grid->Recordset->Close();
?>
<?php if (($vouchers->CurrentMode == "add" || $vouchers->CurrentMode == "copy" || $vouchers->CurrentMode == "edit") && $vouchers->CurrentAction != "F") { // add/copy/edit mode ?>
<div class="ewGridLowerPanel">
<?php if ($vouchers->AllowAddDeleteRow) { ?>
<span class="phpmaker">
<a href="javascript:void(0);" onclick="ew_AddGridRow(this);"><?php echo $Language->Phrase("AddBlankRow") ?></a>&nbsp;&nbsp;
</span>
<?php } ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($vouchers->Export == "" && $vouchers->CurrentAction == "") { ?>
<?php } ?>
<?php
$vouchers_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$vouchers_grid->Page_Terminate();
$Page =& $MasterPage;
?>
