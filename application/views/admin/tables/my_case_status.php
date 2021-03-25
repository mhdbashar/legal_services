<?php

defined('BASEPATH') or exit('No direct script access allowed');

$custom_fields         = get_table_custom_fields('cstauts');

$aColumns = [
    '1',
    db_prefix() .'my_casestatus.id as id',
    'name'
];

$join = [];

foreach ($custom_fields as $key => $field) {
    $selectAs = (is_cf_date($field) ? 'date_picker_cvalue_' . $key : 'cvalue_' . $key);
    array_push($customFieldsColumns, $selectAs);
    array_push($aColumns, 'ctable_' . $key . '.value as ' . $selectAs);
    array_push($join, 'LEFT JOIN ' . db_prefix() . 'customfieldsvalues as ctable_' . $key . ' ON ' . db_prefix() . 'my_casestatus.id = ctable_' . $key . '.relid AND ctable_' . $key . '.fieldto="' . $field['fieldto'] . '" AND ctable_' . $key . '.fieldid=' . $field['id']);
}

$where  = [];

array_push($where, 'AND ' .db_prefix() . 'my_casestatus.is_default = 0');

$filter = [];
$sIndexColumn = 'id';
$sTable       = db_prefix() . 'my_casestatus';


$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [
    db_prefix() .'my_casestatus.is_default'
]);

$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    if($aRow['is_default'] == 1)
        continue;
    $row = [];

    $row[] = '<div class="checkbox"><input type="checkbox" value="' . $aRow['id'] . '"><label></label></div>';

    $row[] = $aRow['id'];
    if (has_permission('case_status', '', 'create') && has_permission('case_status', '', 'edit')) {
        $link = admin_url('Case_status/cstatuscu/' . $aRow['id']);
    }else{
        $link = '#';
    }
    $_data = ' <a href="' . $link . '">' . $aRow['name'] . '</a>';
    $_data .= '<div class="row-options">';
    if (has_permission('case_status', '', 'edit')){
        $_data .= ' <a href="' . admin_url('Case_status/cstatuscu/' . $aRow['id']) . '">' . _l('edit') . '</a>';
    }
    if (has_permission('case_status', '', 'delete')) {
        $_data .= ' | <a href="' . admin_url('Case_status/cstatusd/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
    }
    $row[] = $_data;

    // Custom fields add values
    foreach ($customFieldsColumns as $customFieldColumn) {
            $row[] = (strpos($customFieldColumn, 'date_picker_') !== false ? _d($aRow[$customFieldColumn]) : $aRow[$customFieldColumn]);
        }

    $row['DT_RowClass'] = 'has-row-options';


    $output['aaData'][] = $row;
}