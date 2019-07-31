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
hooks()->add_action('admin_init', 'hrm_init_employeedetails_tabs');

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

function hrm_init_employeedetails_tabs()
{
    
    $CI = &get_instance();

    $CI->load->library(HRM_MODULE_NAME . '/' . 'Hr_tabs');
    
    $CI->hr_tabs->add_employeedetails_tab('basic', [
        'name'     => _l('basic_details'),
        'view'     => 'hrm/details/basic',
        'position' => 5,
    ]);

    $CI->hr_tabs->add_employeedetails_tab('bank', [
        'name'     => _l('bank_details'),
        'view'     => 'hrm/details/bank',
        'position' => 10,
    ]);

    $CI->hr_tabs->add_employeedetails_tab('documents', [
        'name'     => _l('documents_details'),
        'view'     => 'hrm/details/documents',
        'position' => 15,
    ]);

    $CI->hr_tabs->add_employeedetails_tab('leave', [
        'name'     => _l('leave_details'),
        'view'     => 'hrm/details/leave',
        'position' => 20,
    ]);

    $CI->hr_tabs->add_employeedetails_tab('overtime', [
        'name'     => _l('overtime_details'),
        'view'     => 'hrm/details/overtime',
        'position' => 25,
    ]);

    $CI->hr_tabs->add_employeedetails_tab('tasks', [
        'name'     => _l('tasks_details'),
        'view'     => 'hrm/details/tasks',
        'position' => 30,
    ]);

    $CI->hr_tabs->add_employeedetails_tab('projects', [
        'name'     => _l('projects_details'),
        'view'     => 'hrm/details/projects',
        'position' => 35,
    ]);

    $CI->hr_tabs->add_employeedetails_tab('activities', [
        'name'     => _l('activities_details'),
        'view'     => 'hrm/details/activities',
        'position' => 40,
    ]);

    $CI->hr_tabs->add_employeedetails_tab('salary', [
        'name'     => _l('salary_details'),
        'view'     => 'hrm/details/salary',
        'position' => 45,
    ]);
    $CI->hr_tabs->add_employeedetails_tab('timecard', [
        'name'     => _l('timecard_details'),
        'view'     => 'hrm/details/timecard',
        'position' => 45,
    ]);

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

/**
* Register language files, must be registered if the module is using languages
*/
register_language_files(HRM_MODULE_NAME, [HRM_MODULE_NAME]);