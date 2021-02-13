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

    $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#update_statutory_deduction', 'data-id' => $aRow['id'], 'onclick' => 'edit(' . $aRow['id'] . ')']);
    $row[]   = $options .= icon_btn('hr/details/delete_statutory_deduction/' . $aRow['id'], 'remove', 'btn-danger _delete');
    

    $output['aaData'][] = $row;
}
