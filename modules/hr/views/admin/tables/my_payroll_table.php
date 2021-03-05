<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
	'CONCAT(firstname, " ", lastname) as full_name',
	db_prefix().'hr_salary.amount as amount', 
	db_prefix().'hr_salary.type as type',
	db_prefix().'hr_payments.payment_date as payment_date', 
	db_prefix().'hr_salary.staff_id as staff_id'
];

$sIndexColumn = 'staffid';
$sTable       = db_prefix().'staff';

$where = [];

$join = [
	'INNER JOIN '.db_prefix().'hr_salary ON '.db_prefix().'hr_salary.staff_id='.db_prefix().'staff.staffid AND '.db_prefix().'hr_salary.type=1',
	'LEFT JOIN '.db_prefix().'hr_payments ON '.db_prefix().'hr_payments.staff_id='.db_prefix().'staff.staffid AND MONTH(payment_date)='.$month.' AND YEAR(payment_date)='.$year,
];

if(has_permission('hr', '', 'view_own') && !has_permission('hr', '', 'view')){
    $where[] = 'AND '. db_prefix() . 'staff.staffid='.get_staff_user_id();
}

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, ['staffid', '(SELECT '.db_prefix().'hr_payments.id) AS payment_id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['full_name'];

    if($aRow['type'] == 1){
    	$row[] = 'Monthly Payslip';
    }elseif($aRow['type'] == 2){
    	$row[] = 'Hourly Payslip';
    }

    $row[] = $aRow['amount'];

    if($aRow['payment_date'] != ''){
    	$paid = true;
    	$row[] = '<div class="text-success">paid</div>';
    }else{
    	$paid = false;
    	$row[] = '<div class="text-danger">un paid</div>';
    }


    if($paid){
    	$options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#show_payment', 'data-id' => $aRow['payment_id'], 'onclick' => 'payment(' . $aRow['payment_id'] . ')']);
    }else{
    	$options = icon_btn('#', 'fa fas fa-money', 'btn-success', ['data-toggle' => 'modal', 'data-target' => '#make_payment', 'data-id' => $aRow['staff_id'], 'onclick' => 'make_payment(' . $aRow['staff_id'] . ',' . $month . ',' . $year . ')']);
    }
    
    $row[]   = $options;
    

    $output['aaData'][] = $row;
}
