<?php

defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: Babil Multi Theme
Description: Multi Themes for Babil CRM
Version: 1.0.0
Author: Zonvoir
Author URI: https://zonvoir.com
Requires at least: 2.3.2
*/

define('BABIL_MULTI_THEME_MODULE_NAME', 'babil_multi_theme');
hooks()->add_action('app_admin_footer', 'multi_theme_selection_sidebar');
$CI = &get_instance();
register_activation_hook(BABIL_MULTI_THEME_MODULE_NAME, 'babil_multi_theme_activation_hook');
function babil_multi_theme_activation_hook()
{
	require(__DIR__ . '/install.php');
}
register_uninstall_hook(BABIL_MULTI_THEME_MODULE_NAME, 'babil_multi_theme_uninstall_hook');
function babil_multi_theme_uninstall_hook()
{
	$CI = &get_instance();
	require_once(__DIR__ . '/uninstall.php');
}
function multi_theme_selection_sidebar()
{
	$CI = &get_instance();
    $CI->load->view('babil_multi_theme/sidebar');

}
register_language_files(BABIL_MULTI_THEME_MODULE_NAME, ['babil_multi_theme']);
$CI->load->helper(BABIL_MULTI_THEME_MODULE_NAME . '/babil_theme_multi');
