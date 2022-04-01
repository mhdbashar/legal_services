<?php

defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: Googlesheets 
Description: Googlesheets API.
Version: 1.0.0
Author: Babel
*/

define('GOOGLESHEET_MODULE_NAME', 'googlesheets');
hooks()->add_action('admin_init', 'add_googlesheets_menu');





/**
* Register activation module hook
*/

register_activation_hook(GOOGLESHEET_MODULE_NAME, 'googlesheets_module_activation_hook');
$CI = & get_instance();
/**
 * Load the module helper
 */
$CI->load->helper(GOOGLESHEET_MODULE_NAME . '/googlesheets');
/**
 * Load the module model
 */
$CI->load->model(GOOGLESHEET_MODULE_NAME . '/Drive_model');
$CI->load->model(GOOGLESHEET_MODULE_NAME . '/Sheets_model');


/**
 * spreadsheet online module activation hook
 */
function googlesheets_module_activation_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/install.php');
}

/**
* Register language files, must be registered if the module is using languages
*/
register_language_files(GOOGLESHEET_MODULE_NAME, [GOOGLESHEET_MODULE_NAME]);

function add_googlesheets_menu()
{
    $CI = &get_instance();
    $CI->app_menu->add_sidebar_menu_item('Google Sheets', [
        'name'     => _l('google_sheets_menu'),
        'icon'     => 'fa fa-file-text',  
        'href'     => admin_url('googlesheets'),
        'position' => 25,
    ]);
    $CI->app_tabs->add_project_tab('project_google_sheets', [
        'name'                      => _l('google_sheets_project'),
        'icon'                      => 'fa fa-file-text-o',
        'view'                      =>  'googlesheets/project_google_sheets',
        'position'                  => 50,
    ]);
    $CI->app_tabs->add_settings_tab('google_sheets_settings', [
        'name'     => _l('google_sheets_settings'),
        'view'     => 'googlesheets/settings',
        'position' => 32,
    ]);
//    /**
//     * Check if can have permissions then apply new tab in settings
//     */
////    if (staff_can('view', 'settings')) {
//        hooks()->add_action('admin_init', 'zmm_add_settings_tab');
////    }
//    /**
//     * @return void
//     */
//    function zmm_add_settings_tab()
//    {
//        if (is_admin()) {
//            $CI = &get_instance();
//            $CI->app_tabs->add_settings_tab('settings_google_sheets', [
//                'name'     => _l('settings_google_sheets'),
//                'view'     => 'googlesheets/settings',
//                'position' => 32,
//            ]);
//        }
//    }


}