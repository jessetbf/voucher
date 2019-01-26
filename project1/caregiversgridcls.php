<?php

//
// Page class
//
class ccaregivers_grid {

	// Page ID
	var $PageID = 'grid';

	// Table name
	var $TableName = 'caregivers';

	// Page object name
	var $PageObjName = 'caregivers_grid';

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
	function ccaregivers_grid() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (caregivers)
		if (!isset($GLOBALS["caregivers"])) {
			$GLOBALS["caregivers"] = new ccaregivers();

//			$GLOBALS["MasterTable"] =& $GLOBALS["Table"];
			$GLOBALS["Table"] =& $GLOBALS["caregivers"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'grid', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'caregivers', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();

		// List options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;
		global $caregivers;

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$caregivers->GridAddRowCount = $gridaddcnt;

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
		global $caregivers;

//		$GLOBALS["Table"] =& $GLOBALS["MasterTable"];
		if ($url == "")
			return;

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();
		$this->Page_Redirecting($url);

		// Go to URL if specified
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
	var $RowOldKey = ""; // Row old key (for copy)
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
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security, $caregivers;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";
		if ($this->IsPageRequest()) { // Validate request

			// Handle reset command
			$this->ResetCmd();

			// Set up master detail parameters
			$this->SetUpMasterParms();

			// Hide all options
			if ($caregivers->Export <> "" ||
				$caregivers->CurrentAction == "gridadd" ||
				$caregivers->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
			}

			// Show grid delete link for grid add / grid edit
			if ($caregivers->AllowAddDeleteRow) {
				if ($caregivers->CurrentAction == "gridadd" ||
					$caregivers->CurrentAction == "gridedit") {
					$item = $this->ListOptions->GetItem("griddelete");
					if ($item) $item->Visible = TRUE;
				}
			}

			// Set up sorting order
			$this->SetUpSortOrder();
		}

		// Restore display records
		if ($caregivers->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $caregivers->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build filter
		$sFilter = "";

		// Restore master/detail filter
		$this->DbMasterFilter = $caregivers->getMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $caregivers->getDetailFilter(); // Restore detail filter
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Load master record
		if ($caregivers->getMasterFilter() <> "" && $caregivers->getCurrentMasterTable() == "colonies") {
			global $colonies;
			$rsmaster = $colonies->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate($caregivers->getReturnUrl()); // Return to caller
			} else {
				$colonies->LoadListRowValues($rsmaster);
				$colonies->RowType = EW_ROWTYPE_MASTER; // Master row
				$colonies->RenderListRow();
				$rsmaster->Close();
			}
		}

		// Set up filter in session
		$caregivers->setSessionWhere($sFilter);
		$caregivers->CurrentFilter = "";
	}

	//  Exit inline mode
	function ClearInlineMode() {
		global $caregivers;
		$caregivers->LastAction = $caregivers->CurrentAction; // Save last action
		$caregivers->CurrentAction = ""; // Clear action
		$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Grid Add mode
	function GridAddMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridadd"; // Enabled grid add
	}

	// Switch to Grid Edit mode
	function GridEditMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridedit"; // Enable grid edit
	}

	// Perform update to grid
	function GridUpdate() {
		global $conn, $Language, $objForm, $gsFormError, $caregivers;
		$bGridUpdate = TRUE;

		// Get old recordset
		$caregivers->CurrentFilter = $this->BuildKeyFilter();
		$sSql = $caregivers->SQL();
		if ($rs = $conn->Execute($sSql)) {
			$rsold = $rs->GetRows();
			$rs->Close();
		}
		$sKey = "";

		// Update row index and get row key
		$objForm->Index = 0;
		$rowcnt = strval($objForm->GetValue("key_count"));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Update all rows based on key
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
			$objForm->Index = $rowindex;
			$rowkey = strval($objForm->GetValue("k_key"));
			$rowaction = strval($objForm->GetValue("k_action"));

			// Load all values and keys
			if ($rowaction <> "insertdelete") { // Skip insert then deleted rows
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
					$bGridUpdate = $this->SetupKeyValues($rowkey); // Set up key values
				} else {
					$bGridUpdate = TRUE;
				}

				// Skip empty row
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// No action required
				// Validate form and insert/update/delete record

				} elseif ($bGridUpdate) {
					if ($rowaction == "delete") {
						$caregivers->CurrentFilter = $caregivers->KeyFilter();
						$bGridUpdate = $this->DeleteRows(); // Delete this row
					} else if (!$this->ValidateForm()) {
						$bGridUpdate = FALSE; // Form error, reset action
						$this->setFailureMessage($gsFormError);
					} else {
						if ($rowaction == "insert") {
							$bGridUpdate = $this->AddRow(); // Insert this row
						} else {
							if ($rowkey <> "") {
								$caregivers->SendEmail = FALSE; // Do not send email on update success
								$bGridUpdate = $this->EditRow(); // Update this row
							}
						} // End update
					}
				}
				if ($bGridUpdate) {
					if ($sKey <> "") $sKey .= ", ";
					$sKey .= $rowkey;
				} else {
					break;
				}
			}
		}
		if ($bGridUpdate) {

			// Get new recordset
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
			$caregivers->EventCancelled = TRUE; // Set event cancelled
			$caregivers->CurrentAction = "gridedit"; // Stay in Grid Edit mode
		}
		return $bGridUpdate;
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm, $caregivers;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue("k_key"));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $caregivers->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue("k_key"));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		global $caregivers;
		$arrKeyFlds = explode(EW_COMPOSITE_KEY_SEPARATOR, $key);
		if (count($arrKeyFlds) >= 1) {
			$caregivers->caregiver_id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($caregivers->caregiver_id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Perform Grid Add
	function GridInsert() {
		global $conn, $Language, $objForm, $gsFormError, $caregivers;
		$rowindex = 1;
		$bGridInsert = FALSE;

		// Init key filter
		$sWrkFilter = "";
		$addcnt = 0;
		$sKey = "";

		// Get row count
		$objForm->Index = 0;
		$rowcnt = strval($objForm->GetValue("key_count"));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Insert all rows
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue("k_action"));
			if ($rowaction <> "" && $rowaction <> "insert")
				continue; // Skip
			if ($rowaction == "insert") {
				$this->RowOldKey = strval($objForm->GetValue("k_oldkey"));
				$this->LoadOldRecord(); // Load old recordset
			}
			$this->LoadFormValues(); // Get form values
			if (!$this->EmptyRow()) {
				$addcnt++;
				$caregivers->SendEmail = FALSE; // Do not send email on insert success

				// Validate form
				if (!$this->ValidateForm()) {
					$bGridInsert = FALSE; // Form error, reset action
					$this->setFailureMessage($gsFormError);
				} else {
					$bGridInsert = $this->AddRow($this->OldRecordset); // Insert this row
				}
				if ($bGridInsert) {
					if ($sKey <> "") $sKey .= EW_COMPOSITE_KEY_SEPARATOR;
					$sKey .= $caregivers->caregiver_id->CurrentValue;

					// Add filter for this record
					$sFilter = $caregivers->KeyFilter();
					if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
					$sWrkFilter .= $sFilter;
				} else {
					break;
				}
			}
		}
		if ($addcnt == 0) { // No record inserted
			$this->ClearInlineMode(); // Clear grid add mode and return
			return TRUE;
		}
		if ($bGridInsert) {

			// Get new recordset
			$caregivers->CurrentFilter = $sWrkFilter;
			$sSql = $caregivers->SQL();
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}
			$this->ClearInlineMode(); // Clear grid add mode
		} else {
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("InsertFailed")); // Set insert failed message
			}
			$caregivers->EventCancelled = TRUE; // Set event cancelled
			$caregivers->CurrentAction = "gridadd"; // Stay in gridadd mode
		}
		return $bGridInsert;
	}

	// Check if empty row
	function EmptyRow() {
		global $caregivers, $objForm;
		if ($objForm->HasValue("x_first_name") && $objForm->HasValue("o_first_name") && $caregivers->first_name->CurrentValue <> $caregivers->first_name->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_last_name") && $objForm->HasValue("o_last_name") && $caregivers->last_name->CurrentValue <> $caregivers->last_name->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_day_phone") && $objForm->HasValue("o_day_phone") && $caregivers->day_phone->CurrentValue <> $caregivers->day_phone->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_other_phone") && $objForm->HasValue("o_other_phone") && $caregivers->other_phone->CurrentValue <> $caregivers->other_phone->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_zemail") && $objForm->HasValue("o_zemail") && $caregivers->zemail->CurrentValue <> $caregivers->zemail->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_address") && $objForm->HasValue("o_address") && $caregivers->address->CurrentValue <> $caregivers->address->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_apt_num") && $objForm->HasValue("o_apt_num") && $caregivers->apt_num->CurrentValue <> $caregivers->apt_num->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_city") && $objForm->HasValue("o_city") && $caregivers->city->CurrentValue <> $caregivers->city->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_county") && $objForm->HasValue("o_county") && $caregivers->county->CurrentValue <> $caregivers->county->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_zip") && $objForm->HasValue("o_zip") && $caregivers->zip->CurrentValue <> $caregivers->zip->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_num_deps") && $objForm->HasValue("o_num_deps") && $caregivers->num_deps->CurrentValue <> $caregivers->num_deps->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_annual_income") && $objForm->HasValue("o_annual_income") && $caregivers->annual_income->CurrentValue <> $caregivers->annual_income->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_app_source") && $objForm->HasValue("o_app_source") && $caregivers->app_source->CurrentValue <> $caregivers->app_source->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_dl") && $objForm->HasValue("o_dl") && $caregivers->dl->CurrentValue <> $caregivers->dl->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_app_date") && $objForm->HasValue("o_app_date") && $caregivers->app_date->CurrentValue <> $caregivers->app_date->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Expiration") && $objForm->HasValue("o_Expiration") && $caregivers->Expiration->CurrentValue <> $caregivers->Expiration->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_ClinicGroup") && $objForm->HasValue("o_ClinicGroup") && $caregivers->ClinicGroup->CurrentValue <> $caregivers->ClinicGroup->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_DateSent") && $objForm->HasValue("o_DateSent") && $caregivers->DateSent->CurrentValue <> $caregivers->DateSent->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_budget_category") && $objForm->HasValue("o_budget_category") && $caregivers->budget_category->CurrentValue <> $caregivers->budget_category->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_AgeOfApplicant") && $objForm->HasValue("o_AgeOfApplicant") && $caregivers->AgeOfApplicant->CurrentValue <> $caregivers->AgeOfApplicant->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Applic") && $objForm->HasValue("o_Applic") && $caregivers->Applic->CurrentValue <> $caregivers->Applic->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_SubApplic") && $objForm->HasValue("o_SubApplic") && $caregivers->SubApplic->CurrentValue <> $caregivers->SubApplic->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_DateSigned") && $objForm->HasValue("o_DateSigned") && $caregivers->DateSigned->CurrentValue <> $caregivers->DateSigned->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_colony_id") && $objForm->HasValue("o_colony_id") && $caregivers->colony_id->CurrentValue <> $caregivers->colony_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_mod_by") && $objForm->HasValue("o_mod_by") && $caregivers->mod_by->CurrentValue <> $caregivers->mod_by->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_mod_date") && $objForm->HasValue("o_mod_date") && $caregivers->mod_date->CurrentValue <> $caregivers->mod_date->OldValue)
			return FALSE;
		return TRUE;
	}

	// Validate grid form
	function ValidateGridForm() {
		global $objForm;

		// Get row count
		$objForm->Index = 0;
		$rowcnt = strval($objForm->GetValue("key_count"));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Validate all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue("k_action"));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else if (!$this->ValidateForm()) {
					return FALSE;
				}
			}
		}
		return TRUE;
	}

	// Restore form values for current row
	function RestoreCurrentRowFormValues($idx) {
		global $objForm, $caregivers;

		// Get row based on current index
		$objForm->Index = $idx;
		$this->LoadFormValues(); // Load form values
	}

	// Set up sort parameters
	function SetUpSortOrder() {
		global $caregivers;

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$caregivers->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$caregivers->CurrentOrderType = @$_GET["ordertype"];
			$caregivers->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		global $caregivers;
		$sOrderBy = $caregivers->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($caregivers->SqlOrderBy() <> "") {
				$sOrderBy = $caregivers->SqlOrderBy();
				$caregivers->setSessionOrderBy($sOrderBy);
				$caregivers->caregiver_id->setSort("DESC");
			}
		}
	}

	// Reset command
	// cmd=reset (Reset search parameters)
	// cmd=resetall (Reset search and master/detail parameters)
	// cmd=resetsort (Reset sort parameters)
	function ResetCmd() {
		global $caregivers;

		// Get reset command
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset master/detail keys
			if (strtolower($sCmd) == "resetall") {
				$caregivers->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$caregivers->colony_id->setSessionValue("");
			}

			// Reset sorting order
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$caregivers->setSessionOrderBy($sOrderBy);
			}

			// Reset start position
			$this->StartRec = 1;
			$caregivers->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language, $caregivers;

		// "griddelete"
		if ($caregivers->AllowAddDeleteRow) {
			$item =& $this->ListOptions->Add("griddelete");
			$item->CssStyle = "white-space: nowrap;";
			$item->OnLeft = TRUE;
			$item->Visible = FALSE; // Default hidden
		}

		// Call ListOptions_Load event
		$this->ListOptions_Load();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $caregivers, $objForm;
		$this->ListOptions->LoadDefault();

		// Set up row action and key
		if (is_numeric($this->RowIndex)) {
			$objForm->Index = $this->RowIndex;
			if ($this->RowAction <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_action\" id=\"k" . $this->RowIndex . "_action\" value=\"" . $this->RowAction . "\">";
			if ($objForm->HasValue("k_oldkey"))
				$this->RowOldKey = strval($objForm->GetValue("k_oldkey"));
			if ($this->RowOldKey <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_oldkey\" id=\"k" . $this->RowIndex . "_oldkey\" value=\"" . ew_HtmlEncode($this->RowOldKey) . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $objForm->GetValue("k_key");
				$this->SetupKeyValues($rowkey);
			}
			if ($this->RowAction == "insert" && $caregivers->CurrentAction == "F" && $this->EmptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_blankrow\" id=\"k" . $this->RowIndex . "_blankrow\" value=\"1\">";
		}

		// "delete"
		if ($caregivers->AllowAddDeleteRow) {
			if ($caregivers->CurrentMode == "add" || $caregivers->CurrentMode == "copy" || $caregivers->CurrentMode == "edit") {
				$oListOpt =& $this->ListOptions->Items["griddelete"];
				$oListOpt->Body = "<a class=\"ewGridLink\" href=\"javascript:void(0);\" onclick=\"ew_DeleteGridRow(this, caregivers_grid, " . $this->RowIndex . ");\">" . $Language->Phrase("DeleteLink") . "</a>";
			}
		}
		if ($caregivers->CurrentMode == "edit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . $caregivers->caregiver_id->CurrentValue . "\">";
		}
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set record key
	function SetRecordKey(&$key, $rs) {
		$key = "";
		if ($key <> "") $key .= EW_COMPOSITE_KEY_SEPARATOR;
		$key .= $rs->fields('caregiver_id');
	}

	function RenderListOptionsExt() {
		global $Security, $Language, $caregivers;
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $caregivers;
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$caregivers->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$caregivers->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $caregivers->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$caregivers->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$caregivers->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$caregivers->setStartRecordNumber($this->StartRec);
		}
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
		$caregivers->caregiver_id->CurrentValue = NULL;
		$caregivers->caregiver_id->OldValue = $caregivers->caregiver_id->CurrentValue;
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
		if (!$caregivers->caregiver_id->FldIsDetailKey && $caregivers->CurrentAction <> "gridadd" && $caregivers->CurrentAction <> "add")
			$caregivers->caregiver_id->setFormValue($objForm->GetValue("x_caregiver_id"));
		if (!$caregivers->first_name->FldIsDetailKey) {
			$caregivers->first_name->setFormValue($objForm->GetValue("x_first_name"));
		}
		$caregivers->first_name->setOldValue($objForm->GetValue("o_first_name"));
		if (!$caregivers->last_name->FldIsDetailKey) {
			$caregivers->last_name->setFormValue($objForm->GetValue("x_last_name"));
		}
		$caregivers->last_name->setOldValue($objForm->GetValue("o_last_name"));
		if (!$caregivers->day_phone->FldIsDetailKey) {
			$caregivers->day_phone->setFormValue($objForm->GetValue("x_day_phone"));
		}
		$caregivers->day_phone->setOldValue($objForm->GetValue("o_day_phone"));
		if (!$caregivers->other_phone->FldIsDetailKey) {
			$caregivers->other_phone->setFormValue($objForm->GetValue("x_other_phone"));
		}
		$caregivers->other_phone->setOldValue($objForm->GetValue("o_other_phone"));
		if (!$caregivers->zemail->FldIsDetailKey) {
			$caregivers->zemail->setFormValue($objForm->GetValue("x_zemail"));
		}
		$caregivers->zemail->setOldValue($objForm->GetValue("o_zemail"));
		if (!$caregivers->address->FldIsDetailKey) {
			$caregivers->address->setFormValue($objForm->GetValue("x_address"));
		}
		$caregivers->address->setOldValue($objForm->GetValue("o_address"));
		if (!$caregivers->apt_num->FldIsDetailKey) {
			$caregivers->apt_num->setFormValue($objForm->GetValue("x_apt_num"));
		}
		$caregivers->apt_num->setOldValue($objForm->GetValue("o_apt_num"));
		if (!$caregivers->city->FldIsDetailKey) {
			$caregivers->city->setFormValue($objForm->GetValue("x_city"));
		}
		$caregivers->city->setOldValue($objForm->GetValue("o_city"));
		if (!$caregivers->county->FldIsDetailKey) {
			$caregivers->county->setFormValue($objForm->GetValue("x_county"));
		}
		$caregivers->county->setOldValue($objForm->GetValue("o_county"));
		if (!$caregivers->zip->FldIsDetailKey) {
			$caregivers->zip->setFormValue($objForm->GetValue("x_zip"));
		}
		$caregivers->zip->setOldValue($objForm->GetValue("o_zip"));
		if (!$caregivers->num_deps->FldIsDetailKey) {
			$caregivers->num_deps->setFormValue($objForm->GetValue("x_num_deps"));
		}
		$caregivers->num_deps->setOldValue($objForm->GetValue("o_num_deps"));
		if (!$caregivers->annual_income->FldIsDetailKey) {
			$caregivers->annual_income->setFormValue($objForm->GetValue("x_annual_income"));
		}
		$caregivers->annual_income->setOldValue($objForm->GetValue("o_annual_income"));
		if (!$caregivers->app_source->FldIsDetailKey) {
			$caregivers->app_source->setFormValue($objForm->GetValue("x_app_source"));
		}
		$caregivers->app_source->setOldValue($objForm->GetValue("o_app_source"));
		if (!$caregivers->dl->FldIsDetailKey) {
			$caregivers->dl->setFormValue($objForm->GetValue("x_dl"));
		}
		$caregivers->dl->setOldValue($objForm->GetValue("o_dl"));
		if (!$caregivers->app_date->FldIsDetailKey) {
			$caregivers->app_date->setFormValue($objForm->GetValue("x_app_date"));
			$caregivers->app_date->CurrentValue = ew_UnFormatDateTime($caregivers->app_date->CurrentValue, 5);
		}
		$caregivers->app_date->setOldValue($objForm->GetValue("o_app_date"));
		if (!$caregivers->Expiration->FldIsDetailKey) {
			$caregivers->Expiration->setFormValue($objForm->GetValue("x_Expiration"));
			$caregivers->Expiration->CurrentValue = ew_UnFormatDateTime($caregivers->Expiration->CurrentValue, 5);
		}
		$caregivers->Expiration->setOldValue($objForm->GetValue("o_Expiration"));
		if (!$caregivers->ClinicGroup->FldIsDetailKey) {
			$caregivers->ClinicGroup->setFormValue($objForm->GetValue("x_ClinicGroup"));
		}
		$caregivers->ClinicGroup->setOldValue($objForm->GetValue("o_ClinicGroup"));
		if (!$caregivers->DateSent->FldIsDetailKey) {
			$caregivers->DateSent->setFormValue($objForm->GetValue("x_DateSent"));
			$caregivers->DateSent->CurrentValue = ew_UnFormatDateTime($caregivers->DateSent->CurrentValue, 5);
		}
		$caregivers->DateSent->setOldValue($objForm->GetValue("o_DateSent"));
		if (!$caregivers->budget_category->FldIsDetailKey) {
			$caregivers->budget_category->setFormValue($objForm->GetValue("x_budget_category"));
		}
		$caregivers->budget_category->setOldValue($objForm->GetValue("o_budget_category"));
		if (!$caregivers->AgeOfApplicant->FldIsDetailKey) {
			$caregivers->AgeOfApplicant->setFormValue($objForm->GetValue("x_AgeOfApplicant"));
		}
		$caregivers->AgeOfApplicant->setOldValue($objForm->GetValue("o_AgeOfApplicant"));
		if (!$caregivers->Applic->FldIsDetailKey) {
			$caregivers->Applic->setFormValue($objForm->GetValue("x_Applic"));
		}
		$caregivers->Applic->setOldValue($objForm->GetValue("o_Applic"));
		if (!$caregivers->SubApplic->FldIsDetailKey) {
			$caregivers->SubApplic->setFormValue($objForm->GetValue("x_SubApplic"));
		}
		$caregivers->SubApplic->setOldValue($objForm->GetValue("o_SubApplic"));
		if (!$caregivers->DateSigned->FldIsDetailKey) {
			$caregivers->DateSigned->setFormValue($objForm->GetValue("x_DateSigned"));
			$caregivers->DateSigned->CurrentValue = ew_UnFormatDateTime($caregivers->DateSigned->CurrentValue, 5);
		}
		$caregivers->DateSigned->setOldValue($objForm->GetValue("o_DateSigned"));
		if (!$caregivers->colony_id->FldIsDetailKey) {
			$caregivers->colony_id->setFormValue($objForm->GetValue("x_colony_id"));
		}
		$caregivers->colony_id->setOldValue($objForm->GetValue("o_colony_id"));
		if (!$caregivers->mod_by->FldIsDetailKey) {
			$caregivers->mod_by->setFormValue($objForm->GetValue("x_mod_by"));
		}
		$caregivers->mod_by->setOldValue($objForm->GetValue("o_mod_by"));
		if (!$caregivers->mod_date->FldIsDetailKey) {
			$caregivers->mod_date->setFormValue($objForm->GetValue("x_mod_date"));
			$caregivers->mod_date->CurrentValue = ew_UnFormatDateTime($caregivers->mod_date->CurrentValue, 5);
		}
		$caregivers->mod_date->setOldValue($objForm->GetValue("o_mod_date"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $caregivers;
		if ($caregivers->CurrentAction <> "gridadd" && $caregivers->CurrentAction <> "add")
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

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $caregivers;

		// Call Recordset Selecting event
		$caregivers->Recordset_Selecting($caregivers->CurrentFilter);

		// Load List page SQL
		$sSql = $caregivers->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$caregivers->Recordset_Selected($rs);
		return $rs;
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
		$arKeys[] = $this->RowOldKey;
		$cnt = count($arKeys);
		if ($cnt >= 1) {
			if (strval($arKeys[0]) <> "")
				$caregivers->caregiver_id->CurrentValue = strval($arKeys[0]); // caregiver_id
			else
				$bValidKey = FALSE;
		} else {
			$bValidKey = FALSE;
		}

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
		} elseif ($caregivers->RowType == EW_ROWTYPE_ADD) { // Add row

			// caregiver_id
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
				$caregivers->colony_id->OldValue = $caregivers->colony_id->CurrentValue;
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
				$caregivers->colony_id->OldValue = $caregivers->colony_id->CurrentValue;
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

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security, $caregivers;
		$DeleteRows = TRUE;
		$sSql = $caregivers->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;
		}

		// Clone old rows
		$rsold = ($rs) ? $rs->GetRows() : array();
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $caregivers->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['caregiver_id'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($caregivers->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($caregivers->CancelMessage <> "") {
				$this->setFailureMessage($caregivers->CancelMessage);
				$caregivers->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
		} else {
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$caregivers->Row_Deleted($row);
			}
		}
		return $DeleteRows;
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

	// Add record
	function AddRow($rsold = NULL) {
		global $conn, $Language, $Security, $caregivers;

		// Set up foreign key field value from Session
			if ($caregivers->getCurrentMasterTable() == "colonies") {
				$caregivers->colony_id->CurrentValue = $caregivers->colony_id->getSessionValue();
			}
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

		// Hide foreign keys
		$sMasterTblVar = $caregivers->getCurrentMasterTable();
		if ($sMasterTblVar == "colonies") {
			$caregivers->colony_id->Visible = FALSE;
			if ($GLOBALS["colonies"]->EventCancelled) $caregivers->EventCancelled = TRUE;
		}
		$this->DbMasterFilter = $caregivers->getMasterFilter(); //  Get master filter
		$this->DbDetailFilter = $caregivers->getDetailFilter(); // Get detail filter
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
