<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Regular_duration_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    //**************************
    public function get_durations()
    {
        return $this->db->get_where(db_prefix() . 'regular_durations')->result();
    }

    //**********************

    public function get_duration_by_id($id)
    {
        return $this->db->get_where(db_prefix() . 'regular_durations', array('id' => $id))->row();
    }

    //*****************************************
    public function add_new_duration($data)
    {
        $this->db->insert(db_prefix() . 'regular_durations', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('New regular_duration Added [CourtID: ' . $insert_id . ' name: ' . $data['name'] . ']');
        }
        return $insert_id;
    }
//****************************************
      public function update_duration_data($id,$data)
    {
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'regular_durations', $data);
        if ($this->db->affected_rows() > 0) {
            log_activity('duration Updated [DurationID: ' . $id . ']');
            return true;
        }
        return false;
    }
//************************************
    public function delete_duration($id)
    {

        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'regular_durations');
        if ($this->db->affected_rows() > 0) {
            log_activity('duration Deleted [durationID: ' . $id . ']');
            return true;
        }
        return false;
    }
//**********tab**************
    public function add_new_duration_cases($data)
    {
        $days=get_dur_number_of_days_by_id($data['reg_id']);
        $duration_date=$data['start_date'];
        $end_date_case  = strtotime($duration_date . " +".$days."days");
        $end_date_case = date('Y-m-d',$end_date_case);
        $data['days']=$days;
        $data['end_date']=$end_date_case;
        $data['deadline_notified']=0;
        $data['	regular_header']=0;
        $data['dur_alert_close']=0;
        //--------
        $data2['reg_id']=$data['reg_id'];
        $data2['case_id']=$data['case_id'];
        $this->db->insert(db_prefix() . 'durations_cases',$data2);
        $insert_id = $this->db->insert_id();
        $data['id']=$insert_id;


        $this->db->insert(db_prefix() . 'cases_regular_durations',$data);
        if ($this->db->affected_rows() > 0) {
            log_activity('duration Updated [DurationID:]');
            return true;
        }
        return false;


    }
    //**********update_case_duration_data************
    public function update_case_duration_data($case_duration_id,$data)
    {
        $days = get_dur_number_of_days_by_id($data['reg_id']);
        $duration_date=$data['start_date'];
        $end_date_case  = strtotime($duration_date . " +".$days."days");
        $end_date_case = date('Y-m-d',$end_date_case);
        $data['days']=$days;
        $data['end_date']=$end_date_case;
        $data['deadline_notified']=0;
        $data['	regular_header']=0;
        $data['dur_alert_close']=0;

        $this->db->where('id', $case_duration_id);
        $this->db->update(db_prefix() . 'cases_regular_durations', $data);
        if ($this->db->affected_rows() > 0) {
            log_activity('duration Updated [DurationID: ' . $case_duration_id . ']');
            return true;
        }
        return false;

    }
    //************************************
  public function delete_case_duration($case_duration_id)
    {

        $this->db->where('id', $case_duration_id);
        $this->db->delete(db_prefix() . 'cases_regular_durations');
        if ($this->db->affected_rows() > 0) {
            log_activity('duration Deleted [durationID: ' . $case_duration_id . ']');
            return true;
        }
        return false;
    }
 //***********************
    public  function dur_alert_close_model($id)
    {
         $this->db->where('id',$id);
         $this->db->update(db_prefix() . 'cases_regular_durations', ['dur_alert_close' => date('Y-m-d')]);
        if ($this->db->affected_rows() > 0) {
            log_activity('duration Updated [DurationID:]');
            return true;
        }
    }
    //***************************
    public  function clear_dur_notified_model($case_id)
    {
        $this->db->where('id',$case_id);
        $this->db->update(db_prefix() . 'my_cases', ['deadline_notified' => 0 , 'dur_alert_close' => 2022-11-01 , 'regular_header' => 0 , 'deadline_notified2' => 0 , 'dur_alert_close2' => 2022-11-01 , 'regular_header2' => 0]);
        if ($this->db->affected_rows() > 0) {
            log_activity('duration Updated [DurationID:]');
            return true;
        }
    }
    //*************************************
    public function get_case_durations_by_id()
    {
        return $this->db->get_where(db_prefix() . 'cases_regular_durations')->result();
    }

    //**********************

    public function get_case_duration_by_id($id)
    {
        return $this->db->get_where(db_prefix() . 'cases_regular_durations', array('id' => $id))->row();
    }

    //*****************************************









}
