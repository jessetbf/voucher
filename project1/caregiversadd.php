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
$caregivers_add = new ccaregivers_add();
$Page =& $caregivers_add;

// Page init
$caregivers_add->Page_Init();

// Page main
$caregivers_add->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var caregivers_add = new ew_Page("caregivers_add");

// page properties
caregivers_add.PageID = "add"; // page ID
caregivers_add.FormID = "fcaregiversadd"; // form ID
var EW_PAGE_ID = caregivers_add.PageID; // for backward compatibility

// extend page with ValidateForm function
caregivers_add.ValidateForm = function(fobj) {
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
caregivers_add.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
caregivers_add.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
caregivers_add.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("Add") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $caregivers->TableCaption() ?></p>
<p class="phpmaker"><a href="<?php echo $caregivers->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $caregivers_add->ShowPageHeader(); ?>
<?php
$caregivers_add->ShowMessage();
?>
<form name="fcaregiversadd" id="fcaregiversadd" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return caregivers_add.ValidateForm(this);">
<p>
<input type="hidden" name="t" id="t" value="caregivers">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
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
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("AddBtn")) ?>">
</form>
<?php
$caregivers_add->ShowPageFooter();
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
$caregivers_add->Page_Terminate();
?>
<?php

//
// Page class
//
class ccaregivers_add {

	// Page ID
	var $PageID = 'add';

	// Table name
	var $TableName = 'caregivers';

	// Page object name
	var $PageObjName = 'caregivers_add';

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
	function ccaregivers_add() {
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
			define("EW_PAGE_ID", 'add', TRUE);

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
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $caregivers;

		// Set up master/detail parameters
		$this->SetUpMasterParms();

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$caregivers->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values

			// Validate form
			if (!$this->ValidateForm()) {
				$caregivers->CurrentAction = "I"; // Form error, reset action
				$caregivers->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["caregiver_id"] != "") {
				$caregivers->caregiver_id->setQueryStringValue($_GET["caregiver_id"]);
				$caregivers->setKey("caregiver_id", $caregivers->caregiver_id->CurrentValue); // Set up key
			} else {
				$caregivers->setKey("caregiver_id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$caregivers->CurrentAction = "C"; // Copy record
			} else {
				$caregivers->CurrentAction = "I"; // Display blank record
				$this->LoadDefaultValues(); // Load default values
			}
		}

		// Perform action based on action code
		switch ($caregivers->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("caregiverslist.php"); // No matching record, return to list
				}
				break;
			case "A": // ' Add new record
				$caregivers->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $caregivers->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "caregiversview.php")
						$sReturnUrl = $caregivers->ViewUrl(); // View paging, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$caregivers->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$caregivers->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
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

	// Load default values
	function LoadDefaultValues() {
		global $caregivers;
		$caregivers->first_name->CurrentValue = NULL;
		$caregivers->first_name->OldValue = $caregivers->first_name->CurrentValue;
		$caregivers->last_name->CurrentValue = NULL;
		$caregivers->last_name->OldValue = $caregivers->last_name->CurrentValue;
		$caregivers->day_phone->CurrentValue = NULL;
		$caregivers->day_phone->OldValue = $caregivers->day_phone->CurrentValue;
		$caregivers->other_phone->CurrentValue = NULL;
		$caregivers->other_phone->OldValue = $caregivers->other_phone->CurrentValue;
		$caregivers->zemail->CurrentValue = NULL;
		$caregivers->zemail->OldValue = $caregivers->zemail->CurrentValue;
		$caregivers->address->CurrentValue = NULL;
		$caregivers->address->OldValue = $caregivers->address->CurrentValue;
		$caregivers->apt_num->CurrentValue = NULL;
		$caregivers->apt_num->OldValue = $caregivers->apt_num->CurrentValue;
		$caregivers->city->CurrentValue = NULL;
		$caregivers->city->OldValue = $caregivers->city->CurrentValue;
		$caregivers->county->CurrentValue = NULL;
		$caregivers->county->OldValue = $caregivers->county->CurrentValue;
		$caregivers->zip->CurrentValue = NULL;
		$caregivers->zip->OldValue = $caregivers->zip->CurrentValue;
		$caregivers->num_deps->CurrentValue = NULL;
		$caregivers->num_deps->OldValue = $caregivers->num_deps->CurrentValue;
		$caregivers->annual_income->CurrentValue = NULL;
		$caregivers->annual_income->OldValue = $caregivers->annual_income->CurrentValue;
		$caregivers->app_source->CurrentValue = NULL;
		$caregivers->app_source->OldValue = $caregivers->app_source->CurrentValue;
		$caregivers->dl->CurrentValue = NULL;
		$caregivers->dl->OldValue = $caregivers->dl->CurrentValue;
		$caregivers->app_date->CurrentValue = NULL;
		$caregivers->app_date->OldValue = $caregivers->app_date->CurrentValue;
		$caregivers->Expiration->CurrentValue = NULL;
		$caregivers->Expiration->OldValue = $caregivers->Expiration->CurrentValue;
		$caregivers->ClinicGroup->CurrentValue = NULL;
		$caregivers->ClinicGroup->OldValue = $caregivers->ClinicGroup->CurrentValue;
		$caregivers->DateSent->CurrentValue = NULL;
		$caregivers->DateSent->OldValue = $caregivers->DateSent->CurrentValue;
		$caregivers->budget_category->CurrentValue = NULL;
		$caregivers->budget_category->OldValue = $caregivers->budget_category->CurrentValue;
		$caregivers->AgeOfApplicant->CurrentValue = NULL;
		$caregivers->AgeOfApplicant->OldValue = $caregivers->AgeOfApplicant->CurrentValue;
		$caregivers->Applic->CurrentValue = NULL;
		$caregivers->Applic->OldValue = $caregivers->Applic->CurrentValue;
		$caregivers->SubApplic->CurrentValue = NULL;
		$caregivers->SubApplic->OldValue = $caregivers->SubApplic->CurrentValue;
		$caregivers->DateSigned->CurrentValue = NULL;
		$caregivers->DateSigned->OldValue = $caregivers->DateSigned->CurrentValue;
		$caregivers->colony_id->CurrentValue = NULL;
		$caregivers->colony_id->OldValue = $caregivers->colony_id->CurrentValue;
		$caregivers->mod_by->CurrentValue = NULL;
		$caregivers->mod_by->OldValue = $caregivers->mod_by->CurrentValue;
		$caregivers->mod_date->CurrentValue = NULL;
		$caregivers->mod_date->OldValue = $caregivers->mod_date->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $caregivers;
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
		$this->LoadOldRecord();
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
		} elseif ($caregivers->RowType == EW_ROWTYPE_ADD) { // Add row

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

	// Add record
	function AddRow($rsold = NULL) {
		global $conn, $Language, $Security, $caregivers;
		$rsnew = array();

		// first_name
		$caregivers->first_name->SetDbValueDef($rsnew, $caregivers->first_name->CurrentValue, NULL, FALSE);

		// last_name
		$caregivers->last_name->SetDbValueDef($rsnew, $caregivers->last_name->CurrentValue, NULL, FALSE);

		// day_phone
		$caregivers->day_phone->SetDbValueDef($rsnew, $caregivers->day_phone->CurrentValue, NULL, FALSE);

		// other_phone
		$caregivers->other_phone->SetDbValueDef($rsnew, $caregivers->other_phone->CurrentValue, NULL, FALSE);

		// email
		$caregivers->zemail->SetDbValueDef($rsnew, $caregivers->zemail->CurrentValue, NULL, FALSE);

		// address
		$caregivers->address->SetDbValueDef($rsnew, $caregivers->address->CurrentValue, NULL, FALSE);

		// apt_num
		$caregivers->apt_num->SetDbValueDef($rsnew, $caregivers->apt_num->CurrentValue, NULL, FALSE);

		// city
		$caregivers->city->SetDbValueDef($rsnew, $caregivers->city->CurrentValue, NULL, FALSE);

		// county
		$caregivers->county->SetDbValueDef($rsnew, $caregivers->county->CurrentValue, NULL, FALSE);

		// zip
		$caregivers->zip->SetDbValueDef($rsnew, $caregivers->zip->CurrentValue, NULL, FALSE);

		// num_deps
		$caregivers->num_deps->SetDbValueDef($rsnew, $caregivers->num_deps->CurrentValue, NULL, FALSE);

		// annual_income
		$caregivers->annual_income->SetDbValueDef($rsnew, $caregivers->annual_income->CurrentValue, NULL, FALSE);

		// app_source
		$caregivers->app_source->SetDbValueDef($rsnew, $caregivers->app_source->CurrentValue, NULL, FALSE);

		// dl
		$caregivers->dl->SetDbValueDef($rsnew, $caregivers->dl->CurrentValue, NULL, FALSE);

		// app_date
		$caregivers->app_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($caregivers->app_date->CurrentValue, 5), NULL, FALSE);

		// Expiration
		$caregivers->Expiration->SetDbValueDef($rsnew, ew_UnFormatDateTime($caregivers->Expiration->CurrentValue, 5), NULL, FALSE);

		// ClinicGroup
		$caregivers->ClinicGroup->SetDbValueDef($rsnew, $caregivers->ClinicGroup->CurrentValue, NULL, FALSE);

		// DateSent
		$caregivers->DateSent->SetDbValueDef($rsnew, ew_UnFormatDateTime($caregivers->DateSent->CurrentValue, 5), NULL, FALSE);

		// budget_category
		$caregivers->budget_category->SetDbValueDef($rsnew, $caregivers->budget_category->CurrentValue, 0, FALSE);

		// AgeOfApplicant
		$caregivers->AgeOfApplicant->SetDbValueDef($rsnew, $caregivers->AgeOfApplicant->CurrentValue, 0, FALSE);

		// Applic
		$caregivers->Applic->SetDbValueDef($rsnew, $caregivers->Applic->CurrentValue, NULL, FALSE);

		// SubApplic
		$caregivers->SubApplic->SetDbValueDef($rsnew, $caregivers->SubApplic->CurrentValue, NULL, FALSE);

		// DateSigned
		$caregivers->DateSigned->SetDbValueDef($rsnew, ew_UnFormatDateTime($caregivers->DateSigned->CurrentValue, 5), NULL, FALSE);

		// colony_id
		$caregivers->colony_id->SetDbValueDef($rsnew, $caregivers->colony_id->CurrentValue, 0, FALSE);

		// mod_by
		$caregivers->mod_by->SetDbValueDef($rsnew, $caregivers->mod_by->CurrentValue, NULL, FALSE);

		// mod_date
		$caregivers->mod_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($caregivers->mod_date->CurrentValue, 5), ew_CurrentDate(), FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $caregivers->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $conn->Execute($caregivers->InsertSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($caregivers->CancelMessage <> "") {
				$this->setFailureMessage($caregivers->CancelMessage);
				$caregivers->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}

		// Get insert id if necessary
		if ($AddRow) {
			$caregivers->caregiver_id->setDbValue($conn->Insert_ID());
			$rsnew['caregiver_id'] = $caregivers->caregiver_id->DbValue;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$caregivers->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
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
