<?php
defined('BASEPATH') or exit('No direct script access allowed');
$custom_fields         = get_table_custom_fields('procurations');

$aColumns = [
    'NO',
    'type',
    'status',
    'addedfrom',
    db_prefix() .'procurations.start_date as start_date',
    db_prefix() .'procurations.end_date as end_date',
    
];

$sIndexColumn = 'id';
$sTable       = db_prefix() . 'procurations';

$where = [];
if(!empty($client_id)){
    $where[] = 'AND client='.$client_id;
}

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], $where, ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

$ci = &get_instance();
$ci->load->model('procurationtype_model');
$ci->load->model('procurationstate_model');
foreach ($rResult as $aRow) {
    $row = [];
    $row[] = $aRow['NO'];
    $row[] = $aRow['start_date'];
    $row[] = $aRow['end_date'];
    $staff = $ci->staff_model->get($aRow['addedfrom']);
    $row[] = $staff->firstname . ' ' . $staff->lastname;

    $row[] = (isset($ci->procurationtype_model->get($aRow['type'])->procurationtype)) ? $ci->procurationtype_model->get($aRow['type'])->procurationtype : 'Not Selected' ;

    $row[] = (isset($ci->procurationstate_model->get($aRow['status'])->procurationstate)) ? $ci->procurationstate_model->get($aRow['status'])->procurationstate : 'Not Selected' ;

    $options = icon_btn('procuration/procurationcu/' . $aRow['id'], 'pencil-square-o', 'btn-default');
    $options .= icon_btn('procuration/procurationcu/' . $aRow['id'], 'home', 'btn-default');
    $row[]   = $options .= icon_btn('procuration/delete/' . $aRow['id'], 'remove', 'btn-danger _delete');
    

    $output['aaData'][] = $row;
}
