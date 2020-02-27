<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Training extends AdminController{
	public function __construct(){
        parent::__construct();
        $this->load->model('Train');
    }

    public function index(){
        if(!is_admin()){
            access_denied();
        }
        if($this->input->is_ajax_request()){
            $this->hrmapp->get_table_data('my_training_table');
        }
        $data['title'] = 'Training';


        $data['status'] = $this->Train->get_statuses();
        
        $this->load->view('training/training', $data);
    }


    public function add(){
        if(!is_admin()){
            access_denied();
        }

        
        $data['title'] = 'Add New Training';
        
        $data['statuses'] = $this->Train->get_statuses();
        $data['performances'] = $this->Train->get_performances();
        
        $this->load->view('training/training_add', $data);
    }


    public function edit($id){
        if(!is_admin()){
            access_denied();
        }

        if (!$id) {
            redirect('hrm/Training');
        }

        $data['title'] = 'Edit Training';
        
        $data = $this->Train->getTrains($id);
        $data['attachments'] = $this->Train->get_training_attachments($id);
        
        $data['statuses'] = $this->Train->get_statuses();
        $data['performances'] = $this->Train->get_performances();
        
        $this->load->view('training/training_edit', $data);
    }


    public function get($id)
    {
        $data = $this->Train->getTrains($id);

        $data['attachments'] = $this->Train->get_training_attachments($id);

        echo json_encode($data);
    }


    
    /*public function update(){
        if (!is_admin()) {
            access_denied();
        }
        if ($this->input->post()) {
            $data            = $this->input->post();
            $id           = $this->input->post('id');
            $success = $this->Train->update($data, $id);
            if ($success) {
                set_alert('success', _l('updated_successfully', 'Training'));
            }
            redirect('hrm/Training');
        }
        if ($id == '')
            redirect('hrm/Training');
    }*/
    
    public function AddNew(){
        if (!is_admin()) {
            access_denied();
        }
        if ($this->input->post()) {
            $data            = $this->input->post();
            $id           = $this->input->post('id');
            $success = $this->Train->update($data, $id);
            if ($success) {
                set_alert('success', 'Training Records Updated Successfully');
            }
            redirect('hrm/Training');
        }
        if ($id == '')
            redirect('hrm/Training');
    }
    
    public function delete($id)
    {
        if (!$id) {
            access_denied();
        }
        if (!is_admin()) {
            access_denied();
        }
        $response = $this->Train->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted', "Training"));
        } else {
            set_alert('warning', _l('problem_deleting', "Training"));
        }
        redirect('hrm/Training');
    }
    
    public function delete_attachment($id)
    {
        if (is_admin() || (!is_admin() && get_option('allow_non_admin_staff_to_delete_ticket_attachments') == '1')) {
            $this->Train->delete_attachment($id);
        }

        redirect($_SERVER['HTTP_REFERER']);
    }
}