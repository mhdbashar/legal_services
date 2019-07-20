<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Award extends AdminController{
	public function __construct(){
        parent::__construct();
        $this->load->model('awards');
    }

    public function index(){
        if(!is_admin()){
            access_denied();
        }

        if($this->input->is_ajax_request()){
            $this->hrmapp->get_table_data('my_award_table');
        }
        $data['title'] = 'awards';
        
        $this->load->view('awards/award', $data);
    }
    public function get($id)
    {
        $data = $this->awards->getAward($id);
        echo json_encode($data);
    }


    
    public function update(){
        if (!is_admin()) {
            access_denied();
        }
        if ($this->input->get()) {
            $data            = $this->input->get();
            $id           = $this->input->get('id');
            // $data['message'] = $this->input->post('message', false);
            $success = $this->awards->update($data, $id);
            if ($success) {
                set_alert('success', _l('updated_successfully', 'Award'));
            }
            redirect('hrm/award');
        }
        if ($id == '')
        redirect('hrm/award');
    }    
   
    public function AddNew(){
        if (!is_admin()) {
            access_denied();
        }
        if ($this->input->get()) {
            $data            = $this->input->get();
            
            $data['date'] = '20' . date('y') . '-' . date('m');
            $id           = $this->input->get('id');
            // $data['message'] = $this->input->post('message', false);
            $success = $this->awards->update($data, $id);
            if ($success) {
                set_alert('success', 'Award Added Successfully');
            }
            redirect('hrm/award');
        }
        if ($id == '')
        redirect('hrm/award');
    }

    public function delete($id)
    {
        if (!$id) {
            access_denied();
        }
        if (!is_admin()) {
            access_denied();
        }
        $response = $this->awards->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted', "Award"));
        } else {
            set_alert('warning', _l('problem_deleting', "Award"));
        }
        redirect('hrm/award');
    }
}