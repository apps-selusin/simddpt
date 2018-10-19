<?php include_once "t96_employeesinfo.php" ?>
<?php

// Create page object
if (!isset($t95_logdesc_grid)) $t95_logdesc_grid = new ct95_logdesc_grid();

// Page init
$t95_logdesc_grid->Page_Init();

// Page main
$t95_logdesc_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t95_logdesc_grid->Page_Render();
?>
<?php if ($t95_logdesc->Export == "") { ?>
<script type="text/javascript">

// Form object
var ft95_logdescgrid = new ew_Form("ft95_logdescgrid", "grid");
ft95_logdescgrid.FormKeyCountName = '<?php echo $t95_logdesc_grid->FormKeyCountName ?>';

// Validate form
ft95_logdescgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_log_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t95_logdesc->log_id->FldCaption(), $t95_logdesc->log_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_log_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t95_logdesc->log_id->FldErrMsg()) ?>");
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
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ft95_logdescgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "log_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "date_issued", false)) return false;
	if (ew_ValueChanged(fobj, infix, "date_solved", false)) return false;
	return true;
}

// Form_CustomValidate event
ft95_logdescgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft95_logdescgrid.ValidateRequired = true;
<?php } else { ?>
ft95_logdescgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($t95_logdesc->CurrentAction == "gridadd") {
	if ($t95_logdesc->CurrentMode == "copy") {
		$bSelectLimit = $t95_logdesc_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$t95_logdesc_grid->TotalRecs = $t95_logdesc->SelectRecordCount();
			$t95_logdesc_grid->Recordset = $t95_logdesc_grid->LoadRecordset($t95_logdesc_grid->StartRec-1, $t95_logdesc_grid->DisplayRecs);
		} else {
			if ($t95_logdesc_grid->Recordset = $t95_logdesc_grid->LoadRecordset())
				$t95_logdesc_grid->TotalRecs = $t95_logdesc_grid->Recordset->RecordCount();
		}
		$t95_logdesc_grid->StartRec = 1;
		$t95_logdesc_grid->DisplayRecs = $t95_logdesc_grid->TotalRecs;
	} else {
		$t95_logdesc->CurrentFilter = "0=1";
		$t95_logdesc_grid->StartRec = 1;
		$t95_logdesc_grid->DisplayRecs = $t95_logdesc->GridAddRowCount;
	}
	$t95_logdesc_grid->TotalRecs = $t95_logdesc_grid->DisplayRecs;
	$t95_logdesc_grid->StopRec = $t95_logdesc_grid->DisplayRecs;
} else {
	$bSelectLimit = $t95_logdesc_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t95_logdesc_grid->TotalRecs <= 0)
			$t95_logdesc_grid->TotalRecs = $t95_logdesc->SelectRecordCount();
	} else {
		if (!$t95_logdesc_grid->Recordset && ($t95_logdesc_grid->Recordset = $t95_logdesc_grid->LoadRecordset()))
			$t95_logdesc_grid->TotalRecs = $t95_logdesc_grid->Recordset->RecordCount();
	}
	$t95_logdesc_grid->StartRec = 1;
	$t95_logdesc_grid->DisplayRecs = $t95_logdesc_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$t95_logdesc_grid->Recordset = $t95_logdesc_grid->LoadRecordset($t95_logdesc_grid->StartRec-1, $t95_logdesc_grid->DisplayRecs);

	// Set no record found message
	if ($t95_logdesc->CurrentAction == "" && $t95_logdesc_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$t95_logdesc_grid->setWarningMessage(ew_DeniedMsg());
		if ($t95_logdesc_grid->SearchWhere == "0=101")
			$t95_logdesc_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t95_logdesc_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$t95_logdesc_grid->RenderOtherOptions();
?>
<?php $t95_logdesc_grid->ShowPageHeader(); ?>
<?php
$t95_logdesc_grid->ShowMessage();
?>
<?php if ($t95_logdesc_grid->TotalRecs > 0 || $t95_logdesc->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid t95_logdesc">
<div id="ft95_logdescgrid" class="ewForm form-inline">
<?php if ($t95_logdesc_grid->ShowOtherOptions) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php
	foreach ($t95_logdesc_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_t95_logdesc" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_t95_logdescgrid" class="table ewTable">
<?php echo $t95_logdesc->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$t95_logdesc_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t95_logdesc_grid->RenderListOptions();

// Render list options (header, left)
$t95_logdesc_grid->ListOptions->Render("header", "left");
?>
<?php if ($t95_logdesc->id->Visible) { // id ?>
	<?php if ($t95_logdesc->SortUrl($t95_logdesc->id) == "") { ?>
		<th data-name="id"><div id="elh_t95_logdesc_id" class="t95_logdesc_id"><div class="ewTableHeaderCaption"><?php echo $t95_logdesc->id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id"><div><div id="elh_t95_logdesc_id" class="t95_logdesc_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t95_logdesc->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t95_logdesc->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t95_logdesc->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t95_logdesc->log_id->Visible) { // log_id ?>
	<?php if ($t95_logdesc->SortUrl($t95_logdesc->log_id) == "") { ?>
		<th data-name="log_id"><div id="elh_t95_logdesc_log_id" class="t95_logdesc_log_id"><div class="ewTableHeaderCaption"><?php echo $t95_logdesc->log_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="log_id"><div><div id="elh_t95_logdesc_log_id" class="t95_logdesc_log_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t95_logdesc->log_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t95_logdesc->log_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t95_logdesc->log_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t95_logdesc->date_issued->Visible) { // date_issued ?>
	<?php if ($t95_logdesc->SortUrl($t95_logdesc->date_issued) == "") { ?>
		<th data-name="date_issued"><div id="elh_t95_logdesc_date_issued" class="t95_logdesc_date_issued"><div class="ewTableHeaderCaption"><?php echo $t95_logdesc->date_issued->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="date_issued"><div><div id="elh_t95_logdesc_date_issued" class="t95_logdesc_date_issued">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t95_logdesc->date_issued->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t95_logdesc->date_issued->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t95_logdesc->date_issued->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t95_logdesc->date_solved->Visible) { // date_solved ?>
	<?php if ($t95_logdesc->SortUrl($t95_logdesc->date_solved) == "") { ?>
		<th data-name="date_solved"><div id="elh_t95_logdesc_date_solved" class="t95_logdesc_date_solved"><div class="ewTableHeaderCaption"><?php echo $t95_logdesc->date_solved->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="date_solved"><div><div id="elh_t95_logdesc_date_solved" class="t95_logdesc_date_solved">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t95_logdesc->date_solved->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t95_logdesc->date_solved->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t95_logdesc->date_solved->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$t95_logdesc_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$t95_logdesc_grid->StartRec = 1;
$t95_logdesc_grid->StopRec = $t95_logdesc_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($t95_logdesc_grid->FormKeyCountName) && ($t95_logdesc->CurrentAction == "gridadd" || $t95_logdesc->CurrentAction == "gridedit" || $t95_logdesc->CurrentAction == "F")) {
		$t95_logdesc_grid->KeyCount = $objForm->GetValue($t95_logdesc_grid->FormKeyCountName);
		$t95_logdesc_grid->StopRec = $t95_logdesc_grid->StartRec + $t95_logdesc_grid->KeyCount - 1;
	}
}
$t95_logdesc_grid->RecCnt = $t95_logdesc_grid->StartRec - 1;
if ($t95_logdesc_grid->Recordset && !$t95_logdesc_grid->Recordset->EOF) {
	$t95_logdesc_grid->Recordset->MoveFirst();
	$bSelectLimit = $t95_logdesc_grid->UseSelectLimit;
	if (!$bSelectLimit && $t95_logdesc_grid->StartRec > 1)
		$t95_logdesc_grid->Recordset->Move($t95_logdesc_grid->StartRec - 1);
} elseif (!$t95_logdesc->AllowAddDeleteRow && $t95_logdesc_grid->StopRec == 0) {
	$t95_logdesc_grid->StopRec = $t95_logdesc->GridAddRowCount;
}

// Initialize aggregate
$t95_logdesc->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t95_logdesc->ResetAttrs();
$t95_logdesc_grid->RenderRow();
if ($t95_logdesc->CurrentAction == "gridadd")
	$t95_logdesc_grid->RowIndex = 0;
if ($t95_logdesc->CurrentAction == "gridedit")
	$t95_logdesc_grid->RowIndex = 0;
while ($t95_logdesc_grid->RecCnt < $t95_logdesc_grid->StopRec) {
	$t95_logdesc_grid->RecCnt++;
	if (intval($t95_logdesc_grid->RecCnt) >= intval($t95_logdesc_grid->StartRec)) {
		$t95_logdesc_grid->RowCnt++;
		if ($t95_logdesc->CurrentAction == "gridadd" || $t95_logdesc->CurrentAction == "gridedit" || $t95_logdesc->CurrentAction == "F") {
			$t95_logdesc_grid->RowIndex++;
			$objForm->Index = $t95_logdesc_grid->RowIndex;
			if ($objForm->HasValue($t95_logdesc_grid->FormActionName))
				$t95_logdesc_grid->RowAction = strval($objForm->GetValue($t95_logdesc_grid->FormActionName));
			elseif ($t95_logdesc->CurrentAction == "gridadd")
				$t95_logdesc_grid->RowAction = "insert";
			else
				$t95_logdesc_grid->RowAction = "";
		}

		// Set up key count
		$t95_logdesc_grid->KeyCount = $t95_logdesc_grid->RowIndex;

		// Init row class and style
		$t95_logdesc->ResetAttrs();
		$t95_logdesc->CssClass = "";
		if ($t95_logdesc->CurrentAction == "gridadd") {
			if ($t95_logdesc->CurrentMode == "copy") {
				$t95_logdesc_grid->LoadRowValues($t95_logdesc_grid->Recordset); // Load row values
				$t95_logdesc_grid->SetRecordKey($t95_logdesc_grid->RowOldKey, $t95_logdesc_grid->Recordset); // Set old record key
			} else {
				$t95_logdesc_grid->LoadDefaultValues(); // Load default values
				$t95_logdesc_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$t95_logdesc_grid->LoadRowValues($t95_logdesc_grid->Recordset); // Load row values
		}
		$t95_logdesc->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($t95_logdesc->CurrentAction == "gridadd") // Grid add
			$t95_logdesc->RowType = EW_ROWTYPE_ADD; // Render add
		if ($t95_logdesc->CurrentAction == "gridadd" && $t95_logdesc->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$t95_logdesc_grid->RestoreCurrentRowFormValues($t95_logdesc_grid->RowIndex); // Restore form values
		if ($t95_logdesc->CurrentAction == "gridedit") { // Grid edit
			if ($t95_logdesc->EventCancelled) {
				$t95_logdesc_grid->RestoreCurrentRowFormValues($t95_logdesc_grid->RowIndex); // Restore form values
			}
			if ($t95_logdesc_grid->RowAction == "insert")
				$t95_logdesc->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$t95_logdesc->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($t95_logdesc->CurrentAction == "gridedit" && ($t95_logdesc->RowType == EW_ROWTYPE_EDIT || $t95_logdesc->RowType == EW_ROWTYPE_ADD) && $t95_logdesc->EventCancelled) // Update failed
			$t95_logdesc_grid->RestoreCurrentRowFormValues($t95_logdesc_grid->RowIndex); // Restore form values
		if ($t95_logdesc->RowType == EW_ROWTYPE_EDIT) // Edit row
			$t95_logdesc_grid->EditRowCnt++;
		if ($t95_logdesc->CurrentAction == "F") // Confirm row
			$t95_logdesc_grid->RestoreCurrentRowFormValues($t95_logdesc_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$t95_logdesc->RowAttrs = array_merge($t95_logdesc->RowAttrs, array('data-rowindex'=>$t95_logdesc_grid->RowCnt, 'id'=>'r' . $t95_logdesc_grid->RowCnt . '_t95_logdesc', 'data-rowtype'=>$t95_logdesc->RowType));

		// Render row
		$t95_logdesc_grid->RenderRow();

		// Render list options
		$t95_logdesc_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($t95_logdesc_grid->RowAction <> "delete" && $t95_logdesc_grid->RowAction <> "insertdelete" && !($t95_logdesc_grid->RowAction == "insert" && $t95_logdesc->CurrentAction == "F" && $t95_logdesc_grid->EmptyRow())) {
?>
	<tr<?php echo $t95_logdesc->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t95_logdesc_grid->ListOptions->Render("body", "left", $t95_logdesc_grid->RowCnt);
?>
	<?php if ($t95_logdesc->id->Visible) { // id ?>
		<td data-name="id"<?php echo $t95_logdesc->id->CellAttributes() ?>>
<?php if ($t95_logdesc->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="t95_logdesc" data-field="x_id" name="o<?php echo $t95_logdesc_grid->RowIndex ?>_id" id="o<?php echo $t95_logdesc_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t95_logdesc->id->OldValue) ?>">
<?php } ?>
<?php if ($t95_logdesc->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t95_logdesc_grid->RowCnt ?>_t95_logdesc_id" class="form-group t95_logdesc_id">
<span<?php echo $t95_logdesc->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t95_logdesc->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="t95_logdesc" data-field="x_id" name="x<?php echo $t95_logdesc_grid->RowIndex ?>_id" id="x<?php echo $t95_logdesc_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t95_logdesc->id->CurrentValue) ?>">
<?php } ?>
<?php if ($t95_logdesc->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t95_logdesc_grid->RowCnt ?>_t95_logdesc_id" class="t95_logdesc_id">
<span<?php echo $t95_logdesc->id->ViewAttributes() ?>>
<?php echo $t95_logdesc->id->ListViewValue() ?></span>
</span>
<?php if ($t95_logdesc->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t95_logdesc" data-field="x_id" name="x<?php echo $t95_logdesc_grid->RowIndex ?>_id" id="x<?php echo $t95_logdesc_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t95_logdesc->id->FormValue) ?>">
<input type="hidden" data-table="t95_logdesc" data-field="x_id" name="o<?php echo $t95_logdesc_grid->RowIndex ?>_id" id="o<?php echo $t95_logdesc_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t95_logdesc->id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t95_logdesc" data-field="x_id" name="ft95_logdescgrid$x<?php echo $t95_logdesc_grid->RowIndex ?>_id" id="ft95_logdescgrid$x<?php echo $t95_logdesc_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t95_logdesc->id->FormValue) ?>">
<input type="hidden" data-table="t95_logdesc" data-field="x_id" name="ft95_logdescgrid$o<?php echo $t95_logdesc_grid->RowIndex ?>_id" id="ft95_logdescgrid$o<?php echo $t95_logdesc_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t95_logdesc->id->OldValue) ?>">
<?php } ?>
<?php } ?>
<a id="<?php echo $t95_logdesc_grid->PageObjName . "_row_" . $t95_logdesc_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($t95_logdesc->log_id->Visible) { // log_id ?>
		<td data-name="log_id"<?php echo $t95_logdesc->log_id->CellAttributes() ?>>
<?php if ($t95_logdesc->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($t95_logdesc->log_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $t95_logdesc_grid->RowCnt ?>_t95_logdesc_log_id" class="form-group t95_logdesc_log_id">
<span<?php echo $t95_logdesc->log_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t95_logdesc->log_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t95_logdesc_grid->RowIndex ?>_log_id" name="x<?php echo $t95_logdesc_grid->RowIndex ?>_log_id" value="<?php echo ew_HtmlEncode($t95_logdesc->log_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t95_logdesc_grid->RowCnt ?>_t95_logdesc_log_id" class="form-group t95_logdesc_log_id">
<input type="text" data-table="t95_logdesc" data-field="x_log_id" name="x<?php echo $t95_logdesc_grid->RowIndex ?>_log_id" id="x<?php echo $t95_logdesc_grid->RowIndex ?>_log_id" size="30" placeholder="<?php echo ew_HtmlEncode($t95_logdesc->log_id->getPlaceHolder()) ?>" value="<?php echo $t95_logdesc->log_id->EditValue ?>"<?php echo $t95_logdesc->log_id->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="t95_logdesc" data-field="x_log_id" name="o<?php echo $t95_logdesc_grid->RowIndex ?>_log_id" id="o<?php echo $t95_logdesc_grid->RowIndex ?>_log_id" value="<?php echo ew_HtmlEncode($t95_logdesc->log_id->OldValue) ?>">
<?php } ?>
<?php if ($t95_logdesc->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($t95_logdesc->log_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $t95_logdesc_grid->RowCnt ?>_t95_logdesc_log_id" class="form-group t95_logdesc_log_id">
<span<?php echo $t95_logdesc->log_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t95_logdesc->log_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t95_logdesc_grid->RowIndex ?>_log_id" name="x<?php echo $t95_logdesc_grid->RowIndex ?>_log_id" value="<?php echo ew_HtmlEncode($t95_logdesc->log_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t95_logdesc_grid->RowCnt ?>_t95_logdesc_log_id" class="form-group t95_logdesc_log_id">
<input type="text" data-table="t95_logdesc" data-field="x_log_id" name="x<?php echo $t95_logdesc_grid->RowIndex ?>_log_id" id="x<?php echo $t95_logdesc_grid->RowIndex ?>_log_id" size="30" placeholder="<?php echo ew_HtmlEncode($t95_logdesc->log_id->getPlaceHolder()) ?>" value="<?php echo $t95_logdesc->log_id->EditValue ?>"<?php echo $t95_logdesc->log_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($t95_logdesc->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t95_logdesc_grid->RowCnt ?>_t95_logdesc_log_id" class="t95_logdesc_log_id">
<span<?php echo $t95_logdesc->log_id->ViewAttributes() ?>>
<?php echo $t95_logdesc->log_id->ListViewValue() ?></span>
</span>
<?php if ($t95_logdesc->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t95_logdesc" data-field="x_log_id" name="x<?php echo $t95_logdesc_grid->RowIndex ?>_log_id" id="x<?php echo $t95_logdesc_grid->RowIndex ?>_log_id" value="<?php echo ew_HtmlEncode($t95_logdesc->log_id->FormValue) ?>">
<input type="hidden" data-table="t95_logdesc" data-field="x_log_id" name="o<?php echo $t95_logdesc_grid->RowIndex ?>_log_id" id="o<?php echo $t95_logdesc_grid->RowIndex ?>_log_id" value="<?php echo ew_HtmlEncode($t95_logdesc->log_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t95_logdesc" data-field="x_log_id" name="ft95_logdescgrid$x<?php echo $t95_logdesc_grid->RowIndex ?>_log_id" id="ft95_logdescgrid$x<?php echo $t95_logdesc_grid->RowIndex ?>_log_id" value="<?php echo ew_HtmlEncode($t95_logdesc->log_id->FormValue) ?>">
<input type="hidden" data-table="t95_logdesc" data-field="x_log_id" name="ft95_logdescgrid$o<?php echo $t95_logdesc_grid->RowIndex ?>_log_id" id="ft95_logdescgrid$o<?php echo $t95_logdesc_grid->RowIndex ?>_log_id" value="<?php echo ew_HtmlEncode($t95_logdesc->log_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t95_logdesc->date_issued->Visible) { // date_issued ?>
		<td data-name="date_issued"<?php echo $t95_logdesc->date_issued->CellAttributes() ?>>
<?php if ($t95_logdesc->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t95_logdesc_grid->RowCnt ?>_t95_logdesc_date_issued" class="form-group t95_logdesc_date_issued">
<input type="text" data-table="t95_logdesc" data-field="x_date_issued" name="x<?php echo $t95_logdesc_grid->RowIndex ?>_date_issued" id="x<?php echo $t95_logdesc_grid->RowIndex ?>_date_issued" placeholder="<?php echo ew_HtmlEncode($t95_logdesc->date_issued->getPlaceHolder()) ?>" value="<?php echo $t95_logdesc->date_issued->EditValue ?>"<?php echo $t95_logdesc->date_issued->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t95_logdesc" data-field="x_date_issued" name="o<?php echo $t95_logdesc_grid->RowIndex ?>_date_issued" id="o<?php echo $t95_logdesc_grid->RowIndex ?>_date_issued" value="<?php echo ew_HtmlEncode($t95_logdesc->date_issued->OldValue) ?>">
<?php } ?>
<?php if ($t95_logdesc->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t95_logdesc_grid->RowCnt ?>_t95_logdesc_date_issued" class="form-group t95_logdesc_date_issued">
<input type="text" data-table="t95_logdesc" data-field="x_date_issued" name="x<?php echo $t95_logdesc_grid->RowIndex ?>_date_issued" id="x<?php echo $t95_logdesc_grid->RowIndex ?>_date_issued" placeholder="<?php echo ew_HtmlEncode($t95_logdesc->date_issued->getPlaceHolder()) ?>" value="<?php echo $t95_logdesc->date_issued->EditValue ?>"<?php echo $t95_logdesc->date_issued->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t95_logdesc->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t95_logdesc_grid->RowCnt ?>_t95_logdesc_date_issued" class="t95_logdesc_date_issued">
<span<?php echo $t95_logdesc->date_issued->ViewAttributes() ?>>
<?php echo $t95_logdesc->date_issued->ListViewValue() ?></span>
</span>
<?php if ($t95_logdesc->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t95_logdesc" data-field="x_date_issued" name="x<?php echo $t95_logdesc_grid->RowIndex ?>_date_issued" id="x<?php echo $t95_logdesc_grid->RowIndex ?>_date_issued" value="<?php echo ew_HtmlEncode($t95_logdesc->date_issued->FormValue) ?>">
<input type="hidden" data-table="t95_logdesc" data-field="x_date_issued" name="o<?php echo $t95_logdesc_grid->RowIndex ?>_date_issued" id="o<?php echo $t95_logdesc_grid->RowIndex ?>_date_issued" value="<?php echo ew_HtmlEncode($t95_logdesc->date_issued->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t95_logdesc" data-field="x_date_issued" name="ft95_logdescgrid$x<?php echo $t95_logdesc_grid->RowIndex ?>_date_issued" id="ft95_logdescgrid$x<?php echo $t95_logdesc_grid->RowIndex ?>_date_issued" value="<?php echo ew_HtmlEncode($t95_logdesc->date_issued->FormValue) ?>">
<input type="hidden" data-table="t95_logdesc" data-field="x_date_issued" name="ft95_logdescgrid$o<?php echo $t95_logdesc_grid->RowIndex ?>_date_issued" id="ft95_logdescgrid$o<?php echo $t95_logdesc_grid->RowIndex ?>_date_issued" value="<?php echo ew_HtmlEncode($t95_logdesc->date_issued->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t95_logdesc->date_solved->Visible) { // date_solved ?>
		<td data-name="date_solved"<?php echo $t95_logdesc->date_solved->CellAttributes() ?>>
<?php if ($t95_logdesc->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t95_logdesc_grid->RowCnt ?>_t95_logdesc_date_solved" class="form-group t95_logdesc_date_solved">
<input type="text" data-table="t95_logdesc" data-field="x_date_solved" name="x<?php echo $t95_logdesc_grid->RowIndex ?>_date_solved" id="x<?php echo $t95_logdesc_grid->RowIndex ?>_date_solved" placeholder="<?php echo ew_HtmlEncode($t95_logdesc->date_solved->getPlaceHolder()) ?>" value="<?php echo $t95_logdesc->date_solved->EditValue ?>"<?php echo $t95_logdesc->date_solved->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t95_logdesc" data-field="x_date_solved" name="o<?php echo $t95_logdesc_grid->RowIndex ?>_date_solved" id="o<?php echo $t95_logdesc_grid->RowIndex ?>_date_solved" value="<?php echo ew_HtmlEncode($t95_logdesc->date_solved->OldValue) ?>">
<?php } ?>
<?php if ($t95_logdesc->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t95_logdesc_grid->RowCnt ?>_t95_logdesc_date_solved" class="form-group t95_logdesc_date_solved">
<input type="text" data-table="t95_logdesc" data-field="x_date_solved" name="x<?php echo $t95_logdesc_grid->RowIndex ?>_date_solved" id="x<?php echo $t95_logdesc_grid->RowIndex ?>_date_solved" placeholder="<?php echo ew_HtmlEncode($t95_logdesc->date_solved->getPlaceHolder()) ?>" value="<?php echo $t95_logdesc->date_solved->EditValue ?>"<?php echo $t95_logdesc->date_solved->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t95_logdesc->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t95_logdesc_grid->RowCnt ?>_t95_logdesc_date_solved" class="t95_logdesc_date_solved">
<span<?php echo $t95_logdesc->date_solved->ViewAttributes() ?>>
<?php echo $t95_logdesc->date_solved->ListViewValue() ?></span>
</span>
<?php if ($t95_logdesc->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t95_logdesc" data-field="x_date_solved" name="x<?php echo $t95_logdesc_grid->RowIndex ?>_date_solved" id="x<?php echo $t95_logdesc_grid->RowIndex ?>_date_solved" value="<?php echo ew_HtmlEncode($t95_logdesc->date_solved->FormValue) ?>">
<input type="hidden" data-table="t95_logdesc" data-field="x_date_solved" name="o<?php echo $t95_logdesc_grid->RowIndex ?>_date_solved" id="o<?php echo $t95_logdesc_grid->RowIndex ?>_date_solved" value="<?php echo ew_HtmlEncode($t95_logdesc->date_solved->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t95_logdesc" data-field="x_date_solved" name="ft95_logdescgrid$x<?php echo $t95_logdesc_grid->RowIndex ?>_date_solved" id="ft95_logdescgrid$x<?php echo $t95_logdesc_grid->RowIndex ?>_date_solved" value="<?php echo ew_HtmlEncode($t95_logdesc->date_solved->FormValue) ?>">
<input type="hidden" data-table="t95_logdesc" data-field="x_date_solved" name="ft95_logdescgrid$o<?php echo $t95_logdesc_grid->RowIndex ?>_date_solved" id="ft95_logdescgrid$o<?php echo $t95_logdesc_grid->RowIndex ?>_date_solved" value="<?php echo ew_HtmlEncode($t95_logdesc->date_solved->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t95_logdesc_grid->ListOptions->Render("body", "right", $t95_logdesc_grid->RowCnt);
?>
	</tr>
<?php if ($t95_logdesc->RowType == EW_ROWTYPE_ADD || $t95_logdesc->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ft95_logdescgrid.UpdateOpts(<?php echo $t95_logdesc_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($t95_logdesc->CurrentAction <> "gridadd" || $t95_logdesc->CurrentMode == "copy")
		if (!$t95_logdesc_grid->Recordset->EOF) $t95_logdesc_grid->Recordset->MoveNext();
}
?>
<?php
	if ($t95_logdesc->CurrentMode == "add" || $t95_logdesc->CurrentMode == "copy" || $t95_logdesc->CurrentMode == "edit") {
		$t95_logdesc_grid->RowIndex = '$rowindex$';
		$t95_logdesc_grid->LoadDefaultValues();

		// Set row properties
		$t95_logdesc->ResetAttrs();
		$t95_logdesc->RowAttrs = array_merge($t95_logdesc->RowAttrs, array('data-rowindex'=>$t95_logdesc_grid->RowIndex, 'id'=>'r0_t95_logdesc', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($t95_logdesc->RowAttrs["class"], "ewTemplate");
		$t95_logdesc->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t95_logdesc_grid->RenderRow();

		// Render list options
		$t95_logdesc_grid->RenderListOptions();
		$t95_logdesc_grid->StartRowCnt = 0;
?>
	<tr<?php echo $t95_logdesc->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t95_logdesc_grid->ListOptions->Render("body", "left", $t95_logdesc_grid->RowIndex);
?>
	<?php if ($t95_logdesc->id->Visible) { // id ?>
		<td data-name="id">
<?php if ($t95_logdesc->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_t95_logdesc_id" class="form-group t95_logdesc_id">
<span<?php echo $t95_logdesc->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t95_logdesc->id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t95_logdesc" data-field="x_id" name="x<?php echo $t95_logdesc_grid->RowIndex ?>_id" id="x<?php echo $t95_logdesc_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t95_logdesc->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t95_logdesc" data-field="x_id" name="o<?php echo $t95_logdesc_grid->RowIndex ?>_id" id="o<?php echo $t95_logdesc_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t95_logdesc->id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t95_logdesc->log_id->Visible) { // log_id ?>
		<td data-name="log_id">
<?php if ($t95_logdesc->CurrentAction <> "F") { ?>
<?php if ($t95_logdesc->log_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_t95_logdesc_log_id" class="form-group t95_logdesc_log_id">
<span<?php echo $t95_logdesc->log_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t95_logdesc->log_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t95_logdesc_grid->RowIndex ?>_log_id" name="x<?php echo $t95_logdesc_grid->RowIndex ?>_log_id" value="<?php echo ew_HtmlEncode($t95_logdesc->log_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_t95_logdesc_log_id" class="form-group t95_logdesc_log_id">
<input type="text" data-table="t95_logdesc" data-field="x_log_id" name="x<?php echo $t95_logdesc_grid->RowIndex ?>_log_id" id="x<?php echo $t95_logdesc_grid->RowIndex ?>_log_id" size="30" placeholder="<?php echo ew_HtmlEncode($t95_logdesc->log_id->getPlaceHolder()) ?>" value="<?php echo $t95_logdesc->log_id->EditValue ?>"<?php echo $t95_logdesc->log_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_t95_logdesc_log_id" class="form-group t95_logdesc_log_id">
<span<?php echo $t95_logdesc->log_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t95_logdesc->log_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t95_logdesc" data-field="x_log_id" name="x<?php echo $t95_logdesc_grid->RowIndex ?>_log_id" id="x<?php echo $t95_logdesc_grid->RowIndex ?>_log_id" value="<?php echo ew_HtmlEncode($t95_logdesc->log_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t95_logdesc" data-field="x_log_id" name="o<?php echo $t95_logdesc_grid->RowIndex ?>_log_id" id="o<?php echo $t95_logdesc_grid->RowIndex ?>_log_id" value="<?php echo ew_HtmlEncode($t95_logdesc->log_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t95_logdesc->date_issued->Visible) { // date_issued ?>
		<td data-name="date_issued">
<?php if ($t95_logdesc->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t95_logdesc_date_issued" class="form-group t95_logdesc_date_issued">
<input type="text" data-table="t95_logdesc" data-field="x_date_issued" name="x<?php echo $t95_logdesc_grid->RowIndex ?>_date_issued" id="x<?php echo $t95_logdesc_grid->RowIndex ?>_date_issued" placeholder="<?php echo ew_HtmlEncode($t95_logdesc->date_issued->getPlaceHolder()) ?>" value="<?php echo $t95_logdesc->date_issued->EditValue ?>"<?php echo $t95_logdesc->date_issued->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t95_logdesc_date_issued" class="form-group t95_logdesc_date_issued">
<span<?php echo $t95_logdesc->date_issued->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t95_logdesc->date_issued->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t95_logdesc" data-field="x_date_issued" name="x<?php echo $t95_logdesc_grid->RowIndex ?>_date_issued" id="x<?php echo $t95_logdesc_grid->RowIndex ?>_date_issued" value="<?php echo ew_HtmlEncode($t95_logdesc->date_issued->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t95_logdesc" data-field="x_date_issued" name="o<?php echo $t95_logdesc_grid->RowIndex ?>_date_issued" id="o<?php echo $t95_logdesc_grid->RowIndex ?>_date_issued" value="<?php echo ew_HtmlEncode($t95_logdesc->date_issued->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t95_logdesc->date_solved->Visible) { // date_solved ?>
		<td data-name="date_solved">
<?php if ($t95_logdesc->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t95_logdesc_date_solved" class="form-group t95_logdesc_date_solved">
<input type="text" data-table="t95_logdesc" data-field="x_date_solved" name="x<?php echo $t95_logdesc_grid->RowIndex ?>_date_solved" id="x<?php echo $t95_logdesc_grid->RowIndex ?>_date_solved" placeholder="<?php echo ew_HtmlEncode($t95_logdesc->date_solved->getPlaceHolder()) ?>" value="<?php echo $t95_logdesc->date_solved->EditValue ?>"<?php echo $t95_logdesc->date_solved->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t95_logdesc_date_solved" class="form-group t95_logdesc_date_solved">
<span<?php echo $t95_logdesc->date_solved->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t95_logdesc->date_solved->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t95_logdesc" data-field="x_date_solved" name="x<?php echo $t95_logdesc_grid->RowIndex ?>_date_solved" id="x<?php echo $t95_logdesc_grid->RowIndex ?>_date_solved" value="<?php echo ew_HtmlEncode($t95_logdesc->date_solved->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t95_logdesc" data-field="x_date_solved" name="o<?php echo $t95_logdesc_grid->RowIndex ?>_date_solved" id="o<?php echo $t95_logdesc_grid->RowIndex ?>_date_solved" value="<?php echo ew_HtmlEncode($t95_logdesc->date_solved->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t95_logdesc_grid->ListOptions->Render("body", "right", $t95_logdesc_grid->RowCnt);
?>
<script type="text/javascript">
ft95_logdescgrid.UpdateOpts(<?php echo $t95_logdesc_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($t95_logdesc->CurrentMode == "add" || $t95_logdesc->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $t95_logdesc_grid->FormKeyCountName ?>" id="<?php echo $t95_logdesc_grid->FormKeyCountName ?>" value="<?php echo $t95_logdesc_grid->KeyCount ?>">
<?php echo $t95_logdesc_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t95_logdesc->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $t95_logdesc_grid->FormKeyCountName ?>" id="<?php echo $t95_logdesc_grid->FormKeyCountName ?>" value="<?php echo $t95_logdesc_grid->KeyCount ?>">
<?php echo $t95_logdesc_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t95_logdesc->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ft95_logdescgrid">
</div>
<?php

// Close recordset
if ($t95_logdesc_grid->Recordset)
	$t95_logdesc_grid->Recordset->Close();
?>
<?php if ($t95_logdesc_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($t95_logdesc_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($t95_logdesc_grid->TotalRecs == 0 && $t95_logdesc->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t95_logdesc_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($t95_logdesc->Export == "") { ?>
<script type="text/javascript">
ft95_logdescgrid.Init();
</script>
<?php } ?>
<?php
$t95_logdesc_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$t95_logdesc_grid->Page_Terminate();
?>
