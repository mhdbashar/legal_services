<?php
defined('BASEPATH') or exit('No direct script access allowed');


// add_action('after_render_single_aside_menu', 'my_custom_menu_items');
hooks()->add_action('admin_init', 'my_custom_setup_menu_items');
hooks()->add_action('admin_init', 'app_init_opponent_profile_tabs');

hooks()->add_action('clients_init', 'my_module_clients_area_menu_items');
hooks()->add_action('admin_init', 'my_module_menu_item_collapsible');

function my_module_menu_item_collapsible()
{
    $CI = &get_instance();
    $services = $CI->db->order_by('id', 'ASC')->get_where('my_basic_services', array('is_primary' => 1 , 'show_on_sidebar' => 1, 'is_module' => 0))->result();
    $CI->app_menu->add_sidebar_menu_item('custom-menu-unique-id', [
        'name'     => _l('LegalServices'), // The name if the item
        'collapse' => true, // Indicates that this item will have submitems
        'position' => 30, // The menu position
        'icon'     => 'fa fa-gavel', // Font awesome icon
    ]);
    foreach ($services as $service):
        // The first paremeter is the parent menu ID/Slug
        $CI->app_menu->add_sidebar_children_item('custom-menu-unique-id', [
            'slug'     => $service->id.'/child-to-custom-menu-item', // Required ID/slug UNIQUE for the child menu
            'name'     => $service->name, // The name if the item
            'href'     => admin_url("Service/$service->id"), // URL of the item
        ]);
    endforeach;
}

function my_module_clients_area_menu_items()
{
    // Item for all clients
    /*add_theme_menu_item('unique-item-id', [
        'name'     => 'Custom Clients Area',
        'href'     => site_url('my_module/acme'),
        'position' => 10,
    ]);*/

    // Show menu item only if client is logged in
    $CI = &get_instance();
    $services = $CI->db->order_by('id', 'DESC')->get_where('my_basic_services', array('is_primary' => 1 , 'show_on_sidebar' => 1, 'is_module' => 0))->result();
    $position = 50;
    if (has_contact_permission('projects')) {
        if (is_client_logged_in()) {
            foreach ($services as $service):
            add_theme_menu_item('LegalServices'.$service->id, [
                'name'     => $service->name,
                'href'     => site_url('clients/legals/'.$service->id),
                'position' => $position+5,
            ]);
            endforeach;
        }
    }
}


function my_custom_setup_menu_items()
{
    $CI = &get_instance();

    $CI->app_menu->add_setup_menu_item('0', [
        'name'     => _l("dialog_box_manage"), // The name if the item
        'position' => 0, // The menu position
        'href'     => admin_url('Dialog_boxes'), // URL of the item
    ]);

    $CI->app_menu->add_setup_menu_item('1', [
        'name'     => _l("procuration"), // The name if the item
        'collapse' => true, // Indicates that this item will have submitems
        'position' => 1, // The menu position
        //'icon'     => 'fa fa-briefcase menu-icon', // Font awesome icon
    ]);

    // The first paremeter is the parent menu ID/Slug
    $CI->app_menu->add_setup_children_item('1', [
        'slug'     => 'child-to-custom-menu-item', // Required ID/slug UNIQUE for the child menu
        'name'     => _l("procuration"), // The name if the item
        'href'     => admin_url('procuration/all'), // URL of the item
        'position' => 1, // The menu position
        // 'icon'     => 'fa fa-exclamation', // Font awesome icon
    ]);

    $CI->app_menu->add_setup_children_item('1', [
        'slug'     => 'child-to-custom-menu-item', // Required ID/slug UNIQUE for the child menu
        'name'     => _l("procuration_state"), // The name if the item
        'href'     => admin_url('procuration/state'), // URL of the item
        'position' => 2, // The menu position
    ]);

    $CI->app_menu->add_setup_children_item('1', [
        'slug'     => 'child-to-custom-menu-item', // Required ID/slug UNIQUE for the child menu
        'name'     => _l("procuration_type"), // The name if the item
        'href'     => admin_url('procuration/type'), // URL of the item
        'position' => 3, // The menu position
    ]);

    $CI->app_menu->add_setup_menu_item('2', [
        'name'     => _l("legal_services_settings"), // The name if the item
        'collapse' => true, // Indicates that this item will have submitems
        'position' => 2, // The menu position
        //'icon'     => 'fa fa-user-circle menu-icon', // Font awesome icon
    ]);

    $CI->app_menu->add_setup_children_item('2', [
        'slug'     => 'child-to-custom-menu-item', // Required ID/slug UNIQUE for the child menu
        'name'     => _l("customer_representative"), // The name if the item
        'href'     => admin_url('customer_representative'), // URL of the item
        'position' => 1, // The menu position
    ]);

    $CI->app_menu->add_setup_children_item('2', [
        'slug'     => 'child-to-custom-menu-item', // Required ID/slug UNIQUE for the child menu
        'name'     => _l("Judges"), // The name if the item
        'href'     => admin_url('Judge'), // URL of the item
        'position' => 2, // The menu position

    ]);

    $CI->app_menu->add_setup_children_item('2', [
        'slug'     => 'child-to-custom-menu-item', // Required ID/slug UNIQUE for the child menu
        'name'     => _l("case_status"), // The name if the item
        'href'     => admin_url('Case_status'), // URL of the item
        'position' => 3, // The menu position
        // 'icon'     => 'fa fa-adjust', // Font awesome icon

    ]);

    $CI->app_menu->add_setup_children_item('2', [
        'slug'     => 'child-to-custom-menu-item', // Required ID/slug UNIQUE for the child menu
        'name'     => _l("CourtsManagement"), // The name if the item
        'href'     => admin_url('courts_control'), // URL of the item
        'position' => 4, // The menu position

    ]);

    $CI->app_menu->add_setup_children_item('2', [
        'slug'     => 'child-to-custom-menu-item', // Required ID/slug UNIQUE for the child menu
        'name'     => _l("LegalServiceManage"), // The name if the item
        'href'     => admin_url('ServicesControl'), // URL of the item
        'position' => 5, // The menu position
        // 'icon'     => 'fa fa-adjust', // Font awesome icon

    ]);

    $CI->app_menu->add_setup_children_item('2', [
        'slug'     => 'child-to-custom-menu-item', // Required ID/slug UNIQUE for the child menu
        'name'     => _l("legal_services_phases"), // The name if the item
        'href'     => admin_url('LegalServices/Phases_controller'), // URL of the item
        'position' => 6, // The menu position
        // 'icon'     => 'fa fa-adjust', // Font awesome icon

    ]);

    $CI->app_menu->add_setup_children_item('2', [
        'slug'     => 'child-to-custom-menu-item', // Required ID/slug UNIQUE for the child menu
        'name'     => _l("LService_recycle_bin"), // The name if the item
        'href'     => admin_url('LegalServices/LegalServices_controller/legal_recycle_bin'), // URL of the item
        'position' => 7, // The menu position
        // 'icon'     => 'fa fa-adjust', // Font awesome icon

    ]);


    $CI->app_menu->add_setup_menu_item('3', [
        'name'     => _l("transactions"), // The name if the item
        'collapse' => true, // Indicates that this item will have submitems
        'position' => 3, // The menu position
        //'icon'     => 'fa fa-briefcase menu-icon', // Font awesome icon
    ]);
    $CI->app_menu->add_setup_children_item('3', [
        'slug'     => 'child-to-custom-menu-item', // Required ID/slug UNIQUE for the child menu
        'name'     => _l("incoming"), // The name if the item
        'href'     => admin_url('transactions/incoming_list'), // URL of the item
        'position' => 1, // The menu position
        // 'icon'     => 'fa fa-adjust', // Font awesome icon

    ]);
    $CI->app_menu->add_setup_children_item('3', [
        'slug'     => 'child-to-custom-menu-item', // Required ID/slug UNIQUE for the child menu
        'name'     => _l("outgoing"), // The name if the item
        'href'     => admin_url('transactions/outgoing_list'), // URL of the item
        'position' => 1, // The menu position
        // 'icon'     => 'fa fa-adjust', // Font awesome icon

    ]);
}

function app_init_opponent_profile_tabs()
{
    $client_id = null;

    if ($client = get_client()) {
        $client_id = $client->userid;
    }

    $CI = &get_instance();

    $CI->app_tabs->add_opponent_profile_tab('profile', [
        'name'     => _l('client_add_edit_profile'),
        'icon'     => 'fa fa-user-circle',
        'view'     => 'admin/opponent/groups/profile',
        'position' => 5,
    ]);

    $CI->app_tabs->add_opponent_profile_tab('contacts', [
        'name'     => !is_empty_customer_company($client_id) || empty($client_id) ? _l('customer_contacts') : _l('contact'),
        'icon'     => 'fa fa-users',
        'view'     => 'admin/opponent/groups/contacts',
        'position' => 10,
    ]);

    $CI->app_tabs->add_opponent_profile_tab('notes', [
        'name'     => _l('contracts_notes_tab'),
        'icon'     => 'fa fa-sticky-note-o',
        'view'     => 'admin/opponent/groups/notes',
        'position' => 15,
    ]);

    $CI->app_tabs->add_opponent_profile_tab('attachments', [
        'name'     => _l('customer_attachments'),
        'icon'     => 'fa fa-paperclip',
        'view'     => 'admin/opponent/groups/attachments',
        'position' => 20,
    ]);

    $CI->app_tabs->add_opponent_profile_tab('map', [
        'name'     => _l('customer_map'),
        'icon'     => 'fa fa-map-marker',
        'view'     => 'admin/opponent/groups/map',
        'position' => 25,
    ]);
}

// hooks()->add_action('after_format_datetime', 'my_custom_date');
// hooks()->add_action('after_format_date', 'my_custom_date');

// function my_custom_date($date)
// {
//     $opt = explode('|', get_option('dateformat'));
//     if(isset($opt[2]) && $opt[2]=='hijri'){
//         $datetime = explode(' ', $date);
//         $date = new DateTime($datetime[0]);
//         $date = Greg2Hijri($date->format('d'), $date->format('m'), $date->format('Y'), $string = true);

//         // First condition for date and datetime
//         // Second condition for 12 or 24 (Time Format)
//         if (isset($datetime[1])){
//         $date = isset($datetime[2]) ? $date.' '.$datetime[1].' '.$datetime[2] : $date.' '.$datetime[1];
//         }
//         return $date;
//     }
// }

/**
 * custom
 * Get all countries stored in database
 * @return array
 */
function my_get_all_countries()
{
    $CI = & get_instance();
    $CI->db->where('short_name_ar != "" ');
    return $CI->db->get('tblcountries')->result_array();
}

/**
 * custom
 * Get all cities for a specific country Stored in database
 * @return array
 */
function my_get_cities($country_id = '')
{
    $CI = & get_instance();
    if(get_option('active_language') == 'arabic'){
    $CI->db->select('Name_ar');
    }else{
    $CI->db->select('Name_en');
    }
    $CI->db->where('Country_id',$country_id);
    $cities =$CI->db->get('cities')->result_array();
    $arr=[];
    foreach ($cities as $key => $value) {
        $arr[$value['Name_ar']]=$value['Name_ar']; 
    }
    return $arr;
}

function admin_assets()
{
    $CI = &get_instance();

    $CI->app_css->add('bootstrap-datetimepicker-css', 'assets/css/bootstrap-datetimepicker.css');

    $CI->app_css->add('bootstrap4-toggle-css', 'assets/css/bootstrap4-toggle.css');

    $CI->app_scripts->add('bootstrap4-toggle-js', 'assets/js/bootstrap4-toggle.min.js');

//    $CI->app_scripts->add('jquery-js', 'assets/js/jquery-3.3.1.js');
//    $CI->app_scripts->add('bootstrap-js', 'assets/js/bootstrap.js');
    $CI->app_scripts->add('momentjs-js', 'assets/js/momentjs.js');
//    $CI->app_scripts->add('moment-with-locales-js', 'assets/js/moment-with-locales.js'); // ddd
    $CI->app_scripts->add('moment-with-data-js', 'assets/js/moment-with-data.js');
//    $CI->app_scripts->add('moment-timezone-js', 'assets/js/moment-timezone.min.js'); // ddd

//    $CI->app_scripts->add('moment-hijri-js', 'https://raw.githubusercontent.com/xsoh/moment-hijri/master/moment-hijri.js');

    $CI->app_scripts->add('moment-hijri-js', 'assets/js/moment-hijri.js');

    $CI->app_scripts->add('bootstrap-hijri-datetimepicker-js', 'assets/js/bootstrap-hijri-datetimepicker.js');

    $CI->app_scripts->add('custom-js', 'assets/js/custom.js');

}

function to_AD_date($date)
{
    if(strpos($date, ' ') !== false){    //is datetime
        $datetime = true;
        $dateArray = explode(' ', $date);
        $date = $dateArray[0];
        $time = $dateArray[1];
//        var_dump($dateArray);exit;
    }
    $sys_format = get_option('dateformat');
    $formats = explode('|', $sys_format);
    $formatMode =$formats[0];  //for general dateformat

    /** to check if this hijri status is on from database **/
    $hijriStatus= get_option('isHijri');
    /*******************************************************************/


    /** to check if this page are included in database hijri option **/
    $hijri_pages = json_decode(get_option('hijri_pages'));
    $current_url = current_url();
    $admin_url = admin_url();
    $this_page = str_replace(admin_url(),'',$current_url);

    if(search_url($hijri_pages, $this_page) > 0){
        $hijri_convert = true;
    }else{
        $hijri_convert = false;
    }

    if (  $hijri_convert && $hijriStatus =="on") {
        $hijri_settings['adj_data'] = get_option('adjust_data');
//                var_dump($hijri_settings['adj_data'].'fghf');exit();

        $current_date = date_parse($date);
        $hijriCalendar = new Calendar($hijri_settings);

        $AD_date = $hijriCalendar->HijriToGregorian($current_date['year'], $current_date['month'], $current_date['day'] );


        $date = $AD_date['y'] . '-' . $AD_date['m'] . '-' . $AD_date['d'];
        $date = date($formatMode, strtotime($date));
    }else{ // AD date

        $date = date($formatMode, strtotime($date));

    }
    if(isset($time)){
        $date = $date.' '.$time;
    }

    return $date;
}

function search_url($pages, $url)
{
    $i = 0;
    if(isset($pages)){
        foreach ($pages as $page){
            if($page != ''){
                if(strpos($url, $page) !== false){
                    $i++;
                }
            }
        }

    }
    return $i;
}

function to_hijri_date($date)
{
    if(strpos($date, ' ') !== false){
        $datetime = true;
        $dateArray = explode(' ', $date);
        $date = $dateArray[0];
        $time = $dateArray[1];

    }

    /** to check if this hijri status is on from database **/
    $hijriStatus= get_option('isHijri');
    /*******************************************************************/


    /** to check if this page are included in database hijri option **/
    $hijri_pages = json_decode(get_option('hijri_pages'));
    $current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

    $admin_url = admin_url();
    $this_page = str_replace(admin_url(),'',$current_url);


    if(search_url($hijri_pages, $this_page) > 0){
        $hijri_convert = true;
    }else{
        $hijri_convert = false;
    }


/*******************************************************************/

    if($hijri_convert && $hijriStatus =="on"){

        $datetime = explode(' ', $date);
        $date = new DateTime($datetime[0]);
        $hijriCalendar = new Calendar();
        $adj = new CalendarAdjustment();
        $hijri_settings['adj_data'] = $adj->get_adjdata(TRUE);

        $hijri_date = $hijriCalendar->GregorianToHijri($date->format('Y'), $date->format('m'), $date->format('d'));

         $date = $hijri_date['y'] . '-' . $hijri_date['m'] . '-' . $hijri_date['d'];


        // First condition for date and datetime
        // Second condition for 12 or 24 (Time Format)
        if (isset($datetime[1])){
        $date = isset($datetime[2]) ? $date.' '.$datetime[1].' '.$datetime[2] : $date.' '.$datetime[1];
        }
    }
    if(isset($time)){
        $date = $date.' '.$time;
    }
        return $date;
}

//hooks()->add_action('pre_admin_init', 'init_hijri_settings');
hooks()->add_action('admin_init', 'add_hijri_settings');
hooks()->add_action('app_admin_assets_added', 'admin_assets');
hooks()->add_filter('before_sql_date_format', 'to_AD_date');
hooks()->add_filter('after_format_date', 'to_hijri_date');
hooks()->add_filter('after_format_datetime', 'to_hijri_date');
hooks()->add_filter('before_settings_updated', 'set_my_options');
hooks()->add_filter('available_date_formats', 'add_hijri_option');

function set_my_options($data){
    if(isset($data['isHijriVal']) && $data['isHijriVal'] == 'on'){
        $isHijrivar = "on";
    }else{
        $isHijrivar = "off";
    }

    if(isset($data['adjust_data'])){

        $adj_data = $data['adjust_data'];

        if($adj_data !=""){
            if (option_exists('adjust_data') != Null){
                update_option('adjust_data',$adj_data);



            }else{

                add_option('adjust_data',$adj_data);

            }
        }

        if (get_option('isHijri') != Null){
            update_option('isHijri',$isHijrivar);

        }else{

            add_option('isHijri',$isHijrivar);
        }
        $links_array = [];
        if(isset($data['isHijriVal'])){
            unset($data['isHijriVal']);
        }

        unset($data['adjust_data']);

        foreach ($data as $key => $value ){
            array_push($links_array,$value );
        }
        if (get_option('hijri_pages') != Null){
            update_option('hijri_pages',json_encode($links_array));
        }else{
            add_option('hijri_pages',json_encode($links_array));
        }
//    var_dump(json_encode($links_array));exit();
//    add_option('dateformat',$data['dateformat']);
    }else{
        return $data;
    }

}

function add_hijri_settings(){

    $CI = &get_instance();
//  var_dump(add_option('dateformat'));exit();
    $CI->app_tabs->add_settings_tab('Hijri', [
        'name'     => _l('Hijri_managment'),
        'view'     => 'admin/settings/includes/hijri',
        'position' => 20,
    ]);
}

function add_hijri_option($date_formats)
{
    $new_formats = [
        'Y-m-d|%Y-%m-%d|hijri' => 'hijri',
        'Y-m-d|%Y-%m-%d|hijri|+1' => 'hijri (+1)',
        'Y-m-d|%Y-%m-%d|hijri|-1' => 'hijri (-1)',
    ];
    return array_merge($date_formats,$new_formats);
}

function check_session_by_id($id)
{
    $CI = &get_instance();
    $CI->db->where('id' , $id);
    $is_session = $CI->db->get(db_prefix() . 'tasks')->row()->is_session;
    if($is_session == 1){
        return true;
    }else{
        return false;
    }
}

function get_legal_service_name_by_id($service_id)
{
    $CI = & get_instance();
    $CI->db->select('name');
    $CI->db->where('id', $service_id);
    $service = $CI->db->get(db_prefix() . 'my_basic_services')->row();
    if ($service) {
        return $service->name;
    }
    return false;
}

function get_legal_service_slug_by_id($service_id)
{
    $CI = & get_instance();
    $CI->db->select('slug');
    $CI->db->where('id', $service_id);
    $service = $CI->db->get(db_prefix() . 'my_basic_services')->row();
    if ($service) {
        return $service->slug;
    }
    return false;
}

hooks()->add_filter('sms_gateways', 'add_sms_gateway');

function add_sms_gateway($gateways)
{
    array_push($gateways, 'sms/sms_mobily');
    
    return $gateways;
}

function get_dialog_boxes()
{
    $CI = & get_instance();
    $result = $CI->db->get_where(db_prefix() . 'my_dialog_boxes', ['active' => 1])->result_array();
    if ($result) {
        return $result;
    }
    return false;
}