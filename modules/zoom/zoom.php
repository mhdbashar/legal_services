<?php

defined('BASEPATH') or exit('No direct script access allowed');

/*
  Module Name: zoom_name
  Description: zoom_desc
  Author: Babil Team
  Author URI: #
 */


define('ZOOM_MODULE_NAME', 'zoom');

/**
 * Load the module helper
 */
$CI = & get_instance();
$CI->load->helper(ZOOM_MODULE_NAME . '/zoom');

hooks()->add_action('app_admin_head', 'zoom_add_head_components');
hooks()->add_action('app_admin_footer', 'zoom_add_footer_components');

hooks()->add_action('admin_init', 'zoom_add_settings_tab');

/**
 * Functions of the module
 */
function zoom_add_head_components() {


    // echo '<link href="' . base_url('modules/zoom/assets/css/bootstrap.css') . '"  rel="stylesheet" type="text/css" />';


    // echo '<link href="' . base_url('modules/zoom/assets/css/react-select.css') . '"  rel="stylesheet" type="text/css" />';
}

function zoom_add_footer_components() {

    // echo '<script src="' . base_url('modules/zoom/assets/js/tool.js') . '"></script>';
    // echo '<script src="' . base_url('modules/zoom/assets/js/index.js') . '"></script>';
}


hooks()->add_action('clients_init', 'zoom_clients_area_menu_items');

function zoom_clients_area_menu_items() {



    if (is_client_logged_in()) {

        add_theme_menu_item('unique-logged-in-item-id', [
            'name' => _l('enter_meeting'),
            'href' => site_url('zoom/Zoom_client'),
            'position' => 2,
             'icon' => 'fa fa-dollar', // Font a
                ]
        );
    }
}

hooks()->add_action('admin_init', 'zoom_init_menu_items');


function zoom_init_menu_items() {
    $CI = &get_instance();
    $CI->app_menu->add_sidebar_menu_item('custom-menu-un
ique-id', [
        'name' => _l('enter_meeting'),
        'href' => admin_url('zoom'), // URL of the item
        'position' => 10, // The menu position, see belo
        'icon' => 'fa fa-dollar', // Font a

    ]);
}

function zoom_add_settings_tab()
{
    $CI = & get_instance();
    $CI->app_tabs->add_settings_tab('zoom-settings', [
       'name'     => ''._l('zoom_setting').'',
       'view'     => 'zoom/zoom_settings',
       'position' => 36,
   ]);
}

/**
* Register language files, must be registered if the module is using languages
*/
register_language_files(ZOOM_MODULE_NAME, [ZOOM_MODULE_NAME]);