<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: تصدير معلومات العميل
Description: إضافة مخصصة للنظرة العامة للعملاء مع توليد تقارير عنهم
Author: Babil Team
Version: 1.0.3
Requires at least: 1.0.*
*/

define('BABIL_EXPORT_CUSTOMER_MODULE_NAME', 'babil_export_customer');

$CI = &get_instance();

hooks()->add_action('admin_init', 'babil_export_customer_admin_init_hook');
hooks()->add_filter('module_'.BABIL_EXPORT_CUSTOMER_MODULE_NAME.'_action_links', 'module_babil_export_customer_action_links');
hooks()->add_action('after_customer_admins_tab','babil_export_customer_profile_preview_tab');
hooks()->add_action('after_custom_profile_tab_content','babil_export_customer_profile_preview_content');
hooks()->add_action('before_client_updated','babil_export_customer_profile_preview_save',1,2);

/**
 * Add additional settings for this module in the module list area
 * @param  array $actions current actions
 * @return array
 */
function module_babil_export_customer_action_links($actions)
{
	$actions[] = '<a href="' . admin_url('settings?group=babil_export_customer_settings') . '">' . _l('settings') . '</a>';
	return $actions;
}

/**
* Load the module helper
*/
$CI->load->helper(BABIL_EXPORT_CUSTOMER_MODULE_NAME . '/babil_export_customer');

/**
* Load the module model
*/
$CI->load->model(BABIL_EXPORT_CUSTOMER_MODULE_NAME . '/babil_export_customer_model');

/**
* Register activation module hook
*/
register_activation_hook(BABIL_EXPORT_CUSTOMER_MODULE_NAME, 'babil_export_customer_activation_hook');

function babil_export_customer_activation_hook()
{
	$CI = &get_instance();
	require_once(__DIR__ . '/install.php');
}

/**
* Register language files, must be registered if the module is using languages
*/
register_language_files(BABIL_EXPORT_CUSTOMER_MODULE_NAME, [BABIL_EXPORT_CUSTOMER_MODULE_NAME]);

/**
*	Admin Init Hook for module
*/
function babil_export_customer_admin_init_hook()
{
	/*Add customer permissions */
	$capabilities = [];
	$capabilities['capabilities'] = [
		'view'   => _l('permission_view') . '(' . _l('permission_global') . ')',
	];
    register_staff_capabilities('babil_export_customer', $capabilities, _l('babil_export_customer'));

	$capabilities['capabilities'] = [
		'view'   => _l('permission_view') . '(' . _l('permission_global') . ')',
	];
	register_staff_capabilities('babil_export_customer_matrix', $capabilities, _l('babil_customer_matrix'));
	
	$capabilities['capabilities'] = [
		'view'   => _l('permission_view') . '(' . _l('permission_global') . ')',
	];
	register_staff_capabilities('babil_export_customer_services', $capabilities, _l('babil_customer_services'));
	
	$CI = &get_instance();
	/** Add Tab In customer List of Tabs **/
	if (is_admin() || has_permission('babil_export_customer_matrix', '', 'view')) {
		$CI->app_tabs->add_customer_profile_tab('client_matrix', [
			'name'     => _l('babil_customer_matrix'),
			'icon'     => 'fa fa-clipboard menu-icon',
			'view'     => 'babil_export_customer/customer_matrix_preview',
			'position' => 15,
		]);
	}
	/**  Add Tab In Settings Tab of Setup **/
	if (is_admin()) {
		$CI->app_tabs->add_settings_tab('babil_export_customer_settings', [
			'name'     => _l('babil_customer_settings'),
			'view'     => 'babil_export_customer/customer_settings',
			'position' => 100,
		]);
	}
	/** Add Menu for Client Services Report**/
	if (is_admin() || has_permission('babil_export_customer_services', '', 'view')) {
		$CI->app_menu->add_sidebar_menu_item('babil_export_customer_menu', [
			'collapse' => true,
			'icon'     => 'fa fa-area-chart',
			'name'     => _l('babil_expoert_customer_menu'),
			'position' => 35,
		]);
		$CI->app_menu->add_sidebar_children_item('babil_export_customer_menu', [
			'slug'     => 'client-services-report',
			'name'     => _l('babil_customer_services'),
			'href'     => admin_url('babil_export_customer/client_services_report'),
			'position' => 10,
		]);
	}
}

/**
*Add Tab in Customer Profile Tab
*/
function babil_export_customer_profile_preview_tab()
{
	$CI = &get_instance();
	if (is_admin() || has_permission('babil_export_customer', '', 'view')) {
		$CI->load->view('babil_export_customer/customer_profile_preview_tab');
	}	
}
/**
*Add Content for Tab in Customer Profile Tab
*/
function babil_export_customer_profile_preview_content($client)
{
	$CI = &get_instance();
	$CI->load->model('invoice_items_model');
	if ((is_admin() || has_permission('babil_export_customer', '', 'view')) && $client) {
		$contact = $CI->clients_model->get_contact(get_primary_contact_user_id($client->userid));
		if ($contact) {
			$data['contact'] = $contact;
		}
		$data['files'] = $CI->clients_model->get_customer_files($client->userid);
		foreach($data['files'] as $key=>$row)
		{
			//if not image file then remove
			if(strpos($row['filetype'], 'image/') === false)
				unset($data['files'][$key]);
		}
		
		$data['items'] = $CI->invoice_items_model->get();	
		$CI->load->view('babil_export_customer/customer_profile_preview_tab_content',$data);
	}	
}
/**
*Hook for Save in Customer Profile Tab
*/
function babil_export_customer_profile_preview_save($data,$id)
{
	$CI = &get_instance();
	if (is_admin() || has_permission('babil_export_customer', '', 'view')) {
		$files_id = $data['babil_export_customer_files'];
		$profile_file = $data['babil_export_customer_profile_file'];
		$items_id = $data['babil_export_customer_items'];
		$update_data['files_id'] = serialize($files_id);
		$update_data['profile_file_id'] = $profile_file;
		unset($data['babil_export_customer_files']);
		unset($data['babil_export_customer_profile_file']);
		unset($data['babil_export_customer_items']);	
		$CI->babil_export_customer_model->update_client_kyc($update_data,$id);
		$CI->babil_export_customer_model->update_client_services($items_id,$id);
		return $data;
	}
	return $data;	
}

