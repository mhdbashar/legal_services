<?php

defined('BASEPATH') or exit('No direct script access allowed');


$aColumns = [
    db_prefix().'staff_insurance.staff_id',
    db_prefix().'insurance_book_nums.name as insurance_book_num',
    db_prefix().'insurances_type.name as insurance_type',
    'health_insurance_num',
    db_prefix().'staff_insurance.start_date as start_date',
    db_prefix().'staff_insurance.end_date as end_date',
    db_prefix().'staff_insurance.file as file'
//    'city_code',
//    'registration_medical'
    ];
$sIndexColumn = 'insurance_id';
$sTable       = db_prefix().'staff_insurance';
$join = [
        'LEFT JOIN '.db_prefix().'staff ON '.db_prefix().'staff.staffid = '.db_prefix().'staff_insurance.staff_id',
        'LEFT JOIN '.db_prefix().'roles ON '.db_prefix().'roles.roleid = '.db_prefix().'staff.role',
        'LEFT JOIN '.db_prefix().'staff_insurance_history ON '.db_prefix().'staff_insurance_history.insurance_id = '.db_prefix().'staff_insurance.insurance_id',
        'LEFT JOIN '.db_prefix().'insurance_book_nums ON '.db_prefix().'insurance_book_nums.id = '.db_prefix().'staff_insurance.insurance_book_num',
        'LEFT JOIN '.db_prefix().'insurances_type ON '.db_prefix().'insurances_type.id = '.db_prefix().'staff_insurance.insurance_type',
];
$where = [];


if(has_permission('insurrance', '', 'view_own') && !has_permission('insurrance', '', 'view')){
    $where[] = 'AND '. db_prefix() . 'staff.staffid='.get_staff_user_id();
}

$department_id = $this->ci->input->post('hrm_deparment');

if(isset($department_id) && strlen($department_id) > 0){

    $where[] = ' AND departmentid IN (select 
        departmentid 
        from    (select * from '.db_prefix().'departments
        order by '.db_prefix().'departments.parent_id, '.db_prefix().'departments.departmentid) departments_sorted,
        (select @pv := '.$department_id.') initialisation
        where   find_in_set(parent_id, @pv)
        and     length(@pv := concat(@pv, ",", departmentid)) OR departmentid = '.$department_id.')';
}

$staff_id = $this->ci->input->post('hrm_staff');
if(isset($staff_id)){
    $where_staff = '';
        foreach ($staff_id as $staffid) {

            if($staffid != '')
            {
                if($where_staff == ''){
                    $where_staff .= ' ('.db_prefix().'staff.staffid in ('.$staffid.')';
                }else{
                    $where_staff .= ' or '.db_prefix().'staff.staffid in ('.$staffid.')';
                }
            }
        }
        if($where_staff != '')
        {
            $where_staff .= ')';
            if($where != ''){
                array_push($where, 'AND'. $where_staff);
            }else{
                array_push($where, $where_staff);
            }

        }
}

$from_month = $this->ci->input->post('hrm_from_month');

if(isset($from_month)){
    $where_month = '';
        foreach ($from_month as $month) {
            if($month != '')
            {
                $month = to_sql_date($month);

                if($where_month == ''){
                    $where_month .= ' ('.db_prefix().'staff_insurance_history.from_month in ("'.$month.'")';
                }else{
                    $where_month .= ' or '.db_prefix().'staff_insurance_history.from_month in ("'.$month.'")';
                }
            }
        }
        if($where_month != '')
        {
            $where_month .= ')';
            if($where != ''){
                array_push($where, 'AND'. $where_month);
            }else{
                array_push($where, $where_month);
            }

        }
}


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix().'staff_insurance.insurance_id as id', 'firstname','lastname',db_prefix().'roles.name',db_prefix().'staff_insurance_history.from_month','premium_rates']);

$output  = $result['output'];
$rResult = $result['rResult'];
function get_payment_company($premium, $social_company, $labor_accident_company, $health_company, $unemployment_company ){
    return (($premium * $social_company)+ ($premium * $labor_accident_company)+($premium * $health_company)+($premium * $unemployment_company))/100;
}

function get_payment_worker($premium, $social_staff, $labor_accident_staff, $health_staff, $unemployment_staff ){
    return (($premium * $social_staff)+ ($premium * $labor_accident_staff)+($premium * $health_staff)+($premium * $unemployment_staff))/100;
}

foreach ($rResult as $aRow) {

    $insurancetypes =   $this->ci->db->query(' select * from '.db_prefix().'insurance_type as t  where t.from_month <= "'.$aRow['from_month'].'"  order by t.from_month desc limit 1')->result_array();
    if(count($insurancetypes) != 0){
        foreach ($insurancetypes as $key => $insurancetype) {
        $social_company         = (float)($insurancetype["social_company"]);
        $labor_accident_company = (float)($insurancetype["labor_accident_company"]);
        $health_company         = (float)($insurancetype["health_company"]);
        $unemployment_company   = (float)($insurancetype["unemployment_company"]);

        $social_staff           = (float)($insurancetype["social_staff"]);
        $labor_accident_staff   = (float)($insurancetype["labor_accident_staff"]);
        $health_staff           = (float)($insurancetype["health_staff"]);
        $unemployment_staff     = (float)($insurancetype["unemployment_staff"]);
        }
    }else{
        $social_company         = 0;
        $labor_accident_company = 0;
        $health_company         = 0;
        $unemployment_company   = 0;

        $social_staff           = 0;
        $labor_accident_staff   = 0;
        $health_staff           = 0;
        $unemployment_staff     = 0;
    }

    $premium                = (float)($aRow['premium_rates']);

    $row = [];
    //$row[] = $aRow['staff_identifi'];
    $row[] = '<a href="/admin/hr/insurance"> ' . staff_profile_image($aRow[db_prefix().'staff_insurance.staff_id'], [
                'staff-profile-image-small',
                ]) . '</a><a href='.admin_url('hr/insurance/'). $aRow['id'] .'> ' . $aRow['firstname'] . ' ' . $aRow['lastname'] . '</a>';


    $row[] = $aRow['insurance_book_num'];
    $row[] = $aRow['insurance_type'];
    $row[] = $aRow['health_insurance_num'];
    $row[] = _d($aRow['start_date']);
    $row[] = _d($aRow['end_date']);
    // file

    $file = '';
    if(basename($aRow["file"]) != '' and file_exists($aRow["file"])){
        $file = '<a target="_blank" href="'.base_url(). $aRow['file'].'">';
        $is_image = is_image($aRow['file']);

        if($is_image){
            $file .= '<div class="preview_image">';
        }
        if ($is_image) {
            $file .=  '<img class="project-file-image img-table-loading" src="' . base_url().$aRow['file'] . '" width="100">';

        }else{
            $file .='<i class="'.get_mime_class(mime_content_type($aRow["file"])).' "></i> '. basename($aRow["file"]);
        }
        if($is_image){ $file .= '</div>'; }
        $file .=  '</a>';
    }

    $row[] = $file;
    // $row[] = date("d-m-Y", strtotime($aRow['from_month']));
//    $row[] = app_format_money((int)($aRow['premium_rates']),'');
//
//    $row[] = app_format_money(get_payment_company($premium, $social_company,  $labor_accident_company, $health_company, $unemployment_company  ),'');
//    $row[] = app_format_money(get_payment_worker($premium, $social_staff,  $labor_accident_staff, $health_staff, $unemployment_staff  ),'');
//

    $output['aaData'][] = $row;
}
