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
$CI->load->helper(GOOGLESHEET_MODULE_NAME . '/Googlesheets');
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


function add_googlesheets_menu()
{
    $CI = &get_instance();
    $CI->app_menu->add_sidebar_menu_item('Google Sheets', [
        'name'     => _l('GoogleSheets'),
        'icon'     => 'fa fa-file-text',  
        'href'     => admin_url('googlesheets'),
        'position' => 1,
    ]);
    $CI->app_tabs->add_project_tab('project_google_sheets', [
        'name'                      => _l('Google Sheets'),
        'icon'                      => 'fa fa-file-text-o',
        'view'                      =>  'googlesheets/project_google_sheets',
        'position'                  => 50,
    ]);


}