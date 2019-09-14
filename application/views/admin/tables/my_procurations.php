<?php
defined('BASEPATH') or exit('No direct script access allowed');
$custom_fields         = get_table_custom_fields('procurations');

$aColumns = [
    'NO',
    'type',
    'status',
    'addedfrom',
    'case_id',
    db_prefix() .'procurations.start_date as start_date',
    db_prefix() .'procurations.end_date as end_date',
    
];

$sIndexColumn = 'id';
$sTable       = db_prefix() . 'procurations';

$where = [];
if(!empty($client_id)){
    $where[] = 'AND client='.$client_id;
}

$join = [];
if(!empty($case_id)){
    $where[] = 'AND case_id='.$case_id;
}

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

$ci = &get_instance();
$ci->load->model('procurationtype_model');
$ci->load->model('procurationstate_model');
$ci->load->model('LegalServices/Cases_model', 'case');
foreach ($rResult as $aRow) {
    $row = [];
    $row[] = $aRow['NO'];
    $row[] = $aRow['start_date'];
    $row[] = $aRow['end_date'];

    if($aRow['case_id'] != ''){
        $case = ($ci->case->get($aRow['case_id']));
        $row[] = $case->name;
    }else $row[] = '';
    
    $staff = $ci->staff_model->get($aRow['addedfrom']);
    $row[] = $staff->firstname . ' ' . $staff->lastname;

    $procuration_type = $ci->procurationtype_model->get($aRow['type'])->procurationtype;
    $row[] = (isset($procuration_type)) ? $procuration_type : 'Not Selected' ;

    $procuration_state = $ci->procurationstate_model->get($aRow['status'])->procurationstate;

    if( date('Ymd', strtotime($aRow['end_date'])) < (date('Ymd'))) {
        $ci->db->where('id', $aRow['id']);
        $ci->db->update(db_prefix() . 'procurations', ['status' => 1]);
    }

    $row[] = (isset($procuration_state)) ? $procuration_state : 'Not Selected' ;

    $request = (!empty($request)) ? $request : '' ;
    $options = icon_btn('procuration/procurationcu/' . $aRow['id'] . '/' . $request , 'pencil-square-o', 'btn-default');
    $options .= icon_btn('procuration/procurationcu/' . $aRow['id'], 'home', 'btn-default');
    $row[]   = $options .= icon_btn('procuration/delete/' . $aRow['id'], 'remove', 'btn-danger _delete');
    

    $output['aaData'][] = $row;
}
