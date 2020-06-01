<?php

defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = ['document_type', 'document_title', 'date_expiry'];

$sIndexColumn = 'id';
$sTable       = db_prefix().'hr_official_documents';

$now = date('Y/m/d');

$join = [];

$where = ['AND date_expiry<=CURDATE() '];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['document_type'];

    $row[] = $aRow['document_title'];

    $row[] = $aRow['date_expiry'];

    $row[]   = icon_btn('hr/organization/delete_document/' . $aRow['id'], 'remove', 'btn-danger _delete');
    

    $output['aaData'][] = $row;
}
