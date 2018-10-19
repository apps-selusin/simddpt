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

$t96_employees_list = NULL; // Initialize page object first

class ct96_employees_list extends ct96_employees {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{78A0660C-C398-4292-A50E-2A3C7D765239}";

	// Table name
	var $TableName = 't96_employees';

	// Page object name
	var $PageObjName = 't96_employees_list';

	// Grid form hidden field names
	var $FormName = 'ft96_employeeslist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "t96_employeesadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "t96_employeesdelete.php";
		$this->MultiUpdateUrl = "t96_employeesupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

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

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";

		// Filter options
		$this->FilterOptions = new cListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption ft96_employeeslistsrch";

		// List actions
		$this->ListActions = new cListActions();
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
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			$this->Page_Terminate(ew_GetUrl("index.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
			if (strval($Security->CurrentUserID()) == "") {
				$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
				$this->Page_Terminate();
			}
		}

		// Get export parameters
		$custom = "";
		if (@$_GET["export"] <> "") {
			$this->Export = $_GET["export"];
			$custom = @$_GET["custom"];
		} elseif (@$_POST["export"] <> "") {
			$this->Export = $_POST["export"];
			$custom = @$_POST["custom"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$this->Export = $_POST["exporttype"];
			$custom = @$_POST["custom"];
		} else {
			$this->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExportFile = $this->TableVar; // Get export file, used in header

		// Get custom export parameters
		if ($this->Export <> "" && $custom <> "") {
			$this->CustomExport = $this->Export;
			$this->Export = "print";
		}
		$gsCustomExport = $this->CustomExport;
		$gsExport = $this->Export; // Get export parameter, used in header

		// Update Export URLs
		if (defined("EW_USE_PHPEXCEL"))
			$this->ExportExcelCustom = FALSE;
		if ($this->ExportExcelCustom)
			$this->ExportExcelUrl .= "&amp;custom=1";
		if (defined("EW_USE_PHPWORD"))
			$this->ExportWordCustom = FALSE;
		if ($this->ExportWordCustom)
			$this->ExportWordUrl .= "&amp;custom=1";
		if ($this->ExportPdfCustom)
			$this->ExportPdfUrl .= "&amp;custom=1";
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();

		// Setup export options
		$this->SetupExportOptions();
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

		// Setup other options
		$this->SetupOtherOptions();

		// Set up custom action (compatible with old version)
		foreach ($this->CustomActions as $name => $action)
			$this->ListActions->Add($name, $action);

		// Show checkbox column if multiple action
		foreach ($this->ListActions->Items as $listaction) {
			if ($listaction->Select == EW_ACTION_MULTIPLE && $listaction->Allow) {
				$this->ListOptions->Items["checkbox"]->Visible = TRUE;
				break;
			}
		}
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

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $OtherOptions = array(); // Other options
	var $FilterOptions; // Filter options
	var $ListActions; // List actions
	var $SelectedCount = 0;
	var $SelectedIndex = 0;
	var $DisplayRecs = 20;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $DefaultSearchWhere = ""; // Default search WHERE clause
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $MultiColumnClass;
	var $MultiColumnEditClass = "col-sm-12";
	var $MultiColumnCnt = 12;
	var $MultiColumnEditCnt = 12;
	var $GridCnt = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;	
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $DetailPages;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process list action first
			if ($this->ProcessListAction()) // Ajax request
				$this->Page_Terminate();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide options
			if ($this->Export <> "" || $this->CurrentAction <> "") {
				$this->ExportOptions->HideAllOptions();
				$this->FilterOptions->HideAllOptions();
			}

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Get default search criteria
			ew_AddFilter($this->DefaultSearchWhere, $this->BasicSearchWhere(TRUE));
			ew_AddFilter($this->DefaultSearchWhere, $this->AdvancedSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Get and validate search values for advanced search
			$this->LoadSearchValues(); // Get search values

			// Process filter list
			$this->ProcessFilterList();
			if (!$this->ValidateSearch())
				$this->setFailureMessage($gsSearchError);

			// Restore search parms from Session if not searching / reset / export
			if (($this->Export <> "" || $this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall") && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();

			// Get search criteria for advanced search
			if ($gsSearchError == "")
				$sSrchAdvanced = $this->AdvancedSearchWhere();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

			// Load basic search from default
			$this->BasicSearch->LoadDefault();
			if ($this->BasicSearch->Keyword != "")
				$sSrchBasic = $this->BasicSearchWhere();

			// Load advanced search from default
			if ($this->LoadAdvancedSearchDefault()) {
				$sSrchAdvanced = $this->AdvancedSearchWhere();
			}
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search" && !$this->RestoreSearch) {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} else {
			$this->SearchWhere = $this->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter in session
		$this->setSessionWhere($sFilter);
		$this->CurrentFilter = "";

		// Export data only
		if ($this->CustomExport == "" && in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}

		// Load record count first
		if (!$this->IsAddOrEdit()) {
			$bSelectLimit = $this->UseSelectLimit;
			if ($bSelectLimit) {
				$this->TotalRecs = $this->SelectRecordCount();
			} else {
				if ($this->Recordset = $this->LoadRecordset())
					$this->TotalRecs = $this->Recordset->RecordCount();
			}
		}

		// Search options
		$this->SetupSearchOptions();
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 1) {
			$this->EmployeeID->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->EmployeeID->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Load server side filters
		if (EW_SEARCH_FILTER_OPTION == "Server") {
			$sSavedFilterList = isset($UserProfile) ? $UserProfile->GetSearchFilters(CurrentUserName(), "ft96_employeeslistsrch") : "";
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->EmployeeID->AdvancedSearch->ToJSON(), ","); // Field EmployeeID
		$sFilterList = ew_Concat($sFilterList, $this->LastName->AdvancedSearch->ToJSON(), ","); // Field LastName
		$sFilterList = ew_Concat($sFilterList, $this->FirstName->AdvancedSearch->ToJSON(), ","); // Field FirstName
		$sFilterList = ew_Concat($sFilterList, $this->Title->AdvancedSearch->ToJSON(), ","); // Field Title
		$sFilterList = ew_Concat($sFilterList, $this->TitleOfCourtesy->AdvancedSearch->ToJSON(), ","); // Field TitleOfCourtesy
		$sFilterList = ew_Concat($sFilterList, $this->BirthDate->AdvancedSearch->ToJSON(), ","); // Field BirthDate
		$sFilterList = ew_Concat($sFilterList, $this->HireDate->AdvancedSearch->ToJSON(), ","); // Field HireDate
		$sFilterList = ew_Concat($sFilterList, $this->Address->AdvancedSearch->ToJSON(), ","); // Field Address
		$sFilterList = ew_Concat($sFilterList, $this->City->AdvancedSearch->ToJSON(), ","); // Field City
		$sFilterList = ew_Concat($sFilterList, $this->Region->AdvancedSearch->ToJSON(), ","); // Field Region
		$sFilterList = ew_Concat($sFilterList, $this->PostalCode->AdvancedSearch->ToJSON(), ","); // Field PostalCode
		$sFilterList = ew_Concat($sFilterList, $this->Country->AdvancedSearch->ToJSON(), ","); // Field Country
		$sFilterList = ew_Concat($sFilterList, $this->HomePhone->AdvancedSearch->ToJSON(), ","); // Field HomePhone
		$sFilterList = ew_Concat($sFilterList, $this->Extension->AdvancedSearch->ToJSON(), ","); // Field Extension
		$sFilterList = ew_Concat($sFilterList, $this->_Email->AdvancedSearch->ToJSON(), ","); // Field Email
		$sFilterList = ew_Concat($sFilterList, $this->Photo->AdvancedSearch->ToJSON(), ","); // Field Photo
		$sFilterList = ew_Concat($sFilterList, $this->Notes->AdvancedSearch->ToJSON(), ","); // Field Notes
		$sFilterList = ew_Concat($sFilterList, $this->ReportsTo->AdvancedSearch->ToJSON(), ","); // Field ReportsTo
		$sFilterList = ew_Concat($sFilterList, $this->Password->AdvancedSearch->ToJSON(), ","); // Field Password
		$sFilterList = ew_Concat($sFilterList, $this->UserLevel->AdvancedSearch->ToJSON(), ","); // Field UserLevel
		$sFilterList = ew_Concat($sFilterList, $this->Username->AdvancedSearch->ToJSON(), ","); // Field Username
		$sFilterList = ew_Concat($sFilterList, $this->Activated->AdvancedSearch->ToJSON(), ","); // Field Activated
		$sFilterList = ew_Concat($sFilterList, $this->Profile->AdvancedSearch->ToJSON(), ","); // Field Profile
		if ($this->BasicSearch->Keyword <> "") {
			$sWrk = "\"" . EW_TABLE_BASIC_SEARCH . "\":\"" . ew_JsEncode2($this->BasicSearch->Keyword) . "\",\"" . EW_TABLE_BASIC_SEARCH_TYPE . "\":\"" . ew_JsEncode2($this->BasicSearch->Type) . "\"";
			$sFilterList = ew_Concat($sFilterList, $sWrk, ",");
		}
		$sFilterList = preg_replace('/,$/', "", $sFilterList);

		// Return filter list in json
		if ($sFilterList <> "")
			$sFilterList = "\"data\":{" . $sFilterList . "}";
		if ($sSavedFilterList <> "") {
			if ($sFilterList <> "")
				$sFilterList .= ",";
			$sFilterList .= "\"filters\":" . $sSavedFilterList;
		}
		return ($sFilterList <> "") ? "{" . $sFilterList . "}" : "null";
	}

	// Process filter list
	function ProcessFilterList() {
		global $UserProfile;
		if (@$_POST["ajax"] == "savefilters") { // Save filter request (Ajax)
			$filters = ew_StripSlashes(@$_POST["filters"]);
			$UserProfile->SetSearchFilters(CurrentUserName(), "ft96_employeeslistsrch", $filters);

			// Clean output buffer
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			echo ew_ArrayToJson(array(array("success" => TRUE))); // Success
			$this->Page_Terminate();
			exit();
		} elseif (@$_POST["cmd"] == "resetfilter") {
			$this->RestoreFilterList();
		}
	}

	// Restore list of filters
	function RestoreFilterList() {

		// Return if not reset filter
		if (@$_POST["cmd"] <> "resetfilter")
			return FALSE;
		$filter = json_decode(ew_StripSlashes(@$_POST["filter"]), TRUE);
		$this->Command = "search";

		// Field EmployeeID
		$this->EmployeeID->AdvancedSearch->SearchValue = @$filter["x_EmployeeID"];
		$this->EmployeeID->AdvancedSearch->SearchOperator = @$filter["z_EmployeeID"];
		$this->EmployeeID->AdvancedSearch->SearchCondition = @$filter["v_EmployeeID"];
		$this->EmployeeID->AdvancedSearch->SearchValue2 = @$filter["y_EmployeeID"];
		$this->EmployeeID->AdvancedSearch->SearchOperator2 = @$filter["w_EmployeeID"];
		$this->EmployeeID->AdvancedSearch->Save();

		// Field LastName
		$this->LastName->AdvancedSearch->SearchValue = @$filter["x_LastName"];
		$this->LastName->AdvancedSearch->SearchOperator = @$filter["z_LastName"];
		$this->LastName->AdvancedSearch->SearchCondition = @$filter["v_LastName"];
		$this->LastName->AdvancedSearch->SearchValue2 = @$filter["y_LastName"];
		$this->LastName->AdvancedSearch->SearchOperator2 = @$filter["w_LastName"];
		$this->LastName->AdvancedSearch->Save();

		// Field FirstName
		$this->FirstName->AdvancedSearch->SearchValue = @$filter["x_FirstName"];
		$this->FirstName->AdvancedSearch->SearchOperator = @$filter["z_FirstName"];
		$this->FirstName->AdvancedSearch->SearchCondition = @$filter["v_FirstName"];
		$this->FirstName->AdvancedSearch->SearchValue2 = @$filter["y_FirstName"];
		$this->FirstName->AdvancedSearch->SearchOperator2 = @$filter["w_FirstName"];
		$this->FirstName->AdvancedSearch->Save();

		// Field Title
		$this->Title->AdvancedSearch->SearchValue = @$filter["x_Title"];
		$this->Title->AdvancedSearch->SearchOperator = @$filter["z_Title"];
		$this->Title->AdvancedSearch->SearchCondition = @$filter["v_Title"];
		$this->Title->AdvancedSearch->SearchValue2 = @$filter["y_Title"];
		$this->Title->AdvancedSearch->SearchOperator2 = @$filter["w_Title"];
		$this->Title->AdvancedSearch->Save();

		// Field TitleOfCourtesy
		$this->TitleOfCourtesy->AdvancedSearch->SearchValue = @$filter["x_TitleOfCourtesy"];
		$this->TitleOfCourtesy->AdvancedSearch->SearchOperator = @$filter["z_TitleOfCourtesy"];
		$this->TitleOfCourtesy->AdvancedSearch->SearchCondition = @$filter["v_TitleOfCourtesy"];
		$this->TitleOfCourtesy->AdvancedSearch->SearchValue2 = @$filter["y_TitleOfCourtesy"];
		$this->TitleOfCourtesy->AdvancedSearch->SearchOperator2 = @$filter["w_TitleOfCourtesy"];
		$this->TitleOfCourtesy->AdvancedSearch->Save();

		// Field BirthDate
		$this->BirthDate->AdvancedSearch->SearchValue = @$filter["x_BirthDate"];
		$this->BirthDate->AdvancedSearch->SearchOperator = @$filter["z_BirthDate"];
		$this->BirthDate->AdvancedSearch->SearchCondition = @$filter["v_BirthDate"];
		$this->BirthDate->AdvancedSearch->SearchValue2 = @$filter["y_BirthDate"];
		$this->BirthDate->AdvancedSearch->SearchOperator2 = @$filter["w_BirthDate"];
		$this->BirthDate->AdvancedSearch->Save();

		// Field HireDate
		$this->HireDate->AdvancedSearch->SearchValue = @$filter["x_HireDate"];
		$this->HireDate->AdvancedSearch->SearchOperator = @$filter["z_HireDate"];
		$this->HireDate->AdvancedSearch->SearchCondition = @$filter["v_HireDate"];
		$this->HireDate->AdvancedSearch->SearchValue2 = @$filter["y_HireDate"];
		$this->HireDate->AdvancedSearch->SearchOperator2 = @$filter["w_HireDate"];
		$this->HireDate->AdvancedSearch->Save();

		// Field Address
		$this->Address->AdvancedSearch->SearchValue = @$filter["x_Address"];
		$this->Address->AdvancedSearch->SearchOperator = @$filter["z_Address"];
		$this->Address->AdvancedSearch->SearchCondition = @$filter["v_Address"];
		$this->Address->AdvancedSearch->SearchValue2 = @$filter["y_Address"];
		$this->Address->AdvancedSearch->SearchOperator2 = @$filter["w_Address"];
		$this->Address->AdvancedSearch->Save();

		// Field City
		$this->City->AdvancedSearch->SearchValue = @$filter["x_City"];
		$this->City->AdvancedSearch->SearchOperator = @$filter["z_City"];
		$this->City->AdvancedSearch->SearchCondition = @$filter["v_City"];
		$this->City->AdvancedSearch->SearchValue2 = @$filter["y_City"];
		$this->City->AdvancedSearch->SearchOperator2 = @$filter["w_City"];
		$this->City->AdvancedSearch->Save();

		// Field Region
		$this->Region->AdvancedSearch->SearchValue = @$filter["x_Region"];
		$this->Region->AdvancedSearch->SearchOperator = @$filter["z_Region"];
		$this->Region->AdvancedSearch->SearchCondition = @$filter["v_Region"];
		$this->Region->AdvancedSearch->SearchValue2 = @$filter["y_Region"];
		$this->Region->AdvancedSearch->SearchOperator2 = @$filter["w_Region"];
		$this->Region->AdvancedSearch->Save();

		// Field PostalCode
		$this->PostalCode->AdvancedSearch->SearchValue = @$filter["x_PostalCode"];
		$this->PostalCode->AdvancedSearch->SearchOperator = @$filter["z_PostalCode"];
		$this->PostalCode->AdvancedSearch->SearchCondition = @$filter["v_PostalCode"];
		$this->PostalCode->AdvancedSearch->SearchValue2 = @$filter["y_PostalCode"];
		$this->PostalCode->AdvancedSearch->SearchOperator2 = @$filter["w_PostalCode"];
		$this->PostalCode->AdvancedSearch->Save();

		// Field Country
		$this->Country->AdvancedSearch->SearchValue = @$filter["x_Country"];
		$this->Country->AdvancedSearch->SearchOperator = @$filter["z_Country"];
		$this->Country->AdvancedSearch->SearchCondition = @$filter["v_Country"];
		$this->Country->AdvancedSearch->SearchValue2 = @$filter["y_Country"];
		$this->Country->AdvancedSearch->SearchOperator2 = @$filter["w_Country"];
		$this->Country->AdvancedSearch->Save();

		// Field HomePhone
		$this->HomePhone->AdvancedSearch->SearchValue = @$filter["x_HomePhone"];
		$this->HomePhone->AdvancedSearch->SearchOperator = @$filter["z_HomePhone"];
		$this->HomePhone->AdvancedSearch->SearchCondition = @$filter["v_HomePhone"];
		$this->HomePhone->AdvancedSearch->SearchValue2 = @$filter["y_HomePhone"];
		$this->HomePhone->AdvancedSearch->SearchOperator2 = @$filter["w_HomePhone"];
		$this->HomePhone->AdvancedSearch->Save();

		// Field Extension
		$this->Extension->AdvancedSearch->SearchValue = @$filter["x_Extension"];
		$this->Extension->AdvancedSearch->SearchOperator = @$filter["z_Extension"];
		$this->Extension->AdvancedSearch->SearchCondition = @$filter["v_Extension"];
		$this->Extension->AdvancedSearch->SearchValue2 = @$filter["y_Extension"];
		$this->Extension->AdvancedSearch->SearchOperator2 = @$filter["w_Extension"];
		$this->Extension->AdvancedSearch->Save();

		// Field Email
		$this->_Email->AdvancedSearch->SearchValue = @$filter["x__Email"];
		$this->_Email->AdvancedSearch->SearchOperator = @$filter["z__Email"];
		$this->_Email->AdvancedSearch->SearchCondition = @$filter["v__Email"];
		$this->_Email->AdvancedSearch->SearchValue2 = @$filter["y__Email"];
		$this->_Email->AdvancedSearch->SearchOperator2 = @$filter["w__Email"];
		$this->_Email->AdvancedSearch->Save();

		// Field Photo
		$this->Photo->AdvancedSearch->SearchValue = @$filter["x_Photo"];
		$this->Photo->AdvancedSearch->SearchOperator = @$filter["z_Photo"];
		$this->Photo->AdvancedSearch->SearchCondition = @$filter["v_Photo"];
		$this->Photo->AdvancedSearch->SearchValue2 = @$filter["y_Photo"];
		$this->Photo->AdvancedSearch->SearchOperator2 = @$filter["w_Photo"];
		$this->Photo->AdvancedSearch->Save();

		// Field Notes
		$this->Notes->AdvancedSearch->SearchValue = @$filter["x_Notes"];
		$this->Notes->AdvancedSearch->SearchOperator = @$filter["z_Notes"];
		$this->Notes->AdvancedSearch->SearchCondition = @$filter["v_Notes"];
		$this->Notes->AdvancedSearch->SearchValue2 = @$filter["y_Notes"];
		$this->Notes->AdvancedSearch->SearchOperator2 = @$filter["w_Notes"];
		$this->Notes->AdvancedSearch->Save();

		// Field ReportsTo
		$this->ReportsTo->AdvancedSearch->SearchValue = @$filter["x_ReportsTo"];
		$this->ReportsTo->AdvancedSearch->SearchOperator = @$filter["z_ReportsTo"];
		$this->ReportsTo->AdvancedSearch->SearchCondition = @$filter["v_ReportsTo"];
		$this->ReportsTo->AdvancedSearch->SearchValue2 = @$filter["y_ReportsTo"];
		$this->ReportsTo->AdvancedSearch->SearchOperator2 = @$filter["w_ReportsTo"];
		$this->ReportsTo->AdvancedSearch->Save();

		// Field Password
		$this->Password->AdvancedSearch->SearchValue = @$filter["x_Password"];
		$this->Password->AdvancedSearch->SearchOperator = @$filter["z_Password"];
		$this->Password->AdvancedSearch->SearchCondition = @$filter["v_Password"];
		$this->Password->AdvancedSearch->SearchValue2 = @$filter["y_Password"];
		$this->Password->AdvancedSearch->SearchOperator2 = @$filter["w_Password"];
		$this->Password->AdvancedSearch->Save();

		// Field UserLevel
		$this->UserLevel->AdvancedSearch->SearchValue = @$filter["x_UserLevel"];
		$this->UserLevel->AdvancedSearch->SearchOperator = @$filter["z_UserLevel"];
		$this->UserLevel->AdvancedSearch->SearchCondition = @$filter["v_UserLevel"];
		$this->UserLevel->AdvancedSearch->SearchValue2 = @$filter["y_UserLevel"];
		$this->UserLevel->AdvancedSearch->SearchOperator2 = @$filter["w_UserLevel"];
		$this->UserLevel->AdvancedSearch->Save();

		// Field Username
		$this->Username->AdvancedSearch->SearchValue = @$filter["x_Username"];
		$this->Username->AdvancedSearch->SearchOperator = @$filter["z_Username"];
		$this->Username->AdvancedSearch->SearchCondition = @$filter["v_Username"];
		$this->Username->AdvancedSearch->SearchValue2 = @$filter["y_Username"];
		$this->Username->AdvancedSearch->SearchOperator2 = @$filter["w_Username"];
		$this->Username->AdvancedSearch->Save();

		// Field Activated
		$this->Activated->AdvancedSearch->SearchValue = @$filter["x_Activated"];
		$this->Activated->AdvancedSearch->SearchOperator = @$filter["z_Activated"];
		$this->Activated->AdvancedSearch->SearchCondition = @$filter["v_Activated"];
		$this->Activated->AdvancedSearch->SearchValue2 = @$filter["y_Activated"];
		$this->Activated->AdvancedSearch->SearchOperator2 = @$filter["w_Activated"];
		$this->Activated->AdvancedSearch->Save();

		// Field Profile
		$this->Profile->AdvancedSearch->SearchValue = @$filter["x_Profile"];
		$this->Profile->AdvancedSearch->SearchOperator = @$filter["z_Profile"];
		$this->Profile->AdvancedSearch->SearchCondition = @$filter["v_Profile"];
		$this->Profile->AdvancedSearch->SearchValue2 = @$filter["y_Profile"];
		$this->Profile->AdvancedSearch->SearchOperator2 = @$filter["w_Profile"];
		$this->Profile->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere($Default = FALSE) {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->EmployeeID, $Default, FALSE); // EmployeeID
		$this->BuildSearchSql($sWhere, $this->LastName, $Default, FALSE); // LastName
		$this->BuildSearchSql($sWhere, $this->FirstName, $Default, FALSE); // FirstName
		$this->BuildSearchSql($sWhere, $this->Title, $Default, FALSE); // Title
		$this->BuildSearchSql($sWhere, $this->TitleOfCourtesy, $Default, FALSE); // TitleOfCourtesy
		$this->BuildSearchSql($sWhere, $this->BirthDate, $Default, FALSE); // BirthDate
		$this->BuildSearchSql($sWhere, $this->HireDate, $Default, FALSE); // HireDate
		$this->BuildSearchSql($sWhere, $this->Address, $Default, FALSE); // Address
		$this->BuildSearchSql($sWhere, $this->City, $Default, FALSE); // City
		$this->BuildSearchSql($sWhere, $this->Region, $Default, FALSE); // Region
		$this->BuildSearchSql($sWhere, $this->PostalCode, $Default, FALSE); // PostalCode
		$this->BuildSearchSql($sWhere, $this->Country, $Default, FALSE); // Country
		$this->BuildSearchSql($sWhere, $this->HomePhone, $Default, FALSE); // HomePhone
		$this->BuildSearchSql($sWhere, $this->Extension, $Default, FALSE); // Extension
		$this->BuildSearchSql($sWhere, $this->_Email, $Default, FALSE); // Email
		$this->BuildSearchSql($sWhere, $this->Photo, $Default, FALSE); // Photo
		$this->BuildSearchSql($sWhere, $this->Notes, $Default, FALSE); // Notes
		$this->BuildSearchSql($sWhere, $this->ReportsTo, $Default, FALSE); // ReportsTo
		$this->BuildSearchSql($sWhere, $this->Password, $Default, FALSE); // Password
		$this->BuildSearchSql($sWhere, $this->UserLevel, $Default, FALSE); // UserLevel
		$this->BuildSearchSql($sWhere, $this->Username, $Default, FALSE); // Username
		$this->BuildSearchSql($sWhere, $this->Activated, $Default, FALSE); // Activated
		$this->BuildSearchSql($sWhere, $this->Profile, $Default, FALSE); // Profile

		// Set up search parm
		if (!$Default && $sWhere <> "") {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->EmployeeID->AdvancedSearch->Save(); // EmployeeID
			$this->LastName->AdvancedSearch->Save(); // LastName
			$this->FirstName->AdvancedSearch->Save(); // FirstName
			$this->Title->AdvancedSearch->Save(); // Title
			$this->TitleOfCourtesy->AdvancedSearch->Save(); // TitleOfCourtesy
			$this->BirthDate->AdvancedSearch->Save(); // BirthDate
			$this->HireDate->AdvancedSearch->Save(); // HireDate
			$this->Address->AdvancedSearch->Save(); // Address
			$this->City->AdvancedSearch->Save(); // City
			$this->Region->AdvancedSearch->Save(); // Region
			$this->PostalCode->AdvancedSearch->Save(); // PostalCode
			$this->Country->AdvancedSearch->Save(); // Country
			$this->HomePhone->AdvancedSearch->Save(); // HomePhone
			$this->Extension->AdvancedSearch->Save(); // Extension
			$this->_Email->AdvancedSearch->Save(); // Email
			$this->Photo->AdvancedSearch->Save(); // Photo
			$this->Notes->AdvancedSearch->Save(); // Notes
			$this->ReportsTo->AdvancedSearch->Save(); // ReportsTo
			$this->Password->AdvancedSearch->Save(); // Password
			$this->UserLevel->AdvancedSearch->Save(); // UserLevel
			$this->Username->AdvancedSearch->Save(); // Username
			$this->Activated->AdvancedSearch->Save(); // Activated
			$this->Profile->AdvancedSearch->Save(); // Profile
		}
		return $sWhere;
	}

	// Build search SQL
	function BuildSearchSql(&$Where, &$Fld, $Default, $MultiValue) {
		$FldParm = substr($Fld->FldVar, 2);
		$FldVal = ($Default) ? $Fld->AdvancedSearch->SearchValueDefault : $Fld->AdvancedSearch->SearchValue; // @$_GET["x_$FldParm"]
		$FldOpr = ($Default) ? $Fld->AdvancedSearch->SearchOperatorDefault : $Fld->AdvancedSearch->SearchOperator; // @$_GET["z_$FldParm"]
		$FldCond = ($Default) ? $Fld->AdvancedSearch->SearchConditionDefault : $Fld->AdvancedSearch->SearchCondition; // @$_GET["v_$FldParm"]
		$FldVal2 = ($Default) ? $Fld->AdvancedSearch->SearchValue2Default : $Fld->AdvancedSearch->SearchValue2; // @$_GET["y_$FldParm"]
		$FldOpr2 = ($Default) ? $Fld->AdvancedSearch->SearchOperator2Default : $Fld->AdvancedSearch->SearchOperator2; // @$_GET["w_$FldParm"]
		$sWrk = "";

		//$FldVal = ew_StripSlashes($FldVal);
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);

		//$FldVal2 = ew_StripSlashes($FldVal2);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$FldOpr = strtoupper(trim($FldOpr));
		if ($FldOpr == "") $FldOpr = "=";
		$FldOpr2 = strtoupper(trim($FldOpr2));
		if ($FldOpr2 == "") $FldOpr2 = "=";
		if (EW_SEARCH_MULTI_VALUE_OPTION == 1)
			$MultiValue = FALSE;
		if ($MultiValue) {
			$sWrk1 = ($FldVal <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr, $FldVal, $this->DBID) : ""; // Field value 1
			$sWrk2 = ($FldVal2 <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr2, $FldVal2, $this->DBID) : ""; // Field value 2
			$sWrk = $sWrk1; // Build final SQL
			if ($sWrk2 <> "")
				$sWrk = ($sWrk <> "") ? "($sWrk) $FldCond ($sWrk2)" : $sWrk2;
		} else {
			$FldVal = $this->ConvertSearchValue($Fld, $FldVal);
			$FldVal2 = $this->ConvertSearchValue($Fld, $FldVal2);
			$sWrk = ew_GetSearchSql($Fld, $FldVal, $FldOpr, $FldCond, $FldVal2, $FldOpr2, $this->DBID);
		}
		ew_AddFilter($Where, $sWrk);
	}

	// Convert search value
	function ConvertSearchValue(&$Fld, $FldVal) {
		if ($FldVal == EW_NULL_VALUE || $FldVal == EW_NOT_NULL_VALUE)
			return $FldVal;
		$Value = $FldVal;
		if ($Fld->FldDataType == EW_DATATYPE_BOOLEAN) {
			if ($FldVal <> "") $Value = ($FldVal == "1" || strtolower(strval($FldVal)) == "y" || strtolower(strval($FldVal)) == "t") ? $Fld->TrueValue : $Fld->FalseValue;
		} elseif ($Fld->FldDataType == EW_DATATYPE_DATE || $Fld->FldDataType == EW_DATATYPE_TIME) {
			if ($FldVal <> "") $Value = ew_UnFormatDateTime($FldVal, $Fld->FldDateTimeFormat);
		}
		return $Value;
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->LastName, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->FirstName, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Title, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->TitleOfCourtesy, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Address, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->City, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Region, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->PostalCode, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Country, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->HomePhone, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Extension, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->_Email, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Photo, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Notes, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Password, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Username, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Profile, $arKeywords, $type);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSQL(&$Where, &$Fld, $arKeywords, $type) {
		global $EW_BASIC_SEARCH_IGNORE_PATTERN;
		$sDefCond = ($type == "OR") ? "OR" : "AND";
		$arSQL = array(); // Array for SQL parts
		$arCond = array(); // Array for search conditions
		$cnt = count($arKeywords);
		$j = 0; // Number of SQL parts
		for ($i = 0; $i < $cnt; $i++) {
			$Keyword = $arKeywords[$i];
			$Keyword = trim($Keyword);
			if ($EW_BASIC_SEARCH_IGNORE_PATTERN <> "") {
				$Keyword = preg_replace($EW_BASIC_SEARCH_IGNORE_PATTERN, "\\", $Keyword);
				$ar = explode("\\", $Keyword);
			} else {
				$ar = array($Keyword);
			}
			foreach ($ar as $Keyword) {
				if ($Keyword <> "") {
					$sWrk = "";
					if ($Keyword == "OR" && $type == "") {
						if ($j > 0)
							$arCond[$j-1] = "OR";
					} elseif ($Keyword == EW_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NULL";
					} elseif ($Keyword == EW_NOT_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NOT NULL";
					} elseif ($Fld->FldIsVirtual) {
						$sWrk = $Fld->FldVirtualExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					} elseif ($Fld->FldDataType != EW_DATATYPE_NUMBER || is_numeric($Keyword)) {
						$sWrk = $Fld->FldBasicSearchExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					}
					if ($sWrk <> "") {
						$arSQL[$j] = $sWrk;
						$arCond[$j] = $sDefCond;
						$j += 1;
					}
				}
			}
		}
		$cnt = count($arSQL);
		$bQuoted = FALSE;
		$sSql = "";
		if ($cnt > 0) {
			for ($i = 0; $i < $cnt-1; $i++) {
				if ($arCond[$i] == "OR") {
					if (!$bQuoted) $sSql .= "(";
					$bQuoted = TRUE;
				}
				$sSql .= $arSQL[$i];
				if ($bQuoted && $arCond[$i] <> "OR") {
					$sSql .= ")";
					$bQuoted = FALSE;
				}
				$sSql .= " " . $arCond[$i] . " ";
			}
			$sSql .= $arSQL[$cnt-1];
			if ($bQuoted)
				$sSql .= ")";
		}
		if ($sSql <> "") {
			if ($Where <> "") $Where .= " OR ";
			$Where .=  "(" . $sSql . ")";
		}
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere($Default = FALSE) {
		global $Security;
		$sSearchStr = "";
		if (!$Security->CanSearch()) return "";
		$sSearchKeyword = ($Default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
		$sSearchType = ($Default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;
		if ($sSearchKeyword <> "") {
			$sSearch = trim($sSearchKeyword);
			if ($sSearchType <> "=") {
				$ar = array();

				// Match quoted keywords (i.e.: "...")
				if (preg_match_all('/"([^"]*)"/i', $sSearch, $matches, PREG_SET_ORDER)) {
					foreach ($matches as $match) {
						$p = strpos($sSearch, $match[0]);
						$str = substr($sSearch, 0, $p);
						$sSearch = substr($sSearch, $p + strlen($match[0]));
						if (strlen(trim($str)) > 0)
							$ar = array_merge($ar, explode(" ", trim($str)));
						$ar[] = $match[1]; // Save quoted keyword
					}
				}

				// Match individual keywords
				if (strlen(trim($sSearch)) > 0)
					$ar = array_merge($ar, explode(" ", trim($sSearch)));

				// Search keyword in any fields
				if (($sSearchType == "OR" || $sSearchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
					foreach ($ar as $sKeyword) {
						if ($sKeyword <> "") {
							if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
							$sSearchStr .= "(" . $this->BasicSearchSQL(array($sKeyword), $sSearchType) . ")";
						}
					}
				} else {
					$sSearchStr = $this->BasicSearchSQL($ar, $sSearchType);
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL(array($sSearch), $sSearchType);
			}
			if (!$Default) $this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->BasicSearch->setKeyword($sSearchKeyword);
			$this->BasicSearch->setType($sSearchType);
		}
		return $sSearchStr;
	}

	// Check if search parm exists
	function CheckSearchParms() {

		// Check basic search
		if ($this->BasicSearch->IssetSession())
			return TRUE;
		if ($this->EmployeeID->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->LastName->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->FirstName->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Title->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->TitleOfCourtesy->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->BirthDate->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->HireDate->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Address->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->City->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Region->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->PostalCode->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Country->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->HomePhone->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Extension->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->_Email->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Photo->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Notes->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->ReportsTo->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Password->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->UserLevel->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Username->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Activated->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Profile->AdvancedSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();

		// Clear advanced search parameters
		$this->ResetAdvancedSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Clear all advanced search parameters
	function ResetAdvancedSearchParms() {
		$this->EmployeeID->AdvancedSearch->UnsetSession();
		$this->LastName->AdvancedSearch->UnsetSession();
		$this->FirstName->AdvancedSearch->UnsetSession();
		$this->Title->AdvancedSearch->UnsetSession();
		$this->TitleOfCourtesy->AdvancedSearch->UnsetSession();
		$this->BirthDate->AdvancedSearch->UnsetSession();
		$this->HireDate->AdvancedSearch->UnsetSession();
		$this->Address->AdvancedSearch->UnsetSession();
		$this->City->AdvancedSearch->UnsetSession();
		$this->Region->AdvancedSearch->UnsetSession();
		$this->PostalCode->AdvancedSearch->UnsetSession();
		$this->Country->AdvancedSearch->UnsetSession();
		$this->HomePhone->AdvancedSearch->UnsetSession();
		$this->Extension->AdvancedSearch->UnsetSession();
		$this->_Email->AdvancedSearch->UnsetSession();
		$this->Photo->AdvancedSearch->UnsetSession();
		$this->Notes->AdvancedSearch->UnsetSession();
		$this->ReportsTo->AdvancedSearch->UnsetSession();
		$this->Password->AdvancedSearch->UnsetSession();
		$this->UserLevel->AdvancedSearch->UnsetSession();
		$this->Username->AdvancedSearch->UnsetSession();
		$this->Activated->AdvancedSearch->UnsetSession();
		$this->Profile->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->EmployeeID->AdvancedSearch->Load();
		$this->LastName->AdvancedSearch->Load();
		$this->FirstName->AdvancedSearch->Load();
		$this->Title->AdvancedSearch->Load();
		$this->TitleOfCourtesy->AdvancedSearch->Load();
		$this->BirthDate->AdvancedSearch->Load();
		$this->HireDate->AdvancedSearch->Load();
		$this->Address->AdvancedSearch->Load();
		$this->City->AdvancedSearch->Load();
		$this->Region->AdvancedSearch->Load();
		$this->PostalCode->AdvancedSearch->Load();
		$this->Country->AdvancedSearch->Load();
		$this->HomePhone->AdvancedSearch->Load();
		$this->Extension->AdvancedSearch->Load();
		$this->_Email->AdvancedSearch->Load();
		$this->Photo->AdvancedSearch->Load();
		$this->Notes->AdvancedSearch->Load();
		$this->ReportsTo->AdvancedSearch->Load();
		$this->Password->AdvancedSearch->Load();
		$this->UserLevel->AdvancedSearch->Load();
		$this->Username->AdvancedSearch->Load();
		$this->Activated->AdvancedSearch->Load();
		$this->Profile->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->EmployeeID, $bCtrl); // EmployeeID
			$this->UpdateSort($this->LastName, $bCtrl); // LastName
			$this->UpdateSort($this->FirstName, $bCtrl); // FirstName
			$this->UpdateSort($this->Title, $bCtrl); // Title
			$this->UpdateSort($this->TitleOfCourtesy, $bCtrl); // TitleOfCourtesy
			$this->UpdateSort($this->BirthDate, $bCtrl); // BirthDate
			$this->UpdateSort($this->HireDate, $bCtrl); // HireDate
			$this->UpdateSort($this->Address, $bCtrl); // Address
			$this->UpdateSort($this->City, $bCtrl); // City
			$this->UpdateSort($this->Region, $bCtrl); // Region
			$this->UpdateSort($this->PostalCode, $bCtrl); // PostalCode
			$this->UpdateSort($this->Country, $bCtrl); // Country
			$this->UpdateSort($this->HomePhone, $bCtrl); // HomePhone
			$this->UpdateSort($this->Extension, $bCtrl); // Extension
			$this->UpdateSort($this->_Email, $bCtrl); // Email
			$this->UpdateSort($this->Photo, $bCtrl); // Photo
			$this->UpdateSort($this->ReportsTo, $bCtrl); // ReportsTo
			$this->UpdateSort($this->Password, $bCtrl); // Password
			$this->UpdateSort($this->UserLevel, $bCtrl); // UserLevel
			$this->UpdateSort($this->Username, $bCtrl); // Username
			$this->UpdateSort($this->Activated, $bCtrl); // Activated
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->getSqlOrderBy() <> "") {
				$sOrderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->EmployeeID->setSort("");
				$this->LastName->setSort("");
				$this->FirstName->setSort("");
				$this->Title->setSort("");
				$this->TitleOfCourtesy->setSort("");
				$this->BirthDate->setSort("");
				$this->HireDate->setSort("");
				$this->Address->setSort("");
				$this->City->setSort("");
				$this->Region->setSort("");
				$this->PostalCode->setSort("");
				$this->Country->setSort("");
				$this->HomePhone->setSort("");
				$this->Extension->setSort("");
				$this->_Email->setSort("");
				$this->Photo->setSort("");
				$this->ReportsTo->setSort("");
				$this->Password->setSort("");
				$this->UserLevel->setSort("");
				$this->Username->setSort("");
				$this->Activated->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanView();
		$item->OnLeft = TRUE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = TRUE;

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanAdd();
		$item->OnLeft = TRUE;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssStyle = "white-space: nowrap;";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = $Security->CanDelete();
		$item->OnLeft = TRUE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->MoveTo(0);
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$this->SetupListOptionsExt();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if ($Security->CanView() && $this->ShowOptionLink('view')) {
			$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		$editcaption = ew_HtmlTitle($Language->Phrase("EditLink"));
		if ($Security->CanEdit() && $this->ShowOptionLink('edit')) {
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		$copycaption = ew_HtmlTitle($Language->Phrase("CopyLink"));
		if ($Security->CanAdd() && $this->ShowOptionLink('add')) {
			$oListOpt->Body = "<a class=\"ewRowLink ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("CopyLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// Set up list action buttons
		$oListOpt = &$this->ListOptions->GetItem("listactions");
		if ($oListOpt && $this->Export == "" && $this->CurrentAction == "") {
			$body = "";
			$links = array();
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_SINGLE && $listaction->Allow) {
					$action = $listaction->Action;
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode(str_replace(" ewIcon", "", $listaction->Icon)) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\"></span> " : "";
					$links[] = "<li><a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . $listaction->Caption . "</a></li>";
					if (count($links) == 1) // Single button
						$body = "<a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $Language->Phrase("ListActionButton") . "</a>";
				}
			}
			if (count($links) > 1) { // More than one buttons, use dropdown
				$body = "<button class=\"dropdown-toggle btn btn-default btn-sm ewActions\" title=\"" . ew_HtmlTitle($Language->Phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("ListActionButton") . "<b class=\"caret\"></b></button>";
				$content = "";
				foreach ($links as $link)
					$content .= "<li>" . $link . "</li>";
				$body .= "<ul class=\"dropdown-menu" . ($oListOpt->OnLeft ? "" : " dropdown-menu-right") . "\">". $content . "</ul>";
				$body = "<div class=\"btn-group\">" . $body . "</div>";
			}
			if (count($links) > 0) {
				$oListOpt->Body = $body;
				$oListOpt->Visible = TRUE;
			}
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->EmployeeID->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("AddLink"));
		$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());
		$option = $options["action"];

		// Add multi delete
		$item = &$option->Add("multidelete");
		$item->Body = "<a class=\"ewAction ewMultiDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" href=\"\" onclick=\"ew_SubmitAction(event,{f:document.ft96_employeeslist,url:'" . $this->MultiDeleteUrl . "'});return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
		$item->Visible = ($Security->CanDelete());

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = TRUE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-sm"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"ft96_employeeslistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"ft96_employeeslistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
		$this->FilterOptions->DropDownButtonPhrase = $Language->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.ft96_employeeslist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
					$item->Visible = $listaction->Allow;
				}
			}

			// Hide grid edit and other options
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$option->HideAllOptions();
			}
	}

	// Process list action
	function ProcessListAction() {
		global $Language, $Security;
		$userlist = "";
		$user = "";
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {

			// Check permission first
			$ActionCaption = $UserAction;
			if (array_key_exists($UserAction, $this->ListActions->Items)) {
				$ActionCaption = $this->ListActions->Items[$UserAction]->Caption;
				if (!$this->ListActions->Items[$UserAction]->Allow) {
					$errmsg = str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionNotAllowed"));
					if (@$_POST["ajax"] == $UserAction) // Ajax
						echo "<p class=\"text-danger\">" . $errmsg . "</p>";
					else
						$this->setFailureMessage($errmsg);
					return FALSE;
				}
			}
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$this->CurrentAction = $UserAction;

			// Call row action event
			if ($rs && !$rs->EOF) {
				$conn->BeginTrans();
				$this->SelectedCount = $rs->RecordCount();
				$this->SelectedIndex = 0;
				while (!$rs->EOF) {
					$this->SelectedIndex++;
					$row = $rs->fields;
					$user = $row['Username'];
					if ($userlist <> "") $userlist .= ",";
					$userlist .= $user;
					if ($UserAction == "resendregisteremail")
						$Processed = FALSE;
					elseif ($UserAction == "resetconcurrentuser")
						$Processed = FALSE;
					elseif ($UserAction == "resetloginretry")
						$Processed = FALSE;
					elseif ($UserAction == "setpasswordexpired")
						$Processed = FALSE;
					else
						$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
					$rs->MoveNext();
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionFailed")));
					}
				}
			}
			if ($rs)
				$rs->Close();
			$this->CurrentAction = ""; // Clear action
			if (@$_POST["ajax"] == $UserAction) { // Ajax
				if ($this->getSuccessMessage() <> "") {
					echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
					$this->ClearSuccessMessage(); // Clear message
				}
				if ($this->getFailureMessage() <> "") {
					echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
					$this->ClearFailureMessage(); // Clear message
				}
				return TRUE;
			}
		}
		return FALSE; // Not ajax request
	}

	// Set up search options
	function SetupSearchOptions() {
		global $Language;
		$this->SearchOptions = new cListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Search button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = ($this->SearchWhere <> "") ? " active" : " active";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"ft96_employeeslistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Button group for search
		$this->SearchOptions->UseDropDownButton = FALSE;
		$this->SearchOptions->UseImageAndText = TRUE;
		$this->SearchOptions->UseButtonGroup = TRUE;
		$this->SearchOptions->DropDownButtonPhrase = $Language->Phrase("ButtonSearch");

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide search options
		if ($this->Export <> "" || $this->CurrentAction <> "")
			$this->SearchOptions->HideAllOptions();
		global $Security;
		if (!$Security->CanSearch()) {
			$this->SearchOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
		}
	}

	function SetupListOptionsExt() {
		global $Security, $Language;
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
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

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// EmployeeID

		$this->EmployeeID->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_EmployeeID"]);
		if ($this->EmployeeID->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->EmployeeID->AdvancedSearch->SearchOperator = @$_GET["z_EmployeeID"];

		// LastName
		$this->LastName->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_LastName"]);
		if ($this->LastName->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->LastName->AdvancedSearch->SearchOperator = @$_GET["z_LastName"];

		// FirstName
		$this->FirstName->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_FirstName"]);
		if ($this->FirstName->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->FirstName->AdvancedSearch->SearchOperator = @$_GET["z_FirstName"];

		// Title
		$this->Title->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Title"]);
		if ($this->Title->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Title->AdvancedSearch->SearchOperator = @$_GET["z_Title"];

		// TitleOfCourtesy
		$this->TitleOfCourtesy->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_TitleOfCourtesy"]);
		if ($this->TitleOfCourtesy->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->TitleOfCourtesy->AdvancedSearch->SearchOperator = @$_GET["z_TitleOfCourtesy"];

		// BirthDate
		$this->BirthDate->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_BirthDate"]);
		if ($this->BirthDate->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->BirthDate->AdvancedSearch->SearchOperator = @$_GET["z_BirthDate"];

		// HireDate
		$this->HireDate->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_HireDate"]);
		if ($this->HireDate->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->HireDate->AdvancedSearch->SearchOperator = @$_GET["z_HireDate"];

		// Address
		$this->Address->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Address"]);
		if ($this->Address->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Address->AdvancedSearch->SearchOperator = @$_GET["z_Address"];

		// City
		$this->City->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_City"]);
		if ($this->City->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->City->AdvancedSearch->SearchOperator = @$_GET["z_City"];

		// Region
		$this->Region->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Region"]);
		if ($this->Region->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Region->AdvancedSearch->SearchOperator = @$_GET["z_Region"];

		// PostalCode
		$this->PostalCode->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_PostalCode"]);
		if ($this->PostalCode->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->PostalCode->AdvancedSearch->SearchOperator = @$_GET["z_PostalCode"];

		// Country
		$this->Country->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Country"]);
		if ($this->Country->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Country->AdvancedSearch->SearchOperator = @$_GET["z_Country"];

		// HomePhone
		$this->HomePhone->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_HomePhone"]);
		if ($this->HomePhone->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->HomePhone->AdvancedSearch->SearchOperator = @$_GET["z_HomePhone"];

		// Extension
		$this->Extension->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Extension"]);
		if ($this->Extension->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Extension->AdvancedSearch->SearchOperator = @$_GET["z_Extension"];

		// Email
		$this->_Email->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x__Email"]);
		if ($this->_Email->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->_Email->AdvancedSearch->SearchOperator = @$_GET["z__Email"];

		// Photo
		$this->Photo->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Photo"]);
		if ($this->Photo->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Photo->AdvancedSearch->SearchOperator = @$_GET["z_Photo"];

		// Notes
		$this->Notes->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Notes"]);
		if ($this->Notes->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Notes->AdvancedSearch->SearchOperator = @$_GET["z_Notes"];

		// ReportsTo
		$this->ReportsTo->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_ReportsTo"]);
		if ($this->ReportsTo->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->ReportsTo->AdvancedSearch->SearchOperator = @$_GET["z_ReportsTo"];

		// Password
		$this->Password->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Password"]);
		if ($this->Password->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Password->AdvancedSearch->SearchOperator = @$_GET["z_Password"];

		// UserLevel
		$this->UserLevel->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_UserLevel"]);
		if ($this->UserLevel->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->UserLevel->AdvancedSearch->SearchOperator = @$_GET["z_UserLevel"];

		// Username
		$this->Username->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Username"]);
		if ($this->Username->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Username->AdvancedSearch->SearchOperator = @$_GET["z_Username"];

		// Activated
		$this->Activated->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Activated"]);
		if ($this->Activated->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Activated->AdvancedSearch->SearchOperator = @$_GET["z_Activated"];

		// Profile
		$this->Profile->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Profile"]);
		if ($this->Profile->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Profile->AdvancedSearch->SearchOperator = @$_GET["z_Profile"];
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// EmployeeID
			$this->EmployeeID->EditAttrs["class"] = "form-control";
			$this->EmployeeID->EditCustomAttributes = "";
			if (!$Security->IsAdmin() && $Security->IsLoggedIn() && !$this->UserIDAllow($this->CurrentAction)) { // Non system admin
				$this->EmployeeID->AdvancedSearch->SearchValue = CurrentUserID();
			$this->EmployeeID->EditValue = $this->EmployeeID->AdvancedSearch->SearchValue;
			$this->EmployeeID->ViewCustomAttributes = "";
			} else {
			$this->EmployeeID->EditValue = ew_HtmlEncode($this->EmployeeID->AdvancedSearch->SearchValue);
			$this->EmployeeID->PlaceHolder = ew_RemoveHtml($this->EmployeeID->FldCaption());
			}

			// LastName
			$this->LastName->EditAttrs["class"] = "form-control";
			$this->LastName->EditCustomAttributes = "";
			$this->LastName->EditValue = ew_HtmlEncode($this->LastName->AdvancedSearch->SearchValue);
			$this->LastName->PlaceHolder = ew_RemoveHtml($this->LastName->FldCaption());

			// FirstName
			$this->FirstName->EditAttrs["class"] = "form-control";
			$this->FirstName->EditCustomAttributes = "";
			$this->FirstName->EditValue = ew_HtmlEncode($this->FirstName->AdvancedSearch->SearchValue);
			$this->FirstName->PlaceHolder = ew_RemoveHtml($this->FirstName->FldCaption());

			// Title
			$this->Title->EditAttrs["class"] = "form-control";
			$this->Title->EditCustomAttributes = "";
			$this->Title->EditValue = ew_HtmlEncode($this->Title->AdvancedSearch->SearchValue);
			$this->Title->PlaceHolder = ew_RemoveHtml($this->Title->FldCaption());

			// TitleOfCourtesy
			$this->TitleOfCourtesy->EditAttrs["class"] = "form-control";
			$this->TitleOfCourtesy->EditCustomAttributes = "";
			$this->TitleOfCourtesy->EditValue = ew_HtmlEncode($this->TitleOfCourtesy->AdvancedSearch->SearchValue);
			$this->TitleOfCourtesy->PlaceHolder = ew_RemoveHtml($this->TitleOfCourtesy->FldCaption());

			// BirthDate
			$this->BirthDate->EditAttrs["class"] = "form-control";
			$this->BirthDate->EditCustomAttributes = "";
			$this->BirthDate->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->BirthDate->AdvancedSearch->SearchValue, 0), 8));
			$this->BirthDate->PlaceHolder = ew_RemoveHtml($this->BirthDate->FldCaption());

			// HireDate
			$this->HireDate->EditAttrs["class"] = "form-control";
			$this->HireDate->EditCustomAttributes = "";
			$this->HireDate->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->HireDate->AdvancedSearch->SearchValue, 0), 8));
			$this->HireDate->PlaceHolder = ew_RemoveHtml($this->HireDate->FldCaption());

			// Address
			$this->Address->EditAttrs["class"] = "form-control";
			$this->Address->EditCustomAttributes = "";
			$this->Address->EditValue = ew_HtmlEncode($this->Address->AdvancedSearch->SearchValue);
			$this->Address->PlaceHolder = ew_RemoveHtml($this->Address->FldCaption());

			// City
			$this->City->EditAttrs["class"] = "form-control";
			$this->City->EditCustomAttributes = "";
			$this->City->EditValue = ew_HtmlEncode($this->City->AdvancedSearch->SearchValue);
			$this->City->PlaceHolder = ew_RemoveHtml($this->City->FldCaption());

			// Region
			$this->Region->EditAttrs["class"] = "form-control";
			$this->Region->EditCustomAttributes = "";
			$this->Region->EditValue = ew_HtmlEncode($this->Region->AdvancedSearch->SearchValue);
			$this->Region->PlaceHolder = ew_RemoveHtml($this->Region->FldCaption());

			// PostalCode
			$this->PostalCode->EditAttrs["class"] = "form-control";
			$this->PostalCode->EditCustomAttributes = "";
			$this->PostalCode->EditValue = ew_HtmlEncode($this->PostalCode->AdvancedSearch->SearchValue);
			$this->PostalCode->PlaceHolder = ew_RemoveHtml($this->PostalCode->FldCaption());

			// Country
			$this->Country->EditAttrs["class"] = "form-control";
			$this->Country->EditCustomAttributes = "";
			$this->Country->EditValue = ew_HtmlEncode($this->Country->AdvancedSearch->SearchValue);
			$this->Country->PlaceHolder = ew_RemoveHtml($this->Country->FldCaption());

			// HomePhone
			$this->HomePhone->EditAttrs["class"] = "form-control";
			$this->HomePhone->EditCustomAttributes = "";
			$this->HomePhone->EditValue = ew_HtmlEncode($this->HomePhone->AdvancedSearch->SearchValue);
			$this->HomePhone->PlaceHolder = ew_RemoveHtml($this->HomePhone->FldCaption());

			// Extension
			$this->Extension->EditAttrs["class"] = "form-control";
			$this->Extension->EditCustomAttributes = "";
			$this->Extension->EditValue = ew_HtmlEncode($this->Extension->AdvancedSearch->SearchValue);
			$this->Extension->PlaceHolder = ew_RemoveHtml($this->Extension->FldCaption());

			// Email
			$this->_Email->EditAttrs["class"] = "form-control";
			$this->_Email->EditCustomAttributes = "";
			$this->_Email->EditValue = ew_HtmlEncode($this->_Email->AdvancedSearch->SearchValue);
			$this->_Email->PlaceHolder = ew_RemoveHtml($this->_Email->FldCaption());

			// Photo
			$this->Photo->EditAttrs["class"] = "form-control";
			$this->Photo->EditCustomAttributes = "";
			$this->Photo->EditValue = ew_HtmlEncode($this->Photo->AdvancedSearch->SearchValue);
			$this->Photo->PlaceHolder = ew_RemoveHtml($this->Photo->FldCaption());

			// ReportsTo
			$this->ReportsTo->EditAttrs["class"] = "form-control";
			$this->ReportsTo->EditCustomAttributes = "";
			$this->ReportsTo->EditValue = ew_HtmlEncode($this->ReportsTo->AdvancedSearch->SearchValue);
			$this->ReportsTo->PlaceHolder = ew_RemoveHtml($this->ReportsTo->FldCaption());

			// Password
			$this->Password->EditAttrs["class"] = "form-control ewPasswordStrength";
			$this->Password->EditCustomAttributes = "";
			$this->Password->EditValue = ew_HtmlEncode($this->Password->AdvancedSearch->SearchValue);
			$this->Password->PlaceHolder = ew_RemoveHtml($this->Password->FldCaption());

			// UserLevel
			$this->UserLevel->EditAttrs["class"] = "form-control";
			$this->UserLevel->EditCustomAttributes = "";
			if (!$Security->CanAdmin()) { // System admin
				$this->UserLevel->EditValue = $Language->Phrase("PasswordMask");
			} else {
			}

			// Username
			$this->Username->EditAttrs["class"] = "form-control";
			$this->Username->EditCustomAttributes = "";
			$this->Username->EditValue = ew_HtmlEncode($this->Username->AdvancedSearch->SearchValue);
			$this->Username->PlaceHolder = ew_RemoveHtml($this->Username->FldCaption());

			// Activated
			$this->Activated->EditCustomAttributes = "";
			$this->Activated->EditValue = $this->Activated->Options(FALSE);
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

	// Validate search
	function ValidateSearch() {
		global $gsSearchError;

		// Initialize
		$gsSearchError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;

		// Return validate result
		$ValidateSearch = ($gsSearchError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateSearch = $ValidateSearch && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsSearchError, $sFormCustomError);
		}
		return $ValidateSearch;
	}

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->EmployeeID->AdvancedSearch->Load();
		$this->LastName->AdvancedSearch->Load();
		$this->FirstName->AdvancedSearch->Load();
		$this->Title->AdvancedSearch->Load();
		$this->TitleOfCourtesy->AdvancedSearch->Load();
		$this->BirthDate->AdvancedSearch->Load();
		$this->HireDate->AdvancedSearch->Load();
		$this->Address->AdvancedSearch->Load();
		$this->City->AdvancedSearch->Load();
		$this->Region->AdvancedSearch->Load();
		$this->PostalCode->AdvancedSearch->Load();
		$this->Country->AdvancedSearch->Load();
		$this->HomePhone->AdvancedSearch->Load();
		$this->Extension->AdvancedSearch->Load();
		$this->_Email->AdvancedSearch->Load();
		$this->Photo->AdvancedSearch->Load();
		$this->Notes->AdvancedSearch->Load();
		$this->ReportsTo->AdvancedSearch->Load();
		$this->Password->AdvancedSearch->Load();
		$this->UserLevel->AdvancedSearch->Load();
		$this->Username->AdvancedSearch->Load();
		$this->Activated->AdvancedSearch->Load();
		$this->Profile->AdvancedSearch->Load();
	}

	// Set up export options
	function SetupExportOptions() {
		global $Language;

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a href=\"" . $this->ExportPrintUrl . "\" class=\"ewExportLink ewPrint\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = TRUE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ewExportLink ewExcel\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a href=\"" . $this->ExportWordUrl . "\" class=\"ewExportLink ewWord\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = TRUE;

		// Export to Html
		$item = &$this->ExportOptions->Add("html");
		$item->Body = "<a href=\"" . $this->ExportHtmlUrl . "\" class=\"ewExportLink ewHtml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = TRUE;

		// Export to Xml
		$item = &$this->ExportOptions->Add("xml");
		$item->Body = "<a href=\"" . $this->ExportXmlUrl . "\" class=\"ewExportLink ewXml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = TRUE;

		// Export to Csv
		$item = &$this->ExportOptions->Add("csv");
		$item->Body = "<a href=\"" . $this->ExportCsvUrl . "\" class=\"ewExportLink ewCsv\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = TRUE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a href=\"" . $this->ExportPdfUrl . "\" class=\"ewExportLink ewPdf\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = FALSE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_t96_employees\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_t96_employees',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.ft96_employeeslist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
		$item->Visible = FALSE;

		// Drop down button for export
		$this->ExportOptions->UseButtonGroup = TRUE;
		$this->ExportOptions->UseImageAndText = TRUE;
		$this->ExportOptions->UseDropDownButton = TRUE;
		if ($this->ExportOptions->UseButtonGroup && ew_IsMobile())
			$this->ExportOptions->UseDropDownButton = TRUE;
		$this->ExportOptions->DropDownButtonPhrase = $Language->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = $this->UseSelectLimit;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $this->SelectRecordCount();
		} else {
			if (!$this->Recordset)
				$this->Recordset = $this->LoadRecordset();
			$rs = &$this->Recordset;
			if ($rs)
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;

		// Export all
		if ($this->ExportAll) {
			set_time_limit(EW_EXPORT_ALL_TIME_LIMIT);
			$this->DisplayRecs = $this->TotalRecs;
			$this->StopRec = $this->TotalRecs;
		} else { // Export one page only
			$this->SetUpStartRec(); // Set up start record position

			// Set the last record to display
			if ($this->DisplayRecs <= 0) {
				$this->StopRec = $this->TotalRecs;
			} else {
				$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
			}
		}
		if ($bSelectLimit)
			$rs = $this->LoadRecordset($this->StartRec-1, $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs);
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$this->ExportDoc = ew_ExportDocument($this, "h");
		$Doc = &$this->ExportDoc;
		if ($bSelectLimit) {
			$this->StartRec = 1;
			$this->StopRec = $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs;
		} else {

			//$this->StartRec = $this->StartRec;
			//$this->StopRec = $this->StopRec;

		}

		// Call Page Exporting server event
		$this->ExportDoc->ExportCustom = !$this->Page_Exporting();
		$ParentTable = "";
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		$Doc->Text .= $sHeader;
		$this->ExportDocument($Doc, $rs, $this->StartRec, $this->StopRec, "");
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		$Doc->Text .= $sFooter;

		// Close recordset
		$rs->Close();

		// Call Page Exported server event
		$this->Page_Exported();

		// Export header and footer
		$Doc->ExportHeaderAndFooter();

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED && $this->Export <> "pdf")
			echo ew_DebugMsg();

		// Output data
		$Doc->Export();
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
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		if ($pageId == "list") {
			switch ($fld->FldVar) {
			}
		} elseif ($pageId == "extbs") {
			switch ($fld->FldVar) {
			}
		} 
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		if ($pageId == "list") {
			switch ($fld->FldVar) {
			}
		} elseif ($pageId == "extbs") {
			switch ($fld->FldVar) {
			}
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

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
	}

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

		//$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t96_employees_list)) $t96_employees_list = new ct96_employees_list();

// Page init
$t96_employees_list->Page_Init();

// Page main
$t96_employees_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t96_employees_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($t96_employees->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = ft96_employeeslist = new ew_Form("ft96_employeeslist", "list");
ft96_employeeslist.FormKeyCountName = '<?php echo $t96_employees_list->FormKeyCountName ?>';

// Form_CustomValidate event
ft96_employeeslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft96_employeeslist.ValidateRequired = true;
<?php } else { ?>
ft96_employeeslist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft96_employeeslist.Lists["x_UserLevel"] = {"LinkField":"x_userlevelid","Ajax":true,"AutoFill":false,"DisplayFields":["x_userlevelname","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t97_userlevels"};
ft96_employeeslist.Lists["x_Activated"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ft96_employeeslist.Lists["x_Activated"].Options = <?php echo json_encode($t96_employees->Activated->Options()) ?>;

// Form object for search
var CurrentSearchForm = ft96_employeeslistsrch = new ew_Form("ft96_employeeslistsrch");

// Validate function for search
ft96_employeeslistsrch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}

// Form_CustomValidate event
ft96_employeeslistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft96_employeeslistsrch.ValidateRequired = true; // Use JavaScript validation
<?php } else { ?>
ft96_employeeslistsrch.ValidateRequired = false; // No JavaScript validation
<?php } ?>

// Dynamic selection lists
ft96_employeeslistsrch.Lists["x_Activated"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ft96_employeeslistsrch.Lists["x_Activated"].Options = <?php echo json_encode($t96_employees->Activated->Options()) ?>;
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($t96_employees->Export == "") { ?>
<div class="ewToolbar">
<?php if ($t96_employees->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($t96_employees_list->TotalRecs > 0 && $t96_employees_list->ExportOptions->Visible()) { ?>
<?php $t96_employees_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($t96_employees_list->SearchOptions->Visible()) { ?>
<?php $t96_employees_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($t96_employees_list->FilterOptions->Visible()) { ?>
<?php $t96_employees_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($t96_employees->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
	$bSelectLimit = $t96_employees_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t96_employees_list->TotalRecs <= 0)
			$t96_employees_list->TotalRecs = $t96_employees->SelectRecordCount();
	} else {
		if (!$t96_employees_list->Recordset && ($t96_employees_list->Recordset = $t96_employees_list->LoadRecordset()))
			$t96_employees_list->TotalRecs = $t96_employees_list->Recordset->RecordCount();
	}
	$t96_employees_list->StartRec = 1;
	if ($t96_employees_list->DisplayRecs <= 0 || ($t96_employees->Export <> "" && $t96_employees->ExportAll)) // Display all records
		$t96_employees_list->DisplayRecs = $t96_employees_list->TotalRecs;
	if (!($t96_employees->Export <> "" && $t96_employees->ExportAll))
		$t96_employees_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$t96_employees_list->Recordset = $t96_employees_list->LoadRecordset($t96_employees_list->StartRec-1, $t96_employees_list->DisplayRecs);

	// Set no record found message
	if ($t96_employees->CurrentAction == "" && $t96_employees_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$t96_employees_list->setWarningMessage(ew_DeniedMsg());
		if ($t96_employees_list->SearchWhere == "0=101")
			$t96_employees_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t96_employees_list->setWarningMessage($Language->Phrase("NoRecord"));
	}

	// Audit trail on search
	if ($t96_employees_list->AuditTrailOnSearch && $t96_employees_list->Command == "search" && !$t96_employees_list->RestoreSearch) {
		$searchparm = ew_ServerVar("QUERY_STRING");
		$searchsql = $t96_employees_list->getSessionWhere();
		$t96_employees_list->WriteAuditTrailOnSearch($searchparm, $searchsql);
	}
$t96_employees_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($t96_employees->Export == "" && $t96_employees->CurrentAction == "") { ?>
<form name="ft96_employeeslistsrch" id="ft96_employeeslistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($t96_employees_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="ft96_employeeslistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="t96_employees">
	<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$t96_employees_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$t96_employees->RowType = EW_ROWTYPE_SEARCH;

// Render row
$t96_employees->ResetAttrs();
$t96_employees_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($t96_employees->Activated->Visible) { // Activated ?>
	<div id="xsc_Activated" class="ewCell form-group">
		<label class="ewSearchCaption ewLabel"><?php echo $t96_employees->Activated->FldCaption() ?></label>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Activated" id="z_Activated" value="="></span>
		<span class="ewSearchField">
<div id="tp_x_Activated" class="ewTemplate"><input type="radio" data-table="t96_employees" data-field="x_Activated" data-value-separator="<?php echo $t96_employees->Activated->DisplayValueSeparatorAttribute() ?>" name="x_Activated" id="x_Activated" value="{value}"<?php echo $t96_employees->Activated->EditAttributes() ?>></div>
<div id="dsl_x_Activated" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $t96_employees->Activated->RadioButtonListHtml(FALSE, "x_Activated") ?>
</div></div>
</span>
	</div>
<?php } ?>
</div>
<div id="xsr_2" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($t96_employees_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($t96_employees_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $t96_employees_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($t96_employees_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($t96_employees_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($t96_employees_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($t96_employees_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
		</ul>
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("QuickSearchBtn") ?></button>
	</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $t96_employees_list->ShowPageHeader(); ?>
<?php
$t96_employees_list->ShowMessage();
?>
<?php if ($t96_employees_list->TotalRecs > 0 || $t96_employees->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid t96_employees">
<?php if ($t96_employees->Export == "") { ?>
<div class="panel-heading ewGridUpperPanel">
<?php if ($t96_employees->CurrentAction <> "gridadd" && $t96_employees->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t96_employees_list->Pager)) $t96_employees_list->Pager = new cPrevNextPager($t96_employees_list->StartRec, $t96_employees_list->DisplayRecs, $t96_employees_list->TotalRecs) ?>
<?php if ($t96_employees_list->Pager->RecordCount > 0 && $t96_employees_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t96_employees_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t96_employees_list->PageUrl() ?>start=<?php echo $t96_employees_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t96_employees_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t96_employees_list->PageUrl() ?>start=<?php echo $t96_employees_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t96_employees_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t96_employees_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t96_employees_list->PageUrl() ?>start=<?php echo $t96_employees_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t96_employees_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t96_employees_list->PageUrl() ?>start=<?php echo $t96_employees_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t96_employees_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $t96_employees_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $t96_employees_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $t96_employees_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t96_employees_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="ft96_employeeslist" id="ft96_employeeslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t96_employees_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t96_employees_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t96_employees">
<div id="gmp_t96_employees" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($t96_employees_list->TotalRecs > 0 || $t96_employees->CurrentAction == "gridedit") { ?>
<table id="tbl_t96_employeeslist" class="table ewTable">
<?php echo $t96_employees->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$t96_employees_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t96_employees_list->RenderListOptions();

// Render list options (header, left)
$t96_employees_list->ListOptions->Render("header", "left");
?>
<?php if ($t96_employees->EmployeeID->Visible) { // EmployeeID ?>
	<?php if ($t96_employees->SortUrl($t96_employees->EmployeeID) == "") { ?>
		<th data-name="EmployeeID"><div id="elh_t96_employees_EmployeeID" class="t96_employees_EmployeeID"><div class="ewTableHeaderCaption"><?php echo $t96_employees->EmployeeID->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="EmployeeID"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->EmployeeID) ?>',2);"><div id="elh_t96_employees_EmployeeID" class="t96_employees_EmployeeID">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->EmployeeID->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->EmployeeID->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->EmployeeID->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t96_employees->LastName->Visible) { // LastName ?>
	<?php if ($t96_employees->SortUrl($t96_employees->LastName) == "") { ?>
		<th data-name="LastName"><div id="elh_t96_employees_LastName" class="t96_employees_LastName"><div class="ewTableHeaderCaption"><?php echo $t96_employees->LastName->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="LastName"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->LastName) ?>',2);"><div id="elh_t96_employees_LastName" class="t96_employees_LastName">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->LastName->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->LastName->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->LastName->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t96_employees->FirstName->Visible) { // FirstName ?>
	<?php if ($t96_employees->SortUrl($t96_employees->FirstName) == "") { ?>
		<th data-name="FirstName"><div id="elh_t96_employees_FirstName" class="t96_employees_FirstName"><div class="ewTableHeaderCaption"><?php echo $t96_employees->FirstName->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="FirstName"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->FirstName) ?>',2);"><div id="elh_t96_employees_FirstName" class="t96_employees_FirstName">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->FirstName->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->FirstName->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->FirstName->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t96_employees->Title->Visible) { // Title ?>
	<?php if ($t96_employees->SortUrl($t96_employees->Title) == "") { ?>
		<th data-name="Title"><div id="elh_t96_employees_Title" class="t96_employees_Title"><div class="ewTableHeaderCaption"><?php echo $t96_employees->Title->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Title"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->Title) ?>',2);"><div id="elh_t96_employees_Title" class="t96_employees_Title">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->Title->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->Title->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->Title->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t96_employees->TitleOfCourtesy->Visible) { // TitleOfCourtesy ?>
	<?php if ($t96_employees->SortUrl($t96_employees->TitleOfCourtesy) == "") { ?>
		<th data-name="TitleOfCourtesy"><div id="elh_t96_employees_TitleOfCourtesy" class="t96_employees_TitleOfCourtesy"><div class="ewTableHeaderCaption"><?php echo $t96_employees->TitleOfCourtesy->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="TitleOfCourtesy"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->TitleOfCourtesy) ?>',2);"><div id="elh_t96_employees_TitleOfCourtesy" class="t96_employees_TitleOfCourtesy">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->TitleOfCourtesy->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->TitleOfCourtesy->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->TitleOfCourtesy->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t96_employees->BirthDate->Visible) { // BirthDate ?>
	<?php if ($t96_employees->SortUrl($t96_employees->BirthDate) == "") { ?>
		<th data-name="BirthDate"><div id="elh_t96_employees_BirthDate" class="t96_employees_BirthDate"><div class="ewTableHeaderCaption"><?php echo $t96_employees->BirthDate->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="BirthDate"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->BirthDate) ?>',2);"><div id="elh_t96_employees_BirthDate" class="t96_employees_BirthDate">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->BirthDate->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->BirthDate->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->BirthDate->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t96_employees->HireDate->Visible) { // HireDate ?>
	<?php if ($t96_employees->SortUrl($t96_employees->HireDate) == "") { ?>
		<th data-name="HireDate"><div id="elh_t96_employees_HireDate" class="t96_employees_HireDate"><div class="ewTableHeaderCaption"><?php echo $t96_employees->HireDate->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="HireDate"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->HireDate) ?>',2);"><div id="elh_t96_employees_HireDate" class="t96_employees_HireDate">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->HireDate->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->HireDate->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->HireDate->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t96_employees->Address->Visible) { // Address ?>
	<?php if ($t96_employees->SortUrl($t96_employees->Address) == "") { ?>
		<th data-name="Address"><div id="elh_t96_employees_Address" class="t96_employees_Address"><div class="ewTableHeaderCaption"><?php echo $t96_employees->Address->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Address"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->Address) ?>',2);"><div id="elh_t96_employees_Address" class="t96_employees_Address">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->Address->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->Address->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->Address->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t96_employees->City->Visible) { // City ?>
	<?php if ($t96_employees->SortUrl($t96_employees->City) == "") { ?>
		<th data-name="City"><div id="elh_t96_employees_City" class="t96_employees_City"><div class="ewTableHeaderCaption"><?php echo $t96_employees->City->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="City"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->City) ?>',2);"><div id="elh_t96_employees_City" class="t96_employees_City">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->City->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->City->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->City->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t96_employees->Region->Visible) { // Region ?>
	<?php if ($t96_employees->SortUrl($t96_employees->Region) == "") { ?>
		<th data-name="Region"><div id="elh_t96_employees_Region" class="t96_employees_Region"><div class="ewTableHeaderCaption"><?php echo $t96_employees->Region->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Region"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->Region) ?>',2);"><div id="elh_t96_employees_Region" class="t96_employees_Region">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->Region->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->Region->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->Region->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t96_employees->PostalCode->Visible) { // PostalCode ?>
	<?php if ($t96_employees->SortUrl($t96_employees->PostalCode) == "") { ?>
		<th data-name="PostalCode"><div id="elh_t96_employees_PostalCode" class="t96_employees_PostalCode"><div class="ewTableHeaderCaption"><?php echo $t96_employees->PostalCode->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="PostalCode"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->PostalCode) ?>',2);"><div id="elh_t96_employees_PostalCode" class="t96_employees_PostalCode">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->PostalCode->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->PostalCode->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->PostalCode->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t96_employees->Country->Visible) { // Country ?>
	<?php if ($t96_employees->SortUrl($t96_employees->Country) == "") { ?>
		<th data-name="Country"><div id="elh_t96_employees_Country" class="t96_employees_Country"><div class="ewTableHeaderCaption"><?php echo $t96_employees->Country->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Country"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->Country) ?>',2);"><div id="elh_t96_employees_Country" class="t96_employees_Country">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->Country->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->Country->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->Country->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t96_employees->HomePhone->Visible) { // HomePhone ?>
	<?php if ($t96_employees->SortUrl($t96_employees->HomePhone) == "") { ?>
		<th data-name="HomePhone"><div id="elh_t96_employees_HomePhone" class="t96_employees_HomePhone"><div class="ewTableHeaderCaption"><?php echo $t96_employees->HomePhone->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="HomePhone"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->HomePhone) ?>',2);"><div id="elh_t96_employees_HomePhone" class="t96_employees_HomePhone">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->HomePhone->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->HomePhone->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->HomePhone->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t96_employees->Extension->Visible) { // Extension ?>
	<?php if ($t96_employees->SortUrl($t96_employees->Extension) == "") { ?>
		<th data-name="Extension"><div id="elh_t96_employees_Extension" class="t96_employees_Extension"><div class="ewTableHeaderCaption"><?php echo $t96_employees->Extension->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Extension"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->Extension) ?>',2);"><div id="elh_t96_employees_Extension" class="t96_employees_Extension">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->Extension->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->Extension->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->Extension->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t96_employees->_Email->Visible) { // Email ?>
	<?php if ($t96_employees->SortUrl($t96_employees->_Email) == "") { ?>
		<th data-name="_Email"><div id="elh_t96_employees__Email" class="t96_employees__Email"><div class="ewTableHeaderCaption"><?php echo $t96_employees->_Email->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="_Email"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->_Email) ?>',2);"><div id="elh_t96_employees__Email" class="t96_employees__Email">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->_Email->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->_Email->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->_Email->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t96_employees->Photo->Visible) { // Photo ?>
	<?php if ($t96_employees->SortUrl($t96_employees->Photo) == "") { ?>
		<th data-name="Photo"><div id="elh_t96_employees_Photo" class="t96_employees_Photo"><div class="ewTableHeaderCaption"><?php echo $t96_employees->Photo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Photo"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->Photo) ?>',2);"><div id="elh_t96_employees_Photo" class="t96_employees_Photo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->Photo->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->Photo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->Photo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t96_employees->ReportsTo->Visible) { // ReportsTo ?>
	<?php if ($t96_employees->SortUrl($t96_employees->ReportsTo) == "") { ?>
		<th data-name="ReportsTo"><div id="elh_t96_employees_ReportsTo" class="t96_employees_ReportsTo"><div class="ewTableHeaderCaption"><?php echo $t96_employees->ReportsTo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ReportsTo"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->ReportsTo) ?>',2);"><div id="elh_t96_employees_ReportsTo" class="t96_employees_ReportsTo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->ReportsTo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->ReportsTo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->ReportsTo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t96_employees->Password->Visible) { // Password ?>
	<?php if ($t96_employees->SortUrl($t96_employees->Password) == "") { ?>
		<th data-name="Password"><div id="elh_t96_employees_Password" class="t96_employees_Password"><div class="ewTableHeaderCaption"><?php echo $t96_employees->Password->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Password"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->Password) ?>',2);"><div id="elh_t96_employees_Password" class="t96_employees_Password">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->Password->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->Password->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->Password->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t96_employees->UserLevel->Visible) { // UserLevel ?>
	<?php if ($t96_employees->SortUrl($t96_employees->UserLevel) == "") { ?>
		<th data-name="UserLevel"><div id="elh_t96_employees_UserLevel" class="t96_employees_UserLevel"><div class="ewTableHeaderCaption"><?php echo $t96_employees->UserLevel->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="UserLevel"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->UserLevel) ?>',2);"><div id="elh_t96_employees_UserLevel" class="t96_employees_UserLevel">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->UserLevel->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->UserLevel->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->UserLevel->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t96_employees->Username->Visible) { // Username ?>
	<?php if ($t96_employees->SortUrl($t96_employees->Username) == "") { ?>
		<th data-name="Username"><div id="elh_t96_employees_Username" class="t96_employees_Username"><div class="ewTableHeaderCaption"><?php echo $t96_employees->Username->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Username"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->Username) ?>',2);"><div id="elh_t96_employees_Username" class="t96_employees_Username">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->Username->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->Username->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->Username->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t96_employees->Activated->Visible) { // Activated ?>
	<?php if ($t96_employees->SortUrl($t96_employees->Activated) == "") { ?>
		<th data-name="Activated"><div id="elh_t96_employees_Activated" class="t96_employees_Activated"><div class="ewTableHeaderCaption"><?php echo $t96_employees->Activated->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Activated"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->Activated) ?>',2);"><div id="elh_t96_employees_Activated" class="t96_employees_Activated">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->Activated->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->Activated->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->Activated->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$t96_employees_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($t96_employees->ExportAll && $t96_employees->Export <> "") {
	$t96_employees_list->StopRec = $t96_employees_list->TotalRecs;
} else {

	// Set the last record to display
	if ($t96_employees_list->TotalRecs > $t96_employees_list->StartRec + $t96_employees_list->DisplayRecs - 1)
		$t96_employees_list->StopRec = $t96_employees_list->StartRec + $t96_employees_list->DisplayRecs - 1;
	else
		$t96_employees_list->StopRec = $t96_employees_list->TotalRecs;
}
$t96_employees_list->RecCnt = $t96_employees_list->StartRec - 1;
if ($t96_employees_list->Recordset && !$t96_employees_list->Recordset->EOF) {
	$t96_employees_list->Recordset->MoveFirst();
	$bSelectLimit = $t96_employees_list->UseSelectLimit;
	if (!$bSelectLimit && $t96_employees_list->StartRec > 1)
		$t96_employees_list->Recordset->Move($t96_employees_list->StartRec - 1);
} elseif (!$t96_employees->AllowAddDeleteRow && $t96_employees_list->StopRec == 0) {
	$t96_employees_list->StopRec = $t96_employees->GridAddRowCount;
}

// Initialize aggregate
$t96_employees->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t96_employees->ResetAttrs();
$t96_employees_list->RenderRow();
while ($t96_employees_list->RecCnt < $t96_employees_list->StopRec) {
	$t96_employees_list->RecCnt++;
	if (intval($t96_employees_list->RecCnt) >= intval($t96_employees_list->StartRec)) {
		$t96_employees_list->RowCnt++;

		// Set up key count
		$t96_employees_list->KeyCount = $t96_employees_list->RowIndex;

		// Init row class and style
		$t96_employees->ResetAttrs();
		$t96_employees->CssClass = "";
		if ($t96_employees->CurrentAction == "gridadd") {
		} else {
			$t96_employees_list->LoadRowValues($t96_employees_list->Recordset); // Load row values
		}
		$t96_employees->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$t96_employees->RowAttrs = array_merge($t96_employees->RowAttrs, array('data-rowindex'=>$t96_employees_list->RowCnt, 'id'=>'r' . $t96_employees_list->RowCnt . '_t96_employees', 'data-rowtype'=>$t96_employees->RowType));

		// Render row
		$t96_employees_list->RenderRow();

		// Render list options
		$t96_employees_list->RenderListOptions();
?>
	<tr<?php echo $t96_employees->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t96_employees_list->ListOptions->Render("body", "left", $t96_employees_list->RowCnt);
?>
	<?php if ($t96_employees->EmployeeID->Visible) { // EmployeeID ?>
		<td data-name="EmployeeID"<?php echo $t96_employees->EmployeeID->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees_EmployeeID" class="t96_employees_EmployeeID">
<span<?php echo $t96_employees->EmployeeID->ViewAttributes() ?>>
<?php echo $t96_employees->EmployeeID->ListViewValue() ?></span>
</span>
<a id="<?php echo $t96_employees_list->PageObjName . "_row_" . $t96_employees_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($t96_employees->LastName->Visible) { // LastName ?>
		<td data-name="LastName"<?php echo $t96_employees->LastName->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees_LastName" class="t96_employees_LastName">
<span<?php echo $t96_employees->LastName->ViewAttributes() ?>>
<?php echo $t96_employees->LastName->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t96_employees->FirstName->Visible) { // FirstName ?>
		<td data-name="FirstName"<?php echo $t96_employees->FirstName->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees_FirstName" class="t96_employees_FirstName">
<span<?php echo $t96_employees->FirstName->ViewAttributes() ?>>
<?php echo $t96_employees->FirstName->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t96_employees->Title->Visible) { // Title ?>
		<td data-name="Title"<?php echo $t96_employees->Title->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees_Title" class="t96_employees_Title">
<span<?php echo $t96_employees->Title->ViewAttributes() ?>>
<?php echo $t96_employees->Title->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t96_employees->TitleOfCourtesy->Visible) { // TitleOfCourtesy ?>
		<td data-name="TitleOfCourtesy"<?php echo $t96_employees->TitleOfCourtesy->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees_TitleOfCourtesy" class="t96_employees_TitleOfCourtesy">
<span<?php echo $t96_employees->TitleOfCourtesy->ViewAttributes() ?>>
<?php echo $t96_employees->TitleOfCourtesy->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t96_employees->BirthDate->Visible) { // BirthDate ?>
		<td data-name="BirthDate"<?php echo $t96_employees->BirthDate->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees_BirthDate" class="t96_employees_BirthDate">
<span<?php echo $t96_employees->BirthDate->ViewAttributes() ?>>
<?php echo $t96_employees->BirthDate->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t96_employees->HireDate->Visible) { // HireDate ?>
		<td data-name="HireDate"<?php echo $t96_employees->HireDate->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees_HireDate" class="t96_employees_HireDate">
<span<?php echo $t96_employees->HireDate->ViewAttributes() ?>>
<?php echo $t96_employees->HireDate->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t96_employees->Address->Visible) { // Address ?>
		<td data-name="Address"<?php echo $t96_employees->Address->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees_Address" class="t96_employees_Address">
<span<?php echo $t96_employees->Address->ViewAttributes() ?>>
<?php echo $t96_employees->Address->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t96_employees->City->Visible) { // City ?>
		<td data-name="City"<?php echo $t96_employees->City->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees_City" class="t96_employees_City">
<span<?php echo $t96_employees->City->ViewAttributes() ?>>
<?php echo $t96_employees->City->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t96_employees->Region->Visible) { // Region ?>
		<td data-name="Region"<?php echo $t96_employees->Region->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees_Region" class="t96_employees_Region">
<span<?php echo $t96_employees->Region->ViewAttributes() ?>>
<?php echo $t96_employees->Region->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t96_employees->PostalCode->Visible) { // PostalCode ?>
		<td data-name="PostalCode"<?php echo $t96_employees->PostalCode->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees_PostalCode" class="t96_employees_PostalCode">
<span<?php echo $t96_employees->PostalCode->ViewAttributes() ?>>
<?php echo $t96_employees->PostalCode->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t96_employees->Country->Visible) { // Country ?>
		<td data-name="Country"<?php echo $t96_employees->Country->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees_Country" class="t96_employees_Country">
<span<?php echo $t96_employees->Country->ViewAttributes() ?>>
<?php echo $t96_employees->Country->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t96_employees->HomePhone->Visible) { // HomePhone ?>
		<td data-name="HomePhone"<?php echo $t96_employees->HomePhone->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees_HomePhone" class="t96_employees_HomePhone">
<span<?php echo $t96_employees->HomePhone->ViewAttributes() ?>>
<?php echo $t96_employees->HomePhone->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t96_employees->Extension->Visible) { // Extension ?>
		<td data-name="Extension"<?php echo $t96_employees->Extension->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees_Extension" class="t96_employees_Extension">
<span<?php echo $t96_employees->Extension->ViewAttributes() ?>>
<?php echo $t96_employees->Extension->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t96_employees->_Email->Visible) { // Email ?>
		<td data-name="_Email"<?php echo $t96_employees->_Email->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees__Email" class="t96_employees__Email">
<span<?php echo $t96_employees->_Email->ViewAttributes() ?>>
<?php echo $t96_employees->_Email->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t96_employees->Photo->Visible) { // Photo ?>
		<td data-name="Photo"<?php echo $t96_employees->Photo->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees_Photo" class="t96_employees_Photo">
<span<?php echo $t96_employees->Photo->ViewAttributes() ?>>
<?php echo $t96_employees->Photo->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t96_employees->ReportsTo->Visible) { // ReportsTo ?>
		<td data-name="ReportsTo"<?php echo $t96_employees->ReportsTo->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees_ReportsTo" class="t96_employees_ReportsTo">
<span<?php echo $t96_employees->ReportsTo->ViewAttributes() ?>>
<?php echo $t96_employees->ReportsTo->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t96_employees->Password->Visible) { // Password ?>
		<td data-name="Password"<?php echo $t96_employees->Password->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees_Password" class="t96_employees_Password">
<span<?php echo $t96_employees->Password->ViewAttributes() ?>>
<?php echo $t96_employees->Password->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t96_employees->UserLevel->Visible) { // UserLevel ?>
		<td data-name="UserLevel"<?php echo $t96_employees->UserLevel->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees_UserLevel" class="t96_employees_UserLevel">
<span<?php echo $t96_employees->UserLevel->ViewAttributes() ?>>
<?php echo $t96_employees->UserLevel->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t96_employees->Username->Visible) { // Username ?>
		<td data-name="Username"<?php echo $t96_employees->Username->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees_Username" class="t96_employees_Username">
<span<?php echo $t96_employees->Username->ViewAttributes() ?>>
<?php echo $t96_employees->Username->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t96_employees->Activated->Visible) { // Activated ?>
		<td data-name="Activated"<?php echo $t96_employees->Activated->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees_Activated" class="t96_employees_Activated">
<span<?php echo $t96_employees->Activated->ViewAttributes() ?>>
<?php echo $t96_employees->Activated->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t96_employees_list->ListOptions->Render("body", "right", $t96_employees_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($t96_employees->CurrentAction <> "gridadd")
		$t96_employees_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($t96_employees->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($t96_employees_list->Recordset)
	$t96_employees_list->Recordset->Close();
?>
<?php if ($t96_employees->Export == "") { ?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($t96_employees->CurrentAction <> "gridadd" && $t96_employees->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t96_employees_list->Pager)) $t96_employees_list->Pager = new cPrevNextPager($t96_employees_list->StartRec, $t96_employees_list->DisplayRecs, $t96_employees_list->TotalRecs) ?>
<?php if ($t96_employees_list->Pager->RecordCount > 0 && $t96_employees_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t96_employees_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t96_employees_list->PageUrl() ?>start=<?php echo $t96_employees_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t96_employees_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t96_employees_list->PageUrl() ?>start=<?php echo $t96_employees_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t96_employees_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t96_employees_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t96_employees_list->PageUrl() ?>start=<?php echo $t96_employees_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t96_employees_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t96_employees_list->PageUrl() ?>start=<?php echo $t96_employees_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t96_employees_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $t96_employees_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $t96_employees_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $t96_employees_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t96_employees_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($t96_employees_list->TotalRecs == 0 && $t96_employees->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t96_employees_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($t96_employees->Export == "") { ?>
<script type="text/javascript">
ft96_employeeslistsrch.FilterList = <?php echo $t96_employees_list->GetFilterList() ?>;
ft96_employeeslistsrch.Init();
ft96_employeeslist.Init();
</script>
<?php } ?>
<?php
$t96_employees_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($t96_employees->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$t96_employees_list->Page_Terminate();
?>
