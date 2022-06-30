<?php
defined('BASEPATH') or exit('No direct script access allowed');
$custom_fields         = get_table_custom_fields('procurations');

$aColumns = [
    'name',
    'NO',
    'type',
    'status',
    'addedfrom',
    'id',
    db_prefix() .'procurations.start_date as start_date',
    db_prefix() .'procurations.end_date as end_date',
    
];

$sIndexColumn = 'id';
$sTable       = db_prefix() . 'procurations';

$where = [];
if(!empty($client_id)){
    $where[] = 'AND client='.$client_id;
}else{
    $client_id = 'no_request';
}


if(!empty($case_id)){
    $where[] = 'AND id IN (SELECT procuration from ' . db_prefix() . 'procuration_cases WHERE _case="'.$case_id.'")';
}elseif (!empty($disputes_case_id)){
    $where[] = 'AND id IN (SELECT procuration from ' . db_prefix() . 'procuration_disputes_cases WHERE _case="'.$disputes_case_id.'")';
}
$join = [];

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, ['id', 'client', 'come_from', 'file']);
$output  = $result['output'];
$rResult = $result['rResult'];

$ci = &get_instance();
$ci->load->model('procurationtype_model');
$ci->load->model('procurationstate_model');
$ci->load->model('procurations_model');
$ci->load->model('legalservices/Cases_model', 'case');
$ci->load->model('legalservices/Disputes_cases_model', 'Dcase');

foreach ($rResult as $aRow) {
    $row = [];
    $row[] = $aRow['come_from'];
    $row[] = $aRow['name'];
    $row[] = $aRow['NO'];
    $CI = &get_instance();


    $CI->load->library('app_modules');

    $row[] = $CI->app_modules->is_active('hijri') ? _d($aRow['start_date']) . '<br>' . to_hijri_date(_d($aRow['start_date'])) : _d($aRow['start_date']);
    $row[] = $CI->app_modules->is_active('hijri') ? _d($aRow['end_date']) . '<br>' . to_hijri_date(_d($aRow['end_date'])) : _d($aRow['end_date']);

//
//    $row[] = ($aRow['start_date']);
//    $row[] = ($aRow['end_date']);

    $cases = $ci->procurations_model->get_procurations_cases($aRow['id']);
    $addition = '';
    $show_case = '';
    foreach($cases as $case){
        if(is_object($ci->case->get($case['id'])))
            $show_case .= $ci->case->get($case['id'])->name . ', ';
    }

    $disputes_cases = $ci->procurations_model->get_procurations_disputes_cases($aRow['id']);
    foreach($disputes_cases as $case){
        if(is_object($ci->Dcase->get($case['id'])))
            $show_case .= $ci->Dcase->get($case['id'])->name . ', ';
    }

    $row[] = $show_case;

    
    $staff = $ci->staff_model->get($aRow['addedfrom']);
    $row[] = $staff->firstname . ' ' . $staff->lastname;

    if(isset($ci->procurationtype_model->get($aRow['type'])->procurationtype)) {
        $procuration_type = $ci->procurationtype_model->get($aRow['type'])->procurationtype;
    }else{
        $procuration_type = 'Not Selected';
    }
    $row[] = $procuration_type;


    if( date('Ymd', strtotime($aRow['end_date'])) < (date('Ymd'))) {
        $ci->db->where('id', $aRow['id']);
        $ci->db->update(db_prefix() . 'procurations', ['status' => 1]);
    }

    // if(isset($ci->procurationstate_model->get($aRow['status'])->procurationstate)) {
    //     $procuration_state = $ci->procurationstate_model->get($aRow['status'])->procurationstate;
    // }else{
    //     $procuration_state = 'Not Selected';
    // }

    if($aRow['status'] == 1)
        $status_name = _l('active');
    else
        $status_name = _l('inactive');
    $row[] = $status_name;

    if(isset($all) && $all = 1)
        $request = 'null';
    else
        $request = (is_numeric($client_id)) ? $client_id : $aRow['client'] ;
    $options = '';

    if (has_permission('procurations', '', 'edit') || is_admin())
    $options .= icon_btn('procuration/procurationcu/' . $request . '/' . $aRow['id'] . '/' . $addition , 'pencil-square-o', 'btn-default');
    // $options .= icon_btn('procuration/procurationcu/' . $request . '/' . $aRow['id'] . '/' . $addition , 'home', 'btn-default');
    
    if (has_permission('procurations', '', 'delete') || is_admin())
    $options .= icon_btn('procuration/delete/' . $aRow['id'], 'remove', 'btn-danger _delete');
    $options .= icon_btn('procuration/pdf/' . $aRow['id'] . '?output_type=I', 'download', 'btn-default');
    $p_file = $aRow['file'];
    if($p_file != '') $options .= icon_btn('#', 'eye', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#file', 'data-id' => $aRow['id'], 'onclick' => 'edit(' . $aRow['id'] . ')']);

    $row[]   = $options;

    $output['aaData'][] = $row;
}
