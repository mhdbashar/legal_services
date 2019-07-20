<?php

/**
 * Ensures that the module init file can't be accessed directly, only within the application.
 */
defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: Label Management
Description: Translate Label (Arabic- English).
Version: 2.3.0
Requires at least: 2.3.*
*/


hooks()->add_action('admin_init', 'my_module_init_menu_items');

function my_module_init_menu_items(){
    $CI = &get_instance();

    $CI->app_menu->add_sidebar_menu_item('label_management', [
        'name'     => 'Languages', // The name if the item
        'href'     => base_url() . 'admin/label_management/language', // URL of the item
        'position' => 10, // The menu position, see below for default positions.
        'icon'     => 'fa fa-file-text-o', // Font awesome icon
    ]);
}