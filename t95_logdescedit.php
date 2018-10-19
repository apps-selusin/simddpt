<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t95_logdescinfo.php" ?>
<?php include_once "t94_loginfo.php" ?>
<?php include_once "t96_employeesinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t95_logdesc_edit = NULL; // Initialize page object first

class ct95_logdesc_edit extends ct95_logdesc {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{78A0660C-C398-4292-A50E-2A3C7D765239}";

	// Table name
	var $TableName = 't95_logdesc';

	// Page object name
	var $PageObjName = 't95_logdesc_edit';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
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

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (t95_logdesc)
		if (!isset($GLOBALS["t95_logdesc"]) || get_class($GLOBALS["t95_logdesc"]) == "ct95_logdesc") {
			$GLOBALS["t95_logdesc"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t95_logdesc"];
		}

		// Table object (t94_log)
		if (!isset($GLOBALS['t94_log'])) $GLOBALS['t94_log'] = new ct94_log();

		// Table object (t96_employees)
		if (!isset($GLOBALS['t96_employees'])) $GLOBALS['t96_employees'] = new ct96_employees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't95_logdesc', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// User table object (t96_employees)
		if (!isset($UserTable)) {
			$UserTable = new ct96_employees();
			$UserTableConn = Conn($UserTable->DBID);
		}
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("t95_logdesclist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->log_id->SetVisibility();
		$this->desc_->SetVisibility();
		$this->date_issued->SetVisibility();
		$this->date_solved->SetVisibility();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $t95_logdesc;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t95_logdesc);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		 // Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();

			// Handle modal response
			if ($this->IsModal) {
				$row = array();
				$row["url"] = $url;
				echo ew_ArrayToJson(array($row));
			} else {
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $IsModal = FALSE;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $DisplayRecs = 1;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $RecCnt;
	var $RecKey = array();
	var $Recordset;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		global $gbSkipHeaderFooter;

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;

		// Load current record
		$bLoadCurrentRecord = FALSE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;

		// Load key from QueryString
		if (@$_GET["id"] <> "") {
			$this->id->setQueryStringValue($_GET["id"]);
			$this->RecKey["id"] = $this->id->QueryStringValue;
		} else {
			$bLoadCurrentRecord = TRUE;
		}

		// Set up master detail parameters
		$this->SetUpMasterParms();

		// Load recordset
		$this->StartRec = 1; // Initialize start position
		if ($this->Recordset = $this->LoadRecordset()) // Load records
			$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
		if ($this->TotalRecs <= 0) { // No record found
			if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$this->Page_Terminate("t95_logdesclist.php"); // Return to list page
		} elseif ($bLoadCurrentRecord) { // Load current record position
			$this->SetUpStartRec(); // Set up start record position

			// Point to current record
			if (intval($this->StartRec) <= intval($this->TotalRecs)) {
				$bMatchRecord = TRUE;
				$this->Recordset->Move($this->StartRec-1);
			}
		} else { // Match key values
			while (!$this->Recordset->EOF) {
				if (strval($this->id->CurrentValue) == strval($this->Recordset->fields('id'))) {
					$this->setStartRecordNumber($this->StartRec); // Save record position
					$bMatchRecord = TRUE;
					break;
				} else {
					$this->StartRec++;
					$this->Recordset->MoveNext();
				}
			}
		}

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$bMatchRecord) {
					if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
						$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
					$this->Page_Terminate("t95_logdesclist.php"); // Return to list page
				} else {
					$this->LoadRowValues($this->Recordset); // Load row values
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "t95_logdesclist.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->log_id->FldIsDetailKey) {
			$this->log_id->setFormValue($objForm->GetValue("x_log_id"));
		}
		if (!$this->desc_->FldIsDetailKey) {
			$this->desc_->setFormValue($objForm->GetValue("x_desc_"));
		}
		if (!$this->date_issued->FldIsDetailKey) {
			$this->date_issued->setFormValue($objForm->GetValue("x_date_issued"));
			$this->date_issued->CurrentValue = ew_UnFormatDateTime($this->date_issued->CurrentValue, 0);
		}
		if (!$this->date_solved->FldIsDetailKey) {
			$this->date_solved->setFormValue($objForm->GetValue("x_date_solved"));
			$this->date_solved->CurrentValue = ew_UnFormatDateTime($this->date_solved->CurrentValue, 0);
		}
		if (!$this->id->FldIsDetailKey)
			$this->id->setFormValue($objForm->GetValue("x_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->id->CurrentValue = $this->id->FormValue;
		$this->log_id->CurrentValue = $this->log_id->FormValue;
		$this->desc_->CurrentValue = $this->desc_->FormValue;
		$this->date_issued->CurrentValue = $this->date_issued->FormValue;
		$this->date_issued->CurrentValue = ew_UnFormatDateTime($this->date_issued->CurrentValue, 0);
		$this->date_solved->CurrentValue = $this->date_solved->FormValue;
		$this->date_solved->CurrentValue = ew_UnFormatDateTime($this->date_solved->CurrentValue, 0);
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->SelectSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->id->setDbValue($rs->fields('id'));
		$this->log_id->setDbValue($rs->fields('log_id'));
		$this->desc_->setDbValue($rs->fields('desc_'));
		$this->date_issued->setDbValue($rs->fields('date_issued'));
		$this->date_solved->setDbValue($rs->fields('date_solved'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->log_id->DbValue = $row['log_id'];
		$this->desc_->DbValue = $row['desc_'];
		$this->date_issued->DbValue = $row['date_issued'];
		$this->date_solved->DbValue = $row['date_solved'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// log_id
		// desc_
		// date_issued
		// date_solved

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// log_id
		$this->log_id->ViewValue = $this->log_id->CurrentValue;
		if (strval($this->log_id->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->log_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `subj_` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t94_log`";
		$sWhereWrk = "";
		$this->log_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->log_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->log_id->ViewValue = $this->log_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->log_id->ViewValue = $this->log_id->CurrentValue;
			}
		} else {
			$this->log_id->ViewValue = NULL;
		}
		$this->log_id->ViewCustomAttributes = "";

		// desc_
		$this->desc_->ViewValue = $this->desc_->CurrentValue;
		$this->desc_->ViewCustomAttributes = "";

		// date_issued
		$this->date_issued->ViewValue = $this->date_issued->CurrentValue;
		$this->date_issued->ViewValue = ew_FormatDateTime($this->date_issued->ViewValue, 0);
		$this->date_issued->ViewCustomAttributes = "";

		// date_solved
		$this->date_solved->ViewValue = $this->date_solved->CurrentValue;
		$this->date_solved->ViewValue = ew_FormatDateTime($this->date_solved->ViewValue, 0);
		$this->date_solved->ViewCustomAttributes = "";

			// log_id
			$this->log_id->LinkCustomAttributes = "";
			$this->log_id->HrefValue = "";
			$this->log_id->TooltipValue = "";

			// desc_
			$this->desc_->LinkCustomAttributes = "";
			$this->desc_->HrefValue = "";
			$this->desc_->TooltipValue = "";

			// date_issued
			$this->date_issued->LinkCustomAttributes = "";
			$this->date_issued->HrefValue = "";
			$this->date_issued->TooltipValue = "";

			// date_solved
			$this->date_solved->LinkCustomAttributes = "";
			$this->date_solved->HrefValue = "";
			$this->date_solved->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// log_id
			$this->log_id->EditAttrs["class"] = "form-control";
			$this->log_id->EditCustomAttributes = "";
			if ($this->log_id->getSessionValue() <> "") {
				$this->log_id->CurrentValue = $this->log_id->getSessionValue();
			$this->log_id->ViewValue = $this->log_id->CurrentValue;
			if (strval($this->log_id->CurrentValue) <> "") {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->log_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `id`, `subj_` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t94_log`";
			$sWhereWrk = "";
			$this->log_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->log_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->log_id->ViewValue = $this->log_id->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->log_id->ViewValue = $this->log_id->CurrentValue;
				}
			} else {
				$this->log_id->ViewValue = NULL;
			}
			$this->log_id->ViewCustomAttributes = "";
			} else {
			$this->log_id->EditValue = ew_HtmlEncode($this->log_id->CurrentValue);
			if (strval($this->log_id->CurrentValue) <> "") {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->log_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `id`, `subj_` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t94_log`";
			$sWhereWrk = "";
			$this->log_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->log_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->log_id->EditValue = $this->log_id->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->log_id->EditValue = ew_HtmlEncode($this->log_id->CurrentValue);
				}
			} else {
				$this->log_id->EditValue = NULL;
			}
			$this->log_id->PlaceHolder = ew_RemoveHtml($this->log_id->FldCaption());
			}

			// desc_
			$this->desc_->EditAttrs["class"] = "form-control";
			$this->desc_->EditCustomAttributes = "";
			$this->desc_->EditValue = ew_HtmlEncode($this->desc_->CurrentValue);
			$this->desc_->PlaceHolder = ew_RemoveHtml($this->desc_->FldCaption());

			// date_issued
			$this->date_issued->EditAttrs["class"] = "form-control";
			$this->date_issued->EditCustomAttributes = "";
			$this->date_issued->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->date_issued->CurrentValue, 8));
			$this->date_issued->PlaceHolder = ew_RemoveHtml($this->date_issued->FldCaption());

			// date_solved
			$this->date_solved->EditAttrs["class"] = "form-control";
			$this->date_solved->EditCustomAttributes = "";
			$this->date_solved->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->date_solved->CurrentValue, 8));
			$this->date_solved->PlaceHolder = ew_RemoveHtml($this->date_solved->FldCaption());

			// Edit refer script
			// log_id

			$this->log_id->LinkCustomAttributes = "";
			$this->log_id->HrefValue = "";

			// desc_
			$this->desc_->LinkCustomAttributes = "";
			$this->desc_->HrefValue = "";

			// date_issued
			$this->date_issued->LinkCustomAttributes = "";
			$this->date_issued->HrefValue = "";

			// date_solved
			$this->date_solved->LinkCustomAttributes = "";
			$this->date_solved->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->log_id->FldIsDetailKey && !is_null($this->log_id->FormValue) && $this->log_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->log_id->FldCaption(), $this->log_id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->log_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->log_id->FldErrMsg());
		}
		if (!$this->desc_->FldIsDetailKey && !is_null($this->desc_->FormValue) && $this->desc_->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->desc_->FldCaption(), $this->desc_->ReqErrMsg));
		}
		if (!$this->date_issued->FldIsDetailKey && !is_null($this->date_issued->FormValue) && $this->date_issued->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->date_issued->FldCaption(), $this->date_issued->ReqErrMsg));
		}
		if (!ew_CheckDateDef($this->date_issued->FormValue)) {
			ew_AddMessage($gsFormError, $this->date_issued->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->date_solved->FormValue)) {
			ew_AddMessage($gsFormError, $this->date_solved->FldErrMsg());
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
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// log_id
			$this->log_id->SetDbValueDef($rsnew, $this->log_id->CurrentValue, 0, $this->log_id->ReadOnly);

			// desc_
			$this->desc_->SetDbValueDef($rsnew, $this->desc_->CurrentValue, "", $this->desc_->ReadOnly);

			// date_issued
			$this->date_issued->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->date_issued->CurrentValue, 0), ew_CurrentDate(), $this->date_issued->ReadOnly);

			// date_solved
			$this->date_solved->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->date_solved->CurrentValue, 0), NULL, $this->date_solved->ReadOnly);

			// Check referential integrity for master table 't94_log'
			$bValidMasterRecord = TRUE;
			$sMasterFilter = $this->SqlMasterFilter_t94_log();
			$KeyValue = isset($rsnew['log_id']) ? $rsnew['log_id'] : $rsold['log_id'];
			if (strval($KeyValue) <> "") {
				$sMasterFilter = str_replace("@id@", ew_AdjustSql($KeyValue), $sMasterFilter);
			} else {
				$bValidMasterRecord = FALSE;
			}
			if ($bValidMasterRecord) {
				if (!isset($GLOBALS["t94_log"])) $GLOBALS["t94_log"] = new ct94_log();
				$rsmaster = $GLOBALS["t94_log"]->LoadRs($sMasterFilter);
				$bValidMasterRecord = ($rsmaster && !$rsmaster->EOF);
				$rsmaster->Close();
			}
			if (!$bValidMasterRecord) {
				$sRelatedRecordMsg = str_replace("%t", "t94_log", $Language->Phrase("RelatedRecordRequired"));
				$this->setFailureMessage($sRelatedRecordMsg);
				$rs->Close();
				return FALSE;
			}

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "t94_log") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_id"] <> "") {
					$GLOBALS["t94_log"]->id->setQueryStringValue($_GET["fk_id"]);
					$this->log_id->setQueryStringValue($GLOBALS["t94_log"]->id->QueryStringValue);
					$this->log_id->setSessionValue($this->log_id->QueryStringValue);
					if (!is_numeric($GLOBALS["t94_log"]->id->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		} elseif (isset($_POST[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_POST[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "t94_log") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_id"] <> "") {
					$GLOBALS["t94_log"]->id->setFormValue($_POST["fk_id"]);
					$this->log_id->setFormValue($GLOBALS["t94_log"]->id->FormValue);
					$this->log_id->setSessionValue($this->log_id->FormValue);
					if (!is_numeric($GLOBALS["t94_log"]->id->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);
			$this->setSessionWhere($this->GetDetailFilter());

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "t94_log") {
				if ($this->log_id->CurrentValue == "") $this->log_id->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t95_logdesclist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_log_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `subj_` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t94_log`";
			$sWhereWrk = "{filter}";
			$this->log_id->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->log_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_log_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id`, `subj_` AS `DispFld` FROM `t94_log`";
			$sWhereWrk = "`subj_` LIKE '{query_value}%'";
			$this->log_id->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->log_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		}
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
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
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
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t95_logdesc_edit)) $t95_logdesc_edit = new ct95_logdesc_edit();

// Page init
$t95_logdesc_edit->Page_Init();

// Page main
$t95_logdesc_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t95_logdesc_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = ft95_logdescedit = new ew_Form("ft95_logdescedit", "edit");

// Validate form
ft95_logdescedit.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_log_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t95_logdesc->log_id->FldCaption(), $t95_logdesc->log_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_log_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t95_logdesc->log_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_desc_");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t95_logdesc->desc_->FldCaption(), $t95_logdesc->desc_->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_date_issued");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t95_logdesc->date_issued->FldCaption(), $t95_logdesc->date_issued->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_date_issued");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t95_logdesc->date_issued->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_date_solved");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t95_logdesc->date_solved->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
ft95_logdescedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft95_logdescedit.ValidateRequired = true;
<?php } else { ?>
ft95_logdescedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft95_logdescedit.Lists["x_log_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_subj_","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t94_log"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$t95_logdesc_edit->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $t95_logdesc_edit->ShowPageHeader(); ?>
<?php
$t95_logdesc_edit->ShowMessage();
?>
<?php if (!$t95_logdesc_edit->IsModal) { ?>
<form name="ewPagerForm" class="form-horizontal ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t95_logdesc_edit->Pager)) $t95_logdesc_edit->Pager = new cPrevNextPager($t95_logdesc_edit->StartRec, $t95_logdesc_edit->DisplayRecs, $t95_logdesc_edit->TotalRecs) ?>
<?php if ($t95_logdesc_edit->Pager->RecordCount > 0 && $t95_logdesc_edit->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t95_logdesc_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t95_logdesc_edit->PageUrl() ?>start=<?php echo $t95_logdesc_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t95_logdesc_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t95_logdesc_edit->PageUrl() ?>start=<?php echo $t95_logdesc_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t95_logdesc_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t95_logdesc_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t95_logdesc_edit->PageUrl() ?>start=<?php echo $t95_logdesc_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t95_logdesc_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t95_logdesc_edit->PageUrl() ?>start=<?php echo $t95_logdesc_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t95_logdesc_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="ft95_logdescedit" id="ft95_logdescedit" class="<?php echo $t95_logdesc_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t95_logdesc_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t95_logdesc_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t95_logdesc">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($t95_logdesc_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($t95_logdesc->getCurrentMasterTable() == "t94_log") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="t94_log">
<input type="hidden" name="fk_id" value="<?php echo $t95_logdesc->log_id->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($t95_logdesc->log_id->Visible) { // log_id ?>
	<div id="r_log_id" class="form-group">
		<label id="elh_t95_logdesc_log_id" class="col-sm-2 control-label ewLabel"><?php echo $t95_logdesc->log_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t95_logdesc->log_id->CellAttributes() ?>>
<?php if ($t95_logdesc->log_id->getSessionValue() <> "") { ?>
<span id="el_t95_logdesc_log_id">
<span<?php echo $t95_logdesc->log_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t95_logdesc->log_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_log_id" name="x_log_id" value="<?php echo ew_HtmlEncode($t95_logdesc->log_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_t95_logdesc_log_id">
<?php
$wrkonchange = trim(" " . @$t95_logdesc->log_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t95_logdesc->log_id->EditAttrs["onchange"] = "";
?>
<span id="as_x_log_id" style="white-space: nowrap; z-index: 8980">
	<input type="text" name="sv_x_log_id" id="sv_x_log_id" value="<?php echo $t95_logdesc->log_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t95_logdesc->log_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t95_logdesc->log_id->getPlaceHolder()) ?>"<?php echo $t95_logdesc->log_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t95_logdesc" data-field="x_log_id" data-value-separator="<?php echo $t95_logdesc->log_id->DisplayValueSeparatorAttribute() ?>" name="x_log_id" id="x_log_id" value="<?php echo ew_HtmlEncode($t95_logdesc->log_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x_log_id" id="q_x_log_id" value="<?php echo $t95_logdesc->log_id->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ft95_logdescedit.CreateAutoSuggest({"id":"x_log_id","forceSelect":false});
</script>
</span>
<?php } ?>
<?php echo $t95_logdesc->log_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t95_logdesc->desc_->Visible) { // desc_ ?>
	<div id="r_desc_" class="form-group">
		<label id="elh_t95_logdesc_desc_" for="x_desc_" class="col-sm-2 control-label ewLabel"><?php echo $t95_logdesc->desc_->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t95_logdesc->desc_->CellAttributes() ?>>
<span id="el_t95_logdesc_desc_">
<textarea data-table="t95_logdesc" data-field="x_desc_" name="x_desc_" id="x_desc_" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($t95_logdesc->desc_->getPlaceHolder()) ?>"<?php echo $t95_logdesc->desc_->EditAttributes() ?>><?php echo $t95_logdesc->desc_->EditValue ?></textarea>
</span>
<?php echo $t95_logdesc->desc_->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t95_logdesc->date_issued->Visible) { // date_issued ?>
	<div id="r_date_issued" class="form-group">
		<label id="elh_t95_logdesc_date_issued" for="x_date_issued" class="col-sm-2 control-label ewLabel"><?php echo $t95_logdesc->date_issued->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t95_logdesc->date_issued->CellAttributes() ?>>
<span id="el_t95_logdesc_date_issued">
<input type="text" data-table="t95_logdesc" data-field="x_date_issued" name="x_date_issued" id="x_date_issued" placeholder="<?php echo ew_HtmlEncode($t95_logdesc->date_issued->getPlaceHolder()) ?>" value="<?php echo $t95_logdesc->date_issued->EditValue ?>"<?php echo $t95_logdesc->date_issued->EditAttributes() ?>>
</span>
<?php echo $t95_logdesc->date_issued->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t95_logdesc->date_solved->Visible) { // date_solved ?>
	<div id="r_date_solved" class="form-group">
		<label id="elh_t95_logdesc_date_solved" for="x_date_solved" class="col-sm-2 control-label ewLabel"><?php echo $t95_logdesc->date_solved->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t95_logdesc->date_solved->CellAttributes() ?>>
<span id="el_t95_logdesc_date_solved">
<input type="text" data-table="t95_logdesc" data-field="x_date_solved" name="x_date_solved" id="x_date_solved" placeholder="<?php echo ew_HtmlEncode($t95_logdesc->date_solved->getPlaceHolder()) ?>" value="<?php echo $t95_logdesc->date_solved->EditValue ?>"<?php echo $t95_logdesc->date_solved->EditAttributes() ?>>
</span>
<?php echo $t95_logdesc->date_solved->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<input type="hidden" data-table="t95_logdesc" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($t95_logdesc->id->CurrentValue) ?>">
<?php if (!$t95_logdesc_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t95_logdesc_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php if (!isset($t95_logdesc_edit->Pager)) $t95_logdesc_edit->Pager = new cPrevNextPager($t95_logdesc_edit->StartRec, $t95_logdesc_edit->DisplayRecs, $t95_logdesc_edit->TotalRecs) ?>
<?php if ($t95_logdesc_edit->Pager->RecordCount > 0 && $t95_logdesc_edit->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t95_logdesc_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t95_logdesc_edit->PageUrl() ?>start=<?php echo $t95_logdesc_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t95_logdesc_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t95_logdesc_edit->PageUrl() ?>start=<?php echo $t95_logdesc_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t95_logdesc_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t95_logdesc_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t95_logdesc_edit->PageUrl() ?>start=<?php echo $t95_logdesc_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t95_logdesc_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t95_logdesc_edit->PageUrl() ?>start=<?php echo $t95_logdesc_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t95_logdesc_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<script type="text/javascript">
ft95_logdescedit.Init();
</script>
<?php
$t95_logdesc_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t95_logdesc_edit->Page_Terminate();
?>
