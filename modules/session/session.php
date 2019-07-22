<?php

/**
 * Ensures that the module init file can't be accessed directly, only within the application.
 */
defined('BASEPATH') or exit('No direct script access allowed');

define('SESSION_MODULE_NAME', 'session');
define('SESSION_MODULE_PATH', __DIR__ );

/*
Module Name: Session Module
Description: Manages session
Version: 2.3.0
Requires at least: 2.3.*
Author: Ahmad Zaher Khrezaty
*/


/**
* Register language files, must be registered if the module is using languages
*/
register_language_files(SESSION_MODULE_NAME, [SESSION_MODULE_NAME]);


register_activation_hook('session', 'session_module_activation_hook');
hooks()->add_action('admin_init', 'session_module_init_menu_item');
hooks()->add_action('admin_init', 'session_init_Hr_tabs');

function session_module_init_menu_item() {
    $CI = &get_instance();

    $CI->app_menu->add_sidebar_menu_item('session', [
        'name' => 'Session',
        'href' => base_url('session/service_sessions/session/1/1'),
        'position' => 10,
        'icon' => 'fa fa-map-marker',
    ]);
}
function session_module_activation_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/install.php');
}
function session_init_Hr_tabs(){
    $CI = & get_instance();
    $CI->load->library(SESSION_MODULE_NAME . '/' . 'SessionApp');
}