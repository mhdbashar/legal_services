<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Details extends AdminController{

	public function __construct() {
        parent::__construct();
        $this->load->model('Details_model');
    }

    public function edit_basic_details($id){
        if(!is_admin()){
            access_denied();
        }

    	$arr = [
    		'firstname' 	=> $this->input->post('firstname'), 
    		'lastname' 		=> $this->input->post('lastname'), 
    		'facebook'		=> $this->input->post('facebook'), 
    		'email' 		=> $this->input->post('email'), 
    		'phonenumber' 	=> $this->input->post('phonenumber'), 
    		'skype' 		=> $this->input->post('skype'), 
    		'hourly_rate' 	=> $this->input->post('hourly_rate'), 
    	];
        
    	$arr2 = [
            'staff_id'                      => $id, 
           'job_title'                      => $this->input->post('job_title'), 
           'period'                      => $this->input->post('period'), 
    		'gender' 						=> $this->input->post('gender'), 
    		'main_salary' 					=> $this->input->post('main_salary'), 
    		'transportation_expenses' 		=> $this->input->post('transportation_expenses'), 
    		'other_expenses' 				=> $this->input->post('other_expenses'), 
            'created'                       => $this->input->post('created')
    	];
    	$success = $this->Details_model->updateStaff($id, $arr, $arr2);
        if ($success)
            set_alert('success', 'Staff Details Updated Successfully');
        else
            set_alert('danger', 'Problem Updating');
    	redirect('hrm/employees/member/' . $id . '?group=basic');
    }

    public function add_bank(){
        if(!is_admin()){
            access_denied();
        }
        $data = $this->input->post();
        $success = $this->Details_model->add_bank($data);
        if($success)
            set_alert('success', 'Bank Added Successfully');
        else
            set_alert('danger', 'Problem Adding');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function edit_bank(){
        if(!is_admin()){
            access_denied();
        }
        $data = $this->input->post();
        $id = $this->input->post('id');
        $success = $this->Details_model->edit_bank($data, $id);
        if($success)
            set_alert('success', 'Bank Updated Successfully');
        else
            set_alert('danger', 'Problem Updating');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function get_bank($id){
        $data = $this->Details_model->get_bank($id);
        echo json_encode($data);
    }

    public function delete_bank($id){
        if(!is_admin()){
            access_denied();
        }

        $success = $this->Details_model->delete_bank($id);
        if($success)
            set_alert('success', 'Bank Deleted Successfully');
        else
            set_alert('danger', 'Problem Deleting');
        redirect($_SERVER['HTTP_REFERER']);
    }

}