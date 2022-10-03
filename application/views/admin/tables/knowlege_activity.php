<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    'subject',
    'type',
    'groupid',
    'staff_id',
    'process',
    'datecreated',
];
$sIndexColumn     = 'id';
$sTable           = db_prefix() . 'knowlege_activity';
$additionalSelect = [];
$join = [];
$where   = [];
$filter  = [];
$groups  = $this->ci->knowledge_base_model->get_kbg();
$_groups = [];
foreach ($groups as $group) {
    if ($this->ci->input->post('kb_group_' . $group['groupid'])) {
        array_push($_groups, $group['groupid']);
    }
}
if (count($_groups) > 0) {
    array_push($filter, 'AND type IN (' . implode(', ', $_groups) . ')');
}
if (count($filter) > 0) {
    array_push($where, 'AND (' . prepare_dt_filter($filter) . ')');
}

//if (!has_permission('knowledge_base', '', 'create') && !has_permission('knowledge_base', '', 'edit')) {
//    array_push($where, ' AND ' . db_prefix() . 'knowledge_base.active=1');
//}

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, $additionalSelect);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    for ($i = 0; $i < count($aColumns); $i++) {
        $_data = $aRow[$aColumns[$i]];
        if ($aColumns[$i] == 'groupid') {
            $_data = kb_all_main_group_name($aRow['groupid']);
        } elseif ($aColumns[$i] == 'datecreated') {
            $_data = _dt($_data);
        } elseif ($aColumns[$i] == 'type') {
            $_data = kb_group_name($aRow['type'])->name;
        } elseif ($aColumns[$i] == 'staff_id') {
            $_data = get_staff_full_name($aRow['staff_id']);
        } elseif ($aColumns[$i] == 'process') {
            $_data = _l($aRow['process']);
        }

        $row[]              = $_data;
//        $row['DT_RowClass'] = 'has-row-options';
    }

    $output['aaData'][] = $row;
}
