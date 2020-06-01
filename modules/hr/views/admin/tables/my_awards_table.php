<?php
/*
`id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `award_type` varchar(200) NOT NULL,
    `date` date NOT NULL,
    `gift` varchar(200) NOT NULL,
    `cash` bigint NOT NULL,
    `description` text NOT NULL,
    `award_information` text NOT NULL,
    `award_photo` varchar(200) NOT NULL,
    `staff_id` int(11) NOT NULL
*/
defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = ['award_type', 'CONCAT(firstname, " ", lastname) as fullname', 'gift'];

$ci = &get_instance();
if($ci->app_modules->is_active('branches'))
if(get_staff_default_language() == 'arabic'){
    $aColumns[] = db_prefix().'branches.title_ar as branch_id';
}else{
    $aColumns[] = db_prefix().'branches.title_en as branch_id';
}

$sIndexColumn = 'id';
$sTable       = db_prefix().'hr_awards';

$join = [
	'LEFT JOIN '.db_prefix().'staff ON '.db_prefix().'staff.staffid='.db_prefix().'hr_awards.staff_id',
	'LEFT JOIN '.db_prefix().'branches_services ON '.db_prefix().'branches_services.rel_id='.db_prefix().'hr_awards.id AND '.db_prefix().'branches_services.rel_type="awards"',
	'LEFT JOIN '.db_prefix().'branches ON '.db_prefix().'branches.id='.db_prefix().'branches_services.branch_id'
];

$where = [];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix().'hr_awards.id', 'award_photo']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['award_type'];

    $row[] = $aRow['fullname'];
$ci = &get_instance();
if($ci->app_modules->is_active('branches'))
    $row[] = $aRow['branch_id'];

    $row[] = $aRow['gift'];

    $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#update_document', 'data-id' => $aRow['id'], 'onclick' => 'edit(' . $aRow['id'] . ')']);
    $options .= icon_btn(base_url().$aRow['award_photo'], 'download', 'btn-default','download');
    $row[]   = $options .= icon_btn('hr/core_hr/delete_document/' . $aRow['id'], 'remove', 'btn-danger _delete');
    

    $output['aaData'][] = $row;
}
