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
        'href'     => admin_url('procuration'), // URL of the item
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


hooks()->add_filter('available_date_formats', 'add_hijri_option');
    function add_hijri_option($date_formats)
    {
        $date_formats ['Y-m-d|%Y-%m-%d|hijri']='hijri';
        return $date_formats;
    }
