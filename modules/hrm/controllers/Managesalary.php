<?php

class ManageSalary extends AdminController{

    public function __construct(){
        parent::__construct();
        $this->load->model('manage_salary');
    }

    public function index(){
        if(!is_admin()){
            access_denied();
        }
        if($this->input->is_ajax_request()){
            $this->hrmapp->get_table_data('my_managesalary_table');
        }
        $data['title'] = 'Manage Salary';
        
        $this->load->view('payments/managesalary', $data);
    }
    public function get($user_id){
        $data = $this->manage_salary->getSalary($user_id);
        echo json_encode($data);
    }
    public function update(){
        if (!is_admin()) {
            access_denied();
        }
        if ($this->input->get()) {
            $data            = $this->input->get();
            $id           = $this->input->get('user_id');
         
            $success = $this->manage_salary->update($id, $data);
            
            if ($success) {
                set_alert('success', _l('updated_successfully', 'Salary'));
            }else{
                set_alert('warning', 'Problem Updateing Salary');
            }
            redirect('hrm/managesalary');
        }
        if ($id == '')
        redirect('hrm/managesalary');
    }  

}