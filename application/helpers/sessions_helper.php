<?php

defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Function that format session status for the final user
 * @param  string  $id    status id
 * @param  boolean $text
 * @param  boolean $clean
 * @return string
 */

function get_session_timer_round_off_options()
{
    $options = [
        [
            'name' => _l('task_timer_dont_round_off'),
            'id'   => 0,
        ],
        [
            'name' => _l('task_timer_round_up'),
            'id'   => 1,
        ],
        [
            'name' => _l('task_timer_round_down'),
            'id'   => 2,
        ],
        [
            'name' => _l('task_timer_round_nearest'),
            'id'   => 3,
        ],
    ];

    return hooks()->apply_filters('before_get_task_timer_round_off_options', $options);
}

function get_session_timer_round_off_times()
{
    return hooks()->apply_filters('before_get_task_timer_round_off_times', [5, 10, 15, 20, 25, 30, 35, 40, 45]);
}

function format_session_status($status, $text = false, $clean = false)
{
    if (!is_array($status)) {
        $status = get_session_status_by_id($status);
    }

    $status_name = $status['name'];

    $status_name = hooks()->apply_filters('session_status_name', $status_name, $status);

    if ($clean == true) {
        return $status_name;
    }

    $style = '';
    $class = '';
    if ($text == false) {
        $style = 'border: 1px solid ' . $status['color'] . ';color:' . $status['color'] . ';';
        $class = 'label';
    } else {
        $style = 'color:' . $status['color'] . ';';
    }

    return '<span class="' . $class . '" style="' . $style . '">' . $status_name . '</span>';
}

function format_session_status_by_date($datetime, $text = false, $clean = false)
{
    $current_date = strtotime(date('Y-m-d'));
    $datetime = strtotime($datetime);
    if ($datetime >= $current_date) {
        $style = 'border: 1px solid green;color:green;';
        $class = 'label';
        $status_name = _l('waiting');
        return '<span class="' . $class . '" style="' . $style . '">' . $status_name . '</span>';
    }else{
        $style = 'border: 1px solid red;color:red;';
        $class = 'label';
        $status_name = _l('previous');
        return '<span class="' . $class . '" style="' . $style . '">' . $status_name . '</span>';
    }

    $status_name = $status['name'];

    $status_name = hooks()->apply_filters('session_status_name', $status_name, $status);

    if ($clean == true) {
        return $status_name;
    }

    $style = '';
    $class = '';
    if ($text == false) {
        $style = 'border: 1px solid ' . $status['color'] . ';color:' . $status['color'] . ';';
        $class = 'label';
    } else {
        $style = 'color:' . $status['color'] . ';';
    }

    return '<span class="' . $class . '" style="' . $style . '">' . $status_name . '</span>';
}

/**
 * Return predefined sessions priorities
 * @return array
 */
function get_sessions_priorities()
{
    return hooks()->apply_filters('tasks_priorities', [
        [
            'id'     => 1,
            'name'   => _l('task_priority_low'),
             'color' => '#777',

        ],
        [
            'id'     => 2,
            'name'   => _l('task_priority_medium'),
             'color' => '#03a9f4',

        ],
        [
            'id'    => 3,
            'name'  => _l('task_priority_high'),
            'color' => '#ff6f00',
        ],
        [
            'id'    => 4,
            'name'  => _l('task_priority_urgent'),
            'color' => '#fc2d42',
        ],
    ]);
}

/**
 * Get project name by passed id
 * @param  mixed $id
 * @return string
 */
function get_session_subject_by_id($id)
{
    $CI = & get_instance();
    $CI->db->select('name');
    $CI->db->where('id', $id);
    $CI->db->where('is_session', 1);
    $session = $CI->db->get(db_prefix() . 'tasks')->row();
    if ($session) {
        return $session->name;
    }

    return '';
}

/**
 * Get session status by passed session id
 * @param  mixed $id session id
 * @return array
 */
function get_session_status_by_id($id)
{
    $CI       = &get_instance();
    $statuses = $CI->sessions_model->get_statuses();

    $status = [
      'id'         => 0,
      'bg_color'   => '#333',
      'text_color' => '#333',
      'name'       => '[Status Not Found]',
      'order'      => 1,
      ];

    foreach ($statuses as $s) {
        if ($s['id'] == $id) {
            $status = $s;

            break;
        }
    }

    return $status;
}

/**
 * Format session priority based on passed priority id
 * @param  mixed $id
 * @return string
 */
function session_priority($id)
{
    foreach (get_sessions_priorities() as $priority) {
        if ($priority['id'] == $id) {
            return $priority['name'];
        }
    }

    // Not exists?
    return $id;
}

/**
 * Get and return session priority color
 * @param  mixed $id priority id
 * @return string
 */
function session_priority_color($id)
{
    foreach (get_sessions_priorities() as $priority) {
        if ($priority['id'] == $id) {
            return $priority['color'];
        }
    }

    // Not exists?
    return '#333';
}

/**
 * Format html session assignees
 * This function is used to save up on query
 * @param  string $ids   string coma separated assignee staff id
 * @param  string $names compa separated in the same order like assignee ids
 * @return string
 */
function format_members_by_ids_and_names_session($ids, $names, $hidden_export_table = true, $image_class = 'staff-profile-image-small')
{
    $outputAssignees = '';
    $exportAssignees = '';
    $assignees   = explode(',', $names);
    $assigneeIds = explode(',', $ids);
    foreach ($assignees as $key => $assigned) {
        $assignee_id = $assigneeIds[$key];
        $assignee_id = trim($assignee_id);
        if ($assigned != '') {
            $outputAssignees .= '<a href="' . admin_url('profile/' . $assignee_id) . '">' .
                staff_profile_image($assignee_id, [
                  $image_class . ' mright5',
                ], 'small', [
                  'data-toggle' => 'tooltip',
                  'data-title'  => $assigned,
                ]) . '</a>';
            $exportAssignees .= $assigned . ', ';
        }
    }

    if ($exportAssignees != '') {
        $outputAssignees .= '<span class="hide">' . mb_substr($exportAssignees, 0, -2) . '</span>';
    }
    return $outputAssignees;
}

/**
 * Format session relation name
 * @param  string $rel_name current rel name
 * @param  mixed $rel_id   relation id
 * @param  string $rel_type relation type
 * @return string
 */
function session_rel_name($rel_name, $rel_id, $rel_type)
{
    if ($rel_type == 'invoice') {
        $rel_name = format_invoice_number($rel_id);
    } elseif ($rel_type == 'estimate') {
        $rel_name = format_estimate_number($rel_id);
    } elseif ($rel_type == 'proposal') {
        $rel_name = format_proposal_number($rel_id);
    }

    return $rel_name;
}

/**
 * session relation link
 * @param  mixed $rel_id   relation id
 * @param  string $rel_type relation type
 * @return string
 */
function session_rel_link($rel_id, $rel_type)
{
    $link = '#';
    if ($rel_type == 'customer') {
        $link = admin_url('clients/client/' . $rel_id);
    } elseif ($rel_type == 'invoice') {
        $link = admin_url('invoices/list_invoices/' . $rel_id);
    } elseif ($rel_type == 'project') {
        $link = admin_url('projects/view/' . $rel_id);
    } elseif ($rel_type == 'estimate') {
        $link = admin_url('estimates/list_estimates/' . $rel_id);
    } elseif ($rel_type == 'contract') {
        $link = admin_url('contracts/contract/' . $rel_id);
    } elseif ($rel_type == 'ticket') {
        $link = admin_url('tickets/ticket/' . $rel_id);
    } elseif ($rel_type == 'expense') {
        $link = admin_url('expenses/list_expenses/' . $rel_id);
    } elseif ($rel_type == 'lead') {
        $link = admin_url('leads/index/' . $rel_id);
    } elseif ($rel_type == 'proposal') {
        $link = admin_url('proposals/list_proposals/' . $rel_id);
    }

    return $link;
}

/**
 * Prepares session array gantt data to be used in the gantt chart
 * @param  array $session session array
 * @return array
 */
function get_session_array_gantt_data($session)
{
    $data           = [];
    $data['values'] = [];
    $values         = [];

    $data['desc'] = $session['name'];
    $data['name'] = '';

    $values['from']  = strftime('%Y/%m/%d', strtotime($session['startdate']));
    $values['to']    = strftime('%Y/%m/%d', strtotime($session['duedate']));
    $values['desc']  = $session['name'] . ' - ' . _l('session_total_logged_time') . ' ' . seconds_to_time_format($session['total_logged_time']);
    $values['label'] = $session['name'];
    if ($session['duedate'] && date('Y-m-d') > $session['duedate'] && $session['status'] != Sessions_model::STATUS_COMPLETE) {
        $values['customClass'] = 'ganttRed';
    } elseif ($session['status'] == Sessions_model::STATUS_COMPLETE) {
        $values['label']       = ' <i class="fa fa-check"></i> ' . $values['label'];
        $values['customClass'] = 'ganttGreen';
    }

    $values['dataObj'] = [
        'session_id' => $session['id'],
    ];

    $data['values'][] = $values;

    return $data;
}
/**
 * Common function used to select session relation name
 * @return string
 */
function sessions_rel_name_select_query()
{
    return '(CASE rel_type
        WHEN "contract" THEN (SELECT subject FROM ' . db_prefix() . 'contracts WHERE ' . db_prefix() . 'contracts.id = ' . db_prefix() . 'tasks.rel_id)
        WHEN "estimate" THEN (SELECT id FROM ' . db_prefix() . 'estimates WHERE ' . db_prefix() . 'estimates.id = ' . db_prefix() . 'tasks.rel_id)
        WHEN "proposal" THEN (SELECT id FROM ' . db_prefix() . 'proposals WHERE ' . db_prefix() . 'proposals.id = ' . db_prefix() . 'tasks.rel_id)
        WHEN "invoice" THEN (SELECT id FROM ' . db_prefix() . 'invoices WHERE ' . db_prefix() . 'invoices.id = ' . db_prefix() . 'tasks.rel_id)
        WHEN "ticket" THEN (SELECT CONCAT(CONCAT("#",' . db_prefix() . 'tickets.ticketid), " - ", ' . db_prefix() . 'tickets.subject) FROM ' . db_prefix() . 'tickets WHERE ' . db_prefix() . 'tickets.ticketid=' . db_prefix() . 'tasks.rel_id)
        WHEN "lead" THEN (SELECT CASE ' . db_prefix() . 'leads.email WHEN "" THEN ' . db_prefix() . 'leads.name ELSE CONCAT(' . db_prefix() . 'leads.name, " - ", ' . db_prefix() . 'leads.email) END FROM ' . db_prefix() . 'leads WHERE ' . db_prefix() . 'leads.id=' . db_prefix() . 'tasks.rel_id)
        WHEN "customer" THEN (SELECT CASE company WHEN "" THEN (SELECT CONCAT(firstname, " ", lastname) FROM ' . db_prefix() . 'contacts WHERE userid = ' . db_prefix() . 'clients.userid and is_primary = 1) ELSE company END FROM ' . db_prefix() . 'clients WHERE ' . db_prefix() . 'clients.userid=' . db_prefix() . 'tasks.rel_id)
        WHEN "project" THEN (SELECT CONCAT(CONCAT(CONCAT("#",' . db_prefix() . 'projects.id)," - ",' . db_prefix() . 'projects.name), " - ", (SELECT CASE company WHEN "" THEN (SELECT CONCAT(firstname, " ", lastname) FROM ' . db_prefix() . 'contacts WHERE userid = ' . db_prefix() . 'clients.userid and is_primary = 1) ELSE company END FROM ' . db_prefix() . 'clients WHERE userid=' . db_prefix() . 'projects.clientid)) FROM ' . db_prefix() . 'projects WHERE ' . db_prefix() . 'projects.id=' . db_prefix() . 'tasks.rel_id)
        WHEN "expense" THEN (SELECT CASE expense_name WHEN "" THEN ' . db_prefix() . 'expenses_categories.name ELSE
         CONCAT(' . db_prefix() . 'expenses_categories.name, \' (\',' . db_prefix() . 'expenses.expense_name,\')\') END FROM ' . db_prefix() . 'expenses JOIN ' . db_prefix() . 'expenses_categories ON ' . db_prefix() . 'expenses_categories.id = ' . db_prefix() . 'expenses.category WHERE ' . db_prefix() . 'expenses.id=' . db_prefix() . 'tasks.rel_id)
        ELSE NULL
        END)';
}

/**
 * sessions html table used all over the application for relation sessions
 * This table is not used for the main sessions table
 * @param  array  $table_attributes
 * @return string
 */
function init_relation_sessions_table($table_attributes = [])
{
    $table_data = [
        _l('the_number_sign'),
        [
            'name'     => _l('tasks_dt_name'),
            'th_attrs' => [
                'style' => 'min-width:200px',
                ],
            ],
             _l('session_status'),
         [
            'name'     => _l('tasks_dt_datestart'),
            'th_attrs' => [
                'style' => 'min-width:75px',
                ],
            ],
         [
            'name'     => _l('task_duedate'),
            'th_attrs' => [
                'style' => 'min-width:75px',
                'class' => 'duedate',
                ],
            ],
         [
            'name'     => _l('task_assigned'),
            'th_attrs' => [
                'style' => 'min-width:75px',
                ],
            ],
        _l('tags'),
        _l('tasks_list_priority'),
    ];

    array_unshift($table_data, [
        'name'     => '<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="rel-sessions"><label></label></div>',
        'th_attrs' => ['class' => ($table_attributes['data-new-rel-type'] !== 'project' ? 'not_visible' : '')],
    ]);

    $custom_fields = get_custom_fields('sessions', [
        'show_on_table' => 1,
    ]);

    foreach ($custom_fields as $field) {
        array_push($table_data, $field['name']);
    }

    $table_data = hooks()->apply_filters('sessions_related_table_columns', $table_data);

    $name = 'rel-sessions';
    if ($table_attributes['data-new-rel-type'] == 'lead') {
        $name = 'rel-sessions-leads';
    }

    $table      = '';
    $CI         = & get_instance();
    $table_name = '.table-' . $name;
    $CI->load->view('admin/sessions/tasks_filter_by', [
        'view_table_name' => $table_name,
    ]);
    if (has_permission('sessions', '', 'create')) {
        $disabled   = '';
        $table_name = addslashes($table_name);
        if ($table_attributes['data-new-rel-type'] == 'customer' && is_numeric($table_attributes['data-new-rel-id'])) {
            if (total_rows(db_prefix() . 'clients', [
                'active' => 0,
                'userid' => $table_attributes['data-new-rel-id'],
            ]) > 0) {
                $disabled = ' disabled';
            }
        }
        // projects have button on top
        if ($table_attributes['data-new-rel-type'] != 'project') {
            echo "<a href='#' class='btn btn-info pull-left mbot25 mright5 new-session-relation" . $disabled . "' onclick=\"new_session_from_relation('$table_name'); return false;\" data-rel-id='" . $table_attributes['data-new-rel-id'] . "' data-rel-type='" . $table_attributes['data-new-rel-type'] . "'>" . _l('new_session') . '</a>';
        }
    }

    if ($table_attributes['data-new-rel-type'] == 'project') {
        echo "<a href='" . admin_url('sessions/detailed_overview?project_id=' . $table_attributes['data-new-rel-id']) . "' class='btn btn-success pull-right mbot25'>" . _l('session_detailed_overview') . '</a>';
        echo "<a href='" . admin_url('sessions/list_sessions?project_id=' . $table_attributes['data-new-rel-id'] . '&kanban=true') . "' class='btn btn-default pull-right mbot25 mright5 hidden-xs'>" . _l('view_kanban') . '</a>';
        echo '<div class="clearfix"></div>';
        echo $CI->load->view('admin/sessions/_bulk_actions', ['table' => '.table-rel-sessions'], true);
        echo $CI->load->view('admin/sessions/_summary', ['rel_id' => $table_attributes['data-new-rel-id'], 'rel_type' => 'project', 'table' => $table_name], true);
        echo '<a href="#" data-toggle="modal" data-target="#tasks_bulk_actions" class="hide bulk-actions-btn table-btn" data-table=".table-rel-sessions">' . _l('bulk_actions') . '</a>';
    } elseif ($table_attributes['data-new-rel-type'] == 'customer') {
        echo '<div class="clearfix"></div>';
        echo '<div id="tasks_related_filter">';
        echo '<p class="bold">' . _l('task_related_to') . ': </p>';

        echo '<div class="checkbox checkbox-inline mbot25">
        <input type="checkbox" checked value="customer" disabled id="ts_rel_to_customer" name="tasks_related_to[]">
        <label for="ts_rel_to_customer">' . _l('client') . '</label>
        </div>';

        $services = $CI->db->get('my_basic_services')->result();
        foreach ($services as $service):
            if($service->is_module == 0):
                echo '<div class="checkbox checkbox-inline mbot25">
                      <input type="checkbox" value="'.$service->slug.'" id="ts_rel_to_'.$service->slug.'" name="tasks_related_to[]">
                      <label for="ts_rel_to_'.$service->slug.'">' . $service->name . '</label>
                      </div>';
            else:
                echo '<div class="checkbox checkbox-inline mbot25">
                    <input type="checkbox" value="project" id="ts_rel_to_project" name="tasks_related_to[]">
                    <label for="ts_rel_to_project">' . $service->name . '</label>
                    </div>';
            endif;
        endforeach;

        echo '</div>';
    }
    echo "<div class='clearfix'></div>";
    echo ' <div class="horizontal-scrollable-tabs preview-tabs-top">
                <div class="horizontal-tabs">
                    <ul class="nav nav-tabs tabs-in-body-no-margin contract-tab nav-tabs-horizontal mbot15" role="tablist">
                        <li role="presentation" class="active" >
                            <a href="#Waiting_sessions" aria-controls="Waiting_sessions" role="tab" data-toggle="tab">
                               '. _l('Waiting_sessions').'
                            </a>
                        </li>
                        <li role="presentation" class="tab-separator">
                            <a href="#Previous_Sessions" aria-controls="Previous_Sessions" role="tab" data-toggle="tab">                                               
                                '. _l('Previous_Sessions').'
                            </a>
                        </li>
                    </ul>
                </div>
            </div>';
    // If new column is added on sessions relations table this will not work fine
    // In this case we need to add new identifier eq session-relation
    $table_attributes['data-last-order-identifier'] = 'tasks';
    $table_attributes['data-default-order']         = get_table_last_order('tasks');

    echo '<div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="Waiting_sessions">';
               $table .= render_datatable($table_data, $name, [], $table_attributes);
            echo '</div>
            <div role="tabpanel" class="tab-pane " id="Previous_Sessions">';
               $table .= render_datatable($table_data, $name, [], $table_attributes);
            echo '</div>
        </div>';
    //$table .= render_datatable($table_data, $name, [], $table_attributes);
    return $table;
}

/**
 * Return sessions summary formated data
 * @param  string $where additional where to perform
 * @return array
 */
function sessions_summary_data($rel_id = null, $rel_type = null)
{
    $CI            = &get_instance();
    $sessions_summary = [];
    $statuses      = $CI->sessions_model->get_statuses();
    foreach ($statuses as $status) {
        $sessions_where = 'status = ' . $CI->db->escape_str($status['id']);
        $sessions_where .= ' AND is_session = 1';
        if (!has_permission('sessions', '', 'view')) {
            $sessions_where .= ' ' . get_sessions_where_string();
        }
        $sessions_my_where = 'id IN(SELECT taskid FROM ' . db_prefix() . 'task_assigned WHERE staffid=' . get_staff_user_id() . ') AND status=' . $CI->db->escape_str($status['id']);
        if ($rel_id && $rel_type) {
            $sessions_where .= ' AND rel_id=' . $CI->db->escape_str($rel_id) . ' AND rel_type="' . $CI->db->escape_str($rel_type) . '"';
            $sessions_my_where .= ' AND rel_id=' . $CI->db->escape_str($rel_id) . ' AND rel_type="' . $CI->db->escape_str($rel_type) . '"';
        } else {
            $sqlProjecSessionsWhere = ' AND is_session= 1';
            $sqlProjecSessionsWhere .= ' AND CASE
            WHEN rel_type="project" AND rel_id IN (SELECT project_id FROM ' . db_prefix() . 'project_settings WHERE project_id=rel_id AND name="hide_tasks_on_main_tasks_table" AND value=1)
            THEN rel_type != "project"
            ELSE 1=1
            END';
            $sessions_where .= $sqlProjecSessionsWhere;
            $sessions_my_where .= $sqlProjecSessionsWhere;
        }

        $summary                   = [];
        $summary['total_tasks']    = total_rows(db_prefix() . 'tasks', $sessions_where);
        $summary['total_my_tasks'] = total_rows(db_prefix() . 'tasks', $sessions_my_where);
        $summary['color']          = $status['color'];
        $summary['name']           = $status['name'];
        $summary['status_id']      = $status['id'];
        $sessions_summary[]           = $summary;
    }
    return $sessions_summary;
}

function get_sql_calc_session_logged_time($session_id)
{
    /**
    * Do not remove where session_id=
    * Used in sessions detailed_overview to overwrite the sessionid
    */
    return 'SELECT SUM(CASE
            WHEN end_time is NULL THEN ' . time() . '-start_time
            ELSE end_time-start_time
            END) as total_logged_time FROM ' . db_prefix() . 'taskstimers WHERE task_id =' . get_instance()->db->escape_str($session_id);
}

function get_sql_select_session_assignees_ids()
{
    return '(SELECT GROUP_CONCAT(staffid SEPARATOR ",") FROM ' . db_prefix() . 'task_assigned WHERE taskid=' . db_prefix() . 'tasks.id ORDER BY ' . db_prefix() . 'task_assigned.staffid)';
}

function get_sql_select_session_asignees_full_names()
{
    return '(SELECT GROUP_CONCAT(CONCAT(firstname, \' \', lastname) SEPARATOR ",") FROM ' . db_prefix() . 'task_assigned JOIN ' . db_prefix() . 'staff ON ' . db_prefix() . 'staff.staffid = ' . db_prefix() . 'task_assigned.staffid WHERE taskid=' . db_prefix() . 'tasks.id ORDER BY ' . db_prefix() . 'task_assigned.staffid)';
}

function get_sql_select_session_total_checklist_items()
{
    return '(SELECT COUNT(id) FROM ' . db_prefix() . 'task_checklist_items WHERE taskid=' . db_prefix() . 'tasks.id) as total_checklist_items';
}

function get_sql_select_session_total_finished_checklist_items()
{
    return '(SELECT COUNT(id) FROM ' . db_prefix() . 'task_checklist_items WHERE taskid=' . db_prefix() . 'tasks.id AND finished=1) as total_finished_checklist_items';
}

/**
 * This text is used in WHERE statements for sessions if the staff member don't have permission for sessions VIEW
 * This query will shown only sessions that are created from current user, public sessions or where this user is added is session follower.
 * Other statement will be included the sessions to be visible for this user only if Show All sessions For Project Members is set to YES
 * @return string
 */
function get_sessions_where_string($table = true)
{
    $_sessions_where = '(' . db_prefix() . 'tasks.id IN (SELECT taskid FROM ' . db_prefix() . 'task_assigned WHERE staffid = ' . get_staff_user_id() . ') OR ' . db_prefix() . 'tasks.id IN (SELECT taskid FROM ' . db_prefix() . 'task_followers WHERE staffid = ' . get_staff_user_id() . ') OR (addedfrom=' . get_staff_user_id() . ' AND is_added_from_contact=0)';
    if (get_option('show_all_tasks_for_project_member') == 1) {
        $_sessions_where .= ' OR (' . db_prefix() . 'tasks.rel_type="project" AND ' . db_prefix() . 'tasks.rel_id IN (SELECT project_id FROM ' . db_prefix() . 'project_members WHERE staff_id=' . get_staff_user_id() . '))';
    }
    $_sessions_where .= ' OR is_public = 1)';
    if ($table == true) {
        $_sessions_where = 'AND ' . $_sessions_where;
    }

    return $_sessions_where;
}

function get_count_of_watting_sessions()
{
    $CI = &get_instance();
    return $CI->db->query('SELECT COUNT(id) AS session_count FROM ' . db_prefix() . 'tasks WHERE is_session = 1 AND DATE_FORMAT(now(),"%Y-%m-%d") <= STR_TO_DATE('.db_prefix() .'tasks.startdate, "%Y-%m-%d")')->row()->session_count;
}

function get_count_of_previous_sessions()
{
    $CI = &get_instance();
    return $CI->db->query('SELECT COUNT(id) AS session_count FROM ' . db_prefix() . 'tasks WHERE is_session = 1 AND DATE_FORMAT(now(),"%Y-%m-%d") > STR_TO_DATE('.db_prefix() .'tasks.startdate, "%Y-%m-%d")')->row()->session_count;
}