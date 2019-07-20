<?php

defined('BASEPATH') or exit('No direct script access allowed');

function statusName($id){
  switch ($id) {
     case 0:
        return "جلسة أولى";
        break;
     case 1:
        return "جلسة استماع";
        break;
     case 2:
        return "جلسة رد";
        break;
     case 3:
        return "النطق  بالحكم";
        break;
     
     default:
        return "جلسة أولى";
        break;
  }
}
function resultName($id){
  switch ($id) {
     case 0:
        return "تم الحكم لصالح المدعي";
        break;
     case 1:
        return "تم الحكم لصالح المدعي عليه";
        break;
     case 2:
        return "تم إقفال القضية";
        break;
    
     
     default:
        return "تم الحكم لصالح المدعي";
        break;
  }
}

// `id`, `service_id`, `rel_id`, `rel_type`, `subject`, `court_id`, `judge_id`, `date`, `details`, `next_action`, `next_date`, `report`, `deleted`

$aColumns = [
    'subject',
    'date',
    db_prefix() .'my_service_session.id as id',
    'status',
    'result'

];

$join = [
    'JOIN '.db_prefix().'my_courts ON '.db_prefix().'my_courts.c_id = '.db_prefix().'my_service_session.court_id',
    'JOIN '.db_prefix().'my_judges ON '.db_prefix().'my_judges.id = '.db_prefix().'my_service_session.judge_id',
];

$where  = [
    'AND' . db_prefix() . 'my_service_session.service_id=' . $service_id,
    'AND ' . db_prefix() . 'my_service_session.rel_id=' . $rel_id
];

$filter = [];
$sIndexColumn = 'id';
$sTable       = db_prefix() . 'my_service_session';


$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where);

$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];

    $_data = '<a href="' . base_url() . 'session/session_info/session_detail/' . $aRow['id'] . '?tab=attachments">' . $aRow['subject'] . '</a>';

    $row[] = $_data;
    
    $row[] = $aRow['date'];
    $row[] = statusName($aRow['status']);
    $row[] = resultName($aRow['result']);

    $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#update_session', 'id' => 'm', 'onclick' => 'update_session_json(' . $aRow['id'] . ')']);
    $row[]   = $options .= icon_btn('session/service_sessions/delete/' . $aRow['id'], 'remove', 'btn-danger _delete');

    // $row['DT_RowClass'] = 'has-row-options';

    $output['aaData'][] = $row;
}