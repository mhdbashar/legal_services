<?php

defined('BASEPATH') or exit('No direct script access allowed');
/*
Author: Babil Team
Module Name: تسجيل الحضور والانصراف
Description: الإضافة الافتراضية لتسجيل الحضور والانصراف من خلال الجوال
Version: 1.0.0
Requires at least: 2.3.*
Author URI: #

*/

define('FINGER_API_MODULE_NAME', 'finger_api');
hooks()->add_action('admin_init', 'finger_api_init_menu_items');
hooks()->add_action('admin_init', 'finger_api_permissions');

function finger_api_permissions()
{
    $capabilities = [];

    $capabilities['capabilities'] = [
        'timekeeper'   => _l('finger_timekeeper'),
    ];

    register_staff_capabilities('finger_api', $capabilities, _l('finger_api'));
}

/**
* Load the module helper
*/
$CI = & get_instance();
$CI->load->helper(FINGER_API_MODULE_NAME . '/finger_api');
/**
* Register activation module hook
*/
register_activation_hook(FINGER_API_MODULE_NAME, 'finger_api_activation_hook');


function finger_api_activation_hook()
{
    require_once(__DIR__ . '/install.php');
}

/**
* Register language files, must be registered if the module is using languages
*/
register_language_files(FINGER_API_MODULE_NAME, [FINGER_API_MODULE_NAME]);

/**
 * Init api module menu items in setup in admin_init hook
 * @return null
 */
function finger_api_init_menu_items()
{
    /**
    * If the logged in user is administrator, add custom menu in Setup
    */
    if (has_permission('finger_api', '', 'timekeeper')) {
        $CI = &get_instance();
        $CI->app_menu->add_sidebar_menu_item('finger_api-options', [
            'collapse' => true,
            'name'     => _l('finger_api'),
            'position' => 40,
            'icon'     => 'fa fa-cogs',
        ]);
        $CI->app_menu->add_sidebar_children_item('finger_api-options', [
            'slug'     => 'finger_api-register-options',
            'name'     => _l('qr_code'),
            'href'     => admin_url('finger_api/qr_management'),
            'position' => 5,
        ]);
        
//        $CI->app_menu->add_sidebar_children_item('finger_api-options', [
//            'slug'     => 'finger_api-guide-options',
//            'name'     => _l('api_guide'),
//            'href'     => 'https://perfexcrm.themesic.com/apiguide/',
//            'position' => 10,
//        ]);
    }
}

//hooks()->add_action('app_init','api_actLib');
//function api_actLib()
//{
//	$CI = & get_instance();
//    $CI->load->library(FINGER_API_MODULE_NAME.'/Envapi');
//    $envato_res = $CI->envapi->validatePurchase(FINGER_API_MODULE_NAME);
//    if (!$envato_res) {
//        set_alert('danger', "One of your modules failed its verification and got deactivated. Please reactivate or contact support.");
//        redirect(admin_url('modules'));
//    }
//}

//hooks()->add_action('pre_activate_module', 'api_sidecheck');
//function api_sidecheck($module_name)
//{
//    if ($module_name['system_name'] == FINGER_API_MODULE_NAME) {
//        if (!option_exists(FINGER_API_MODULE_NAME.'_verified') && empty(get_option(FINGER_API_MODULE_NAME.'_verified')) && !option_exists(FINGER_API_MODULE_NAME.'_verification_id') && empty(get_option(FINGER_API_MODULE_NAME.'_verification_id'))) {
//            $CI = & get_instance();
//            $data['submit_url'] = $module_name['system_name'].'/env_ver/activate';
//            $data['original_url'] = admin_url('modules/activate/'.FINGER_API_MODULE_NAME);
//            $data['module_name'] = FINGER_API_MODULE_NAME;
//            $data['title']       = $module_name['headers']['module_name']. " module activation";
//            echo $CI->load->view($module_name['system_name'].'/activate', $data, true);
//            exit();
//        }
//    }
//}

//hooks()->add_action('pre_deactivate_module', 'api_deregister');
//function api_deregister($module_name)
//{
//    if ($module_name['system_name'] == FINGER_API_MODULE_NAME) {
//        delete_option(FINGER_API_MODULE_NAME."_verified");
//        delete_option(FINGER_API_MODULE_NAME."_verification_id");
//        delete_option(FINGER_API_MODULE_NAME."_last_verification");
//        if(file_exists(__DIR__."/config/token.php")){
//            unlink(__DIR__."/config/token.php");
//        }
//    }
//}