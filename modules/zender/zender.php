<?php

/**
 * Ensures that the module init file can"t be accessed directly, only within the application.
 */
defined("BASEPATH") or exit("No direct script access allowed");

/*
Module Name: Zender SMS Module
Description: ادارة استلام الرسائل النصية القصيرة
Author: Babil Team
Author URI: https://www.babiltec.com
Version: 1.0
Requires at least: 2.3.5
*/

/**
 * Module libraries path
 * e.q. modules/module_name/libraries
 * @param string $module module name
 * @param string $concat append additional string to the path
 * @return string
 */
require(__DIR__ . "/vendor/autoload.php");

define("ZENDER_MODULE_NAME", "zender");
define('ZENDER_MODULE_PATH', __DIR__ );
define("SMS_TRIGGER_INVOICE_SEND_TO_CUSTOMER", "invoice_send_to_customer");

hooks()->add_filter("sms_gateways", "zender_sms_gateways");
hooks()->add_filter("sms_triggers", "zender_triggers");
hooks()->add_filter("sms_gateway_available_triggers", "zender_triggers");
hooks()->add_action("invoice_sent", "customerInvoice");

function zender_sms_gateways($gateways)
{
    $gateways[] = "zender/sms_zender";
    return $gateways;
}

function zender_triggers($triggers)
{
    
    $invoice_fields = [
        "{contact_firstname}",
        "{contact_lastname}",
        "{client_company}",
        "{client_vat_number}",
        "{client_id}",
        "{invoice_link}",
        "{invoice_number}",
        "{invoice_duedate}",
        "{invoice_date}",
        "{invoice_status}",
        "{invoice_subtotal}",
        "{invoice_total}",
    ];
    

    $triggers[SMS_TRIGGER_INVOICE_SEND_TO_CUSTOMER] = [
        "merge_fields" => $invoice_fields,
        "label" => "Send Invoice To Customer",
        "info" => "Trigger when invoice is created or sent to customer contacts.",
    ];

    return $triggers;
}

function customerInvoice($id)
{
    $CI = &get_instance();
    $CI->load->helper("sms_helper");

    $invoice = $CI->invoices_model->get($id);
    $where = ["active" => 1, "invoice_emails" => 1];
    $contacts = $CI->clients_model->get_contacts($invoice->clientid, $where);

    foreach($contacts as $contact):
        $template = mail_template("invoice_overdue_notice", $invoice, $contact);
        $merge_fields = $template->get_merge_fields();
        if(is_sms_trigger_active(SMS_TRIGGER_INVOICE_SEND_TO_CUSTOMER)):
            $CI->app_sms->trigger(SMS_TRIGGER_INVOICE_SEND_TO_CUSTOMER, $contact["phonenumber"], $merge_fields);
        endif;
    endforeach;
}
hooks()->add_action('admin_init', 'zender_module_init_menu_items');


/**
 * Init goals module menu items in setup in admin_init hook
 * @return null
 */
function zender_module_init_menu_items() {

    $CI = &get_instance();
    if (has_permission('zender', '', 'view')) {
        $CI->app_menu->add_sidebar_menu_item('zender', [
            'name' => _l('Zender'),
            'icon' => 'fa fa-envelope',
            'position' => 10,
        ]);

        $CI->app_menu->add_sidebar_children_item('zender', [
            'slug' => 'receive-sms-messages',
            'name' => _l('messages'),
            'icon' => 'fa fa-envelope',
            'href' => admin_url('zender'),
            'position' => 3,
        ]);


        $CI->app_menu->add_sidebar_children_item('zender', [
            'slug' => 'saved-sms-messages',
            'name' => _l('saved_messages'),
            'icon' => 'fa fa-file-text-o',
            'href' => admin_url('zender/saved_messages'),
            'position' => 3,
        ]);
//
//        $CI->app_menu->add_sidebar_children_item('receive_sms', [
//            'slug' => 'rec_settings',
//            'name' => _l('setting'),
//            'icon' => 'fa fa-gears',
//            'href' => admin_url('receive_sms/setting'),
//            'position' => 8,
//        ]);
    }
}

/**
 * Register language files, must be registered if the module is using languages
 */
register_language_files(ZENDER_MODULE_NAME, [ZENDER_MODULE_NAME]);


hooks()->add_action('admin_init', 'init_zender');
hooks()->add_filter('before_settings_updated', 'zender_set_senders_options');
hooks()->add_action('admin_init', 'zender_add_device_sms_settings');
hooks()->add_action('admin_init', 'zender_permissions');
hooks()->add_action('app_admin_footer', 'zender_receive_sms_load_js');
register_activation_hook(ZENDER_MODULE_NAME, 'zender_module_activation_hook');

$CI = &get_instance();
$CI->load->helper(ZENDER_MODULE_NAME . '/zender');

$CI->load->library('app_custom_tabs');
if (has_permission('Zender', '', 'view')) {
    $CI->app_custom_tabs->add_case_tab('Zender', [
        'name' => _l('Receive SMS'),
        'icon' => 'fa fa-th',
        'view' => 'receive_sms/case',
        'position' => 200,
    ]);


    $CI->app_custom_tabs->add_oservice_tab('Zender', [
        'name' => _l('Receive SMS'),
        'icon' => 'fa fa-th',
        'view' => 'receive_sms/oservice',
        'position' => 200,
    ]);
}
function zender_module_activation_hook() {
    $CI = &get_instance();
    require_once __DIR__ . '/install.php';
}

function zender_permissions()
{
    $capabilities = [];

    $capabilities['capabilities'] = [
        'view'   => _l('permission_view') . '(' . _l('permission_global') . ')',
    ];

    register_staff_capabilities('receive_sms', $capabilities, _l('receive_sms'));
}


function init_zender()
{
    $CI = &get_instance();
    $CI->load->library(ZENDER_MODULE_NAME . '/' . 'ZenderReceiveSMS');
}

function zender_set_senders_options($data)
{

    if(isset($data['settings']['receive_sms_token'])){
        $settings = $data['settings'];

        unset($data['settings']);
        $senders = [];
        foreach ($data as $key => $value ){
            array_push($senders,$value );
        }
        //echo '<pre>'; print_r($senders); exit;
        if (get_option('sms_senders') != Null){
            update_option('sms_senders',json_encode($senders));
        }else{
            add_option('sms_senders',json_encode($senders));
        }
        return ['settings' => $settings];
    }else{
        return $data;
    }
}

function zender_receive_sms_load_js()
{

    $viewuri = $_SERVER['REQUEST_URI'];
    if (strpos($viewuri, 'settings?group=device_sms') !== false) {
        echo '<script src="'.module_dir_url('zender', 'assets/js/settings.js').'"></script>';
    }

}

function zender_add_device_sms_settings()
{
    $CI = &get_instance();
    if (has_permission('Zender', '', 'view')){
        $CI->app_tabs->add_settings_tab('device_sms', [
            'name'     => _l('device_sms'),
            'view'     => 'zender/settings',
            'position' => 22,
        ]);
    }
}