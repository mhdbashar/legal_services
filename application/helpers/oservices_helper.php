<?php defined('BASEPATH') or exit('No direct script access allowed');

hooks()->add_action('admin_init', 'app_init_oservice_tabs');
hooks()->add_action('app_admin_assets', '_maybe_init_admin_oservice_assets', 5);

function _maybe_init_admin_oservice_assets()
{
    $CI = &get_instance();
    if (strpos($_SERVER['REQUEST_URI'], get_admin_uri() . '/SOther/view') !== false
        || strpos($_SERVER['REQUEST_URI'], get_admin_uri() . '/LegalServices/Other_services_controller/gantt') !== false) {
        $CI = &get_instance();

        $CI->app_scripts->add('jquery-comments-js', 'assets/plugins/jquery-comments/js/jquery-comments.min.js', 'admin', ['vendor-js']);
        $CI->app_scripts->add('jquery-gantt-js', 'assets/plugins/gantt/js/jquery.fn.gantt.min.js', 'admin', ['vendor-js']);

        $CI->app_css->add('jquery-comments-css', 'assets/plugins/jquery-comments/css/jquery-comments.css', 'admin', ['reset-css']);
        $CI->app_css->add('jquery-gantt-css', 'assets/plugins/gantt/css/style.css', 'admin', ['reset-css']);
    }
}

/**
 * Default project tabs
 * @return array
 */

function get_oservice_tabs_admin()
{
    return get_instance()->app_tabs->get_oservice_tabs();
}

/**
 * Init the default project tabs
 * @return null
 */
function app_init_oservice_tabs()
{
    $CI = &get_instance();

    $CI->db->select('service_session_link');
    $data = $CI->db->get(db_prefix() . 'my_other_services')->result();
    foreach ($data as $item):
        $service_session_link = $item->service_session_link;
    endforeach;


    $CI->app_tabs->add_oservice_tab('project_overview', [
        'name' => _l('project_overview'),
        'icon' => 'fa fa-th',
        'view' => 'admin/LegalServices/other_services/project_overview',
        'position' => 5,
    ]);

    $CI->app_tabs->add_oservice_tab('project_tasks', [
        'name' => _l('tasks'),
        'icon' => 'fa fa-check-circle',
        'view' => 'admin/LegalServices/other_services/project_tasks',
        'position' => 10,
        'linked_to_customer_option' => ['view_tasks'],
    ]);

    $CI->app_tabs->add_oservice_tab('project_timesheets', [
        'name' => _l('project_timesheets'),
        'icon' => 'fa fa-clock-o',
        'view' => 'admin/LegalServices/other_services/project_timesheets',
        'position' => 15,
        'linked_to_customer_option' => ['view_timesheets'],
    ]);

    $CI->app_tabs->add_oservice_tab('project_milestones', [
        'name' => _l('project_milestones'),
        'icon' => 'fa fa-rocket',
        'view' => 'admin/LegalServices/other_services/project_milestones',
        'position' => 20,
        'linked_to_customer_option' => ['view_milestones'],
    ]);

    $CI->app_tabs->add_oservice_tab('project_files', [
        'name' => _l('project_files'),
        'icon' => 'fa fa-files-o',
        'view' => 'admin/LegalServices/other_services/project_files',
        'position' => 25,
        'linked_to_customer_option' => ['upload_files'],
    ]);

    $CI->app_tabs->add_oservice_tab('project_discussions', [
        'name' => _l('project_discussions'),
        'icon' => 'fa fa-commenting',
        'view' => 'admin/LegalServices/other_services/project_discussions',
        'position' => 30,
        'linked_to_customer_option' => ['open_discussions'],
    ]);

    $CI->app_tabs->add_oservice_tab('project_gantt', [
        'name' => _l('project_gant'),
        'icon' => 'fa fa-align-left',
        'view' => 'admin/LegalServices/other_services/project_gantt',
        'position' => 35,
        'linked_to_customer_option' => ['view_gantt'],
    ]);

    $CI->app_tabs->add_oservice_tab('project_tickets', [
        'name' => _l('project_tickets'),
        'icon' => 'fa fa-life-ring',
        'view' => 'admin/LegalServices/other_services/project_tickets',
        'position' => 40,
        'visible' => (get_option('access_tickets_to_none_staff_members') == 1 && !is_staff_member()) || is_staff_member(),
    ]);

    $CI->app_tabs->add_oservice_tab('sales', [
        'name' => _l('sales_string'),
        'position' => 45,
        'collapse' => true,
        'visible' => (has_permission('estimates', '', 'view') || has_permission('estimates', '', 'view_own') || (get_option('allow_staff_view_estimates_assigned') == 1 && staff_has_assigned_estimates()))
            || (has_permission('invoices', '', 'view') || has_permission('invoices', '', 'view_own') || (get_option('allow_staff_view_invoices_assigned') == 1 && staff_has_assigned_invoices()))
            || (has_permission('expenses', '', 'view') || has_permission('expenses', '', 'view_own')),
    ]);

    $CI->app_tabs->add_oservice_tab_children_item('sales', [
        'slug' => 'project_invoices',
        'name' => _l('project_invoices'),
        'view' => 'admin/LegalServices/other_services/project_invoices',
        'position' => 5,
        'visible' => (has_permission('invoices', '', 'view') || has_permission('invoices', '', 'view_own') || (get_option('allow_staff_view_invoices_assigned') == 1 && staff_has_assigned_invoices())),
    ]);

    $CI->app_tabs->add_oservice_tab_children_item('sales', [
        'slug' => 'project_estimates',
        'name' => _l('estimates'),
        'view' => 'admin/LegalServices/other_services/project_estimates',
        'position' => 10,
        'visible' => (has_permission('estimates', '', 'view') || has_permission('estimates', '', 'view_own') || (get_option('allow_staff_view_estimates_assigned') == 1 && staff_has_assigned_estimates())),
    ]);

    $CI->app_tabs->add_oservice_tab_children_item('sales', [
        'slug' => 'project_expenses',
        'name' => _l('project_expenses'),
        'view' => 'admin/LegalServices/other_services/project_expenses',
        'position' => 15,
        'visible' => has_permission('expenses', '', 'view') || has_permission('expenses', '', 'view_own'),
    ]);

    $CI->app_tabs->add_oservice_tab_children_item('sales', [
        'slug' => 'project_credit_notes',
        'name' => _l('credit_notes'),
        'view' => 'admin/LegalServices/other_services/project_credit_notes',
        'position' => 20,
        'visible' => has_permission('credit_notes', '', 'view') || has_permission('credit_notes', '', 'view_own'),
    ]);

    // $CI->app_tabs->add_oservice_tab_children_item('sales', [
    //     'slug' => 'project_subscriptions',
    //     'name' => _l('subscriptions'),
    //     'view' => 'admin/LegalServices/other_services/project_subscriptions',
    //     'position' => 25,
    //     'visible' => has_permission('subscriptions', '', 'view') || has_permission('subscriptions', '', 'view_own'),
    // ]);

    $CI->app_tabs->add_oservice_tab('project_notes', [
        'name' => _l('project_notes'),
        'icon' => 'fa fa-file-o',
        'view' => 'admin/LegalServices/other_services/project_notes',
        'position' => 50,
    ]);

    $CI->app_tabs->add_oservice_tab('project_activity', [
        'name' => _l('project_activity'),
        'icon' => 'fa fa-exclamation',
        'view' => 'admin/LegalServices/other_services/project_activity',
        'position' => 55,
        'linked_to_customer_option' => ['view_activity_log'],
    ]);

    if(isset($service_session_link)):
        if($service_session_link == 1):
            $CI->app_tabs->add_oservice_tab('OserviceSession', [
                'name'     => _l('SessionLog'),
                'icon'     => 'fa fa-gavel',
                'view'     => 'admin/LegalServices/services_sessions/services_sessions',
                'position' => 60,
            ]);
        endif;
    endif;

    $CI->app_tabs->add_oservice_tab('Phase', [
        'name'                      => _l('phases'),
        'icon'                      => 'fa fa-list-ol',
        'view'                      => 'admin/LegalServices/phases/tab',
        'position'                  => 65,
    ]);

    $CI->app_tabs->add_oservice_tab('Procedures', [
        'name'                      => _l('legal_procedures'),
        'icon'                      => 'fa fa-braille',
        'view'                      => 'admin/LegalServices/legal_procedures/tab',
        'position'                  => 70,
    ]);

    $CI->app_tabs->add_oservice_tab('help_library', [
        'name'                      => _l('help_library'),
        'icon'                      => 'fa fa-book',
        'view'                      => 'admin/help_library/tab',
        'position'                  => 75,
    ]);
}

/**
 * Filter only visible tabs selected from project settings
 * @param array $tabs available tabs
 * @param array $applied_settings current applied project visible tabs
 * @return array
 */
function filter_oservice_visible_tabs($tabs, $applied_settings)
{
    $newTabs = [];
    foreach ($tabs as $key => $tab) {
        $dropdown = isset($tab['collapse']) ? true : false;

        if ($dropdown) {
            $totalChildTabsHidden = 0;
            $newChild = [];

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

    return hooks()->apply_filters('oservice_filtered_visible_tabs', $newTabs);
}

/**
 * Get project by ID or current queried project
 * @param mixed $id project id
 * @return mixed
 */
function get_oservice($id = null)
{
    if (empty($id) && isset($GLOBALS['oservice'])) {
        return $GLOBALS['oservice'];
    }

    // Client global object not set
    if (empty($id)) {
        return null;
    }

    if (!class_exists('LegalServices/Other_services_model', false)) {
        get_instance()->load->model('LegalServices/Other_services_model', 'other');
    }

    $project = get_instance()->other->get($id);

    return $project;
}

/**
 * Get project status by passed project id
 * @param mixed $id project id
 * @return array
 */
function get_oservice_status_by_id($id)
{
    $CI = &get_instance();
    if (!class_exists('LegalServices/Other_services_model')) {
        $CI->load->model('LegalServices/Other_services_model', 'other');
    }

    $statuses = $CI->other->get_project_statuses();

    $status = [
        'id' => 0,
        'color' => '#333',
        'name' => '[Status Not Found]',
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

/**
 * Return logged in user pinned projects
 * @return array
 */
function get_user_pinned_oservices()
{
    $CI = &get_instance();
    $CI->db->select(db_prefix() . 'my_other_services.id, ' . db_prefix() . 'my_other_services.name, ' . db_prefix() . 'my_other_services.clientid, ' . get_sql_select_client_company());
    $CI->db->join(db_prefix() . 'my_other_services', db_prefix() . 'my_other_services.id=' . db_prefix() . 'pinned_oservices.oservice_id');
    $CI->db->join(db_prefix() . 'clients', db_prefix() . 'clients.userid=' . db_prefix() . 'my_other_services.clientid');
    $CI->db->where(db_prefix() . 'pinned_oservices.staff_id', get_staff_user_id());
    $oservices = $CI->db->get(db_prefix() . 'pinned_oservices')->result_array();

    $CI->load->model('LegalServices/Other_services_model',"other");

    foreach ($oservices as $key => $oservice) {
        $ServID = $CI->db->get_where('my_other_services', array('id' => $oservice['id']))->row()->service_id;

        $slug=$CI->db->get_where('my_basic_services', array('id' => $ServID))->row()->slug;

        $oservices[$key]['progress'] = $CI->other->calc_progress($slug,$oservice['id']);
        $oservices[$key]['slug'] = $slug;
        $oservices[$key]['service_id'] = $ServID;
    }

    return $oservices;
}

/**
 * Get project name by passed id
 * @param mixed $id
 * @return string
 */
function get_oservice_name_by_id($id)
{
    $CI = &get_instance();
    $project = $CI->app_object_cache->get('oservice-name-data-' . $id);

    if (!$project) {
        $CI->db->select('name');
        $CI->db->where('id', $id);
        $project = $CI->db->get(db_prefix() . 'my_other_services')->row();
        $CI->app_object_cache->add('oservice-name-data-' . $id, $project);
    }

    if ($project) {
        return $project->name;
    }

    return '';
}

/**
 * Return project milestones
 * @param mixed $project_id project id
 * @return array
 */
function get_oservice_milestones($project_id)
{
    $CI = &get_instance();
    $CI->db->where('project_id', $project_id);
    $CI->db->order_by('milestone_order', 'ASC');

    return $CI->db->get(db_prefix() . 'milestones')->result_array();
}

/**
 * Get project client id by passed project id
 * @param mixed $id project id
 * @return mixed
 */
function get_client_id_by_oservice_id($id)
{
    $CI = &get_instance();
    $CI->db->select('clientid');
    $CI->db->where('id', $id);
    $project = $CI->db->get(db_prefix() . 'my_other_services')->row();
    if ($project) {
        return $project->clientid;
    }

    return false;
}

/**
 * Check if customer has project assigned
 * @param mixed $customer_id customer id to check
 * @return boolean
 */
function customer_has_oservices($customer_id)
{
    $totalCustomerProjects = total_rows(db_prefix() . 'my_other_services', 'clientid=' . $customer_id);

    return ($totalCustomerProjects > 0 ? true : false);
}

/**
 * Get project billing type
 * @param mixed $project_id
 * @return mixed
 */
function get_oservice_billing_type($project_id)
{
    $CI = &get_instance();
    $CI->db->select('billing_type');
    $CI->db->where('id', $project_id);
    $project = $CI->db->get(db_prefix() . 'my_other_services')->row();
    if ($project) {
        return $project->billing_type;
    }

    return false;
}

/**
 * Get project deadline
 * @param mixed $project_id
 * @return mixed
 */
function get_oservice_deadline($project_id)
{
    $CI = &get_instance();
    $CI->db->select('deadline');
    $CI->db->where('id', $project_id);
    $project = $CI->db->get(db_prefix() . 'my_other_services')->row();
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
function get_oservice_discussions_language_array()
{
    $lang = [
        'discussion_add_comment' => _l('discussion_add_comment'),
        'discussion_newest' => _l('discussion_newest'),
        'discussion_oldest' => _l('discussion_oldest'),
        'discussion_attachments' => _l('discussion_attachments'),
        'discussion_send' => _l('discussion_send'),
        'discussion_reply' => _l('discussion_reply'),
        'discussion_edit' => _l('discussion_edit'),
        'discussion_edited' => _l('discussion_edited'),
        'discussion_you' => _l('discussion_you'),
        'discussion_save' => _l('discussion_save'),
        'discussion_delete' => _l('discussion_delete'),
        'discussion_view_all_replies' => _l('discussion_view_all_replies'),
        'discussion_hide_replies' => _l('discussion_hide_replies'),
        'discussion_no_comments' => _l('discussion_no_comments'),
        'discussion_no_attachments' => _l('discussion_no_attachments'),
        'discussion_attachments_drop' => _l('discussion_attachments_drop'),
    ];

    return $lang;
}

/**
 * Check if project has recurring tasks
 * @param mixed $id project id
 * @return boolean
 */
function oservice_has_recurring_tasks($id)
{
    return total_rows(db_prefix() . 'tasks', 'recurring=1 AND rel_id="' . $id . '" AND rel_type="project"') > 0;
}

function total_oservice_tasks_by_milestone($milestone_id, $project_id, $slug='')
{
    return total_rows(db_prefix() . 'tasks', [
        'rel_type' => $slug,
        'rel_id' => $project_id,
        'milestone' => $milestone_id,
    ]);
}

function total_oservice_finished_tasks_by_milestone($milestone_id, $project_id, $slug='')
{
    return total_rows(db_prefix() . 'tasks', [
        'rel_type' => $slug,
        'rel_id' => $project_id,
        'status' => 5,
        'milestone' => $milestone_id,
    ]);
}

function get_oservices_countries($field)
{
    $CI = &get_instance();
    if ($field == 'short_name') {
        $field = 'short_name_ar';
    }
    return $CI->db->get_where(db_prefix() . 'countries', array($field . '!=' => ''))->result_array();
}

function oservice_file_url($file, $preview = false)
{
    $path = 'uploads/oservices/' . $file['oservice_id'] . '/';
    $fullPath = FCPATH . $path . $file['file_name'];
    $url = base_url($path . $file['file_name']);

    if (!empty($file['external']) && !empty($file['thumbnail_link'])) {
        $url = $file['thumbnail_link'];
    } else {
        if ($preview) {
            $fname = pathinfo($fullPath, PATHINFO_FILENAME);
            $fext = pathinfo($fullPath, PATHINFO_EXTENSION);
            $thumbPath = pathinfo($fullPath, PATHINFO_DIRNAME) . '/' . $fname . '_thumb.' . $fext;
            if (file_exists($thumbPath)) {
                $url = base_url('uploads/oservices/' . $file['oservice_id'] . '/' . $fname . '_thumb.' . $fext);
            }
        }
    }

    return $url;
}

function get_tags_oservice($id)
{
    return _call_tags_method('GetTagsOservices', $id);
}

function init_relation_tasks_oservice_table($table_attributes = [])
{
    $slug = $table_attributes['data-new-rel-slug'];
    $table_data = [
        _l('the_number_sign'),
        [
            'name' => _l('tasks_dt_name'),
            'th_attrs' => [
                'style' => 'min-width:200px',
            ],
        ],
        _l('task_status'),
        [
            'name' => _l('tasks_dt_datestart'),
            'th_attrs' => [
                'style' => 'min-width:75px',
            ],
        ],
        [
            'name' => _l('task_duedate'),
            'th_attrs' => [
                'style' => 'min-width:75px',
                'class' => 'duedate',
            ],
        ],
        [
            'name' => _l('task_assigned'),
            'th_attrs' => [
                'style' => 'min-width:75px',
            ],
        ],
        _l('tags'),
        _l('tasks_list_priority'),
    ];

    array_unshift($table_data, [
        'name' => '<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="rel-tasks_oservice"><label></label></div>',
        'th_attrs' => ['class' => ($table_attributes['data-new-rel-type'] !== "$slug" ? 'not_visible' : '')],
    ]);

    $custom_fields = get_custom_fields('tasks', [
        'show_on_table' => 1,
    ]);

    foreach ($custom_fields as $field) {
        array_push($table_data, $field['name']);
    }


    $table_data = hooks()->apply_filters('tasks_related_table_columns', $table_data);

    $name = 'rel-tasks_oservice';
    if ($table_attributes['data-new-rel-type'] == 'lead') {
        $name = 'rel-tasks-leads';
    }

    $table = '';
    $CI = &get_instance();
    $table_name = '.table-' . $name;
    $CI->load->view('admin/tasks/tasks_filter_by', [
        'view_table_name' => $table_name,
    ]);
    if (has_permission('tasks', '', 'create')) {
        $disabled = '';
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
        if ($table_attributes['data-new-rel-type'] != "$slug") {
            echo "<a href='#' class='btn btn-info pull-left mbot25 mright5 new-task-relation" . $disabled . "' onclick=\"new_task_from_relation('$table_name'); return false;\" data-rel-id='" . $table_attributes['data-new-rel-id'] . "' data-rel-type='" . $table_attributes['data-new-rel-type'] . "'>" . _l('new_task') . '</a>';
        }
    }

    if ($table_attributes['data-new-rel-type'] == "$slug") {
        echo "<a href='" . admin_url('tasks/detailed_overview?project_id=' . $table_attributes['data-new-rel-id']) . "' class='btn btn-success pull-right mbot25'>" . _l('detailed_overview') . '</a>';
        echo "<a href='" . admin_url('tasks/list_tasks_for_LegalServices?rel_type='.$slug.'&project_id=' . $table_attributes['data-new-rel-id'] . '&kanban=true') . "' class='btn btn-default pull-right mbot25 mright5 hidden-xs'>" . _l('view_kanban') . '</a>';
        echo '<div class="clearfix"></div>';
        echo $CI->load->view('admin/tasks/_bulk_actions', ['table' => '.table-rel-tasks_oservice'], true);
        echo $CI->load->view('admin/tasks/_summary', ['rel_id' => $table_attributes['data-new-rel-id'], 'rel_type' => "$slug", 'table' => $table_name], true);
        echo '<a href="#" data-toggle="modal" data-target="#tasks_bulk_actions" class="hide bulk-actions-btn table-btn" data-table=".table-rel-tasks_oservice">' . _l('bulk_actions') . '</a>';
    } elseif ($table_attributes['data-new-rel-type'] == 'customer') {
        echo '<div class="clearfix"></div>';
        echo '<div id="tasks_related_filter">';
        echo '<p class="bold">' . _l('task_related_to') . ': </p>';

        echo '<div class="checkbox checkbox-inline mbot25">
        <input type="checkbox" checked value="customer" disabled id="ts_rel_to_customer" name="tasks_related_to[]">
        <label for="ts_rel_to_customer">' . _l('client') . '</label>
        </div>

        <div class="checkbox checkbox-inline mbot25">
        <input type="checkbox" value="project" id="ts_rel_to_project" name="tasks_related_to[]">
        <label for="ts_rel_to_project">' . _l('projects') . '</label>
        </div>

        <div class="checkbox checkbox-inline mbot25">
        <input type="checkbox" value="invoice" id="ts_rel_to_invoice" name="tasks_related_to[]">
        <label for="ts_rel_to_invoice">' . _l('invoices') . '</label>
        </div>

        <div class="checkbox checkbox-inline mbot25">
        <input type="checkbox" value="estimate" id="ts_rel_to_estimate" name="tasks_related_to[]">
        <label for="ts_rel_to_estimate">' . _l('estimates') . '</label>
        </div>

        <div class="checkbox checkbox-inline mbot25">
        <input type="checkbox" value="contract" id="ts_rel_to_contract" name="tasks_related_to[]">
        <label for="ts_rel_to_contract">' . _l('contracts') . '</label>
        </div>

        <div class="checkbox checkbox-inline mbot25">
        <input type="checkbox" value="ticket" id="ts_rel_to_ticket" name="tasks_related_to[]">
        <label for="ts_rel_to_ticket">' . _l('tickets') . '</label>
        </div>

        <div class="checkbox checkbox-inline mbot25">
        <input type="checkbox" value="expense" id="ts_rel_to_expense" name="tasks_related_to[]">
        <label for="ts_rel_to_expense">' . _l('expenses') . '</label>
        </div>

        <div class="checkbox checkbox-inline mbot25">
        <input type="checkbox" value="proposal" id="ts_rel_to_proposal" name="tasks_related_to[]">
        <label for="ts_rel_to_proposal">' . _l('proposals') . '</label>
        </div>';

        echo '</div>';
    } else {
        echo "<a href='" . admin_url('tasks/detailed_overview?project_id=' . $table_attributes['data-new-rel-id']) . "' class='btn btn-success pull-right mbot25'>" . _l('detailed_overview') . '</a>';
        echo "<a href='" . admin_url('tasks/list_tasks?project_id=' . $table_attributes['data-new-rel-id'] . '&kanban=true') . "' class='btn btn-default pull-right mbot25 mright5 hidden-xs'>" . _l('view_kanban') . '</a>';
        echo '<div class="clearfix"></div>';
        echo $CI->load->view('admin/tasks/_bulk_actions', ['table' => '.table-rel-tasks_oservice'], true);
        echo $CI->load->view('admin/tasks/_summary', ['rel_id' => $table_attributes['data-new-rel-id'], 'rel_type' => $table_attributes['data-new-rel-type'], 'table' => $table_name], true);
        echo '<a href="#" data-toggle="modal" data-target="#tasks_bulk_actions" class="hide bulk-actions-btn table-btn" data-table=".table-rel-tasks_oservice">' . _l('bulk_actions') . '</a>';
    }
    echo "<div class='clearfix'></div>";

    // If new column is added on tasks relations table this will not work fine
    // In this case we need to add new identifier eq task-relation
    $table_attributes['data-last-order-identifier'] = 'tasks_oservice';
    $table_attributes['data-default-order'] = get_table_last_order('tasks_oservice');

    $table .= render_datatable($table_data, $name, [], $table_attributes);

    return $table;
}

function AdminTicketsOserviceTableStructure($name = '', $bulk_action = false, $slug)
{
    $table = '<table class="table customizable-table dt-table-loading ' . ($name == '' ? 'tickets_oservice-table' : $name) . ' table-tickets_oservice" id="table-tickets_oservice" data-last-order-identifier="tickets_oservice" data-default-order="' . get_table_last_order('tickets_oservice') . '"  data-slug=' . $slug . '>';
    $table .= '<thead>';
    $table .= '<tr>';

    $table .= '<th class="' . ($bulk_action == true ? '' : 'not_visible') . '">';
    $table .= '<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="tickets_oservice"><label></label></div>';
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

    $table .= '<script id="hidden-columns-table-tickets_oservice" type="text/json">';
    $table .= get_staff_meta(get_staff_user_id(), 'hidden-columns-table-tickets_oservice');
    $table .= '</script>';

    return $table;
}

function handle_oservice_file_uploads($ServID, $project_id)
{
    $filesIDS = [];
    $errors = [];
    if (isset($_FILES['file']['name'])
        && ($_FILES['file']['name'] != '' || is_array($_FILES['file']['name']) && count($_FILES['file']['name']) > 0)) {
        hooks()->do_action('before_upload_project_attachment', $project_id);

        if (!is_array($_FILES['file']['name'])) {
            $_FILES['file']['name'] = [$_FILES['file']['name']];
            $_FILES['file']['type'] = [$_FILES['file']['type']];
            $_FILES['file']['tmp_name'] = [$_FILES['file']['tmp_name']];
            $_FILES['file']['error'] = [$_FILES['file']['error']];
            $_FILES['file']['size'] = [$_FILES['file']['size']];
        }

        $path = get_upload_path_by_type_oservice('oservice') . $project_id . '/';

        for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
            if (_perfex_upload_error($_FILES['file']['error'][$i])) {
                $errors[$_FILES['file']['name'][$i]] = _perfex_upload_error($_FILES['file']['error'][$i]);

                continue;
            }

            // Get the temp file path
            $tmpFilePath = $_FILES['file']['tmp_name'][$i];
            // Make sure we have a filepath
            if (!empty($tmpFilePath) && $tmpFilePath != '') {
                _maybe_create_upload_path($path);
                $filename = unique_filename($path, $_FILES['file']['name'][$i]);

                // In case client side validation is bypassed
                if (!_upload_extension_allowed($filename)) {
                    continue;
                }

                $newFilePath = $path . $filename;
                // Upload the file into the company uploads dir
                if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                    $CI = &get_instance();
                    if (is_client_logged_in()) {
                        $contact_id = get_contact_user_id();
                        $staffid = 0;
                    } else {
                        $staffid = get_staff_user_id();
                        $contact_id = 0;
                    }
                    $data = [
                        'oservice_id' => $project_id,
                        'file_name' => $filename,
                        'filetype' => $_FILES['file']['type'][$i],
                        'dateadded' => date('Y-m-d H:i:s'),
                        'staffid' => $staffid,
                        'contact_id' => $contact_id,
                        'subject' => $filename,
                    ];
                    if (is_client_logged_in()) {
                        $data['visible_to_customer'] = 1;
                    } else {
                        $data['visible_to_customer'] = ($CI->input->post('visible_to_customer') == 'true' ? 1 : 0);
                    }
                    $CI->db->insert(db_prefix() . 'oservice_files', $data);

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
        $CI->load->model('LegalServices/Other_services_model', 'other');
        end($filesIDS);
        $lastFileID = key($filesIDS);
        $CI->other->new_project_file_notification($ServID, $filesIDS[$lastFileID], $project_id);
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

function get_upload_path_by_type_oservice($type)
{
    $path = '';
    switch ($type) {
        case 'oservice':
            $path = OSERVICE_ATTACHMENTS_FOLDER;
            break;
    }

    return hooks()->apply_filters('get_upload_path_by_type', $path, $type);
}

function handle_oservice_discussion_comment_attachments($discussion_id, $post_data, $insert_data)
{
    if (isset($_FILES['file']['name']) && _perfex_upload_error($_FILES['file']['error'])) {
        header('HTTP/1.0 400 Bad error');
        echo json_encode(['message' => _perfex_upload_error($_FILES['file']['error'])]);
        die;
    }

    if (isset($_FILES['file']['name'])) {
        hooks()->do_action('before_upload_project_discussion_comment_attachment');
        $path = OSERVICE_DISCUSSION_ATTACHMENT_FOLDER . $discussion_id . '/';

        // Check for all cases if this extension is allowed
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
            $filename = unique_filename($path, $_FILES['file']['name']);
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
