<?php

defined('BASEPATH') or exit('No direct script access allowed');
/*
Module Name: API *****
Description: ------
Version: 1.0.0
*/

define('API_MODULE_NAME', 'api');


/**
* Load the module helper
*/
$CI = & get_instance();
$CI->load->helper(API_MODULE_NAME . '/api');
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

