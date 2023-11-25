<?php

defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: HR Records
Description: The primary function of HR Records is to provide a central database containing records for all employees past and presen
Version: 1.1.2
Requires at least: 2.3.*
Author: GreenTech Solutions
Author URI: https://codecanyon.net/user/greentech_solutions
*/

define('HR_PROFILE_MODULE_NAME', 'hr_profile');
define('HR_PROFILE_MODULE_UPLOAD_FOLDER', module_dir_path(HR_PROFILE_MODULE_NAME, 'uploads'));
define('HR_PROFILE_CONTRACT_ATTACHMENTS_UPLOAD_FOLDER', module_dir_path(HR_PROFILE_MODULE_NAME, 'uploads/contracts/'));
define('HR_PROFILE_JOB_POSIITON_ATTACHMENTS_UPLOAD_FOLDER', module_dir_path(HR_PROFILE_MODULE_NAME, 'uploads/job_position/'));
define('HR_PROFILE_Q_A_ATTACHMENTS_UPLOAD_FOLDER', module_dir_path(HR_PROFILE_MODULE_NAME, 'uploads/q_a/'));
define('HR_PROFILE_FILE_ATTACHMENTS_UPLOAD_FOLDER', module_dir_path(HR_PROFILE_MODULE_NAME, 'uploads/att_file/'));
define('HR_PROFILE_IMAGE_UPLOAD_FOLDER', 'uploads/staff_profile_images/');
define('HR_PROFILE_PATH', 'modules/hr_profile/uploads/');
define('HR_MODULE_PATH', __DIR__ );
define('HR_PROFILE_ERROR', 'modules/hr_profile/uploads/file_error_response/');
define('HR_PROFILE_CREATE_EMPLOYEES_SAMPLE', 'modules/hr_profile/uploads/employees_sample_file/');
define('HR_PROFILE_CONTRACT_SIGN', 'modules/hr_profile/uploads/contract_sign/');


register_merge_fields('hr_profile/merge_fields/hr_contract_merge_fields');
hooks()->add_filter('other_merge_fields_available_for', 'hr_contract_register_other_merge_fields');

hooks()->add_action('admin_init', 'hr_profile_permissions');
hooks()->add_action('app_admin_head', 'hr_profile_add_head_components');
hooks()->add_action('app_admin_footer', 'hr_profile_load_js');
hooks()->add_action('app_search', 'hr_profile_load_search');
hooks()->add_action('admin_init', 'hr_profile_module_init_menu_items');
//add hook render profile icon on header menu
hooks()->add_action('after_render_top_search', 'render_my_profile_icon');
hooks()->add_action('hr_profile_init',HR_PROFILE_MODULE_NAME.'_appint');
hooks()->add_action('admin_init', 'hr_init_hrmApp');
hooks()->add_action('after_cron_settings_last_tab', 'add_immigration_reminder_tab');
hooks()->add_action('after_cron_settings_last_tab_content', 'add_immigration_reminder_tab_content');
hooks()->add_action('after_cron_run', 'immigration_reminders');
hooks()->add_action('after_cron_run', 'create_new_type_of_leave');
hooks()->add_action('after_cron_run', 'checkContractExpiry');
hooks()->add_action('pre_activate_module', HR_PROFILE_MODULE_NAME.'_preactivate');
hooks()->add_action('pre_deactivate_module', HR_PROFILE_MODULE_NAME.'_predeactivate');

define('VERSION_HR_PROFILE', 107);

/**
 * Register activation module hook
 */
register_activation_hook(HR_PROFILE_MODULE_NAME, 'hr_profile_module_activation_hook');

// In your module's initialization file
// Load the cron model
// function cron_leave(){
// $this->load->model('cron_model');

// // Define the cron job details
// $cron_data = array(
//     'hook' => 'leave_cron_run', // A custom hook to trigger the cron job
//     'interval' => 'daily',        // Schedule (e.g., daily, hourly)
//     'enabled' => 1,               // Enable the cron job
// );

// // Insert the cron job into the database
// $this->cron_model->insertCron($cron_data);
// }
function hr_profile_module_activation_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/install.php');
}
/**immigration */
function add_immigration_reminder_tab(){
    echo '
	<li role="presentation">
	<a href="#immigration" aria-control="immigration" role="tab" data-toggle="tab">'._l('immigration').'</a>
	</li>';
}

function add_immigration_reminder_tab_content(){
    echo '<div role="tabpanel" class="tab-pane" id="immigration">
 <i class="fa fa-question-circle pull-left" data-toggle="tooltip" data-title="'. _l('hr_immigration_reminder_notification_before_help').'"></i>
 '.render_input('settings[hr_immigration_reminder_notification_before]','hr_immigration_reminder_notification_before',get_option('hr_immigration_reminder_notification_before'),'number').'
</div>  ';
}

function add_staff_hr_reminder_tab(){
    echo '
	<li role="presentation">
	<a href="#hr_document" aria-control="hr_document" role="tab" data-toggle="tab">'._l('hr_document').'</a>
	</li>';
}

function add_staff_hr_reminder_tab_content(){
    echo '<div role="tabpanel" class="tab-pane" id="hr_document">
 <i class="fa fa-question-circle pull-left" data-toggle="tooltip" data-title="'. _l('hr_document_reminder_notification_before_help').'"></i>
 '.render_input('settings[hr_document_reminder_notification_before]','hr_document_reminder_notification_before',get_option('hr_document_reminder_notification_before'),'number').'
</div>  ';
}
function add_official_document_reminder_tab(){
    echo '
	<li role="presentation">
	<a href="#official_document" aria-control="official_document" role="tab" data-toggle="tab">'._l('official_documents').'</a>
	</li>';
}

function add_official_document_reminder_tab_content(){
    echo '<div role="tabpanel" class="tab-pane" id="official_document">
 <i class="fa fa-question-circle pull-left" data-toggle="tooltip" data-title="'. _l('hr_official_document_reminder_notification_before').'"></i>
 '.render_input('settings[hr_official_document_reminder_notification_before]','hr_official_document_reminder_notification_before',get_option('hr_official_document_reminder_notification_before'),'number').'
</div>  ';
}
function add_type_of_leave_reminder(){
  echo '<div role="tabpanel" class="tab-pane" id="official_document">
<i class="fa fa-question-circle pull-left" data-toggle="tooltip" data-title="'. _l('hr_type_leave_reminders_notification_before').'"></i>
'.render_input('settings[hr_type_leave_reminders_notification_before]','hr_type_leave_reminders_notification_before',get_option('hr_type_leave_reminders_notification_before'),'number').'
</div>  ';
}
 
  
/**
 * Register language files, must be registered if the module is using languages
 */
register_language_files(HR_PROFILE_MODULE_NAME, [HR_PROFILE_MODULE_NAME]);


$CI = & get_instance();
$CI->load->helper(HR_PROFILE_MODULE_NAME . '/hr_profile');

/**
 * Init goals module menu items in setup in admin_init hook
 * @return null
 */
function hr_profile_module_init_menu_items()
{
    $CI = &get_instance();

    $CI->app_menu->add_sidebar_menu_item('organizations', [
        'name' => _l('organizations'),
        'icon' => 'fa fa-users',
        'position' => 5,
    ]);
    if(has_permission('hrm_dashboard','','view') || has_permission('staffmanage_orgchart','','view') || has_permission('hrm_reception_staff','','view') || has_permission('hrm_hr_records','','view') || has_permission('staffmanage_job_position','','view') || has_permission('staffmanage_training','','view') || has_permission('hr_manage_q_a','','view') || has_permission('hrm_contract','','view') || has_permission('hrm_dependent_person','','view') || has_permission('hrm_procedures_for_quitting_work','','view') || has_permission('hrm_report','','view') || has_permission('hrm_setting','','view')|| has_permission('staffmanage_orgchart','','view_own') || has_permission('staffmanage_job_position','','view_own') || has_permission('hrm_reception_staff','','view_own') || has_permission('hrm_hr_records','','view_own') || has_permission('staffmanage_training','','view_own')  || has_permission('hrm_contract','','view_own') || has_permission('hrm_dependent_person','','view_own') || has_permission('hrm_procedures_for_quitting_work','','view_own')){

        $CI->app_menu->add_sidebar_menu_item('hr_profile', [
            'name'     => _l('hr_hr_profile'),
            'icon'     => 'fa fa-users',
            'position' => 5,
        ]);
    }
 if(has_permission('hr','','view_own') || has_permission('hr','','view')){
  $CI->app_menu->add_sidebar_menu_item('performance', [
    'name' => _l('performance'),
    'icon'=> 'fa fa-users',
    'position' => 5,
  ]);
 }
    if (has_permission('hr', '', 'view_own') || has_permission('hr', '', 'view')){
      $CI->app_menu->add_sidebar_children_item('performance', [
          'slug'     => 'indicators',
          'name'     => _l('indicators'),
          'href'     => admin_url('hr_profile/performance/indicators'),
          'position' => 45,
          'icon'     => 'fa fa-tachometer',
      ]);
    }
    if (has_permission('hr', '', 'view_own') || has_permission('hr', '', 'view')){
      $CI->app_menu->add_sidebar_children_item('performance', [
          'slug'     => 'appraisals',
          'name'     => _l('appraisals'),
          'href'     => admin_url('hr_profile/performance/appraisals'),
          'position' => 50,
          'icon'     => 'fa fa-tachometer',
      ]);
    }


    if (has_permission('hr', '', 'view_own') || has_permission('hr', '', 'view')
    ) {
        $CI->app_menu->add_sidebar_menu_item('organizations', [
            'name' => _l('organizations'),
            'icon' => 'fa fa-users',
            'position' => 5,
        ]);
    }

    if (has_permission('hr', '', 'view_own') || has_permission('hr', '', 'view') ){
        $CI->app_menu->add_sidebar_children_item('organizations', [
            'slug'     => 'official_documents',
            'name'     => _l('official_documents'),
            'href'     => admin_url('hr_profile/organization/officail_documents'),
            'position' => 45,
            'icon'     => 'fa fa-file',
        ]);
    }
  /* if (has_permission('hr', '', 'view_own') || has_permission('hr', '', 'view')){
        $CI->app_menu->add_sidebar_children_item('organizations', [
            'slug'     => 'indicators',
            'name'     => _l('indicators'),
            'href'     => admin_url('hr_profile/performance/indicators'),
            'position' => 45,
            'icon'     => 'fa fa-tachometer',
        ]);
    }
  */
   /* if (has_permission('hr', '', 'view_own') || has_permission('hr', '', 'view')){
        $CI->app_menu->add_sidebar_children_item('organizations', [
            'slug'     => 'appraisals',
            'name'     => _l('appraisals'),
            'href'     => admin_url('hr_profile/performance/appraisals'),
            'position' => 50,
            'icon'     => 'fa fa-tachometer',
        ]);
    }
  
    
   */
  if (has_permission('hr', '', 'view_own') || has_permission('hr', '', 'view') || is_admin()) {          
		$CI->app_menu->add_sidebar_children_item('hr_profile', [
			'slug'     => 'timesheets_timekeeping_mnrh',
			'name'     => _l('hr_leave'),
			'icon'     => 'fa fa-clipboard',
			'href'     => admin_url('hr_profile/requisition_manage') ,
			'position' => 2,

		]);
	}
    if (has_permission('expired_documents', '', 'view_own') || has_permission('expired_documents', '', 'view')){
        $CI->app_menu->add_sidebar_children_item('organizations', [
            'slug'     => 'expired_documents',
            'name'     => _l('expired_documents'),
            'href'     => admin_url('hr_profile/organization/expired_documents'),
            'position' => 44,
            'icon'     => 'fa fa-users',
        ]);
    }
    $CI->app_menu->add_sidebar_children_item('organizations', [
        'slug'     => 'sub_department',
        'name'     => _l('sub_department'),
        'href'     => admin_url('hr_profile/organization/sub_department'),
        'position' => 65,
        'icon'     => 'fa fa-building-o',
    ]);




    $CI->app_menu->add_sidebar_menu_item('hr', [
        'name'     => _l('hr'),
        'icon'     => 'fa fa-users',
        'position' => 5,
    ]);
    $CI->app_menu->add_sidebar_children_item('hr', [
        'slug'     => 'awards',
        'name'     => _l('awards'),
        'href'     => admin_url('hr_profile/core_hr/awards'),
        'position' => 75,
        'icon'     => 'fa fa-trophy',
    ]);
    $CI->app_menu->add_sidebar_children_item('hr', [
        'slug'     => 'terminations',
        'name'     => _l('terminations'),
        'href'     => admin_url('hr_profile/core_hr/terminations'),
        'position' => 80,
        'icon'     => 'fa fa-sign-out',
    ]);
    $CI->app_menu->add_sidebar_children_item('hr', [
        'slug'     => 'warnings',
        'name'     => _l('warnings'),
        'href'     => admin_url('hr_profile/core_hr/warnings'),
        'position' => 85,
        'icon'     => 'fa fa-exclamation-triangle',
    ]);
    $CI->app_menu->add_sidebar_children_item('hr', [
        'slug'     => 'complaints',
        'name'     => _l('complaints'),
        'href'     => admin_url('hr_profile/core_hr/complaints'),
        'position' => 95,
        'icon'     => 'fa fa-file',
    ]);
    $CI->app_menu->add_sidebar_children_item('hr', [
        'slug'     => 'resignations',
        'name'     => _l('resignations'),
        'href'     => admin_url('hr_profile/core_hr/resignations'),
        'position' => 100,
        'icon'     => 'fa fa-file',
    ]);
    $CI->app_menu->add_sidebar_children_item('hr', [
        'slug'     => 'promotions',
        'name'     => _l('promotions'),
        'href'     => admin_url('hr_profile/core_hr/promotions'),
        'position' => 105,
        'icon'     => 'fa fa-bullhorn',
    ]);
    $CI->app_menu->add_sidebar_children_item('hr', [
        'slug'     => 'travels',
        'name'     => _l('travels'),
        'href'     => admin_url('hr_profile/core_hr/travels'),
        'position' => 110,
        'icon'     => 'fa fa-file',
    ]);







    if(has_permission('hrm_dashboard','','view')){
        $CI->app_menu->add_sidebar_children_item('hr_profile', [
            'slug'     => 'hr_profile_dashboard',
            'name'     => _l('hr_dashboard'),
            'icon'     => 'fa fa-dashboard',
            'href'     => admin_url('hr_profile/dashboard'),
            'position' => 1,
        ]);
    }
    

        $CI->app_menu->add_sidebar_children_item('hr', [
            'slug'     => 'vacations',
            'name'     => _l('hr_vacations'),
            'href'     => admin_url('hr_profile/core_hr/vacations/manage'),
            'position' => 15,
            'icon'     => 'fa fa-file-o',
        ]);

    


    if(has_permission('staffmanage_orgchart','','view') || has_permission('staffmanage_orgchart','','view_own')){
        $CI->app_menu->add_sidebar_children_item('hr_profile', [
            'slug'     => 'hr_profile_organizational_chart',
            'name'     => _l('hr_organizational_chart'),
            'icon'     => 'fa fa-th-list',
            'href'     => admin_url('hr_profile/organizational_chart'),
            'position' => 3,
        ]);
    }

    if(has_permission('hrm_reception_staff','','view') || has_permission('hrm_reception_staff','','view_own')){
        $CI->app_menu->add_sidebar_children_item('hr_profile', [
            'slug'     => 'hr_profile_reception_of_staff',
            'name'     => _l('hr_receiving_staff_lable'),
            'icon'     => 'fa fa-edit',
            'href'     => admin_url('hr_profile/reception_staff'),
            'position' => 3,
        ]);
    }

    if(has_permission('hrm_hr_records','','view') || has_permission('hrm_hr_records','','view_own')){
        $CI->app_menu->add_sidebar_children_item('hr_profile', [
            'slug'     => 'hr_profile_hr_records',
            'name'     => _l('hr_hr_records'),
            'icon'     => 'fa fa-user',
            'href'     => admin_url('hr_profile/staff_infor'),
            'position' => 4,
        ]);
    }

    if(has_permission('staffmanage_job_position','','view') || has_permission('staffmanage_job_position','','view_own')){
        $CI->app_menu->add_sidebar_children_item('hr_profile', [
            'slug'     => 'hr_profile_job_position_manage',
            'name'     => _l('hr_job_descriptions'),
            'icon'     => 'fa fa-map-pin',
            'href'     => admin_url('hr_profile/job_positions'),
            'position' => 2,
        ]);
    }

    if(has_permission('staffmanage_training','','view') || has_permission('staffmanage_training','','view_own')){
        $CI->app_menu->add_sidebar_children_item('hr_profile', [
            'slug'     => 'hr_profile_training',
            'name'     => _l('hr_training'),
            'icon'     => 'fa fa-graduation-cap',
            'href'     => admin_url('hr_profile/training?group=training_program'),
            'position' => 5,
        ]);
    }

    if(has_permission('hr_manage_q_a','','view')){
        $CI->app_menu->add_sidebar_children_item('hr_profile', [
            'slug'     => 'hr_profile_q_a',
            'name'     => _l('hr_q_a'),
            'icon'     => 'fa fa-question-circle',
            'href'     => admin_url('hr_profile/knowledge_base_q_a'),
            'position' => 9,
        ]);
    }

    if(has_permission('hrm_contract','','view') || has_permission('hrm_contract','','view_own')){
        $CI->app_menu->add_sidebar_children_item('hr_profile', [
            'slug'     => 'hr_profile_contract',
            'name'     => _l('hr_hr_contracts'),
            'icon'     => 'fa fa-wpforms',
            'href'     => admin_url('hr_profile/contracts'),
            'position' => 6,
        ]);
    }

    if(has_permission('hrm_dependent_person','','view') || has_permission('hrm_dependent_person','','view_own')){
        $CI->app_menu->add_sidebar_children_item('hr_profile', [
            'slug'     => 'hr_profile_dependent_person',
            'name'     => _l('hr_dependent_persons'),
            'icon'     => 'fa fa-address-card-o',
            'href'     => admin_url('hr_profile/dependent_persons'),
            'position' => 7,
        ]);
    }

    if(has_permission('hrm_procedures_for_quitting_work','','view') || has_permission('hrm_procedures_for_quitting_work','','view_own')){
        $CI->app_menu->add_sidebar_children_item('hr_profile', [
            'slug'     => 'hr_profile_quitting_works',
            'name'     => _l('hr_resignation_procedures'),
            'icon'     => 'fa fa-user-times',
            'href'     => admin_url('hr_profile/resignation_procedures'),
            'position' => 8,
        ]);
    }

    if(has_permission('hrm_report','','view')){
        $CI->app_menu->add_sidebar_children_item('hr_profile', [
            'slug'     => 'hr_profile_reports',
            'name'     => _l('hr_reports'),
            'icon'     => 'fa fa-list-alt',
            'href'     => admin_url('hr_profile/reports'),
            'position' => 10,
        ]);
    }

    if(has_permission('hrm_setting','','view')){
        $CI->app_menu->add_sidebar_children_item('hr_profile', [
            'slug'     => 'hr_profile_setting',
            'name'     => _l('hr_settings'),
            'icon'     => 'fa fa-cogs',
            'href'     => admin_url('hr_profile/setting?group=contract_type'),
            'position' => 14,
        ]);
    }
if (has_permission('attendance_management', '', 'view_own') || has_permission('attendance_management', '', 'view') || is_admin()) {
		$CI->app_menu->add_sidebar_children_item('hr_profile', [
			'slug'     => 'hr_profile_timekeeping',
			'name'     => _l('attendance_hr'),
			'href'     => admin_url('hr_profile/timekeeping2'),
			'icon'     => 'fa fa-pencil-square-o',
			'position' =>1,
		]); 
	}


}

/**
 * hr profile load js
 */
function hr_profile_load_js(){
    $CI = &get_instance();
    $viewuri = $_SERVER['REQUEST_URI'];
    if(!(strpos($viewuri,'admin/hr_profile/dashboard') === false)){

        echo '<script src="'.module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/plugins/highcharts/highcharts.js').'?v=' . VERSION_HR_PROFILE.'"></script>';
        echo '<script src="'.module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/plugins/highcharts/variable-pie.js').'?v=' . VERSION_HR_PROFILE.'"></script>';
        echo '<script src="'.module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/plugins/highcharts/export-data.js').'?v=' . VERSION_HR_PROFILE.'"></script>';
        echo '<script src="'.module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/plugins/highcharts/accessibility.js').'?v=' . VERSION_HR_PROFILE.'"></script>';
        echo '<script src="'.module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/plugins/highcharts/exporting.js').'?v=' . VERSION_HR_PROFILE.'"></script>';
        echo '<script src="'.module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/plugins/highcharts/highcharts-3d.js').'?v=' . VERSION_HR_PROFILE.'"></script>';
    }

    if(!(strpos($viewuri,'admin/hr_profile/reports') === false)){

        echo '<script src="'.module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/plugins/highcharts/highcharts.js').'?v=' . VERSION_HR_PROFILE.'"></script>';
        echo '<script src="'.module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/plugins/highcharts/exporting.js').'?v=' . VERSION_HR_PROFILE.'"></script>';
        echo '<script src="'.module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/plugins/highcharts/series-label.js').'?v=' . VERSION_HR_PROFILE.'"></script>';
    }


    //settings
    if(!(strpos($viewuri,'admin/hr_profile/setting?group=contract_type') === false)){
        echo '<script src="'.module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/js/setting/contract_type.js').'?v=' . VERSION_HR_PROFILE.'"></script>';
    }

    if(!(strpos($viewuri,'admin/hr_profile/setting?group=allowance_type') === false)){

        echo '<script src="'.module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/js/setting/allowance_type.js').'?v=' . VERSION_HR_PROFILE.'"></script>';
    }

    if(!(strpos($viewuri,'admin/hr_profile/setting?group=payroll') === false)){
        echo '<script src="'.module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/js/setting/payroll.js').'?v=' . VERSION_HR_PROFILE.'"></script>';
    }

    if(!(strpos($viewuri,'admin/hr_profile/setting?group=type_of_training') === false)){
        echo '<script src="'.module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/js/setting/type_of_training.js').'?v=' . VERSION_HR_PROFILE.'"></script>';
    }

    if(!(strpos($viewuri,'admin/hr_profile/setting?group=income_tax_individual') === false)){
        echo '<script src="https://cdn.jsdelivr.net/npm/handsontable@7.2.2/dist/handsontable.full.min.js"></script>';
        echo '<link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable@7.2.2/dist/handsontable.full.min.css">';
    }

    if(!(strpos($viewuri,'admin/hr_profile/setting?group=procedure_retire') === false)){
        echo '<script src="'.module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/js/setting/procedure_retire.js').'?v=' . VERSION_HR_PROFILE.'"></script>';
    }

    if(!(strpos($viewuri,'admin/hr_profile/setting?group=salary_type') === false)){
        echo '<script src="'.module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/js/setting/salary_type.js').'?v=' . VERSION_HR_PROFILE.'"></script>';
    }

    if(!(strpos($viewuri,'admin/hr_profile/setting?group=workplace') === false)){
        echo '<script src="'.module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/js/setting/workplace.js').'?v=' . VERSION_HR_PROFILE.'"></script>';
    }


    if(!(strpos($viewuri,'admin/hr_profile/training') === false)){
        if(!(strpos($viewuri,'training_library') === false)){
            echo '<script src="'.module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/js/training/training_library.js').'?v=' . VERSION_HR_PROFILE.'"></script>';
        }
    }

    if(!(strpos($viewuri,'admin/hr_profile/job_position_manage') === false)){
        echo '<script src="'.module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/js/job_position/job/job.js').'?v=' . VERSION_HR_PROFILE.'"></script>';
    }
    if(!(strpos($viewuri,'admin/hr_profile/job_positions') === false)){
        echo '<script src="'.module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/js/job_position/position/position_manage.js').'?v=' . VERSION_HR_PROFILE.'"></script>';
    }
    if(!(strpos($viewuri,'admin/hr_profile/job_position_view_edit') === false)){
        echo '<script src="'.module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/js/job_position/job_position_view_edit.js').'?v=' . VERSION_HR_PROFILE.'"></script>';
    }
    if(!(strpos($viewuri,'admin/hr_profile/importxlsx') === false)){
        echo '<script src="'.base_url('assets/plugins/jquery-validation/additional-methods.min.js').'?v=' . VERSION_HR_PROFILE.'"></script>';
    }

    if(!(strpos($viewuri,'admin/hr_profile/member') === false)){
        if(!(strpos($viewuri,'insurrance') === false)){
            echo '<script src="'.module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/js/hr_record/includes/insurrance.js').'?v=' . VERSION_HR_PROFILE.'"></script>';
        }
        if(!(strpos($viewuri,'income_tax') === false)){
            echo '<script src="'.module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/js/hr_record/includes/income_tax.js').'?v=' . VERSION_HR_PROFILE.'"></script>';
        }
        if(!(strpos($viewuri,'profile') === false)){
            echo '<script src="'.module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/js/hr_record/includes/profile.js').'?v=' . VERSION_HR_PROFILE.'"></script>';
        }

        if(!(strpos($viewuri,'dependent_person') === false)){
            echo '<script src="'.module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/js/hr_record/includes/dependent_person.js').'?v=' . VERSION_HR_PROFILE.'"></script>';
        }
        if(!(strpos($viewuri,'bonus_discipline') === false)){
            echo '<script src="'.module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/js/hr_record/includes/bonus_discipline.js').'?v=' . VERSION_HR_PROFILE.'"></script>';
        }
        if(!(strpos($viewuri,'application_submitted') === false)){
            echo '<script src="'.module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/js/hr_record/includes/application_submitted.js').'?v=' . VERSION_HR_PROFILE.'"></script>';
        }
        if(!(strpos($viewuri,'attach') === false)){
            echo '<script src="'.module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/js/hr_record/includes/attach.js').'?v=' . VERSION_HR_PROFILE.'"></script>';
        }
        if(!(strpos($viewuri,'permission') === false)){
            echo '<script src="'.module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/js/hr_record/includes/permission.js').'?v=' . VERSION_HR_PROFILE.'"></script>';
        }
    }

    if(!(strpos($viewuri,'admin/hr_profile/contracts') === false) || !(strpos($viewuri,'admin/hr_profile/staff_infor') === false)|| !(strpos($viewuri,'admin/hr_profile/organizational_chart') === false)){
        echo '<script src="'.module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/plugins/ComboTree/comboTreePlugin.js').'?v=' . VERSION_HR_PROFILE.'"></script>';
        echo '<script src="'.module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/plugins/ComboTree/icontains.js').'?v=' . VERSION_HR_PROFILE.'"></script>';
        echo '<script src="'.module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/plugins/OrgChart-master/jquery.orgchart.js').'?v=' . VERSION_HR_PROFILE.'"></script>';

    }

    if(!(strpos($viewuri,'admin/hr_profile/contracts') === false) || !(strpos($viewuri,'admin/hr_profile/staff_infor') === false) || !(strpos($viewuri,'admin/hr_profile/organizational_chart') === false)){
        echo '<script src="'.module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/plugins/ComboTree/comboTreePlugin.js').'?v=' . VERSION_HR_PROFILE.'"></script>';
        echo '<script src="'.module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/plugins/ComboTree/comboTreePlugin.js').'?v=' . VERSION_HR_PROFILE.'"></script>';


    }

    if (!(strpos($viewuri, '/admin/hr_profile/contract') === false)) {
        echo '<script src="' . module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/plugins/handsontable/chosen.jquery.js') . '"></script>';
        echo '<script src="' . module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/plugins/handsontable/handsontable-chosen-editor.js') . '"></script>';
    }

    if (!(strpos($viewuri, '/admin/hr_profile/contract_sign') === false)) {
        echo '<script src="' . module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/plugins/signature_pad.min.js') . '"></script>';
    }



}


/**
 * hr profile add head components
 */
function hr_profile_add_head_components(){
    $CI = &get_instance();
    $viewuri = $_SERVER['REQUEST_URI'];

    if(hr_profile_check_hide_menu()){
        if(!(strpos($viewuri,'admin') === false)){
            echo '<link href="' . module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/css/hide_sidebar_menu.css') . '?v=' . VERSION_HR_PROFILE. '"  rel="stylesheet" type="text/css" />';
        }
    }
    if(!(strpos($viewuri,'admin/hr_profile') === false)){
        echo '<link href="' . module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/css/style.css') . '?v=' . VERSION_HR_PROFILE. '"  rel="stylesheet" type="text/css" />';
    }

    if(!(strpos($viewuri,'admin/hr_profile/organizational_chart') === false) || !(strpos($viewuri,'admin/hr_profile/staff_infor') === false)){
        echo '<link href="' . module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/plugins/ComboTree/style.css') . '?v=' . VERSION_HR_PROFILE. '"  rel="stylesheet" type="text/css" />';
        echo '<link href="' . module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/css/style.css') . '?v=' . VERSION_HR_PROFILE. '"  rel="stylesheet" type="text/css" />';
        echo '<link href="' . module_dir_url(HR_PROFILE_MODULE_NAME, '/assets/plugins/OrgChart-master/jquery.orgchart.css') . '?v=' . VERSION_HR_PROFILE. '"  rel="stylesheet" type="text/css" />';

    }


    if(!(strpos($viewuri,'admin/hr_profile/organizational_chart') === false)){
        echo '<link href="' . module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/css/organizational/organizational.css') . '?v=' . VERSION_HR_PROFILE. '"  rel="stylesheet" type="text/css" />';
        echo '<link href="https://fonts.googleapis.com/css?family=Gochi+Hand" rel="stylesheet">';
    }

    if(!(strpos($viewuri,'admin/hr_profile/training') === false)){
        if(!(strpos($viewuri,'insurrance') === false)){
            echo '<link href="' . module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/css/setting/insurrance.css') . '?v=' . VERSION_HR_PROFILE. '"  rel="stylesheet" type="text/css" />';
        }
    }

    if(!(strpos($viewuri,'admin/hr_profile/job_position_view_edit') === false) || !(strpos($viewuri,'admin/hr_profile/job_positions') === false)|| !(strpos($viewuri,'admin/hr_profile/reception_staff') === false)|| !(strpos($viewuri,'admin/hr_profile/training') === false)){
        echo '<link href="' . module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/css/job/job_position_view_edit.css') . '?v=' . VERSION_HR_PROFILE. '"  rel="stylesheet" type="text/css" />';
    }

    if(!(strpos($viewuri,'admin/hr_profile/member') === false) || !(strpos($viewuri,'admin/hr_profile/new_member') === false)|| !(strpos($viewuri,'admin/hr_profile/staff_infor') === false)){
        if(!(strpos($viewuri,'profile') === false)){
            echo '<link href="' . module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/css/hr_record/includes/profile.css') . '?v=' . VERSION_HR_PROFILE. '"  rel="stylesheet" type="text/css" />';
        }
    }

    if(!(strpos($viewuri,'admin/hr_profile/import_job_p') === false) || !(strpos($viewuri,'admin/hr_profile/import_xlsx_dependent_person') === false) || !(strpos($viewuri,'admin/hr_profile/importxlsx') === false)){
        echo '<link href="' . module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/css/box_loading/box_loading.css') . '?v=' . VERSION_HR_PROFILE. '"  rel="stylesheet" type="text/css" />';
    }

    if(!(strpos($viewuri,'admin/hr_profile/contracts') === false) || !(strpos($viewuri,'admin/hr_profile/staff_infor') === false)){
        echo '<link href="' . module_dir_url(HR_PROFILE_MODULE_NAME,'assets/plugins/ComboTree/style.css') .'?v=' . VERSION_HR_PROFILE. '"  rel="stylesheet" type="text/css" />';
        echo '<link href="' . module_dir_url(HR_PROFILE_MODULE_NAME,'assets/css/ribbons.css') .'?v=' . VERSION_HR_PROFILE. '"  rel="stylesheet" type="text/css" />';
    }

    if( !(strpos($viewuri,'admin/hr_profile/staff_infor') === false)){
        echo '<link href="' . module_dir_url(HR_PROFILE_MODULE_NAME,'assets/css/hr_record/hr_record.css') .'?v=' . VERSION_HR_PROFILE. '"  rel="stylesheet" type="text/css" />';
    }

    if (!(strpos($viewuri, '/admin/hr_profile/contract') === false)) {
        echo '<link href="' . module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/plugins/handsontable/handsontable.full.min.css') . '"  rel="stylesheet" type="text/css" />';
        echo '<link href="' . module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/plugins/handsontable/chosen.css') . '"  rel="stylesheet" type="text/css" />';
        echo '<script src="' . module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/plugins/handsontable/handsontable.full.min.js') . '"></script>';
    }

    if (!(strpos($viewuri, '/admin/hr_profile/dashboard') === false)) {
        echo '<link href="' . module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/css/dashboard/dashboard.css') . '?v=' . VERSION_HR_PROFILE. '"  rel="stylesheet" type="text/css" />';
    }


    if (!(strpos($viewuri, '/admin/hr_profile/setting') === false)) {
        echo '<link href="' . module_dir_url(HR_PROFILE_MODULE_NAME, 'assets/css/setting/contract_template.css') . '?v=' . VERSION_HR_PROFILE. '"  rel="stylesheet" type="text/css" />';

    }

}



/**
 * hr profile permissions
 */
function hr_profile_permissions()
{

    $capabilities = [];
    $capabilities_2 = [];
    $capabilities_3 = [];
    $dashboard = [];

    $capabilities['capabilities'] = [
        'view'   => _l('permission_view') . '(' . _l('permission_global') . ')',
        'create' => _l('permission_create'),
        'edit'   => _l('permission_edit'),
        'delete' => _l('permission_delete'),
    ];

    $capabilities_2['capabilities'] = [
        // 'view_own'   => _l('permission_view'),
        'view'   => _l('permission_view') . '(' . _l('permission_global') . ')',
        'create' => _l('permission_create'),
        'edit'   => _l('permission_edit'),
        'delete' => _l('permission_delete'),
    ];

    $capabilities_3['capabilities'] = [
        'view_own'   => _l('permission_view_own'),
        'view'   => _l('permission_view') . '(' . _l('permission_global') . ')',
        'create' => _l('permission_create'),
        'edit'   => _l('permission_edit'),
        'delete' => _l('permission_delete'),
    ];

    $dashboard['capabilities'] = [
        'view'   => _l('permission_view') . '(' . _l('permission_global') . ')',

    ];

    //Dashboard
    register_staff_capabilities('hrm_dashboard', $dashboard, _l('HR_dashboard'));
    //Orgranization
    register_staff_capabilities('staffmanage_orgchart', $capabilities_3, _l('HR_organizational_chart'));
    //Onboarding Process
    register_staff_capabilities('hrm_reception_staff', $capabilities_3, _l('HR_reception_staff'));
    //Hr Profile
    register_staff_capabilities('hrm_hr_records', $capabilities_3, _l('hr_hr_records'));
    //Job Description
    register_staff_capabilities('staffmanage_job_position', $capabilities_3, _l('HR_job_escription'));
    //Training
    register_staff_capabilities('staffmanage_training', $capabilities_3, _l('HR_training'));
    //Q&A
    register_staff_capabilities('hr_manage_q_a', $capabilities_2, _l('HR_q&a'));
    //Contracts
    register_staff_capabilities('hrm_contract', $capabilities_3, _l('HR_contract'));
    //Dependent Persons
    register_staff_capabilities('hrm_dependent_person', $capabilities_3, _l('HR_dependent_persons'));
    //Resignation procedures
    register_staff_capabilities('hrm_procedures_for_quitting_work', $capabilities_3, _l('HR_resignation_procedures'));
    //Reports
    register_staff_capabilities('hrm_report', $dashboard, _l('HR_report'));
    //Settings
    register_staff_capabilities('hrm_setting', $capabilities, _l('HR_setting'));
    //hr_staff_profile
    register_staff_capabilities('profile', $capabilities, _l('profile'));
    //contract
    register_staff_capabilities('contract', $capabilities, _l('contract'));
    //dependent_person
    register_staff_capabilities('dependent_person', $capabilities, _l('dependent_person'));
    //hr_training
    register_staff_capabilities('training', $capabilities, _l('training'));
    //hr_attach
    register_staff_capabilities('attach', $capabilities, _l('attach'));
    //hr_immigration
    register_staff_capabilities('immigration', $capabilities, _l('immigration'));
    //hr_document
    register_staff_capabilities('document', $capabilities, _l('document'));
    //hr_qualification
    register_staff_capabilities('qualification', $capabilities, _l('qualification'));
    //hr_work_experience
    register_staff_capabilities('work_experience', $capabilities, _l('work_experience'));
    //hr_emergency_contacts
    register_staff_capabilities('emergency_contacts', $capabilities, _l('emergency_contacts'));
    //hr_bank_account
    register_staff_capabilities('bank_account', $capabilities_2, _l('bank_account'));



    //hr_update_salary
    register_staff_capabilities('update_salary', $capabilities_2, _l('update_salary'));
//hr_allowances
    register_staff_capabilities('allowances', $capabilities_2, _l('allowances'));
//hr_commissions
    register_staff_capabilities('commissions', $capabilities_2, _l('commissions'));
//hr_loan
    register_staff_capabilities('loan', $capabilities_2, _l('loan'));
//hr_statutory_deductions
    register_staff_capabilities('statutory_deductions', $capabilities_2, _l('statutory_deductions'));
//hr_other_payments
    register_staff_capabilities('other_payments', $capabilities_2, _l('other_payments'));
//hr_overtime
    register_staff_capabilities('overtime', $capabilities_2, _l('overtime'));

}


/**
 * render my profile icon
 * @return [type]
 */
function render_my_profile_icon(){
    $CI = &get_instance();
    if(!hr_profile_check_hide_menu()){
        echo '<li class="dropdown">
			<a href="' . admin_url('hr_profile/member/' . get_staff_user_id()) . '" class="check_in_out_timesheet" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="'._l('hr_my_profile').'"><i class="fa fa-address-card"></i>
			</a>' ;
        echo '</li>';
    }
}

/**
 * hr contract register other merge fields
 * @param  [type] $for
 * @return [type]
 */
function hr_contract_register_other_merge_fields($for)
{
    $for[] = 'hr_contract';

    return $for;
}

function hr_init_hrmApp(){
    $CI = &get_instance();
    $CI->load->library(HR_PROFILE_MODULE_NAME . '/' . 'hrmApp');
}


function hr_profile_appint(){
    $CI = & get_instance();
    require_once 'libraries/gtsslib.php';
    $hr_profile_api = new HRProfileLic();
    $hr_profile_gtssres = $hr_profile_api->verify_license(true);
    if(!$hr_profile_gtssres || ($hr_profile_gtssres && isset($hr_profile_gtssres['status']) && !$hr_profile_gtssres['status'])){
        $CI->app_modules->deactivate(HR_PROFILE_MODULE_NAME);
        set_alert('danger', "One of your modules failed its verification and got deactivated. Please reactivate or contact support.");
        redirect(admin_url('modules'));
    }
}

function hr_profile_preactivate($module_name){

}

function hr_profile_predeactivate($module_name){
    if ($module_name['system_name'] == HR_PROFILE_MODULE_NAME) {
        require_once 'libraries/gtsslib.php';
        $hr_profile_api = new HRProfileLic();
        $hr_profile_api->deactivate_license();
    }
}
function create_new_type_of_leave() {
  $CI = &get_instance();
  $CI->db->select('deserving_in_years, is_notification');
  $results = $CI->db->get(db_prefix().'type_of_leave')->result_array();

  foreach ($results as $row) {
      $deserving_in_years = $row['deserving_in_years'];
      $is_notification = $row['is_notification'];

      if ($deserving_in_years > 0 && is_null($is_notification)) {
          $CI->db->set('is_notification', 1)->update(db_prefix().'type_of_leave'); 
          $assignees = $CI->staff_model->get();

          foreach ($assignees as $member) {
              $notified = add_notification([
                  'description' => 'new_type_of_leave_created',
                  'touserid' => $member['staffid'],
                  'fromcompany' => 1,
                  'fromuserid' => null,
                  'link' => 'hr_profile/requisition_manage?tab=type_of_leave',
              ]);
          }
      }
  }
}
create_new_type_of_leave();

function checkContractExpiry() {
  $CI = &get_instance();
  $CI->db->select('id, isexpirynotified, datestart');
  $results = $CI->db->get(db_prefix().'hr_contracts')->result_array();

  foreach ($results as $result) {
      $staffId = $result['id'];
      $is_notification = $result['isexpirynotified'];
      $dateStart = new DateTime($result['datestart']);
      $currentDate = new DateTime();
      $interval = $dateStart->diff($currentDate);
      // Check if the notification has not been sent yet
      if ($is_notification == 0 && $interval -> y > 5) {
          // Update only the specific contract to mark it as notified
          $CI->db->set('isexpirynotified', 1)
                  ->update(db_prefix().'hr_contracts');
                  // $assignees = $CI->staff_model->get();

          // Send notification to staff
          $staffNotification = add_notification([
              'description' => 'A reminder to take a five-year vacation from your work with us',
              'touserid' => $staffId,
              'fromcompany' => 1,
              'fromuserid' => null,
              'link' => 'hr_profile/core_hr/vacations/manage',
          ]);
      }
  }
}

// Call the function to check contract expiry
checkContractExpiry();


function immigration_reminders()
{
    $CI = &get_instance();
    $reminder_before = get_option('hr_immigration_reminder_notification_before');

    // INSERT INTO `tbloptions` (`id`, `name`, `value`, `autoload`) VALUES (NULL, 'hr_document_reminder_notification_before', '3', '1');

    $CI->db->where('date_expiry IS NOT NULL');
    $CI->db->where('deadline_notified', 0);
    // $CI->db->where('is_notification', 1);

    $documents = $CI->db->get(db_prefix() . 'hr_immigration')->result_array();

    $now = new DateTime(date('Y-m-d'));

    $notifiedUsers = [];
    foreach ($documents as $document) {
        if (date('Y-m-d', strtotime($document['date_expiry'])) >= date('Y-m-d')) {
            $end_date = new DateTime($document['date_expiry']);
            $diff = $end_date->diff($now)->format('%a');
            // Check if difference between start date and date_expiry is the same like the reminder before
            // In this case reminder wont be sent becuase the document it too short
            $end_date = strtotime($document['date_expiry']);
            $start_and_end_date_diff = $end_date;
            $start_and_end_date_diff = floor($end_date / (60 * 60 * 24));

            if (date('Y-m-d', strtotime($document['eligible_review_date'])) == date('Y-m-d')) {
                $CI->db->where('admin', 1);
                $assignees = $CI->staff_model->get();

                foreach ($assignees as $member) {
                    $row = $CI->db->get(db_prefix() . 'staff')->row();
                    if ($row) {
                        $notified = add_notification([
                            'description' => 'not_document_deadline_reminder',
                            'touserid' => $member['staffid'],
                            'fromcompany' => 1,
                            'fromuserid' => null,
                            'link' => 'hr_profile/general/' . $document['staff_id'] . '?group=immigration',

                        ]);

                        if ($notified) {
                            array_push($notifiedUsers, $member['staffid']);
                        }

                        send_mail_template('document_deadline_reminder_to_staff', $row->email, $member['staffid'], $document['id']);


                        $CI->db->where('id', $document['id']);
                        $CI->db->update(db_prefix() . 'hr_immigration', [
                            'deadline_notified' => 1,
                        ]);
                    }
                }
            }
        }
    }
  }
    function official_document_reminders()
    {
        $CI = &get_instance();
        $reminder_before = get_option('hr_official_document_reminder_notification_before');

        // INSERT INTO `tbloptions` (`id`, `name`, `value`, `autoload`) VALUES (NULL, 'hr_document_reminder_notification_before', '3', '1');

        $CI->db->where('date_expiry IS NOT NULL');
        $CI->db->where('deadline_notified', 0);
        $CI->db->where('is_notification', 1);

        $documents = $CI->db->get(db_prefix() . 'hr_official_documents')->result_array();

        $now = new DateTime(date('Y-m-d'));

        $notifiedUsers = [];
        foreach ($documents as $document) {
            if (date('Y-m-d', strtotime($document['date_expiry'])) >= date('Y-m-d')) {
                $end_date = new DateTime($document['date_expiry']);
                $diff = $end_date->diff($now)->format('%a');
                // Check if difference between start date and date_expiry is the same like the reminder before
                // In this case reminder wont be sent becuase the document it too short
                $end_date = strtotime($document['date_expiry']);
                $start_and_end_date_diff = $end_date;
                $start_and_end_date_diff = floor($end_date / (60 * 60 * 24));

                if ($diff <= $reminder_before) {
                    $CI->db->where('admin', 1);
                    $assignees = $CI->staff_model->get();

                    foreach ($assignees as $member) {
                        $row = $CI->db->get(db_prefix() . 'staff')->row();
                        if ($row) {
                            $notified = add_notification([
                                'description' => ' official_document_reminders',
                                'touserid' => $member['staffid'],
                                'fromcompany' => 1,
                                'fromuserid' => null,
                                'link' => 'hr_profile/organization/officail_documents',

                            ]);

                            if ($notified) {
                                array_push($notifiedUsers, $member['staffid']);
                            }

                            // send_mail_template('document_deadline_reminder_to_staff', $row->email, $member['staffid'], $document['id']);


                            $CI->db->where('id', $document['id']);
                            $CI->db->update(db_prefix() . 'hr_official_documents', [
                                'deadline_notified' => 1,
                            ]);
                        }
                    }
                }
            }
        }

        pusher_trigger_notification($notifiedUsers);


    }

    function document_reminders()
    {
        $CI = &get_instance();
        $reminder_before = get_option('hr_document_reminder_notification_before');

        // INSERT INTO `tbloptions` (`id`, `name`, `value`, `autoload`) VALUES (NULL, 'hr_document_reminder_notification_before', '3', '1');

        $CI->db->where('date_expiry IS NOT NULL');
        $CI->db->where('deadline_notified', 0);
        $CI->db->where('is_notification', 1);

        $documents = $CI->db->get(db_prefix() . 'hr_documents')->result_array();

        $now = new DateTime(date('Y-m-d'));

        $notifiedUsers = [];
        foreach ($documents as $document) {
            if (date('Y-m-d', strtotime($document['date_expiry'])) >= date('Y-m-d')) {
                $end_date = new DateTime($document['date_expiry']);
                $diff = $end_date->diff($now)->format('%a');
                // Check if difference between start date and date_expiry is the same like the reminder before
                // In this case reminder wont be sent becuase the document it too short
                $end_date = strtotime($document['date_expiry']);
                $start_and_end_date_diff = $end_date;
                $start_and_end_date_diff = floor($end_date / (60 * 60 * 24));

                if ($diff <= $reminder_before) {
                    $CI->db->where('admin', 1);
                    $assignees = $CI->staff_model->get();

                    foreach ($assignees as $member) {
                        $row = $CI->db->get(db_prefix() . 'staff')->row();
                        if ($row) {
                            $notified = add_notification([
                                'description' => 'document_reminders',
                                'touserid' => $member['staffid'],
                                'fromcompany' => 1,
                                'fromuserid' => null,
                                'link' => 'hr_profile/member/' . $document['staff_id'] . '?group=document',

                            ]);

                            if ($notified) {
                                array_push($notifiedUsers, $member['staffid']);
                            }

                            //send_mail_template('document_deadline_reminder_to_staff', $row->email, $member['staffid'], $document['id']);


                            $CI->db->where('id', $document['id']);
                            $CI->db->update(db_prefix() . 'hr_documents', [
                                'deadline_notified' => 1,
                            ]);
                        }
                    }
                }
            }
        }

        pusher_trigger_notification($notifiedUsers);

    }

