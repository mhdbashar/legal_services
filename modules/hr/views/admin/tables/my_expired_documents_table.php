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

    $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#update_document', 'data-id' => $aRow['id'], 'onclick' => 'edit(' . $aRow['id'] . ')']);
    $row[]   = $options .= icon_btn('hr/general/delete_document/' . $aRow['id'], 'remove', 'btn-danger _delete');
    

    $output['aaData'][] = $row;
}
