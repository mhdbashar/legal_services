<?php

defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = [
    'CONCAT(tostaff.firstname," ", tostaff.lastname) as complaint_againts', 
    'complaint_date', 
    'complaint_title',
    'CONCAT(bystaff.firstname," ", bystaff.lastname) as complaint_from'
];

$ci = &get_instance();
//if($ci->app_modules->is_active('branches'))
//if(get_staff_default_language() == 'arabic'){
//    $aColumns[] = db_prefix().'branches.title_ar as branch_id';
//}else{
//    $aColumns[] = db_prefix().'branches.title_en as branch_id';
//}

$sIndexColumn = 'id';
$sTable       = db_prefix().'hr_complaints';

$join = [
    'LEFT JOIN '.db_prefix().'staff as tostaff ON tostaff.staffid='.db_prefix().'hr_complaints.complaint_againts',
    'LEFT JOIN '.db_prefix().'staff as bystaff ON bystaff.staffid='.db_prefix().'hr_complaints.complaint_from',
//	'LEFT JOIN '.db_prefix().'branches_services ON '.db_prefix().'branches_services.rel_id='.db_prefix().'hr_complaints.id AND '.db_prefix().'branches_services.rel_type="complaints"',
//	'LEFT JOIN '.db_prefix().'branches ON '.db_prefix().'branches.id='.db_prefix().'branches_services.branch_id'
];

$where = [];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix().'hr_complaints.id', 'attachment']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];

    $row[] = $aRow['complaint_from'];
    
    $row[] = $aRow['complaint_againts'];
//$ci = &get_instance();
//if($ci->app_modules->is_active('branches'))
//    $row[] = $aRow['branch_id'];

    $row[] = $aRow['complaint_date'];

    $row[] = $aRow['complaint_title'];


    $options = ''; if (has_permission('hr', '', 'edit')) $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#update_complaint', 'data-id' => $aRow['id'], 'onclick' => 'edit(' . $aRow['id'] . ')']);
    $options .= icon_btn(base_url().$aRow['attachment'], 'download', 'btn-default','download');
    if (has_permission('hr', '', 'delete')) $options .= icon_btn('hr/core_hr/delete_complaint/' . $aRow['id'], 'remove', 'btn-danger _delete');
    $row[]   = $options;

    $output['aaData'][] = $row;
}
