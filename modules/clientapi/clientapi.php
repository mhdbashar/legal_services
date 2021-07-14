<?php



defined('BASEPATH') or exit('No direct script access allowed');



/*

Module Name: CLIENT API
Description: CLIENT APP Api FOR PERFEX CRM
Version: 1.0.0
Author: LBM SOLUTIONS
Author URI: https://lbmsolutions.in

*/



define('API_MODULE_NAME', 'clientapi');

hooks()->add_action('admin_init', 'api_init_menu_items');



/**

* Load the module helper

*/

$CI = & get_instance();

$CI->load->helper(API_MODULE_NAME . '/clientapi');

/**

* Register activation module hook

*/

register_activation_hook(API_MODULE_NAME, 'api_activation_hook');





function api_activation_hook()

{

    require_once(__DIR__ . '/install.php');

}



/**

* Register language files, must be registered if the module is using languages

*/

register_language_files(API_MODULE_NAME, [API_MODULE_NAME]);



/**

 * Init api module menu items in setup in admin_init hook

 * @return null

 */

function api_init_menu_items()

{

    /**

    * If the logged in user is administrator, add custom menu in Setup

    */

    if (is_admin()) {

        $CI = &get_instance();

       $CI->app_menu->add_sidebar_menu_item('custom-menu-unique-id', [
        'name'     => 'CLIENT app', // The name if the item
        'href'     => admin_url('clientapi/api_management'), // URL of the item
        'position' => 60, // The menu position, see below for default positions.
        'icon'     => 'fa fa-mobile', // Font awesome icon
    ]);
    }

}