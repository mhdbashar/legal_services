<?php

class Core_hr extends AdminController{

	public function __construct(){
		parent::__construct();
		$this->load->model('Awards_model');
        $this->load->model('Terminations_model');
		$this->load->model('Branches_model');
		$this->load->model('Staff_model');
        $this->load->model('Warnings_model');
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