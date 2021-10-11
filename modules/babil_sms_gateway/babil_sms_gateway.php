<?php

/**
 * Ensures that the module init file can"t be accessed directly, only within the application.
 */
defined("BASEPATH") or exit("No direct script access allowed");

/*
Module Name: بوابة بابل للرسائل الصادرة والواردة
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

define("BABIL_SMS_GATEWAY_MODULE_NAME", "babil_sms_gateway");
define('BABIL_SMS_GATEWAY_MODULE_PATH', __DIR__ );
define("SMS_TRIGGER_INVOICE_SEND_TO_CUSTOMER", "invoice_send_to_customer");

hooks()->add_filter("sms_gateways", "babil_sms_gateway_sms_gateways");
hooks()->add_filter("sms_triggers", "babil_sms_gateway_triggers");
hooks()->add_filter("sms_gateway_available_triggers", "babil_sms_gateway_triggers");
hooks()->add_action("invoice_sent", "customerInvoice");

function babil_sms_gateway_sms_gateways($gateways)
{
    $gateways[] = "babil_sms_gateway/sms_babil_sms_gateway";
    return $gateways;
}

function babil_sms_gateway_triggers($triggers)
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
hooks()->add_action('admin_init', 'babil_sms_gateway_module_init_menu_items');


/**
 * Init goals module menu items in setup in admin_init hook
 * @return null
 */
function babil_sms_gateway_module_init_menu_items() {

    $CI = &get_instance();
    if (has_permission('receive_sms', '', 'view')) {
        $CI->app_menu->add_sidebar_menu_item('babil_sms_gateway', [
            'name' => _l('babil_sms_gateway'),
            'icon' => 'fa fa-envelope',
            'position' => 10,
        ]);

        $CI->app_menu->add_sidebar_children_item('babil_sms_gateway', [
            'slug' => 'receive-sms-messages',
            'name' => _l('messages'),
            'icon' => 'fa fa-envelope',
            'href' => admin_url('babil_sms_gateway'),
            'position' => 3,
        ]);


        $CI->app_menu->add_sidebar_children_item('babil_sms_gateway', [
            'slug' => 'saved-sms-messages',
            'name' => _l('saved_messages'),
            'icon' => 'fa fa-file-text-o',
            'href' => admin_url('babil_sms_gateway/saved_messages'),
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
register_language_files(BABIL_SMS_GATEWAY_MODULE_NAME, [BABIL_SMS_GATEWAY_MODULE_NAME]);


hooks()->add_action('admin_init', 'init_babil_sms_gateway');
hooks()->add_filter('before_settings_updated', 'babil_sms_gateway_set_senders_options');
hooks()->add_action('admin_init', 'babil_sms_gateway_add_device_sms_settings');
hooks()->add_action('admin_init', 'babil_sms_gateway_permissions');
hooks()->add_action('app_admin_footer', 'babil_sms_gateway_receive_sms_load_js');
register_activation_hook(BABIL_SMS_GATEWAY_MODULE_NAME, 'babil_sms_gateway_module_activation_hook');

$CI = &get_instance();
$CI->load->helper(BABIL_SMS_GATEWAY_MODULE_NAME . '/babil_sms_gateway');

$CI->load->library('app_custom_tabs');
if (has_permission('receive_sms', '', 'view')) {
    $CI->app_custom_tabs->add_case_tab('babil_sms_gateway', [
        'name' => _l('Receive SMS'),
        'icon' => 'fa fa-th',
        'view' => 'babil_sms_gateway/case',
        'position' => 200,
    ]);


    $CI->app_custom_tabs->add_oservice_tab('babil_sms_gateway', [
        'name' => _l('Receive SMS'),
        'icon' => 'fa fa-th',
        'view' => 'babil_sms_gateway/oservice',
        'position' => 200,
    ]);
}
function babil_sms_gateway_module_activation_hook() {
    $CI = &get_instance();
    require_once __DIR__ . '/install.php';
}

function babil_sms_gateway_permissions()
{
    $capabilities = [];

    $capabilities['capabilities'] = [
        'view'   => _l('permission_view') . '(' . _l('permission_global') . ')',
    ];

    register_staff_capabilities('receive_sms', $capabilities, _l('receive_sms'));
}


function init_babil_sms_gateway()
{
    $CI = &get_instance();
    $CI->load->library(BABIL_SMS_GATEWAY_MODULE_NAME . '/' . 'BabilSMSGateway');
}

function babil_sms_gateway_set_senders_options($data)
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

function babil_sms_gateway_receive_sms_load_js()
{

    $viewuri = $_SERVER['REQUEST_URI'];
    if (strpos($viewuri, 'settings?group=device_sms') !== false) {
        echo '<script src="'.module_dir_url('babil_sms_gateway', 'assets/js/settings.js').'"></script>';
    }

}

function babil_sms_gateway_add_device_sms_settings()
{
    $CI = &get_instance();
    if (has_permission('receive_sms', '', 'view')){
        $CI->app_tabs->add_settings_tab('device_sms', [
            'name'     => _l('device_sms'),
            'view'     => 'babil_sms_gateway/settings',
            'position' => 22,
        ]);
    }
}