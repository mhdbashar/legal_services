<?php

defined('BASEPATH') or exit('No direct script access allowed');

class My_custom_controller extends AdminController
{
//    public $lang;

    public function __construct()
    {
        parent::__construct();
//        $CI       = & get_instance();
//        $language = get_option('active_language');

//        $this->lang = $CI->lang->load($language . '_lang', $language);

    }


    function get_date_options(){
//        $json['lang'] ="ar";
        $json['lang'] = $this->app->get_option('active_language');
        $json['lang'] ="ar";
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
            $json['mode'] = "hijri"; //$this->app->get_option('date_format');
        }else{
            $json['mode'] = ""; //$this->app->get_option('date_format');
        }
//
//            $json['adjust'] = $date_option; //$this->app->get_option('date_format');

//        var_dump($json['hijri_pages']);exit;

        echo json_encode($json)  ;



    }
    function set_hijri_adjust(){
//        $lang = $this->lang;
        $adj = new CalendarAdjustment();
//        var_dump($_GET);exit();
        $month = $_GET['add_month'];
        $year = $_GET['add_year'];
        $adj_val = $_GET['add_value'];
        $hmonths = array(1 => "محرم", "صفر", "ربيع الأول", "ربيع الثاني", "جمادى الأولى", "جمادى الآخرة", "رجب", "شعبان", "رمضان", "شوال", "ذو القعدة", "ذو الحجة");

        $adj->add_adj($month, $year, $adj_val);
//        var_dump($adj->get_adjdata(TRUE),$a);exit();
        $final_res = array();

        foreach ($adj->get_current_adjs() as $v) {
//            $result = "<div id='delete_div'> " .$v['year'] . "/ " . $v['month'] . " - " . $hmonths[$v['month']] . " => " . $v['current'] . " الافتراضي هو " . $v['default'] . "
//
//            <input type='button' id='delete_btn' data-month='".$v['month']."' data-year='".$v['year']."' value='حذف'>
//            <input type='button' id='update_btn' data-month='".$v['month']."' data-year='".$v['year']."' value='تعديل'> <br/>
//            </div>";
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
//            $result = $v['year'] . "/ " . $v['month'] . " - " . $hmonths[$v['month']] . " => " . $v['current'] . " الافتراضي هو " . $v['default'] . " [<a href='" . $_SERVER['SCRIPT_NAME'] . "?action=del&amp;month=" . $v['month'] . "&amp;year=" . $v['year'] . "'>حذف</a>] [<a href='" . $_SERVER['SCRIPT_NAME'] . "?action=edit&amp;month=" . $v['month'] . "&amp;year=" . $v['year'] . "'>تعديل</a>]<br/>";
//            $final_res.push($result);
            array_push($final_res,$result);
        }

        $hijri_settings['adj_data'] = $adj->get_adjdata(TRUE);
        $res['adjdata']= $adj->get_adjdata(TRUE);
        $res['new'] = $final_res;
//        var_dump(json_encode($res));exit();
//        return json_encode($res);
        echo json_encode($res);
    }

    function  delete_hijri_adjust(){
//        var_dump($_GET);exit;
        $adj = new CalendarAdjustment();
        $adj->del_adj($_GET['del_month'], $_GET['del_year']);

        $res['adjdata']= $adj->get_adjdata(TRUE);
//        var_dump(json_encode($res));exit();
//        return json_encode($res);
        echo json_encode($res);
    }

    function  update_hijri_adjust(){

    }

    function add_adjust_form(){
//        $lang = $this->lang;
        $adj = new CalendarAdjustment();
        $hmonths = array(1 => "محرم", "صفر", "ربيع الأول", "ربيع الثاني", "جمادى الأولى", "جمادى الآخرة", "رجب", "شعبان", "رمضان", "شوال", "ذو القعدة", "ذو الحجة");
        $msg='';
//var_dump($adj->get_adjdata(TRUE));exit;
        $hm = $_GET['add_month'];
                $hy = $_GET['add_year'];

//                echo '<div id="adjust_div">';
//                echo "تعديل بداية الشهر " . $hmonths[$hm] . " من سنة $hy إلى:";
//                echo '<select  id="target_adjust">';
//                $starts = $adj->get_possible_starts($hm, $hy);
//                foreach ($starts as $start) {
//                    echo '<option value="' . $start['jd'] . '"' . (($start['currentset']) ? ' selected' : '') . ' >' . $start['grdate'];
//                    foreach ($start['alsoadjdata'] as $v) {
//                        echo " وسيتم أيضا تعديل بداية شهر " . $hmonths[$v['month']] . " من سنة " . $v['year'] . " إلى:" . $v['grdate'];
//                    }
//                    echo "</option>";
//                }
//                echo '</select><input type="button" id="add_adjust_action" value="إرسال" />';
//                echo '<input type="button" id="cancel_btn" value="إالغاء">';
//                echo '</div>';

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
//        var_dump($_GET);exit();
    }

}