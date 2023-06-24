<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = ['sub_department_name'];

$sIndexColumn = 'id';
$sTable       = db_prefix().'hr_sub_departments';

$where = [];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], $where, ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['sub_department_name'];

    $options = '';
    $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#update_sub_department', 'data-id' => $aRow['id'], 'onclick' => 'edit(' . $aRow['id'] . ')']);
    $options .= icon_btn('hr_profile/organization/delete_sub_department/' . $aRow['id'], 'remove', 'btn-danger _delete');

        $row[]   = $options;

    $output['aaData'][] = $row;
}
