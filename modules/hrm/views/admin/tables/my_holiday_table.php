<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = ['event_name', 'description', 'start_date', 'end_date'];

$sIndexColumn = 'id';
$sTable       = db_prefix().'holiday';

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], [], ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['event_name'];

    $row[] = $aRow['description'];

    $row[] = $aRow['start_date'];

    $row[] = $aRow['end_date'];

    $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#edit_holiday', 'data-id' => $aRow['id'], 'onclick' => 'edit_holiday_json(' . $aRow['id'] . ')']);
    $row[]   = $options .= icon_btn('hrm/Holidays/delete/' . $aRow['id'], 'remove', 'btn-danger _delete');
    

    $output['aaData'][] = $row;
}
