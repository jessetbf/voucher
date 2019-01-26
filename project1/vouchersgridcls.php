<?php

//
// Page class
//
class cvouchers_grid {

	// Page ID
	var $PageID = 'grid';

	// Table name
	var $TableName = 'vouchers';

	// Page object name
	var $PageObjName = 'vouchers_grid';

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
	function cvouchers_grid() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (vouchers)
		if (!isset($GLOBALS["vouchers"])) {
			$GLOBALS["vouchers"] = new cvouchers();

//			$GLOBALS["MasterTable"] =& $GLOBALS["Table"];
			$GLOBALS["Table"] =& $GLOBALS["vouchers"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'grid', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'vouchers', TRUE);

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
		global $vouchers;

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$vouchers->GridAddRowCount = $gridaddcnt;

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
		global $vouchers;

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
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security, $vouchers;

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
			if ($vouchers->Export <> "" ||
				$vouchers->CurrentAction == "gridadd" ||
				$vouchers->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
			}

			// Show grid delete link for grid add / grid edit
			if ($vouchers->AllowAddDeleteRow) {
				if ($vouchers->CurrentAction == "gridadd" ||
					$vouchers->CurrentAction == "gridedit") {
					$item = $this->ListOptions->GetItem("griddelete");
					if ($item) $item->Visible = TRUE;
				}
			}

			// Set up sorting order
			$this->SetUpSortOrder();
		}

		// Restore display records
		if ($vouchers->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $vouchers->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build filter
		$sFilter = "";

		// Restore master/detail filter
		$this->DbMasterFilter = $vouchers->getMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $vouchers->getDetailFilter(); // Restore detail filter
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Load master record
		if ($vouchers->getMasterFilter() <> "" && $vouchers->getCurrentMasterTable() == "colonies") {
			global $colonies;
			$rsmaster = $colonies->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate($vouchers->getReturnUrl()); // Return to caller
			} else {
				$colonies->LoadListRowValues($rsmaster);
				$colonies->RowType = EW_ROWTYPE_MASTER; // Master row
				$colonies->RenderListRow();
				$rsmaster->Close();
			}
		}

		// Set up filter in session
		$vouchers->setSessionWhere($sFilter);
		$vouchers->CurrentFilter = "";
	}

	//  Exit inline mode
	function ClearInlineMode() {
		global $vouchers;
		$vouchers->LastAction = $vouchers->CurrentAction; // Save last action
		$vouchers->CurrentAction = ""; // Clear action
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
		global $conn, $Language, $objForm, $gsFormError, $vouchers;
		$bGridUpdate = TRUE;

		// Get old recordset
		$vouchers->CurrentFilter = $this->BuildKeyFilter();
		$sSql = $vouchers->SQL();
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
						$vouchers->CurrentFilter = $vouchers->KeyFilter();
						$bGridUpdate = $this->DeleteRows(); // Delete this row
					} else if (!$this->ValidateForm()) {
						$bGridUpdate = FALSE; // Form error, reset action
						$this->setFailureMessage($gsFormError);
					} else {
						if ($rowaction == "insert") {
							$bGridUpdate = $this->AddRow(); // Insert this row
						} else {
							if ($rowkey <> "") {
								$vouchers->SendEmail = FALSE; // Do not send email on update success
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
			$vouchers->EventCancelled = TRUE; // Set event cancelled
			$vouchers->CurrentAction = "gridedit"; // Stay in Grid Edit mode
		}
		return $bGridUpdate;
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm, $vouchers;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue("k_key"));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $vouchers->KeyFilter();
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
		global $vouchers;
		$arrKeyFlds = explode(EW_COMPOSITE_KEY_SEPARATOR, $key);
		if (count($arrKeyFlds) >= 1) {
			$vouchers->id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($vouchers->id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Perform Grid Add
	function GridInsert() {
		global $conn, $Language, $objForm, $gsFormError, $vouchers;
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
				$vouchers->SendEmail = FALSE; // Do not send email on insert success

				// Validate form
				if (!$this->ValidateForm()) {
					$bGridInsert = FALSE; // Form error, reset action
					$this->setFailureMessage($gsFormError);
				} else {
					$bGridInsert = $this->AddRow($this->OldRecordset); // Insert this row
				}
				if ($bGridInsert) {
					if ($sKey <> "") $sKey .= EW_COMPOSITE_KEY_SEPARATOR;
					$sKey .= $vouchers->id->CurrentValue;

					// Add filter for this record
					$sFilter = $vouchers->KeyFilter();
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
			$vouchers->CurrentFilter = $sWrkFilter;
			$sSql = $vouchers->SQL();
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}
			$this->ClearInlineMode(); // Clear grid add mode
		} else {
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("InsertFailed")); // Set insert failed message
			}
			$vouchers->EventCancelled = TRUE; // Set event cancelled
			$vouchers->CurrentAction = "gridadd"; // Stay in gridadd mode
		}
		return $bGridInsert;
	}

	// Check if empty row
	function EmptyRow() {
		global $vouchers, $objForm;
		if ($objForm->HasValue("x_VoucherNumber") && $objForm->HasValue("o_VoucherNumber") && $vouchers->VoucherNumber->CurrentValue <> $vouchers->VoucherNumber->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_ExpireDate") && $objForm->HasValue("o_ExpireDate") && $vouchers->ExpireDate->CurrentValue <> $vouchers->ExpireDate->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_IssuedByFirst") && $objForm->HasValue("o_IssuedByFirst") && $vouchers->IssuedByFirst->CurrentValue <> $vouchers->IssuedByFirst->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_IssuedByLast") && $objForm->HasValue("o_IssuedByLast") && $vouchers->IssuedByLast->CurrentValue <> $vouchers->IssuedByLast->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_FirstName") && $objForm->HasValue("o_FirstName") && $vouchers->FirstName->CurrentValue <> $vouchers->FirstName->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_LastName") && $objForm->HasValue("o_LastName") && $vouchers->LastName->CurrentValue <> $vouchers->LastName->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Program") && $objForm->HasValue("o_Program") && $vouchers->Program->CurrentValue <> $vouchers->Program->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_cat_name") && $objForm->HasValue("o_cat_name") && $vouchers->cat_name->CurrentValue <> $vouchers->cat_name->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_cat_breed") && $objForm->HasValue("o_cat_breed") && $vouchers->cat_breed->CurrentValue <> $vouchers->cat_breed->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_cat_age") && $objForm->HasValue("o_cat_age") && $vouchers->cat_age->CurrentValue <> $vouchers->cat_age->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_copay") && $objForm->HasValue("o_copay") && $vouchers->copay->CurrentValue <> $vouchers->copay->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_cat_status") && $objForm->HasValue("o_cat_status") && $vouchers->cat_status->CurrentValue <> $vouchers->cat_status->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_date_redeemed") && $objForm->HasValue("o_date_redeemed") && $vouchers->date_redeemed->CurrentValue <> $vouchers->date_redeemed->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Clinic") && $objForm->HasValue("o_Clinic") && $vouchers->Clinic->CurrentValue <> $vouchers->Clinic->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_ClinicPrice") && $objForm->HasValue("o_ClinicPrice") && $vouchers->ClinicPrice->CurrentValue <> $vouchers->ClinicPrice->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_vet_used") && $objForm->HasValue("o_vet_used") && $vouchers->vet_used->CurrentValue <> $vouchers->vet_used->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_colony_id") && $objForm->HasValue("o_colony_id") && $vouchers->colony_id->CurrentValue <> $vouchers->colony_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Spay") && $objForm->HasValue("o_Spay") && $vouchers->Spay->CurrentValue <> $vouchers->Spay->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Neuter") && $objForm->HasValue("o_Neuter") && $vouchers->Neuter->CurrentValue <> $vouchers->Neuter->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_FVRCP") && $objForm->HasValue("o_FVRCP") && $vouchers->FVRCP->CurrentValue <> $vouchers->FVRCP->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_FELV") && $objForm->HasValue("o_FELV") && $vouchers->FELV->CurrentValue <> $vouchers->FELV->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Rabies") && $objForm->HasValue("o_Rabies") && $vouchers->Rabies->CurrentValue <> $vouchers->Rabies->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Pregnant") && $objForm->HasValue("o_Pregnant") && $vouchers->Pregnant->CurrentValue <> $vouchers->Pregnant->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_AssignedTo") && $objForm->HasValue("o_AssignedTo") && $vouchers->AssignedTo->CurrentValue <> $vouchers->AssignedTo->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_mod_by") && $objForm->HasValue("o_mod_by") && $vouchers->mod_by->CurrentValue <> $vouchers->mod_by->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_mod_date") && $objForm->HasValue("o_mod_date") && $vouchers->mod_date->CurrentValue <> $vouchers->mod_date->OldValue)
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
		global $objForm, $vouchers;

		// Get row based on current index
		$objForm->Index = $idx;
		$this->LoadFormValues(); // Load form values
	}

	// Set up sort parameters
	function SetUpSortOrder() {
		global $vouchers;

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$vouchers->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$vouchers->CurrentOrderType = @$_GET["ordertype"];
			$vouchers->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		global $vouchers;
		$sOrderBy = $vouchers->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($vouchers->SqlOrderBy() <> "") {
				$sOrderBy = $vouchers->SqlOrderBy();
				$vouchers->setSessionOrderBy($sOrderBy);
				$vouchers->id->setSort("DESC");
			}
		}
	}

	// Reset command
	// cmd=reset (Reset search parameters)
	// cmd=resetall (Reset search and master/detail parameters)
	// cmd=resetsort (Reset sort parameters)
	function ResetCmd() {
		global $vouchers;

		// Get reset command
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset master/detail keys
			if (strtolower($sCmd) == "resetall") {
				$vouchers->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$vouchers->colony_id->setSessionValue("");
			}

			// Reset sorting order
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$vouchers->setSessionOrderBy($sOrderBy);
			}

			// Reset start position
			$this->StartRec = 1;
			$vouchers->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language, $vouchers;

		// "griddelete"
		if ($vouchers->AllowAddDeleteRow) {
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
		global $Security, $Language, $vouchers, $objForm;
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
			if ($this->RowAction == "insert" && $vouchers->CurrentAction == "F" && $this->EmptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_blankrow\" id=\"k" . $this->RowIndex . "_blankrow\" value=\"1\">";
		}

		// "delete"
		if ($vouchers->AllowAddDeleteRow) {
			if ($vouchers->CurrentMode == "add" || $vouchers->CurrentMode == "copy" || $vouchers->CurrentMode == "edit") {
				$oListOpt =& $this->ListOptions->Items["griddelete"];
				$oListOpt->Body = "<a class=\"ewGridLink\" href=\"javascript:void(0);\" onclick=\"ew_DeleteGridRow(this, vouchers_grid, " . $this->RowIndex . ");\">" . $Language->Phrase("DeleteLink") . "</a>";
			}
		}
		if ($vouchers->CurrentMode == "edit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . $vouchers->id->CurrentValue . "\">";
		}
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set record key
	function SetRecordKey(&$key, $rs) {
		$key = "";
		if ($key <> "") $key .= EW_COMPOSITE_KEY_SEPARATOR;
		$key .= $rs->fields('id');
	}

	function RenderListOptionsExt() {
		global $Security, $Language, $vouchers;
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $vouchers;
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$vouchers->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$vouchers->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $vouchers->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$vouchers->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$vouchers->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$vouchers->setStartRecordNumber($this->StartRec);
		}
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
		$vouchers->id->CurrentValue = NULL;
		$vouchers->id->OldValue = $vouchers->id->CurrentValue;
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
		if (!$vouchers->id->FldIsDetailKey && $vouchers->CurrentAction <> "gridadd" && $vouchers->CurrentAction <> "add")
			$vouchers->id->setFormValue($objForm->GetValue("x_id"));
		if (!$vouchers->VoucherNumber->FldIsDetailKey) {
			$vouchers->VoucherNumber->setFormValue($objForm->GetValue("x_VoucherNumber"));
		}
		$vouchers->VoucherNumber->setOldValue($objForm->GetValue("o_VoucherNumber"));
		if (!$vouchers->ExpireDate->FldIsDetailKey) {
			$vouchers->ExpireDate->setFormValue($objForm->GetValue("x_ExpireDate"));
			$vouchers->ExpireDate->CurrentValue = ew_UnFormatDateTime($vouchers->ExpireDate->CurrentValue, 5);
		}
		$vouchers->ExpireDate->setOldValue($objForm->GetValue("o_ExpireDate"));
		if (!$vouchers->IssuedByFirst->FldIsDetailKey) {
			$vouchers->IssuedByFirst->setFormValue($objForm->GetValue("x_IssuedByFirst"));
		}
		$vouchers->IssuedByFirst->setOldValue($objForm->GetValue("o_IssuedByFirst"));
		if (!$vouchers->IssuedByLast->FldIsDetailKey) {
			$vouchers->IssuedByLast->setFormValue($objForm->GetValue("x_IssuedByLast"));
		}
		$vouchers->IssuedByLast->setOldValue($objForm->GetValue("o_IssuedByLast"));
		if (!$vouchers->FirstName->FldIsDetailKey) {
			$vouchers->FirstName->setFormValue($objForm->GetValue("x_FirstName"));
		}
		$vouchers->FirstName->setOldValue($objForm->GetValue("o_FirstName"));
		if (!$vouchers->LastName->FldIsDetailKey) {
			$vouchers->LastName->setFormValue($objForm->GetValue("x_LastName"));
		}
		$vouchers->LastName->setOldValue($objForm->GetValue("o_LastName"));
		if (!$vouchers->Program->FldIsDetailKey) {
			$vouchers->Program->setFormValue($objForm->GetValue("x_Program"));
		}
		$vouchers->Program->setOldValue($objForm->GetValue("o_Program"));
		if (!$vouchers->cat_name->FldIsDetailKey) {
			$vouchers->cat_name->setFormValue($objForm->GetValue("x_cat_name"));
		}
		$vouchers->cat_name->setOldValue($objForm->GetValue("o_cat_name"));
		if (!$vouchers->cat_breed->FldIsDetailKey) {
			$vouchers->cat_breed->setFormValue($objForm->GetValue("x_cat_breed"));
		}
		$vouchers->cat_breed->setOldValue($objForm->GetValue("o_cat_breed"));
		if (!$vouchers->cat_age->FldIsDetailKey) {
			$vouchers->cat_age->setFormValue($objForm->GetValue("x_cat_age"));
		}
		$vouchers->cat_age->setOldValue($objForm->GetValue("o_cat_age"));
		if (!$vouchers->copay->FldIsDetailKey) {
			$vouchers->copay->setFormValue($objForm->GetValue("x_copay"));
		}
		$vouchers->copay->setOldValue($objForm->GetValue("o_copay"));
		if (!$vouchers->cat_status->FldIsDetailKey) {
			$vouchers->cat_status->setFormValue($objForm->GetValue("x_cat_status"));
		}
		$vouchers->cat_status->setOldValue($objForm->GetValue("o_cat_status"));
		if (!$vouchers->date_redeemed->FldIsDetailKey) {
			$vouchers->date_redeemed->setFormValue($objForm->GetValue("x_date_redeemed"));
			$vouchers->date_redeemed->CurrentValue = ew_UnFormatDateTime($vouchers->date_redeemed->CurrentValue, 5);
		}
		$vouchers->date_redeemed->setOldValue($objForm->GetValue("o_date_redeemed"));
		if (!$vouchers->Clinic->FldIsDetailKey) {
			$vouchers->Clinic->setFormValue($objForm->GetValue("x_Clinic"));
		}
		$vouchers->Clinic->setOldValue($objForm->GetValue("o_Clinic"));
		if (!$vouchers->ClinicPrice->FldIsDetailKey) {
			$vouchers->ClinicPrice->setFormValue($objForm->GetValue("x_ClinicPrice"));
		}
		$vouchers->ClinicPrice->setOldValue($objForm->GetValue("o_ClinicPrice"));
		if (!$vouchers->vet_used->FldIsDetailKey) {
			$vouchers->vet_used->setFormValue($objForm->GetValue("x_vet_used"));
		}
		$vouchers->vet_used->setOldValue($objForm->GetValue("o_vet_used"));
		if (!$vouchers->colony_id->FldIsDetailKey) {
			$vouchers->colony_id->setFormValue($objForm->GetValue("x_colony_id"));
		}
		$vouchers->colony_id->setOldValue($objForm->GetValue("o_colony_id"));
		if (!$vouchers->Spay->FldIsDetailKey) {
			$vouchers->Spay->setFormValue($objForm->GetValue("x_Spay"));
		}
		$vouchers->Spay->setOldValue($objForm->GetValue("o_Spay"));
		if (!$vouchers->Neuter->FldIsDetailKey) {
			$vouchers->Neuter->setFormValue($objForm->GetValue("x_Neuter"));
		}
		$vouchers->Neuter->setOldValue($objForm->GetValue("o_Neuter"));
		if (!$vouchers->FVRCP->FldIsDetailKey) {
			$vouchers->FVRCP->setFormValue($objForm->GetValue("x_FVRCP"));
		}
		$vouchers->FVRCP->setOldValue($objForm->GetValue("o_FVRCP"));
		if (!$vouchers->FELV->FldIsDetailKey) {
			$vouchers->FELV->setFormValue($objForm->GetValue("x_FELV"));
		}
		$vouchers->FELV->setOldValue($objForm->GetValue("o_FELV"));
		if (!$vouchers->Rabies->FldIsDetailKey) {
			$vouchers->Rabies->setFormValue($objForm->GetValue("x_Rabies"));
		}
		$vouchers->Rabies->setOldValue($objForm->GetValue("o_Rabies"));
		if (!$vouchers->Pregnant->FldIsDetailKey) {
			$vouchers->Pregnant->setFormValue($objForm->GetValue("x_Pregnant"));
		}
		$vouchers->Pregnant->setOldValue($objForm->GetValue("o_Pregnant"));
		if (!$vouchers->AssignedTo->FldIsDetailKey) {
			$vouchers->AssignedTo->setFormValue($objForm->GetValue("x_AssignedTo"));
		}
		$vouchers->AssignedTo->setOldValue($objForm->GetValue("o_AssignedTo"));
		if (!$vouchers->mod_by->FldIsDetailKey) {
			$vouchers->mod_by->setFormValue($objForm->GetValue("x_mod_by"));
		}
		$vouchers->mod_by->setOldValue($objForm->GetValue("o_mod_by"));
		if (!$vouchers->mod_date->FldIsDetailKey) {
			$vouchers->mod_date->setFormValue($objForm->GetValue("x_mod_date"));
			$vouchers->mod_date->CurrentValue = ew_UnFormatDateTime($vouchers->mod_date->CurrentValue, 5);
		}
		$vouchers->mod_date->setOldValue($objForm->GetValue("o_mod_date"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $vouchers;
		if ($vouchers->CurrentAction <> "gridadd" && $vouchers->CurrentAction <> "add")
			$vouchers->id->CurrentValue = $vouchers->id->FormValue;
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

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $vouchers;

		// Call Recordset Selecting event
		$vouchers->Recordset_Selecting($vouchers->CurrentFilter);

		// Load List page SQL
		$sSql = $vouchers->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$vouchers->Recordset_Selected($rs);
		return $rs;
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
		$arKeys[] = $this->RowOldKey;
		$cnt = count($arKeys);
		if ($cnt >= 1) {
			if (strval($arKeys[0]) <> "")
				$vouchers->id->CurrentValue = strval($arKeys[0]); // id
			else
				$bValidKey = FALSE;
		} else {
			$bValidKey = FALSE;
		}

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

			// id
			$vouchers->id->LinkCustomAttributes = "";
			$vouchers->id->HrefValue = "";
			$vouchers->id->TooltipValue = "";

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

			// id
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
				$vouchers->colony_id->OldValue = $vouchers->colony_id->CurrentValue;
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
			// id

			$vouchers->id->HrefValue = "";

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
		} elseif ($vouchers->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$vouchers->id->EditCustomAttributes = "";
			$vouchers->id->EditValue = $vouchers->id->CurrentValue;
			$vouchers->id->ViewCustomAttributes = "";

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
				$vouchers->colony_id->OldValue = $vouchers->colony_id->CurrentValue;
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
			// id

			$vouchers->id->HrefValue = "";

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

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security, $vouchers;
		$DeleteRows = TRUE;
		$sSql = $vouchers->SQL();
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
				$DeleteRows = $vouchers->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['id'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($vouchers->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($vouchers->CancelMessage <> "") {
				$this->setFailureMessage($vouchers->CancelMessage);
				$vouchers->CancelMessage = "";
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
				$vouchers->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Update record based on key values
	function EditRow() {
		global $conn, $Security, $Language, $vouchers;
		$sFilter = $vouchers->KeyFilter();
		$vouchers->CurrentFilter = $sFilter;
		$sSql = $vouchers->SQL();
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

			// VoucherNumber
			$vouchers->VoucherNumber->SetDbValueDef($rsnew, $vouchers->VoucherNumber->CurrentValue, 0, $vouchers->VoucherNumber->ReadOnly);

			// ExpireDate
			$vouchers->ExpireDate->SetDbValueDef($rsnew, ew_UnFormatDateTime($vouchers->ExpireDate->CurrentValue, 5), ew_CurrentDate(), $vouchers->ExpireDate->ReadOnly);

			// IssuedByFirst
			$vouchers->IssuedByFirst->SetDbValueDef($rsnew, $vouchers->IssuedByFirst->CurrentValue, "", $vouchers->IssuedByFirst->ReadOnly);

			// IssuedByLast
			$vouchers->IssuedByLast->SetDbValueDef($rsnew, $vouchers->IssuedByLast->CurrentValue, "", $vouchers->IssuedByLast->ReadOnly);

			// FirstName
			$vouchers->FirstName->SetDbValueDef($rsnew, $vouchers->FirstName->CurrentValue, NULL, $vouchers->FirstName->ReadOnly);

			// LastName
			$vouchers->LastName->SetDbValueDef($rsnew, $vouchers->LastName->CurrentValue, NULL, $vouchers->LastName->ReadOnly);

			// Program
			$vouchers->Program->SetDbValueDef($rsnew, $vouchers->Program->CurrentValue, NULL, $vouchers->Program->ReadOnly);

			// cat_name
			$vouchers->cat_name->SetDbValueDef($rsnew, $vouchers->cat_name->CurrentValue, NULL, $vouchers->cat_name->ReadOnly);

			// cat_breed
			$vouchers->cat_breed->SetDbValueDef($rsnew, $vouchers->cat_breed->CurrentValue, NULL, $vouchers->cat_breed->ReadOnly);

			// cat_age
			$vouchers->cat_age->SetDbValueDef($rsnew, $vouchers->cat_age->CurrentValue, NULL, $vouchers->cat_age->ReadOnly);

			// copay
			$vouchers->copay->SetDbValueDef($rsnew, $vouchers->copay->CurrentValue, NULL, $vouchers->copay->ReadOnly);

			// cat_status
			$vouchers->cat_status->SetDbValueDef($rsnew, $vouchers->cat_status->CurrentValue, NULL, $vouchers->cat_status->ReadOnly);

			// date_redeemed
			$vouchers->date_redeemed->SetDbValueDef($rsnew, ew_UnFormatDateTime($vouchers->date_redeemed->CurrentValue, 5), NULL, $vouchers->date_redeemed->ReadOnly);

			// Clinic
			$vouchers->Clinic->SetDbValueDef($rsnew, $vouchers->Clinic->CurrentValue, NULL, $vouchers->Clinic->ReadOnly);

			// ClinicPrice
			$vouchers->ClinicPrice->SetDbValueDef($rsnew, $vouchers->ClinicPrice->CurrentValue, NULL, $vouchers->ClinicPrice->ReadOnly);

			// vet_used
			$vouchers->vet_used->SetDbValueDef($rsnew, $vouchers->vet_used->CurrentValue, NULL, $vouchers->vet_used->ReadOnly);

			// colony_id
			$vouchers->colony_id->SetDbValueDef($rsnew, $vouchers->colony_id->CurrentValue, NULL, $vouchers->colony_id->ReadOnly);

			// Spay
			$vouchers->Spay->SetDbValueDef($rsnew, $vouchers->Spay->CurrentValue, NULL, $vouchers->Spay->ReadOnly);

			// Neuter
			$vouchers->Neuter->SetDbValueDef($rsnew, $vouchers->Neuter->CurrentValue, NULL, $vouchers->Neuter->ReadOnly);

			// FVRCP
			$vouchers->FVRCP->SetDbValueDef($rsnew, $vouchers->FVRCP->CurrentValue, NULL, $vouchers->FVRCP->ReadOnly);

			// FELV
			$vouchers->FELV->SetDbValueDef($rsnew, $vouchers->FELV->CurrentValue, NULL, $vouchers->FELV->ReadOnly);

			// Rabies
			$vouchers->Rabies->SetDbValueDef($rsnew, $vouchers->Rabies->CurrentValue, NULL, $vouchers->Rabies->ReadOnly);

			// Pregnant
			$vouchers->Pregnant->SetDbValueDef($rsnew, $vouchers->Pregnant->CurrentValue, NULL, $vouchers->Pregnant->ReadOnly);

			// AssignedTo
			$vouchers->AssignedTo->SetDbValueDef($rsnew, $vouchers->AssignedTo->CurrentValue, NULL, $vouchers->AssignedTo->ReadOnly);

			// mod_by
			$vouchers->mod_by->SetDbValueDef($rsnew, $vouchers->mod_by->CurrentValue, NULL, $vouchers->mod_by->ReadOnly);

			// mod_date
			$vouchers->mod_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($vouchers->mod_date->CurrentValue, 5), ew_CurrentDate(), $vouchers->mod_date->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $vouchers->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				if (count($rsnew) > 0)
					$EditRow = $conn->Execute($vouchers->UpdateSQL($rsnew));
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
			} else {
				if ($vouchers->CancelMessage <> "") {
					$this->setFailureMessage($vouchers->CancelMessage);
					$vouchers->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$vouchers->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $conn, $Language, $Security, $vouchers;

		// Set up foreign key field value from Session
			if ($vouchers->getCurrentMasterTable() == "colonies") {
				$vouchers->colony_id->CurrentValue = $vouchers->colony_id->getSessionValue();
			}
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

		// Hide foreign keys
		$sMasterTblVar = $vouchers->getCurrentMasterTable();
		if ($sMasterTblVar == "colonies") {
			$vouchers->colony_id->Visible = FALSE;
			if ($GLOBALS["colonies"]->EventCancelled) $vouchers->EventCancelled = TRUE;
		}
		$this->DbMasterFilter = $vouchers->getMasterFilter(); //  Get master filter
		$this->DbDetailFilter = $vouchers->getDetailFilter(); // Get detail filter
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
