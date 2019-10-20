<?php

defined('BASEPATH') or exit('No direct script access allowed');
define('HR_MODULE_PATH', __DIR__ );
define('HR_MODULE_NAME', 'hr');

//ShababSy.com Added this line

/*
Author: Ahmad Zaher khrezaty
Module Name: HR System
Description: Default module for Human Resources Management
Version: 1.0.0
Requires at least: 2.3.*
*/

register_activation_hook('hr', 'hr_module_activation_hook');
hooks()->add_action('admin_init', 'hr_init_hrmApp');
hooks()->add_action('admin_init', 'hr_module_init_menu_items');

function hr_module_init_menu_items()
{
    $CI = &get_instance();

    $CI->app->add_quick_actions_link([
            'name'       => _l('hr'),
            'permission' => 'hr',
            'url'        => 'hr',
            'position'   => 70,
            ]);

			
		$CI->app_menu->add_sidebar_menu_item('hr-system', [
            'collapse' => true,
            'name'     => "HR",
            'position' => 7,
			'icon'     => 'fa fa-users',
        ]);
		
    if (has_permission('hr', '', 'view')) {
		
        $CI->app_menu->add_sidebar_children_item('hr-system', [
                'slug'     => 'Holidays',
                'name'     => 'Holidays',
                'href'     => admin_url('hr/Holidays'),
                'position' => 26,
        ]);  
                
    }
}


function hr_module_activation_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/install.php');
}
function hr_init_hrmApp(){
    $CI = & get_instance();
    $CI->load->library(HR_MODULE_NAME . '/' . 'hrmApp');
}
