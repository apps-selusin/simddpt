<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t03_kelurahaninfo.php" ?>
<?php include_once "t96_employeesinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t03_kelurahan_list = NULL; // Initialize page object first

class ct03_kelurahan_list extends ct03_kelurahan {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{78A0660C-C398-4292-A50E-2A3C7D765239}";

	// Table name
	var $TableName = 't03_kelurahan';

	// Page object name
	var $PageObjName = 't03_kelurahan_list';

	// Grid form hidden field names
	var $FormName = 'ft03_kelurahanlist';
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

		// Table object (t03_kelurahan)
		if (!isset($GLOBALS["t03_kelurahan"]) || get_class($GLOBALS["t03_kelurahan"]) == "ct03_kelurahan") {
			$GLOBALS["t03_kelurahan"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t03_kelurahan"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "t03_kelurahanadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "t03_kelurahandelete.php";
		$this->MultiUpdateUrl = "t03_kelurahanupdate.php";

		// Table object (t96_employees)
		if (!isset($GLOBALS['t96_employees'])) $GLOBALS['t96_employees'] = new ct96_employees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't03_kelurahan', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption ft03_kelurahanlistsrch";

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
		}

		// Create form object
		$objForm = new cFormObj();

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
		$this->provinsi_id->SetVisibility();
		$this->kabupatenkota_id->SetVisibility();
		$this->kecamatan_id->SetVisibility();
		$this->Nama->SetVisibility();

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
		global $EW_EXPORT, $t03_kelurahan;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t03_kelurahan);
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
	var $DisplayRecs = 25;
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

			// Set up records per page
			$this->SetUpDisplayRecs();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

			// Check QueryString parameters
			if (@$_GET["a"] <> "") {
				$this->CurrentAction = $_GET["a"];

				// Clear inline mode
				if ($this->CurrentAction == "cancel")
					$this->ClearInlineMode();

				// Switch to grid edit mode
				if ($this->CurrentAction == "gridedit")
					$this->GridEditMode();

				// Switch to inline edit mode
				if ($this->CurrentAction == "edit")
					$this->InlineEditMode();

				// Switch to inline add mode
				if ($this->CurrentAction == "add" || $this->CurrentAction == "copy")
					$this->InlineAddMode();

				// Switch to grid add mode
				if ($this->CurrentAction == "gridadd")
					$this->GridAddMode();
			} else {
				if (@$_POST["a_list"] <> "") {
					$this->CurrentAction = $_POST["a_list"]; // Get action

					// Grid Update
					if (($this->CurrentAction == "gridupdate" || $this->CurrentAction == "gridoverwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridedit") {
						if ($this->ValidateGridForm()) {
							$bGridUpdate = $this->GridUpdate();
						} else {
							$bGridUpdate = FALSE;
							$this->setFailureMessage($gsFormError);
						}
						if (!$bGridUpdate) {
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridedit"; // Stay in Grid Edit mode
						}
					}

					// Inline Update
					if (($this->CurrentAction == "update" || $this->CurrentAction == "overwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "edit")
						$this->InlineUpdate();

					// Insert Inline
					if ($this->CurrentAction == "insert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "add")
						$this->InlineInsert();

					// Grid Insert
					if ($this->CurrentAction == "gridinsert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridadd") {
						if ($this->ValidateGridForm()) {
							$bGridInsert = $this->GridInsert();
						} else {
							$bGridInsert = FALSE;
							$this->setFailureMessage($gsFormError);
						}
						if (!$bGridInsert) {
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridadd"; // Stay in Grid Add mode
						}
					}
				}
			}

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

			// Show grid delete link for grid add / grid edit
			if ($this->AllowAddDeleteRow) {
				if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
					$item = $this->ListOptions->GetItem("griddelete");
					if ($item) $item->Visible = TRUE;
				}
			}

			// Get default search criteria
			ew_AddFilter($this->DefaultSearchWhere, $this->AdvancedSearchWhere(TRUE));

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

			// Get search criteria for advanced search
			if ($gsSearchError == "")
				$sSrchAdvanced = $this->AdvancedSearchWhere();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 25; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

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

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		$sWrk = @$_GET[EW_TABLE_REC_PER_PAGE];
		if ($sWrk <> "") {
			if (is_numeric($sWrk)) {
				$this->DisplayRecs = intval($sWrk);
			} else {
				if (strtolower($sWrk) == "all") { // Display all records
					$this->DisplayRecs = -1;
				} else {
					$this->DisplayRecs = 25; // Non-numeric, load default
				}
			}
			$this->setRecordsPerPage($this->DisplayRecs); // Save to Session

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	//  Exit inline mode
	function ClearInlineMode() {
		$this->setKey("id", ""); // Clear inline edit key
		$this->LastAction = $this->CurrentAction; // Save last action
		$this->CurrentAction = ""; // Clear action
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

	// Switch to Inline Edit mode
	function InlineEditMode() {
		global $Security, $Language;
		if (!$Security->CanEdit())
			$this->Page_Terminate("login.php"); // Go to login page
		$bInlineEdit = TRUE;
		if (@$_GET["id"] <> "") {
			$this->id->setQueryStringValue($_GET["id"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$this->setKey("id", $this->id->CurrentValue); // Set up inline edit key
				$_SESSION[EW_SESSION_INLINE_MODE] = "edit"; // Enable inline edit
			}
		}
	}

	// Perform update to Inline Edit record
	function InlineUpdate() {
		global $Language, $objForm, $gsFormError;
		$objForm->Index = 1; 
		$this->LoadFormValues(); // Get form values

		// Validate form
		$bInlineUpdate = TRUE;
		if (!$this->ValidateForm()) {	
			$bInlineUpdate = FALSE; // Form error, reset action
			$this->setFailureMessage($gsFormError);
		} else {
			$bInlineUpdate = FALSE;
			$rowkey = strval($objForm->GetValue($this->FormKeyName));
			if ($this->SetupKeyValues($rowkey)) { // Set up key values
				if ($this->CheckInlineEditKey()) { // Check key
					$this->SendEmail = TRUE; // Send email on update success
					$bInlineUpdate = $this->EditRow(); // Update record
				} else {
					$bInlineUpdate = FALSE;
				}
			}
		}
		if ($bInlineUpdate) { // Update success
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
			$this->EventCancelled = TRUE; // Cancel event
			$this->CurrentAction = "edit"; // Stay in edit mode
		}
	}

	// Check Inline Edit key
	function CheckInlineEditKey() {

		//CheckInlineEditKey = True
		if (strval($this->getKey("id")) <> strval($this->id->CurrentValue))
			return FALSE;
		return TRUE;
	}

	// Switch to Inline Add mode
	function InlineAddMode() {
		global $Security, $Language;
		if (!$Security->CanAdd())
			$this->Page_Terminate("login.php"); // Return to login page
		if ($this->CurrentAction == "copy") {
			if (@$_GET["id"] <> "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->setKey("id", $this->id->CurrentValue); // Set up key
			} else {
				$this->setKey("id", ""); // Clear key
				$this->CurrentAction = "add";
			}
		}
		$_SESSION[EW_SESSION_INLINE_MODE] = "add"; // Enable inline add
	}

	// Perform update to Inline Add/Copy record
	function InlineInsert() {
		global $Language, $objForm, $gsFormError;
		$this->LoadOldRecord(); // Load old recordset
		$objForm->Index = 0;
		$this->LoadFormValues(); // Get form values

		// Validate form
		if (!$this->ValidateForm()) {
			$this->setFailureMessage($gsFormError); // Set validation error message
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "add"; // Stay in add mode
			return;
		}
		$this->SendEmail = TRUE; // Send email on add success
		if ($this->AddRow($this->OldRecordset)) { // Add record
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up add success message
			$this->ClearInlineMode(); // Clear inline add mode
		} else { // Add failed
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "add"; // Stay in add mode
		}
	}

	// Perform update to grid
	function GridUpdate() {
		global $Language, $objForm, $gsFormError;
		$bGridUpdate = TRUE;

		// Get old recordset
		$this->CurrentFilter = $this->BuildKeyFilter();
		if ($this->CurrentFilter == "")
			$this->CurrentFilter = "0=1";
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			$rsold = $rs->GetRows();
			$rs->Close();
		}

		// Call Grid Updating event
		if (!$this->Grid_Updating($rsold)) {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("GridEditCancelled")); // Set grid edit cancelled message
			return FALSE;
		}

		// Begin transaction
		$conn->BeginTrans();
		if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateBegin")); // Batch update begin
		$sKey = "";

		// Update row index and get row key
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Update all rows based on key
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
			$objForm->Index = $rowindex;
			$rowkey = strval($objForm->GetValue($this->FormKeyName));
			$rowaction = strval($objForm->GetValue($this->FormActionName));

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
						$this->CurrentFilter = $this->KeyFilter();
						$bGridUpdate = $this->DeleteRows(); // Delete this row
					} else if (!$this->ValidateForm()) {
						$bGridUpdate = FALSE; // Form error, reset action
						$this->setFailureMessage($gsFormError);
					} else {
						if ($rowaction == "insert") {
							$bGridUpdate = $this->AddRow(); // Insert this row
						} else {
							if ($rowkey <> "") {
								$this->SendEmail = FALSE; // Do not send email on update success
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
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Updated event
			$this->Grid_Updated($rsold, $rsnew);
			if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateSuccess")); // Batch update success
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up update success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateRollback")); // Batch update rollback
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
		}
		return $bGridUpdate;
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
			$this->id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Perform Grid Add
	function GridInsert() {
		global $Language, $objForm, $gsFormError;
		$rowindex = 1;
		$bGridInsert = FALSE;
		$conn = &$this->Connection();

		// Call Grid Inserting event
		if (!$this->Grid_Inserting()) {
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("GridAddCancelled")); // Set grid add cancelled message
			}
			return FALSE;
		}

		// Begin transaction
		$conn->BeginTrans();

		// Init key filter
		$sWrkFilter = "";
		$addcnt = 0;
		if ($this->AuditTrailOnAdd) $this->WriteAuditTrailDummy($Language->Phrase("BatchInsertBegin")); // Batch insert begin
		$sKey = "";

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Insert all rows
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "" && $rowaction <> "insert")
				continue; // Skip
			$this->LoadFormValues(); // Get form values
			if (!$this->EmptyRow()) {
				$addcnt++;
				$this->SendEmail = FALSE; // Do not send email on insert success

				// Validate form
				if (!$this->ValidateForm()) {
					$bGridInsert = FALSE; // Form error, reset action
					$this->setFailureMessage($gsFormError);
				} else {
					$bGridInsert = $this->AddRow($this->OldRecordset); // Insert this row
				}
				if ($bGridInsert) {
					if ($sKey <> "") $sKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
					$sKey .= $this->id->CurrentValue;

					// Add filter for this record
					$sFilter = $this->KeyFilter();
					if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
					$sWrkFilter .= $sFilter;
				} else {
					break;
				}
			}
		}
		if ($addcnt == 0) { // No record inserted
			$this->setFailureMessage($Language->Phrase("NoAddRecord"));
			$bGridInsert = FALSE;
		}
		if ($bGridInsert) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			$this->CurrentFilter = $sWrkFilter;
			$sSql = $this->SQL();
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Inserted event
			$this->Grid_Inserted($rsnew);
			if ($this->AuditTrailOnAdd) $this->WriteAuditTrailDummy($Language->Phrase("BatchInsertSuccess")); // Batch insert success
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("InsertSuccess")); // Set up insert success message
			$this->ClearInlineMode(); // Clear grid add mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->AuditTrailOnAdd) $this->WriteAuditTrailDummy($Language->Phrase("BatchInsertRollback")); // Batch insert rollback
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("InsertFailed")); // Set insert failed message
			}
		}
		return $bGridInsert;
	}

	// Check if empty row
	function EmptyRow() {
		global $objForm;
		if ($objForm->HasValue("x_provinsi_id") && $objForm->HasValue("o_provinsi_id") && $this->provinsi_id->CurrentValue <> $this->provinsi_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_kabupatenkota_id") && $objForm->HasValue("o_kabupatenkota_id") && $this->kabupatenkota_id->CurrentValue <> $this->kabupatenkota_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_kecamatan_id") && $objForm->HasValue("o_kecamatan_id") && $this->kecamatan_id->CurrentValue <> $this->kecamatan_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Nama") && $objForm->HasValue("o_Nama") && $this->Nama->CurrentValue <> $this->Nama->OldValue)
			return FALSE;
		return TRUE;
	}

	// Validate grid form
	function ValidateGridForm() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Validate all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
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

	// Get all form values of the grid
	function GetGridFormValues() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;
		$rows = array();

		// Loop through all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else {
					$rows[] = $this->GetFieldValues("FormValue"); // Return row as array
				}
			}
		}
		return $rows; // Return as array of array
	}

	// Restore form values for current row
	function RestoreCurrentRowFormValues($idx) {
		global $objForm;

		// Get row based on current index
		$objForm->Index = $idx;
		$this->LoadFormValues(); // Load form values
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Load server side filters
		if (EW_SEARCH_FILTER_OPTION == "Server") {
			$sSavedFilterList = isset($UserProfile) ? $UserProfile->GetSearchFilters(CurrentUserName(), "ft03_kelurahanlistsrch") : "";
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->id->AdvancedSearch->ToJSON(), ","); // Field id
		$sFilterList = ew_Concat($sFilterList, $this->provinsi_id->AdvancedSearch->ToJSON(), ","); // Field provinsi_id
		$sFilterList = ew_Concat($sFilterList, $this->kabupatenkota_id->AdvancedSearch->ToJSON(), ","); // Field kabupatenkota_id
		$sFilterList = ew_Concat($sFilterList, $this->kecamatan_id->AdvancedSearch->ToJSON(), ","); // Field kecamatan_id
		$sFilterList = ew_Concat($sFilterList, $this->Nama->AdvancedSearch->ToJSON(), ","); // Field Nama
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "ft03_kelurahanlistsrch", $filters);

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

		// Field id
		$this->id->AdvancedSearch->SearchValue = @$filter["x_id"];
		$this->id->AdvancedSearch->SearchOperator = @$filter["z_id"];
		$this->id->AdvancedSearch->SearchCondition = @$filter["v_id"];
		$this->id->AdvancedSearch->SearchValue2 = @$filter["y_id"];
		$this->id->AdvancedSearch->SearchOperator2 = @$filter["w_id"];
		$this->id->AdvancedSearch->Save();

		// Field provinsi_id
		$this->provinsi_id->AdvancedSearch->SearchValue = @$filter["x_provinsi_id"];
		$this->provinsi_id->AdvancedSearch->SearchOperator = @$filter["z_provinsi_id"];
		$this->provinsi_id->AdvancedSearch->SearchCondition = @$filter["v_provinsi_id"];
		$this->provinsi_id->AdvancedSearch->SearchValue2 = @$filter["y_provinsi_id"];
		$this->provinsi_id->AdvancedSearch->SearchOperator2 = @$filter["w_provinsi_id"];
		$this->provinsi_id->AdvancedSearch->Save();

		// Field kabupatenkota_id
		$this->kabupatenkota_id->AdvancedSearch->SearchValue = @$filter["x_kabupatenkota_id"];
		$this->kabupatenkota_id->AdvancedSearch->SearchOperator = @$filter["z_kabupatenkota_id"];
		$this->kabupatenkota_id->AdvancedSearch->SearchCondition = @$filter["v_kabupatenkota_id"];
		$this->kabupatenkota_id->AdvancedSearch->SearchValue2 = @$filter["y_kabupatenkota_id"];
		$this->kabupatenkota_id->AdvancedSearch->SearchOperator2 = @$filter["w_kabupatenkota_id"];
		$this->kabupatenkota_id->AdvancedSearch->Save();

		// Field kecamatan_id
		$this->kecamatan_id->AdvancedSearch->SearchValue = @$filter["x_kecamatan_id"];
		$this->kecamatan_id->AdvancedSearch->SearchOperator = @$filter["z_kecamatan_id"];
		$this->kecamatan_id->AdvancedSearch->SearchCondition = @$filter["v_kecamatan_id"];
		$this->kecamatan_id->AdvancedSearch->SearchValue2 = @$filter["y_kecamatan_id"];
		$this->kecamatan_id->AdvancedSearch->SearchOperator2 = @$filter["w_kecamatan_id"];
		$this->kecamatan_id->AdvancedSearch->Save();

		// Field Nama
		$this->Nama->AdvancedSearch->SearchValue = @$filter["x_Nama"];
		$this->Nama->AdvancedSearch->SearchOperator = @$filter["z_Nama"];
		$this->Nama->AdvancedSearch->SearchCondition = @$filter["v_Nama"];
		$this->Nama->AdvancedSearch->SearchValue2 = @$filter["y_Nama"];
		$this->Nama->AdvancedSearch->SearchOperator2 = @$filter["w_Nama"];
		$this->Nama->AdvancedSearch->Save();
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere($Default = FALSE) {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->id, $Default, FALSE); // id
		$this->BuildSearchSql($sWhere, $this->provinsi_id, $Default, FALSE); // provinsi_id
		$this->BuildSearchSql($sWhere, $this->kabupatenkota_id, $Default, FALSE); // kabupatenkota_id
		$this->BuildSearchSql($sWhere, $this->kecamatan_id, $Default, FALSE); // kecamatan_id
		$this->BuildSearchSql($sWhere, $this->Nama, $Default, FALSE); // Nama

		// Set up search parm
		if (!$Default && $sWhere <> "") {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->id->AdvancedSearch->Save(); // id
			$this->provinsi_id->AdvancedSearch->Save(); // provinsi_id
			$this->kabupatenkota_id->AdvancedSearch->Save(); // kabupatenkota_id
			$this->kecamatan_id->AdvancedSearch->Save(); // kecamatan_id
			$this->Nama->AdvancedSearch->Save(); // Nama
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

	// Check if search parm exists
	function CheckSearchParms() {
		if ($this->id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->provinsi_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->kabupatenkota_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->kecamatan_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Nama->AdvancedSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear advanced search parameters
		$this->ResetAdvancedSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all advanced search parameters
	function ResetAdvancedSearchParms() {
		$this->id->AdvancedSearch->UnsetSession();
		$this->provinsi_id->AdvancedSearch->UnsetSession();
		$this->kabupatenkota_id->AdvancedSearch->UnsetSession();
		$this->kecamatan_id->AdvancedSearch->UnsetSession();
		$this->Nama->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore advanced search values
		$this->id->AdvancedSearch->Load();
		$this->provinsi_id->AdvancedSearch->Load();
		$this->kabupatenkota_id->AdvancedSearch->Load();
		$this->kecamatan_id->AdvancedSearch->Load();
		$this->Nama->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->provinsi_id, $bCtrl); // provinsi_id
			$this->UpdateSort($this->kabupatenkota_id, $bCtrl); // kabupatenkota_id
			$this->UpdateSort($this->kecamatan_id, $bCtrl); // kecamatan_id
			$this->UpdateSort($this->Nama, $bCtrl); // Nama
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
				$this->provinsi_id->setSort("");
				$this->kabupatenkota_id->setSort("");
				$this->kecamatan_id->setSort("");
				$this->Nama->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// "griddelete"
		if ($this->AllowAddDeleteRow) {
			$item = &$this->ListOptions->Add("griddelete");
			$item->CssStyle = "white-space: nowrap;";
			$item->OnLeft = TRUE;
			$item->Visible = FALSE; // Default hidden
		}

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

		// "sequence"
		$item = &$this->ListOptions->Add("sequence");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = TRUE;
		$item->OnLeft = TRUE; // Always on left
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

		// Set up row action and key
		if (is_numeric($this->RowIndex) && $this->CurrentMode <> "view") {
			$objForm->Index = $this->RowIndex;
			$ActionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
			$OldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormOldKeyName);
			$KeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormKeyName);
			$BlankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
			if ($this->RowAction <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $ActionName . "\" id=\"" . $ActionName . "\" value=\"" . $this->RowAction . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $objForm->GetValue($this->FormKeyName);
				$this->SetupKeyValues($rowkey);
			}
			if ($this->RowAction == "insert" && $this->CurrentAction == "F" && $this->EmptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $BlankRowName . "\" id=\"" . $BlankRowName . "\" value=\"1\">";
		}

		// "delete"
		if ($this->AllowAddDeleteRow) {
			if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$option = &$this->ListOptions;
				$option->UseButtonGroup = TRUE; // Use button group for grid delete button
				$option->UseImageAndText = TRUE; // Use image and text for grid delete button
				$oListOpt = &$option->Items["griddelete"];
				if (!$Security->CanDelete() && is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
					$oListOpt->Body = "&nbsp;";
				} else {
					$oListOpt->Body = "<a class=\"ewGridLink ewGridDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" onclick=\"return ew_DeleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->Phrase("DeleteLink") . "</a>";
				}
			}
		}

		// "sequence"
		$oListOpt = &$this->ListOptions->Items["sequence"];
		$oListOpt->Body = ew_FormatSeqNo($this->RecCnt);

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		if (($this->CurrentAction == "add" || $this->CurrentAction == "copy") && $this->RowType == EW_ROWTYPE_ADD) { // Inline Add/Copy
			$this->ListOptions->CustomItem = "copy"; // Show copy column only
			$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
			$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
				"<a class=\"ewGridLink ewInlineInsert\" title=\"" . ew_HtmlTitle($Language->Phrase("InsertLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InsertLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("InsertLink") . "</a>&nbsp;" .
				"<a class=\"ewGridLink ewInlineCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("CancelLink") . "</a>" .
				"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"insert\"></div>";
			return;
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($this->CurrentAction == "edit" && $this->RowType == EW_ROWTYPE_EDIT) { // Inline-Edit
			$this->ListOptions->CustomItem = "edit"; // Show edit column only
			$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
				$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
					"<a class=\"ewGridLink ewInlineUpdate\" title=\"" . ew_HtmlTitle($Language->Phrase("UpdateLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("UpdateLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . ew_GetHashUrl($this->PageName(), $this->PageObjName . "_row_" . $this->RowCnt) . "');\">" . $Language->Phrase("UpdateLink") . "</a>&nbsp;" .
					"<a class=\"ewGridLink ewInlineCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("CancelLink") . "</a>" .
					"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"update\"></div>";
			$oListOpt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . ew_HtmlEncode($this->id->CurrentValue) . "\">";
			return;
		}

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if ($Security->CanView()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		$editcaption = ew_HtmlTitle($Language->Phrase("EditLink"));
		if ($Security->CanEdit()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
			$oListOpt->Body .= "<a class=\"ewRowLink ewInlineEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("InlineEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineEditLink")) . "\" href=\"" . ew_HtmlEncode(ew_GetHashUrl($this->InlineEditUrl, $this->PageObjName . "_row_" . $this->RowCnt)) . "\">" . $Language->Phrase("InlineEditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		$copycaption = ew_HtmlTitle($Language->Phrase("CopyLink"));
		if ($Security->CanAdd()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("CopyLink") . "</a>";
			$oListOpt->Body .= "<a class=\"ewRowLink ewInlineCopy\" title=\"" . ew_HtmlTitle($Language->Phrase("InlineCopyLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->InlineCopyUrl) . "\">" . $Language->Phrase("InlineCopyLink") . "</a>";
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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->id->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->id->CurrentValue . "\">";
		}
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

		// Inline Add
		$item = &$option->Add("inlineadd");
		$item->Body = "<a class=\"ewAddEdit ewInlineAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("InlineAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineAddLink")) . "\" href=\"" . ew_HtmlEncode($this->InlineAddUrl) . "\">" .$Language->Phrase("InlineAddLink") . "</a>";
		$item->Visible = ($this->InlineAddUrl <> "" && $Security->CanAdd());
		$item = &$option->Add("gridadd");
		$item->Body = "<a class=\"ewAddEdit ewGridAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "\" href=\"" . ew_HtmlEncode($this->GridAddUrl) . "\">" . $Language->Phrase("GridAddLink") . "</a>";
		$item->Visible = ($this->GridAddUrl <> "" && $Security->CanAdd());

		// Add grid edit
		$option = $options["addedit"];
		$item = &$option->Add("gridedit");
		$item->Body = "<a class=\"ewAddEdit ewGridEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GridEditUrl) . "\">" . $Language->Phrase("GridEditLink") . "</a>";
		$item->Visible = ($this->GridEditUrl <> "" && $Security->CanEdit());
		$option = $options["action"];

		// Add multi delete
		$item = &$option->Add("multidelete");
		$item->Body = "<a class=\"ewAction ewMultiDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" href=\"\" onclick=\"ew_SubmitAction(event,{f:document.ft03_kelurahanlist,url:'" . $this->MultiDeleteUrl . "'});return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"ft03_kelurahanlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"ft03_kelurahanlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "gridedit") { // Not grid add/edit mode
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.ft03_kelurahanlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		} else { // Grid add/edit mode

			// Hide all options first
			foreach ($options as &$option)
				$option->HideAllOptions();
			if ($this->CurrentAction == "gridadd") {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = &$options["addedit"];
					$option->UseDropDownButton = FALSE;
					$option->UseImageAndText = TRUE;
					$item = &$option->Add("addblankrow");
					$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
					$item->Visible = $Security->CanAdd();
				}
				$option = &$options["action"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;

				// Add grid insert
				$item = &$option->Add("gridinsert");
				$item->Body = "<a class=\"ewAction ewGridInsert\" title=\"" . ew_HtmlTitle($Language->Phrase("GridInsertLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridInsertLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("GridInsertLink") . "</a>";

				// Add grid cancel
				$item = &$option->Add("gridcancel");
				$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
				$item->Body = "<a class=\"ewAction ewGridCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("GridCancelLink") . "</a>";
			}
			if ($this->CurrentAction == "gridedit") {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = &$options["addedit"];
					$option->UseDropDownButton = FALSE;
					$option->UseImageAndText = TRUE;
					$item = &$option->Add("addblankrow");
					$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
					$item->Visible = $Security->CanAdd();
				}
				$option = &$options["action"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;
					$item = &$option->Add("gridsave");
					$item->Body = "<a class=\"ewAction ewGridSave\" title=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("GridSaveLink") . "</a>";
					$item = &$option->Add("gridcancel");
					$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
					$item->Body = "<a class=\"ewAction ewGridCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("GridCancelLink") . "</a>";
			}
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"ft03_kelurahanlistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
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

	// Load default values
	function LoadDefaultValues() {
		$this->provinsi_id->CurrentValue = NULL;
		$this->provinsi_id->OldValue = $this->provinsi_id->CurrentValue;
		$this->kabupatenkota_id->CurrentValue = NULL;
		$this->kabupatenkota_id->OldValue = $this->kabupatenkota_id->CurrentValue;
		$this->kecamatan_id->CurrentValue = NULL;
		$this->kecamatan_id->OldValue = $this->kecamatan_id->CurrentValue;
		$this->Nama->CurrentValue = NULL;
		$this->Nama->OldValue = $this->Nama->CurrentValue;
	}

	// Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// id

		$this->id->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_id"]);
		if ($this->id->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->id->AdvancedSearch->SearchOperator = @$_GET["z_id"];

		// provinsi_id
		$this->provinsi_id->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_provinsi_id"]);
		if ($this->provinsi_id->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->provinsi_id->AdvancedSearch->SearchOperator = @$_GET["z_provinsi_id"];

		// kabupatenkota_id
		$this->kabupatenkota_id->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_kabupatenkota_id"]);
		if ($this->kabupatenkota_id->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->kabupatenkota_id->AdvancedSearch->SearchOperator = @$_GET["z_kabupatenkota_id"];

		// kecamatan_id
		$this->kecamatan_id->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_kecamatan_id"]);
		if ($this->kecamatan_id->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->kecamatan_id->AdvancedSearch->SearchOperator = @$_GET["z_kecamatan_id"];

		// Nama
		$this->Nama->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Nama"]);
		if ($this->Nama->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Nama->AdvancedSearch->SearchOperator = @$_GET["z_Nama"];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->provinsi_id->FldIsDetailKey) {
			$this->provinsi_id->setFormValue($objForm->GetValue("x_provinsi_id"));
		}
		$this->provinsi_id->setOldValue($objForm->GetValue("o_provinsi_id"));
		if (!$this->kabupatenkota_id->FldIsDetailKey) {
			$this->kabupatenkota_id->setFormValue($objForm->GetValue("x_kabupatenkota_id"));
		}
		$this->kabupatenkota_id->setOldValue($objForm->GetValue("o_kabupatenkota_id"));
		if (!$this->kecamatan_id->FldIsDetailKey) {
			$this->kecamatan_id->setFormValue($objForm->GetValue("x_kecamatan_id"));
		}
		$this->kecamatan_id->setOldValue($objForm->GetValue("o_kecamatan_id"));
		if (!$this->Nama->FldIsDetailKey) {
			$this->Nama->setFormValue($objForm->GetValue("x_Nama"));
		}
		$this->Nama->setOldValue($objForm->GetValue("o_Nama"));
		if (!$this->id->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id->setFormValue($objForm->GetValue("x_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id->CurrentValue = $this->id->FormValue;
		$this->provinsi_id->CurrentValue = $this->provinsi_id->FormValue;
		$this->kabupatenkota_id->CurrentValue = $this->kabupatenkota_id->FormValue;
		$this->kecamatan_id->CurrentValue = $this->kecamatan_id->FormValue;
		$this->Nama->CurrentValue = $this->Nama->FormValue;
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
		$this->provinsi_id->setDbValue($rs->fields('provinsi_id'));
		$this->kabupatenkota_id->setDbValue($rs->fields('kabupatenkota_id'));
		$this->kecamatan_id->setDbValue($rs->fields('kecamatan_id'));
		$this->Nama->setDbValue($rs->fields('Nama'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->provinsi_id->DbValue = $row['provinsi_id'];
		$this->kabupatenkota_id->DbValue = $row['kabupatenkota_id'];
		$this->kecamatan_id->DbValue = $row['kecamatan_id'];
		$this->Nama->DbValue = $row['Nama'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id")) <> "")
			$this->id->CurrentValue = $this->getKey("id"); // id
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
		// id
		// provinsi_id
		// kabupatenkota_id
		// kecamatan_id
		// Nama

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// provinsi_id
		if (strval($this->provinsi_id->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->provinsi_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `Nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t00_provinsi`";
		$sWhereWrk = "";
		$this->provinsi_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->provinsi_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->provinsi_id->ViewValue = $this->provinsi_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->provinsi_id->ViewValue = $this->provinsi_id->CurrentValue;
			}
		} else {
			$this->provinsi_id->ViewValue = NULL;
		}
		$this->provinsi_id->ViewCustomAttributes = "";

		// kabupatenkota_id
		if (strval($this->kabupatenkota_id->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->kabupatenkota_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `Nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t01_kabupatenkota`";
		$sWhereWrk = "";
		$this->kabupatenkota_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kabupatenkota_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->kabupatenkota_id->ViewValue = $this->kabupatenkota_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kabupatenkota_id->ViewValue = $this->kabupatenkota_id->CurrentValue;
			}
		} else {
			$this->kabupatenkota_id->ViewValue = NULL;
		}
		$this->kabupatenkota_id->ViewCustomAttributes = "";

		// kecamatan_id
		if (strval($this->kecamatan_id->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->kecamatan_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `Nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t02_kecamatan`";
		$sWhereWrk = "";
		$this->kecamatan_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kecamatan_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->kecamatan_id->ViewValue = $this->kecamatan_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kecamatan_id->ViewValue = $this->kecamatan_id->CurrentValue;
			}
		} else {
			$this->kecamatan_id->ViewValue = NULL;
		}
		$this->kecamatan_id->ViewCustomAttributes = "";

		// Nama
		$this->Nama->ViewValue = $this->Nama->CurrentValue;
		$this->Nama->ViewCustomAttributes = "";

			// provinsi_id
			$this->provinsi_id->LinkCustomAttributes = "";
			$this->provinsi_id->HrefValue = "";
			$this->provinsi_id->TooltipValue = "";

			// kabupatenkota_id
			$this->kabupatenkota_id->LinkCustomAttributes = "";
			$this->kabupatenkota_id->HrefValue = "";
			$this->kabupatenkota_id->TooltipValue = "";

			// kecamatan_id
			$this->kecamatan_id->LinkCustomAttributes = "";
			$this->kecamatan_id->HrefValue = "";
			$this->kecamatan_id->TooltipValue = "";

			// Nama
			$this->Nama->LinkCustomAttributes = "";
			$this->Nama->HrefValue = "";
			$this->Nama->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// provinsi_id
			$this->provinsi_id->EditAttrs["class"] = "form-control";
			$this->provinsi_id->EditCustomAttributes = "";
			if (trim(strval($this->provinsi_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->provinsi_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `Nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `t00_provinsi`";
			$sWhereWrk = "";
			$this->provinsi_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->provinsi_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->provinsi_id->EditValue = $arwrk;

			// kabupatenkota_id
			$this->kabupatenkota_id->EditAttrs["class"] = "form-control";
			$this->kabupatenkota_id->EditCustomAttributes = "";
			if (trim(strval($this->kabupatenkota_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->kabupatenkota_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `Nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `provinsi_id` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `t01_kabupatenkota`";
			$sWhereWrk = "";
			$this->kabupatenkota_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->kabupatenkota_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->kabupatenkota_id->EditValue = $arwrk;

			// kecamatan_id
			$this->kecamatan_id->EditAttrs["class"] = "form-control";
			$this->kecamatan_id->EditCustomAttributes = "";
			if (trim(strval($this->kecamatan_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->kecamatan_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `Nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `kabupatenkota_id` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `t02_kecamatan`";
			$sWhereWrk = "";
			$this->kecamatan_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->kecamatan_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->kecamatan_id->EditValue = $arwrk;

			// Nama
			$this->Nama->EditAttrs["class"] = "form-control";
			$this->Nama->EditCustomAttributes = "";
			$this->Nama->EditValue = ew_HtmlEncode($this->Nama->CurrentValue);
			$this->Nama->PlaceHolder = ew_RemoveHtml($this->Nama->FldCaption());

			// Add refer script
			// provinsi_id

			$this->provinsi_id->LinkCustomAttributes = "";
			$this->provinsi_id->HrefValue = "";

			// kabupatenkota_id
			$this->kabupatenkota_id->LinkCustomAttributes = "";
			$this->kabupatenkota_id->HrefValue = "";

			// kecamatan_id
			$this->kecamatan_id->LinkCustomAttributes = "";
			$this->kecamatan_id->HrefValue = "";

			// Nama
			$this->Nama->LinkCustomAttributes = "";
			$this->Nama->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// provinsi_id
			$this->provinsi_id->EditAttrs["class"] = "form-control";
			$this->provinsi_id->EditCustomAttributes = "";
			if (trim(strval($this->provinsi_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->provinsi_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `Nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `t00_provinsi`";
			$sWhereWrk = "";
			$this->provinsi_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->provinsi_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->provinsi_id->EditValue = $arwrk;

			// kabupatenkota_id
			$this->kabupatenkota_id->EditAttrs["class"] = "form-control";
			$this->kabupatenkota_id->EditCustomAttributes = "";
			if (trim(strval($this->kabupatenkota_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->kabupatenkota_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `Nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `provinsi_id` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `t01_kabupatenkota`";
			$sWhereWrk = "";
			$this->kabupatenkota_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->kabupatenkota_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->kabupatenkota_id->EditValue = $arwrk;

			// kecamatan_id
			$this->kecamatan_id->EditAttrs["class"] = "form-control";
			$this->kecamatan_id->EditCustomAttributes = "";
			if (trim(strval($this->kecamatan_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->kecamatan_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `Nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `kabupatenkota_id` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `t02_kecamatan`";
			$sWhereWrk = "";
			$this->kecamatan_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->kecamatan_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->kecamatan_id->EditValue = $arwrk;

			// Nama
			$this->Nama->EditAttrs["class"] = "form-control";
			$this->Nama->EditCustomAttributes = "";
			$this->Nama->EditValue = ew_HtmlEncode($this->Nama->CurrentValue);
			$this->Nama->PlaceHolder = ew_RemoveHtml($this->Nama->FldCaption());

			// Edit refer script
			// provinsi_id

			$this->provinsi_id->LinkCustomAttributes = "";
			$this->provinsi_id->HrefValue = "";

			// kabupatenkota_id
			$this->kabupatenkota_id->LinkCustomAttributes = "";
			$this->kabupatenkota_id->HrefValue = "";

			// kecamatan_id
			$this->kecamatan_id->LinkCustomAttributes = "";
			$this->kecamatan_id->HrefValue = "";

			// Nama
			$this->Nama->LinkCustomAttributes = "";
			$this->Nama->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// provinsi_id
			$this->provinsi_id->EditAttrs["class"] = "form-control";
			$this->provinsi_id->EditCustomAttributes = "";
			if (trim(strval($this->provinsi_id->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->provinsi_id->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `Nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `t00_provinsi`";
			$sWhereWrk = "";
			$this->provinsi_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->provinsi_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->provinsi_id->EditValue = $arwrk;

			// kabupatenkota_id
			$this->kabupatenkota_id->EditAttrs["class"] = "form-control";
			$this->kabupatenkota_id->EditCustomAttributes = "";
			if (trim(strval($this->kabupatenkota_id->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->kabupatenkota_id->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `Nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `provinsi_id` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `t01_kabupatenkota`";
			$sWhereWrk = "";
			$this->kabupatenkota_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->kabupatenkota_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->kabupatenkota_id->EditValue = $arwrk;

			// kecamatan_id
			$this->kecamatan_id->EditAttrs["class"] = "form-control";
			$this->kecamatan_id->EditCustomAttributes = "";
			if (trim(strval($this->kecamatan_id->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->kecamatan_id->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `Nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `kabupatenkota_id` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `t02_kecamatan`";
			$sWhereWrk = "";
			$this->kecamatan_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->kecamatan_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->kecamatan_id->EditValue = $arwrk;

			// Nama
			$this->Nama->EditAttrs["class"] = "form-control";
			$this->Nama->EditCustomAttributes = "";
			$this->Nama->EditValue = ew_HtmlEncode($this->Nama->AdvancedSearch->SearchValue);
			$this->Nama->PlaceHolder = ew_RemoveHtml($this->Nama->FldCaption());
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

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->provinsi_id->FldIsDetailKey && !is_null($this->provinsi_id->FormValue) && $this->provinsi_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->provinsi_id->FldCaption(), $this->provinsi_id->ReqErrMsg));
		}
		if (!$this->kabupatenkota_id->FldIsDetailKey && !is_null($this->kabupatenkota_id->FormValue) && $this->kabupatenkota_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kabupatenkota_id->FldCaption(), $this->kabupatenkota_id->ReqErrMsg));
		}
		if (!$this->kecamatan_id->FldIsDetailKey && !is_null($this->kecamatan_id->FormValue) && $this->kecamatan_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kecamatan_id->FldCaption(), $this->kecamatan_id->ReqErrMsg));
		}
		if (!$this->Nama->FldIsDetailKey && !is_null($this->Nama->FormValue) && $this->Nama->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Nama->FldCaption(), $this->Nama->ReqErrMsg));
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
				$sThisKey .= $row['id'];
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
			if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteSuccess")); // Batch delete success
		} else {
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
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

			// provinsi_id
			$this->provinsi_id->SetDbValueDef($rsnew, $this->provinsi_id->CurrentValue, 0, $this->provinsi_id->ReadOnly);

			// kabupatenkota_id
			$this->kabupatenkota_id->SetDbValueDef($rsnew, $this->kabupatenkota_id->CurrentValue, 0, $this->kabupatenkota_id->ReadOnly);

			// kecamatan_id
			$this->kecamatan_id->SetDbValueDef($rsnew, $this->kecamatan_id->CurrentValue, 0, $this->kecamatan_id->ReadOnly);

			// Nama
			$this->Nama->SetDbValueDef($rsnew, $this->Nama->CurrentValue, "", $this->Nama->ReadOnly);

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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// provinsi_id
		$this->provinsi_id->SetDbValueDef($rsnew, $this->provinsi_id->CurrentValue, 0, FALSE);

		// kabupatenkota_id
		$this->kabupatenkota_id->SetDbValueDef($rsnew, $this->kabupatenkota_id->CurrentValue, 0, FALSE);

		// kecamatan_id
		$this->kecamatan_id->SetDbValueDef($rsnew, $this->kecamatan_id->CurrentValue, 0, FALSE);

		// Nama
		$this->Nama->SetDbValueDef($rsnew, $this->Nama->CurrentValue, "", FALSE);

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

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->id->AdvancedSearch->Load();
		$this->provinsi_id->AdvancedSearch->Load();
		$this->kabupatenkota_id->AdvancedSearch->Load();
		$this->kecamatan_id->AdvancedSearch->Load();
		$this->Nama->AdvancedSearch->Load();
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
		$item->Body = "<button id=\"emf_t03_kelurahan\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_t03_kelurahan',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.ft03_kelurahanlist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
		case "x_provinsi_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `Nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t00_provinsi`";
			$sWhereWrk = "";
			$this->provinsi_id->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->provinsi_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_kabupatenkota_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `Nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t01_kabupatenkota`";
			$sWhereWrk = "{filter}";
			$this->kabupatenkota_id->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "3", "fn0" => "", "f1" => '`provinsi_id` IN ({filter_value})', "t1" => "3", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->kabupatenkota_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_kecamatan_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `Nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t02_kecamatan`";
			$sWhereWrk = "{filter}";
			$this->kecamatan_id->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "3", "fn0" => "", "f1" => '`kabupatenkota_id` IN ({filter_value})', "t1" => "3", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->kecamatan_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
			}
		} elseif ($pageId == "extbs") {
			switch ($fld->FldVar) {
		case "x_provinsi_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `Nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t00_provinsi`";
			$sWhereWrk = "";
			$this->provinsi_id->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->provinsi_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_kabupatenkota_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `Nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t01_kabupatenkota`";
			$sWhereWrk = "{filter}";
			$this->kabupatenkota_id->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "3", "fn0" => "", "f1" => '`provinsi_id` IN ({filter_value})', "t1" => "3", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->kabupatenkota_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_kecamatan_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `Nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t02_kecamatan`";
			$sWhereWrk = "{filter}";
			$this->kecamatan_id->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "3", "fn0" => "", "f1" => '`kabupatenkota_id` IN ({filter_value})', "t1" => "3", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->kecamatan_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
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
if (!isset($t03_kelurahan_list)) $t03_kelurahan_list = new ct03_kelurahan_list();

// Page init
$t03_kelurahan_list->Page_Init();

// Page main
$t03_kelurahan_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t03_kelurahan_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($t03_kelurahan->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = ft03_kelurahanlist = new ew_Form("ft03_kelurahanlist", "list");
ft03_kelurahanlist.FormKeyCountName = '<?php echo $t03_kelurahan_list->FormKeyCountName ?>';

// Validate form
ft03_kelurahanlist.Validate = function() {
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
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
			elm = this.GetElements("x" + infix + "_provinsi_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t03_kelurahan->provinsi_id->FldCaption(), $t03_kelurahan->provinsi_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kabupatenkota_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t03_kelurahan->kabupatenkota_id->FldCaption(), $t03_kelurahan->kabupatenkota_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kecamatan_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t03_kelurahan->kecamatan_id->FldCaption(), $t03_kelurahan->kecamatan_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Nama");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t03_kelurahan->Nama->FldCaption(), $t03_kelurahan->Nama->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	if (gridinsert && addcnt == 0) { // No row added
		ew_Alert(ewLanguage.Phrase("NoAddRecord"));
		return false;
	}
	return true;
}

// Check empty row
ft03_kelurahanlist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "provinsi_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "kabupatenkota_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "kecamatan_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Nama", false)) return false;
	return true;
}

// Form_CustomValidate event
ft03_kelurahanlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft03_kelurahanlist.ValidateRequired = true;
<?php } else { ?>
ft03_kelurahanlist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft03_kelurahanlist.Lists["x_provinsi_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nama","","",""],"ParentFields":[],"ChildFields":["x_kabupatenkota_id"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t00_provinsi"};
ft03_kelurahanlist.Lists["x_kabupatenkota_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nama","","",""],"ParentFields":["x_provinsi_id"],"ChildFields":["x_kecamatan_id"],"FilterFields":["x_provinsi_id"],"Options":[],"Template":"","LinkTable":"t01_kabupatenkota"};
ft03_kelurahanlist.Lists["x_kecamatan_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nama","","",""],"ParentFields":["x_kabupatenkota_id"],"ChildFields":[],"FilterFields":["x_kabupatenkota_id"],"Options":[],"Template":"","LinkTable":"t02_kecamatan"};

// Form object for search
var CurrentSearchForm = ft03_kelurahanlistsrch = new ew_Form("ft03_kelurahanlistsrch");

// Validate function for search
ft03_kelurahanlistsrch.Validate = function(fobj) {
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
ft03_kelurahanlistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft03_kelurahanlistsrch.ValidateRequired = true; // Use JavaScript validation
<?php } else { ?>
ft03_kelurahanlistsrch.ValidateRequired = false; // No JavaScript validation
<?php } ?>

// Dynamic selection lists
ft03_kelurahanlistsrch.Lists["x_provinsi_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nama","","",""],"ParentFields":[],"ChildFields":["x_kabupatenkota_id"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t00_provinsi"};
ft03_kelurahanlistsrch.Lists["x_kabupatenkota_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nama","","",""],"ParentFields":["x_provinsi_id"],"ChildFields":["x_kecamatan_id"],"FilterFields":["x_provinsi_id"],"Options":[],"Template":"","LinkTable":"t01_kabupatenkota"};
ft03_kelurahanlistsrch.Lists["x_kecamatan_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nama","","",""],"ParentFields":["x_kabupatenkota_id"],"ChildFields":[],"FilterFields":["x_kabupatenkota_id"],"Options":[],"Template":"","LinkTable":"t02_kecamatan"};
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($t03_kelurahan->Export == "") { ?>
<div class="ewToolbar">
<?php if ($t03_kelurahan->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($t03_kelurahan_list->TotalRecs > 0 && $t03_kelurahan_list->ExportOptions->Visible()) { ?>
<?php $t03_kelurahan_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($t03_kelurahan_list->SearchOptions->Visible()) { ?>
<?php $t03_kelurahan_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($t03_kelurahan_list->FilterOptions->Visible()) { ?>
<?php $t03_kelurahan_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($t03_kelurahan->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
if ($t03_kelurahan->CurrentAction == "gridadd") {
	$t03_kelurahan->CurrentFilter = "0=1";
	$t03_kelurahan_list->StartRec = 1;
	$t03_kelurahan_list->DisplayRecs = $t03_kelurahan->GridAddRowCount;
	$t03_kelurahan_list->TotalRecs = $t03_kelurahan_list->DisplayRecs;
	$t03_kelurahan_list->StopRec = $t03_kelurahan_list->DisplayRecs;
} else {
	$bSelectLimit = $t03_kelurahan_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t03_kelurahan_list->TotalRecs <= 0)
			$t03_kelurahan_list->TotalRecs = $t03_kelurahan->SelectRecordCount();
	} else {
		if (!$t03_kelurahan_list->Recordset && ($t03_kelurahan_list->Recordset = $t03_kelurahan_list->LoadRecordset()))
			$t03_kelurahan_list->TotalRecs = $t03_kelurahan_list->Recordset->RecordCount();
	}
	$t03_kelurahan_list->StartRec = 1;
	if ($t03_kelurahan_list->DisplayRecs <= 0 || ($t03_kelurahan->Export <> "" && $t03_kelurahan->ExportAll)) // Display all records
		$t03_kelurahan_list->DisplayRecs = $t03_kelurahan_list->TotalRecs;
	if (!($t03_kelurahan->Export <> "" && $t03_kelurahan->ExportAll))
		$t03_kelurahan_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$t03_kelurahan_list->Recordset = $t03_kelurahan_list->LoadRecordset($t03_kelurahan_list->StartRec-1, $t03_kelurahan_list->DisplayRecs);

	// Set no record found message
	if ($t03_kelurahan->CurrentAction == "" && $t03_kelurahan_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$t03_kelurahan_list->setWarningMessage(ew_DeniedMsg());
		if ($t03_kelurahan_list->SearchWhere == "0=101")
			$t03_kelurahan_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t03_kelurahan_list->setWarningMessage($Language->Phrase("NoRecord"));
	}

	// Audit trail on search
	if ($t03_kelurahan_list->AuditTrailOnSearch && $t03_kelurahan_list->Command == "search" && !$t03_kelurahan_list->RestoreSearch) {
		$searchparm = ew_ServerVar("QUERY_STRING");
		$searchsql = $t03_kelurahan_list->getSessionWhere();
		$t03_kelurahan_list->WriteAuditTrailOnSearch($searchparm, $searchsql);
	}
}
$t03_kelurahan_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($t03_kelurahan->Export == "" && $t03_kelurahan->CurrentAction == "") { ?>
<form name="ft03_kelurahanlistsrch" id="ft03_kelurahanlistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($t03_kelurahan_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="ft03_kelurahanlistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="t03_kelurahan">
	<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$t03_kelurahan_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$t03_kelurahan->RowType = EW_ROWTYPE_SEARCH;

// Render row
$t03_kelurahan->ResetAttrs();
$t03_kelurahan_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($t03_kelurahan->provinsi_id->Visible) { // provinsi_id ?>
	<div id="xsc_provinsi_id" class="ewCell form-group">
		<label for="x_provinsi_id" class="ewSearchCaption ewLabel"><?php echo $t03_kelurahan->provinsi_id->FldCaption() ?></label>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_provinsi_id" id="z_provinsi_id" value="="></span>
		<span class="ewSearchField">
<?php $t03_kelurahan->provinsi_id->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$t03_kelurahan->provinsi_id->EditAttrs["onchange"]; ?>
<select data-table="t03_kelurahan" data-field="x_provinsi_id" data-value-separator="<?php echo $t03_kelurahan->provinsi_id->DisplayValueSeparatorAttribute() ?>" id="x_provinsi_id" name="x_provinsi_id"<?php echo $t03_kelurahan->provinsi_id->EditAttributes() ?>>
<?php echo $t03_kelurahan->provinsi_id->SelectOptionListHtml("x_provinsi_id") ?>
</select>
<input type="hidden" name="s_x_provinsi_id" id="s_x_provinsi_id" value="<?php echo $t03_kelurahan->provinsi_id->LookupFilterQuery(false, "extbs") ?>">
</span>
	</div>
<?php } ?>
</div>
<div id="xsr_2" class="ewRow">
<?php if ($t03_kelurahan->kabupatenkota_id->Visible) { // kabupatenkota_id ?>
	<div id="xsc_kabupatenkota_id" class="ewCell form-group">
		<label for="x_kabupatenkota_id" class="ewSearchCaption ewLabel"><?php echo $t03_kelurahan->kabupatenkota_id->FldCaption() ?></label>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_kabupatenkota_id" id="z_kabupatenkota_id" value="="></span>
		<span class="ewSearchField">
<?php $t03_kelurahan->kabupatenkota_id->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$t03_kelurahan->kabupatenkota_id->EditAttrs["onchange"]; ?>
<select data-table="t03_kelurahan" data-field="x_kabupatenkota_id" data-value-separator="<?php echo $t03_kelurahan->kabupatenkota_id->DisplayValueSeparatorAttribute() ?>" id="x_kabupatenkota_id" name="x_kabupatenkota_id"<?php echo $t03_kelurahan->kabupatenkota_id->EditAttributes() ?>>
<?php echo $t03_kelurahan->kabupatenkota_id->SelectOptionListHtml("x_kabupatenkota_id") ?>
</select>
<input type="hidden" name="s_x_kabupatenkota_id" id="s_x_kabupatenkota_id" value="<?php echo $t03_kelurahan->kabupatenkota_id->LookupFilterQuery(false, "extbs") ?>">
</span>
	</div>
<?php } ?>
</div>
<div id="xsr_3" class="ewRow">
<?php if ($t03_kelurahan->kecamatan_id->Visible) { // kecamatan_id ?>
	<div id="xsc_kecamatan_id" class="ewCell form-group">
		<label for="x_kecamatan_id" class="ewSearchCaption ewLabel"><?php echo $t03_kelurahan->kecamatan_id->FldCaption() ?></label>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_kecamatan_id" id="z_kecamatan_id" value="="></span>
		<span class="ewSearchField">
<select data-table="t03_kelurahan" data-field="x_kecamatan_id" data-value-separator="<?php echo $t03_kelurahan->kecamatan_id->DisplayValueSeparatorAttribute() ?>" id="x_kecamatan_id" name="x_kecamatan_id"<?php echo $t03_kelurahan->kecamatan_id->EditAttributes() ?>>
<?php echo $t03_kelurahan->kecamatan_id->SelectOptionListHtml("x_kecamatan_id") ?>
</select>
<input type="hidden" name="s_x_kecamatan_id" id="s_x_kecamatan_id" value="<?php echo $t03_kelurahan->kecamatan_id->LookupFilterQuery(false, "extbs") ?>">
</span>
	</div>
<?php } ?>
</div>
<div id="xsr_4" class="ewRow">
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("QuickSearchBtn") ?></button>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $t03_kelurahan_list->ShowPageHeader(); ?>
<?php
$t03_kelurahan_list->ShowMessage();
?>
<?php if ($t03_kelurahan_list->TotalRecs > 0 || $t03_kelurahan->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid t03_kelurahan">
<?php if ($t03_kelurahan->Export == "") { ?>
<div class="panel-heading ewGridUpperPanel">
<?php if ($t03_kelurahan->CurrentAction <> "gridadd" && $t03_kelurahan->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t03_kelurahan_list->Pager)) $t03_kelurahan_list->Pager = new cPrevNextPager($t03_kelurahan_list->StartRec, $t03_kelurahan_list->DisplayRecs, $t03_kelurahan_list->TotalRecs) ?>
<?php if ($t03_kelurahan_list->Pager->RecordCount > 0 && $t03_kelurahan_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t03_kelurahan_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t03_kelurahan_list->PageUrl() ?>start=<?php echo $t03_kelurahan_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t03_kelurahan_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t03_kelurahan_list->PageUrl() ?>start=<?php echo $t03_kelurahan_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t03_kelurahan_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t03_kelurahan_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t03_kelurahan_list->PageUrl() ?>start=<?php echo $t03_kelurahan_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t03_kelurahan_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t03_kelurahan_list->PageUrl() ?>start=<?php echo $t03_kelurahan_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t03_kelurahan_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $t03_kelurahan_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $t03_kelurahan_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $t03_kelurahan_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($t03_kelurahan_list->TotalRecs > 0 && (!EW_AUTO_HIDE_PAGE_SIZE_SELECTOR || $t03_kelurahan_list->Pager->Visible)) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="t03_kelurahan">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="10"<?php if ($t03_kelurahan_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($t03_kelurahan_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="25"<?php if ($t03_kelurahan_list->DisplayRecs == 25) { ?> selected<?php } ?>>25</option>
<option value="50"<?php if ($t03_kelurahan_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($t03_kelurahan_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="200"<?php if ($t03_kelurahan_list->DisplayRecs == 200) { ?> selected<?php } ?>>200</option>
<option value="500"<?php if ($t03_kelurahan_list->DisplayRecs == 500) { ?> selected<?php } ?>>500</option>
<option value="ALL"<?php if ($t03_kelurahan->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t03_kelurahan_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="ft03_kelurahanlist" id="ft03_kelurahanlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t03_kelurahan_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t03_kelurahan_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t03_kelurahan">
<div id="gmp_t03_kelurahan" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($t03_kelurahan_list->TotalRecs > 0 || $t03_kelurahan->CurrentAction == "add" || $t03_kelurahan->CurrentAction == "copy" || $t03_kelurahan->CurrentAction == "gridedit") { ?>
<table id="tbl_t03_kelurahanlist" class="table ewTable">
<?php echo $t03_kelurahan->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$t03_kelurahan_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t03_kelurahan_list->RenderListOptions();

// Render list options (header, left)
$t03_kelurahan_list->ListOptions->Render("header", "left");
?>
<?php if ($t03_kelurahan->provinsi_id->Visible) { // provinsi_id ?>
	<?php if ($t03_kelurahan->SortUrl($t03_kelurahan->provinsi_id) == "") { ?>
		<th data-name="provinsi_id"><div id="elh_t03_kelurahan_provinsi_id" class="t03_kelurahan_provinsi_id"><div class="ewTableHeaderCaption"><?php echo $t03_kelurahan->provinsi_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="provinsi_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t03_kelurahan->SortUrl($t03_kelurahan->provinsi_id) ?>',2);"><div id="elh_t03_kelurahan_provinsi_id" class="t03_kelurahan_provinsi_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t03_kelurahan->provinsi_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t03_kelurahan->provinsi_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t03_kelurahan->provinsi_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t03_kelurahan->kabupatenkota_id->Visible) { // kabupatenkota_id ?>
	<?php if ($t03_kelurahan->SortUrl($t03_kelurahan->kabupatenkota_id) == "") { ?>
		<th data-name="kabupatenkota_id"><div id="elh_t03_kelurahan_kabupatenkota_id" class="t03_kelurahan_kabupatenkota_id"><div class="ewTableHeaderCaption"><?php echo $t03_kelurahan->kabupatenkota_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kabupatenkota_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t03_kelurahan->SortUrl($t03_kelurahan->kabupatenkota_id) ?>',2);"><div id="elh_t03_kelurahan_kabupatenkota_id" class="t03_kelurahan_kabupatenkota_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t03_kelurahan->kabupatenkota_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t03_kelurahan->kabupatenkota_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t03_kelurahan->kabupatenkota_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t03_kelurahan->kecamatan_id->Visible) { // kecamatan_id ?>
	<?php if ($t03_kelurahan->SortUrl($t03_kelurahan->kecamatan_id) == "") { ?>
		<th data-name="kecamatan_id"><div id="elh_t03_kelurahan_kecamatan_id" class="t03_kelurahan_kecamatan_id"><div class="ewTableHeaderCaption"><?php echo $t03_kelurahan->kecamatan_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kecamatan_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t03_kelurahan->SortUrl($t03_kelurahan->kecamatan_id) ?>',2);"><div id="elh_t03_kelurahan_kecamatan_id" class="t03_kelurahan_kecamatan_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t03_kelurahan->kecamatan_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t03_kelurahan->kecamatan_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t03_kelurahan->kecamatan_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t03_kelurahan->Nama->Visible) { // Nama ?>
	<?php if ($t03_kelurahan->SortUrl($t03_kelurahan->Nama) == "") { ?>
		<th data-name="Nama"><div id="elh_t03_kelurahan_Nama" class="t03_kelurahan_Nama"><div class="ewTableHeaderCaption"><?php echo $t03_kelurahan->Nama->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nama"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t03_kelurahan->SortUrl($t03_kelurahan->Nama) ?>',2);"><div id="elh_t03_kelurahan_Nama" class="t03_kelurahan_Nama">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t03_kelurahan->Nama->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t03_kelurahan->Nama->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t03_kelurahan->Nama->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$t03_kelurahan_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
	if ($t03_kelurahan->CurrentAction == "add" || $t03_kelurahan->CurrentAction == "copy") {
		$t03_kelurahan_list->RowIndex = 0;
		$t03_kelurahan_list->KeyCount = $t03_kelurahan_list->RowIndex;
		if ($t03_kelurahan->CurrentAction == "copy" && !$t03_kelurahan_list->LoadRow())
				$t03_kelurahan->CurrentAction = "add";
		if ($t03_kelurahan->CurrentAction == "add")
			$t03_kelurahan_list->LoadDefaultValues();
		if ($t03_kelurahan->EventCancelled) // Insert failed
			$t03_kelurahan_list->RestoreFormValues(); // Restore form values

		// Set row properties
		$t03_kelurahan->ResetAttrs();
		$t03_kelurahan->RowAttrs = array_merge($t03_kelurahan->RowAttrs, array('data-rowindex'=>0, 'id'=>'r0_t03_kelurahan', 'data-rowtype'=>EW_ROWTYPE_ADD));
		$t03_kelurahan->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t03_kelurahan_list->RenderRow();

		// Render list options
		$t03_kelurahan_list->RenderListOptions();
		$t03_kelurahan_list->StartRowCnt = 0;
?>
	<tr<?php echo $t03_kelurahan->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t03_kelurahan_list->ListOptions->Render("body", "left", $t03_kelurahan_list->RowCnt);
?>
	<?php if ($t03_kelurahan->provinsi_id->Visible) { // provinsi_id ?>
		<td data-name="provinsi_id">
<span id="el<?php echo $t03_kelurahan_list->RowCnt ?>_t03_kelurahan_provinsi_id" class="form-group t03_kelurahan_provinsi_id">
<?php $t03_kelurahan->provinsi_id->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$t03_kelurahan->provinsi_id->EditAttrs["onchange"]; ?>
<select data-table="t03_kelurahan" data-field="x_provinsi_id" data-value-separator="<?php echo $t03_kelurahan->provinsi_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t03_kelurahan_list->RowIndex ?>_provinsi_id" name="x<?php echo $t03_kelurahan_list->RowIndex ?>_provinsi_id"<?php echo $t03_kelurahan->provinsi_id->EditAttributes() ?>>
<?php echo $t03_kelurahan->provinsi_id->SelectOptionListHtml("x<?php echo $t03_kelurahan_list->RowIndex ?>_provinsi_id") ?>
</select>
<input type="hidden" name="s_x<?php echo $t03_kelurahan_list->RowIndex ?>_provinsi_id" id="s_x<?php echo $t03_kelurahan_list->RowIndex ?>_provinsi_id" value="<?php echo $t03_kelurahan->provinsi_id->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="t03_kelurahan" data-field="x_provinsi_id" name="o<?php echo $t03_kelurahan_list->RowIndex ?>_provinsi_id" id="o<?php echo $t03_kelurahan_list->RowIndex ?>_provinsi_id" value="<?php echo ew_HtmlEncode($t03_kelurahan->provinsi_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t03_kelurahan->kabupatenkota_id->Visible) { // kabupatenkota_id ?>
		<td data-name="kabupatenkota_id">
<span id="el<?php echo $t03_kelurahan_list->RowCnt ?>_t03_kelurahan_kabupatenkota_id" class="form-group t03_kelurahan_kabupatenkota_id">
<?php $t03_kelurahan->kabupatenkota_id->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$t03_kelurahan->kabupatenkota_id->EditAttrs["onchange"]; ?>
<select data-table="t03_kelurahan" data-field="x_kabupatenkota_id" data-value-separator="<?php echo $t03_kelurahan->kabupatenkota_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t03_kelurahan_list->RowIndex ?>_kabupatenkota_id" name="x<?php echo $t03_kelurahan_list->RowIndex ?>_kabupatenkota_id"<?php echo $t03_kelurahan->kabupatenkota_id->EditAttributes() ?>>
<?php echo $t03_kelurahan->kabupatenkota_id->SelectOptionListHtml("x<?php echo $t03_kelurahan_list->RowIndex ?>_kabupatenkota_id") ?>
</select>
<input type="hidden" name="s_x<?php echo $t03_kelurahan_list->RowIndex ?>_kabupatenkota_id" id="s_x<?php echo $t03_kelurahan_list->RowIndex ?>_kabupatenkota_id" value="<?php echo $t03_kelurahan->kabupatenkota_id->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="t03_kelurahan" data-field="x_kabupatenkota_id" name="o<?php echo $t03_kelurahan_list->RowIndex ?>_kabupatenkota_id" id="o<?php echo $t03_kelurahan_list->RowIndex ?>_kabupatenkota_id" value="<?php echo ew_HtmlEncode($t03_kelurahan->kabupatenkota_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t03_kelurahan->kecamatan_id->Visible) { // kecamatan_id ?>
		<td data-name="kecamatan_id">
<span id="el<?php echo $t03_kelurahan_list->RowCnt ?>_t03_kelurahan_kecamatan_id" class="form-group t03_kelurahan_kecamatan_id">
<select data-table="t03_kelurahan" data-field="x_kecamatan_id" data-value-separator="<?php echo $t03_kelurahan->kecamatan_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t03_kelurahan_list->RowIndex ?>_kecamatan_id" name="x<?php echo $t03_kelurahan_list->RowIndex ?>_kecamatan_id"<?php echo $t03_kelurahan->kecamatan_id->EditAttributes() ?>>
<?php echo $t03_kelurahan->kecamatan_id->SelectOptionListHtml("x<?php echo $t03_kelurahan_list->RowIndex ?>_kecamatan_id") ?>
</select>
<input type="hidden" name="s_x<?php echo $t03_kelurahan_list->RowIndex ?>_kecamatan_id" id="s_x<?php echo $t03_kelurahan_list->RowIndex ?>_kecamatan_id" value="<?php echo $t03_kelurahan->kecamatan_id->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="t03_kelurahan" data-field="x_kecamatan_id" name="o<?php echo $t03_kelurahan_list->RowIndex ?>_kecamatan_id" id="o<?php echo $t03_kelurahan_list->RowIndex ?>_kecamatan_id" value="<?php echo ew_HtmlEncode($t03_kelurahan->kecamatan_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t03_kelurahan->Nama->Visible) { // Nama ?>
		<td data-name="Nama">
<span id="el<?php echo $t03_kelurahan_list->RowCnt ?>_t03_kelurahan_Nama" class="form-group t03_kelurahan_Nama">
<input type="text" data-table="t03_kelurahan" data-field="x_Nama" name="x<?php echo $t03_kelurahan_list->RowIndex ?>_Nama" id="x<?php echo $t03_kelurahan_list->RowIndex ?>_Nama" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t03_kelurahan->Nama->getPlaceHolder()) ?>" value="<?php echo $t03_kelurahan->Nama->EditValue ?>"<?php echo $t03_kelurahan->Nama->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_kelurahan" data-field="x_Nama" name="o<?php echo $t03_kelurahan_list->RowIndex ?>_Nama" id="o<?php echo $t03_kelurahan_list->RowIndex ?>_Nama" value="<?php echo ew_HtmlEncode($t03_kelurahan->Nama->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t03_kelurahan_list->ListOptions->Render("body", "right", $t03_kelurahan_list->RowCnt);
?>
<script type="text/javascript">
ft03_kelurahanlist.UpdateOpts(<?php echo $t03_kelurahan_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
<?php
if ($t03_kelurahan->ExportAll && $t03_kelurahan->Export <> "") {
	$t03_kelurahan_list->StopRec = $t03_kelurahan_list->TotalRecs;
} else {

	// Set the last record to display
	if ($t03_kelurahan_list->TotalRecs > $t03_kelurahan_list->StartRec + $t03_kelurahan_list->DisplayRecs - 1)
		$t03_kelurahan_list->StopRec = $t03_kelurahan_list->StartRec + $t03_kelurahan_list->DisplayRecs - 1;
	else
		$t03_kelurahan_list->StopRec = $t03_kelurahan_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($t03_kelurahan_list->FormKeyCountName) && ($t03_kelurahan->CurrentAction == "gridadd" || $t03_kelurahan->CurrentAction == "gridedit" || $t03_kelurahan->CurrentAction == "F")) {
		$t03_kelurahan_list->KeyCount = $objForm->GetValue($t03_kelurahan_list->FormKeyCountName);
		$t03_kelurahan_list->StopRec = $t03_kelurahan_list->StartRec + $t03_kelurahan_list->KeyCount - 1;
	}
}
$t03_kelurahan_list->RecCnt = $t03_kelurahan_list->StartRec - 1;
if ($t03_kelurahan_list->Recordset && !$t03_kelurahan_list->Recordset->EOF) {
	$t03_kelurahan_list->Recordset->MoveFirst();
	$bSelectLimit = $t03_kelurahan_list->UseSelectLimit;
	if (!$bSelectLimit && $t03_kelurahan_list->StartRec > 1)
		$t03_kelurahan_list->Recordset->Move($t03_kelurahan_list->StartRec - 1);
} elseif (!$t03_kelurahan->AllowAddDeleteRow && $t03_kelurahan_list->StopRec == 0) {
	$t03_kelurahan_list->StopRec = $t03_kelurahan->GridAddRowCount;
}

// Initialize aggregate
$t03_kelurahan->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t03_kelurahan->ResetAttrs();
$t03_kelurahan_list->RenderRow();
$t03_kelurahan_list->EditRowCnt = 0;
if ($t03_kelurahan->CurrentAction == "edit")
	$t03_kelurahan_list->RowIndex = 1;
if ($t03_kelurahan->CurrentAction == "gridadd")
	$t03_kelurahan_list->RowIndex = 0;
if ($t03_kelurahan->CurrentAction == "gridedit")
	$t03_kelurahan_list->RowIndex = 0;
while ($t03_kelurahan_list->RecCnt < $t03_kelurahan_list->StopRec) {
	$t03_kelurahan_list->RecCnt++;
	if (intval($t03_kelurahan_list->RecCnt) >= intval($t03_kelurahan_list->StartRec)) {
		$t03_kelurahan_list->RowCnt++;
		if ($t03_kelurahan->CurrentAction == "gridadd" || $t03_kelurahan->CurrentAction == "gridedit" || $t03_kelurahan->CurrentAction == "F") {
			$t03_kelurahan_list->RowIndex++;
			$objForm->Index = $t03_kelurahan_list->RowIndex;
			if ($objForm->HasValue($t03_kelurahan_list->FormActionName))
				$t03_kelurahan_list->RowAction = strval($objForm->GetValue($t03_kelurahan_list->FormActionName));
			elseif ($t03_kelurahan->CurrentAction == "gridadd")
				$t03_kelurahan_list->RowAction = "insert";
			else
				$t03_kelurahan_list->RowAction = "";
		}

		// Set up key count
		$t03_kelurahan_list->KeyCount = $t03_kelurahan_list->RowIndex;

		// Init row class and style
		$t03_kelurahan->ResetAttrs();
		$t03_kelurahan->CssClass = "";
		if ($t03_kelurahan->CurrentAction == "gridadd") {
			$t03_kelurahan_list->LoadDefaultValues(); // Load default values
		} else {
			$t03_kelurahan_list->LoadRowValues($t03_kelurahan_list->Recordset); // Load row values
		}
		$t03_kelurahan->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($t03_kelurahan->CurrentAction == "gridadd") // Grid add
			$t03_kelurahan->RowType = EW_ROWTYPE_ADD; // Render add
		if ($t03_kelurahan->CurrentAction == "gridadd" && $t03_kelurahan->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$t03_kelurahan_list->RestoreCurrentRowFormValues($t03_kelurahan_list->RowIndex); // Restore form values
		if ($t03_kelurahan->CurrentAction == "edit") {
			if ($t03_kelurahan_list->CheckInlineEditKey() && $t03_kelurahan_list->EditRowCnt == 0) { // Inline edit
				$t03_kelurahan->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($t03_kelurahan->CurrentAction == "gridedit") { // Grid edit
			if ($t03_kelurahan->EventCancelled) {
				$t03_kelurahan_list->RestoreCurrentRowFormValues($t03_kelurahan_list->RowIndex); // Restore form values
			}
			if ($t03_kelurahan_list->RowAction == "insert")
				$t03_kelurahan->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$t03_kelurahan->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($t03_kelurahan->CurrentAction == "edit" && $t03_kelurahan->RowType == EW_ROWTYPE_EDIT && $t03_kelurahan->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$t03_kelurahan_list->RestoreFormValues(); // Restore form values
		}
		if ($t03_kelurahan->CurrentAction == "gridedit" && ($t03_kelurahan->RowType == EW_ROWTYPE_EDIT || $t03_kelurahan->RowType == EW_ROWTYPE_ADD) && $t03_kelurahan->EventCancelled) // Update failed
			$t03_kelurahan_list->RestoreCurrentRowFormValues($t03_kelurahan_list->RowIndex); // Restore form values
		if ($t03_kelurahan->RowType == EW_ROWTYPE_EDIT) // Edit row
			$t03_kelurahan_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$t03_kelurahan->RowAttrs = array_merge($t03_kelurahan->RowAttrs, array('data-rowindex'=>$t03_kelurahan_list->RowCnt, 'id'=>'r' . $t03_kelurahan_list->RowCnt . '_t03_kelurahan', 'data-rowtype'=>$t03_kelurahan->RowType));

		// Render row
		$t03_kelurahan_list->RenderRow();

		// Render list options
		$t03_kelurahan_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($t03_kelurahan_list->RowAction <> "delete" && $t03_kelurahan_list->RowAction <> "insertdelete" && !($t03_kelurahan_list->RowAction == "insert" && $t03_kelurahan->CurrentAction == "F" && $t03_kelurahan_list->EmptyRow())) {
?>
	<tr<?php echo $t03_kelurahan->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t03_kelurahan_list->ListOptions->Render("body", "left", $t03_kelurahan_list->RowCnt);
?>
	<?php if ($t03_kelurahan->provinsi_id->Visible) { // provinsi_id ?>
		<td data-name="provinsi_id"<?php echo $t03_kelurahan->provinsi_id->CellAttributes() ?>>
<?php if ($t03_kelurahan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t03_kelurahan_list->RowCnt ?>_t03_kelurahan_provinsi_id" class="form-group t03_kelurahan_provinsi_id">
<?php $t03_kelurahan->provinsi_id->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$t03_kelurahan->provinsi_id->EditAttrs["onchange"]; ?>
<select data-table="t03_kelurahan" data-field="x_provinsi_id" data-value-separator="<?php echo $t03_kelurahan->provinsi_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t03_kelurahan_list->RowIndex ?>_provinsi_id" name="x<?php echo $t03_kelurahan_list->RowIndex ?>_provinsi_id"<?php echo $t03_kelurahan->provinsi_id->EditAttributes() ?>>
<?php echo $t03_kelurahan->provinsi_id->SelectOptionListHtml("x<?php echo $t03_kelurahan_list->RowIndex ?>_provinsi_id") ?>
</select>
<input type="hidden" name="s_x<?php echo $t03_kelurahan_list->RowIndex ?>_provinsi_id" id="s_x<?php echo $t03_kelurahan_list->RowIndex ?>_provinsi_id" value="<?php echo $t03_kelurahan->provinsi_id->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="t03_kelurahan" data-field="x_provinsi_id" name="o<?php echo $t03_kelurahan_list->RowIndex ?>_provinsi_id" id="o<?php echo $t03_kelurahan_list->RowIndex ?>_provinsi_id" value="<?php echo ew_HtmlEncode($t03_kelurahan->provinsi_id->OldValue) ?>">
<?php } ?>
<?php if ($t03_kelurahan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t03_kelurahan_list->RowCnt ?>_t03_kelurahan_provinsi_id" class="form-group t03_kelurahan_provinsi_id">
<?php $t03_kelurahan->provinsi_id->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$t03_kelurahan->provinsi_id->EditAttrs["onchange"]; ?>
<select data-table="t03_kelurahan" data-field="x_provinsi_id" data-value-separator="<?php echo $t03_kelurahan->provinsi_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t03_kelurahan_list->RowIndex ?>_provinsi_id" name="x<?php echo $t03_kelurahan_list->RowIndex ?>_provinsi_id"<?php echo $t03_kelurahan->provinsi_id->EditAttributes() ?>>
<?php echo $t03_kelurahan->provinsi_id->SelectOptionListHtml("x<?php echo $t03_kelurahan_list->RowIndex ?>_provinsi_id") ?>
</select>
<input type="hidden" name="s_x<?php echo $t03_kelurahan_list->RowIndex ?>_provinsi_id" id="s_x<?php echo $t03_kelurahan_list->RowIndex ?>_provinsi_id" value="<?php echo $t03_kelurahan->provinsi_id->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($t03_kelurahan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t03_kelurahan_list->RowCnt ?>_t03_kelurahan_provinsi_id" class="t03_kelurahan_provinsi_id">
<span<?php echo $t03_kelurahan->provinsi_id->ViewAttributes() ?>>
<?php echo $t03_kelurahan->provinsi_id->ListViewValue() ?></span>
</span>
<?php } ?>
<a id="<?php echo $t03_kelurahan_list->PageObjName . "_row_" . $t03_kelurahan_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($t03_kelurahan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="t03_kelurahan" data-field="x_id" name="x<?php echo $t03_kelurahan_list->RowIndex ?>_id" id="x<?php echo $t03_kelurahan_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t03_kelurahan->id->CurrentValue) ?>">
<input type="hidden" data-table="t03_kelurahan" data-field="x_id" name="o<?php echo $t03_kelurahan_list->RowIndex ?>_id" id="o<?php echo $t03_kelurahan_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t03_kelurahan->id->OldValue) ?>">
<?php } ?>
<?php if ($t03_kelurahan->RowType == EW_ROWTYPE_EDIT || $t03_kelurahan->CurrentMode == "edit") { ?>
<input type="hidden" data-table="t03_kelurahan" data-field="x_id" name="x<?php echo $t03_kelurahan_list->RowIndex ?>_id" id="x<?php echo $t03_kelurahan_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t03_kelurahan->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($t03_kelurahan->kabupatenkota_id->Visible) { // kabupatenkota_id ?>
		<td data-name="kabupatenkota_id"<?php echo $t03_kelurahan->kabupatenkota_id->CellAttributes() ?>>
<?php if ($t03_kelurahan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t03_kelurahan_list->RowCnt ?>_t03_kelurahan_kabupatenkota_id" class="form-group t03_kelurahan_kabupatenkota_id">
<?php $t03_kelurahan->kabupatenkota_id->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$t03_kelurahan->kabupatenkota_id->EditAttrs["onchange"]; ?>
<select data-table="t03_kelurahan" data-field="x_kabupatenkota_id" data-value-separator="<?php echo $t03_kelurahan->kabupatenkota_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t03_kelurahan_list->RowIndex ?>_kabupatenkota_id" name="x<?php echo $t03_kelurahan_list->RowIndex ?>_kabupatenkota_id"<?php echo $t03_kelurahan->kabupatenkota_id->EditAttributes() ?>>
<?php echo $t03_kelurahan->kabupatenkota_id->SelectOptionListHtml("x<?php echo $t03_kelurahan_list->RowIndex ?>_kabupatenkota_id") ?>
</select>
<input type="hidden" name="s_x<?php echo $t03_kelurahan_list->RowIndex ?>_kabupatenkota_id" id="s_x<?php echo $t03_kelurahan_list->RowIndex ?>_kabupatenkota_id" value="<?php echo $t03_kelurahan->kabupatenkota_id->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="t03_kelurahan" data-field="x_kabupatenkota_id" name="o<?php echo $t03_kelurahan_list->RowIndex ?>_kabupatenkota_id" id="o<?php echo $t03_kelurahan_list->RowIndex ?>_kabupatenkota_id" value="<?php echo ew_HtmlEncode($t03_kelurahan->kabupatenkota_id->OldValue) ?>">
<?php } ?>
<?php if ($t03_kelurahan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t03_kelurahan_list->RowCnt ?>_t03_kelurahan_kabupatenkota_id" class="form-group t03_kelurahan_kabupatenkota_id">
<?php $t03_kelurahan->kabupatenkota_id->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$t03_kelurahan->kabupatenkota_id->EditAttrs["onchange"]; ?>
<select data-table="t03_kelurahan" data-field="x_kabupatenkota_id" data-value-separator="<?php echo $t03_kelurahan->kabupatenkota_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t03_kelurahan_list->RowIndex ?>_kabupatenkota_id" name="x<?php echo $t03_kelurahan_list->RowIndex ?>_kabupatenkota_id"<?php echo $t03_kelurahan->kabupatenkota_id->EditAttributes() ?>>
<?php echo $t03_kelurahan->kabupatenkota_id->SelectOptionListHtml("x<?php echo $t03_kelurahan_list->RowIndex ?>_kabupatenkota_id") ?>
</select>
<input type="hidden" name="s_x<?php echo $t03_kelurahan_list->RowIndex ?>_kabupatenkota_id" id="s_x<?php echo $t03_kelurahan_list->RowIndex ?>_kabupatenkota_id" value="<?php echo $t03_kelurahan->kabupatenkota_id->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($t03_kelurahan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t03_kelurahan_list->RowCnt ?>_t03_kelurahan_kabupatenkota_id" class="t03_kelurahan_kabupatenkota_id">
<span<?php echo $t03_kelurahan->kabupatenkota_id->ViewAttributes() ?>>
<?php echo $t03_kelurahan->kabupatenkota_id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t03_kelurahan->kecamatan_id->Visible) { // kecamatan_id ?>
		<td data-name="kecamatan_id"<?php echo $t03_kelurahan->kecamatan_id->CellAttributes() ?>>
<?php if ($t03_kelurahan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t03_kelurahan_list->RowCnt ?>_t03_kelurahan_kecamatan_id" class="form-group t03_kelurahan_kecamatan_id">
<select data-table="t03_kelurahan" data-field="x_kecamatan_id" data-value-separator="<?php echo $t03_kelurahan->kecamatan_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t03_kelurahan_list->RowIndex ?>_kecamatan_id" name="x<?php echo $t03_kelurahan_list->RowIndex ?>_kecamatan_id"<?php echo $t03_kelurahan->kecamatan_id->EditAttributes() ?>>
<?php echo $t03_kelurahan->kecamatan_id->SelectOptionListHtml("x<?php echo $t03_kelurahan_list->RowIndex ?>_kecamatan_id") ?>
</select>
<input type="hidden" name="s_x<?php echo $t03_kelurahan_list->RowIndex ?>_kecamatan_id" id="s_x<?php echo $t03_kelurahan_list->RowIndex ?>_kecamatan_id" value="<?php echo $t03_kelurahan->kecamatan_id->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="t03_kelurahan" data-field="x_kecamatan_id" name="o<?php echo $t03_kelurahan_list->RowIndex ?>_kecamatan_id" id="o<?php echo $t03_kelurahan_list->RowIndex ?>_kecamatan_id" value="<?php echo ew_HtmlEncode($t03_kelurahan->kecamatan_id->OldValue) ?>">
<?php } ?>
<?php if ($t03_kelurahan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t03_kelurahan_list->RowCnt ?>_t03_kelurahan_kecamatan_id" class="form-group t03_kelurahan_kecamatan_id">
<select data-table="t03_kelurahan" data-field="x_kecamatan_id" data-value-separator="<?php echo $t03_kelurahan->kecamatan_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t03_kelurahan_list->RowIndex ?>_kecamatan_id" name="x<?php echo $t03_kelurahan_list->RowIndex ?>_kecamatan_id"<?php echo $t03_kelurahan->kecamatan_id->EditAttributes() ?>>
<?php echo $t03_kelurahan->kecamatan_id->SelectOptionListHtml("x<?php echo $t03_kelurahan_list->RowIndex ?>_kecamatan_id") ?>
</select>
<input type="hidden" name="s_x<?php echo $t03_kelurahan_list->RowIndex ?>_kecamatan_id" id="s_x<?php echo $t03_kelurahan_list->RowIndex ?>_kecamatan_id" value="<?php echo $t03_kelurahan->kecamatan_id->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($t03_kelurahan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t03_kelurahan_list->RowCnt ?>_t03_kelurahan_kecamatan_id" class="t03_kelurahan_kecamatan_id">
<span<?php echo $t03_kelurahan->kecamatan_id->ViewAttributes() ?>>
<?php echo $t03_kelurahan->kecamatan_id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t03_kelurahan->Nama->Visible) { // Nama ?>
		<td data-name="Nama"<?php echo $t03_kelurahan->Nama->CellAttributes() ?>>
<?php if ($t03_kelurahan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t03_kelurahan_list->RowCnt ?>_t03_kelurahan_Nama" class="form-group t03_kelurahan_Nama">
<input type="text" data-table="t03_kelurahan" data-field="x_Nama" name="x<?php echo $t03_kelurahan_list->RowIndex ?>_Nama" id="x<?php echo $t03_kelurahan_list->RowIndex ?>_Nama" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t03_kelurahan->Nama->getPlaceHolder()) ?>" value="<?php echo $t03_kelurahan->Nama->EditValue ?>"<?php echo $t03_kelurahan->Nama->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_kelurahan" data-field="x_Nama" name="o<?php echo $t03_kelurahan_list->RowIndex ?>_Nama" id="o<?php echo $t03_kelurahan_list->RowIndex ?>_Nama" value="<?php echo ew_HtmlEncode($t03_kelurahan->Nama->OldValue) ?>">
<?php } ?>
<?php if ($t03_kelurahan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t03_kelurahan_list->RowCnt ?>_t03_kelurahan_Nama" class="form-group t03_kelurahan_Nama">
<input type="text" data-table="t03_kelurahan" data-field="x_Nama" name="x<?php echo $t03_kelurahan_list->RowIndex ?>_Nama" id="x<?php echo $t03_kelurahan_list->RowIndex ?>_Nama" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t03_kelurahan->Nama->getPlaceHolder()) ?>" value="<?php echo $t03_kelurahan->Nama->EditValue ?>"<?php echo $t03_kelurahan->Nama->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t03_kelurahan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t03_kelurahan_list->RowCnt ?>_t03_kelurahan_Nama" class="t03_kelurahan_Nama">
<span<?php echo $t03_kelurahan->Nama->ViewAttributes() ?>>
<?php echo $t03_kelurahan->Nama->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t03_kelurahan_list->ListOptions->Render("body", "right", $t03_kelurahan_list->RowCnt);
?>
	</tr>
<?php if ($t03_kelurahan->RowType == EW_ROWTYPE_ADD || $t03_kelurahan->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ft03_kelurahanlist.UpdateOpts(<?php echo $t03_kelurahan_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($t03_kelurahan->CurrentAction <> "gridadd")
		if (!$t03_kelurahan_list->Recordset->EOF) $t03_kelurahan_list->Recordset->MoveNext();
}
?>
<?php
	if ($t03_kelurahan->CurrentAction == "gridadd" || $t03_kelurahan->CurrentAction == "gridedit") {
		$t03_kelurahan_list->RowIndex = '$rowindex$';
		$t03_kelurahan_list->LoadDefaultValues();

		// Set row properties
		$t03_kelurahan->ResetAttrs();
		$t03_kelurahan->RowAttrs = array_merge($t03_kelurahan->RowAttrs, array('data-rowindex'=>$t03_kelurahan_list->RowIndex, 'id'=>'r0_t03_kelurahan', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($t03_kelurahan->RowAttrs["class"], "ewTemplate");
		$t03_kelurahan->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t03_kelurahan_list->RenderRow();

		// Render list options
		$t03_kelurahan_list->RenderListOptions();
		$t03_kelurahan_list->StartRowCnt = 0;
?>
	<tr<?php echo $t03_kelurahan->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t03_kelurahan_list->ListOptions->Render("body", "left", $t03_kelurahan_list->RowIndex);
?>
	<?php if ($t03_kelurahan->provinsi_id->Visible) { // provinsi_id ?>
		<td data-name="provinsi_id">
<span id="el$rowindex$_t03_kelurahan_provinsi_id" class="form-group t03_kelurahan_provinsi_id">
<?php $t03_kelurahan->provinsi_id->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$t03_kelurahan->provinsi_id->EditAttrs["onchange"]; ?>
<select data-table="t03_kelurahan" data-field="x_provinsi_id" data-value-separator="<?php echo $t03_kelurahan->provinsi_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t03_kelurahan_list->RowIndex ?>_provinsi_id" name="x<?php echo $t03_kelurahan_list->RowIndex ?>_provinsi_id"<?php echo $t03_kelurahan->provinsi_id->EditAttributes() ?>>
<?php echo $t03_kelurahan->provinsi_id->SelectOptionListHtml("x<?php echo $t03_kelurahan_list->RowIndex ?>_provinsi_id") ?>
</select>
<input type="hidden" name="s_x<?php echo $t03_kelurahan_list->RowIndex ?>_provinsi_id" id="s_x<?php echo $t03_kelurahan_list->RowIndex ?>_provinsi_id" value="<?php echo $t03_kelurahan->provinsi_id->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="t03_kelurahan" data-field="x_provinsi_id" name="o<?php echo $t03_kelurahan_list->RowIndex ?>_provinsi_id" id="o<?php echo $t03_kelurahan_list->RowIndex ?>_provinsi_id" value="<?php echo ew_HtmlEncode($t03_kelurahan->provinsi_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t03_kelurahan->kabupatenkota_id->Visible) { // kabupatenkota_id ?>
		<td data-name="kabupatenkota_id">
<span id="el$rowindex$_t03_kelurahan_kabupatenkota_id" class="form-group t03_kelurahan_kabupatenkota_id">
<?php $t03_kelurahan->kabupatenkota_id->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$t03_kelurahan->kabupatenkota_id->EditAttrs["onchange"]; ?>
<select data-table="t03_kelurahan" data-field="x_kabupatenkota_id" data-value-separator="<?php echo $t03_kelurahan->kabupatenkota_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t03_kelurahan_list->RowIndex ?>_kabupatenkota_id" name="x<?php echo $t03_kelurahan_list->RowIndex ?>_kabupatenkota_id"<?php echo $t03_kelurahan->kabupatenkota_id->EditAttributes() ?>>
<?php echo $t03_kelurahan->kabupatenkota_id->SelectOptionListHtml("x<?php echo $t03_kelurahan_list->RowIndex ?>_kabupatenkota_id") ?>
</select>
<input type="hidden" name="s_x<?php echo $t03_kelurahan_list->RowIndex ?>_kabupatenkota_id" id="s_x<?php echo $t03_kelurahan_list->RowIndex ?>_kabupatenkota_id" value="<?php echo $t03_kelurahan->kabupatenkota_id->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="t03_kelurahan" data-field="x_kabupatenkota_id" name="o<?php echo $t03_kelurahan_list->RowIndex ?>_kabupatenkota_id" id="o<?php echo $t03_kelurahan_list->RowIndex ?>_kabupatenkota_id" value="<?php echo ew_HtmlEncode($t03_kelurahan->kabupatenkota_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t03_kelurahan->kecamatan_id->Visible) { // kecamatan_id ?>
		<td data-name="kecamatan_id">
<span id="el$rowindex$_t03_kelurahan_kecamatan_id" class="form-group t03_kelurahan_kecamatan_id">
<select data-table="t03_kelurahan" data-field="x_kecamatan_id" data-value-separator="<?php echo $t03_kelurahan->kecamatan_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t03_kelurahan_list->RowIndex ?>_kecamatan_id" name="x<?php echo $t03_kelurahan_list->RowIndex ?>_kecamatan_id"<?php echo $t03_kelurahan->kecamatan_id->EditAttributes() ?>>
<?php echo $t03_kelurahan->kecamatan_id->SelectOptionListHtml("x<?php echo $t03_kelurahan_list->RowIndex ?>_kecamatan_id") ?>
</select>
<input type="hidden" name="s_x<?php echo $t03_kelurahan_list->RowIndex ?>_kecamatan_id" id="s_x<?php echo $t03_kelurahan_list->RowIndex ?>_kecamatan_id" value="<?php echo $t03_kelurahan->kecamatan_id->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="t03_kelurahan" data-field="x_kecamatan_id" name="o<?php echo $t03_kelurahan_list->RowIndex ?>_kecamatan_id" id="o<?php echo $t03_kelurahan_list->RowIndex ?>_kecamatan_id" value="<?php echo ew_HtmlEncode($t03_kelurahan->kecamatan_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t03_kelurahan->Nama->Visible) { // Nama ?>
		<td data-name="Nama">
<span id="el$rowindex$_t03_kelurahan_Nama" class="form-group t03_kelurahan_Nama">
<input type="text" data-table="t03_kelurahan" data-field="x_Nama" name="x<?php echo $t03_kelurahan_list->RowIndex ?>_Nama" id="x<?php echo $t03_kelurahan_list->RowIndex ?>_Nama" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t03_kelurahan->Nama->getPlaceHolder()) ?>" value="<?php echo $t03_kelurahan->Nama->EditValue ?>"<?php echo $t03_kelurahan->Nama->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_kelurahan" data-field="x_Nama" name="o<?php echo $t03_kelurahan_list->RowIndex ?>_Nama" id="o<?php echo $t03_kelurahan_list->RowIndex ?>_Nama" value="<?php echo ew_HtmlEncode($t03_kelurahan->Nama->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t03_kelurahan_list->ListOptions->Render("body", "right", $t03_kelurahan_list->RowCnt);
?>
<script type="text/javascript">
ft03_kelurahanlist.UpdateOpts(<?php echo $t03_kelurahan_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($t03_kelurahan->CurrentAction == "add" || $t03_kelurahan->CurrentAction == "copy") { ?>
<input type="hidden" name="<?php echo $t03_kelurahan_list->FormKeyCountName ?>" id="<?php echo $t03_kelurahan_list->FormKeyCountName ?>" value="<?php echo $t03_kelurahan_list->KeyCount ?>">
<?php } ?>
<?php if ($t03_kelurahan->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $t03_kelurahan_list->FormKeyCountName ?>" id="<?php echo $t03_kelurahan_list->FormKeyCountName ?>" value="<?php echo $t03_kelurahan_list->KeyCount ?>">
<?php echo $t03_kelurahan_list->MultiSelectKey ?>
<?php } ?>
<?php if ($t03_kelurahan->CurrentAction == "edit") { ?>
<input type="hidden" name="<?php echo $t03_kelurahan_list->FormKeyCountName ?>" id="<?php echo $t03_kelurahan_list->FormKeyCountName ?>" value="<?php echo $t03_kelurahan_list->KeyCount ?>">
<?php } ?>
<?php if ($t03_kelurahan->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $t03_kelurahan_list->FormKeyCountName ?>" id="<?php echo $t03_kelurahan_list->FormKeyCountName ?>" value="<?php echo $t03_kelurahan_list->KeyCount ?>">
<?php echo $t03_kelurahan_list->MultiSelectKey ?>
<?php } ?>
<?php if ($t03_kelurahan->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($t03_kelurahan_list->Recordset)
	$t03_kelurahan_list->Recordset->Close();
?>
<?php if ($t03_kelurahan->Export == "") { ?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($t03_kelurahan->CurrentAction <> "gridadd" && $t03_kelurahan->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t03_kelurahan_list->Pager)) $t03_kelurahan_list->Pager = new cPrevNextPager($t03_kelurahan_list->StartRec, $t03_kelurahan_list->DisplayRecs, $t03_kelurahan_list->TotalRecs) ?>
<?php if ($t03_kelurahan_list->Pager->RecordCount > 0 && $t03_kelurahan_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t03_kelurahan_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t03_kelurahan_list->PageUrl() ?>start=<?php echo $t03_kelurahan_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t03_kelurahan_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t03_kelurahan_list->PageUrl() ?>start=<?php echo $t03_kelurahan_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t03_kelurahan_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t03_kelurahan_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t03_kelurahan_list->PageUrl() ?>start=<?php echo $t03_kelurahan_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t03_kelurahan_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t03_kelurahan_list->PageUrl() ?>start=<?php echo $t03_kelurahan_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t03_kelurahan_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $t03_kelurahan_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $t03_kelurahan_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $t03_kelurahan_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($t03_kelurahan_list->TotalRecs > 0 && (!EW_AUTO_HIDE_PAGE_SIZE_SELECTOR || $t03_kelurahan_list->Pager->Visible)) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="t03_kelurahan">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="10"<?php if ($t03_kelurahan_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($t03_kelurahan_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="25"<?php if ($t03_kelurahan_list->DisplayRecs == 25) { ?> selected<?php } ?>>25</option>
<option value="50"<?php if ($t03_kelurahan_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($t03_kelurahan_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="200"<?php if ($t03_kelurahan_list->DisplayRecs == 200) { ?> selected<?php } ?>>200</option>
<option value="500"<?php if ($t03_kelurahan_list->DisplayRecs == 500) { ?> selected<?php } ?>>500</option>
<option value="ALL"<?php if ($t03_kelurahan->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t03_kelurahan_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($t03_kelurahan_list->TotalRecs == 0 && $t03_kelurahan->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t03_kelurahan_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($t03_kelurahan->Export == "") { ?>
<script type="text/javascript">
ft03_kelurahanlistsrch.FilterList = <?php echo $t03_kelurahan_list->GetFilterList() ?>;
ft03_kelurahanlistsrch.Init();
ft03_kelurahanlist.Init();
</script>
<?php } ?>
<?php
$t03_kelurahan_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($t03_kelurahan->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$t03_kelurahan_list->Page_Terminate();
?>
