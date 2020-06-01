<?php

defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = ['document_type', 'document_title', 'notification_email', 'date_expiry', 'document_file'];

$sIndexColumn = 'id';
$sTable       = db_prefix().'hr_documents';

$where = ['AND staff_id='.$staff_id];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], $where, ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['document_type'];

    $row[] = $aRow['document_title'];

    $row[] = $aRow['notification_email'];

    $row[] = $aRow['date_expiry'];

    $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#update_document', 'data-id' => $aRow['id'], 'onclick' => 'edit(' . $aRow['id'] . ')']);
    $options .= icon_btn(base_url().$aRow['document_file'], 'download', 'btn-default','download');
    $row[]   = $options .= icon_btn('hr/general/delete_document/' . $aRow['id'], 'remove', 'btn-danger _delete');
    

    $output['aaData'][] = $row;
}
