<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Ahmad helpers
// label_management module 
function getArr($lang){
    $str = '<?php';
   foreach($lang as $key => $value){

       $str .= "\n$" . "lang['" . $key . "']" . ' = "' . str_replace('"', '\"', $value) . '";';
   }
   return $str;
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


