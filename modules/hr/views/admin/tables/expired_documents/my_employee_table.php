<?php

defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = ['document_type', 'document_title', 'CONCAT(firstname, " ", lastname) as fullname', 'date_expiry'];

$sIndexColumn = 'id';
$sTable       = db_prefix().'hr_documents';

$now = date('Y/m/d');

$join = [
	'LEFT JOIN '.db_prefix().'staff ON '.db_prefix().'hr_documents.staff_id='.db_prefix().'staff.staffid'
];

$where = ['AND date_expiry<=CURDATE() '];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['document_type'];

    $row[] = $aRow['document_title'];

    $row[] = $aRow['fullname'];

    $row[] = $aRow['date_expiry'];
if (has_permission('hr', '', 'delete')){
    $row[]   = icon_btn('hr/general/delete_document/' . $aRow['id'], 'remove', 'btn-danger _delete');
} else $row[] = '';

    $output['aaData'][] = $row;
}
