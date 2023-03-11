<?php

defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = ['company_name', 'post', 'from_date', 'to_date', 'description'];

$sIndexColumn = 'id';
$sTable       = db_prefix().'hr_work_experience';

$where = ['AND staff_id='.$staff_id];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], $where, ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['company_name'];

    $row[] = $aRow['post'];

    $row[] = $aRow['from_date'];

    $row[] = $aRow['to_date'];

    $row[] = $aRow['description'];

    $options = ''; if (has_permission('hr', '', 'edit')) $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#update_work_experience', 'data-id' => $aRow['id'], 'onclick' => 'edit(' . $aRow['id'] . ')']);
    if (has_permission('hr', '', 'delete')) $options .= icon_btn('hr/general/delete_work_experience/' . $aRow['id'], 'remove', 'btn-danger _delete');
    $row[]   = $options;

    $output['aaData'][] = $row;
}
