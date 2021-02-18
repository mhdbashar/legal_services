<?php
/*
`id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `termination_type` varchar(200) NOT NULL,
    `termination_date` date NOT NULL,
    `notice_date` date NOT NULL,
    `description` text NOT NULL,
    `award_information` text NOT NULL,
    `attachment` varchar(200) NOT NULL,
    `staff_id` int(11) NOT NULL
*/
defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = ['CONCAT(firstname," ", lastname) as fullname', 'notice_date', 'termination_date'];


$ci = &get_instance();
//if($ci->app_modules->is_active('branches'))
//if(get_staff_default_language() == 'arabic'){
//    $aColumns[] = db_prefix().'branches.title_ar as branch_id';
//}else{
//    $aColumns[] = db_prefix().'branches.title_en as branch_id';
//}

$sIndexColumn = 'id';
$sTable       = db_prefix().'hr_terminations';

$join = [
	'LEFT JOIN '.db_prefix().'staff ON '.db_prefix().'staff.staffid='.db_prefix().'hr_terminations.staff_id',
//	'LEFT JOIN '.db_prefix().'branches_services ON '.db_prefix().'branches_services.rel_id='.db_prefix().'hr_terminations.id AND '.db_prefix().'branches_services.rel_type="terminations"',
//	'LEFT JOIN '.db_prefix().'branches ON '.db_prefix().'branches.id='.db_prefix().'branches_services.branch_id'
];

$where = [];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix().'hr_terminations.id', 'attachment']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['fullname'];
//$ci = &get_instance();
//if($ci->app_modules->is_active('branches'))
//    $row[] = $aRow['branch_id'];

    $row[] = $aRow['notice_date'];

    $row[] = $aRow['termination_date'];

    $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#update_termination', 'data-id' => $aRow['id'], 'onclick' => 'edit(' . $aRow['id'] . ')']);
    $options .= icon_btn(base_url().$aRow['attachment'], 'download', 'btn-default','download');
    $row[]   = $options .= icon_btn('hr/core_hr/delete_termination/' . $aRow['id'], 'remove', 'btn-danger _delete');
    

    $output['aaData'][] = $row;
}
