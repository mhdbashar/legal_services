<?php

defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = ['document_type', 'issue_date', 'date_expiry', 'country', 'eligible_review_date', 'document_file'];

$sIndexColumn = 'id';
$sTable       = db_prefix().'hr_immigration';

$where = ['AND staff_id='.$staff_id];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], $where, ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['document_type'];

    $row[] = $aRow['issue_date'];

    $row[] = $aRow['date_expiry'];

    $row[] = $aRow['country'];

    $row[] = $aRow['eligible_review_date'];

    $row[] = "<a href='".base_url().$aRow['document_file']."'>Download File</a>";

    $options = ''; if (has_permission('hr', '', 'edit')) $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#update_immigration', 'data-id' => $aRow['id'], 'onclick' => 'edit(' . $aRow['id'] . ')']);
    if (has_permission('hr', '', 'delete')) $options .= icon_btn('hr/general/delete_immigration/' . $aRow['id'], 'remove', 'btn-danger _delete');
    $row[]   = $options;

    $output['aaData'][] = $row;
}
