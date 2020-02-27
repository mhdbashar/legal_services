<?php

defined('BASEPATH') or exit('No direct script access allowed');

$custom_fields         = get_table_custom_fields('vac');

$aColumns = ['award', 'reason', 'date','CONCAT(firstname, " ", lastname) as full_name', db_prefix() . 'my_award.id'];
// $aColumns = ['description', 'start_date', 'end_date','firstname, lastname', db_prefix() . 'vac.id'];


$sIndexColumn = 'id';
$sTable       = db_prefix().'my_award';

$where  = [];

$join = [
    'JOIN '.db_prefix().'staff ON '.db_prefix().'staff.staffid = '.db_prefix().'my_award.staff_id',
];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, [], ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['full_name'];
    // $row[] = $aRow['firstname']." ".$aRow['lastname'];


    $row[] = $aRow['award'];

    $row[] = $aRow['reason'];

    $row[] = $aRow['date'];

    $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#edit_award', 'data-id' => $aRow['id'], 'onclick' => 'edit_award_json(' . $aRow['id'] . ')']);
    $row[]   = $options .= icon_btn('hrm/award/delete/' . $aRow['id'], 'remove', 'btn-danger _delete');
    

    $output['aaData'][] = $row;
}
