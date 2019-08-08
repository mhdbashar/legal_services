<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Service_sessions extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Service_sessions_model');
    }

    public function session($service_id, $rel_id)
    {
        $data['service_id'] = $service_id;
        $data['rel_id'] = $rel_id;
        $data['title'] = _l('service_session');
        $data['num_session'] = $this->Service_sessions_model->count_sessions($service_id, $rel_id);

        if ($this->input->is_ajax_request())
            $this->sessionapp->get_table_data('my_service_sessions', $data);

        $this->load->view('session/admin/service_sessions/manage', $data);
    }

    public function session_json($id){
        $data = $this->Service_sessions_model->get($id);
        echo json_encode($data);
    }

    

    public function add($rel_id, $service_id, $staff){

        $data = [
            "subject" => $this->input->get('subject'), 
            "court_id" => $this->input->get('court_id'), 
            "judge_id" => $this->input->get('judge_id'), 
            "date" => $this->input->get('date'),
            "time" => $this->input->get('time') 
        ];
        $data['staff'] = $staff;
        $data['rel_id'] = $rel_id;
        $data['service_id'] = $service_id;
        $success = $this->Service_sessions_model->add($data);
        if($success)
            set_alert('success', _l('session_added_successfuly'));
        else
            set_alert('danger', _l('problem_creating'));
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function update($rel_id, $service_id){
        $data = [
            "subject" => $this->input->get('subject'), 
            "court_id" => $this->input->get('court_id'), 
            "judge_id" => $this->input->get('judge_id'), 
            "date" => $this->input->get('date'),
            "time" => $this->input->get('time') 
        ];

        $id = $this->input->get('id');
        $data['rel_id'] = $rel_id;
        $data['service_id'] = $service_id;
        $success = $this->Service_sessions_model->update($data, $id);
        if($success)
            set_alert('success', _l('session_updated_successfuly'));
        else
            set_alert('danger', _l('problem_updating'));
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete($id){
        $data = ['deleted' => 1];
        $data['rel_id'] = $rel_id;
        $data['service_id'] = $service_id;
        $success = $this->Service_sessions_model->update($data, $id);
        if($success)
            set_alert('success', _l('session_deleted_successfuly'));
        else
            set_alert('danger', _l('problem_deleting'));
        redirect($_SERVER['HTTP_REFERER']);
    }

   

}
