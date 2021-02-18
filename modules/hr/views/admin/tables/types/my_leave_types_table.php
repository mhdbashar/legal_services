<?php

defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = ['name', 'days'];

$sIndexColumn = 'id';
$sTable       = db_prefix().'hr_leave_type';

$where = [];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], $where, ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['name'];

    $row[] = $aRow['days'];

    $options = ''; if (has_permission('hr', '', 'edit')) $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#update_type', 'data-id' => $aRow['id'], 'onclick' => 'edit(' . $aRow['id'] . ')']);
    if (has_permission('hr', '', 'delete')) $options .= icon_btn('hr/setting/delete_leave_type/' . $aRow['id'], 'remove', 'btn-danger _delete');
    $row[]   = $options;

    $output['aaData'][] = $row;
}
