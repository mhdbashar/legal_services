<?php

defined('BASEPATH') or exit('No direct script access allowed');

$custom_fields         = get_table_custom_fields('salary');

$aColumns = ['paid_date', 'payment_month', 'comments',
'CONCAT(firstname, " ", lastname) as full_name',
 'ammount', 'id'];
// $aColumns = ['description', 'start_date', 'end_date','firstname, lastname', db_prefix() . 'vac.id'];


$sIndexColumn = 'id';
$sTable       = db_prefix().'my_salary';

$where  = [];
if(isset($staff_id)){
    $where[] = 'AND staff_id = '. $staff_id;
}

$join = [
    'JOIN '.db_prefix().'staff ON '.db_prefix().'staff.staffid = '.db_prefix().'my_salary.staff_id',
];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, []);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['full_name'];
    
    // $row[] = $aRow['firstname']." ".$aRow['lastname'];

    $row[] = $aRow['ammount'];

    $row[] = $aRow['paid_date'];

    $row[] = $aRow['payment_month'];

    $row[] = $aRow['comments'];

    $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#edit_payment', 'data-id' => $aRow['id'], 'onclick' => 'edit_payment_json(' . $aRow['id'] . ')']);
    $row[]   = $options .= icon_btn('hrm/payments/delete/' . $aRow['id'], 'remove', 'btn-danger _delete');
    

    $output['aaData'][] = $row;
}
