<?php
defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = ['school_university', 'from_date', 'to_date', 'education_level'];

$sIndexColumn = 'id';
$sTable       = db_prefix().'hr_qualification';

$where = [];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], $where, ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['school_university'];

    $row[] = $aRow['from_date'];

    $row[] = $aRow['to_date'];

    $row[] = $aRow['education_level'];

    $options = ''; if (has_permission('qualification', '', 'edit')) $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#update_qualification', 'data-id' => $aRow['id'], 'onclick' => 'edit(' . $aRow['id'] . ')']);
    if (has_permission('qualification', '', 'delete')) $options .= icon_btn('hr_profile/delete_qualification/' . $aRow['id'], 'remove', 'btn-danger _delete');
    $options .= '<a href="' . admin_url('hr_profile/qualifications_view_edit/' . $aRow['id']) . '">' . _l('hr_view') . '</a>';

    $row[]   = $options;

    $output['aaData'][] = $row;
}
