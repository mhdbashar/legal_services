<?php

class General extends AdminController{

	public function __construct(){
		parent::__construct();
        $this->load->model('Qualification_model');
		$this->load->model('Work_experience_model');
		$this->load->model('Bank_account_model');
        $this->load->model('Document_model');
		$this->load->model('Social_networking_model');
	}

	public function general($staff_id){

        $member = $this->staff_model->get($staff_id);
        if (!$member) {
            blank_page('Staff Member Not Found', 'danger');
        }else{
            $data['staff'] = $member;
            $data['member'] = $member;
        }


        $data['staff_id'] = $staff_id;
        $group = '';

        if(!$this->input->get('group')){
            $_GET['group'] = 'basic_information';
        }else{
            $group = $this->input->get('group');
        }
        if ($this->input->is_ajax_request()) {
            if($group == 'qualification'){
                $this->hrmapp->get_table_data('my_qualifications_table', ['staff_id' => $staff_id]);
            }elseif($group == 'work_experience'){
                $this->hrmapp->get_table_data('my_work_experience_table', ['staff_id' => $staff_id]);
            }elseif($group == 'bank_account'){
                $this->hrmapp->get_table_data('my_bank_account_table', ['staff_id' => $staff_id]);
            }elseif($group == 'document'){
                $this->hrmapp->get_table_data('my_document_table', ['staff_id' => $staff_id]);
            }elseif($group == 'qualification'){
                $this->hrmapp->get_table_data('my_qualifications_table', ['staff_id' => $staff_id]);
            }
        }

        $other_social = ['twitter' => '', 'blogger' => '', 'google_plus' => '', 'instagram' => '', 'pinterest' => '', 'youtube' => ''];

        $data['other_social'] = (object)$other_social;

        if($this->Social_networking_model->get($staff_id)){
            $data['other_social'] = $this->Social_networking_model->get($staff_id);
        }

               
        $data['group'] = $group;
        $data['staff_id'] = $staff_id;
        $data['title'] = _l('general');

        $this->load->view('details/general/manage', $data);
    }

    public function update_social_networking(){
        $hr_data = [];

        $hr_data['staff_id'] = $this->input->post('staff_id');
        $hr_data['twitter'] = $this->input->post('twitter');
        $hr_data['blogger'] = $this->input->post('blogger');
        $hr_data['google_plus'] = $this->input->post('google_plus');
        $hr_data['instagram'] = $this->input->post('instagram');
        $hr_data['pinterest'] = $this->input->post('pinterest');
        $hr_data['youtube'] = $this->input->post('youtube');
        $staff_id = $this->input->post('staff_id');

        $staff_data = [];
        $staff_data['staffid'] = $this->input->post('staff_id');
        $staff_data['facebook'] = $this->input->post('facebook');
        $staff_data['linkedin'] = $this->input->post('linkedin');
        $staff_data['skype'] = $this->input->post('skype');


        if($this->Social_networking_model->get($staff_id)){
            $success = $this->Social_networking_model->update($hr_data, $staff_id);
            $success2 = $this->staff_model->update($staff_data, $staff_id);
        }else{
            $success = $this->Social_networking_model->add($hr_data);
            $success2 = $this->staff_model->update($staff_data, $staff_id);
        }
        if($success or $success2)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function change_password(){
        $data = $this->input->post();
        $staff_id = $this->input->post('staffid');

        $success = $this->staff_model->update($data, $staff_id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function expired_documents(){
    	if ($this->input->is_ajax_request()) {
    		$this->hrmapp->get_table_data('my_expired_documents_table');
    	}
    	$data['title'] = _l('general');
    	$this->load->view('details/general/expired_documents', $data);
    }

    // qualification

    public function json_qualification($id){
        $data = $this->Qualification_model->get($id);
        echo json_encode($data);
    }
    public function update_qualification(){
        $data = $this->input->post();
        $id = $this->input->post('id');
        $success = $this->Qualification_model->update($data, $id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function add_qualification(){
        $data = $this->input->post();
        $success = $this->Qualification_model->add($data);
        if($success)
            set_alert('success', _l('added_successfully'));
        else
            set_alert('warning', 'Problem Creating');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete_qualification($id)
    {
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        if (!is_admin()) {
            access_denied();
        }
        $response = $this->Qualification_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
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

    // document

	public function json_document($id){
        $data = $this->Document_model->get($id);
        echo json_encode($data);
    }
    public function update_document(){
        $data = $this->input->post();
        $id = $this->input->post('id');
        $success = $this->Document_model->update($data, $id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');
        redirect($_SERVER['HTTP_REFERER']);
    }

	public function add_document(){
        $data = $this->input->post();
        $success = $this->Document_model->add($data);
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
        $response = $this->Document_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

}