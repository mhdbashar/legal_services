<?php

defined('BASEPATH') or exit('No direct script access allowed');

$custom_fields = get_table_custom_fields('messages');

$aColumns = [
    '1',
    db_prefix() . 'messages.id as id',
    'subject',
    'to_user_id',
    'created_at',
];

$join = [];

foreach ($custom_fields as $key => $field) {
    $selectAs = (is_cf_date($field) ? 'date_picker_cvalue_' . $key : 'cvalue_' . $key);
    array_push($customFieldsColumns, $selectAs);
    array_push($aColumns, 'ctable_' . $key . '.value as ' . $selectAs);
    array_push($join, 'LEFT JOIN ' . db_prefix() . 'customfieldsvalues as ctable_' . $key . ' ON ' . db_prefix() . 'messages.id = ctable_' . $key . '.relid AND ctable_' . $key . '.fieldto="' . $field['fieldto'] . '" AND ctable_' . $key . '.fieldid=' . $field['id']);
}

$filter = [];
$sIndexColumn = 'id';
$sTable = db_prefix() . 'messages';
$y = get_staff_user_id() . '_staff';

$where = [];

$where = ['AND from_user_id like "' . $y . '" '];
array_push($where, 'AND message_id = 0 ');

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where);

$output = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];

    $row[] = '<div class="checkbox"><input type="checkbox" value="' . $aRow['id'] . '"><label></label></div>';

    $row[] = $aRow['id'];
    $row[] = $aRow['created_at'];
    // $row[] = $aRow['to_user_id'];
    $member = $model->GetSender_get($aRow['to_user_id']);

    $row[] = $member->firstname . ' ' . $member->lastname;

    if (has_permission('messages_manage', '', 'create') && has_permission('messages_manage', '', 'edit')) {
        $link = admin_url('messages/messagecu/' . $aRow['id']);
    } else {
        $link = '#';
    }
    $_data = ' <a href="' . admin_url('Messages/view_view_sent_items/' . $aRow['id']) . '">' . $aRow['subject'] . '</a>';
    $_data .= '<div class="row-options">';
    // if (has_permission('messages_manage', '', 'edit')) {
    // $_data .= ' <a href="' . admin_url('Messages/messagescu/' . $aRow['id']) . '">' . _l('edit') . '</a>';
    // }
    if (has_permission('system_messages', '', 'delete')) {
        $_data .= '  <a href="' . admin_url('Messages/messagesd/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
    }
    //$row[] = $aRow['fullname'];
    $row[] = $_data;

    // Custom fields add values
    foreach ($customFieldsColumns as $customFieldColumn) {
        $row[] = (strpos($customFieldColumn, 'date_picker_') !== false ? _d($aRow[$customFieldColumn]) : $aRow[$customFieldColumn]);
    }

    $row['DT_RowClass'] = 'has-row-options';

    $output['aaData'][] = $row;
}
