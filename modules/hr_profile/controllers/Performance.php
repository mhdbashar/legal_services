<?php

class Performance extends AdminController{

	public function __construct(){
		parent::__construct();
		$this->load->model('Indicator_model');
		$this->load->model('Appraisal_model');
        $this->load->model('Hr_profile_model');


       /* if (!has_permission('hr', '', 'view_own') && !has_permission('hr', '', 'view'))
            access_denied();

        $total_complete_staffs = $this->db->count_all_results(db_prefix() . 'hr_extra_info');
        $total_staffs = $this->db->count_all_results(db_prefix() . 'staff');
        if($total_complete_staffs != $total_staffs) {
            set_alert('warning', _l('you_have_to_complete_staff_informations'));
            redirect(admin_url('hr/general/staff'));
        }*/ 
	}

	//indicators

	public function indicators(){
		if($this->input->is_ajax_request()){
            $this->load->library("hr_profile/HrmApp");
            $this->hrmapp->get_table_data("my_indicators_table");
        }
        $data['title'] = _l('indicator');
		$data['job_position'] = $this->Hr_profile_model->get_job_position();
        
        $this->load->view('performance/indicator/manage', $data);
	}

	public function json_indicator($id){
        $data = $this->Indicator_model->get($id);
        echo json_encode($data);
    }
    public function update_indicator(){
        $data = $this->input->post();
        $id = $this->input->post('id');
        $success = $this->Indicator_model->update($data, $id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');
        redirect($_SERVER['HTTP_REFERER']);
    }

	public function add_indicator(){
        $data = $this->input->post();
        $data['added_by'] = get_staff_user_id();
        $success = $this->Indicator_model->add($data);
        if($success)
            set_alert('success', _l('added_successfully'));
        else
            set_alert('warning', 'Problem Creating');
        redirect($_SERVER['HTTP_REFERER']);
	}

	public function delete_indicator($id)
	{
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        if (!is_admin()) {
            access_denied();
        }
        $response = $this->Indicator_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    //appraisals

	public function appraisals(){
		if($this->input->is_ajax_request()){
            $this->load->library("hr_profile/hrmApp");
            $this->hrmapp->get_table_data('my_appraisals_table');
        }
        $this->load->model("Staff_model");
        $data['title'] = _l('appraisals');
        $data['job_position'] = $this->Hr_profile_model->get_job_position();
        $data['staffs'] = $this->Staff_model->get();
        
        $this->load->view('performance/appraisal/manage', $data);
	}



    //wasemalnajjar

	public function json_appraisal($id){
        $data = $this->Appraisal_model->get($id);
        echo json_encode($data);
    }

    public function update_appraisal(){
        $data = $this->input->post();
        $id = $this->input->post('id');
        $success = $this->Appraisal_model->update($data, $id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');
        redirect($_SERVER['HTTP_REFERER']);
    }

	public function add_appraisal(){
        $data = $this->input->post();
        $success = $this->Appraisal_model->add($data);
        if($success)
            set_alert('success', _l('added_successfully'));
        else
            set_alert('warning', 'Problem Creating');
        redirect($_SERVER['HTTP_REFERER']);
	}

	public function delete_appraisal($id)
	{
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        if (!is_admin()) {
            access_denied();
        }
        $response = $this->Appraisal_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
}
   /* public function get_designations_by_branch_id($branch_id){
    	$this->db->select('*');
    	$this->db->where(['branch_id' => $branch_id, 'rel_type' => 'departments']);
    	$this->db->from(db_prefix() . 'branches_services');
    	$this->db->join(db_prefix() . 'hr_designations', db_prefix() . 'hr_designations.department_id = '.db_prefix().'branches_services.rel_id', 'inner');
    	$branches = $this->db->get()->result();
        $data = [];
        foreach ($branches as $branch) {
	            // if($this->Extra_info_model->get($staff_id)->designation == $row['id']){
	            //     continue;
	            // }
	            $data[] = ['key' => $branch->id, 'value' => $branch->designation_name];
        }
        echo json_encode(['success'=>true,'data'=>$data]);
    }
}*/