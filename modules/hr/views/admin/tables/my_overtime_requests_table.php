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
    'CONCAT(firstname," ", lastname) as fullname', 
    'in_time', 
    'out_time', 
    'status', 
];
$ci = &get_instance();
if($ci->app_modules->is_active('branches'))
if(get_staff_default_language() == 'arabic'){
    $aColumns[] = db_prefix().'branches.title_ar as branch_id';
}else{
    $aColumns[] = db_prefix().'branches.title_en as branch_id';
}

$sIndexColumn = 'id';
$sTable       = db_prefix().'hr_overtime_request';

$join = [
	'LEFT JOIN '.db_prefix().'staff ON '.db_prefix().'staff.staffid='.db_prefix().'hr_overtime_request.staff_id',


	'LEFT JOIN '.db_prefix().'branches_services ON '.db_prefix().'branches_services.rel_id='.db_prefix().'staff.staffid AND '.db_prefix().'branches_services.rel_type="staff"',
    'LEFT JOIN '.db_prefix().'branches ON '.db_prefix().'branches.id='.db_prefix().'branches_services.branch_id'
];

$where = [];
if(isset($staff_id)){
    $where[] = 'AND staff_id='.$staff_id;
}

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix().'hr_overtime_request.id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    if($ci->app_modules->is_active('branches'))
    $row[] = $aRow['branch_id'];
    
    $row[] = $aRow['fullname'];

    $row[] = $aRow['in_time'];

    $row[] = $aRow['out_time'];

    $row[] = $aRow['status'];

    if (has_permission('hr', '', 'view')){
        $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#update_travel', 'data-id' => $aRow['id'], 'onclick' => 'edit(' . $aRow['id'] . ')']);
        $options .= icon_btn('hr/timesheet/delete_overtime_request/' . $aRow['id'], 'remove', 'btn-danger _delete');
    }

    else
        $options = '';

    $row[]   = $options;
    

    $output['aaData'][] = $row;
}
