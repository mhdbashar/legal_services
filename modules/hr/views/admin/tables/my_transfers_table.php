<?php

/*
`id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `transfer_date` date NOT NULL,
    `description` text NOT NULL,
    `to_department` int(11) NOT NULL,
    `to_sub_department` int(11) NOT NULL,
    `staff_id` int(11) NOT NULL
*/

defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = [
    'CONCAT(firstname," ", lastname) as fullname', 
    'transfer_date', 
    'status'
];

$ci = &get_instance();
// if($ci->app_modules->is_active('branches'))
//if(get_staff_default_language() == 'arabic'){
//    $aColumns[] = db_prefix().'branches.title_ar as branch_id';
//}else{
//    $aColumns[] = db_prefix().'branches.title_en as branch_id';
//}

$sIndexColumn = 'id';
$sTable       = db_prefix().'hr_transfers';

$join = [
	'LEFT JOIN '.db_prefix().'staff ON '.db_prefix().'staff.staffid='.db_prefix().'hr_transfers.staff_id',
//	'LEFT JOIN '.db_prefix().'branches_services ON '.db_prefix().'branches_services.rel_id='.db_prefix().'hr_transfers.id AND '.db_prefix().'branches_services.rel_type="transfers"',
//	'LEFT JOIN '.db_prefix().'branches ON '.db_prefix().'branches.id='.db_prefix().'branches_services.branch_id'
];

$where = [];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix().'hr_transfers.id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['fullname'];
//$ci = &get_instance();
//if($ci->app_modules->is_active('branches'))
//    $row[] = $aRow['branch_id'];

    $row[] = $aRow['transfer_date'];

    $row[] = $aRow['status'];

    $options = ''; if (has_permission('hr', '', 'edit')) $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#update_transfer', 'data-id' => $aRow['id'], 'onclick' => 'edit(' . $aRow['id'] . ')']);
    if (has_permission('hr', '', 'delete'))$options .= icon_btn('hr/core_hr/delete_transfer/' . $aRow['id'], 'remove', 'btn-danger _delete');
    $row[]   = $options;

    $output['aaData'][] = $row;
}
