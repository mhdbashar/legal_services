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
// hooks()->add_action('admin_init', 'hr_module_init_menu_items');

hooks()->add_action('after_render_single_setup_menu', 'hr_menu_items'); 


function hr_menu_items($item)
{
        // print_r($item);
        if($item['position']=='10'){
                // echo '<ul><a href="#">HRM App</a></ul>';
        echo '<li>';
        echo '<a href="#" aria-expanded="false"><i class="fa fa-balance-scale menu-icon-ar"></i> '._l('hr_system').'<span class="fa arrow-ar"></span></a>';

        echo '<ul class="nav nav-second-level collapse" aria-expanded="false">
                        <li><a href="#" aria-expanded="false">'._l('staff').'<span class="fa arrow-ar"></span></a>
                                <ul class="nav nav-second-level collapse" aria-expanded="false">
                                    <li><a href="'.admin_url('staff').'">'._l('staff').'</a>
                                    </li>
                                    <li><a href="'.admin_url('hr/general/expired_documents').'">'._l('expired_documents').'</a>
                                    </li>
                                </ul>
                        </li>

                        <li><a href="#" aria-expanded="false">'._l('settings').'<span class="fa arrow-ar"></span></a>
                                <ul class="nav nav-second-level collapse" aria-expanded="false">
                                    <li><a href="'.admin_url('hr/setting').'">'._l('constants').'</a>
                                    </li>
                                </ul>
                        </li>

                        <li><a href="#" aria-expanded="false">'._l('payroll').'<span class="fa arrow-ar"></span></a>
                                <ul class="nav nav-second-level collapse" aria-expanded="false">
                                    <li><a href="'.admin_url('hr/payroll').'">'._l('payroll').'</a>
                                    </li>
                                    <li><a href="'.admin_url('hr/payroll/payment_history').'">'._l('payment_history').'</a>
                                    </li>
                                </ul>
                        </li>

                        <li><a href="#" aria-expanded="false">'._l('timesheet').'<span class="fa arrow-ar"></span></a>
                                <ul class="nav nav-second-level collapse" aria-expanded="false">
                                    <li><a href="'.admin_url('hr/timesheet/holidays').'">'._l('holiday').'</a>
                                    </li>
                                </ul>
                        </li>

                        <li><a href="#" aria-expanded="false">'._l('organization').'<span class="fa arrow-ar"></span></a>
                                <ul class="nav nav-second-level collapse" aria-expanded="false">
                                <li><a href="'.admin_url('branches').'">'._l('branches').'</a>
                                </li>
                                <li><a href="'.admin_url('hr/organization/officail_documents').'">'._l('official_documents').'</a>
                                </li>
                                <li><a href="'.admin_url('departments').'">'._l('departments').'</a>
                                </li>
                                <li><a href="'.admin_url('hr/organization/sub_department').'">'._l('sub_department').'</a>
                                </li>
                                <li><a href="'.admin_url('hr/organization/designation').'">'._l('designation').'</a>
                                </li>
                                </ul>
                        </li>

                        <li><a href="#" aria-expanded="false">'._l('core_hr').'<span class="fa arrow-ar"></span></a>
                                <ul class="nav nav-second-level collapse" aria-expanded="false">
                                <li><a href="'.admin_url('hr/core_hr/awards').'">'._l('awards').'</a>
                                </li>
                                <li><a href="'.admin_url('hr/core_hr/terminations').'">'._l('terminations').'</a>
                                </li>
                                <li><a href="'.admin_url('hr/core_hr/warnings').'">'._l('warnings').'</a>
                                </li>
                                <li><a href="'.admin_url('hr/core_hr/transfers').'">'._l('transfers').'</a>
                                </li>
                                <li><a href="'.admin_url('hr/core_hr/complaints').'">'._l('complaints').'</a>
                                </li>
                                <li><a href="'.admin_url('hr/core_hr/resignations').'">'._l('resignations').'</a>
                                </li>
                                <li><a href="'.admin_url('hr/core_hr/promotions').'">'._l('promotions').'</a>
                                </li>
                                <li><a href="'.admin_url('hr/core_hr/travels').'">'._l('travels').'</a>
                                </li>
                                </ul>
                        </li>
                </ul>';
        echo '</li>';
        }
}

    /*
    
    $CI->app->add_quick_actions_link([
            'name'       => _l('staff'),
            'permission' => 'hr',
            'url'        => 'employee',
            'position'   => 70,
            ]);

            
        $CI->app_menu->add_sidebar_menu_item('employee-system', [
            'collapse' => true,
            'name'     => _l("employees"),
            'position' => 7,
            'icon'     => 'fa fa-users',
        ]);
        
    if (has_permission('employee', '', 'view')) {
         
        $CI->app_menu->add_sidebar_children_item('employee-system', [
                'slug'     => 'Staff',
                'name'     => _l('staff'),
                'href'     => admin_url('staff'),
                'position' => 30,
        ]);
        $CI->app_menu->add_sidebar_children_item('employee-system', [
                'slug'     => 'Staff',
                'name'     => _l('expired_documents'),
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
            'name'     => _l('organization'),
            'position' => 7,
            'icon'     => 'fa fa-users',
        ]);
        
    if (has_permission('organization', '', 'view')) {
         
        $CI->app_menu->add_sidebar_children_item('organization-system', [
                'slug'     => 'Branch',
                'name'     => _l('branch'),
                'href'     => admin_url('branches'),
                'position' => 30,
        ]);
        $CI->app_menu->add_sidebar_children_item('organization-system', [
                'slug'     => 'Officail',
                'name'     => _l('official_documents'),
                'href'     => admin_url('hr/organization/officail_documents'),
                'position' => 31,
        ]);
        $CI->app_menu->add_sidebar_children_item('organization-system', [
                'slug'     => 'sub_department',
                'name'     => _l('sub_department'),
                'href'     => admin_url('hr/organization/sub_department'),
                'position' => 32,
        ]);
        $CI->app_menu->add_sidebar_children_item('organization-system', [
                'slug'     => 'department',
                'name'     => _l('departments'),
                'href'     => admin_url('departments'),
                'position' => 34,
        ]);
        $CI->app_menu->add_sidebar_children_item('organization-system', [
                'slug'     => 'Designation',
                'name'     => _l('designation'),
                'href'     => admin_url('hr/organization/designation'),
                'position' => 36,
        ]);
                
    }
}
*/

    



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
