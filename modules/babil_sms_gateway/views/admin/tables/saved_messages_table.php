<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    db_prefix().'saved_sms.id',
    'sender',
    'msg',
    '1',
    '1',
    'firstname',
    'created_at',
    'name'
];

$sIndexColumn = 'id';
$sTable       = db_prefix().'saved_sms';

$where = [];
//
//if(!is_admin())
//    $where[] = 'AND staff_id='.$staff_id;
$join = [
    'LEFT JOIN '.db_prefix().'staff ON '.db_prefix().'staff.staffid='.db_prefix().'saved_sms.staff_id',
    'LEFT JOIN '.db_prefix().'my_basic_services ON '.db_prefix().'my_basic_services.slug='.db_prefix().'saved_sms.rel_type'
];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix().'saved_sms.id', db_prefix() . 'my_basic_services.id as ServID', 'rel_id', 'msg_id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];

    $row[] = $aRow['id'];

    $row[] = $aRow['sender'];

    $row[] = $aRow['msg'];

    $row[] = $aRow['name'];

    $service_id = $aRow['ServID'];

        if ($service_id == 1) {
            $row[] = '<a href="' . admin_url('Case/view/' . $service_id . '/' . $aRow['rel_id']) . '?group=babil_sms_gateway">' . get_case_name_by_id($aRow['rel_id']) . '</a>';
        } else {
            $row[] = '<a href="' . admin_url('SOther/view/' . $service_id . '/' . $aRow['rel_id']) . '?group=babil_sms_gateway">' . get_oservice_name_by_id($aRow['rel_id']) . '</a>';
        }

    $row[] = $aRow['firstname'];

    $row[] = $aRow['created_at'];

    $options = '';
    //if (has_permission('hr', '', 'edit'))
        $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#update_message', 'data-id' => $aRow['msg_id'], 'onclick' => 'edit(' . $aRow['id'] . ')']);
    //if (has_permission('hr', '', 'delete'))
        $options .= icon_btn('receive_sms/delete/' . $aRow['id'], 'remove', 'btn-danger _delete');
    $row[]   = $options;

    $output['aaData'][] = $row;
}
