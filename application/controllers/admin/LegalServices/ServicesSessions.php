<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ServicesSessions extends AdminController{

	public function __construct()
    {
        parent::__construct();
        $this->load->model('LegalServices/ServicesSessions_model', 'service_sessions');
    }

    public function edit_customer_report($id)
    {
        if(!$id){
            set_alert('danger', _l('WrongEntry'));
            redirect($_SERVER['HTTP_REFERER']);
        }
        if ($this->input->post()) {
            $data = $this->input->post();
            $success = $this->service_sessions->update_customer_report($id, $data);
            if ($success) {
                echo 1;
            }else {
                echo 0;
            }
        }
    }

    public function update_session_court_decision($id)
    {
        if (has_permission('tasks', '', 'edit')) {
            $this->db->where('task_id', $id);
            $this->db->update(db_prefix() . 'my_session_info', [
                'court_decision' => $this->input->post('court_decision', false),
            ]);
        }
    }

    public function update_session_information($id)
    {
        if (has_permission('tasks', '', 'edit')) {
            $this->db->where('task_id', $id);
            $this->db->update(db_prefix() . 'my_session_info', [
                'session_information' => $this->input->post('session_information', false),
            ]);
        }
    }

    public function send_report_to_customer($task_id)
    {
        $success = $this->service_sessions->update_send_to_customer($task_id);
        if ($success) {
            echo 1;
        }else {
            echo 0;
        }
    }

    public function print_report($task_id)
    {
        $response = array();
        $response = $this->service_sessions->get_session_data($task_id);
        $client_id = get_client_id_by_case_id($response->tbl1);
        $opponent_id = get_opponent_id_by_case_id($response->tbl1);
        $client_name = get_company_name($client_id);
        $opponent_name = get_company_name($opponent_id);
        $response->tbl2 = $client_name;
        $response->tbl3 = $opponent_name;
        echo json_encode($response);
    }

    public function checklist_items($task_id)
    {
        $response = $this->service_sessions->get_checklist_items($task_id);
        echo json_encode($response);
    }
}