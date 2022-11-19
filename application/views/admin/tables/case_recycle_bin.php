<?php defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = [
    db_prefix() .'my_cases.id as id',
    'name',
];
$join   = [];
$where  = [];
$filter = [];
array_push($where, 'AND ' . db_prefix() . 'my_cases.deleted = 1');
$sIndexColumn = 'id';
$sTable  = db_prefix() . 'my_cases';
$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where);
$output  = $result['output'];
$rResult = $result['rResult'];
$i = 1;
foreach ($rResult as $aRow) {
    $row = [];
    $row[] = $i;
    $row[] = $aRow['name'];
    $_data = '';
    if (has_permission('legal_recycle_bin', '', 'restore')) {
        $_data .= '<a href=' . admin_url("legalservices/legal_services/restore_legal_services/" . $ServID . '/' . $aRow['id'] . "") . ' class="btn btn-warning btn-icon _delete" data-toggle="tooltip" data-placement="top" title="' . _l('restore') . '"><i class="fa fa-undo"></i></a>';
    }
    if (has_permission('legal_recycle_bin', '', 'delete')) {
        $_data .= '<a href=' . admin_url("Case/delete/" . $ServID . '/' . $aRow['id'] . "") . ' class="btn btn-danger btn-icon _delete" data-toggle="tooltip" data-placement="top" title="' . _l('delete') . '"><i class="fa fa-trash"></i></a>';
    }
    $row[] = $_data;
    $output['aaData'][] = $row;
    $i++;
}