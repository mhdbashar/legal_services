<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = ['id', 'sender', 'msg', 'created_at', 'firstname'];

$sIndexColumn = 'id';
$sTable       = db_prefix().'saved_sms';

$where = [];

if(!is_admin())
    $where[] = 'AND staff_id='.$staff_id;
$join = [
    'LEFT JOIN '.db_prefix().'staff ON '.db_prefix().'staff.staffid='.db_prefix().'saved_sms.staff_id'
];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];

    $row[] = $aRow['id'];

    $row[] = $aRow['sender'];

    $row[] = $aRow['msg'];

    $row[] = $aRow['firstname'];

    $row[] = $aRow['created_at'];

    $options = '';
    //if (has_permission('hr', '', 'edit'))
        $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#update_loan', 'data-id' => $aRow['id'], 'onclick' => 'edit(' . $aRow['id'] . ')']);
    //if (has_permission('hr', '', 'delete'))
        $options .= icon_btn('hr/details/delete_loan/' . $aRow['id'], 'remove', 'btn-danger _delete');
    $row[]   = $options;

    $output['aaData'][] = $row;
}
