<?php

defined('BASEPATH') or exit('No direct script access allowed');

hooks()->add_action('admin_init', 'app_init_disputes_case_tabs');
hooks()->add_action('app_admin_assets', '_maybe_init_admin_disputes_case_assets', 5);

function _maybe_init_admin_disputes_case_assets()
{
    $CI = &get_instance();
    if (strpos($_SERVER['REQUEST_URI'], get_admin_uri() . '/Disputes_cases/view') !== false
        || strpos($_SERVER['REQUEST_URI'], get_admin_uri() . '/legalservices/disputes_cases/gantt') !== false) {
        $CI = &get_instance();

        $CI->app_scripts->add('jquery-comments-js', 'assets/plugins/jquery-comments/js/jquery-comments.min.js', 'admin', ['vendor-js']);
        $CI->app_scripts->add('frappe-gantt-js','assets/plugins/frappe/frappe-gantt-es2015.js', 'admin', ['vendor-js']);

        $CI->app_css->add('frappe-gantt-js', 'assets/plugins//frappe/frappe-gantt.css', 'admin', ['vendor-css']);
        $CI->app_css->add('jquery-comments-css', 'assets/plugins/jquery-comments/css/jquery-comments.css', 'admin', ['reset-css']);
    }
}

function get_disputes_case_tabs_admin()
{
    return get_instance()->app_custom_tabs->get_disputes_case_tabs();
}

/**
 * Init the default project tabs
 * @return null
 */
function app_init_disputes_case_tabs()
{
    $CI = &get_instance();

    $CI->app_custom_tabs->add_disputes_case_tab('project_overview', [
        'name'     => _l('project_overview'),
        'icon'     => 'fa fa-th',
        'view'     => 'admin/legalservices/disputes_cases/project_overview',
        'position' => 5,
    ]);

    $CI->app_custom_tabs->add_disputes_case_tab('procuration', [
        'name'     => _l('procurations'),
        'icon'     => 'fa fa-th',
        'view'     => 'admin/legalservices/disputes_cases/case_procuration',
        'position' => 10,
        'visible'  => (has_permission('procurations', '', 'view') || is_admin()),
    ]);

    $CI->app_custom_tabs->add_disputes_case_tab('project_tasks', [
        'name'                      => _l('tasks'),
        'icon'                      => 'fa fa-check-circle',
        'view'                      => 'admin/legalservices/disputes_cases/project_tasks',
        'position'                  => 15,
        'linked_to_customer_option' => ['view_tasks'],
    ]);

    $CI->app_custom_tabs->add_disputes_case_tab('project_timesheets', [
        'name'                      => _l('project_timesheets'),
        'icon'                      => 'fa fa-clock-o',
        'view'                      => 'admin/legalservices/disputes_cases/project_timesheets',
        'position'                  => 20,
        'linked_to_customer_option' => ['view_timesheets'],
    ]);

    $CI->app_custom_tabs->add_disputes_case_tab('project_milestones', [
        'name'                      => _l('project_milestones'),
        'icon'                      => 'fa fa-rocket',
        'view'                      => 'admin/legalservices/disputes_cases/project_milestones',
        'position'                  => 25,
        'linked_to_customer_option' => ['view_milestones'],
    ]);

    $CI->app_custom_tabs->add_disputes_case_tab('project_files', [
        'name'                      => _l('project_files'),
        'icon'                      => 'fa fa-files-o',
        'view'                      => 'admin/legalservices/disputes_cases/project_files',
        'position'                  => 30,
        'linked_to_customer_option' => ['upload_files'],
    ]);

    $CI->app_custom_tabs->add_disputes_case_tab('project_discussions', [
        'name'                      => _l('project_discussions'),
        'icon'                      => 'fa fa-commenting',
        'view'                      => 'admin/legalservices/disputes_cases/project_discussions',
        'position'                  => 35,
        'linked_to_customer_option' => ['open_discussions'],
    ]);

    $CI->app_custom_tabs->add_disputes_case_tab('project_gantt', [
        'name'                      => _l('project_gant'),
        'icon'                      => 'fa fa-align-left',
        'view'                      => 'admin/legalservices/disputes_cases/project_gantt',
        'position'                  => 40,
        'linked_to_customer_option' => ['view_gantt'],
    ]);

    $CI->app_custom_tabs->add_disputes_case_tab('project_tickets', [
        'name'     => _l('project_tickets'),
        'icon'     => 'fa fa-life-ring',
        'view'     => 'admin/legalservices/disputes_cases/project_tickets',
        'position' => 45,
        'visible'  => (get_option('access_tickets_to_none_staff_members') == 1 && !is_staff_member()) || is_staff_member(),
    ]);

    $CI->app_custom_tabs->add_disputes_case_tab('project_contracts', [
        'name'     => _l('contracts'),
        'icon'     => 'fa fa-file',
        'view'     => 'admin/legalservices/disputes_cases/project_contracts',
        'position' => 50,
        'visible'  => has_permission('contracts', '', 'view') || has_permission('contracts', '', 'view_own'),
    ]);

    $CI->app_custom_tabs->add_disputes_case_tab('sales', [
        'name'     => _l('sales_string'),
        'icon'     => 'fa fa-balance-scale',
        'position' => 55,
        'collapse' => true,
        'visible'  => (has_permission('estimates', '', 'view') || has_permission('estimates', '', 'view_own') || (get_option('allow_staff_view_estimates_assigned') == 1 && staff_has_assigned_estimates()))
            || (has_permission('invoices', '', 'view') || has_permission('invoices', '', 'view_own') || (get_option('allow_staff_view_invoices_assigned') == 1 && staff_has_assigned_invoices()))
            || (has_permission('expenses', '', 'view') || has_permission('expenses', '', 'view_own')),
    ]);

    $CI->app_custom_tabs->add_disputes_case_tab_children_item('sales', [
        'slug'     => 'disputes_invoices',
        'name'     => _l('disputes_cases_invoices'),
        'view'     => 'admin/legalservices/disputes_cases/disputes_invoices',
        'visible'  => (has_permission('invoices', '', 'view') || has_permission('invoices', '', 'view_own') || (get_option('allow_staff_view_invoices_assigned') == 1 && staff_has_assigned_invoices())),
        'position' => 0,
    ]);

    $CI->app_custom_tabs->add_disputes_case_tab_children_item('sales', [
        'slug'     => 'project_invoices',
        'name'     => _l('project_invoices'),
        'view'     => 'admin/legalservices/disputes_cases/project_invoices',//'admin/legalservices/disputes_cases/project_invoices',
        'position' => 5,
        'visible'  => (has_permission('invoices', '', 'view') || has_permission('invoices', '', 'view_own') || (get_option('allow_staff_view_invoices_assigned') == 1 && staff_has_assigned_invoices())),
    ]);

    $CI->app_custom_tabs->add_disputes_case_tab_children_item('sales', [
        'slug'     => 'project_estimates',
        'name'     => _l('estimates'),
        'view'     => 'admin/legalservices/disputes_cases/project_estimates',
        'position' => 10,
        'visible'  => (has_permission('estimates', '', 'view') || has_permission('estimates', '', 'view_own') || (get_option('allow_staff_view_estimates_assigned') == 1 && staff_has_assigned_estimates())),
    ]);

    $CI->app_custom_tabs->add_disputes_case_tab_children_item('sales', [
        'slug'     => 'project_expenses',
        'name'     => _l('project_expenses'),
        'view'     => 'admin/legalservices/disputes_cases/project_expenses',
        'position' => 15,
        'visible'   => has_permission('expenses', '', 'view') || has_permission('expenses', '', 'view_own'),
    ]);

    $CI->app_custom_tabs->add_disputes_case_tab_children_item('sales', [
        'slug'     => 'project_credit_notes',
        'name'     => _l('credit_notes'),
        'view'     => 'admin/legalservices/disputes_cases/project_credit_notes',
        'position' => 20,
        'visible'  => has_permission('credit_notes', '', 'view') || has_permission('credit_notes', '', 'view_own'),
    ]);

    // $CI->app_custom_tabs->add_disputes_case_tab_children_item('sales', [
    //     'slug'     => 'project_subscriptions',
    //     'name'     => _l('subscriptions'),
    //     'view'     => 'admin/legalservices/disputes_cases/project_subscriptions',
    //     'position' => 25,
    //     'visible'  => has_permission('subscriptions', '', 'view') || has_permission('subscriptions', '', 'view_own'),
    // ]);

    $CI->app_custom_tabs->add_disputes_case_tab('project_notes', [
        'name'     => _l('project_notes'),
        'icon'     => 'fa fa-file-o',
        'view'     => 'admin/legalservices/disputes_cases/project_notes',
        'position' => 60,
    ]);

    $CI->app_custom_tabs->add_disputes_case_tab('project_activity', [
        'name'                      => _l('project_activity'),
        'icon'                      => 'fa fa-exclamation',
        'view'                      => 'admin/legalservices/disputes_cases/project_activity',
        'position'                  => 65,
        'linked_to_customer_option' => ['view_activity_log'],
    ]);

    $CI->app_custom_tabs->add_disputes_case_tab('CaseMovement', [
        'name'                      => _l('CaseMovement'),
        'icon'                      => 'fa fa-exchange',
        'view'                      => 'admin/legalservices/disputes_cases/case_movement_view',
        'position'                  => 70,
    ]);

    $CI->app_custom_tabs->add_disputes_case_tab('CaseSession', [
        'name'                      => _l('SessionLog'),
        'icon'                      => 'fa fa-font-awesome',
        'view'                      => 'admin/legalservices/services_sessions/services_sessions',
        'position'                  => 75,
    ]);

    $CI->app_custom_tabs->add_disputes_case_tab('Phase', [
        'name'                      => _l('phases'),
        'icon'                      => 'fa fa-list-ol',
        'view'                      => 'admin/legalservices/phases/tab',
        'position'                  => 80,
    ]);

//    $CI->app_custom_tabs->add_disputes_case_tab('IRAC', [
//        'name'                      => _l('IRAC_method'),
//        'icon'                      => 'fa fa-sitemap',
//        'view'                      => 'admin/legalservices/irac/tab',
//        'position'                  => 85,
//    ]);

    $CI->app_custom_tabs->add_disputes_case_tab('Procedures', [
        'name'                      => _l('legal_procedures'),
        'icon'                      => 'fa fa-braille',
        'view'                      => 'admin/legalservices/legal_procedures/tab',
        'position'                  => 90,
    ]);

//    $CI->app_custom_tabs->add_disputes_case_tab('help_library', [
//        'name'                      => _l('help_library'),
//        'icon'                      => 'fa fa-book',
//        'view'                      => 'admin/help_library/tab',
//        'position'                  => 95,
//    ]);

    $CI->app_custom_tabs->add_disputes_case_tab('written_reports', [
        'name'                      => _l('written_reports'),
        'icon'                      => 'fa fa-pencil-square',
        'view'                      => 'admin/written_reports/tab',
        'position'                  => 100,
    ]);
    $CI->app_menu->add_sidebar_children_item('sales', [
        'slug'     => 'disputes_invoices',
        'name'     => _l('disputes_cases_invoices'),
        'href'     => admin_url('legalservices/disputes_invoices/list_invoices'), // URL of the item
        'visible'  => (has_permission('invoices', '', 'view') || has_permission('invoices', '', 'view_own') || (get_option('allow_staff_view_invoices_assigned') == 1 && staff_has_assigned_invoices())),
        'position' => 0,
    ]);

}

/**
 * Filter only visible tabs selected from project settings
 * @param  array $tabs available tabs
 * @param  array $applied_settings current applied project visible tabs
 * @return array
 */
function filter_disputes_case_visible_tabs($tabs, $applied_settings)
{
    $newTabs = [];
    foreach ($tabs as $key => $tab) {
        $dropdown = isset($tab['collapse']) ? true : false;

        if ($dropdown) {
            $totalChildTabsHidden = 0;
            $newChild             = [];

            foreach ($tab['children'] as $d) {
                if ((isset($applied_settings[$d['slug']]) && $applied_settings[$d['slug']] == 0)) {
                    $totalChildTabsHidden++;
                } else {
                    $newChild[] = $d;
                }
            }

            if ($totalChildTabsHidden == count($tab['children'])) {
                continue;
            }

            if (count($newChild) > 0) {
                $tab['children'] = $newChild;
            }

            $newTabs[$tab['slug']] = $tab;
        } else {
            if (isset($applied_settings[$key]) && $applied_settings[$key] == 0) {
                continue;
            }

            $newTabs[$tab['slug']] = $tab;
        }
    }

    return hooks()->apply_filters('disputes_case_filtered_visible_tabs', $newTabs);
}

/**
 * Get project by ID or current queried project
 * @param  mixed $id project id
 * @return mixed
 */
function get_disputes_case($id = null)
{
    if (empty($id) && isset($GLOBALS['disputes_case'])) {
        return $GLOBALS['disputes_case'];
    }

    // Client global object not set
    if (empty($id)) {
        return null;
    }

    if (!class_exists('Disputes_cases_model', false)) {
        get_instance()->load->model('legalservices/disputes_cases/Disputes_cases_model', 'disputes_case');
    }

    $project = get_instance()->disputes_case->get($id);

    return $project;
}

/**
 * Get project status by passed project id
 * @param  mixed $id project id
 * @return array
 */
function get_disputes_case_status_by_id($id)
{
    if (!class_exists('Disputes_cases_model', false)) {
        get_instance()->load->model('legalservices/disputes_cases/Disputes_cases_model', 'disputes_case');
    }

    $statuses = get_instance()->disputes_case->get_project_statuses();

    $status = [
        'id'    => 0,
        'color' => '#333',
        'name'  => '[Status Not Found]',
        'order' => 1,
    ];

    foreach ($statuses as $s) {
        if ($s['id'] == $id) {
            $status = $s;
            break;
        }
    }

    return $status;
}

function get_disputes_status_by_id($id){
    if (!class_exists('Disputes_cases_model', false)) {
        get_instance()->load->model('legalservices/disputes_cases/Disputes_cases_model', 'disputes_case');
    }
    $status = get_instance()->disputes_case->get_status_by_id($id);
    if($status) {
        return $status;
    }
    return false;
}

/**
 * Return logged in user pinned projects
 * @return array
 */
function get_user_pinned_disputes_cases($slug)
{
    $CI = &get_instance();
    $CI->db->select(db_prefix() . 'my_disputes_cases.id, ' . db_prefix() . 'my_disputes_cases.name, ' . db_prefix() . 'my_disputes_cases.clientid, ' . get_sql_select_client_company());
    $CI->db->join(db_prefix() . 'my_disputes_cases', db_prefix() . 'my_disputes_cases.id=' . db_prefix() . 'disputes_pinned_cases.project_id');
    $CI->db->join(db_prefix() . 'clients', db_prefix() . 'clients.userid=' . db_prefix() . 'my_disputes_cases.clientid');
    $CI->db->where(db_prefix() . 'disputes_pinned_cases.staff_id', get_staff_user_id());
    $CI->db->where(db_prefix() . 'my_disputes_cases.deleted', 0);
    $projects = $CI->db->get(db_prefix() . 'disputes_pinned_cases')->result_array();
    $CI->load->model('legalservices/disputes_cases/Disputes_cases_model', 'disputes_case');

    foreach ($projects as $key => $project) {
        $projects[$key]['progress'] = $CI->disputes_case->calc_progress($project['id'], $slug);
    }

    return $projects;
}

/**
 * Get project name by passed id
 * @param  mixed $id
 * @return string
 */
function get_disputes_case_name_by_id($id)
{
    $CI      = & get_instance();
    $project = $CI->app_object_cache->get('disputes_case-name-data-' . $id);

    if (!$project) {
        $CI->db->select('name');
        $CI->db->where('id', $id);
        $project = $CI->db->get(db_prefix() . 'my_disputes_cases')->row();
        $CI->app_object_cache->add('disputes_case-name-data-' . $id, $project);
    }

    if ($project) {
        return $project->name;
    }

    return '';
}

/**
 * Return project milestones
 * @param  mixed $project_id project id
 * @return array
 */
function get_disputes_case_milestones($project_id)
{
    $CI = &get_instance();
    $CI->db->where('project_id', $project_id);
    $CI->db->order_by('milestone_order', 'ASC');

    return $CI->db->get(db_prefix() . 'milestones')->result_array();
}

/**
 * Return project milestones
 * @param  mixed $project_id project id
 * @return array
 */
function get_disputes_case_contracts($project_id = '', $slug)
{
    $CI = &get_instance();
    if($project_id != ''){
        $CI->db->where('rel_sid', $project_id);
    }
    $CI->db->where('rel_stype', $slug);
    return $CI->db->get(db_prefix() . 'contracts')->result_array();
}

/**
 * Get project client id by passed project id
 * @param  mixed $id project id
 * @return mixed
 */
function get_client_id_by_disputes_case_id($id)
{
    $CI = & get_instance();
    $CI->db->select('clientid');
    $CI->db->where('id', $id);
    $project = $CI->db->get(db_prefix() . 'my_disputes_cases')->row();
    if ($project) {
        return $project->clientid;
    }

    return false;
}

function get_opponent_lawyer_by_id($id)
{
    $CI = & get_instance();
    $CI->db->where('userid', $id);
    $opponent_lawyer = $CI->db->get(db_prefix() . 'clients')->row();
    if ($opponent_lawyer) {
        return $opponent_lawyer;
    }

    return false;
}

function get_opponent_id_by_disputes_case_id($id)
{
    $CI = & get_instance();
    $CI->db->select('opponent_id');
    $CI->db->where('id', $id);
    $project = $CI->db->get(db_prefix() . 'my_disputes_cases')->row();
    if ($project) {
        return $project->opponent_id;
    }

    return false;
}

/**
 * Check if customer has project assigned
 * @param  mixed $customer_id customer id to check
 * @return boolean
 */
function customer_has_disputes_cases($customer_id)
{
    $totalCustomerProjects = total_rows(db_prefix() . 'my_disputes_cases', 'clientid=' . $customer_id);

    return ($totalCustomerProjects > 0 ? true : false);
}

/**
 * Get project billing type
 * @param  mixed $project_id
 * @return mixed
 */
function get_disputes_case_billing_type($project_id)
{
    $CI = & get_instance();
    $CI->db->select('billing_type');
    $CI->db->where('id', $project_id);
    $project = $CI->db->get(db_prefix() . 'my_disputes_cases')->row();
    if ($project) {
        return $project->billing_type;
    }

    return false;
}
/**
 * Get project deadline
 * @param  mixed $project_id
 * @return mixed
 */
function get_disputes_case_deadline($project_id)
{
    $CI = & get_instance();
    $CI->db->select('deadline');
    $CI->db->where('id', $project_id);
    $project = $CI->db->get(db_prefix() . 'my_disputes_cases')->row();
    if ($project) {
        return $project->deadline;
    }

    return false;
}

/**
 * Translated jquery-comment language based on app languages
 * This feature is used on both admin and customer area
 * @return array
 */
function get_disputes_case_discussions_language_array()
{
    $lang = [
        'discussion_add_comment'      => _l('discussion_add_comment'),
        'discussion_newest'           => _l('discussion_newest'),
        'discussion_oldest'           => _l('discussion_oldest'),
        'discussion_attachments'      => _l('discussion_attachments'),
        'discussion_send'             => _l('discussion_send'),
        'discussion_reply'            => _l('discussion_reply'),
        'discussion_edit'             => _l('discussion_edit'),
        'discussion_edited'           => _l('discussion_edited'),
        'discussion_you'              => _l('discussion_you'),
        'discussion_save'             => _l('discussion_save'),
        'discussion_delete'           => _l('discussion_delete'),
        'discussion_view_all_replies' => _l('discussion_view_all_replies'),
        'discussion_hide_replies'     => _l('discussion_hide_replies'),
        'discussion_no_comments'      => _l('discussion_no_comments'),
        'discussion_no_attachments'   => _l('discussion_no_attachments'),
        'discussion_attachments_drop' => _l('discussion_attachments_drop'),
    ];

    return $lang;
}

/**
 * Check if project has recurring tasks
 * @param  mixed $id project id
 * @return boolean
 */
function disputes_disputes_case_has_recurring_tasks($id)
{
    return total_rows(db_prefix() . 'tasks', 'recurring=11 AND rel_id="' . $id . '" AND rel_type="project"') > 0;
}

function total_disputes_case_tasks_by_milestone($milestone_id, $project_id, $slug='')
{
    return total_rows(db_prefix() . 'tasks', [
        'rel_type'  => $slug,
        'rel_id'    => $project_id,
        'milestone' => $milestone_id,
    ]);
}

function total_disputes_case_finished_tasks_by_milestone($milestone_id, $project_id, $slug='')
{
    return total_rows(db_prefix() . 'tasks', [
        'rel_type'  => $slug,
        'rel_id'    => $project_id,
        'status'    => 5,
        'milestone' => $milestone_id,
    ]);
}

function get_disputes_cases_countries($field)
{
    $CI = & get_instance();
    if($field == 'short_name'){
        $field = 'short_name_ar';
    }
    return $CI->db->get_where(db_prefix().'countries', array($field.'!=' => ''))->result_array();
}

function disputes_case_file_url($file, $preview = false)
{
    $path     = 'uploads/disputes_cases/' . $file['project_id'] . '/';
    $fullPath = FCPATH . $path . $file['file_name'];
    $url      = base_url($path . $file['file_name']);

    if (!empty($file['external']) && !empty($file['thumbnail_link'])) {
        $url = $file['thumbnail_link'];
    } else {
        if ($preview) {
            $fname     = pathinfo($fullPath, PATHINFO_FILENAME);
            $fext      = pathinfo($fullPath, PATHINFO_EXTENSION);
            $thumbPath = pathinfo($fullPath, PATHINFO_DIRNAME) . '/' . $fname . '_thumb.' . $fext;
            if (file_exists($thumbPath)) {
                $url = base_url('uploads/disputes_cases/' . $file['project_id'] . '/' . $fname . '_thumb.' . $fext);
            }
        }
    }

    return $url;
}

function get_tags_disputes_case($id)
{
    return _call_tags_method('GetTagsDisputes_cases', $id);
}

//function init_relation_tasks_disputes_case_table($table_attributes = [])
//{
//    $slug = $table_attributes['data-new-rel-slug'];
//    $table_data = [
//        _l('the_number_sign'),
//        [
//            'name'     => _l('tasks_dt_name'),
//            'th_attrs' => [
//                'style' => 'min-width:200px',
//            ],
//        ],
//        _l('task_status'),
//        [
//            'name'     => _l('tasks_dt_datestart'),
//            'th_attrs' => [
//                'style' => 'min-width:75px',
//            ],
//        ],
//        [
//            'name'     => _l('task_duedate'),
//            'th_attrs' => [
//                'style' => 'min-width:75px',
//                'class' => 'duedate',
//            ],
//        ],
//        [
//            'name'     => _l('task_assigned'),
//            'th_attrs' => [
//                'style' => 'min-width:75px',
//            ],
//        ],
//        _l('tags'),
//        _l('tasks_list_priority'),
//    ];
//
//    array_unshift($table_data, [
//        'name'     => '<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="rel-tasks_disputes_case"><label></label></div>',
//        'th_attrs' => ['class' => ($table_attributes['data-new-rel-type'] !== "$slug" ? 'not_visible' : '')],
//    ]);
//
//    $custom_fields = get_custom_fields('tasks', [
//        'show_on_table' => 1,
//    ]);
//
//    foreach ($custom_fields as $field) {
//        array_push($table_data, $field['name']);
//    }
//
//
//    $table_data = hooks()->apply_filters('tasks_related_table_columns', $table_data);
//
//    $name = 'rel-tasks_disputes_case';
//    if ($table_attributes['data-new-rel-type'] == 'lead') {
//        $name = 'rel-tasks-leads';
//    }
//
//    $table      = '';
//    $CI         = & get_instance();
//    $table_name = '.table-' . $name;
//    $CI->load->view('admin/tasks/tasks_filter_by', [
//        'view_table_name' => $table_name,
//    ]);
//    if (has_permission('tasks', '', 'create')) {
//        $disabled   = '';
//        $table_name = addslashes($table_name);
//        if ($table_attributes['data-new-rel-type'] == 'customer' && is_numeric($table_attributes['data-new-rel-id'])) {
//            if (total_rows(db_prefix() . 'clients', [
//                    'active' => 0,
//                    'userid' => $table_attributes['data-new-rel-id'],
//                ]) > 0) {
//                $disabled = ' disabled';
//            }
//        }
//        // projects have button on top
//        if ($table_attributes['data-new-rel-type'] != "$slug") {
//            echo "<a href='#' class='btn btn-info pull-left mbot25 mright5 new-task-relation" . $disabled . "' onclick=\"new_task_from_relation('$table_name'); return false;\" data-rel-id='" . $table_attributes['data-new-rel-id'] . "' data-rel-type='" . $table_attributes['data-new-rel-type'] . "'>" . _l('new_task') . '</a>';
//        }
//    }
//
//    if ($table_attributes['data-new-rel-type'] == "$slug") {
//        echo "<a href='" . admin_url('tasks/detailed_overview?rel_type='.$slug.'&project_id=' . $table_attributes['data-new-rel-id']) . "' class='btn btn-success pull-right mbot25'>" . _l('detailed_overview') . '</a>';
//        echo "<a href='" . admin_url('tasks/list_tasks_for_LegalServices?rel_type='.$slug.'&project_id=' . $table_attributes['data-new-rel-id'] . '&kanban=true') . "' class='btn btn-default pull-right mbot25 mright5 hidden-xs'>" . _l('view_kanban') . '</a>';
//        echo '<div class="clearfix"></div>';
//        echo $CI->load->view('admin/tasks/_bulk_actions', ['table' => '.table-rel-tasks_disputes_case'], true);
//        echo $CI->load->view('admin/tasks/_summary', ['rel_id' => $table_attributes['data-new-rel-id'], 'rel_type' => "$slug", 'table' => $table_name], true);
//        echo '<a href="#" data-toggle="modal" data-target="#tasks_bulk_actions" class="hide bulk-actions-btn table-btn" data-table=".table-rel-tasks_disputes_case">' . _l('bulk_actions') . '</a>';
//    } elseif ($table_attributes['data-new-rel-type'] == 'customer') {
//        echo '<div class="clearfix"></div>';
//        echo '<div id="tasks_related_filter">';
//        echo '<p class="bold">' . _l('task_related_to') . ': </p>';
//
//        echo '<div class="checkbox checkbox-inline mbot25">
//        <input type="checkbox" checked value="customer" disabled id="ts_rel_to_customer" name="tasks_related_to[]">
//        <label for="ts_rel_to_customer">' . _l('client') . '</label>
//        </div>
//
//        <div class="checkbox checkbox-inline mbot25">
//        <input type="checkbox" value="project" id="ts_rel_to_project" name="tasks_related_to[]">
//        <label for="ts_rel_to_project">' . _l('projects') . '</label>
//        </div>
//
//        <div class="checkbox checkbox-inline mbot25">
//        <input type="checkbox" value="invoice" id="ts_rel_to_invoice" name="tasks_related_to[]">
//        <label for="ts_rel_to_invoice">' . _l('invoices') . '</label>
//        </div>
//
//        <div class="checkbox checkbox-inline mbot25">
//        <input type="checkbox" value="estimate" id="ts_rel_to_estimate" name="tasks_related_to[]">
//        <label for="ts_rel_to_estimate">' . _l('estimates') . '</label>
//        </div>
//
//        <div class="checkbox checkbox-inline mbot25">
//        <input type="checkbox" value="contract" id="ts_rel_to_contract" name="tasks_related_to[]">
//        <label for="ts_rel_to_contract">' . _l('contracts') . '</label>
//        </div>
//
//        <div class="checkbox checkbox-inline mbot25">
//        <input type="checkbox" value="ticket" id="ts_rel_to_ticket" name="tasks_related_to[]">
//        <label for="ts_rel_to_ticket">' . _l('tickets') . '</label>
//        </div>
//
//        <div class="checkbox checkbox-inline mbot25">
//        <input type="checkbox" value="expense" id="ts_rel_to_expense" name="tasks_related_to[]">
//        <label for="ts_rel_to_expense">' . _l('expenses') . '</label>
//        </div>
//
//        <div class="checkbox checkbox-inline mbot25">
//        <input type="checkbox" value="proposal" id="ts_rel_to_proposal" name="tasks_related_to[]">
//        <label for="ts_rel_to_proposal">' . _l('proposals') . '</label>
//        </div>';
//
//        echo '</div>';
//    }else{
//        echo "<a href='" . admin_url('tasks/detailed_overview?project_id=' . $table_attributes['data-new-rel-id']) . "' class='btn btn-success pull-right mbot25'>" . _l('detailed_overview') . '</a>';
//        echo "<a href='" . admin_url('tasks/list_tasks?project_id=' . $table_attributes['data-new-rel-id'] . '&kanban=true') . "' class='btn btn-default pull-right mbot25 mright5 hidden-xs'>" . _l('view_kanban') . '</a>';
//        echo '<div class="clearfix"></div>';
//        echo $CI->load->view('admin/tasks/_bulk_actions', ['table' => '.table-rel-tasks_disputes_case'], true);
//        echo $CI->load->view('admin/tasks/_summary', ['rel_id' => $table_attributes['data-new-rel-id'], 'rel_type' => $table_attributes['data-new-rel-type'], 'table' => $table_name], true);
//        echo '<a href="#" data-toggle="modal" data-target="#tasks_bulk_actions" class="hide bulk-actions-btn table-btn" data-table=".table-rel-tasks_disputes_case">' . _l('bulk_actions') . '</a>';
//    }
//    echo "<div class='clearfix'></div>";
//
//    // If new column is added on tasks relations table this will not work fine
//    // In this disputes_case we need to add new identifier eq task-relation
//    $table_attributes['data-last-order-identifier'] = 'tasks_disputes_case';
//    $table_attributes['data-default-order']         = get_table_last_order('tasks_disputes_case');
//
//    $table .= render_datatable($table_data, $name, [], $table_attributes);
//
//    return $table;
//}

function AdminTicketsDisputes_caseTableStructure($name = '', $bulk_action = false, $slug)
{
    $table = '<table class="table customizable-table dt-table-loading ' . ($name == '' ? 'tickets_disputes_case-table' : $name) . ' table-tickets_disputes_case" id="table-tickets_disputes_case" data-last-order-identifier="tickets_disputes_case" data-default-order="' . get_table_last_order('tickets_disputes_case') . '"  data-slug='.$slug.'>';
    $table .= '<thead>';
    $table .= '<tr>';

    $table .= '<th class="' . ($bulk_action == true ? '' : 'not_visible') . '">';
    $table .= '<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="tickets_disputes_case"><label></label></div>';
    $table .= '</th>';

    $table .= '<th class="toggleable" id="th-number">' . _l('the_number_sign') . '</th>';
    $table .= '<th class="toggleable" id="th-subject">' . _l('ticket_dt_subject') . '</th>';
    $table .= '<th class="toggleable" id="th-tags">' . _l('tags') . '</th>';
    $table .= '<th class="toggleable" id="th-department">' . _l('ticket_dt_department') . '</th>';
    $services_th_attrs = '';
    if (get_option('services') == 0) {
        $services_th_attrs = ' class="not_visible"';
    }
    $table .= '<th' . $services_th_attrs . '>' . _l('ticket_dt_service') . '</th>';
    $table .= '<th class="toggleable" id="th-submitter">' . _l('ticket_dt_submitter') . '</th>';
    $table .= '<th class="toggleable" id="th-status">' . _l('ticket_dt_status') . '</th>';
    $table .= '<th class="toggleable" id="th-priority">' . _l('ticket_dt_priority') . '</th>';
    $table .= '<th class="toggleable" id="th-last-reply">' . _l('ticket_dt_last_reply') . '</th>';
    $table .= '<th class="toggleable ticket_created_column" id="th-created">' . _l('ticket_date_created') . '</th>';

    $custom_fields = get_table_custom_fields('tickets');

    foreach ($custom_fields as $field) {
        $table .= '<th>' . $field['name'] . '</th>';
    }

    $table .= '</tr>';
    $table .= '</thead>';
    $table .= '<tbody></tbody>';
    $table .= '</table>';

    $table .= '<script id="hidden-columns-table-tickets_disputes_case" type="text/json">';
    $table .= get_staff_meta(get_staff_user_id(), 'hidden-columns-table-tickets_disputes_case');
    $table .= '</script>';

    return $table;
}

function handle_disputes_case_file_uploads($ServID, $project_id)
{
    $filesIDS = [];
    $errors   = [];
    if (isset($_FILES['file']['name'])
        && ($_FILES['file']['name'] != '' || is_array($_FILES['file']['name']) && count($_FILES['file']['name']) > 0)) {
        hooks()->do_action('before_upload_project_attachment', $project_id);

        if (!is_array($_FILES['file']['name'])) {
            $_FILES['file']['name']     = [$_FILES['file']['name']];
            $_FILES['file']['type']     = [$_FILES['file']['type']];
            $_FILES['file']['tmp_name'] = [$_FILES['file']['tmp_name']];
            $_FILES['file']['error']    = [$_FILES['file']['error']];
            $_FILES['file']['size']     = [$_FILES['file']['size']];
        }
        if(!file_exists('uploads/disputes_cases')){
            mkdir('uploads/disputes_cases');
        }
            $path = get_upload_path_by_type_disputes_case('disputes_case') . $project_id . '/';
        for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
            if (_babil_upload_error($_FILES['file']['error'][$i])) {
                $errors[$_FILES['file']['name'][$i]] = _babil_upload_error($_FILES['file']['error'][$i]);

                continue;
            }

            // Get the temp file path
            $tmpFilePath = $_FILES['file']['tmp_name'][$i];
            // Make sure we have a filepath
            if (!empty($tmpFilePath) && $tmpFilePath != '') {
                _maybe_create_upload_path($path);
                $filename = unique_filename($path, $_FILES['file']['name'][$i]);

                // In disputes_case client side validation is bypassed
                if (!_upload_extension_allowed($filename)) {
                    continue;
                }

                $newFilePath = $path . $filename;
                // Upload the file into the company uploads dir
                if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                    $CI = & get_instance();
                    if (is_client_logged_in()) {
                        $contact_id = get_contact_user_id();
                        $staffid    = 0;
                    } else {
                        $staffid    = get_staff_user_id();
                        $contact_id = 0;
                    }
                    $data = [
                        'project_id' => $project_id,
                        'file_name'  => $filename,
                        'filetype'   => $_FILES['file']['type'][$i],
                        'dateadded'  => date('Y-m-d H:i:s'),
                        'staffid'    => $staffid,
                        'contact_id' => $contact_id,
                        'subject'    => $filename,
                    ];
                    if (is_client_logged_in()) {
                        $data['visible_to_customer'] = 1;
                    } else {
                        $data['visible_to_customer'] = ($CI->input->post('visible_to_customer') == 'true' ? 1 : 0);
                    }
                    $CI->db->insert(db_prefix().'my_disputes_case_files', $data);

                    $insert_id = $CI->db->insert_id();
                    if ($insert_id) {
                        if (is_image($newFilePath)) {
                            create_img_thumb($path, $filename);
                        }
                        array_push($filesIDS, $insert_id);
                    } else {
                        unlink($newFilePath);

                        return false;
                    }
                }
            }
        }
    }
    if (count($filesIDS) > 0) {
        $CI->load->model('legalservices/disputes_cases/disputes_cases_model', 'disputes_case');
        end($filesIDS);
        $lastFileID = key($filesIDS);
        $CI->disputes_case->new_project_file_notification($ServID,$filesIDS[$lastFileID], $project_id);
    }

    if (count($errors) > 0) {
        $message = '';
        foreach ($errors as $filename => $error_message) {
            $message .= $filename . ' - ' . $error_message . '<br />';
        }
        header('HTTP/1.0 400 Bad error');
        echo $message;
        die;
    }

    if (count($filesIDS) > 0) {
        return true;
    }

    return false;
}

function get_upload_path_by_type_disputes_case($type)
{
    $path = '';
    switch ($type) {
        case 'disputes_case':
            $path = 'uploads/disputes_cases/';
            break;
    }

    return hooks()->apply_filters('get_upload_path_by_type', $path, $type);
}

function handle_disputes_case_discussion_comment_attachments($discussion_id, $post_data, $insert_data)
{
    if (isset($_FILES['file']['name']) && _babil_upload_error($_FILES['file']['error'])) {
        header('HTTP/1.0 400 Bad error');
        echo json_encode(['message' => _babil_upload_error($_FILES['file']['error'])]);
        die;
    }

    if (isset($_FILES['file']['name'])) {
        hooks()->do_action('before_upload_project_discussion_comment_attachment');
        $path = CASE_DISCUSSION_ATTACHMENT_FOLDER . $discussion_id . '/';

        // Check for all disputes_cases if this extension is allowed
        if (!_upload_extension_allowed($_FILES['file']['name'])) {
            header('HTTP/1.0 400 Bad error');
            echo json_encode(['message' => _l('file_php_extension_blocked')]);
            die;
        }

        // Get the temp file path
        $tmpFilePath = $_FILES['file']['tmp_name'];
        // Make sure we have a filepath
        if (!empty($tmpFilePath) && $tmpFilePath != '') {
            _maybe_create_upload_path($path);
            $filename    = unique_filename($path, $_FILES['file']['name']);
            $newFilePath = $path . $filename;
            // Upload the file into the temp dir
            if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                $insert_data['file_name'] = $filename;

                if (isset($_FILES['file']['type'])) {
                    $insert_data['file_mime_type'] = $_FILES['file']['type'];
                } else {
                    $insert_data['file_mime_type'] = get_mime_by_extension($filename);
                }
            }
        }
    }

    return $insert_data;
}
function disputes_get_invoice_total_left_to_pay($id, $invoice_total = null)
{
    $CI = & get_instance();

    if ($invoice_total === null) {
        $CI->db->select('total')
            ->where('id', $id);
        $invoice_total = $CI->db->get(db_prefix() . 'my_disputes_cases_invoices')->row()->total;
    }

    if (!class_exists('payments_model')) {
        $CI->load->model('legalservices/disputes_cases/disputes_payments_model','payments');
    }

    if (!class_exists('credit_notes_model')) {
        $CI->load->model('credit_notes_model');
    }

    $payments = $CI->payments->get_invoice_payments($id);
    $credits  = $CI->credit_notes_model->get_applied_invoice_credits($id);

    $payments = array_merge($payments, $credits);

    $totalPayments = 0;

    $bcadd = function_exists('bcadd');

    foreach ($payments as $payment) {
        if ($bcadd) {
            $totalPayments = bcadd($totalPayments, $payment['amount'], get_decimal_places());
        } else {
            $totalPayments += $payment['amount'];
        }
    }

    if (function_exists('bcsub')) {
        return bcsub($invoice_total, $totalPayments, get_decimal_places());
    }

    return number_format($invoice_total - $totalPayments, get_decimal_places(), '.', '');
}


/**
 * Check if invoice email template for overdue notices is enabled
 * @return boolean
 */
function disputes_is_invoices_email_overdue_notice_enabled()
{
    return total_rows(db_prefix() . 'emailtemplates', ['slug' => 'invoice-overdue-notice', 'active' => 1]) > 0;
}

/**
 * Check if there are sources for sending invoice overdue notices
 * Will be either email or SMS
 * @return boolean
 */
function disputes_is_invoices_overdue_reminders_enabled()
{
    return disputes_is_invoices_email_overdue_notice_enabled() || is_sms_trigger_active(SMS_TRIGGER_INVOICE_OVERDUE);
}

/**
 * Check invoice restrictions - hash, clientid
 * @since  Version 1.0.1
 * @param  mixed $id   invoice id
 * @param  string $hash invoice hash
 */
function disputes_check_invoice_restrictions($id, $hash)
{
//    $CI = & get_instance();
//    if (!class_exists('legalservices/Disputes_cases_model', false)) {
//        get_instance()->load->model('legalservices/disputes_cases_model', 'disputes_case');
//    }

    get_instance()->load->model('legalservices/disputes_cases/disputes_invoices_model','invoices');
    if (!$hash || !$id) {
        show_404();
    }
    if (!is_client_logged_in() && !is_staff_logged_in()) {
        if (get_option('view_invoice_only_logged_in') == 1) {
            redirect_after_login_to_current_url();
            redirect(site_url('authentication/login'));
        }
    }
    $invoice = get_instance()->invoices->get($id);
    if (!$invoice || ($invoice->hash != $hash)) {
        show_404();
    }

    // Do one more check
    if (!is_staff_logged_in()) {
        if (get_option('view_invoice_only_logged_in') == 1) {
            if ($invoice->clientid != get_client_user_id()) {
                show_404();
            }
        }
    }
}

/**
 * Format invoice status
 * @param  integer  $status
 * @param  string  $classes additional classes
 * @param  boolean $label   To include in html label or not
 * @return mixed
 */
function disputes_format_invoice_status($status, $classes = '', $label = true)
{
    if (!class_exists('Disputes_invoices_model', false)) {
        get_instance()->load->model('legalservices/disputes_cases/disputes_invoices_model','invoices');
    }

    $id          = $status;
    $label_class = disputes_get_invoice_status_label($status);
    if ($status == 1) {
        $status = _l('invoice_status_unpaid');
    } elseif ($status == 2) {
        $status = _l('invoice_status_paid');
    } elseif ($status == 3) {
        $status = _l('invoice_status_not_paid_completely');
    } elseif ($status == 4) {
        $status = _l('invoice_status_overdue');
    } elseif ($status == 5) {
        $status = _l('invoice_status_cancelled');
    } else {
        $status = _l('invoice_status_draft');
    }
    if ($label == true) {
        return '<span class="label label-' . $label_class . ' ' . $classes . ' s-status invoice-status-' . $id . '">' . $status . '</span>';
    }

    return $status;
}
/**
 * Return invoice status label class baed on twitter bootstrap classses
 * @param  mixed $status invoice status id
 * @return string
 */
function disputes_get_invoice_status_label($status)
{
    if (!class_exists('Disputes_invoices_model', false)) {
        get_instance()->load->model('legalservices/disputes_cases/disputes_invoices_model','invoices');
    }

    $label_class = '';
    if ($status == 1) {
        $label_class = 'danger';
    } elseif ($status == 2) {
        $label_class = 'success';
    } elseif ($status == 3) {
        $label_class = 'warning';
    } elseif ($status == 4) {
        $label_class = 'warning';
    } elseif ($status == 5 || $status == 6) {
        $label_class = 'default';
    } else {
        if (!is_numeric($status)) {
            if ($status == 'not_sent') {
                $label_class = 'default';
            }
        }
    }

    return $label_class;
}

/**
 * Function used in invoice PDF, this function will return RGBa color for PDF dcouments
 * @param  mixed $status_id current invoice status id
 * @return string
 */
function disputes_invoice_status_color_pdf($status_id)
{
    $statusColor = '';

    if (!class_exists('Disputes_invoices_model', false)) {
        get_instance()->load->model('legalservices/disputes_cases/disputes_invoices_model','invoices');
    }

    if ($status_id == 1) {
        $statusColor = '252, 45, 66';
    } elseif ($status_id == 2) {
        $statusColor = '0, 191, 54';
    } elseif ($status_id == 3) {
        $statusColor = '255, 111, 0';
    } elseif ($status_id == 4) {
        $statusColor = '255, 111, 0';
    } elseif ($status_id == 5 || $status_id == 6) {
        $statusColor = '114, 123, 144';
    }

    return $statusColor;
}

/**
 * Update invoice status
 * @param  mixed $id invoice id
 * @return mixed invoice updates status / if no update return false
 * @return boolean $prevent_logging do not log changes if the status is updated for the invoice activity log
 */
function disputes_update_invoice_status($id, $force_update = false, $prevent_logging = false)
{
    $CI = & get_instance();

    $CI->load->model('legalservices/disputes_cases/disputes_invoices_model','invoices');
    $invoice = $CI->invoices->get($id);

    $original_status = $invoice->status;

    if (($original_status == 6 && $force_update == false)
        || ($original_status == 5 && $force_update == false)) {
        return false;
    }

    $CI->db->select('amount')
        ->where('invoiceid', $id)
        ->order_by(db_prefix() . 'my_disputes_cases_invoicepaymentrecords.id', 'asc');
    $payments = $CI->db->get(db_prefix() . 'my_disputes_cases_invoicepaymentrecords')->result_array();

    if (!class_exists('credit_notes_model')) {
        $CI->load->model('credit_notes_model');
    }

    $credits = $CI->credit_notes_model->get_applied_invoice_credits($id);
    // Merge credits applied with payments, credits in this function are casted as payments directly to invoice
    // This merge will help to update the status
    $payments = array_merge($payments, $credits);

    $totalPayments = [];
    $status        = 1;

    // Check if the first payments is equal to invoice total
    if (isset($payments[0])) {
        if ($payments[0]['amount'] == $invoice->total) {
            // Paid status
            $status = 2;
        } else {
            foreach ($payments as $payment) {
                array_push($totalPayments, $payment['amount']);
            }

            $totalPayments = array_sum($totalPayments);

            if ((function_exists('bccomp')
                    ?  bccomp($invoice->total, $totalPayments, get_decimal_places()) === 0
                    || bccomp($invoice->total, $totalPayments, get_decimal_places()) === -1
                    : number_format(($invoice->total - $totalPayments), get_decimal_places(), '.', '') == '0')
                || $totalPayments > $invoice->total) {
                // Paid status
                $status = 2;
            } elseif ($totalPayments == 0) {
                // Unpaid status
                $status = 1;
            } else {
                if ($invoice->duedate != null) {
                    if ($totalPayments > 0) {
                        // Not paid completely status
                        $status = 3;
                    } elseif (date('Y-m-d', strtotime($invoice->duedate)) < date('Y-m-d')) {
                        $status = 4;
                    }
                } else {
                    // Not paid completely status
                    $status = 3;
                }
            }
        }
    } else {
        if ($invoice->total == 0) {
            $status = 2;
        } else {
            if ($invoice->duedate != null) {
                if (date('Y-m-d', strtotime($invoice->duedate)) < date('Y-m-d')) {
                    // Overdue status
                    $status = 4;
                }
            }
        }
    }

    $CI->db->where('id', $id);
    $CI->db->update(db_prefix() . 'my_disputes_cases_invoices', [
        'status' => $status,
    ]);

    if ($CI->db->affected_rows() > 0) {
        hooks()->do_action('invoice_status_changed', ['invoice_id' => $id, 'status' => $status]);
        if ($prevent_logging == true) {
            return $status;
        }

        $log = 'Invoice Status Updated [Invoice Number: ' . disputes_format_invoice_number($invoice->id) . ', From: ' . disputes_format_invoice_status($original_status, '', false) . ' To: ' . disputes_format_invoice_status($status, '', false) . ']';

        log_activity($log, null);

        $additional_activity = serialize([
            '<original_status>' . $original_status . '</original_status>',
            '<new_status>' . $status . '</new_status>',
        ]);

        $CI->invoices->log_invoice_activity($invoice->id, 'invoice_activity_status_updated', false, $additional_activity);

        return $status;
    }

    return false;
}


/**
 * Check if the invoice id is last invoice
 * @param  mixed  $id invoice id
 * @return boolean
 */
function disputes_is_last_invoice($id)
{
    $CI = & get_instance();
    $CI->db->select('id')->from(db_prefix() . 'my_disputes_cases_invoices')->order_by('id', 'desc')->limit(1);
    $query           = $CI->db->get();
    $last_invoice_id = $query->row()->id;
    if ($last_invoice_id == $id) {
        return true;
    }

    return false;
}

/**
 * Format invoice number based on description
 * @param  mixed $id
 * @return string
 */
function disputes_format_invoice_number($id)
{
    $CI = & get_instance();
    $CI->db->select('date,number,prefix,number_format')->from(db_prefix() . 'my_disputes_cases_invoices')->where('id', $id);
    $invoice = $CI->db->get()->row();

    if (!$invoice) {
        return '';
    }

    $number = sales_number_format($invoice->number, $invoice->number_format, $invoice->prefix, $invoice->date);

    return hooks()->apply_filters('disputes_format_invoice_number', $number, [
        'id'      => $id,
        'invoice' => $invoice,
    ]);
}

/**
 * Function that return invoice item taxes based on passed item id
 * @param  mixed $itemid
 * @return array
 */
function disputes_get_invoice_item_taxes($itemid)
{
    $CI = & get_instance();
    $CI->db->where('itemid', $itemid);
    $CI->db->where('rel_type', 'invoice');
    $taxes = $CI->db->get(db_prefix() . 'item_tax')->result_array();
    $i     = 0;
    foreach ($taxes as $tax) {
        $taxes[$i]['taxname'] = $tax['taxname'] . '|' . $tax['taxrate'];
        $i++;
    }

    return $taxes;
}

/**
 * Check if payment mode is allowed for specific invoice
 * @param  mixed  $id payment mode id
 * @param  mixed  $invoiceid invoice id
 * @return boolean
 */
function disputes_is_payment_mode_allowed_for_invoice($id, $invoiceid)
{
    $CI = & get_instance();
    $CI->db->select('' . db_prefix() . 'currencies.name as currency_name,allowed_payment_modes')->from(db_prefix() . 'my_disputes_cases_invoices')->join(db_prefix() . 'currencies', '' . db_prefix() . 'currencies.id = ' . db_prefix() . 'my_disputes_cases_invoices.currency', 'left')->where(db_prefix() . 'my_disputes_cases_invoices.id', $invoiceid);
    $invoice       = $CI->db->get()->row();
    $allowed_modes = $invoice->allowed_payment_modes;
    if (!is_null($allowed_modes)) {
        $allowed_modes = unserialize($allowed_modes);
        if (count($allowed_modes) == 0) {
            return false;
        }
        foreach ($allowed_modes as $mode) {
            if ($mode == $id) {
                // is offline payment mode
                if (is_numeric($id)) {
                    return true;
                }
                // check currencies
                $currencies = explode(',', get_option('paymentmethod_' . $id . '_currencies'));
                foreach ($currencies as $currency) {
                    $currency = trim($currency);
                    if (mb_strtoupper($currency) == mb_strtoupper($invoice->currency_name)) {
                        return true;
                    }
                }

                return false;
            }
        }
    } else {
        return false;
    }

    return false;
}
/**
 * Check if invoice mode exists in invoice
 * @since  Version 1.0.1
 * @param  array  $modes     all invoice modes
 * @param  mixed  $invoiceid invoice id
 * @param  boolean $offline   should check offline or online modes
 * @return boolean
 */
function disputes_found_invoice_mode($modes, $invoiceid, $offline = true, $show_on_pdf = false)
{
    $CI = & get_instance();
    $CI->db->select('' . db_prefix() . 'currencies.name as currency_name,allowed_payment_modes')->from(db_prefix() . 'my_disputes_cases_invoices')->join(db_prefix() . 'currencies', '' . db_prefix() . 'currencies.id = ' . db_prefix() . 'my_disputes_cases_invoices.currency', 'left')->where(db_prefix() . 'my_disputes_cases_invoices.id', $invoiceid);
    $invoice = $CI->db->get()->row();
    if (!is_null($invoice->allowed_payment_modes)) {
        $invoice->allowed_payment_modes = unserialize($invoice->allowed_payment_modes);
        if (count($invoice->allowed_payment_modes) == 0) {
            return false;
        }
        foreach ($modes as $mode) {
            if ($offline == true) {
                if (is_numeric($mode['id']) && is_array($invoice->allowed_payment_modes)) {
                    foreach ($invoice->allowed_payment_modes as $allowed_mode) {
                        if ($allowed_mode == $mode['id']) {
                            if ($show_on_pdf == false) {
                                return true;
                            }
                            if ($mode['show_on_pdf'] == 1) {
                                return true;
                            }

                            return false;
                        }
                    }
                }
            } else {
                if (!is_numeric($mode['id']) && !empty($mode['id'])) {
                    foreach ($invoice->allowed_payment_modes as $allowed_mode) {
                        if ($allowed_mode == $mode['id']) {
                            // Check for currencies
                            $currencies = explode(',', get_option('paymentmethod_' . $mode['id'] . '_currencies'));
                            foreach ($currencies as $currency) {
                                $currency = trim($currency);
                                if (strtoupper($currency) == strtoupper($invoice->currency_name)) {
                                    return true;
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    return false;
}

/**
 * This function do not work with cancelled status
 * Calculate invoices percent by status
 * @param  mixed $status          estimate status
 * @param  mixed $total_invoices in case the total is calculated in other place
 * @return array
 */
function disputes_get_invoices_percent_by_status($status)
{
    $has_permission_view = has_permission('invoices', '', 'view');
    $total_invoices      = total_rows(db_prefix() . 'my_disputes_cases_invoices', 'status NOT IN(5)' . (!$has_permission_view ? ' AND (' . disputes_get_invoices_where_sql_for_staff(get_staff_user_id()) . ')' : ''));

    $data            = [];
    $total_by_status = 0;
    if (!is_numeric($status)) {
        if ($status == 'not_sent') {
            $total_by_status = total_rows(db_prefix() . 'my_disputes_cases_invoices', 'sent=0 AND status NOT IN(2,5)' . (!$has_permission_view ? ' AND (' . disputes_get_invoices_where_sql_for_staff(get_staff_user_id()) . ')' : ''));
        }
    } else {
        $total_by_status = total_rows(db_prefix() . 'my_disputes_cases_invoices', 'status = ' . $status . ' AND status NOT IN(5)' . (!$has_permission_view ? ' AND (' . disputes_get_invoices_where_sql_for_staff(get_staff_user_id()) . ')' : ''));
    }
    $percent                 = ($total_invoices > 0 ? number_format(($total_by_status * 100) / $total_invoices, 2) : 0);
    $data['total_by_status'] = $total_by_status;
    $data['percent']         = $percent;
    $data['total']           = $total_invoices;

    return $data;
}
/**
 * Check if staff member have assigned invoices / added as sale agent
 * @param  mixed $staff_id staff id to check
 * @return boolean
 */
function disputes_staff_has_assigned_invoices($staff_id = '')
{
    $CI       = &get_instance();
    $staff_id = is_numeric($staff_id) ? $staff_id : get_staff_user_id();
    $cache    = $CI->app_object_cache->get('staff-total-assigned-invoices-' . $staff_id);

    if (is_numeric($cache)) {
        $result = $cache;
    } else {
        $result = total_rows(db_prefix() . 'my_disputes_cases_invoices', ['sale_agent' => $staff_id]);
        $CI->app_object_cache->add('staff-total-assigned-invoices-' . $staff_id, $result);
    }

    return $result > 0 ? true : false;
}

/**
 * Load invoices total templates
 * This is the template where is showing the panels Outstanding Invoices, Paid Invoices and Past Due invoices
 * @return string
 */
function disputes_load_invoices_total_template()
{
    $CI = &get_instance();
    $CI->load->model('legalservices/disputes_cases/disputes_invoices_model','invoices');
    $_data = $CI->input->post();
    if (!$CI->input->post('customer_id')) {
        $multiple_currencies = call_user_func('is_using_multiple_currencies');
    } else {
        $_data['customer_id'] = $CI->input->post('customer_id');
        $multiple_currencies  = call_user_func('is_client_using_multiple_currencies', $CI->input->post('customer_id'));
    }

    if ($CI->input->post('project_id')) {
        $_data['project_id'] = $CI->input->post('project_id');
    }

    if ($multiple_currencies) {
        $CI->load->model('currencies_model');
        $data['invoices_total_currencies'] = $CI->currencies_model->get();
    }

    $data['invoices_years'] = $CI->invoices->get_invoices_years();

    if (count($data['invoices_years']) >= 1 && $data['invoices_years'][0]['year'] != date('Y')) {
        array_unshift($data['invoices_years'], ['year' => date('Y')]);
    }

    $data['total_result'] = $CI->invoices->get_invoices_total($_data);
    $data['_currency']    = $data['total_result']['currencyid'];

    $CI->load->view('admin/legalservices/disputes_cases/invoices/invoices_total_template', $data);
}

function disputes_get_invoices_where_sql_for_staff($staff_id)
{
    $has_permission_view_own            = has_permission('invoices', '', 'view_own');
    $allow_staff_view_invoices_assigned = get_option('allow_staff_view_invoices_assigned');
    $whereUser                          = '';
    if ($has_permission_view_own) {
        $whereUser = '((' . db_prefix() . 'my_disputes_cases_invoices.addedfrom=' . $staff_id . ' AND ' . db_prefix() . 'my_disputes_cases_invoices.addedfrom IN (SELECT staff_id FROM ' . db_prefix() . 'staff_permissions WHERE feature = "invoices" AND capability="view_own"))';
        if ($allow_staff_view_invoices_assigned == 1) {
            $whereUser .= ' OR sale_agent=' . $staff_id;
        }
        $whereUser .= ')';
    } else {
        $whereUser .= 'sale_agent=' . $staff_id;
    }

    return $whereUser;
}

/**
 * Check if staff member can view invoice
 * @param  mixed $id invoice id
 * @param  mixed $staff_id
 * @return boolean
 */
function disputes_user_can_view_invoice($id, $staff_id = false)
{
    $CI = &get_instance();

    $staff_id = $staff_id ? $staff_id : get_staff_user_id();

    if (has_permission('invoices', $staff_id, 'view')) {
        return true;
    }

    $CI->db->select('id, addedfrom, sale_agent');
    $CI->db->from(db_prefix() . 'my_disputes_cases_invoices');
    $CI->db->where('id', $id);
    $invoice = $CI->db->get()->row();

    if ((has_permission('invoices', $staff_id, 'view_own') && $invoice->addedfrom == $staff_id)
        || ($invoice->sale_agent == $staff_id && get_option('allow_staff_view_invoices_assigned') == '1')) {
        return true;
    }

    return false;
}
function get_disputes_cases_opponents_by_case_id($case_id){
    $CI = &get_instance();
    $CI->db->where('case_id', $case_id);
    $CI->db->from(db_prefix() . 'my_disputes_cases_opponents');
    $opponents = $CI->db->get()->result();
    if($opponents > 0)
        return $opponents;
    else
        return false;
}

function get_disputes_cases_statuses(){
    $CI = &get_instance();
    $CI->load->model('legalservices/disputes_cases/disputes_cases_model','disputes_cases');
    $statuses = $CI->disputes_cases->get_all_statuses();
    if($statuses > 0){
        return $statuses;
    }
    return false;
}
function disputes_case_invoice_pdf($invoice, $tag = ''){
    return app_pdf('invoice', LIBSPATH . 'pdf/Disputes_invoice_pdf', $invoice, $tag);
}

function disputes_case_payment_pdf($payment, $tag = '')
{
    return app_pdf('payment', LIBSPATH . 'pdf/Disputes_case_payment_pdf', $payment, $tag);
}

function check_if_invoiced_disputes_case($disputes_case_id){
    $CI = &get_instance();
    $CI->db->where('project_id', $disputes_case_id);
    $CI->db->from(db_prefix() . 'my_disputes_cases_invoices');
    $result = $CI->db->get()->result();
    if($result)
        return true;
    else
        return false;
}

function check_if_invoiced_case($disputes_case_id){
    $CI = &get_instance();
    $CI->db->where('id', $disputes_case_id);
    $CI->db->select('is_invoiced');
    $CI->db->from(db_prefix() . 'my_disputes_cases');
    $row = $CI->db->get()->row();
    if($row->is_invoiced == 1)
        return true;
    else
        return false;
}

