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
$vouchers_add = new cvouchers_add();
$Page =& $vouchers_add;

// Page init
$vouchers_add->Page_Init();

// Page main
$vouchers_add->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var vouchers_add = new ew_Page("vouchers_add");

// page properties
vouchers_add.PageID = "add"; // page ID
vouchers_add.FormID = "fvouchersadd"; // form ID
var EW_PAGE_ID = vouchers_add.PageID; // for backward compatibility

// extend page with ValidateForm function
vouchers_add.ValidateForm = function(fobj) {
	ew_PostAutoSuggest(fobj);
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = 1;
	for (i=0; i<rowcnt; i++) {
		infix = "";
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
	}

	// Process detail page
	var detailpage = (fobj.detailpage) ? fobj.detailpage.value : "";
	if (detailpage != "") {
		return eval(detailpage+".ValidateForm(fobj)");
	}
	return true;
}

// extend page with Form_CustomValidate function
vouchers_add.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
vouchers_add.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
vouchers_add.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("Add") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $vouchers->TableCaption() ?></p>
<p class="phpmaker"><a href="<?php echo $vouchers->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $vouchers_add->ShowPageHeader(); ?>
<?php
$vouchers_add->ShowMessage();
?>
<form name="fvouchersadd" id="fvouchersadd" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return vouchers_add.ValidateForm(this);">
<p>
<input type="hidden" name="t" id="t" value="vouchers">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($vouchers->VoucherNumber->Visible) { // VoucherNumber ?>
	<tr id="r_VoucherNumber"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->VoucherNumber->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $vouchers->VoucherNumber->CellAttributes() ?>><span id="el_VoucherNumber">
<input type="text" name="x_VoucherNumber" id="x_VoucherNumber" size="30" value="<?php echo $vouchers->VoucherNumber->EditValue ?>"<?php echo $vouchers->VoucherNumber->EditAttributes() ?>>
</span><?php echo $vouchers->VoucherNumber->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vouchers->ExpireDate->Visible) { // ExpireDate ?>
	<tr id="r_ExpireDate"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->ExpireDate->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $vouchers->ExpireDate->CellAttributes() ?>><span id="el_ExpireDate">
<input type="text" name="x_ExpireDate" id="x_ExpireDate" value="<?php echo $vouchers->ExpireDate->EditValue ?>"<?php echo $vouchers->ExpireDate->EditAttributes() ?>>
</span><?php echo $vouchers->ExpireDate->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vouchers->IssuedByFirst->Visible) { // IssuedByFirst ?>
	<tr id="r_IssuedByFirst"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->IssuedByFirst->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $vouchers->IssuedByFirst->CellAttributes() ?>><span id="el_IssuedByFirst">
<input type="text" name="x_IssuedByFirst" id="x_IssuedByFirst" size="30" maxlength="50" value="<?php echo $vouchers->IssuedByFirst->EditValue ?>"<?php echo $vouchers->IssuedByFirst->EditAttributes() ?>>
</span><?php echo $vouchers->IssuedByFirst->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vouchers->IssuedByLast->Visible) { // IssuedByLast ?>
	<tr id="r_IssuedByLast"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->IssuedByLast->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $vouchers->IssuedByLast->CellAttributes() ?>><span id="el_IssuedByLast">
<input type="text" name="x_IssuedByLast" id="x_IssuedByLast" size="30" maxlength="50" value="<?php echo $vouchers->IssuedByLast->EditValue ?>"<?php echo $vouchers->IssuedByLast->EditAttributes() ?>>
</span><?php echo $vouchers->IssuedByLast->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vouchers->FirstName->Visible) { // FirstName ?>
	<tr id="r_FirstName"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->FirstName->FldCaption() ?></td>
		<td<?php echo $vouchers->FirstName->CellAttributes() ?>><span id="el_FirstName">
<input type="text" name="x_FirstName" id="x_FirstName" size="30" maxlength="50" value="<?php echo $vouchers->FirstName->EditValue ?>"<?php echo $vouchers->FirstName->EditAttributes() ?>>
</span><?php echo $vouchers->FirstName->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vouchers->LastName->Visible) { // LastName ?>
	<tr id="r_LastName"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->LastName->FldCaption() ?></td>
		<td<?php echo $vouchers->LastName->CellAttributes() ?>><span id="el_LastName">
<input type="text" name="x_LastName" id="x_LastName" size="30" maxlength="50" value="<?php echo $vouchers->LastName->EditValue ?>"<?php echo $vouchers->LastName->EditAttributes() ?>>
</span><?php echo $vouchers->LastName->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vouchers->Program->Visible) { // Program ?>
	<tr id="r_Program"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->Program->FldCaption() ?></td>
		<td<?php echo $vouchers->Program->CellAttributes() ?>><span id="el_Program">
<input type="text" name="x_Program" id="x_Program" size="30" maxlength="50" value="<?php echo $vouchers->Program->EditValue ?>"<?php echo $vouchers->Program->EditAttributes() ?>>
</span><?php echo $vouchers->Program->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vouchers->cat_name->Visible) { // cat_name ?>
	<tr id="r_cat_name"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->cat_name->FldCaption() ?></td>
		<td<?php echo $vouchers->cat_name->CellAttributes() ?>><span id="el_cat_name">
<input type="text" name="x_cat_name" id="x_cat_name" size="30" maxlength="20" value="<?php echo $vouchers->cat_name->EditValue ?>"<?php echo $vouchers->cat_name->EditAttributes() ?>>
</span><?php echo $vouchers->cat_name->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vouchers->cat_breed->Visible) { // cat_breed ?>
	<tr id="r_cat_breed"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->cat_breed->FldCaption() ?></td>
		<td<?php echo $vouchers->cat_breed->CellAttributes() ?>><span id="el_cat_breed">
<input type="text" name="x_cat_breed" id="x_cat_breed" size="30" maxlength="20" value="<?php echo $vouchers->cat_breed->EditValue ?>"<?php echo $vouchers->cat_breed->EditAttributes() ?>>
</span><?php echo $vouchers->cat_breed->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vouchers->cat_age->Visible) { // cat_age ?>
	<tr id="r_cat_age"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->cat_age->FldCaption() ?></td>
		<td<?php echo $vouchers->cat_age->CellAttributes() ?>><span id="el_cat_age">
<input type="text" name="x_cat_age" id="x_cat_age" size="30" value="<?php echo $vouchers->cat_age->EditValue ?>"<?php echo $vouchers->cat_age->EditAttributes() ?>>
</span><?php echo $vouchers->cat_age->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vouchers->copay->Visible) { // copay ?>
	<tr id="r_copay"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->copay->FldCaption() ?></td>
		<td<?php echo $vouchers->copay->CellAttributes() ?>><span id="el_copay">
<input type="text" name="x_copay" id="x_copay" size="30" value="<?php echo $vouchers->copay->EditValue ?>"<?php echo $vouchers->copay->EditAttributes() ?>>
</span><?php echo $vouchers->copay->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vouchers->cat_status->Visible) { // cat_status ?>
	<tr id="r_cat_status"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->cat_status->FldCaption() ?></td>
		<td<?php echo $vouchers->cat_status->CellAttributes() ?>><span id="el_cat_status">
<input type="text" name="x_cat_status" id="x_cat_status" size="30" maxlength="1" value="<?php echo $vouchers->cat_status->EditValue ?>"<?php echo $vouchers->cat_status->EditAttributes() ?>>
</span><?php echo $vouchers->cat_status->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vouchers->date_redeemed->Visible) { // date_redeemed ?>
	<tr id="r_date_redeemed"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->date_redeemed->FldCaption() ?></td>
		<td<?php echo $vouchers->date_redeemed->CellAttributes() ?>><span id="el_date_redeemed">
<input type="text" name="x_date_redeemed" id="x_date_redeemed" value="<?php echo $vouchers->date_redeemed->EditValue ?>"<?php echo $vouchers->date_redeemed->EditAttributes() ?>>
</span><?php echo $vouchers->date_redeemed->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vouchers->Clinic->Visible) { // Clinic ?>
	<tr id="r_Clinic"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->Clinic->FldCaption() ?></td>
		<td<?php echo $vouchers->Clinic->CellAttributes() ?>><span id="el_Clinic">
<input type="text" name="x_Clinic" id="x_Clinic" size="30" maxlength="50" value="<?php echo $vouchers->Clinic->EditValue ?>"<?php echo $vouchers->Clinic->EditAttributes() ?>>
</span><?php echo $vouchers->Clinic->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vouchers->ClinicPrice->Visible) { // ClinicPrice ?>
	<tr id="r_ClinicPrice"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->ClinicPrice->FldCaption() ?></td>
		<td<?php echo $vouchers->ClinicPrice->CellAttributes() ?>><span id="el_ClinicPrice">
<input type="text" name="x_ClinicPrice" id="x_ClinicPrice" size="30" value="<?php echo $vouchers->ClinicPrice->EditValue ?>"<?php echo $vouchers->ClinicPrice->EditAttributes() ?>>
</span><?php echo $vouchers->ClinicPrice->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vouchers->vet_used->Visible) { // vet_used ?>
	<tr id="r_vet_used"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->vet_used->FldCaption() ?></td>
		<td<?php echo $vouchers->vet_used->CellAttributes() ?>><span id="el_vet_used">
<input type="text" name="x_vet_used" id="x_vet_used" size="30" maxlength="35" value="<?php echo $vouchers->vet_used->EditValue ?>"<?php echo $vouchers->vet_used->EditAttributes() ?>>
</span><?php echo $vouchers->vet_used->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vouchers->colony_id->Visible) { // colony_id ?>
	<tr id="r_colony_id"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->colony_id->FldCaption() ?></td>
		<td<?php echo $vouchers->colony_id->CellAttributes() ?>><span id="el_colony_id">
<?php if ($vouchers->colony_id->getSessionValue() <> "") { ?>
<div<?php echo $vouchers->colony_id->ViewAttributes() ?>><?php echo $vouchers->colony_id->ViewValue ?></div>
<input type="hidden" id="x_colony_id" name="x_colony_id" value="<?php echo ew_HtmlEncode($vouchers->colony_id->CurrentValue) ?>">
<?php } else { ?>
<input type="text" name="x_colony_id" id="x_colony_id" size="30" value="<?php echo $vouchers->colony_id->EditValue ?>"<?php echo $vouchers->colony_id->EditAttributes() ?>>
<?php } ?>
</span><?php echo $vouchers->colony_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vouchers->Spay->Visible) { // Spay ?>
	<tr id="r_Spay"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->Spay->FldCaption() ?></td>
		<td<?php echo $vouchers->Spay->CellAttributes() ?>><span id="el_Spay">
<input type="text" name="x_Spay" id="x_Spay" size="30" maxlength="1" value="<?php echo $vouchers->Spay->EditValue ?>"<?php echo $vouchers->Spay->EditAttributes() ?>>
</span><?php echo $vouchers->Spay->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vouchers->Neuter->Visible) { // Neuter ?>
	<tr id="r_Neuter"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->Neuter->FldCaption() ?></td>
		<td<?php echo $vouchers->Neuter->CellAttributes() ?>><span id="el_Neuter">
<input type="text" name="x_Neuter" id="x_Neuter" size="30" maxlength="1" value="<?php echo $vouchers->Neuter->EditValue ?>"<?php echo $vouchers->Neuter->EditAttributes() ?>>
</span><?php echo $vouchers->Neuter->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vouchers->FVRCP->Visible) { // FVRCP ?>
	<tr id="r_FVRCP"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->FVRCP->FldCaption() ?></td>
		<td<?php echo $vouchers->FVRCP->CellAttributes() ?>><span id="el_FVRCP">
<input type="text" name="x_FVRCP" id="x_FVRCP" size="30" maxlength="1" value="<?php echo $vouchers->FVRCP->EditValue ?>"<?php echo $vouchers->FVRCP->EditAttributes() ?>>
</span><?php echo $vouchers->FVRCP->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vouchers->FELV->Visible) { // FELV ?>
	<tr id="r_FELV"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->FELV->FldCaption() ?></td>
		<td<?php echo $vouchers->FELV->CellAttributes() ?>><span id="el_FELV">
<input type="text" name="x_FELV" id="x_FELV" size="30" maxlength="1" value="<?php echo $vouchers->FELV->EditValue ?>"<?php echo $vouchers->FELV->EditAttributes() ?>>
</span><?php echo $vouchers->FELV->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vouchers->Rabies->Visible) { // Rabies ?>
	<tr id="r_Rabies"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->Rabies->FldCaption() ?></td>
		<td<?php echo $vouchers->Rabies->CellAttributes() ?>><span id="el_Rabies">
<input type="text" name="x_Rabies" id="x_Rabies" size="30" maxlength="1" value="<?php echo $vouchers->Rabies->EditValue ?>"<?php echo $vouchers->Rabies->EditAttributes() ?>>
</span><?php echo $vouchers->Rabies->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vouchers->Pregnant->Visible) { // Pregnant ?>
	<tr id="r_Pregnant"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->Pregnant->FldCaption() ?></td>
		<td<?php echo $vouchers->Pregnant->CellAttributes() ?>><span id="el_Pregnant">
<input type="text" name="x_Pregnant" id="x_Pregnant" size="30" maxlength="1" value="<?php echo $vouchers->Pregnant->EditValue ?>"<?php echo $vouchers->Pregnant->EditAttributes() ?>>
</span><?php echo $vouchers->Pregnant->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vouchers->AssignedTo->Visible) { // AssignedTo ?>
	<tr id="r_AssignedTo"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->AssignedTo->FldCaption() ?></td>
		<td<?php echo $vouchers->AssignedTo->CellAttributes() ?>><span id="el_AssignedTo">
<input type="text" name="x_AssignedTo" id="x_AssignedTo" size="30" maxlength="50" value="<?php echo $vouchers->AssignedTo->EditValue ?>"<?php echo $vouchers->AssignedTo->EditAttributes() ?>>
</span><?php echo $vouchers->AssignedTo->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vouchers->mod_by->Visible) { // mod_by ?>
	<tr id="r_mod_by"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->mod_by->FldCaption() ?></td>
		<td<?php echo $vouchers->mod_by->CellAttributes() ?>><span id="el_mod_by">
<input type="text" name="x_mod_by" id="x_mod_by" size="30" maxlength="20" value="<?php echo $vouchers->mod_by->EditValue ?>"<?php echo $vouchers->mod_by->EditAttributes() ?>>
</span><?php echo $vouchers->mod_by->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($vouchers->mod_date->Visible) { // mod_date ?>
	<tr id="r_mod_date"<?php echo $vouchers->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $vouchers->mod_date->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $vouchers->mod_date->CellAttributes() ?>><span id="el_mod_date">
<input type="text" name="x_mod_date" id="x_mod_date" value="<?php echo $vouchers->mod_date->EditValue ?>"<?php echo $vouchers->mod_date->EditAttributes() ?>>
</span><?php echo $vouchers->mod_date->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("AddBtn")) ?>">
</form>
<?php
$vouchers_add->ShowPageFooter();
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
$vouchers_add->Page_Terminate();
?>
<?php

//
// Page class
//
class cvouchers_add {

	// Page ID
	var $PageID = 'add';

	// Table name
	var $TableName = 'vouchers';

	// Page object name
	var $PageObjName = 'vouchers_add';

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
	function cvouchers_add() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (vouchers)
		if (!isset($GLOBALS["vouchers"])) {
			$GLOBALS["vouchers"] = new cvouchers();
			$GLOBALS["Table"] =& $GLOBALS["vouchers"];
		}

		// Table object (colonies)
		if (!isset($GLOBALS['colonies'])) $GLOBALS['colonies'] = new ccolonies();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'vouchers', TRUE);

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
		global $vouchers;

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
		global $objForm, $Language, $gsFormError, $vouchers;

		// Set up master/detail parameters
		$this->SetUpMasterParms();

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$vouchers->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values

			// Validate form
			if (!$this->ValidateForm()) {
				$vouchers->CurrentAction = "I"; // Form error, reset action
				$vouchers->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["id"] != "") {
				$vouchers->id->setQueryStringValue($_GET["id"]);
				$vouchers->setKey("id", $vouchers->id->CurrentValue); // Set up key
			} else {
				$vouchers->setKey("id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$vouchers->CurrentAction = "C"; // Copy record
			} else {
				$vouchers->CurrentAction = "I"; // Display blank record
				$this->LoadDefaultValues(); // Load default values
			}
		}

		// Perform action based on action code
		switch ($vouchers->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("voucherslist.php"); // No matching record, return to list
				}
				break;
			case "A": // ' Add new record
				$vouchers->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $vouchers->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "vouchersview.php")
						$sReturnUrl = $vouchers->ViewUrl(); // View paging, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$vouchers->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$vouchers->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
		$vouchers->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $vouchers;

		// Get upload data
		$index = $objForm->Index; // Save form index
		$objForm->Index = 0;
		$confirmPage = (strval($objForm->GetValue("a_confirm")) <> "");
		$objForm->Index = $index; // Restore form index
	}

	// Load default values
	function LoadDefaultValues() {
		global $vouchers;
		$vouchers->VoucherNumber->CurrentValue = NULL;
		$vouchers->VoucherNumber->OldValue = $vouchers->VoucherNumber->CurrentValue;
		$vouchers->ExpireDate->CurrentValue = NULL;
		$vouchers->ExpireDate->OldValue = $vouchers->ExpireDate->CurrentValue;
		$vouchers->IssuedByFirst->CurrentValue = NULL;
		$vouchers->IssuedByFirst->OldValue = $vouchers->IssuedByFirst->CurrentValue;
		$vouchers->IssuedByLast->CurrentValue = NULL;
		$vouchers->IssuedByLast->OldValue = $vouchers->IssuedByLast->CurrentValue;
		$vouchers->FirstName->CurrentValue = NULL;
		$vouchers->FirstName->OldValue = $vouchers->FirstName->CurrentValue;
		$vouchers->LastName->CurrentValue = NULL;
		$vouchers->LastName->OldValue = $vouchers->LastName->CurrentValue;
		$vouchers->Program->CurrentValue = NULL;
		$vouchers->Program->OldValue = $vouchers->Program->CurrentValue;
		$vouchers->cat_name->CurrentValue = NULL;
		$vouchers->cat_name->OldValue = $vouchers->cat_name->CurrentValue;
		$vouchers->cat_breed->CurrentValue = NULL;
		$vouchers->cat_breed->OldValue = $vouchers->cat_breed->CurrentValue;
		$vouchers->cat_age->CurrentValue = NULL;
		$vouchers->cat_age->OldValue = $vouchers->cat_age->CurrentValue;
		$vouchers->copay->CurrentValue = NULL;
		$vouchers->copay->OldValue = $vouchers->copay->CurrentValue;
		$vouchers->cat_status->CurrentValue = NULL;
		$vouchers->cat_status->OldValue = $vouchers->cat_status->CurrentValue;
		$vouchers->date_redeemed->CurrentValue = NULL;
		$vouchers->date_redeemed->OldValue = $vouchers->date_redeemed->CurrentValue;
		$vouchers->Clinic->CurrentValue = NULL;
		$vouchers->Clinic->OldValue = $vouchers->Clinic->CurrentValue;
		$vouchers->ClinicPrice->CurrentValue = NULL;
		$vouchers->ClinicPrice->OldValue = $vouchers->ClinicPrice->CurrentValue;
		$vouchers->vet_used->CurrentValue = NULL;
		$vouchers->vet_used->OldValue = $vouchers->vet_used->CurrentValue;
		$vouchers->colony_id->CurrentValue = NULL;
		$vouchers->colony_id->OldValue = $vouchers->colony_id->CurrentValue;
		$vouchers->Spay->CurrentValue = NULL;
		$vouchers->Spay->OldValue = $vouchers->Spay->CurrentValue;
		$vouchers->Neuter->CurrentValue = NULL;
		$vouchers->Neuter->OldValue = $vouchers->Neuter->CurrentValue;
		$vouchers->FVRCP->CurrentValue = NULL;
		$vouchers->FVRCP->OldValue = $vouchers->FVRCP->CurrentValue;
		$vouchers->FELV->CurrentValue = NULL;
		$vouchers->FELV->OldValue = $vouchers->FELV->CurrentValue;
		$vouchers->Rabies->CurrentValue = NULL;
		$vouchers->Rabies->OldValue = $vouchers->Rabies->CurrentValue;
		$vouchers->Pregnant->CurrentValue = NULL;
		$vouchers->Pregnant->OldValue = $vouchers->Pregnant->CurrentValue;
		$vouchers->AssignedTo->CurrentValue = NULL;
		$vouchers->AssignedTo->OldValue = $vouchers->AssignedTo->CurrentValue;
		$vouchers->mod_by->CurrentValue = NULL;
		$vouchers->mod_by->OldValue = $vouchers->mod_by->CurrentValue;
		$vouchers->mod_date->CurrentValue = NULL;
		$vouchers->mod_date->OldValue = $vouchers->mod_date->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $vouchers;
		if (!$vouchers->VoucherNumber->FldIsDetailKey) {
			$vouchers->VoucherNumber->setFormValue($objForm->GetValue("x_VoucherNumber"));
		}
		if (!$vouchers->ExpireDate->FldIsDetailKey) {
			$vouchers->ExpireDate->setFormValue($objForm->GetValue("x_ExpireDate"));
			$vouchers->ExpireDate->CurrentValue = ew_UnFormatDateTime($vouchers->ExpireDate->CurrentValue, 5);
		}
		if (!$vouchers->IssuedByFirst->FldIsDetailKey) {
			$vouchers->IssuedByFirst->setFormValue($objForm->GetValue("x_IssuedByFirst"));
		}
		if (!$vouchers->IssuedByLast->FldIsDetailKey) {
			$vouchers->IssuedByLast->setFormValue($objForm->GetValue("x_IssuedByLast"));
		}
		if (!$vouchers->FirstName->FldIsDetailKey) {
			$vouchers->FirstName->setFormValue($objForm->GetValue("x_FirstName"));
		}
		if (!$vouchers->LastName->FldIsDetailKey) {
			$vouchers->LastName->setFormValue($objForm->GetValue("x_LastName"));
		}
		if (!$vouchers->Program->FldIsDetailKey) {
			$vouchers->Program->setFormValue($objForm->GetValue("x_Program"));
		}
		if (!$vouchers->cat_name->FldIsDetailKey) {
			$vouchers->cat_name->setFormValue($objForm->GetValue("x_cat_name"));
		}
		if (!$vouchers->cat_breed->FldIsDetailKey) {
			$vouchers->cat_breed->setFormValue($objForm->GetValue("x_cat_breed"));
		}
		if (!$vouchers->cat_age->FldIsDetailKey) {
			$vouchers->cat_age->setFormValue($objForm->GetValue("x_cat_age"));
		}
		if (!$vouchers->copay->FldIsDetailKey) {
			$vouchers->copay->setFormValue($objForm->GetValue("x_copay"));
		}
		if (!$vouchers->cat_status->FldIsDetailKey) {
			$vouchers->cat_status->setFormValue($objForm->GetValue("x_cat_status"));
		}
		if (!$vouchers->date_redeemed->FldIsDetailKey) {
			$vouchers->date_redeemed->setFormValue($objForm->GetValue("x_date_redeemed"));
			$vouchers->date_redeemed->CurrentValue = ew_UnFormatDateTime($vouchers->date_redeemed->CurrentValue, 5);
		}
		if (!$vouchers->Clinic->FldIsDetailKey) {
			$vouchers->Clinic->setFormValue($objForm->GetValue("x_Clinic"));
		}
		if (!$vouchers->ClinicPrice->FldIsDetailKey) {
			$vouchers->ClinicPrice->setFormValue($objForm->GetValue("x_ClinicPrice"));
		}
		if (!$vouchers->vet_used->FldIsDetailKey) {
			$vouchers->vet_used->setFormValue($objForm->GetValue("x_vet_used"));
		}
		if (!$vouchers->colony_id->FldIsDetailKey) {
			$vouchers->colony_id->setFormValue($objForm->GetValue("x_colony_id"));
		}
		if (!$vouchers->Spay->FldIsDetailKey) {
			$vouchers->Spay->setFormValue($objForm->GetValue("x_Spay"));
		}
		if (!$vouchers->Neuter->FldIsDetailKey) {
			$vouchers->Neuter->setFormValue($objForm->GetValue("x_Neuter"));
		}
		if (!$vouchers->FVRCP->FldIsDetailKey) {
			$vouchers->FVRCP->setFormValue($objForm->GetValue("x_FVRCP"));
		}
		if (!$vouchers->FELV->FldIsDetailKey) {
			$vouchers->FELV->setFormValue($objForm->GetValue("x_FELV"));
		}
		if (!$vouchers->Rabies->FldIsDetailKey) {
			$vouchers->Rabies->setFormValue($objForm->GetValue("x_Rabies"));
		}
		if (!$vouchers->Pregnant->FldIsDetailKey) {
			$vouchers->Pregnant->setFormValue($objForm->GetValue("x_Pregnant"));
		}
		if (!$vouchers->AssignedTo->FldIsDetailKey) {
			$vouchers->AssignedTo->setFormValue($objForm->GetValue("x_AssignedTo"));
		}
		if (!$vouchers->mod_by->FldIsDetailKey) {
			$vouchers->mod_by->setFormValue($objForm->GetValue("x_mod_by"));
		}
		if (!$vouchers->mod_date->FldIsDetailKey) {
			$vouchers->mod_date->setFormValue($objForm->GetValue("x_mod_date"));
			$vouchers->mod_date->CurrentValue = ew_UnFormatDateTime($vouchers->mod_date->CurrentValue, 5);
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $vouchers;
		$this->LoadOldRecord();
		$vouchers->VoucherNumber->CurrentValue = $vouchers->VoucherNumber->FormValue;
		$vouchers->ExpireDate->CurrentValue = $vouchers->ExpireDate->FormValue;
		$vouchers->ExpireDate->CurrentValue = ew_UnFormatDateTime($vouchers->ExpireDate->CurrentValue, 5);
		$vouchers->IssuedByFirst->CurrentValue = $vouchers->IssuedByFirst->FormValue;
		$vouchers->IssuedByLast->CurrentValue = $vouchers->IssuedByLast->FormValue;
		$vouchers->FirstName->CurrentValue = $vouchers->FirstName->FormValue;
		$vouchers->LastName->CurrentValue = $vouchers->LastName->FormValue;
		$vouchers->Program->CurrentValue = $vouchers->Program->FormValue;
		$vouchers->cat_name->CurrentValue = $vouchers->cat_name->FormValue;
		$vouchers->cat_breed->CurrentValue = $vouchers->cat_breed->FormValue;
		$vouchers->cat_age->CurrentValue = $vouchers->cat_age->FormValue;
		$vouchers->copay->CurrentValue = $vouchers->copay->FormValue;
		$vouchers->cat_status->CurrentValue = $vouchers->cat_status->FormValue;
		$vouchers->date_redeemed->CurrentValue = $vouchers->date_redeemed->FormValue;
		$vouchers->date_redeemed->CurrentValue = ew_UnFormatDateTime($vouchers->date_redeemed->CurrentValue, 5);
		$vouchers->Clinic->CurrentValue = $vouchers->Clinic->FormValue;
		$vouchers->ClinicPrice->CurrentValue = $vouchers->ClinicPrice->FormValue;
		$vouchers->vet_used->CurrentValue = $vouchers->vet_used->FormValue;
		$vouchers->colony_id->CurrentValue = $vouchers->colony_id->FormValue;
		$vouchers->Spay->CurrentValue = $vouchers->Spay->FormValue;
		$vouchers->Neuter->CurrentValue = $vouchers->Neuter->FormValue;
		$vouchers->FVRCP->CurrentValue = $vouchers->FVRCP->FormValue;
		$vouchers->FELV->CurrentValue = $vouchers->FELV->FormValue;
		$vouchers->Rabies->CurrentValue = $vouchers->Rabies->FormValue;
		$vouchers->Pregnant->CurrentValue = $vouchers->Pregnant->FormValue;
		$vouchers->AssignedTo->CurrentValue = $vouchers->AssignedTo->FormValue;
		$vouchers->mod_by->CurrentValue = $vouchers->mod_by->FormValue;
		$vouchers->mod_date->CurrentValue = $vouchers->mod_date->FormValue;
		$vouchers->mod_date->CurrentValue = ew_UnFormatDateTime($vouchers->mod_date->CurrentValue, 5);
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
		} elseif ($vouchers->RowType == EW_ROWTYPE_ADD) { // Add row

			// VoucherNumber
			$vouchers->VoucherNumber->EditCustomAttributes = "";
			$vouchers->VoucherNumber->EditValue = ew_HtmlEncode($vouchers->VoucherNumber->CurrentValue);

			// ExpireDate
			$vouchers->ExpireDate->EditCustomAttributes = "";
			$vouchers->ExpireDate->EditValue = ew_HtmlEncode(ew_FormatDateTime($vouchers->ExpireDate->CurrentValue, 5));

			// IssuedByFirst
			$vouchers->IssuedByFirst->EditCustomAttributes = "";
			$vouchers->IssuedByFirst->EditValue = ew_HtmlEncode($vouchers->IssuedByFirst->CurrentValue);

			// IssuedByLast
			$vouchers->IssuedByLast->EditCustomAttributes = "";
			$vouchers->IssuedByLast->EditValue = ew_HtmlEncode($vouchers->IssuedByLast->CurrentValue);

			// FirstName
			$vouchers->FirstName->EditCustomAttributes = "";
			$vouchers->FirstName->EditValue = ew_HtmlEncode($vouchers->FirstName->CurrentValue);

			// LastName
			$vouchers->LastName->EditCustomAttributes = "";
			$vouchers->LastName->EditValue = ew_HtmlEncode($vouchers->LastName->CurrentValue);

			// Program
			$vouchers->Program->EditCustomAttributes = "";
			$vouchers->Program->EditValue = ew_HtmlEncode($vouchers->Program->CurrentValue);

			// cat_name
			$vouchers->cat_name->EditCustomAttributes = "";
			$vouchers->cat_name->EditValue = ew_HtmlEncode($vouchers->cat_name->CurrentValue);

			// cat_breed
			$vouchers->cat_breed->EditCustomAttributes = "";
			$vouchers->cat_breed->EditValue = ew_HtmlEncode($vouchers->cat_breed->CurrentValue);

			// cat_age
			$vouchers->cat_age->EditCustomAttributes = "";
			$vouchers->cat_age->EditValue = ew_HtmlEncode($vouchers->cat_age->CurrentValue);

			// copay
			$vouchers->copay->EditCustomAttributes = "";
			$vouchers->copay->EditValue = ew_HtmlEncode($vouchers->copay->CurrentValue);

			// cat_status
			$vouchers->cat_status->EditCustomAttributes = "";
			$vouchers->cat_status->EditValue = ew_HtmlEncode($vouchers->cat_status->CurrentValue);

			// date_redeemed
			$vouchers->date_redeemed->EditCustomAttributes = "";
			$vouchers->date_redeemed->EditValue = ew_HtmlEncode(ew_FormatDateTime($vouchers->date_redeemed->CurrentValue, 5));

			// Clinic
			$vouchers->Clinic->EditCustomAttributes = "";
			$vouchers->Clinic->EditValue = ew_HtmlEncode($vouchers->Clinic->CurrentValue);

			// ClinicPrice
			$vouchers->ClinicPrice->EditCustomAttributes = "";
			$vouchers->ClinicPrice->EditValue = ew_HtmlEncode($vouchers->ClinicPrice->CurrentValue);

			// vet_used
			$vouchers->vet_used->EditCustomAttributes = "";
			$vouchers->vet_used->EditValue = ew_HtmlEncode($vouchers->vet_used->CurrentValue);

			// colony_id
			$vouchers->colony_id->EditCustomAttributes = "";
			if ($vouchers->colony_id->getSessionValue() <> "") {
				$vouchers->colony_id->CurrentValue = $vouchers->colony_id->getSessionValue();
			$vouchers->colony_id->ViewValue = $vouchers->colony_id->CurrentValue;
			$vouchers->colony_id->ViewCustomAttributes = "";
			} else {
			$vouchers->colony_id->EditValue = ew_HtmlEncode($vouchers->colony_id->CurrentValue);
			}

			// Spay
			$vouchers->Spay->EditCustomAttributes = "";
			$vouchers->Spay->EditValue = ew_HtmlEncode($vouchers->Spay->CurrentValue);

			// Neuter
			$vouchers->Neuter->EditCustomAttributes = "";
			$vouchers->Neuter->EditValue = ew_HtmlEncode($vouchers->Neuter->CurrentValue);

			// FVRCP
			$vouchers->FVRCP->EditCustomAttributes = "";
			$vouchers->FVRCP->EditValue = ew_HtmlEncode($vouchers->FVRCP->CurrentValue);

			// FELV
			$vouchers->FELV->EditCustomAttributes = "";
			$vouchers->FELV->EditValue = ew_HtmlEncode($vouchers->FELV->CurrentValue);

			// Rabies
			$vouchers->Rabies->EditCustomAttributes = "";
			$vouchers->Rabies->EditValue = ew_HtmlEncode($vouchers->Rabies->CurrentValue);

			// Pregnant
			$vouchers->Pregnant->EditCustomAttributes = "";
			$vouchers->Pregnant->EditValue = ew_HtmlEncode($vouchers->Pregnant->CurrentValue);

			// AssignedTo
			$vouchers->AssignedTo->EditCustomAttributes = "";
			$vouchers->AssignedTo->EditValue = ew_HtmlEncode($vouchers->AssignedTo->CurrentValue);

			// mod_by
			$vouchers->mod_by->EditCustomAttributes = "";
			$vouchers->mod_by->EditValue = ew_HtmlEncode($vouchers->mod_by->CurrentValue);

			// mod_date
			$vouchers->mod_date->EditCustomAttributes = "";
			$vouchers->mod_date->EditValue = ew_HtmlEncode(ew_FormatDateTime($vouchers->mod_date->CurrentValue, 5));

			// Edit refer script
			// VoucherNumber

			$vouchers->VoucherNumber->HrefValue = "";

			// ExpireDate
			$vouchers->ExpireDate->HrefValue = "";

			// IssuedByFirst
			$vouchers->IssuedByFirst->HrefValue = "";

			// IssuedByLast
			$vouchers->IssuedByLast->HrefValue = "";

			// FirstName
			$vouchers->FirstName->HrefValue = "";

			// LastName
			$vouchers->LastName->HrefValue = "";

			// Program
			$vouchers->Program->HrefValue = "";

			// cat_name
			$vouchers->cat_name->HrefValue = "";

			// cat_breed
			$vouchers->cat_breed->HrefValue = "";

			// cat_age
			$vouchers->cat_age->HrefValue = "";

			// copay
			$vouchers->copay->HrefValue = "";

			// cat_status
			$vouchers->cat_status->HrefValue = "";

			// date_redeemed
			$vouchers->date_redeemed->HrefValue = "";

			// Clinic
			$vouchers->Clinic->HrefValue = "";

			// ClinicPrice
			$vouchers->ClinicPrice->HrefValue = "";

			// vet_used
			$vouchers->vet_used->HrefValue = "";

			// colony_id
			$vouchers->colony_id->HrefValue = "";

			// Spay
			$vouchers->Spay->HrefValue = "";

			// Neuter
			$vouchers->Neuter->HrefValue = "";

			// FVRCP
			$vouchers->FVRCP->HrefValue = "";

			// FELV
			$vouchers->FELV->HrefValue = "";

			// Rabies
			$vouchers->Rabies->HrefValue = "";

			// Pregnant
			$vouchers->Pregnant->HrefValue = "";

			// AssignedTo
			$vouchers->AssignedTo->HrefValue = "";

			// mod_by
			$vouchers->mod_by->HrefValue = "";

			// mod_date
			$vouchers->mod_date->HrefValue = "";
		}
		if ($vouchers->RowType == EW_ROWTYPE_ADD ||
			$vouchers->RowType == EW_ROWTYPE_EDIT ||
			$vouchers->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$vouchers->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($vouchers->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$vouchers->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError, $vouchers;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!is_null($vouchers->VoucherNumber->FormValue) && $vouchers->VoucherNumber->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $vouchers->VoucherNumber->FldCaption());
		}
		if (!ew_CheckInteger($vouchers->VoucherNumber->FormValue)) {
			ew_AddMessage($gsFormError, $vouchers->VoucherNumber->FldErrMsg());
		}
		if (!is_null($vouchers->ExpireDate->FormValue) && $vouchers->ExpireDate->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $vouchers->ExpireDate->FldCaption());
		}
		if (!ew_CheckDate($vouchers->ExpireDate->FormValue)) {
			ew_AddMessage($gsFormError, $vouchers->ExpireDate->FldErrMsg());
		}
		if (!is_null($vouchers->IssuedByFirst->FormValue) && $vouchers->IssuedByFirst->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $vouchers->IssuedByFirst->FldCaption());
		}
		if (!is_null($vouchers->IssuedByLast->FormValue) && $vouchers->IssuedByLast->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $vouchers->IssuedByLast->FldCaption());
		}
		if (!ew_CheckInteger($vouchers->cat_age->FormValue)) {
			ew_AddMessage($gsFormError, $vouchers->cat_age->FldErrMsg());
		}
		if (!ew_CheckInteger($vouchers->copay->FormValue)) {
			ew_AddMessage($gsFormError, $vouchers->copay->FldErrMsg());
		}
		if (!ew_CheckDate($vouchers->date_redeemed->FormValue)) {
			ew_AddMessage($gsFormError, $vouchers->date_redeemed->FldErrMsg());
		}
		if (!ew_CheckInteger($vouchers->ClinicPrice->FormValue)) {
			ew_AddMessage($gsFormError, $vouchers->ClinicPrice->FldErrMsg());
		}
		if (!ew_CheckInteger($vouchers->colony_id->FormValue)) {
			ew_AddMessage($gsFormError, $vouchers->colony_id->FldErrMsg());
		}
		if (!is_null($vouchers->mod_date->FormValue) && $vouchers->mod_date->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $vouchers->mod_date->FldCaption());
		}
		if (!ew_CheckDate($vouchers->mod_date->FormValue)) {
			ew_AddMessage($gsFormError, $vouchers->mod_date->FldErrMsg());
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
		global $conn, $Language, $Security, $vouchers;
		$rsnew = array();

		// VoucherNumber
		$vouchers->VoucherNumber->SetDbValueDef($rsnew, $vouchers->VoucherNumber->CurrentValue, 0, FALSE);

		// ExpireDate
		$vouchers->ExpireDate->SetDbValueDef($rsnew, ew_UnFormatDateTime($vouchers->ExpireDate->CurrentValue, 5), ew_CurrentDate(), FALSE);

		// IssuedByFirst
		$vouchers->IssuedByFirst->SetDbValueDef($rsnew, $vouchers->IssuedByFirst->CurrentValue, "", FALSE);

		// IssuedByLast
		$vouchers->IssuedByLast->SetDbValueDef($rsnew, $vouchers->IssuedByLast->CurrentValue, "", FALSE);

		// FirstName
		$vouchers->FirstName->SetDbValueDef($rsnew, $vouchers->FirstName->CurrentValue, NULL, FALSE);

		// LastName
		$vouchers->LastName->SetDbValueDef($rsnew, $vouchers->LastName->CurrentValue, NULL, FALSE);

		// Program
		$vouchers->Program->SetDbValueDef($rsnew, $vouchers->Program->CurrentValue, NULL, FALSE);

		// cat_name
		$vouchers->cat_name->SetDbValueDef($rsnew, $vouchers->cat_name->CurrentValue, NULL, FALSE);

		// cat_breed
		$vouchers->cat_breed->SetDbValueDef($rsnew, $vouchers->cat_breed->CurrentValue, NULL, FALSE);

		// cat_age
		$vouchers->cat_age->SetDbValueDef($rsnew, $vouchers->cat_age->CurrentValue, NULL, FALSE);

		// copay
		$vouchers->copay->SetDbValueDef($rsnew, $vouchers->copay->CurrentValue, NULL, FALSE);

		// cat_status
		$vouchers->cat_status->SetDbValueDef($rsnew, $vouchers->cat_status->CurrentValue, NULL, FALSE);

		// date_redeemed
		$vouchers->date_redeemed->SetDbValueDef($rsnew, ew_UnFormatDateTime($vouchers->date_redeemed->CurrentValue, 5), NULL, FALSE);

		// Clinic
		$vouchers->Clinic->SetDbValueDef($rsnew, $vouchers->Clinic->CurrentValue, NULL, FALSE);

		// ClinicPrice
		$vouchers->ClinicPrice->SetDbValueDef($rsnew, $vouchers->ClinicPrice->CurrentValue, NULL, FALSE);

		// vet_used
		$vouchers->vet_used->SetDbValueDef($rsnew, $vouchers->vet_used->CurrentValue, NULL, FALSE);

		// colony_id
		$vouchers->colony_id->SetDbValueDef($rsnew, $vouchers->colony_id->CurrentValue, NULL, FALSE);

		// Spay
		$vouchers->Spay->SetDbValueDef($rsnew, $vouchers->Spay->CurrentValue, NULL, FALSE);

		// Neuter
		$vouchers->Neuter->SetDbValueDef($rsnew, $vouchers->Neuter->CurrentValue, NULL, FALSE);

		// FVRCP
		$vouchers->FVRCP->SetDbValueDef($rsnew, $vouchers->FVRCP->CurrentValue, NULL, FALSE);

		// FELV
		$vouchers->FELV->SetDbValueDef($rsnew, $vouchers->FELV->CurrentValue, NULL, FALSE);

		// Rabies
		$vouchers->Rabies->SetDbValueDef($rsnew, $vouchers->Rabies->CurrentValue, NULL, FALSE);

		// Pregnant
		$vouchers->Pregnant->SetDbValueDef($rsnew, $vouchers->Pregnant->CurrentValue, NULL, FALSE);

		// AssignedTo
		$vouchers->AssignedTo->SetDbValueDef($rsnew, $vouchers->AssignedTo->CurrentValue, NULL, FALSE);

		// mod_by
		$vouchers->mod_by->SetDbValueDef($rsnew, $vouchers->mod_by->CurrentValue, NULL, FALSE);

		// mod_date
		$vouchers->mod_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($vouchers->mod_date->CurrentValue, 5), ew_CurrentDate(), FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $vouchers->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $conn->Execute($vouchers->InsertSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($vouchers->CancelMessage <> "") {
				$this->setFailureMessage($vouchers->CancelMessage);
				$vouchers->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}

		// Get insert id if necessary
		if ($AddRow) {
			$vouchers->id->setDbValue($conn->Insert_ID());
			$rsnew['id'] = $vouchers->id->DbValue;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$vouchers->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
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
