<?php

defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = [
    'CONCAT(tostaff.firstname," ", tostaff.lastname) as warning_to', 
    'warning_date', 
    'subject',
    'CONCAT(bystaff.firstname," ", bystaff.lastname) as warning_by'
];

$ci = &get_instance();
//if($ci->app_modules->is_active('branches'))
//if(get_staff_default_language() == 'arabic'){
//    $aColumns[] = db_prefix().'branches.title_ar as branch_id';
//}else{
//    $aColumns[] = db_prefix().'branches.title_en as branch_id';
//}

$sIndexColumn = 'id';
$sTable       = db_prefix().'hr_warnings';

$join = [
    'LEFT JOIN '.db_prefix().'staff as tostaff ON tostaff.staffid='.db_prefix().'hr_warnings.warning_to',
    'LEFT JOIN '.db_prefix().'staff as bystaff ON bystaff.staffid='.db_prefix().'hr_warnings.warning_by',
//	'LEFT JOIN '.db_prefix().'branches_services ON '.db_prefix().'branches_services.rel_id='.db_prefix().'hr_warnings.id AND '.db_prefix().'branches_services.rel_type="warnings"',
//	'LEFT JOIN '.db_prefix().'branches ON '.db_prefix().'branches.id='.db_prefix().'branches_services.branch_id'
];

$where = [];

if(has_permission('warnings', '', 'view_own') && !has_permission('warnings', '', 'view')){
    $where[] = 'AND tostaff.staffid='.get_staff_user_id().' OR bystaff.staffid='.get_staff_user_id();
}

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix().'hr_warnings.id', 'attachment']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['warning_to'];
//$ci = &get_instance();
//if($ci->app_modules->is_active('branches'))
//    $row[] = $aRow['branch_id'];

    $row[] = $aRow['warning_date'];

    $row[] = $aRow['subject'];

    $row[] = $aRow['warning_by'];

    $options = ''; if (has_permission('warnings', '', 'edit')) $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#update_warning', 'data-id' => $aRow['id'], 'onclick' => 'edit(' . $aRow['id'] . ')']);
    $options .= icon_btn(base_url().$aRow['attachment'], 'download', 'btn-default','download');
    if (has_permission('warnings', '', 'delete'))$options .= icon_btn('hr_profile/core_hr/delete_warning/' . $aRow['id'], 'remove', 'btn-danger _delete');
    $row[]   = $options;

    $output['aaData'][] = $row;
}
