<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Basic extends AdminController{

	public function __construct() {
        parent::__construct();
        $this->load->model('basic_details');
    }

    public function edit($id){
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
    		'gender' 						=> $this->input->post('gender'), 
    		'main_salary' 					=> $this->input->post('main_salary'), 
    		'transportation_expenses' 		=> $this->input->post('transportation_expenses'), 
    		'other_expenses' 				=> $this->input->post('other_expenses'), 
            'created'                       => $this->input->post('created')
    	];
    	$this->basic_details->updateStaff($id, $arr, $arr2);
    	redirect('hrm/employees/member/' . $id . '?group=basic');
    }

}