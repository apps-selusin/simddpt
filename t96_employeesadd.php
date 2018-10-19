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

$t96_employees_add = NULL; // Initialize page object first

class ct96_employees_add extends ct96_employees {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{78A0660C-C398-4292-A50E-2A3C7D765239}";

	// Table name
	var $TableName = 't96_employees';

	// Page object name
	var $PageObjName = 't96_employees_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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
		if (!$Security->CanAdd()) {
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

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
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
		$this->Notes->SetVisibility();
		$this->ReportsTo->SetVisibility();
		$this->Password->SetVisibility();
		$this->UserLevel->SetVisibility();
		$this->Username->SetVisibility();
		$this->Activated->SetVisibility();
		$this->Profile->SetVisibility();

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
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $IsModal = FALSE;
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

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

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["EmployeeID"] != "") {
				$this->EmployeeID->setQueryStringValue($_GET["EmployeeID"]);
				$this->setKey("EmployeeID", $this->EmployeeID->CurrentValue); // Set up key
			} else {
				$this->setKey("EmployeeID", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		} else {
			if ($this->CurrentAction == "I") // Load default values for blank record
				$this->LoadDefaultValues();
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("t96_employeeslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "t96_employeeslist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "t96_employeesview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->LastName->CurrentValue = NULL;
		$this->LastName->OldValue = $this->LastName->CurrentValue;
		$this->FirstName->CurrentValue = NULL;
		$this->FirstName->OldValue = $this->FirstName->CurrentValue;
		$this->Title->CurrentValue = NULL;
		$this->Title->OldValue = $this->Title->CurrentValue;
		$this->TitleOfCourtesy->CurrentValue = NULL;
		$this->TitleOfCourtesy->OldValue = $this->TitleOfCourtesy->CurrentValue;
		$this->BirthDate->CurrentValue = NULL;
		$this->BirthDate->OldValue = $this->BirthDate->CurrentValue;
		$this->HireDate->CurrentValue = NULL;
		$this->HireDate->OldValue = $this->HireDate->CurrentValue;
		$this->Address->CurrentValue = NULL;
		$this->Address->OldValue = $this->Address->CurrentValue;
		$this->City->CurrentValue = NULL;
		$this->City->OldValue = $this->City->CurrentValue;
		$this->Region->CurrentValue = NULL;
		$this->Region->OldValue = $this->Region->CurrentValue;
		$this->PostalCode->CurrentValue = NULL;
		$this->PostalCode->OldValue = $this->PostalCode->CurrentValue;
		$this->Country->CurrentValue = NULL;
		$this->Country->OldValue = $this->Country->CurrentValue;
		$this->HomePhone->CurrentValue = NULL;
		$this->HomePhone->OldValue = $this->HomePhone->CurrentValue;
		$this->Extension->CurrentValue = NULL;
		$this->Extension->OldValue = $this->Extension->CurrentValue;
		$this->_Email->CurrentValue = NULL;
		$this->_Email->OldValue = $this->_Email->CurrentValue;
		$this->Photo->CurrentValue = NULL;
		$this->Photo->OldValue = $this->Photo->CurrentValue;
		$this->Notes->CurrentValue = NULL;
		$this->Notes->OldValue = $this->Notes->CurrentValue;
		$this->ReportsTo->CurrentValue = NULL;
		$this->ReportsTo->OldValue = $this->ReportsTo->CurrentValue;
		$this->Password->CurrentValue = NULL;
		$this->Password->OldValue = $this->Password->CurrentValue;
		$this->UserLevel->CurrentValue = NULL;
		$this->UserLevel->OldValue = $this->UserLevel->CurrentValue;
		$this->Username->CurrentValue = NULL;
		$this->Username->OldValue = $this->Username->CurrentValue;
		$this->Activated->CurrentValue = "N";
		$this->Profile->CurrentValue = NULL;
		$this->Profile->OldValue = $this->Profile->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->LastName->FldIsDetailKey) {
			$this->LastName->setFormValue($objForm->GetValue("x_LastName"));
		}
		if (!$this->FirstName->FldIsDetailKey) {
			$this->FirstName->setFormValue($objForm->GetValue("x_FirstName"));
		}
		if (!$this->Title->FldIsDetailKey) {
			$this->Title->setFormValue($objForm->GetValue("x_Title"));
		}
		if (!$this->TitleOfCourtesy->FldIsDetailKey) {
			$this->TitleOfCourtesy->setFormValue($objForm->GetValue("x_TitleOfCourtesy"));
		}
		if (!$this->BirthDate->FldIsDetailKey) {
			$this->BirthDate->setFormValue($objForm->GetValue("x_BirthDate"));
			$this->BirthDate->CurrentValue = ew_UnFormatDateTime($this->BirthDate->CurrentValue, 0);
		}
		if (!$this->HireDate->FldIsDetailKey) {
			$this->HireDate->setFormValue($objForm->GetValue("x_HireDate"));
			$this->HireDate->CurrentValue = ew_UnFormatDateTime($this->HireDate->CurrentValue, 0);
		}
		if (!$this->Address->FldIsDetailKey) {
			$this->Address->setFormValue($objForm->GetValue("x_Address"));
		}
		if (!$this->City->FldIsDetailKey) {
			$this->City->setFormValue($objForm->GetValue("x_City"));
		}
		if (!$this->Region->FldIsDetailKey) {
			$this->Region->setFormValue($objForm->GetValue("x_Region"));
		}
		if (!$this->PostalCode->FldIsDetailKey) {
			$this->PostalCode->setFormValue($objForm->GetValue("x_PostalCode"));
		}
		if (!$this->Country->FldIsDetailKey) {
			$this->Country->setFormValue($objForm->GetValue("x_Country"));
		}
		if (!$this->HomePhone->FldIsDetailKey) {
			$this->HomePhone->setFormValue($objForm->GetValue("x_HomePhone"));
		}
		if (!$this->Extension->FldIsDetailKey) {
			$this->Extension->setFormValue($objForm->GetValue("x_Extension"));
		}
		if (!$this->_Email->FldIsDetailKey) {
			$this->_Email->setFormValue($objForm->GetValue("x__Email"));
		}
		if (!$this->Photo->FldIsDetailKey) {
			$this->Photo->setFormValue($objForm->GetValue("x_Photo"));
		}
		if (!$this->Notes->FldIsDetailKey) {
			$this->Notes->setFormValue($objForm->GetValue("x_Notes"));
		}
		if (!$this->ReportsTo->FldIsDetailKey) {
			$this->ReportsTo->setFormValue($objForm->GetValue("x_ReportsTo"));
		}
		if (!$this->Password->FldIsDetailKey) {
			$this->Password->setFormValue($objForm->GetValue("x_Password"));
		}
		if (!$this->UserLevel->FldIsDetailKey) {
			$this->UserLevel->setFormValue($objForm->GetValue("x_UserLevel"));
		}
		if (!$this->Username->FldIsDetailKey) {
			$this->Username->setFormValue($objForm->GetValue("x_Username"));
		}
		if (!$this->Activated->FldIsDetailKey) {
			$this->Activated->setFormValue($objForm->GetValue("x_Activated"));
		}
		if (!$this->Profile->FldIsDetailKey) {
			$this->Profile->setFormValue($objForm->GetValue("x_Profile"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->LastName->CurrentValue = $this->LastName->FormValue;
		$this->FirstName->CurrentValue = $this->FirstName->FormValue;
		$this->Title->CurrentValue = $this->Title->FormValue;
		$this->TitleOfCourtesy->CurrentValue = $this->TitleOfCourtesy->FormValue;
		$this->BirthDate->CurrentValue = $this->BirthDate->FormValue;
		$this->BirthDate->CurrentValue = ew_UnFormatDateTime($this->BirthDate->CurrentValue, 0);
		$this->HireDate->CurrentValue = $this->HireDate->FormValue;
		$this->HireDate->CurrentValue = ew_UnFormatDateTime($this->HireDate->CurrentValue, 0);
		$this->Address->CurrentValue = $this->Address->FormValue;
		$this->City->CurrentValue = $this->City->FormValue;
		$this->Region->CurrentValue = $this->Region->FormValue;
		$this->PostalCode->CurrentValue = $this->PostalCode->FormValue;
		$this->Country->CurrentValue = $this->Country->FormValue;
		$this->HomePhone->CurrentValue = $this->HomePhone->FormValue;
		$this->Extension->CurrentValue = $this->Extension->FormValue;
		$this->_Email->CurrentValue = $this->_Email->FormValue;
		$this->Photo->CurrentValue = $this->Photo->FormValue;
		$this->Notes->CurrentValue = $this->Notes->FormValue;
		$this->ReportsTo->CurrentValue = $this->ReportsTo->FormValue;
		$this->Password->CurrentValue = $this->Password->FormValue;
		$this->UserLevel->CurrentValue = $this->UserLevel->FormValue;
		$this->Username->CurrentValue = $this->Username->FormValue;
		$this->Activated->CurrentValue = $this->Activated->FormValue;
		$this->Profile->CurrentValue = $this->Profile->FormValue;
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

		// Check if valid user id
		if ($res) {
			$res = $this->ShowOptionLink('add');
			if (!$res) {
				$sUserIdMsg = ew_DeniedMsg();
				$this->setFailureMessage($sUserIdMsg);
			}
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("EmployeeID")) <> "")
			$this->EmployeeID->CurrentValue = $this->getKey("EmployeeID"); // EmployeeID
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
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

		// Notes
		$this->Notes->ViewValue = $this->Notes->CurrentValue;
		$this->Notes->ViewCustomAttributes = "";

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

		// Profile
		$this->Profile->ViewValue = $this->Profile->CurrentValue;
		$this->Profile->ViewCustomAttributes = "";

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

			// Notes
			$this->Notes->LinkCustomAttributes = "";
			$this->Notes->HrefValue = "";
			$this->Notes->TooltipValue = "";

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

			// Profile
			$this->Profile->LinkCustomAttributes = "";
			$this->Profile->HrefValue = "";
			$this->Profile->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// LastName
			$this->LastName->EditAttrs["class"] = "form-control";
			$this->LastName->EditCustomAttributes = "";
			$this->LastName->EditValue = ew_HtmlEncode($this->LastName->CurrentValue);
			$this->LastName->PlaceHolder = ew_RemoveHtml($this->LastName->FldCaption());

			// FirstName
			$this->FirstName->EditAttrs["class"] = "form-control";
			$this->FirstName->EditCustomAttributes = "";
			$this->FirstName->EditValue = ew_HtmlEncode($this->FirstName->CurrentValue);
			$this->FirstName->PlaceHolder = ew_RemoveHtml($this->FirstName->FldCaption());

			// Title
			$this->Title->EditAttrs["class"] = "form-control";
			$this->Title->EditCustomAttributes = "";
			$this->Title->EditValue = ew_HtmlEncode($this->Title->CurrentValue);
			$this->Title->PlaceHolder = ew_RemoveHtml($this->Title->FldCaption());

			// TitleOfCourtesy
			$this->TitleOfCourtesy->EditAttrs["class"] = "form-control";
			$this->TitleOfCourtesy->EditCustomAttributes = "";
			$this->TitleOfCourtesy->EditValue = ew_HtmlEncode($this->TitleOfCourtesy->CurrentValue);
			$this->TitleOfCourtesy->PlaceHolder = ew_RemoveHtml($this->TitleOfCourtesy->FldCaption());

			// BirthDate
			$this->BirthDate->EditAttrs["class"] = "form-control";
			$this->BirthDate->EditCustomAttributes = "";
			$this->BirthDate->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->BirthDate->CurrentValue, 8));
			$this->BirthDate->PlaceHolder = ew_RemoveHtml($this->BirthDate->FldCaption());

			// HireDate
			$this->HireDate->EditAttrs["class"] = "form-control";
			$this->HireDate->EditCustomAttributes = "";
			$this->HireDate->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->HireDate->CurrentValue, 8));
			$this->HireDate->PlaceHolder = ew_RemoveHtml($this->HireDate->FldCaption());

			// Address
			$this->Address->EditAttrs["class"] = "form-control";
			$this->Address->EditCustomAttributes = "";
			$this->Address->EditValue = ew_HtmlEncode($this->Address->CurrentValue);
			$this->Address->PlaceHolder = ew_RemoveHtml($this->Address->FldCaption());

			// City
			$this->City->EditAttrs["class"] = "form-control";
			$this->City->EditCustomAttributes = "";
			$this->City->EditValue = ew_HtmlEncode($this->City->CurrentValue);
			$this->City->PlaceHolder = ew_RemoveHtml($this->City->FldCaption());

			// Region
			$this->Region->EditAttrs["class"] = "form-control";
			$this->Region->EditCustomAttributes = "";
			$this->Region->EditValue = ew_HtmlEncode($this->Region->CurrentValue);
			$this->Region->PlaceHolder = ew_RemoveHtml($this->Region->FldCaption());

			// PostalCode
			$this->PostalCode->EditAttrs["class"] = "form-control";
			$this->PostalCode->EditCustomAttributes = "";
			$this->PostalCode->EditValue = ew_HtmlEncode($this->PostalCode->CurrentValue);
			$this->PostalCode->PlaceHolder = ew_RemoveHtml($this->PostalCode->FldCaption());

			// Country
			$this->Country->EditAttrs["class"] = "form-control";
			$this->Country->EditCustomAttributes = "";
			$this->Country->EditValue = ew_HtmlEncode($this->Country->CurrentValue);
			$this->Country->PlaceHolder = ew_RemoveHtml($this->Country->FldCaption());

			// HomePhone
			$this->HomePhone->EditAttrs["class"] = "form-control";
			$this->HomePhone->EditCustomAttributes = "";
			$this->HomePhone->EditValue = ew_HtmlEncode($this->HomePhone->CurrentValue);
			$this->HomePhone->PlaceHolder = ew_RemoveHtml($this->HomePhone->FldCaption());

			// Extension
			$this->Extension->EditAttrs["class"] = "form-control";
			$this->Extension->EditCustomAttributes = "";
			$this->Extension->EditValue = ew_HtmlEncode($this->Extension->CurrentValue);
			$this->Extension->PlaceHolder = ew_RemoveHtml($this->Extension->FldCaption());

			// Email
			$this->_Email->EditAttrs["class"] = "form-control";
			$this->_Email->EditCustomAttributes = "";
			$this->_Email->EditValue = ew_HtmlEncode($this->_Email->CurrentValue);
			$this->_Email->PlaceHolder = ew_RemoveHtml($this->_Email->FldCaption());

			// Photo
			$this->Photo->EditAttrs["class"] = "form-control";
			$this->Photo->EditCustomAttributes = "";
			$this->Photo->EditValue = ew_HtmlEncode($this->Photo->CurrentValue);
			$this->Photo->PlaceHolder = ew_RemoveHtml($this->Photo->FldCaption());

			// Notes
			$this->Notes->EditAttrs["class"] = "form-control";
			$this->Notes->EditCustomAttributes = "";
			$this->Notes->EditValue = ew_HtmlEncode($this->Notes->CurrentValue);
			$this->Notes->PlaceHolder = ew_RemoveHtml($this->Notes->FldCaption());

			// ReportsTo
			$this->ReportsTo->EditAttrs["class"] = "form-control";
			$this->ReportsTo->EditCustomAttributes = "";
			$this->ReportsTo->EditValue = ew_HtmlEncode($this->ReportsTo->CurrentValue);
			$this->ReportsTo->PlaceHolder = ew_RemoveHtml($this->ReportsTo->FldCaption());

			// Password
			$this->Password->EditAttrs["class"] = "form-control ewPasswordStrength";
			$this->Password->EditCustomAttributes = "";
			$this->Password->EditValue = ew_HtmlEncode($this->Password->CurrentValue);
			$this->Password->PlaceHolder = ew_RemoveHtml($this->Password->FldCaption());

			// UserLevel
			$this->UserLevel->EditAttrs["class"] = "form-control";
			$this->UserLevel->EditCustomAttributes = "";
			if (!$Security->CanAdmin()) { // System admin
				$this->UserLevel->EditValue = $Language->Phrase("PasswordMask");
			} else {
			if (trim(strval($this->UserLevel->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`userlevelid`" . ew_SearchString("=", $this->UserLevel->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `userlevelid`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `t97_userlevels`";
			$sWhereWrk = "";
			$this->UserLevel->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->UserLevel, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->UserLevel->EditValue = $arwrk;
			}

			// Username
			$this->Username->EditAttrs["class"] = "form-control";
			$this->Username->EditCustomAttributes = "";
			$this->Username->EditValue = ew_HtmlEncode($this->Username->CurrentValue);
			$this->Username->PlaceHolder = ew_RemoveHtml($this->Username->FldCaption());

			// Activated
			$this->Activated->EditCustomAttributes = "";
			$this->Activated->EditValue = $this->Activated->Options(FALSE);

			// Profile
			$this->Profile->EditAttrs["class"] = "form-control";
			$this->Profile->EditCustomAttributes = "";
			$this->Profile->EditValue = ew_HtmlEncode($this->Profile->CurrentValue);
			$this->Profile->PlaceHolder = ew_RemoveHtml($this->Profile->FldCaption());

			// Add refer script
			// LastName

			$this->LastName->LinkCustomAttributes = "";
			$this->LastName->HrefValue = "";

			// FirstName
			$this->FirstName->LinkCustomAttributes = "";
			$this->FirstName->HrefValue = "";

			// Title
			$this->Title->LinkCustomAttributes = "";
			$this->Title->HrefValue = "";

			// TitleOfCourtesy
			$this->TitleOfCourtesy->LinkCustomAttributes = "";
			$this->TitleOfCourtesy->HrefValue = "";

			// BirthDate
			$this->BirthDate->LinkCustomAttributes = "";
			$this->BirthDate->HrefValue = "";

			// HireDate
			$this->HireDate->LinkCustomAttributes = "";
			$this->HireDate->HrefValue = "";

			// Address
			$this->Address->LinkCustomAttributes = "";
			$this->Address->HrefValue = "";

			// City
			$this->City->LinkCustomAttributes = "";
			$this->City->HrefValue = "";

			// Region
			$this->Region->LinkCustomAttributes = "";
			$this->Region->HrefValue = "";

			// PostalCode
			$this->PostalCode->LinkCustomAttributes = "";
			$this->PostalCode->HrefValue = "";

			// Country
			$this->Country->LinkCustomAttributes = "";
			$this->Country->HrefValue = "";

			// HomePhone
			$this->HomePhone->LinkCustomAttributes = "";
			$this->HomePhone->HrefValue = "";

			// Extension
			$this->Extension->LinkCustomAttributes = "";
			$this->Extension->HrefValue = "";

			// Email
			$this->_Email->LinkCustomAttributes = "";
			$this->_Email->HrefValue = "";

			// Photo
			$this->Photo->LinkCustomAttributes = "";
			$this->Photo->HrefValue = "";

			// Notes
			$this->Notes->LinkCustomAttributes = "";
			$this->Notes->HrefValue = "";

			// ReportsTo
			$this->ReportsTo->LinkCustomAttributes = "";
			$this->ReportsTo->HrefValue = "";

			// Password
			$this->Password->LinkCustomAttributes = "";
			$this->Password->HrefValue = "";

			// UserLevel
			$this->UserLevel->LinkCustomAttributes = "";
			$this->UserLevel->HrefValue = "";

			// Username
			$this->Username->LinkCustomAttributes = "";
			$this->Username->HrefValue = "";

			// Activated
			$this->Activated->LinkCustomAttributes = "";
			$this->Activated->HrefValue = "";

			// Profile
			$this->Profile->LinkCustomAttributes = "";
			$this->Profile->HrefValue = "";
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
		if (!ew_CheckDateDef($this->BirthDate->FormValue)) {
			ew_AddMessage($gsFormError, $this->BirthDate->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->HireDate->FormValue)) {
			ew_AddMessage($gsFormError, $this->HireDate->FldErrMsg());
		}
		if (!ew_CheckInteger($this->ReportsTo->FormValue)) {
			ew_AddMessage($gsFormError, $this->ReportsTo->FldErrMsg());
		}
		if (!$this->Password->FldIsDetailKey && !is_null($this->Password->FormValue) && $this->Password->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Password->FldCaption(), $this->Password->ReqErrMsg));
		}
		if (!$this->Username->FldIsDetailKey && !is_null($this->Username->FormValue) && $this->Username->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Username->FldCaption(), $this->Username->ReqErrMsg));
		}
		if ($this->Activated->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Activated->FldCaption(), $this->Activated->ReqErrMsg));
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
		global $Language, $Security;

		// Check if valid User ID
		$bValidUser = FALSE;
		if ($Security->CurrentUserID() <> "" && !ew_Empty($this->EmployeeID->CurrentValue) && !$Security->IsAdmin()) { // Non system admin
			$bValidUser = $Security->IsValidUserID($this->EmployeeID->CurrentValue);
			if (!$bValidUser) {
				$sUserIdMsg = str_replace("%c", CurrentUserID(), $Language->Phrase("UnAuthorizedUserID"));
				$sUserIdMsg = str_replace("%u", $this->EmployeeID->CurrentValue, $sUserIdMsg);
				$this->setFailureMessage($sUserIdMsg);
				return FALSE;
			}
		}
		if ($this->Username->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(Username = '" . ew_AdjustSql($this->Username->CurrentValue, $this->DBID) . "')";
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->Username->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->Username->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// LastName
		$this->LastName->SetDbValueDef($rsnew, $this->LastName->CurrentValue, NULL, FALSE);

		// FirstName
		$this->FirstName->SetDbValueDef($rsnew, $this->FirstName->CurrentValue, NULL, FALSE);

		// Title
		$this->Title->SetDbValueDef($rsnew, $this->Title->CurrentValue, NULL, FALSE);

		// TitleOfCourtesy
		$this->TitleOfCourtesy->SetDbValueDef($rsnew, $this->TitleOfCourtesy->CurrentValue, NULL, FALSE);

		// BirthDate
		$this->BirthDate->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->BirthDate->CurrentValue, 0), NULL, FALSE);

		// HireDate
		$this->HireDate->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->HireDate->CurrentValue, 0), NULL, FALSE);

		// Address
		$this->Address->SetDbValueDef($rsnew, $this->Address->CurrentValue, NULL, FALSE);

		// City
		$this->City->SetDbValueDef($rsnew, $this->City->CurrentValue, NULL, FALSE);

		// Region
		$this->Region->SetDbValueDef($rsnew, $this->Region->CurrentValue, NULL, FALSE);

		// PostalCode
		$this->PostalCode->SetDbValueDef($rsnew, $this->PostalCode->CurrentValue, NULL, FALSE);

		// Country
		$this->Country->SetDbValueDef($rsnew, $this->Country->CurrentValue, NULL, FALSE);

		// HomePhone
		$this->HomePhone->SetDbValueDef($rsnew, $this->HomePhone->CurrentValue, NULL, FALSE);

		// Extension
		$this->Extension->SetDbValueDef($rsnew, $this->Extension->CurrentValue, NULL, FALSE);

		// Email
		$this->_Email->SetDbValueDef($rsnew, $this->_Email->CurrentValue, NULL, FALSE);

		// Photo
		$this->Photo->SetDbValueDef($rsnew, $this->Photo->CurrentValue, NULL, FALSE);

		// Notes
		$this->Notes->SetDbValueDef($rsnew, $this->Notes->CurrentValue, NULL, FALSE);

		// ReportsTo
		$this->ReportsTo->SetDbValueDef($rsnew, $this->ReportsTo->CurrentValue, NULL, FALSE);

		// Password
		$this->Password->SetDbValueDef($rsnew, $this->Password->CurrentValue, "", FALSE);

		// UserLevel
		if ($Security->CanAdmin()) { // System admin
		$this->UserLevel->SetDbValueDef($rsnew, $this->UserLevel->CurrentValue, NULL, FALSE);
		}

		// Username
		$this->Username->SetDbValueDef($rsnew, $this->Username->CurrentValue, "", FALSE);

		// Activated
		$this->Activated->SetDbValueDef($rsnew, ((strval($this->Activated->CurrentValue) == "Y") ? "Y" : "N"), "N", strval($this->Activated->CurrentValue) == "");

		// Profile
		$this->Profile->SetDbValueDef($rsnew, $this->Profile->CurrentValue, NULL, FALSE);

		// EmployeeID
		// Call Row Inserting event

		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
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
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_UserLevel":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `userlevelid` AS `LinkFld`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t97_userlevels`";
			$sWhereWrk = "";
			$this->UserLevel->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`userlevelid` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->UserLevel, $sWhereWrk); // Call Lookup selecting
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
if (!isset($t96_employees_add)) $t96_employees_add = new ct96_employees_add();

// Page init
$t96_employees_add->Page_Init();

// Page main
$t96_employees_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t96_employees_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ft96_employeesadd = new ew_Form("ft96_employeesadd", "add");

// Validate form
ft96_employeesadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_BirthDate");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t96_employees->BirthDate->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_HireDate");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t96_employees->HireDate->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_ReportsTo");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t96_employees->ReportsTo->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Password");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t96_employees->Password->FldCaption(), $t96_employees->Password->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Password");
			if (elm && $(elm).hasClass("ewPasswordStrength") && !$(elm).data("validated"))
				return this.OnError(elm, ewLanguage.Phrase("PasswordTooSimple"));
			elm = this.GetElements("x" + infix + "_Username");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t96_employees->Username->FldCaption(), $t96_employees->Username->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Activated");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t96_employees->Activated->FldCaption(), $t96_employees->Activated->ReqErrMsg)) ?>");

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
ft96_employeesadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft96_employeesadd.ValidateRequired = true;
<?php } else { ?>
ft96_employeesadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft96_employeesadd.Lists["x_UserLevel"] = {"LinkField":"x_userlevelid","Ajax":true,"AutoFill":false,"DisplayFields":["x_userlevelname","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t97_userlevels"};
ft96_employeesadd.Lists["x_Activated"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ft96_employeesadd.Lists["x_Activated"].Options = <?php echo json_encode($t96_employees->Activated->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$t96_employees_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $t96_employees_add->ShowPageHeader(); ?>
<?php
$t96_employees_add->ShowMessage();
?>
<form name="ft96_employeesadd" id="ft96_employeesadd" class="<?php echo $t96_employees_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t96_employees_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t96_employees_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t96_employees">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($t96_employees_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<!-- Fields to prevent google autofill -->
<input class="hidden" type="text" name="<?php echo ew_Encrypt(ew_Random()) ?>">
<input class="hidden" type="password" name="<?php echo ew_Encrypt(ew_Random()) ?>">
<div>
<?php if ($t96_employees->LastName->Visible) { // LastName ?>
	<div id="r_LastName" class="form-group">
		<label id="elh_t96_employees_LastName" for="x_LastName" class="col-sm-2 control-label ewLabel"><?php echo $t96_employees->LastName->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t96_employees->LastName->CellAttributes() ?>>
<span id="el_t96_employees_LastName">
<input type="text" data-table="t96_employees" data-field="x_LastName" name="x_LastName" id="x_LastName" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($t96_employees->LastName->getPlaceHolder()) ?>" value="<?php echo $t96_employees->LastName->EditValue ?>"<?php echo $t96_employees->LastName->EditAttributes() ?>>
</span>
<?php echo $t96_employees->LastName->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t96_employees->FirstName->Visible) { // FirstName ?>
	<div id="r_FirstName" class="form-group">
		<label id="elh_t96_employees_FirstName" for="x_FirstName" class="col-sm-2 control-label ewLabel"><?php echo $t96_employees->FirstName->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t96_employees->FirstName->CellAttributes() ?>>
<span id="el_t96_employees_FirstName">
<input type="text" data-table="t96_employees" data-field="x_FirstName" name="x_FirstName" id="x_FirstName" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($t96_employees->FirstName->getPlaceHolder()) ?>" value="<?php echo $t96_employees->FirstName->EditValue ?>"<?php echo $t96_employees->FirstName->EditAttributes() ?>>
</span>
<?php echo $t96_employees->FirstName->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t96_employees->Title->Visible) { // Title ?>
	<div id="r_Title" class="form-group">
		<label id="elh_t96_employees_Title" for="x_Title" class="col-sm-2 control-label ewLabel"><?php echo $t96_employees->Title->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t96_employees->Title->CellAttributes() ?>>
<span id="el_t96_employees_Title">
<input type="text" data-table="t96_employees" data-field="x_Title" name="x_Title" id="x_Title" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($t96_employees->Title->getPlaceHolder()) ?>" value="<?php echo $t96_employees->Title->EditValue ?>"<?php echo $t96_employees->Title->EditAttributes() ?>>
</span>
<?php echo $t96_employees->Title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t96_employees->TitleOfCourtesy->Visible) { // TitleOfCourtesy ?>
	<div id="r_TitleOfCourtesy" class="form-group">
		<label id="elh_t96_employees_TitleOfCourtesy" for="x_TitleOfCourtesy" class="col-sm-2 control-label ewLabel"><?php echo $t96_employees->TitleOfCourtesy->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t96_employees->TitleOfCourtesy->CellAttributes() ?>>
<span id="el_t96_employees_TitleOfCourtesy">
<input type="text" data-table="t96_employees" data-field="x_TitleOfCourtesy" name="x_TitleOfCourtesy" id="x_TitleOfCourtesy" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t96_employees->TitleOfCourtesy->getPlaceHolder()) ?>" value="<?php echo $t96_employees->TitleOfCourtesy->EditValue ?>"<?php echo $t96_employees->TitleOfCourtesy->EditAttributes() ?>>
</span>
<?php echo $t96_employees->TitleOfCourtesy->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t96_employees->BirthDate->Visible) { // BirthDate ?>
	<div id="r_BirthDate" class="form-group">
		<label id="elh_t96_employees_BirthDate" for="x_BirthDate" class="col-sm-2 control-label ewLabel"><?php echo $t96_employees->BirthDate->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t96_employees->BirthDate->CellAttributes() ?>>
<span id="el_t96_employees_BirthDate">
<input type="text" data-table="t96_employees" data-field="x_BirthDate" name="x_BirthDate" id="x_BirthDate" placeholder="<?php echo ew_HtmlEncode($t96_employees->BirthDate->getPlaceHolder()) ?>" value="<?php echo $t96_employees->BirthDate->EditValue ?>"<?php echo $t96_employees->BirthDate->EditAttributes() ?>>
</span>
<?php echo $t96_employees->BirthDate->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t96_employees->HireDate->Visible) { // HireDate ?>
	<div id="r_HireDate" class="form-group">
		<label id="elh_t96_employees_HireDate" for="x_HireDate" class="col-sm-2 control-label ewLabel"><?php echo $t96_employees->HireDate->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t96_employees->HireDate->CellAttributes() ?>>
<span id="el_t96_employees_HireDate">
<input type="text" data-table="t96_employees" data-field="x_HireDate" name="x_HireDate" id="x_HireDate" placeholder="<?php echo ew_HtmlEncode($t96_employees->HireDate->getPlaceHolder()) ?>" value="<?php echo $t96_employees->HireDate->EditValue ?>"<?php echo $t96_employees->HireDate->EditAttributes() ?>>
</span>
<?php echo $t96_employees->HireDate->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t96_employees->Address->Visible) { // Address ?>
	<div id="r_Address" class="form-group">
		<label id="elh_t96_employees_Address" for="x_Address" class="col-sm-2 control-label ewLabel"><?php echo $t96_employees->Address->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t96_employees->Address->CellAttributes() ?>>
<span id="el_t96_employees_Address">
<input type="text" data-table="t96_employees" data-field="x_Address" name="x_Address" id="x_Address" size="30" maxlength="60" placeholder="<?php echo ew_HtmlEncode($t96_employees->Address->getPlaceHolder()) ?>" value="<?php echo $t96_employees->Address->EditValue ?>"<?php echo $t96_employees->Address->EditAttributes() ?>>
</span>
<?php echo $t96_employees->Address->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t96_employees->City->Visible) { // City ?>
	<div id="r_City" class="form-group">
		<label id="elh_t96_employees_City" for="x_City" class="col-sm-2 control-label ewLabel"><?php echo $t96_employees->City->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t96_employees->City->CellAttributes() ?>>
<span id="el_t96_employees_City">
<input type="text" data-table="t96_employees" data-field="x_City" name="x_City" id="x_City" size="30" maxlength="15" placeholder="<?php echo ew_HtmlEncode($t96_employees->City->getPlaceHolder()) ?>" value="<?php echo $t96_employees->City->EditValue ?>"<?php echo $t96_employees->City->EditAttributes() ?>>
</span>
<?php echo $t96_employees->City->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t96_employees->Region->Visible) { // Region ?>
	<div id="r_Region" class="form-group">
		<label id="elh_t96_employees_Region" for="x_Region" class="col-sm-2 control-label ewLabel"><?php echo $t96_employees->Region->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t96_employees->Region->CellAttributes() ?>>
<span id="el_t96_employees_Region">
<input type="text" data-table="t96_employees" data-field="x_Region" name="x_Region" id="x_Region" size="30" maxlength="15" placeholder="<?php echo ew_HtmlEncode($t96_employees->Region->getPlaceHolder()) ?>" value="<?php echo $t96_employees->Region->EditValue ?>"<?php echo $t96_employees->Region->EditAttributes() ?>>
</span>
<?php echo $t96_employees->Region->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t96_employees->PostalCode->Visible) { // PostalCode ?>
	<div id="r_PostalCode" class="form-group">
		<label id="elh_t96_employees_PostalCode" for="x_PostalCode" class="col-sm-2 control-label ewLabel"><?php echo $t96_employees->PostalCode->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t96_employees->PostalCode->CellAttributes() ?>>
<span id="el_t96_employees_PostalCode">
<input type="text" data-table="t96_employees" data-field="x_PostalCode" name="x_PostalCode" id="x_PostalCode" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($t96_employees->PostalCode->getPlaceHolder()) ?>" value="<?php echo $t96_employees->PostalCode->EditValue ?>"<?php echo $t96_employees->PostalCode->EditAttributes() ?>>
</span>
<?php echo $t96_employees->PostalCode->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t96_employees->Country->Visible) { // Country ?>
	<div id="r_Country" class="form-group">
		<label id="elh_t96_employees_Country" for="x_Country" class="col-sm-2 control-label ewLabel"><?php echo $t96_employees->Country->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t96_employees->Country->CellAttributes() ?>>
<span id="el_t96_employees_Country">
<input type="text" data-table="t96_employees" data-field="x_Country" name="x_Country" id="x_Country" size="30" maxlength="15" placeholder="<?php echo ew_HtmlEncode($t96_employees->Country->getPlaceHolder()) ?>" value="<?php echo $t96_employees->Country->EditValue ?>"<?php echo $t96_employees->Country->EditAttributes() ?>>
</span>
<?php echo $t96_employees->Country->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t96_employees->HomePhone->Visible) { // HomePhone ?>
	<div id="r_HomePhone" class="form-group">
		<label id="elh_t96_employees_HomePhone" for="x_HomePhone" class="col-sm-2 control-label ewLabel"><?php echo $t96_employees->HomePhone->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t96_employees->HomePhone->CellAttributes() ?>>
<span id="el_t96_employees_HomePhone">
<input type="text" data-table="t96_employees" data-field="x_HomePhone" name="x_HomePhone" id="x_HomePhone" size="30" maxlength="24" placeholder="<?php echo ew_HtmlEncode($t96_employees->HomePhone->getPlaceHolder()) ?>" value="<?php echo $t96_employees->HomePhone->EditValue ?>"<?php echo $t96_employees->HomePhone->EditAttributes() ?>>
</span>
<?php echo $t96_employees->HomePhone->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t96_employees->Extension->Visible) { // Extension ?>
	<div id="r_Extension" class="form-group">
		<label id="elh_t96_employees_Extension" for="x_Extension" class="col-sm-2 control-label ewLabel"><?php echo $t96_employees->Extension->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t96_employees->Extension->CellAttributes() ?>>
<span id="el_t96_employees_Extension">
<input type="text" data-table="t96_employees" data-field="x_Extension" name="x_Extension" id="x_Extension" size="30" maxlength="4" placeholder="<?php echo ew_HtmlEncode($t96_employees->Extension->getPlaceHolder()) ?>" value="<?php echo $t96_employees->Extension->EditValue ?>"<?php echo $t96_employees->Extension->EditAttributes() ?>>
</span>
<?php echo $t96_employees->Extension->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t96_employees->_Email->Visible) { // Email ?>
	<div id="r__Email" class="form-group">
		<label id="elh_t96_employees__Email" for="x__Email" class="col-sm-2 control-label ewLabel"><?php echo $t96_employees->_Email->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t96_employees->_Email->CellAttributes() ?>>
<span id="el_t96_employees__Email">
<input type="text" data-table="t96_employees" data-field="x__Email" name="x__Email" id="x__Email" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($t96_employees->_Email->getPlaceHolder()) ?>" value="<?php echo $t96_employees->_Email->EditValue ?>"<?php echo $t96_employees->_Email->EditAttributes() ?>>
</span>
<?php echo $t96_employees->_Email->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t96_employees->Photo->Visible) { // Photo ?>
	<div id="r_Photo" class="form-group">
		<label id="elh_t96_employees_Photo" for="x_Photo" class="col-sm-2 control-label ewLabel"><?php echo $t96_employees->Photo->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t96_employees->Photo->CellAttributes() ?>>
<span id="el_t96_employees_Photo">
<input type="text" data-table="t96_employees" data-field="x_Photo" name="x_Photo" id="x_Photo" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($t96_employees->Photo->getPlaceHolder()) ?>" value="<?php echo $t96_employees->Photo->EditValue ?>"<?php echo $t96_employees->Photo->EditAttributes() ?>>
</span>
<?php echo $t96_employees->Photo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t96_employees->Notes->Visible) { // Notes ?>
	<div id="r_Notes" class="form-group">
		<label id="elh_t96_employees_Notes" for="x_Notes" class="col-sm-2 control-label ewLabel"><?php echo $t96_employees->Notes->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t96_employees->Notes->CellAttributes() ?>>
<span id="el_t96_employees_Notes">
<textarea data-table="t96_employees" data-field="x_Notes" name="x_Notes" id="x_Notes" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($t96_employees->Notes->getPlaceHolder()) ?>"<?php echo $t96_employees->Notes->EditAttributes() ?>><?php echo $t96_employees->Notes->EditValue ?></textarea>
</span>
<?php echo $t96_employees->Notes->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t96_employees->ReportsTo->Visible) { // ReportsTo ?>
	<div id="r_ReportsTo" class="form-group">
		<label id="elh_t96_employees_ReportsTo" for="x_ReportsTo" class="col-sm-2 control-label ewLabel"><?php echo $t96_employees->ReportsTo->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t96_employees->ReportsTo->CellAttributes() ?>>
<span id="el_t96_employees_ReportsTo">
<input type="text" data-table="t96_employees" data-field="x_ReportsTo" name="x_ReportsTo" id="x_ReportsTo" size="30" placeholder="<?php echo ew_HtmlEncode($t96_employees->ReportsTo->getPlaceHolder()) ?>" value="<?php echo $t96_employees->ReportsTo->EditValue ?>"<?php echo $t96_employees->ReportsTo->EditAttributes() ?>>
</span>
<?php echo $t96_employees->ReportsTo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t96_employees->Password->Visible) { // Password ?>
	<div id="r_Password" class="form-group">
		<label id="elh_t96_employees_Password" for="x_Password" class="col-sm-2 control-label ewLabel"><?php echo $t96_employees->Password->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t96_employees->Password->CellAttributes() ?>>
<span id="el_t96_employees_Password">
<div class="input-group" id="ig_Password">
<input type="text" data-password-strength="pst_Password" data-password-generated="pgt_Password" data-table="t96_employees" data-field="x_Password" name="x_Password" id="x_Password" value="<?php echo $t96_employees->Password->EditValue ?>" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t96_employees->Password->getPlaceHolder()) ?>"<?php echo $t96_employees->Password->EditAttributes() ?>>
<span class="input-group-btn">
	<button type="button" class="btn btn-default ewPasswordGenerator" title="<?php echo ew_HtmlTitle($Language->Phrase("GeneratePassword")) ?>" data-password-field="x_Password" data-password-confirm="c_Password" data-password-strength="pst_Password" data-password-generated="pgt_Password"><?php echo $Language->Phrase("GeneratePassword") ?></button>
</span>
</div>
<span class="help-block" id="pgt_Password" style="display: none;"></span>
<div class="progress ewPasswordStrengthBar" id="pst_Password" style="display: none;">
	<div class="progress-bar" role="progressbar"></div>
</div>
</span>
<?php echo $t96_employees->Password->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t96_employees->UserLevel->Visible) { // UserLevel ?>
	<div id="r_UserLevel" class="form-group">
		<label id="elh_t96_employees_UserLevel" for="x_UserLevel" class="col-sm-2 control-label ewLabel"><?php echo $t96_employees->UserLevel->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t96_employees->UserLevel->CellAttributes() ?>>
<?php if (!$Security->IsAdmin() && $Security->IsLoggedIn()) { // Non system admin ?>
<span id="el_t96_employees_UserLevel">
<p class="form-control-static"><?php echo $t96_employees->UserLevel->EditValue ?></p>
</span>
<?php } else { ?>
<span id="el_t96_employees_UserLevel">
<select data-table="t96_employees" data-field="x_UserLevel" data-value-separator="<?php echo $t96_employees->UserLevel->DisplayValueSeparatorAttribute() ?>" id="x_UserLevel" name="x_UserLevel"<?php echo $t96_employees->UserLevel->EditAttributes() ?>>
<?php echo $t96_employees->UserLevel->SelectOptionListHtml("x_UserLevel") ?>
</select>
<input type="hidden" name="s_x_UserLevel" id="s_x_UserLevel" value="<?php echo $t96_employees->UserLevel->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php echo $t96_employees->UserLevel->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t96_employees->Username->Visible) { // Username ?>
	<div id="r_Username" class="form-group">
		<label id="elh_t96_employees_Username" for="x_Username" class="col-sm-2 control-label ewLabel"><?php echo $t96_employees->Username->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t96_employees->Username->CellAttributes() ?>>
<span id="el_t96_employees_Username">
<input type="text" data-table="t96_employees" data-field="x_Username" name="x_Username" id="x_Username" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($t96_employees->Username->getPlaceHolder()) ?>" value="<?php echo $t96_employees->Username->EditValue ?>"<?php echo $t96_employees->Username->EditAttributes() ?>>
</span>
<?php echo $t96_employees->Username->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t96_employees->Activated->Visible) { // Activated ?>
	<div id="r_Activated" class="form-group">
		<label id="elh_t96_employees_Activated" class="col-sm-2 control-label ewLabel"><?php echo $t96_employees->Activated->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t96_employees->Activated->CellAttributes() ?>>
<span id="el_t96_employees_Activated">
<div id="tp_x_Activated" class="ewTemplate"><input type="radio" data-table="t96_employees" data-field="x_Activated" data-value-separator="<?php echo $t96_employees->Activated->DisplayValueSeparatorAttribute() ?>" name="x_Activated" id="x_Activated" value="{value}"<?php echo $t96_employees->Activated->EditAttributes() ?>></div>
<div id="dsl_x_Activated" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $t96_employees->Activated->RadioButtonListHtml(FALSE, "x_Activated") ?>
</div></div>
</span>
<?php echo $t96_employees->Activated->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t96_employees->Profile->Visible) { // Profile ?>
	<div id="r_Profile" class="form-group">
		<label id="elh_t96_employees_Profile" for="x_Profile" class="col-sm-2 control-label ewLabel"><?php echo $t96_employees->Profile->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t96_employees->Profile->CellAttributes() ?>>
<span id="el_t96_employees_Profile">
<textarea data-table="t96_employees" data-field="x_Profile" name="x_Profile" id="x_Profile" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($t96_employees->Profile->getPlaceHolder()) ?>"<?php echo $t96_employees->Profile->EditAttributes() ?>><?php echo $t96_employees->Profile->EditValue ?></textarea>
</span>
<?php echo $t96_employees->Profile->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$t96_employees_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t96_employees_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ft96_employeesadd.Init();
</script>
<?php
$t96_employees_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t96_employees_add->Page_Terminate();
?>
