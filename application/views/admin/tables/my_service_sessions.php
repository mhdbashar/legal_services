
<?php

defined('BASEPATH') or exit('No direct script access allowed');

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
$i = 0;
foreach ($rResult as $aRow) {
    $row = [];

    

    $_data = '<a href="' . base_url() . 'session/session_info/session_detail/' . $aRow['id'] . '?tab=info">' . $aRow['subject'] . '</a>';

    $row[] = $_data;
    
    $row[] = $aRow['date'];

    $zero = ''; $one = ''; $tow = ''; $three = ''; $four = '';
    if($aRow['status'] == 0) $zero = "selected='selected'";
    if ($aRow['status'] == 1) $one = "selected='selected'";
    if ($aRow['status'] == 2) $tow = "selected='selected'";
    if ($aRow['status'] == 3) $three = "selected='selected'";
    if ($aRow['status'] == 4) $four = "selected='selected'";
    $row[] = '
      <form name="my" id="myform'.$i.'" method="get" action="' . base_url() . "session/" . "session_info" . "/edit_status/" . $aRow['id'] . '">
        <select id="themes" name="status" style="padding: 6px 9px; border-radius: 3px;" onchange="submitForm' . $i . '();">

            <option value="0" ' . $zero . '>Not Selected</option>
            <option value="1" ' . $one . '>جلسة أولى</option>
            <option value="2" ' . $tow . '>جلسة استماع</option>
            <option value="3" ' . $three . '>جلسة رد</option>
            <option value="4" ' . $four . '>النطق  بالحكم</option>
            
        </select>
      </form>
    ';

    $zero = ''; $one = ''; $tow = ''; $three = '';
    if($aRow['result'] == 0) $zero = "selected='selected'";
    if ($aRow['result'] == 1) $one = "selected='selected'";
    if ($aRow['result'] == 2) $tow = "selected='selected'";
    if ($aRow['result'] == 3) $three = "selected='selected'";
    $row[] = '
      <form id="resultform'.$i.'" method="get" action="' . base_url() . "session/" . "session_info" . "/edit_result/" . $aRow['id'] . '">
        <select name="result" id="result" style="padding: 6px 9px; border-radius: 3px;" onchange="resultForm' . $i . '();">

            <option value="0" ' . $zero . '>Not Selected</option>
            <option value="1" ' . $one . '>تم الحكم لصالح المدعي</option>
            <option value="2" ' . $tow . '>تم الحكم لصالح المدعي عليه</option>
            <option value="3" ' . $three . '>تم إقفال القضية</option>
            
        </select>
      </form>
    ';

    $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#update_session', 'id' => 'm', 'onclick' => 'update_session_json(' . $aRow['id'] . ')']);
    $row[]   = $options .= icon_btn('session/service_sessions/delete/' . $aRow['id'], 'remove', 'btn-danger _delete');

    // $row['DT_RowClass'] = 'has-row-options';

    $output['aaData'][] = $row;
    $i++;
}