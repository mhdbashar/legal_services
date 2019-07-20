<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = ['main_salary', 'transportation_expenses', 
'other_expenses','CONCAT(firstname, " ", lastname) as full_name', db_prefix() . 'my_newstaff.user_id'];
// $aColumns = ['description', 'start_date', 'end_date','firstname, lastname', db_prefix() . 'vac.id'];


$sIndexColumn = 'user_id';
$sTable       = db_prefix().'my_newstaff';

$where  = [];

$join = [
    'JOIN '.db_prefix().'staff ON '.db_prefix().'staff.staffid = '.db_prefix().'my_newstaff.staff_id',
];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, [], ['user_id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['full_name'];
    // $row[] = $aRow['firstname']." ".$aRow['lastname'];


    $row[] = $aRow['main_salary'];

    $row[] = $aRow['transportation_expenses'];

    $row[] = $aRow['other_expenses'];

    $row[] = $aRow['other_expenses'] + $aRow['transportation_expenses'] + $aRow['main_salary'];

    $row[] = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#managesalary', 'data-id' => $aRow['user_id'], 'onclick' => 'edit_managesalary_json(' . $aRow['user_id'] . ')']);
    

    $output['aaData'][] = $row;
}
