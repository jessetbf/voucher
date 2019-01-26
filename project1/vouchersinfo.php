<?php

// Global variable for table object
$vouchers = NULL;

//
// Table class for vouchers
//
class cvouchers {
	var $TableVar = 'vouchers';
	var $TableName = 'vouchers';
	var $TableType = 'TABLE';
	var $id;
	var $VoucherNumber;
	var $ExpireDate;
	var $IssuedByFirst;
	var $IssuedByLast;
	var $FirstName;
	var $LastName;
	var $Program;
	var $cat_name;
	var $cat_breed;
	var $cat_age;
	var $copay;
	var $cat_status;
	var $date_redeemed;
	var $Clinic;
	var $ClinicPrice;
	var $vet_used;
	var $colony_id;
	var $Spay;
	var $Neuter;
	var $FVRCP;
	var $FELV;
	var $Rabies;
	var $Pregnant;
	var $AssignedTo;
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
	function cvouchers() {
		global $Language;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row

		// id
		$this->id = new cField('vouchers', 'vouchers', 'x_id', 'id', '`id`', 21, -1, FALSE, '`id`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] =& $this->id;

		// VoucherNumber
		$this->VoucherNumber = new cField('vouchers', 'vouchers', 'x_VoucherNumber', 'VoucherNumber', '`VoucherNumber`', 20, -1, FALSE, '`VoucherNumber`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->VoucherNumber->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['VoucherNumber'] =& $this->VoucherNumber;

		// ExpireDate
		$this->ExpireDate = new cField('vouchers', 'vouchers', 'x_ExpireDate', 'ExpireDate', '`ExpireDate`', 133, 5, FALSE, '`ExpireDate`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->ExpireDate->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateYMD"));
		$this->fields['ExpireDate'] =& $this->ExpireDate;

		// IssuedByFirst
		$this->IssuedByFirst = new cField('vouchers', 'vouchers', 'x_IssuedByFirst', 'IssuedByFirst', '`IssuedByFirst`', 200, -1, FALSE, '`IssuedByFirst`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['IssuedByFirst'] =& $this->IssuedByFirst;

		// IssuedByLast
		$this->IssuedByLast = new cField('vouchers', 'vouchers', 'x_IssuedByLast', 'IssuedByLast', '`IssuedByLast`', 200, -1, FALSE, '`IssuedByLast`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['IssuedByLast'] =& $this->IssuedByLast;

		// FirstName
		$this->FirstName = new cField('vouchers', 'vouchers', 'x_FirstName', 'FirstName', '`FirstName`', 200, -1, FALSE, '`FirstName`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['FirstName'] =& $this->FirstName;

		// LastName
		$this->LastName = new cField('vouchers', 'vouchers', 'x_LastName', 'LastName', '`LastName`', 200, -1, FALSE, '`LastName`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['LastName'] =& $this->LastName;

		// Program
		$this->Program = new cField('vouchers', 'vouchers', 'x_Program', 'Program', '`Program`', 200, -1, FALSE, '`Program`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Program'] =& $this->Program;

		// cat_name
		$this->cat_name = new cField('vouchers', 'vouchers', 'x_cat_name', 'cat_name', '`cat_name`', 200, -1, FALSE, '`cat_name`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['cat_name'] =& $this->cat_name;

		// cat_breed
		$this->cat_breed = new cField('vouchers', 'vouchers', 'x_cat_breed', 'cat_breed', '`cat_breed`', 200, -1, FALSE, '`cat_breed`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['cat_breed'] =& $this->cat_breed;

		// cat_age
		$this->cat_age = new cField('vouchers', 'vouchers', 'x_cat_age', 'cat_age', '`cat_age`', 19, -1, FALSE, '`cat_age`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->cat_age->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['cat_age'] =& $this->cat_age;

		// copay
		$this->copay = new cField('vouchers', 'vouchers', 'x_copay', 'copay', '`copay`', 16, -1, FALSE, '`copay`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->copay->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['copay'] =& $this->copay;

		// cat_status
		$this->cat_status = new cField('vouchers', 'vouchers', 'x_cat_status', 'cat_status', '`cat_status`', 200, -1, FALSE, '`cat_status`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['cat_status'] =& $this->cat_status;

		// date_redeemed
		$this->date_redeemed = new cField('vouchers', 'vouchers', 'x_date_redeemed', 'date_redeemed', '`date_redeemed`', 133, 5, FALSE, '`date_redeemed`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->date_redeemed->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateYMD"));
		$this->fields['date_redeemed'] =& $this->date_redeemed;

		// Clinic
		$this->Clinic = new cField('vouchers', 'vouchers', 'x_Clinic', 'Clinic', '`Clinic`', 200, -1, FALSE, '`Clinic`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Clinic'] =& $this->Clinic;

		// ClinicPrice
		$this->ClinicPrice = new cField('vouchers', 'vouchers', 'x_ClinicPrice', 'ClinicPrice', '`ClinicPrice`', 19, -1, FALSE, '`ClinicPrice`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->ClinicPrice->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['ClinicPrice'] =& $this->ClinicPrice;

		// vet_used
		$this->vet_used = new cField('vouchers', 'vouchers', 'x_vet_used', 'vet_used', '`vet_used`', 200, -1, FALSE, '`vet_used`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['vet_used'] =& $this->vet_used;

		// colony_id
		$this->colony_id = new cField('vouchers', 'vouchers', 'x_colony_id', 'colony_id', '`colony_id`', 19, -1, FALSE, '`colony_id`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->colony_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['colony_id'] =& $this->colony_id;

		// Spay
		$this->Spay = new cField('vouchers', 'vouchers', 'x_Spay', 'Spay', '`Spay`', 200, -1, FALSE, '`Spay`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Spay'] =& $this->Spay;

		// Neuter
		$this->Neuter = new cField('vouchers', 'vouchers', 'x_Neuter', 'Neuter', '`Neuter`', 200, -1, FALSE, '`Neuter`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Neuter'] =& $this->Neuter;

		// FVRCP
		$this->FVRCP = new cField('vouchers', 'vouchers', 'x_FVRCP', 'FVRCP', '`FVRCP`', 200, -1, FALSE, '`FVRCP`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['FVRCP'] =& $this->FVRCP;

		// FELV
		$this->FELV = new cField('vouchers', 'vouchers', 'x_FELV', 'FELV', '`FELV`', 200, -1, FALSE, '`FELV`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['FELV'] =& $this->FELV;

		// Rabies
		$this->Rabies = new cField('vouchers', 'vouchers', 'x_Rabies', 'Rabies', '`Rabies`', 200, -1, FALSE, '`Rabies`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Rabies'] =& $this->Rabies;

		// Pregnant
		$this->Pregnant = new cField('vouchers', 'vouchers', 'x_Pregnant', 'Pregnant', '`Pregnant`', 200, -1, FALSE, '`Pregnant`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Pregnant'] =& $this->Pregnant;

		// AssignedTo
		$this->AssignedTo = new cField('vouchers', 'vouchers', 'x_AssignedTo', 'AssignedTo', '`AssignedTo`', 200, -1, FALSE, '`AssignedTo`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['AssignedTo'] =& $this->AssignedTo;

		// mod_by
		$this->mod_by = new cField('vouchers', 'vouchers', 'x_mod_by', 'mod_by', '`mod_by`', 200, -1, FALSE, '`mod_by`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['mod_by'] =& $this->mod_by;

		// mod_date
		$this->mod_date = new cField('vouchers', 'vouchers', 'x_mod_date', 'mod_date', '`mod_date`', 135, 5, FALSE, '`mod_date`', FALSE, FALSE, 'FORMATTED TEXT');
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
		return "vouchers_Highlight";
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
		return "`vouchers`";
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
		return "`id` DESC";
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
		return "INSERT INTO `vouchers` ($names) VALUES ($values)";
	}

	// UPDATE statement
	function UpdateSQL(&$rs) {
		global $conn;
		$SQL = "UPDATE `vouchers` SET ";
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
		$SQL = "DELETE FROM `vouchers` WHERE ";
		$SQL .= ew_QuotedName('id') . '=' . ew_QuotedValue($rs['id'], $this->id->FldDataType) . ' AND ';
		if (substr($SQL, -5) == " AND ") $SQL = substr($SQL, 0, strlen($SQL)-5);
		if ($this->CurrentFilter <> "")	$SQL .= " AND " . $this->CurrentFilter;
		return $SQL;
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`id` = @id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@id@", ew_AdjustSql($this->id->CurrentValue), $sKeyFilter); // Replace key value
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
			return "voucherslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function ListUrl() {
		return "voucherslist.php";
	}

	// View URL
	function ViewUrl() {
		return $this->KeyUrl("vouchersview.php", $this->UrlParm());
	}

	// Add URL
	function AddUrl() {
		$AddUrl = "vouchersadd.php";

//		$sUrlParm = $this->UrlParm();
//		if ($sUrlParm <> "")
//			$AddUrl .= "?" . $sUrlParm;

		return $AddUrl;
	}

	// Edit URL
	function EditUrl($parm = "") {
		return $this->KeyUrl("vouchersedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function InlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function CopyUrl($parm = "") {
		return $this->KeyUrl("vouchersadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function InlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function DeleteUrl() {
		return $this->KeyUrl("vouchersdelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->id->CurrentValue)) {
			$sUrl .= "id=" . urlencode($this->id->CurrentValue);
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
		$UrlParm = ($this->UseTokenInUrl) ? "t=vouchers" : "";
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
			$arKeys[] = @$_GET["id"]; // id

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
			$this->id->CurrentValue = $key;
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
		$this->id->setDbValue($rs->fields('id'));
		$this->VoucherNumber->setDbValue($rs->fields('VoucherNumber'));
		$this->ExpireDate->setDbValue($rs->fields('ExpireDate'));
		$this->IssuedByFirst->setDbValue($rs->fields('IssuedByFirst'));
		$this->IssuedByLast->setDbValue($rs->fields('IssuedByLast'));
		$this->FirstName->setDbValue($rs->fields('FirstName'));
		$this->LastName->setDbValue($rs->fields('LastName'));
		$this->Program->setDbValue($rs->fields('Program'));
		$this->cat_name->setDbValue($rs->fields('cat_name'));
		$this->cat_breed->setDbValue($rs->fields('cat_breed'));
		$this->cat_age->setDbValue($rs->fields('cat_age'));
		$this->copay->setDbValue($rs->fields('copay'));
		$this->cat_status->setDbValue($rs->fields('cat_status'));
		$this->date_redeemed->setDbValue($rs->fields('date_redeemed'));
		$this->Clinic->setDbValue($rs->fields('Clinic'));
		$this->ClinicPrice->setDbValue($rs->fields('ClinicPrice'));
		$this->vet_used->setDbValue($rs->fields('vet_used'));
		$this->colony_id->setDbValue($rs->fields('colony_id'));
		$this->Spay->setDbValue($rs->fields('Spay'));
		$this->Neuter->setDbValue($rs->fields('Neuter'));
		$this->FVRCP->setDbValue($rs->fields('FVRCP'));
		$this->FELV->setDbValue($rs->fields('FELV'));
		$this->Rabies->setDbValue($rs->fields('Rabies'));
		$this->Pregnant->setDbValue($rs->fields('Pregnant'));
		$this->AssignedTo->setDbValue($rs->fields('AssignedTo'));
		$this->mod_by->setDbValue($rs->fields('mod_by'));
		$this->mod_date->setDbValue($rs->fields('mod_date'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
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
		// id

		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// VoucherNumber
		$this->VoucherNumber->ViewValue = $this->VoucherNumber->CurrentValue;
		$this->VoucherNumber->ViewCustomAttributes = "";

		// ExpireDate
		$this->ExpireDate->ViewValue = $this->ExpireDate->CurrentValue;
		$this->ExpireDate->ViewValue = ew_FormatDateTime($this->ExpireDate->ViewValue, 5);
		$this->ExpireDate->ViewCustomAttributes = "";

		// IssuedByFirst
		$this->IssuedByFirst->ViewValue = $this->IssuedByFirst->CurrentValue;
		$this->IssuedByFirst->ViewCustomAttributes = "";

		// IssuedByLast
		$this->IssuedByLast->ViewValue = $this->IssuedByLast->CurrentValue;
		$this->IssuedByLast->ViewCustomAttributes = "";

		// FirstName
		$this->FirstName->ViewValue = $this->FirstName->CurrentValue;
		$this->FirstName->ViewCustomAttributes = "";

		// LastName
		$this->LastName->ViewValue = $this->LastName->CurrentValue;
		$this->LastName->ViewCustomAttributes = "";

		// Program
		$this->Program->ViewValue = $this->Program->CurrentValue;
		$this->Program->ViewCustomAttributes = "";

		// cat_name
		$this->cat_name->ViewValue = $this->cat_name->CurrentValue;
		$this->cat_name->ViewCustomAttributes = "";

		// cat_breed
		$this->cat_breed->ViewValue = $this->cat_breed->CurrentValue;
		$this->cat_breed->ViewCustomAttributes = "";

		// cat_age
		$this->cat_age->ViewValue = $this->cat_age->CurrentValue;
		$this->cat_age->ViewCustomAttributes = "";

		// copay
		$this->copay->ViewValue = $this->copay->CurrentValue;
		$this->copay->ViewCustomAttributes = "";

		// cat_status
		$this->cat_status->ViewValue = $this->cat_status->CurrentValue;
		$this->cat_status->ViewCustomAttributes = "";

		// date_redeemed
		$this->date_redeemed->ViewValue = $this->date_redeemed->CurrentValue;
		$this->date_redeemed->ViewValue = ew_FormatDateTime($this->date_redeemed->ViewValue, 5);
		$this->date_redeemed->ViewCustomAttributes = "";

		// Clinic
		$this->Clinic->ViewValue = $this->Clinic->CurrentValue;
		$this->Clinic->ViewCustomAttributes = "";

		// ClinicPrice
		$this->ClinicPrice->ViewValue = $this->ClinicPrice->CurrentValue;
		$this->ClinicPrice->ViewCustomAttributes = "";

		// vet_used
		$this->vet_used->ViewValue = $this->vet_used->CurrentValue;
		$this->vet_used->ViewCustomAttributes = "";

		// colony_id
		$this->colony_id->ViewValue = $this->colony_id->CurrentValue;
		$this->colony_id->ViewCustomAttributes = "";

		// Spay
		$this->Spay->ViewValue = $this->Spay->CurrentValue;
		$this->Spay->ViewCustomAttributes = "";

		// Neuter
		$this->Neuter->ViewValue = $this->Neuter->CurrentValue;
		$this->Neuter->ViewCustomAttributes = "";

		// FVRCP
		$this->FVRCP->ViewValue = $this->FVRCP->CurrentValue;
		$this->FVRCP->ViewCustomAttributes = "";

		// FELV
		$this->FELV->ViewValue = $this->FELV->CurrentValue;
		$this->FELV->ViewCustomAttributes = "";

		// Rabies
		$this->Rabies->ViewValue = $this->Rabies->CurrentValue;
		$this->Rabies->ViewCustomAttributes = "";

		// Pregnant
		$this->Pregnant->ViewValue = $this->Pregnant->CurrentValue;
		$this->Pregnant->ViewCustomAttributes = "";

		// AssignedTo
		$this->AssignedTo->ViewValue = $this->AssignedTo->CurrentValue;
		$this->AssignedTo->ViewCustomAttributes = "";

		// mod_by
		$this->mod_by->ViewValue = $this->mod_by->CurrentValue;
		$this->mod_by->ViewCustomAttributes = "";

		// mod_date
		$this->mod_date->ViewValue = $this->mod_date->CurrentValue;
		$this->mod_date->ViewValue = ew_FormatDateTime($this->mod_date->ViewValue, 5);
		$this->mod_date->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// VoucherNumber
		$this->VoucherNumber->LinkCustomAttributes = "";
		$this->VoucherNumber->HrefValue = "";
		$this->VoucherNumber->TooltipValue = "";

		// ExpireDate
		$this->ExpireDate->LinkCustomAttributes = "";
		$this->ExpireDate->HrefValue = "";
		$this->ExpireDate->TooltipValue = "";

		// IssuedByFirst
		$this->IssuedByFirst->LinkCustomAttributes = "";
		$this->IssuedByFirst->HrefValue = "";
		$this->IssuedByFirst->TooltipValue = "";

		// IssuedByLast
		$this->IssuedByLast->LinkCustomAttributes = "";
		$this->IssuedByLast->HrefValue = "";
		$this->IssuedByLast->TooltipValue = "";

		// FirstName
		$this->FirstName->LinkCustomAttributes = "";
		$this->FirstName->HrefValue = "";
		$this->FirstName->TooltipValue = "";

		// LastName
		$this->LastName->LinkCustomAttributes = "";
		$this->LastName->HrefValue = "";
		$this->LastName->TooltipValue = "";

		// Program
		$this->Program->LinkCustomAttributes = "";
		$this->Program->HrefValue = "";
		$this->Program->TooltipValue = "";

		// cat_name
		$this->cat_name->LinkCustomAttributes = "";
		$this->cat_name->HrefValue = "";
		$this->cat_name->TooltipValue = "";

		// cat_breed
		$this->cat_breed->LinkCustomAttributes = "";
		$this->cat_breed->HrefValue = "";
		$this->cat_breed->TooltipValue = "";

		// cat_age
		$this->cat_age->LinkCustomAttributes = "";
		$this->cat_age->HrefValue = "";
		$this->cat_age->TooltipValue = "";

		// copay
		$this->copay->LinkCustomAttributes = "";
		$this->copay->HrefValue = "";
		$this->copay->TooltipValue = "";

		// cat_status
		$this->cat_status->LinkCustomAttributes = "";
		$this->cat_status->HrefValue = "";
		$this->cat_status->TooltipValue = "";

		// date_redeemed
		$this->date_redeemed->LinkCustomAttributes = "";
		$this->date_redeemed->HrefValue = "";
		$this->date_redeemed->TooltipValue = "";

		// Clinic
		$this->Clinic->LinkCustomAttributes = "";
		$this->Clinic->HrefValue = "";
		$this->Clinic->TooltipValue = "";

		// ClinicPrice
		$this->ClinicPrice->LinkCustomAttributes = "";
		$this->ClinicPrice->HrefValue = "";
		$this->ClinicPrice->TooltipValue = "";

		// vet_used
		$this->vet_used->LinkCustomAttributes = "";
		$this->vet_used->HrefValue = "";
		$this->vet_used->TooltipValue = "";

		// colony_id
		$this->colony_id->LinkCustomAttributes = "";
		$this->colony_id->HrefValue = "";
		$this->colony_id->TooltipValue = "";

		// Spay
		$this->Spay->LinkCustomAttributes = "";
		$this->Spay->HrefValue = "";
		$this->Spay->TooltipValue = "";

		// Neuter
		$this->Neuter->LinkCustomAttributes = "";
		$this->Neuter->HrefValue = "";
		$this->Neuter->TooltipValue = "";

		// FVRCP
		$this->FVRCP->LinkCustomAttributes = "";
		$this->FVRCP->HrefValue = "";
		$this->FVRCP->TooltipValue = "";

		// FELV
		$this->FELV->LinkCustomAttributes = "";
		$this->FELV->HrefValue = "";
		$this->FELV->TooltipValue = "";

		// Rabies
		$this->Rabies->LinkCustomAttributes = "";
		$this->Rabies->HrefValue = "";
		$this->Rabies->TooltipValue = "";

		// Pregnant
		$this->Pregnant->LinkCustomAttributes = "";
		$this->Pregnant->HrefValue = "";
		$this->Pregnant->TooltipValue = "";

		// AssignedTo
		$this->AssignedTo->LinkCustomAttributes = "";
		$this->AssignedTo->HrefValue = "";
		$this->AssignedTo->TooltipValue = "";

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
					$XmlDoc->AddField('id', $this->id->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('VoucherNumber', $this->VoucherNumber->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('ExpireDate', $this->ExpireDate->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('IssuedByFirst', $this->IssuedByFirst->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('IssuedByLast', $this->IssuedByLast->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('FirstName', $this->FirstName->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('LastName', $this->LastName->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('Program', $this->Program->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('cat_name', $this->cat_name->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('cat_breed', $this->cat_breed->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('cat_age', $this->cat_age->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('copay', $this->copay->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('cat_status', $this->cat_status->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('date_redeemed', $this->date_redeemed->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('Clinic', $this->Clinic->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('ClinicPrice', $this->ClinicPrice->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('vet_used', $this->vet_used->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('colony_id', $this->colony_id->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('Spay', $this->Spay->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('Neuter', $this->Neuter->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('FVRCP', $this->FVRCP->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('FELV', $this->FELV->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('Rabies', $this->Rabies->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('Pregnant', $this->Pregnant->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('AssignedTo', $this->AssignedTo->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('mod_by', $this->mod_by->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('mod_date', $this->mod_date->ExportValue($this->Export, $this->ExportOriginalValue));
				} else {
					$XmlDoc->AddField('id', $this->id->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('VoucherNumber', $this->VoucherNumber->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('ExpireDate', $this->ExpireDate->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('IssuedByFirst', $this->IssuedByFirst->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('IssuedByLast', $this->IssuedByLast->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('FirstName', $this->FirstName->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('LastName', $this->LastName->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('Program', $this->Program->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('cat_name', $this->cat_name->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('cat_breed', $this->cat_breed->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('cat_age', $this->cat_age->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('copay', $this->copay->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('cat_status', $this->cat_status->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('date_redeemed', $this->date_redeemed->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('Clinic', $this->Clinic->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('ClinicPrice', $this->ClinicPrice->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('vet_used', $this->vet_used->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('colony_id', $this->colony_id->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('Spay', $this->Spay->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('Neuter', $this->Neuter->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('FVRCP', $this->FVRCP->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('FELV', $this->FELV->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('Rabies', $this->Rabies->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('Pregnant', $this->Pregnant->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('AssignedTo', $this->AssignedTo->ExportValue($this->Export, $this->ExportOriginalValue));
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
				$Doc->ExportCaption($this->id);
				$Doc->ExportCaption($this->VoucherNumber);
				$Doc->ExportCaption($this->ExpireDate);
				$Doc->ExportCaption($this->IssuedByFirst);
				$Doc->ExportCaption($this->IssuedByLast);
				$Doc->ExportCaption($this->FirstName);
				$Doc->ExportCaption($this->LastName);
				$Doc->ExportCaption($this->Program);
				$Doc->ExportCaption($this->cat_name);
				$Doc->ExportCaption($this->cat_breed);
				$Doc->ExportCaption($this->cat_age);
				$Doc->ExportCaption($this->copay);
				$Doc->ExportCaption($this->cat_status);
				$Doc->ExportCaption($this->date_redeemed);
				$Doc->ExportCaption($this->Clinic);
				$Doc->ExportCaption($this->ClinicPrice);
				$Doc->ExportCaption($this->vet_used);
				$Doc->ExportCaption($this->colony_id);
				$Doc->ExportCaption($this->Spay);
				$Doc->ExportCaption($this->Neuter);
				$Doc->ExportCaption($this->FVRCP);
				$Doc->ExportCaption($this->FELV);
				$Doc->ExportCaption($this->Rabies);
				$Doc->ExportCaption($this->Pregnant);
				$Doc->ExportCaption($this->AssignedTo);
				$Doc->ExportCaption($this->mod_by);
				$Doc->ExportCaption($this->mod_date);
			} else {
				$Doc->ExportCaption($this->id);
				$Doc->ExportCaption($this->VoucherNumber);
				$Doc->ExportCaption($this->ExpireDate);
				$Doc->ExportCaption($this->IssuedByFirst);
				$Doc->ExportCaption($this->IssuedByLast);
				$Doc->ExportCaption($this->FirstName);
				$Doc->ExportCaption($this->LastName);
				$Doc->ExportCaption($this->Program);
				$Doc->ExportCaption($this->cat_name);
				$Doc->ExportCaption($this->cat_breed);
				$Doc->ExportCaption($this->cat_age);
				$Doc->ExportCaption($this->copay);
				$Doc->ExportCaption($this->cat_status);
				$Doc->ExportCaption($this->date_redeemed);
				$Doc->ExportCaption($this->Clinic);
				$Doc->ExportCaption($this->ClinicPrice);
				$Doc->ExportCaption($this->vet_used);
				$Doc->ExportCaption($this->colony_id);
				$Doc->ExportCaption($this->Spay);
				$Doc->ExportCaption($this->Neuter);
				$Doc->ExportCaption($this->FVRCP);
				$Doc->ExportCaption($this->FELV);
				$Doc->ExportCaption($this->Rabies);
				$Doc->ExportCaption($this->Pregnant);
				$Doc->ExportCaption($this->AssignedTo);
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
					$Doc->ExportField($this->id);
					$Doc->ExportField($this->VoucherNumber);
					$Doc->ExportField($this->ExpireDate);
					$Doc->ExportField($this->IssuedByFirst);
					$Doc->ExportField($this->IssuedByLast);
					$Doc->ExportField($this->FirstName);
					$Doc->ExportField($this->LastName);
					$Doc->ExportField($this->Program);
					$Doc->ExportField($this->cat_name);
					$Doc->ExportField($this->cat_breed);
					$Doc->ExportField($this->cat_age);
					$Doc->ExportField($this->copay);
					$Doc->ExportField($this->cat_status);
					$Doc->ExportField($this->date_redeemed);
					$Doc->ExportField($this->Clinic);
					$Doc->ExportField($this->ClinicPrice);
					$Doc->ExportField($this->vet_used);
					$Doc->ExportField($this->colony_id);
					$Doc->ExportField($this->Spay);
					$Doc->ExportField($this->Neuter);
					$Doc->ExportField($this->FVRCP);
					$Doc->ExportField($this->FELV);
					$Doc->ExportField($this->Rabies);
					$Doc->ExportField($this->Pregnant);
					$Doc->ExportField($this->AssignedTo);
					$Doc->ExportField($this->mod_by);
					$Doc->ExportField($this->mod_date);
				} else {
					$Doc->ExportField($this->id);
					$Doc->ExportField($this->VoucherNumber);
					$Doc->ExportField($this->ExpireDate);
					$Doc->ExportField($this->IssuedByFirst);
					$Doc->ExportField($this->IssuedByLast);
					$Doc->ExportField($this->FirstName);
					$Doc->ExportField($this->LastName);
					$Doc->ExportField($this->Program);
					$Doc->ExportField($this->cat_name);
					$Doc->ExportField($this->cat_breed);
					$Doc->ExportField($this->cat_age);
					$Doc->ExportField($this->copay);
					$Doc->ExportField($this->cat_status);
					$Doc->ExportField($this->date_redeemed);
					$Doc->ExportField($this->Clinic);
					$Doc->ExportField($this->ClinicPrice);
					$Doc->ExportField($this->vet_used);
					$Doc->ExportField($this->colony_id);
					$Doc->ExportField($this->Spay);
					$Doc->ExportField($this->Neuter);
					$Doc->ExportField($this->FVRCP);
					$Doc->ExportField($this->FELV);
					$Doc->ExportField($this->Rabies);
					$Doc->ExportField($this->Pregnant);
					$Doc->ExportField($this->AssignedTo);
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
