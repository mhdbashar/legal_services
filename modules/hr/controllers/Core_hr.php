<?php

class Core_hr extends AdminController{

	public function __construct(){
		parent::__construct();
		$this->load->model('Awards_model');
        $this->load->model('Terminations_model');
		$this->load->model('Branches_model');
		$this->load->model('Staff_model');
        $this->load->model('Warnings_model');
        $this->load->model('Transfers_model');
        $this->load->model('Extra_info_model');
        $this->load->model('Sub_department_model');
        $this->load->model('Complaint_model');
        $this->load->model('Resignations_model');
        $this->load->model('Promotion_model');
	}
    // awards

    public function awards(){
        if($this->input->is_ajax_request()){
            $this->hrmapp->get_table_data('my_awards_table');
        }
        if($this->app_modules->is_active('branches')) {
            $ci = &get_instance();
            $ci->load->model('branches/Branches_model');
            $data['branches'] = $ci->Branches_model->getBranches();
        }
        $data['staffes'] = $this->Staff_model->get();
        $data['title'] = _l('awards');
        $this->load->view('core_hr/awards/manage', $data);
    }


    public function json_document($id){
        $branch_id = '';
        if($this->Branches_model->get('awards', $id))
            $branch_id = $this->Branches_model->get_branch('awards', $id);
        $data = $this->Awards_model->get($id);
        $data->branch_id = $branch_id;
        echo json_encode($data);
    }
    public function update_document(){
        $data = $this->input->post();
        $branch_id = $data['branch_id'];
        unset($data['branch_id']);
        $id = $this->input->post('id');
        $success = $this->Awards_model->update($data, $id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');

            $this->Branches_model->update_branch('awards', $id, $branch_id);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function add_document(){
        $data = $this->input->post();
        $branch_id = $data['branch_id'];
        unset($data['branch_id']);

        $success = $this->Awards_model->add($data);
        if($success)
            set_alert('success', _l('added_successfully'));
        else
            set_alert('warning', 'Problem Creating');


        if(is_numeric($branch_id)){
            $branch_data = [
                'branch_id' => $branch_id, 
                'rel_type' => 'awards', 
                'rel_id' => $success
            ];
            $this->Branches_model->set_branch($branch_data);
        }
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
        $response = $this->Awards_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    // complaint

    public function complaints(){
        if($this->input->is_ajax_request()){
            $this->hrmapp->get_table_data('my_complaints_table');
        }
        if($this->app_modules->is_active('branches')) {
            $ci = &get_instance();
            $ci->load->model('branches/Branches_model');
            $data['branches'] = $ci->Branches_model->getBranches();
        }
        $data['staffes'] = $this->Staff_model->get();
        $data['title'] = _l('complaints');
        $this->load->view('core_hr/complaints/manage', $data);
    }

    public function complaint_json($id){
        $branch_id = '';
        if($this->Branches_model->get('complaints', $id))
            $branch_id = $this->Branches_model->get_branch('complaints', $id);
        $data = $this->Complaint_model->get($id);
        $data->branch_id = $branch_id;
        echo json_encode($data);
    }
    public function update_complaint(){
        $data = $this->input->post();
        $branch_id = $data['branch_id'];
        unset($data['branch_id']);
        $id = $this->input->post('id');
        $success = $this->Complaint_model->update($data, $id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');

            $this->Branches_model->update_branch('complaints', $id, $branch_id);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function add_complaint(){
        $data = $this->input->post();
        $branch_id = $data['branch_id'];
        unset($data['branch_id']);

        $success = $this->Complaint_model->add($data);
        if($success)
            set_alert('success', _l('added_successfully'));
        else
            set_alert('warning', 'Problem Creating');


        if(is_numeric($branch_id)){
            $branch_data = [
                'branch_id' => $branch_id, 
                'rel_type' => 'complaints', 
                'rel_id' => $success
            ];
            $this->Branches_model->set_branch($branch_data);
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete_complaint($id)
    {
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        if (!is_admin()) {
            access_denied();
        }
        $response = $this->Complaint_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    // promotion

    public function promotions(){
        $this->load->model('Departments_model');
        $this->load->model('Designation_model');
        $data['departments'] = $this->Departments_model->get();
        $data['designations'] = $this->Designation_model->get();
        if($this->input->is_ajax_request()){
            $this->hrmapp->get_table_data('my_promotions_table');
        }
        if($this->app_modules->is_active('branches')) {
            $ci = &get_instance();
            $ci->load->model('branches/Branches_model');
            $data['branches'] = $ci->Branches_model->getBranches();
        }
        $data['staffes'] = $this->Staff_model->get();
        $data['title'] = _l('promotions');
        $this->load->view('core_hr/promotions/manage', $data);
    }

    public function promotion_json($id){
        $branch_id = '';
        if($this->Branches_model->get('promotions', $id))
            $branch_id = $this->Branches_model->get_branch('promotions', $id);
        $data = $this->Promotion_model->get($id);
        $data->branch_id = $branch_id;
        echo json_encode($data);
    }
    public function update_promotion(){
        $data = $this->input->post();
        $branch_id = $data['branch_id'];
        unset($data['branch_id']);
        $id = $this->input->post('id');
        $success = $this->Promotion_model->update($data, $id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');

            $this->Branches_model->update_branch('promotions', $id, $branch_id);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function add_promotion(){
        $data = $this->input->post();
        $branch_id = $data['branch_id'];
        unset($data['branch_id']);

        $success = $this->Promotion_model->add($data);
        if($success)
            set_alert('success', _l('added_successfully'));
        else
            set_alert('warning', 'Problem Creating');


        if(is_numeric($branch_id)){
            $branch_data = [
                'branch_id' => $branch_id, 
                'rel_type' => 'promotions', 
                'rel_id' => $success
            ];
            $this->Branches_model->set_branch($branch_data);
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete_promotion($id)
    {
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        if (!is_admin()) {
            access_denied();
        }
        $response = $this->Promotion_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    // resignation

    public function resignations(){
        if($this->input->is_ajax_request()){
            $this->hrmapp->get_table_data('my_resignations_table');
        }
        if($this->app_modules->is_active('branches')) {
            $ci = &get_instance();
            $ci->load->model('branches/Branches_model');
            $data['branches'] = $ci->Branches_model->getBranches();
        }
        $data['staffes'] = $this->Staff_model->get();
        $data['title'] = _l('resignations');
        $this->load->view('core_hr/resignations/manage', $data);
    }

    public function json_resignation($id){
        $branch_id = '';
        if($this->Branches_model->get('resignations', $id))
            $branch_id = $this->Branches_model->get_branch('resignations', $id);
        $data = $this->Resignations_model->get($id);
        $data->branch_id = $branch_id;
        echo json_encode($data);
    }
    public function update_resignation(){
        $data = $this->input->post();
        $branch_id = $data['branch_id'];
        unset($data['branch_id']);
        $id = $this->input->post('id');
        $success = $this->Resignations_model->update($data, $id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');

            $this->Branches_model->update_branch('complaints', $id, $branch_id);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function add_resignation(){
        $data = $this->input->post();
        $branch_id = $data['branch_id'];
        unset($data['branch_id']);

        $success = $this->Resignations_model->add($data);
        if($success)
            set_alert('success', _l('added_successfully'));
        else
            set_alert('warning', 'Problem Creating');


        if(is_numeric($branch_id)){
            $branch_data = [
                'branch_id' => $branch_id, 
                'rel_type' => 'resignations', 
                'rel_id' => $success
            ];
            $this->Branches_model->set_branch($branch_data);
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete_resignation($id)
    {
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        if (!is_admin()) {
            access_denied();
        }
        $response = $this->Resignations_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    // transfers

    public function transfers(){
        $this->load->model('Departments_model');
        $this->load->model('Sub_department_model');

        if($this->input->is_ajax_request()){
            $this->hrmapp->get_table_data('my_transfers_table');
        }
        if($this->app_modules->is_active('branches')) {
            $ci = &get_instance();
            $ci->load->model('branches/Branches_model');
            $data['branches'] = $ci->Branches_model->getBranches();
        }
        $data['departments'] = $this->Departments_model->get();
        $data['sub_departments'] = $this->Sub_department_model->get();
        $data['staffes'] = $this->Staff_model->get();
        $data['title'] = _l('transfers');
        $this->load->view('core_hr/transfers/manage', $data);
    }


    public function json_transfer($id){
        $branch_id = '';
        if($this->Branches_model->get('transfers', $id))
            $branch_id = $this->Branches_model->get_branch('transfers', $id);
        $data = $this->Transfers_model->get($id);
        $data->branch_id = $branch_id;
        $data->has_extra_info = $this->Extra_info_model->has_extra_info($data->staff_id);
        echo json_encode($data);
    }

    public function in_hr_system($staff_id){
        echo json_encode(['success'=>true,'data'=>$this->Extra_info_model->has_extra_info($staff_id)]);
        die();
    }
    public function update_transfer(){
        $data = $this->input->post();
        $branch_id = $data['branch_id'];
        unset($data['branch_id']);
        $id = $this->input->post('id');
        $success = $this->Transfers_model->update($data, $id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');

        $sub_department = $data['to_sub_department'];
        $department = $data['to_department'];
        $staff = $data['staff_id'];

        if($data['status'] == 'Accepted'){

            $this->Transfers_model->in_department($staff, $department);

            $this->Transfers_model->to_sub_department($staff, $sub_department);
        }
            $this->Branches_model->update_branch('transfers', $id, $branch_id);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function add_transfer(){
        $data = $this->input->post();
        $branch_id = $data['branch_id'];
        unset($data['branch_id']);

        $success = $this->Transfers_model->add($data);
        if($success)
            set_alert('success', _l('added_successfully'));
        else
            set_alert('warning', 'Problem Creating');
        if(is_numeric($branch_id)){
            $branch_data = [
                'branch_id' => $branch_id, 
                'rel_type' => 'transfers', 
                'rel_id' => $success
            ];
            $this->Branches_model->set_branch($branch_data);
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete_transfer($id)
    {
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        if (!is_admin()) {
            access_denied();
        }
        $response = $this->Transfers_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    // warnings

    public function warnings(){
        if($this->input->is_ajax_request()){
            $this->hrmapp->get_table_data('my_warnings_table');
        }
        if($this->app_modules->is_active('branches')) {
            $ci = &get_instance();
            $ci->load->model('branches/Branches_model');
            $data['branches'] = $ci->Branches_model->getBranches();
        }
        $data['staffes'] = $this->Staff_model->get();
        $data['title'] = _l('warnings');
        $this->load->view('core_hr/warnings/manage', $data);
    }


    public function json_warning($id){
        $branch_id = '';
        if($this->Branches_model->get('warnings', $id))
            $branch_id = $this->Branches_model->get_branch('warnings', $id);
        $data = $this->Warnings_model->get($id);
        $data->branch_id = $branch_id;
        echo json_encode($data);
    }
    public function update_warning(){
        $data = $this->input->post();
        $branch_id = $data['branch_id'];
        unset($data['branch_id']);
        $id = $this->input->post('id');
        $success = $this->Warnings_model->update($data, $id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');

        if(is_numeric($branch_id)){
            $this->Branches_model->update_branch('warnings', $id, $branch_id);
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function add_warning(){
        $data = $this->input->post();
        $branch_id = $data['branch_id'];
        unset($data['branch_id']);

        $success = $this->Warnings_model->add($data);
        if($success)
            set_alert('success', _l('added_successfully'));
        else
            set_alert('warning', 'Problem Creating');


        if(is_numeric($branch_id)){
            $branch_data = [
                'branch_id' => $branch_id, 
                'rel_type' => 'warnings', 
                'rel_id' => $success
            ];
            $this->Branches_model->set_branch($branch_data);
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete_warning($id)
    {
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        if (!is_admin()) {
            access_denied();
        }
        $response = $this->Warnings_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    // terminations

    public function terminations(){
        if($this->input->is_ajax_request()){
            $this->hrmapp->get_table_data('my_terminations_table');
        }
        if($this->app_modules->is_active('branches')) {
            $ci = &get_instance();
            $ci->load->model('branches/Branches_model');
            $data['branches'] = $ci->Branches_model->getBranches();
        }
        $data['staffes'] = $this->Staff_model->get();
        $data['title'] = _l('terminations');
        $this->load->view('core_hr/terminations/manage', $data);
    }


    public function json_termination($id){
        $branch_id = '';
        if($this->Branches_model->get('terminations', $id))
            $branch_id = $this->Branches_model->get_branch('terminations', $id);
        $data = $this->Terminations_model->get($id);
        $data->branch_id = $branch_id;
        echo json_encode($data);
    }
    public function update_termination(){
        $data = $this->input->post();
        $branch_id = $data['branch_id'];
        unset($data['branch_id']);
        $id = $this->input->post('id');
        $success = $this->Terminations_model->update($data, $id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');

        if(is_numeric($branch_id)){
            $this->Branches_model->update_branch('terminations', $id, $branch_id);
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function add_termination(){
        $data = $this->input->post();
        $branch_id = $data['branch_id'];
        unset($data['branch_id']);

        $success = $this->Terminations_model->add($data);
        if($success)
            set_alert('success', _l('added_successfully'));
        else
            set_alert('warning', 'Problem Creating');


        if(is_numeric($branch_id)){
            $branch_data = [
                'branch_id' => $branch_id, 
                'rel_type' => 'terminations', 
                'rel_id' => $success
            ];
            $this->Branches_model->set_branch($branch_data);
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete_termination($id)
    {
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        if (!is_admin()) {
            access_denied();
        }
        $response = $this->Terminations_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
}