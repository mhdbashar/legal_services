<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = ['firstname', 'net_salary', "DATE_FORMAT(created,'%Y/%m') AS payroll_month", 'created', '(SELECT '.db_prefix().'hr_payments.id) AS payment_id'];

$sIndexColumn = 'id';
$sTable       = db_prefix().'hr_payments';

$join = [
	'LEFT JOIN '.db_prefix().'staff ON '.db_prefix().'staff.staffid='.db_prefix().'hr_payments.staff_id'
];

$ci = &get_instance();
//    if(get_staff_default_language() == 'arabic'){
//        $aColumns[] = db_prefix().'branches.title_ar as branch_id';
//    }else{
//        $aColumns[] = db_prefix().'branches.title_en as branch_id';
//    }
//    $join[] = 'LEFT JOIN '.db_prefix().'branches_services ON '.db_prefix().'branches_services.rel_id='.db_prefix().'staff.staffid AND '.db_prefix().'branches_services.rel_type="staff"';
//
//    $join[] = 'LEFT JOIN '.db_prefix().'branches ON '.db_prefix().'branches.id='.db_prefix().'branches_services.branch_id';

$where = [];

if(has_permission('hr', '', 'view_own') && !has_permission('hr', '', 'view')){
    $where[] = 'AND '. db_prefix() . 'staff.staffid='.get_staff_user_id();
}

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, ['lastname']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['firstname'] .' '. $aRow['lastname'];

        // $row[] = $aRow['branch_id'];

    $row[] = $aRow['net_salary'];

    $row[] = $aRow['payroll_month'];

    $row[] = $aRow['created'];

    $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#show_payment', 'data-id' => $aRow['payment_id'], 'onclick' => 'payment(' . $aRow['payment_id'] . ')']);
    $row[]   = $options;
    

    $output['aaData'][] = $row;
}
