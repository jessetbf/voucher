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
$caregivers_edit = new ccaregivers_edit();
$Page =& $caregivers_edit;

// Page init
$caregivers_edit->Page_Init();

// Page main
$caregivers_edit->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var caregivers_edit = new ew_Page("caregivers_edit");

// page properties
caregivers_edit.PageID = "edit"; // page ID
caregivers_edit.FormID = "fcaregiversedit"; // form ID
var EW_PAGE_ID = caregivers_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
caregivers_edit.ValidateForm = function(fobj) {
	ew_PostAutoSuggest(fobj);
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = 1;
	for (i=0; i<rowcnt; i++) {
		infix = "";
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
	}

	// Process detail page
	var detailpage = (fobj.detailpage) ? fobj.detailpage.value : "";
	if (detailpage != "") {
		return eval(detailpage+".ValidateForm(fobj)");
	}
	return true;
}

// extend page with Form_CustomValidate function
caregivers_edit.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
caregivers_edit.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
caregivers_edit.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("Edit") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $caregivers->TableCaption() ?></p>
<p class="phpmaker"><a href="<?php echo $caregivers->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $caregivers_edit->ShowPageHeader(); ?>
<?php
$caregivers_edit->ShowMessage();
?>
<form name="fcaregiversedit" id="fcaregiversedit" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return caregivers_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="caregivers">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($caregivers->caregiver_id->Visible) { // caregiver_id ?>
	<tr id="r_caregiver_id"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->caregiver_id->FldCaption() ?></td>
		<td<?php echo $caregivers->caregiver_id->CellAttributes() ?>><span id="el_caregiver_id">
<div<?php echo $caregivers->caregiver_id->ViewAttributes() ?>><?php echo $caregivers->caregiver_id->EditValue ?></div>
<input type="hidden" name="x_caregiver_id" id="x_caregiver_id" value="<?php echo ew_HtmlEncode($caregivers->caregiver_id->CurrentValue) ?>">
</span><?php echo $caregivers->caregiver_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($caregivers->first_name->Visible) { // first_name ?>
	<tr id="r_first_name"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->first_name->FldCaption() ?></td>
		<td<?php echo $caregivers->first_name->CellAttributes() ?>><span id="el_first_name">
<input type="text" name="x_first_name" id="x_first_name" size="30" maxlength="20" value="<?php echo $caregivers->first_name->EditValue ?>"<?php echo $caregivers->first_name->EditAttributes() ?>>
</span><?php echo $caregivers->first_name->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($caregivers->last_name->Visible) { // last_name ?>
	<tr id="r_last_name"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->last_name->FldCaption() ?></td>
		<td<?php echo $caregivers->last_name->CellAttributes() ?>><span id="el_last_name">
<input type="text" name="x_last_name" id="x_last_name" size="30" maxlength="30" value="<?php echo $caregivers->last_name->EditValue ?>"<?php echo $caregivers->last_name->EditAttributes() ?>>
</span><?php echo $caregivers->last_name->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($caregivers->day_phone->Visible) { // day_phone ?>
	<tr id="r_day_phone"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->day_phone->FldCaption() ?></td>
		<td<?php echo $caregivers->day_phone->CellAttributes() ?>><span id="el_day_phone">
<input type="text" name="x_day_phone" id="x_day_phone" size="30" maxlength="20" value="<?php echo $caregivers->day_phone->EditValue ?>"<?php echo $caregivers->day_phone->EditAttributes() ?>>
</span><?php echo $caregivers->day_phone->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($caregivers->other_phone->Visible) { // other_phone ?>
	<tr id="r_other_phone"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->other_phone->FldCaption() ?></td>
		<td<?php echo $caregivers->other_phone->CellAttributes() ?>><span id="el_other_phone">
<input type="text" name="x_other_phone" id="x_other_phone" size="30" maxlength="20" value="<?php echo $caregivers->other_phone->EditValue ?>"<?php echo $caregivers->other_phone->EditAttributes() ?>>
</span><?php echo $caregivers->other_phone->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($caregivers->zemail->Visible) { // email ?>
	<tr id="r_zemail"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->zemail->FldCaption() ?></td>
		<td<?php echo $caregivers->zemail->CellAttributes() ?>><span id="el_zemail">
<input type="text" name="x_zemail" id="x_zemail" size="30" maxlength="60" value="<?php echo $caregivers->zemail->EditValue ?>"<?php echo $caregivers->zemail->EditAttributes() ?>>
</span><?php echo $caregivers->zemail->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($caregivers->address->Visible) { // address ?>
	<tr id="r_address"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->address->FldCaption() ?></td>
		<td<?php echo $caregivers->address->CellAttributes() ?>><span id="el_address">
<input type="text" name="x_address" id="x_address" size="30" maxlength="70" value="<?php echo $caregivers->address->EditValue ?>"<?php echo $caregivers->address->EditAttributes() ?>>
</span><?php echo $caregivers->address->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($caregivers->apt_num->Visible) { // apt_num ?>
	<tr id="r_apt_num"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->apt_num->FldCaption() ?></td>
		<td<?php echo $caregivers->apt_num->CellAttributes() ?>><span id="el_apt_num">
<input type="text" name="x_apt_num" id="x_apt_num" size="30" maxlength="5" value="<?php echo $caregivers->apt_num->EditValue ?>"<?php echo $caregivers->apt_num->EditAttributes() ?>>
</span><?php echo $caregivers->apt_num->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($caregivers->city->Visible) { // city ?>
	<tr id="r_city"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->city->FldCaption() ?></td>
		<td<?php echo $caregivers->city->CellAttributes() ?>><span id="el_city">
<input type="text" name="x_city" id="x_city" size="30" maxlength="30" value="<?php echo $caregivers->city->EditValue ?>"<?php echo $caregivers->city->EditAttributes() ?>>
</span><?php echo $caregivers->city->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($caregivers->county->Visible) { // county ?>
	<tr id="r_county"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->county->FldCaption() ?></td>
		<td<?php echo $caregivers->county->CellAttributes() ?>><span id="el_county">
<input type="text" name="x_county" id="x_county" size="30" maxlength="20" value="<?php echo $caregivers->county->EditValue ?>"<?php echo $caregivers->county->EditAttributes() ?>>
</span><?php echo $caregivers->county->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($caregivers->zip->Visible) { // zip ?>
	<tr id="r_zip"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->zip->FldCaption() ?></td>
		<td<?php echo $caregivers->zip->CellAttributes() ?>><span id="el_zip">
<input type="text" name="x_zip" id="x_zip" size="30" value="<?php echo $caregivers->zip->EditValue ?>"<?php echo $caregivers->zip->EditAttributes() ?>>
</span><?php echo $caregivers->zip->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($caregivers->num_deps->Visible) { // num_deps ?>
	<tr id="r_num_deps"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->num_deps->FldCaption() ?></td>
		<td<?php echo $caregivers->num_deps->CellAttributes() ?>><span id="el_num_deps">
<input type="text" name="x_num_deps" id="x_num_deps" size="30" value="<?php echo $caregivers->num_deps->EditValue ?>"<?php echo $caregivers->num_deps->EditAttributes() ?>>
</span><?php echo $caregivers->num_deps->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($caregivers->annual_income->Visible) { // annual_income ?>
	<tr id="r_annual_income"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->annual_income->FldCaption() ?></td>
		<td<?php echo $caregivers->annual_income->CellAttributes() ?>><span id="el_annual_income">
<input type="text" name="x_annual_income" id="x_annual_income" size="30" value="<?php echo $caregivers->annual_income->EditValue ?>"<?php echo $caregivers->annual_income->EditAttributes() ?>>
</span><?php echo $caregivers->annual_income->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($caregivers->app_source->Visible) { // app_source ?>
	<tr id="r_app_source"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->app_source->FldCaption() ?></td>
		<td<?php echo $caregivers->app_source->CellAttributes() ?>><span id="el_app_source">
<input type="text" name="x_app_source" id="x_app_source" size="30" value="<?php echo $caregivers->app_source->EditValue ?>"<?php echo $caregivers->app_source->EditAttributes() ?>>
</span><?php echo $caregivers->app_source->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($caregivers->dl->Visible) { // dl ?>
	<tr id="r_dl"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->dl->FldCaption() ?></td>
		<td<?php echo $caregivers->dl->CellAttributes() ?>><span id="el_dl">
<input type="text" name="x_dl" id="x_dl" size="30" maxlength="10" value="<?php echo $caregivers->dl->EditValue ?>"<?php echo $caregivers->dl->EditAttributes() ?>>
</span><?php echo $caregivers->dl->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($caregivers->app_date->Visible) { // app_date ?>
	<tr id="r_app_date"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->app_date->FldCaption() ?></td>
		<td<?php echo $caregivers->app_date->CellAttributes() ?>><span id="el_app_date">
<input type="text" name="x_app_date" id="x_app_date" value="<?php echo $caregivers->app_date->EditValue ?>"<?php echo $caregivers->app_date->EditAttributes() ?>>
</span><?php echo $caregivers->app_date->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($caregivers->Expiration->Visible) { // Expiration ?>
	<tr id="r_Expiration"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->Expiration->FldCaption() ?></td>
		<td<?php echo $caregivers->Expiration->CellAttributes() ?>><span id="el_Expiration">
<input type="text" name="x_Expiration" id="x_Expiration" value="<?php echo $caregivers->Expiration->EditValue ?>"<?php echo $caregivers->Expiration->EditAttributes() ?>>
</span><?php echo $caregivers->Expiration->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($caregivers->ClinicGroup->Visible) { // ClinicGroup ?>
	<tr id="r_ClinicGroup"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->ClinicGroup->FldCaption() ?></td>
		<td<?php echo $caregivers->ClinicGroup->CellAttributes() ?>><span id="el_ClinicGroup">
<input type="text" name="x_ClinicGroup" id="x_ClinicGroup" size="30" maxlength="25" value="<?php echo $caregivers->ClinicGroup->EditValue ?>"<?php echo $caregivers->ClinicGroup->EditAttributes() ?>>
</span><?php echo $caregivers->ClinicGroup->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($caregivers->DateSent->Visible) { // DateSent ?>
	<tr id="r_DateSent"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->DateSent->FldCaption() ?></td>
		<td<?php echo $caregivers->DateSent->CellAttributes() ?>><span id="el_DateSent">
<input type="text" name="x_DateSent" id="x_DateSent" value="<?php echo $caregivers->DateSent->EditValue ?>"<?php echo $caregivers->DateSent->EditAttributes() ?>>
</span><?php echo $caregivers->DateSent->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($caregivers->budget_category->Visible) { // budget_category ?>
	<tr id="r_budget_category"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->budget_category->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $caregivers->budget_category->CellAttributes() ?>><span id="el_budget_category">
<input type="text" name="x_budget_category" id="x_budget_category" size="30" value="<?php echo $caregivers->budget_category->EditValue ?>"<?php echo $caregivers->budget_category->EditAttributes() ?>>
</span><?php echo $caregivers->budget_category->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($caregivers->AgeOfApplicant->Visible) { // AgeOfApplicant ?>
	<tr id="r_AgeOfApplicant"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->AgeOfApplicant->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $caregivers->AgeOfApplicant->CellAttributes() ?>><span id="el_AgeOfApplicant">
<input type="text" name="x_AgeOfApplicant" id="x_AgeOfApplicant" size="30" value="<?php echo $caregivers->AgeOfApplicant->EditValue ?>"<?php echo $caregivers->AgeOfApplicant->EditAttributes() ?>>
</span><?php echo $caregivers->AgeOfApplicant->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($caregivers->Applic->Visible) { // Applic ?>
	<tr id="r_Applic"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->Applic->FldCaption() ?></td>
		<td<?php echo $caregivers->Applic->CellAttributes() ?>><span id="el_Applic">
<input type="text" name="x_Applic" id="x_Applic" size="30" maxlength="32" value="<?php echo $caregivers->Applic->EditValue ?>"<?php echo $caregivers->Applic->EditAttributes() ?>>
</span><?php echo $caregivers->Applic->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($caregivers->SubApplic->Visible) { // SubApplic ?>
	<tr id="r_SubApplic"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->SubApplic->FldCaption() ?></td>
		<td<?php echo $caregivers->SubApplic->CellAttributes() ?>><span id="el_SubApplic">
<input type="text" name="x_SubApplic" id="x_SubApplic" size="30" maxlength="32" value="<?php echo $caregivers->SubApplic->EditValue ?>"<?php echo $caregivers->SubApplic->EditAttributes() ?>>
</span><?php echo $caregivers->SubApplic->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($caregivers->DateSigned->Visible) { // DateSigned ?>
	<tr id="r_DateSigned"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->DateSigned->FldCaption() ?></td>
		<td<?php echo $caregivers->DateSigned->CellAttributes() ?>><span id="el_DateSigned">
<input type="text" name="x_DateSigned" id="x_DateSigned" value="<?php echo $caregivers->DateSigned->EditValue ?>"<?php echo $caregivers->DateSigned->EditAttributes() ?>>
</span><?php echo $caregivers->DateSigned->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($caregivers->colony_id->Visible) { // colony_id ?>
	<tr id="r_colony_id"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->colony_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $caregivers->colony_id->CellAttributes() ?>><span id="el_colony_id">
<?php if ($caregivers->colony_id->getSessionValue() <> "") { ?>
<div<?php echo $caregivers->colony_id->ViewAttributes() ?>><?php echo $caregivers->colony_id->ViewValue ?></div>
<input type="hidden" id="x_colony_id" name="x_colony_id" value="<?php echo ew_HtmlEncode($caregivers->colony_id->CurrentValue) ?>">
<?php } else { ?>
<input type="text" name="x_colony_id" id="x_colony_id" size="30" value="<?php echo $caregivers->colony_id->EditValue ?>"<?php echo $caregivers->colony_id->EditAttributes() ?>>
<?php } ?>
</span><?php echo $caregivers->colony_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($caregivers->mod_by->Visible) { // mod_by ?>
	<tr id="r_mod_by"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->mod_by->FldCaption() ?></td>
		<td<?php echo $caregivers->mod_by->CellAttributes() ?>><span id="el_mod_by">
<input type="text" name="x_mod_by" id="x_mod_by" size="30" maxlength="20" value="<?php echo $caregivers->mod_by->EditValue ?>"<?php echo $caregivers->mod_by->EditAttributes() ?>>
</span><?php echo $caregivers->mod_by->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($caregivers->mod_date->Visible) { // mod_date ?>
	<tr id="r_mod_date"<?php echo $caregivers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $caregivers->mod_date->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $caregivers->mod_date->CellAttributes() ?>><span id="el_mod_date">
<input type="text" name="x_mod_date" id="x_mod_date" value="<?php echo $caregivers->mod_date->EditValue ?>"<?php echo $caregivers->mod_date->EditAttributes() ?>>
</span><?php echo $caregivers->mod_date->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("EditBtn")) ?>">
</form>
<?php
$caregivers_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php include_once "footer.php" ?>
<?php
$caregivers_edit->Page_Terminate();
?>
<?php

//
// Page class
//
class ccaregivers_edit {

	// Page ID
	var $PageID = 'edit';

	// Table name
	var $TableName = 'caregivers';

	// Page object name
	var $PageObjName = 'caregivers_edit';

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
	function ccaregivers_edit() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (caregivers)
		if (!isset($GLOBALS["caregivers"])) {
			$GLOBALS["caregivers"] = new ccaregivers();
			$GLOBALS["Table"] =& $GLOBALS["caregivers"];
		}

		// Table object (colonies)
		if (!isset($GLOBALS['colonies'])) $GLOBALS['colonies'] = new ccolonies();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'caregivers', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;
		global $caregivers;

		// Create form object
		$objForm = new cFormObj();

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
	var $DbMasterFilter;
	var $DbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $caregivers;

		// Load key from QueryString
		if (@$_GET["caregiver_id"] <> "")
			$caregivers->caregiver_id->setQueryStringValue($_GET["caregiver_id"]);

		// Set up master detail parameters
		$this->SetUpMasterParms();
		if (@$_POST["a_edit"] <> "") {
			$caregivers->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Validate form
			if (!$this->ValidateForm()) {
				$caregivers->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$caregivers->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		} else {
			$caregivers->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($caregivers->caregiver_id->CurrentValue == "")
			$this->Page_Terminate("caregiverslist.php"); // Invalid key, return to list
		switch ($caregivers->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("caregiverslist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$caregivers->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $caregivers->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "caregiversview.php")
						$sReturnUrl = $caregivers->ViewUrl(); // View paging, return to View page directly
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$caregivers->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$caregivers->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$caregivers->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $caregivers;

		// Get upload data
		$index = $objForm->Index; // Save form index
		$objForm->Index = 0;
		$confirmPage = (strval($objForm->GetValue("a_confirm")) <> "");
		$objForm->Index = $index; // Restore form index
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $caregivers;
		if (!$caregivers->caregiver_id->FldIsDetailKey)
			$caregivers->caregiver_id->setFormValue($objForm->GetValue("x_caregiver_id"));
		if (!$caregivers->first_name->FldIsDetailKey) {
			$caregivers->first_name->setFormValue($objForm->GetValue("x_first_name"));
		}
		if (!$caregivers->last_name->FldIsDetailKey) {
			$caregivers->last_name->setFormValue($objForm->GetValue("x_last_name"));
		}
		if (!$caregivers->day_phone->FldIsDetailKey) {
			$caregivers->day_phone->setFormValue($objForm->GetValue("x_day_phone"));
		}
		if (!$caregivers->other_phone->FldIsDetailKey) {
			$caregivers->other_phone->setFormValue($objForm->GetValue("x_other_phone"));
		}
		if (!$caregivers->zemail->FldIsDetailKey) {
			$caregivers->zemail->setFormValue($objForm->GetValue("x_zemail"));
		}
		if (!$caregivers->address->FldIsDetailKey) {
			$caregivers->address->setFormValue($objForm->GetValue("x_address"));
		}
		if (!$caregivers->apt_num->FldIsDetailKey) {
			$caregivers->apt_num->setFormValue($objForm->GetValue("x_apt_num"));
		}
		if (!$caregivers->city->FldIsDetailKey) {
			$caregivers->city->setFormValue($objForm->GetValue("x_city"));
		}
		if (!$caregivers->county->FldIsDetailKey) {
			$caregivers->county->setFormValue($objForm->GetValue("x_county"));
		}
		if (!$caregivers->zip->FldIsDetailKey) {
			$caregivers->zip->setFormValue($objForm->GetValue("x_zip"));
		}
		if (!$caregivers->num_deps->FldIsDetailKey) {
			$caregivers->num_deps->setFormValue($objForm->GetValue("x_num_deps"));
		}
		if (!$caregivers->annual_income->FldIsDetailKey) {
			$caregivers->annual_income->setFormValue($objForm->GetValue("x_annual_income"));
		}
		if (!$caregivers->app_source->FldIsDetailKey) {
			$caregivers->app_source->setFormValue($objForm->GetValue("x_app_source"));
		}
		if (!$caregivers->dl->FldIsDetailKey) {
			$caregivers->dl->setFormValue($objForm->GetValue("x_dl"));
		}
		if (!$caregivers->app_date->FldIsDetailKey) {
			$caregivers->app_date->setFormValue($objForm->GetValue("x_app_date"));
			$caregivers->app_date->CurrentValue = ew_UnFormatDateTime($caregivers->app_date->CurrentValue, 5);
		}
		if (!$caregivers->Expiration->FldIsDetailKey) {
			$caregivers->Expiration->setFormValue($objForm->GetValue("x_Expiration"));
			$caregivers->Expiration->CurrentValue = ew_UnFormatDateTime($caregivers->Expiration->CurrentValue, 5);
		}
		if (!$caregivers->ClinicGroup->FldIsDetailKey) {
			$caregivers->ClinicGroup->setFormValue($objForm->GetValue("x_ClinicGroup"));
		}
		if (!$caregivers->DateSent->FldIsDetailKey) {
			$caregivers->DateSent->setFormValue($objForm->GetValue("x_DateSent"));
			$caregivers->DateSent->CurrentValue = ew_UnFormatDateTime($caregivers->DateSent->CurrentValue, 5);
		}
		if (!$caregivers->budget_category->FldIsDetailKey) {
			$caregivers->budget_category->setFormValue($objForm->GetValue("x_budget_category"));
		}
		if (!$caregivers->AgeOfApplicant->FldIsDetailKey) {
			$caregivers->AgeOfApplicant->setFormValue($objForm->GetValue("x_AgeOfApplicant"));
		}
		if (!$caregivers->Applic->FldIsDetailKey) {
			$caregivers->Applic->setFormValue($objForm->GetValue("x_Applic"));
		}
		if (!$caregivers->SubApplic->FldIsDetailKey) {
			$caregivers->SubApplic->setFormValue($objForm->GetValue("x_SubApplic"));
		}
		if (!$caregivers->DateSigned->FldIsDetailKey) {
			$caregivers->DateSigned->setFormValue($objForm->GetValue("x_DateSigned"));
			$caregivers->DateSigned->CurrentValue = ew_UnFormatDateTime($caregivers->DateSigned->CurrentValue, 5);
		}
		if (!$caregivers->colony_id->FldIsDetailKey) {
			$caregivers->colony_id->setFormValue($objForm->GetValue("x_colony_id"));
		}
		if (!$caregivers->mod_by->FldIsDetailKey) {
			$caregivers->mod_by->setFormValue($objForm->GetValue("x_mod_by"));
		}
		if (!$caregivers->mod_date->FldIsDetailKey) {
			$caregivers->mod_date->setFormValue($objForm->GetValue("x_mod_date"));
			$caregivers->mod_date->CurrentValue = ew_UnFormatDateTime($caregivers->mod_date->CurrentValue, 5);
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $caregivers;
		$this->LoadRow();
		$caregivers->caregiver_id->CurrentValue = $caregivers->caregiver_id->FormValue;
		$caregivers->first_name->CurrentValue = $caregivers->first_name->FormValue;
		$caregivers->last_name->CurrentValue = $caregivers->last_name->FormValue;
		$caregivers->day_phone->CurrentValue = $caregivers->day_phone->FormValue;
		$caregivers->other_phone->CurrentValue = $caregivers->other_phone->FormValue;
		$caregivers->zemail->CurrentValue = $caregivers->zemail->FormValue;
		$caregivers->address->CurrentValue = $caregivers->address->FormValue;
		$caregivers->apt_num->CurrentValue = $caregivers->apt_num->FormValue;
		$caregivers->city->CurrentValue = $caregivers->city->FormValue;
		$caregivers->county->CurrentValue = $caregivers->county->FormValue;
		$caregivers->zip->CurrentValue = $caregivers->zip->FormValue;
		$caregivers->num_deps->CurrentValue = $caregivers->num_deps->FormValue;
		$caregivers->annual_income->CurrentValue = $caregivers->annual_income->FormValue;
		$caregivers->app_source->CurrentValue = $caregivers->app_source->FormValue;
		$caregivers->dl->CurrentValue = $caregivers->dl->FormValue;
		$caregivers->app_date->CurrentValue = $caregivers->app_date->FormValue;
		$caregivers->app_date->CurrentValue = ew_UnFormatDateTime($caregivers->app_date->CurrentValue, 5);
		$caregivers->Expiration->CurrentValue = $caregivers->Expiration->FormValue;
		$caregivers->Expiration->CurrentValue = ew_UnFormatDateTime($caregivers->Expiration->CurrentValue, 5);
		$caregivers->ClinicGroup->CurrentValue = $caregivers->ClinicGroup->FormValue;
		$caregivers->DateSent->CurrentValue = $caregivers->DateSent->FormValue;
		$caregivers->DateSent->CurrentValue = ew_UnFormatDateTime($caregivers->DateSent->CurrentValue, 5);
		$caregivers->budget_category->CurrentValue = $caregivers->budget_category->FormValue;
		$caregivers->AgeOfApplicant->CurrentValue = $caregivers->AgeOfApplicant->FormValue;
		$caregivers->Applic->CurrentValue = $caregivers->Applic->FormValue;
		$caregivers->SubApplic->CurrentValue = $caregivers->SubApplic->FormValue;
		$caregivers->DateSigned->CurrentValue = $caregivers->DateSigned->FormValue;
		$caregivers->DateSigned->CurrentValue = ew_UnFormatDateTime($caregivers->DateSigned->CurrentValue, 5);
		$caregivers->colony_id->CurrentValue = $caregivers->colony_id->FormValue;
		$caregivers->mod_by->CurrentValue = $caregivers->mod_by->FormValue;
		$caregivers->mod_date->CurrentValue = $caregivers->mod_date->FormValue;
		$caregivers->mod_date->CurrentValue = ew_UnFormatDateTime($caregivers->mod_date->CurrentValue, 5);
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
		} elseif ($caregivers->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// caregiver_id
			$caregivers->caregiver_id->EditCustomAttributes = "";
			$caregivers->caregiver_id->EditValue = $caregivers->caregiver_id->CurrentValue;
			$caregivers->caregiver_id->ViewCustomAttributes = "";

			// first_name
			$caregivers->first_name->EditCustomAttributes = "";
			$caregivers->first_name->EditValue = ew_HtmlEncode($caregivers->first_name->CurrentValue);

			// last_name
			$caregivers->last_name->EditCustomAttributes = "";
			$caregivers->last_name->EditValue = ew_HtmlEncode($caregivers->last_name->CurrentValue);

			// day_phone
			$caregivers->day_phone->EditCustomAttributes = "";
			$caregivers->day_phone->EditValue = ew_HtmlEncode($caregivers->day_phone->CurrentValue);

			// other_phone
			$caregivers->other_phone->EditCustomAttributes = "";
			$caregivers->other_phone->EditValue = ew_HtmlEncode($caregivers->other_phone->CurrentValue);

			// email
			$caregivers->zemail->EditCustomAttributes = "";
			$caregivers->zemail->EditValue = ew_HtmlEncode($caregivers->zemail->CurrentValue);

			// address
			$caregivers->address->EditCustomAttributes = "";
			$caregivers->address->EditValue = ew_HtmlEncode($caregivers->address->CurrentValue);

			// apt_num
			$caregivers->apt_num->EditCustomAttributes = "";
			$caregivers->apt_num->EditValue = ew_HtmlEncode($caregivers->apt_num->CurrentValue);

			// city
			$caregivers->city->EditCustomAttributes = "";
			$caregivers->city->EditValue = ew_HtmlEncode($caregivers->city->CurrentValue);

			// county
			$caregivers->county->EditCustomAttributes = "";
			$caregivers->county->EditValue = ew_HtmlEncode($caregivers->county->CurrentValue);

			// zip
			$caregivers->zip->EditCustomAttributes = "";
			$caregivers->zip->EditValue = ew_HtmlEncode($caregivers->zip->CurrentValue);

			// num_deps
			$caregivers->num_deps->EditCustomAttributes = "";
			$caregivers->num_deps->EditValue = ew_HtmlEncode($caregivers->num_deps->CurrentValue);

			// annual_income
			$caregivers->annual_income->EditCustomAttributes = "";
			$caregivers->annual_income->EditValue = ew_HtmlEncode($caregivers->annual_income->CurrentValue);

			// app_source
			$caregivers->app_source->EditCustomAttributes = "";
			$caregivers->app_source->EditValue = ew_HtmlEncode($caregivers->app_source->CurrentValue);

			// dl
			$caregivers->dl->EditCustomAttributes = "";
			$caregivers->dl->EditValue = ew_HtmlEncode($caregivers->dl->CurrentValue);

			// app_date
			$caregivers->app_date->EditCustomAttributes = "";
			$caregivers->app_date->EditValue = ew_HtmlEncode(ew_FormatDateTime($caregivers->app_date->CurrentValue, 5));

			// Expiration
			$caregivers->Expiration->EditCustomAttributes = "";
			$caregivers->Expiration->EditValue = ew_HtmlEncode(ew_FormatDateTime($caregivers->Expiration->CurrentValue, 5));

			// ClinicGroup
			$caregivers->ClinicGroup->EditCustomAttributes = "";
			$caregivers->ClinicGroup->EditValue = ew_HtmlEncode($caregivers->ClinicGroup->CurrentValue);

			// DateSent
			$caregivers->DateSent->EditCustomAttributes = "";
			$caregivers->DateSent->EditValue = ew_HtmlEncode(ew_FormatDateTime($caregivers->DateSent->CurrentValue, 5));

			// budget_category
			$caregivers->budget_category->EditCustomAttributes = "";
			$caregivers->budget_category->EditValue = ew_HtmlEncode($caregivers->budget_category->CurrentValue);

			// AgeOfApplicant
			$caregivers->AgeOfApplicant->EditCustomAttributes = "";
			$caregivers->AgeOfApplicant->EditValue = ew_HtmlEncode($caregivers->AgeOfApplicant->CurrentValue);

			// Applic
			$caregivers->Applic->EditCustomAttributes = "";
			$caregivers->Applic->EditValue = ew_HtmlEncode($caregivers->Applic->CurrentValue);

			// SubApplic
			$caregivers->SubApplic->EditCustomAttributes = "";
			$caregivers->SubApplic->EditValue = ew_HtmlEncode($caregivers->SubApplic->CurrentValue);

			// DateSigned
			$caregivers->DateSigned->EditCustomAttributes = "";
			$caregivers->DateSigned->EditValue = ew_HtmlEncode(ew_FormatDateTime($caregivers->DateSigned->CurrentValue, 5));

			// colony_id
			$caregivers->colony_id->EditCustomAttributes = "";
			if ($caregivers->colony_id->getSessionValue() <> "") {
				$caregivers->colony_id->CurrentValue = $caregivers->colony_id->getSessionValue();
			$caregivers->colony_id->ViewValue = $caregivers->colony_id->CurrentValue;
			$caregivers->colony_id->ViewCustomAttributes = "";
			} else {
			$caregivers->colony_id->EditValue = ew_HtmlEncode($caregivers->colony_id->CurrentValue);
			}

			// mod_by
			$caregivers->mod_by->EditCustomAttributes = "";
			$caregivers->mod_by->EditValue = ew_HtmlEncode($caregivers->mod_by->CurrentValue);

			// mod_date
			$caregivers->mod_date->EditCustomAttributes = "";
			$caregivers->mod_date->EditValue = ew_HtmlEncode(ew_FormatDateTime($caregivers->mod_date->CurrentValue, 5));

			// Edit refer script
			// caregiver_id

			$caregivers->caregiver_id->HrefValue = "";

			// first_name
			$caregivers->first_name->HrefValue = "";

			// last_name
			$caregivers->last_name->HrefValue = "";

			// day_phone
			$caregivers->day_phone->HrefValue = "";

			// other_phone
			$caregivers->other_phone->HrefValue = "";

			// email
			$caregivers->zemail->HrefValue = "";

			// address
			$caregivers->address->HrefValue = "";

			// apt_num
			$caregivers->apt_num->HrefValue = "";

			// city
			$caregivers->city->HrefValue = "";

			// county
			$caregivers->county->HrefValue = "";

			// zip
			$caregivers->zip->HrefValue = "";

			// num_deps
			$caregivers->num_deps->HrefValue = "";

			// annual_income
			$caregivers->annual_income->HrefValue = "";

			// app_source
			$caregivers->app_source->HrefValue = "";

			// dl
			$caregivers->dl->HrefValue = "";

			// app_date
			$caregivers->app_date->HrefValue = "";

			// Expiration
			$caregivers->Expiration->HrefValue = "";

			// ClinicGroup
			$caregivers->ClinicGroup->HrefValue = "";

			// DateSent
			$caregivers->DateSent->HrefValue = "";

			// budget_category
			$caregivers->budget_category->HrefValue = "";

			// AgeOfApplicant
			$caregivers->AgeOfApplicant->HrefValue = "";

			// Applic
			$caregivers->Applic->HrefValue = "";

			// SubApplic
			$caregivers->SubApplic->HrefValue = "";

			// DateSigned
			$caregivers->DateSigned->HrefValue = "";

			// colony_id
			$caregivers->colony_id->HrefValue = "";

			// mod_by
			$caregivers->mod_by->HrefValue = "";

			// mod_date
			$caregivers->mod_date->HrefValue = "";
		}
		if ($caregivers->RowType == EW_ROWTYPE_ADD ||
			$caregivers->RowType == EW_ROWTYPE_EDIT ||
			$caregivers->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$caregivers->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($caregivers->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$caregivers->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError, $caregivers;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!ew_CheckInteger($caregivers->zip->FormValue)) {
			ew_AddMessage($gsFormError, $caregivers->zip->FldErrMsg());
		}
		if (!ew_CheckInteger($caregivers->num_deps->FormValue)) {
			ew_AddMessage($gsFormError, $caregivers->num_deps->FldErrMsg());
		}
		if (!ew_CheckInteger($caregivers->annual_income->FormValue)) {
			ew_AddMessage($gsFormError, $caregivers->annual_income->FldErrMsg());
		}
		if (!ew_CheckInteger($caregivers->app_source->FormValue)) {
			ew_AddMessage($gsFormError, $caregivers->app_source->FldErrMsg());
		}
		if (!ew_CheckDate($caregivers->app_date->FormValue)) {
			ew_AddMessage($gsFormError, $caregivers->app_date->FldErrMsg());
		}
		if (!ew_CheckDate($caregivers->Expiration->FormValue)) {
			ew_AddMessage($gsFormError, $caregivers->Expiration->FldErrMsg());
		}
		if (!ew_CheckDate($caregivers->DateSent->FormValue)) {
			ew_AddMessage($gsFormError, $caregivers->DateSent->FldErrMsg());
		}
		if (!is_null($caregivers->budget_category->FormValue) && $caregivers->budget_category->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $caregivers->budget_category->FldCaption());
		}
		if (!ew_CheckInteger($caregivers->budget_category->FormValue)) {
			ew_AddMessage($gsFormError, $caregivers->budget_category->FldErrMsg());
		}
		if (!is_null($caregivers->AgeOfApplicant->FormValue) && $caregivers->AgeOfApplicant->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $caregivers->AgeOfApplicant->FldCaption());
		}
		if (!ew_CheckInteger($caregivers->AgeOfApplicant->FormValue)) {
			ew_AddMessage($gsFormError, $caregivers->AgeOfApplicant->FldErrMsg());
		}
		if (!ew_CheckDate($caregivers->DateSigned->FormValue)) {
			ew_AddMessage($gsFormError, $caregivers->DateSigned->FldErrMsg());
		}
		if (!is_null($caregivers->colony_id->FormValue) && $caregivers->colony_id->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $caregivers->colony_id->FldCaption());
		}
		if (!ew_CheckInteger($caregivers->colony_id->FormValue)) {
			ew_AddMessage($gsFormError, $caregivers->colony_id->FldErrMsg());
		}
		if (!is_null($caregivers->mod_date->FormValue) && $caregivers->mod_date->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $caregivers->mod_date->FldCaption());
		}
		if (!ew_CheckDate($caregivers->mod_date->FormValue)) {
			ew_AddMessage($gsFormError, $caregivers->mod_date->FldErrMsg());
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Update record based on key values
	function EditRow() {
		global $conn, $Security, $Language, $caregivers;
		$sFilter = $caregivers->KeyFilter();
		$caregivers->CurrentFilter = $sFilter;
		$sSql = $caregivers->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold =& $rs->fields;
			$rsnew = array();

			// first_name
			$caregivers->first_name->SetDbValueDef($rsnew, $caregivers->first_name->CurrentValue, NULL, $caregivers->first_name->ReadOnly);

			// last_name
			$caregivers->last_name->SetDbValueDef($rsnew, $caregivers->last_name->CurrentValue, NULL, $caregivers->last_name->ReadOnly);

			// day_phone
			$caregivers->day_phone->SetDbValueDef($rsnew, $caregivers->day_phone->CurrentValue, NULL, $caregivers->day_phone->ReadOnly);

			// other_phone
			$caregivers->other_phone->SetDbValueDef($rsnew, $caregivers->other_phone->CurrentValue, NULL, $caregivers->other_phone->ReadOnly);

			// email
			$caregivers->zemail->SetDbValueDef($rsnew, $caregivers->zemail->CurrentValue, NULL, $caregivers->zemail->ReadOnly);

			// address
			$caregivers->address->SetDbValueDef($rsnew, $caregivers->address->CurrentValue, NULL, $caregivers->address->ReadOnly);

			// apt_num
			$caregivers->apt_num->SetDbValueDef($rsnew, $caregivers->apt_num->CurrentValue, NULL, $caregivers->apt_num->ReadOnly);

			// city
			$caregivers->city->SetDbValueDef($rsnew, $caregivers->city->CurrentValue, NULL, $caregivers->city->ReadOnly);

			// county
			$caregivers->county->SetDbValueDef($rsnew, $caregivers->county->CurrentValue, NULL, $caregivers->county->ReadOnly);

			// zip
			$caregivers->zip->SetDbValueDef($rsnew, $caregivers->zip->CurrentValue, NULL, $caregivers->zip->ReadOnly);

			// num_deps
			$caregivers->num_deps->SetDbValueDef($rsnew, $caregivers->num_deps->CurrentValue, NULL, $caregivers->num_deps->ReadOnly);

			// annual_income
			$caregivers->annual_income->SetDbValueDef($rsnew, $caregivers->annual_income->CurrentValue, NULL, $caregivers->annual_income->ReadOnly);

			// app_source
			$caregivers->app_source->SetDbValueDef($rsnew, $caregivers->app_source->CurrentValue, NULL, $caregivers->app_source->ReadOnly);

			// dl
			$caregivers->dl->SetDbValueDef($rsnew, $caregivers->dl->CurrentValue, NULL, $caregivers->dl->ReadOnly);

			// app_date
			$caregivers->app_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($caregivers->app_date->CurrentValue, 5), NULL, $caregivers->app_date->ReadOnly);

			// Expiration
			$caregivers->Expiration->SetDbValueDef($rsnew, ew_UnFormatDateTime($caregivers->Expiration->CurrentValue, 5), NULL, $caregivers->Expiration->ReadOnly);

			// ClinicGroup
			$caregivers->ClinicGroup->SetDbValueDef($rsnew, $caregivers->ClinicGroup->CurrentValue, NULL, $caregivers->ClinicGroup->ReadOnly);

			// DateSent
			$caregivers->DateSent->SetDbValueDef($rsnew, ew_UnFormatDateTime($caregivers->DateSent->CurrentValue, 5), NULL, $caregivers->DateSent->ReadOnly);

			// budget_category
			$caregivers->budget_category->SetDbValueDef($rsnew, $caregivers->budget_category->CurrentValue, 0, $caregivers->budget_category->ReadOnly);

			// AgeOfApplicant
			$caregivers->AgeOfApplicant->SetDbValueDef($rsnew, $caregivers->AgeOfApplicant->CurrentValue, 0, $caregivers->AgeOfApplicant->ReadOnly);

			// Applic
			$caregivers->Applic->SetDbValueDef($rsnew, $caregivers->Applic->CurrentValue, NULL, $caregivers->Applic->ReadOnly);

			// SubApplic
			$caregivers->SubApplic->SetDbValueDef($rsnew, $caregivers->SubApplic->CurrentValue, NULL, $caregivers->SubApplic->ReadOnly);

			// DateSigned
			$caregivers->DateSigned->SetDbValueDef($rsnew, ew_UnFormatDateTime($caregivers->DateSigned->CurrentValue, 5), NULL, $caregivers->DateSigned->ReadOnly);

			// colony_id
			$caregivers->colony_id->SetDbValueDef($rsnew, $caregivers->colony_id->CurrentValue, 0, $caregivers->colony_id->ReadOnly);

			// mod_by
			$caregivers->mod_by->SetDbValueDef($rsnew, $caregivers->mod_by->CurrentValue, NULL, $caregivers->mod_by->ReadOnly);

			// mod_date
			$caregivers->mod_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($caregivers->mod_date->CurrentValue, 5), ew_CurrentDate(), $caregivers->mod_date->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $caregivers->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				if (count($rsnew) > 0)
					$EditRow = $conn->Execute($caregivers->UpdateSQL($rsnew));
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
			} else {
				if ($caregivers->CancelMessage <> "") {
					$this->setFailureMessage($caregivers->CancelMessage);
					$caregivers->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$caregivers->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
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
}
?>
