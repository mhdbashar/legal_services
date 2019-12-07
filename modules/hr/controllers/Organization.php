<?php

class Organization extends AdminController{

	public function __construct(){
		parent::__construct();
		$this->load->model('Designation_model');
		$this->load->model('Branches_model');
		$this->load->model('Departments_model');

	}

	public function officail_documents(){

	}

	public function location(){
		$data['title'] = 'Location';
		$this->load->view('organization/location', $data);
	}

	public function designation(){
		if($this->input->is_ajax_request()){
            $this->hrmapp->get_table_data('my_designation_table');
        }
        if($this->app_modules->is_active('branches')) {
            $ci = &get_instance();
            $ci->load->model('branches/Branches_model');
            $data['branches'] = $ci->Branches_model->getBranches();
        }
        $data['departments']   = $this->Departments_model->get();
		$data['title'] = 'designation';
		$this->load->view('organization/designation', $data);
	}

	// work_experience

	public function json_designation($id){
        $data = $this->Designation_model->get($id);
        echo json_encode($data);
    }
    public function update_designation(){
        $data = $this->input->post();
        if($this->app_modules->is_active('branches')){
            $branch_id = $this->input->post()['branch_id'];

            unset($data['branch_id']);
        }
        $id = $this->input->post('id');
        $success = $this->Designation_model->update($data, $id);
        if($this->app_modules->is_active('branches')){
	            $this->Branches_model->update_branch('designations', $id, $branch_id);
	        }
        if($success){
        	set_alert('success', _l('updated_successfully'));
        }
        else
            set_alert('warning', 'Problem Updating');
        redirect($_SERVER['HTTP_REFERER']);
    }

	public function add_designation(){
		$data = $this->input->post();
		if($this->app_modules->is_active('branches')){
            $branch_id = $this->input->post()['branch_id'];

            unset($data['branch_id']);
        }
        $success = $this->Designation_model->add($data);
        if($success){

	        if($this->app_modules->is_active('branches')){
	            $this->Branches_model->update_branch('designations', $success, $branch_id);
	        }
            set_alert('success', _l('added_successfully'));
        }else
            set_alert('warning', 'Problem Creating');
        redirect($_SERVER['HTTP_REFERER']);
	}

	public function delete_designation($id)
	{
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        if (!is_admin()) {
            access_denied();
        }
        $response = $this->Designation_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
}