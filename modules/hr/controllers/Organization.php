<?php

class Organization extends AdminController{

    public function __construct(){
        parent::__construct();
        $this->load->model('Designation_model');

        $this->load->model('Departments_model');
        $this->load->model('Sub_department_model');
        $this->load->model('Official_document_model');
        $this->load->model('Extra_info_model');
        $this->load->model('No_branch_model');


        if (!has_permission('hr', '', 'view_own') && !has_permission('hr', '', 'view'))
            access_denied();
    }

    public function get_designation_number(){
        $next_designation_number = get_option('next_hr_designation_number');
        $prefix = get_option('hr_designation_prefix');

        $data['number'] = ($prefix . '0000' . $next_designation_number);

        echo json_encode($data);
    }
    public  function validate_designation_number($id = ''){

        $number = $this->input->post('number');


        $query = $this->db->get_where(db_prefix().'hr_designations', array('number' => $number, 'id!=' => $id));
        if($query->num_rows() < 1){
            $data['status'] = TRUE;
        }else{
            $data['status'] = false;
        }
        echo json_encode($data);
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
        $data['departments']   = $this->Departments_model->get();
        $data['designations_groups'] = $this->Designation_model->get_designation_group();
        $data['title'] = _l('designation');
        $this->load->view('organization/designation', $data);
    }

    public function designations_groups(){
        if($this->input->is_ajax_request()){
            $this->hrmapp->get_table_data('my_designations_groups_table');
        }
        $data['title'] = _l('designations_groups');
        $this->load->view('organization/designations_groups', $data);

    }

    public function sub_department(){
        if($this->input->is_ajax_request()){
            $this->hrmapp->get_table_data('my_sub_department_table');
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
    public function json_designation_group($id){
        $data = $this->Designation_model->get_designation_group($id);
        echo json_encode($data);
    }
    public function update_designation(){
        $data = $this->input->post();
        $data['description'] = $this->input->post('description', FALSE);
        $id = $this->input->post('id');
        $success = $this->Designation_model->update($data, $id);
//        if(true){
//                $this->Branches_model->update_branch('designations', $id, $branch_id);
//            }
        if($success){
            set_alert('success', _l('updated_successfully'));
        }
        else
            set_alert('warning', 'Problem Updating');
        redirect($_SERVER['HTTP_REFERER']);
    }


    public function update_designation_group(){
        $data = $this->input->post();
        $id = $this->input->post('id');
        $data['description'] = $this->input->post('description', FALSE);
        $success = $this->Designation_model->update_designation_group($data, $id);
        if($success){
            set_alert('success', _l('updated_successfully'));
        }
        else
            set_alert('warning', 'Problem Updating');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function add_designation(){
        $data = $this->input->post();
        $data['description'] = $data['description_add'];
        unset($data['description_add']);

        $data['description'] = $this->input->post('description_add', FALSE);

        $success = $this->Designation_model->add($data);
        if($success){
            update_option('next_hr_designation_number', get_option('next_hr_designation_number') + 1);
            set_alert('success', _l('added_successfully'));
        }else
            set_alert('warning', 'Problem Creating');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function add_designation_group(){
        $data = $this->input->post();
        $data['description'] = $data['description_add'];
        unset($data['description_add']);

        $data['description'] = $this->input->post('description_add', TRUE);

        $success = $this->Designation_model->add_designation_group($data);
        if($success){
            set_alert('success', _l('added_successfully'));
        }else
            set_alert('warning', 'Problem Creating');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function get_staff_department(){
        var_dump($this->Extra_info_model->get_staff_department(1));
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
        if (is_array($response) && isset($response['referenced'])) {
            set_alert('warning', _l('is_referenced'));
        } elseif  ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', _l('problem_deleting'));
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

    public function get_departments_by_branch_id($department_id){
        echo json_encode(['success'=>true,'data'=>$this->Sub_department_model->get_departments_by_branch_id($department_id)]);
        die();
    }

    public function json_sub_department($id){
        $data = $this->Sub_department_model->get($id);
        echo json_encode($data);
    }
    public function update_sub_department(){
        $data = $this->input->post();
//        if($this->app_modules->is_active('branches')){
//            $branch_id = $this->input->post()['branch_id'];
//
//            unset($data['branch_id']);
//        }
//        else
//            $branch_id = $this->No_branch_model->get_general_branch();
        $id = $this->input->post('id');
        $success = $this->Sub_department_model->update($data, $id);
//        if(true){
//                $this->Branches_model->update_branch('sub_departments', $id, $branch_id);
//            }
        if($success){
            set_alert('success', _l('updated_successfully'));
        }
        else
            set_alert('warning', 'Problem Updating');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function add_sub_department(){
        $data = $this->input->post();
//        if($this->app_modules->is_active('branches')){
//            $branch_id = $this->input->post()['branch_id'];
//
//            unset($data['branch_id']);
//        }
//        else
//            $branch_id = $this->No_branch_model->get_general_branch();
        $success = $this->Sub_department_model->add($data);
        if($success){

//            if(true){
//                $this->Branches_model->update_branch('sub_departments', $success, $branch_id);
//            }
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
        if (is_array($response) && isset($response['referenced'])) {
            set_alert('warning', _l('is_referenced'));
        } elseif  ($response == true) {
            is_array('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', _l('problem_deleting'));
        }

        redirect($_SERVER['HTTP_REFERER']);
    }
}