<?php
defined('BASEPATH') or exit('No direct script access allowed');

// /*
//  * Code for convert from Gregorian date to hijri date
//  */
// function intPart($float)
// {
//     if ($float < -0.0000001)
//         return ceil($float - 0.0000001);
//     else
//         return floor($float + 0.0000001);
// }

// function Greg2Hijri($day, $month, $year, $string = false)
// {
//     $day   = (int) $day;
//     $month = (int) $month;
//     $year  = (int) $year;

//     if (($year > 1582) or (($year == 1582) and ($month > 10)) or (($year == 1582) and ($month == 10) and ($day > 14)))
//     {
//         $jd = intPart((1461*($year+4800+intPart(($month-14)/12)))/4)+intPart((367*($month-2-12*(intPart(($month-14)/12))))/12)-
//         intPart( (3* (intPart(  ($year+4900+    intPart( ($month-14)/12)     )/100)    )   ) /4)+$day-32075;
//     }
//     else
//     {
//         $jd = 367*$year-intPart((7*($year+5001+intPart(($month-9)/7)))/4)+intPart((275*$month)/9)+$day+1729777;
//     }

//     $l = $jd-1948440+10632;
//     $n = intPart(($l-1)/10631);
//     $l = $l-10631*$n+354;
//     $j = (intPart((10985-$l)/5316))*(intPart((50*$l)/17719))+(intPart($l/5670))*(intPart((43*$l)/15238));
//     $l = $l-(intPart((30-$j)/15))*(intPart((17719*$j)/50))-(intPart($j/16))*(intPart((15238*$j)/43))+29;

//     $month = intPart((24*$l)/709);
//     $day   = $l-intPart((709*$month)/24);
//     $year  = 30*$n+$j-30;

//     $date = array();
//     $date['year']  = $year;
//     $date['month'] = $month;
//     $date['day']   = $day;

//     if (!$string)
//         return $date;
//     else
//         return     "{$year}-{$month}-{$day}";
// }

// add_action('after_render_single_aside_menu', 'my_custom_menu_items');
hooks()->add_action('admin_init', 'my_custom_setup_menu_items');

function my_custom_setup_menu_items()
{
    $CI = &get_instance();

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
        'name'     => _l("LService_recycle_bin"), // The name if the item
        'href'     => admin_url('LegalServices/LegalServices_controller/legal_recycle_bin'), // URL of the item
        'position' => 5, // The menu position
        // 'icon'     => 'fa fa-adjust', // Font awesome icon

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
    return $CI->db->get('cities')->result_array();
}

hooks()->add_action('admin_init', 'add_hijri_settings');
hooks()->add_action('app_admin_assets_added', 'admin_assets');
hooks()->add_filter('before_sql_date_format', 'to_AD_date');
hooks()->add_filter('after_format_date', 'to_hijri_date');
hooks()->add_filter('after_format_datetime', 'to_hijri_date');

hooks()->add_filter('before_settings_updated', 'set_my_options');

hooks()->add_filter('available_date_formats', 'add_hijri_option');

function admin_assets()
{
    $CI = &get_instance();

    $CI->app_css->add('bootstrap-datetimepicker-css', 'assets/css/bootstrap-datetimepicker.css');

    $CI->app_css->add('bootstrap4-toggle-css', 'assets/css/bootstrap4-toggle.css');

    $CI->app_scripts->add('bootstrap4-toggle-js', 'assets/js/bootstrap4-toggle.min.js');

//    $CI->app_scripts->add('jquery-js', 'assets/js/jquery-3.3.1.js');
//    $CI->app_scripts->add('bootstrap-js', 'assets/js/bootstrap.js');
//    $CI->app_scripts->add('momentjs-js', 'assets/js/momentjs.js');
    $CI->app_scripts->add('moment-with-locales-js', 'assets/js/moment-with-locales.js');
    $CI->app_scripts->add('moment-timezone-js', 'assets/js/moment-timezone.min.js');
//    $CI->app_scripts->add('moment-hijri-js', 'https://raw.githubusercontent.com/xsoh/moment-hijri/master/moment-hijri.js');

    $CI->app_scripts->add('moment-hijri-js', 'assets/js/moment-hijri.js');

    $CI->app_scripts->add('bootstrap-hijri-datetimepicker-js', 'assets/js/bootstrap-hijri-datetimepicker.js');

    $CI->app_scripts->add('custom-js', 'assets/js/custom.js');
    

}


//
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



    }else{
        return $data;
    }

}
function add_hijri_settings(){

    $CI = &get_instance();

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


