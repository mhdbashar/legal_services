<?php

defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: disputes
Description: Default module for managing Financial disputes
Version: 1.0.0
Requires at least: 2.3.*
*/

define('DISPUTES_MODULE_NAME', 'disputes');
define('DISPUTES_MODULE_PATH', __DIR__ );

register_activation_hook('disputes', 'disputes_module_activation_hook');
hooks()->add_action('admin_init', 'disputes_module_init_menu_items');
hooks()->add_action('admin_init', 'disputes_init_library');
hooks()->add_action('admin_init', 'disputes_init_invoice_tabs');
hooks()->add_action('after_render_single_setup_menu','my_custom_menu_items');

hooks()->add_action('after_cron_settings_last_tab', 'add_disputes_reminder_tab');
hooks()->add_action('after_cron_settings_last_tab_content', 'add_disputes_reminder_tab_content');
hooks()->add_action('after_cron_run', 'disputes_invoice_overdue');

add_option('automatically_resend_disputes_invoice_overdue_reminder_after', -3, true);
add_option('automatically_send_disputes_invoice_overdue_reminder_after', 1, true);


function add_disputes_reminder_tab(){
    echo '<li role="presentation">
        <a href="#disputes_reminder" aria-controls="disputes_reminder" role="tab" data-toggle="tab">'. _l('disputes_reminder') .'</a>
    </li>';
}

function add_disputes_reminder_tab_content(){
    echo '<div role="tablpanel" class="tab-pane" id="disputes_reminder">' .
    render_input('settings[automatically_send_disputes_invoice_overdue_reminder_after]','automatically_send_disputes_invoice_overdue_reminder_after',get_option('automatically_send_disputes_invoice_overdue_reminder_after'),'number') .
    render_input('settings[automatically_resend_disputes_invoice_overdue_reminder_after]','automatically_resend_disputes_invoice_overdue_reminder_after',get_option('automatically_resend_disputes_invoice_overdue_reminder_after'),'number') . '
    </div>';
}

function my_custom_menu_items($item){
    //print_r($item);
    if($item['slug']==2) echo '<li><a href="'.admin_url('disputes/statuses').'">إدارة حالات النزاع المالي</a></li>';
}




function disputes_invoice_overdue()
{
        $invoice_auto_operations_hour = get_option('invoice_auto_operations_hour');
        if ($invoice_auto_operations_hour == '') {
            $invoice_auto_operations_hour = 9;
        }

        $invoice_auto_operations_hour = intval($invoice_auto_operations_hour);
        $hour_now                     = date('G');
        if ($hour_now != $invoice_auto_operations_hour && $this->manually === false) {
            return;
        }

        $this->load->model('invoices_model');
        $this->db->select('id,date,status,last_overdue_reminder,duedate,cancel_overdue_reminders');
        $this->db->from(db_prefix() . 'my_project_invoices');
        $this->db->where('(duedate != "" AND duedate IS NOT NULL)'); // We dont need invoices with no duedate
        $this->db->where('status !=', 2); // We dont need paid status
        $this->db->where('status !=', 5); // We dont need cancelled status
        $this->db->where('status !=', 6); // We dont need draft status
        $invoices = $this->db->get()->result_array();

        $now = time();
        foreach ($invoices as $invoice) {
            $statusid = disputes_update_invoice_status($invoice['id']);

            if ($invoice['cancel_overdue_reminders'] == 0 && disputes_is_invoices_overdue_reminders_enabled()) {
                if ($invoice['status'] == Invoices_model::STATUS_OVERDUE
                    || $statusid == Invoices_model::STATUS_OVERDUE
                    || $invoice['status'] == Invoices_model::STATUS_PARTIALLY) {
                    if ($invoice['status'] == Invoices_model::STATUS_PARTIALLY) {
                        // Invoice is with status partialy paid and its not due
                        if (date('Y-m-d') <= date('Y-m-d', strtotime($invoice['duedate']))) {
                            continue;
                        }
                    }
                    // Check if already sent invoice reminder
                    if ($invoice['last_overdue_reminder']) {
                        // We already have sent reminder, check for resending
                        $resend_days = get_option('automatically_resend_disputes_invoice_overdue_reminder_after');
                        // If resend_days from options is 0 means that the admin dont want to resend the mails.
                        if ($resend_days != 0) {
                            $datediff  = $now - strtotime($invoice['last_overdue_reminder']);
                            $days_diff = floor($datediff / (60 * 60 * 24));
                            if ($days_diff >= $resend_days) {
                                $this->invoices_model->send_invoice_overdue_notice($invoice['id']);
                            }
                        }
                    } else {
                        $datediff  = $now - strtotime($invoice['duedate']);
                        $days_diff = floor($datediff / (60 * 60 * 24));
                        if ($days_diff >= get_option('automatically_send_disputes_invoice_overdue_reminder_after')) {
                            $this->invoices_model->send_invoice_overdue_notice($invoice['id']);
                        }
                    }
                }
            }
        }
}





function disputes_init_invoice_tabs()
{
    $CI = &get_instance();

    $CI->app_tabs->add_project_tab_children_item('sales', [
        'slug'     => 'disputes_invoices',
        'name'     => _l('disputes_invoices'),
        'view'     => 'disputes/disputes_invoices',
        'visible'  => true
    ]);
    
    //$CI->app_tabs->add_project_tab('disputes_invoices', [
    //    'name'                      => _l('disputes_invoices'),
    //    'icon'                      => 'fa fa-map-marker',
    //    'view'                      => 'disputes/disputes_invoices',
    //    'position'                  => 65,
    //]);
}

/**
 * Init disputes module menu items in setup in admin_init hook
 * @return null
 */
function disputes_module_init_menu_items()
{
    $CI = &get_instance();

    $CI->app->add_quick_actions_link([
            'name'       => _l('disputes'),
            'url'        => 'disputes/disputes',
            'permission' => 'disputes',
            'position'   => 56,
            ]);


    if (has_permission('disputes', '', 'view')) {
        $CI->app_menu->add_sidebar_children_item('custom-menu-unique-id', [
                'slug'     => 'disputes',
                'name'     => _l('نزاعات مالية'),
                'href'     => admin_url('disputes'),
                'position' => 24,
        ]);
        /*$CI->app_menu->add_sidebar_children_item('custom-menu-unique-id', [
                'slug'     => 'disputes',
                'name'     => _l('إدارة حالات النزاع'),
                'href'     => admin_url('disputes/statuses'),
                'position' => 24,
        ]);*/
    }
}

function disputes_module_activation_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/install.php');
}

function disputes_init_library(){
    $CI = & get_instance();
    $CI->load->library(DISPUTES_MODULE_NAME . '/' . 'disputesApp');
    $CI->load->helper(DISPUTES_MODULE_NAME . '/' . 'disputes_invoices');
}

/**
* Register language files, must be registered if the module is using languages
*/
register_language_files(DISPUTES_MODULE_NAME, [DISPUTES_MODULE_NAME]);
