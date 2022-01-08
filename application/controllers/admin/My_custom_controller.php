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
                    'startdate' => ($startdate),
                ]);
                // echo force_to_AD_date_for_filter($startdate) . '<br>';
            }
            if($dateadded_year < 1900){
                $this->db->where('id', $task['id']);
                $this->db->update('tbltasks', [
                    'dateadded' => ($dateadded),
                ]);
            }

            if($startdate_year > 2100){
                $this->db->where('id', $task['id']);
                $this->db->update('tbltasks', [
                    'startdate' => ($startdate),
                ]);
                // echo force_to_AD_date_for_filter($startdate) . '<br>';
            }
            if($dateadded_year > 2100){
                $this->db->where('id', $task['id']);
                $this->db->update('tbltasks', [
                    'dateadded' => ($dateadded),
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
                    'start_date' => ($startdate),
                ]);
            }
            if($startdate_year > 2100){
                $this->db->where('id', $task['id']);
                $this->db->update('tblmy_cases', [
                    'start_date' => ($startdate),
                ]);
            }

            if($dateline_year < 1900 && $dateline != null){
                $this->db->where('id', $task['id']);
                $this->db->update('tblmy_cases', [
                    'deadline' => ($dateline),
                ]);
            }
            if($dateline_year > 2100 && $dateline != null){
                $this->db->where('id', $task['id']);
                $this->db->update('tblmy_cases', [
                    'deadline' => ($dateline),
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
                    'start_date' => ($startdate),
                ]);
            }
            if($startdate_year > 2100){
                $this->db->where('id', $task['id']);
                $this->db->update('tblmy_other_services', [
                    'start_date' => ($startdate),
                ]);
            }

            if($dateline_year < 1900 && $dateline != null){
                $this->db->where('id', $task['id']);
                $this->db->update('tblmy_other_services', [
                    'deadline' => ($dateline),
                ]);
            }
            if($dateline_year > 2100 && $dateline != null){
                $this->db->where('id', $task['id']);
                $this->db->update('tblmy_other_services', [
                    'deadline' => ($dateline),
                ]);
            }
        }
        echo '<h1>Done</h1>';
    }




}