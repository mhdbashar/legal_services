<?php

class General extends AdminController{

	public function __construct(){
		parent::__construct();
		$this->load->model('Work_experience_model');
		$this->load->model('Bank_account_model');
	}

	public function general($staff_id){

        $data['staff_id'] = $staff_id;
        $group = '';

        if(!$this->input->get('group')){
            $_GET['group'] = 'basic_information';
        }else{
            $group = $this->input->get('group');
        }
        if ($this->input->is_ajax_request()) {
            if($group == 'qualification'){
                $this->hrmapp->get_table_data('my_qualification_table', ['staff_id' => $staff_id]);
            }elseif($group == 'work_experience'){
                $this->hrmapp->get_table_data('my_work_experience_table', ['staff_id' => $staff_id]);
            }elseif($group == 'bank_account'){
                $this->hrmapp->get_table_data('my_bank_account_table', ['staff_id' => $staff_id]);
            }elseif($group == 'overtime'){
                $this->hrmapp->get_table_data('my_overtime_table', ['staff_id' => $staff_id]);
            }elseif($group == 'allowances'){
                $this->hrmapp->get_table_data('my_allowances_table', ['staff_id' => $staff_id]);
            }elseif($group == 'statutory_deductions'){
                $this->hrmapp->get_table_data('my_statutory_deductions_table', ['staff_id' => $staff_id]);
            }
        }
        $data['group'] = $group;
        $data['staff_id'] = $staff_id;
        $data['title'] = _l('general');

        $this->load->view('details/general/manage', $data);
    }

    // work_experience

	public function json_work_experience($id){
        $data = $this->Work_experience_model->get($id);
        echo json_encode($data);
    }
    public function update_work_experience(){
        $data = $this->input->post();
        $id = $this->input->post('id');
        $success = $this->Work_experience_model->update($data, $id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');
        redirect($_SERVER['HTTP_REFERER']);
    }

	public function add_work_experience(){
        $data = $this->input->post();
        $success = $this->Work_experience_model->add($data);
        if($success)
            set_alert('success', _l('added_successfully'));
        else
            set_alert('warning', 'Problem Creating');
        redirect($_SERVER['HTTP_REFERER']);
	}

	public function delete_work_experience($id)
	{
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        if (!is_admin()) {
            access_denied();
        }
        $response = $this->Work_experience_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    // bank_account

	public function json_bank_account($id){
        $data = $this->Bank_account_model->get($id);
        echo json_encode($data);
    }
    public function update_bank_account(){
        $data = $this->input->post();
        $id = $this->input->post('id');
        $success = $this->Bank_account_model->update($data, $id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');
        redirect($_SERVER['HTTP_REFERER']);
    }

	public function add_bank_account(){
        $data = $this->input->post();
        $success = $this->Bank_account_model->add($data);
        if($success)
            set_alert('success', _l('added_successfully'));
        else
            set_alert('warning', 'Problem Creating');
        redirect($_SERVER['HTTP_REFERER']);
	}

	public function delete_bank_account($id)
	{
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        if (!is_admin()) {
            access_denied();
        }
        $response = $this->Bank_account_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
}