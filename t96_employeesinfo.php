<?php

// Global variable for table object
$t96_employees = NULL;

//
// Table class for t96_employees
//
class ct96_employees extends cTable {
	var $AuditTrailOnAdd = TRUE;
	var $AuditTrailOnEdit = TRUE;
	var $AuditTrailOnDelete = TRUE;
	var $AuditTrailOnView = FALSE;
	var $AuditTrailOnViewData = FALSE;
	var $AuditTrailOnSearch = FALSE;
	var $EmployeeID;
	var $LastName;
	var $FirstName;
	var $Title;
	var $TitleOfCourtesy;
	var $BirthDate;
	var $HireDate;
	var $Address;
	var $City;
	var $Region;
	var $PostalCode;
	var $Country;
	var $HomePhone;
	var $Extension;
	var $_Email;
	var $Photo;
	var $Notes;
	var $ReportsTo;
	var $Password;
	var $UserLevel;
	var $Username;
	var $Activated;
	var $Profile;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 't96_employees';
		$this->TableName = 't96_employees';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`t96_employees`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// EmployeeID
		$this->EmployeeID = new cField('t96_employees', 't96_employees', 'x_EmployeeID', 'EmployeeID', '`EmployeeID`', '`EmployeeID`', 3, -1, FALSE, '`EmployeeID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->EmployeeID->Sortable = TRUE; // Allow sort
		$this->EmployeeID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['EmployeeID'] = &$this->EmployeeID;

		// LastName
		$this->LastName = new cField('t96_employees', 't96_employees', 'x_LastName', 'LastName', '`LastName`', '`LastName`', 200, -1, FALSE, '`LastName`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->LastName->Sortable = TRUE; // Allow sort
		$this->fields['LastName'] = &$this->LastName;

		// FirstName
		$this->FirstName = new cField('t96_employees', 't96_employees', 'x_FirstName', 'FirstName', '`FirstName`', '`FirstName`', 200, -1, FALSE, '`FirstName`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->FirstName->Sortable = TRUE; // Allow sort
		$this->fields['FirstName'] = &$this->FirstName;

		// Title
		$this->Title = new cField('t96_employees', 't96_employees', 'x_Title', 'Title', '`Title`', '`Title`', 200, -1, FALSE, '`Title`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Title->Sortable = TRUE; // Allow sort
		$this->fields['Title'] = &$this->Title;

		// TitleOfCourtesy
		$this->TitleOfCourtesy = new cField('t96_employees', 't96_employees', 'x_TitleOfCourtesy', 'TitleOfCourtesy', '`TitleOfCourtesy`', '`TitleOfCourtesy`', 200, -1, FALSE, '`TitleOfCourtesy`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TitleOfCourtesy->Sortable = TRUE; // Allow sort
		$this->fields['TitleOfCourtesy'] = &$this->TitleOfCourtesy;

		// BirthDate
		$this->BirthDate = new cField('t96_employees', 't96_employees', 'x_BirthDate', 'BirthDate', '`BirthDate`', ew_CastDateFieldForLike('`BirthDate`', 0, "DB"), 135, 0, FALSE, '`BirthDate`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BirthDate->Sortable = TRUE; // Allow sort
		$this->BirthDate->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['BirthDate'] = &$this->BirthDate;

		// HireDate
		$this->HireDate = new cField('t96_employees', 't96_employees', 'x_HireDate', 'HireDate', '`HireDate`', ew_CastDateFieldForLike('`HireDate`', 0, "DB"), 135, 0, FALSE, '`HireDate`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->HireDate->Sortable = TRUE; // Allow sort
		$this->HireDate->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['HireDate'] = &$this->HireDate;

		// Address
		$this->Address = new cField('t96_employees', 't96_employees', 'x_Address', 'Address', '`Address`', '`Address`', 200, -1, FALSE, '`Address`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Address->Sortable = TRUE; // Allow sort
		$this->fields['Address'] = &$this->Address;

		// City
		$this->City = new cField('t96_employees', 't96_employees', 'x_City', 'City', '`City`', '`City`', 200, -1, FALSE, '`City`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->City->Sortable = TRUE; // Allow sort
		$this->fields['City'] = &$this->City;

		// Region
		$this->Region = new cField('t96_employees', 't96_employees', 'x_Region', 'Region', '`Region`', '`Region`', 200, -1, FALSE, '`Region`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Region->Sortable = TRUE; // Allow sort
		$this->fields['Region'] = &$this->Region;

		// PostalCode
		$this->PostalCode = new cField('t96_employees', 't96_employees', 'x_PostalCode', 'PostalCode', '`PostalCode`', '`PostalCode`', 200, -1, FALSE, '`PostalCode`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PostalCode->Sortable = TRUE; // Allow sort
		$this->fields['PostalCode'] = &$this->PostalCode;

		// Country
		$this->Country = new cField('t96_employees', 't96_employees', 'x_Country', 'Country', '`Country`', '`Country`', 200, -1, FALSE, '`Country`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Country->Sortable = TRUE; // Allow sort
		$this->fields['Country'] = &$this->Country;

		// HomePhone
		$this->HomePhone = new cField('t96_employees', 't96_employees', 'x_HomePhone', 'HomePhone', '`HomePhone`', '`HomePhone`', 200, -1, FALSE, '`HomePhone`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->HomePhone->Sortable = TRUE; // Allow sort
		$this->fields['HomePhone'] = &$this->HomePhone;

		// Extension
		$this->Extension = new cField('t96_employees', 't96_employees', 'x_Extension', 'Extension', '`Extension`', '`Extension`', 200, -1, FALSE, '`Extension`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Extension->Sortable = TRUE; // Allow sort
		$this->fields['Extension'] = &$this->Extension;

		// Email
		$this->_Email = new cField('t96_employees', 't96_employees', 'x__Email', 'Email', '`Email`', '`Email`', 200, -1, FALSE, '`Email`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->_Email->Sortable = TRUE; // Allow sort
		$this->fields['Email'] = &$this->_Email;

		// Photo
		$this->Photo = new cField('t96_employees', 't96_employees', 'x_Photo', 'Photo', '`Photo`', '`Photo`', 200, -1, FALSE, '`Photo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Photo->Sortable = TRUE; // Allow sort
		$this->fields['Photo'] = &$this->Photo;

		// Notes
		$this->Notes = new cField('t96_employees', 't96_employees', 'x_Notes', 'Notes', '`Notes`', '`Notes`', 201, -1, FALSE, '`Notes`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Notes->Sortable = TRUE; // Allow sort
		$this->fields['Notes'] = &$this->Notes;

		// ReportsTo
		$this->ReportsTo = new cField('t96_employees', 't96_employees', 'x_ReportsTo', 'ReportsTo', '`ReportsTo`', '`ReportsTo`', 3, -1, FALSE, '`ReportsTo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ReportsTo->Sortable = TRUE; // Allow sort
		$this->ReportsTo->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['ReportsTo'] = &$this->ReportsTo;

		// Password
		$this->Password = new cField('t96_employees', 't96_employees', 'x_Password', 'Password', '`Password`', '`Password`', 200, -1, FALSE, '`Password`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Password->Sortable = TRUE; // Allow sort
		$this->fields['Password'] = &$this->Password;

		// UserLevel
		$this->UserLevel = new cField('t96_employees', 't96_employees', 'x_UserLevel', 'UserLevel', '`UserLevel`', '`UserLevel`', 3, -1, FALSE, '`UserLevel`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->UserLevel->Sortable = TRUE; // Allow sort
		$this->UserLevel->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->UserLevel->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->UserLevel->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['UserLevel'] = &$this->UserLevel;

		// Username
		$this->Username = new cField('t96_employees', 't96_employees', 'x_Username', 'Username', '`Username`', '`Username`', 200, -1, FALSE, '`Username`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Username->Sortable = TRUE; // Allow sort
		$this->fields['Username'] = &$this->Username;

		// Activated
		$this->Activated = new cField('t96_employees', 't96_employees', 'x_Activated', 'Activated', '`Activated`', '`Activated`', 202, -1, FALSE, '`Activated`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Activated->Sortable = TRUE; // Allow sort
		$this->Activated->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Activated->TrueValue = 'Y';
		$this->Activated->FalseValue = 'N';
		$this->Activated->OptionCount = 2;
		$this->fields['Activated'] = &$this->Activated;

		// Profile
		$this->Profile = new cField('t96_employees', 't96_employees', 'x_Profile', 'Profile', '`Profile`', '`Profile`', 201, -1, FALSE, '`Profile`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Profile->Sortable = TRUE; // Allow sort
		$this->fields['Profile'] = &$this->Profile;
	}

	// Set Field Visibility
	function SetFieldVisibility($fldparm) {
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
	}

	// Multiple column sort
	function UpdateSort(&$ofld, $ctrl) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			if ($ctrl) {
				$sOrderBy = $this->getSessionOrderBy();
				if (strpos($sOrderBy, $sSortField . " " . $sLastSort) !== FALSE) {
					$sOrderBy = str_replace($sSortField . " " . $sLastSort, $sSortField . " " . $sThisSort, $sOrderBy);
				} else {
					if ($sOrderBy <> "") $sOrderBy .= ", ";
					$sOrderBy .= $sSortField . " " . $sThisSort;
				}
				$this->setSessionOrderBy($sOrderBy); // Save to Session
			} else {
				$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
			}
		} else {
			if (!$ctrl) $ofld->setSort("");
		}
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`t96_employees`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		global $Security;

		// Add User ID filter
		if ($Security->CurrentUserID() <> "" && !$Security->IsAdmin()) { // Non system admin
			$sFilter = $this->AddUserIDFilter($sFilter);
		}
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = $this->UserIDAllowSecurity;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		$cnt = -1;
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match("/^SELECT \* FROM/i", $sSql)) {
			$sSql = "SELECT COUNT(*) FROM" . preg_replace('/^SELECT\s([\s\S]+)?\*\sFROM/i', "", $sSql);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
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

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
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
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			if (EW_ENCRYPTED_PASSWORD && $name == 'Password')
				$value = (EW_CASE_SENSITIVE_PASSWORD) ? ew_EncryptPassword($value) : ew_EncryptPassword(strtolower($value));
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		$bInsert = $conn->Execute($this->InsertSQL($rs));
		if ($bInsert) {

			// Get insert id if necessary
			$this->EmployeeID->setDbValue($conn->Insert_ID());
			$rs['EmployeeID'] = $this->EmployeeID->DbValue;
			if ($this->AuditTrailOnAdd)
				$this->WriteAuditTrailOnAdd($rs);
		}
		return $bInsert;
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			if (EW_ENCRYPTED_PASSWORD && $name == 'Password') {
				$value = (EW_CASE_SENSITIVE_PASSWORD) ? ew_EncryptPassword($value) : ew_EncryptPassword(strtolower($value));
			}
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		$bUpdate = $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
		if ($bUpdate && $this->AuditTrailOnEdit) {
			$rsaudit = $rs;
			$fldname = 'EmployeeID';
			if (!array_key_exists($fldname, $rsaudit)) $rsaudit[$fldname] = $rsold[$fldname];
			$this->WriteAuditTrailOnEdit($rsold, $rsaudit);
		}
		return $bUpdate;
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('EmployeeID', $rs))
				ew_AddFilter($where, ew_QuotedName('EmployeeID', $this->DBID) . '=' . ew_QuotedValue($rs['EmployeeID'], $this->EmployeeID->FldDataType, $this->DBID));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$conn = &$this->Connection();
		$bDelete = $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
		if ($bDelete && $this->AuditTrailOnDelete)
			$this->WriteAuditTrailOnDelete($rs);
		return $bDelete;
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`EmployeeID` = @EmployeeID@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->EmployeeID->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@EmployeeID@", ew_AdjustSql($this->EmployeeID->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "t96_employeeslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "t96_employeeslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("t96_employeesview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("t96_employeesview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "t96_employeesadd.php?" . $this->UrlParm($parm);
		else
			$url = "t96_employeesadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("t96_employeesedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("t96_employeesadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("t96_employeesdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "EmployeeID:" . ew_VarToJson($this->EmployeeID->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->EmployeeID->CurrentValue)) {
			$sUrl .= "EmployeeID=" . urlencode($this->EmployeeID->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return $this->AddMasterUrl(ew_CurrentPage() . "?" . $sUrlParm);
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsHttpPost();
			if ($isPost && isset($_POST["EmployeeID"]))
				$arKeys[] = ew_StripSlashes($_POST["EmployeeID"]);
			elseif (isset($_GET["EmployeeID"]))
				$arKeys[] = ew_StripSlashes($_GET["EmployeeID"]);
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
					continue;
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->EmployeeID->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
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

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
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

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// EmployeeID
		$this->EmployeeID->EditAttrs["class"] = "form-control";
		$this->EmployeeID->EditCustomAttributes = "";
		$this->EmployeeID->EditValue = $this->EmployeeID->CurrentValue;
		$this->EmployeeID->ViewCustomAttributes = "";

		// LastName
		$this->LastName->EditAttrs["class"] = "form-control";
		$this->LastName->EditCustomAttributes = "";
		$this->LastName->EditValue = $this->LastName->CurrentValue;
		$this->LastName->PlaceHolder = ew_RemoveHtml($this->LastName->FldCaption());

		// FirstName
		$this->FirstName->EditAttrs["class"] = "form-control";
		$this->FirstName->EditCustomAttributes = "";
		$this->FirstName->EditValue = $this->FirstName->CurrentValue;
		$this->FirstName->PlaceHolder = ew_RemoveHtml($this->FirstName->FldCaption());

		// Title
		$this->Title->EditAttrs["class"] = "form-control";
		$this->Title->EditCustomAttributes = "";
		$this->Title->EditValue = $this->Title->CurrentValue;
		$this->Title->PlaceHolder = ew_RemoveHtml($this->Title->FldCaption());

		// TitleOfCourtesy
		$this->TitleOfCourtesy->EditAttrs["class"] = "form-control";
		$this->TitleOfCourtesy->EditCustomAttributes = "";
		$this->TitleOfCourtesy->EditValue = $this->TitleOfCourtesy->CurrentValue;
		$this->TitleOfCourtesy->PlaceHolder = ew_RemoveHtml($this->TitleOfCourtesy->FldCaption());

		// BirthDate
		$this->BirthDate->EditAttrs["class"] = "form-control";
		$this->BirthDate->EditCustomAttributes = "";
		$this->BirthDate->EditValue = ew_FormatDateTime($this->BirthDate->CurrentValue, 8);
		$this->BirthDate->PlaceHolder = ew_RemoveHtml($this->BirthDate->FldCaption());

		// HireDate
		$this->HireDate->EditAttrs["class"] = "form-control";
		$this->HireDate->EditCustomAttributes = "";
		$this->HireDate->EditValue = ew_FormatDateTime($this->HireDate->CurrentValue, 8);
		$this->HireDate->PlaceHolder = ew_RemoveHtml($this->HireDate->FldCaption());

		// Address
		$this->Address->EditAttrs["class"] = "form-control";
		$this->Address->EditCustomAttributes = "";
		$this->Address->EditValue = $this->Address->CurrentValue;
		$this->Address->PlaceHolder = ew_RemoveHtml($this->Address->FldCaption());

		// City
		$this->City->EditAttrs["class"] = "form-control";
		$this->City->EditCustomAttributes = "";
		$this->City->EditValue = $this->City->CurrentValue;
		$this->City->PlaceHolder = ew_RemoveHtml($this->City->FldCaption());

		// Region
		$this->Region->EditAttrs["class"] = "form-control";
		$this->Region->EditCustomAttributes = "";
		$this->Region->EditValue = $this->Region->CurrentValue;
		$this->Region->PlaceHolder = ew_RemoveHtml($this->Region->FldCaption());

		// PostalCode
		$this->PostalCode->EditAttrs["class"] = "form-control";
		$this->PostalCode->EditCustomAttributes = "";
		$this->PostalCode->EditValue = $this->PostalCode->CurrentValue;
		$this->PostalCode->PlaceHolder = ew_RemoveHtml($this->PostalCode->FldCaption());

		// Country
		$this->Country->EditAttrs["class"] = "form-control";
		$this->Country->EditCustomAttributes = "";
		$this->Country->EditValue = $this->Country->CurrentValue;
		$this->Country->PlaceHolder = ew_RemoveHtml($this->Country->FldCaption());

		// HomePhone
		$this->HomePhone->EditAttrs["class"] = "form-control";
		$this->HomePhone->EditCustomAttributes = "";
		$this->HomePhone->EditValue = $this->HomePhone->CurrentValue;
		$this->HomePhone->PlaceHolder = ew_RemoveHtml($this->HomePhone->FldCaption());

		// Extension
		$this->Extension->EditAttrs["class"] = "form-control";
		$this->Extension->EditCustomAttributes = "";
		$this->Extension->EditValue = $this->Extension->CurrentValue;
		$this->Extension->PlaceHolder = ew_RemoveHtml($this->Extension->FldCaption());

		// Email
		$this->_Email->EditAttrs["class"] = "form-control";
		$this->_Email->EditCustomAttributes = "";
		$this->_Email->EditValue = $this->_Email->CurrentValue;
		$this->_Email->PlaceHolder = ew_RemoveHtml($this->_Email->FldCaption());

		// Photo
		$this->Photo->EditAttrs["class"] = "form-control";
		$this->Photo->EditCustomAttributes = "";
		$this->Photo->EditValue = $this->Photo->CurrentValue;
		$this->Photo->PlaceHolder = ew_RemoveHtml($this->Photo->FldCaption());

		// Notes
		$this->Notes->EditAttrs["class"] = "form-control";
		$this->Notes->EditCustomAttributes = "";
		$this->Notes->EditValue = $this->Notes->CurrentValue;
		$this->Notes->PlaceHolder = ew_RemoveHtml($this->Notes->FldCaption());

		// ReportsTo
		$this->ReportsTo->EditAttrs["class"] = "form-control";
		$this->ReportsTo->EditCustomAttributes = "";
		$this->ReportsTo->EditValue = $this->ReportsTo->CurrentValue;
		$this->ReportsTo->PlaceHolder = ew_RemoveHtml($this->ReportsTo->FldCaption());

		// Password
		$this->Password->EditAttrs["class"] = "form-control ewPasswordStrength";
		$this->Password->EditCustomAttributes = "";
		$this->Password->EditValue = $this->Password->CurrentValue;
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
		$this->Username->EditValue = $this->Username->CurrentValue;
		$this->Username->PlaceHolder = ew_RemoveHtml($this->Username->FldCaption());

		// Activated
		$this->Activated->EditCustomAttributes = "";
		$this->Activated->EditValue = $this->Activated->Options(FALSE);

		// Profile
		$this->Profile->EditAttrs["class"] = "form-control";
		$this->Profile->EditCustomAttributes = "";
		$this->Profile->EditValue = $this->Profile->CurrentValue;
		$this->Profile->PlaceHolder = ew_RemoveHtml($this->Profile->FldCaption());

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->EmployeeID->Exportable) $Doc->ExportCaption($this->EmployeeID);
					if ($this->LastName->Exportable) $Doc->ExportCaption($this->LastName);
					if ($this->FirstName->Exportable) $Doc->ExportCaption($this->FirstName);
					if ($this->Title->Exportable) $Doc->ExportCaption($this->Title);
					if ($this->TitleOfCourtesy->Exportable) $Doc->ExportCaption($this->TitleOfCourtesy);
					if ($this->BirthDate->Exportable) $Doc->ExportCaption($this->BirthDate);
					if ($this->HireDate->Exportable) $Doc->ExportCaption($this->HireDate);
					if ($this->Address->Exportable) $Doc->ExportCaption($this->Address);
					if ($this->City->Exportable) $Doc->ExportCaption($this->City);
					if ($this->Region->Exportable) $Doc->ExportCaption($this->Region);
					if ($this->PostalCode->Exportable) $Doc->ExportCaption($this->PostalCode);
					if ($this->Country->Exportable) $Doc->ExportCaption($this->Country);
					if ($this->HomePhone->Exportable) $Doc->ExportCaption($this->HomePhone);
					if ($this->Extension->Exportable) $Doc->ExportCaption($this->Extension);
					if ($this->_Email->Exportable) $Doc->ExportCaption($this->_Email);
					if ($this->Photo->Exportable) $Doc->ExportCaption($this->Photo);
					if ($this->Notes->Exportable) $Doc->ExportCaption($this->Notes);
					if ($this->ReportsTo->Exportable) $Doc->ExportCaption($this->ReportsTo);
					if ($this->Password->Exportable) $Doc->ExportCaption($this->Password);
					if ($this->UserLevel->Exportable) $Doc->ExportCaption($this->UserLevel);
					if ($this->Username->Exportable) $Doc->ExportCaption($this->Username);
					if ($this->Activated->Exportable) $Doc->ExportCaption($this->Activated);
					if ($this->Profile->Exportable) $Doc->ExportCaption($this->Profile);
				} else {
					if ($this->EmployeeID->Exportable) $Doc->ExportCaption($this->EmployeeID);
					if ($this->LastName->Exportable) $Doc->ExportCaption($this->LastName);
					if ($this->FirstName->Exportable) $Doc->ExportCaption($this->FirstName);
					if ($this->Title->Exportable) $Doc->ExportCaption($this->Title);
					if ($this->TitleOfCourtesy->Exportable) $Doc->ExportCaption($this->TitleOfCourtesy);
					if ($this->BirthDate->Exportable) $Doc->ExportCaption($this->BirthDate);
					if ($this->HireDate->Exportable) $Doc->ExportCaption($this->HireDate);
					if ($this->Address->Exportable) $Doc->ExportCaption($this->Address);
					if ($this->City->Exportable) $Doc->ExportCaption($this->City);
					if ($this->Region->Exportable) $Doc->ExportCaption($this->Region);
					if ($this->PostalCode->Exportable) $Doc->ExportCaption($this->PostalCode);
					if ($this->Country->Exportable) $Doc->ExportCaption($this->Country);
					if ($this->HomePhone->Exportable) $Doc->ExportCaption($this->HomePhone);
					if ($this->Extension->Exportable) $Doc->ExportCaption($this->Extension);
					if ($this->_Email->Exportable) $Doc->ExportCaption($this->_Email);
					if ($this->Photo->Exportable) $Doc->ExportCaption($this->Photo);
					if ($this->ReportsTo->Exportable) $Doc->ExportCaption($this->ReportsTo);
					if ($this->Password->Exportable) $Doc->ExportCaption($this->Password);
					if ($this->UserLevel->Exportable) $Doc->ExportCaption($this->UserLevel);
					if ($this->Username->Exportable) $Doc->ExportCaption($this->Username);
					if ($this->Activated->Exportable) $Doc->ExportCaption($this->Activated);
				}
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

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->EmployeeID->Exportable) $Doc->ExportField($this->EmployeeID);
						if ($this->LastName->Exportable) $Doc->ExportField($this->LastName);
						if ($this->FirstName->Exportable) $Doc->ExportField($this->FirstName);
						if ($this->Title->Exportable) $Doc->ExportField($this->Title);
						if ($this->TitleOfCourtesy->Exportable) $Doc->ExportField($this->TitleOfCourtesy);
						if ($this->BirthDate->Exportable) $Doc->ExportField($this->BirthDate);
						if ($this->HireDate->Exportable) $Doc->ExportField($this->HireDate);
						if ($this->Address->Exportable) $Doc->ExportField($this->Address);
						if ($this->City->Exportable) $Doc->ExportField($this->City);
						if ($this->Region->Exportable) $Doc->ExportField($this->Region);
						if ($this->PostalCode->Exportable) $Doc->ExportField($this->PostalCode);
						if ($this->Country->Exportable) $Doc->ExportField($this->Country);
						if ($this->HomePhone->Exportable) $Doc->ExportField($this->HomePhone);
						if ($this->Extension->Exportable) $Doc->ExportField($this->Extension);
						if ($this->_Email->Exportable) $Doc->ExportField($this->_Email);
						if ($this->Photo->Exportable) $Doc->ExportField($this->Photo);
						if ($this->Notes->Exportable) $Doc->ExportField($this->Notes);
						if ($this->ReportsTo->Exportable) $Doc->ExportField($this->ReportsTo);
						if ($this->Password->Exportable) $Doc->ExportField($this->Password);
						if ($this->UserLevel->Exportable) $Doc->ExportField($this->UserLevel);
						if ($this->Username->Exportable) $Doc->ExportField($this->Username);
						if ($this->Activated->Exportable) $Doc->ExportField($this->Activated);
						if ($this->Profile->Exportable) $Doc->ExportField($this->Profile);
					} else {
						if ($this->EmployeeID->Exportable) $Doc->ExportField($this->EmployeeID);
						if ($this->LastName->Exportable) $Doc->ExportField($this->LastName);
						if ($this->FirstName->Exportable) $Doc->ExportField($this->FirstName);
						if ($this->Title->Exportable) $Doc->ExportField($this->Title);
						if ($this->TitleOfCourtesy->Exportable) $Doc->ExportField($this->TitleOfCourtesy);
						if ($this->BirthDate->Exportable) $Doc->ExportField($this->BirthDate);
						if ($this->HireDate->Exportable) $Doc->ExportField($this->HireDate);
						if ($this->Address->Exportable) $Doc->ExportField($this->Address);
						if ($this->City->Exportable) $Doc->ExportField($this->City);
						if ($this->Region->Exportable) $Doc->ExportField($this->Region);
						if ($this->PostalCode->Exportable) $Doc->ExportField($this->PostalCode);
						if ($this->Country->Exportable) $Doc->ExportField($this->Country);
						if ($this->HomePhone->Exportable) $Doc->ExportField($this->HomePhone);
						if ($this->Extension->Exportable) $Doc->ExportField($this->Extension);
						if ($this->_Email->Exportable) $Doc->ExportField($this->_Email);
						if ($this->Photo->Exportable) $Doc->ExportField($this->Photo);
						if ($this->ReportsTo->Exportable) $Doc->ExportField($this->ReportsTo);
						if ($this->Password->Exportable) $Doc->ExportField($this->Password);
						if ($this->UserLevel->Exportable) $Doc->ExportField($this->UserLevel);
						if ($this->Username->Exportable) $Doc->ExportField($this->Username);
						if ($this->Activated->Exportable) $Doc->ExportField($this->Activated);
					}
					$Doc->EndExportRow();
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// User ID filter
	function UserIDFilter($userid) {
		$sUserIDFilter = '`EmployeeID` = ' . ew_QuotedValue($userid, EW_DATATYPE_NUMBER, EW_USER_TABLE_DBID);
		return $sUserIDFilter;
	}

	// Add User ID filter
	function AddUserIDFilter($sFilter) {
		global $Security;
		$sFilterWrk = "";
		$id = (CurrentPageID() == "list") ? $this->CurrentAction : CurrentPageID();
		if (!$this->UserIDAllow($id) && !$Security->IsAdmin()) {
			$sFilterWrk = $Security->UserIDList();
			if ($sFilterWrk <> "")
				$sFilterWrk = '`EmployeeID` IN (' . $sFilterWrk . ')';
		}

		// Call User ID Filtering event
		$this->UserID_Filtering($sFilterWrk);
		ew_AddFilter($sFilter, $sFilterWrk);
		return $sFilter;
	}

	// User ID subquery
	function GetUserIDSubquery(&$fld, &$masterfld) {
		global $UserTableConn;
		$sWrk = "";
		$sSql = "SELECT " . $masterfld->FldExpression . " FROM `t96_employees`";
		$sFilter = $this->AddUserIDFilter("");
		if ($sFilter <> "") $sSql .= " WHERE " . $sFilter;

		// Use subquery
		if (EW_USE_SUBQUERY_FOR_MASTER_USER_ID) {
			$sWrk = $sSql;
		} else {

			// List all values
			if ($rs = $UserTableConn->Execute($sSql)) {
				while (!$rs->EOF) {
					if ($sWrk <> "") $sWrk .= ",";
					$sWrk .= ew_QuotedValue($rs->fields[0], $masterfld->FldDataType, EW_USER_TABLE_DBID);
					$rs->MoveNext();
				}
				$rs->Close();
			}
		}
		if ($sWrk <> "") {
			$sWrk = $fld->FldExpression . " IN (" . $sWrk . ")";
		}
		return $sWrk;
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 't96_employees';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 't96_employees';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['EmployeeID'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$usr = CurrentUserID();
		foreach (array_keys($rs) as $fldname) {
			if (array_key_exists($fldname, $this->fields) && $this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") {
					$newvalue = $Language->Phrase("PasswordMask"); // Password Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) {
					if (EW_AUDIT_TRAIL_TO_DATABASE)
						$newvalue = $rs[$fldname];
					else
						$newvalue = "[MEMO]"; // Memo Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) {
					$newvalue = "[XML]"; // XML Field
				} else {
					$newvalue = $rs[$fldname];
				}
				if ($fldname == 'Password')
					$newvalue = $Language->Phrase("PasswordMask");
				ew_WriteAuditTrail("log", $dt, $id, $usr, "A", $table, $fldname, $key, "", $newvalue);
			}
		}
	}

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		global $Language;
		if (!$this->AuditTrailOnEdit) return;
		$table = 't96_employees';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['EmployeeID'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$usr = CurrentUserID();
		foreach (array_keys($rsnew) as $fldname) {
			if (array_key_exists($fldname, $this->fields) && array_key_exists($fldname, $rsold) && $this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldDataType == EW_DATATYPE_DATE) { // DateTime field
					$modified = (ew_FormatDateTime($rsold[$fldname], 0) <> ew_FormatDateTime($rsnew[$fldname], 0));
				} else {
					$modified = !ew_CompareValue($rsold[$fldname], $rsnew[$fldname]);
				}
				if ($modified) {
					if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") { // Password Field
						$oldvalue = $Language->Phrase("PasswordMask");
						$newvalue = $Language->Phrase("PasswordMask");
					} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) { // Memo field
						if (EW_AUDIT_TRAIL_TO_DATABASE) {
							$oldvalue = $rsold[$fldname];
							$newvalue = $rsnew[$fldname];
						} else {
							$oldvalue = "[MEMO]";
							$newvalue = "[MEMO]";
						}
					} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) { // XML field
						$oldvalue = "[XML]";
						$newvalue = "[XML]";
					} else {
						$oldvalue = $rsold[$fldname];
						$newvalue = $rsnew[$fldname];
					}
					if ($fldname == 'Password') {
						$oldvalue = $Language->Phrase("PasswordMask");
						$newvalue = $Language->Phrase("PasswordMask");
					}
					ew_WriteAuditTrail("log", $dt, $id, $usr, "U", $table, $fldname, $key, $oldvalue, $newvalue);
				}
			}
		}
	}

	// Write Audit Trail (delete page)
	function WriteAuditTrailOnDelete(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnDelete) return;
		$table = 't96_employees';

		// Get key value
		$key = "";
		if ($key <> "")
			$key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['EmployeeID'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$curUser = CurrentUserID();
		foreach (array_keys($rs) as $fldname) {
			if (array_key_exists($fldname, $this->fields) && $this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") {
					$oldvalue = $Language->Phrase("PasswordMask"); // Password Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) {
					if (EW_AUDIT_TRAIL_TO_DATABASE)
						$oldvalue = $rs[$fldname];
					else
						$oldvalue = "[MEMO]"; // Memo field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) {
					$oldvalue = "[XML]"; // XML field
				} else {
					$oldvalue = $rs[$fldname];
				}
				if ($fldname == 'Password')
					$oldvalue = $Language->Phrase("PasswordMask");
				ew_WriteAuditTrail("log", $dt, $id, $curUser, "D", $table, $fldname, $key, $oldvalue, "");
			}
		}
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

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
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

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

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

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
