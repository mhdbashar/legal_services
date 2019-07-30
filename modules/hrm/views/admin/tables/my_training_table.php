<?php

defined('BASEPATH') or exit('No direct script access allowed');

//$custom_fields         = get_table_custom_fields('vac');

$aColumns = ['training', 'vendor', 'start_date', 'end_date', 'cost', 'status', 'CONCAT(firstname, " ", lastname) as full_name', db_prefix().'my_training.id'];
// $aColumns = ['description', 'start_date', 'end_date','firstname, lastname', db_prefix() . 'vac.id'];


$sIndexColumn = 'id';
$sTable       = db_prefix().'my_training';

$where  = [];

$join = [
    'JOIN '.db_prefix().'staff ON '.db_prefix().'staff.staffid = '.db_prefix().'my_training.staff_id',
];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, [], ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];


$status = array(
                0 => 'Pending',
                1 => 'Started',
                2 => 'Compeleted',
                3 => 'Terminated'
        );



foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['full_name'];
    
    $row[] = $aRow['training'];
    
    $row[] = $aRow['vendor'];
    
    $row[] = $aRow['start_date'];
    
    $row[] = $aRow['end_date'];
    
    $row[] = $aRow['cost'];
    
    $row[] = $status[$aRow['status']];

    //$options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#add_training', 'data-id' => $aRow['id'], 'onclick' => 'edit_training_json(' . $aRow['id'] . ')']);
    $options = icon_btn('hrm/training/edit/' . $aRow['id'], 'pencil-square-o', 'btn-default');
    $row[]   = $options .= icon_btn('hrm/training/delete/' . $aRow['id'], 'remove', 'btn-danger _delete');
    

    $output['aaData'][] = $row;
}
