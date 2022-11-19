<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Regular_duration_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    //**************************
    public function get_durations_by_id()
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
        $this->db->where('id', $data['id']);
        $this->db->update(db_prefix() . 'my_cases', $data);
        if ($this->db->affected_rows() > 0) {
            log_activity('duration Updated [DurationID:]');
            return true;
        }
        return false;
    }
 //***********************
    public  function dur_alert_close_model($case_id)
    {
         $this->db->where('id',$case_id);
         $this->db->update(db_prefix() . 'my_cases', ['dur_alert_close' => date('Y-m-d')]);
        if ($this->db->affected_rows() > 0) {
            log_activity('duration Updated [DurationID:]');
            return true;
        }
    }

    //***************************
    public  function clear_dur_notified_model($case_id)
    {
        $this->db->where('id',$case_id);
        $this->db->update(db_prefix() . 'my_cases', ['deadline_notified' => 0 , 'dur_alert_close' => 2022-11-01 , 'regular_header' => 0]);
        if ($this->db->affected_rows() > 0) {
            log_activity('duration Updated [DurationID:]');
            return true;
        }
    }






}
