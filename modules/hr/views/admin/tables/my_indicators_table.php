<?php

defined('BASEPATH') or exit('No direct script access allowed');
/*
	`id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `designation_id` int(11) NOT NULL,
    `customer_experience` varchar(200) NOT NULL,
    `marketing` varchar(200) NOT NULL,
    `administration` varchar(200) NOT NULL,
    `professionalism` varchar(200) NOT NULL,
    `integrity` varchar(200) NOT NULL,
    `attendance` varchar(200) NOT NULL,
    `added_by` int(11) NOT NULL
*/
$aColumns = [
    'CONCAT(firstname," ", lastname) as fullname', 
    db_prefix().'departments.name as department_name', 
    db_prefix().'hr_designations.designation_name as designation_name', 
    'created', 
];

$ci = &get_instance();
//if($ci->app_modules->is_active('branches'))
//if(get_staff_default_language() == 'arabic'){
//    $aColumns[] = db_prefix().'branches.title_ar as branch_id';
//}else{
//    $aColumns[] = db_prefix().'branches.title_en as branch_id';
//}

$sIndexColumn = 'id';
$sTable       = db_prefix().'hr_indicators';

$join = [
	'LEFT JOIN '.db_prefix().'staff ON '.db_prefix().'staff.staffid='.db_prefix().'hr_indicators.added_by',

	'LEFT JOIN '.db_prefix().'hr_designations ON '.db_prefix().'hr_designations.id='.db_prefix().'hr_indicators.designation_id',
    'LEFT JOIN '.db_prefix().'departments ON '.db_prefix().'departments.departmentid='.db_prefix().'hr_designations.department_id',

//	'LEFT JOIN '.db_prefix().'branches_services ON '.db_prefix().'branches_services.rel_id='.db_prefix().'departments.departmentid AND '.db_prefix().'branches_services.rel_type="departments"',
//	'LEFT JOIN '.db_prefix().'branches ON '.db_prefix().'branches.id='.db_prefix().'branches_services.branch_id'
];

$where = [];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix().'hr_indicators.id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];

//    if($ci->app_modules->is_active('branches'))
//    $row[] = $aRow['branch_id'];

    $row[] = $aRow['department_name'];

    $row[] = $aRow['designation_name'];
    
    $row[] = $aRow['fullname'];

    $row[] = $aRow['created'];

    $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#update_appraisal', 'data-id' => $aRow['id'], 'onclick' => 'edit(' . $aRow['id'] . ')']);
    $row[]   = $options .= icon_btn('hr/performance/delete_indicator/' . $aRow['id'], 'remove', 'btn-danger _delete');
    

    $output['aaData'][] = $row;
}
