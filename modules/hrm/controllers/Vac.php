<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Vac extends AdminController{

    public function __construct(){
        parent::__construct();
        $this->load->model('vaction');
    }

    public function index(){
        if(!is_admin()){
            access_denied();
        }

        if($this->input->is_ajax_request()){
            $this->hrmapp->get_table_data('my_vac_table');
        }
        $data['title'] = 'Vaction';
        
        $this->load->view('settings/vac', $data);
    }
    public function get($id)
    {
        $data = $this->vaction->getVac($id);
        echo json_encode($data);
    }

    public function add(){
        if (!is_admin()) {
            access_denied();
        }
        if ($this->input->get()) {
            $data            = $this->input->get();
            // $data['message'] = $this->input->post('message', false);
            $success = $this->vaction->add($data);
            if ($success) {
                set_alert('Vaction Added Successfully');
            }
            redirect('hrm/vac');
        }
    }

    
    public function update(){
        if (!is_admin()) {
            access_denied();
        }
        if ($this->input->get()) {
            $data            = $this->input->get();
            $id           = $this->input->get('id');
            // $data['message'] = $this->input->post('message', false);
            $success = $this->vaction->update($data, $id);
            if ($success) {
                set_alert('success', _l('updated_successfully', 'Vac'));
            }
            redirect('hrm/vac');
        }
        if ($id == '')
        redirect('hrm/holidays');
    }
    public function delete($id)
    {
        if (!$id) {
            access_denied();
        }
        if (!is_admin()) {
            access_denied();
        }
        $response = $this->vaction->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted', "Holiday"));
        } else {
            set_alert('warning', _l('problem_deleting', "Holiday"));
        }
        redirect('hrm/vac');
    }
}