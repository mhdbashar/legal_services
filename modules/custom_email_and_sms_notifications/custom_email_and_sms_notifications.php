<?php

defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: smsemail_name
Description: smsemail_desc
Version: 2.3.0
Requires at least: 2.3.*
Author: Babil Team
*/

define('CUSTOM_EMAIL_AND_SMS_NOTIFICATIONS_MODULE_NAME', 'custom_email_and_sms_notifications');

$CI = &get_instance();

hooks()->add_filter('sidebar_custom_email_and_sms_notifications_items', 'app_admin_sidebar_custom_options', 999);
hooks()->add_filter('sidebar_custom_email_and_sms_notifications_items', 'app_admin_sidebar_custom_positions', 998);

hooks()->add_filter('setup_custom_email_and_sms_notifications_items', 'app_admin_custom_email_and_sms_notifications_custom_options', 999);
hooks()->add_filter('setup_custom_email_and_sms_notifications_items', 'app_admin_custom_email_and_sms_notifications_custom_positions', 998);
hooks()->add_filter('module_custom_email_and_sms_notifications_action_links', 'module_custom_email_and_sms_notifications_action_links');
hooks()->add_action('app_admin_footer', 'sms_and_email_assets');

/**
 * Staff login includes
 * @return stylesheet / script
 */
function sms_and_email_assets()
{
    echo '<link href="' . base_url('modules/custom_email_and_sms_notifications/assets/style.css') . '"  rel="stylesheet" type="text/css" >';
	echo '<script src="' . base_url('/modules/custom_email_and_sms_notifications/assets/check.js') . '"></script>';
}

/**
* Add additional settings for this module in the module list area
* @param  array $actions current actions
* @return array
*/
function module_custom_email_and_sms_notifications_action_links($actions)
{
    return $actions;
}
/**
* Load the module helper
*/
$CI->load->helper(CUSTOM_EMAIL_AND_SMS_NOTIFICATIONS_MODULE_NAME . '/custom_email_and_sms_notifications');

/**
* Register activation module hook
*/
register_activation_hook(CUSTOM_EMAIL_AND_SMS_NOTIFICATIONS_MODULE_NAME, 'custom_email_and_sms_notifications_activation_hook');

function custom_email_and_sms_notifications_activation_hook()
{
    require_once(__DIR__ . '/install.php');
}

/**
* Register language files, must be registered if the module is using languages
*/
register_language_files(CUSTOM_EMAIL_AND_SMS_NOTIFICATIONS_MODULE_NAME, [CUSTOM_EMAIL_AND_SMS_NOTIFICATIONS_MODULE_NAME]);