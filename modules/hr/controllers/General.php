<?php

class General extends AdminController{

	public function __construct(){
		parent::__construct();
        $this->load->model('Qualification_model');
		$this->load->model('Work_experience_model');
		$this->load->model('Bank_account_model');
        $this->load->model('Document_model');
		$this->load->model('Social_networking_model');
        $this->load->model('Roles_model');
        $this->load->model('Misc_model');
        $this->load->model('Currencies_model');
        $this->load->model('Departments_model');
        $this->load->model('Immigration_model');
        $this->load->model('Extra_info_model');
        $this->load->model('Emergency_contact_model');
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

        if(!$this->input->get('group') or $this->input->get('group') == 'basic_information'){
            $_GET['group'] = 'basic_information';
            $ts_filter_data = [];
            if ($this->input->get('filter')) {
                if ($this->input->get('range') != 'period') {
                    $ts_filter_data[$this->input->get('range')] = true;
                } else {
                    $ts_filter_data['period-from'] = $this->input->get('period-from');
                    $ts_filter_data['period-to']   = $this->input->get('period-to');
                }
            } else {
                $ts_filter_data['this_month'] = true;
            }
            $data['logged_time'] = $this->staff_model->get_logged_time_data($staff_id, $ts_filter_data);
            $data['timesheets']  = $data['logged_time']['timesheets'];
            $data['base_currency'] = $this->Currencies_model->get_base_currency();
            $data['roles']         = $this->Roles_model->get();
            $data['user_notes']    = $this->Misc_model->get_notes($staff_id, 'staff');
            $data['departments']   = $this->Departments_model->get();
            $data['staff_departments'] = $this->Departments_model->get_staff_departments($member->staffid);
            $extra_info = ['emloyee_id' => '', 'location' => '', 'designation' => '', 'gender' => '', 'marital_status' => '', 'office_sheft' => '', 'date_birth' => '', 'state_province' => '', 'city' => '', 'zip_code' => '', 'address' => ''];

            $data['extra_info'] = (object)$extra_info;

            if($this->Extra_info_model->get($staff_id)){
                $data['extra_info'] = $this->Extra_info_model->get($staff_id);
            }

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
            }elseif($group == 'immigration'){
                $this->hrmapp->get_table_data('my_immigrations_table', ['staff_id' => $staff_id]);
            }elseif($group == 'qualification'){
                $this->hrmapp->get_table_data('my_qualifications_table', ['staff_id' => $staff_id]);
            }elseif($group == 'emergency_contacts'){
                $this->hrmapp->get_table_data('my_emergency_contacts_table', ['staff_id' => $staff_id]);
            }
        }

        if($group == 'social_networking'){
            $other_social = ['twitter' => '', 'blogger' => '', 'google_plus' => '', 'instagram' => '', 'pinterest' => '', 'youtube' => ''];

            $data['other_social'] = (object)$other_social;

            if($this->Social_networking_model->get($staff_id)){
                $data['other_social'] = $this->Social_networking_model->get($staff_id);
            }
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

    /* Add new staff member or edit existing */
    public function member($id = '')
    {
        if (!has_permission('staff', '', 'view')) {
            access_denied('staff');
        }
        hooks()->do_action('staff_member_edit_view_profile', $id);
        $this->load->model('departments_model');

        $hr_data = [];

        $hr_data['staff_id'] = $id;
        $hr_data['emloyee_id'] = $this->input->post('emloyee_id');
        $hr_data['location'] = $this->input->post('location');
        $hr_data['designation'] = $this->input->post('designation');
        $hr_data['gender'] = $this->input->post('gender');
        $hr_data['marital_status'] = $this->input->post('marital_status');
        $hr_data['office_sheft'] = $this->input->post('office_sheft');
        $hr_data['date_birth'] = $this->input->post('date_birth');
        $hr_data['state_province'] = $this->input->post('state_province');
        $hr_data['city'] = $this->input->post('city');
        $hr_data['zip_code'] = $this->input->post('zip_code');
        $hr_data['address'] = $this->input->post('address');
        $staff_id = $id;

        if ($this->input->post()) {
            $data = $this->input->post();
            foreach ($data as $key => $value){
                if (in_array($value, $hr_data))
                    unset($data[$key]);
            }
            // Don't do XSS clean here.
            $data['email_signature'] = $this->input->post('email_signature', false);
            $data['email_signature'] = html_entity_decode($data['email_signature']);

            if ($data['email_signature'] == strip_tags($data['email_signature'])) {
                // not contains HTML, add break lines
                $data['email_signature'] = nl2br_save_html($data['email_signature']);
            }

            $data['password'] = $this->input->post('password', false);

            if ($id == '') {
                if (!has_permission('staff', '', 'create')) {
                    access_denied('staff');
                }
                $id = $this->staff_model->add($data);
                if ($id) {

                    handle_staff_profile_image_upload($id);
                    set_alert('success', _l('added_successfully', _l('staff_member')));
                    redirect(admin_url('staff/member/' . $id));
                }
            } else {
                if (!has_permission('staff', '', 'edit')) {
                    access_denied('staff');
                }
                handle_staff_profile_image_upload($id);

                if($this->Extra_info_model->get($id)){
                    $success = $this->Extra_info_model->update($hr_data, $id);
                    $response = $this->staff_model->update($data, $id);
                }else{
                    $success = $this->Extra_info_model->add($hr_data);
                    $response = $this->staff_model->update($data, $id);
                }
                if (is_array($response)) {
                    if (isset($response['cant_remove_main_admin'])) {
                        set_alert('warning', _l('staff_cant_remove_main_admin'));
                    } elseif (isset($response['cant_remove_yourself_from_admin'])) {
                        set_alert('warning', _l('staff_cant_remove_yourself_from_admin'));
                    }
                } elseif ($response == true and $success == true) {
                    set_alert('success', _l('updated_successfully', _l('staff_member')));
                }
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('staff_member_lowercase'));
        } else {
            $member = $this->staff_model->get($id);
            if (!$member) {
                blank_page('Staff Member Not Found', 'danger');
            }
            $data['member']            = $member;
            $title                     = $member->firstname . ' ' . $member->lastname;
            $data['staff_departments'] = $this->departments_model->get_staff_departments($member->staffid);

            $ts_filter_data = [];
            if ($this->input->get('filter')) {
                if ($this->input->get('range') != 'period') {
                    $ts_filter_data[$this->input->get('range')] = true;
                } else {
                    $ts_filter_data['period-from'] = $this->input->get('period-from');
                    $ts_filter_data['period-to']   = $this->input->get('period-to');
                }
            } else {
                $ts_filter_data['this_month'] = true;
            }

            $data['logged_time'] = $this->staff_model->get_logged_time_data($id, $ts_filter_data);
            $data['timesheets']  = $data['logged_time']['timesheets'];
        }
        $this->load->model('currencies_model');
        $data['base_currency'] = $this->currencies_model->get_base_currency();
        $data['roles']         = $this->roles_model->get();
        $data['user_notes']    = $this->misc_model->get_notes($id, 'staff');
        $data['departments']   = $this->departments_model->get();
        $data['title']         = $title;

        $this->load->view('admin/staff/member', $data);
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


    // qualification

    public function json_emergency_contact($id){
        $data = $this->Emergency_contact_model->get($id);
        echo json_encode($data);
    }
    public function update_emergency_contact(){
        $data = $this->input->post();
        $id = $this->input->post('id');
        $success = $this->Emergency_contact_model->update($data, $id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function add_emergency_contact(){
        $data = $this->input->post();
        $success = $this->Emergency_contact_model->add($data);
        if($success)
            set_alert('success', _l('added_successfully'));
        else
            set_alert('warning', 'Problem Creating');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete_emergency_contact($id)
    {
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        if (!is_admin()) {
            access_denied();
        }
        $response = $this->Emergency_contact_model->delete($id);
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

    // immigration

    public function json_immigration($id){
        $data = $this->Immigration_model->get($id);
        echo json_encode($data);
    }
    public function update_immigration(){
        $data = $this->input->post();
        $id = $this->input->post('id');
        $success = $this->Immigration_model->update($data, $id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function add_immigration(){
        $data = $this->input->post();
        $success = $this->Immigration_model->add($data);
        if($success)
            set_alert('success', _l('added_successfully'));
        else
            set_alert('warning', 'Problem Creating');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete_immigration($id)
    {
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        if (!is_admin()) {
            access_denied();
        }
        $response = $this->Immigration_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

}