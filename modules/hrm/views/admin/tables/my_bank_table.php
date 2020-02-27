<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = ['bank_name', 'account_name', 'routing_number', 'account_number'];

$sIndexColumn = 'id';
$sTable       = db_prefix().'my_bank';
$where = ['AND staff_id=' . $staff_id];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], $where, ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['bank_name'];

    $row[] = $aRow['account_name'];

    $row[] = $aRow['routing_number'];

    $row[] = $aRow['account_number'];

    $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#edit_bank', 'data-id' => $aRow['id'], 'onclick' => 'edit_bank_json(' . $aRow['id'] . ')']);
    $row[]   = $options .= icon_btn('hrm/details/delete_bank/' . $aRow['id'], 'remove', 'btn-danger _delete');
    

    $output['aaData'][] = $row;
}
