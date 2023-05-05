<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    'name',
    'country',
];
$sIndexColumn = 'id';
$sTable = db_prefix() . 'nezam_vers';
$join = [];
$where = [];
$filter = [];
if (count($filter) > 0) {
    array_push($where, 'AND (' . prepare_dt_filter($filter) . ')');
}
$additionalSelect = ['id'];

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, $additionalSelect);
$output = $result['output'];
$rResult = $result['rResult'];

$staff_language = get_staff_default_language(get_staff_user_id());
foreach ($rResult as $aRow) {
    $row = [];
    for ($i = 0; $i < count($aColumns); $i++) {
        $_data = '';
        if ($aColumns[$i] == 'name') {
            $_data .=  $aRow['name'];
            $_data .= '<div class="row-options">';
//            if ($hasPermissionEdit) {
                $_data .= ' <a href="' . admin_url('knowledge_base/knowlege_nezam_vers/' . $aRow['id']) . '">' . _l('edit') . '</a>';
//            }
//            if ($hasPermissionDelete) {
                $_data .= ' | <a href="' . admin_url('knowledge_base/delete_nezam_vers/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
//            }
            $_data .= '</div>';
        }

        if ($aColumns[$i] == 'country') {
            $_data = get_country_name_by_staff_default_language($aRow['country'],$staff_language);
        }
        $row[] = $_data;
    }
    $output['aaData'][] = $row;
}
