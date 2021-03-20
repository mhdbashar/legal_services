<?php

defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = [
    db_prefix().'insurances_type.id as id',
    db_prefix().'insurances_type.name as type_name',
    db_prefix().'insurance_book_nums.name as name'
];

$sIndexColumn = 'id';
$sTable       = db_prefix().'insurances_type';

$where = [];
$join = [
    'LEFT JOIN '.db_prefix(). 'insurance_book_nums ON '.db_prefix().'insurances_type.insurance_book_id='.db_prefix().'insurance_book_nums.id'
];

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, []);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];

    $row[] = $aRow['type_name'];

    $row[] = $aRow['name'];

    $options = ''; if (has_permission('hr_settings', '', 'edit')) $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#update_type', 'data-id' => $aRow['id'], 'onclick' => 'edit(' . $aRow['id'] . ')']);
    if (has_permission('hr_settings', '', 'delete')) $options .= icon_btn('hr/setting/delete_insurances_type/' . $aRow['id'], 'remove', 'btn-danger _delete');
    $row[]   = $options;

    $output['aaData'][] = $row;
}
