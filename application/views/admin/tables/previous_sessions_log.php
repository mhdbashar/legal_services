<?php defined('BASEPATH') or exit('No direct script access allowed');
$hasPermissionEdit   = has_permission('sessions', '', 'edit');
$hasPermissionDelete = has_permission('sessions', '', 'delete');
$tasksPriorities     = get_sessions_priorities();

$aColumns = [
    db_prefix() . 'tasks.id as id',
    db_prefix() . 'tasks.name as task_name',
    db_prefix() . 'tasks.status as status',
    //db_prefix() . 'my_judges.name as judge',
    get_sql_select_session_asignees_full_names() . ' as assignees',
    'startdate',
    'time',
    'court_name',
    'customer_report',
    'send_to_customer',
];

//$additionalSelect = [
//    get_sql_select_session_asignees_full_names() . ' as assignees'
//];

$sIndexColumn = 'id';
$sTable       = db_prefix() . 'tasks';

$where = [];
include_once(APPPATH . 'views/admin/tables/includes/sessions_filter.php');

if (!$this->ci->input->post('tasks_related_to')) {
    if(!$all_data):
        array_push($where, 'AND rel_id="' . $rel_id . '" AND rel_type="' . $rel_type . '"');
    endif;
    array_push($where, 'AND deleted = 0');
} else {
    // Used in the customer profile filters
    $tasks_related_to = explode(',', $this->ci->input->post('tasks_related_to'));
    $rel_to_query     = 'AND (';

    $lastElement = end($tasks_related_to);
    foreach ($tasks_related_to as $rel_to) {
        $this->ci->load->model('LegalServices/LegalServicesModel', 'legal');
        $ServID = $this->ci->legal->get_service_id_by_slug($rel_type);

        if($ServID == 1){
            $table_rel = 'my_cases';
        }else{
            $table_rel = 'my_other_services';
        }
        $rel_to_query .= '(rel_id IN (SELECT id FROM ' . db_prefix(). $table_rel. ' WHERE clientid=' . $rel_id . ')';
        $rel_to_query .= ' AND rel_type="' . $rel_to . '")';

        if ($rel_to != $lastElement) {
            $rel_to_query .= ' OR ';
        }
    }

    $rel_to_query .= ')';
    array_push($where, $rel_to_query);
}
//array_push($where, 'AND DATE_FORMAT(now(),"%Y-%m-%d %H:%i:%s") > STR_TO_DATE(CONCAT('.db_prefix() .'tasks.startdate, " ", '.db_prefix() .'my_session_info.time), "%Y-%m-%d %H:%i:%s")');
array_push($where, 'AND DATE_FORMAT(now(),"%Y-%m-%d") > STR_TO_DATE('.db_prefix() .'tasks.startdate, "%Y-%m-%d")');
array_push($where, 'AND ' . db_prefix() . 'tasks.is_session = 1');

$join = [
    'LEFT JOIN ' . db_prefix() . 'my_session_info ON ' . db_prefix() . 'my_session_info.task_id = ' . db_prefix() . 'tasks.id',
    'LEFT JOIN '.db_prefix().'my_courts ON '.db_prefix().'my_courts.c_id = '.db_prefix().'my_session_info.court_id',
  //  'LEFT JOIN '.db_prefix().'my_judges ON '.db_prefix().'my_judges.id = '.db_prefix().'my_session_info.judge_id',
];

$custom_fields = get_table_custom_fields('sessions');

foreach ($custom_fields as $key => $field) {
    $selectAs = (is_cf_date($field) ? 'date_picker_cvalue_' . $key : 'cvalue_' . $key);
    array_push($customFieldsColumns, $selectAs);
    array_push($aColumns, '(SELECT value FROM ' . db_prefix() . 'customfieldsvalues WHERE ' . db_prefix() . 'customfieldsvalues.relid=' . db_prefix() . 'tasks.id AND ' . db_prefix() . 'customfieldsvalues.fieldid=' . $field['id'] . ' AND ' . db_prefix() . 'customfieldsvalues.fieldto="' . $field['fieldto'] . '" LIMIT 1) as ' . $selectAs);
}

// $aColumns = hooks()->apply_filters('tasks_related_table_sql_columns', $aColumns);

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [
    'billed',
    'recurring',
    '(SELECT staffid FROM ' . db_prefix() . 'task_assigned WHERE taskid=' . db_prefix() . 'tasks.id AND staffid=' . get_staff_user_id() . ') as is_assigned',
    get_sql_select_session_assignees_ids() . ' as assignees_ids',
    '(SELECT MAX(id) FROM ' . db_prefix() . 'taskstimers WHERE task_id=' . db_prefix() . 'tasks.id and staff_id=' . get_staff_user_id() . ' and end_time IS NULL) as not_finished_timer_by_current_staff',
    '(SELECT staffid FROM ' . db_prefix() . 'task_assigned WHERE taskid=' . db_prefix() . 'tasks.id AND staffid=' . get_staff_user_id() . ') as current_user_is_assigned',
    '(SELECT CASE WHEN addedfrom=' . get_staff_user_id() . ' AND is_added_from_contact=0 THEN 1 ELSE 0 END) as current_user_is_creator',
]);

$output  = $result['output'];
$rResult = $result['rResult'];
$i = 1;
foreach ($rResult as $aRow) {
    $row = [];
    $row[] = $i;
    $outputName = '';

    if ($aRow['not_finished_timer_by_current_staff']) {
        $outputName .= '<span class="pull-left text-danger"><i class="fa fa-clock-o fa-fw"></i></span>';
    }

    $outputName .= '<a href="' . admin_url('tasks/view/' . $aRow['id']) . '" class="display-block main-tasks-table-href-name" onclick="init_session_modal(' . $aRow['id'] . '); return false;">' . $aRow['task_name'] . '</a>';

    if ($aRow['recurring'] == 1) {
        $outputName .= '<span class="label label-primary inline-block mtop4"> ' . _l('recurring_session') . '</span>';
    }

    $outputName .= '<div class="row-options">';

    $class = 'text-success bold';
    $style = '';
    $tooltip = '';

    if ($aRow['billed'] == 1 || !$aRow['is_assigned'] || $aRow['status'] == Sessions_model::STATUS_COMPLETE) {
        $class = 'text-dark disabled';
        $style = 'style="opacity:0.6;cursor: not-allowed;"';
        if ($aRow['status'] == Sessions_model::STATUS_COMPLETE) {
            $tooltip = ' data-toggle="tooltip" data-title="' . format_session_status($aRow['status'], false, true) . '"';
        } elseif ($aRow['billed'] == 1) {
            $tooltip = ' data-toggle="tooltip" data-title="' . _l('session_billed_cant_start_timer') . '"';
        } elseif (!$aRow['is_assigned']) {
            $tooltip = ' data-toggle="tooltip" data-title="' . _l('session_start_timer_only_assignee') . '"';
        }
    }

    if ($aRow['not_finished_timer_by_current_staff']) {
        $outputName .= '<a href="#" class="text-danger tasks-table-stop-timer" onclick="timer_action(this,' . $aRow['id'] . ',' . $aRow['not_finished_timer_by_current_staff'] . '); return false;">' . _l('task_stop_timer') . '</a>';
    } else {
        $outputName .= '<span' . $tooltip . ' ' . $style . '>
      <a href="#" class="' . $class . ' tasks-table-start-timer" onclick="timer_action(this,' . $aRow['id'] . '); return false;">' . _l('task_start_timer') . '</a>
      </span>';
    }

    if ($hasPermissionEdit) {
        $outputName .= '<span class="text-dark"> | </span><a href="#" onclick="edit_session(' . $aRow['id'] . '); return false">' . _l('edit') . '</a>';
    }

    if ($hasPermissionDelete) {
        $outputName .= '<span class="text-dark"> | </span><a href="' . admin_url('Legalservices/Sessions/delete_task/' . $aRow['id']) . '" class="text-danger _delete task-delete">' . _l('delete') . '</a>';
    }
    $outputName .= '</div>';
    $row[] = $outputName;
   // $row[] = $aRow['judge'];
    $row[] = format_members_by_ids_and_names($aRow['assignees_ids'], $aRow['assignees']);
    $row[] = $aRow['court_name'];
//    $row[] = $aRow['court_decision'] != '' ? substr($aRow['court_decision'],0,40).'...' : '';
    if($aRow['customer_report'] == 0):
        $report = '<span class="label label inline-block project-status-1" style="color:#989898;border: 1px solid #989898">لايوجد</span>';
    else:
        $report = '<span class="label label inline-block project-status-4" style="color:#84c529;border: 1px solid #84c529">يوجد</span>';
    endif;
    $row[] = $report;
    if($aRow['send_to_customer'] == 0):
        $send = '<span class="label label inline-block project-status-1" style="color:#989898;border: 1px solid #989898">لم يتم الارسال</span>';
    else:
        $send = '<span class="label label inline-block project-status-4" style=color:#84c529;border: 1px solid #84c529">مرسل</span>';
    endif;
    $row[] = $send;


    // startdate
    $row[] = _dha($aRow['startdate']);
    // ~startdate
    $row[] = $aRow['time'];
    if($aRow['customer_report'] == 0 && $aRow['send_to_customer'] == 0):
        $stc = '<a href="#" data-toggle="modal" data-target="#customer_report'.$aRow['id'].'" class="btn btn-info pull-left display-block">';
        $stc .=  _l('add_new') . '<i class="fa fa-plus"></i>  ';
        $stc .= '</a>';
        $stc .= '<div class="modal fade" id="customer_report'.$aRow['id'].'" tabindex="-1" role="dialog" aria-labelledby="customer_report" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">
                                    <span class="add-title">'._l('Customer_report').'</span>
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group" app-field-wrapper="date">
                                            <label for="next_session_date'.$aRow['id'].'" class="control-label">'._l('next_session_date').'</label>
                                            <div class="input-group date">
                                                <input type="text" id="next_session_date'.$aRow['id'].'" name="next_session_date" class="form-control datepicker"  autocomplete="off" aria-invalid="false">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar calendar-icon"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="col-md-6">                                       
                                        <label for="next_session_time'.$aRow['id'].'" class="control-label">'. _l('next_session_time').'</label>                                           
                                        <input type="text" class="form-control" id="next_session_time'.$aRow['id'].'" name="next_session_time" style="display: block;width: 100%;">                                                                               
                                    </div>                      
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="bold">'._l('Court_decision').'</p>
                                        <textarea type="text" class="form-control" id="edit_court_decision'.$aRow['id'].'" name="edit_court_decision" rows="4" placeholder="'. _l('Court_decision').'"></textarea>
                                    </div>
                                </div> 
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                      <div class="checkbox checkbox-primary">
                                            <input type="checkbox" name="send_mail_to_opponent" id="send_mail_to_opponent'.$aRow['id'].'">
                                            <label for="send_mail_to_opponent'.$aRow['id'].'">'._l('send_mail_to_opponent').'</label>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">'. _l('close').'</button>
                                <button type="button" onclick="edit_customer_report(' . $aRow['id'] . ')" class="btn btn-info">'. _l('submit').'</button>
                            </div>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                 init_datepicker();            
                 load_time_picker(' . $aRow['id'] . ');
                </script>';
    elseif ($aRow['customer_report'] == 1 && $aRow['send_to_customer'] == 0):
        $stc = '<a href="#/" onclick="send_report('.$aRow['id'].')" class="btn btn-info pull-left display-block">';
        $stc .= '<i class="fa fa-envelope-o"></i>  </br> '._l('send');
        $stc .= '</a>';
    elseif ($aRow['customer_report'] == 1 && $aRow['send_to_customer'] == 1):
        $stc = '<a href="#/" id="print_btn'.$aRow['id'].'" onclick="print_session_report('.$aRow['id'].')" class="btn btn-info pull-left display-block">';
        $stc .= '<i class="fa fa-print"></i>  </br> '._l('dt_button_print');
        $stc .= '</a>';
    endif;
    $row[] = $stc;

    // Custom fields add values
    foreach ($customFieldsColumns as $customFieldColumn) {
        $row[] = (strpos($customFieldColumn, 'date_picker_') !== false ? _d($aRow[$customFieldColumn]) : $aRow[$customFieldColumn]);
    }

    $output['aaData'][] = $row;
    $i++;
}

