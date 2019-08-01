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

        $date_option = get_option('dateformat');
        $parts = explode('|', $date_option);
        if(isset($parts[2])){
            $json['mode'] = $parts[2]; //$this->app->get_option('date_format');
        }else{
            $json['mode'] = $parts[0]; //$this->app->get_option('date_format');
        }
//        var_dump($json['mode']);exit;

        echo json_encode($json)  ;



    }
}