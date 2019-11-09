<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = ['event_name', 'start_date', 'end_date', 'color'];

$sIndexColumn = 'holiday_id';
$sTable       = db_prefix().'hr_holiday';

$where = [
	'AND MONTH(start_date)='.$month,
	'AND YEAR(start_date)='.$year
];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], $where, ['holiday_id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['event_name'];

    $row[] = $aRow['start_date'];

    $row[] = $aRow['end_date'];

    $row[] = $aRow['color'];

    $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#update_holiday', 'data-id' => $aRow['holiday_id'], 'onclick' => 'edit(' . $aRow['holiday_id'] . ')']);
    $row[]   = $options .= icon_btn('hr/Holidays/delete/' . $aRow['holiday_id'], 'remove', 'btn-danger _delete');
    

    $output['aaData'][] = $row;
}
