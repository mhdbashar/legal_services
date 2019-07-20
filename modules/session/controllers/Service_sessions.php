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
        $data['title'] = 'Service Sessions';

        if ($this->input->is_ajax_request())
            $this->sessionapp->get_table_data('my_service_sessions', $data);

        $this->load->view('session/admin/service_sessions/manage', $data);
    }

    public function session_json($id){
        $data = $this->Service_sessions_model->get($id);
        echo json_encode($data);
    }

    public function add($rel_id, $service_id, $staff){
        $data = $this->input->get();
        $data['staff'] = $staff;
        $data['rel_id'] = $rel_id;
        $data['service_id'] = $service_id;
        $success = $this->Service_sessions_model->add($data);
        if($success)
            set_alert('success', 'Added Successfuly');
        else
            set_alert('danger', 'Problem Deleting');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function update($rel_id, $service_id){
        $data = $this->input->get();
        $id = $this->input->get('id');
        $data['rel_id'] = $rel_id;
        $data['service_id'] = $service_id;
        $success = $this->Service_sessions_model->update($data, $id);
        if($success)
            set_alert('success', 'Updated Successfuly');
        else
            set_alert('danger', 'Problem Updating');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete($id){
        $data = ['deleted' => 1];
        $data['rel_id'] = $rel_id;
        $data['service_id'] = $service_id;
        $success = $this->Service_sessions_model->update($data, $id);
        if($success)
            set_alert('success', 'Deleted Successfuly');
        else
            set_alert('danger', 'Problem Deleting');
        redirect($_SERVER['HTTP_REFERER']);
    }

   

}
