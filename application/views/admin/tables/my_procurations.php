<?php
defined('BASEPATH') or exit('No direct script access allowed');
$custom_fields         = get_table_custom_fields('procurations');

$aColumns = [
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

$join = [];

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

$ci = &get_instance();
$ci->load->model('procurationtype_model');
$ci->load->model('procurationstate_model');
$ci->load->model('procurations_model');
$ci->load->model('LegalServices/Cases_model', 'case');
foreach ($rResult as $aRow) {
    $row = [];
    $row[] = $aRow['NO'];
    $row[] = $aRow['start_date'];
    $row[] = $aRow['end_date'];

    $cases = $ci->procurations_model->get_procurations_cases($aRow['id']);
    if(isset($case_id)){
        $ca = array();
        foreach($cases as $case){
            $ca[] = $ci->case->get($case['id'])->id;
        }
        if(!in_array($case_id, $ca)){
            continue;
        }
    }
    $show_case = '';
    foreach($cases as $case){
        $show_case .= $ci->case->get($case['id'])->name . ', ';
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

    if(isset($ci->procurationstate_model->get($aRow['status'])->procurationstate)) {
        $procuration_state = $ci->procurationstate_model->get($aRow['status'])->procurationstate;
    }else{
        $procuration_state = 'Not Selected';
    }
    $row[] = $procuration_state;

    $request = (!empty($request)) ? $client_id : 'no_request' ;
    $options = icon_btn('procuration/procurationcu/' . $request . '/' . $aRow['id'] , 'pencil-square-o', 'btn-default');
    $options .= icon_btn('procuration/procurationcu/' . $aRow['id'], 'home', 'btn-default');
    $row[]   = $options .= icon_btn('procuration/delete/' . $aRow['id'], 'remove', 'btn-danger _delete');
    

    $output['aaData'][] = $row;
}
