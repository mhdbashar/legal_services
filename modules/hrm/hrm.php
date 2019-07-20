<?php

defined('BASEPATH') or exit('No direct script access allowed');
define('HRM_MODULE_PATH', __DIR__ );
define('HRM_MODULE_NAME', 'hrm');

/*
Module Name: New HR System
Description: Default module for Human Resources Management
Version: 1.0.0
Requires at least: 2.3.*
*/


register_activation_hook('hrm', 'hrm_module_activation_hook');
hooks()->add_action('admin_init', 'hrm_init_hrmApp');
hooks()->add_action('admin_init', 'hrm_module_init_menu_items');

function hrm_module_init_menu_items()
{
    $CI = &get_instance();

    $CI->app->add_quick_actions_link([
            'name'       => _l('hr'),
            'permission' => 'hrm',
            'url'        => 'hrm',
            'position'   => 70,
            ]);

			
		$CI->app_menu->add_sidebar_menu_item('hrm-system', [
            'collapse' => true,
            'name'     => "HRM",
            'position' => 7,
			'icon'     => 'fa fa-users',
        ]);
		
    if (has_permission('hr', '', 'view')) {
		
		$CI->app_menu->add_sidebar_children_item('hrm-system', [
                'slug'     => 'Settings',
                'name'     => 'Settings',
                'href'     => admin_url('hrm/Workdays'),
                'position' => 26,
        ]);
                
        $CI->app_menu->add_sidebar_children_item('hrm-system', [
                'slug'     => 'Employees',
                'name'     => 'Employees',
                'href'     => admin_url('hrm/Employees'),
                'position' => 27,
        ]);
        
        $CI->app_menu->add_sidebar_children_item('hrm-system', [
                'slug'     => 'Awards',
                'name'     => 'Awards',
                'href'     => admin_url('hrm/award'),
                'position' => 28,
        ]);
        $CI->app_menu->add_sidebar_children_item('hrm-system', [
            'slug'     => 'Salary',
            'name'     => 'Salary',
            'href'     => admin_url('hrm/payments'),
            'position' => 28,
        ]);
                
    }
}


function hrm_module_activation_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/install.php');
}
function hrm_init_hrmApp(){
    $CI = & get_instance();
    $CI->load->library(HRM_MODULE_NAME . '/' . 'hrmApp');
}