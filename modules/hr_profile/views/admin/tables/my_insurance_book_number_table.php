<?php

defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = [
    'name',
    'company_name',
    'start_date',
    'end_date',
    'file'
];

$sIndexColumn = 'id';
$sTable       = db_prefix().'insurance_book_nums';

$where = [];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], $where, ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];

    $row[] = $aRow['name'];
    $row[] = $aRow['company_name'];
    $row[] = $aRow['start_date'];
    $row[] = $aRow['end_date'];

    // file

    $file = '';
    if(basename($aRow["file"]) != '' and file_exists($aRow["file"])){
        $file = '<a target="_blank" href="'.base_url(). $aRow['file'].'">';
        $is_image = is_image($aRow['file']);

        if($is_image){
            $file .= '<div class="preview_image">';
        }
        if ($is_image) {
            $file .=  '<img class="project-file-image img-table-loading" src="' . base_url().$aRow['file'] . '" width="100">';

        }else{
            $file .='<i class="'.get_mime_class(mime_content_type($aRow["file"])).' "></i> '. basename($aRow["file"]);
        }
        if($is_image){ $file .= '</div>'; }
        $file .=  '</a>';
    }

    $row[] = $file;

    $options = ''; if (has_permission('hr_profile_settings', '', 'edit')) $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#update_type', 'data-id' => $aRow['id'], 'onclick' => 'edit(' . $aRow['id'] . ')']);
    if (has_permission('hr_profile_settings', '', 'delete')) $options .= icon_btn('hr_profile/hr_profile/delete_insurance_book_num/' . $aRow['id'], 'remove', 'btn-danger _delete');
    $row[]   = $options;

    $output['aaData'][] = $row;
}
