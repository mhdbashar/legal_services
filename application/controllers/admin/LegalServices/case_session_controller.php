<?php

defined('BASEPATH') or exit('No direct script access allowed');

    class case_session_controller extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('LegalServices/case_session_model', 'case_session');
    }

    public function session($service_id, $rel_id)
    {
        $data['service_id']  = $service_id;
        $data['rel_id']      = $rel_id;
        $data['title']       = _l('service_session');
        $data['num_session'] = $this->case_session->count_sessions($service_id, $rel_id);
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('my_service_sessions', $data);
        }
        $this->load->view('admin/LegalServices/cases/case_session', $data);
    }

    public function session_json($id){
        $data = $this->case_session->get($id);
        echo json_encode($data);
    }

}
