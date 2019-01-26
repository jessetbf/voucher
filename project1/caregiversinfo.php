<?php

// Global variable for table object
$caregivers = NULL;

//
// Table class for caregivers
//
class ccaregivers {
	var $TableVar = 'caregivers';
	var $TableName = 'caregivers';
	var $TableType = 'TABLE';
	var $caregiver_id;
	var $first_name;
	var $last_name;
	var $day_phone;
	var $other_phone;
	var $zemail;
	var $address;
	var $apt_num;
	var $city;
	var $county;
	var $zip;
	var $num_deps;
	var $annual_income;
	var $app_source;
	var $dl;
	var $app_date;
	var $Expiration;
	var $ClinicGroup;
	var $DateSent;
	var $budget_category;
	var $AgeOfApplicant;
	var $Applic;
	var $SubApplic;
	var $DateSigned;
	var $colony_id;
	var $mod_by;
	var $mod_date;
	var $fields = array();
	var $UseTokenInUrl = EW_USE_TOKEN_IN_URL;
	var $Export; // Export
	var $ExportOriginalValue = EW_EXPORT_ORIGINAL_VALUE;
	var $ExportAll = TRUE;
	var $ExportPageBreakCount = 0; // Page break per every n record (PDF only)
	var $SendEmail; // Send email
	var $TableCustomInnerHtml; // Custom inner HTML
	var $BasicSearchKeyword; // Basic search keyword
	var $BasicSearchType; // Basic search type
	var $CurrentFilter; // Current filter
	var $CurrentOrder; // Current order
	var $CurrentOrderType; // Current order type
	var $RowType; // Row type
	var $CssClass; // CSS class
	var $CssStyle; // CSS style
	var $RowAttrs = array(); // Row custom attributes

	// Reset attributes for table object
	function ResetAttrs() {
		$this->CssClass = "";
		$this->CssStyle = "";
    	$this->RowAttrs = array();
		foreach ($this->fields as $fld) {
			$fld->ResetAttrs();
		}
	}

	// Setup field titles
	function SetupFieldTitles() {
		foreach ($this->fields as &$fld) {
			if (strval($fld->FldTitle()) <> "") {
				$fld->EditAttrs["onmouseover"] = "ew_ShowTitle(this, '" . ew_JsEncode3($fld->FldTitle()) . "');";
				$fld->EditAttrs["onmouseout"] = "ew_HideTooltip();";
			}
		}
	}
	var $TableFilter = "";
	var $CurrentAction; // Current action
	var $LastAction; // Last action
	var $CurrentMode = ""; // Current mode
	var $UpdateConflict; // Update conflict
	var $EventName; // Event name
	var $EventCancelled; // Event cancelled
	var $CancelMessage; // Cancel message
	var $AllowAddDeleteRow = TRUE; // Allow add/delete row
	var $DetailAdd = FALSE; // Allow detail add
	var $DetailEdit = FALSE; // Allow detail edit
	var $GridAddRowCount = 5;

	// Check current action
	// - Add
	function IsAdd() {
		return $this->CurrentAction == "add";
	}

	// - Copy
	function IsCopy() {
		return $this->CurrentAction == "copy" || $this->CurrentAction == "C";
	}

	// - Edit
	function IsEdit() {
		return $this->CurrentAction == "edit";
	}

	// - Delete
	function IsDelete() {
		return $this->CurrentAction == "D";
	}

	// - Confirm
	function IsConfirm() {
		return $this->CurrentAction == "F";
	}

	// - Overwrite
	function IsOverwrite() {
		return $this->CurrentAction == "overwrite";
	}

	// - Cancel
	function IsCancel() {
		return $this->CurrentAction == "cancel";
	}

	// - Grid add
	function IsGridAdd() {
		return $this->CurrentAction == "gridadd";
	}

	// - Grid edit
	function IsGridEdit() {
		return $this->CurrentAction == "gridedit";
	}

	// - Insert
	function IsInsert() {
		return $this->CurrentAction == "insert" || $this->CurrentAction == "A";
	}

	// - Update
	function IsUpdate() {
		return $this->CurrentAction == "update" || $this->CurrentAction == "U";
	}

	// - Grid update
	function IsGridUpdate() {
		return $this->CurrentAction == "gridupdate";
	}

	// - Grid insert
	function IsGridInsert() {
		return $this->CurrentAction == "gridinsert";
	}

	// - Grid overwrite
	function IsGridOverwrite() {
		return $this->CurrentAction == "gridoverwrite";
	}

	// Check last action
	// - Cancelled
	function IsCanceled() {
		return $this->LastAction == "cancel" && $this->CurrentAction == "";
	}

	// - Inline inserted
	function IsInlineInserted() {
		return $this->LastAction == "insert" && $this->CurrentAction == "";
	}

	// - Inline updated
	function IsInlineUpdated() {
		return $this->LastAction == "update" && $this->CurrentAction == "";
	}

	// - Grid updated
	function IsGridUpdated() {
		return $this->LastAction == "gridupdate" && $this->CurrentAction == "";
	}

	// - Grid inserted
	function IsGridInserted() {
		return $this->LastAction == "gridinsert" && $this->CurrentAction == "";
	}

	//
	// Table class constructor
	//
	function ccaregivers() {
		global $Language;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row

		// caregiver_id
		$this->caregiver_id = new cField('caregivers', 'caregivers', 'x_caregiver_id', 'caregiver_id', '`caregiver_id`', 19, -1, FALSE, '`caregiver_id`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->caregiver_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['caregiver_id'] =& $this->caregiver_id;

		// first_name
		$this->first_name = new cField('caregivers', 'caregivers', 'x_first_name', 'first_name', '`first_name`', 200, -1, FALSE, '`first_name`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['first_name'] =& $this->first_name;

		// last_name
		$this->last_name = new cField('caregivers', 'caregivers', 'x_last_name', 'last_name', '`last_name`', 200, -1, FALSE, '`last_name`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['last_name'] =& $this->last_name;

		// day_phone
		$this->day_phone = new cField('caregivers', 'caregivers', 'x_day_phone', 'day_phone', '`day_phone`', 200, -1, FALSE, '`day_phone`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['day_phone'] =& $this->day_phone;

		// other_phone
		$this->other_phone = new cField('caregivers', 'caregivers', 'x_other_phone', 'other_phone', '`other_phone`', 200, -1, FALSE, '`other_phone`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['other_phone'] =& $this->other_phone;

		// email
		$this->zemail = new cField('caregivers', 'caregivers', 'x_zemail', 'email', '`email`', 200, -1, FALSE, '`email`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['email'] =& $this->zemail;

		// address
		$this->address = new cField('caregivers', 'caregivers', 'x_address', 'address', '`address`', 200, -1, FALSE, '`address`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['address'] =& $this->address;

		// apt_num
		$this->apt_num = new cField('caregivers', 'caregivers', 'x_apt_num', 'apt_num', '`apt_num`', 200, -1, FALSE, '`apt_num`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['apt_num'] =& $this->apt_num;

		// city
		$this->city = new cField('caregivers', 'caregivers', 'x_city', 'city', '`city`', 200, -1, FALSE, '`city`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['city'] =& $this->city;

		// county
		$this->county = new cField('caregivers', 'caregivers', 'x_county', 'county', '`county`', 200, -1, FALSE, '`county`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['county'] =& $this->county;

		// zip
		$this->zip = new cField('caregivers', 'caregivers', 'x_zip', 'zip', '`zip`', 3, -1, FALSE, '`zip`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->zip->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['zip'] =& $this->zip;

		// num_deps
		$this->num_deps = new cField('caregivers', 'caregivers', 'x_num_deps', 'num_deps', '`num_deps`', 16, -1, FALSE, '`num_deps`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->num_deps->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['num_deps'] =& $this->num_deps;

		// annual_income
		$this->annual_income = new cField('caregivers', 'caregivers', 'x_annual_income', 'annual_income', '`annual_income`', 16, -1, FALSE, '`annual_income`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->annual_income->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['annual_income'] =& $this->annual_income;

		// app_source
		$this->app_source = new cField('caregivers', 'caregivers', 'x_app_source', 'app_source', '`app_source`', 16, -1, FALSE, '`app_source`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->app_source->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['app_source'] =& $this->app_source;

		// dl
		$this->dl = new cField('caregivers', 'caregivers', 'x_dl', 'dl', '`dl`', 200, -1, FALSE, '`dl`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['dl'] =& $this->dl;

		// app_date
		$this->app_date = new cField('caregivers', 'caregivers', 'x_app_date', 'app_date', '`app_date`', 133, 5, FALSE, '`app_date`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->app_date->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateYMD"));
		$this->fields['app_date'] =& $this->app_date;

		// Expiration
		$this->Expiration = new cField('caregivers', 'caregivers', 'x_Expiration', 'Expiration', '`Expiration`', 133, 5, FALSE, '`Expiration`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->Expiration->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateYMD"));
		$this->fields['Expiration'] =& $this->Expiration;

		// ClinicGroup
		$this->ClinicGroup = new cField('caregivers', 'caregivers', 'x_ClinicGroup', 'ClinicGroup', '`ClinicGroup`', 200, -1, FALSE, '`ClinicGroup`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['ClinicGroup'] =& $this->ClinicGroup;

		// DateSent
		$this->DateSent = new cField('caregivers', 'caregivers', 'x_DateSent', 'DateSent', '`DateSent`', 133, 5, FALSE, '`DateSent`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->DateSent->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateYMD"));
		$this->fields['DateSent'] =& $this->DateSent;

		// budget_category
		$this->budget_category = new cField('caregivers', 'caregivers', 'x_budget_category', 'budget_category', '`budget_category`', 16, -1, FALSE, '`budget_category`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->budget_category->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['budget_category'] =& $this->budget_category;

		// AgeOfApplicant
		$this->AgeOfApplicant = new cField('caregivers', 'caregivers', 'x_AgeOfApplicant', 'AgeOfApplicant', '`AgeOfApplicant`', 16, -1, FALSE, '`AgeOfApplicant`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->AgeOfApplicant->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['AgeOfApplicant'] =& $this->AgeOfApplicant;

		// Applic
		$this->Applic = new cField('caregivers', 'caregivers', 'x_Applic', 'Applic', '`Applic`', 200, -1, FALSE, '`Applic`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Applic'] =& $this->Applic;

		// SubApplic
		$this->SubApplic = new cField('caregivers', 'caregivers', 'x_SubApplic', 'SubApplic', '`SubApplic`', 200, -1, FALSE, '`SubApplic`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['SubApplic'] =& $this->SubApplic;

		// DateSigned
		$this->DateSigned = new cField('caregivers', 'caregivers', 'x_DateSigned', 'DateSigned', '`DateSigned`', 133, 5, FALSE, '`DateSigned`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->DateSigned->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateYMD"));
		$this->fields['DateSigned'] =& $this->DateSigned;

		// colony_id
		$this->colony_id = new cField('caregivers', 'caregivers', 'x_colony_id', 'colony_id', '`colony_id`', 19, -1, FALSE, '`colony_id`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->colony_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['colony_id'] =& $this->colony_id;

		// mod_by
		$this->mod_by = new cField('caregivers', 'caregivers', 'x_mod_by', 'mod_by', '`mod_by`', 200, -1, FALSE, '`mod_by`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['mod_by'] =& $this->mod_by;

		// mod_date
		$this->mod_date = new cField('caregivers', 'caregivers', 'x_mod_date', 'mod_date', '`mod_date`', 135, 5, FALSE, '`mod_date`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->mod_date->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateYMD"));
		$this->fields['mod_date'] =& $this->mod_date;
	}

	// Get field values
	function GetFieldValues($propertyname) {
		$values = array();
		foreach ($this->fields as $fldname => $fld)
			$values[$fldname] =& $fld->$propertyname;
		return $values;
	}

	// Table caption
	function TableCaption() {
		global $Language;
		return $Language->TablePhrase($this->TableVar, "TblCaption");
	}

	// Page caption
	function PageCaption($Page) {
		global $Language;
		$Caption = $Language->TablePhrase($this->TableVar, "TblPageCaption" . $Page);
		if ($Caption == "") $Caption = "Page " . $Page;
		return $Caption;
	}

	// Export return page
	function ExportReturnUrl() {
		$url = @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_EXPORT_RETURN_URL];
		return ($url <> "") ? $url : ew_CurrentPage();
	}

	function setExportReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_EXPORT_RETURN_URL] = $v;
	}

	// Records per page
	function getRecordsPerPage() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_REC_PER_PAGE];
	}

	function setRecordsPerPage($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_REC_PER_PAGE] = $v;
	}

	// Start record number
	function getStartRecordNumber() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_START_REC];
	}

	function setStartRecordNumber($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_START_REC] = $v;
	}

	// Search highlight name
	function HighlightName() {
		return "caregivers_Highlight";
	}

	// Advanced search
	function getAdvancedSearch($fld) {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ADVANCED_SEARCH . "_" . $fld];
	}

	function setAdvancedSearch($fld, $v) {
		if (@$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ADVANCED_SEARCH . "_" . $fld] <> $v) {
			$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ADVANCED_SEARCH . "_" . $fld] = $v;
		}
	}

	// Basic search keyword
	function getSessionBasicSearchKeyword() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_BASIC_SEARCH];
	}

	function setSessionBasicSearchKeyword($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_BASIC_SEARCH] = $v;
	}

	// Basic search type
	function getSessionBasicSearchType() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_BASIC_SEARCH_TYPE];
	}

	function setSessionBasicSearchType($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_BASIC_SEARCH_TYPE] = $v;
	}

	// Search WHERE clause
	function getSearchWhere() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_SEARCH_WHERE];
	}

	function setSearchWhere($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_SEARCH_WHERE] = $v;
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Session WHERE clause
	function getSessionWhere() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_WHERE];
	}

	function setSessionWhere($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_WHERE] = $v;
	}

	// Session ORDER BY
	function getSessionOrderBy() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ORDER_BY];
	}

	function setSessionOrderBy($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ORDER_BY] = $v;
	}

	// Session key
	function getKey($fld) {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_KEY . "_" . $fld];
	}

	function setKey($fld, $v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_KEY . "_" . $fld] = $v;
	}

	// Current master table name
	function getCurrentMasterTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_TABLE];
	}

	function setCurrentMasterTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_TABLE] = $v;
	}

	// Session master WHERE clause
	function getMasterFilter() {

		// Master filter
		$sMasterFilter = "";
		if ($this->getCurrentMasterTable() == "colonies") {
			if ($this->colony_id->getSessionValue() <> "")
				$sMasterFilter .= "`colony_id`=" . ew_QuotedValue($this->colony_id->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		return $sMasterFilter;
	}

	// Session detail WHERE clause
	function getDetailFilter() {

		// Detail filter
		$sDetailFilter = "";
		if ($this->getCurrentMasterTable() == "colonies") {
			if ($this->colony_id->getSessionValue() <> "")
				$sDetailFilter .= "`colony_id`=" . ew_QuotedValue($this->colony_id->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_colonies() {
		return "`colony_id`=@colony_id@";
	}

	// Detail filter
	function SqlDetailFilter_colonies() {
		return "`colony_id`=@colony_id@";
	}

	// Table level SQL
	function SqlFrom() { // From
		return "`caregivers`";
	}

	function SqlSelect() { // Select
		return "SELECT * FROM " . $this->SqlFrom();
	}

	function SqlWhere() { // Where
		$sWhere = "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlGroupBy() { // Group By
		return "";
	}

	function SqlHaving() { // Having
		return "";
	}

	function SqlOrderBy() { // Order By
		return "`caregiver_id` DESC";
	}

	// Check if Anonymous User is allowed
	function AllowAnonymousUser() {
		switch (EW_PAGE_ID) {
			case "add":
			case "register":
			case "addopt":
				return ;
			case "edit":
			case "update":
				return ;
			case "delete":
				return ;
			case "view":
				return ;
			case "search":
				return ;
			default:
				return ;
		}
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(),
			$this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(),
			$this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(), $this->SqlGroupBy(),
			$this->SqlHaving(), $this->SqlOrderBy(), $sFilter, $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		global $conn;
		$cnt = -1;
		if ($this->TableType == 'TABLE' || $this->TableType == 'VIEW') {
			$sSql = "SELECT COUNT(*) FROM" . substr($sSql, 13);
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);
		$sSql = $this->SQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function SelectRecordCount() {
		global $conn;
		$origFilter = $this->CurrentFilter;
		$this->Recordset_Selecting($this->CurrentFilter);
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $conn->Execute($this->SelectSQL())) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		global $conn;
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType) . ",";
		}
		if (substr($names, -1) == ",") $names = substr($names, 0, strlen($names)-1);
		if (substr($values, -1) == ",") $values = substr($values, 0, strlen($values)-1);
		return "INSERT INTO `caregivers` ($names) VALUES ($values)";
	}

	// UPDATE statement
	function UpdateSQL(&$rs) {
		global $conn;
		$SQL = "UPDATE `caregivers` SET ";
		foreach ($rs as $name => $value) {
			$SQL .= $this->fields[$name]->FldExpression . "=";
			$SQL .= ew_QuotedValue($value, $this->fields[$name]->FldDataType) . ",";
		}
		if (substr($SQL, -1) == ",") $SQL = substr($SQL, 0, strlen($SQL)-1);
		if ($this->CurrentFilter <> "")	$SQL .= " WHERE " . $this->CurrentFilter;
		return $SQL;
	}

	// DELETE statement
	function DeleteSQL(&$rs) {
		$SQL = "DELETE FROM `caregivers` WHERE ";
		$SQL .= ew_QuotedName('caregiver_id') . '=' . ew_QuotedValue($rs['caregiver_id'], $this->caregiver_id->FldDataType) . ' AND ';
		if (substr($SQL, -5) == " AND ") $SQL = substr($SQL, 0, strlen($SQL)-5);
		if ($this->CurrentFilter <> "")	$SQL .= " AND " . $this->CurrentFilter;
		return $SQL;
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`caregiver_id` = @caregiver_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->caregiver_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@caregiver_id@", ew_AdjustSql($this->caregiver_id->CurrentValue), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "caregiverslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function ListUrl() {
		return "caregiverslist.php";
	}

	// View URL
	function ViewUrl() {
		return $this->KeyUrl("caregiversview.php", $this->UrlParm());
	}

	// Add URL
	function AddUrl() {
		$AddUrl = "caregiversadd.php";

//		$sUrlParm = $this->UrlParm();
//		if ($sUrlParm <> "")
//			$AddUrl .= "?" . $sUrlParm;

		return $AddUrl;
	}

	// Edit URL
	function EditUrl($parm = "") {
		return $this->KeyUrl("caregiversedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function InlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function CopyUrl($parm = "") {
		return $this->KeyUrl("caregiversadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function InlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function DeleteUrl() {
		return $this->KeyUrl("caregiversdelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->caregiver_id->CurrentValue)) {
			$sUrl .= "caregiver_id=" . urlencode($this->caregiver_id->CurrentValue);
		} else {
			return "javascript:alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&ordertype=" . $fld->ReverseSort());
			return ew_CurrentPage() . "?" . $sUrlParm;
		} else {
			return "";
		}
	}

	// Add URL parameter
	function UrlParm($parm = "") {
		$UrlParm = ($this->UseTokenInUrl) ? "t=caregivers" : "";
		if ($parm <> "") {
			if ($UrlParm <> "")
				$UrlParm .= "&";
			$UrlParm .= $parm;
		}
		return $UrlParm;
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET)) {
			$arKeys[] = @$_GET["caregiver_id"]; // caregiver_id

			//return $arKeys; // do not return yet, so the values will also be checked by the following code
		}

		// check keys
		$ar = array();
		foreach ($arKeys as $key) {
			if (!is_numeric($key))
				continue;
			$ar[] = $key;
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->caregiver_id->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {
		global $conn;

		// Set up filter (SQL WHERE clause) and get return SQL
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->caregiver_id->setDbValue($rs->fields('caregiver_id'));
		$this->first_name->setDbValue($rs->fields('first_name'));
		$this->last_name->setDbValue($rs->fields('last_name'));
		$this->day_phone->setDbValue($rs->fields('day_phone'));
		$this->other_phone->setDbValue($rs->fields('other_phone'));
		$this->zemail->setDbValue($rs->fields('email'));
		$this->address->setDbValue($rs->fields('address'));
		$this->apt_num->setDbValue($rs->fields('apt_num'));
		$this->city->setDbValue($rs->fields('city'));
		$this->county->setDbValue($rs->fields('county'));
		$this->zip->setDbValue($rs->fields('zip'));
		$this->num_deps->setDbValue($rs->fields('num_deps'));
		$this->annual_income->setDbValue($rs->fields('annual_income'));
		$this->app_source->setDbValue($rs->fields('app_source'));
		$this->dl->setDbValue($rs->fields('dl'));
		$this->app_date->setDbValue($rs->fields('app_date'));
		$this->Expiration->setDbValue($rs->fields('Expiration'));
		$this->ClinicGroup->setDbValue($rs->fields('ClinicGroup'));
		$this->DateSent->setDbValue($rs->fields('DateSent'));
		$this->budget_category->setDbValue($rs->fields('budget_category'));
		$this->AgeOfApplicant->setDbValue($rs->fields('AgeOfApplicant'));
		$this->Applic->setDbValue($rs->fields('Applic'));
		$this->SubApplic->setDbValue($rs->fields('SubApplic'));
		$this->DateSigned->setDbValue($rs->fields('DateSigned'));
		$this->colony_id->setDbValue($rs->fields('colony_id'));
		$this->mod_by->setDbValue($rs->fields('mod_by'));
		$this->mod_date->setDbValue($rs->fields('mod_date'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
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
		// caregiver_id

		$this->caregiver_id->ViewValue = $this->caregiver_id->CurrentValue;
		$this->caregiver_id->ViewCustomAttributes = "";

		// first_name
		$this->first_name->ViewValue = $this->first_name->CurrentValue;
		$this->first_name->ViewCustomAttributes = "";

		// last_name
		$this->last_name->ViewValue = $this->last_name->CurrentValue;
		$this->last_name->ViewCustomAttributes = "";

		// day_phone
		$this->day_phone->ViewValue = $this->day_phone->CurrentValue;
		$this->day_phone->ViewCustomAttributes = "";

		// other_phone
		$this->other_phone->ViewValue = $this->other_phone->CurrentValue;
		$this->other_phone->ViewCustomAttributes = "";

		// email
		$this->zemail->ViewValue = $this->zemail->CurrentValue;
		$this->zemail->ViewCustomAttributes = "";

		// address
		$this->address->ViewValue = $this->address->CurrentValue;
		$this->address->ViewCustomAttributes = "";

		// apt_num
		$this->apt_num->ViewValue = $this->apt_num->CurrentValue;
		$this->apt_num->ViewCustomAttributes = "";

		// city
		$this->city->ViewValue = $this->city->CurrentValue;
		$this->city->ViewCustomAttributes = "";

		// county
		$this->county->ViewValue = $this->county->CurrentValue;
		$this->county->ViewCustomAttributes = "";

		// zip
		$this->zip->ViewValue = $this->zip->CurrentValue;
		$this->zip->ViewCustomAttributes = "";

		// num_deps
		$this->num_deps->ViewValue = $this->num_deps->CurrentValue;
		$this->num_deps->ViewCustomAttributes = "";

		// annual_income
		$this->annual_income->ViewValue = $this->annual_income->CurrentValue;
		$this->annual_income->ViewCustomAttributes = "";

		// app_source
		$this->app_source->ViewValue = $this->app_source->CurrentValue;
		$this->app_source->ViewCustomAttributes = "";

		// dl
		$this->dl->ViewValue = $this->dl->CurrentValue;
		$this->dl->ViewCustomAttributes = "";

		// app_date
		$this->app_date->ViewValue = $this->app_date->CurrentValue;
		$this->app_date->ViewValue = ew_FormatDateTime($this->app_date->ViewValue, 5);
		$this->app_date->ViewCustomAttributes = "";

		// Expiration
		$this->Expiration->ViewValue = $this->Expiration->CurrentValue;
		$this->Expiration->ViewValue = ew_FormatDateTime($this->Expiration->ViewValue, 5);
		$this->Expiration->ViewCustomAttributes = "";

		// ClinicGroup
		$this->ClinicGroup->ViewValue = $this->ClinicGroup->CurrentValue;
		$this->ClinicGroup->ViewCustomAttributes = "";

		// DateSent
		$this->DateSent->ViewValue = $this->DateSent->CurrentValue;
		$this->DateSent->ViewValue = ew_FormatDateTime($this->DateSent->ViewValue, 5);
		$this->DateSent->ViewCustomAttributes = "";

		// budget_category
		$this->budget_category->ViewValue = $this->budget_category->CurrentValue;
		$this->budget_category->ViewCustomAttributes = "";

		// AgeOfApplicant
		$this->AgeOfApplicant->ViewValue = $this->AgeOfApplicant->CurrentValue;
		$this->AgeOfApplicant->ViewCustomAttributes = "";

		// Applic
		$this->Applic->ViewValue = $this->Applic->CurrentValue;
		$this->Applic->ViewCustomAttributes = "";

		// SubApplic
		$this->SubApplic->ViewValue = $this->SubApplic->CurrentValue;
		$this->SubApplic->ViewCustomAttributes = "";

		// DateSigned
		$this->DateSigned->ViewValue = $this->DateSigned->CurrentValue;
		$this->DateSigned->ViewValue = ew_FormatDateTime($this->DateSigned->ViewValue, 5);
		$this->DateSigned->ViewCustomAttributes = "";

		// colony_id
		$this->colony_id->ViewValue = $this->colony_id->CurrentValue;
		$this->colony_id->ViewCustomAttributes = "";

		// mod_by
		$this->mod_by->ViewValue = $this->mod_by->CurrentValue;
		$this->mod_by->ViewCustomAttributes = "";

		// mod_date
		$this->mod_date->ViewValue = $this->mod_date->CurrentValue;
		$this->mod_date->ViewValue = ew_FormatDateTime($this->mod_date->ViewValue, 5);
		$this->mod_date->ViewCustomAttributes = "";

		// caregiver_id
		$this->caregiver_id->LinkCustomAttributes = "";
		$this->caregiver_id->HrefValue = "";
		$this->caregiver_id->TooltipValue = "";

		// first_name
		$this->first_name->LinkCustomAttributes = "";
		$this->first_name->HrefValue = "";
		$this->first_name->TooltipValue = "";

		// last_name
		$this->last_name->LinkCustomAttributes = "";
		$this->last_name->HrefValue = "";
		$this->last_name->TooltipValue = "";

		// day_phone
		$this->day_phone->LinkCustomAttributes = "";
		$this->day_phone->HrefValue = "";
		$this->day_phone->TooltipValue = "";

		// other_phone
		$this->other_phone->LinkCustomAttributes = "";
		$this->other_phone->HrefValue = "";
		$this->other_phone->TooltipValue = "";

		// email
		$this->zemail->LinkCustomAttributes = "";
		$this->zemail->HrefValue = "";
		$this->zemail->TooltipValue = "";

		// address
		$this->address->LinkCustomAttributes = "";
		$this->address->HrefValue = "";
		$this->address->TooltipValue = "";

		// apt_num
		$this->apt_num->LinkCustomAttributes = "";
		$this->apt_num->HrefValue = "";
		$this->apt_num->TooltipValue = "";

		// city
		$this->city->LinkCustomAttributes = "";
		$this->city->HrefValue = "";
		$this->city->TooltipValue = "";

		// county
		$this->county->LinkCustomAttributes = "";
		$this->county->HrefValue = "";
		$this->county->TooltipValue = "";

		// zip
		$this->zip->LinkCustomAttributes = "";
		$this->zip->HrefValue = "";
		$this->zip->TooltipValue = "";

		// num_deps
		$this->num_deps->LinkCustomAttributes = "";
		$this->num_deps->HrefValue = "";
		$this->num_deps->TooltipValue = "";

		// annual_income
		$this->annual_income->LinkCustomAttributes = "";
		$this->annual_income->HrefValue = "";
		$this->annual_income->TooltipValue = "";

		// app_source
		$this->app_source->LinkCustomAttributes = "";
		$this->app_source->HrefValue = "";
		$this->app_source->TooltipValue = "";

		// dl
		$this->dl->LinkCustomAttributes = "";
		$this->dl->HrefValue = "";
		$this->dl->TooltipValue = "";

		// app_date
		$this->app_date->LinkCustomAttributes = "";
		$this->app_date->HrefValue = "";
		$this->app_date->TooltipValue = "";

		// Expiration
		$this->Expiration->LinkCustomAttributes = "";
		$this->Expiration->HrefValue = "";
		$this->Expiration->TooltipValue = "";

		// ClinicGroup
		$this->ClinicGroup->LinkCustomAttributes = "";
		$this->ClinicGroup->HrefValue = "";
		$this->ClinicGroup->TooltipValue = "";

		// DateSent
		$this->DateSent->LinkCustomAttributes = "";
		$this->DateSent->HrefValue = "";
		$this->DateSent->TooltipValue = "";

		// budget_category
		$this->budget_category->LinkCustomAttributes = "";
		$this->budget_category->HrefValue = "";
		$this->budget_category->TooltipValue = "";

		// AgeOfApplicant
		$this->AgeOfApplicant->LinkCustomAttributes = "";
		$this->AgeOfApplicant->HrefValue = "";
		$this->AgeOfApplicant->TooltipValue = "";

		// Applic
		$this->Applic->LinkCustomAttributes = "";
		$this->Applic->HrefValue = "";
		$this->Applic->TooltipValue = "";

		// SubApplic
		$this->SubApplic->LinkCustomAttributes = "";
		$this->SubApplic->HrefValue = "";
		$this->SubApplic->TooltipValue = "";

		// DateSigned
		$this->DateSigned->LinkCustomAttributes = "";
		$this->DateSigned->HrefValue = "";
		$this->DateSigned->TooltipValue = "";

		// colony_id
		$this->colony_id->LinkCustomAttributes = "";
		$this->colony_id->HrefValue = "";
		$this->colony_id->TooltipValue = "";

		// mod_by
		$this->mod_by->LinkCustomAttributes = "";
		$this->mod_by->HrefValue = "";
		$this->mod_by->TooltipValue = "";

		// mod_date
		$this->mod_date->LinkCustomAttributes = "";
		$this->mod_date->HrefValue = "";
		$this->mod_date->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {
	}

	// Export data in Xml Format
	function ExportXmlDocument(&$XmlDoc, $HasParent, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$XmlDoc)
			return;
		if (!$HasParent)
			$XmlDoc->AddRoot($this->TableVar);

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if ($HasParent)
					$XmlDoc->AddRow($this->TableVar);
				else
					$XmlDoc->AddRow();
				if ($ExportPageType == "view") {
					$XmlDoc->AddField('caregiver_id', $this->caregiver_id->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('first_name', $this->first_name->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('last_name', $this->last_name->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('day_phone', $this->day_phone->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('other_phone', $this->other_phone->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('zemail', $this->zemail->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('address', $this->address->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('apt_num', $this->apt_num->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('city', $this->city->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('county', $this->county->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('zip', $this->zip->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('num_deps', $this->num_deps->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('annual_income', $this->annual_income->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('app_source', $this->app_source->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('dl', $this->dl->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('app_date', $this->app_date->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('Expiration', $this->Expiration->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('ClinicGroup', $this->ClinicGroup->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('DateSent', $this->DateSent->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('budget_category', $this->budget_category->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('AgeOfApplicant', $this->AgeOfApplicant->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('Applic', $this->Applic->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('SubApplic', $this->SubApplic->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('DateSigned', $this->DateSigned->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('colony_id', $this->colony_id->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('mod_by', $this->mod_by->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('mod_date', $this->mod_date->ExportValue($this->Export, $this->ExportOriginalValue));
				} else {
					$XmlDoc->AddField('caregiver_id', $this->caregiver_id->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('first_name', $this->first_name->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('last_name', $this->last_name->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('day_phone', $this->day_phone->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('other_phone', $this->other_phone->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('zemail', $this->zemail->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('address', $this->address->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('apt_num', $this->apt_num->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('city', $this->city->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('county', $this->county->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('zip', $this->zip->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('num_deps', $this->num_deps->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('annual_income', $this->annual_income->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('app_source', $this->app_source->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('dl', $this->dl->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('app_date', $this->app_date->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('Expiration', $this->Expiration->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('ClinicGroup', $this->ClinicGroup->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('DateSent', $this->DateSent->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('budget_category', $this->budget_category->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('AgeOfApplicant', $this->AgeOfApplicant->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('Applic', $this->Applic->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('SubApplic', $this->SubApplic->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('DateSigned', $this->DateSigned->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('colony_id', $this->colony_id->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('mod_by', $this->mod_by->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('mod_date', $this->mod_date->ExportValue($this->Export, $this->ExportOriginalValue));
				}
			}
			$Recordset->MoveNext();
		}
	}

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;

		// Write header
		$Doc->ExportTableHeader();
		if ($Doc->Horizontal) { // Horizontal format, write header
			$Doc->BeginExportRow();
			if ($ExportPageType == "view") {
				$Doc->ExportCaption($this->caregiver_id);
				$Doc->ExportCaption($this->first_name);
				$Doc->ExportCaption($this->last_name);
				$Doc->ExportCaption($this->day_phone);
				$Doc->ExportCaption($this->other_phone);
				$Doc->ExportCaption($this->zemail);
				$Doc->ExportCaption($this->address);
				$Doc->ExportCaption($this->apt_num);
				$Doc->ExportCaption($this->city);
				$Doc->ExportCaption($this->county);
				$Doc->ExportCaption($this->zip);
				$Doc->ExportCaption($this->num_deps);
				$Doc->ExportCaption($this->annual_income);
				$Doc->ExportCaption($this->app_source);
				$Doc->ExportCaption($this->dl);
				$Doc->ExportCaption($this->app_date);
				$Doc->ExportCaption($this->Expiration);
				$Doc->ExportCaption($this->ClinicGroup);
				$Doc->ExportCaption($this->DateSent);
				$Doc->ExportCaption($this->budget_category);
				$Doc->ExportCaption($this->AgeOfApplicant);
				$Doc->ExportCaption($this->Applic);
				$Doc->ExportCaption($this->SubApplic);
				$Doc->ExportCaption($this->DateSigned);
				$Doc->ExportCaption($this->colony_id);
				$Doc->ExportCaption($this->mod_by);
				$Doc->ExportCaption($this->mod_date);
			} else {
				$Doc->ExportCaption($this->caregiver_id);
				$Doc->ExportCaption($this->first_name);
				$Doc->ExportCaption($this->last_name);
				$Doc->ExportCaption($this->day_phone);
				$Doc->ExportCaption($this->other_phone);
				$Doc->ExportCaption($this->zemail);
				$Doc->ExportCaption($this->address);
				$Doc->ExportCaption($this->apt_num);
				$Doc->ExportCaption($this->city);
				$Doc->ExportCaption($this->county);
				$Doc->ExportCaption($this->zip);
				$Doc->ExportCaption($this->num_deps);
				$Doc->ExportCaption($this->annual_income);
				$Doc->ExportCaption($this->app_source);
				$Doc->ExportCaption($this->dl);
				$Doc->ExportCaption($this->app_date);
				$Doc->ExportCaption($this->Expiration);
				$Doc->ExportCaption($this->ClinicGroup);
				$Doc->ExportCaption($this->DateSent);
				$Doc->ExportCaption($this->budget_category);
				$Doc->ExportCaption($this->AgeOfApplicant);
				$Doc->ExportCaption($this->Applic);
				$Doc->ExportCaption($this->SubApplic);
				$Doc->ExportCaption($this->DateSigned);
				$Doc->ExportCaption($this->colony_id);
				$Doc->ExportCaption($this->mod_by);
				$Doc->ExportCaption($this->mod_date);
			}
			if ($this->Export == "pdf") {
				$Doc->EndExportRow(TRUE);
			} else {
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break for PDF
				if ($this->Export == "pdf" && $this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
				if ($ExportPageType == "view") {
					$Doc->ExportField($this->caregiver_id);
					$Doc->ExportField($this->first_name);
					$Doc->ExportField($this->last_name);
					$Doc->ExportField($this->day_phone);
					$Doc->ExportField($this->other_phone);
					$Doc->ExportField($this->zemail);
					$Doc->ExportField($this->address);
					$Doc->ExportField($this->apt_num);
					$Doc->ExportField($this->city);
					$Doc->ExportField($this->county);
					$Doc->ExportField($this->zip);
					$Doc->ExportField($this->num_deps);
					$Doc->ExportField($this->annual_income);
					$Doc->ExportField($this->app_source);
					$Doc->ExportField($this->dl);
					$Doc->ExportField($this->app_date);
					$Doc->ExportField($this->Expiration);
					$Doc->ExportField($this->ClinicGroup);
					$Doc->ExportField($this->DateSent);
					$Doc->ExportField($this->budget_category);
					$Doc->ExportField($this->AgeOfApplicant);
					$Doc->ExportField($this->Applic);
					$Doc->ExportField($this->SubApplic);
					$Doc->ExportField($this->DateSigned);
					$Doc->ExportField($this->colony_id);
					$Doc->ExportField($this->mod_by);
					$Doc->ExportField($this->mod_date);
				} else {
					$Doc->ExportField($this->caregiver_id);
					$Doc->ExportField($this->first_name);
					$Doc->ExportField($this->last_name);
					$Doc->ExportField($this->day_phone);
					$Doc->ExportField($this->other_phone);
					$Doc->ExportField($this->zemail);
					$Doc->ExportField($this->address);
					$Doc->ExportField($this->apt_num);
					$Doc->ExportField($this->city);
					$Doc->ExportField($this->county);
					$Doc->ExportField($this->zip);
					$Doc->ExportField($this->num_deps);
					$Doc->ExportField($this->annual_income);
					$Doc->ExportField($this->app_source);
					$Doc->ExportField($this->dl);
					$Doc->ExportField($this->app_date);
					$Doc->ExportField($this->Expiration);
					$Doc->ExportField($this->ClinicGroup);
					$Doc->ExportField($this->DateSent);
					$Doc->ExportField($this->budget_category);
					$Doc->ExportField($this->AgeOfApplicant);
					$Doc->ExportField($this->Applic);
					$Doc->ExportField($this->SubApplic);
					$Doc->ExportField($this->DateSigned);
					$Doc->ExportField($this->colony_id);
					$Doc->ExportField($this->mod_by);
					$Doc->ExportField($this->mod_date);
				}
				$Doc->EndExportRow();
			}
			$Recordset->MoveNext();
		}
		$Doc->ExportTableFooter();
	}

	// Row styles
	function RowStyles() {
		$sAtt = "";
		$sStyle = trim($this->CssStyle);
		if (@$this->RowAttrs["style"] <> "")
			$sStyle .= " " . $this->RowAttrs["style"];
		$sClass = trim($this->CssClass);
		if (@$this->RowAttrs["class"] <> "")
			$sClass .= " " . $this->RowAttrs["class"];
		if (trim($sStyle) <> "")
			$sAtt .= " style=\"" . trim($sStyle) . "\"";
		if (trim($sClass) <> "")
			$sAtt .= " class=\"" . trim($sClass) . "\"";
		return $sAtt;
	}

	// Row attributes
	function RowAttributes() {
		$sAtt = $this->RowStyles();
		if ($this->Export == "") {
			foreach ($this->RowAttrs as $k => $v) {
				if ($k <> "class" && $k <> "style" && trim($v) <> "")
					$sAtt .= " " . $k . "=\"" . trim($v) . "\"";
			}
		}
		return $sAtt;
	}

	// Field object by name
	function fields($fldname) {
		return $this->fields[$fldname];
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}
}
?>
