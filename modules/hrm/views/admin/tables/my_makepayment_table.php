<?php
defined('BASEPATH') or exit('No direct script access allowed');

$custom_fields         = get_table_custom_fields('salary');

$aColumns = [
    'CONCAT(firstname, " ", lastname) as full_name', 
    'job_title', 
    'payment_month', 
    'CONCAT(other_expenses + main_salary + transportation_expenses + IFNULL(award ,0)) as full_salary', 
    'staffid'
];
// $aColumns = ['description', 'start_date', 'end_date','firstname, lastname', db_prefix() . 'vac.id'];


$sIndexColumn = 'staff_id';
$sTable       = db_prefix().'newstaff';

$where  = [];

$join = [
    'LEFT JOIN '.db_prefix().'salary ON '.db_prefix().'salary.payment_month = "'.$month.'" AND '.db_prefix().'salary.staff_id = '.db_prefix().'newstaff.staff_id',
    'JOIN '.db_prefix().'staff ON '.db_prefix().'staff.staffid = '.db_prefix().'newstaff.staff_id',

    'LEFT JOIN 
    (SELECT SUM(award)  award, staff_id, date FROM '.db_prefix().'award GROUP BY staff_id) as p 
    ON p.date = "'.$month.'" AND p.staff_id = '.db_prefix().'newstaff.staff_id '
    
];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, [], []);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {

    if($aRow['payment_month'] == $month) continue; 

    $row = [];
    
    $row[] = $aRow['staffid'];
    $row[] = $aRow['full_name'];
    $row[] = $aRow['full_salary'];
    

    $row[] = $aRow['job_title'];


    $row[]   = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#make_payment', 'data-id' => $aRow['staffid'], 'onclick' => 'make_payment_json(' . $aRow['staffid'] . ')']);
    

    $output['aaData'][] = $row;
}
