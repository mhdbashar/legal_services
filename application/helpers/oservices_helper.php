<?php

defined('BASEPATH') or exit('No direct script access allowed');

hooks()->add_action('admin_init', 'app_init_oservice_tabs');
hooks()->add_action('app_admin_assets', '_maybe_init_admin_oservice_assets', 5);

function _maybe_init_admin_oservice_assets()
{
    $CI = &get_instance();

    if (strpos($_SERVER['REQUEST_URI'], get_admin_uri() . '/SOther/view') !== false
        || strpos($_SERVER['REQUEST_URI'], get_admin_uri() . '/SOther/gantt') !== false) {
        $CI = &get_instance();

        $CI->app_scripts->add('jquery-comments-js', 'assets/plugins/jquery-comments/js/jquery-comments.min.js', 'admin', ['vendor-js']);
        $CI->app_scripts->add('jquery-gantt-js', 'assets/plugins/gantt/js/jquery.fn.gantt.min.js', 'admin', ['vendor-js']);

        $CI->app_css->add('jquery-comments-css', 'assets/plugins/jquery-comments/css/jquery-comments.css', 'admin', ['reset-css']);
        $CI->app_css->add('jquery-gantt-css', 'assets/plugins/gantt/css/style.css', 'admin', ['reset-css']);
    }
}

/**
 * Default oservice tabs
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

    $CI->app_tabs->add_oservice_tab('project_overview', [
        'name'     => _l('project_overview'),
        'icon'     => 'fa fa-th',
        'view'     => 'admin/LegalServices/other_services/oservice_overview',
        'position' => 5,
    ]);

    $CI->app_tabs->add_oservice_tab('project_tasks', [
        'name'                      => _l('project_tasks'),
        'icon'                      => 'fa fa-check-circle',
        'view'                      => 'admin/LegalServices/other_services/oservice_tasks',
        'position'                  => 10,
        'linked_to_customer_option' => ['view_tasks'],
    ]);

    $CI->app_tabs->add_oservice_tab('project_timesheets', [
        'name'                      => _l('project_timesheets'),
        'icon'                      => 'fa fa-clock-o',
        'view'                      => 'admin/LegalServices/other_services/oservice_timesheets',
        'position'                  => 15,
        'linked_to_customer_option' => ['view_timesheets'],
    ]);

    $CI->app_tabs->add_oservice_tab('project_milestones', [
        'name'                      => _l('project_milestones'),
        'icon'                      => 'fa fa-rocket',
        'view'                      => 'admin/LegalServices/other_services/oservice_milestones',
        'position'                  => 20,
        'linked_to_customer_option' => ['view_milestones'],
    ]);

    $CI->app_tabs->add_oservice_tab('project_files', [
        'name'                      => _l('project_files'),
        'icon'                      => 'fa fa-files-o',
        'view'                      => 'admin/LegalServices/other_services/oservice_files',
        'position'                  => 25,
        'linked_to_customer_option' => ['upload_files'],
    ]);

    $CI->app_tabs->add_oservice_tab('project_discussions', [
        'name'                      => _l('project_discussions'),
        'icon'                      => 'fa fa-commenting',
        'view'                      => 'admin/LegalServices/other_services/oservice_discussions',
        'position'                  => 30,
        'linked_to_customer_option' => ['open_discussions'],
    ]);

    $CI->app_tabs->add_oservice_tab('project_gantt', [
        'name'                      => _l('project_gantt'),
        'icon'                      => 'fa fa-align-left',
        'view'                      => 'admin/LegalServices/other_services/oservice_gantt',
        'position'                  => 35,
        'linked_to_customer_option' => ['view_gantt'],
    ]);

    $CI->app_tabs->add_oservice_tab('project_tickets', [
        'name'     => _l('project_tickets'),
        'icon'     => 'fa fa-life-ring',
        'view'     => 'admin/LegalServices/other_services/oservice_tickets',
        'position' => 40,
        'visible'  => (get_option('access_tickets_to_none_staff_members') == 1 && !is_staff_member()) || is_staff_member(),
    ]);

    $CI->app_tabs->add_oservice_tab('sales', [
        'name'     => _l('sales_string'),
        'position' => 45,
        'collapse' => true,
        'visible'  => (has_permission('estimates', '', 'view') || has_permission('estimates', '', 'view_own') || (get_option('allow_staff_view_estimates_assigned') == 1 && staff_has_assigned_estimates()))
            || (has_permission('invoices', '', 'view') || has_permission('invoices', '', 'view_own') || (get_option('allow_staff_view_invoices_assigned') == 1 && staff_has_assigned_invoices()))
            || (has_permission('expenses', '', 'view') || has_permission('expenses', '', 'view_own')),
    ]);

    $CI->app_tabs->add_oservice_tab_children_item('sales', [
        'slug'     => 'project_invoices',
        'name'     => _l('project_invoices'),
        'view'     => 'admin/LegalServices/other_services/oservice_invoices',
        'position' => 5,
        'visible'  => (has_permission('invoices', '', 'view') || has_permission('invoices', '', 'view_own') || (get_option('allow_staff_view_invoices_assigned') == 1 && staff_has_assigned_invoices())),
    ]);

    $CI->app_tabs->add_oservice_tab_children_item('sales', [
        'slug'     => 'project_estimates',
        'name'     => _l('estimates'),
        'view'     => 'admin/LegalServices/other_services/oservice_estimates',
        'position' => 10,
        'visible'  => (has_permission('estimates', '', 'view') || has_permission('estimates', '', 'view_own') || (get_option('allow_staff_view_estimates_assigned') == 1 && staff_has_assigned_estimates())),
    ]);

    $CI->app_tabs->add_oservice_tab_children_item('sales', [
        'slug'     => 'project_expenses',
        'name'     => _l('project_expenses'),
        'view'     => 'admin/LegalServices/other_services/oservice_expenses',
        'position' => 15,
        'visible'   => has_permission('expenses', '', 'view') || has_permission('expenses', '', 'view_own'),
    ]);

    $CI->app_tabs->add_oservice_tab_children_item('sales', [
        'slug'     => 'project_credit_notes',
        'name'     => _l('credit_notes'),
        'view'     => 'admin/LegalServices/other_services/oservice_credit_notes',
        'position' => 20,
        'visible'  => has_permission('credit_notes', '', 'view') || has_permission('credit_notes', '', 'view_own'),
    ]);

    $CI->app_tabs->add_oservice_tab_children_item('sales', [
        'slug'     => 'project_subscriptions',
        'name'     => _l('subscriptions'),
        'view'     => 'admin/LegalServices/other_services/oservice_subscriptions',
        'position' => 25,
        'visible'  => has_permission('subscriptions', '', 'view') || has_permission('subscriptions', '', 'view_own'),
    ]);

    $CI->app_tabs->add_oservice_tab('project_notes', [
        'name'     => _l('project_notes'),
        'icon'     => 'fa fa-file-o',
        'view'     => 'admin/LegalServices/other_services/oservice_notes',
        'position' => 50,
    ]);

    $CI->app_tabs->add_oservice_tab('project_activity', [
        'name'                      => _l('project_activity'),
        'icon'                      => 'fa fa-exclamation',
        'view'                      => 'admin/LegalServices/other_services/oservice_activity',
        'position'                  => 55,
        'linked_to_customer_option' => ['view_activity_log'],
    ]);
}

/**
 * Filter only visible tabs selected from project settings
 * @param  array $tabs available tabs
 * @param  array $applied_settings current applied project visible tabs
 * @return array
 */
function filter_oservice_visible_tabs($tabs, $applied_settings)
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

    return hooks()->apply_filters('oservice_filtered_visible_tabs', $newTabs);
}
/**
 * Get project by ID or current queried project
 * @param  mixed $id project id
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

    if (!class_exists('Other_services_model', false)) {
        get_instance()->load->model('LegalServices/Other_services_model','oservice');
    }

    $oservice = get_instance()->oservice->get($id);

    return $oservice;
}
function get_client_id_by_oservice_id($id)
{
    $CI = & get_instance();
    $CI->db->select('clientid');
    $CI->db->where('id', $id);
    $oservice = $CI->db->get(db_prefix() . 'my_other_services')->row();
    if ($oservice) {
        return $oservice->clientid;
    }

    return false;
}
/**
 * Init the default project tabs
 * @return null
 */


/**
 * Filter only visible tabs selected from project settings
 * @param  array $tabs available tabs
 * @param  array $applied_settings current applied project visible tabs
 * @return array
 */
/**
 * Get project billing type
 * @param  mixed $project_id
 * @return mixed
 */
function get_oservice_billing_type($oservice_id)
{
    $CI = & get_instance();
    $CI->db->select('billing_type');
    $CI->db->where('id', $oservice_id);
    $oservice = $CI->db->get(db_prefix() . 'my_other_services')->row();
    if ($oservice) {
        return $oservice->billing_type;
    }

    return false;
}
/**
 * Get project status by passed oservice id
 * @param  mixed $id oservice id
 * @return array
 */
function get_oservice_status_by_id($id)
{
    $CI = &get_instance();
    if (!class_exists('LegalServices/Other_services_model')) {
        $CI->load->model('LegalServices/Other_services_model','oservice');
    }

    $statuses = $CI->oservice->get_oservice_statuses();

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
function get_oservice_deadline($oservice_id)
{
    $CI = & get_instance();
    $CI->db->select('deadline');
    $CI->db->where('id', $oservice_id);
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
 * Get oservice name by passed id
 * @param  mixed $id
 * @return string
 */
function get_oservice_name_by_id($id)
{
    $CI      = & get_instance();
    $oservice = $CI->app_object_cache->get('oservice-name-data-' . $id);

    if (!$oservice) {
        $CI->db->select('name');
        $CI->db->where('id', $id);
        $oservice = $CI->db->get(db_prefix() . 'my_other_services')->row();
        $CI->app_object_cache->add('oservice-name-data-' . $id, $oservice);
    }

    if ($oservice) {
        return $oservice->name;
    }

    return '';
}
/**
 * Check if project has recurring tasks
 * @param  mixed $id project id
 * @return boolean
 */
function oservice_has_recurring_tasks($id,$slug)
{
    return total_rows(db_prefix() . 'tasks', 'recurring=1 AND rel_id="' . $id . '" AND rel_type="' . $slug . '"') > 0;
}

function total_oservice_tasks_by_milestone($milestone_id, $oservice_id,$slug)
{
    return total_rows(db_prefix() . 'tasks', [
        'rel_type'  => $slug,
        'rel_id'    => $oservice_id,
        'milestone' => $milestone_id,
    ]);
}

function total_oservice_finished_tasks_by_milestone($milestone_id, $oservice_id,$slug)
{
    return total_rows(db_prefix() . 'tasks', [
        'rel_type'  =>$slug,
        'rel_id'    => $oservice_id,
        'status'    => 5,
        'milestone' => $milestone_id,
    ]);
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

        $oservices[$key]['progress'] = $CI->other->calc_progress($slug,$ServID,$oservice['id']);
        $oservices[$key]['slug'] = $slug;
        $oservices[$key]['service_id'] = $ServID;
    }

    return $oservices;
}