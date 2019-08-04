<?php
defined('BASEPATH') or exit('No direct script access allowed');
$custom_fields = get_table_custom_fields($service->slug);
$aColumns = [
    db_prefix() .'my_cases.id as id',
    'name',
    'clientid',
    '(SELECT GROUP_CONCAT(name SEPARATOR ",") FROM ' . db_prefix() . 'taggables JOIN ' . db_prefix() . 'tags ON ' . db_prefix() . 'taggables.tag_id = ' . db_prefix() . 'tags.id WHERE rel_id = ' . db_prefix() . 'my_cases.id and rel_type="'.$service->slug.'" ORDER by tag_order ASC) as tags',
    'start_date',
    'deadline',
    'status',
];
$join = [];
foreach ($custom_fields as $key => $field) {
    $selectAs = (is_cf_date($field) ? 'date_picker_cvalue_' . $key : 'cvalue_' . $key);
    array_push($customFieldsColumns, $selectAs);
    array_push($aColumns, 'ctable_' . $key . '.value as ' . $selectAs);
    array_push($join, 'LEFT JOIN ' . db_prefix() . 'customfieldsvalues as ctable_' . $key . ' ON ' . db_prefix() . 'my_cases.id = ctable_' . $key . '.relid AND ctable_' . $key . '.fieldto="' . $field['fieldto'] . '" AND ctable_' . $key . '.fieldid=' . $field['id']);
}
$where  = [];
$filter = [];
array_push($where, '');
$sIndexColumn = 'id';
$sTable  = db_prefix() . 'my_cases';
$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where);
$output  = $result['output'];
$rResult = $result['rResult'];
$i = 1;
foreach ($rResult as $aRow) {
    $row = [];
    $row[] = $i;
    $_data =  '<a href="' . admin_url('Case/view/' .$ServID.'/'. $aRow['id']) . '">' . $aRow['name'] . '</a>';
    $_data .= '<div class="row-options">';
    $_data .= '  <a href="' . admin_url('LegalServices/case_movement_controller/edit/' .$ServID.'/'. $aRow['id']) . '">' . _l('CaseMovement') . '</a>';
    $_data .= ' | <a href="' . admin_url('Case/edit/' .$ServID.'/'. $aRow['id']) . '">' . _l('edit') . '</a>';
    $_data .= ' | <a href="' . admin_url('Case/delete/' .$ServID.'/'. $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
    $_data .= ' | <a href="' . admin_url('Case/view/' .$ServID.'/'. $aRow['id']) . '">' . _l('view') . '</a>';
    $_data .= '</div>';
    $row[] = $_data;
    $customers = $model->GetClientsCases($aRow['id']);
    $row[] = '<a href="' . admin_url('clients/client/' . $aRow['clientid']) . '">' . $customers->company . '</a>';
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
    $status = get_project_status_by_id($aRow['status']);
    $row[]  = '<span class="label label inline-block project-status-' . $aRow['status'] . '" style="color:' . $status['color'] . ';border:1px solid ' . $status['color'] . '">' . $status['name'] . '</span>';
    // Custom fields add values
    foreach ($customFieldsColumns as $customFieldColumn) {
        $row[] = (strpos($customFieldColumn, 'date_picker_') !== false ? _d($aRow[$customFieldColumn]) : $aRow[$customFieldColumn]);
    }
    $row['DT_RowClass'] = 'has-row-options';
    $output['aaData'][] = $row;
    $i++;
}