<?php

/**
 * Ensures that the module init file can't be accessed directly, only within the application.
 */
defined('BASEPATH') or exit('No direct script access allowed');

define('LOCATION_MODULE_NAME', 'location_module');
define('LOCATION_MODULE_PATH', __DIR__ );

/*
Module Name: Location Module
Description: Manages cities and countries inside your app by adding, modifying and deleting Countries or Cities
Version: 2.3.0
Requires at least: 2.3.*
Author: Anas Shaikhany
*/

hooks()->add_action('admin_init', 'location_module_init_menu_item');
hooks()->add_action('admin_init', 'location_init_LocationApp');

function location_module_init_menu_item() {
    $CI = &get_instance();

    $CI->app_menu->add_sidebar_menu_item('location', [
        'name' => 'Locations',
        'href' => admin_url('location_module/L_Locations'),
        'position' => 10,
        'icon' => 'fa fa-map-marker',
    ]);
}

function location_init_LocationApp(){
    $CI = & get_instance();
    $CI->load->library(LOCATION_MODULE_NAME . '/' . 'LocationApp');
}