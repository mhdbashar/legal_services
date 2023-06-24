<?php
/*

id int(11)
deduction_type varchar(200)
title varchar(200)
amount bigint
staff_id int(11)
*/
defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = ['id', 'deduction_type', 'title', 'amount'];

$sIndexColumn = 'id';
$sTable       = db_prefix().'hr_statutory_deductions';

$where = ['AND staff_id='.$staff_id];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], $where, ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['id'];

    $row[] = $aRow['deduction_type'];

    $row[] = $aRow['title'];

    $row[] = $aRow['amount'];

    $options = ''; if (has_permission('statutory_deductions', '', 'edit')) $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#update_statutory_deduction', 'data-id' => $aRow['id'], 'onclick' => 'edit(' . $aRow['id'] . ')']);
    if (has_permission('statutory_deductions', '', 'delete')) $options .= icon_btn('hr_profile/delete_statutory_deduction/' . $aRow['id'], 'remove', 'btn-danger _delete');
    $options .= '<a href="' . admin_url('hr_profile/loan_view_edit/' . $aRow['id']) . '">' . _l('hr_view') . '</a>';

    $row[]   = $options;

    $output['aaData'][] = $row;
}
