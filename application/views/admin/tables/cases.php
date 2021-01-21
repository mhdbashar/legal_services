<?php

defined('BASEPATH') or exit('No direct script access allowed');
$hasPermissionEdit   = has_permission('projects', '', 'edit');
$hasPermissionDelete = has_permission('projects', '', 'delete');
$hasPermissionCreate = has_permission('projects', '', 'create');

$aColumns = [
    'file_number_court',
    db_prefix() .'my_cases.id as id',
    'name',
    db_prefix().'clients.company as company',
    '(SELECT GROUP_CONCAT(name SEPARATOR ",") FROM ' . db_prefix() . 'taggables JOIN ' . db_prefix() . 'tags ON ' . db_prefix() . 'taggables.tag_id = ' . db_prefix() . 'tags.id WHERE rel_id = ' . db_prefix() . 'my_cases.id and rel_type="'.$service->slug.'" ORDER by tag_order ASC) as tags',
    'start_date',
    'deadline',
    'status',
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
        $_data .= ' | <a href="' . admin_url('LegalServices/Cases_controller/move_to_recycle_bin/' . $ServID . '/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
    }
    $_data .= ' | <a href="' . admin_url('Case/view/' .$ServID.'/'. $aRow['id']) . '">' . _l('view') . '</a>';
    // $_data .= ' | <a href="'.admin_url("LegalServices/other_services_controller/export_case/".$aRow['id']."").'">'. _l('export') .'</a>';
    $_data .= '</div>';
    $row[] = $_data;
    //$customers = $model->GetClientsCases($aRow['id']);
    $row[] = '<a href="' . admin_url('clients/client/' . $aRow['clientid']) . '">' . $aRow['company'] . '</a>';
    $row[] = render_tags($aRow['tags']);
    $row[] = _d($aRow['start_date']);
    $row[] = _d($aRow['deadline']);
    $members = $model->GetMembersCases($aRow['id']);
    $membersOutput='';
    foreach ($members as $member):
        $membersOutput .= '<a href="' . admin_url('profile/' . $member->staffid) . '">' .
            staff_profile_image($member->staffid, [
                'staff-profile-image-small mright5',
            ], 'small', [
                'data-toggle' => 'tooltip',
                'data-title'  => $member->firstname.' '.$member->lastname,
            ]) . '</a>';
    endforeach;
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