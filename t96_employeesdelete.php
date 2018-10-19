<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t96_employeesinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t96_employees_delete = NULL; // Initialize page object first

class ct96_employees_delete extends ct96_employees {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{78A0660C-C398-4292-A50E-2A3C7D765239}";

	// Table name
	var $TableName = 't96_employees';

	// Page object name
	var $PageObjName = 't96_employees_delete';

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

		// Table object (t96_employees)
		if (!isset($GLOBALS["t96_employees"]) || get_class($GLOBALS["t96_employees"]) == "ct96_employees") {
			$GLOBALS["t96_employees"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t96_employees"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't96_employees', TRUE);

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
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("t96_employeeslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
			if (strval($Security->CurrentUserID()) == "") {
				$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
				$this->Page_Terminate(ew_GetUrl("t96_employeeslist.php"));
			}
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->EmployeeID->SetVisibility();
		$this->EmployeeID->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->LastName->SetVisibility();
		$this->FirstName->SetVisibility();
		$this->Title->SetVisibility();
		$this->TitleOfCourtesy->SetVisibility();
		$this->BirthDate->SetVisibility();
		$this->HireDate->SetVisibility();
		$this->Address->SetVisibility();
		$this->City->SetVisibility();
		$this->Region->SetVisibility();
		$this->PostalCode->SetVisibility();
		$this->Country->SetVisibility();
		$this->HomePhone->SetVisibility();
		$this->Extension->SetVisibility();
		$this->_Email->SetVisibility();
		$this->Photo->SetVisibility();
		$this->ReportsTo->SetVisibility();
		$this->Password->SetVisibility();
		$this->UserLevel->SetVisibility();
		$this->Username->SetVisibility();
		$this->Activated->SetVisibility();

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
		global $EW_EXPORT, $t96_employees;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t96_employees);
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
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("t96_employeeslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in t96_employees class, t96_employeesinfo.php

		$this->CurrentFilter = $sFilter;

		// Check if valid user id
		$conn = &$this->Connection();
		$sql = $this->GetSQL($this->CurrentFilter, "");
		if ($this->Recordset = ew_LoadRecordset($sql, $conn)) {
			$res = TRUE;
			while (!$this->Recordset->EOF) {
				$this->LoadRowValues($this->Recordset);
				if (!$this->ShowOptionLink('delete')) {
					$sUserIdMsg = $Language->Phrase("NoDeletePermission");
					$this->setFailureMessage($sUserIdMsg);
					$res = FALSE;
					break;
				}
				$this->Recordset->MoveNext();
			}
			$this->Recordset->Close();
			if (!$res) $this->Page_Terminate("t96_employeeslist.php"); // Return to list
		}

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("t96_employeeslist.php"); // Return to list
			}
		}
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
		$this->EmployeeID->setDbValue($rs->fields('EmployeeID'));
		$this->LastName->setDbValue($rs->fields('LastName'));
		$this->FirstName->setDbValue($rs->fields('FirstName'));
		$this->Title->setDbValue($rs->fields('Title'));
		$this->TitleOfCourtesy->setDbValue($rs->fields('TitleOfCourtesy'));
		$this->BirthDate->setDbValue($rs->fields('BirthDate'));
		$this->HireDate->setDbValue($rs->fields('HireDate'));
		$this->Address->setDbValue($rs->fields('Address'));
		$this->City->setDbValue($rs->fields('City'));
		$this->Region->setDbValue($rs->fields('Region'));
		$this->PostalCode->setDbValue($rs->fields('PostalCode'));
		$this->Country->setDbValue($rs->fields('Country'));
		$this->HomePhone->setDbValue($rs->fields('HomePhone'));
		$this->Extension->setDbValue($rs->fields('Extension'));
		$this->_Email->setDbValue($rs->fields('Email'));
		$this->Photo->setDbValue($rs->fields('Photo'));
		$this->Notes->setDbValue($rs->fields('Notes'));
		$this->ReportsTo->setDbValue($rs->fields('ReportsTo'));
		$this->Password->setDbValue($rs->fields('Password'));
		$this->UserLevel->setDbValue($rs->fields('UserLevel'));
		$this->Username->setDbValue($rs->fields('Username'));
		$this->Activated->setDbValue($rs->fields('Activated'));
		$this->Profile->setDbValue($rs->fields('Profile'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->EmployeeID->DbValue = $row['EmployeeID'];
		$this->LastName->DbValue = $row['LastName'];
		$this->FirstName->DbValue = $row['FirstName'];
		$this->Title->DbValue = $row['Title'];
		$this->TitleOfCourtesy->DbValue = $row['TitleOfCourtesy'];
		$this->BirthDate->DbValue = $row['BirthDate'];
		$this->HireDate->DbValue = $row['HireDate'];
		$this->Address->DbValue = $row['Address'];
		$this->City->DbValue = $row['City'];
		$this->Region->DbValue = $row['Region'];
		$this->PostalCode->DbValue = $row['PostalCode'];
		$this->Country->DbValue = $row['Country'];
		$this->HomePhone->DbValue = $row['HomePhone'];
		$this->Extension->DbValue = $row['Extension'];
		$this->_Email->DbValue = $row['Email'];
		$this->Photo->DbValue = $row['Photo'];
		$this->Notes->DbValue = $row['Notes'];
		$this->ReportsTo->DbValue = $row['ReportsTo'];
		$this->Password->DbValue = $row['Password'];
		$this->UserLevel->DbValue = $row['UserLevel'];
		$this->Username->DbValue = $row['Username'];
		$this->Activated->DbValue = $row['Activated'];
		$this->Profile->DbValue = $row['Profile'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// EmployeeID
		// LastName
		// FirstName
		// Title
		// TitleOfCourtesy
		// BirthDate
		// HireDate
		// Address
		// City
		// Region
		// PostalCode
		// Country
		// HomePhone
		// Extension
		// Email
		// Photo
		// Notes
		// ReportsTo
		// Password
		// UserLevel
		// Username
		// Activated
		// Profile

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// EmployeeID
		$this->EmployeeID->ViewValue = $this->EmployeeID->CurrentValue;
		$this->EmployeeID->ViewCustomAttributes = "";

		// LastName
		$this->LastName->ViewValue = $this->LastName->CurrentValue;
		$this->LastName->ViewCustomAttributes = "";

		// FirstName
		$this->FirstName->ViewValue = $this->FirstName->CurrentValue;
		$this->FirstName->ViewCustomAttributes = "";

		// Title
		$this->Title->ViewValue = $this->Title->CurrentValue;
		$this->Title->ViewCustomAttributes = "";

		// TitleOfCourtesy
		$this->TitleOfCourtesy->ViewValue = $this->TitleOfCourtesy->CurrentValue;
		$this->TitleOfCourtesy->ViewCustomAttributes = "";

		// BirthDate
		$this->BirthDate->ViewValue = $this->BirthDate->CurrentValue;
		$this->BirthDate->ViewValue = ew_FormatDateTime($this->BirthDate->ViewValue, 0);
		$this->BirthDate->ViewCustomAttributes = "";

		// HireDate
		$this->HireDate->ViewValue = $this->HireDate->CurrentValue;
		$this->HireDate->ViewValue = ew_FormatDateTime($this->HireDate->ViewValue, 0);
		$this->HireDate->ViewCustomAttributes = "";

		// Address
		$this->Address->ViewValue = $this->Address->CurrentValue;
		$this->Address->ViewCustomAttributes = "";

		// City
		$this->City->ViewValue = $this->City->CurrentValue;
		$this->City->ViewCustomAttributes = "";

		// Region
		$this->Region->ViewValue = $this->Region->CurrentValue;
		$this->Region->ViewCustomAttributes = "";

		// PostalCode
		$this->PostalCode->ViewValue = $this->PostalCode->CurrentValue;
		$this->PostalCode->ViewCustomAttributes = "";

		// Country
		$this->Country->ViewValue = $this->Country->CurrentValue;
		$this->Country->ViewCustomAttributes = "";

		// HomePhone
		$this->HomePhone->ViewValue = $this->HomePhone->CurrentValue;
		$this->HomePhone->ViewCustomAttributes = "";

		// Extension
		$this->Extension->ViewValue = $this->Extension->CurrentValue;
		$this->Extension->ViewCustomAttributes = "";

		// Email
		$this->_Email->ViewValue = $this->_Email->CurrentValue;
		$this->_Email->ViewCustomAttributes = "";

		// Photo
		$this->Photo->ViewValue = $this->Photo->CurrentValue;
		$this->Photo->ViewCustomAttributes = "";

		// ReportsTo
		$this->ReportsTo->ViewValue = $this->ReportsTo->CurrentValue;
		$this->ReportsTo->ViewCustomAttributes = "";

		// Password
		$this->Password->ViewValue = $this->Password->CurrentValue;
		$this->Password->ViewCustomAttributes = "";

		// UserLevel
		if ($Security->CanAdmin()) { // System admin
		if (strval($this->UserLevel->CurrentValue) <> "") {
			$sFilterWrk = "`userlevelid`" . ew_SearchString("=", $this->UserLevel->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `userlevelid`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t97_userlevels`";
		$sWhereWrk = "";
		$this->UserLevel->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->UserLevel, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->UserLevel->ViewValue = $this->UserLevel->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->UserLevel->ViewValue = $this->UserLevel->CurrentValue;
			}
		} else {
			$this->UserLevel->ViewValue = NULL;
		}
		} else {
			$this->UserLevel->ViewValue = $Language->Phrase("PasswordMask");
		}
		$this->UserLevel->ViewCustomAttributes = "";

		// Username
		$this->Username->ViewValue = $this->Username->CurrentValue;
		$this->Username->ViewCustomAttributes = "";

		// Activated
		if (ew_ConvertToBool($this->Activated->CurrentValue)) {
			$this->Activated->ViewValue = $this->Activated->FldTagCaption(1) <> "" ? $this->Activated->FldTagCaption(1) : "Y";
		} else {
			$this->Activated->ViewValue = $this->Activated->FldTagCaption(2) <> "" ? $this->Activated->FldTagCaption(2) : "N";
		}
		$this->Activated->ViewCustomAttributes = "";

			// EmployeeID
			$this->EmployeeID->LinkCustomAttributes = "";
			$this->EmployeeID->HrefValue = "";
			$this->EmployeeID->TooltipValue = "";

			// LastName
			$this->LastName->LinkCustomAttributes = "";
			$this->LastName->HrefValue = "";
			$this->LastName->TooltipValue = "";

			// FirstName
			$this->FirstName->LinkCustomAttributes = "";
			$this->FirstName->HrefValue = "";
			$this->FirstName->TooltipValue = "";

			// Title
			$this->Title->LinkCustomAttributes = "";
			$this->Title->HrefValue = "";
			$this->Title->TooltipValue = "";

			// TitleOfCourtesy
			$this->TitleOfCourtesy->LinkCustomAttributes = "";
			$this->TitleOfCourtesy->HrefValue = "";
			$this->TitleOfCourtesy->TooltipValue = "";

			// BirthDate
			$this->BirthDate->LinkCustomAttributes = "";
			$this->BirthDate->HrefValue = "";
			$this->BirthDate->TooltipValue = "";

			// HireDate
			$this->HireDate->LinkCustomAttributes = "";
			$this->HireDate->HrefValue = "";
			$this->HireDate->TooltipValue = "";

			// Address
			$this->Address->LinkCustomAttributes = "";
			$this->Address->HrefValue = "";
			$this->Address->TooltipValue = "";

			// City
			$this->City->LinkCustomAttributes = "";
			$this->City->HrefValue = "";
			$this->City->TooltipValue = "";

			// Region
			$this->Region->LinkCustomAttributes = "";
			$this->Region->HrefValue = "";
			$this->Region->TooltipValue = "";

			// PostalCode
			$this->PostalCode->LinkCustomAttributes = "";
			$this->PostalCode->HrefValue = "";
			$this->PostalCode->TooltipValue = "";

			// Country
			$this->Country->LinkCustomAttributes = "";
			$this->Country->HrefValue = "";
			$this->Country->TooltipValue = "";

			// HomePhone
			$this->HomePhone->LinkCustomAttributes = "";
			$this->HomePhone->HrefValue = "";
			$this->HomePhone->TooltipValue = "";

			// Extension
			$this->Extension->LinkCustomAttributes = "";
			$this->Extension->HrefValue = "";
			$this->Extension->TooltipValue = "";

			// Email
			$this->_Email->LinkCustomAttributes = "";
			$this->_Email->HrefValue = "";
			$this->_Email->TooltipValue = "";

			// Photo
			$this->Photo->LinkCustomAttributes = "";
			$this->Photo->HrefValue = "";
			$this->Photo->TooltipValue = "";

			// ReportsTo
			$this->ReportsTo->LinkCustomAttributes = "";
			$this->ReportsTo->HrefValue = "";
			$this->ReportsTo->TooltipValue = "";

			// Password
			$this->Password->LinkCustomAttributes = "";
			$this->Password->HrefValue = "";
			$this->Password->TooltipValue = "";

			// UserLevel
			$this->UserLevel->LinkCustomAttributes = "";
			$this->UserLevel->HrefValue = "";
			$this->UserLevel->TooltipValue = "";

			// Username
			$this->Username->LinkCustomAttributes = "";
			$this->Username->HrefValue = "";
			$this->Username->TooltipValue = "";

			// Activated
			$this->Activated->LinkCustomAttributes = "";
			$this->Activated->HrefValue = "";
			$this->Activated->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();
		if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteBegin")); // Batch delete begin

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['EmployeeID'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
			if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteSuccess")); // Batch delete success
		} else {
			$conn->RollbackTrans(); // Rollback changes
			if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteRollback")); // Batch delete rollback
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Show link optionally based on User ID
	function ShowOptionLink($id = "") {
		global $Security;
		if ($Security->IsLoggedIn() && !$Security->IsAdmin() && !$this->UserIDAllow($id))
			return $Security->IsValidUserID($this->EmployeeID->CurrentValue);
		return TRUE;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t96_employeeslist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t96_employees_delete)) $t96_employees_delete = new ct96_employees_delete();

// Page init
$t96_employees_delete->Page_Init();

// Page main
$t96_employees_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t96_employees_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = ft96_employeesdelete = new ew_Form("ft96_employeesdelete", "delete");

// Form_CustomValidate event
ft96_employeesdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft96_employeesdelete.ValidateRequired = true;
<?php } else { ?>
ft96_employeesdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft96_employeesdelete.Lists["x_UserLevel"] = {"LinkField":"x_userlevelid","Ajax":true,"AutoFill":false,"DisplayFields":["x_userlevelname","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t97_userlevels"};
ft96_employeesdelete.Lists["x_Activated"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ft96_employeesdelete.Lists["x_Activated"].Options = <?php echo json_encode($t96_employees->Activated->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $t96_employees_delete->ShowPageHeader(); ?>
<?php
$t96_employees_delete->ShowMessage();
?>
<form name="ft96_employeesdelete" id="ft96_employeesdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t96_employees_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t96_employees_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t96_employees">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($t96_employees_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $t96_employees->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($t96_employees->EmployeeID->Visible) { // EmployeeID ?>
		<th><span id="elh_t96_employees_EmployeeID" class="t96_employees_EmployeeID"><?php echo $t96_employees->EmployeeID->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t96_employees->LastName->Visible) { // LastName ?>
		<th><span id="elh_t96_employees_LastName" class="t96_employees_LastName"><?php echo $t96_employees->LastName->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t96_employees->FirstName->Visible) { // FirstName ?>
		<th><span id="elh_t96_employees_FirstName" class="t96_employees_FirstName"><?php echo $t96_employees->FirstName->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t96_employees->Title->Visible) { // Title ?>
		<th><span id="elh_t96_employees_Title" class="t96_employees_Title"><?php echo $t96_employees->Title->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t96_employees->TitleOfCourtesy->Visible) { // TitleOfCourtesy ?>
		<th><span id="elh_t96_employees_TitleOfCourtesy" class="t96_employees_TitleOfCourtesy"><?php echo $t96_employees->TitleOfCourtesy->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t96_employees->BirthDate->Visible) { // BirthDate ?>
		<th><span id="elh_t96_employees_BirthDate" class="t96_employees_BirthDate"><?php echo $t96_employees->BirthDate->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t96_employees->HireDate->Visible) { // HireDate ?>
		<th><span id="elh_t96_employees_HireDate" class="t96_employees_HireDate"><?php echo $t96_employees->HireDate->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t96_employees->Address->Visible) { // Address ?>
		<th><span id="elh_t96_employees_Address" class="t96_employees_Address"><?php echo $t96_employees->Address->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t96_employees->City->Visible) { // City ?>
		<th><span id="elh_t96_employees_City" class="t96_employees_City"><?php echo $t96_employees->City->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t96_employees->Region->Visible) { // Region ?>
		<th><span id="elh_t96_employees_Region" class="t96_employees_Region"><?php echo $t96_employees->Region->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t96_employees->PostalCode->Visible) { // PostalCode ?>
		<th><span id="elh_t96_employees_PostalCode" class="t96_employees_PostalCode"><?php echo $t96_employees->PostalCode->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t96_employees->Country->Visible) { // Country ?>
		<th><span id="elh_t96_employees_Country" class="t96_employees_Country"><?php echo $t96_employees->Country->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t96_employees->HomePhone->Visible) { // HomePhone ?>
		<th><span id="elh_t96_employees_HomePhone" class="t96_employees_HomePhone"><?php echo $t96_employees->HomePhone->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t96_employees->Extension->Visible) { // Extension ?>
		<th><span id="elh_t96_employees_Extension" class="t96_employees_Extension"><?php echo $t96_employees->Extension->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t96_employees->_Email->Visible) { // Email ?>
		<th><span id="elh_t96_employees__Email" class="t96_employees__Email"><?php echo $t96_employees->_Email->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t96_employees->Photo->Visible) { // Photo ?>
		<th><span id="elh_t96_employees_Photo" class="t96_employees_Photo"><?php echo $t96_employees->Photo->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t96_employees->ReportsTo->Visible) { // ReportsTo ?>
		<th><span id="elh_t96_employees_ReportsTo" class="t96_employees_ReportsTo"><?php echo $t96_employees->ReportsTo->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t96_employees->Password->Visible) { // Password ?>
		<th><span id="elh_t96_employees_Password" class="t96_employees_Password"><?php echo $t96_employees->Password->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t96_employees->UserLevel->Visible) { // UserLevel ?>
		<th><span id="elh_t96_employees_UserLevel" class="t96_employees_UserLevel"><?php echo $t96_employees->UserLevel->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t96_employees->Username->Visible) { // Username ?>
		<th><span id="elh_t96_employees_Username" class="t96_employees_Username"><?php echo $t96_employees->Username->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t96_employees->Activated->Visible) { // Activated ?>
		<th><span id="elh_t96_employees_Activated" class="t96_employees_Activated"><?php echo $t96_employees->Activated->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$t96_employees_delete->RecCnt = 0;
$i = 0;
while (!$t96_employees_delete->Recordset->EOF) {
	$t96_employees_delete->RecCnt++;
	$t96_employees_delete->RowCnt++;

	// Set row properties
	$t96_employees->ResetAttrs();
	$t96_employees->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$t96_employees_delete->LoadRowValues($t96_employees_delete->Recordset);

	// Render row
	$t96_employees_delete->RenderRow();
?>
	<tr<?php echo $t96_employees->RowAttributes() ?>>
<?php if ($t96_employees->EmployeeID->Visible) { // EmployeeID ?>
		<td<?php echo $t96_employees->EmployeeID->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_delete->RowCnt ?>_t96_employees_EmployeeID" class="t96_employees_EmployeeID">
<span<?php echo $t96_employees->EmployeeID->ViewAttributes() ?>>
<?php echo $t96_employees->EmployeeID->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t96_employees->LastName->Visible) { // LastName ?>
		<td<?php echo $t96_employees->LastName->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_delete->RowCnt ?>_t96_employees_LastName" class="t96_employees_LastName">
<span<?php echo $t96_employees->LastName->ViewAttributes() ?>>
<?php echo $t96_employees->LastName->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t96_employees->FirstName->Visible) { // FirstName ?>
		<td<?php echo $t96_employees->FirstName->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_delete->RowCnt ?>_t96_employees_FirstName" class="t96_employees_FirstName">
<span<?php echo $t96_employees->FirstName->ViewAttributes() ?>>
<?php echo $t96_employees->FirstName->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t96_employees->Title->Visible) { // Title ?>
		<td<?php echo $t96_employees->Title->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_delete->RowCnt ?>_t96_employees_Title" class="t96_employees_Title">
<span<?php echo $t96_employees->Title->ViewAttributes() ?>>
<?php echo $t96_employees->Title->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t96_employees->TitleOfCourtesy->Visible) { // TitleOfCourtesy ?>
		<td<?php echo $t96_employees->TitleOfCourtesy->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_delete->RowCnt ?>_t96_employees_TitleOfCourtesy" class="t96_employees_TitleOfCourtesy">
<span<?php echo $t96_employees->TitleOfCourtesy->ViewAttributes() ?>>
<?php echo $t96_employees->TitleOfCourtesy->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t96_employees->BirthDate->Visible) { // BirthDate ?>
		<td<?php echo $t96_employees->BirthDate->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_delete->RowCnt ?>_t96_employees_BirthDate" class="t96_employees_BirthDate">
<span<?php echo $t96_employees->BirthDate->ViewAttributes() ?>>
<?php echo $t96_employees->BirthDate->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t96_employees->HireDate->Visible) { // HireDate ?>
		<td<?php echo $t96_employees->HireDate->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_delete->RowCnt ?>_t96_employees_HireDate" class="t96_employees_HireDate">
<span<?php echo $t96_employees->HireDate->ViewAttributes() ?>>
<?php echo $t96_employees->HireDate->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t96_employees->Address->Visible) { // Address ?>
		<td<?php echo $t96_employees->Address->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_delete->RowCnt ?>_t96_employees_Address" class="t96_employees_Address">
<span<?php echo $t96_employees->Address->ViewAttributes() ?>>
<?php echo $t96_employees->Address->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t96_employees->City->Visible) { // City ?>
		<td<?php echo $t96_employees->City->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_delete->RowCnt ?>_t96_employees_City" class="t96_employees_City">
<span<?php echo $t96_employees->City->ViewAttributes() ?>>
<?php echo $t96_employees->City->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t96_employees->Region->Visible) { // Region ?>
		<td<?php echo $t96_employees->Region->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_delete->RowCnt ?>_t96_employees_Region" class="t96_employees_Region">
<span<?php echo $t96_employees->Region->ViewAttributes() ?>>
<?php echo $t96_employees->Region->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t96_employees->PostalCode->Visible) { // PostalCode ?>
		<td<?php echo $t96_employees->PostalCode->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_delete->RowCnt ?>_t96_employees_PostalCode" class="t96_employees_PostalCode">
<span<?php echo $t96_employees->PostalCode->ViewAttributes() ?>>
<?php echo $t96_employees->PostalCode->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t96_employees->Country->Visible) { // Country ?>
		<td<?php echo $t96_employees->Country->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_delete->RowCnt ?>_t96_employees_Country" class="t96_employees_Country">
<span<?php echo $t96_employees->Country->ViewAttributes() ?>>
<?php echo $t96_employees->Country->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t96_employees->HomePhone->Visible) { // HomePhone ?>
		<td<?php echo $t96_employees->HomePhone->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_delete->RowCnt ?>_t96_employees_HomePhone" class="t96_employees_HomePhone">
<span<?php echo $t96_employees->HomePhone->ViewAttributes() ?>>
<?php echo $t96_employees->HomePhone->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t96_employees->Extension->Visible) { // Extension ?>
		<td<?php echo $t96_employees->Extension->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_delete->RowCnt ?>_t96_employees_Extension" class="t96_employees_Extension">
<span<?php echo $t96_employees->Extension->ViewAttributes() ?>>
<?php echo $t96_employees->Extension->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t96_employees->_Email->Visible) { // Email ?>
		<td<?php echo $t96_employees->_Email->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_delete->RowCnt ?>_t96_employees__Email" class="t96_employees__Email">
<span<?php echo $t96_employees->_Email->ViewAttributes() ?>>
<?php echo $t96_employees->_Email->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t96_employees->Photo->Visible) { // Photo ?>
		<td<?php echo $t96_employees->Photo->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_delete->RowCnt ?>_t96_employees_Photo" class="t96_employees_Photo">
<span<?php echo $t96_employees->Photo->ViewAttributes() ?>>
<?php echo $t96_employees->Photo->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t96_employees->ReportsTo->Visible) { // ReportsTo ?>
		<td<?php echo $t96_employees->ReportsTo->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_delete->RowCnt ?>_t96_employees_ReportsTo" class="t96_employees_ReportsTo">
<span<?php echo $t96_employees->ReportsTo->ViewAttributes() ?>>
<?php echo $t96_employees->ReportsTo->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t96_employees->Password->Visible) { // Password ?>
		<td<?php echo $t96_employees->Password->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_delete->RowCnt ?>_t96_employees_Password" class="t96_employees_Password">
<span<?php echo $t96_employees->Password->ViewAttributes() ?>>
<?php echo $t96_employees->Password->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t96_employees->UserLevel->Visible) { // UserLevel ?>
		<td<?php echo $t96_employees->UserLevel->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_delete->RowCnt ?>_t96_employees_UserLevel" class="t96_employees_UserLevel">
<span<?php echo $t96_employees->UserLevel->ViewAttributes() ?>>
<?php echo $t96_employees->UserLevel->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t96_employees->Username->Visible) { // Username ?>
		<td<?php echo $t96_employees->Username->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_delete->RowCnt ?>_t96_employees_Username" class="t96_employees_Username">
<span<?php echo $t96_employees->Username->ViewAttributes() ?>>
<?php echo $t96_employees->Username->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t96_employees->Activated->Visible) { // Activated ?>
		<td<?php echo $t96_employees->Activated->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_delete->RowCnt ?>_t96_employees_Activated" class="t96_employees_Activated">
<span<?php echo $t96_employees->Activated->ViewAttributes() ?>>
<?php echo $t96_employees->Activated->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$t96_employees_delete->Recordset->MoveNext();
}
$t96_employees_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t96_employees_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
ft96_employeesdelete.Init();
</script>
<?php
$t96_employees_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t96_employees_delete->Page_Terminate();
?>
