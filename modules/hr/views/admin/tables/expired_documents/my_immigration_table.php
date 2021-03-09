<?php

defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = ['document_type', 'document_number', 'CONCAT(firstname, " ", lastname) as fullname', 'date_expiry'];

$sIndexColumn = 'id';
$sTable       = db_prefix().'hr_immigration';

$now = date('Y/m/d');

$join = [
	'LEFT JOIN '.db_prefix().'staff ON '.db_prefix().'hr_immigration.staff_id='.db_prefix().'staff.staffid'
];

$where = ['AND date_expiry<=CURDATE() '];

if(has_permission('expired_documents', '', 'view_own') && !has_permission('expired_documents', '', 'view')){
    $where[] = 'AND '. db_prefix() . 'staff.staffid='.get_staff_user_id();
}

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['document_type'];

    $row[] = $aRow['document_number'];

    $row[] = $aRow['fullname'];

    $row[] = $aRow['date_expiry'];
if (has_permission('hr', '', 'delete')){
    $row[]   = icon_btn('hr/general/delete_immigration/' . $aRow['id'], 'remove', 'btn-danger _delete');
    } else $row[] = '';

    $output['aaData'][] = $row;
}
