<?php

class Organization extends AdminController{

	public function __construct(){
		parent::__construct();
		$this->load->model('Designation_model');
		$this->load->model('Branches_model');
		$this->load->model('Departments_model');
        $this->load->model('Sub_department_model');
        $this->load->model('Official_document_model');
        $this->load->model('Extra_info_model');

	}

	public function officail_documents(){
        if($this->input->is_ajax_request()){
            $this->hrmapp->get_table_data('my_official_documents_table');
        }
        $data['title'] = _l('official_documents');
        $this->load->view('organization/officail_documents', $data);
	}

    // document

    public function json_document($id){
        $data = $this->Official_document_model->get($id);
        echo json_encode($data);
    }
    public function update_document(){
        $data = $this->input->post();
        $id = $this->input->post('id');
        $success = $this->Official_document_model->update($data, $id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function add_document(){
        $data = $this->input->post();
        $success = $this->Official_document_model->add($data);
        if($success)
            set_alert('success', _l('added_successfully'));
        else
            set_alert('warning', 'Problem Creating');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete_document($id)
    {
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        if (!is_admin()) {
            access_denied();
        }
        $response = $this->Official_document_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    //

	public function location(){
		$data['title'] = _l('location');
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
        $data['title'] = _l('designation');
        $this->load->view('organization/designation', $data);
    }

    public function sub_department(){
        if($this->input->is_ajax_request()){
            $this->hrmapp->get_table_data('my_sub_department_table');
        }
        if($this->app_modules->is_active('branches')) {
            $ci = &get_instance();
            $ci->load->model('branches/Branches_model');
            $data['branches'] = $ci->Branches_model->getBranches();
        }
        $data['departments']   = $this->Departments_model->get();
        $data['title'] = _l('sub_department');
        $this->load->view('organization/sub_department', $data);
    }

	// designation

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

    public function get_designations($department_id){
        echo json_encode(['success'=>true,'data'=>$this->Designation_model->get_designations($department_id)]);
        die();
    }

    public function get_designations_by_staff_id($staff_id){
        echo json_encode(['success'=>true, 'data'=>$this->Designation_model->get_designations_by_staff_id($staff_id)]);
        die();
    }


    public function get_staffs_by_branch_id($branch_id){
        echo json_encode(['success'=>true,'data'=>$this->Designation_model->get_staffs_by_branch_id($branch_id)]);
        die();
    }

    // sub_department

    public function get_sub_departments($department_id){
        echo json_encode(['success'=>true,'data'=>$this->Sub_department_model->get_sub_departments($department_id)]);
        die();
    }

    public function json_sub_department($id){
        $data = $this->Sub_department_model->get($id);
        echo json_encode($data);
    }
    public function update_sub_department(){
        $data = $this->input->post();
        if($this->app_modules->is_active('branches')){
            $branch_id = $this->input->post()['branch_id'];

            unset($data['branch_id']);
        }
        $id = $this->input->post('id');
        $success = $this->Sub_department_model->update($data, $id);
        if($this->app_modules->is_active('branches')){
                $this->Branches_model->update_branch('sub_departments', $id, $branch_id);
            }
        if($success){
            set_alert('success', _l('updated_successfully'));
        }
        else
            set_alert('warning', 'Problem Updating');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function add_sub_department(){
        $data = $this->input->post();
        if($this->app_modules->is_active('branches')){
            $branch_id = $this->input->post()['branch_id'];

            unset($data['branch_id']);
        }
        $success = $this->Sub_department_model->add($data);
        if($success){

            if($this->app_modules->is_active('branches')){
                $this->Branches_model->update_branch('sub_departments', $success, $branch_id);
            }
            set_alert('success', _l('added_successfully'));
        }else
            set_alert('warning', 'Problem Creating');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete_sub_department($id)
    {
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        if (!is_admin()) {
            access_denied();
        }
        $response = $this->Sub_department_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
}