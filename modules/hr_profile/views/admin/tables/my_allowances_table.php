<?php

defined('BASEPATH') or exit('No direct script access allowed');
/*
'ID',
'Allowance Option',
'Tilte',
'Amount',
*/
$aColumns = ['id', 'tax', 'title', 'amount'];

$sIndexColumn = 'id';
$sTable       = db_prefix().'hr_allowances';

$where = ['AND staff_id='.$staff_id];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], $where, ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['id'];

    $row[] = ($aRow['tax'] == 1) ? 'Non Taxable' : 'Taxable';

    $row[] = $aRow['title'];

    $row[] = $aRow['amount'];

    $options = ''; if (has_permission('allowances', '', 'edit')) $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#update_allownce', 'data-id' => $aRow['id'], 'onclick' => 'edit(' . $aRow['id'] . ')']);
    if (has_permission('allowances', '', 'delete')) $options .= icon_btn('hr_profile/delete_allowance/' . $aRow['id'], 'remove', 'btn-danger _delete');
    $options .= '<a href="' . admin_url('hr_profile/allowance_view_edit/' . $aRow['id']) . '">' . _l('hr_view') . '</a>';

    $row[]   = $options;

    $output['aaData'][] = $row;
}
