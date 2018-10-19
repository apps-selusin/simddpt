<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "userfn13.php" ?>
<?php
ew_Header(FALSE);
$session = new cewsession;
$session->Page_Main();

//
// Page class for session
//
class cewsession {

	// Page ID
	var $PageID = "session";

	// Project ID
	var $ProjectID = "{78A0660C-C398-4292-A50E-2A3C7D765239}";

	// Page object name
	var $PageObjName = "session";

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		return ew_CurrentPage() . "?";
	}

	// Main
	// - Uncomment ** for database connectivity / Page_Loading / Page_Unloaded server event
	function Page_Main() {
		global $conn;
		$GLOBALS["Page"] = &$this;

		//**$conn = ew_Connect();
		// Global Page Loading event (in userfn*.php)
		//**Page_Loading();

		if (ob_get_length())
			ob_end_clean();
		$time = time();
		$_SESSION["EW_LAST_REFRESH_TIME"] = $time;
		echo ew_Encrypt($time);

		// Global Page Unloaded event (in userfn*.php)
		//**Page_Unloaded();
		 // Close connection
		//**ew_CloseConn();

	}
}
?>
