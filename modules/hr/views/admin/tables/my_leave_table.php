<?php

defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = [
    db_prefix().'hr_leave_type.name as type',
    'CONCAT(firstname," ", lastname) as fullname', 
    'CONCAT("'._l("from").': ", start_date,"<br>'._l("to").' ", end_date) as request_duration', 
    'created'
];

if(get_staff_default_language() == 'arabic'){
    $aColumns[] = db_prefix().'branches.title_ar as branch_id';
}else{
    $aColumns[] = db_prefix().'branches.title_en as branch_id';
}

$sIndexColumn = 'id';
$sTable       = db_prefix().'hr_leaves';

$join = [
    'LEFT JOIN '.db_prefix().'staff ON '.db_prefix().'staff.staffid='.db_prefix().'hr_leaves.staff_id',
    'LEFT JOIN '.db_prefix().'branches_services ON '.db_prefix().'branches_services.rel_id='.db_prefix().'staff.staffid AND '.db_prefix().'branches_services.rel_type="staff"',
    'LEFT JOIN '.db_prefix().'branches ON '.db_prefix().'branches.id='.db_prefix().'branches_services.branch_id',
    'LEFT JOIN '.db_prefix().'hr_leave_type ON '.db_prefix().'hr_leave_type.id='.db_prefix().'hr_leaves.leave_type'
];

$where = [];
if(isset($staff_id)){
    $where[] = 'AND staff_id='.$staff_id;
}


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix().'hr_leaves.id', 'status']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];

    $row[] = $aRow['type'] . "<br>Status : " . $aRow['status'];

    $row[] = $aRow['branch_id'];
    
    $row[] = $aRow['fullname'];

    $row[] = $aRow['request_duration'];

    $row[] = $aRow['created'];


    $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#update_travel', 'data-id' => $aRow['id'], 'onclick' => 'edit(' . $aRow['id'] . ')']);
    $row[]   = $options .= icon_btn('hr/timesheet/delete_leave/' . $aRow['id'], 'remove', 'btn-danger _delete');
    

    $output['aaData'][] = $row;
}
