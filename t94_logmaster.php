<?php

// id
// index_
// subj_

?>
<?php if ($t94_log->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $t94_log->TableCaption() ?></h4> -->
<table id="tbl_t94_logmaster" class="table table-bordered table-striped ewViewTable">
<?php echo $t94_log->TableCustomInnerHtml ?>
	<tbody>
<?php if ($t94_log->id->Visible) { // id ?>
		<tr id="r_id">
			<td><?php echo $t94_log->id->FldCaption() ?></td>
			<td<?php echo $t94_log->id->CellAttributes() ?>>
<span id="el_t94_log_id">
<span<?php echo $t94_log->id->ViewAttributes() ?>>
<?php echo $t94_log->id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t94_log->index_->Visible) { // index_ ?>
		<tr id="r_index_">
			<td><?php echo $t94_log->index_->FldCaption() ?></td>
			<td<?php echo $t94_log->index_->CellAttributes() ?>>
<span id="el_t94_log_index_">
<span<?php echo $t94_log->index_->ViewAttributes() ?>>
<?php echo $t94_log->index_->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t94_log->subj_->Visible) { // subj_ ?>
		<tr id="r_subj_">
			<td><?php echo $t94_log->subj_->FldCaption() ?></td>
			<td<?php echo $t94_log->subj_->CellAttributes() ?>>
<span id="el_t94_log_subj_">
<span<?php echo $t94_log->subj_->ViewAttributes() ?>>
<?php echo $t94_log->subj_->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
