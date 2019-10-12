<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ServicesSessions_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function count_sessions($service_id, $rel_id){
        $this->db->select('id');
        $this->db->from(db_prefix() . 'my_service_session');
        $this->db->where(['service_id' => $service_id, 'rel_id' => $rel_id]);
        return $this->db->count_all_results();
    }

    public function get_court($id = '')
    {
        if (is_numeric($id)) {
            $this->db->where('c_id', $id);
            return $this->db->get('tblmy_courts')->row();
        }
        $this->db->order_by('court_name', 'asc');
        return $this->db->get('tblmy_courts')->result_array();
    }

    public function get_judges($id = '')
    {
        if (is_numeric($id)) {
            $this->db->where('id', $id);
            return $this->db->get('tblmy_judges')->row();
        }
        $this->db->order_by('id', 'desc');
        return $this->db->get('tblmy_judges')->result_array();
    }

    public function update_customer_report($id, $data)
    {
        $this->db->where(array('task_id' => $id));
        $this->db->set(array('customer_report' => 1));
        $this->db->update(db_prefix() .'my_session_info', $data);
        if ($this->db->affected_rows() > 0) {
            log_activity(' Customer report added [ Session ID ' . $id . ']');
            return true;
        }
        return false;
    }

    public function update_send_to_customer($id)
    {
        $this->db->where(array('task_id' => $id));
        $this->db->set(array('send_to_customer' => 1));
        $this->db->update(db_prefix() .'my_session_info');
        if ($this->db->affected_rows() > 0) {
            //send_mail_template('task_added_as_follower_to_staff', 'baraa-alhalabi@hotmail.com', 1, 1);
            log_activity(' Send Report To Customer [ Session ID ' . $id . ']');
            return true;
        }
        return false;
    }

    public function get_session_data($task_id)
    {
        $this->db->where('task_id' , $task_id);
        $this->db->select('rel_id as tbl1, startdate as tbl5, court_name as tbl4, session_information as tbl7, next_session_date as tbl6, court_decision as tbl8');
        $this->db->join(db_prefix() . 'tasks',  'tasks.id=' . db_prefix() . 'my_session_info.task_id');
        $this->db->join(db_prefix() . 'my_courts',  'my_courts.c_id=' . db_prefix() . 'my_session_info.court_id');
        return $this->db->get(db_prefix() . 'my_session_info')->row();
    }

    public function get_checklist_items($task_id)
    {
        $this->db->where('taskid' , $task_id);
        $this->db->select('description');
        return $this->db->get(db_prefix() . 'task_checklist_items')->result();
    }

}
