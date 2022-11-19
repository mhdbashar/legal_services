<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = ['designation_name'];

$sIndexColumn = 'id';
$sTable       = db_prefix().'hr_designations';

$where = [];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], $where, ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['designation_name'];

    $options = ''; if (has_permission('hr', '', 'edit')) $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#update_designation', 'data-id' => $aRow['id'], 'onclick' => 'edit(' . $aRow['id'] . ')']);
    if (has_permission('hr', '', 'delete')) $options .= icon_btn('hr/organization/delete_designation/' . $aRow['id'], 'remove', 'btn-danger _delete');
    if (has_permission('hr', '', 'edit') || has_permission('hr', '', 'delete') )
        $row[]   = $options;

    $output['aaData'][] = $row;
}
