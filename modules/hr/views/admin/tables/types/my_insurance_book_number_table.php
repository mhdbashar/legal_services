<?php

defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = ['name'];

$sIndexColumn = 'id';
$sTable       = db_prefix().'insurance_book_nums';

$where = [];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], $where, ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];

    $row[] = $aRow['name'];

    $options = ''; if (has_permission('hr_settings', '', 'edit')) $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#update_type', 'data-id' => $aRow['id'], 'onclick' => 'edit(' . $aRow['id'] . ')']);
    if (has_permission('hr_settings', '', 'delete')) $options .= icon_btn('hr/setting/delete_insurance_book_num/' . $aRow['id'], 'remove', 'btn-danger _delete');
    $row[]   = $options;

    $output['aaData'][] = $row;
}
