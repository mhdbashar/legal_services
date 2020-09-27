<?php
defined('BASEPATH') or exit('No direct script access allowed');


function my_check_license()
{
    include('./license/check.php');
                
                // Get the license key and local key from storage
                // These are typically stored either in flat files or an SQL database
                $licensekey = "";
                $localkey = "";
                $base = getcwd()."/license";
                $handle = fopen($base."/license.txt", "r");
                if ($handle) {
                    $count = 0;
                    while (($line = fgets($handle)) !== false) {
                        // process the line read.
                        if ($count == 0) {
                            $licensekey = trim($line);
                        } else if ($count == 1) {
                            $localkey = trim($line);
                            break;
                        }
                        $count++;
                    }
                    fclose($handle);
                } else {
                    die("Could not read license file. Please contact support.");
                }
                // echo $licensekey."<br/>";
                // echo $localkey."<br/>";
                // Validate the license key information
                $results = check_license($licensekey, $localkey);
                // Raw output of results for debugging purpose
                

                // Interpret response
                switch ($results['status']) {
                    case "Active":
                        // get new local key and save it somewhere
                        $localkeydata = str_replace(' ','',preg_replace('/\s+/', ' ', $results['localkey']));
                        $handle = fopen($base."/license.txt", "r");
                        if ($handle) {
                            $count = 0;
                            while (($line = fgets($handle)) !== false) {
                                // process the line read.
                                if ($count == 0) {
                                    $licensekey = trim($line);
                                    break;
                                }
                                $count++;
                            }
                            fclose($handle);
                            if (isset($results['localkey'])) {
                                $textfile = fopen($base . "/license.txt", "w") or die("Unable to open file!");
                                $contents = $licensekey . "\n" . $localkeydata . "\n";
                                fwrite($textfile, $contents);
                                fclose($textfile);
                            }
                            return $results;
                        } else {
                            die("Could not read license file. Please contact support.");
                        }
                        break;
                    case "Invalid":
                        die("License key is Invalid");
                        break;
                    case "Expired":
                        die("License key is Expired");
                        break;
                    case "Suspended":
                        die("License key is Suspended");
                        break;
                    default:
                        die("Invalid Response");
                        break;
                }
}
// add_action('after_render_single_aside_menu', 'my_custom_menu_items');
hooks()->add_action('admin_init', 'my_custom_setup_menu_items');
hooks()->add_action('admin_init', 'app_init_opponent_profile_tabs');

hooks()->add_action('clients_init', 'my_module_clients_area_menu_items');
hooks()->add_action('admin_init', 'my_module_menu_item_collapsible');

function my_module_menu_item_collapsible()
{
    $CI = &get_instance();
    
    // $CI->app_menu->add_sidebar_menu_item('clients', [
    //     'name'     => _l('clients_'), // The name if the item
    //     'collapse' => true, // Indicates that this item will have submitems
    //     // 'href'     => admin_url('opponents'), // URL of the item
    //     'position' => 5, // The menu position
    //     'icon'     => 'fa fa-user-o', // Font awesome icon
    // ]);

    // $CI->app_menu->add_sidebar_children_item('clients', [
    //     'name'     => _l('clients'),
    //     'slug'     => 'clients', // Required ID/slug UNIQUE for the child menu
    //     'href'     => admin_url('clients'),
    //     'position' => 5,
    // ]);

    // $CI->app_menu->add_sidebar_children_item('clients', [
    //     'name'     => _l('opponents'), // The name if the item
    //     'slug'     => 'child-to-custom-menu-item', // Required ID/slug UNIQUE for the child menu
    //     'href'     => admin_url('opponents'), // URL of the item
    //     'position' => 5, // The menu position
    // ]);

    $services = $CI->db->order_by('id', 'ASC')->get_where('my_basic_services', array('is_primary' => 1 , 'show_on_sidebar' => 1, 'is_module' => 0))->result();
    $CI->app_menu->add_sidebar_menu_item('custom-menu-unique-id', [
        'name'     => _l('LegalServices'), // The name if the item
        'collapse' => true, // Indicates that this item will have submitems
        'position' => 5, // The menu position
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

    $CI->app_menu->add_sidebar_menu_item('transactions', [
        'name'     => _l("transactions"), // The name if the item
        'collapse' => true, // Indicates that this item will have submitems
        'position' => 7, // The menu position
        'icon'     => 'fa fa-briefcase', // Font awesome icon
    ]);
    $CI->app_menu->add_sidebar_children_item('transactions', [
        'slug'     => 'child-to-custom-menu-item', // Required ID/slug UNIQUE for the child menu
        'name'     => _l("incoming"), // The name if the item
        'href'     => admin_url('transactions/incoming_list'), // URL of the item
        'position' => 1, // The menu position
        // 'icon'     => 'fa fa-adjust', // Font awesome icon

    ]);
    $CI->app_menu->add_sidebar_children_item('transactions', [
        'slug'     => 'child-to-custom-menu-item', // Required ID/slug UNIQUE for the child menu
        'name'     => _l("outgoing"), // The name if the item
        'href'     => admin_url('transactions/outgoing_list'), // URL of the item
        'position' => 1, // The menu position
        // 'icon'     => 'fa fa-adjust', // Font awesome icon

    ]);
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

    // $CI->app_menu->add_setup_menu_item('0', [
    //     'name'     => _l("dialog_box_manage"), // The name if the item
    //     'position' => 0, // The menu position
    //     'href'     => admin_url('Dialog_boxes'), // URL of the item
    // ]);
    $CI->app_menu->add_setup_menu_item('1', [
        'name' => _l("legal_services_settings"), // The name if the item
        'collapse' => true, // Indicates that this item will have submitems
        'position' => 1, // The menu position
    ]);

    if (has_permission('customer_representative', '', 'create')) {
        $CI->app_menu->add_setup_children_item('1', [
            'slug' => 'child-to-custom-menu-item1', // Required ID/slug UNIQUE for the child menu
            'name' => _l("customer_representative"), // The name if the item
            'href' => admin_url('customer_representative'), // URL of the item
            'position' => 1, // The menu position
        ]);
    }

    if (has_permission('judges_manage', '', 'create')) {
        $CI->app_menu->add_setup_children_item('1', [
            'slug' => 'child-to-custom-menu-item2', // Required ID/slug UNIQUE for the child menu
            'name' => _l("Judges"), // The name if the item
            'href' => admin_url('Judge'), // URL of the item
            'position' => 2, // The menu position
        ]);
    }

    if (has_permission('case_status', '', 'create')) {
        $CI->app_menu->add_setup_children_item('1', [
            'slug' => 'child-to-custom-menu-item3', // Required ID/slug UNIQUE for the child menu
            'name' => _l("case_status"), // The name if the item
            'href' => admin_url('Case_status'), // URL of the item
            'position' => 3, // The menu position
        ]);
    }

    if (has_permission('courts', '', 'create') || has_permission('judicial_departments', '', 'create')) {
        $CI->app_menu->add_setup_children_item('1', [
            'slug' => 'child-to-custom-menu-item4', // Required ID/slug UNIQUE for the child menu
            'name' => _l("CourtsManagement"), // The name if the item
            'href' => admin_url('courts_control'), // URL of the item
            'position' => 4, // The menu position
        ]);
    }

    if (has_permission('legal_services', '', 'create')) {
        $CI->app_menu->add_setup_children_item('1', [
            'slug' => 'child-to-custom-menu-item5', // Required ID/slug UNIQUE for the child menu
            'name' => _l("LegalServiceManage"), // The name if the item
            'href' => admin_url('ServicesControl'), // URL of the item
            'position' => 5, // The menu position
        ]);
    }

    $CI->app_menu->add_setup_children_item('1', [
        'slug' => 'child-to-custom-menu-item6', // Required ID/slug UNIQUE for the child menu
        'name' => _l("legal_services_phases"), // The name if the item
        'href' => admin_url('LegalServices/Phases_controller'), // URL of the item
        'position' => 6, // The menu position
    ]);

    if (has_permission('legal_recycle_bin', '', 'view')) {
        $CI->app_menu->add_setup_children_item('1', [
            'slug' => 'child-to-custom-menu-item7', // Required ID/slug UNIQUE for the child menu
            'name' => _l("LService_recycle_bin"), // The name if the item
            'href' => admin_url('LegalServices/LegalServices_controller/legal_recycle_bin'), // URL of the item
            'position' => 7, // The menu position
        ]);
    }

    $CI->app_menu->add_setup_children_item('1', [
        'slug' => 'child-to-custom-menu-item8', // Required ID/slug UNIQUE for the child menu
        'name' => _l("legal_procedures_management"), // The name if the item
        'href' => admin_url('LegalServices/legal_procedures'), // URL of the item
        'position' => 8, // The menu position
    ]);

    $CI->app_menu->add_setup_menu_item('2', [
        'name' => _l("procurations"), // The name if the item
        'collapse' => true, // Indicates that this item will have submitems
        'position' => 2, // The menu position
    ]);

    // The first paremeter is the parent menu ID/Slug
    $CI->app_menu->add_setup_children_item('2', [
        'slug' => 'child-to-custom-menu-item', // Required ID/slug UNIQUE for the child menu
        'name' => _l("procuration"), // The name if the item
        'href' => admin_url('procuration/all'), // URL of the item
        'position' => 1, // The menu position
    ]);

    $CI->app_menu->add_setup_children_item('2', [
        'slug' => 'child-to-custom-menu-item', // Required ID/slug UNIQUE for the child menu
        'name' => _l("procuration_state"), // The name if the item
        'href' => admin_url('procuration/state'), // URL of the item
        'position' => 2, // The menu position
    ]);

    $CI->app_menu->add_setup_children_item('2', [
        'slug' => 'child-to-custom-menu-item', // Required ID/slug UNIQUE for the child menu
        'name' => _l("procuration_type"), // The name if the item
        'href' => admin_url('procuration/type'), // URL of the item
        'position' => 3, // The menu position
    ]);

    $CI->app_menu->add_setup_menu_item('opponents', [
        'name' => _l('opponents'), // The name if the item
        'slug' => 'child-to-custom-menu-item', // Required ID/slug UNIQUE for the child menu
        'href' => admin_url('opponents'), // URL of the item
        'position' => 6, // The menu position
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
    }
    $sys_format = get_option('dateformat');
    $formats = explode('|', $sys_format);
    $formatMode =$formats[0];  //for general dateformat

    /** to check if this hijri status is on from database **/
    $hijriStatus= get_option('isHijri');
    /*******************************************************************/


    /** to check if this page are included in database hijri option **/
    $hijri_pages = json_decode(get_option('hijri_pages'));
    $current_url = isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER']:'';
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
    // $current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
    $current_url = isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER']:'';

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

/**
 * Prepare general IRAC pdf
 * @param  object $irac  irac as object with all necessary fields
 * @param  string $tag   tag for bulk pdf exporter
 * @return mixed object
 */
function irac_pdf($irac, $tag = '')
{
    return app_pdf('irac', LIBSPATH . 'pdf/irac_pdf', $irac, $tag);
}

function legal_procedure_by_list_id($list_id)
{
    $CI = & get_instance();
    $CI->db->where('list_id', $list_id);
    $CI->db->select(db_prefix() . 'legal_procedures.*,subcat.name AS subcat_name');
    $CI->db->join(db_prefix() . 'my_categories AS subcat', 'subcat.id = ' . db_prefix() . 'legal_procedures.subcat_id', 'left');
    return $CI->db->get(db_prefix() . 'legal_procedures')->result_array();
}

function list_procedure_by_id($id)
{
    $CI = & get_instance();
    $CI->db->where('id', $id);
    return $CI->db->get(db_prefix() . 'legal_procedures_lists')->row();
}

function legal_procedure_by_ref_id($ref_id)
{
    $CI = & get_instance();
    $CI->db->where('reference_id', $ref_id);
    return $CI->db->get(db_prefix() . 'legal_procedures')->row();
}

function get_cat_name_by_id($id)
{
    $CI = & get_instance();
    $CI->db->select('name');
    $CI->db->where('id', $id);
    $cat = $CI->db->get(db_prefix() . 'my_categories')->row();
    if ($cat) {
        return $cat->name;
    }
    return false;
}

function convert_to_tags($string)
{
   // $string_after_replace = preg_replace("/(?!.[.=$'€%-])\p{P}/u", "", $string);
    $string_array         = explode(' ', $string);
    $array_after_filter   = array_filter($string_array);
    return $array_after_filter;
}

/**
 * Function that add tags based on passed arguments
 * @param  string $tags
 * @param  mixed $rel_id
 * @param  string $rel_type
 * @return boolean
 */
function save_edit_services_tags($tags, $rel_id, $rel_type)
{
    $CI = & get_instance();
    // Check if there is tags
    $old_tags = get_service_tags($rel_id, $rel_type);
    if(!empty($old_tags)) {
        foreach ($old_tags as $tag) {
            $CI->db->where('id', $tag['id']);
            $CI->db->where('rel_id', $tag['rel_id']);
            $CI->db->where('rel_type', $tag['rel_type']);
            $CI->db->delete(db_prefix() . 'my_services_tags');
        }
        foreach ($tags as $row) {
            /*$tag_text = clear_textarea_breaks($tag);
            $tag_purify = html_purify($tag_text);
            $tag_purify1 = html_escape($tag_purify);*/
            $data = array(
                'tag'      => $row,
                'rel_type' => $rel_type,
                'rel_id'   => $rel_id
            );
            $CI->db->insert(db_prefix() . 'my_services_tags', $data);
            $CI->db->insert_id();
        }
        return true;
    }else{
        foreach ($tags as $row) {
            $data = array(
                'tag'      => $row,
                'rel_type' => $rel_type,
                'rel_id'   => $rel_id
            );
            $CI->db->insert(db_prefix() . 'my_services_tags', $data);
            $CI->db->insert_id();
        }
        return true;
    }
}

function get_service_tags($rel_id, $rel_type)
{
    $CI = & get_instance();
    $CI->db->where(array(
        'rel_id' => $rel_id,
        'rel_type' => $rel_type
    ));
    return $CI->db->get(db_prefix().'my_services_tags')->result_array();
}

function get_books_by_api($tags)
{
    $info  = array(
        'tags' => $tags
    );
    $postdata    = http_build_query($info);
    //$webservices = 'http://localhost/babillawlib/';
    $webservices = 'http://lib.babillawnet.com/';
    $url         = $webservices."Book/search_book_api";
    $curl 	     = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "$url",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "$postdata",
    ));
    $response = curl_exec($curl);
    $err 	  = curl_error($curl);
    curl_close($curl);
    if(!empty($err)):
        return array($response, $err);
    else:
        return $response;
    endif;
}

//function search_book_api()
//{
//    if($this->input->post()){
//        $tags_array = $this->input->post();
//        if(isset($tags_array['tags']) && !empty($tags_array['tags'])){
//            $new_tag_name = str_replace(' ', '', $tags_array['tags']);
//
//            $tags_name = explode(',', $new_tag_name);
//
//            foreach ($tags_name as $tag) {
//                $this->db->like('tag_name', $tag);
//                $result[] = $this->db->get('tag')->result();
//            }
//            if($result){
//                foreach ($result as $value => $key) {
//                    foreach ($result[$value] as $item){
//                        $arr[] = $item->tag_id;
//                    }
//                }
//                $sql = "SELECT section_id,book_id,book_title,url,file,
//                        COUNT(book_title) AS relevance
//                        FROM
//                        (SELECT book.section_id,book.book_id,file,url, book_title
//                         FROM book,book_tag,section
//                         WHERE  book.book_id = book_tag.book_id
//                         AND book.main_section = section.section_id
//                         AND tag_id IN('" . implode("','", $arr) . "')
//                         ) AS matches
//                         GROUP BY section_id, book_id, book_title, url, file
//                         ORDER BY relevance DESC";
//                $books = $this->db->query($sql)->result();
//
//                foreach ($books as $book) {
//                    $sql2 = "SELECT c.*
//                            FROM (
//                                SELECT
//                                    @r AS _id,
//                                    (SELECT @r := parent_id FROM section WHERE section_id = _id) AS parent_id,
//                                    @l := @l + 1 AS level
//                                FROM
//                                    (SELECT @r := " . $book->section_id . ", @l := 0) vars, section m
//                                WHERE @r <> 0) d
//                            JOIN section c
//                            ON d._id = c.section_id ORDER BY section_id ASC";
//                    $sections = $this->db->query($sql2)->result();
//                    $book->sections = $sections;
//                }
//                // set response code - 200 OK
//                http_response_code(200);
//                echo json_encode(array("message" => "success", "books" => $books), JSON_UNESCAPED_UNICODE);
//            }else{
//                // set response code - 503 service unavailable
//                http_response_code(503);
//                echo json_encode(array("message" => "No data found."));
//            }
//        }else{
//            // set response code - 400 bad request
//            http_response_code(400);
//            echo json_encode(array("message" => "Unable to read tags. The data is incomplete."));
//        }
//    }else{
//        // set response code - 405 method not allowed
//        http_response_code(405);
//        echo json_encode(array("message" => "Method Not Allowed"));
//    }
//}