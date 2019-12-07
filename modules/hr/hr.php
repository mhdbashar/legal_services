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
        $CI->app_menu->add_sidebar_children_item('hr-system', [
                'slug'     => 'payroll',
                'name'     => 'Payroll',
                'href'     => admin_url('hr/payroll'),
                'position' => 35,
        ]); 
        $CI->app_menu->add_sidebar_children_item('hr-system', [
                'slug'     => 'settings',
                'name'     => 'Settings',
                'href'     => admin_url('hr/setting'),
                'position' => 35,
        ]);  
                
    }

    $CI->app->add_quick_actions_link([
            'name'       => _l('staff'),
            'permission' => 'hr',
            'url'        => 'employee',
            'position'   => 70,
            ]);

            
        $CI->app_menu->add_sidebar_menu_item('employee-system', [
            'collapse' => true,
            'name'     => "Employees",
            'position' => 7,
            'icon'     => 'fa fa-users',
        ]);
        
    if (has_permission('employee', '', 'view')) {
         
        $CI->app_menu->add_sidebar_children_item('employee-system', [
                'slug'     => 'Staff',
                'name'     => 'Staff',
                'href'     => admin_url('staff'),
                'position' => 30,
        ]);
        $CI->app_menu->add_sidebar_children_item('employee-system', [
                'slug'     => 'Staff',
                'name'     => 'Expired Documents',
                'href'     => admin_url('hr/general/expired_documents'),
                'position' => 30,
        ]);
                
    }

    $CI->app->add_quick_actions_link([
            'name'       => _l('staff'),
            'permission' => 'hr',
            'url'        => 'organization',
            'position'   => 70,
            ]);

            
        $CI->app_menu->add_sidebar_menu_item('organization-system', [
            'collapse' => true,
            'name'     => "Organization",
            'position' => 7,
            'icon'     => 'fa fa-users',
        ]);
        
    if (has_permission('organization', '', 'view')) {
         
        $CI->app_menu->add_sidebar_children_item('organization-system', [
                'slug'     => 'Branch',
                'name'     => 'Branch',
                'href'     => admin_url('branches'),
                'position' => 30,
        ]);
        $CI->app_menu->add_sidebar_children_item('organization-system', [
                'slug'     => 'Officail',
                'name'     => 'Officail Documents',
                'href'     => admin_url('hr/organization/officail_documents'),
                'position' => 31,
        ]);
        $CI->app_menu->add_sidebar_children_item('organization-system', [
                'slug'     => 'sub_department',
                'name'     => 'Sub Department',
                'href'     => admin_url('hr/organization/sub_department'),
                'position' => 32,
        ]);
        $CI->app_menu->add_sidebar_children_item('organization-system', [
                'slug'     => 'department',
                'name'     => 'Department',
                'href'     => admin_url('departments'),
                'position' => 34,
        ]);
        $CI->app_menu->add_sidebar_children_item('organization-system', [
                'slug'     => 'Designation',
                'name'     => 'Designation',
                'href'     => admin_url('hr/organization/designation'),
                'position' => 36,
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
$CI = & get_instance();
$CI->app_modules->activate('branches');
