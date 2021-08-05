<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name:  رسائل SMS الواردة
Description: ادارة استلام الرسائل النصية القصيرة
Version: 1.0.0
Requires at least: 2.3.*
Author: Babil Team
Author URI: https://www.babiltec.com
 */

define('RECEIVE_SMS_MODULE_NAME', 'receive_sms');
define('RECEIVE_SMS_MODULE_PATH', __DIR__ );



/**
 * Register activation module hook
 */
hooks()->add_action('admin_init', 'receive_sms_module_init_menu_items');
hooks()->add_action('admin_init', 'init_receive_sms');
hooks()->add_filter('before_settings_updated', 'set_senders_options');
hooks()->add_action('admin_init', 'add_device_sms_settings');
hooks()->add_action('admin_init', 'receive_sms_permissions');
hooks()->add_action('app_admin_footer', 'receive_sms_load_js');
register_activation_hook(RECEIVE_SMS_MODULE_NAME, 'receive_sms_module_activation_hook');
/**
 * Load the module helper
 */
$CI = &get_instance();
$CI->load->helper(RECEIVE_SMS_MODULE_NAME . '/receive_sms');

$CI->load->library('app_custom_tabs');
if (has_permission('receive_sms', '', 'view')) {
    $CI->app_custom_tabs->add_case_tab('receive_sms', [
        'name' => _l('Receive SMS'),
        'icon' => 'fa fa-th',
        'view' => 'receive_sms/case',
        'position' => 200,
    ]);


    $CI->app_custom_tabs->add_oservice_tab('receive_sms', [
        'name' => _l('Receive SMS'),
        'icon' => 'fa fa-th',
        'view' => 'receive_sms/oservice',
        'position' => 200,
    ]);
}
function receive_sms_module_activation_hook() {
    $CI = &get_instance();
    require_once __DIR__ . '/install.php';
}

function receive_sms_permissions()
{
    $capabilities = [];

    $capabilities['capabilities'] = [
        'view'   => _l('permission_view') . '(' . _l('permission_global') . ')',
    ];

    register_staff_capabilities('receive_sms', $capabilities, _l('receive_sms'));
}


function init_receive_sms()
{
    $CI = &get_instance();
    $CI->load->library(RECEIVE_SMS_MODULE_NAME . '/' . 'ReceiveSMS');
}

function set_senders_options($data)
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

function receive_sms_load_js()
{

    $viewuri = $_SERVER['REQUEST_URI'];
    if (strpos($viewuri, 'settings?group=device_sms') !== false) {
        echo '<script src="'.module_dir_url('receive_sms', 'assets/js/settings.js').'"></script>';
    }

}

function add_device_sms_settings()
{
    $CI = &get_instance();
    if (has_permission('receive_sms', '', 'view')){
        $CI->app_tabs->add_settings_tab('device_sms', [
            'name'     => _l('device_sms'),
            'view'     => 'receive_sms/settings',
            'position' => 22,
        ]);
    }
}

/**
 * Register language files, must be registered if the module is using languages
 */
register_language_files(RECEIVE_SMS_MODULE_NAME, [RECEIVE_SMS_MODULE_NAME]);

/**
 * Init goals module menu items in setup in admin_init hook
 * @return null
 */
function receive_sms_module_init_menu_items() {

    $CI = &get_instance();
    if (has_permission('receive_sms', '', 'view')) {
        $CI->app_menu->add_sidebar_menu_item('receive_sms', [
            'name' => _l('receive_sms'),
            'icon' => 'fa fa-envelope',
            'position' => 10,
        ]);

        $CI->app_menu->add_sidebar_children_item('receive_sms', [
            'slug' => 'receive-sms-messages',
            'name' => _l('messages'),
            'icon' => 'fa fa-envelope',
            'href' => admin_url('receive_sms'),
            'position' => 3,
        ]);


        $CI->app_menu->add_sidebar_children_item('receive_sms', [
            'slug' => 'saved-sms-messages',
            'name' => _l('saved_messages'),
            'icon' => 'fa fa-file-text-o',
            'href' => admin_url('receive_sms/saved_messages'),
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