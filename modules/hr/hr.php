<?php

defined('BASEPATH') or exit('No direct script access allowed');
define('HR_MODULE_PATH', __DIR__ );
define('HR_MODULE_NAME', 'hr');

//ShababSy.com Added this line

/*
Author: Babil Team
Module Name: hr_name
Description: hr_desc
Version: 1.0.0
Requires at least: 2.3.*
Author URI: #

*/


register_activation_hook('hr', 'hr_module_activation_hook');
hooks()->add_action('admin_init', 'hr_init_hrmApp');
hooks()->add_action('app_admin_head', 'hr_add_head_components');
hooks()->add_action('app_admin_footer', 'hr_add_footer_components');
// hooks()->add_action('admin_init', 'hr_module_init_menu_items');

$CI = & get_instance();
$CI->load->helper(HR_MODULE_NAME . '/hr');
hooks()->add_action('after_render_single_setup_menu', 'hr_menu_items');

/**
 * Register language files, must be registered if the module is using languages
 */
register_language_files(HR_MODULE_NAME, [HR_MODULE_NAME]);

function accepted_pages($pages = []){
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
        $url = "https://";
    else
        $url = "http://";
    // Append the host(domain name, ip) to the URL.
    $url.= $_SERVER['HTTP_HOST'];

    // Append the requested resource location to the URL
    $url.= $_SERVER['REQUEST_URI'];

    $url = str_replace(base_url(),'',$url);

    foreach ($pages as $page){
        if(strpos($url, $page) !== false){
            return true;
        }
    }
    return false;
}

function hr_add_head_components(){
    $CI = &get_instance();
    $viewuri = $_SERVER['REQUEST_URI'];

    echo '<link href="' . module_dir_url('hr','assets/css/style.css') .'"  rel="stylesheet" type="text/css" />';
    echo '<link href="' . module_dir_url('hr','assets/plugins/ComboTree/style.css') .'"  rel="stylesheet" type="text/css" />';


    if (accepted_pages(['hr'])) {
        echo '<script src="'.module_dir_url('hr', 'assets/plugins/highcharts/highcharts.js').'"></script>';
        echo '<script src="'.module_dir_url('hr', 'assets/plugins/highcharts/modules/variable-pie.js').'"></script>';
        echo '<script src="'.module_dir_url('hr', 'assets/plugins/highcharts/modules/export-data.js').'"></script>';
        echo '<script src="'.module_dir_url('hr', 'assets/plugins/highcharts/modules/accessibility.js').'"></script>';
        echo '<script src="'.module_dir_url('hr', 'assets/plugins/highcharts/modules/exporting.js').'"></script>';
        echo '<script src="'.module_dir_url('hr', 'assets/plugins/highcharts/highcharts-3d.js').'"></script>';
    }


}



function hr_add_footer_components(){
    $CI = &get_instance();
    $viewuri = $_SERVER['REQUEST_URI'];

    echo '<script src="'.module_dir_url('hr', 'assets/plugins/ComboTree/comboTreePlugin.js').'"></script>';
    echo '<script src="'.module_dir_url('hr', 'assets/plugins/ComboTree/icontains.js').'"></script>';

    if (strpos($viewuri, 'contract_type') !== false || $viewuri == '/admin/hrm/setting') {
        echo '<script src="'.module_dir_url('hr', 'assets/js/contracttype.js').'"></script>';
    }


    if (accepted_pages(['hr/contract'])) {
        echo '<script src="'.module_dir_url('hr', 'assets/js/contract.js').'"></script>';
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
    $CI->load->helper(HR_MODULE_NAME . '/' . 'hr_general');
}
$CI = & get_instance();
// $CI->app_modules->activate('branches');


function hr_menu_items($item)
{
    $branch = '';
    $CI = & get_instance();
//    if($CI->app_modules->is_active('branches')){
//        $branch = '<li><a href="'.admin_url('branches').'">'._l('branches').'</a>
//                                    </li>';
//    }
    if (has_permission('hr', '', 'view')){
        if($item['position']=='10'){
                // echo '<ul><a href="#">HRM App</a></ul>';
        echo '<li class="menu-item-hr">';
        echo '<a href="#" aria-expanded="false"> '._l('hr_system').'<span class="fa arrow-ar"></span></a>';

        echo '<ul class="nav nav-second-level collapse" aria-expanded="false">
                        <li><a href="'.admin_url('hr').'" aria-expanded="false">'._l('dashboard').'</span></a>
                        </li>
                        <li><a href="#" aria-expanded="false">'._l('staff').'<span class="fa arrow-ar"></span></a>
                                <ul class="nav nav-second-level collapse" aria-expanded="false">
                                    <li><a href="'.admin_url('hr/general/staff').'">'._l('staff').'</a>
                                    </li>
                                    <li><a href="'.admin_url('hr/general/expired_documents').'">'._l('expired_documents').'</a>
                                    </li>
                                    <li><a href="'.admin_url('hr/contracts').'">'._l('staff_contract').'</a>
                                    </li>
                                </ul>
                        </li>

                        <li><a href="#" aria-expanded="false">'._l('settings').'<span class="fa arrow-ar"></span></a>
                                <ul class="nav nav-second-level collapse" aria-expanded="false">
                                    <li><a href="'.admin_url('hr/setting').'">'._l('constants').'</a>
                                    </li>
                                    <li><a href="'.admin_url('hr/setting/global_hr_setting').'">'._l('global_hr_setting').'</a>
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
';
                        // <li><a href="#" aria-expanded="false">'._l('timesheet').'<span class="fa arrow-ar"></span></a>
                        //         <ul class="nav nav-second-level collapse" aria-expanded="false">
                                    
                        //             <li><a href="'.admin_url('hr/timesheet/attendance').'">'._l('attendance').'</a>
                        //             </li>
                        //             <li><a href="'.admin_url('hr/timesheet/calendar').'">'._l('calendar').'</a>
                        //             </li>
                        //             <li><a href="'.admin_url('hr/timesheet/date_wise_attendance').'">'._l('date_wise_attendance').'</a>
                        //             </li>
                        //             <li><a href="'.admin_url('hr/timesheet/leaves').'">'._l('leaves').'</a>
                        //             </li>
                        //             <li><a href="'.admin_url('hr/timesheet/overtime_requests').'">'._l('overtime_requests').'</a>
                        //             </li>
                        //             <li><a href="'.admin_url('hr/timesheet/office_shift').'">'._l('office_shift').'</a>
                        //             </li>
                        //         </ul>
                        // </li>
echo '
                        <li><a href="#" aria-expanded="false">'._l('performance').'<span class="fa arrow-ar"></span></a>
                                <ul class="nav nav-second-level collapse" aria-expanded="false">
                                    
                                    <li><a href="'.admin_url('hr/performance/indicators').'">'._l('indicators').'</a>
                                    </li>
                                    <li><a href="'.admin_url('hr/performance/appraisals').'">'._l('appraisals').'</a>
                                    </li>
                                </ul>
                        </li>

                        <li><a href="#" aria-expanded="false">'._l('organization').'<span class="fa arrow-ar"></span></a>
                                <ul class="nav nav-second-level collapse" aria-expanded="false">
                                '.$branch.'
                                <li><a href="'.admin_url('hr/organization/officail_documents').'">'._l('official_documents').'</a>
                                </li>
                                <li><a href="'.admin_url('departments').'">'._l('departments').'</a>
                                </li>';
                            if(is_active_sub_department())
                                echo '<li><a href="'.admin_url('hr/organization/sub_department').'">'._l('sub_department').'</a>
                                </li>';

                                echo '<li><a href="'.admin_url('hr/organization/designation').'">'._l('designation').'</a>
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
                                </li>';
                            if(is_active_sub_department())
                            echo    '<li><a href="'.admin_url('hr/core_hr/transfers').'">'._l('transfers').'</a>
                                </li>';

                            echo    '<li><a href="'.admin_url('hr/core_hr/complaints').'">'._l('complaints').'</a>
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
    // else
    //     if($item['position']=='10'){
    //             // echo '<ul><a href="#">HRM App</a></ul>';
    //     echo '<li class="menu-item-hr">';
    //     echo '<a href="#" aria-expanded="false"> '._l('hr_system').'<span class="fa arrow-ar"></span></a>';

    //     echo '<ul class="nav nav-second-level collapse" aria-expanded="false">
                       

    //                     <li><a href="#" aria-expanded="false">'._l('timesheet').'<span class="fa arrow-ar"></span></a>
    //                             <ul class="nav nav-second-level collapse" aria-expanded="false">
                                    
    //                                 <li><a href="'.admin_url('hr/timesheet/leaves').'">'._l('leaves').'</a>
    //                                 </li>
    //                                 <li><a href="'.admin_url('hr/timesheet/overtime_requests').'">'._l('overtime_requests').'</a>
    //                                 </li>
    //                             </ul>
    //                     </li>

    //             </ul>';
    //     echo '</li>';
    //     }
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
