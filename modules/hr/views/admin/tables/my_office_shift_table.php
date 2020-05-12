<?php

defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = [

    'CASE WHEN '.db_prefix().'hr_office_shift.default=1 
    THEN CONCAT('.db_prefix().'hr_office_shift.shift_name,"<br>","<span class=\'text-success\'>'._l("default").'</span>")  
    ELSE CONCAT('.db_prefix().'hr_office_shift.shift_name,"<br>","<span class=\'text-danger\'>'._l("not_default").'</span>") END as shift_default', 
    'CONCAT("'._l('from').': ",TIME_FORMAT(saturday_in, "%r"),"<br>'._l('to').'",TIME_FORMAT(saturday_out, "%r")) as saturday', 
    'CONCAT("'._l('from').': ",TIME_FORMAT(sunday_in, "%r"),"<br>'._l('to').'",TIME_FORMAT(sunday_out, "%r")) as sunday',
    'CONCAT("'._l('from').': ",TIME_FORMAT(monday_in, "%r"),"<br>'._l('to').'",TIME_FORMAT(monday_out, "%r")) as monday',
    'CONCAT("'._l('from').': ",TIME_FORMAT(tuesday_in, "%r"),"<br>'._l('to').'",TIME_FORMAT(tuesday_out, "%r")) as tuesday',
    'CONCAT("'._l('from').': ",TIME_FORMAT(wednesday_in, "%r"),"<br>'._l('to').'",TIME_FORMAT(wednesday_out, "%r")) as wednesday',
    'CONCAT("'._l('from').': ",TIME_FORMAT(thursday_in, "%r"),"<br>'._l('to').'",TIME_FORMAT(thursday_out, "%r")) as thursday',
    'CONCAT("'._l('from').': ",TIME_FORMAT(friday_in, "%r"),"<br>'._l('to').'",TIME_FORMAT(friday_out, "%r")) as friday',
];
$ci = &get_instance();
if($ci->app_modules->is_active('branches'))
if(get_staff_default_language() == 'arabic'){
    $aColumns[] = db_prefix().'branches.title_ar as branch_id';
}else{
    $aColumns[] = db_prefix().'branches.title_en as branch_id';
}

$sIndexColumn = 'id';
$sTable       = db_prefix().'hr_office_shift';

$join = [

	'LEFT JOIN '.db_prefix().'branches_services ON '.db_prefix().'branches_services.rel_id='.db_prefix().'hr_office_shift.id AND '.db_prefix().'branches_services.rel_type="office_shift"',
    'LEFT JOIN '.db_prefix().'branches ON '.db_prefix().'branches.id='.db_prefix().'branches_services.branch_id'
];

$where = [];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix().'hr_office_shift.id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    if($ci->app_modules->is_active('branches'))
    $row[] = $aRow['branch_id'];
    $row[] = $aRow['shift_default'];
    
    $row[] = $aRow['saturday'];
    $row[] = $aRow['sunday'];
    $row[] = $aRow['monday'];
    $row[] = $aRow['tuesday'];
    $row[] = $aRow['wednesday'];
    $row[] = $aRow['thursday'];
    $row[] = $aRow['friday'];

    $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#update_office_shift', 'data-id' => $aRow['id'], 'onclick' => 'edit(' . $aRow['id'] . ')']);
    $row[]   = $options .= icon_btn('hr/timesheet/delete_office_shift/' . $aRow['id'], 'remove', 'btn-danger _delete');
    

    $output['aaData'][] = $row;
}
