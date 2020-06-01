<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ServicesSessions_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('LegalServices/LegalServicesModel' , 'legal');
    }

//    public function count_sessions($service_id, $rel_id){
//        $this->db->select('id');
//        $this->db->from(db_prefix() . 'my_service_session');
//        $this->db->where(['service_id' => $service_id, 'rel_id' => $rel_id]);
//        return $this->db->count_all_results();
//    }

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
        if(isset($data['send_mail_to_opponent']) && $data['send_mail_to_opponent'] == 'true'){
            $send_mail_to_opponent = true;
            unset($data['send_mail_to_opponent']);
        }else{
            $send_mail_to_opponent = false;
            unset($data['send_mail_to_opponent']);
        }
        $sent = $this->send_mail_next_action_session($id, $send_mail_to_opponent);
        if($sent == 1){
            $data['next_session_date'] = to_sql_date($data['next_session_date']);
            $this->db->where('task_id' , $id);
            $this->db->set('customer_report', 1);
            $this->db->update(db_prefix() .'my_session_info', $data);
            if ($this->db->affected_rows() > 0) {
                log_activity(' Customer report added [ Session ID ' . $id . ']');
                return true;
            }
        }else{
            return $sent;
        }
        return false;
    }

    function send_mail_next_action_session($id, $send_mail_to_opponent)
    {
        $this->db->where('id', $id);
        $row = $this->db->get(db_prefix() .'tasks')->row();
        $rel_type = $row->rel_type;
        $rel_id = $row->rel_id;
        $service_id = $this->legal->get_service_id_by_slug($rel_type);
        if($service_id == 1){
            $client_id = get_client_id_by_case_id($rel_id);
            $opponent_id = get_opponent_id_by_case_id($rel_id);
        }else{
            $client_id = get_client_id_by_oservice_id($rel_id);
            $opponent_id = '';
        }
        $this->db->where('userid', $client_id);
        $contact_client = $this->db->get(db_prefix() . 'contacts')->row();
        if(!isset($contact_client)){
            echo 'error_client'; // This customer doesn't have primary contact
            return;
        }
        if($send_mail_to_opponent == true){
            $this->db->where('userid', $opponent_id);
            $contact_opponent = $this->db->get(db_prefix() . 'contacts')->row();
            if(!isset($contact_opponent)){
                echo 'error_opponent'; // This opponent doesn't have primary contact
                return;
            }  else{
                send_mail_template('reminder_for_next_session_action',$contact_opponent, $id);
            }
        }

        if(isset($contact_client)){ // && isset($contact_opponent)
            send_mail_template('reminder_for_next_session_action',$contact_client, $id);
            return true;
        }
        return false;
    }

    public function update_send_to_customer($id)
    {
        //for send email to client
        $sent = $this->send_mail_to_client($id);
        if ($sent == 1){
            $this->db->where(array('task_id' => $id));
            $this->db->set(array('send_to_customer' => 1));
            $this->db->update(db_prefix() .'my_session_info');
            if ($this->db->affected_rows() > 0) {
                log_activity(' Send Report To Customer [ Session ID ' . $id . ']');
                return true;
            }
        }elseif ($sent == 2){
            return 2;
        }
        return false;
    }

    public function send_mail_to_client($id)
    {
        $this->db->where('id', $id);
        $service_data = $this->db->get(db_prefix() .'tasks')->row();
        $rel_type = $service_data->rel_type;
        $rel_id = $service_data->rel_id;
        $service_id = $this->legal->get_service_id_by_slug($rel_type);
        if($service_id == 1){
            $client_id = get_client_id_by_case_id($rel_id);
        }else{
            $client_id = get_client_id_by_oservice_id($rel_id);
        }
        $this->db->where('userid', $client_id);
        $contact = $this->db->get(db_prefix() . 'contacts')->row();
        if(isset($contact)){
            send_mail_template('send_report_session_to_customer', $contact, $service_data);
            return true;
        }
        return 2; // This customer doesn't have primary contact
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
