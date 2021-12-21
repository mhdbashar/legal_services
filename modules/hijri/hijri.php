<?php

defined('BASEPATH') or exit('No direct script access allowed');

/*
Author: Babil Team
Module Name: التاريخ الهجري
Description: الإضافة الافتراضية للتاريخ الهجري
Version: 1.0.0
Requires at least: 2.3.*
Author URI: #

*/


define('HIJRI_MODULE_NAME', 'hijri');

require FCPATH . '/modules/hijri/libraries/Calendar.php';
require FCPATH . '/modules/hijri/libraries/CalendarAdjustment.php';

/**
 * Load the module helper
 */

hooks()->add_action('app_admin_assets_added', 'hijri_assets');
$CI = & get_instance();



function to_hijri_date($date)
{
    if ($date=='')
        return '';
    $CI = & get_instance();
    if(strpos($date, ' ') !== false){
        $datetime = true;
        $dateArray = explode(' ', $date);
        $date = $dateArray[0];
        $time = $dateArray[1];
    }

    if (true) {
        $datetime = explode(' ', $date);
        $date = new DateTime($datetime[0]);
        $hijriCalendar = new Calendar();
        $adj = new CalendarAdjustment();
        $hijri_settings['adj_data'] = $adj->get_adjdata(TRUE);
        $hijri_date = $hijriCalendar->GregorianToHijri($date->format('Y'), $date->format('m'), $date->format('d'));
        $date = $hijri_date['y'] . '-' . ($hijri_date['m'] < 10 ? '0'.$hijri_date['m'] : $hijri_date['m']) . '-' . ($hijri_date['d'] < 10 ? '0'.$hijri_date['d'] : $hijri_date['d']);
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











function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}
function hijri_assets(){

    $CI = & get_instance();
    $CI->app_css->add('bootstrap-datetimepicker-css', 'modules/hijri/assets/css/bootstrap-datetimepicker.css');
//    $CI->app_css->add('bootstrap4-toggle-css', 'modules/hijri/assets/css/bootstrap4-toggle.css');
//    $CI->app_scripts->add('bootstrap4-toggle-js', 'modules/hijri/assets/js/bootstrap4-toggle.min.js');
    $CI->app_scripts->add('momentjs-js', 'modules/hijri/assets/js/momentjs.js');
    $CI->app_scripts->add('moment-with-data-js', 'modules/hijri/assets/js/moment-with-data.js');
    $CI->app_scripts->add('moment-hijri-js', 'modules/hijri/assets/js/moment-hijri.js');
    $CI->app_scripts->add('bootstrap-hijri-datetimepicker-js', 'modules/hijri/assets/js/bootstrap-hijri-datetimepicker.js');
    $CI->app_scripts->add('init-js', 'modules/hijri/assets/js/init.js');




}



