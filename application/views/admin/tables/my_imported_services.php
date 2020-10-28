<?php

defined('BASEPATH') or exit('No direct script access allowed');

$hasPermissionEdit   = has_permission('projects', '', 'edit');
$hasPermissionDelete = has_permission('imported_services', '', 'delete');
$hasPermissionCreate = has_permission('projects', '', 'create');

$custom_fields = get_table_custom_fields($service->slug);

$aColumns = [
    db_prefix() .'my_imported_services.id as id',
    'name',
    db_prefix().'clients.company as company',
    'start_date',
    'deadline',
];
$join = [
    'LEFT JOIN '.db_prefix().'clients ON '.db_prefix().'clients.userid='.db_prefix().'my_imported_services.clientid',
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
    array_push($join, 'LEFT JOIN ' . db_prefix() . 'customfieldsvalues as ctable_' . $key . ' ON ' . db_prefix() . 'my_imported_services.id = ctable_' . $key . '.relid AND ctable_' . $key . '.fieldto="' . $field['fieldto'] . '" AND ctable_' . $key . '.fieldid=' . $field['id']);
}
$where  = [];
$filter = [];
$statusIds = [];

foreach ($model->get_project_statuses() as $status) {
    if ($this->ci->input->post('project_status_' . $status['id'])) {
        array_push($statusIds, $status['id']);
    }
}


// if (count($statusIds) > 0) {
//     array_push($filter, 'OR status IN (' . implode(', ', $statusIds) . ')');
// }

if (count($filter) > 0) {
    array_push($where, 'AND (' . prepare_dt_filter($filter) . ')');
}
array_push($where, ' AND ' . db_prefix() . 'my_imported_services.deleted=0');

$sIndexColumn = 'id';
$sTable  = db_prefix() . 'my_imported_services';
$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix().'my_imported_services.clientid']);
$output  = $result['output'];
$rResult = $result['rResult'];
$i = 1;
foreach ($rResult as $aRow) {
    $row = [];
    $row[] = $i;
    $_data =  '<a href="' . admin_url('SImported/view/' . $aRow['id']) . '">' . $aRow['name'] . '</a>';
    $_data .= '<div class="row-options">';
    if (has_permission('imported_services', '', 'delete')) {
        
        $_data .= ' | <a href="' . admin_url('LegalServices/Imported_services_controller/move_to_recycle_bin/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a> | ';
    }
    $_data .= '<a href="' . admin_url('SImported/view/' . $aRow['id']) . '">' . _l('view') . '</a>';
    $_data .= '</div>';
    $row[] = $_data;
    //$customers = $model->GetClientsServices($aRow['id']);
    $row[] = '<a href="' . admin_url('clients/client/' . $aRow['clientid']) . '">' . $aRow['company'] . '</a>';
    $row[] = _d($aRow['start_date']);
    $row[] = _d($aRow['deadline']);
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