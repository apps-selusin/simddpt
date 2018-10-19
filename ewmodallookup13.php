<?php
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class for modal lookup
//
class cewmodallookup {

	// Page ID
	var $PageID = "modallookup";

	// Project ID
	var $ProjectID = "{78A0660C-C398-4292-A50E-2A3C7D765239}";

	// Page object name
	var $PageObjName = "modallookup";

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		return ew_CurrentPage() . "?";
	}
	var $Connection;
	var $DBID;
	var $SQL;
	var $Recordset;
	var $TotalRecs;
	var $RowCnt;
	var $ColSpan = 1;
	var $RecCount;
	var $StartOffset = 0; // 0-based, not $StartRec which is 1-based
	var $LookupTable;
	var $LookupTableCaption;
	var $LinkField;
	var $LinkFieldCaption;
	var $DisplayFields = array();
	var $DisplayFieldCaptions = array();
 	var $DisplayFieldExpressions = array();
	var $ParentFields = array();
	var $Multiple = FALSE;
	var $PageSize = 10;
	var $SearchValue = "";
	var $SearchFilter = "";
	var $SearchType = ""; // Auto ("=" => Exact Match, "AND" => All Keywords, "OR" => Any Keywords)
	var $PostData;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;
		$this->PostData = ew_StripSlashes($_POST);
		if (count($this->PostData) == 0)
			$this->Page_Error("Missing post data.");
		$Language = new cLanguage("", @$this->PostData["lang"]);
		$GLOBALS["Page"] = &$this;

		// Load form data
		$sql = @$this->PostData["s"];
		$sql = ew_Decrypt($sql);
		if ($sql == "")
			$this->Page_Error("Missing SQL.");
		$filter = @$this->PostData["f0"];
		$filter = ew_Decrypt($filter);
		$this->DBID = @$this->PostData["d"] ?: "DB";
		$this->Multiple = @$this->PostData["m"] == "1";
		$this->PageSize = @$this->PostData["n"] ?: 10;
		$this->Action = @$this->PostData["action"];
		$this->StartOffset = @$this->PostData["start"] ?: 0;

		// Load lookup table/field names
		$this->LookupTable = @$this->PostData["lt"];
		if ($this->LookupTable == "")
			$this->Page_Error("Missing lookup table.");
		$this->LookupTableCaption = $Language->TablePhrase($this->LookupTable, "TblCaption");
		$this->LinkField = @$this->PostData["lf"];
		if ($this->LinkField == "")
			$this->Page_Error("Missing link field.");
		$this->LinkFieldCaption = $Language->FieldPhrase($this->LookupTable, $this->LinkField, "FldCaption");
		$ar = preg_grep('/^ldf\d+$/', array_keys($this->PostData));
		foreach ($ar as $key) {
			$i = preg_replace('/^ldf/', '', $key);
			$fldvar = $this->PostData[$key];
			if ($fldvar <> "") {
				$fldcaption = $Language->FieldPhrase($this->LookupTable, $fldvar, "FldCaption");
				if ($fldcaption == "")
					$fldcaption = $fldvar;
				$this->DisplayFields[$i] = $fldvar;
				$this->DisplayFieldCaptions[$i] = $fldcaption;
				$this->DisplayFieldExpressions[$i] = ew_Decrypt(@$this->PostData["dx" . $i]);
				$this->ColSpan++;
			}
		}

		// Load search filter / selected key values
		$fldtype = intval(@$this->PostData["t0"]);
		$flddatatype = ew_FieldDataType($fldtype);
		if (isset($_POST["sv"])) {
			$this->SearchValue = $this->PostData["sv"];
			$this->SearchFilter = $this->GetSearchFilter();
			$filter = "";
		} elseif (isset($_POST["keys"])) {
			$arKeys = @$this->PostData["keys"];
			if (is_array($arKeys) && count($arKeys) > 0) {
				$filterwrk = "";
				$cnt = count($arKeys);
				for ($i = 0; $i < $cnt; $i++) {
					$arKeys[$i] = ew_QuotedValue($arKeys[$i], $flddatatype, $this->DBID);
					$filterwrk .= (($filterwrk <> "") ? " OR " : "") . str_replace("{filter_value}", $arKeys[$i], $filter);
				}
				$filter = $filterwrk;
				$this->PageSize = -1;
			} else {
				$filter = "1=0";
			}
		} else {
			$filter = "";
		}

		// Check parent filters
		$filters = "";
		if (ew_ContainsStr($sql, "{filter}")) {
			$ar = preg_grep('/^f\d+$/', array_keys(@$this->PostData));
			foreach ($ar as $key) {

				// Get the filter values (for "IN")
				$filter2 = ew_Decrypt(@$this->PostData[$key]);
				if ($filter2 <> "") {
					$i = preg_replace('/^f/', '', $key);
					$value = @$this->PostData["v" . $i];
					if ($value == "") {
						if ($i > 0) // Empty parent field

							//continue; // Allow
							ew_AddFilter($filters, "1=0"); // Disallow
						continue;
					}
					$this->ParentFields[$i] = $i;
					$arValue = explode(EW_LOOKUP_FILTER_VALUE_SEPARATOR, $value);
					$fldtype = intval(@$this->PostData["t" . $i]);
					$flddatatype = ew_FieldDataType($fldtype);
					$bValidData = TRUE;
					for ($j = 0, $cnt = count($arValue); $j < $cnt; $j++) {
						if ($flddatatype == EW_DATATYPE_NUMBER && !is_numeric($arValue[$j])) {
							$bValidData = FALSE;
							break;
						} else {
							$arValue[$j] = ew_QuotedValue($arValue[$j], $flddatatype, $this->DBID);
						}
					}
					if ($bValidData)
						$filter2 = str_replace("{filter_value}", implode(",", $arValue), $filter2);
					else
						$filter2 = "1=0";
					$fn = @$this->PostData["fn" . $i];
					if ($fn == "" || !function_exists($fn)) $fn = "ew_AddFilter";
					$fn($filters, $filter2);
				}
			}
		}
		$where = ""; // Initialize
		if ($this->SearchFilter <> "" && $this->SearchValue <> "")
			ew_AddFilter($where, $this->SearchFilter);
		if ($filter <> "")
			ew_AddFilter($where, $filter);
		if ($filters <> "")
			ew_AddFilter($where, $filters);
		$sql = str_replace("{filter}", ($where <> "") ? $where : "1=1", $sql);
		$this->SQL = $sql;

		//$this->Page_Error($sql); // Show SQL for debugging
		// Get records

		$this->Connection = &Conn($this->DBID);
		$this->TotalRecs = $this->GetRecordCount($sql);
		if ($this->PageSize > 0)
			$this->Recordset = $this->Connection->SelectLimit($sql, $this->PageSize, $this->StartOffset);
		if (!$this->Recordset)
			$this->Recordset = $this->Connection->Execute($sql);

		// Return JSON
		$this->Page_Response();
	}

	// Get search filter
	function GetSearchFilter() {
		if (trim($this->SearchValue) == "")
			return "";
		$sSearchStr = "";
		$sSearch = trim($this->SearchValue);
		$sSearchType = $this->SearchType;
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
			if ($sSearchType == "OR" || $sSearchType == "AND") {
				foreach ($ar as $sKeyword) {
					if ($sKeyword <> "") {
						$sSearchFilter = $this->GetSearchSQL(array($sKeyword));
						if ($sSearchFilter <> "") {
							if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
							$sSearchStr .= "(" . $sSearchFilter . ")";
						}
					}
				}
			} else {
				$sSearchStr = $this->GetSearchSQL($ar);
			}
		} else {
			$sSearchStr = $this->GetSearchSQL(array($sSearch));
		}
		return $sSearchStr;
	}

	// Get search SQL
	function GetSearchSQL($arKeywords) {
		$sWhere = "";
		foreach ($this->DisplayFieldExpressions as $sql) {
			if ($sql <> "") {
				$this->BuildSearchSQL($sWhere, $sql, $arKeywords);
			}
		}
		return $sWhere;
	}

	// Build search SQL
	function BuildSearchSQL(&$Where, $FldExpr, $arKeywords) {
		global $EW_BASIC_SEARCH_IGNORE_PATTERN;
		$sSearchType = $this->SearchType;
		$sDefCond = ($sSearchType == "OR") ? "OR" : "AND";
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
					if ($Keyword == "OR" && $sSearchType == "") {
						if ($j > 0)
							$arCond[$j-1] = "OR";
					} else {
						$sWrk = $FldExpr . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
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
			$Where .= "(" . $sSql . ")";
		}
	}

	// Get record count
	function GetRecordCount($sSql) {
		$cnt = -1;
		$rs = NULL;
		$sql = preg_replace('/\/\*BeginOrderBy\*\/[\s\S]+\/\*EndOrderBy\*\//', "", $sSql); // Remove ORDER BY clause (MSSQL)
		$pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';
		if (preg_match($pattern, $sql)) {
			$sqlwrk = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sql);
			$rs = $this->Connection->Execute($sqlwrk);
		}
		if (!$rs) {
			$sqlwrk = "SELECT COUNT(*) FROM (" . $sql . ") EW_COUNT_TABLE";
			$rs = $this->Connection->Execute($sqlwrk);
		}
		if ($rs && !$rs->EOF && $rs->FieldCount() > 0) {
			$cnt = $rs->fields[0];
			$rs->Close();
			return intval($cnt);
		}

		// Unable to get count, get record count directly
		if ($rs = $this->Connection->Execute($sql)) {
			$cnt = $rs->RecordCount();
			$rs->Close();
			return intval($cnt);
		}
		return $cnt;
	}

	// Show page response
	function Page_Response() {
		if (!is_object($this->Recordset)) {
			$result = array("Result" => "ERROR", "Message" => "Failed to execute SQL");
			if (EW_DEBUG_ENABLED)
				$result["Message"] .= ": " . $this->SQL; // To be viewed in browser Network panel for debugging
			echo json_encode($result);
			exit();
		}
		$rowcnt = $this->Recordset->RecordCount();
		$fldcnt = count($this->DisplayFields);
		$rsarr = $this->Recordset->GetRows();
		$this->Recordset->Close();
		ew_CloseConn();

		// Clean output buffer
		if (ob_get_length())
			ob_clean();

		// Format date
		$ardt = array();
		for ($i = 0; $i <= $fldcnt; $i++)
			$ardt[$i] = @$_POST["df" . $i]; // Get date formats

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			foreach ($rsarr as &$row) {
				$ar = array($this->LinkField => $row[0]);
				for ($i = 1; $i <= $fldcnt; $i++) {
					$str = ew_ConvertToUtf8(strval($row[$i]));
					if ($ardt[$i] != "" && intval($ardt[$i]) >= 0) // Format date
						$str = ew_FormatDateTime($str, $ardt[$i]);
					$str = str_replace(array("\r", "\n", "\t"), isset($post["keepCRLF"]) ? array("\\r", "\\n", "\\t") : array(" ", " ", " "), $str);
					$row[$i] = $str;
				}
			}
		}
		echo '{"Result": "OK", "Records": ' . ew_ArrayToJson($rsarr) . ', "TotalRecordCount": ' . $this->TotalRecs . '}';
		exit();
	}

	// Show page error
	function Page_Error($msg) {
		$result = array("Result" => "ERROR", "Message" => $msg); 
		echo json_encode($result);
		exit();
	}
}
ew_Header(FALSE, 'utf-8');
$modallookup = new cewmodallookup;
$modallookup->Page_Main();
?>
