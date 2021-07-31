<?php defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: إدارة حالات الخدمات القانونية
Description: يسمح لك بإدارة الحالات الغير إفتراضية في الخدمات القانونية
Author: Babil Team
Version: 1.0.0
Requires at least: 1.0.*
*/

define('BABIL_CUSTOM_STATUS_MODULE_NAME', 'babil_custom_status');

$CI = &get_instance();

hooks()->add_action('admin_init','babil_custom_status_hook_admin_init');
hooks()->add_filter('module_'.BABIL_CUSTOM_STATUS_MODULE_NAME.'_action_links', 'module_babil_custom_status_action_links');
hooks()->add_filter('before_get_project_statuses','babil_custom_status_hook_before_get_project_statuses');
hooks()->add_filter('before_get_task_statuses','babil_custom_status_hook_before_get_task_statuses');

/**
 * Add additional settings for this module in the module list area
 * @param  array $actions current actions
 * @return array
 */
function module_babil_custom_status_action_links($actions)
{
	$actions[] = '<a href="' . admin_url('babil_custom_status/statuses/projects') . '">' . _l('settings') . '</a>';
	return $actions;
}

/**
* Load the module model
*/
$CI->load->model(BABIL_CUSTOM_STATUS_MODULE_NAME . '/babil_custom_status_model');
/**
* Load the module helper
*/
$CI->load->helper(BABIL_CUSTOM_STATUS_MODULE_NAME . '/babil_custom_status');

/**
* Register activation module hook
*/
register_activation_hook(BABIL_CUSTOM_STATUS_MODULE_NAME, 'babil_custom_status_activation_hook');

function babil_custom_status_activation_hook()
{
	$CI = &get_instance();
	require_once(__DIR__ . '/install.php');
}

/**
* Register language files, must be registered if the module is using languages
*/
register_language_files(BABIL_CUSTOM_STATUS_MODULE_NAME, [BABIL_CUSTOM_STATUS_MODULE_NAME]);

/**
*	Admin Init Hook for module
*/
function babil_custom_status_hook_admin_init()
{
	$CI = &get_instance();
	/*Add customer permissions */
	$capabilities = [];
	$capabilities['capabilities'] = [
		'view'   => _l('permission_view') . '(' . _l('permission_global') . ')',
		'create'	 => _l('permission_create'),
		'edit'	 => _l('permission_edit'),
		'delete'	=> _l('permission_delete'),
	];
	register_staff_capabilities('babil_custom_status', $capabilities, _l('babil_custom_status'));
	
	/** Add Menu for Custom Statuses in Setup**/
	if (is_admin() || has_permission('babil_custom_status', '', 'view')) {
		$CI->app_menu->add_setup_menu_item('babil_custom_status_setup_menu', [
			'collapse' => true,
			'name'     => _l('babil_custom_status_setup_menu'),
			'position' => 35,
		]);
		$CI->app_menu->add_setup_children_item('babil_custom_status_setup_menu', [
			'slug'     => 'babil-custom-status-project',
			'name'     => _l('babil_custom_status_project_statuses_menu'),
			'href'     => admin_url('babil_custom_status/statuses/projects'),
			'position' => 10,
		]);
		$CI->app_menu->add_setup_children_item('babil_custom_status_setup_menu', [
			'slug'     => 'babil-custom-status-task',
			'name'     => _l('babil_custom_status_task_statuses_menu'),
			'href'     => admin_url('babil_custom_status/statuses/tasks'),
			'position' => 10,
		]);
	}
}

/** Hook for call extra project statuses**/
function babil_custom_status_hook_before_get_project_statuses($statuses)
{
	$CI = &get_instance();
	$custom_statuses = babil_cs_get_custom_statuses("projects");
	if(!empty($custom_statuses))
		$statuses = array_merge($statuses,$custom_statuses);    
	return $statuses;
}

/** Hook for call extra task statuses**/
function babil_custom_status_hook_before_get_task_statuses($statuses)
{
	$CI = &get_instance();
	$custom_statuses = babil_cs_get_custom_statuses("tasks");
	if(!empty($custom_statuses))
		$statuses = array_merge($statuses,$custom_statuses);     
	return $statuses;
}



