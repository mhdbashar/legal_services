<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = ['id', 'title', 'amount'];

$sIndexColumn = 'id';
$sTable       = db_prefix().'hr_commissions';

$where = ['AND staff_id='.$staff_id];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], $where, ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['id'];

    $row[] = $aRow['title'];

    $row[] = $aRow['amount'];

    $options = ''; if (has_permission('hr', '', 'edit')) $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#update_commission', 'data-id' => $aRow['id'], 'onclick' => 'edit(' . $aRow['id'] . ')']);
    if (has_permission('hr', '', 'delete')) $options .= icon_btn('hr/details/delete_commission/' . $aRow['id'], 'remove', 'btn-danger _delete');
    $row[]   = $options;

    $output['aaData'][] = $row;
}
