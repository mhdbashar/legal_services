<?php

defined('BASEPATH') or exit('No direct script access allowed');

class My_custom_controller extends AdminController
{


    public function __construct()
    {
        parent::__construct();

    }


    function get_date_options(){
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

        $date_option = get_option('isHijri');
        $parts = explode('|', $date_option);
        if($date_option == "on"){
            $json['mode'] = "hijri";
        }else{
            $json['mode'] = "";
        }

        echo json_encode($json)  ;



    }
    function set_hijri_adjust(){
        $adj = new CalendarAdjustment();
        $month = $_GET['add_month'];
        $year = $_GET['add_year'];
        $adj_val = $_GET['add_value'];
        $hmonths = array(1 => "محرم", "صفر", "ربيع الأول", "ربيع الثاني", "جمادى الأولى", "جمادى الآخرة", "رجب", "شعبان", "رمضان", "شوال", "ذو القعدة", "ذو الحجة");

        $adj->add_adj($month, $year, $adj_val);
        $final_res = array();

        foreach ($adj->get_current_adjs() as $v) {
            $result= '<div  id="delete_div" class="form-group col-sm-12" style="display: inline-flex;">
                            <div class="form-group col-sm-7" style="display: inline-flex;">
                                <p>'.$v['year'] . "/" . $v['month'].'</p>
                                <p> - </p>
                                <p>'.$hmonths[$v['month']].'</p>
                                <p>=></p>
                                <p>'. $v['current'] .'</p>
                                <p> '._l('default_adjust').'</p>
                                <p> '. $v['default'].'</p>
                            </div>
                            <div class="form-group col-sm-2">
                                <input type="button" id="delete_btn" class="form-control" 
                                data-month="'.$v['month'].'" data-year="'.$v['year'].'" value="'._l('delete_adjust').'">
                            </div>
                     </div>';
            array_push($final_res,$result);
        }

        $hijri_settings['adj_data'] = $adj->get_adjdata(TRUE);
        $res['adjdata']= $adj->get_adjdata(TRUE);
        $res['new'] = $final_res;
        echo json_encode($res);
    }

    function  delete_hijri_adjust(){
        $adj = new CalendarAdjustment();
        $adj->del_adj($_GET['del_month'], $_GET['del_year']);

        $res['adjdata']= $adj->get_adjdata(TRUE);
        echo json_encode($res);
    }


    function add_adjust_form(){
        $adj = new CalendarAdjustment();
        $hmonths = array(1 => "محرم", "صفر", "ربيع الأول", "ربيع الثاني", "جمادى الأولى", "جمادى الآخرة", "رجب", "شعبان", "رمضان", "شوال", "ذو القعدة", "ذو الحجة");
        $msg='';
        $hm = $_GET['add_month'];
        $hy = $_GET['add_year'];

        echo '<div id="form_div" class="form-group">
                <div id="form_select" class="form-group col-sm-12" style="display: inline-flex;">
                    
                        <p>'._l('start_month'). ' </p>
                        <p>'. $hmonths[$hm] .'</p>
                        <p>'._l('from_year').'</p>
                        <p>'.$hy.'</p>
                        <p>'._l('to').'</p>
                </div>
                <div class="form-group col-sm-12">
                    <div class="form-group col-sm-8">
                        <select id="target_adjust" class="form-control col-sm-2">';
                            $starts = $adj->get_possible_starts($hm, $hy);
                            foreach ($starts as $start) {
                                echo '<option value="' . $start['jd'] . '"' . (($start['currentset']) ? ' selected' : '') . ' >' . $start['grdate'];
                                foreach ($start['alsoadjdata'] as $v) {
                                    echo _l('also_start_month') . $hmonths[$v['month']] . _l('from_year') . $v['year'] . _l('to') . $v['grdate'];
                                }
                                echo "</option>";
                            }
                    echo '</select>
                    </div>
                    <div class="form-group col-sm-4" style="display: inline-flex;">
        
                        <input type="button" class="form-control add_adjust_action" id="add_adjust_action" value="'._l('send').'">
                        <input type="button" class="form-control" id="cancel_btn" value="'._l('cancel').'">
                    </div>
                </div>
        </div>';
    }

}