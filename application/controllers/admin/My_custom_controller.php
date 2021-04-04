<?php

defined('BASEPATH') or exit('No direct script access allowed');

class My_custom_controller extends AdminController
{


    public function __construct()
    {
        parent::__construct();

    }

    public function session(){
        echo json_encode(array_to_object([
            'sess_time_to_update' => $this->config->item('sess_time_to_update'), 
            'sess_expiration' => $this->config->item('custom_sess_expiration')
        ]));   
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

    public function case_settings() {
        $this->db->select('id');
        $this->db->from(db_prefix() . 'my_cases');
        $this->db->where('deleted', 0);
        $cases = $this->db->get()->result_array();
        foreach($cases as $case) {
            $case_id = $case['id'];
            $this->db->where('case_id', $case_id);
            $case_settings = $this->db->get(db_prefix() . 'case_settings')->result_array();

            if(!empty($case_settings)){
                continue;
            }else{
                $this->db->insert(db_prefix() . 'case_settings', [
                    'case_id' => $case_id,
                    'value' => 'a:23:{s:16:"project_overview";i:1;s:11:"procuration";i:1;s:13:"project_tasks";i:1;s:18:"project_timesheets";i:1;s:18:"project_milestones";i:1;s:13:"project_files";i:1;s:19:"project_discussions";i:1;s:13:"project_gantt";i:1;s:15:"project_tickets";i:1;s:17:"project_contracts";i:1;s:16:"project_invoices";i:1;s:17:"project_estimates";i:1;s:16:"project_expenses";i:1;s:20:"project_credit_notes";i:1;s:13:"project_notes";i:1;s:16:"project_activity";i:1;s:12:"CaseMovement";i:1;s:11:"CaseSession";i:1;s:5:"Phase";i:1;s:4:"IRAC";i:1;s:10:"Procedures";i:1;s:12:"help_library";i:1;s:15:"written_reports";i:1;}',
                    'name' => 'available_features'
                ]);
                $this->db->insert(db_prefix() . 'case_settings', [
                    'case_id' => $case_id,
                    'value' => '0',
                    'name' => 'hide_tasks_on_main_tasks_table'
                ]);
                $this->db->insert(db_prefix() . 'case_settings', [
                    'case_id' => $case_id,
                    'value' => '0',
                    'name' => 'view_team_members'
                ]);
                $this->db->insert(db_prefix() . 'case_settings', [
                    'case_id' => $case_id,
                    'value' => '0',
                    'name' => 'view_activity_log'
                ]);
                $this->db->insert(db_prefix() . 'case_settings', [
                    'case_id' => $case_id,
                    'value' => '0',
                    'name' => 'view_timesheets'
                ]);
                $this->db->insert(db_prefix() . 'case_settings', [
                    'case_id' => $case_id,
                    'value' => '0',
                    'name' => 'view_gantt'
                ]);
                $this->db->insert(db_prefix() . 'case_settings', [
                    'case_id' => $case_id,
                    'value' => '0',
                    'name' => 'view_milestones'
                ]);
                $this->db->insert(db_prefix() . 'case_settings', [
                    'case_id' => $case_id,
                    'value' => '0',
                    'name' => 'open_discussions'
                ]);
                $this->db->insert(db_prefix() . 'case_settings', [
                    'case_id' => $case_id,
                    'value' => '0',
                    'name' => 'upload_files'
                ]);
                $this->db->insert(db_prefix() . 'case_settings', [
                    'case_id' => $case_id,
                    'value' => '0',
                    'name' => 'view_finance_overview'
                ]);
                $this->db->insert(db_prefix() . 'case_settings', [
                    'case_id' => $case_id,
                    'value' => '0',
                    'name' => 'view_task_total_logged_time'
                ]);
                $this->db->insert(db_prefix() . 'case_settings', [
                    'case_id' => $case_id,
                    'value' => '0',
                    'name' => 'upload_on_tasks'
                ]);
                $this->db->insert(db_prefix() . 'case_settings', [
                    'case_id' => $case_id,
                    'value' => '0',
                    'name' => 'view_task_checklist_items'
                ]);
                $this->db->insert(db_prefix() . 'case_settings', [
                    'case_id' => $case_id,
                    'value' => '0',
                    'name' => 'view_task_attachments'
                ]);
                $this->db->insert(db_prefix() . 'case_settings', [
                    'case_id' => $case_id,
                    'value' => '0',
                    'name' => 'view_task_comments'
                ]);
                $this->db->insert(db_prefix() . 'case_settings', [
                    'case_id' => $case_id,
                    'value' => '0',
                    'name' => 'comment_on_tasks'
                ]);
                $this->db->insert(db_prefix() . 'case_settings', [
                    'case_id' => $case_id,
                    'value' => '0',
                    'name' => 'edit_tasks'
                ]);
                $this->db->insert(db_prefix() . 'case_settings', [
                    'case_id' => $case_id,
                    'value' => '0',
                    'name' => 'create_tasks'
                ]);
                $this->db->insert(db_prefix() . 'case_settings', [
                    'case_id' => $case_id,
                    'value' => '0',
                    'name' => 'view_procurations'
                ]);
                $this->db->insert(db_prefix() . 'case_settings', [
                    'case_id' => $case_id,
                    'value' => '0',
                    'name' => 'view_session_logs'
                ]);
                $this->db->insert(db_prefix() . 'case_settings', [
                    'case_id' => $case_id,
                    'value' => '0',
                    'name' => 'view_tasks'
                ]);
            }

        }
    }

    public function fix_tasks(){
        $this->db->select('id, startdate, dateadded');
        $tasks = $this->db->get('tbltasks')->result_array();
        // echo '<pre>'; print_r($tasks); exit;
        foreach ($tasks as $task){
            $startdate = $task['startdate'];
            $dateadded = $task['dateadded'];
            $startdate_year = date('Y', strtotime($startdate));
            $dateadded_year = date('Y', strtotime($dateadded));

            if($startdate_year < 1900){
                $this->db->where('id', $task['id']);
                $this->db->update('tbltasks', [
                    'startdate' => force_to_AD_date_for_filter($startdate),
                ]);
                // echo force_to_AD_date_for_filter($startdate) . '<br>';
            }
            if($dateadded_year < 1900){
                $this->db->where('id', $task['id']);
                $this->db->update('tbltasks', [
                    'dateadded' => force_to_AD_date_for_filter($dateadded),
                ]);
            }

            if($startdate_year > 2100){
                $this->db->where('id', $task['id']);
                $this->db->update('tbltasks', [
                    'startdate' => force_to_hijri_date($startdate),
                ]);
                // echo force_to_AD_date_for_filter($startdate) . '<br>';
            }
            if($dateadded_year > 2100){
                $this->db->where('id', $task['id']);
                $this->db->update('tbltasks', [
                    'dateadded' => force_to_hijri_date($dateadded),
                ]);
            }
        }
        echo '<h1>Done</h1>';
    }

    public function fix_cases(){
        $this->db->select('id, start_date, deadline');
        $tasks = $this->db->get('tblmy_cases')->result_array();
        // echo '<pre>'; print_r($tasks); exit;
        foreach ($tasks as $task){
            $startdate = $task['start_date'];
            $startdate_year = date('Y', strtotime($startdate));

            $dateline = $task['deadline'];
            $dateline_year = date('Y', strtotime($dateline));

            if($startdate_year < 1900){
                $this->db->where('id', $task['id']);
                $this->db->update('tblmy_cases', [
                    'start_date' => force_to_AD_date_for_filter($startdate),
                ]);
            }
            if($startdate_year > 2100){
                $this->db->where('id', $task['id']);
                $this->db->update('tblmy_cases', [
                    'start_date' => force_to_hijri_date($startdate),
                ]);
            }

            if($dateline_year < 1900 && $dateline != null){
                $this->db->where('id', $task['id']);
                $this->db->update('tblmy_cases', [
                    'deadline' => force_to_AD_date_for_filter($dateline),
                ]);
            }
            if($dateline_year > 2100 && $dateline != null){
                $this->db->where('id', $task['id']);
                $this->db->update('tblmy_cases', [
                    'deadline' => force_to_hijri_date($dateline),
                ]);
            }
        }
        echo '<h1>Done</h1>';
    }

    public function fix_other_services(){
        $this->db->select('id, start_date, deadline');
        $tasks = $this->db->get('tblmy_other_services')->result_array();
        // echo '<pre>'; print_r($tasks); exit;
        foreach ($tasks as $task){
            $startdate = $task['start_date'];
            $startdate_year = date('Y', strtotime($startdate));

            $dateline = $task['deadline'];
            $dateline_year = date('Y', strtotime($dateline));

            if($startdate_year < 1900){
                $this->db->where('id', $task['id']);
                $this->db->update('tblmy_other_services', [
                    'start_date' => force_to_AD_date_for_filter($startdate),
                ]);
            }
            if($startdate_year > 2100){
                $this->db->where('id', $task['id']);
                $this->db->update('tblmy_other_services', [
                    'start_date' => force_to_hijri_date($startdate),
                ]);
            }

            if($dateline_year < 1900 && $dateline != null){
                $this->db->where('id', $task['id']);
                $this->db->update('tblmy_other_services', [
                    'deadline' => force_to_AD_date_for_filter($dateline),
                ]);
            }
            if($dateline_year > 2100 && $dateline != null){
                $this->db->where('id', $task['id']);
                $this->db->update('tblmy_other_services', [
                    'deadline' => force_to_hijri_date($dateline),
                ]);
            }
        }
        echo '<h1>Done</h1>';
    }




}