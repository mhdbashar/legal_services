<?php

/**
 * Ensures that the module init file can't be accessed directly, only within the application.
 */
defined('BASEPATH') or exit('No direct script access allowed');

/*
Author: Babil Team
Module Name: label_name
Description: label_desc
Version: 2.3.0
Requires at least: 2.3.*
*/


hooks()->add_action('admin_init', 'my_module_init_menu_items');

function my_module_init_menu_items(){
    $CI = &get_instance();

    $CI->app_menu->add_setup_menu_item('label_management', [
        'name'     => _l("languages"), // The name if the item
        'href'     => base_url() . 'admin/label_management/language', // URL of the item
        'position' => 50, // The menu position, see below for default positions.
        // 'icon'     => 'fa fa-file-text-o', // Font awesome icon
    ]);
}