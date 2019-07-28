<?php
defined('BASEPATH') or exit('No direct script access allowed');
$custom_fields         = get_table_custom_fields('proc_state');
$aColumns = [
    '1',
    'tblprocurationstate.id as id',
    'procurationstate',
];
$join = [];
foreach ($custom_fields as $key => $field) {
    $selectAs = (is_cf_date($field) ? 'date_picker_cvalue_' . $key : 'cvalue_' . $key);
    array_push($customFieldsColumns, $selectAs);
    array_push($aColumns, 'ctable_' . $key . '.value as ' . $selectAs);
    array_push($join, 'LEFT JOIN ' . db_prefix() . 'customfieldsvalues as ctable_' . $key . ' ON ' . db_prefix() . 'procurationstate.id = ctable_' . $key . '.relid AND ctable_' . $key . '.fieldto="' . $field['fieldto'] . '" AND ctable_' . $key . '.fieldid=' . $field['id']);
}
$where  = [];
$filter = [];
$sIndexColumn = 'id';
$sTable       = db_prefix() . 'procurationstate';
$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where);
// echo "hello test"
$output  = $result['output'];
$rResult = $result['rResult'];
foreach ($rResult as $aRow) {
    $row = [];
    $row[] = '<div class="checkbox"><input type="checkbox" value="' . $aRow['id'] . '"><label></label></div>';
    $row[] = $aRow['id'];
    $_data = ' <a href="' . admin_url('procuration/statecu/' . $aRow['id']) . '">' . $aRow['procurationstate'] . '</a>';
    $_data .= '<div class="row-options">';
    $_data .= ' <a href="' . admin_url('procuration/statecu/' . $aRow['id']) . '">' . _l('edit') . '</a>';
    $_data .= ' | <a href="' . admin_url('procuration/stated/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
    $row[] = $_data;
    // Custom fields add values
    foreach ($customFieldsColumns as $customFieldColumn) {
            $row[] = (strpos($customFieldColumn, 'date_picker_') !== false ? _d($aRow[$customFieldColumn]) : $aRow[$customFieldColumn]);
        }
    $row['DT_RowClass'] = 'has-row-options';
    $output['aaData'][] = $row;
}