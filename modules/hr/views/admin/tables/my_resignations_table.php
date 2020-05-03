<?php
defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = ['CONCAT(firstname," ", lastname) as fullname', 'notice_date', 'resignation_date'];

if(get_staff_default_language() == 'arabic'){
    $aColumns[] = db_prefix().'branches.title_ar as branch_id';
}else{
    $aColumns[] = db_prefix().'branches.title_en as branch_id';
}

$sIndexColumn = 'id';
$sTable       = db_prefix().'hr_resignations';

$join = [
    'LEFT JOIN '.db_prefix().'staff ON '.db_prefix().'staff.staffid='.db_prefix().'hr_resignations.staff_id',
    'LEFT JOIN '.db_prefix().'branches_services ON '.db_prefix().'branches_services.rel_id='.db_prefix().'hr_resignations.id AND '.db_prefix().'branches_services.rel_type="resignations"',
    'LEFT JOIN '.db_prefix().'branches ON '.db_prefix().'branches.id='.db_prefix().'branches_services.branch_id'
];

$where = [];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix().'hr_resignations.id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['fullname'];

    $row[] = $aRow['branch_id'];

    $row[] = $aRow['notice_date'];

    $row[] = $aRow['resignation_date'];

    $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#update_resignation', 'data-id' => $aRow['id'], 'onclick' => 'edit(' . $aRow['id'] . ')']);
    $row[]   = $options .= icon_btn('hr/core_hr/delete_resignation/' . $aRow['id'], 'remove', 'btn-danger _delete');
    

    $output['aaData'][] = $row;
}
