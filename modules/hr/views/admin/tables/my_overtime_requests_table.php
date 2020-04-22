<?php

defined('BASEPATH') or exit('No direct script access allowed');
/*
	`id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `date` date NOT NULL,
    `in_time` varchar(200) NOT NULL,
    `out_time` varchar(200) NOT NULL,
    `reason` text NOT NULL,
    `staff_id` int(11) NOT NULL
*/
$aColumns = [
    db_prefix().'branches.title_en as branch_id', 
    'CONCAT(firstname," ", lastname) as fullname', 
    'in_time', 
    'out_time', 
    'status', 
];

$sIndexColumn = 'id';
$sTable       = db_prefix().'hr_overtime_request';

$join = [
	'LEFT JOIN '.db_prefix().'staff ON '.db_prefix().'staff.staffid='.db_prefix().'hr_overtime_request.staff_id',


	'LEFT JOIN '.db_prefix().'branches_services ON '.db_prefix().'branches_services.rel_id='.db_prefix().'staff.staffid AND '.db_prefix().'branches_services.rel_type="staff"',
    'LEFT JOIN '.db_prefix().'branches ON '.db_prefix().'branches.id='.db_prefix().'branches_services.branch_id'
];

$where = [];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix().'hr_overtime_request.id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];

    $row[] = $aRow['branch_id'];
    
    $row[] = $aRow['fullname'];

    $row[] = $aRow['in_time'];

    $row[] = $aRow['out_time'];

    $row[] = $aRow['status'];

    $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#update_overtime_request', 'data-id' => $aRow['id'], 'onclick' => 'edit(' . $aRow['id'] . ')']);
    $row[]   = $options .= icon_btn('hr/timesheet/delete_overtime_request/' . $aRow['id'], 'remove', 'btn-danger _delete');
    

    $output['aaData'][] = $row;
}
