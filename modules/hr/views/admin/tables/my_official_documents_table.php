<?php

defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = ['document_type', 'document_title', 'date_expiry', 'document_file'];

$sIndexColumn = 'id';
$sTable       = db_prefix().'hr_official_documents';

$where = [];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], $where, ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['document_type'];

    $row[] = $aRow['document_title'];

    $row[] = $aRow['date_expiry'];


// file

    $file = '';
    if(basename($aRow["document_file"]) != '' and file_exists($aRow["document_file"])){
        $file = '<a target="_blank" href="'.base_url(). $aRow['document_file'].'">';
        $is_image = is_image($aRow['document_file']);

        if($is_image){
            $file .= '<div class="preview_image">';
        }
        if ($is_image) {
            $file .=  '<img class="project-file-image img-table-loading" src="' . base_url().$aRow['document_file'] . '" width="100">';

        }else{
            $file .='<i class="'.get_mime_class(mime_content_type($aRow["document_file"])).' "></i> '. basename($aRow["document_file"]);
        }
        if($is_image){ $file .= '</div>'; }
        $file .=  '</a>';
    }
    $row[] = $file;

// end file

    $options = ''; if (has_permission('hr', '', 'edit')) $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#update_document', 'data-id' => $aRow['id'], 'onclick' => 'edit(' . $aRow['id'] . ')']);
    if (has_permission('hr', '', 'delete')) $options .= icon_btn('hr/organization/delete_document/' . $aRow['id'], 'remove', 'btn-danger _delete');
    if (has_permission('hr', '', 'edit') || has_permission('hr', '', 'delete') )
        $row[]   = $options;

    $output['aaData'][] = $row;
}
