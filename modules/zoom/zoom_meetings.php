<?php

defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: ZOOM إجتماعات
Requires at least: 2.3.*
*/

define('ZOOM_MEETINGS_MODULE_NAME', 'zoom_meetings');
$CI = &get_instance();

/**

/**
* Register activation module hook
*/
register_activation_hook(ZOOM_MEETINGS_MODULE_NAME, 'zoom_meetings_meetings_module_activation_hook');

function zoom_meetings_module_activation_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/install.php');
}

hooks()->add_action('admin_init', 'zoom_meetings_module_init_menu_items');
/**


/**
* Register language files, must be registered if the module is using languages
*/
register_language_files(ZOOM_MEETINGS_MODULE_NAME, [ZOOM_MEETINGS_MODULE_NAME]);


function zoom_meetings_module_init_menu_items()
{
	
		$CI = &get_instance();

		$CI->app_menu->add_sidebar_menu_item('zoom_meetings', [
			'name'     => _l('zoom'), // The name if the item
			'collapse' => true, // Indicates that this item will have submitems
			'position' => 10, // The menu position
			'icon'     => 'fa fa-comment-o', // Font awesome icon
		]);
		
			$CI->app_menu->add_sidebar_children_item('zoom_meetings', [
				'slug'     => 'send-zoom_meetings', // Required ID/slug UNIQUE for the child menu
				'name'     => _l('zoom_meeting_list'), // The name if the item
				'href'     => admin_url('zoom_meetings'),
				'position' => 5,
			   
			   
			]);
      
		// The first paremeter is the parent menu ID/Slug
		$CI->app_menu->add_sidebar_children_item('zoom_meetings', [
			'slug'     => 'create-meeting', // Required ID/slug UNIQUE for the child menu
			'name'     => _l('zoom_create_meeting'), // The name if the item
			'href'     =>admin_url('zoom_meetings/create_meeting'),
			'position' => 5, // The menu position
		   
		]);
	  }

	if (is_admin()) {
		$CI->app_menu->add_sidebar_children_item('zoom_meetings', [
			'slug'     => 'meeting-registrant', // Required ID/slug UNIQUE for the child menu
			'name'     => _l('zoom_add_registrant'), // The name if the item
			'href'     =>admin_url('zoom_meetings/add_registrant'),
			'position' => 5, // The menu position
		   
		]);

		$CI->app_menu->add_sidebar_children_item('zoom_meetings', [
			'slug'     => 'api-meeting', // Required ID/slug UNIQUE for the child menu
			'name'     => _l('zoom_api_settings'), // The name if the item
			'href'     =>admin_url('zoom_meetings/api_meeting'),
			'position' => 5, // The menu position
		   
		]);
	 }
		
	
    
}
function zoom_meetings_client_module_init_menu_items()