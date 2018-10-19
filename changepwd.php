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

$changepwd = NULL; // Initialize page object first

class cchangepwd extends ct96_employees {

	// Page ID
	var $PageID = 'changepwd';

	// Project ID
	var $ProjectID = "{78A0660C-C398-4292-A50E-2A3C7D765239}";

	// Page object name
	var $PageObjName = 'changepwd';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
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
		return TRUE;
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
		if (!isset($GLOBALS["t96_employees"])) $GLOBALS["t96_employees"] = &$this;

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'changepwd', TRUE);

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
		if (!IsPasswordReset()) {
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn() || $Security->IsSysAdmin())
			$this->Page_Terminate(ew_GetUrl("login.php"));
		$Security->LoadCurrentUserLevel($this->ProjectID . 't96_employees');
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

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
	var $OldPassword = "";
	var $NewPassword = "";
	var $ConfirmedPassword = "";

	// 
	// Page main
	//
	function Page_Main() {
		global $UserTableConn, $Language, $Security, $gsFormError;
		global $Breadcrumb;
		$Breadcrumb = new cBreadcrumb;
		$Breadcrumb->Add("changepwd", "ChangePwdPage", ew_CurrentUrl(), "", "", TRUE);
		$bPostBack = ew_IsHttpPost();
		$bValidate = TRUE;
		if ($bPostBack) {
			$this->OldPassword = ew_StripSlashes(@$_POST["opwd"]);
			$this->NewPassword = ew_StripSlashes(@$_POST["npwd"]);
			$this->ConfirmedPassword = ew_StripSlashes(@$_POST["cpwd"]);
			$bValidate = $this->ValidateForm($this->OldPassword, $this->NewPassword, $this->ConfirmedPassword);
			if (!$bValidate) {
				$this->setFailureMessage($gsFormError);
			}
		}
		$bPwdUpdated = FALSE;
		if ($bPostBack && $bValidate) {

			// Setup variables
			$sUsername = $Security->CurrentUserName();
			if (IsPasswordReset())
				$sUsername = $_SESSION[EW_SESSION_USER_PROFILE_USER_NAME];
			$sFilter = str_replace("%u", ew_AdjustSql($sUsername, EW_USER_TABLE_DBID), EW_USER_NAME_FILTER);

			// Set up filter (Sql Where Clause) and get Return SQL
			// SQL constructor in t96_employees class, t96_employeesinfo.php

			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			if ($rs = $UserTableConn->Execute($sSql)) {
				if (!$rs->EOF) {
					$rsold = $rs->fields;
					if (IsPasswordReset() || ew_ComparePassword($rsold['Password'], $this->OldPassword)) {
						$bValidPwd = TRUE;
						if (!IsPasswordReset())
							$bValidPwd = $this->User_ChangePassword($rsold, $sUsername, $this->OldPassword, $this->NewPassword);
						if ($bValidPwd) {
							$rsnew = array('Password' => $this->NewPassword); // Change Password
							$rs->Close();
							$UserTableConn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
							$bValidPwd = $this->Update($rsnew);
							$UserTableConn->raiseErrorFn = '';
							if ($bValidPwd)
								$bPwdUpdated = TRUE;
						} else {
							$this->setFailureMessage($Language->Phrase("InvalidNewPassword"));
							$rs->Close();
						}
					} else {
						$this->setFailureMessage($Language->Phrase("InvalidPassword"));
					}
				} else {
					$rs->Close();
				}
			}
		}
		if ($bPwdUpdated) {
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("PasswordChanged")); // Set up success message
			if (IsPasswordReset()) {
				$_SESSION[EW_SESSION_STATUS] = "";
				$_SESSION[EW_SESSION_USER_PROFILE_USER_NAME] = "";
			}
			$this->Page_Terminate("index.php"); // Exit page and clean up
		}
	}

	// Validate form
	function ValidateForm($opwd, $npwd, $cpwd) {
		global $Language, $gsFormError;

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;

		// Initialize form error message
		$gsFormError = "";
		if (!IsPasswordReset() && $opwd == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterOldPassword"));
		}
		if ($npwd == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterNewPassword"));
		}
		if ($npwd <> $cpwd) {
			ew_AddMessage($gsFormError, $Language->Phrase("MismatchPassword"));
		}

		// Return validate result
		$valid = ($gsFormError == "");

		// Call Form CustomValidate event
		$sFormCustomError = "";
		$valid = $valid && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $valid;
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

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}

	// User ChangePassword event
	function User_ChangePassword(&$rs, $usr, $oldpwd, &$newpwd) {

		// Return FALSE to abort
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($changepwd)) $changepwd = new cchangepwd();

// Page init
$changepwd->Page_Init();

// Page main
$changepwd->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$changepwd->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<script type="text/javascript">
var fchangepwd = new ew_Form("fchangepwd");

// Extend form with Validate function
fchangepwd.Validate = function() {
	var $ = jQuery, fobj = this.Form, $npwd = $(fobj.npwd);
	if (!this.ValidateRequired)
		return true; // Ignore validation
<?php if (!IsPasswordReset()) { ?>
	if (!ew_HasValue(fobj.opwd))
		return this.OnError(fobj.opwd, ewLanguage.Phrase("EnterOldPassword"));
<?php } ?>
	if (!ew_HasValue(fobj.npwd))
		return this.OnError(fobj.npwd, ewLanguage.Phrase("EnterNewPassword"));
	if ($npwd.hasClass("ewPasswordStrength") && !$npwd.data("validated"))
		return this.OnError(fobj.npwd, ewLanguage.Phrase("PasswordTooSimple"));
	if (fobj.npwd.value != fobj.cpwd.value)
		return this.OnError(fobj.cpwd, ewLanguage.Phrase("MismatchPassword"));

	// Call Form Custom Validate event
	if (!this.Form_CustomValidate(fobj)) return false;
	return true;
}

// Extend form with Form_CustomValidate function
fchangepwd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Requires js validation
<?php if (EW_CLIENT_VALIDATE) { ?>
fchangepwd.ValidateRequired = true;
<?php } else { ?>
fchangepwd.ValidateRequired = false;
<?php } ?>
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $changepwd->ShowPageHeader(); ?>
<?php
$changepwd->ShowMessage();
?>
<form name="fchangepwd" id="fchangepwd" class="form-horizontal ewForm ewChangepwdForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($changepwd->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $changepwd->Token ?>">
<?php } ?>
<!-- Fields to prevent google autofill -->
<input class="hidden" type="text" name="<?php echo ew_Encrypt(ew_Random()) ?>">
<input class="hidden" type="password" name="<?php echo ew_Encrypt(ew_Random()) ?>">
<?php if (!IsPasswordReset()) { ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel" for="opwd"><?php echo $Language->Phrase("OldPassword") ?></label>
		<div class="col-sm-10"><input type="password" name="opwd" id="opwd" class="form-control ewControl" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("OldPassword")) ?>"></div>
	</div>
<?php } ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel" for="npwd"><?php echo $Language->Phrase("NewPassword") ?></label>
		<div class="col-sm-10">
		<div class="input-group" id="ignpwd">
		<input type="password" data-password-strength="pst_npwd" data-password-generated="pgt_npwd" name="npwd" id="npwd" class="form-control ewControl ewPasswordStrength" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("NewPassword")) ?>">
		<span class="input-group-btn">
			<button type="button" class="btn btn-default ewPasswordGenerator" title="<?php echo ew_HtmlTitle($Language->Phrase("GeneratePassword")) ?>" data-password-field="npwd" data-password-confirm="cpwd" data-password-strength="pst_npwd" data-password-generated="pgt_npwd"><?php echo $Language->Phrase("GeneratePassword") ?></button>
		</span>
		</div>
		<span class="help-block" id="pgt_npwd" style="display: none;"></span>
		<div class="progress ewPasswordStrengthBar" id="pst_npwd" style="display: none;">
			<div class="progress-bar" role="progressbar"></div>
		</div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel" for="cpwd"><?php echo $Language->Phrase("ConfirmPassword") ?></label>
		<div class="col-sm-10">
		<input type="password" name="cpwd" id="cpwd" class="form-control ewControl" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("ConfirmPassword")) ?>">
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("ChangePwdBtn") ?></button>
		</div>
	</div>
</form>
<script type="text/javascript">
fchangepwd.Init();
</script>
<?php
$changepwd->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$changepwd->Page_Terminate();
?>
