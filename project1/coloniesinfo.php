<?php

// Global variable for table object
$colonies = NULL;

//
// Table class for colonies
//
class ccolonies {
	var $TableVar = 'colonies';
	var $TableName = 'colonies';
	var $TableType = 'TABLE';
	var $colony_id;
	var $colony_name;
	var $colony_address;
	var $colony_aptnum;
	var $colony_city;
	var $colony_county;
	var $colony_zip;
	var $NumVouchIssued;
	var $VoucherStartNum;
	var $VoucherEndNum;
	var $trapper;
	var $notes;
	var $sage;
	var $Inactive;
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
	function ccolonies() {
		global $Language;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row

		// colony_id
		$this->colony_id = new cField('colonies', 'colonies', 'x_colony_id', 'colony_id', '`colony_id`', 19, -1, FALSE, '`colony_id`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->colony_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['colony_id'] =& $this->colony_id;

		// colony_name
		$this->colony_name = new cField('colonies', 'colonies', 'x_colony_name', 'colony_name', '`colony_name`', 200, -1, FALSE, '`colony_name`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['colony_name'] =& $this->colony_name;

		// colony_address
		$this->colony_address = new cField('colonies', 'colonies', 'x_colony_address', 'colony_address', '`colony_address`', 200, -1, FALSE, '`colony_address`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['colony_address'] =& $this->colony_address;

		// colony_aptnum
		$this->colony_aptnum = new cField('colonies', 'colonies', 'x_colony_aptnum', 'colony_aptnum', '`colony_aptnum`', 200, -1, FALSE, '`colony_aptnum`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['colony_aptnum'] =& $this->colony_aptnum;

		// colony_city
		$this->colony_city = new cField('colonies', 'colonies', 'x_colony_city', 'colony_city', '`colony_city`', 200, -1, FALSE, '`colony_city`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['colony_city'] =& $this->colony_city;

		// colony_county
		$this->colony_county = new cField('colonies', 'colonies', 'x_colony_county', 'colony_county', '`colony_county`', 200, -1, FALSE, '`colony_county`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['colony_county'] =& $this->colony_county;

		// colony_zip
		$this->colony_zip = new cField('colonies', 'colonies', 'x_colony_zip', 'colony_zip', '`colony_zip`', 200, -1, FALSE, '`colony_zip`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['colony_zip'] =& $this->colony_zip;

		// NumVouchIssued
		$this->NumVouchIssued = new cField('colonies', 'colonies', 'x_NumVouchIssued', 'NumVouchIssued', '`NumVouchIssued`', 17, -1, FALSE, '`NumVouchIssued`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->NumVouchIssued->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['NumVouchIssued'] =& $this->NumVouchIssued;

		// VoucherStartNum
		$this->VoucherStartNum = new cField('colonies', 'colonies', 'x_VoucherStartNum', 'VoucherStartNum', '`VoucherStartNum`', 19, -1, FALSE, '`VoucherStartNum`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->VoucherStartNum->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['VoucherStartNum'] =& $this->VoucherStartNum;

		// VoucherEndNum
		$this->VoucherEndNum = new cField('colonies', 'colonies', 'x_VoucherEndNum', 'VoucherEndNum', '`VoucherEndNum`', 19, -1, FALSE, '`VoucherEndNum`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->VoucherEndNum->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['VoucherEndNum'] =& $this->VoucherEndNum;

		// trapper
		$this->trapper = new cField('colonies', 'colonies', 'x_trapper', 'trapper', '`trapper`', 200, -1, FALSE, '`trapper`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['trapper'] =& $this->trapper;

		// notes
		$this->notes = new cField('colonies', 'colonies', 'x_notes', 'notes', '`notes`', 200, -1, FALSE, '`notes`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['notes'] =& $this->notes;

		// sage
		$this->sage = new cField('colonies', 'colonies', 'x_sage', 'sage', '`sage`', 200, -1, FALSE, '`sage`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['sage'] =& $this->sage;

		// Inactive
		$this->Inactive = new cField('colonies', 'colonies', 'x_Inactive', 'Inactive', '`Inactive`', 17, -1, FALSE, '`Inactive`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->Inactive->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Inactive'] =& $this->Inactive;

		// mod_by
		$this->mod_by = new cField('colonies', 'colonies', 'x_mod_by', 'mod_by', '`mod_by`', 200, -1, FALSE, '`mod_by`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['mod_by'] =& $this->mod_by;

		// mod_date
		$this->mod_date = new cField('colonies', 'colonies', 'x_mod_date', 'mod_date', '`mod_date`', 135, 5, FALSE, '`mod_date`', FALSE, FALSE, 'FORMATTED TEXT');
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
		return "colonies_Highlight";
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

	// Current detail table name
	function getCurrentDetailTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE];
	}

	function setCurrentDetailTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE] = $v;
	}

	// Get detail url
	function getDetailUrl() {

		// Detail url
		$sDetailUrl = "";
		if ($this->getCurrentDetailTable() == "vouchers") {
			$sDetailUrl = $GLOBALS["vouchers"]->ListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&colony_id=" . $this->colony_id->CurrentValue;
		}
		if ($this->getCurrentDetailTable() == "caregivers") {
			$sDetailUrl = $GLOBALS["caregivers"]->ListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&colony_id=" . $this->colony_id->CurrentValue;
		}
		return $sDetailUrl;
	}

	// Table level SQL
	function SqlFrom() { // From
		return "`colonies`";
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
		return "`colony_id` DESC";
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
		return "INSERT INTO `colonies` ($names) VALUES ($values)";
	}

	// UPDATE statement
	function UpdateSQL(&$rs) {
		global $conn;
		$SQL = "UPDATE `colonies` SET ";
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
		$SQL = "DELETE FROM `colonies` WHERE ";
		$SQL .= ew_QuotedName('colony_id') . '=' . ew_QuotedValue($rs['colony_id'], $this->colony_id->FldDataType) . ' AND ';
		$SQL .= ew_QuotedName('colony_name') . '=' . ew_QuotedValue($rs['colony_name'], $this->colony_name->FldDataType) . ' AND ';
		if (substr($SQL, -5) == " AND ") $SQL = substr($SQL, 0, strlen($SQL)-5);
		if ($this->CurrentFilter <> "")	$SQL .= " AND " . $this->CurrentFilter;
		return $SQL;
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`colony_id` = @colony_id@ AND `colony_name` = '@colony_name@'";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->colony_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@colony_id@", ew_AdjustSql($this->colony_id->CurrentValue), $sKeyFilter); // Replace key value
		$sKeyFilter = str_replace("@colony_name@", ew_AdjustSql($this->colony_name->CurrentValue), $sKeyFilter); // Replace key value
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
			return "colonieslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function ListUrl() {
		return "colonieslist.php";
	}

	// View URL
	function ViewUrl() {
		return $this->KeyUrl("coloniesview.php", $this->UrlParm());
	}

	// Add URL
	function AddUrl() {
		$AddUrl = "coloniesadd.php";

//		$sUrlParm = $this->UrlParm();
//		if ($sUrlParm <> "")
//			$AddUrl .= "?" . $sUrlParm;

		return $AddUrl;
	}

	// Edit URL
	function EditUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("coloniesedit.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("coloniesedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Inline edit URL
	function InlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function CopyUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("coloniesadd.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("coloniesadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Inline copy URL
	function InlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function DeleteUrl() {
		return $this->KeyUrl("coloniesdelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->colony_id->CurrentValue)) {
			$sUrl .= "colony_id=" . urlencode($this->colony_id->CurrentValue);
		} else {
			return "javascript:alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		if (!is_null($this->colony_name->CurrentValue)) {
			$sUrl .= "&colony_name=" . urlencode($this->colony_name->CurrentValue);
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
		$UrlParm = ($this->UseTokenInUrl) ? "t=colonies" : "";
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
			for ($i = 0; $i < $cnt; $i++)
				$arKeys[$i] = explode(EW_COMPOSITE_KEY_SEPARATOR, $arKeys[$i]);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
			for ($i = 0; $i < $cnt; $i++)
				$arKeys[$i] = explode(EW_COMPOSITE_KEY_SEPARATOR, $arKeys[$i]);
		} elseif (isset($_GET)) {
			$arKey[] = @$_GET["colony_id"]; // colony_id
			$arKey[] = @$_GET["colony_name"]; // colony_name
			$arKeys[] = $arKey;

			//return $arKeys; // do not return yet, so the values will also be checked by the following code
		}

		// check keys
		$ar = array();
		foreach ($arKeys as $key) {
			if (!is_array($key) || count($key) <> 2)
				continue; // just skip so other keys will still work
			if (!is_numeric($key[0])) // colony_id
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
			$this->colony_id->CurrentValue = $key[0];
			$this->colony_name->CurrentValue = $key[1];
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
		$this->colony_id->setDbValue($rs->fields('colony_id'));
		$this->colony_name->setDbValue($rs->fields('colony_name'));
		$this->colony_address->setDbValue($rs->fields('colony_address'));
		$this->colony_aptnum->setDbValue($rs->fields('colony_aptnum'));
		$this->colony_city->setDbValue($rs->fields('colony_city'));
		$this->colony_county->setDbValue($rs->fields('colony_county'));
		$this->colony_zip->setDbValue($rs->fields('colony_zip'));
		$this->NumVouchIssued->setDbValue($rs->fields('NumVouchIssued'));
		$this->VoucherStartNum->setDbValue($rs->fields('VoucherStartNum'));
		$this->VoucherEndNum->setDbValue($rs->fields('VoucherEndNum'));
		$this->trapper->setDbValue($rs->fields('trapper'));
		$this->notes->setDbValue($rs->fields('notes'));
		$this->sage->setDbValue($rs->fields('sage'));
		$this->Inactive->setDbValue($rs->fields('Inactive'));
		$this->mod_by->setDbValue($rs->fields('mod_by'));
		$this->mod_date->setDbValue($rs->fields('mod_date'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
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
		// colony_id

		$this->colony_id->ViewValue = $this->colony_id->CurrentValue;
		$this->colony_id->ViewCustomAttributes = "";

		// colony_name
		$this->colony_name->ViewValue = $this->colony_name->CurrentValue;
		$this->colony_name->ViewCustomAttributes = "";

		// colony_address
		$this->colony_address->ViewValue = $this->colony_address->CurrentValue;
		$this->colony_address->ViewCustomAttributes = "";

		// colony_aptnum
		$this->colony_aptnum->ViewValue = $this->colony_aptnum->CurrentValue;
		$this->colony_aptnum->ViewCustomAttributes = "";

		// colony_city
		$this->colony_city->ViewValue = $this->colony_city->CurrentValue;
		$this->colony_city->ViewCustomAttributes = "";

		// colony_county
		$this->colony_county->ViewValue = $this->colony_county->CurrentValue;
		$this->colony_county->ViewCustomAttributes = "";

		// colony_zip
		$this->colony_zip->ViewValue = $this->colony_zip->CurrentValue;
		$this->colony_zip->ViewCustomAttributes = "";

		// NumVouchIssued
		$this->NumVouchIssued->ViewValue = $this->NumVouchIssued->CurrentValue;
		$this->NumVouchIssued->ViewCustomAttributes = "";

		// VoucherStartNum
		$this->VoucherStartNum->ViewValue = $this->VoucherStartNum->CurrentValue;
		$this->VoucherStartNum->ViewCustomAttributes = "";

		// VoucherEndNum
		$this->VoucherEndNum->ViewValue = $this->VoucherEndNum->CurrentValue;
		$this->VoucherEndNum->ViewCustomAttributes = "";

		// trapper
		$this->trapper->ViewValue = $this->trapper->CurrentValue;
		$this->trapper->ViewCustomAttributes = "";

		// notes
		$this->notes->ViewValue = $this->notes->CurrentValue;
		$this->notes->ViewCustomAttributes = "";

		// sage
		$this->sage->ViewValue = $this->sage->CurrentValue;
		$this->sage->ViewCustomAttributes = "";

		// Inactive
		$this->Inactive->ViewValue = $this->Inactive->CurrentValue;
		$this->Inactive->ViewCustomAttributes = "";

		// mod_by
		$this->mod_by->ViewValue = $this->mod_by->CurrentValue;
		$this->mod_by->ViewCustomAttributes = "";

		// mod_date
		$this->mod_date->ViewValue = $this->mod_date->CurrentValue;
		$this->mod_date->ViewValue = ew_FormatDateTime($this->mod_date->ViewValue, 5);
		$this->mod_date->ViewCustomAttributes = "";

		// colony_id
		$this->colony_id->LinkCustomAttributes = "";
		$this->colony_id->HrefValue = "";
		$this->colony_id->TooltipValue = "";

		// colony_name
		$this->colony_name->LinkCustomAttributes = "";
		$this->colony_name->HrefValue = "";
		$this->colony_name->TooltipValue = "";

		// colony_address
		$this->colony_address->LinkCustomAttributes = "";
		$this->colony_address->HrefValue = "";
		$this->colony_address->TooltipValue = "";

		// colony_aptnum
		$this->colony_aptnum->LinkCustomAttributes = "";
		$this->colony_aptnum->HrefValue = "";
		$this->colony_aptnum->TooltipValue = "";

		// colony_city
		$this->colony_city->LinkCustomAttributes = "";
		$this->colony_city->HrefValue = "";
		$this->colony_city->TooltipValue = "";

		// colony_county
		$this->colony_county->LinkCustomAttributes = "";
		$this->colony_county->HrefValue = "";
		$this->colony_county->TooltipValue = "";

		// colony_zip
		$this->colony_zip->LinkCustomAttributes = "";
		$this->colony_zip->HrefValue = "";
		$this->colony_zip->TooltipValue = "";

		// NumVouchIssued
		$this->NumVouchIssued->LinkCustomAttributes = "";
		$this->NumVouchIssued->HrefValue = "";
		$this->NumVouchIssued->TooltipValue = "";

		// VoucherStartNum
		$this->VoucherStartNum->LinkCustomAttributes = "";
		$this->VoucherStartNum->HrefValue = "";
		$this->VoucherStartNum->TooltipValue = "";

		// VoucherEndNum
		$this->VoucherEndNum->LinkCustomAttributes = "";
		$this->VoucherEndNum->HrefValue = "";
		$this->VoucherEndNum->TooltipValue = "";

		// trapper
		$this->trapper->LinkCustomAttributes = "";
		$this->trapper->HrefValue = "";
		$this->trapper->TooltipValue = "";

		// notes
		$this->notes->LinkCustomAttributes = "";
		$this->notes->HrefValue = "";
		$this->notes->TooltipValue = "";

		// sage
		$this->sage->LinkCustomAttributes = "";
		$this->sage->HrefValue = "";
		$this->sage->TooltipValue = "";

		// Inactive
		$this->Inactive->LinkCustomAttributes = "";
		$this->Inactive->HrefValue = "";
		$this->Inactive->TooltipValue = "";

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
					$XmlDoc->AddField('colony_id', $this->colony_id->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('colony_name', $this->colony_name->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('colony_address', $this->colony_address->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('colony_aptnum', $this->colony_aptnum->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('colony_city', $this->colony_city->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('colony_county', $this->colony_county->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('colony_zip', $this->colony_zip->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('NumVouchIssued', $this->NumVouchIssued->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('VoucherStartNum', $this->VoucherStartNum->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('VoucherEndNum', $this->VoucherEndNum->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('trapper', $this->trapper->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('notes', $this->notes->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('sage', $this->sage->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('Inactive', $this->Inactive->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('mod_by', $this->mod_by->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('mod_date', $this->mod_date->ExportValue($this->Export, $this->ExportOriginalValue));
				} else {
					$XmlDoc->AddField('colony_id', $this->colony_id->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('colony_name', $this->colony_name->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('colony_address', $this->colony_address->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('colony_aptnum', $this->colony_aptnum->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('colony_city', $this->colony_city->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('colony_county', $this->colony_county->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('colony_zip', $this->colony_zip->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('NumVouchIssued', $this->NumVouchIssued->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('VoucherStartNum', $this->VoucherStartNum->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('VoucherEndNum', $this->VoucherEndNum->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('trapper', $this->trapper->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('notes', $this->notes->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('sage', $this->sage->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('Inactive', $this->Inactive->ExportValue($this->Export, $this->ExportOriginalValue));
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
				$Doc->ExportCaption($this->colony_id);
				$Doc->ExportCaption($this->colony_name);
				$Doc->ExportCaption($this->colony_address);
				$Doc->ExportCaption($this->colony_aptnum);
				$Doc->ExportCaption($this->colony_city);
				$Doc->ExportCaption($this->colony_county);
				$Doc->ExportCaption($this->colony_zip);
				$Doc->ExportCaption($this->NumVouchIssued);
				$Doc->ExportCaption($this->VoucherStartNum);
				$Doc->ExportCaption($this->VoucherEndNum);
				$Doc->ExportCaption($this->trapper);
				$Doc->ExportCaption($this->notes);
				$Doc->ExportCaption($this->sage);
				$Doc->ExportCaption($this->Inactive);
				$Doc->ExportCaption($this->mod_by);
				$Doc->ExportCaption($this->mod_date);
			} else {
				$Doc->ExportCaption($this->colony_id);
				$Doc->ExportCaption($this->colony_name);
				$Doc->ExportCaption($this->colony_address);
				$Doc->ExportCaption($this->colony_aptnum);
				$Doc->ExportCaption($this->colony_city);
				$Doc->ExportCaption($this->colony_county);
				$Doc->ExportCaption($this->colony_zip);
				$Doc->ExportCaption($this->NumVouchIssued);
				$Doc->ExportCaption($this->VoucherStartNum);
				$Doc->ExportCaption($this->VoucherEndNum);
				$Doc->ExportCaption($this->trapper);
				$Doc->ExportCaption($this->notes);
				$Doc->ExportCaption($this->sage);
				$Doc->ExportCaption($this->Inactive);
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
					$Doc->ExportField($this->colony_id);
					$Doc->ExportField($this->colony_name);
					$Doc->ExportField($this->colony_address);
					$Doc->ExportField($this->colony_aptnum);
					$Doc->ExportField($this->colony_city);
					$Doc->ExportField($this->colony_county);
					$Doc->ExportField($this->colony_zip);
					$Doc->ExportField($this->NumVouchIssued);
					$Doc->ExportField($this->VoucherStartNum);
					$Doc->ExportField($this->VoucherEndNum);
					$Doc->ExportField($this->trapper);
					$Doc->ExportField($this->notes);
					$Doc->ExportField($this->sage);
					$Doc->ExportField($this->Inactive);
					$Doc->ExportField($this->mod_by);
					$Doc->ExportField($this->mod_date);
				} else {
					$Doc->ExportField($this->colony_id);
					$Doc->ExportField($this->colony_name);
					$Doc->ExportField($this->colony_address);
					$Doc->ExportField($this->colony_aptnum);
					$Doc->ExportField($this->colony_city);
					$Doc->ExportField($this->colony_county);
					$Doc->ExportField($this->colony_zip);
					$Doc->ExportField($this->NumVouchIssued);
					$Doc->ExportField($this->VoucherStartNum);
					$Doc->ExportField($this->VoucherEndNum);
					$Doc->ExportField($this->trapper);
					$Doc->ExportField($this->notes);
					$Doc->ExportField($this->sage);
					$Doc->ExportField($this->Inactive);
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
