<?php

defined('BASEPATH') or exit('No direct script access allowed');

class My_custom_controller extends AdminController
{
    public function __construct()
    {
        parent::__construct();

    }


    function get_date_options(){
//        $json['lang'] ="ar";
        $json['lang'] = $this->app->get_option('active_language');
//        $json['lang'] ="ar";
        if($this->app->get_option('hijri_pages') != null){
            $json['hijri_pages'] =  $this->app->get_option('hijri_pages');
        }else{
            $json['hijri_pages'] = "";
        }
        if($this->app->get_option('isHijri') != null){
            $json['isHijri'] =  $this->app->get_option('isHijri');
        }else{
            $json['isHijri'] = "off";
        }

        $date_option = get_option('hijri_format');
        $parts = explode('|', $date_option);
        if(isset($parts[2])){
            $json['mode'] = $parts[2]; //$this->app->get_option('date_format');
        }else{
            $json['mode'] = $parts[0]; //$this->app->get_option('date_format');
        }
        
            $json['adjust'] = $date_option; //$this->app->get_option('date_format');

//        var_dump($json['hijri_pages']);exit;

        echo json_encode($json)  ;



    }
//    function set_option(){
//        var_dump('ddfgjkdhkjd');exit();
//    }
}