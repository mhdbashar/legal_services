<?php

defined('BASEPATH') or exit('No direct script access allowed');
/*
id int(11)
title varchar(200)
amount bigint
start_date date
end_date date
reason text
staff_id int(11)
*/
$aColumns = ['id', 'title', 'amount', 'start_date', 'end_date', 'reason'];

$sIndexColumn = 'id';
$sTable       = db_prefix().'hr_loan';

$where = ['AND staff_id='.$staff_id];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], $where, ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['id'];

    $row[] = $aRow['title'];

    $row[] = $aRow['amount'];

    $row[] = $aRow['start_date'];

    $row[] = $aRow['end_date'];

    $row[] = $aRow['reason'];

    $options = ''; if (has_permission('hr', '', 'edit')) $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#update_loan', 'data-id' => $aRow['id'], 'onclick' => 'edit(' . $aRow['id'] . ')']);
    if (has_permission('hr', '', 'delete')) $options .= icon_btn('hr/details/delete_loan/' . $aRow['id'], 'remove', 'btn-danger _delete');
    $row[]   = $options;

    $output['aaData'][] = $row;
}
