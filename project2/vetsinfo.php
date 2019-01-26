<?php

// Global variable for table object
$vets = NULL;

//
// Table class for vets
//
class cvets {
	var $TableVar = 'vets';
	var $TableName = 'vets';
	var $TableType = 'TABLE';
	var $id;
	var $CountyServed;
	var $Clinic;
	var $Vet;
	var $Address;
	var $MailingAddress;
	var $City;
	var $Zip;
	var $County;
	var $Phone;
	var $Fax;
	var $AllCatsFee;
	var $AllMaleDogs;
	var $FemDogsUnder75;
	var $FemDogsOver75;
	var $AllFeralMaleCats;
	var $AllFeralFemaleCats;
	var $Comments;
	var $Active;
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
	function cvets() {
		global $Language;
		$AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row

		// id
		$this->id = new cField('vets', 'vets', 'x_id', 'id', '`id`', 21, -1, FALSE, '`id`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] =& $this->id;

		// CountyServed
		$this->CountyServed = new cField('vets', 'vets', 'x_CountyServed', 'CountyServed', '`CountyServed`', 200, -1, FALSE, '`CountyServed`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['CountyServed'] =& $this->CountyServed;

		// Clinic
		$this->Clinic = new cField('vets', 'vets', 'x_Clinic', 'Clinic', '`Clinic`', 200, -1, FALSE, '`Clinic`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Clinic'] =& $this->Clinic;

		// Vet
		$this->Vet = new cField('vets', 'vets', 'x_Vet', 'Vet', '`Vet`', 200, -1, FALSE, '`Vet`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Vet'] =& $this->Vet;

		// Address
		$this->Address = new cField('vets', 'vets', 'x_Address', 'Address', '`Address`', 200, -1, FALSE, '`Address`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Address'] =& $this->Address;

		// MailingAddress
		$this->MailingAddress = new cField('vets', 'vets', 'x_MailingAddress', 'MailingAddress', '`MailingAddress`', 200, -1, FALSE, '`MailingAddress`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['MailingAddress'] =& $this->MailingAddress;

		// City
		$this->City = new cField('vets', 'vets', 'x_City', 'City', '`City`', 200, -1, FALSE, '`City`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['City'] =& $this->City;

		// Zip
		$this->Zip = new cField('vets', 'vets', 'x_Zip', 'Zip', '`Zip`', 3, -1, FALSE, '`Zip`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->Zip->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Zip'] =& $this->Zip;

		// County
		$this->County = new cField('vets', 'vets', 'x_County', 'County', '`County`', 200, -1, FALSE, '`County`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['County'] =& $this->County;

		// Phone
		$this->Phone = new cField('vets', 'vets', 'x_Phone', 'Phone', '`Phone`', 200, -1, FALSE, '`Phone`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Phone'] =& $this->Phone;

		// Fax
		$this->Fax = new cField('vets', 'vets', 'x_Fax', 'Fax', '`Fax`', 200, -1, FALSE, '`Fax`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Fax'] =& $this->Fax;

		// AllCatsFee
		$this->AllCatsFee = new cField('vets', 'vets', 'x_AllCatsFee', 'AllCatsFee', '`AllCatsFee`', 200, -1, FALSE, '`AllCatsFee`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['AllCatsFee'] =& $this->AllCatsFee;

		// AllMaleDogs
		$this->AllMaleDogs = new cField('vets', 'vets', 'x_AllMaleDogs', 'AllMaleDogs', '`AllMaleDogs`', 200, -1, FALSE, '`AllMaleDogs`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['AllMaleDogs'] =& $this->AllMaleDogs;

		// FemDogsUnder75
		$this->FemDogsUnder75 = new cField('vets', 'vets', 'x_FemDogsUnder75', 'FemDogsUnder75', '`FemDogsUnder75`', 200, -1, FALSE, '`FemDogsUnder75`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['FemDogsUnder75'] =& $this->FemDogsUnder75;

		// FemDogsOver75
		$this->FemDogsOver75 = new cField('vets', 'vets', 'x_FemDogsOver75', 'FemDogsOver75', '`FemDogsOver75`', 200, -1, FALSE, '`FemDogsOver75`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['FemDogsOver75'] =& $this->FemDogsOver75;

		// AllFeralMaleCats
		$this->AllFeralMaleCats = new cField('vets', 'vets', 'x_AllFeralMaleCats', 'AllFeralMaleCats', '`AllFeralMaleCats`', 200, -1, FALSE, '`AllFeralMaleCats`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['AllFeralMaleCats'] =& $this->AllFeralMaleCats;

		// AllFeralFemaleCats
		$this->AllFeralFemaleCats = new cField('vets', 'vets', 'x_AllFeralFemaleCats', 'AllFeralFemaleCats', '`AllFeralFemaleCats`', 200, -1, FALSE, '`AllFeralFemaleCats`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['AllFeralFemaleCats'] =& $this->AllFeralFemaleCats;

		// Comments
		$this->Comments = new cField('vets', 'vets', 'x_Comments', 'Comments', '`Comments`', 200, -1, FALSE, '`Comments`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Comments'] =& $this->Comments;

		// Active
		$this->Active = new cField('vets', 'vets', 'x_Active', 'Active', '`Active`', 200, -1, FALSE, '`Active`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Active'] =& $this->Active;
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
		return "vets_Highlight";
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

	// Table level SQL
	function SqlFrom() { // From
		return "`vets`";
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
		return "";
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
		return "INSERT INTO `vets` ($names) VALUES ($values)";
	}

	// UPDATE statement
	function UpdateSQL(&$rs) {
		global $conn;
		$SQL = "UPDATE `vets` SET ";
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
		$SQL = "DELETE FROM `vets` WHERE ";
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
			return "vetslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function ListUrl() {
		return "vetslist.php";
	}

	// View URL
	function ViewUrl() {
		return $this->KeyUrl("vetsview.php", $this->UrlParm());
	}

	// Add URL
	function AddUrl() {
		$AddUrl = "vetsadd.php";

//		$sUrlParm = $this->UrlParm();
//		if ($sUrlParm <> "")
//			$AddUrl .= "?" . $sUrlParm;

		return $AddUrl;
	}

	// Edit URL
	function EditUrl($parm = "") {
		return $this->KeyUrl("vetsedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function InlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function CopyUrl($parm = "") {
		return $this->KeyUrl("vetsadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function InlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function DeleteUrl() {
		return $this->KeyUrl("vetsdelete.php", $this->UrlParm());
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
		$UrlParm = ($this->UseTokenInUrl) ? "t=vets" : "";
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
		$this->CountyServed->setDbValue($rs->fields('CountyServed'));
		$this->Clinic->setDbValue($rs->fields('Clinic'));
		$this->Vet->setDbValue($rs->fields('Vet'));
		$this->Address->setDbValue($rs->fields('Address'));
		$this->MailingAddress->setDbValue($rs->fields('MailingAddress'));
		$this->City->setDbValue($rs->fields('City'));
		$this->Zip->setDbValue($rs->fields('Zip'));
		$this->County->setDbValue($rs->fields('County'));
		$this->Phone->setDbValue($rs->fields('Phone'));
		$this->Fax->setDbValue($rs->fields('Fax'));
		$this->AllCatsFee->setDbValue($rs->fields('AllCatsFee'));
		$this->AllMaleDogs->setDbValue($rs->fields('AllMaleDogs'));
		$this->FemDogsUnder75->setDbValue($rs->fields('FemDogsUnder75'));
		$this->FemDogsOver75->setDbValue($rs->fields('FemDogsOver75'));
		$this->AllFeralMaleCats->setDbValue($rs->fields('AllFeralMaleCats'));
		$this->AllFeralFemaleCats->setDbValue($rs->fields('AllFeralFemaleCats'));
		$this->Comments->setDbValue($rs->fields('Comments'));
		$this->Active->setDbValue($rs->fields('Active'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
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
		// id

		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// CountyServed
		$this->CountyServed->ViewValue = $this->CountyServed->CurrentValue;
		$this->CountyServed->ViewCustomAttributes = "";

		// Clinic
		$this->Clinic->ViewValue = $this->Clinic->CurrentValue;
		$this->Clinic->ViewCustomAttributes = "";

		// Vet
		$this->Vet->ViewValue = $this->Vet->CurrentValue;
		$this->Vet->ViewCustomAttributes = "";

		// Address
		$this->Address->ViewValue = $this->Address->CurrentValue;
		$this->Address->ViewCustomAttributes = "";

		// MailingAddress
		$this->MailingAddress->ViewValue = $this->MailingAddress->CurrentValue;
		$this->MailingAddress->ViewCustomAttributes = "";

		// City
		$this->City->ViewValue = $this->City->CurrentValue;
		$this->City->ViewCustomAttributes = "";

		// Zip
		$this->Zip->ViewValue = $this->Zip->CurrentValue;
		$this->Zip->ViewCustomAttributes = "";

		// County
		$this->County->ViewValue = $this->County->CurrentValue;
		$this->County->ViewCustomAttributes = "";

		// Phone
		$this->Phone->ViewValue = $this->Phone->CurrentValue;
		$this->Phone->ViewCustomAttributes = "";

		// Fax
		$this->Fax->ViewValue = $this->Fax->CurrentValue;
		$this->Fax->ViewCustomAttributes = "";

		// AllCatsFee
		$this->AllCatsFee->ViewValue = $this->AllCatsFee->CurrentValue;
		$this->AllCatsFee->ViewCustomAttributes = "";

		// AllMaleDogs
		$this->AllMaleDogs->ViewValue = $this->AllMaleDogs->CurrentValue;
		$this->AllMaleDogs->ViewCustomAttributes = "";

		// FemDogsUnder75
		$this->FemDogsUnder75->ViewValue = $this->FemDogsUnder75->CurrentValue;
		$this->FemDogsUnder75->ViewCustomAttributes = "";

		// FemDogsOver75
		$this->FemDogsOver75->ViewValue = $this->FemDogsOver75->CurrentValue;
		$this->FemDogsOver75->ViewCustomAttributes = "";

		// AllFeralMaleCats
		$this->AllFeralMaleCats->ViewValue = $this->AllFeralMaleCats->CurrentValue;
		$this->AllFeralMaleCats->ViewCustomAttributes = "";

		// AllFeralFemaleCats
		$this->AllFeralFemaleCats->ViewValue = $this->AllFeralFemaleCats->CurrentValue;
		$this->AllFeralFemaleCats->ViewCustomAttributes = "";

		// Comments
		$this->Comments->ViewValue = $this->Comments->CurrentValue;
		$this->Comments->ViewCustomAttributes = "";

		// Active
		$this->Active->ViewValue = $this->Active->CurrentValue;
		$this->Active->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// CountyServed
		$this->CountyServed->LinkCustomAttributes = "";
		$this->CountyServed->HrefValue = "";
		$this->CountyServed->TooltipValue = "";

		// Clinic
		$this->Clinic->LinkCustomAttributes = "";
		$this->Clinic->HrefValue = "";
		$this->Clinic->TooltipValue = "";

		// Vet
		$this->Vet->LinkCustomAttributes = "";
		$this->Vet->HrefValue = "";
		$this->Vet->TooltipValue = "";

		// Address
		$this->Address->LinkCustomAttributes = "";
		$this->Address->HrefValue = "";
		$this->Address->TooltipValue = "";

		// MailingAddress
		$this->MailingAddress->LinkCustomAttributes = "";
		$this->MailingAddress->HrefValue = "";
		$this->MailingAddress->TooltipValue = "";

		// City
		$this->City->LinkCustomAttributes = "";
		$this->City->HrefValue = "";
		$this->City->TooltipValue = "";

		// Zip
		$this->Zip->LinkCustomAttributes = "";
		$this->Zip->HrefValue = "";
		$this->Zip->TooltipValue = "";

		// County
		$this->County->LinkCustomAttributes = "";
		$this->County->HrefValue = "";
		$this->County->TooltipValue = "";

		// Phone
		$this->Phone->LinkCustomAttributes = "";
		$this->Phone->HrefValue = "";
		$this->Phone->TooltipValue = "";

		// Fax
		$this->Fax->LinkCustomAttributes = "";
		$this->Fax->HrefValue = "";
		$this->Fax->TooltipValue = "";

		// AllCatsFee
		$this->AllCatsFee->LinkCustomAttributes = "";
		$this->AllCatsFee->HrefValue = "";
		$this->AllCatsFee->TooltipValue = "";

		// AllMaleDogs
		$this->AllMaleDogs->LinkCustomAttributes = "";
		$this->AllMaleDogs->HrefValue = "";
		$this->AllMaleDogs->TooltipValue = "";

		// FemDogsUnder75
		$this->FemDogsUnder75->LinkCustomAttributes = "";
		$this->FemDogsUnder75->HrefValue = "";
		$this->FemDogsUnder75->TooltipValue = "";

		// FemDogsOver75
		$this->FemDogsOver75->LinkCustomAttributes = "";
		$this->FemDogsOver75->HrefValue = "";
		$this->FemDogsOver75->TooltipValue = "";

		// AllFeralMaleCats
		$this->AllFeralMaleCats->LinkCustomAttributes = "";
		$this->AllFeralMaleCats->HrefValue = "";
		$this->AllFeralMaleCats->TooltipValue = "";

		// AllFeralFemaleCats
		$this->AllFeralFemaleCats->LinkCustomAttributes = "";
		$this->AllFeralFemaleCats->HrefValue = "";
		$this->AllFeralFemaleCats->TooltipValue = "";

		// Comments
		$this->Comments->LinkCustomAttributes = "";
		$this->Comments->HrefValue = "";
		$this->Comments->TooltipValue = "";

		// Active
		$this->Active->LinkCustomAttributes = "";
		$this->Active->HrefValue = "";
		$this->Active->TooltipValue = "";

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
					$XmlDoc->AddField('CountyServed', $this->CountyServed->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('Clinic', $this->Clinic->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('Vet', $this->Vet->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('Address', $this->Address->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('MailingAddress', $this->MailingAddress->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('City', $this->City->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('Zip', $this->Zip->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('County', $this->County->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('Phone', $this->Phone->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('Fax', $this->Fax->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('AllCatsFee', $this->AllCatsFee->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('AllMaleDogs', $this->AllMaleDogs->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('FemDogsUnder75', $this->FemDogsUnder75->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('FemDogsOver75', $this->FemDogsOver75->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('AllFeralMaleCats', $this->AllFeralMaleCats->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('AllFeralFemaleCats', $this->AllFeralFemaleCats->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('Comments', $this->Comments->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('Active', $this->Active->ExportValue($this->Export, $this->ExportOriginalValue));
				} else {
					$XmlDoc->AddField('id', $this->id->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('CountyServed', $this->CountyServed->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('Clinic', $this->Clinic->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('Vet', $this->Vet->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('Address', $this->Address->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('MailingAddress', $this->MailingAddress->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('City', $this->City->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('Zip', $this->Zip->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('County', $this->County->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('Phone', $this->Phone->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('Fax', $this->Fax->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('AllCatsFee', $this->AllCatsFee->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('AllMaleDogs', $this->AllMaleDogs->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('FemDogsUnder75', $this->FemDogsUnder75->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('FemDogsOver75', $this->FemDogsOver75->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('AllFeralMaleCats', $this->AllFeralMaleCats->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('AllFeralFemaleCats', $this->AllFeralFemaleCats->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('Comments', $this->Comments->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('Active', $this->Active->ExportValue($this->Export, $this->ExportOriginalValue));
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
				$Doc->ExportCaption($this->CountyServed);
				$Doc->ExportCaption($this->Clinic);
				$Doc->ExportCaption($this->Vet);
				$Doc->ExportCaption($this->Address);
				$Doc->ExportCaption($this->MailingAddress);
				$Doc->ExportCaption($this->City);
				$Doc->ExportCaption($this->Zip);
				$Doc->ExportCaption($this->County);
				$Doc->ExportCaption($this->Phone);
				$Doc->ExportCaption($this->Fax);
				$Doc->ExportCaption($this->AllCatsFee);
				$Doc->ExportCaption($this->AllMaleDogs);
				$Doc->ExportCaption($this->FemDogsUnder75);
				$Doc->ExportCaption($this->FemDogsOver75);
				$Doc->ExportCaption($this->AllFeralMaleCats);
				$Doc->ExportCaption($this->AllFeralFemaleCats);
				$Doc->ExportCaption($this->Comments);
				$Doc->ExportCaption($this->Active);
			} else {
				$Doc->ExportCaption($this->id);
				$Doc->ExportCaption($this->CountyServed);
				$Doc->ExportCaption($this->Clinic);
				$Doc->ExportCaption($this->Vet);
				$Doc->ExportCaption($this->Address);
				$Doc->ExportCaption($this->MailingAddress);
				$Doc->ExportCaption($this->City);
				$Doc->ExportCaption($this->Zip);
				$Doc->ExportCaption($this->County);
				$Doc->ExportCaption($this->Phone);
				$Doc->ExportCaption($this->Fax);
				$Doc->ExportCaption($this->AllCatsFee);
				$Doc->ExportCaption($this->AllMaleDogs);
				$Doc->ExportCaption($this->FemDogsUnder75);
				$Doc->ExportCaption($this->FemDogsOver75);
				$Doc->ExportCaption($this->AllFeralMaleCats);
				$Doc->ExportCaption($this->AllFeralFemaleCats);
				$Doc->ExportCaption($this->Comments);
				$Doc->ExportCaption($this->Active);
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
					$Doc->ExportField($this->CountyServed);
					$Doc->ExportField($this->Clinic);
					$Doc->ExportField($this->Vet);
					$Doc->ExportField($this->Address);
					$Doc->ExportField($this->MailingAddress);
					$Doc->ExportField($this->City);
					$Doc->ExportField($this->Zip);
					$Doc->ExportField($this->County);
					$Doc->ExportField($this->Phone);
					$Doc->ExportField($this->Fax);
					$Doc->ExportField($this->AllCatsFee);
					$Doc->ExportField($this->AllMaleDogs);
					$Doc->ExportField($this->FemDogsUnder75);
					$Doc->ExportField($this->FemDogsOver75);
					$Doc->ExportField($this->AllFeralMaleCats);
					$Doc->ExportField($this->AllFeralFemaleCats);
					$Doc->ExportField($this->Comments);
					$Doc->ExportField($this->Active);
				} else {
					$Doc->ExportField($this->id);
					$Doc->ExportField($this->CountyServed);
					$Doc->ExportField($this->Clinic);
					$Doc->ExportField($this->Vet);
					$Doc->ExportField($this->Address);
					$Doc->ExportField($this->MailingAddress);
					$Doc->ExportField($this->City);
					$Doc->ExportField($this->Zip);
					$Doc->ExportField($this->County);
					$Doc->ExportField($this->Phone);
					$Doc->ExportField($this->Fax);
					$Doc->ExportField($this->AllCatsFee);
					$Doc->ExportField($this->AllMaleDogs);
					$Doc->ExportField($this->FemDogsUnder75);
					$Doc->ExportField($this->FemDogsOver75);
					$Doc->ExportField($this->AllFeralMaleCats);
					$Doc->ExportField($this->AllFeralFemaleCats);
					$Doc->ExportField($this->Comments);
					$Doc->ExportField($this->Active);
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

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

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
}
?>
