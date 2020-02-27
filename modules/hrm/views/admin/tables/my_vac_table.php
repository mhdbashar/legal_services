<?php

defined('BASEPATH') or exit('No direct script access allowed');

$custom_fields         = get_table_custom_fields('vac');

$aColumns = ['description', 'start_date', 'end_date','CONCAT(firstname, " ", lastname) as full_name', db_prefix() . 'my_vac.id'];
// $aColumns = ['description', 'start_date', 'end_date','firstname, lastname', db_prefix() . 'vac.id'];


$sIndexColumn = 'id';
$sTable       = db_prefix().'my_vac';

$where  = [];
if(isset($staff_id)){
    $where[] = 'AND staff_id = '. $staff_id;
}

$join = [
    'JOIN '.db_prefix().'staff ON '.db_prefix().'staff.staffid = '.db_prefix().'my_vac.staff_id',
];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['full_name'];
    // $row[] = $aRow['firstname']." ".$aRow['lastname'];


    $row[] = $aRow['description'];

    $row[] = $aRow['start_date'];

    $row[] = $aRow['end_date'];

    $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#edit_vac', 'data-id' => $aRow['id'], 'onclick' => 'edit_vac_json(' . $aRow['id'] . ')']);
    $row[]   = $options .= icon_btn('hrm/vac/delete/' . $aRow['id'], 'remove', 'btn-danger _delete');
    

    $output['aaData'][] = $row;
}
