<?php

defined('BASEPATH') or exit('No direct script access allowed');
define('HR_MODULE_PATH', __DIR__ );
define('HR_MODULE_NAME', 'hr');


/*
Author: Babil Team
Module Name: hr_name
Description: hr_desc
Version: 3.0.1
Requires at least: 2.3.*
Author URI: #

*/


register_activation_hook('hr', 'hr_module_activation_hook');
hooks()->add_action('admin_init', 'hr_init_hrmApp');
hooks()->add_action('app_admin_head', 'hr_add_head_components');
hooks()->add_action('app_admin_footer', 'hr_add_footer_components');

hooks()->add_action('after_cron_settings_last_tab', 'add_staff_hr_reminder_tab');
hooks()->add_action('after_cron_settings_last_tab_content', 'add_staff_hr_reminder_tab_content');

hooks()->add_action('after_cron_settings_last_tab', 'add_immigration_reminder_tab');
hooks()->add_action('after_cron_settings_last_tab_content', 'add_immigration_reminder_tab_content');

hooks()->add_action('after_cron_settings_last_tab', 'add_official_document_reminder_tab');
hooks()->add_action('after_cron_settings_last_tab_content', 'add_official_document_reminder_tab_content');


hooks()->add_action('after_cron_settings_last_tab', 'add_insurance_reminder_tab');
hooks()->add_action('after_cron_settings_last_tab_content', 'add_insurance_reminder_tab_content');
hooks()->add_action('after_cron_settings_last_tab', 'add_insurance_book_number_reminder_tab');
hooks()->add_action('after_cron_settings_last_tab_content', 'add_insurance_book_number_reminder_tab_content');
hooks()->add_action('after_cron_run', 'document_reminders');
hooks()->add_action('after_cron_run', 'insurance_reminders');
hooks()->add_action('after_cron_run', 'insurance_book_number_reminders');
hooks()->add_action('after_cron_run', 'immigration_reminders');
hooks()->add_action('after_cron_run', 'official_document_reminders');
hooks()->add_action('after_email_templates', 'add_hr_email_templates');
register_merge_fields('hr/merge_fields/termination_staff_merge_fields');
register_merge_fields('hr/merge_fields/resignation_staff_merge_fields');
register_merge_fields('hr/merge_fields/award_staff_merge_fields');
register_merge_fields('hr/merge_fields/complaint_staff_merge_fields');
register_merge_fields('hr/merge_fields/warning_staff_merge_fields');
register_merge_fields('hr/merge_fields/promotion_staff_merge_fields');
register_merge_fields('hr/merge_fields/transfer_staff_merge_fields');
register_merge_fields('hr/merge_fields/travel_staff_merge_fields');

$CI = & get_instance();
$CI->load->helper(HR_MODULE_NAME . '/hr');
// hooks()->add_action('after_render_single_setup_menu', 'hr_menu_items');

/**
 * Register language files, must be registered if the module is using languages
 */
register_language_files(HR_MODULE_NAME, [HR_MODULE_NAME]);

function add_hr_email_templates(){
    $CI = &get_instance();
    $CI->load->view('hr/email/email_templates');
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

function add_insurance_reminder_tab(){
    echo '
    <li role="presentation">
    <a href="#insurance" aria-control="insurance" role="tab" data-toggle="tab">'._l('insurance_history').'</a>
    </li>';
}

function add_insurance_reminder_tab_content(){
    echo '<div role="tabpanel" class="tab-pane" id="insurance">
   <i class="fa fa-question-circle pull-left" data-toggle="tooltip" data-title="'. _l('hr_insurance_reminder_notification_before_help').'"></i>
   '.render_input('settings[hr_insurance_reminder_notification_before]','hr_insurance_reminder_notification_before',get_option('hr_insurance_reminder_notification_before'),'number').'
 </div>  ';
}

function add_insurance_book_number_reminder_tab(){
    echo '
    <li role="presentation">
    <a href="#insurance_book_number" aria-control="insurance_book_number" role="tab" data-toggle="tab">'._l('insurance_book_number').'</a>
    </li>';
}


function add_insurance_book_number_reminder_tab_content(){
    echo '<div role="tabpanel" class="tab-pane" id="insurance_book_number">
   <i class="fa fa-question-circle pull-left" data-toggle="tooltip" data-title="'. _l('hr_insurance_book_number_reminder_notification_before_help').'"></i>
   '.render_input('settings[hr_insurance_book_number_reminder_notification_before]','hr_insurance_book_number_reminder_notification_before',get_option('hr_insurance_book_number_reminder_notification_before'),'number').'
 </div>  ';
}

function insurance_reminders()
{
    $CI = & get_instance();
    $reminder_before = get_option('hr_insurance_reminder_notification_before');


    // INSERT INTO `tbloptions` (`id`, `name`, `value`, `autoload`) VALUES (NULL, 'hr_document_reminder_notification_before', '3', '1');

    $CI->db->where('end_date IS NOT NULL');
    $CI->db->where('deadline_notified', 0);
    // $CI->db->where('is_notification', 1);

    $entries = $CI->db->get(db_prefix() . 'staff_insurance')->result_array();

    $now   = new DateTime(date('Y-m-d'));

    $notifiedUsers = [];
    foreach ($entries as $entrie) {
        if (date('Y-m-d', strtotime($entrie['end_date'])) <= date('Y-m-d')) {
            $end_date = new DateTime($entrie['end_date']);
            $diff    = $end_date->diff($now)->format('%a');
            // Check if difference between start date and end_date is the same like the reminder before
            // In this case reminder wont be sent becuase the document it too short
            $end_date                 = strtotime($entrie['end_date']);
            $start_and_end_date_diff = $end_date;
            $start_and_end_date_diff = floor($end_date / (60 * 60 * 24));


            if ($diff <= $reminder_before) {
                $CI->db->where('admin', 1);
                $assignees = $CI->staff_model->get();

                foreach ($assignees as $member) {
                    $row = $CI->db->get(db_prefix() . 'staff')->row();
                    if ($row) {
                        $notified = add_notification([
                            'description'     => 'not_insurance_deadline_reminder',
                            'touserid'        => $member['staffid'],
                            'fromcompany'     => 1,
                            'fromuserid'      => null,
                            'link'            => 'hr/insurance/'.$entrie['insurance_id'],

                        ]);

                        if ($notified) {
                            array_push($notifiedUsers, $member['staffid']);
                        }

                        // send_mail_template('document_deadline_reminder_to_staff', $row->email, $member['staffid'], $entrie['insurance_id']);


                        $CI->db->where('insurance_id', $entrie['insurance_id']);
                        $CI->db->update(db_prefix() . 'staff_insurance', [
                            'deadline_notified' => 1,
                        ]);
                    }
                }
            }
        }
    }

    pusher_trigger_notification($notifiedUsers);

}

function insurance_book_number_reminders()
{
    $CI = & get_instance();
    $reminder_before = get_option('hr_insurance_book_number_reminder_notification_before');


    // INSERT INTO `tbloptions` (`id`, `name`, `value`, `autoload`) VALUES (NULL, 'hr_document_reminder_notification_before', '3', '1');

    $CI->db->where('end_date IS NOT NULL');
    $CI->db->where('deadline_notified', 0);
    // $CI->db->where('is_notification', 1);

    $entries = $CI->db->get(db_prefix() . 'insurance_book_nums')->result_array();

    $now   = new DateTime(date('Y-m-d'));

    $notifiedUsers = [];
    foreach ($entries as $entrie) {
        if (date('Y-m-d', strtotime($entrie['end_date'])) <= date('Y-m-d')) {
            $end_date = new DateTime($entrie['end_date']);
            $diff    = $end_date->diff($now)->format('%a');
            // Check if difference between start date and end_date is the same like the reminder before
            // In this case reminder wont be sent becuase the document it too short
            $end_date                 = strtotime($entrie['end_date']);
            $start_and_end_date_diff = $end_date;
            $start_and_end_date_diff = floor($end_date / (60 * 60 * 24));


            if ($diff <= $reminder_before) {
                $CI->db->where('admin', 1);
                $assignees = $CI->staff_model->get();

                foreach ($assignees as $member) {
                    $row = $CI->db->get(db_prefix() . 'staff')->row();
                    if ($row) {
                        $notified = add_notification([
                            'description'     => 'not_insurance_book_number_deadline_reminder',
                            'touserid'        => $member['staffid'],
                            'fromcompany'     => 1,
                            'fromuserid'      => null,
                            'link'            => 'hr/setting?group=insurance_book_number',

                        ]);

                        if ($notified) {
                            array_push($notifiedUsers, $member['staffid']);
                        }

                        // send_mail_template('document_deadline_reminder_to_staff', $row->email, $member['staffid'], $entrie['insurance_id']);


                        $CI->db->where('id', $entrie['id']);
                        $CI->db->update(db_prefix() . 'insurance_book_nums', [
                            'deadline_notified' => 1,
                        ]);
                    }
                }
            }
        }
    }

    pusher_trigger_notification($notifiedUsers);

}

function immigration_reminders()
{
    $CI = & get_instance();
    $reminder_before = get_option('hr_immigration_reminder_notification_before');

    // INSERT INTO `tbloptions` (`id`, `name`, `value`, `autoload`) VALUES (NULL, 'hr_document_reminder_notification_before', '3', '1');

    $CI->db->where('date_expiry IS NOT NULL');
    $CI->db->where('deadline_notified', 0);
    // $CI->db->where('is_notification', 1);

    $documents = $CI->db->get(db_prefix() . 'hr_immigration')->result_array();

    $now   = new DateTime(date('Y-m-d'));

    $notifiedUsers = [];
    foreach ($documents as $document) {
        if (date('Y-m-d', strtotime($document['date_expiry'])) >= date('Y-m-d')) {
            $end_date = new DateTime($document['date_expiry']);
            $diff    = $end_date->diff($now)->format('%a');
            // Check if difference between start date and date_expiry is the same like the reminder before
            // In this case reminder wont be sent becuase the document it too short
            $end_date                 = strtotime($document['date_expiry']);
            $start_and_end_date_diff = $end_date;
            $start_and_end_date_diff = floor($end_date / (60 * 60 * 24));

            if (date('Y-m-d', strtotime($document['eligible_review_date'])) == date('Y-m-d')){
                $CI->db->where('admin', 1);
                $assignees = $CI->staff_model->get();

                foreach ($assignees as $member) {
                    $row = $CI->db->get(db_prefix() . 'staff')->row();
                    if ($row) {
                        $notified = add_notification([
                            'description'     => 'not_document_deadline_reminder',
                            'touserid'        => $member['staffid'],
                            'fromcompany'     => 1,
                            'fromuserid'      => null,
                            'link'            => 'hr/general/general/' . $document['staff_id'] . '?group=immigration',

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

    pusher_trigger_notification($notifiedUsers);

}

function official_document_reminders()
{
    $CI = & get_instance();
    $reminder_before = get_option('hr_official_document_reminder_notification_before');

    // INSERT INTO `tbloptions` (`id`, `name`, `value`, `autoload`) VALUES (NULL, 'hr_document_reminder_notification_before', '3', '1');

    $CI->db->where('date_expiry IS NOT NULL');
    $CI->db->where('deadline_notified', 0);
    $CI->db->where('is_notification', 1);

    $documents = $CI->db->get(db_prefix() . 'hr_official_documents')->result_array();

    $now   = new DateTime(date('Y-m-d'));

    $notifiedUsers = [];
    foreach ($documents as $document) {
        if (date('Y-m-d', strtotime($document['date_expiry'])) >= date('Y-m-d')) {
            $end_date = new DateTime($document['date_expiry']);
            $diff    = $end_date->diff($now)->format('%a');
            // Check if difference between start date and date_expiry is the same like the reminder before
            // In this case reminder wont be sent becuase the document it too short
            $end_date                 = strtotime($document['date_expiry']);
            $start_and_end_date_diff = $end_date;
            $start_and_end_date_diff = floor($end_date / (60 * 60 * 24));

            if ($diff <= $reminder_before) {
                $CI->db->where('admin', 1);
                $assignees = $CI->staff_model->get();

                foreach ($assignees as $member) {
                    $row = $CI->db->get(db_prefix() . 'staff')->row();
                    if ($row) {
                        $notified = add_notification([
                            'description'     => 'not_document_deadline_reminder',
                            'touserid'        => $member['staffid'],
                            'fromcompany'     => 1,
                            'fromuserid'      => null,
                            'link'            => 'hr/organization/officail_documents',

                        ]);

                        if ($notified) {
                            array_push($notifiedUsers, $member['staffid']);
                        }

                        send_mail_template('document_deadline_reminder_to_staff', $row->email, $member['staffid'], $document['id']);


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
    $CI = & get_instance();
    $reminder_before = get_option('hr_document_reminder_notification_before');

    // INSERT INTO `tbloptions` (`id`, `name`, `value`, `autoload`) VALUES (NULL, 'hr_document_reminder_notification_before', '3', '1');

    $CI->db->where('date_expiry IS NOT NULL');
    $CI->db->where('deadline_notified', 0);
    $CI->db->where('is_notification', 1);

    $documents = $CI->db->get(db_prefix() . 'hr_documents')->result_array();

    $now   = new DateTime(date('Y-m-d'));

    $notifiedUsers = [];
    foreach ($documents as $document) {
        if (date('Y-m-d', strtotime($document['date_expiry'])) >= date('Y-m-d')) {
            $end_date = new DateTime($document['date_expiry']);
            $diff    = $end_date->diff($now)->format('%a');
            // Check if difference between start date and date_expiry is the same like the reminder before
            // In this case reminder wont be sent becuase the document it too short
            $end_date                 = strtotime($document['date_expiry']);
            $start_and_end_date_diff = $end_date;
            $start_and_end_date_diff = floor($end_date / (60 * 60 * 24));

            if ($diff <= $reminder_before) {
                $CI->db->where('admin', 1);
                $assignees = $CI->staff_model->get();

                foreach ($assignees as $member) {
                    $row = $CI->db->get(db_prefix() . 'staff')->row();
                    if ($row) {
                        $notified = add_notification([
                            'description'     => 'not_document_deadline_reminder',
                            'touserid'        => $member['staffid'],
                            'fromcompany'     => 1,
                            'fromuserid'      => null,
                            'link'            => 'hr/general/general/' . $document['staff_id'] . '?group=document',

                        ]);

                        if ($notified) {
                            array_push($notifiedUsers, $member['staffid']);
                        }

                        send_mail_template('document_deadline_reminder_to_staff', $row->email, $member['staffid'], $document['id']);


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
    if (accepted_pages(['allowance_type'])) {
        echo '<script src="'.module_dir_url('hr', 'assets/js/allowancetype.js').'"></script>';
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

    $viewGlobalName = _l('permission_view') . '(' . _l('permission_global') . ')';

    $allPermissionsArray = [
        'view_own' => _l('permission_view_own'),
        'view'     => $viewGlobalName,
        'create'   => _l('permission_create'),
        'edit'     => _l('permission_edit'),
        'delete'   => _l('permission_delete'),
    ];
    $withoutViewOwnPermissionsArray = [
        'view'   => $viewGlobalName,
        'create' => _l('permission_create'),
        'edit'   => _l('permission_edit'),
        'delete' => _l('permission_delete'),
    ];

    register_staff_capabilities('hr', ['capabilities' => $allPermissionsArray,], _l('hr'));
    register_staff_capabilities('awards', ['capabilities' => $allPermissionsArray,], _l('awards'));
    register_staff_capabilities('transfers', ['capabilities' => $allPermissionsArray,], _l('transfers'));
    register_staff_capabilities('resignations', ['capabilities' => $allPermissionsArray,], _l('resignations'));
    register_staff_capabilities('travels', ['capabilities' => $allPermissionsArray,], _l('travels'));
    register_staff_capabilities('promotions', ['capabilities' => $allPermissionsArray,], _l('promotions'));
    register_staff_capabilities('complaints', ['capabilities' => $allPermissionsArray,], _l('complaints'));
    register_staff_capabilities('warnings', ['capabilities' => $allPermissionsArray,], _l('warnings'));
    register_staff_capabilities('insurrance', ['capabilities' => $allPermissionsArray,], _l('insurrance'));
    register_staff_capabilities('hr_contracts', ['capabilities' => $allPermissionsArray,], _l('hr_contracts'));
    register_staff_capabilities('hr_settings', ['capabilities' => $withoutViewOwnPermissionsArray,], _l('hr_settings'));
    register_staff_capabilities('payroll', ['capabilities' => $allPermissionsArray,], _l('payroll'));
    register_staff_capabilities('expired_documents', ['capabilities' => $allPermissionsArray,], _l('expired_documents'));

    if (has_permission('hr', '', 'view_own') || has_permission('hr', '', 'view')) {
        $CI->app_menu->add_setup_menu_item('hr', [
            'name' => _l("hr"), // The name if the item
            'href' => '#', // URL of the item
            'position' => 10, // The menu position, see below for default positions.
            // 'icon'     => 'fa fa-file-text-o', // Font awesome icon
        ]);
    }
    if (has_permission('hr', '', 'view')){
        $CI->app_menu->add_setup_children_item('hr', [
            'slug'     => 'dashboard',
            'name'     => _l('dashboard'),
            'href'     => admin_url('hr'),
            'position' => 5,
        ]);
    }
    if (has_permission('hr', '', 'view_own') || has_permission('hr', '', 'view')){
        $CI->app_menu->add_setup_children_item('hr', [
            'slug'     => 'staff',
            'name'     => _l('staff'),
            'href'     => admin_url('hr/general/staff'),
            'position' => 5,
        ]);
    }

    if (has_permission('expired_documents', '', 'view_own') || has_permission('expired_documents', '', 'view')){
        $CI->app_menu->add_setup_children_item('hr', [
            'slug'     => 'expired_documents',
            'name'     => _l('expired_documents'),
            'href'     => admin_url('hr/general/expired_documents'),
            'position' => 10,
        ]);
    }

    if (has_permission('hr_contracts', '', 'view_own') || has_permission('hr_contracts', '', 'view')){
        $CI->app_menu->add_setup_children_item('hr', [
            'slug'     => 'staff_contract',
            'name'     => _l('staff_contract'),
            'href'     => admin_url('hr/contracts'),
            'position' => 15,
        ]);
    }
    if (has_permission('insurrance', '', 'view_own') || has_permission('insurrance', '', 'view')){
        $CI->app_menu->add_setup_children_item('hr', [
            'slug'     => 'insurrance',
            'name'     => _l('insurrance'),
            'href'     => admin_url('hr/insurances'),
            'position' => 20,
        ]);
    }
    if (has_permission('hr_settings', '', 'view')){
        $CI->app_menu->add_setup_children_item('hr', [
            'slug'     => 'constants',
            'name'     => _l('constants'),
            'href'     => admin_url('hr/setting'),
            'position' => 25,
        ]);
    }
    if (has_permission('hr_settings', '', 'view')){
        $CI->app_menu->add_setup_children_item('hr', [
            'slug'     => 'global_hr_setting',
            'name'     => _l('global_hr_setting'),
            'href'     => admin_url('hr/setting/global_hr_setting'),
            'position' => 30,
        ]);
    }
    if (has_permission('hr', '', 'view_own') || has_permission('hr', '', 'view')){
        $CI->app_menu->add_setup_children_item('hr', [
            'slug'     => 'payroll',
            'name'     => _l('payroll'),
            'href'     => admin_url('hr/payroll'),
            'position' => 35,
        ]);
    }
    if (has_permission('hr', '', 'view_own') || has_permission('hr', '', 'view')){
        $CI->app_menu->add_setup_children_item('hr', [
            'slug'     => 'payment_history',
            'name'     => _l('payment_history'),
            'href'     => admin_url('hr/payroll/payment_history'),
            'position' => 40,
        ]);
    }
    if (has_permission('hr', '', 'view_own') || has_permission('hr', '', 'view')){
        $CI->app_menu->add_setup_children_item('hr', [
            'slug'     => 'indicators',
            'name'     => _l('indicators'),
            'href'     => admin_url('hr/performance/indicators'),
            'position' => 45,
        ]);
    }
    if (has_permission('hr', '', 'view_own') || has_permission('hr', '', 'view')){
        $CI->app_menu->add_setup_children_item('hr', [
            'slug'     => 'appraisals',
            'name'     => _l('appraisals'),
            'href'     => admin_url('hr/performance/appraisals'),
            'position' => 50,
        ]);
    }
    if (has_permission('hr', '', 'view_own') || has_permission('hr', '', 'view')){
        $CI->app_menu->add_setup_children_item('hr', [
            'slug'     => 'official_documents',
            'name'     => _l('official_documents'),
            'href'     => admin_url('hr/organization/officail_documents'),
            'position' => 55,
        ]);
    }
    if (has_permission('hr', '', 'view_own') || has_permission('hr', '', 'view')){
        $CI->app_menu->add_setup_children_item('hr', [
            'slug'     => 'departments',
            'name'     => _l('departments'),
            'href'     => admin_url('departments'),
            'position' => 60,
        ]);
    }
    if (has_permission('hr', '', 'view_own') || has_permission('hr', '', 'view') and is_active_sub_department()){
        $CI->app_menu->add_setup_children_item('hr', [
            'slug'     => 'sub_department',
            'name'     => _l('sub_department'),
            'href'     => admin_url('hr/organization/sub_department'),
            'position' => 65,
        ]);
    }
    if (has_permission('hr', '', 'view_own') || has_permission('hr', '', 'view')){
        $CI->app_menu->add_setup_children_item('hr', [
            'slug'     => 'designation',
            'name'     => _l('designation'),
            'href'     => admin_url('hr/organization/designation'),
            'position' => 70,
        ]);
    }
    if (has_permission('awards', '', 'view_own') || has_permission('awards', '', 'view')){
        $CI->app_menu->add_setup_children_item('hr', [
            'slug'     => 'awards',
            'name'     => _l('awards'),
            'href'     => admin_url('hr/core_hr/awards'),
            'position' => 75,
        ]);
    }
    if (has_permission('hr', '', 'view_own') || has_permission('hr', '', 'view')){
        $CI->app_menu->add_setup_children_item('hr', [
            'slug'     => 'terminations',
            'name'     => _l('terminations'),
            'href'     => admin_url('hr/core_hr/terminations'),
            'position' => 80,
        ]);
    }
    if (has_permission('warnings', '', 'view_own') || has_permission('warnings', '', 'view')){
        $CI->app_menu->add_setup_children_item('hr', [
            'slug'     => 'warnings',
            'name'     => _l('warnings'),
            'href'     => admin_url('hr/core_hr/warnings'),
            'position' => 85,
        ]);
    }
    if (has_permission('transfers', '', 'view_own') || has_permission('transfers', '', 'view') and is_active_sub_department()){
        $CI->app_menu->add_setup_children_item('hr', [
            'slug'     => 'transfers',
            'name'     => _l('transfers'),
            'href'     => admin_url('hr/core_hr/transfers'),
            'position' => 90,
        ]);
    }
    if (has_permission('complaints', '', 'view_own') || has_permission('complaints', '', 'view')){
        $CI->app_menu->add_setup_children_item('hr', [
            'slug'     => 'complaints',
            'name'     => _l('complaints'),
            'href'     => admin_url('hr/core_hr/complaints'),
            'position' => 95,
        ]);
    }
    if (has_permission('resignations', '', 'view_own') || has_permission('resignations', '', 'view')){
        $CI->app_menu->add_setup_children_item('hr', [
            'slug'     => 'resignations',
            'name'     => _l('resignations'),
            'href'     => admin_url('hr/core_hr/resignations'),
            'position' => 100,
        ]);
    }
    if (has_permission('promotions', '', 'view_own') || has_permission('promotions', '', 'view')){
        $CI->app_menu->add_setup_children_item('hr', [
            'slug'     => 'promotions',
            'name'     => _l('promotions'),
            'href'     => admin_url('hr/core_hr/promotions'),
            'position' => 105,
        ]);
    }
    if (has_permission('travels', '', 'view_own') || has_permission('travels', '', 'view')){
        $CI->app_menu->add_setup_children_item('hr', [
            'slug'     => 'travels',
            'name'     => _l('travels'),
            'href'     => admin_url('hr/core_hr/travels'),
            'position' => 110,
        ]);
    }


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
            echo '<a href="#" aria-expanded="false"> '._l('hr').'<span class="fa arrow-ar"></span></a>';

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
                                    <li><a href="'.admin_url('hr/insurances').'">'._l('insurrance').'</a>
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
