<?php

defined('BASEPATH') or exit('No direct script access allowed');
$hasPermissionEdit   = has_permission('projects', '', 'edit');
$hasPermissionDelete = has_permission('projects', '', 'delete');
$hasPermissionCreate = has_permission('projects', '', 'create');

$aColumns = [
    db_prefix() .'my_cases.id as id',
    'name',
        db_prefix().'clients.company as company',
    '(SELECT GROUP_CONCAT(name SEPARATOR ",") FROM ' . db_prefix() . 'taggables JOIN ' . db_prefix() . 'tags ON ' . db_prefix() . 'taggables.tag_id = ' . db_prefix() . 'tags.id WHERE rel_id = ' . db_prefix() . 'my_cases.id and rel_type="'.$service->slug.'" ORDER by tag_order ASC) as tags',
    'file_number_court',
    'court_id',
    'jud_num',
    'start_date',
    'deadline',
    'status',
    'file_number_court',
];
$aColumns = hooks()->apply_filters('cases_table_aColumns', $aColumns);

$join = [
    'LEFT JOIN '.db_prefix().'clients ON '.db_prefix().'clients.userid='.db_prefix().'my_cases.clientid',
];

$join = hooks()->apply_filters('cases_table_sql_join', $join);

if(isset($service)):
$custom_fields = get_table_custom_fields($service->slug);

foreach ($custom_fields as $key => $field) {
    $selectAs = (is_cf_date($field) ? 'date_picker_cvalue_' . $key : 'cvalue_' . $key);
    array_push($customFieldsColumns, $selectAs);
    array_push($aColumns, 'ctable_' . $key . '.value as ' . $selectAs);
    array_push($join, 'LEFT JOIN ' . db_prefix() . 'customfieldsvalues as ctable_' . $key . ' ON ' . db_prefix() . 'my_cases.id = ctable_' . $key . '.relid AND ctable_' . $key . '.fieldto="' . $field['fieldto'] . '" AND ctable_' . $key . '.fieldid=' . $field['id']);
}
endif;

$where  = [];
$filter = [];
$statusIds = [];
foreach ($model->get_project_statuses() as $status) {
    if ($this->ci->input->post('project_status_' . $status['id'])) {
        array_push($statusIds, $status['id']);
    }
}

array_push($where, 'AND ' . db_prefix() . 'my_cases.deleted = 0');
if(isset($clientid)){
    array_push($where, 'AND ' . db_prefix() . "my_cases.clientid = $clientid");
}

if (!has_permission('projects', '', 'view') || $this->ci->input->post('my_projects')) {
    array_push($where, ' AND ' . db_prefix() . 'my_cases.id IN (SELECT project_id FROM ' . db_prefix() . 'my_members_cases WHERE staff_id=' . get_staff_user_id() . ')');
}

if (count($statusIds) > 0) {
    array_push($filter, 'OR status IN (' . implode(', ', $statusIds) . ')');
}


if (count($filter) > 0) {
    array_push($where, 'AND (' . prepare_dt_filter($filter) . ')');
}
$where = hooks()->apply_filters('services_table_filter', $where, $filter);

$sIndexColumn = 'id';
$sTable  = db_prefix() . 'my_cases';
$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix().'my_cases.clientid']);
$output  = $result['output'];
$rResult = $result['rResult'];
$i = 1;
foreach ($rResult as $aRow) {

    $row = [];
    $row[] = $i;
    $_data =  '<a href="' . admin_url('Case/view/' .$ServID.'/'. $aRow['id']) . '">' . $aRow['name'] . '</a>';
    $_data .= '<div class="row-options">';
    $_data .= '  <a href="' . admin_url('Case/view/' .$ServID.'/'. $aRow['id']) . '?group=CaseMovement">' . _l('CaseMovement') . '</a>';
    if ($hasPermissionEdit) {
        $_data .= ' | <a href="' . admin_url('Case/edit/' . $ServID . '/' . $aRow['id']) . '">' . _l('edit') . '</a>';
    }
    if ($hasPermissionDelete) {
        $_data .= ' | <a href="' . admin_url('legalservices/cases/move_to_recycle_bin/' . $ServID . '/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
    }
    $_data .= ' | <a href="' . admin_url('Case/view/' .$ServID.'/'. $aRow['id']) . '">' . _l('view') . '</a>';
    // $_data .= ' | <a href="'.admin_url("legalservices/other_services/export_case/".$aRow['id']."").'">'. _l('export') .'</a>';
    $_data .= '</div>';
    $row[] = $_data;
    //<! ------------------ ADDing Phases ---------------------->
    $CI = &get_instance();
    $CI->load->model('legalservices/Phase_model');
    $phases= $CI ->Phase_model->get_all(['service_id' => $ServID]);
    $_data='';
      //$customers = $model->GetClientsCases($aRow['id']);
    $row[] = '<a href="' . admin_url('clients/client/' . $aRow['clientid']) . '">' . $aRow['company'] . '</a>';
    $number_of_completed_phases=0;
    $total_phases=sizeof($phases);
    foreach ($phases as $phase){
        if (total_rows(db_prefix() . 'customfieldsvalues', array('fieldto' =>$phase->slug.'_'.$service->slug, 'relid' =>$aRow['id'])) > 0) {
            $number_of_completed_phases++ ;
        }
    }
    $now_phase=  $number_of_completed_phases+1;
    $number=1;
    $phase_name=$phases[0]->name;
    foreach ($phases as $phase){
        if ($number== $now_phase)
        {
         $phase_name=$phase->name;

        }
        if ( $now_phase== $total_phases +1)
        {
            $phase_name= _l('the_phases_is_ended');

        }
        $number++;
    }
    $row[]=$phase_name;
    $phases_percentage=($number_of_completed_phases/$total_phases)*100;
    $phases_percentage=ceil($phases_percentage);
 if($phases_percentage>0 && $phases_percentage<=35)
 {
     $top='green';
     $left='grey';
     $right='grey';
     $bottom='grey';
 }
 elseif($phases_percentage>35 && $phases_percentage<65)
 {
     $top='green';
     $left='green';
     $right='grey';
     $bottom='grey';
 }
 elseif($phases_percentage>65 && $phases_percentage<85)
 {
     $top='green';
     $left='green';
     $right='green';
     $bottom='grey';
 }
 elseif($phases_percentage>85 && $phases_percentage<=100)
 {
     $top='green';
     $left='green';
     $right='green';
     $bottom='green';
 }
 else
 {
     $top='grey';
     $left='grey';
     $right='grey';
     $bottom='grey';

 }
   $row[] = ' <div style="position: relative; 
            display: inline-block; 
            width: 5rem; 
            height: 5rem; 
            border-radius: 7rem; 
            margin: 1.5rem; 
            border: 1.2rem solid palegreen; 
            box-shadow: inset 0 0 7px grey; 
            border-left-color: '.$left.'; 
            border-top-color: '.$top.'; 
            border-right-color: '.$right.'; 
            border-bottom-color: '.$bottom.'; 
            text-align: center; 
            box-sizing: border-box; 
            " >
           <div style="top: 40px;  position: absolute; 
            left: 10px; 
            right: 0; 
            font-weight: 700; 
            font-size: 1.5rem; 
  " >'.$phases_percentage.'%</div>
                </div>';
    //<! ------------------ End of Phases ---------------------->

    $row[] = render_tags($aRow['tags']);
    $CI = &get_instance();
    $CI->load->library('app_modules');
    $row[] = $aRow['file_number_court'] !== '0' ?  $aRow['file_number_court'] : '';
    $court = $aRow['court_id'] !== '1' ? get_court_by_id($aRow['court_id']) : '';
    $judicialdept = $aRow['jud_num'] !== '2' ? get_judicialdept_by_id($aRow['jud_num']) : '';
    $row[] = is_object($court) ? $court->court_name : '';
    $row[] = is_object($judicialdept) ? $judicialdept->Jud_number : '';
    $row[] = $CI->app_modules->is_active('hijri') ? _d($aRow['start_date']) . '<br>' . to_hijri_date(_d($aRow['start_date'])) : _d($aRow['start_date']);
//    $row[] = ($aRow['']);
    $row[] = $aRow['deadline'] != '' ? ($CI->app_modules->is_active('hijri') ? _d($aRow['deadline']) . '<br>' . to_hijri_date(_d($aRow['deadline'])) : _d($aRow['deadline'])) : '';
    $members = $model->GetMembersCases($aRow['id']);
    $membersOutput='';
    $exportMembers = '';
    foreach ($members as $member):
        $membersOutput .= '<a href="' . admin_url('profile/' . $member->staffid) . '">' .
            staff_profile_image($member->staffid, [
                'staff-profile-image-small mright5',
            ], 'small', [
                'data-toggle' => 'tooltip',
                'data-title'  => $member->firstname.' '.$member->lastname,
            ]) . '</a>';
        // For exporting
        $exportMembers .= $member->firstname.' '.$member->lastname . ', ';
    endforeach;

    $membersOutput .= '<span class="hide">' . trim($exportMembers, ', ') . '</span>';
    $row[] = $membersOutput;
    $status = get_case_status_by_id($aRow['status']);
    $row[]  = '<span class="label label inline-block project-status-' . $aRow['status'] . '" style="color:' . $status['color'] . ';border:1px solid ' . $status['color'] . '">' . $status['name'] . '</span>';

    foreach ($customFieldsColumns as $customFieldColumn) {
        $row[] = (strpos($customFieldColumn, 'date_picker_') !== false ? _d($aRow[$customFieldColumn]) : $aRow[$customFieldColumn]);
    }
    $row['DT_RowClass'] = 'has-row-options';
    $row = hooks()->apply_filters('services_table_row_data', $row, $aRow);
    
    $output['aaData'][] = $row;
    $i++;
}