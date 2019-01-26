<?php

// Call Row_Rendering event
$colonies->Row_Rendering();

// colony_id
// colony_name
// colony_address
// colony_aptnum
// colony_city
// colony_county
// colony_zip
// NumVouchIssued
// VoucherStartNum
// VoucherEndNum
// trapper
// notes
// sage
// Inactive
// mod_by
// mod_date
// Call Row_Rendered event

$colonies->Row_Rendered();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
	<tbody>
<?php if ($colonies->colony_id->Visible) { // colony_id ?>
		<tr id="r_colony_id">
			<td class="ewTableHeader"><?php echo $colonies->colony_id->FldCaption() ?></td>
			<td<?php echo $colonies->colony_id->CellAttributes() ?>>
<div<?php echo $colonies->colony_id->ViewAttributes() ?>><?php echo $colonies->colony_id->ListViewValue() ?></div></td>
		</tr>
<?php } ?>
<?php if ($colonies->colony_name->Visible) { // colony_name ?>
		<tr id="r_colony_name">
			<td class="ewTableHeader"><?php echo $colonies->colony_name->FldCaption() ?></td>
			<td<?php echo $colonies->colony_name->CellAttributes() ?>>
<div<?php echo $colonies->colony_name->ViewAttributes() ?>><?php echo $colonies->colony_name->ListViewValue() ?></div></td>
		</tr>
<?php } ?>
<?php if ($colonies->colony_address->Visible) { // colony_address ?>
		<tr id="r_colony_address">
			<td class="ewTableHeader"><?php echo $colonies->colony_address->FldCaption() ?></td>
			<td<?php echo $colonies->colony_address->CellAttributes() ?>>
<div<?php echo $colonies->colony_address->ViewAttributes() ?>><?php echo $colonies->colony_address->ListViewValue() ?></div></td>
		</tr>
<?php } ?>
<?php if ($colonies->colony_aptnum->Visible) { // colony_aptnum ?>
		<tr id="r_colony_aptnum">
			<td class="ewTableHeader"><?php echo $colonies->colony_aptnum->FldCaption() ?></td>
			<td<?php echo $colonies->colony_aptnum->CellAttributes() ?>>
<div<?php echo $colonies->colony_aptnum->ViewAttributes() ?>><?php echo $colonies->colony_aptnum->ListViewValue() ?></div></td>
		</tr>
<?php } ?>
<?php if ($colonies->colony_city->Visible) { // colony_city ?>
		<tr id="r_colony_city">
			<td class="ewTableHeader"><?php echo $colonies->colony_city->FldCaption() ?></td>
			<td<?php echo $colonies->colony_city->CellAttributes() ?>>
<div<?php echo $colonies->colony_city->ViewAttributes() ?>><?php echo $colonies->colony_city->ListViewValue() ?></div></td>
		</tr>
<?php } ?>
<?php if ($colonies->colony_county->Visible) { // colony_county ?>
		<tr id="r_colony_county">
			<td class="ewTableHeader"><?php echo $colonies->colony_county->FldCaption() ?></td>
			<td<?php echo $colonies->colony_county->CellAttributes() ?>>
<div<?php echo $colonies->colony_county->ViewAttributes() ?>><?php echo $colonies->colony_county->ListViewValue() ?></div></td>
		</tr>
<?php } ?>
<?php if ($colonies->colony_zip->Visible) { // colony_zip ?>
		<tr id="r_colony_zip">
			<td class="ewTableHeader"><?php echo $colonies->colony_zip->FldCaption() ?></td>
			<td<?php echo $colonies->colony_zip->CellAttributes() ?>>
<div<?php echo $colonies->colony_zip->ViewAttributes() ?>><?php echo $colonies->colony_zip->ListViewValue() ?></div></td>
		</tr>
<?php } ?>
<?php if ($colonies->NumVouchIssued->Visible) { // NumVouchIssued ?>
		<tr id="r_NumVouchIssued">
			<td class="ewTableHeader"><?php echo $colonies->NumVouchIssued->FldCaption() ?></td>
			<td<?php echo $colonies->NumVouchIssued->CellAttributes() ?>>
<div<?php echo $colonies->NumVouchIssued->ViewAttributes() ?>><?php echo $colonies->NumVouchIssued->ListViewValue() ?></div></td>
		</tr>
<?php } ?>
<?php if ($colonies->VoucherStartNum->Visible) { // VoucherStartNum ?>
		<tr id="r_VoucherStartNum">
			<td class="ewTableHeader"><?php echo $colonies->VoucherStartNum->FldCaption() ?></td>
			<td<?php echo $colonies->VoucherStartNum->CellAttributes() ?>>
<div<?php echo $colonies->VoucherStartNum->ViewAttributes() ?>><?php echo $colonies->VoucherStartNum->ListViewValue() ?></div></td>
		</tr>
<?php } ?>
<?php if ($colonies->VoucherEndNum->Visible) { // VoucherEndNum ?>
		<tr id="r_VoucherEndNum">
			<td class="ewTableHeader"><?php echo $colonies->VoucherEndNum->FldCaption() ?></td>
			<td<?php echo $colonies->VoucherEndNum->CellAttributes() ?>>
<div<?php echo $colonies->VoucherEndNum->ViewAttributes() ?>><?php echo $colonies->VoucherEndNum->ListViewValue() ?></div></td>
		</tr>
<?php } ?>
<?php if ($colonies->trapper->Visible) { // trapper ?>
		<tr id="r_trapper">
			<td class="ewTableHeader"><?php echo $colonies->trapper->FldCaption() ?></td>
			<td<?php echo $colonies->trapper->CellAttributes() ?>>
<div<?php echo $colonies->trapper->ViewAttributes() ?>><?php echo $colonies->trapper->ListViewValue() ?></div></td>
		</tr>
<?php } ?>
<?php if ($colonies->notes->Visible) { // notes ?>
		<tr id="r_notes">
			<td class="ewTableHeader"><?php echo $colonies->notes->FldCaption() ?></td>
			<td<?php echo $colonies->notes->CellAttributes() ?>>
<div<?php echo $colonies->notes->ViewAttributes() ?>><?php echo $colonies->notes->ListViewValue() ?></div></td>
		</tr>
<?php } ?>
<?php if ($colonies->sage->Visible) { // sage ?>
		<tr id="r_sage">
			<td class="ewTableHeader"><?php echo $colonies->sage->FldCaption() ?></td>
			<td<?php echo $colonies->sage->CellAttributes() ?>>
<div<?php echo $colonies->sage->ViewAttributes() ?>><?php echo $colonies->sage->ListViewValue() ?></div></td>
		</tr>
<?php } ?>
<?php if ($colonies->Inactive->Visible) { // Inactive ?>
		<tr id="r_Inactive">
			<td class="ewTableHeader"><?php echo $colonies->Inactive->FldCaption() ?></td>
			<td<?php echo $colonies->Inactive->CellAttributes() ?>>
<div<?php echo $colonies->Inactive->ViewAttributes() ?>><?php echo $colonies->Inactive->ListViewValue() ?></div></td>
		</tr>
<?php } ?>
<?php if ($colonies->mod_by->Visible) { // mod_by ?>
		<tr id="r_mod_by">
			<td class="ewTableHeader"><?php echo $colonies->mod_by->FldCaption() ?></td>
			<td<?php echo $colonies->mod_by->CellAttributes() ?>>
<div<?php echo $colonies->mod_by->ViewAttributes() ?>><?php echo $colonies->mod_by->ListViewValue() ?></div></td>
		</tr>
<?php } ?>
<?php if ($colonies->mod_date->Visible) { // mod_date ?>
		<tr id="r_mod_date">
			<td class="ewTableHeader"><?php echo $colonies->mod_date->FldCaption() ?></td>
			<td<?php echo $colonies->mod_date->CellAttributes() ?>>
<div<?php echo $colonies->mod_date->ViewAttributes() ?>><?php echo $colonies->mod_date->ListViewValue() ?></div></td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
</td></tr></table>
<br>
