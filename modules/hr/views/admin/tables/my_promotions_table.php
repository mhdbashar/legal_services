<?php
defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = ['CONCAT(firstname," ", lastname) as fullname', db_prefix().'branches.title_en as branch_id', 'promotion_title', 'promotion_date'];

$sIndexColumn = 'id';
$sTable       = db_prefix().'hr_promotions';

$join = [
    'LEFT JOIN '.db_prefix().'staff ON '.db_prefix().'staff.staffid='.db_prefix().'hr_promotions.staff_id',
    'LEFT JOIN '.db_prefix().'branches_services ON '.db_prefix().'branches_services.rel_id='.db_prefix().'hr_promotions.id AND '.db_prefix().'branches_services.rel_type="promotions"',
    'LEFT JOIN '.db_prefix().'branches ON '.db_prefix().'branches.id='.db_prefix().'branches_services.branch_id'
];

$where = [];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix().'hr_promotions.id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['fullname'];

    $row[] = $aRow['branch_id'];

    $row[] = $aRow['promotion_title'];

    $row[] = $aRow['promotion_date'];

    $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#update_promotion', 'data-id' => $aRow['id'], 'onclick' => 'edit(' . $aRow['id'] . ')']);
    $row[]   = $options .= icon_btn('hr/core_hr/delete_promotion/' . $aRow['id'], 'remove', 'btn-danger _delete');
    

    $output['aaData'][] = $row;
}