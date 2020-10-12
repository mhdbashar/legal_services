<?php

defined('BASEPATH') or exit('No direct script access allowed');

$hasPermissionEdit   = has_permission('projects', '', 'edit');
$hasPermissionDelete = has_permission('projects', '', 'delete');
$hasPermissionCreate = has_permission('projects', '', 'create');

$custom_fields = get_table_custom_fields($service->slug);

$aColumns = [
    '1',
    db_prefix() .'my_other_services.id as id',
    'name',
    db_prefix().'clients.company as company',
    '(SELECT GROUP_CONCAT(name SEPARATOR ",") FROM ' . db_prefix() . 'taggables JOIN ' . db_prefix() . 'tags ON ' . db_prefix() . 'taggables.tag_id = ' . db_prefix() . 'tags.id WHERE rel_id = ' . db_prefix() . 'my_other_services.id and rel_type="'.$service->slug.'" ORDER by tag_order ASC) as tags',
    'start_date',
    'deadline',
    'status',
];
$join = [
    'LEFT JOIN '.db_prefix().'clients ON '.db_prefix().'clients.userid='.db_prefix().'my_other_services.clientid',
];

$ci = &get_instance();
if($ci->app_modules->is_active('branches')){
    $aColumns[] = db_prefix().'branches.title_en as branch_id';
    $join[] = 'LEFT JOIN '.db_prefix().'branches_services ON '.db_prefix().'branches_services.rel_id='.db_prefix().'clients.userid AND '.db_prefix().'branches_services.rel_type="clients"';

    $join[] = 'LEFT JOIN '.db_prefix().'branches ON '.db_prefix().'branches.id='.db_prefix().'branches_services.branch_id';
}

foreach ($custom_fields as $key => $field) {
    $selectAs = (is_cf_date($field) ? 'date_picker_cvalue_' . $key : 'cvalue_' . $key);
    array_push($customFieldsColumns, $selectAs);
    array_push($aColumns, 'ctable_' . $key . '.value as ' . $selectAs);
    array_push($join, 'LEFT JOIN ' . db_prefix() . 'customfieldsvalues as ctable_' . $key . ' ON ' . db_prefix() . 'my_other_services.id = ctable_' . $key . '.relid AND ctable_' . $key . '.fieldto="' . $field['fieldto'] . '" AND ctable_' . $key . '.fieldid=' . $field['id']);
}
$where  = [];
$filter = [];
$statusIds = [];

foreach ($model->get_project_statuses() as $status) {
    if ($this->ci->input->post('project_status_' . $status['id'])) {
        array_push($statusIds, $status['id']);
    }
}


if (count($statusIds) > 0) {
    array_push($filter, 'OR status IN (' . implode(', ', $statusIds) . ')');
}

if (count($filter) > 0) {
    array_push($where, 'AND (' . prepare_dt_filter($filter) . ')');
}
array_push($where, ' AND ' . db_prefix() . 'my_other_services.service_id='.$ServID);
array_push($where, ' AND ' . db_prefix() . 'my_other_services.deleted=0');

if (!has_permission('projects', '', 'view') || $this->ci->input->post('my_projects')) {
    array_push($where, ' AND ' . db_prefix() . 'my_other_services.id IN (SELECT oservice_id FROM ' . db_prefix() . 'my_members_services WHERE staff_id=' . get_staff_user_id() . ')');
}
$sIndexColumn = 'id';
$sTable  = db_prefix() . 'my_other_services';
$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix().'my_other_services.clientid']);
$output  = $result['output'];
$rResult = $result['rResult'];
$i = 1;
foreach ($rResult as $aRow) {
    $row = [];
    $row[] = $i;
    $_data =  '<a href="' . admin_url('SOther/view/' .$ServID.'/'. $aRow['id']) . '">' . $aRow['name'] . '</a>';
    $_data .= '<div class="row-options">';
    if ($hasPermissionEdit) {
        $_data .= '  <a href="' . admin_url('SOther/edit/' . $ServID . '/' . $aRow['id']) . '">' . _l('edit') . '</a>';
    }
    if ($hasPermissionDelete) {
        $_data .= ' | <a href="' . admin_url('LegalServices/Other_services_controller/move_to_recycle_bin/' . $ServID . '/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
    }
    $_data .= ' | <a href="' . admin_url('SOther/view/' .$ServID.'/'. $aRow['id']) . '">' . _l('view') . '</a>';

 

   $ci->db->where(['service_id' => $ServID, 'rel_id' => $aRow['id']]);

    $exported_data = $ci->db->get('tblmy_exported_services')->row_array();
    
    if(empty($exported_data)){
        $_data .= ' |  <a href="#" onclick="office_name_other_services('. $aRow['id'] .','.$ServID.'); return false" >'. _l('export') .'</a>';
    }
        
    else{
        $_data .= ' | <a target="_blank" href="'.admin_url("LegalServices/other_services_controller/follow_service/".$ServID."/".$aRow['id']."").'">'. _l('follow_up_service') .'</a>';
        $_data .= ' |  <a href="#" onclick=\'login_details("'. $exported_data['email'] .'", "'.$exported_data['password'].'", "'.$exported_data['url'].', ","'.$exported_data['rel_id'].'", "'.$exported_data['service_id'].'"); return false\' >'. _l('login_details') .'</a>';
    }
        
    $_data .= '</div>';
    $row[] = $_data;
    //$customers = $model->GetClientsServices($aRow['id']);
    $row[] = '<a href="' . admin_url('clients/client/' . $aRow['clientid']) . '">' . $aRow['company'] . '</a>';
    $row[] = render_tags($aRow['tags']);
    $row[] = _d($aRow['start_date']);
    $row[] = _d($aRow['deadline']);
    $members = $model->GetMembersServices($aRow['id']);
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
    $status = get_oservice_status_by_id($aRow['status']);
    $row[]  = '<span class="label label inline-block project-status-' . $aRow['status'] . '" style="color:' . $status['color'] . ';border:1px solid ' . $status['color'] . '">' . $status['name'] . '</span>';
    //$row[]  = '---';
    // Custom fields add values
    foreach ($customFieldsColumns as $customFieldColumn) {
        $row[] = (strpos($customFieldColumn, 'date_picker_') !== false ? _d($aRow[$customFieldColumn]) : $aRow[$customFieldColumn]);
    }
    $row['DT_RowClass'] = 'has-row-options';
    if($ci->app_modules->is_active('branches')){
        $row[] = $aRow['branch_id'];
    }
    $output['aaData'][] = $row;
    $i++;
}